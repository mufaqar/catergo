<section class="food-category-section fix section-padding section-bg">
    <div class="tomato-shape">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/imagestomato-shape.png" alt="shape-img">
    </div>
    <div class="burger-shape-2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/imagesburger-shape-2.png" alt="shape-img">
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
    // Get terms from the food_types taxonomy
    $terms = get_terms(array(
        'taxonomy' => 'food_types',
        'hide_empty' => false,
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {

          
            
            // Get term meta or use defaults
            $product_count = $term->count;
            $category_name = $term->name;
            $category_slug = $term->slug;

            $termid = $term->term_id;
            $product_image = get_field('feature_image', $term->taxonomy . '_' . $term->term_id);

            

?>




                <div class="swiper-slide">
                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/imagescatagory-card-shape.jpg');">
                        <h5><?php echo $product_count; ?> products</h5>
                        <div class="catagory-product-image text-center">
                            <a href="<?php echo get_term_link($term); ?>">
                                <img src="<?php echo esc_url($product_image); ?>"
                                    alt="<?php echo esc_attr($category_name); ?>" width="100%" height="auto">
                                <div class="decor-leaf">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/imagesdecor-leaf.svg"
                                        alt="shape-img">
                                </div>
                                <div class="decor-leaf-2">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/imagesdecor-leaf-2.svg"
                                        alt="shape-img">
                                </div>
                                <div class="burger-shape">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/imagesburger-shape.png"
                                        alt="shape-img">
                                </div>
                            </a>
                        </div>
                        <div class="catagory-product-content text-center">
                            <h3>
                                <a href="<?php echo get_term_link($term); ?>">
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