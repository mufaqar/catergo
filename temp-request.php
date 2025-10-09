<?php
/*Template Name: Request */

get_header(); ?>

<?php $bg_image = get_template_directory_uri() . '/assets/img/default.webp';
        get_template_part('partials/content', 'breadcrumb', [
            'bg' => $bg_image
        ]); ?>

    <!-- Booking Section Start -->
        <section class="booking-section fix section-bg section-padding mt-0">
            <div class="container">
                <div class="booking-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="booking-contact mb-0 style-2 bg-cover" style="background-image: url('assets/img/shape/booking-shape.png');">
                                <h3 class="text-center mb-4 text-white wow fadeInUp">create an reservation</h3>
                                <div class="booking-items">
                                    <div class="row g-4">
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">
                                                    Clients Name
                                                    </span>
                                                    <ul class="list">
                                                        <li data-value="1" class="option selected">
                                                            Lucas Henry
                                                        </li>
                                                        <li data-value="1" class="option">
                                                            Mateo Jack
                                                        </li>
                                                        <li data-value="1" class="option">
                                                            Michael Asher
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">
                                                    no of person
                                                    </span>
                                                    <ul class="list">
                                                        <li data-value="1" class="option selected">
                                                            1 People
                                                        </li>
                                                        <li data-value="1" class="option">
                                                            2 People
                                                        </li>
                                                        <li data-value="1" class="option">
                                                            3 People
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <input type="text" name="number" id="number" placeholder="phone number">
                                                <div class="icon">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <input type="date" id="calendar" name="calendar">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <input type="text" name="phone" id="phone" placeholder="phone number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <input type="text" name="email" id="email" placeholder="Email Address">
                                                <div class="icon">
                                                    <i class="fal fa-envelope"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <a href="reservation.html" class="theme-btn bg-yellow">
                                                booking now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Testimonial Section Start -->
        <section class="testimonial-section fix section-padding">
            <div class="burger-shape">
                <img src="assets/img/shape/burger-shape-3.png" alt="burger-shape">
            </div>
            <div class="fry-shape">
                <img src="assets/img/shape/fry-shape-2.png" alt="burger-shape">
            </div>
            <div class="pizza-shape">
                <img src="assets/img/shape/pizzashape.png" alt="burger-shape">
            </div>
            <div class="container">
                <div class="testimonial-wrapper style-2">
                    <div class="testimonial-items text-center">
                        <div class="swiper testimonial-content-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-content">
                                        <div class="client-info">
                                            <h4>Piter Bowman</h4>
                                            <h5>Business CEO & co founder</h5>
                                        </div>
                                        <h3>
                                            “Thank you for dinner last night. It was amazing!! I have
                                            say it’s the best meal I have had in quite some time.
                                            will definitely be seeing more eating next year.”
                                        </h3>
                                        <div class="star">
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-content">
                                        <div class="client-info">
                                            <h4>Piter Bowman</h4>
                                            <h5>Business CEO & co founder</h5>
                                        </div>
                                        <h3>
                                            “Thank you for dinner last night. It was amazing!! I have
                                            say it’s the best meal I have had in quite some time.
                                            will definitely be seeing more eating next year.”
                                        </h3>
                                        <div class="star">
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-content">
                                        <div class="client-info">
                                            <h4>Piter Bowman</h4>
                                            <h5>Business CEO & co founder</h5>
                                        </div>
                                        <h3>
                                            “Thank you for dinner last night. It was amazing!! I have
                                            say it’s the best meal I have had in quite some time.
                                            will definitely be seeing more eating next year.”
                                        </h3>
                                        <div class="star">
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper testimonial-image-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="client-image-item">
                                        <div class="client-img bg-cover" style="background-image: url('assets/img/client/01.jpg')"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="client-image-item">
                                        <div class="client-img bg-cover" style="background-image: url('assets/img/client/02.jpg')"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="client-image-item">
                                        <div class="client-img bg-cover" style="background-image: url('assets/img/client/03.jpg')"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<?php get_footer(); ?>
