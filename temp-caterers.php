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
                                <p class="small text-muted mb-0">
                                    <?php echo esc_html($excerpt ?: 'No description available.'); ?></p>
                            </div>
                            <div class="text-end">
                                <?php if ($price) : ?>
                                <h6 class="text-primary fw-bold mb-1"><?php echo wc_price($price); ?></h6>
                                <?php endif; ?>
                                <a href="#" class="product-popup plusicon" data-productid="<?php echo $product->ID; ?>">
                                    <i class="fa fa-plus-circle"></i>
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

        <?php
      endforeach;
    else :
      echo '<p class="text-center text-muted">No caterers found.</p>';
    endif;
    ?>
    </div>
</section>

<!-- Hidden Popup Container -->
<div id="product-popup" class="mfp-hide white-popup">
    <div class="popup-inner">
        <div class="text-center py-5">Loading...</div>
    </div>
</div>

<style>
.white-popup {
    background: #fff;
    padding: 25px;
    max-width: 650px;
    margin: 0 auto;
    position: relative;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
</style>

<?php get_footer(); ?>

<script>
jQuery(document).ready(function($) {
    // Product popup trigger
    $(".product-popup").on("click", function(e) {
        e.preventDefault();
        const productID = $(this).data("productid");
        const popup = $("#product-popup");

        popup.find(".popup-inner").html('<div class="text-center py-5">Loading...</div>');

        $.post("<?php echo admin_url('admin-ajax.php'); ?>", {
            action: "get_product_popup",
            product_id: productID
        }, function(response) {
            if (response.success) {
                popup.find(".popup-inner").html(response.data);
            } else {
                popup.find(".popup-inner").html(
                    '<p class="text-danger">Error loading product.</p>');
            }
        });

        $.magnificPopup.open({
            items: {
                src: "#product-popup"
            },
            type: "inline",
            midClick: true,
            mainClass: "mfp-fade"
        });
    });

    // Handle Add to Cart inside popup
    $(document).on("submit", ".popup-inner form.cart", function(e) {
        e.preventDefault();
        const form = $(this);
        const note = form.find("textarea[name='custom_note']").val();
        form.find("input[name='custom_note_field']").val(note);
        const formData = form.serialize();

        $.ajax({
            url: wc_add_to_cart_params.wc_ajax_url.replace("%%endpoint%%", "add_to_cart"),
            type: "POST",
            data: formData,
            success: function(response) {
                if (response && response.fragments) {
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                    form.html(
                        '<div class="alert alert-success">✅ Added to cart successfully!</div>'
                    );
                    setTimeout(() => $.magnificPopup.close(), 1200);
                } else {
                    form.prepend(
                        '<div class="alert alert-danger">Error adding to cart. Please try again.</div>'
                    );
                }
            },
            error: function() {
                form.prepend(
                    '<div class="alert alert-danger">Server error. Try again.</div>');
            }
        });
    });
});
</script>