<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');

// Get current page number for pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// ============================
// 🔍 Build Query Args based on current page
// ============================
if (is_product_category()) {
    $current_cat = get_queried_object();
    $bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
} else {
    $bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
}

// Start with default WooCommerce query args
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'meta_query'     => array(
        array(
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '='
        )
    )
);

// Handle category context
if (is_product_category()) {
    // We're on a category page - use the current category
    $current_cat = get_queried_object();
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'id',
            'terms'    => $current_cat->term_id,
        )
    );
} elseif (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
    // We're on shop page with category filter
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['product_cat'])
        )
    );
}

// Price filter
if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $args['meta_query'][] = array(
        'key'     => '_price',
        'value'   => [floatval($_GET['min_price']), floatval($_GET['max_price'])],
        'type'    => 'DECIMAL',
        'compare' => 'BETWEEN'
    );
}

// Orderby filter
if (isset($_GET['orderby'])) {
    switch ($_GET['orderby']) {
        case 'price':
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order']    = 'ASC';
            break;
        case 'price-desc':
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order']    = 'DESC';
            break;
        case 'date':
            $args['orderby']  = 'date';
            $args['order']    = 'DESC';
            break;
        case 'rating':
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = '_wc_average_rating';
            $args['order']    = 'DESC';
            break;
        case 'popularity':
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'total_sales';
            $args['order']    = 'DESC';
            break;
        default:
            $args['orderby']  = 'menu_order title';
            $args['order']    = 'ASC';
    }
} else {
    // Default WooCommerce ordering
    $ordering = WC()->query->get_catalog_ordering_args();
    $args['orderby'] = $ordering['orderby'];
    $args['order']   = $ordering['order'];
    if ($ordering['meta_key']) {
        $args['meta_key'] = $ordering['meta_key'];
    }
}

$shop_query = new WP_Query($args);

// Breadcrumb (optional)
get_template_part('partials/content', 'breadcrumb', ['bg' => $bg_image]);
?>

<!-- Food Category Section Start -->
<section class="food-category-section fix section-padding section-bg">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 order-2 order-md-1 mt-5">
                <div class="main-sidebar">
                    
                    <!-- WooCommerce Categories -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="widget-categories">
                            <?php
                            $categories = get_terms([
                                'taxonomy'   => 'product_cat',
                                'hide_empty' => true,
                                'orderby'    => 'name',
                                'order'      => 'ASC'
                            ]);
                            
                            if ($categories && !is_wp_error($categories)) {
                                echo '<ul>';
                                foreach ($categories as $category) {
                                    $icon_class = 'flaticon-burger'; // Default icon
                                    switch (strtolower($category->name)) {
                                        case 'burger': $icon_class = 'flaticon-burger'; break;
                                        case 'chicken': $icon_class = 'flaticon-chicken'; break;
                                        case 'pizza': $icon_class = 'flaticon-pizza'; break;
                                        case 'fries': $icon_class = 'flaticon-french-fries'; break;
                                        case 'sandwich': $icon_class = 'flaticon-sandwich'; break;
                                        case 'bread': $icon_class = 'flaticon-bread'; break;
                                        case 'rice': $icon_class = 'flaticon-rice'; break;
                                        case 'hotdog': $icon_class = 'flaticon-hotdog'; break;
                                    }
                                    
                                    $active_class = '';
                                    if (is_product_category($category->term_id)) {
                                        $active_class = 'active';
                                    } elseif (isset($_GET['product_cat']) && $_GET['product_cat'] == $category->slug) {
                                        $active_class = 'active';
                                    }
                                    
                                    $category_url = get_term_link($category);
                                    
                                    // If we're on shop page, add category as filter parameter
                                    if (!is_product_category()) {
                                        $category_url = add_query_arg('product_cat', $category->slug, get_permalink(wc_get_page_id('shop')));
                                    }
                                    
                                    echo '<li class="' . $active_class . '"><a href="' . esc_url($category_url) . '"><i class="' . esc_attr($icon_class) . '"></i> ' . esc_html($category->name) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title"><h4>Price Filter</h4></div>
                        <div class="range__barcustom">
                            <?php
                            $current_url = is_product_category() ? get_term_link(get_queried_object()) : get_permalink(wc_get_page_id('shop'));
                            ?>
                            <form method="GET" action="<?php echo esc_url($current_url); ?>">
                                <div class="range-items">
                                    <div class="price-input d-flex">
                                        <div class="field"><span>Price:</span></div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" name="min_price" value="<?php echo esc_attr($_GET['min_price'] ?? '0'); ?>">
                                        </div>
                                        <div class="separators">-</div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" name="max_price" value="<?php echo esc_attr($_GET['max_price'] ?? '1000'); ?>">
                                        </div>
                                        <button type="submit" class="theme-btn border-radius-none">Filter</button>

                                        <?php 
                                        // Preserve other parameters
                                        foreach (['product_cat', 'orderby'] as $param) {
                                            if (isset($_GET[$param])) {
                                                echo '<input type="hidden" name="' . esc_attr($param) . '" value="' . esc_attr($_GET[$param]) . '">';
                                            }
                                        }
                                        
                                        // If on category page, preserve category in filter
                                        if (is_product_category()) {
                                            $current_cat = get_queried_object();
                                            echo '<input type="hidden" name="product_cat" value="' . esc_attr($current_cat->slug) . '">';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- New Arrivals -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title"><h4>New Arrivals</h4></div>
                        <div class="popular-food-posts">
                            <?php
                            $new_arrivals_args = [
                                'post_type'      => 'product',
                                'posts_per_page' => 4,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                                'meta_query'     => [
                                    [
                                        'key'     => '_stock_status',
                                        'value'   => 'instock',
                                        'compare' => '='
                                    ]
                                ]
                            ];
                            
                            // If on category page, show new arrivals from current category
                            if (is_product_category()) {
                                $current_cat = get_queried_object();
                                $new_arrivals_args['tax_query'] = [
                                    [
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'id',
                                        'terms'    => $current_cat->term_id,
                                    ]
                                ];
                            }
                            
                            $new_arrivals = new WP_Query($new_arrivals_args);

                            if ($new_arrivals->have_posts()) :
                                while ($new_arrivals->have_posts()) : $new_arrivals->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    ?>
                                    <div class="single-post-item">
                                        <div class="thumb bg-cover" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>');"></div>
                                        <div class="post-content">
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <div class="post-price">
                                                <?php echo $product->get_price_html(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xl-9 col-lg-8 order-1 order-md-2">
                <div class="woocommerce-notices-wrapper mb-0">
                    <div class="product-showing">
                        <?php if (is_product_category()) : ?>
                            <?php 
                            $current_cat = get_queried_object();
                            $category_title = $current_cat->name;
                            ?>
                            <h5>Category: <span><?php echo esc_html($category_title); ?></span> - Showing <span><?php echo intval($shop_query->post_count); ?> product<?php echo ($shop_query->post_count != 1) ? 's' : ''; ?></span></h5>
                        <?php else : ?>
                            <h5>Showing <span><?php echo intval($shop_query->post_count); ?> product<?php echo ($shop_query->post_count != 1) ? 's' : ''; ?></span></h5>
                        <?php endif; ?>
                    </div>
                    <div class="form-clt">
                        <h6>Sort by: <a href="#"><i class="fal fa-sort-alt"></i></a></h6>
                        <form method="GET" action="<?php echo esc_url(is_product_category() ? get_term_link(get_queried_object()) : get_permalink(wc_get_page_id('shop'))); ?>" class="sort-form">
                            <select name="orderby" class="nice-select" onchange="this.form.submit()">
                                <option value="menu_order" <?php selected($_GET['orderby'] ?? '', 'menu_order'); ?>>Default</option>
                                <option value="popularity" <?php selected($_GET['orderby'] ?? '', 'popularity'); ?>>Popularity</option>
                                <option value="rating" <?php selected($_GET['orderby'] ?? '', 'rating'); ?>>Average Rating</option>
                                <option value="date" <?php selected($_GET['orderby'] ?? '', 'date'); ?>>Newest</option>
                                <option value="price" <?php selected($_GET['orderby'] ?? '', 'price'); ?>>Price: Low to High</option>
                                <option value="price-desc" <?php selected($_GET['orderby'] ?? '', 'price-desc'); ?>>Price: High to Low</option>
                            </select>
                            <?php
                            // preserve filters
                            foreach (['min_price', 'max_price', 'product_cat'] as $param) {
                                if (isset($_GET[$param])) {
                                    echo '<input type="hidden" name="' . esc_attr($param) . '" value="' . esc_attr($_GET[$param]) . '">';
                                }
                            }
                            
                            // If on category page, preserve category
                            if (is_product_category()) {
                                $current_cat = get_queried_object();
                                echo '<input type="hidden" name="product_cat" value="' . esc_attr($current_cat->slug) . '">';
                            }
                            ?>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if ($shop_query->have_posts()) :
                        while ($shop_query->have_posts()) : $shop_query->the_post();
                            $product = wc_get_product(get_the_ID());
                            ?>
                            <div class="col-xl-12 col-lg-12">
                                <div class="shop-list-items">
                                    <div class="shop-image">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title(); ?>">
                                        <?php if ($product->is_on_sale()): ?>
                                            <span class="onsale">Sale!</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="shop-content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                        <h5><?php echo $product->get_price_html(); ?></h5>
                                        <div class="shop-list-btn">
                                            <?php 
                                            // Use WooCommerce add to cart button
                                            echo apply_filters('woocommerce_loop_add_to_cart_link',
                                                sprintf('<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                    esc_url($product->add_to_cart_url()),
                                                    esc_attr(1),
                                                    esc_attr('theme-btn border-radius-none' . ($product->is_purchasable() && $product->is_in_stock() ? ' add_to_cart_button' : '')),
                                                    $product->is_purchasable() && $product->is_in_stock() ? 'data-product_id="' . esc_attr($product->get_id()) . '"' : '',
                                                    esc_html($product->add_to_cart_text())
                                                ),
                                            $product);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    else :
                        echo '<div class="col-12"><p>No products found.</p></div>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- Pagination -->
                <div class="page-nav-wrap mt-5 text-center">
                    <?php
                    echo paginate_links([
                        'total'   => $shop_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => '<i class="fal fa-long-arrow-left"></i>',
                        'next_text' => '<i class="fal fa-long-arrow-right"></i>',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer('shop');