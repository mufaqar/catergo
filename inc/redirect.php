<?php

// 1️⃣ Rewrite selected pages with location slug
function add_location_rewrite_for_pages($pages = []) {
    if (empty($pages)) return;

    // Get all locations
    $locations = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ]);

    if (!$locations || is_wp_error($locations)) return;

    foreach ($locations as $location) {
        foreach ($pages as $page_slug) {
            // Add rewrite rule: /location/page-slug/
            add_rewrite_rule(
                '^' . $location->slug . '/' . $page_slug . '/?$',
                'index.php?pagename=' . $page_slug . '&location=' . $location->slug,
                'top'
            );
        }
    }
}

// 2️⃣ Register query var
add_filter('query_vars', function($vars) {
    $vars[] = 'location';
    return $vars;
});

// 3️⃣ Redirect to location if page visited without location
add_action('template_redirect', function() {
    if (!empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);

        // List of pages to rewrite
        $allowed_pages = ['all-caterers','menus','bestseller'];

        $current_slug = get_post_field('post_name', get_queried_object_id());

        // Only redirect if:
        // 1. It's an allowed page
        // 2. URL does NOT already contain location
        if (in_array($current_slug, $allowed_pages)) {
            $requested_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

            // If URL does NOT start with the location slug
            if (!str_starts_with($requested_path, $location)) {
                wp_redirect(home_url("/$location/$current_slug/"));
                exit;
            }
        }
    }
});


// 4️⃣ Call the function with your pages
add_action('init', function() {
  //  add_location_rewrite_for_pages(['all-caterers','menus','bestallning']);
});
