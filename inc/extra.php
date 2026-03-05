<?php



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


include_once('woo.php');
include_once('ajax_calls.php');
include_once('store.php');
include_once('request.php');
include_once('redirect.php');

add_filter('wp_nav_menu_items', function ($items, $args) {

    // Only for primary menu location (change if your theme uses a different key)
    if (empty($args->theme_location) || $args->theme_location !== 'main') {
        return $items;
    }

    // Get location from cookie
    $location_slug = '';
    if (!empty($_COOKIE['selected_location'])) {
        $location_slug = sanitize_text_field(wp_unslash($_COOKIE['selected_location']));
    }

    // Fallback if no cookie
    if (!$location_slug) {
        // Either don't add anything:
        return $items;

        // Or add default (uncomment):
        // $url = home_url('/caterrers/');
        // $label = 'Caterers';
    }

    // Optional: validate it is a real location term
    $term = get_term_by('slug', $location_slug, 'location');
    if (!$term || is_wp_error($term)) {
        return $items;
    }

    // Build URL: /{location}/caterrers
    $url   = home_url('/' . $term->slug . '/catering/');
    $label = 'catering'; // or: 'Caterers in ' . $term->name

    $new_item  = '<li class="menu-item menu-item-caterers-by-location">';
    $new_item .= '<a href="' . esc_url($url) . '">' . esc_html($label) . '</a>';
    $new_item .= '</li>';

     // Add as FIRST item
    return $new_item . $items;

}, 10, 2);



function get_home_url_with_location() {

    // Get location from query var
    $location = get_query_var('location');

    // Fallback to cookie
    if (!$location && !empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);
    }

    if ($location) {
        $location = sanitize_title($location); // makes it URL safe
        return esc_url( home_url('/' . $location ) );
    }

    return esc_url( home_url('/') );
}