<?php
$bg = isset($args['bg']) ? esc_url($args['bg']) : get_template_directory_uri() . '/assets/images/banner.webp';
?>


<div class="breadcrumb-wrapper bg-cover" style="background-image: url('<?php echo $bg; ?>');">
    <div class="container">
        <div class="page-heading center">
            <h1><?php the_title()?></h1>
            <ul class="breadcrumb-items">
                <li>
                    <a href="<?php echo home_url('/home'); ?>">
                        Home Page
                    </a>
                </li>
                <li>
                    <i class="far fa-chevron-right"></i>
                </li>
                <li>
                    <?php the_title()?>
                </li>
            </ul>
        </div>
    </div>
</div>