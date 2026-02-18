<?php

    include_once('ajax_calls.php');
  include_once('store.php');
  include_once('request.php');
   //include_once('redirect.php');

 



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





function current_location_shortcode() {
    // From URL query var
    $location = get_query_var('location');

    // fallback from cookie
    if (!$location && !empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);
    }

    return $location ? $location : '';
}
add_shortcode('current_location', 'current_location_shortcode');


add_filter('wp_nav_menu_objects', function($items, $args) {

    // Get current location
    $location = get_query_var('location');
    if (!$location && !empty($_COOKIE['selected_location'])) {
        $location = sanitize_text_field($_COOKIE['selected_location']);
    }

    foreach ($items as $item) {
        // Replace placeholder __location__ in menu links
        if (strpos($item->url, '__location__') !== false) {
            $item->url = str_replace('__location__', $location ? $location : '', $item->url);
        }
    }

    return $items;
}, 10, 2);

