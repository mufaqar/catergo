<!-- Blog Card -->
<div class="col-12 col-sm-6 col-lg-4">
    <div class="blog-card-two theme-two wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
        <!-- Post Image -->
        <div class="post-img mb-4">
            <?php if ( has_post_thumbnail() ) {
						the_post_thumbnail('blog');
					} else { ?>
            <img src="<?php bloginfo('template_directory'); ?>/assets/img/bg-img/1.jpg" alt="Featured Thumbnail" />
            <?php } ?>
        </div>

        <!-- Blog Body -->
        <div class="post-body">
            <div class="blog-meta mb-3 flex-wrap d-flex align-items-center gap-4">
              
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 10C14.2091 10 16 8.20914 16 6C16 3.79086 14.2091 2 12 2C9.79086 2 8 3.79086 8 6C8 8.20914 9.79086 10 12 10Z"
                            stroke="#3cb371" stroke-width="1.5" />
                        <path
                            d="M20 17.5C20 19.985 20 22 12 22C4 22 4 19.985 4 17.5C4 15.015 7.582 13 12 13C16.418 13 20 15.015 20 17.5Z"
                            stroke="#3cb371" stroke-width="1.5" />
                    </svg>
                   <?php the_author(); ?>
               
           
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M3.464 16.828C2 15.657 2 14.771 2 11C2 7.229 2 5.343 3.464 4.172C4.93 3 7.286 3 12 3C16.714 3 19.071 3 20.535 4.172C21.999 5.344 22 7.229 22 11C22 14.771 22 15.657 20.535 16.828C19.072 18 16.714 18 12 18C9.49 18 8.2 19.738 6 21V17.788C4.906 17.625 4.101 17.338 3.464 16.828Z"
                            stroke="#3cb371" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                 <?php comments_number('No Comments', '1 Comment', '% Comments'); ?>
              
            </div>
            <a class="post-title h4" href="<?php the_permalink() ?>"><?php the_title()?></a>
            <div class="d-block mt-4">
                <a class="btn btn-outline-success" href="<?php the_permalink() ?>">Read More <i
                        class="icon-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>