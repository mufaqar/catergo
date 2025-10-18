<?php get_header(); ?>

<?php $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/images/banner-bg.jpg';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image
]); ?>

<!-- Tour Details Section -->
<div class="tour-details-section">
    <!-- Divider -->
    <div class="divider-sm"></div>

    <div class="container">

        <div class="row g-5">
            <div class="col-12 col-lg-12">
                <?php if (have_posts()):
                    while (have_posts()):
                        the_post(); ?>
                        <div class="post" id="post-<?php the_ID(); ?>">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; endif; ?>
            </div>
            <!-- Divider -->
            <div class="divider-sm"></div>
        </div>

    </div>
</div>
<?php get_footer(); ?>