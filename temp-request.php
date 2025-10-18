<?php
/*Template Name: Request */

get_header(); ?>

<?php $bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
        get_template_part('partials/content', 'breadcrumb', [
            'bg' => $bg_image
        ]); ?>

<section class="booking-section fix section-bg section-padding mt-0">
    <div class="container">
        <div class="booking-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="booking-contact mb-0 style-2 bg-cover"
                        style="background-image: url('assets/images/booking-shape.png');">
                        <h3 class="text-center mb-4 text-white wow fadeInUp">
                            Skapa En Reservation
                        </h3>

                        <form class="booking-items">
                            <div class="row g-4">
                                <!-- Förnamn -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".1s">
                                    <div class="form-clt">
                                        <label>Förnamn *</label>
                                        <input type="text" name="first_name" placeholder="Ange ditt förnamn" required>
                                    </div>
                                </div>

                                <!-- Efternamn -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="form-clt">
                                        <label>Efternamn *</label>
                                        <input type="text" name="last_name" placeholder="Ange ditt efternamn" required>
                                    </div>
                                </div>

                                <!-- E-post -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                    <div class="form-clt">
                                        <label>E-post *</label>
                                        <input type="email" name="email" placeholder="Ange din e-postadress" required>
                                    </div>
                                </div>

                                <!-- Telefonnummer -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".4s">
                                    <div class="form-clt">
                                        <label>Telefonnummer *</label>
                                        <input type="tel" name="phone" placeholder="Ange ditt telefonnummer" required>
                                    </div>
                                </div>

                                <!-- Organisationsnummer -->
                                <div class="col-12 wow fadeInUp" data-wow-delay=".5s">
                                    <div class="form-clt">
                                        <label>Organisations-/Personnummer *</label>
                                        <input type="text" name="org_number" placeholder="Ange organisationsnummer"
                                            required>
                                    </div>
                                </div>

                                <!-- Vad vill du beställa -->
                                <div class="col-12 wow fadeInUp" data-wow-delay=".6s">
                                    <label>Vad Vill Du Beställa? *</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <label><input type="checkbox" name="order_type[]" value="Lunchcatering">
                                            Lunchcatering</label>
                                        <label><input type="checkbox" name="order_type[]" value="Kaffe"> Kaffe</label>
                                        <label><input type="checkbox" name="order_type[]" value="Kaffemaskin">
                                            Kaffemaskin</label>
                                        <label><input type="checkbox" name="order_type[]" value="Fruktkorgar">
                                            Fruktkorgar</label>
                                        <label><input type="checkbox" name="order_type[]" value="Food Truck"> Food
                                            Truck</label>
                                        <label><input type="checkbox" name="order_type[]" value="Frukost">
                                            Frukost</label>
                                        <label><input type="checkbox" name="order_type[]" value="Hämta Mat"> Hämta
                                            Mat</label>
                                    </div>
                                </div>

                                <!-- Leveransadress & Postnummer -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                    <div class="form-clt">
                                        <label>Leveransadress *</label>
                                        <input type="text" name="delivery_address" placeholder="Ange leveransadress"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".8s">
                                    <div class="form-clt">
                                        <label>Postnummer *</label>
                                        <input type="text" name="postal_code" placeholder="Ange postnummer" required>
                                    </div>
                                </div>

                                <!-- Hur många personer -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay=".9s">
                                    <div class="form-clt">
                                        <label>Hur Många Personer/Portioner? *</label>
                                        <input type="number" name="persons" placeholder="Ange antal personer" required>
                                    </div>
                                </div>

                                <!-- Budget -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay="1s">
                                    <div class="form-clt">
                                        <label>Budget Per Person *</label>
                                        <input type="text" name="budget" placeholder="Ange budget per person" required>
                                    </div>
                                </div>

                                <!-- Datum & Tid -->
                                <div class="col-md-6 wow fadeInUp" data-wow-delay="1.1s">
                                    <div class="form-clt">
                                        <label>Leveransdatum *</label>
                                        <input type="date" name="delivery_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6 wow fadeInUp" data-wow-delay="1.2s">
                                    <div class="form-clt">
                                        <label>Leveranstid *</label>
                                        <input type="time" name="delivery_time" required>
                                    </div>
                                </div>

                                <!-- Övrig information -->
                                <div class="col-12 wow fadeInUp" data-wow-delay="1.3s">
                                    <div class="form-clt">
                                        <label>Övrig Information</label>
                                        <textarea name="additional_info"
                                            placeholder="Ange ytterligare information"></textarea>
                                    </div>
                                </div>

                                
                            
                                <!-- Submit -->
                                <div class="col-12 text-center wow fadeInUp" data-wow-delay="1.6s">
                                    <button type="submit" class="theme-btn bg-yellow">Skicka</button>
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


<?php get_footer(); ?>