<?php get_header();
$bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/img/bg-img/97.jpg';
$tour_comments = get_tour_comments(get_the_ID());
$review_count = count($tour_comments);
$tour_overview = get_post_meta($post->ID, "tour_overview", true);
$trip_itinerary = get_post_meta($post->ID, "trip_itinerary", true);
?>
<div class="tour-details-section">
    <div class="divider"></div>
    <div class="container">
        <div class="divider-xs"></div>
        <?php if (!wp_is_mobile()): ?>
        <?php get_template_part('partials/tours/banner', null, array('review_count' => $review_count)); ?>
        <?php endif; ?>
        <div class="divider-xs"></div>
        <div class="row g-5">
            <div class="col-12 col-lg-8">
                <div class="d-flex flex-row gap-4 align-items-start">
                    <!-- Vertical Thumbs -->
                    <div class="swiper destination-thumbs col-lg-2 col-3 d-lg-flex d-none">
                        <div class="swiper-wrapper d-flex flex-column gap-3">
                            <?php

                            $gallery = get_post_meta($post->ID, "gallery", true);
                            if (!empty($gallery)) {
                                $image_ids = explode(',', $gallery);
                                $index = 0;
                                foreach ($image_ids as $image_id) {
                                    $thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                                    if ($thumb_url) { ?>
                            <div class="swiper-slide  <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="" class="w-100 rounded">
                            </div>
                            <?php }
                                }
                            } ?>
                        </div>

                    </div>
                    <!-- Main Slider -->
                    <div class="swiper destination-details-wrapper col-lg-10 col-12 position-relative">
                        <ul class="list-unstyled d-flex gap-2 wishlist">
                            <li>
                                <button class="wishlist_btn">
                                    <i class='icon ti ti-share'></i> Share <i
                                        class='icon ti ti-chevron-down open_share_links'></i>
                                </button>
                                <ul class="list-unstyled share_links">
                                    <li>
                                        <a href="#"><i class='icon ti ti-link'></i> Copy Link</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class='icon ti ti-mail'></i> Email</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <button class="wishlist_btn" id="add-to-wishlist" data-tour-id="<?php the_ID(); ?>">
                                    <i class='icon ti ti-heart'></i>
                                </button>
                            </li>
                        </ul>
                        <div class="swiper-wrapper">
                            <?php
                            if (!empty($gallery)) {
                                foreach ($image_ids as $image_id) {
                                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                                    if ($image_url) { ?>
                            <div class="swiper-slide">
                                <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-100 rounded">
                            </div>
                            <?php }
                                }
                            } ?>
                        </div>
                        <button class="destination-details-button-prev"><i class="icon-arrow-left"></i></button>
                        <button class="destination-details-button-next"><i class="icon-arrow-right"></i></button>
                    </div>
                </div>
                <?php if (wp_is_mobile()): ?>
                <div class="mt-5">
                    <?php get_template_part('partials/tours/banner', null, array('review_count' => $review_count)); ?>
                </div>
                <?php endif; ?>

                <div class="meta_info">
                    <ul class="list-unstyled d-flex flex-lg-row flex-row align-items-center gap-lg-5 gap-1">
                        <li class="d-flex align-items-center gap-1">
                            <i class='icon ti ti-clock'></i> 5 h 30 m
                        </li>
                        <li class="d-flex align-items-center gap-1">
                            <i class='icon ti ti-device-mobile'></i> Mobile ticket
                        </li>
                        <li class="d-flex align-items-center gap-1">
                            <i class='icon ti ti-messages'></i> English and 1 more
                        </li>
                    </ul>
                </div>
                <?php if (wp_is_mobile()): ?>
                <div class="col-12 col-lg-4">
                    <div class="d-flex flex-column gap-5 mt-5">
                        <?php get_template_part('partials/tours/sidebar'); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Tour Details Content -->
                <div class="tour-details-content">
                    <div class="tour_overview">
                        <h2 class="pb-3">Overview</h2>
                        <?php
                                $overview_text = wp_strip_all_tags($tour_overview); // removes <p>, <br>, etc.
                                $max_chars     = 150;
                                $is_long       = mb_strlen($overview_text) > $max_chars;
                                $short_text    = $is_long ? mb_substr($overview_text, 0, $max_chars) . '...' : $overview_text;
                                ?>
                        <div class="overview-content">
                            <span class="short-text"><?php echo esc_html($short_text); ?></span>
                            <?php if ($is_long): ?>
                            <span class="full-text" style="display:none;"><?php echo esc_html($overview_text); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($is_long): ?>
                        <button class="btn btn-link p-0 mt-2 read-more-btn" type="button">Show All</button>
                        <?php endif; ?>
                    </div>
                    <?php
                        get_template_part('partials/tours/itinerary', null, array('trip_itinerary' => $trip_itinerary));
                    ?>
                </div>
                <div class="tour_included">
                    <h2 class="pb-3">What's Included</h2>
                    <div class="d-flex flex-lg-row flex-column gap-2 align-items-start">
                        <div>
                            <ul class="list-unstyled d-flex flex-column gap-2">
                                <?php
                                $included = get_post_meta($post->ID, "included", true);
                                if (!empty($included) && is_array($included)) {
                                    foreach ($included as $feature => $is_included) {
                                        if ($is_included && $is_included !== 'false') {
                                            echo "<li class='d-flex gap-2 align-items-center'><i class='ti ti-check text-black'></i> $feature</li>";
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div>
                            <ul class="list-unstyled d-flex flex-column gap-2 ">
                                <?php
                                $not_included = get_post_meta($post->ID, "not_included", true);
                                if (!empty($not_included) && is_array($not_included)) {
                                    foreach ($not_included as $nofeature => $is_not_included) {
                                        if ($is_not_included && $is_not_included !== 'false') {
                                            echo "<li class='d-flex gap-2 align-items-center'><i class='ti ti-x text-black'></i> $nofeature</li>";
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tour_additional">
                    <h2 class="pb-3">Additional Info</h2>
                    <ul class="list-disc d-flex flex-column gap-2 mb-3">
                        <li>
                            Confirmation will be received at time of booking
                        </li>
                        <li>
                            Wheelchair accessible
                        </li>
                    </ul>
                    <button onclick="openPopup('tour_additional_popup')">
                        Show more
                    </button>

                </div>
                <div class="tour_additional_list d-flex flex-lg-row flex-column gap-4 mt-5">
                    <div class="tour_additional_box col-lg-6 col-12">
                        <div class="d-flex flex-lg-row flex-column justify-content-between">
                            <h4>
                                Cancellation Policy
                            </h4>
                        </div>
                        <p>You can cancel up to 24 hours in advance of the experience for a full refund.</p>
                        <button onclick="openPopup('cancellation_popup')">
                            Show more
                        </button>
                    </div>
                    <div class="tour_additional_box col-lg-6 col-12">
                        <div class="d-flex flex-lg-row flex-column justify-content-between">
                            <h4>
                                Questions?
                            </h4>
                        </div>
                        <p>Need help? Contact us for any further questions</p>
                        <button onclick="openPopup('questions_popup')">
                            Contact Support
                        </button>
                    </div>


                </div>
                <!-- Tour reviews -->
                <?php if (!wp_is_mobile()) {
                        get_template_part('partials/tours/reviews', null, array('tour_comments' => $tour_comments, 'review_count' => $review_count));
                    }
                ?>
            </div>
            <div class="col-12 col-lg-4">
                <?php if (!wp_is_mobile()): ?>
                <div class="d-flex flex-column gap-5 sticky-sidebar">
                    <?php get_template_part('partials/tours/sidebar'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tour_additional Popup -->
<div id="tour_additional_popup" class="pop_up_wrapper">
    <div class="cancellation_pop_up ">
        <div class="d-flex align-items-start justify-content-between pb-2 mb-4 border-bottom">
            <h3>
                Additional Info
            </h3>
            <button class="close_popup" onclick="closePopup('tour_additional_popup')">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="pb-5">
            <?php echo get_post_meta($post->ID, "additional_info", true); ?>
        </div>
    </div>
</div>
<!-- Cancellation Popup -->
<div id="cancellation_popup" class="pop_up_wrapper">
    <div class="cancellation_pop_up ">
        <div class="d-flex align-items-start justify-content-between pb-2 mb-4 border-bottom">
            <h3>
                Cancellation
            </h3>
            <button class="close_popup" onclick="closePopup('cancellation_popup')">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="pb-5">
            <p class="mb-3">
                You can cancel up to 24 hours in advance of the experience for a full refund.
            </p>
            <ul class="mb-3 d-flex flex-column gap-2">
                <li>For a full refund, you must cancel at least 24 hours before the experience's start time. </li>
                <li>If you cancel less than 24 hours before the experience's start time, the amount you paid will not be
                    refunded. </li>
                <li>Any changes made less than 24 hours before the experience's start time will not be accepted. </li>
                <li>Cut-off times are based on the experience's local time. </li>
                <li>This experience requires a minimum number of travelers. If it's canceled because the minimum isn't
                    met, you'll be offered a different date/experience or a full refund.</li>
            </ul>
            <a href="#" class="text-decoration-underline">
                Read more about Cancellation.
            </a>
        </div>
    </div>
</div>
<!-- Questions Popup -->
<div id="questions_popup" class="pop_up_wrapper">
    <div class="cancellation_pop_up ">
        <div class="d-flex align-items-start justify-content-between pb-2 mb-4 border-bottom">
            <h3>
                Questions?
            </h3>
            <button class="close_popup" onclick="closePopup('questions_popup')">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="pb-5">
            <div class="accordion" id="faqAccordion">

                <!-- FAQ 1 (Open by default) -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                            What is included in the tour package?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Our tour packages usually include transportation, guided tours, entrance fees, and
                            accommodation. Meals may vary depending on the package.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false"
                            aria-controls="faq2">
                            Can I cancel or reschedule my booking?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes! You can cancel or reschedule up to 24 hours before the start of your tour for a full
                            refund.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false"
                            aria-controls="faq3">
                            Do you offer group discounts?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we provide special discounts for groups of 10 or more. Contact us for customized group
                            pricing.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false"
                            aria-controls="faq4">
                            What should I bring for the tour?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We recommend bringing comfortable shoes, sunscreen, a hat, water, and a valid ID/passport
                            depending on the destination.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<section class="tour-list-section">
    <!-- Divider -->
    <div class="container">
        <div class="row g-4">
            <?php if (wp_is_mobile()): ?>
            <?php get_template_part('partials/tours/reviews', null, array('tour_comments' => $tour_comments, 'review_count' => $review_count)); ?>
            <?php endif; ?>

            <div class="">
                <h2 class="pb-3 pt-lg-5">Related Tours</h2>
            </div>
            <div class="col-12 col-md-8">
                <div class="tour-list-content">
                    <div id="tour-results" class="row g-4">
                        <?php
                        $args = array(
                            'post_type' => 'tours',
                            'posts_per_page' => 4,
                            'post_status' => 'publish',
                        );
                        $tours_query = new WP_Query($args);
                        if ($tours_query->have_posts()):
                            while ($tours_query->have_posts()):
                                $tours_query->the_post();                               
                                echo '<div class="col-12 col-lg-6">';
                                get_template_part('partials/tour','box',array('review_count' => $review_count  )
                                );
                                echo '</div>';
                            endwhile;
                            wp_reset_postdata();
                        else:
                            echo '<p>No tours found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
</section>
<?php get_footer(); ?>


<script>
// Traveler selection functionality

// Open popup by ID
function openPopup(id) {
    document.getElementById(id).classList.add('active');
}

// Close popup by ID
function closePopup(id) {
    document.getElementById(id).classList.remove('active');
}

// Close when clicking outside popup
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('pop_up_wrapper')) {
        e.target.classList.remove('active');
    }
});

document.querySelectorAll('.wishlist_btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // Close other open dropdowns (optional)
        document.querySelectorAll('.share_links').forEach(menu => {
            if (menu !== this.nextElementSibling) {
                menu.classList.remove('active');
            }
        });

        // Toggle this dropdown
        const dropdown = this.nextElementSibling;
        dropdown.classList.toggle('active');
    });
});

// Close when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.wishlist li')) {
        document.querySelectorAll('.share_links').forEach(menu => {
            menu.classList.remove('active');
        });
    }
});



document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".read-more-btn").forEach(function(btn) {
        btn.addEventListener("click", function() {
            const parent = btn.closest(".tour_overview");
            parent.querySelector(".short-text").style.display = "none";
            parent.querySelector(".full-text").style.display = "inline";
            btn.style.display = "none"; // hide button after expanding
        });
    });
});
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/sticky.js"></script>