<?php

add_action('rest_api_init', 'magLikeRoute');

function magLikeRoute(){
    register_rest_route('magpreneur/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('magpreneur/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($postData){
    if (is_user_logged_in()){
    $postID = sanitize_text_field($postData['postID']);

    $userLikeCheck = new WP_Query(array(
          'author' => get_current_user_id(),
          'post_type' => 'liked',
          'meta_query' => array(
            array(
              'key' => 'liked_posts',
              'compare' => '=',
              'value' => $postID
            )
          )
    ));

    if($userLikeCheck->found_posts == 0 AND get_post_type($postID) == 'post'){
        $newLike =  wp_insert_post(array(
            'post_type' => 'liked',
            'post_status' => 'publish',
            'post_title' => get_the_title($postID),
            'meta_input' => array(
                'liked_posts' => $postID
            )
        ));

        return wp_send_json_success(array(
            'message' => 'Like created',
            'likeID'  => $newLike
        ));
        } else {
             return wp_send_json_error(array(
            'message' => 'Invalid ID'
            ), 403);
        }

    } else {
         return wp_send_json_error(array(
            'message' => 'Only logged-in users can like.'
        ), 403);
    }
}

function deleteLike($postData){
    $likeID = sanitize_text_field($postData['likeID']);
    if(get_current_user_id() == get_post_field('post_author', $likeID) AND get_post_type($likeID) == 'liked'){
        wp_delete_post($likeID, true);
        return wp_send_json_success(array(
            'message' => 'like deleted'
        ));
    } else {
        return wp_send_json_error(array(
            'message' => 'You cannot delete this like'
        ), 403);
    }
}