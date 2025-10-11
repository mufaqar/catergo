<section class="food-category-section fix section-padding section-bg">
    <div class="tomato-shape">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tomato-shape.png" alt="shape-img">
    </div>
    <div class="burger-shape-2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/burger-shape-2.png" alt="shape-img">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-9">
                <div class="section-title">
                    <span class="wow fadeInUp">crispy, every bite taste</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Beställ nu</h2>
                </div>
            </div>
            <div class="col-md-5 ps-0 col-3 text-end wow fadeInUp" data-wow-delay=".5s">
                <div class="array-button">
                    <button class="array-prev"><i class="far fa-long-arrow-left"></i></button>
                    <button class="array-next"><i class="far fa-long-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="swiper food-catagory-slider">

            <div class="swiper-wrapper">
                <?php
                // Get terms from the product_cat taxonomy (WooCommerce categories)
                $terms = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true, // Changed to true to show only categories with products
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'parent' => 0, // Only show top-level categories
                ));

                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        // Get term data
                        $product_count = $term->count;
                        $category_name = $term->name;
                        $category_description = $term->description;
                        
                      // WooCommerce category thumbnail (custom size)
                        if (!$product_image) {
                            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                            if ($thumbnail_id) {
                                $img = wp_get_attachment_image_src($thumbnail_id, 'category_thumbnail');
                                $product_image = $img ? $img[0] : '';
                            }
                        }

                        // Default fallback
                        if (!$product_image) {
                            $product_image = get_template_directory_uri() . '/assets/images/category.jpg';
                        }
                                                
                        $term_link = get_term_link($term);
                        
                        // Skip if there's an error with the term link
                        if (is_wp_error($term_link)) {
                            continue;
                        }
                        ?>



                <div class="swiper-slide">
                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/catagory-card-shape.jpg');">
                        <div class="catagory-product-image text-center">
                            <a href="<?php echo get_term_link($term); ?>">
                                <img src="<?php echo esc_url($product_image); ?>"
                                    alt="<?php echo esc_attr($category_name); ?>">

                            </a>
                        </div>
                        <div class="catagory-product-content text-center">
                            <h3>
                                <a href="<?php echo esc_url($term_link); ?>">
                                    <?php echo esc_html($category_name); ?>
                                </a>
                            </h3>
                            <p><?php echo $product_count; ?> products</p>
                        </div>
                    </div>
                </div>
                <?php
        }
    } else {
        // Fallback if no terms found
        echo '<p>No food categories found.</p>';
    }
    ?>
            </div>
        </div>
    </div>
</section>