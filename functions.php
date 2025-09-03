<?php
require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function theme_files(){
    wp_enqueue_style('google-font-inter','//fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', array(), null);
    wp_enqueue_style('bootstrap_style', get_theme_file_uri('assets/css/bootstrap.css'), array());
    wp_enqueue_style('main_style', get_theme_file_uri('assets/css/main-style.css'), array());
    wp_enqueue_script('fontawesome', get_theme_file_uri('assets/js/fontawesome.js'), array(), null, true);
    wp_enqueue_script('fontawesome_brands', get_theme_file_uri('assets/js/brands.js'), array(), null, true);
    wp_enqueue_script('fontawesome_regular', get_theme_file_uri('assets/js/regular.js'), array(), null, true);
    wp_enqueue_script('fontawesome_solid', get_theme_file_uri('assets/js/solid.js'), array(), null, true);
    wp_enqueue_script('bootstrap_script', get_theme_file_uri('assets/js/bootstrap.js'), array(), null, true);
    wp_enqueue_script('main_script', get_theme_file_uri('assets/js/script.js'), array(), null, true);
    wp_enqueue_script(
        'theme-js',
        get_template_directory_uri() . '/build/index.js',
        [ 'wp-element' ], // React dependency if using JSX
        filemtime( get_template_directory() . '/build/index.js' ),
        true
    );
    if(is_single()){
        wp_enqueue_script('single_post_script', get_theme_file_uri('assets/js/single.js'), array(), null, true);
    }

    if(!is_single()){
        wp_enqueue_script('cards_script', get_theme_file_uri('assets/js/cards.js'), array(), null, true);
    }

    wp_localize_script('theme-js', 'magpreneur', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));

}
add_action('wp_enqueue_scripts','theme_files');

function add_defer_to_scripts($tag, $handle) {
    $fontawesome_scripts = array('fontawesome', 'fontawesome_brands', 'fontawesome_regular', 'fontawesome_solid');
    if (in_array($handle, $fontawesome_scripts)) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_defer_to_scripts', 10, 2);

function custom_google_font() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'custom_google_font');

function theme_features(){
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLinks', 'Footer Links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('largeCard', 400, 225, true);
    add_image_size('smallCard', 267, 150, true);
    add_image_size('circularCard', 75, 75, true);
    add_image_size('largeBanner', 1280, 530, true);
    add_image_size('smallBanner', 845, 350, true);
}

add_action('after_setup_theme','theme_features');


function remove_default_image_sizes($sizes) {
    unset($sizes['thumbnail']); // 150x150
    unset($sizes['medium']);    // 300x300
    unset($sizes['medium_large']); // 768
    unset($sizes['large']);     // 1024
    unset($sizes['1536x1536']); // WP 5.3+
    unset($sizes['2048x2048']); // WP 5.3+
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

function theme_adjust_queries($query){
    $todayDate = date('Ymd');
    if(!is_admin() AND is_post_type_archive('webinars') AND $query->is_main_query()){
        $query->set('meta_key', 'webinar_date_time');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
      array(
        'key' => 'webinar_date_time',
        'compare' => '>=',
        'value' => $todayDate,
        'type' => 'datetime'
      )
    ));
    }
}

add_action('pre_get_posts', 'theme_adjust_queries');


class Theme_Nav_Walker extends Walker_Nav_Menu {
    // Start the <ul> output
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    // Start the <li> output
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['class'] = 'nav-link';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // End the <li> output
    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

class FooterNoUlWalker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        // Do nothing to skip <ul>.
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        // Do nothing to skip </ul>.
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $attributes = !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $output .= '<a' . $attributes . ' class="footer-link">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        // No closing </li> tag needed since we only output <a>.
    }
}

function wrap_sections_by_h2($content) {
    if (trim($content) === '') {
        return $content;
    }
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

    $body = $doc->getElementsByTagName('body')->item(0);
    $newContent = '';
    $childNodes = iterator_to_array($body->childNodes);

    $i = 0;
    $count = count($childNodes);

    while ($i < $count) {
        $node = $childNodes[$i];

        // If <h2> found, start a new section
        if ($node->nodeName === 'h2') {
            $sectionNodes = [];
            $sectionNodes[] = $node;

            // Generate ID from h2 text
            $headingText = strtolower(trim($node->textContent));
            $slug = preg_replace('/[^a-z0-9]+/', '-', $headingText);
            $slug = trim($slug, '-');

            $i++;

            // Collect all nodes until the next <h2>
            while ($i < $count && $childNodes[$i]->nodeName !== 'h2') {
                $sectionNodes[] = $childNodes[$i];
                $i++;
            }

            // Create wrapper <div>
            $div = $doc->createElement('div');
            $div->setAttribute('class', 'toc-section');
            $div->setAttribute('id', $slug);

            foreach ($sectionNodes as $sectionNode) {
                $div->appendChild($sectionNode->cloneNode(true));
            }

            $newContent .= $doc->saveHTML($div);
        } else {
            // Not an <h2>, just output it
            $newContent .= $doc->saveHTML($node);
            $i++;
        }
    }

    return $newContent;
}
add_filter('the_content', 'wrap_sections_by_h2');

function set_post_views($postID) {
    if (is_bot()) return;

    $key = 'post_views_count';
    $count = get_post_meta($postID, $key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $key);
        add_post_meta($postID, $key, '0');
    } else {
        $count++;
        update_post_meta($postID, $key, $count);
    }
}

function is_bot() {
    $bots = [
        'bot', 'crawl', 'spider', 'slurp', 'fetch', 'preview', 'monitor', 'facebookexternalhit', 'pingdom'
    ];

    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

    foreach ($bots as $bot) {
        if (strpos($user_agent, $bot) !== false) {
            return true;
        }
    }

    return false;
}

add_filter('get_avatar_url', 'use_custom_author_avatar', 10, 3);

function use_custom_author_avatar($url, $id_or_email, $args) {
    $user = false;

    // Get user object from various possible inputs
    if (is_numeric($id_or_email)) {
        $user = get_user_by('id', (int) $id_or_email);
    } elseif (is_object($id_or_email) && !empty($id_or_email->user_id)) {
        $user = get_user_by('id', (int) $id_or_email->user_id);
    } elseif (is_string($id_or_email)) {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user) {
        $custom_avatar_id = get_user_meta($user->ID, 'profile_picture_id', true);

        if ($custom_avatar_id) {
            $custom_avatar_url = wp_get_attachment_image_url($custom_avatar_id, 'author_pro_pic'); // use correct size
            if ($custom_avatar_url) {
                return $custom_avatar_url;
            }
        }
    }

    return $url; // Fallback to default (Gravatar or Mystery Person)
}

add_filter('get_avatar', 'replace_avatar_img_tag', 10, 5);
function replace_avatar_img_tag($avatar, $id_or_email, $size, $default, $alt) {
    $custom_url = apply_filters('get_avatar_url', '', $id_or_email, ['size' => $size]);

    if (!empty($custom_url)) {
        $alt_text = esc_attr($alt ?: 'User Avatar');
        return "<img src='" . esc_url($custom_url) . "' alt='{$alt_text}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    }

    return $avatar;
}

function get_author_thumb_url($author_id = null){
    if(!$author_id){
        $author_id = get_the_author_meta('ID');
    }
        $author_pic_id = get_user_meta($author_id, 'profile_picture_id', true);
        $author_thumb = wp_get_attachment_image_url($author_pic_id, 'author_thumb');
        return $author_thumb? esc_url($author_thumb) : esc_url(get_avatar_url($author_id));
};

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
        show_admin_bar(false);
    }
}

