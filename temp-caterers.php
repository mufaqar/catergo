<?php
/* Template Name: Caterers */
get_header();
?>

<section class="caterers-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="section-title fw-bold">Our Caterers</h1>
            </div>
        </div>

        <?php
    $stores = get_posts([
      'post_type'      => 'store',
      'posts_per_page' => -1,
      'post_status'    => 'publish'
    ]);

    if ($stores) :
      foreach ($stores as $store) : ?>

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
                            Pakistani • BBQ • Karahi & Handi
                        </div>
                        <h2 class="store-title mb-1">
                            <a href="<?php echo get_permalink($store->ID); ?>"
                                class="text-dark fw-semibold text-decoration-none">
                                <?php echo esc_html($store->post_title); ?>
                            </a>
                        </h2>
                        <p class="store-description text-muted">
                            <?php echo wp_trim_words($store->post_content, 25, '...'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Store Products -->
            <div class="fooder-menu-section">
                <div class="brand-title mb-3">
                    <h3 class="fw-bold">Popular Items</h3>
                </div>

                <div class="fooder-menu-wrapper">
                    <div class="row">
                        <?php
              $products = get_posts([
                'post_type'      => 'product',
                'meta_key'       => '_assigned_store',
                'meta_value'     => $store->ID,
                'posts_per_page' => -1,
                'post_status'    => 'publish'
              ]);

              if ($products) :
                foreach ($products as $product) :
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
                                    <div class="store_name">
                                        <?php echo get_product_store_name(get_the_ID()); ?>
                                    </div>
                                    <p class="small text-muted mb-0">
                                        <?php echo esc_html($excerpt ?: 'No description available.'); ?></p>
                                </div>
                                <div class="text-end">
                                    <?php if ($price) : ?>
                                    <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
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
              else :
                echo '<div class="col-12"><p class="text-muted"><em>No products found for this caterer.</em></p></div>';
              endif;
              ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
      endforeach;
    else :
      echo '<p class="text-center text-muted">No caterers found.</p>';
    endif;
    ?>
    </div>
</section>



<?php get_footer(); ?>