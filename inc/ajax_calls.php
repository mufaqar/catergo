<?php
/**
 * AJAX: Load Woo product popup
 */
add_action('wp_ajax_get_product_popup', 'get_product_popup');
add_action('wp_ajax_nopriv_get_product_popup', 'get_product_popup');

function get_product_popup() {
    $product_id = intval($_POST['product_id']);
    if (!$product_id) wp_send_json_error('Invalid product ID');

    $product = wc_get_product($product_id);
    if (!$product) wp_send_json_error('Product not found');

    ob_start(); ?>
<div class="popup-inner">
    <div class="container-fluid">
        <div class="row align-items-start g-4">
            <!-- Product Image -->
            <div class="col-md-5 text-center">
                <?php echo $product->get_image('large', ['class' => 'img-fluid rounded shadow-sm']); ?>
            </div>

            <!-- Product Info -->
            <div class="col-md-7">
                <h3 class="fw-bold mb-2"><?php echo esc_html($product->get_name()); ?></h3>
                <div class="text-primary fs-5 mb-2"><?php echo $product->get_price_html(); ?></div>
                <div class="text-muted mb-3">
                    <?php echo wpautop($product->get_short_description() ?: 'No description available.'); ?>
                </div>

                <!-- Instruction box -->
                <div class="form-group mb-3">
                    <label class="form-label fw-semibold">Special Instructions (optional)</label>
                    <textarea name="custom_note" class="form-control" rows="3"
                        placeholder="Add a note for the chef..."></textarea>
                </div>

                <!-- WooCommerce Add to Cart -->
                <form class="cart" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="custom_note_field" value="" />
                    <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>">

                    <?php if ($product->is_type('simple')) : ?>
                    <button type="submit" class="single_add_to_cart_button btn btn-primary">
                        <?php echo esc_html($product->single_add_to_cart_text()); ?>
                    </button>
                    <?php else : ?>
                    <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="btn btn-outline-primary">
                        View Product
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

    wp_send_json_success(ob_get_clean());
}

/**
 * Save instruction note in cart
 */
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    if (!empty($_POST['custom_note_field'])) {
        $cart_item_data['custom_note'] = sanitize_textarea_field($_POST['custom_note_field']);
    }
    return $cart_item_data;
}, 10, 2);

/**
 * Display custom note in cart/checkout
 */
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    if (!empty($cart_item['custom_note'])) {
        $item_data[] = [
            'key'   => __('Instruction', 'textdomain'),
            'value' => esc_html($cart_item['custom_note']),
        ];
    }
    return $item_data;
}, 10, 2);