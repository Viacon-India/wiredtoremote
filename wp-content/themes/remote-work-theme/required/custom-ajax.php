<?php
//AJAX Live Search
add_action( 'wp_footer', 'all_javascript' );
function all_javascript() { ?>
	<script>
		jQuery(document).ready(function($) {
//--------------------------------------------------------------------------------------------search_fetch
			jQuery('#default-search').on('input', function(){
				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					type: 'post',
					data: { action: 'search_fetch', keyword: jQuery('#default-search').val() },
					beforeSend: function(){
						$('#datafetch .modal-card').each(function() {
							$(this).find('figure').height($(this).find('figure img').height()).width($(this).find('figure img').width()).empty().addClass("data-loading");
							$(this).find('.modal-detail').height($(this).find('.modal-detail').height()).width($(this).find('.modal-detail').width()).empty().addClass("data-loading");
						});
					},
					success: function(data) {
						jQuery('#datafetch').empty().html( data );
					}
				});
			});
//--------------------------------------------------------------------------------------------load_more
			var page = 2;
			jQuery('#load_more').click(function(){
				var orderby = 'date';
				var page_type = 'archive';
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				var card_index = jQuery('#load_more_div').children('div').last().data('card_index');
				var page_count = jQuery('#load_more').data('page_count');
				var cat_id = jQuery('#load_more').data('cat_id');
				var tag_id = jQuery('#load_more').data('tag_id');
				var user_id = jQuery('#load_more').data('user_id');
				var meta_key = jQuery('#load_more').data('meta_key');
				var paging = jQuery('#load_more').data('paged');
				if(user_id != undefined){ var page_type = 'author'; }
				if(meta_key){ var orderby = 'meta_value_num'; }
				if(page <= paging){ page = paging + 1; }
				var data = {'action': 'load_more_blog',
							'card_index': card_index,
							'page': page,
							'cat_id' : cat_id,
							'tag_id' : tag_id,
							'user_id' : user_id,
							'orderby' : orderby,
							'page_type': page_type };
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#load_more_div').append(response);
					var url = window.location.href;
					if (url.includes('page/')) {
						var prev_text = url.split('page/')[0];
						var split_text_1 = url.split('page/')[1];
						var next_text = split_text_1.split('/')[1];
						var current_page = split_text_1.split('/')[0];
						page = parseInt(current_page) + 1;
						window.history.replaceState('URL', 'Title', prev_text+'page/'+page+'/'+next_text); 
					}else{
						if(url.includes('?')){
							var variables = url.split('?')[1];
							window.history.replaceState('URL', 'Title', 'page/'+page+'/?'+variables); 
						}else{
							window.history.replaceState('URL', 'Title', 'page/'+page+'/'); 
						}
					}
					if(page_count <= page){
						jQuery('#load_more').hide().after('<span class="flex justify-center view-more-btn cursor-default condition-msg">No More Articles</span>');
					}else{
						jQuery('#load_more').parent().show();
						jQuery('#load_more').show().siblings('span.condition-msg').remove();
					}
					page = page + 1;
				});
			});
//--------------------------------------------------------------------------------------------load_more_comments
			$('body').on('click', 'span.show-comment', function(){
				var comment_id = jQuery(this).data('comment_id');
				var post_id = jQuery(this).data('post_id');
				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: { action: 'load_more_comments', comment_id: comment_id, post_id: post_id},
					success: function(data) {
						$('#load_button_'+comment_id).remove();
						$('#load_child_'+comment_id).empty().html(data);
					}
				});
			});
		});
	</script>
<?php }