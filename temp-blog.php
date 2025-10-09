<?php
/*Template Name: Blog*/

get_header(); ?>

 <?php $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/img/bg-img/slide1.webp';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image
]); 

?>

<!-- Blog Section -->
<section class="blog-section">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-4 g-xxl-5">
            <?php
            $args = array(
                'post_type' => 'post', // or 'tours' or any custom post type
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );

            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()):
                while ($blog_query->have_posts()):
                    $blog_query->the_post();
                    get_template_part('partials/blog-card');
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No blog posts found.</p>';
            endif;
            ?>
        </div>
    </div>

    <!-- Divider -->
    <div class="divider"></div>
</section>

<?php get_footer(); ?>