<?php


/*
|--------------------------------------------------------------------------
| 1️⃣ Caterer Permalink with %location%
|--------------------------------------------------------------------------
*/

add_filter('post_type_link', function ($post_link, $post) {

    if ($post->post_type !== 'caterer') {
        return $post_link;
    }

    $terms = wp_get_post_terms($post->ID, 'location');

    if (!empty($terms) && !is_wp_error($terms)) {
        return str_replace('%location%', $terms[0]->slug, $post_link);
    }

    return str_replace('%location%', 'location', $post_link);

}, 10, 2);


add_action('init', function() {

    $taxonomy = 'location';
    $locations = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ]);

    if (!$locations || is_wp_error($locations)) return;

    foreach ($locations as $location) {
        // Add rewrite rule: /stockholm/ → location=stockholm
        add_rewrite_rule(
            '^' . $location->slug . '/?$',
            'index.php?taxonomy=' . $taxonomy . '&term=' . $location->slug,
            'top'
        );
    }
});


add_filter('query_vars', function($vars) {
    $vars[] = 'taxonomy';
    $vars[] = 'term';
    return $vars;
});



