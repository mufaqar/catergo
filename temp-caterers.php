<?php
/* Template Name: Caterers */
get_header();
$location = get_query_var('location');
if (!$location && !empty($_COOKIE['selected_location'])) {
    $location = sanitize_text_field($_COOKIE['selected_location']);
}

$bg_image = get_theme_mod('category_archive_bg_image') ?: get_template_directory_uri() . '/assets/images/banner-bg.jpg';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image,
    'title' => 'Our ' . ' Caterers in ' . esc_html($location),
]);
?>
<!-- Food Category Section Start -->
<section class="food-category-section fix section-padding section-bg">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 order-1 order-md-1 mt-5">
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
                                    switch (strtolower($category->name)) {
                                        case 'burger':
                                            $icon_class = 'flaticon-burger';
                                            break;
                                        case 'chicken':
                                            $icon_class = 'flaticon-chicken';
                                            break;
                                        case 'pizza':
                                            $icon_class = 'flaticon-pizza';
                                            break;
                                        case 'fries':
                                            $icon_class = 'flaticon-french-fries';
                                            break;
                                        case 'sandwich':
                                            $icon_class = 'flaticon-sandwich';
                                            break;
                                        case 'bread':
                                            $icon_class = 'flaticon-bread';
                                            break;
                                        case 'rice':
                                            $icon_class = 'flaticon-rice';
                                            break;
                                        case 'hotdog':
                                            $icon_class = 'flaticon-hotdog';
                                            break;
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
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'meta_query' => [
                                    [
                                        'key' => '_stock_status',
                                        'value' => 'instock',
                                        'compare' => '='
                                    ]
                                ]
                            ]);

                            if ($new_arrivals->have_posts()):
                                while ($new_arrivals->have_posts()):
                                    $new_arrivals->the_post();
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
            <div class="col-xl-9 col-lg-8 order-2 order-md-2">
                <div class="row">
                    <?php
                    $stores = get_posts([
                        'post_type' => 'caterer',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'location' => $location,
                    ]);
                    if ($stores):
                        foreach ($stores as $store): ?>
                            <div class="store-item mb-5 pb-4 border-bottom">
                                <div class="row align-items-center mb-4">
                                    <!-- Store Image -->
                                    <div class="col-md-2 col-sm-3">
                                        <?php
                                        if (has_post_thumbnail($store->ID)) {
                                            echo get_the_post_thumbnail($store->ID, 'medium', ['class' => 'img-fluid rounded']);
                                        } else {
                                            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-store.jpg') . '" class="img-fluid rounded" alt="Default store">';
                                        }
                                        ?>
                                    </div>
                                    <!-- Store Info -->
                                    <div class="col-md-10 col-sm-9">
                                        <div class="store-header">
                                            <div class="store-meta small text-muted mb-1">
                                                <?php echo $location; ?>
                                            </div>
                                            <h3 class="store-title mb-1">
                                                <a href="<?php echo get_permalink($store->ID); ?>"
                                                    class="text-dark fw-semibold text-decoration-none">
                                                    <?php echo $store->post_title; ?>
                                                </a>
                                            </h3>
                                            <p class="store-description text-muted">
                                                <?php echo wp_trim_words($store->post_content, 25, '...'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Store Products -->
                                <div class="fooder-menu-section">
                                    <div class="brand-title mb-3">
                                        <h4>Popular Items</h4>
                                    </div>

                                    <div class="fooder-menu-wrapper">
                                        <div class="row">
                                            <?php
                                            $products = get_posts([
                                                'post_type' => 'product',
                                                'meta_key' => '_assigned_store',
                                                'meta_value' => $store->ID,
                                                'posts_per_page' => -1,
                                                'post_status' => 'publish'
                                            ]);

                                            if ($products):
                                                foreach ($products as $product):
                                                    $price = get_post_meta($product->ID, '_price', true);
                                                    $excerpt = wp_trim_words(get_the_excerpt($product->ID), 15);
                                                    ?>
                                                    <div class="col-xl-6 col-lg-6 mb-3">
                                                        <div
                                                            class="food-menu-items d-flex align-items-center justify-content-between border rounded p-3 shadow-sm bg-white">
                                                            <div class="food-menu-content">
                                                                <h5 class="mb-1">
                                                                    <a href="<?php echo get_permalink($product->ID); ?>"
                                                                        class="text-dark text-decoration-none">
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
                                                                    <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?>
                                                                    </h6>
                                                                <?php endif; ?>
                                                                <a href="#" class="product-popup plusicon"
                                                                    data-productid="<?php echo $product->ID; ?>">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            else:
                                                echo '<div class="col-12"><p class="text-muted"><em>No products found for this caterer.</em></p></div>';
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        endforeach;
                    else:
                        echo '<p class="text-center text-muted">No caterers found.</p>';
                    endif;
                    ?>
                </div>
            </div>
</section>



<?php get_footer(); ?>