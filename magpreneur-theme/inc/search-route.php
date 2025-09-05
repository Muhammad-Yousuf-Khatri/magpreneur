<?php

add_action('rest_api_init', 'magRegisterSearch');

function magRegisterSearch(){
    register_rest_route('magpreneur/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'magSearchResult'
    ));
}

function magSearchResult($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'webinars'),
        's' => sanitize_text_field($data['term']) 
    ));

    $results = array(
        'topics' => array(),
        'webinars' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() == 'post'){
            array_push($results['topics'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'ID' => get_the_ID()
        ));
        }

        if (get_post_type() == 'webinars'){
            $webinarsDateAndTime = strtotime(get_field('webinar_date_time'));
            $todayDateAndTime = strtotime(date('F j, Y g:i a'));

            $webinarStatus = null;

            if($todayDateAndTime < $webinarsDateAndTime){
                $webinarStatus = 'Upcoming';
            } else {
                $webinarStatus = 'Past';
            }

            array_push($results['webinars'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'ID' => get_the_ID(),
            'status' => $webinarStatus
        ));
        }
    }

    return $results;
}