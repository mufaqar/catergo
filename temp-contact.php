<?php 
/*Template Name: Contact*/

get_header(); ?>


<?php $bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
        get_template_part('partials/content', 'breadcrumb', [
            'bg' => $bg_image
        ]); ?>



<section class="contact-info-section fix section-padding section-bg">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="contact-info-items text-center">
                    <div class="icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/location.svg"
                            alt="icon-img">
                    </div>
                    <div class="content">
                        <h3>address line</h3>
                        <p>
                            Ljungaverk, Southern Norrland 840 10 Sweden
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                <div class="contact-info-items active text-center">
                    <div class="icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.svg"
                            alt="icon-img">
                    </div>
                    <div class="content">
                        <h3>Phone Number</h3>
                        <p>
                            08-640 244 00
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                <div class="contact-info-items text-center">
                    <div class="icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/email.svg"
                            alt="icon-img">
                    </div>
                    <div class="content">
                        <h3>Mail Adress</h3>
                        <p>
                            info@catergo.se
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section section-padding pt-0 section-bg">
    <div class="container">
        <div class="contact-area">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-lg-6">
                    <div class="map-content-area">
                        <h3 class="wow fadeInUp" data-wow-delay=".3s"> Get in touch</h3>
                        <p class="wow fadeInUp" data-wow-delay=".5s">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit mattis <br>
                            faucibus odio feugiat arc dolor.
                        </p>
                        <div class="google-map wow fadeInUp" data-wow-delay=".7s">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9556513153167!3d-37.81732797975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d6fb4d5d9c5b!2sEnvato!5e0!3m2!1sen!2sin!4v1547517459706"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 mt-5 mt-lg-0">
                    <div class="contact-form-items">
                        <div class="contact-title">
                            <h3 class="wow fadeInUp" data-wow-delay=".3s">Fill Up The Form</h3>
                            <p class="wow fadeInUp" data-wow-delay=".5s">Your email address will not be published.
                                Required fields are marked *</p>
                        </div>

                        <form id="ajax-contact-form" method="post">
                            <?php wp_nonce_field('ajax_contact_nonce', 'contact_nonce'); ?>
                            <div class="row g-4">
                                <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                    <div class="form-clt">
                                        <input type="text" name="name" placeholder="Your Name*" required>
                                        <div class="icon"><i class="fal fa-user"></i></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                    <div class="form-clt">
                                        <input type="email" name="email" placeholder="Email Address*" required>
                                        <div class="icon"><i class="fal fa-envelope"></i></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 wow fadeInUp" data-wow-delay=".7s">
                                    <div class="form-clt-big form-clt">
                                        <textarea name="message" placeholder="Enter Your Message here"
                                            required></textarea>
                                        <div class="icon"><i class="fal fa-edit"></i></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".8s">
                                    <button type="submit" class="theme-btn">
                                        <span class="button-content-wrapper d-flex align-items-center">
                                            <span class="button-icon"><i class="fal fa-paper-plane"></i></span>
                                            <span class="button-text">Get In Touch</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <p id="contact-response" class="mt-3 text-success" style="display:none;"></p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>




<?php get_footer(); ?>


<script>
jQuery(document).ready(function($) {
    $('#ajax-contact-form').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData + '&action=handle_contact_form',
            beforeSend: function() {
                $('#contact-response').hide().removeClass('text-success text-danger');
            },
            success: function(response) {
                if (response.success) {
                    $('#contact-response').addClass('text-success').text(response.data
                        .message).fadeIn();
                    $('#ajax-contact-form')[0].reset();
                } else {
                    $('#contact-response').addClass('text-danger').text(response.data
                        .message).fadeIn();
                }
            },
            error: function() {
                $('#contact-response').addClass('text-danger').text(
                    'Something went wrong, please try again.').fadeIn();
            }
        });
    });
});
</script>