<?php
/**
 * Plugin Name: Featured Posts Manager
 * Description: Manage and mark up to 4 featured posts for the front page.
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Featured_Posts_Table extends WP_List_Table {

    function __construct() {
        parent::__construct([
            'singular' => 'featured_post',
            'plural'   => 'featured_posts',
            'ajax'     => false
        ]);
    }

    function get_columns() {
        return [
            'title'    => 'Title',
            'author'   => 'Author',
            'date'     => 'Date',
            'featured' => 'Featured',
        ];
    }

    function get_sortable_columns() {
        return [
            'title'    => ['title', false],
            'date'     => ['date', false],
            'featured' => ['featured', false],
        ];
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'title':
                return '<strong class="item-title">' . esc_html($item->post_title) .'</strong>';
            case 'author':
                return esc_html(get_the_author_meta('display_name', $item->post_author));
            case 'date':
                return esc_html(get_the_date('', $item));
            case 'featured':
                $is_featured = get_post_meta($item->ID, '_is_featured', true);
                return '<span class="dashicons star-toggle ' .
                    ($is_featured ? 'dashicons-star-filled' : 'dashicons-star-empty') .
                    '" data-post="' . $item->ID . '"></span>';
            default:
                return '';
        }
    }

    function prepare_items() {
    $per_page     = 10;
    $current_page = $this->get_pagenum();

    $orderby = !empty($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
    $order   = !empty($_GET['order']) ? sanitize_text_field($_GET['order']) : 'desc';
    $search  = !empty($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $per_page,
        'paged'          => $current_page,
        'orderby'        => $orderby,
        'order'          => $order,
        's'              => $search,
    ];

    if ($orderby === 'featured') {
        global $wpdb;

        $args['orderby'] = 'date'; // fallback
        $args['order']   = $order;

        add_filter('posts_clauses', function ($clauses) use ($wpdb, $order) {
            $order_sql = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

            // ✅ Join postmeta as alias pm
            if (strpos($clauses['join'], 'postmeta') === false) {
                $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} pm 
                    ON ({$wpdb->posts}.ID = pm.post_id AND pm.meta_key = '_is_featured')";
            }

            // ✅ Order by meta_value (1 or 0), treating NULL as 0
            $clauses['orderby'] = "CAST(IFNULL(pm.meta_value, 0) AS UNSIGNED) $order_sql, {$wpdb->posts}.post_date DESC";

            return $clauses;
        });
    }

    $query = new WP_Query($args);

    $this->items = $query->posts;
    $this->set_pagination_args([
        'total_items' => $query->found_posts,
        'per_page'    => $per_page,
        'total_pages' => $query->max_num_pages,
    ]);

    $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];

    // cleanup
    remove_all_filters('posts_clauses');
}


}

class FeaturedPostsPlugin {

    function __construct() {
        add_action('admin_menu', [$this, 'featuredPostsSetup']);

        // Enqueue JS for star toggle
        add_action('admin_enqueue_scripts', function($hook) {
            if ($hook === 'toplevel_page_featured-posts-setup') {
                wp_enqueue_script(
                    'featured-posts-js',
                    plugin_dir_url(__FILE__) . 'featured-posts.js',
                    ['jquery'],
                    false,
                    true
                );
                wp_localize_script('featured-posts-js', 'FeaturedPostsAjax', [
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce'    => wp_create_nonce('toggle_featured_post'),
                ]);
            }
        });

        // Ajax toggle
        add_action('wp_ajax_toggle_featured_post', [$this, 'toggle_featured_post']);
    }

    function featuredPostsSetup() {
        add_menu_page(
            'Featured Posts Setup',
            'Featured Posts',
            'manage_options',
            'featured-posts-setup',
            [$this, 'featuredPostsHTML'],
            'dashicons-star-filled',
            20
        );
    }

    function featuredPostsHTML() {
        echo '<div class="wrap">
        <h2>Featured Posts</h2>
        <p class="description-featured-posts-setup">You can set up-to 4 post on featured posts sections</p>';

        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="featured-posts-setup" />';
        $table = new Featured_Posts_Table();
        $table->prepare_items();
        $table->search_box('Search Posts', 'post_search');
        $table->display();
        echo '</form>';

        echo '</div>';

        echo    '<style>
                    
                    .column-featured{
                    width: 10%;
                    
                    }

                    .star-toggle {
                    cursor: pointer;
                    font-size: 20px;
                    color: #aaa;
                    }

                    .star-toggle.dashicons-star-filled {
                    color: #333;
                    }

                    .item-title {
                    color: #2271b1;
                    font-weight: 600;
                    padding-bottom: 1rem;
                    }

                    .description-featured-posts-setup{
                    font-size: 1rem;
                    float: left;
                    }

                </style>';
    }

    function toggle_featured_post() {
        check_ajax_referer('toggle_featured_post', 'nonce');

        $post_id = intval($_POST['post_id']);
        $is_featured = get_post_meta($post_id, '_is_featured', true);

        if ($is_featured) {
            delete_post_meta($post_id, '_is_featured');
            wp_send_json_success(['status' => 'removed']);
        } else {
            // Limit to 4 featured posts
            $featured_posts = get_posts([
                'post_type'      => 'post',
                'meta_key'       => '_is_featured',
                'meta_value'     => 1,
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ]);

            if (count($featured_posts) >= 4) {
                wp_send_json_error(['message' => 'You can only feature up to 4 posts.']);
            }

            update_post_meta($post_id, '_is_featured', 1);
            wp_send_json_success(['status' => 'added']);
        }
    }
}

new FeaturedPostsPlugin();
