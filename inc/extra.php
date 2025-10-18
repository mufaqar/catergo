<?php

    include_once('ajax_calls.php');
    include_once('store.php');
    include_once('request.php');

 


    function handle_contact_form() {
        check_ajax_referer('ajax-contact-nonce', 'security');

        $name    = sanitize_text_field($_POST['name']);
        $email   = sanitize_email($_POST['email']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);

        if(empty($name) || empty($email) || empty($message)){
            wp_send_json_error('Please fill all required fields.');
        }

        if(!is_email($email)){
            wp_send_json_error('Invalid email address.');
        }

        // Send Email
        $to = 'booking@gotriptoday.com,info@gotriptoday.com';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Subject:</strong> $subject<br><strong>Message:</strong><br>$message";

        if(wp_mail($to, 'Contact Form: '.$subject, $body, $headers)){
            wp_send_json_success('Thank you! Your message has been sent.');
        } else {
            wp_send_json_error('Email could not be sent. Please try again later..');
        }
    }
    add_action('wp_ajax_submit_contact_form', 'handle_contact_form');
    add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form');

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