<?php /* Template Name: Location Archive */ get_header(); 


if (is_page()) {
    $slug = get_query_var('pagename');
    echo $slug;
}

$term = get_queried_object();

// echo $term->term_id;
// echo $term->name;
 //echo $term->slug;
//echo $term->taxonomy;

print_r($term);



?>


 
 <?php get_template_part('partials/home', 'sliders'); ?>
 <?php get_template_part('partials/home', 'categories'); ?>
  <?php get_template_part('partials/home', 'banner'); ?>
 <?php get_template_part('partials/home', 'products'); ?>
 <?php //get_template_part('partials/home', 'mission'); ?>
  <?php //get_template_part('partials/home', 'testimonials'); ?>
 <?php get_template_part('partials/home', 'booking'); ?>


<?php get_footer(); ?>
