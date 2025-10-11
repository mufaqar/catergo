<?php get_header(); ?>
<?php

$bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/images/bg-img/97.jpg';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image
]);
?>

<!-- Hotel Details Section -->
<section class="hotel-details-section">
    <!-- Divider -->
    <div class="divider-sm"></div>
    <div class="container">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>

                <div class="hotel-details-header mb-5">
                    <div class="row g-5 align-items-end">
                        <div class="col-12 col-lg-6">
                            <h2 class="mb-3">Book your Business Class</h2>
                            <p class="mb-0 d-flex flex-wrap align-items-center gap-2">
                                <span><i class="ti ti-car text-success"></i>
                                    <?php echo get_post_meta($post->ID, "car_equivalent", true); ?></span>
                            </p>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-4">
                                <a href="#">
                                    <div class="icon">
                                        <i class="ti ti-car-4wd"></i>
                                    </div>
                                    <h2 class="pb-3"><?php
                                    $term = wp_get_post_terms(get_the_ID(), 'vehicle-type', array('fields' => 'all'));
                                    if (!empty($term) && !is_wp_error($term)) {
                                        // Since it's single value, take the first one
                                        $vehicle_type = $term[0];

                                        echo esc_html($vehicle_type->name);

                                    } ?>
                                    </h2>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-12 col-lg-8">

                        <div class="tour-details-content">
                            <img class="rounded-4" src="<?php echo $bg_image ?>" alt="">
                            <!-- Car meta -->
                            <div class="hotel-meta-info-card mb-4">
                                <div class="row g-4">

                                    <!-- Hotel Meta Info Card Item -->
                                    <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                                        <div class="hotel-meta-info-card-item">
                                            <div class="icon">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <div>
                                                <h6>Passengers </h6>
                                                <p><?php echo get_post_meta($post->ID, "passengers", true); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hotel Meta Info Card Item -->
                                    <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                                        <div class="hotel-meta-info-card-item">
                                            <div class="icon">
                                                <i class="ti ti-luggage"></i>
                                            </div>
                                            <div>
                                                <h6>Luggage</h6>
                                                <p><?php echo get_post_meta($post->ID, "large_bag", true); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hotel Meta Info Card Item -->
                                    <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                                        <div class="hotel-meta-info-card-item">
                                            <div class="icon">
                                                <i class="ti ti-car"></i>
                                            </div>
                                            <div>
                                                <h6><?php echo get_post_meta($post->ID, "car_equivalent", true); ?></h6>
                                                <p>similar or a higher class</p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <h2 class="pb-3">Overview</h2>
                            <div class="pb-3"><?php the_content() ?></div>
                            <h2 class="pb-3">Features & Amenities</h2>
                            <ul class="list-unstyled style-two">
                                <li><i class="ti ti-rosette-discount-check"></i> Meet & Greet included</li>
                                <li><i class="ti ti-rosette-discount-check"></i>Free cancellation</li>
                                <li><i class="ti ti-rosette-discount-check"></i> Free Waiting time</li>
                                <li><i class="ti ti-rosette-discount-check"></i> Safe and secure travel</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="d-flex flex-column gap-5">
                            <!-- Widget -->
                            <div class="sidebar-widget">
                                <div class="h4 fw-bold mb-4">Book your Business Class</div>
                                <form action="#">
                                    <div class="row g-2">
                                        <div class="col-12 border rounded">
                                            <input type="date" class="form-control py-0 bg-white">
                                        </div>
                                        <div class="col-12 border rounded">
                                            <input type="text" class="form-control bg-white" placeholder="Pickup Location *">
                                        </div>
                                        <div class="col-12 border rounded">
                                            <input type="text" class="form-control bg-white" placeholder="Drop Location *">
                                        </div>
                                        <div class="col-12 border rounded">
                                            <input type="text" class="form-control bg-white" placeholder="Name*">
                                        </div>
                                        <div class="col-12 border rounded">
                                            <input type="text" class="form-control bg-white" placeholder="Email*">
                                        </div>
                                        <div class="col-12 border rounded">
                                            <input type="text" class="form-control bg-white" placeholder="Phone*">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success w-100">Book Your Car Now <i
                                                    class="icon-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
    </div>

    <!-- Divider -->
    <div class="divider-sm"></div>
</section>



<?php get_template_part('partials/related', 'tours'); ?>




<?php get_footer(); ?>