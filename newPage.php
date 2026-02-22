<?php /* Template Name: New Page */ get_header();


echo "New Page Template Loaded Successfully";

?>






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