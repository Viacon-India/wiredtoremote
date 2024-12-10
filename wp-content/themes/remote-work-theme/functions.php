<?php
session_start();
//---------------------------------------------Custom Theme Settings Path
if (file_exists(get_template_directory() . '/required/custom-plugins.php')) {
	require_once(get_template_directory() . '/required/custom-plugins.php');
}
if (file_exists(get_template_directory() . '/required/custom-ajax.php')) {
	require_once(get_template_directory() . '/required/custom-ajax.php');
}
if (file_exists(get_template_directory() . '/required/custom-ajax-functions.php')) {
	require_once(get_template_directory() . '/required/custom-ajax-functions.php');
}



//---------------------------------------------Enqueue Script and Style
add_action('wp_enqueue_scripts', 'my_plugin_assets');
function my_plugin_assets()
{
	$ver = '1.3.7';
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

		add_image_size('single-thumbnail', 702, 428, true);
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



//---------------------------------------------Check and Call Logo
function logo_url()
{
	$logo_url = get_stylesheet_directory_uri() . '/images/SBJ-logo.svg';
	if (has_custom_logo()) {
		$custom_logo_id = get_theme_mod('custom_logo');
		$custom_logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
		$custom_logo_url = $custom_logo_data[0];
		return esc_url($custom_logo_url);
	} elseif (is_file(realpath($_SERVER["DOCUMENT_ROOT"]) . parse_url($logo_url)['path'])) {
		$header_img_url = $logo_url;
		return $header_img_url;
	} else {
		return false;
	}
}



//---------------------------------------------Footer Logo
function footer_logo($wp_customize)
{
	$wp_customize->add_setting('footer_logo');
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
		'label'    => __('Footer Logo', 'Dream_Land_Estate'),
		'section'  => 'title_tagline',
		'settings' => 'footer_logo',
		'priority'       => 8
	)));
}
add_action('customize_register', 'footer_logo');



//---------------------------------------------Check and Call Footer Logo
function footer_logo_url()
{
	$footer_logo_url = get_theme_mod('footer_logo');
	if ($footer_logo_url) {
		return $footer_logo_url;
	} else {
		$footer_logo_url = get_stylesheet_directory_uri() . '/images/footer-logo.svg';
		if (is_file(realpath($_SERVER["DOCUMENT_ROOT"]) . parse_url($footer_logo_url)['path'])) {
			return $footer_logo_url;
		} else {
			logo_url();
		}
	}
}



//---------------------------------------------Check and Add Favicon
function add_favicon()
{
	if (!has_site_icon()  && !is_customize_preview()) {
		$favicon_url = get_stylesheet_directory_uri() . '/images/favicon.png';
		echo '<link rel="icon" type="image/gif" href="' . $favicon_url . '" />';
	} else {
		echo '<link rel="icon" type="image/gif" href="' . wp_get_attachment_image_url(get_option('site_icon'), 'full') . '">';
	}
}
add_action('wp_head', 'add_favicon');
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');
// add_action('web_stories_story_head', 'add_favicon');



//---------------------------------------------Theme Menu
add_action('init', 'register_my_menus');
function register_my_menus()
{
	register_nav_menus(array(
		'header-menu'		=> 'Header Menu',
		'useful-menu'		=> 'Useful Menu',
		'footer-menu'		=> 'Footer Menu'
	));
}



//---------------------------------------------Image Function
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


//---------------------------------------------Custom Comment Form
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


////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

add_action('wp_ajax_tech_contact_process', 'ajax_tech_contact_process');
add_action('wp_ajax_nopriv_tech_contact_process', 'ajax_tech_contact_process');
function ajax_tech_contact_process() {
    $response_arr = ['flag' => FALSE, 'msg' => NULL];
    
    $user_name = $_POST['u_name'];
    $user_email = $_POST['u_email'];
    $subject = $_POST['u_subject'];
    $u_mnessage = $_POST['u_message'];
    
    if(empty($user_name)) {
        $response_arr['msg'] = 'Enter your name.';
    } elseif(empty($user_email)) {
        $response_arr['msg'] = 'Enter your email address.';
    } elseif(empty($subject)) {
        $response_arr['msg'] = 'Enter subject.';
    } elseif(empty($u_mnessage)) {
        $response_arr['msg'] = 'Enter your message.';
    } else {

		echo "Submited";
        
        // $to = 'mashum.webmaster@gmail.com';
        // $to = 'viacon.sharmita@gmail.com';
        // $body = '<table class="mail-table" style="border: 1px solid #0a9e01; padding:20px; width: 100%;">
        //             <h4 style="border-bottom: 2px solid #ccc; padding-bottom: 10px; width: 50%;">This e-mail was sent from a contact form on Techtrendspro.</h4>
        //             <tr>
        //                 <td>Name: ' .$user_name .'</td>
        //             </tr>
        //             <tr>
        //                 <td>Email: '. $user_email .'</td>
        //             </tr>
        //             <tr>
        //                 <td>Subject: ' . $subject. '</td>
        //             </tr>
        //             <tr>
        //                 <td>Message: ' . $u_mnessage .'</td>
        //             </tr>
        //         </table>';
        // $headers = array('Content-Type: text/html; charset=UTF-8', 'Reply-To: ' .$user_name .' <' . $user_email. '>');
        // wp_mail( $to, 'Tech Trends Pro Conatct Form' , $body, $headers );
        
        $response_arr['msg'] = 'Thank you for your message. It has been sent.';
        $response_arr['flag'] = true;
    }
    
    
    echo json_encode($response_arr);
    exit;
}
