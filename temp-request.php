<?php
/* Template Name: Request */

get_header();

// Breadcrumb background
$bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
get_template_part('partials/content', 'breadcrumb', ['bg' => $bg_image]);
?>

<section class="booking-section fix section-bg section-padding mt-0">
    <div class="container">
        <div class="booking-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="booking-contact mb-0 style-2 bg-cover"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/booking-shape.png');">

                        <h3 class="text-center mb-4 text-white wow fadeInUp">Skapa En Reservation</h3>

                        <!-- AJAX Form -->
                        <form class="booking-items" id="custom-request-form">
                            <div class="row g-4">
                                <!-- Förnamn -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Förnamn *</label>
                                        <input type="text" name="first_name" placeholder="Ange ditt förnamn" required>
                                    </div>
                                </div>

                                <!-- Efternamn -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Efternamn *</label>
                                        <input type="text" name="last_name" placeholder="Ange ditt efternamn" required>
                                    </div>
                                </div>

                                <!-- E-post -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>E-post *</label>
                                        <input type="email" name="email" placeholder="Ange din e-postadress" required>
                                    </div>
                                </div>

                                <!-- Telefonnummer -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Telefonnummer *</label>
                                        <input type="tel" name="phone" placeholder="Ange ditt telefonnummer" required>
                                    </div>
                                </div>

                                <!-- Organisationsnummer -->
                                <div class="col-12">
                                    <div class="form-clt">
                                        <label>Organisations-/Personnummer *</label>
                                        <input type="text" name="org_number" placeholder="Ange organisationsnummer" required>
                                    </div>
                                </div>

                                <!-- Vad Vill Du Beställa -->
                                <div class="col-12">
                                    <label>Vad Vill Du Beställa? *</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php
                                        $options = ['Lunchcatering', 'Kaffe', 'Kaffemaskin', 'Fruktkorgar', 'Food Truck', 'Frukost', 'Hämta Mat'];
                                        foreach ($options as $option) :
                                        ?>
                                            <label>
                                                <input type="checkbox" name="order_type[]" value="<?php echo esc_attr($option); ?>"> <?php echo esc_html($option); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Leveransadress & Postnummer -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Leveransadress *</label>
                                        <input type="text" name="delivery_address" placeholder="Ange leveransadress" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Postnummer *</label>
                                        <input type="text" name="postal_code" placeholder="Ange postnummer" required>
                                    </div>
                                </div>

                                <!-- Personer / Budget -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Hur Många Personer/Portioner? *</label>
                                        <input type="number" name="persons" placeholder="Ange antal personer" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Budget Per Person *</label>
                                        <input type="text" name="budget" placeholder="Ange budget per person" required>
                                    </div>
                                </div>

                                <!-- Datum & Tid -->
                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Leveransdatum *</label>
                                        <input type="date" name="delivery_date" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-clt">
                                        <label>Leveranstid *</label>
                                        <input type="time" name="delivery_time" required>
                                    </div>
                                </div>

                                <!-- Övrig Information -->
                                <div class="col-12">
                                    <div class="form-clt">
                                        <label>Övrig Information</label>
                                        <textarea name="additional_info" placeholder="Ange ytterligare information"></textarea>
                                    </div>
                                </div>

                                <!-- GDPR Checkbox -->
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agree_terms" required>
                                        <label class="form-check-label">Jag har läst och godkänner Catergos villkor.</label>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-12 text-center">
                                    <button type="submit" class="theme-btn bg-yellow">
                                        <span>Skicka</span>
                                    </button>
                                </div>

                                <!-- Message -->
                                <div class="col-12">
                                    <div id="form-message" class="text-center mt-3"></div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('partials/home', 'testimonials'); ?>

<script>
jQuery(document).ready(function($) {
    $('#custom-request-form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var message = $('#form-message');
        message.html('').removeClass('text-success text-danger');

        var formData = form.serialize();
        formData += '&action=handle_custom_request_form';
        formData += '&nonce=' + '<?php echo wp_create_nonce('custom_request_nonce'); ?>';

        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                form.find('button').prop('disabled', true).text('Skickar...');
            },
            success: function(response) {
                if (response.success) {
                    message.addClass('text-success').html(response.data.message);
                    form[0].reset();
                } else {
                    message.addClass('text-danger').html('Ett fel uppstod. Försök igen.');
                }
            },
            error: function() {
                message.addClass('text-danger').html('Ett serverfel inträffade.');
            },
            complete: function() {
                form.find('button').prop('disabled', false).text('Skicka');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
