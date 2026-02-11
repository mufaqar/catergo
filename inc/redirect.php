<?php



add_action('template_redirect', function () {

  if (!is_front_page() || is_admin()) {
    return;
  }

  if (!empty($_COOKIE['selected_location'])) {
    $term = get_term_by('slug', sanitize_text_field($_COOKIE['selected_location']), 'location');

    if ($term && !is_wp_error($term)) {
      wp_redirect(home_url('/' . $term->slug . '/'), 302);
      exit;
    }
  }

});


// 1️⃣ Only rewrite selected pages with location slug
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

// 3️⃣ Redirect to location only for allowed pages
add_action('template_redirect', function() {
    $allowed_pages = ['all-caterers','menus','bestseller']; // pages using location

    if (is_page()) {
        $page_slug = get_post_field('post_name', get_queried_object_id());

        // Only redirect for allowed pages
        if (in_array($page_slug, $allowed_pages) && !empty($_COOKIE['selected_location'])) {
            $location = sanitize_text_field($_COOKIE['selected_location']);
            $requested_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

            // Skip redirect if URL already contains location slug
            if (!preg_match('#^' . preg_quote($location, '#') . '/#', $requested_path)) {
                wp_redirect(home_url("/$location/$page_slug/"));
                exit;
            }
        }
    }
});

// 4️⃣ Initialize rewrite rules for allowed pages
add_action('init', function() {
    add_location_rewrite_for_pages(['all-caterers','menus','bestseller']);
});
