<?php

// class AuthorManager {
//     function __construct(){
        
//     }
// }

// $authorManager = new AuthorManager();



function add_author_admin_page() {
    add_menu_page(
        'Author Profile',
        'Author Profile',
        'edit_posts',
        'author-profile',
        'author_admin_page_html',
        'dashicons-admin-users',
        20
    );
}
add_action('admin_menu', 'add_author_admin_page');

function author_admin_page_html() {
    // Get current user data
    $current_user = wp_get_current_user();
    $profile_pic_id = get_user_meta($current_user->ID, 'profile_picture_id', true);
    $image_url = wp_get_attachment_image_url($profile_pic_id, 'author_pro_pic');
    $headline = get_user_meta($current_user->ID, 'author_headline', true);
    $social_links = get_user_meta($current_user->ID, 'author_social_links', true);
    $social_links = is_array($social_links) ? $social_links : array();
    $allowed_platforms = array(
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube'
    );
    ?>

    <div class="wrap">
        <h2>Author Profile</h2>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
            <?php wp_nonce_field('author_profile_update', 'author_profile_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="profile_picture">Profile Picture</label></th>
                    <td>
                        <img src="<?php echo ($image_url)? esc_url($image_url) : esc_url(get_avatar_url(get_current_user_id())); ?>" alt="Profile Picture" width="100">
                        <input type="file" name="profile_picture" id="profile_picture">
                    </td>
                </tr>
                <tr>
                    <th><label for="first_name">First Name</label></th>
                    <td><input type="text" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="last_name">Last Name</label></th>
                    <td><input type="text" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="email">Email</label></th>
                    <td><input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" class="regular-text" disabled></td>
                </tr>
                <tr>
                    <th><label for="description">Description</label></th>
                    <td><textarea name="description" rows="5" class="large-text"><?php echo esc_textarea(get_user_meta($current_user->ID, 'description', true)); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="author_headline">Headline</label></th>
                    <td><input type="text" name="author_headline" value="<?php echo esc_attr($headline); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label>Social Media Links</label></th>
                    <td>
                        <div id="social-links-container">
                            <?php foreach ($social_links as $index => $link) : ?>
                                <div class="social-link-row">
                                    <select name="author_social_links[<?php echo $index; ?>][platform]" class="regular-text">
                                        <?php foreach ($allowed_platforms as $value => $label) : ?>
                                            <option value="<?php echo esc_attr($value); ?>" <?php selected($link['platform'], $value); ?>>
                                                <?php echo esc_html($label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="url" name="author_social_links[<?php echo $index; ?>][url]" 
                                           value="<?php echo esc_url($link['url']); ?>" class="regular-text">
                                    <button type="button" class="button remove-social-link">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-social-link" class="button">Add Social Media Links</button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="save_author_profile">
            <?php submit_button('Save Changes'); ?>
        </form>

        <script>
        jQuery(document).ready(function($) {
            var container = $('#social-links-container');
            var index = <?php echo count($social_links); ?>;
            
            $('#add-social-link').click(function() {
                $('#add-social-link').html("Add Another Link");
                var newRow = $('<div class="social-link-row">' +
                    '<select name="author_social_links[' + index + '][platform]" class="regular-text">' +
                    '<option value="">Select Platform</option>' +
                        '<?php foreach ($allowed_platforms as $value => $label) : ?>' +
                        '<option value="<?php echo $value; ?>"><?php echo $label; ?></option>' +
                        '<?php endforeach; ?>' +
                    '</select>' +
                    '<input type="url" name="author_social_links[' + index + '][url]" value="" class="regular-text" placeholder="https://example.com">' +
                    '<button type="button" class="button remove-social-link">Remove</button>' +
                '</div>');
                
                container.append(newRow);
                index++;
            });

            container.on('click', '.remove-social-link', function() {
                $(this).closest('.social-link-row').remove();
            });
        });
        </script>
        <style>
            .social-link-row { margin-bottom: 10px; }
            .social-link-row select, .social-link-row input { margin-right: 10px; }
        </style>

    </div>

    <?php
}

function save_author_profile_data() {
    // Check user permissions
    if (!current_user_can('edit_posts')) {
        return;
    }

    // Verify nonce for security
    if (!isset($_POST['author_profile_nonce']) || !wp_verify_nonce($_POST['author_profile_nonce'], 'author_profile_update')) {
        return;
    }

    // Get current user ID
    $current_user_id = get_current_user_id();
    $allowed_platforms = array('facebook', 'twitter', 'instagram', 'linkedin', 'youtube');

    // Update standard fields
    if (isset($_POST['first_name'])) {
        update_user_meta($current_user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }
    if (isset($_POST['last_name'])) {
        update_user_meta($current_user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
    if (isset($_POST['description'])) {
        update_user_meta($current_user_id, 'description', sanitize_textarea_field($_POST['description']));
    }

    // Update custom fields
    if (isset($_POST['author_headline'])) {
        update_user_meta($current_user_id, 'author_headline', sanitize_text_field($_POST['author_headline']));
    }
    $social_links = array();
    if (!empty($_POST['author_social_links'])) {
        foreach ($_POST['author_social_links'] as $link) {
            if (!empty($link['url'])) {
                $platform = in_array($link['platform'], $allowed_platforms) 
                            ? $link['platform'] 
                            : 'website';
                $social_links[] = array(
                    'platform' => sanitize_text_field($platform),
                    'url' => esc_url_raw($link['url'])
                );
            }
        }
        update_user_meta($current_user_id, 'author_social_links', $social_links);
    }

    // Handle profile picture upload
 // ✅ Declare filter function FIRST
function limit_author_image_sizes($sizes) {
    return [
        'author_thumb' => $sizes['author_thumb'] ?? [],
        'author_pro_pic' => $sizes['author_pro_pic'] ?? [],
    ];
}

if (!empty($_FILES['profile_picture']['name'])) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // ✅ Add the filter after function is defined
    add_filter('intermediate_image_sizes_advanced', 'limit_author_image_sizes');

    add_image_size('author_thumb', 48, 48, true);
    add_image_size('author_pro_pic', 240, 240, true);

    $attachment_id = media_handle_upload('profile_picture', 0);

    if (!is_wp_error($attachment_id)) {
        update_user_meta($current_user_id, 'profile_picture_id', $attachment_id);

        $fullsize_path = get_attached_file($attachment_id);
        $metadata = wp_generate_attachment_metadata($attachment_id, $fullsize_path);
        wp_update_attachment_metadata($attachment_id, $metadata);
    }

    // ✅ Remove filter after it's used
    remove_filter('intermediate_image_sizes_advanced', 'limit_author_image_sizes');
}


    // Redirect back to the author profile page
    wp_safe_redirect(admin_url('admin.php?page=author-profile'));
    exit;
}
add_action('admin_post_save_author_profile', 'save_author_profile_data');
