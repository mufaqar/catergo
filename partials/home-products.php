<section class="food-category-section fix section-padding section-bg">
    <div class="container">
        <div class="section-title text-center">
            <span class="wow fadeInUp">crispy, every bite taste</span>
            <h2 class="wow fadeInUp" data-wow-delay=".3s">Popular Food Items</h2>
        </div>

        <div class="row">
            <?php
            // WooCommerce Product Query
            $args = [
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'meta_query'     => [
                    [
                        'key'     => '_stock_status',
                        'value'   => 'instock',
                        'compare' => '='
                    ]
                ]
            ];

            $products = new WP_Query($args);
            $delay_classes = ['.3s', '.5s', '.7s', '.8s', '.3s', '.5s', '.7s', '.8s'];
            $delay_index = 0;

            if ($products->have_posts()) :
                while ($products->have_posts()) : $products->the_post();
                    $product = wc_get_product(get_the_ID());
                    $regular_price = $product->get_regular_price();
                    $sale_price    = $product->get_sale_price();
                    $price_html    = $product->get_price_html();
                    $discount_percent = 0;

                    if ($regular_price && $sale_price && $regular_price > $sale_price) {
                        $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                    }

                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: wc_placeholder_img_src();
                    $image_alt = get_the_title();
                    ?>

            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp"
                data-wow-delay="<?php echo esc_attr($delay_classes[$delay_index]); ?>">
                <div class="catagory-product-card-2 text-center">
                    <div class="icon">
                        <?php
                                // Wishlist (if plugin available)
                                if (function_exists('YITH_WCWL')) {
                                    echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . get_the_ID() . '"]');
                                } else {
                                    echo '<a href="#"><i class="far fa-heart"></i></a>';
                                }
                                ?>
                    </div>

                    <div class="catagory-product-image">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        </a>
                        <?php if ($product->is_on_sale()) : ?>
                        <span class="onsale">-<?php echo esc_html($discount_percent); ?>%</span>
                        <?php endif; ?>
                    </div>

                    <div class="catagory-product-content">
                        <div class="info-price d-flex align-items-center justify-content-center">
                            <?php if ($discount_percent > 0) : ?>
                            <p>-<?php echo esc_html($discount_percent); ?>%</p>
                            <?php endif; ?>
                            <h6><?php echo $price_html; ?></h6>
                        </div>
                        <h4>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                        </h4>
                        <div class="store_name">
                            <?php echo get_product_store_name(get_the_ID()); ?>
                        </div>
                        <div class="">
                            <a href="#" class="product-popup btn btn-outline-secondary btn-sm"
                                data-productid="<?php echo get_the_ID(); ?>">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <?php
                    $delay_index++;
                    if ($delay_index >= count($delay_classes)) {
                        $delay_index = 0;
                    }
                endwhile;
                wp_reset_postdata();
            else :
                ?>
            <div class="col-12 text-center">
                <p>No products found.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="catagory-button text-center pt-4 wow fadeInUp" data-wow-delay=".3s">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="theme-btn">
                <span class="button-content-wrapper d-flex align-items-center">
                    <span class="button-icon"><i class="flaticon-delivery"></i></span>
                    <span class="button-text">View More</span>
                </span>
            </a>
        </div>
    </div>
</section>