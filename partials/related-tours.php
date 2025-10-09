<section class="related-tours">
    <div class="container">
        <div class="row g-3">
            <h2>Day trips that might interest you</h2>
            <?php
            $args = array(
                'post_type' => 'tours',
                'posts_per_page' => 4,
                'post_status' => 'publish',
            );

            $tours_query = new WP_Query($args);
            if ($tours_query->have_posts()):
                while ($tours_query->have_posts()):
                    $tours_query->the_post();
                        $tour_comments = get_tour_comments(get_the_ID());
                                $review_count = count($tour_comments);
                    echo '<div class="col-12 col-lg-3">';
                      get_template_part('partials/tour', 'box',array('review_count' => $review_count  )  );
                    echo '</div>';
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No tours found.</p>';
            endif;
            ?>
        </div>
    </div>
     <div class="divider"></div>
</section>