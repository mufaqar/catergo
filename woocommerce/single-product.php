<?php
/**
 * Template for displaying a single WooCommerce product with custom layout
 */
if (!defined('ABSPATH')) {
    exit;
}

// Get global WooCommerce product object safely
global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

get_header('shop');
?>

<!-- Product Details Section Start -->
<section class="product-details-section section-padding">
    <div class="container">
        <div class="product-details-wrapper style-2">
            <div class="row g-4">
                <!-- Product Image -->
                <div class="col-xl-4 col-lg-6">
                    <div class="product-image-items">
                        <div class="product-image">
                            <?php
                            if (has_post_thumbnail()) {
                                echo get_the_post_thumbnail($product->get_id(), 'large', ['class' => 'w-100 rounded']);
                            } else {
                                echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="Placeholder" class="w-100 rounded">';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-xl-5 col-lg-6">
                    <div class="product-details-content">
                        <div class="star pb-3">
                            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                            <a href="#reviews" class="text-color">(<?php echo $product->get_review_count(); ?> Reviews)</a>
                        </div>

                        <h3 class="pb-3"><?php the_title(); ?></h3>

                        <div class="price-list d-flex align-items-center mb-4">
                            <span class="fw-bold text-primary fs-4"><?php echo $product->get_price_html(); ?></span>
                        </div>

                        <div class="mb-4 product-short-description">
                            <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt); ?>
                        </div>

                        <div class="social-icon d-flex align-items-center gap-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart + Options -->
                <div class="col-xl-3 col-lg-4">
                    <div class="product-form-wrapper p-4 border rounded shadow-sm bg-white">
                        <div class="delivery-time mb-3">
                            <strong>Delivery:</strong> <span>35 minutes</span>
                        </div>

                        <?php do_action('woocommerce_before_add_to_cart_form'); ?>

                        <form class="cart" method="post" enctype='multipart/form-data'>
                            <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                            <div class="form-clt mb-3">
                                <label class="select-crust">Quantity</label>
                                <?php
                                woocommerce_quantity_input([
                                    'min_value' => 1,
                                    'max_value' => $product->get_max_purchase_quantity(),
                                    'input_value' => 1,
                                ]);
                                ?>
                            </div>

                            <!-- ✅ Custom Instruction Field -->
                            <div class="form-clt mb-3">
                                <label for="custom_instructions" class="fw-semibold">Special Instructions</label>
                                <textarea name="custom_instructions" id="custom_instructions" rows="3" class="form-control" placeholder="e.g. No onions, extra spicy"></textarea>
                            </div>

                            <div class="form-clt">
                                <button type="submit" name="add-to-cart"
                                        value="<?php echo esc_attr($product->get_id()); ?>"
                                        class="theme-btn add_to_cart_button single_add_to_cart_button button alt">
                                    <i class="far fa-shopping-bag"></i>
                                    <span class="button-text">Add To Cart</span>
                                </button>
                            </div>

                            <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                        </form>

                        <?php do_action('woocommerce_after_add_to_cart_form'); ?>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="single-tab mt-5">
                <ul class="nav mb-4">
                    <li class="nav-item">
                        <a href="#description" data-bs-toggle="tab" class="nav-link active">Description</a>
                    </li>
                    <li class="nav-item">
                        <a href="#additional" data-bs-toggle="tab" class="nav-link">Additional Information</a>
                    </li>
                    <li class="nav-item">
                        <a href="#reviews" data-bs-toggle="tab" class="nav-link">Reviews (<?php echo $product->get_review_count(); ?>)</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Description Tab -->
                    <div id="description" class="tab-pane fade show active">
                        <div class="description-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Additional Info Tab -->
                    <div id="additional" class="tab-pane fade">
                        <div class="table-responsive">
                            <?php do_action('woocommerce_product_additional_information', $product); ?>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-pane fade">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer('shop'); ?>
