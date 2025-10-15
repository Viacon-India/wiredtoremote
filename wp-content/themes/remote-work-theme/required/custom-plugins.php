<?php 
//---------------------------------------------Menu
add_action('admin_menu', 'theme_menu');
function theme_menu(){
	add_menu_page( "Theme Menu", "Theme Settings", 'manage_options', 'theme_menu', 'theme_menu_callback','', 7);
}
  
function theme_menu_callback(){
	echo '<div class="wrap">';
		echo '<h1>Theme Settings</h1>';
		echo '<form method="post" action="options.php" novalidate="novalidate">';
			settings_fields('theme_menu');
			echo '<table class="form-table" role="presentation">';
				do_settings_sections( 'theme_menu', 'default' );
				do_settings_fields('theme_menu','default');
			echo '</table>';
			submit_button();

			echo '<button type="button" class="button" onclick="'."document.getElementById('form-structure').style.display = 'block'".'">Show Contact form Structure</button>';
			echo '<div id="form-structure" style="display: none;padding-top: 20px;">
				<textarea rows="12" style="width: 100%;color: black;" type="text" disabled>
[text* your-name placeholder "Enter your Name"]
[email* your-email placeholder "Enter your E-mail"]

[text* your-subject placeholder "Subject"]

[textarea your-message 50x5 placeholder "Your message"]

[submit "get in touch"]</textarea>
			</div>';

		echo '</form>';
	echo '</div>';
}



//---------------------------------------------Menu Section and Field
add_action('admin_init', 'theme_settings');
function theme_settings() {  
	add_settings_section( 'categories', 'Categories', '', 'theme_menu' );
	add_settings_section( 'footer_settings', 'Footer Settings', '', 'theme_menu' );

	add_settings_field('footer_text', 'Footer Text', 'footer_text_callback', 'theme_menu', 'footer_settings','footer_text');
	register_setting('theme_menu','footer_text', 'esc_attr');

	add_settings_field('subscription_text', 'Subscription Content', 'footer_text_callback', 'theme_menu', 'footer_settings','subscription_text');
	register_setting('theme_menu','subscription_text', 'esc_attr');
	
	$socials = array('facebook','linkedin');
	foreach($socials as $social){
		add_settings_field($social, ucwords(str_replace('_',' ',$social)).' Link', 'social_content_callback', 'theme_menu', 'footer_settings',$social);
		register_setting('theme_menu',$social, 'esc_attr');
	}

	$categories = array('category_1','category_2','category_3','category_4');
	foreach($categories as $category){
		add_settings_field($category, ucwords(str_replace('_',' ',$category)), 'category_callback', 'theme_menu', 'categories',$category);
		register_setting('theme_menu',$category, 'esc_attr');
	}

	$articles = array('start_article_id','grow_article_id','exit_article_id');
	foreach($articles as $article){
		add_settings_field($article, ucwords(str_replace('_',' ',$article)), 'category_callback', 'theme_menu', 'categories',$article);
		register_setting('theme_menu',$article, 'esc_attr');
	}
}

function social_content_callback($args) {
	$option = get_option($args);
	echo '<input type="url" size="100" name="'. $args .'" value="' . $option . '" />';
}

function category_callback($args) {
	$option = get_option($args);
	echo '<input type="text" name="'.$args.'" value="'.$option.'" />';
}

function footer_text_callback($args) {
	$footer_text = get_option($args);
	echo '<textarea rows="4" cols="103" type="text" name="'. $args .'" id="'. $args .'">' . $footer_text . '</textarea>';
}



//---------------------------------------------Add Post Views Function
function set_post_views($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function track_post_views ($post_id) {
	if ( !is_single() ) return;
	if ( empty ( $post_id) ) {
		global $post;
		$post_id = $post->ID;    
	}
	set_post_views($post_id);
}
add_action( 'wp_head', 'track_post_views');



//---------------------------------------------Add Custom Field in Category Section
function svg_category_fields($term) {
    if (current_filter() == 'category_edit_form_fields') {	
        $svg = get_term_meta( $term->term_id, 'term_svg', true ); 	
        ?><tr class="form-field">
            <th valign="top" scope="row"><label for="svg"><?php _e('Image URL'); ?></label></th>
            <td>
				<input type="text" name="svg" value="<?php echo esc_attr( $svg ) ? esc_attr( $svg ) : ''; ?>">
                <span class="description"><?php _e('Please enter your image URL'); ?></span>
            </td>
        </tr><?php
	}elseif (current_filter() == 'category_add_form_fields') {
        ?><div class="form-field">
            <label for="svg"><?php _e('Image URL'); ?></label>
            <input type="text" size="40" value=""  name="svg">
            <p class="description"><?php _e('Please enter your Image URL'); ?></p>
        </div><?php
    }
}
add_action('category_edit_form_fields', 'svg_category_fields', 10, 2);
add_action('category_add_form_fields', 'svg_category_fields', 10, 2);
function svg_save_category_fields($term_id) {
    if ( isset( $_POST['svg'] ) ) {
        $term_svg = $_POST['svg'];
        update_term_meta( $term_id, 'term_svg', $term_svg );

    } 	
}
add_action('edited_category', 'svg_save_category_fields', 10, 2);
add_action('create_category', 'svg_save_category_fields', 10, 2);
function svg_header( $defaults ){
	$defaults['svg']  = __('SVG', 'category-featured-image' );
	return $defaults;
}


function svg_content_category( $columns, $column, $termID ){
	if ( 'svg' === $column ) {
		$imageID = get_term_meta( $termID, 'term_svg', true );
		if ( $imageID ) {
			$image = '<div style="background-color: grey; padding:5px;">'.$imageID.'</div>';
			return $image;
		}
	}
	return $columns;
}
add_filter('manage_edit-category_columns', 'svg_header' );
add_filter('manage_category_custom_column', 'svg_content_category', 10, 3 );
if(!function_exists('category_svg'))
{
	function category_svg( $termID){
		$svg_code = get_term_meta( $termID, 'term_svg', true );
		return $svg_code;
	}
}



//-------------------------------------------------------------------Idea Taxonomy
// add_action('init', function() {
// 	register_taxonomy('idea', 'post', array('label'				=> __('Ideas'),
// 												'hierarchical'		=> true,
// 												'rewrite'			=> array('slug'			=> 'idea',
// 																			'with_front'	=> false,
// 																			'hierarchical'	=> true	),
// 												'show_admin_column'	=> true,
// 												'show_in_rest'		=> true,
// 												'labels'			=> array('singular_name'				=> __('Idea'),
// 																			'all_items'						=> __('All Ideas'),
// 																			'parent_item_colon'				=> __('Parent Idea'),
// 																			'edit_item'						=> __('Edit Idea'),
// 																			'view_item'						=> __('View Idea'),
// 																			'update_item'					=> __('Update Idea'),
// 																			'add_new_item'					=> __('Add New Idea'),
// 																			'new_item_name'					=> __('New Idea Name'),
// 																			'search_items'					=> __('Search Ideas'),
// 																			'popular_items'					=> __('Popular Ideas'),
// 																			'separate_items_with_commas'	=> __('Separate Ideas with comma'),
// 																			'choose_from_most_used'			=> __('Choose from most used Ideas'),
// 																			'not_found'						=> __('No Ideas found'))));
// });
// register_taxonomy_for_object_type('idea', 'post');



//-------------------------------------------------------------------Taxonomy Meta Field
function add_taxonomy_meta_data( $taxonomy ) {
	wp_nonce_field( 'meta_box', 'meta_box_nonce' ); ?>
	<div class="form-field term-tax-image-wrap">
		<label for="tax_image_id">Image</label>
		<div>
			<div style="display: flex;">
				<div style="line-height: 60px; margin-right: 10px;">
					<input type="hidden" id="tax_image_id" name="tax_image_id" value="" />
					<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add Image', 'taxonomy-featured-image' ); ?></button>
					<button type="button" class="remove_image_button button" style="display: none;"><?php _e( 'Remove Image', 'taxonomy-featured-image' ); ?></button>
				</div>
				<div id="tax_image" style="float: left; display: none;"><img src="" width="60px" height="60px" alt="Image"/></div>
			</div>
			<script>
				jQuery(document).ready( function($){
					var file_frame;
					$( 'body' ).on( 'click', '.upload_image_button', function( event ) {
						event.preventDefault();
						if ( file_frame ) {
							file_frame.open();
							return;
						}
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( 'Choose An Image', 'taxonomy-featured-image' ); ?>',
							button: {
								text: '<?php _e( 'Use This Image', 'taxonomy-featured-image' ); ?>'
							},
							multiple: false
						});
						file_frame.on( 'select', function() {
							var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;
							$( '#tax_image_id').val( attachment.id );
							$( '#tax_image' ).show().find( 'img' ).attr( 'src', attachment_thumbnail.url );
							$( '.remove_image_button' ).show();
							$( '.upload_image_button' ).hide();
						});
						file_frame.open();
					});

					$( 'body' ).on( 'click', '.remove_image_button', function() {
						$( '#tax_image').hide().find( 'img' ).attr( 'src', '' );
						$( '#tax_image_id' ).val( '' );
						$( '.remove_image_button' ).hide();
						$( '.upload_image_button' ).show();
						return false;
					});
				});
			</script>
			<div style="clear:both;"></div>
		</div>
	</div><?php
}
add_action( 'idea_add_form_fields', 'add_taxonomy_meta_data', 10, 2 );
function edit_taxonomy_meta_data( $term, $taxonomy ) {
	$thumbnail_id = get_term_meta( $term->term_id, 'tax_image_id', true );
	$image = ($thumbnail_id)?wp_get_attachment_image_url( $thumbnail_id, 'full' ):''; ?>	
	<tr class="form-field">
		<th scope="row" valign="top"><label>Image</label></th>
		<td>
			<div style="display: flex;">
				<div style="line-height: 60px; margin-right: 10px;">
					<input type="hidden" id="tax_image_id" name="tax_image_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="upload_image_button button" <?php echo (!empty($image))?'style="display: none;"':''; ?>><?php _e( 'Upload/Add Image', 'taxonomy-featured-image' ); ?></button>
					<button type="button" class="remove_image_button button" <?php echo (empty($image))?'style="display: none;"':''; ?>><?php _e( 'Remove Image', 'taxonomy-featured-image' ); ?></button>
				</div>
				<div id="tax_image" style="float: left; <?php echo (empty($image))?'display: none;':''; ?>"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" alt="Image"/></div>
			</div>
			<script>
				jQuery(document).ready( function($){
					var file_frame;
					$( 'body' ).on( 'click', '.upload_image_button', function( event ) {
						event.preventDefault();
						if ( file_frame ) {
							file_frame.open();
							return;
						}
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( 'Choose An Image', 'taxonomy-featured-image' ); ?>',
							button: {
								text: '<?php _e( 'Use This Image', 'taxonomy-featured-image' ); ?>'
							},
							multiple: false
						});
						file_frame.on( 'select', function() {
							var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;
							$( '#tax_image_id' ).val( attachment.id );
							$( '#tax_image' ).show().find( 'img' ).attr( 'src', attachment_thumbnail.url );
							$( '.remove_image_button' ).show();
							$( '.upload_image_button' ).hide();
						});
						file_frame.open();
					});

					$( 'body' ).on( 'click', '.remove_image_button', function() {
						$( '#tax_image' ).hide().find( 'img' ).attr( 'src', '' );
						$( '#tax_image_id' ).val( '' );
						$( '.remove_image_button' ).hide();
						$( '.upload_image_button' ).show();
						return false;
					});
				});
			</script>
			<div style="clear:both;"></div>
		</td>
	</tr><?php
}
add_action( 'idea_edit_form_fields', 'edit_taxonomy_meta_data', 10, 2);
function save_taxonomy_meta_data( $term_id ) {
	$image = (isset($_POST['tax_image_id'])?$_POST['tax_image_id']:'');
	update_term_meta( $term_id, 'tax_image_id', $image);
}
add_action( 'created_idea', 'save_taxonomy_meta_data', 10, 1);
add_action( 'edited_idea', 'save_taxonomy_meta_data' );



//-------------------------------------------------------------------Post Meta Field
function custom_add_meta_boxes() {
	global $post;
	add_meta_box( 'fast-facts', 'Fast Facts', 'fast_facts_callback', 'post', 'side', 'high' );
	// add_meta_box('pros_cons_metabox', 'Affiliate Fields', 'pros_cons_callback', '', 'normal', 'high');
	$articles = array(get_option('start_article_id'),get_option('grow_article_id'),get_option('exit_article_id'));
	if(in_array($post->ID, $articles)){
		add_meta_box('custom_tips_metabox', 'Tips', 'custom_tips_callback', '', 'normal', 'high');
	}
}
add_action( 'add_meta_boxes_post', 'custom_add_meta_boxes' );
function fast_facts_callback($post){
    $fast_facts = get_post_meta($post->ID, "fast-facts", true);
	echo '<div id="fast_facts_forum" style="margin-bottom: 4px;">';
		if(is_array($fast_facts) && !empty($fast_facts)){
			$fast_facts = array_values($fast_facts);
			foreach($fast_facts as $key => $question){
				echo '<div>';
					echo '<h3>Fast Fact '.($key+1).'</h3>';
					echo '<input type="text" class="widefat" name="fast-facts['.$key.'][key]" placeholder="Key" value="'.$fast_facts[$key]['key'].'" style="margin-bottom: 4px;">';
					echo '<input type="text" class="widefat" name="fast-facts['.$key.'][value]" placeholder="Value" value="'.$fast_facts[$key]['value'].'" style="margin-bottom: 4px;">';
					echo '<input type="button" class="button fast-facts-remove-row" value="Remove">';	
				echo '</div>';	
			}
			$next_key = array_key_last($fast_facts)+1;
		}else{
			$next_key = 0;
		}
	echo '</div>';
	echo '<input type="button" class="button fast-facts-add-row" value="Add">';
	?><script>
		jQuery(document).ready(function( $ ){
			var index = '<?php echo ($next_key); ?>';
			var index = parseInt(index);
			var question = index + 1;
			$('body').on('click', '.fast-facts-add-row', function(){
				$('#fast_facts_forum').append('<div><h3>Fast Fact '+question+'</h3><input type="text" class="widefat" name="fast-facts['+index+'][key]" placeholder="Key" style="margin-bottom: 4px;"><input type="text" class="widefat" name="fast-facts['+index+'][value]" placeholder="Value" style="margin-bottom: 4px;"><input type="button" class="button fast-facts-remove-row" value="Remove"></div>');
				index = index + 1;
				question = question + 1;
			});
			$('body').on('click', '.fast-facts-remove-row', function(){
				$(this).parent().remove();
			});
		});
	</script><?php
}
function pros_cons_callback() {
    global $post;
	?><p>Use Shortcode: [pros-cons]</p>
	<div style="padding-bottom: 20px; display: flex; gap: 1rem;">
		<div style="width: 50%;">
			<h3 style="margin-bottom: 5px;">Pros</h3>
			<?php wp_editor( get_post_meta( $post->ID, 'pros', true ), 'pros', array( 'wpautop' => false, 'media_buttons' =>  true, 'textarea_rows' => 10 ) ); ?>
		</div>
		<div style="width: 50%;">
			<h3 style="margin-bottom: 5px;">Cons</h3>
			<?php wp_editor( get_post_meta( $post->ID, 'cons', true ), 'cons', array( 'wpautop' => false, 'media_buttons' =>  true, 'textarea_rows' => 10 ) ); ?>
		</div>
	</div><?php
}
function custom_tips_callback() {
    global $post;
	$tips = get_post_meta($post->ID, "tips", true);
	echo '<div id="tip_forum" style="margin-bottom: 5px;">';
		if(is_array($tips) && !empty($tips)){
			$tips = array_values($tips);
			foreach($tips as $i => $tip) :
				echo '<div style="padding-bottom: 20px;" class="tips">';
					echo '<h3 style="margin-bottom: 5px;">Tip '.($i+1).'</h3>';
					echo '<input type="text" style="width: 100%;margin-bottom: 5px;" name="tips['.$i.'][title]" placeholder="Card Title" value="'.$tips[$i]['title'].'" />';
					wp_editor( $tips[$i]['content'], 'tips['.$i.'][content]', array('wpautop' => false, 'media_buttons' =>  true, 'textarea_rows' => 5 ));
					echo '<input type="button" style="margin-top: 5px;" class="button remove-row" value="Remove Tip '.($i+1).'">';
				echo '</div>';
			endforeach;
			$next_key = array_key_last($tips)+1;
		}else{
			$next_key = 0;
		}
	echo '</div>';
	echo '<input type="button" class="button add-row" value="Add Tip '.($next_key+1).'">';
	?><script>
		jQuery(document).ready(function( $ ){
			var index = '<?php echo ($next_key); ?>';
			var index = parseInt(index);
			var tip = index + 1;
			$('body').on('click', '.add-row', function(){
				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: { action: 'add_tip', index: index},
					success: function(data) {
						$('#tip_forum').append(data);
						$('.add-row').val('Add Tip '+tip)
					}
				});
				index = index + 1;
				tip = tip + 1;
			});
			$('body').on('click', '.remove-row', function(){
				$(this).parent().remove();
			});
		});
	</script><?php
}
add_action( 'save_post', 'custom_subtitle_save_meta' );
add_action( 'publish_post', 'custom_subtitle_save_meta' );
add_action( 'draft_post', 'custom_subtitle_save_meta' );
add_action( 'future_post', 'custom_subtitle_save_meta' );
add_action( 'pre_post_update', 'custom_subtitle_save_meta' );
function custom_subtitle_save_meta( $post_id ) {
	if( isset( $_POST['pros'] ) ) {
		update_post_meta($post_id, 'pros', $_POST['pros']);
	}else{
		update_post_meta($post_id, 'pros', '');
	}
	if( isset( $_POST['cons'] ) ) {
		update_post_meta($post_id, 'cons', $_POST['cons']);
	}else{
		update_post_meta($post_id, 'cons', '');
	}
	if( isset( $_POST['tips'] ) ) {
		update_post_meta($post_id, 'tips', $_POST['tips']);
	}else{
		update_post_meta($post_id, 'tips', array());
	}
	if( isset( $_POST['fast-facts'] ) ) {
		update_post_meta($post_id, 'fast-facts', $_POST['fast-facts']);
	}else{
		update_post_meta($post_id, 'fast-facts', array());
	}
}
add_shortcode('pros-cons', 'pros_cons_shortcode');
function pros_cons_shortcode(){
	global $post;
	$pros = get_post_meta( $post->ID, 'pros', true );
	$cons = get_post_meta( $post->ID, 'cons', true );

	if(!empty($pros) || !empty($cons)){
		$pros_cons = '<div class="pros-and-cons">';
		if(!empty($pros)) $pros_cons .= '<div class="pros"><h4>Pros</h4>'.$pros.'</div>';
		if(!empty($cons)) $pros_cons .= '<div class="cons"><h4>Cons</h4>'.$cons.'</div>';
		$pros_cons .= '</div>';
		return $pros_cons;
	}
}



//-------------------------------------------------------------------Add User Meta
add_filter( 'user_contactmethods', 'user_custom_meta' );
function user_custom_meta( $user_custom_meta ) {
	$custom_meta_fields = array('designation', 'facebook', 'twitter', 'linkedin', 'instagram');
	foreach($custom_meta_fields as $meta_field){
		$user_custom_meta[$meta_field]   = ucwords(str_replace('_',' ',$meta_field));
	}
	return $user_custom_meta;
}
add_action( 'show_user_profile', 'add_custom_writer_checkbox_callback' );
add_action( 'edit_user_profile', 'add_custom_writer_checkbox_callback' );
function add_custom_writer_checkbox_callback( $user ) {
    $user_id = $user->data->ID;
    $checked = get_user_meta( $user_id, 'writer_status', true );
	$author_image_id = get_user_meta($user_id,'user_profile_img_id', true);
	$author_image_url = (!empty($author_image_id))?wp_get_attachment_image_url($author_image_id,'full'):'';
	echo '<h3>Extra Profile Information</h3><table class="form-table">';
		echo '<tr><th><label for="Writer">Writer Status</label></th><td><input type="checkbox" name="writer_status" value="checked" ' . $checked . '></td></tr>';
		echo '<tr><th><label for="custom-image">Custom Profile Image</label></th><td>';
			echo '<img id="profile-pic" src="'.$author_image_url.'" />';
			echo '<input type="hidden" id="user-profile-img-id" name="user_profile_img_id" value="" />';
			echo '<button type="button" class="upload_image_button button">Add/Replace image</button>';
			if(!empty($author_image_id)) echo '<button type="button" class="remove_image_button button">Remove image</button>';
		echo '</td></tr>';
	echo '</table>';				
	?><script type="text/javascript">
		jQuery(document).ready( function($){
			var file_frame;
			$( 'body' ).on( 'click', '.upload_image_button', function( event ) {
				event.preventDefault();
				if ( file_frame ) {
					file_frame.open();
					return;
				}
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: 'Choose a Profile Image',
					button: {
						text: 'Use as Profile Image'
					},
					multiple: false
				});
				file_frame.on( 'select', function() {
					var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.full;
					$( '#user-profile-img-id' ).val( attachment.id );
					$( '#profile-pic' ).attr( 'src', attachment_thumbnail.url );
				});
				file_frame.open();
			});

			$( 'body' ).on( 'click', '.remove_image_button', function() {
				$( '#profile-pic' ).attr( 'src', '' ).hide();
				$( '#user-profile-img-id' ).val( '' );
				$( '.remove_image_button' ).hide();
				return false;
			});
		});
	</script><?php
}

add_action( 'personal_options_update', 'save_custom_writer_checkbox_callback' );
add_action( 'edit_user_profile_update', 'save_custom_writer_checkbox_callback' );
function save_custom_writer_checkbox_callback( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    $writer_status = ( isset( $_POST['writer_status'] ) ) ? 'checked' : '';
    update_user_meta( $user_id, 'writer_status', $writer_status );

	$new_author_image_id = ( isset( $_POST['user_profile_img_id'] ) ) ? $_POST['user_profile_img_id'] : '';
	if(!metadata_exists('user', $user_id, 'user_profile_img_id') && !is_wp_error( $new_author_image_id )){
		add_user_meta($user_id, 'user_profile_img_id', $new_author_image_id);
	}else{
		$old_author_image_id = get_user_meta($user_id, 'user_profile_img_id', true);
		if(!empty($old_author_image_id)) wp_delete_attachment($old_author_image_id);
		update_user_meta($user_id, 'user_profile_img_id', $new_author_image_id);
	}
	
}



//-------------------------------------------------------------------About Us Shortcode
function custom_add_meta_boxes_page() {
	if('page' == get_post_type() && 'about-us' == get_post_field( 'post_name', get_post())) add_meta_box('custom_shortcode_metabox', 'Shortcode', 'custom_shortcode_metabox_callback', '', 'side', 'high');
}
add_action( 'add_meta_boxes_page', 'custom_add_meta_boxes_page' );
function custom_shortcode_metabox_callback() {
	echo 'Use Shortcode: [about-writer]';
}
add_shortcode('about-writer', 'about_writer');
function about_writer(){
	$writers = new WP_User_Query(array('meta_key'       => 'writer_status',
                                'meta_value'        => array('checked'),
                                'number'            => 4,
                                'fields'            => array('ID') ));
	if(!empty($writers->get_results())) :
		$output = '<div class="about-tame-sec"><h3 class="about-tame-sec-title">Editorial Team</h3><div class="about-us-card-wrapper">';
				foreach ( $writers->get_results() as $writer ) :
					$image_id = get_user_meta($writer->ID,'user_profile_img_id', true);
					$image_url = (empty($image_id))?get_avatar_url($writer->ID):wp_get_attachment_image_url($image_id, 'writer-thumbnail');
					$designation = get_the_author_meta('designation', $writer->ID);
					$output .=	'<div class="about-teem-card">';
						$output .=	'<figure class="about-teem-card-figure"><img class=" img-responsive" src="'.$image_url.'" alt="about us card image" /></figure><div class="about-teem-card-content">';
							$output .=	'<h3 class="about-teem-card-title">'.get_the_author_meta('display_name', $writer->ID).'</h3>';
							if(!empty($designation)) $output .=	'<p class="about-card-user-position">'.$designation.'</p>';
					$output .=	'</div></div>';
				endforeach;
		$output .=	'</div></div>';
		return $output;
	endif;
}



//-------------------------------------------------------------------TOC Function
function toc($content) {
    $content = preg_replace_callback('/<h2>(.*?)<\/h2>/', function($matches) {
        $id = $matches[1];
        return '<h2 id="' . $matches[1] . '">' . $matches[1] . '</h2>';
    }, $content);
    
    $content = preg_replace_callback('/<h3>(.*?)<\/h3>/', function($matches) {
        $id = $matches[1];
        return '<h3 id="' . $matches[1] . '">' . $matches[1] . '</h3>';
    }, $content);
    
    $content = preg_replace_callback('/<h4>(.*?)<\/h4>/', function($matches) {
        $id = $matches[1];
        return '<h4 id="' . $matches[1] . '">' . $matches[1] . '</h4>';
    }, $content);

    return $content;
}
add_filter('the_content', 'toc');



function table_of_content($li_class, $a_class) {
	$content = get_the_content();
    $heading_links = array();
    preg_match_all('/<(h2|h3|h4)[^>]*id=["\']([^"\']+)["\'][^>]*>(.*?)<\/\1>/i', $content, $matches);
    if (!empty($matches)) {
        foreach ($matches[2] as $index => $id) {
            $heading_text = strip_tags($matches[3][$index]);
            $heading_links[] = '<a href="#' . esc_attr($id) . '" class="'.$a_class.'">' . esc_html($heading_text) . '</a>';
        }
    }
    if (!empty($heading_links)) {
        return '<li class="'.$li_class.'">' . implode('</li><li class="'.$li_class.'">', $heading_links) . '</li>';
    }
    return '';
}



////****************************************Gratuity Calculator Shortcode ****************************************/////
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
          accent-color: #000080;
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
            <input type="number" id="salary" value="0" placeholder="Enter Your Amount">
          </div>
          
          <label>No. of Years Of Service (Min: 5 Years)</label>
          <div class="gratuity-slider">
            <input type="range" id="yearsRange" min="5" max="40" value="5" oninput="syncYearsFromSlider(this.value)">
          </div>
          <div class="years-control">
            <input type="text" id="yearsInput" oninput="validateYears(this)" placeholder="5">
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

   function validateYears(input) {
    // Remove non-numeric characters
    let valStr = input.value.replace(/[^0-9]/g, "");
    
    // Allow user to type freely, only clamp on blur
    input.value = valStr;

    let val = parseInt(valStr);
    if (!isNaN(val)) {
        document.getElementById('yearsRange').value = val;
        calculateGratuity();
    } else {
        document.getElementById('yearsRange').value = 5;
        document.getElementById('result').innerText = "₹ 0";
    }
}

// Clamp the value when user leaves the input
document.getElementById('yearsInput').addEventListener('blur', function() {
    let val = parseInt(this.value);
    if (isNaN(val) || val < 5) val = 5;
    if (val > 40) val = 40;
    this.value = val;
    document.getElementById('yearsRange').value = val;
    calculateGratuity();
});
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



////****************************************Salary Calculator Shortcode ****************************************/////


function salary_calculator_shortcode() {
    // Enqueue Chart.js
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);
    
    // Start output buffering
    ob_start();
    ?>
    
    <style>
    .salary-calc-wrapper :root{
      --primary:#010080;
      --card-bg:#fff;
      --muted:#6b7280;
      --surface:#f6f9fc;
      --accent:#f1f7ff;
      --round:12px;
    }
    .salary-calc-wrapper {
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:var(--surface);
      padding:20px;
      display:flex;
      justify-content:center;
    }
    .salary-calc-wrapper .wrap{
      width:100%;
      max-width:1100px;
      display:grid;
      grid-template-columns: 1fr 420px;
      gap:18px;
    }

    .salary-calc-wrapper .card{
      background:var(--card-bg);
      border-radius:var(--round);
      padding:16px;
      box-shadow:0 6px 24px rgba(10,10,30,0.06);
    }
    .salary-calc-wrapper h1{ margin:0 0 10px 0; font-size:18px; text-align:center}
    .salary-calc-wrapper .section-title{ font-weight:600; color:#111827; margin-top:8px; margin-bottom:8px}
    .salary-calc-wrapper label{ display:block; font-size:13px; color:var(--muted); margin-bottom:6px}
    .salary-calc-wrapper input[type="number"], .salary-calc-wrapper select, .salary-calc-wrapper input[type="text"]{
      width:100%; padding:10px; border-radius:8px; border:1px solid #e6e9ef; font-size:14px; box-sizing:border-box;
    }
    .salary-calc-wrapper .row{
      display:flex; gap:10px; margin-bottom:10px;
    }
    .salary-calc-wrapper .col{ flex:1 }
    .salary-calc-wrapper .btn{
      background:var(--primary); color:#fff; border:none; padding:10px 14px; border-radius:8px; cursor:pointer;
      font-weight:600;
    }
    .salary-calc-wrapper .btn.secondary{ background:#e6e6e6; color:#111; }
    .salary-calc-wrapper .small{ font-size:13px; color:var(--muted) }
    .salary-calc-wrapper .muted{ color:var(--muted) }
    .salary-calc-wrapper .results { background:var(--accent); border-radius:10px; padding:12px; margin-top:12px }
    .salary-calc-wrapper .result-row{ display:flex; justify-content:space-between; padding:8px 4px; border-bottom:1px solid rgba(0,0,0,0.03)}
    .salary-calc-wrapper .result-row:last-child{ border-bottom:none }
    .salary-calc-wrapper .highlight{ font-weight:700; color:var(--primary) }
    
    
    /*////new btn design*/
    /* === Button Styles === */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  background: var(--primary);
  color: #fff;
  box-shadow: 0 2px 6px rgba(1, 0, 128, 0.2);
}

.btn:hover {
  background: #1a1ab5;
  box-shadow: 0 3px 8px rgba(1, 0, 128, 0.3);
  transform: translateY(-1px);
}

.btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(1, 0, 128, 0.2);
}

/* Secondary Button */
.btn.secondary {
  background: #f3f4f6;
  color: #111;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.btn.secondary:hover {
  background: #e5e7eb;
  transform: translateY(-1px);
}

/* Common Button (for special actions like Download / Copy) */
.btn.common-btn {
  background: linear-gradient(135deg, #010080, #1e40af);
  color: #fff;
  box-shadow: 0 4px 10px rgba(1, 0, 128, 0.25);
}

.btn.common-btn:hover {
  background: linear-gradient(135deg, #1e40af, #3b82f6);
  transform: translateY(-1px);
}


    @media (max-width:1000px){
      .salary-calc-wrapper .wrap{ grid-template-columns: 1fr; }
    }

    .salary-calc-wrapper .slab-table{ width:100%; border-collapse:collapse; margin-top:6px}
    .salary-calc-wrapper .slab-table th, .salary-calc-wrapper .slab-table td{ padding:8px; border:1px solid #eee; text-align:left; font-size:13px }
    .salary-calc-wrapper .tiny{ font-size:12px; color:var(--muted) }
    .salary-calc-wrapper .controls{ display:flex; gap:8px; margin-top:10px; flex-wrap:wrap }
    .salary-calc-wrapper .center{ text-align:center }
    </style>

    <div class="salary-calc-wrapper">
      <div class="wrap">
        <!-- LEFT: Inputs + settings -->
        <div class="card" id="leftCard">
          <h1>Salary Breakdown — Advanced (Step-by-step)</h1>

          <!-- Step 1: Currency + Salary input -->
          <div class="section">
            <div class="section-title">Step 1 — Salary & Currency</div>
            <div class="row">
              <div class="col">
                <label for="currency">Currency</label>
                <select id="currency">
                  <option value="INR">INR (₹)</option>
                  <option value="USD">USD ($)</option>
                  <option value="EUR">EUR (€)</option>
                  <option value="GBP">GBP (£)</option>
                  <option value="AED">AED (د.إ)</option>
                </select>
              </div>
              <div style="width:140px">
                <label for="period">View</label>
                <select id="period">
                  <option value="annual">Annually</option>
                  <option value="monthly">Monthly</option>
                </select>
              </div>
            </div>

            <label for="salary">Gross Annual Salary (in selected currency)</label>
            <input id="salary" type="number" placeholder="1200000" />

            <div style="display:flex; gap:10px; margin-top:8px;">
              <button class="btn common-btn" id="calcBtn">Calculate</button>
              <button class="btn secondary" id="resetBtn">Reset</button>
              <button class="btn secondary" id="fetchRatesBtn" title="Fetch live rates">Fetch Live Rates</button>
            </div>

            <div class="tiny" style="margin-top:8px">
              Use the "Fetch Live Rates" button to update conversion rates from exchangerate.host (optional). Defaults are available offline.
            </div>
          </div>

          <!-- Step 2: Component Breakdown -->
          <div class="section" style="margin-top:14px">
            <div class="section-title">Step 2 — Salary Components (auto-split)</div>
            <div class="row">
              <div class="col">
                <label>Basic % of Gross</label>
                <input id="basicPct" type="number" value="40" />
              </div>
              <div class="col">
                <label>HRA % of Basic</label>
                <input id="hraPct" type="number" value="50" />
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label>Conveyance (annual fixed)</label>
                <input id="conveyance" type="number" value="19200" />
              </div>
              <div class="col">
                <label>Medical (annual fixed)</label>
                <input id="medical" type="number" value="15000" />
              </div>
            </div>

            <div class="tiny">Special allowance will be computed as remainder after Basic, HRA, Conveyance & Medical.</div>
          </div>

          <!-- Step 3: Deductions -->
          <div class="section" style="margin-top:14px">
            <div class="section-title">Step 3 — Employee Deductions (editable)</div>
            <div class="row">
              <div class="col">
                <label>Employee PF % (of Basic)</label>
                <input id="empPfPct" type="number" value="12" />
              </div>
              <div class="col">
                <label>Employer PF % (of Basic)</label>
                <input id="emprPfPct" type="number" value="12" />
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label>ESI Employee %</label>
                <input id="esiEmpPct" type="number" value="0" />
              </div>
              <div class="col">
                <label>ESI Employer %</label>
                <input id="esiEmprPct" type="number" value="0" />
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label>Professional Tax (annual)</label>
                <input id="profTax" type="number" value="2400" />
              </div>
              <div class="col">
                <label>Other custom deductions (annual)</label>
                <input id="otherDed" type="number" value="0" />
              </div>
            </div>

            <div class="tiny">You can fine-tune employee/employer shares. Employee deductions reduce take-home; employer contributions increase CTC.</div>
          </div>

          <!-- Step 4: Tax settings -->
          <div class="section" style="margin-top:14px">
            <div class="section-title">Step 4 — Tax & Slabs (editable)</div>

            <div class="row">
              <div class="col">
                <label>Tax regime (sample)</label>
                <select id="taxRegime">
                  <option value="old">Old Regime (sample slabs)</option>
                  <option value="new">New Regime (sample slabs)</option>
                </select>
              </div>
              <div style="width:160px">
                <label>Standard Deduction</label>
                <input id="stdDed" type="number" value="50000" />
              </div>
            </div>

            <div style="margin-top:8px">
              <label class="tiny">Editable slabs (upper limit, percent). Enter 0 or empty for 'no upper limit' (i.e., last slab is unlimited).</label>

              <table class="slab-table" id="slabTable">
                <thead>
                  <tr><th style="width:45%">Upper Limit (annual)</th><th style="width:30%">Rate %</th><th style="width:25%">Action</th></tr>
                </thead>
                <tbody id="slabBody"></tbody>
              </table>

              <div class="controls">
                <button class="btn secondary" id="addSlabBtn">Add slab</button>
                <button class="btn secondary" id="setDefaultOld">Defaults: Old</button>
                <button class="btn secondary" id="setDefaultNew">Defaults: New</button>
              </div>
            </div>

            <div style="margin-top:8px" class="tiny">
              Cess %: <input id="cess" type="number" style="width:80px; display:inline-block;" value="4" /> — applies on computed tax.
            </div>
          </div>

          <!-- Step 5: Employer contributions -->
          <div class="section" style="margin-top:14px">
            <div class="section-title">Step 5 — Employer Contributions (auto)</div>
            <div class="tiny">Employer PF & ESI are computed from entered percentages. You can add other employer costs manually below.</div>
            <div class="row" style="margin-top:8px">
              <div class="col">
                <label>Other Employer Contributions (annual)</label>
                <input id="otherEmployer" type="number" value="0" />
              </div>
              <div style="width:160px; align-self:end;">
                <button class="btn common-btn" id="downloadCsvBtn">Download CSV</button>
              </div>
            </div>
          </div>

          <!-- Step 6: Actions -->
          <div class="section" style="margin-top:14px">
            <div class="controls">
              <button class="btn common-btn" id="recalcBtn">Recalculate Live</button>
              <button class="btn secondary" id="printBtn">Print / Save as PDF</button>
            </div>
          </div>
        </div>

        <!-- RIGHT: Results + Chart -->
        <div class="card" id="rightCard">
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
              <div class="section-title">Step 7 — Results</div>
              <div class="tiny">Values shown in selected currency. Switch to Monthly view to see monthly amounts.</div>
            </div>
            <div class="center"><button class="btn secondary" id="toggleChartBtn">Toggle Chart</button></div>
          </div>

          <div id="resultsArea" class="results" style="margin-top:10px">
            <div class="result-row"><div>Gross Annual Salary</div><div id="rGross">-</div></div>
            <div class="result-row"><div>Basic</div><div id="rBasic">-</div></div>
            <div class="result-row"><div>HRA</div><div id="rHra">-</div></div>
            <div class="result-row"><div>Conveyance</div><div id="rConv">-</div></div>
            <div class="result-row"><div>Medical</div><div id="rMed">-</div></div>
            <div class="result-row"><div>Special Allowance</div><div id="rSpecial">-</div></div>

            <div style="height:10px"></div>
            <div class="result-row"><div>Employee Deductions (total)</div><div id="rDeductions">-</div></div>
            <div class="result-row"><div>Net Annual Take-home (pre-tax)</div><div id="rPreTaxNet">-</div></div>
            <div class="result-row"><div>Taxable Income (after standard ded & employee ded)</div><div id="rTaxable">-</div></div>
            <div class="result-row"><div>Income Tax + Cess</div><div id="rTax">-</div></div>

            <div style="height:8px"></div>
            <div class="result-row highlight"><div>Net Annual Take-home (after tax)</div><div id="rNet">-</div></div>
            <div class="result-row highlight"><div>Employer Cost to Company (CTC)</div><div id="rCtc">-</div></div>
          </div>

          <div id="chartWrap" style="margin-top:12px; display:block;">
            <canvas id="pieChart" width="400" height="300"></canvas>
          </div>

          <div style="margin-top:10px; display:flex; gap:8px;">
            <button class="btn common-btn" id="downloadCsvBtnBottom">Download CSV</button>
            <button class="btn secondary" id="copyBtn">Copy Summary</button>
          </div>
        </div>
      </div>
    </div>

    <script>
    (function() {
    const symbols = { INR:'₹', USD:'$', EUR:'€', GBP:'£', AED:'د.إ' };
    let rates = { INR:1, USD:0.012, EUR:0.011, GBP:0.0096, AED:0.044 };

    const $ = id => document.getElementById(id);
    const parseNum = v => { const n = parseFloat(v); return isNaN(n)?0:n; };

    let pieChart = null;

    function buildSlabRow(upper='', rate='') {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><input class="slab-upper" type="number" placeholder="e.g., 250000" value="${upper}" style="width:100%"></td>
        <td><input class="slab-rate" type="number" placeholder="Rate %" value="${rate}" style="width:100%"></td>
        <td style="text-align:right"><button class="btn secondary remove-slab">Remove</button></td>
      `;
      return tr;
    }

    function refreshSlabTableFromDefaults(defaults){
      const body = $('slabBody');
      body.innerHTML = '';
      defaults.forEach(s => {
        const up = s.upTo ? s.upTo : '';
        const r = s.rate;
        body.appendChild(buildSlabRow(up, r));
      });
      attachSlabActions();
    }

    function attachSlabActions(){
      document.querySelectorAll('.remove-slab').forEach(btn => {
        btn.onclick = (e) => { e.target.closest('tr').remove(); }
      });
    }

    const sampleOld = [
      { upTo:250000, rate:0 },
      { upTo:500000, rate:5 },
      { upTo:1000000, rate:20 },
      { upTo:0, rate:30 }
    ];
    const sampleNew = [
      { upTo:300000, rate:0 },
      { upTo:600000, rate:5 },
      { upTo:900000, rate:10 },
      { upTo:1200000, rate:15 },
      { upTo:1500000, rate:20 },
      { upTo:0, rate:30 }
    ];

    async function fetchLiveRates(){
      try {
        const symbolsList = ['USD','EUR','GBP','AED'].join(',');
        const resp = await fetch(`https://api.exchangerate.host/latest?base=INR&symbols=${symbolsList}`);
        const data = await resp.json();
        if (data && data.rates) {
          Object.keys(data.rates).forEach(k => { rates[k] = data.rates[k]; });
          rates.INR = 1;
          alert('Live rates fetched and applied (base=INR).');
          recalc();
        } else {
          alert('Failed to fetch rates. Using static defaults.');
        }
      } catch (err) {
        console.error(err);
        alert('Error fetching live rates (CORS, network). Using static defaults.');
      }
    }

    function convertAmount(amount, from, to){
      if (!rates[from] || !rates[to]) return amount;
      const amountInINR = amount / rates[from];
      return amountInINR * rates[to];
    }

    function formatAmt(val, currency){
      const n = Number(val) || 0;
      try {
        const opts = {minimumFractionDigits:2, maximumFractionDigits:2};
        const locale = (currency === 'INR' ? 'en-IN' : 'en-US');
        return new Intl.NumberFormat(locale, opts).format(n) + ' ' + (symbols[currency] || currency);
      } catch (e){
        return n.toFixed(2) + ' ' + (symbols[currency] || currency);
      }
    }

    function readSlabsFromTable(){
      const rows = document.querySelectorAll('#slabBody tr');
      const slabs = [];
      rows.forEach(row => {
        const upper = parseNum(row.querySelector('.slab-upper').value);
        const rate = parseNum(row.querySelector('.slab-rate').value);
        slabs.push({ upTo: upper>0?upper:0, rate: rate });
      });
      if (slabs.length === 0) {
        return sampleOld;
      }
      return slabs;
    }

    function computeTaxUsingSlabs(taxableIncome, slabs, cessPct=4){
      const s = slabs.slice().map(x => ({upTo: x.upTo || 0, rate: x.rate || 0}));
      s.sort((a,b) => {
        if (a.upTo === 0) return 1;
        if (b.upTo === 0) return -1;
        return a.upTo - b.upTo;
      });

      let tax = 0;
      let prevLimit = 0;
      for (let i=0;i<s.length;i++){
        const limit = s[i].upTo === 0 ? Infinity : s[i].upTo;
        if (taxableIncome <= prevLimit) break;
        const taxablePortion = Math.min(taxableIncome, limit) - prevLimit;
        if (taxablePortion > 0) {
          tax += (taxablePortion * (s[i].rate/100));
        }
        prevLimit = limit;
      }
      const cess = tax * (cessPct/100);
      return { tax: tax, cess: cess, totalTax: tax + cess };
    }

    function computeAll(){
      const currency = $('currency').value;
      const period = $('period').value;
      const gross = parseNum($('salary').value);

      if (gross <= 0) {
        return null;
      }

      const basicPct = parseNum($('basicPct').value)/100;
      const hraPct = parseNum($('hraPct').value)/100;
      const conveyance = parseNum($('conveyance').value);
      const medical = parseNum($('medical').value);

      const basic = gross * basicPct;
      const hra = basic * hraPct;
      const special = Math.max(0, gross - (basic + hra + conveyance + medical));

      const empPfPct = parseNum($('empPfPct').value)/100;
      const empPf = basic * empPfPct;
      const esiEmpPct = parseNum($('esiEmpPct').value)/100;
      const esiEmp = gross * esiEmpPct;
      const profTax = parseNum($('profTax').value);
      const otherDed = parseNum($('otherDed').value);

      const totalEmployeeDeductions = empPf + esiEmp + profTax + otherDed;

      const preTaxNet = gross - totalEmployeeDeductions;

      const stdDed = parseNum($('stdDed').value);
      const taxableIncome = Math.max(0, preTaxNet - stdDed);

      const slabs = readSlabsFromTable();
      const cess = parseNum($('cess').value) || 0;
      const computedTax = computeTaxUsingSlabs(taxableIncome, slabs, cess);

      const emprPfPct = parseNum($('emprPfPct').value)/100;
      const emprPf = basic * emprPfPct;
      const esiEmprPct = parseNum($('esiEmprPct').value)/100;
      const esiEmpr = gross * esiEmprPct;
      const otherEmployer = parseNum($('otherEmployer').value);

      const employerContributions = emprPf + esiEmpr + otherEmployer;

      const netAfterTax = preTaxNet - computedTax.totalTax;

      const ctc = gross + employerContributions;

      const breakdown = {
        currency, period,
        gross, basic, hra, conveyance, medical, special,
        empPf, esiEmp, profTax, otherDed, totalEmployeeDeductions,
        preTaxNet, stdDed, taxableIncome,
        tax: computedTax.tax, cess: computedTax.cess, totalTax: computedTax.totalTax,
        netAfterTax, employerContributions, emprPf, esiEmpr, otherEmployer, ctc,
        slabsUsed: slabs
      };
      return breakdown;
    }

    function updateUI(bd){
      if (!bd) return;
      const cur = bd.currency;

      $('rGross').innerText = formatAmt(bd.gross, cur);
      $('rBasic').innerText = formatAmt(bd.basic, cur);
      $('rHra').innerText = formatAmt(bd.hra, cur);
      $('rConv').innerText = formatAmt(bd.conveyance, cur);
      $('rMed').innerText = formatAmt(bd.medical, cur);
      $('rSpecial').innerText = formatAmt(bd.special, cur);

      $('rDeductions').innerText = formatAmt(bd.totalEmployeeDeductions, cur);
      $('rPreTaxNet').innerText = formatAmt(bd.preTaxNet, cur);
      $('rTaxable').innerText = formatAmt(bd.taxableIncome, cur);
      $('rTax').innerText = formatAmt(bd.totalTax, cur);

      $('rNet').innerText = formatAmt(bd.netAfterTax, cur);
      $('rCtc').innerText = formatAmt(bd.ctc, cur);

      updateChart(bd);
    }

    function updateChart(bd){
      const ctx = document.getElementById('pieChart').getContext('2d');

      const labels = ['Basic','HRA','Special','Employee Deductions','Employer Contributions'];
      const data = [
        bd.basic,
        bd.hra,
        bd.special,
        bd.totalEmployeeDeductions,
        bd.employerContributions
      ];

      if (pieChart) pieChart.destroy();
      pieChart = new Chart(ctx, {
        type:'pie',
        data: {
          labels,
          datasets:[{ data, label:'Salary split' }]
        },
        options:{ plugins:{ legend:{ position:'bottom' } } }
      });
    }

    function buildCsv(bd){
      if (!bd) return '';
      const rows = [
        ['Field','Amount ('+bd.currency+')'],
        ['Gross Annual Salary', bd.gross],
        ['Basic', bd.basic],
        ['HRA', bd.hra],
        ['Conveyance', bd.conveyance],
        ['Medical', bd.medical],
        ['Special Allowance', bd.special],
        ['------','------'],
        ['Employee PF (annual)', bd.empPf],
        ['ESI Employee (annual)', bd.esiEmp],
        ['Professional Tax', bd.profTax],
        ['Other Deductions', bd.otherDed],
        ['Total Employee Deductions', bd.totalEmployeeDeductions],
        ['Pre-Tax Net', bd.preTaxNet],
        ['Standard Deduction', bd.stdDed],
        ['Taxable Income', bd.taxableIncome],
        ['Income Tax', bd.tax],
        ['Cess', bd.cess],
        ['Total Tax', bd.totalTax],
        ['Net After Tax', bd.netAfterTax],
        ['Employer PF (annual)', bd.emprPf],
        ['ESI Employer (annual)', bd.esiEmpr],
        ['Other Employer Contributions', bd.otherEmployer],
        ['Employer Contributions Total', bd.employerContributions],
        ['CTC', bd.ctc]
      ];
      return rows.map(r => r.map(c => `"${(c===null||c===undefined)?'':c}"`).join(',')).join('\n');
    }

    function downloadCsv(){
      const bd = computeAll();
      if (!bd) { alert('Please enter salary first.'); return;}
      const csv = buildCsv(bd);
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'salary_breakdown.csv';
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(url);
    }

    function recalc(){
      const bd = computeAll();
      if (!bd) return;
      updateUI(bd);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
    } else {
      init();
    }

    function init() {
      refreshSlabTableFromDefaults(sampleOld);

      $('addSlabBtn').onclick = () => {
        $('slabBody').appendChild(buildSlabRow('',''));
        attachSlabActions();
      };
      $('setDefaultOld').onclick = () => refreshSlabTableFromDefaults(sampleOld);
      $('setDefaultNew').onclick = () => refreshSlabTableFromDefaults(sampleNew);

      $('calcBtn').onclick = () => {
        const b = computeAll();
        if (!b) { alert('Enter a valid gross salary.'); return; }
        updateUI(b);
        $('resultsArea').scrollIntoView({behavior:'smooth'});
      };

      $('recalcBtn').onclick = () => recalc();
      $('resetBtn').onclick = () => {
        $('salary').value = '';
        $('basicPct').value = 40;
        $('hraPct').value = 50;
        $('conveyance').value = 19200;
        $('medical').value = 15000;
        $('empPfPct').value = 12; $('emprPfPct').value = 12;
        $('esiEmpPct').value = 0; $('esiEmprPct').value = 0;
        $('profTax').value = 2400; $('otherDed').value = 0;
        $('stdDed').value = 50000; $('cess').value = 4;
        refreshSlabTableFromDefaults(sampleOld);
        recalc();
      };

      $('fetchRatesBtn').onclick = () => fetchLiveRates();

      const inputsToWatch = ['currency','period','salary','basicPct','hraPct','conveyance','medical','empPfPct','emprPfPct','esiEmpPct','esiEmprPct','profTax','otherDed','stdDed','cess','otherEmployer'];
      let debounceTimer = null;
      inputsToWatch.forEach(id => {
        const el = $(id);
        if (!el) return;
        el.addEventListener('input', () => {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(recalc, 350);
        });
        el.addEventListener('change', () => { clearTimeout(debounceTimer); debounceTimer = setTimeout(recalc, 200);});
      });

      document.body.addEventListener('input', (e) => {
        if (e.target.matches('.slab-upper') || e.target.matches('.slab-rate')) {
          clearTimeout(debounceTimer); debounceTimer = setTimeout(recalc, 400);
        }
      });

      $('toggleChartBtn').onclick = () => {
        const el = $('chartWrap');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
      };

      $('printBtn').onclick = () => { window.print(); };

      $('downloadCsvBtn').onclick = downloadCsv;
      $('downloadCsvBtnBottom').onclick = downloadCsv;

      $('copyBtn').onclick = () => {
        const bd = computeAll();
        if (!bd) { alert('No data'); return; }
        const lines = [
          `Gross: ${formatAmt(bd.gross, bd.currency)}`,
          `Net (after tax): ${formatAmt(bd.netAfterTax, bd.currency)}`,
          `CTC: ${formatAmt(bd.ctc, bd.currency)}`
        ];
        navigator.clipboard?.writeText(lines.join('\n')).then(()=>alert('Summary copied to clipboard.'));
      };

      recalc();
    }
    })();
    </script>

    <?php
    return ob_get_clean();
}


add_shortcode('salary_calculator', 'salary_calculator_shortcode');
