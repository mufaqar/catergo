<?php
/**
 * Register Custom Post Type: Custom Request
 */
add_action('init', function() {
    register_post_type('custom_request', [
        'labels' => [
            'name'          => __('Requests'),
            'singular_name' => __('Request'),
        ],
        'public'       => true,
        'has_archive'  => false,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor', 'custom-fields'],
        'menu_icon'    => 'dashicons-clipboard',
    ]);
});


/**
 * Handle AJAX Submission for Custom Request Form
 */
add_action('wp_ajax_handle_custom_request_form', 'handle_custom_request_form');
add_action('wp_ajax_nopriv_handle_custom_request_form', 'handle_custom_request_form');

function handle_custom_request_form() {
    check_ajax_referer('custom_request_nonce', 'nonce');

    // Sanitize fields
    $data = [
        'first_name'       => sanitize_text_field($_POST['first_name'] ?? ''),
        'last_name'        => sanitize_text_field($_POST['last_name'] ?? ''),
        'email'            => sanitize_email($_POST['email'] ?? ''),
        'phone'            => sanitize_text_field($_POST['phone'] ?? ''),
        'org_number'       => sanitize_text_field($_POST['org_number'] ?? ''),
        'order_type'       => isset($_POST['order_type']) ? array_map('sanitize_text_field', $_POST['order_type']) : [],
        'delivery_address' => sanitize_text_field($_POST['delivery_address'] ?? ''),
        'postal_code'      => sanitize_text_field($_POST['postal_code'] ?? ''),
        'persons'          => sanitize_text_field($_POST['persons'] ?? ''),
        'budget'           => sanitize_text_field($_POST['budget'] ?? ''),
        'delivery_date'    => sanitize_text_field($_POST['delivery_date'] ?? ''),
        'delivery_time'    => sanitize_text_field($_POST['delivery_time'] ?? ''),
        'additional_info'  => sanitize_textarea_field($_POST['additional_info'] ?? ''),
    ];

    // Insert post
    $post_id = wp_insert_post([
        'post_type'   => 'custom_request',
        'post_title'  => $data['first_name'] . ' ' . $data['last_name'] . ' - ' . $data['delivery_date'],
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Error creating request post.']);
    }

    // Save meta
    foreach ($data as $key => $value) {
        update_post_meta($post_id, $key, is_array($value) ? implode(', ', $value) : $value);
    }

    // Send email notification
    $admin_email = get_option('admin_email');
    $subject = 'Ny förfrågan från ' . $data['first_name'];
    $message = "En ny förfrågan har inkommit:\n\n";
    foreach ($data as $key => $value) {
        $message .= ucfirst(str_replace('_', ' ', $key)) . ': ' . (is_array($value) ? implode(', ', $value) : $value) . "\n";
    }
    wp_mail($admin_email, $subject, $message);

    wp_send_json_success(['message' => 'Tack! Din förfrågan har skickats.']);
}


/**
 * Show Meta Fields in Admin
 */
add_action('add_meta_boxes', function() {
    add_meta_box('request_details', 'Request Details', 'render_request_details_meta_box', 'custom_request', 'normal', 'default');
});

function render_request_details_meta_box($post) {
    $fields = [
        'first_name', 'last_name', 'email', 'phone', 'org_number',
        'order_type', 'delivery_address', 'postal_code', 'persons',
        'budget', 'delivery_date', 'delivery_time', 'additional_info'
    ];

    echo '<table class="form-table">';
    foreach ($fields as $field) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<tr>';
        echo '<th><strong>' . ucfirst(str_replace('_', ' ', $field)) . '</strong></th>';
        echo '<td>' . esc_html($value ?: '—') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}



// contact page 

/**
 * Handle AJAX Contact Form Submission
 */
add_action('wp_ajax_handle_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_handle_contact_form', 'handle_contact_form');

function handle_contact_form() {
    check_ajax_referer('ajax_contact_nonce', 'contact_nonce');

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Please fill out all required fields.']);
    }

    $admin_email = get_option('admin_email');
    $subject = 'New Contact Form Submission';
    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    $headers = ['Reply-To: ' . $name . ' <' . $email . '>'];

    if (wp_mail($admin_email, $subject, $body, $headers)) {
        wp_send_json_success(['message' => 'Thank you! Your message has been sent.']);
    } else {
        wp_send_json_error(['message' => 'Failed to send email. Please try again later.']);
    }
}