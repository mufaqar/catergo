<section class="food-category-section fix section-padding section-bg">
    <div class="container">
        <div class="section-title text-center">
            <span class="wow fadeInUp">crispy, every bite taste</span>
            <h2 class="wow fadeInUp" data-wow-delay=".3s">Popular Food Items</h2>
        </div>
        <div class="row">
            <?php
            // WP Query for catering post type
            $catering_args = array(
                'post_type' => 'catering',
                'posts_per_page' => 8, // Adjust as needed
                'status' => 'publish'
            );
            
            $catering_query = new WP_Query($catering_args);
            $delay_classes = array('.3s', '.5s', '.7s', '.8s', '.3s', '.5s', '.7s', '.8s');
            $delay_index = 0;
            
            if ($catering_query->have_posts()) :
                while ($catering_query->have_posts()) : $catering_query->the_post();
                    $post_id = get_the_ID();
                    
                    // Get ACF fields or fallback to default values
                    $regular_price = get_field('regular_price', $post_id) ?: '30.52';
                    $sale_price = get_field('sale_price', $post_id) ?: '28.52';
                    $discount_percent = 0;                
                    $rating = get_field('rating', $post_id) ?: 4;                   
                  
                    // Fallback to post thumbnail
                    $image_url = get_the_post_thumbnail_url($post_id, 'medium');
                    $image_alt = get_the_title();
                  
                    
                    // Calculate active class for specific post (you can modify this logic)
                    $active_class = ($catering_query->current_post == 1) ? 'active' : '';
                    ?>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay_classes[$delay_index]; ?>">
                        <div class="catagory-product-card-2 text-center <?php echo $active_class; ?>">
                            <div class="icon">
                                <a href="#"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="catagory-product-image">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.jpg" alt="No image available">
                                <?php endif; ?>
                            </div>
                            <div class="catagory-product-content">
                                <div class="catagory-button">
                                    <a href="#" class="theme-btn-2">
                                        <i class="far fa-shopping-basket"></i>Add To Cart
                                    </a>
                                </div>
                                <div class="info-price d-flex align-items-center justify-content-center">
                                    <p>-<?php echo esc_html($discount_percent); ?>%</p>
                                    <h6>$<?php echo esc_html($regular_price); ?></h6>
                                    <span>$<?php echo esc_html($sale_price); ?></span>
                                </div>
                                <h4>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                               
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    $delay_index++;
                    if ($delay_index >= count($delay_classes)) {
                        $delay_index = 0;
                    }
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="col-12 text-center">
                    <p>No catering items found.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="catagory-button text-center pt-4 wow fadeInUp" data-wow-delay=".3s">
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="theme-btn">
                <span class="button-content-wrapper d-flex align-items-center">
                    <span class="button-icon"><i class="flaticon-delivery"></i></span>
                    <span class="button-text">view more</span>
                </span>
            </a>
        </div>
    </div>
</section>