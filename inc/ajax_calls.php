<?php



// Hook registrations (keep these if not already present)
//add_action('admin_post_process_booking', 'process_booking_form');
//add_action('admin_post_nopriv_process_booking', 'process_booking_form');

/**
 * Process booking form submitted from the Booking Details template.
 */
function process_booking_form() {
    // Verify nonce
    if ( ! isset( $_POST['booking_nonce_field'] ) || ! wp_verify_nonce( $_POST['booking_nonce_field'], 'booking_nonce' ) ) {
        wp_die( __( 'Security check failed', 'your-text-domain' ) );
    }

    // Basic posted values
    $tour_id            = isset( $_POST['tour_id'] ) ? intval( $_POST['tour_id'] ) : 0;
    $tour_date          = isset( $_POST['tour_date'] ) ? sanitize_text_field( $_POST['tour_date'] ) : '';
    $tour_adults        = isset( $_POST['tour_adults'] ) ? intval( $_POST['tour_adults'] ) : 0;
    $tour_child         = isset( $_POST['tour_child'] ) ? intval( $_POST['tour_child'] ) : 0;
    $tour_price         = isset( $_POST['tour_price'] ) ? floatval( $_POST['tour_price'] ) : 0;
    $booking_product_id = isset( $_POST['booking_product_id'] ) ? intval( $_POST['booking_product_id'] ) : 0;

    // Form fields (new names)
    $pax              = isset( $_POST['pax'] ) ? intval( $_POST['pax'] ) : ( $tour_adults + $tour_child );
    $pickup_datetime  = isset( $_POST['pickup_datetime'] ) ? sanitize_text_field( $_POST['pickup_datetime'] ) : '';
    $pickup_address   = isset( $_POST['pickup_address'] ) ? sanitize_text_field( $_POST['pickup_address'] ) : '';
    $dropoff_address  = isset( $_POST['dropoff_address'] ) ? sanitize_text_field( $_POST['dropoff_address'] ) : '';
    $transport_info   = isset( $_POST['transport_info'] ) ? sanitize_text_field( $_POST['transport_info'] ) : '';
    $driver_notes     = isset( $_POST['driver_notes'] ) ? sanitize_textarea_field( $_POST['driver_notes'] ) : '';
    $vehicle_posted   = isset( $_POST['vehicle'] ) ? sanitize_text_field( $_POST['vehicle'] ) : '';
    $child_seats      = isset( $_POST['child_seat_type'] ) && is_array( $_POST['child_seat_type'] ) ? array_map( 'sanitize_text_field', $_POST['child_seat_type'] ) : array();

    $customer_name    = isset( $_POST['passenger_name'] ) ? sanitize_text_field( $_POST['passenger_name'] ) : '';
    $customer_email   = isset( $_POST['passenger_email'] ) ? sanitize_email( $_POST['passenger_email'] ) : '';
    $customer_phone   = isset( $_POST['passenger_mobile'] ) ? sanitize_text_field( $_POST['passenger_mobile'] ) : '';

    $need_invoice     = isset( $_POST['need_invoice'] ) ? 1 : 0;
    $company_name     = isset( $_POST['company_name'] ) ? sanitize_text_field( $_POST['company_name'] ) : '';
    $invoice_street   = isset( $_POST['invoice_street'] ) ? sanitize_text_field( $_POST['invoice_street'] ) : '';
    $invoice_city     = isset( $_POST['invoice_city'] ) ? sanitize_text_field( $_POST['invoice_city'] ) : '';
    $invoice_zip      = isset( $_POST['invoice_zip'] ) ? sanitize_text_field( $_POST['invoice_zip'] ) : '';
    $invoice_country  = isset( $_POST['invoice_country'] ) ? sanitize_text_field( $_POST['invoice_country'] ) : '';
    $vat_id           = isset( $_POST['vat_id'] ) ? sanitize_text_field( $_POST['vat_id'] ) : '';

    // Vehicles list - mirror the front-end configuration so server-side price calculation matches
    $vehicles = array(
        "Sedan (1–3 Persons)"            => array( 'price' => 150, 'px' => 3,  'capacity' => '1–3',  'luggage' => '2 large + 2 small' ),
        "MPV (4 Persons)"                => array( 'price' => 200, 'px' => 4,  'capacity' => '4',    'luggage' => '3 large + 3 small' ),
        "Van (5–7 Persons)"              => array( 'price' => 250, 'px' => 5,  'capacity' => '5–7',  'luggage' => '6 large + 6 small' ),
        "Sedan + Van (7–10 Persons)"     => array( 'price' => 400, 'px' => 7,  'capacity' => '8–10', 'luggage' => '10 large + 10 small' ),
        "Two Vans / Sprinter (11–14)"    => array( 'price' => 500, 'px' => 11, 'capacity' => '11–14','luggage' => '14 large + 14 small' ),
    );

    // Helper to parse min capacity
    $get_min_capacity = function( $capacity ) {
        if ( false !== strpos( $capacity, '–' ) ) {
            $parts = explode( '–', $capacity );
            return intval( trim( $parts[0] ) );
        }
        return intval( trim( $capacity ) );
    };

    // Determine highlight vehicle based on pax (fallback logic if frontend didn't post a vehicle)
    $highlightVehicle = '';
    if ( $pax <= 3 ) {
        $highlightVehicle = "Sedan (1–3 Persons)";
    } elseif ( $pax === 4 ) {
        $highlightVehicle = "MPV (4 Persons)";
    } elseif ( $pax >= 5 && $pax <= 7 ) {
        $highlightVehicle = "Van (5–7 Persons)";
    } elseif ( $pax >= 8 && $pax <= 10 ) {
        $highlightVehicle = "Sedan + Van (7–10 Persons)";
    } elseif ( $pax >= 11 && $pax <= 14 ) {
        $highlightVehicle = "Two Vans / Sprinter (11–14)";
    }

    // Choose final vehicle: prefer POSTed vehicle, else highlight
    $vehicle = '';
    if ( ! empty( $vehicle_posted ) && isset( $vehicles[ $vehicle_posted ] ) ) {
        $vehicle = $vehicle_posted;
    } elseif ( ! empty( $highlightVehicle ) && isset( $vehicles[ $highlightVehicle ] ) ) {
        $vehicle = $highlightVehicle;
    } else {
        // Fallback to first vehicle defined
        $vehicle = array_keys( $vehicles )[0];
    }

    // Get discounted price for tour (server-side)
    $discounted_price = 0;
    if ( function_exists( 'get_discounted_price' ) ) {
        $discounted_price = floatval( get_discounted_price( $tour_id, false ) );
    } else {
        // fallback to posted tour_price
        $discounted_price = floatval( $tour_price );
    }

    // Determine px multiplier for chosen vehicle (fallback to 1)
    $px = isset( $vehicles[ $vehicle ] ) ? intval( $vehicles[ $vehicle ]['px'] ) : 1;

    // Final price calculation - px * discounted_price
    $final_price = $px * $discounted_price;

    // If you want to add extra fees (child seats etc.), adjust $final_price here.
    // Example: add fee per child seat if required:
    // $child_seat_fee_per = 5;
    // $final_price += count($child_seats) * $child_seat_fee_per;

    // Create WooCommerce order and add booking product
    if ( class_exists( 'WooCommerce' ) ) {
        try {
           

           
            // Now create WooCommerce order
            $order = wc_create_order();

            // If a user was found/created, assign order to them
            if ( $user_id ) {
                $order->set_customer_id( $customer_email );
            }

            // Retrieve product
            $product = wc_get_product( $booking_product_id );

            if ( ! $product ) {
                // invalid booking product id
                wp_safe_redirect( home_url( '/booking-error' ) );
                exit;
            }

            // Add product to order with custom price as subtotal/total
            // Use add_product (older helper) — if you're on a newer WC version you can use WC_Order_Item_Product directly.
            $item_id = $order->add_product( $product, 1, array(
                'subtotal' => $final_price,
                'total'    => $final_price,
            ) );

            // If add_product returned false/0, attempt adding item via WC_Order_Item_Product for compatibility
            if ( ! $item_id ) {
                $order_item = new WC_Order_Item_Product();
                $order_item->set_product( $product );
                $order_item->set_quantity( 1 );
                $order_item->set_subtotal( $final_price );
                $order_item->set_total( $final_price );
                $order->add_item( $order_item );
                $item_id = $order_item->get_id();
            }

            // Add booking details as item meta (visible in order items)
            if ( $item_id ) {
                // Use wc_add_order_item_meta for compatibility (works with older WP/WC)
                wc_add_order_item_meta( $item_id, 'Tour ID', $tour_id );
                wc_add_order_item_meta( $item_id, 'Tour Date', $tour_date );
                wc_add_order_item_meta( $item_id, 'Adults', $tour_adults );
                wc_add_order_item_meta( $item_id, 'Children', $tour_child );
                wc_add_order_item_meta( $item_id, 'Total Passengers', $pax );
                wc_add_order_item_meta( $item_id, 'Pickup Date & Time', $pickup_datetime );
                wc_add_order_item_meta( $item_id, 'Pickup Address', $pickup_address );
                wc_add_order_item_meta( $item_id, 'Drop-off Address', $dropoff_address );
                wc_add_order_item_meta( $item_id, 'Transport Info', $transport_info );
                wc_add_order_item_meta( $item_id, 'Driver Notes', $driver_notes );
                wc_add_order_item_meta( $item_id, 'Vehicle Type', $vehicle );
                wc_add_order_item_meta( $item_id, 'Base Price (per px)', wc_price( $discounted_price ) );
                wc_add_order_item_meta( $item_id, 'PX (vehicle multiplier)', $px );
                wc_add_order_item_meta( $item_id, 'Final Price', wc_price( $final_price ) );

                if ( ! empty( $child_seats ) ) {
                    wc_add_order_item_meta( $item_id, 'Child Seat Types', implode( ', ', $child_seats ) );
                }

                if ( $need_invoice ) {
                    wc_add_order_item_meta( $item_id, 'Invoice Required', 'Yes' );
                    wc_add_order_item_meta( $item_id, 'Company Name', $company_name );
                    wc_add_order_item_meta( $item_id, 'Invoice Street', $invoice_street );
                    wc_add_order_item_meta( $item_id, 'Invoice City', $invoice_city );
                    wc_add_order_item_meta( $item_id, 'Invoice ZIP', $invoice_zip );
                    wc_add_order_item_meta( $item_id, 'Invoice Country', $invoice_country );
                    if ( ! empty( $vat_id ) ) {
                        wc_add_order_item_meta( $item_id, 'VAT ID', $vat_id );
                    }
                }

                // Customer details
                wc_add_order_item_meta( $item_id, 'Passenger Name', $customer_name );
                wc_add_order_item_meta( $item_id, 'Passenger Email', $customer_email );
                wc_add_order_item_meta( $item_id, 'Passenger Phone', $customer_phone );
            }

            // Set addresses (billing & shipping)
            $address = array(
                'first_name' => $customer_name,
                'email'      => $customer_email,
                'phone'      => $customer_phone,
            );
            $order->set_address( $address, 'billing' );
            $order->set_address( $address, 'shipping' );

            // Set payment method if posted (optional)
            $payment_method = isset( $_POST['payment_method'] ) ? sanitize_text_field( $_POST['payment_method'] ) : '';
            if ( $payment_method ) {
                $order->set_payment_method( $payment_method );
            }

            // Add internal order note with booking summary
            $order_notes  = "Booking Details:\n";
            $order_notes .= "Tour: #{$tour_id}\n";
            $order_notes .= "Date: {$tour_date}\n";
            $order_notes .= "Passengers: {$tour_adults} adults, {$tour_child} children (Total: {$pax})\n";
            $order_notes .= "Pickup: {$pickup_datetime} at {$pickup_address}\n";
            if ( ! empty( $dropoff_address ) ) {
                $order_notes .= "Drop-off: {$dropoff_address}\n";
            }
            $order_notes .= "Vehicle: {$vehicle}\n";
            if ( ! empty( $driver_notes ) ) {
                $order_notes .= "Driver Notes: {$driver_notes}\n";
            }
            $order->add_order_note( $order_notes );

            // Save booking meta on order for easy queries
            $order->update_meta_data( '_booking_tour_id', $tour_id );
            $order->update_meta_data( '_booking_tour_date', $tour_date );
            $order->update_meta_data( '_booking_adults', $tour_adults );
            $order->update_meta_data( '_booking_children', $tour_child );
            $order->update_meta_data( '_booking_pax', $pax );
            $order->update_meta_data( '_booking_pickup_datetime', $pickup_datetime );
            $order->update_meta_data( '_booking_pickup_address', $pickup_address );
            $order->update_meta_data( '_booking_dropoff_address', $dropoff_address );
            $order->update_meta_data( '_booking_transport_info', $transport_info );
            $order->update_meta_data( '_booking_driver_notes', $driver_notes );
            $order->update_meta_data( '_booking_vehicle', $vehicle );
            if ( ! empty( $child_seats ) ) {
                $order->update_meta_data( '_booking_child_seats', $child_seats );
            }
            if ( $need_invoice ) {
                $order->update_meta_data( '_booking_invoice_required', 1 );
                $order->update_meta_data( '_booking_company_name', $company_name );
                $order->update_meta_data( '_booking_invoice_street', $invoice_street );
                $order->update_meta_data( '_booking_invoice_city', $invoice_city );
                $order->update_meta_data( '_booking_invoice_zip', $invoice_zip );
                $order->update_meta_data( '_booking_invoice_country', $invoice_country );
                if ( ! empty( $vat_id ) ) {
                    $order->update_meta_data( '_booking_vat_id', $vat_id );
                }
            }
            $order->update_meta_data( '_booking_final_price', $final_price );

            // Calculate totals and save
            $order->calculate_totals();
            $order->save();

            // Redirect customer to checkout payment URL
            $checkout_url =  home_url('/checkout/'); 
            if ( $checkout_url ) {
                wp_safe_redirect( $checkout_url );
                exit;
            } else {
                // If no checkout url, go to order received page
                wp_safe_redirect( $order->get_view_order_url() );
                exit;
            }
        } catch ( Exception $e ) {
            // Log exception or handle gracefully
            error_log( 'Booking processing error: ' . $e->getMessage() );
            wp_safe_redirect( home_url( '/booking-error' ) );
            exit;
        }
    }

    // If WooCommerce not available or something else failed
    wp_safe_redirect( home_url( '/booking-error' ) );
    exit;
}

/**
 * Simple helper in case you want to calculate final price with extras later.
 * Currently unused because final price is px * discounted_price above.
 */
function calculate_final_price( $base_px_price, $px_multiplier = 1, $extras = array() ) {
    $final = floatval( $base_px_price ) * intval( $px_multiplier );

    // example extras array could be [ 'child_seat' => 5, 'hours' => 100 ]
    foreach ( $extras as $k => $v ) {
        $final += floatval( $v );
    }
    return $final;
}


// Handle booking form submission
add_action('admin_post_process_booking', 'handle_booking_submission');
add_action('admin_post_nopriv_process_booking', 'handle_booking_submission');

function handle_booking_submission() {
    if (!isset($_POST['booking_nonce_field']) || !wp_verify_nonce($_POST['booking_nonce_field'], 'booking_nonce')) {
        wp_die('Security check failed.');
    }

     // Ensure WooCommerce session is ready
    if (function_exists('WC')) {
        if (null === WC()->session) {
            WC()->initialize_session();
        }
        if (null === WC()->cart) {
            wc_load_cart();
        }
    }


    
    $product_id     = 26324; // Your WooCommerce product ID

    // Sanitize inputs
    $tour_id          = intval( $_POST['tour_id'] );
    $pickup_address   = sanitize_text_field( $_POST['pickup_address'] ?? '' );
    $dropoff_address  = sanitize_text_field( $_POST['dropoff_address'] ?? '' );
    $pickup_datetime  = sanitize_text_field( $_POST['pickup_datetime'] ?? '' );
    $tour_adults      = intval( $_POST['tour_adults'] ?? 0 );
    $tour_child       = intval( $_POST['tour_child'] ?? 0 );
    $driver_notes     = sanitize_textarea_field( $_POST['driver_notes'] ?? '' );
    $passenger_name   = sanitize_text_field( $_POST['passenger_name'] ?? '' );
    $passenger_email  = sanitize_email( $_POST['passenger_email'] ?? '' );
    $passenger_mobile = sanitize_text_field( $_POST['passenger_mobile'] ?? '' );
    $vehicle_type     = sanitize_text_field( $_POST['vehicle_type'] ?? '' ); // 👈 From hidden input (next step)
    $final_price      = floatval( $_POST['final_price'] ?? 0 );

      // Group all booking data properly
    $booking_data = [
        'Tour ID'          => $tour_id,
        'Pickup DateTime'  => $pickup_datetime,
        'Pickup Address'   => $pickup_address,
        'Dropoff Address'  => $dropoff_address,
        'Adults'           => $tour_adults,
        'Children'         => $tour_child,
        'Passenger Name'   => $passenger_name,
        'Passenger Email'  => $passenger_email,
        'Passenger Mobile' => $passenger_mobile,
        'Driver Notes'     => $driver_notes,
        'Vehicle Type'     => $vehicle_type,
        'Total Price'      => $final_price,
    ];
    // Add to WooCommerce cart
    WC()->cart->empty_cart(); // optional – if you want only 1 booking at a time
    WC()->cart->add_to_cart(
        $product_id,
        1,
        0,
        [],
        ['booking_data' => $booking_data] // 👈 correctly nested
    );

    // Redirect to checkout
    wp_safe_redirect(wc_get_checkout_url());
    exit;
}


// Display custom booking meta in cart & checkout
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (isset($cart_item['booking_data'])) {
        foreach ($cart_item['booking_data'] as $key => $value) {
            $item_data[] = [
                'key'   => $key,
                'value' => $value,
            ];
        }
    }
    return $item_data;
}, 10, 2);

// Save meta to order item
add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    if (isset($values['booking_data'])) {
        foreach ($values['booking_data'] as $key => $value) {
            $item->add_meta_data($key, $value);
        }
    }
}, 10, 4);


add_action('woocommerce_before_calculate_totals', function ($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['booking_data']['Total Price'])) {
            $price = floatval($cart_item['booking_data']['Total Price']);
            $cart_item['data']->set_price($price);
        }
    }
});

















function enqueue_tour_filter_scripts() {
    // Enqueue jQuery (already included in WordPress)
    wp_enqueue_script('jquery');

    // Enqueue custom script
    wp_enqueue_script('tour-filter', get_template_directory_uri() . '/assets/js/tour-filter.js', array('jquery'), '1.0', true);

    // Localize script to pass AJAX URL and nonce
    wp_localize_script('tour-filter', 'tourFilter', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tour_filter_nonce'),
    ));
}
//add_action('wp_enqueue_scripts', 'enqueue_tour_filter_scripts');


function filter_tours_callback() {
    // Verify nonce
    check_ajax_referer('tour_filter_nonce', 'nonce');

    // Get selected term(s)
    $termIds = isset($_POST['termId']) 
        ? array_map('intval', (array) $_POST['termId']) 
        : [];

    // Build tax query
    $tax_query = [];

    if (!empty($termIds)) {
        $tax_query[] = [
            'taxonomy' => 'toour-properties',
            'field'    => 'id',   // since we're passing term_id
            'terms'    => $termIds,
        ];
    }

    // WP_Query arguments
    $args = [
        'post_type'      => 'tours',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $tours_query = new WP_Query($args);

    // Start output buffering to capture HTML
    ob_start();

    if ($tours_query->have_posts()) {
        while ($tours_query->have_posts()) {
            $tours_query->the_post();
            echo '<div class="col-12 col-lg-3">';
            get_template_part('partials/tour', 'box');
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>No tours found.</p>';
    }

    $html = ob_get_clean();

    // Return JSON response
    wp_send_json_success(['html' => $html]);
}


//add_action('wp_ajax_filter_tours', 'filter_tours_callback');
//add_action('wp_ajax_nopriv_filter_tours', 'filter_tours_callback');


// Hide specific product details from checkout page
function custom_hide_checkout_product_details( $item_name, $item ) {
    // Check if we're on checkout page
    if ( is_checkout() && ! is_wc_endpoint_url() ) {
        // Return empty string to hide product details
        return '';
    }
    return $item_name;
}
add_filter( 'woocommerce_order_item_name', 'custom_hide_checkout_product_details', 10, 2 );

// Or hide entire product column
function custom_hide_product_column_checkout( $columns ) {
    if ( is_checkout() ) {
        unset( $columns['product'] );
    }
    return $columns;
}
add_filter( 'woocommerce_checkout_cart_item_visible', '__return_false' );
add_filter( 'woocommerce_checkout_cart_item_quantity', '__return_false' );








// Hide specific checkout fields
add_filter( 'woocommerce_checkout_fields' , 'hide_checkout_fields' );

function hide_checkout_fields( $fields ) {
    // Hide billing company field
    unset($fields['billing']['billing_company']);
    
    // Hide shipping company field
    unset($fields['shipping']['shipping_company']);
    
    // You can hide other fields as needed:
     unset($fields['billing']['billing_address_2']);
     unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
     unset($fields['billing']['billing_state']);
      unset($fields['billing']['billing_city']);

    
    
    
    
    return $fields;
}

