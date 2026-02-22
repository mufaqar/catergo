<?php

// include_once('woo.php');
// include_once('ajax_calls.php');
// include_once('store.php');
// include_once('request.php');
// include_once('redirect.php');




function current_location_shortcode() {
    // From URL query var
    $location = get_query_var('location');

    // fallback from cookie
    if (!$location && !empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);
    }

    return $location ? $location : '';
}
add_shortcode('current_location', 'current_location_shortcode');


add_filter('wp_nav_menu_objects', function($items, $args) {   
    $location = get_query_var('location');
    if (!$location && !empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);
    }
    foreach ($items as $item) {      
        if (strpos($item->url, '__location__') !== false) {
            $item->url = str_replace('__location__', $location ? $location : '', $item->url);
        }
    }
    return $items;
}, 10, 2);