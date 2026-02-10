<?php


// add_action('init', function() {
//     // Get all locations
//     $locations = get_terms([
//         'taxonomy' => 'location',
//         'hide_empty' => false
//     ]);

//     if ($locations && !is_wp_error($locations)) {
//         foreach ($locations as $location) {
//             // catch-all: /location/{any-page}/
//             add_rewrite_rule(
//                 '^' . $location->slug . '/([^/]+)/?$',
//                 'index.php?pagename=$matches[1]&location=' . $location->slug,
//                 'top'
//             );
//         }
//     }
// });

// add_filter('query_vars', function($vars) {
//     $vars[] = 'location';
//     return $vars;
// });

// add_action('template_redirect', function() {
//     if (is_page() && empty(get_query_var('location')) && !empty($_COOKIE['selected_location'])) {
//         $city = sanitize_text_field($_COOKIE['selected_location']);
//         $page_slug = get_post_field('post_name', get_queried_object_id());
//         wp_redirect(home_url("/$city/$page_slug/"));
//         exit;
//     }
// });



