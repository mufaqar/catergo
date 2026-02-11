<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <?php if (is_search()) { ?>
    <meta name="robots" content="noindex, nofollow" />
    <?php } ?>
    <title>
        <?php
				global $page, $paged, $post;			
				wp_title( '|', true, 'right' );
				bloginfo( 'name' );
				$site_description = get_bloginfo( 'description', 'display' );
				if ( $site_description && ( is_home() || is_front_page() ) )
					echo " | $site_description";
				if ( $paged >= 2 || $page >= 2 )
					echo ' | ' . sprintf( __( 'Page %s', 'wpv' ), max( $paged, $page ) );
            ?>
    </title>
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/meanmenu.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/custom.css">
</head>

<body <?php body_class(); ?>>

    <!-- Proloader Start -->
    <!-- <div id="preloader" class="preloader">
        <div class="animation-preloader">
            <div class="spinner">
            </div>
            <div class="txt-loading">
                <span data-text-preloader="C" class="letters-loading">
                    C
                </span>
                <span data-text-preloader="A" class="letters-loading">
                    A
                </span>
                <span data-text-preloader="T" class="letters-loading">
                    T
                </span>
                <span data-text-preloader="E" class="letters-loading">
                    E
                </span>
                <span data-text-preloader="R" class="letters-loading">
                    R
                </span>
                <span data-text-preloader="G" class="letters-loading">
                    G
                </span>
                <span data-text-preloader="O" class="letters-loading">
                    O
                </span>
            </div>
            <p class="text-center">Loading</p>
        </div>
    </div>
    <div class="loader">
        <div class="row">
            <div class="col-3 loader-section section-left">
                <div class="bg"></div>
            </div>
            <div class="col-3 loader-section section-left">
                <div class="bg"></div>
            </div>
            <div class="col-3 loader-section section-right">
                <div class="bg"></div>
            </div>
            <div class="col-3 loader-section section-right">
                <div class="bg"></div>
            </div>
        </div>
    </div>
    </div> -->


    <!-- Header Area Start -->
    <header class="section-bg">
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">

                <div>test</div>

                
 <select id="city-selector" style="margin-left:200px">
                     <option value="">Select city</option>
                       <?php
                                $current_location = '';
                                if (is_tax('location')) {
                                    $term = get_queried_object();
                                    if (!empty($term->slug)) {
                                        $current_location = $term->slug;
                                    }
                                }

                                elseif (!empty($_COOKIE['selected_location'])) {
                                    $current_location = sanitize_text_field($_COOKIE['selected_location']);
                                }
                                    $locations = get_terms([
                                        'taxonomy'   => 'location',
                                        'hide_empty' => false,
                                    ]);

                                    foreach ($locations as $location):
                                        $url = home_url('/' . $location->slug . '/');
                                    ?>
                <option
                    value="<?php echo esc_url($url); ?>"
                    <?php selected($current_location, $location->slug); ?>
                >
                    <?php echo esc_html($location->name); ?>
                </option>
             <?php endforeach; ?>
                </select>
                   

               


                    <div class="top-right">
                        <div class="search-wrp">
                            <button><i class="far fa-search"></i></button>
                            <input placeholder="Search" aria-label="Search">
                        </div>
                        <div class="social-icon d-flex align-items-center">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-vimeo-v"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-sticky" class="header-1">
            <div class="container">
                <div class="mega-menu-wrapper">
                    <div class="header-main">
                        <div class="logo">
                            <a href="<?php bloginfo('url'); ?>" class="header-logo">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images//Logo.svg"
                                    width="170" height="43" alt="Catergo-Logo">
                            </a>
                        </div>
                        <div class="header-left">
                            <div class="mean__menu-wrapper d-none d-lg-block">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <?php
                                        wp_nav_menu( array(
                                            'theme_location' => 'main', // Matches the registered location
                                            'menu_id'        => 'mobile-menu', // Optional: matches your ID
                                            'container'      => false, // No extra container div
                                            'walker'         => new Custom_Menu_Walker(), // Use the custom walker
                                            'fallback_cb'    => false, // Optional: hide if no menu assigned
                                        ) );
                                        ?>
                                    </nav>
                                    <!-- for wp -->
                                </div>
                            </div>
                        </div>
                        <div class="header-right d-flex justify-content-end align-items-center">
                            <?php get_template_part('partials/cart', 'widget'); ?>
                            <div class="header-button">
                                <a href="<?php echo home_url('/contact-us'); ?>" class="theme-btn bg-red-2">Contact
                                    us</a>
                            </div>
                            <div class="header__hamburger d-xl-block my-auto">
                                <div class="sidebar__toggle">
                                    <div class="header-bar">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // List of pages where this should run
    const allowedPages = [
        '/all-caterers/',  
        '/menus/'   
    ];

    // Get the current path
    const currentPath = window.location.pathname;
   

    // Check if current page is in the allowed list
    if (!allowedPages.includes(currentPath)) return;

    const select = document.getElementById('city-selector');
    if (!select) return;

    select.addEventListener('change', function () {
        if (!this.value) return;

        const slug = this.value
            .replace(window.location.origin + '/', '')
            .replace(/\/$/, '');

        document.cookie = `selected_location=${slug}; path=/; max-age=${60*60*24*30}`;
         window.location.href = this.value;
     
    });
});
</script>

