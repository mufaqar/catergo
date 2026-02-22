<?php /* Template Name: Location Archive */ get_header(); 



$term = get_queried_object();


echo $term->slug;






?>


 
 <?php get_template_part('partials/home', 'sliders'); ?>
 <?php get_template_part('partials/home', 'categories'); ?>
  <?php get_template_part('partials/home', 'banner'); ?>
 <?php get_template_part('partials/home', 'products'); ?>
 <?php //get_template_part('partials/home', 'mission'); ?>
  <?php //get_template_part('partials/home', 'testimonials'); ?>
 <?php get_template_part('partials/home', 'booking'); ?>


<?php get_footer(); ?>
