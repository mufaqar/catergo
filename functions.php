<?php 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 140, 140, true );
	add_image_size( 'single-post-thumbnail', 300, 9999 );
    add_image_size( 'tour-thumbnail', 300, 200, true );
    add_image_size('tour_slide', 1350, 500, true); // true = hard crop

    add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
    function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    
    include_once('inc/class-walker-nav.php');
    include_once('inc/extra.php');

	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
		// Declare sidebar widget zone
	if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h4>',
    		'after_title'   => '</h4>'
    	));
    }

function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}

if (function_exists('register_nav_menus')) {
register_nav_menus( array(
		'main' => __( 'Main Menu', '' ),
		'footer_routes' => __( 'Footer Routes Menu', '' ),
        'footer_offer' => __( 'Footer Offer Menu', '' ),
        'footer_legal' => __( 'Footer Legaal Menu', '' ),
	) );
}


function fallbackmenu1(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function fallbackmenu2(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'sub';
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 $buttons[] = 'lineheight';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");

function add_first_and_last($items) {
    $items[1]->classes[] = 'first-menu-item';
    $items[count($items)]->classes[] = 'last-menu-item';
    return $items;
}
 
add_filter('wp_nav_menu_objects', 'add_first_and_last');

function enqueue_ajax_contact_form_script() {
    wp_enqueue_script('ajax-contact', get_stylesheet_directory_uri() . '/assets/js/ajax.js', array('jquery'), null, true);
    wp_localize_script('ajax-contact', 'ajaxContact', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ajax-contact-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_contact_form_script');



function enqueue_wishlist_script() {
    if (is_singular('tours') || is_page_template('wishlist.php')) { 
        // enqueue on single tour AND wishlist page
        wp_enqueue_script(
            'wishlist-script',
            get_stylesheet_directory_uri() . '/assets/js/wishlist.js',
            array('jquery'),
            null,
            true
        );
        wp_localize_script('wishlist-script', 'wpvars', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_wishlist_script');



function get_tour_details_ajax() {
    if (isset($_GET['tour_id'])) {
        $tour_id = intval($_GET['tour_id']);
        $tour = get_post($tour_id);

        // ✅ Correct post type check
        if ($tour && $tour->post_type === 'tours') {
            wp_send_json(array(
                'title'     => get_the_title($tour_id),
                'permalink' => get_permalink($tour_id),
                'thumbnail' => get_the_post_thumbnail_url($tour_id, 'thumbnail') // optional
            ));
        }
    }
    wp_send_json_error('Invalid tour ID');
}
add_action('wp_ajax_get_tour_details', 'get_tour_details_ajax');
add_action('wp_ajax_nopriv_get_tour_details', 'get_tour_details_ajax');



function get_tour_comments($post_id) {
    $args = array(
        'post_id' => $post_id,
        'status'  => 'approve', // only approved comments
        'order'   => 'DESC',    // newest first
    );

    $comments = get_comments($args);
    $data = array();

    foreach ($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'rating', true);

        $data[] = array(
            'comment_ID' => $comment->comment_ID,
            'author'     => $comment->comment_author,
            'content'    => $comment->comment_content,
            'date'       => get_comment_date('', $comment),
            'rating'     => $rating ? intval($rating) : null,
        );
    }

    return $data;
}


// Hide admin bar for non-admins
add_filter('show_admin_bar', function($show) {
    return current_user_can('manage_options') ? $show : false;
});



add_filter('woocommerce_get_checkout_order_received_url', 'mufaqar_custom_thankyou_redirect', 10, 2);
function mufaqar_custom_thankyou_redirect($order_received_url, $order) {
    // Redirect after successful checkout
    return home_url('/thank-you/?order_id=' . $order->get_id());
}