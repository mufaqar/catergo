<?php
/*Template Name: Password Reset */

get_header(); ?>

<?php $bg_image = get_template_directory_uri() . '/assets/images//car_ride.jpg';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image
]); ?>

<!-- Why Choose Section -->
<section class="why-choose-section style-two bg-secondary">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-5">
            <!-- Why Choose Thumbnail -->
            <div class="col-12 col-lg-6">
                <div class="why-choose-thumbnail">
                    <!-- First Image -->
                    <div class="first-img wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images//21.jpg" alt="">
                    </div>

                    <!-- Second Image -->
                    <div class="second-img wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images//20.jpg" alt="">
                    </div>

                    <!-- Third Image -->
                    <div class="third-img wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images//22.jpg" alt="">
                    </div>
                </div>
            </div>

            <!-- Why Choose Content -->
            <div class="col-12 col-lg-6 gotrip_login_form align-items-center d-flex">
                 <?php echo do_shortcode('[ultimatemember_password]') ?>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="divider"></div>
</section>



<?php get_footer(); ?>