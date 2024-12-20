<?php
/* Set post views count using post meta */
add_filter('pre_get_posts','SearchFilter');
if (!function_exists('SearchFilter')) {
    function SearchFilter($query) {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
        return $query;
    }
}


//Check and Call Logo
if (!function_exists('logo_url')) {
    function logo_url() {
        $logo_url = get_stylesheet_directory_uri() . '/images/remote-logo.svg';
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
}



//Footer Logo
if (!function_exists('footer_logo')) {
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
}
add_action('customize_register', 'footer_logo');


//---------------------------------------------Check and Call Footer Logo
if (!function_exists('footer_logo_url')) {
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
}

add_action('wp_head', 'add_favicon');
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');
if (!function_exists('add_favicon')) {
    function add_favicon(){
        if (!has_site_icon()  && !is_customize_preview()) {
            $favicon_url = get_stylesheet_directory_uri() . '/images/favicon.png';
            echo '<link rel="icon" type="image/gif" href="' . $favicon_url . '" />';
        } else {
            echo '<link rel="icon" type="image/gif" href="' . wp_get_attachment_image_url(get_option('site_icon'), 'full') . '">';
        }
    }
}


if (!function_exists('customSetPostViews')) {
    function customSetPostViews($postID) {
        $countKey = 'post_views_count';
        $count = get_post_meta($postID, $countKey, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $countKey);
            add_post_meta($postID, $countKey, '1');
        }else{
            $count++;
            update_post_meta($postID, $countKey, $count);
        }
    }
}