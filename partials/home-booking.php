<section class="main-cta-banner section-padding pt-0">
    <div class="container">
        <div class="main-cta-banner-wrapper bg-cover mt-10"
            style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/banner/main-cta-bg.jpg');">
            <div class="section-title">
                <span class="theme-color-3 wow fadeInUp">crispy, every bite taste</span>
                <h2 class="text-white wow fadeInUp" data-wow-delay=".3s">
                    30 minutes fast <br>
                    <span class="theme-color-3">delivery</span> challage
                </h2>
            </div>
            <a href="shop-single.html" class="theme-btn bg-white mt-4 mt-md-0 wow fadeInUp" data-wow-delay=".5s">
                <span class="button-content-wrapper d-flex align-items-center">
                    <span class="button-icon"><i class="flaticon-delivery"></i></span>
                    <span class="button-text">order now</span>
                </span>
            </a>

            <div class="delivery-man">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/delivery-man.png" alt="img">
            </div>

        </div>
    </div>
</section>

<section class="booking-section fix section-padding bg-cover"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/banner/main-bg.jpg');">
    <div class="container">
        <div class="booking-wrapper style-responsive section-padding pb-0">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div class="booking-content">
                        <div class="section-title">
                            <span class="wow fadeInUp">crispy, every bite taste</span>
                            <h2 class="text-white wow fadeInUp" data-wow-delay=".3s">
                                need booking? <br>
                                reserve your table?
                            </h2>
                        </div>
                        <div class="icon-items d-flex align-items-center wow fadeInUp" data-wow-delay=".5s">
                            <div class="icon">
                                <i class="flaticon-phone-call-2"></i>
                            </div>
                            <div class="content">
                                <h5>24/7 Support center</h5>
                                <h3><a href="tel:+0864024400">08-640 244 00</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 mt-5 mt-lg-0 wow fadeInUp" data-wow-delay=".4s">
                    <div class="booking-contact bg-cover"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/booking-shape.png');">
                        <h4 class="text-center text-white">Quick Reservation</h4>

                        <form id="ajax-quick-reservation">
                            <?php wp_nonce_field('ajax_quick_reservation_nonce', 'quick_reservation_nonce'); ?>
                            <div class="booking-items">

                                <!-- Number of Persons -->
                                <div class="form-clt">
                                    <label for="persons" class="text-white mb-1 d-block">Number of Persons*</label>
                                    <select name="persons" id="persons" required class="form-select">
                                        <option value="">Select</option>
                                        <option value="1">1 Person</option>
                                        <option value="2">2 Persons</option>
                                        <option value="3">3 Persons</option>
                                        <option value="4">4 Persons</option>
                                        <option value="5+">5+ Persons</option>
                                    </select>
                                </div>

                                <!-- Phone -->
                                <div class="form-clt">
                                    <label for="phone" class="text-white mb-1 d-block">Phone Number*</label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter phone number"
                                        required>

                                </div>

                                <!-- Date -->
                                <div class="form-clt">
                                    <label for="date" class="text-white mb-1 d-block">Reservation Date*</label>
                                    <input type="date" id="date" name="date" required>
                                </div>

                                <!-- Time -->
                                <div class="form-clt">
                                    <label for="time" class="text-white mb-1 d-block">Time*</label>
                                    <input type="time" id="time" name="time" required>
                                </div>

                                <!-- Message -->
                                <div class="form-clt">
                                    <label for="message" class="text-white mb-1 d-block">Message</label>
                                    <textarea name="message" id="message" placeholder="Additional details"></textarea>
                                </div>

                                <!-- Submit -->
                                <div class="form-clt text-center mt-3">
                                    <button type="submit" class="theme-btn bg-yellow w-100">Book Now</button>
                                </div>

                                <p id="reservation-response" class="mt-3 text-center text-white" style="display:none;">
                                </p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    $('#ajax-quick-reservation').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData + '&action=handle_quick_reservation',
            beforeSend: function() {
                $('#reservation-response').hide().removeClass('text-success text-danger');
            },
            success: function(response) {
                if (response.success) {
                    $('#reservation-response').addClass('text-success').text(response.data
                        .message).fadeIn();
                    $('#ajax-quick-reservation')[0].reset();
                } else {
                    $('#reservation-response').addClass('text-danger').text(response.data
                        .message).fadeIn();
                }
            },
            error: function() {
                $('#reservation-response').addClass('text-danger').text(
                    'Something went wrong. Please try again.').fadeIn();
            }
        });
    });
});
</script>