<?php get_header();

$author_id = get_queried_object_id();
$display_name = get_the_author_meta('display_name', $author_id);
$desc = get_the_author_meta('description', $author_id);
$designation = get_the_author_meta('designation', $author_id);
$total_post_count = $GLOBALS['wp_query']->found_posts;
$post_count = $GLOBALS['wp_query']->post_count;
$paged = get_query_var('paged');
$page_count = $GLOBALS['wp_query']->max_num_pages;
$post_per_page = get_option('posts_per_page');
$image_id = get_user_meta($author_id, 'user_profile_img_id', true);
$image_url = (empty($image_id)) ? get_avatar_url($author_id) : wp_get_attachment_image_url($image_id, 'profile-thumbnail');
$facebook = get_the_author_meta('facebook', $author_id);
$twitter = get_the_author_meta('twitter', $author_id);
$linkedin = get_the_author_meta('linkedin', $author_id);
$instagram = get_the_author_meta('instagram', $author_id); ?>


<section class="author-page">
    <div class=" container mx-auto">
        <div class="author-page-breadcrumbs-wrappers">
            <ul class="breadcrumbs">
                <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="bread-list"><?php echo $display_name; ?></li>
            </ul>
        </div>
        <div class="author-page-author-card ">
            <div class="author-page-author-card-img-sec">
                <figure class="author-page-author-card-img-sec-figure">
                    <img class="img-responsive rounded-[6px] overflow-hidden " src="<?php echo $image_url; ?>" alt="author img" />
                </figure>

                <div class="flex sm:hidden h-fit">
                    <h2 class="author-page-author-card-title "><?php echo $display_name; ?></h2>
                </div>
            </div>
            <div class="author-page-author-card-content-sec">
                <h2 class="author-page-author-card-title hidden sm:block"><?php echo $display_name; ?></h2>
                <?php echo (!empty($desc)) ? '<div class="author-page-author-card-dsc-wrapper"><p class="author-page-author-card-dsc">' . $desc . '</p></div>' : ''; ?>
                <span class="author-card-line"></span>
                <?php if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false) || (!empty($twitter) && (filter_var($twitter, FILTER_VALIDATE_URL) !== false)) || (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false)) || (!empty($instagram) && (filter_var($instagram, FILTER_VALIDATE_URL) !== false))) :
                    echo '<div class="author-page-author-card-social-icon-wrapper">';
                    if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false)) echo '<a class="author-card-social-icon" href="' . $facebook . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="author_social_Link"><span class="icon-facebook"></span></a>';
                    if (!empty($twitter) && (filter_var($twitter, FILTER_VALIDATE_URL) !== false)) echo '<a class="author-card-social-icon" href="' . $twitter . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="author_social_Link"><span class="icon-x"></span></a>';
                    if (!empty($instagram) && (filter_var($instagram, FILTER_VALIDATE_URL) !== false)) echo '<a class="author-card-social-icon" href="' . $instagram . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="author_social_Link"><span class="icon-instagram"></span></a>';
                    if (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false)) echo '<a class="author-card-social-icon" href="' . $linkedin . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="author_social_Link"><span class="icon-linkedin"></span></a>';
                    echo '</div>';
                endif; ?>
            </div>
        </div>
        <?php if (have_posts()) :
            echo '<div id="load_more_div" class="author-page-grid-wrapper">';
            while (have_posts()) : the_post();
                get_template_part('template-parts/listing', 'card');
            endwhile;
            echo '</div>';
            if (!($total_post_count <= $post_per_page) && !($paged >= $page_count)) : ?>
                <div class="search-page-cta-wrapper">
                    <button class="common-btn" data-paged="<?php echo $paged; ?>" data-page_count="<?php echo $page_count; ?>" data-user_id="<?php echo $author_id; ?>" id="load_more" aria-label="More Post">
                        Load More <span class="icon-arrow"></span>
                    </button>
                </div>
                <div class="hidden">
                    <?php the_posts_pagination(array(
                        'mid_size' => 10,
                        'end_size'  => 10,
                        'total' => ceil($post_count / $post_per_page),
                        'prev_text' => '<<',
                        'next_text' => '>>'
                    )); ?>
                </div>
        <?php endif;
        else :
            echo '<div class="search-page-button-wrapper">';
            echo '<p class="condition-msg !text-center">Sorry, but "<span class="uppercase">' . $display_name . '</span>" has not published any articles.</p>';
            echo '</div>';
        endif; ?>
    </div>
</section>
<?php get_footer(); ?>