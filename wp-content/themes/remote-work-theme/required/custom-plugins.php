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

	$categories = array('category_1','category_2','category_3','category_4','category_5');
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
            <th valign="top" scope="row"><label for="svg"><?php _e('SVG Code'); ?></label></th>
            <td>
				<textarea rows="8" cols="50" name="svg"><?php echo esc_attr( $svg ) ? esc_attr( $svg ) : ''; ?></textarea><br/>
                <span class="description"><?php _e('Please enter your SVG Code'); ?></span>
            </td>
        </tr><?php
	}elseif (current_filter() == 'category_add_form_fields') {
        ?><div class="form-field">
            <label for="svg"><?php _e('SVG Code'); ?></label>
            <input type="text" size="40" value=""  name="svg">
            <p class="description"><?php _e('Please enter your SVG Code'); ?></p>
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
add_action('init', function() {
	register_taxonomy('idea', 'post', array('label'				=> __('Ideas'),
												'hierarchical'		=> true,
												'rewrite'			=> array('slug'			=> 'idea',
																			'with_front'	=> false,
																			'hierarchical'	=> true	),
												'show_admin_column'	=> true,
												'show_in_rest'		=> true,
												'labels'			=> array('singular_name'				=> __('Idea'),
																			'all_items'						=> __('All Ideas'),
																			'parent_item_colon'				=> __('Parent Idea'),
																			'edit_item'						=> __('Edit Idea'),
																			'view_item'						=> __('View Idea'),
																			'update_item'					=> __('Update Idea'),
																			'add_new_item'					=> __('Add New Idea'),
																			'new_item_name'					=> __('New Idea Name'),
																			'search_items'					=> __('Search Ideas'),
																			'popular_items'					=> __('Popular Ideas'),
																			'separate_items_with_commas'	=> __('Separate Ideas with comma'),
																			'choose_from_most_used'			=> __('Choose from most used Ideas'),
																			'not_found'						=> __('No Ideas found'))));
});
register_taxonomy_for_object_type('idea', 'post');



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
	add_meta_box('pros_cons_metabox', 'Pros And Cons', 'pros_cons_callback', '', 'normal', 'high');
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
function toc($html) {
    if (is_single()) {
        if (!$html) return $html;
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        foreach($dom->getElementsByTagName('*') as $element) {
            if($element->tagName == 'h2' || $element->tagName == 'h3' || $element->tagName == 'h4') {
				$title_id = str_replace(array(' '),array('-'),rtrim(preg_replace('#[\s]{2,}#',' ',preg_replace('#[^\w\säüöß]#',null,str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),html_entity_decode(strtolower(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $element->textContent))))))));
				$element->setAttribute('id', $title_id);
				$title_id = str_replace(array(' '),array('-'),rtrim(preg_replace('#[\s]{2,}#',' ',preg_replace('#[^\w\säüöß]#',null,str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),html_entity_decode(strtolower(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $element->textContent))))))));
				$element->setAttribute('id', $title_id);
            }
        }
        $html = $dom->saveHTML();
    }
    return $html;
}
add_filter('the_content', 'toc');

function table_of_content($li_class, $a_class){
	$toc = '';
	$html = get_the_content();
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	libxml_clear_errors();
	foreach($dom->getElementsByTagName('*') as $element) {
		if($element->tagName == 'h2' || $element->tagName == 'h3' || $element->tagName == 'h4') {
			$title_id = str_replace(array(' '),array('-'),rtrim(preg_replace('#[\s]{2,}#',' ',preg_replace('#[^\w\säüöß]#',null,str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),html_entity_decode(strtolower(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $element->textContent))))))));
			$toc .= '<li class="'.$li_class.'"><a href="' . get_the_permalink() . '#'.$title_id . '" id="toc-' . $title_id . '" class="'.$a_class.'">' . $element->textContent . '</a></li>';
		}
	}
	return $toc;
}