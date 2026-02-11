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



/*
|--------------------------------------------------------------------------
| 2️⃣ Add Rewrite Rules for Location Pages
|--------------------------------------------------------------------------
*/

function add_location_rewrite_for_pages($pages = []) {

    if (empty($pages)) return;

    $locations = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ]);

    if (!$locations || is_wp_error($locations)) return;

    foreach ($locations as $location) {
        foreach ($pages as $page_slug) {

            add_rewrite_rule(
                '^' . $location->slug . '/' . $page_slug . '/?$',
                'index.php?pagename=' . $page_slug . '&location=' . $location->slug,
                'top'
            );

        }
    }
}

add_action('init', function () {
    add_location_rewrite_for_pages(['all-caterers', 'menus', 'bestseller']);
});


/*
|--------------------------------------------------------------------------
| 3️⃣ Register Query Var
|--------------------------------------------------------------------------
*/

add_filter('query_vars', function ($vars) {
    $vars[] = 'location';
    return $vars;
});


/*
|--------------------------------------------------------------------------
| 4️⃣ Smart Redirect Logic (SAFE VERSION)
|--------------------------------------------------------------------------
*/

add_action('template_redirect', function () {

    // Stop in admin / ajax / REST
    if (is_admin() || wp_doing_ajax() || defined('REST_REQUEST')) {
        return;
    }

    // Stop WooCommerce core pages
    if (function_exists('is_cart') && (is_cart() || is_checkout() || is_account_page())) {
        return;
    }

    // Get cookie location
    $cookie_location = !empty($_COOKIE['selected_location'])
        ? sanitize_text_field($_COOKIE['selected_location'])
        : '';

    if (!$cookie_location) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | A️⃣ Redirect Homepage → /location/
    |--------------------------------------------------------------------------
    */

    if (is_front_page()) {

        $term = get_term_by('slug', $cookie_location, 'location');

        if ($term && !is_wp_error($term)) {
            wp_redirect(home_url('/' . $term->slug . '/'), 302);
            exit;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | B️⃣ Redirect Specific Pages → /location/page/
    |--------------------------------------------------------------------------
    */

    $allowed_pages = ['all-caterers', 'menus', 'bestseller'];

    if (is_page()) {

        $page_slug = get_post_field('post_name', get_queried_object_id());

        if (in_array($page_slug, $allowed_pages)) {

            $requested_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

            // If URL already starts with location, skip
            if (!preg_match('#^' . preg_quote($cookie_location, '#') . '/#', $requested_path)) {

                wp_redirect(home_url("/$cookie_location/$page_slug/"), 302);
                exit;
            }
        }
    }

});
