<?php 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 140, 140, true );
	add_image_size( 'single-post-thumbnail', 300, 9999 );
    add_image_size( 'category_thumbnail', 250, 250, true );
    add_image_size('tour_slide', 1350, 500, true); // true = hard crop

    add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
    function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    
    include_once('inc/class-walker-nav.php');
    include_once('inc/extra.php');
	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
		// Declare sidebar widget zone
	if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h4>',
    		'after_title'   => '</h4>'
    	));
    }

function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}

if (function_exists('register_nav_menus')) {
register_nav_menus( array(
		'main' => __( 'Main Menu', '' ),
		'footer' => __( 'Footer Menu', '' ),
      
	) );
}


function fallbackmenu1(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function fallbackmenu2(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'sub';
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 $buttons[] = 'lineheight';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");

function add_first_and_last($items) {
    $items[1]->classes[] = 'first-menu-item';
    $items[count($items)]->classes[] = 'last-menu-item';
    return $items;
}
 
add_filter('wp_nav_menu_objects', 'add_first_and_last');

function enqueue_ajax_contact_form_script() {
    wp_enqueue_script('ajax-contact', get_stylesheet_directory_uri() . '/assets/js/ajax.js', array('jquery'), null, true);
    wp_localize_script('ajax-contact', 'ajaxContact', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ajax-contact-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_contact_form_script');

// Modify WooCommerce wrappers if needed
function mytheme_woocommerce_custom_wrappers() {
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
}
add_action('wp', 'mytheme_woocommerce_custom_wrappers');




function caterer_filter_scripts() {
    wp_enqueue_script(
        'caterer-filter',
        get_template_directory_uri() . '/assets/js/caterer-filter.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('caterer-filter', 'caterer_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('caterer_filter_nonce'),
        'location' => get_query_var('location') ?: (!empty($_COOKIE['selected_location']) ? sanitize_text_field($_COOKIE['selected_location']) : ''),
    ]);
}
add_action('wp_enqueue_scripts', 'caterer_filter_scripts');



function filter_caterers_by_type_ajax() {
    check_ajax_referer('caterer_filter_nonce', 'nonce');

    $term_id  = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
    $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';

    $args = [
        'post_type'      => 'caterer',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    if (!empty($location)) {
        $args['location'] = $location;
    }

    if (!empty($term_id)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'caterer_types',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ]
        ];
    }

    $stores = get_posts($args);

    if ($stores) {
        foreach ($stores as $store) {
            ?>
            <div class="store-item mb-5 pb-4 border-bottom">
                <div class="row align-items-center mb-4">
                    <div class="col-md-2 col-sm-3">
                        <?php
                        if (has_post_thumbnail($store->ID)) {
                            echo get_the_post_thumbnail($store->ID, 'medium', ['class' => 'img-fluid rounded']);
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-store.jpg') . '" class="img-fluid rounded" alt="Default store">';
                        }
                        ?>
                    </div>

                    <div class="col-md-10 col-sm-9">
                        <div class="store-header">
                            <div class="store-meta small text-muted mb-1">
                                <?php echo esc_html($location); ?>
                            </div>
                            <h3 class="store-title mb-1">
                                <a href="<?php echo esc_url(get_permalink($store->ID)); ?>" class="text-dark fw-semibold text-decoration-none">
                                    <?php echo esc_html($store->post_title); ?>
                                </a>
                            </h3>
                            <p class="store-description text-muted">
                                <?php echo esc_html(wp_trim_words($store->post_content, 25, '...')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="fooder-menu-section">
                    <div class="brand-title mb-3">
                        <h4>Popular Items</h4>
                    </div>

                    <div class="fooder-menu-wrapper">
                        <div class="row">
                            <?php
                            $all_products = get_posts([
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
]);

$products = [];

if ($all_products) {
    foreach ($all_products as $product) {
        $assigned_store_ids = get_product_assigned_caterer_ids($product->ID);

        if (in_array((int) $store->ID, $assigned_store_ids, true)) {
            $products[] = $product;
        }
    }
}

if ($products) {
    foreach ($products as $product) {
                                    $price   = get_post_meta($product->ID, '_price', true);
                                    $excerpt = wp_trim_words(get_the_excerpt($product->ID), 15);
                                    ?>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <div class="food-menu-items d-flex align-items-center justify-content-between border rounded p-3 shadow-sm bg-white">
                                            <div class="food-menu-content">
                                                <h5 class="mb-1">
                                                    <a href="<?php echo esc_url(get_permalink($product->ID)); ?>" class="text-dark text-decoration-none">
                                                        <?php echo esc_html($product->post_title); ?>
                                                    </a>
                                                </h5>
                                                <div class="store_name">
                                                    <?php echo get_product_store_name($product->ID); ?>
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    <?php echo esc_html($excerpt ?: 'No description available.'); ?>
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <?php if ($price): ?>
                                                    <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
                                                <?php endif; ?>
                                                <a href="#" class="product-popup plusicon" data-productid="<?php echo esc_attr($product->ID); ?>">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-12"><p class="text-muted"><em>No products found for this caterer.</em></p></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p class="text-center text-muted">No caterers found.</p>';
    }

    wp_die();
}
add_action('wp_ajax_filter_caterers_by_type', 'filter_caterers_by_type_ajax');
add_action('wp_ajax_nopriv_filter_caterers_by_type', 'filter_caterers_by_type_ajax');


function get_product_assigned_caterer_ids($product_id) {
    $meta_values = get_post_meta($product_id, '_assigned_store', false);
    $store_ids   = [];

    if (empty($meta_values)) {
        return [];
    }

    foreach ($meta_values as $value) {
        $value = maybe_unserialize($value);

        if (is_array($value)) {
            foreach ($value as $id) {
                $store_ids[] = (int) $id;
            }
        } else {
            $store_ids[] = (int) $value;
        }
    }

    $store_ids = array_filter($store_ids);
    $store_ids = array_unique($store_ids);

    return $store_ids;
}

function filter_caterers_by_product_cat_ajax() {
    check_ajax_referer('caterer_filter_nonce', 'nonce');

    $term_id  = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
    $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';

    if (empty($term_id)) {
        $store_args = [
            'post_type'      => 'caterer',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        if (!empty($location)) {
            $store_args['location'] = $location;
        }

        $stores = get_posts($store_args);
    } else {
        // Get products in selected category
        $product_ids = get_posts([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'tax_query'      => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ]
            ]
        ]);

        $store_ids = [];

        // Collect ALL assigned caterers from each product
        if (!empty($product_ids)) {
            foreach ($product_ids as $product_id) {
                $assigned_store_ids = get_product_assigned_caterer_ids($product_id);

                if (!empty($assigned_store_ids)) {
                    $store_ids = array_merge($store_ids, $assigned_store_ids);
                }
            }
        }

        $store_ids = array_unique(array_filter(array_map('intval', $store_ids)));

        if (!empty($store_ids)) {
            $store_args = [
                'post_type'      => 'caterer',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'post__in'       => $store_ids,
                'orderby'        => 'post__in',
            ];

            if (!empty($location)) {
                $store_args['location'] = $location;
            }

            $stores = get_posts($store_args);
        } else {
            $stores = [];
        }
    }

    if ($stores) {
        foreach ($stores as $store) {
            ?>
            <div class="store-item mb-5 pb-4 border-bottom">
                <div class="row align-items-center mb-4">
                    <div class="col-md-2 col-sm-3">
                        <?php
                        if (has_post_thumbnail($store->ID)) {
                            echo get_the_post_thumbnail($store->ID, 'medium', ['class' => 'img-fluid rounded']);
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-store.jpg') . '" class="img-fluid rounded" alt="Default store">';
                        }
                        ?>
                    </div>

                    <div class="col-md-10 col-sm-9">
                        <div class="store-header">
                            <div class="store-meta small text-muted mb-1">
                                <?php echo esc_html($location); ?>
                            </div>
                            <h3 class="store-title mb-1">
                                <a href="<?php echo esc_url(get_permalink($store->ID)); ?>" class="text-dark fw-semibold text-decoration-none">
                                    <?php echo esc_html($store->post_title); ?>
                                </a>
                            </h3>
                            <p class="store-description text-muted">
                                <?php echo esc_html(wp_trim_words($store->post_content, 25, '...')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="fooder-menu-section">
                    <div class="brand-title mb-3">
                        <h4>Popular Items</h4>
                    </div>

                    <div class="fooder-menu-wrapper">
                        <div class="row">
                            <?php
                            // Get category products first
                            $store_products = get_posts([
                                'post_type'      => 'product',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                                'tax_query'      => [
                                    [
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'term_id',
                                        'terms'    => $term_id,
                                    ]
                                ]
                            ]);

                            $matched_products = [];

                            if ($store_products) {
                                foreach ($store_products as $product) {
                                    $assigned_store_ids = get_product_assigned_caterer_ids($product->ID);

                                    if (in_array((int) $store->ID, $assigned_store_ids, true)) {
                                        $matched_products[] = $product;
                                    }
                                }
                            }

                            if ($matched_products) {
                                foreach ($matched_products as $product) {
                                    $price   = get_post_meta($product->ID, '_price', true);
                                    $excerpt = wp_trim_words(get_the_excerpt($product->ID), 15);
                                    ?>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <div class="food-menu-items d-flex align-items-center justify-content-between border rounded p-3 shadow-sm bg-white">
                                            <div class="food-menu-content">
                                                <h5 class="mb-1">
                                                    <a href="<?php echo esc_url(get_permalink($product->ID)); ?>" class="text-dark text-decoration-none">
                                                        <?php echo esc_html($product->post_title); ?>
                                                    </a>
                                                </h5>
                                                <div class="store_name">
                                                    <?php echo get_product_store_name($product->ID); ?>
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    <?php echo esc_html($excerpt ?: 'No description available.'); ?>
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <?php if ($price): ?>
                                                    <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
                                                <?php endif; ?>
                                                <a href="#" class="product-popup plusicon" data-productid="<?php echo esc_attr($product->ID); ?>">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-12"><p class="text-muted"><em>No products found for this caterer.</em></p></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p class="text-center text-muted">No caterers found for this product category.</p>';
    }

    wp_die();
}
add_action('wp_ajax_filter_caterers_by_product_cat', 'filter_caterers_by_product_cat_ajax');
add_action('wp_ajax_nopriv_filter_caterers_by_product_cat', 'filter_caterers_by_product_cat_ajax');


function filter_caterers_by_product_tag_ajax() {
    check_ajax_referer('caterer_filter_nonce', 'nonce');

    $term_id  = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
    $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';

    if (empty($term_id)) {
        $store_args = [
            'post_type'      => 'caterer',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        if (!empty($location)) {
            $store_args['location'] = $location;
        }

        $stores = get_posts($store_args);
    } else {
        // Get products in selected product tag
        $product_ids = get_posts([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'tax_query'      => [
                [
                    'taxonomy' => 'product_tag',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ]
            ]
        ]);

        $store_ids = [];

        if (!empty($product_ids)) {
            foreach ($product_ids as $product_id) {
                $assigned_store_ids = get_product_assigned_caterer_ids($product_id);

                if (!empty($assigned_store_ids)) {
                    $store_ids = array_merge($store_ids, $assigned_store_ids);
                }
            }
        }

        $store_ids = array_unique(array_filter(array_map('intval', $store_ids)));

        if (!empty($store_ids)) {
            $store_args = [
                'post_type'      => 'caterer',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'post__in'       => $store_ids,
                'orderby'        => 'post__in',
            ];

            if (!empty($location)) {
                $store_args['location'] = $location;
            }

            $stores = get_posts($store_args);
        } else {
            $stores = [];
        }
    }

    if ($stores) {
        foreach ($stores as $store) {
            ?>
            <div class="store-item mb-5 pb-4 border-bottom">
                <div class="row align-items-center mb-4">
                    <div class="col-md-2 col-sm-3">
                        <?php
                        if (has_post_thumbnail($store->ID)) {
                            echo get_the_post_thumbnail($store->ID, 'medium', ['class' => 'img-fluid rounded']);
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-store.jpg') . '" class="img-fluid rounded" alt="Default store">';
                        }
                        ?>
                    </div>

                    <div class="col-md-10 col-sm-9">
                        <div class="store-header">
                            <div class="store-meta small text-muted mb-1">
                                <?php echo esc_html($location); ?>
                            </div>
                            <h3 class="store-title mb-1">
                                <a href="<?php echo esc_url(get_permalink($store->ID)); ?>" class="text-dark fw-semibold text-decoration-none">
                                    <?php echo esc_html($store->post_title); ?>
                                </a>
                            </h3>
                            <p class="store-description text-muted">
                                <?php echo esc_html(wp_trim_words($store->post_content, 25, '...')); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="fooder-menu-section">
                    <div class="brand-title mb-3">
                        <h4>Popular Items</h4>
                    </div>

                    <div class="fooder-menu-wrapper">
                        <div class="row">
                            <?php
                            $product_args = [
                                'post_type'      => 'product',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                            ];

                            if (!empty($term_id)) {
                                $product_args['tax_query'] = [
                                    [
                                        'taxonomy' => 'product_tag',
                                        'field'    => 'term_id',
                                        'terms'    => $term_id,
                                    ]
                                ];
                            }

                            $store_products = get_posts($product_args);
                            $matched_products = [];

                            if ($store_products) {
                                foreach ($store_products as $product) {
                                    $assigned_store_ids = get_product_assigned_caterer_ids($product->ID);

                                    if (in_array((int) $store->ID, $assigned_store_ids, true)) {
                                        $matched_products[] = $product;
                                    }
                                }
                            }

                            if ($matched_products) {
                                foreach ($matched_products as $product) {
                                    $price   = get_post_meta($product->ID, '_price', true);
                                    $excerpt = wp_trim_words(get_the_excerpt($product->ID), 15);
                                    ?>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <div class="food-menu-items d-flex align-items-center justify-content-between border rounded p-3 shadow-sm bg-white">
                                            <div class="food-menu-content">
                                                <h5 class="mb-1">
                                                    <a href="<?php echo esc_url(get_permalink($product->ID)); ?>" class="text-dark text-decoration-none">
                                                        <?php echo esc_html($product->post_title); ?>
                                                    </a>
                                                </h5>
                                                <div class="store_name">
                                                    <?php echo get_product_store_name($product->ID); ?>
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    <?php echo esc_html($excerpt ?: 'No description available.'); ?>
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <?php if ($price): ?>
                                                    <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
                                                <?php endif; ?>
                                                <a href="#" class="product-popup plusicon" data-productid="<?php echo esc_attr($product->ID); ?>">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-12"><p class="text-muted"><em>No products found for this caterer.</em></p></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p class="text-center text-muted">No caterers found for this product tag.</p>';
    }

    wp_die();
}
add_action('wp_ajax_filter_caterers_by_product_tag', 'filter_caterers_by_product_tag_ajax');
add_action('wp_ajax_nopriv_filter_caterers_by_product_tag', 'filter_caterers_by_product_tag_ajax');