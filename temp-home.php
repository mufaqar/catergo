<?php
/* Template Name: HomePage */

// if (is_front_page() || is_home()) {
//     if (!isset($_GET['skip_location_redirect']) || $_GET['skip_location_redirect'] != '1') {
//         if (!empty($_COOKIE['selected_location'])) {
//             $location_slug = sanitize_text_field($_COOKIE['selected_location']);
//             $term = get_term_by('slug', $location_slug, 'location');

//             if ($term && !is_wp_error($term)) {
//                 $location_url = get_term_link($term);

//                 if (!is_wp_error($location_url)) {
//                     wp_redirect($location_url);
//                     exit;
//                 }
//             }
//         }
//     }
// }

// NOW start the header and output
get_header(); ?>

<?php 
// Debug output - only shown if no redirect happened
echo "Home Page Template Loaded Successfully";
?>

<!-- Rest of your home page content here -->

<?php get_footer(); ?>