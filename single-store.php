<?php
/* Template for Single Store */
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        $store_id = get_the_ID();

        // Fetch products linked to this store
        $products = get_posts([
            'post_type'      => 'product',
            'meta_key'       => '_assigned_store',
            'meta_value'     => $store_id,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);
        ?>

<section class="single-store py-5">
    <div class="container">
        <!-- Store Header -->
        <div class="store-header mb-5 border-bottom pb-4">
            <div class="row align-items-center">
                <div class="col-md-2 col-sm-3">
                    <?php if (has_post_thumbnail($store_id)) : ?>
                    <?php echo get_the_post_thumbnail($store_id, 'medium', ['class' => 'img-fluid rounded']); ?>
                    <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-store.jpg'); ?>"
                        class="img-fluid rounded" alt="Default store">
                    <?php endif; ?>
                </div>

                <div class="col-md-10 col-sm-9">
                    <div class="store-info">
                        <div class="store-meta small text-muted mb-1">
                            Pakistani • BBQ • Karahi & Handi
                        </div>

                        <h1 class="store-title fw-bold mb-2">
                            <?php echo esc_html(get_the_title()); ?>
                        </h1>

                        <div class="store-description text-muted mb-3">
                            <?php the_content(); ?>
                        </div>

                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"
                            class="btn btn-outline-secondary btn-sm">
                            ← Back to All Caterers
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Section -->
        <div class="fooder-menu-section">
            <div class="brand-title mb-3">
                <h3 class="fw-bold">Popular Items</h3>
            </div>

            <div class="fooder-menu-wrapper">
                <div class="row">
                    <?php if ($products) : ?>
                    <?php foreach ($products as $product) :
                            $price   = get_post_meta($product->ID, '_price', true);
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
                                <div class="store_name mb-1 small text-muted">
                                    <?php echo get_product_store_name($product->ID); ?>
                                </div>
                                <p class="small text-muted mb-0">
                                    <?php echo esc_html($excerpt ?: 'No description available.'); ?>
                                </p>
                            </div>
                            <div class="text-end">
                                <?php if ($price) : ?>
                                <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
                                <?php endif; ?>
                                <a href="#" class="product-popup plusicon"
                                    data-productid="<?php echo esc_attr($product->ID); ?>">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="col-12">
                        <p class="text-muted"><em>No products found for this store.</em></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    endwhile;
else :
    echo '<p class="text-center text-muted">Store not found.</p>';
endif;

get_footer();
?>