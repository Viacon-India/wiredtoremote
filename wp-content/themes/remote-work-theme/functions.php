<?php
session_start();
//---------------------------------------------Custom Theme Settings Path
if (file_exists(get_template_directory() . '/required/includes.php')) {
	require_once(get_template_directory() . '/required/includes.php');
}

if (file_exists(get_template_directory() . '/required/custom-plugins.php')) {
	require_once(get_template_directory() . '/required/custom-plugins.php');
}
if (file_exists(get_template_directory() . '/required/custom-ajax.php')) {
	require_once(get_template_directory() . '/required/custom-ajax.php');
}
if (file_exists(get_template_directory() . '/required/custom-ajax-functions.php')) {
	require_once(get_template_directory() . '/required/custom-ajax-functions.php');
}
if (file_exists(get_template_directory() . '/required/resume-builder-functions.php')) {
	require_once(get_template_directory() . '/required/resume-builder-functions.php');
}




//---------------------------------------------Enqueue Script and Style
add_action('wp_enqueue_scripts', 'my_plugin_assets');
function my_plugin_assets()
{
	$ver = '1.3.8';
	wp_enqueue_script('jquery.min', get_template_directory_uri() . '/js/jquery-3.7.1.min.js', array('jquery'), $ver, true);
	wp_enqueue_script('owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), $ver, true);
	wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/ThemeScript.js', array('jquery'), $ver, true);
	wp_enqueue_script('swiper-bundle.js.min', get_template_directory_uri() . '/js/swiper-bundle.min.js', array('jquery'), $ver, true);

	wp_enqueue_style('owl.carousel.min', get_template_directory_uri() . '/css/owl.carousel.min.css', $ver, 'all');
	wp_enqueue_style('swiper-bundle.css.min', get_template_directory_uri() . '/css/swiper-bundle.min.css', $ver, 'all');
	wp_enqueue_style('style', get_stylesheet_uri(), false, '', 'all');

	$jsData = [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'test' => '123',
        'test1' => 'world',
        ];

    wp_localize_script('custom-script', 'Front', $jsData);


	
}



//---------------------------------------------Enqueue Wordpress Media Script
add_action('admin_enqueue_scripts', 'admin_scripts');
function admin_scripts()
{
	wp_enqueue_media();
}



//---------------------------------------------Theme Setup
add_action('after_setup_theme', 'custom_theme_setup');
if (!function_exists('custom_theme_setup')) {
	function custom_theme_setup()
	{
		load_theme_textdomain('custom_theme');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('custom-logo');
		add_theme_support('post-thumbnails');

		add_image_size('single-thumbnail', 	825, 428, true);
		add_image_size('listing-thumbnail', 456, 256, true);
		add_image_size('default-thumbnail', 333, 198, true);
		add_image_size('sidebar-thumbnail', 63, 63, true);
		add_image_size('profile-thumbnail', 291, 286, true);
		add_image_size('writer-thumbnail', 224, 224, true);

		set_post_thumbnail_size(1200, 9999);

		$GLOBALS['content_width'] = 900;

		add_theme_support('html5', array('comment-form', 'comment-list', 'script', 'style'));

		$allowed_roles = array('administrator', 'editor', 'author');
		if (!count(array_intersect($allowed_roles, wp_get_current_user()->roles))) {
			show_admin_bar(false);
		} else {
			show_admin_bar(true);
		}
	}
}

//---------------------------------------------Theme Menu
add_action('init', 'register_my_menus');
function register_my_menus()
{
	register_nav_menus(array(
		'header-menu'		=> 'Header Menu',
		'company-menu'		=> 'Company Menu',
		'categories-menu'		=> 'Categories Menu'
	));
}



//Image Function
add_action('wp_footer', 'img');
function img()
{
?><script>
		jQuery(document).ready(function($) {
			$("img").not('.author-page-author-card-img-sec-figure img, .about-teem-card-figure img').removeAttr("srcset");
			$("img").not('.author-page-author-card-img-sec-figure img, .about-teem-card-figure img').each((index, img) => {
				img.src = img.src.replace("http://localhost/smallbusinessjournals/wp-content/uploads/", "https://www.smallbusinessjournals.com/wp-content/uploads/");
				img.src = img.src.replace("http://localhost/projects/smallbusinessjournals/wp-content/uploads/", "https://www.smallbusinessjournals.com/wp-content/uploads/");
				img.src = img.src.replace("https://www.viaconprojects.com/smallbusinessjournals/wp-content/uploads/", "https://www.smallbusinessjournals.com/wp-content/uploads/");
			});
		});
	</script>
<?php
}





//Custom Comment Form
add_filter('comment_form_fields', 'custom_comment_form_fields');
function custom_comment_form_fields($fields)
{
	unset($fields['author']);
	unset($fields['email']);
	unset($fields['url']);
	unset($fields['comment']);
	unset($fields['cookies']);

	$fields['email-wrapper-open']	= '<div class=" comment-f-s-name-email-wrapper">';
	$fields['author']	= '<div class="comment-from-common-mb-for-email-name-sec"><input type="text" class="comment-from-common-input" id="author" name="author" placeholder="Enter your Name" required><span class="focus-border"></span></div>';
	$fields['email']	= '<div class="comment-from-common-mb-for-email-name-sec"><input type="email" class="comment-from-common-input" id="email" name="email" placeholder="Enter your E-mail" required><span class="focus-border"></span></div>';
	$fields['email-wrapper-close']	= '</div>';
	$fields['url']		= '<div class="comment-from-common-mb"><input type="url" class="comment-from-common-input" id="url" name="url" placeholder="website"><span class="focus-border"></span></div>';
	$fields['comment']	= '<div class="comment-from-common-text-aria-mb"><textarea class="comment-from-common-textarea" id="comment" name="comment" placeholder="Comment" cols="50" rows="8" required></textarea><span class="focus-border"></span></div>';
	$fields['cookies']	= '<div class="comment-from-check-box-sec"><div class="comment-from-check-box-wrapper"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"><label for="cb1"></label></div><div class="comment-from-check-box-sec-content"><p>Save my name, email, and website in this browser for the next time I comment.</p></div></div>';
	return $fields;
}


function custom_comment_form_defaults($defaults)
{
	$defaults['class_form']				= 'comment-from';
	$defaults['title_reply']			= 'Leave A Comment';
	$defaults['title_reply_before']		= '<h2 class="comment-from-title">';
	$defaults['title_reply_after']		= '</h2>';
	$defaults['submit_button']			= '<button type="submit" class="comment-from-comment-button">Post Comment<span class="icon-arrow"></span></button>';
	$defaults['submit_field']			= '<div class="comment-from-comment-button-wrapper">%1$s %2$s</div>';

	return $defaults;
}
add_filter('comment_form_defaults', 'custom_comment_form_defaults');


//Code for HSTS
function wps_enable_strict_transport_security_hsts_header_wordpress() { 
    header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' ); 
}
add_action('send_headers','wps_enable_strict_transport_security_hsts_header_wordpress' );


add_filter('wpseo_opengraph_url', 'custom_opengraph_url');
function custom_opengraph_url($url) {
    
	$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if (strpos($current_url, '/page/') !== false) {
		return $current_url;
	} else {
    	return $url; // Return the original URL for other pages
	}
}


