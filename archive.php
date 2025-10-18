<?php
/*
 * Template Name: Category Archive
 * Description: A template for displaying posts from a specific category.
 */
get_header();

$bg_image = get_theme_mod('category_archive_bg_image') ?: get_template_directory_uri() . '/assets/images/banner-bg.jpg';

get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image,
    'title' => single_cat_title('', false) // Display the category name as the title
]);

?>

<div class="blog-section">
    <div class="divider"></div>
    <div class="container">
        <div class="row g-5 g-md-4 g-xxl-5">
            <?php if (have_posts()) : ?>
                <div class="col-12 col-md-7 col-lg-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="single-blog-content wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="200ms">
                            <!-- Post Thumbnail -->
                            <div class="col-12 mb-4">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img class="rounded-4" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else : ?>
                                    <img class="rounded-4" src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-img/127.jpg" alt="Default Image">
                                <?php endif; ?>
                            </div>

                            <!-- Post Body -->
                            <div class="post-body">
                                <div class="blog-meta flex-wrap d-flex align-items-center gap-3 gap-lg-4 mb-3">
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                        <i class="ti ti-user"></i> By <?php the_author(); ?>
                                    </a>
                                    <a href="<?php the_permalink(); ?>">
                                        <i class="ti ti-calendar"></i> <?php the_date(); ?>
                                    </a>
                                    <a href="<?php comments_link(); ?>">
                                        <i class="ti ti-message-circle"></i>
                                        <?php comments_number('No Comments', '1 Comment', '% Comments'); ?>
                                    </a>
                                </div>

                                <!-- Post Title -->
                                <h3 class="post-title mb-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="d-flex flex-column gap-4">
                                    <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read More</a>
                                </div>
                            </div>

                            <div class="divider-sm"></div>

                            <!-- Tag & Share -->
                            <div class="tag-share-wrapper">
                                <ul class="list-unstyled share-list">
                                    <li>Share:</li>
                                    <li><a href="#"><i class="ti ti-brand-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti ti-brand-x"></i></a></li>
                                    <li><a href="#"><i class="ti ti-brand-linkedin"></i></a></li>
                                    <li><a href="#"><i class="ti ti-brand-youtube"></i></a></li>
                                </ul>
                            </div>

                            <div class="divider-sm"></div>
                        </div>
                    <?php endwhile; ?>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <?php
                        the_posts_pagination([
                            'prev_text' => '<i class="ti ti-arrow-left"></i>',
                            'next_text' => '<i class="ti ti-arrow-right"></i>',
                            'screen_reader_text' => __('Posts navigation')
                        ]);
                        ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="d-flex flex-column gap-5">
                        <!-- Categories Widget -->
                        <div class="blog-widget">
                            <div class="h4 fw-bold mb-4">Categories</div>
                            <ul class="blog-list style-two">
                                <?php
                                $categories = get_categories();
                                foreach ($categories as $category) {
                                    echo '<li>';
                                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">';
                                    echo esc_html($category->name);
                                    echo ' <span>' . $category->count . '</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </div>

                        <!-- Follow Us Widget -->
                        <div class="blog-widget">
                            <div class="h4 fw-bold mb-4">Follow Us</div>
                            <div class="follow-nav">
                                <a href="https://www.facebook.com/profile.php?id=61577812495327" target="_blank"><i class="ti ti-brand-facebook"></i></a>
                                <a href="https://www.tiktok.com/@gotriptoday" target="_blank"><i class="ti ti-brand-tiktok"></i></a>
                                <a href="https://www.instagram.com/gotriptodaycom/" target="_blank"><i class="ti ti-brand-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-12">
                    <p><?php esc_html_e('No posts found in this category.', 'text-domain'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>