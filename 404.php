<?php get_header(); ?>
<?php $bg_image =  get_template_directory_uri() . '/assets/img/bg-img/1.jpg';
get_template_part('partials/content', 'breadcrumb', [
    'bg' => $bg_image
]);?>
<div class="error-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="error-content text-center">
                    <img class="mb-4" src="<?php echo get_template_directory_uri(); ?>/assets/img/core-img/404.png"
                        alt="">
                    <p class="mb-5 px-md-5">Sorry, the page you're looking for doesn't exist. If you think something is
                        broken, report a problem </p>
                    <a href="<?php bloginfo('url'); ?>" class="btn btn-success">Back To Home <i
                            class="icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
</div>
<?php get_footer(); ?>
