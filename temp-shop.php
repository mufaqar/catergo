<?php
/* Template Name: Menus */
get_header();

// Get current page number for pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// ============================
// 🔍 Build Query Args
// ============================
$args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'meta_query'     => [
        [
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '='
        ]
    ]
];

// Price filter
if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $args['meta_query'][] = [
        'key'     => '_price',
        'value'   => [floatval($_GET['min_price']), floatval($_GET['max_price'])],
        'type'    => 'DECIMAL',
        'compare' => 'BETWEEN'
    ];
}

// Category filter
if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
    $args['tax_query'][] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => sanitize_text_field($_GET['product_cat'])
    ];
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
        default:
            $args['orderby']  = 'menu_order title';
            $args['order']    = 'ASC';
    }
}

$shop_query = new WP_Query($args);
$bg_image = get_template_directory_uri() . '/assets/images/banner.webp';

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
                                    echo '<li><a href="' . esc_url(get_term_link($category)) . '"><i class="' . esc_attr($icon_class) . '"></i> ' . esc_html($category->name) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Price Filter</h4>
                        </div>
                        <div class="range__barcustom">
                            <form method="GET" action="<?php echo esc_url(get_permalink()); ?>">
                                <div class="range-items">
                                    <div class="price-input d-flex">
                                        <div class="field"><span>Price:</span></div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" name="min_price"
                                                value="<?php echo esc_attr($_GET['min_price'] ?? '0'); ?>">
                                        </div>
                                        <div class="separators">-</div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" name="max_price"
                                                value="<?php echo esc_attr($_GET['max_price'] ?? '1000'); ?>">
                                        </div>
                                        <button type="submit" class="theme-btn border-radius-none">Filter</button>

                                        <?php if (isset($_GET['product_cat'])): ?>
                                        <input type="hidden" name="product_cat"
                                            value="<?php echo esc_attr($_GET['product_cat']); ?>">
                                        <?php endif; ?>
                                        <?php if (isset($_GET['orderby'])): ?>
                                        <input type="hidden" name="orderby"
                                            value="<?php echo esc_attr($_GET['orderby']); ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- New Arrivals -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>New Arrivals</h4>
                        </div>
                        <div class="popular-food-posts">
                            <?php
                            $new_arrivals = new WP_Query([
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
                            ]);

                            if ($new_arrivals->have_posts()) :
                                while ($new_arrivals->have_posts()) : $new_arrivals->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    ?>
                            <div class="single-post-item">
                                <div class="thumb bg-cover"
                                    style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>');">
                                </div>
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
                        <h5>Showing <span><?php echo intval($shop_query->post_count); ?>
                                product<?php echo ($shop_query->post_count != 1) ? 's' : ''; ?></span></h5>
                    </div>
                    <div class="form-clt">
                        <h6>Sort by: <a href="#"><i class="fal fa-sort-alt"></i></a></h6>
                        <form method="GET" action="<?php echo esc_url(get_permalink()); ?>" class="sort-form">
                            <select name="orderby" class="nice-select" onchange="this.form.submit()">
                                <option value="menu_order" <?php selected($_GET['orderby'] ?? '', 'menu_order'); ?>>
                                    Default</option>
                                <option value="price" <?php selected($_GET['orderby'] ?? '', 'price'); ?>>Price: Low to
                                    High</option>
                                <option value="price-desc" <?php selected($_GET['orderby'] ?? '', 'price-desc'); ?>>
                                    Price: High to Low</option>
                                <option value="date" <?php selected($_GET['orderby'] ?? '', 'date'); ?>>Newest</option>
                                <option value="rating" <?php selected($_GET['orderby'] ?? '', 'rating'); ?>>Average
                                    Rating</option>
                            </select>
                            <?php
                            // preserve filters
                            foreach (['min_price', 'max_price', 'product_cat'] as $param) {
                                if (isset($_GET[$param])) {
                                    echo '<input type="hidden" name="' . esc_attr($param) . '" value="' . esc_attr($_GET[$param]) . '">';
                                }
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
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                                    alt="<?php the_title(); ?>">
                                <?php if ($product->is_on_sale()): ?>
                                <span class="onsale">Sale!</span>
                                <?php endif; ?>
                            </div>
                            <div class="shop-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="store_name">
                                        <?php echo get_product_store_name(get_the_ID()); ?>
                                    </div>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <h5><?php echo $product->get_price_html(); ?></h5>
                                <div class="shop-list-btn">
                                    <div class="">
                                        <a href="#" class="product-popup btn btn-outline-secondary btn-sm"
                                            data-productid="<?php echo get_the_ID(); ?>">
                                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </a>
                                    </div>
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

<?php get_footer(); ?>