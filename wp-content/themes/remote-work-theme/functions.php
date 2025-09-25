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
	$ver = '1.4.1';

	if(is_page('test')) {
		wp_enqueue_script('3', 'https://code.jquery.com/jquery-3.6.0.min.js', array('jquery.min'), $ver, true);
		wp_enqueue_script('1', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', array('jquery'), $ver, true);
		wp_enqueue_script('2', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js', array('jquery'), $ver, true);

	} 

	wp_enqueue_script('jquery.min', get_template_directory_uri() . '/js/jquery-3.7.1.min.js', array('jquery'), $ver, true);
	wp_enqueue_script('owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), $ver, true);
	wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/ThemeScript.js', array('jquery'), $ver, true);
	wp_enqueue_script('swiper-bundle.js.min', get_template_directory_uri() . '/js/swiper-bundle.min.js', array('jquery'), $ver, true);

	wp_enqueue_style('owl.carousel.min', get_template_directory_uri() . '/css/owl.carousel.min.css', $ver, 'all');
	wp_enqueue_style('swiper-bundle.css.min', get_template_directory_uri() . '/css/swiper-bundle.min.css', $ver, 'all');
	wp_enqueue_style('style', get_stylesheet_uri(), $ver, 'all');

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
	$defaults['title_reply_before']		= '<h3 class="comment-from-title">';
	$defaults['title_reply_after']		= '</h3>';
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


////************* Function code for block editro link hover design **********///////

function wrap_paragraphs_with_link_class($content) {
    return preg_replace_callback('/<p>(.*?)<\/p>/is', function($matches) {
        $paragraph = $matches[1];

        // If the paragraph contains a link but doesn't already have the class
        if (strpos($paragraph, '<a') !== false && strpos($matches[0], 'class="link-hover-bg"') === false) {
            return '<p class="link-hover-bg">' . $paragraph . '</p>';
        }

        return $matches[0]; // Return unchanged if no link or already has class
    }, $content);
}
add_filter('the_content', 'wrap_paragraphs_with_link_class', 20);

////**************************************** calculator Shortcode ****************************************/////
// Register Gratuity Calculator Shortcode
function gratuity_calculator_shortcode() {
    ob_start(); ?>
    
     <style>
        .gratuity-wrapper {
          font-family: Arial, sans-serif;
          padding: 40px 20px;
          background: #f5f7fb;
          display: flex;
          justify-content: center;
        }
        .gratuity-container {
          display: flex;
          flex-direction: column;
          gap: 25px;
          max-width: 650px;
          width: 100%;
        }
        .gratuity-box {
          background: #fff;
          padding: 28px;
          border-radius: 14px;
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08), 
                      0 4px 10px rgba(0, 0, 0, 0.05);
          transition: all 0.3s ease;
        }
        .gratuity-box:hover {
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12), 
                      0 6px 14px rgba(0, 0, 0, 0.08);
          transform: translateY(-3px);
        }
        .gratuity-box h2, 
        .gratuity-box h3 {
          margin-bottom: 22px;
          font-size: 22px;
          color: #1e2a38;
        }
        .gratuity-box label {
          display: block;
          margin-bottom: 8px;
          font-weight: 500;
          font-size: 14px;
          color: #444;
        }
        .gratuity-input-group {
          display: flex;
          align-items: center;
          margin-bottom: 20px;
        }
        .gratuity-input-group span {
          background: #f1f3f6;
          padding: 10px 12px;
          border: 1px solid #ccc;
          border-radius: 8px 0 0 8px;
          border-right: none;
          font-size: 15px;
          color: #444;
        }
        .gratuity-input-group input {
          flex: 1;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 0 8px 8px 0;
          font-size: 15px;
        }
        .gratuity-slider {
          margin: 15px 0;
        }
        .gratuity-slider input[type="range"] {
          width: 100%;
          cursor: pointer;
          accent-color: #007BFF;
        }
        .years-control {
          display: flex;
          align-items: center;
          gap: 10px;
          margin-top: 10px;
        }
        .years-control input {
          width: 70px;
          padding: 8px;
          border: 1px solid #ccc;
          border-radius: 6px;
          text-align: center;
          font-size: 15px;
        }
        .years-control span {
          font-size: 14px;
          color: #333;
        }
        .gratuity-result {
          text-align: center;
          background: linear-gradient(145deg, #f9fbff, #f0f3f9);
        }
        .gratuity-result h3 {
          margin-bottom: 10px;
          font-size: 18px;
          color: #444;
        }
        .gratuity-result .amount {
          font-size: 32px;
          font-weight: bold;
          color: #000080;
        }
    </style>
    
    <div class="gratuity-wrapper">
      <div class="gratuity-container">
        
        <!-- Input Box -->
        <div class="gratuity-box">
          <h2 style="color:#000080"><strong>Gratuity Calculator</strong></h2>
          
          <label>Salary (Basic Pay + D.A)</label>
          <div class="gratuity-input-group">
            <span>₹</span>
            <input type="number" id="salary" value="10000" placeholder="Enter Your Amount">
          </div>
          
          <label>No. of Years Of Service (Min: 5 Years)</label>
          <div class="gratuity-slider">
            <input type="range" id="yearsRange" min="5" max="40" value="5" oninput="syncYearsFromSlider(this.value)">
          </div>
          <div class="years-control">
            <input type="number" id="yearsInput" min="5" max="40" value="5" oninput="syncYearsFromInput(this.value)">
            <span>Years</span>
          </div>
        </div>
        
        <!-- Result Box -->
        <div class="gratuity-box gratuity-result">
          <h3>Total Gratuity Payable To You</h3>
          <div class="amount" id="result">₹ 0</div>
        </div>
        
      </div>
    </div>
    
    <script>
      function syncYearsFromSlider(val) {
        document.getElementById('yearsInput').value = val;
        calculateGratuity();
      }

      function syncYearsFromInput(val) {
        if(val < 5) val = 5;
        if(val > 40) val = 40;
        document.getElementById('yearsInput').value = val;
        document.getElementById('yearsRange').value = val;
        calculateGratuity();
      }

      function calculateGratuity() {
        let salary = parseFloat(document.getElementById('salary').value);
        let years = parseInt(document.getElementById('yearsInput').value);

        if (isNaN(salary) || salary <= 0 || isNaN(years) || years < 5) {
          document.getElementById('result').innerText = "₹ 0";
          return;
        }

        let gratuity = (salary * 15 / 26) * years;
        document.getElementById('result').innerText = "₹ " + gratuity.toLocaleString();
      }

      // Init
      document.addEventListener("DOMContentLoaded", calculateGratuity);
      document.getElementById('salary').addEventListener("input", calculateGratuity);
    </script>
    
    <?php
    return ob_get_clean();
}
add_shortcode('gratuity_calculator', 'gratuity_calculator_shortcode');
