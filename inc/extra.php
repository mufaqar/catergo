<?php

    include_once('ajax_calls.php');
    include_once('store.php');
    include_once('request.php');

 



    add_action('wp_enqueue_scripts', function() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
});


// Save custom instruction in cart item
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id) {
    if (!empty($_POST['custom_instructions'])) {
        $cart_item_data['custom_instructions'] = sanitize_textarea_field($_POST['custom_instructions']);
    }
    return $cart_item_data;
}, 10, 2);

// Display in cart and checkout
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (!empty($cart_item['custom_instructions'])) {
        $item_data[] = [
            'name'  => __('Instructions', 'your-theme'),
            'value' => wp_kses_post($cart_item['custom_instructions']),
        ];
    }
    return $item_data;
}, 10, 2);

// Save to order items
add_action('woocommerce_add_order_item_meta', function ($item_id, $values) {
    if (!empty($values['custom_instructions'])) {
        wc_add_order_item_meta($item_id, 'Instructions', $values['custom_instructions']);
    }
}, 10, 2);