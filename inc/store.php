<?php
// Add this to your theme's functions.php or create a custom plugin

// Create custom post type for Stores
function create_store_post_type() {
    register_post_type('store',
        array(
            'labels' => array(
                'name' => __('Caterers'),
                'singular_name' => __('Caterer')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-store',
        )
    );
}
add_action('init', 'create_store_post_type');

// Add store relationship to products
function add_store_to_products() {
    register_taxonomy(
        'store_relationship',
        'product',
        array(
            'label' => __('Caterer'),
            'rewrite' => array('slug' => 'caterer'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'add_store_to_products');


// Create Store Manager role
function add_store_manager_role() {
    add_role('store_manager', 'Caterer Manager', array(
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        'upload_files' => true,
    ));
}
add_action('init', 'add_store_manager_role');

// Custom capabilities for store managers
function add_store_manager_capabilities() {
    $role = get_role('store_manager');
    $role->add_cap('edit_products');
    $role->add_cap('read_products');
    $role->add_cap('delete_products');
    $role->add_cap('edit_product');
    $role->add_cap('publish_products');
    $role->add_cap('upload_files');
}
add_action('admin_init', 'add_store_manager_capabilities');


// Add meta box for product-store relationship
function add_store_meta_box() {
    add_meta_box(
        'store_assignment',
        'Store Assignment',
        'store_assignment_meta_box_callback',
        'product',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_store_meta_box');

function store_assignment_meta_box_callback($post) {
    wp_nonce_field('store_assignment_nonce', 'store_assignment_nonce');
    
    $stores = get_posts(array(
        'post_type' => 'store',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    
    $assigned_store = get_post_meta($post->ID, '_assigned_store', true);
    
    echo '<select name="assigned_store" id="assigned_store">';
    echo '<option value="">Select Store</option>';
    foreach ($stores as $store) {
        $selected = ($assigned_store == $store->ID) ? 'selected' : '';
        echo '<option value="' . $store->ID . '" ' . $selected . '>' . $store->post_title . '</option>';
    }
    echo '</select>';
}

function save_store_assignment($post_id) {
    if (!isset($_POST['store_assignment_nonce']) || 
        !wp_verify_nonce($_POST['store_assignment_nonce'], 'store_assignment_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    if (isset($_POST['assigned_store'])) {
        update_post_meta($post_id, '_assigned_store', sanitize_text_field($_POST['assigned_store']));
    }
}
add_action('save_post', 'save_store_assignment');


// Create custom admin page for store managers
function store_manager_admin_menu() {
    add_menu_page(
        'Store Management',
        'My Store',
        'store_manager',
        'store-management',
        'store_management_page',
        'dashicons-store',
        30
    );
}
add_action('admin_menu', 'store_manager_admin_menu');

function store_management_page() {
    $user_id = get_current_user_id();
    $managed_store = get_user_meta($user_id, '_managed_store', true);
    
    if ($managed_store) {
        $store = get_post($managed_store);
        echo '<div class="wrap">';
        echo '<h1>Manage: ' . $store->post_title . '</h1>';
        
        // Show store products
        $products = get_posts(array(
            'post_type' => 'product',
            'meta_key' => '_assigned_store',
            'meta_value' => $managed_store,
            'numberposts' => -1
        ));
        
        echo '<h2>Store Products</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Product</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($products as $product) {
            $price = get_post_meta($product->ID, '_price', true);
            echo '<tr>';
            echo '<td>' . $product->post_title . '</td>';
            echo '<td>' . wc_price($price) . '</td>';
            echo '<td>' . $product->post_status . '</td>';
            echo '<td><a href="' . get_edit_post_link($product->ID) . '">Edit</a></td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        echo '</div>';
    }
}


// Remove "Brands" column and add "Store" column in WooCommerce products list
add_filter('manage_edit-product_columns', function($columns) {
    // Remove Brands column
    if (isset($columns['pa_brands'])) {
        unset($columns['pa_brands']);
    }

    // Add Store column after Categories
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'product_cat') {
            $new_columns['store'] = __('Store', 'your-textdomain');
        }
    }

    return $new_columns;
}, 20);

// Fill Store column data
add_action('manage_product_posts_custom_column', function($column, $post_id) {
    if ($column === 'store') {
        // Pull correct meta key (_assigned_store)
        $store_id = get_post_meta($post_id, '_assigned_store', true);
        if ($store_id) {
            echo '<a href="' . esc_url(get_edit_post_link($store_id)) . '">' . esc_html(get_the_title($store_id)) . '</a>';
        } else {
            echo '<em>No store assigned</em>';
        }
    }
}, 10, 2);


// Make Store column sortable
add_filter('manage_edit-product_sortable_columns', function($columns) {
    $columns['store'] = 'store';
    return $columns;
});
