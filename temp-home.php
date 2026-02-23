<?php
/* Template Name: HomePage */



if (!isset($_GET['skip_location_redirect']) || $_GET['skip_location_redirect'] != '1') {

    // Default location
    $location_slug = 'stockholm';

    // If cookie exists, override default
    if (!empty($_COOKIE['selected_location'])) {
        $cookie_slug = sanitize_text_field($_COOKIE['selected_location']);

        $term = get_term_by('slug', $cookie_slug, 'location');

        if ($term && !is_wp_error($term)) {
            $location_slug = $term->slug;
        }
    }

    // Get final term (either cookie location OR stockholm fallback)
    $term = get_term_by('slug', $location_slug, 'location');

    if ($term && !is_wp_error($term)) {
        $location_url = home_url('/' . $term->slug . '/');
        wp_redirect($location_url);
        exit;
    }
}

// NOW start the header and output
get_header(); ?>



<?php get_footer(); ?>

