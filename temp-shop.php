<?php
/* Template Name: Shop */
get_header(); 

$bg_image = get_template_directory_uri() . '/assets/images/banner.webp';
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
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ]);
                            
                            if ($categories && !is_wp_error($categories)) {
                                echo '<ul>';
                                foreach ($categories as $category) {
                                    $icon_class = 'flaticon-burger'; // Default icon
                                    // You can add specific icons for different categories
                                    switch(strtolower($category->name)) {
                                        case 'burger': $icon_class = 'flaticon-burger'; break;
                                        case 'chicken': $icon_class = 'flaticon-chicken'; break;
                                        case 'pizza': $icon_class = 'flaticon-pizza'; break;
                                        case 'fries': $icon_class = 'flaticon-french-fries'; break;
                                        case 'sandwich': $icon_class = 'flaticon-sandwich'; break;
                                        case 'bread': $icon_class = 'flaticon-bread'; break;
                                        case 'rice': $icon_class = 'flaticon-rice'; break;
                                        case 'hotdog': $icon_class = 'flaticon-hotdog'; break;
                                        default: $icon_class = 'flaticon-burger';
                                    }
                                    echo '<li><a href="' . get_term_link($category) . '"><i class="' . $icon_class . '"></i>' . esc_html($category->name) . '</a></li>';
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
                                <div class="slider">
                                    <div class="progress" style="left: 0%; right: 0%;"></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" class="range-min" name="min_price" min="0" max="1000" value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : '0'; ?>">
                                    <input type="range" class="range-max" name="max_price" min="0" max="1000" value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : '1000'; ?>">
                                </div>
                                <div class="range-items">
                                    <div class="price-input d-flex">
                                        <div class="field">
                                            <span>Price:</span>
                                        </div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" class="input-min" name="min_price" value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : '0'; ?>">
                                        </div>
                                        <div class="separators">-</div>
                                        <div class="field">
                                            <span>$</span>
                                            <input type="number" class="input-max" name="max_price" value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : '1000'; ?>">
                                        </div>
                                        <button type="submit" class="theme-btn border-radius-none">Filter</button>
                                        
                                        <!-- Keep other query parameters -->
                                        <?php if (isset($_GET['product_cat'])): ?>
                                            <input type="hidden" name="product_cat" value="<?php echo esc_attr($_GET['product_cat']); ?>">
                                        <?php endif; ?>
                                        <?php if (isset($_GET['orderby'])): ?>
                                            <input type="hidden" name="orderby" value="<?php echo esc_attr($_GET['orderby']); ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Filter by Size</h4>
                        </div>
                        <div class="filter-size">
                            <?php
                            $sizes = ['small', 'medium', 'large', 'family'];
                            foreach ($sizes as $size) {
                                $checked = isset($_GET['size']) && in_array($size, (array)$_GET['size']) ? 'checked' : '';
                                echo '<div class="input-save d-flex align-items-center">';
                                echo '<input type="checkbox" class="form-check-input" name="size[]" value="' . esc_attr($size) . '" ' . $checked . ' onchange="this.form.submit()">';
                                echo '<label>' . ucfirst($size) . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- WooCommerce New Arrivals -->
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>New Arrivals</h4>
                        </div>
                        <div class="popular-food-posts">
                            <?php
                            $new_arrivals = new WP_Query([
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'meta_query' => [
                                    [
                                        'key' => '_stock_status',
                                        'value' => 'instock',
                                        'compare' => '='
                                    ]
                                ],
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ]);

                            if ($new_arrivals->have_posts()) {
                                while ($new_arrivals->have_posts()) {
                                    $new_arrivals->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    ?>
                                    <div class="single-post-item">
                                        <div class="thumb bg-cover" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>');"></div>
                                        <div class="post-content">
                                            <div class="star">
                                                <?php
                                                $rating = $product->get_average_rating();
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $class = $i <= $rating ? 'fas fa-star' : 'fas fa-star color-bg';
                                                    echo '<span class="' . $class . '"></span>';
                                                }
                                                ?>
                                            </div>
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <div class="post-price">
                                                <?php
                                                if ($product->is_on_sale()) {
                                                    echo '<span class="theme-color-2">' . $product->get_sale_price() . get_woocommerce_currency_symbol() . '</span>';
                                                    echo '<span>' . $product->get_regular_price() . get_woocommerce_currency_symbol() . '</span>';
                                                } else {
                                                    echo '<span>' . $product->get_price() . get_woocommerce_currency_symbol() . '</span>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                wp_reset_postdata();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xl-9 col-lg-8 order-1 order-md-2">
                <div class="woocommerce-notices-wrapper mb-0">
                    <div class="product-showing">
                        <h5><a href="#" id="filter-toggle"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/filter.png" alt="img"></span> Filtering</a></h5>
                        <h5>Showing <span><?php echo $shop_query->post_count; ?> products</span></h5>
                    </div>
                    <div class="form-clt">
                        <h6>Sort by: <a href="#"><i class="fal fa-sort-alt"></i></a></h6>
                        <form method="GET" action="<?php echo esc_url(get_permalink()); ?>" class="sort-form">
                            <select name="orderby" class="nice-select" onchange="this.form.submit()">
                                <option value="menu_order" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'menu_order'); ?>>Default</option>
                                <option value="price" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'price'); ?>>Price: Low to High</option>
                                <option value="price-desc" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'price-desc'); ?>>Price: High to Low</option>
                                <option value="date" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'date'); ?>>Newest</option>
                                <option value="rating" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'rating'); ?>>Average Rating</option>
                            </select>
                            
                            <!-- Keep other query parameters -->
                            <?php if (isset($_GET['min_price'])): ?>
                                <input type="hidden" name="min_price" value="<?php echo esc_attr($_GET['min_price']); ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['max_price'])): ?>
                                <input type="hidden" name="max_price" value="<?php echo esc_attr($_GET['max_price']); ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['product_cat'])): ?>
                                <input type="hidden" name="product_cat" value="<?php echo esc_attr($_GET['product_cat']); ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['size'])): ?>
                                <?php foreach ((array)$_GET['size'] as $size): ?>
                                    <input type="hidden" name="size[]" value="<?php echo esc_attr($size); ?>">
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </form>
                        <div class="icon">
                            <a href="<?php echo esc_url(add_query_arg('view', 'grid', get_permalink())); ?>"><i class="fas fa-th"></i></a>
                        </div>
                        <div class="icon-2">
                            <a href="<?php echo esc_url(add_query_arg('view', 'list', get_permalink())); ?>"><i class="fas fa-list"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    // Build query args
                    $args = [
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                        'meta_query' => [
                            [
                                'key' => '_stock_status',
                                'value' => 'instock',
                                'compare' => '='
                            ]
                        ]
                    ];

                    // Price filter
                    if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
                        $args['meta_query'][] = [
                            'key' => '_price',
                            'value' => [floatval($_GET['min_price']), floatval($_GET['max_price'])],
                            'type' => 'DECIMAL',
                            'compare' => 'BETWEEN'
                        ];
                    }

                    // Category filter
                    if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => sanitize_text_field($_GET['product_cat'])
                        ];
                    }

                    // Order by
                    if (isset($_GET['orderby'])) {
                        switch ($_GET['orderby']) {
                            case 'price':
                                $args['orderby'] = 'meta_value_num';
                                $args['meta_key'] = '_price';
                                $args['order'] = 'ASC';
                                break;
                            case 'price-desc':
                                $args['orderby'] = 'meta_value_num';
                                $args['meta_key'] = '_price';
                                $args['order'] = 'DESC';
                                break;
                            case 'date':
                                $args['orderby'] = 'date';
                                $args['order'] = 'DESC';
                                break;
                            case 'rating':
                                $args['orderby'] = 'meta_value_num';
                                $args['meta_key'] = '_wc_average_rating';
                                $args['order'] = 'DESC';
                                break;
                            default:
                                $args['orderby'] = 'menu_order title';
                                $args['order'] = 'ASC';
                        }
                    }

                    $shop_query = new WP_Query($args);

                    if ($shop_query->have_posts()) {
                        while ($shop_query->have_posts()) {
                            $shop_query->the_post();
                            $product = wc_get_product(get_the_ID());
                            ?>
                            <div class="col-xl-12 col-lg-12">
                                <div class="shop-list-items">
                                    <div class="shop-image">
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>">
                                        <?php if ($product->is_on_sale()): ?>
                                            <span class="onsale">Sale!</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="shop-content">
                                        <div class="star pb-4">
                                            <?php
                                            if ($product->is_on_sale()) {
                                                $regular_price = $product->get_regular_price();
                                                $sale_price = $product->get_sale_price();
                                                $discount = round(($regular_price - $sale_price) / $regular_price * 100);
                                                echo '<span>-'.$discount.'%</span>';
                                            }
                                            
                                            $rating = $product->get_average_rating();
                                            for ($i = 1; $i <= 5; $i++) {
                                                $class = $i <= $rating ? 'fas fa-star' : 'fas fa-star color-bg';
                                                echo '<a href="#"><i class="' . $class . '"></i></a>';
                                            }
                                            ?>
                                        </div>
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                        <h5>
                                            <?php
                                            if ($product->is_on_sale()) {
                                                echo get_woocommerce_currency_symbol() . $product->get_sale_price() . ' - ' . get_woocommerce_currency_symbol() . $product->get_regular_price();
                                            } else {
                                                echo get_woocommerce_currency_symbol() . $product->get_price();
                                            }
                                            ?>
                                        </h5>
                                        <div class="shop-list-btn">
                                            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="1" class="theme-btn add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" aria-label="Add <?php the_title(); ?> to your cart">
                                                <span class="button-content-wrapper d-flex align-items-center">
                                                    <span class="button-icon"><i class="flaticon-delivery"></i></span>
                                                    <span class="button-text">Add to Cart</span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12"><p>No products found.</p></div>';
                    }
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- Pagination -->
                <div class="page-nav-wrap mt-5 text-center">
                    <?php
                    echo paginate_links([
                        'total' => $shop_query->max_num_pages,
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