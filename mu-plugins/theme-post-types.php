<?php 
function theme_post_types(){
    register_post_type('webinars', array(
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Webinars',
            'add_new_item' => 'Add New Webinar',
            'edit_item' => 'Edit Webinar',
            'all_items' => 'All Webinar',
            'singular_name' => 'Webinar'
        ),
        'taxonomies' => array('category', 'post_tag'),
        'menu_icon' => 'dashicons-video-alt3'
    ));

        register_post_type('liked', array(
        'supports' => array('title'),
        'public' => false,
        'show_ui' => true,
        'labels' => array(
            'name' => 'Liked',
            'add_new_item' => 'Add New like',
            'edit_item' => 'Edit like',
            'all_items' => 'All like',
            'singular_name' => 'like'
        ),
        'menu_icon' => 'dashicons-thumbs-up'
    ));
}

add_action('init', 'theme_post_types');