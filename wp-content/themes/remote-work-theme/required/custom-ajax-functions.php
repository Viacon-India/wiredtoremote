<?php
//---------------------------------------------search_fetch Function
add_action('wp_ajax_search_fetch' , 'search_fetch');
add_action('wp_ajax_nopriv_search_fetch','search_fetch');
function search_fetch(){
global $post;
/** Query to filter only post type */
$search = $_POST['keyword'];
$the_query = new WP_Query( array('post_type' => 'post',
								'post_status' => 'publish',
								'post__not_in' => array($post->ID),
								'posts_per_page' => 6,
								's' => esc_attr( $search ),
								'order'   => 'DESC' ));

if ($the_query -> have_posts()) : 
	while ($the_query -> have_posts()) : $the_query -> the_post();
		get_template_part('template-parts/search', 'card');
	endwhile; 
	wp_reset_postdata();
else :
	echo (!empty($search))?'<p class="inner-detail">Sorry, but nothing matched your search "<span class="uppercase">'.esc_attr( $search ).'</span>". Please try again with some different keywords.</p>':'<p class="condition-msg">Sorry, but no latest article is available.</p>';
endif;
img();
die();
}
//---------------------------------------------load_more_comments Function
add_action('wp_ajax_load_more_comments', 'load_more_comments');
add_action('wp_ajax_nopriv_load_more_comments', 'load_more_comments');
function load_more_comments(){
	$comment_id = $_GET['comment_id'];
	$post_id = $_GET['post_id'];
    $comments = get_comments(array('parent' => $comment_id,
									'hierarchical' => 'threaded',
									'status' => 'approve',
									'orderby' => 'date',
									'order' => 'ASC' ));
	if(!empty($comments) && !empty($comment_id)) :
		foreach ( $comments as $comment ) :
			$comment_number = get_comments(array('parent' => $comment->comment_ID,
												'hierarchical' => 'threaded',
												'count' => true,
												'status' => 'approve',
												'orderby' => 'date',
												'order' => 'ASC' )); ?>
			<div class="pl-[15px] pb-[24px] mt-[24px]" id="comment-<?php echo $comment->comment_ID; ?>">
				<div class="comment-replay-card-deffer">
					<div class="comment-replay-card-deffer-inner">
						<div>
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M3.5 14.5H2.5V15.5H3.5V14.5ZM21.7071 15.2071C22.0976 14.8166 22.0976 14.1834 21.7071 13.7929L15.3431 7.42893C14.9526 7.03841 14.3195 7.03841 13.9289 7.42893C13.5384 7.81946 13.5384 8.45262 13.9289 8.84315L19.5858 14.5L13.9289 20.1569C13.5384 20.5474 13.5384 21.1805 13.9289 21.5711C14.3195 21.9616 14.9526 21.9616 15.3431 21.5711L21.7071 15.2071ZM2.5 4.5V14.5H4.5V4.5H2.5ZM3.5 15.5H21V13.5H3.5V15.5Z" fill="#1C3C19" />
							</svg>
						</div>
						<div class="comment-replay-card-deffer-inner-image-name-date-sec">
							<figure class="replay-card-image-controller">
								<img class="image-responsive" src="<?php echo get_avatar_url($comment->user_id); ?>" alt="single page author image ">
							</figure>
							<div class="replay-card-content-deffer">
								<h2 class="replay-card-content-title"><?php echo $comment->comment_author; ?></h2>
								<p class="comment-date-deffer"><?php echo get_comment_date('j F, Y', $comment) ?></p>
							</div>
						</div>
					</div>
					<div class="comment-wrapper">
						<p class="comment-dsc"><?php echo $comment->comment_content; ?></p>
					</div>

					<div class="comment-replay-card-deffer-reply-button-whapper">
						<?php if (is_user_logged_in()) echo '<a class="reply-button" href="' . get_edit_comment_link($comment->comment_ID) . '">Edit</a>'; ?>
						<a class="reply-button" rel="nofollow" href="<?php echo get_permalink($post_id); ?>/?replytocom=<?php echo $comment->comment_ID; ?>#respond" data-commentid="<?php echo $comment->comment_ID; ?>" data-postid="<?php echo $post_id; ?>" data-belowelement="div-comment-<?php echo $comment->comment_ID; ?>" data-respondelement="respond" data-replyto="Reply to <?php echo $comment->comment_author; ?>" aria-label="Reply to <?php echo $comment->comment_author; ?>">Reply</a>
						<?php $comment_reply_txt = (!empty($comment_number) && $comment_number >= 2) ? '(' . $comment_number . ')More Replies' : '(' . $comment_number . ')More Reply';
						echo (!empty($comment_number)) ? '<span id="load_button_' . $comment->comment_ID . '" class="reply-button show-comment cursor-pointer" data-comment_id="' . $comment->comment_ID . '" data-post_id="' . $post_id . '">' . $comment_reply_txt . '</span>' : ''; ?>
					</div>
				</div>
				<?php echo (!empty($comment_number)) ? '<div id="load_child_' . $comment->comment_ID . '"></div>' : ''; ?>
			</div>
		<?php endforeach;
	endif;
	wp_reset_postdata();
    wp_die();
}
//---------------------------------------------load_more_blog Function
add_action('wp_ajax_load_more_blog', 'load_more_blog');
add_action('wp_ajax_nopriv_load_more_blog', 'load_more_blog');
function load_more_blog(){
    $the_query = new WP_Query(array('post_type'		=> 'post',
									'post_status'	=> 'publish',
									'orderby'		=> $_POST['orderby'],
									'order'			=> 'DESC',
									'paged'			=> $_POST['page'],
									'cat'			=> $_POST['cat_id'],
									'tag_id'		=> $_POST['tag_id'],
									'author'		=> $_POST['user_id'],
									's'				=> $_POST['search'] ));
	if($the_query->have_posts()) : 
        while ($the_query->have_posts()) : $the_query->the_post();
			get_template_part('template-parts/listing', 'card');
		endwhile;
	endif;

	if(!function_exists('img')) { ?>
		<script>alert('Remove alert from load_more_blog function');</script>
	<?php }else{
		img();
	}
	wp_reset_postdata();
    wp_die();
}
//---------------------------------------------add_tip Function
add_action('wp_ajax_add_tip', 'add_tip');
add_action('wp_ajax_nopriv_add_tip', 'add_tip');
function add_tip(){
    $index = $_GET['index'];
	echo '<div style="padding-bottom: 20px;" class="tips">';
		echo '<h3 style="margin-bottom: 5px;">Tip '.($index+1).'</h3>';
		echo '<input type="text" style="width: 100%;margin-bottom: 5px;" name="tips['.$index.'][title]" placeholder="Card Title"" />';
		wp_editor( '', 'tips['.$index.'][content]', array('wpautop' => false, 'media_buttons' =>  true, 'textarea_rows' => 5 ));
		echo '<input type="button" style="margin-top: 5px;" class="button remove-row" value="Remove Tip '.($index+1).'">';
	echo '</div>';
	wp_reset_postdata();
    wp_die();
}