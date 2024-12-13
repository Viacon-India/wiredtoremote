<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $post_id = get_queried_object_id();
    $cat = get_the_category();
    $cat_id = (!empty($cat)) ? $cat[0]->term_id : '';
    $tags = get_the_tags();
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_URL = get_author_posts_url($author_id);
    $author_desc = get_the_author_meta('description', $author_id);
    $related_posts = get_posts(array(
        'category__in'    => $cat_id,
        'post_type'         => 'post',
        'orderby'           => 'rand',
        'post_status'       => 'publish',
        'order'             => 'DESC',
        'posts_per_page'    => 3,
        'post__not_in'      => array($post_id)
    ));
    $fast_facts = get_post_meta($post_id, "fast-facts", true); ?>

    <section class="single-page">
        <div class="single-banner">
            <div class=" container mx-auto">
                <div class="single-breadcrumbs-wrappers">
                    <ul class="breadcrumbs">
                        <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                        <?php if (!empty($cat_id)) {
                            $parent_id = $cat[0]->parent;
                            $breadcrumb = '<li class="bread-list"><a href="' . get_category_link($cat_id) . '" title="' . $cat[0]->cat_name . '">' . $cat[0]->cat_name . '</a></li>';
                            while ($parent_id > 0) {
                                $parent_cat = get_category($parent_id);
                                $breadcrumb = '<li class="bread-list"><a href="' . get_category_link($parent_id) . '" title="' . $parent_cat->name . '">' . $parent_cat->name . '</a></li>' . $breadcrumb;
                                $parent_id = $parent_cat->parent;
                            }
                            echo $breadcrumb;
                        } ?>
                        <li class="bread-list"><?php echo the_title_attribute('echo=0'); ?></li>
                    </ul>
                </div>
                <div class="single-banner-inner">
                    <div class="single-banner-content-sec">
                        <?php $published_date = get_the_date('F j, Y');
                        $modified_date = get_the_modified_time('F j, Y'); ?>
                        <div class="single-banner-cat-post-date-wrapper">
                            <?php if (!empty($cat_id)) echo '<a href="' . get_category_link($cat_id) . '" class="single-banner-cat hover:underline ">' . $cat[0]->name . '</a>'; ?>

                            <?php if ($published_date == $modified_date) { ?>
                                <span class="single-banner-cat-post-dish"></span>
                                <span class="font-light text-secondary"><?php echo $published_date; ?></span>
                            <?php } ?>

                            <?php if ($published_date != $modified_date) { ?>
                                <span class="single-banner-cat-post-dish"></span>
                                <span class="font-light text-secondary">
                                    <?php echo $published_date; ?>
                                </span>
                                <span class="single-banner-cat-post-dish"></span>
                                <span class="font-light text-secondary">
                                    Last Updated on: <?php echo $modified_date; ?>
                                </span>
                            <?php } ?>

                        </div>

                        <h1 class="single-post-title"><?php echo the_title_attribute('echo=0'); ?></h1>
                    </div>
                    <div class="single-banner-image-sec">
                        <figure class="single-banner-img-controller">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php echo get_the_post_thumbnail($post_id, 'single-thumbnail', array('class' => 'img-responsive')); ?>
                            <?php else : ?>
                                <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/single-banner.jpg" alt="single-page-banner-image">
                            <?php endif; ?>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-main-content">
            <div class="container mx-auto">
                <div class="single-main-content-inner">
                    <div class="toc-wrapper-sec">
                        <div class="toc-wrapper-box">
                            <div class="toc-title-wrapper">
                                <h2 class="toc-title">Table of Contents</h2>
                                <button class="accordion md:hidden">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/down-icon.svg" alt="toc icon">
                                </button>
                            </div>

                            <div class="panel md:block">
                                <ul id="toc" class="box-item-sec">
                                    <?php echo table_of_content('box-item-wrapper', 'box-item box-line'); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single-post-content-wrapper">
                        <div class="single-post-content">
                            <?php if (!empty($fast_facts)) :
                                echo '<div class="fast_facts">';
                                echo '<h3>Fast Facts</h3>';
                                foreach ($fast_facts as $fast_fact) :
                                    if (!empty($fast_fact['key']) && !empty($fast_fact['value'])) echo '<div class="fact"><p>' . $fast_fact['key'] . '</p><p class="ansver">' . $fast_fact['value'] . '</p></div>';
                                endforeach;
                                echo '</div>';
                            endif; ?>
                            <?php the_content(); ?>

                            <?php if ($tags) { ?>
                                <div class="single-page-tag-sec">
                                    <h3 class="single-page-tag-title">Tags:</h3>
                                    <div class="single-tags-wrapper">
                                        <?php foreach ($tags as $tag) { ?>
                                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="single-tags-btn" rel="tags"><?php echo $tag->name; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="share-this-article-single">
                                <h3 class="single-share-this-article-title">Share This Article:</h3>
                                <div class="share-article-icon-wrapper">
                                    <button class="share-icon share-social" data-link="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($post_id); ?>">
                                        <span class="icon-facebook"></span>
                                    </button>
                                    <button class="share-icon share-social" data-link="http://twitter.com/intent/tweet?text=<?php echo strip_tags(the_title_attribute()); ?>&url=<?php echo get_permalink($post_id); ?>">
                                        <span class="icon-linkedin"></span>
                                    </button>
                                    <button class="share-icon share-social" data-link="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink($post_id); ?>&title=<?php echo strip_tags(the_title_attribute()); ?>">
                                        <span class="icon-x"></span>
                                    </button>
                                    <button class="share-icon share-more" data-post_title="<?php echo the_title_attribute('echo=0'); ?>" data-post_text="post to <?php echo the_title_attribute('echo=0'); ?>" data-post_url="<?php echo get_permalink($post_id); ?>">
                                        <span class="icon-share"></span>
                                    </button>
                                </div>
                            </div>
                            <?php comment_form(); ?>
                            <?php $parent_comments = get_comments(array(
                                'post_id'       => $post_id,
                                'status'        => 'approve',
                                'hierarchical'  => 'threaded',
                                'orderby'       => 'date',
                                'order'         => 'ASC'
                            ));
                            if (!empty($parent_comments)) : ?>
                                <section class="all-comments-reply-sec">
                                    <h2 class="comment-replay-title">all comments</h2>
                                    <?php foreach ($parent_comments as $parent_comment) : ?>
                                        <div class="border-t border-t-forest-green" id="comment-<?php echo $parent_comment->comment_ID; ?>">
                                            <div class="comment-replay-card">
                                                <div class="comment-replay-card-image-name-date-sec">
                                                    <figure class="replay-card-image-controller">
                                                        <img class="image-responsive" src="<?php echo get_avatar_url($parent_comment->user_id); ?>" alt="single page author image ">
                                                    </figure>
                                                    <div class="replay-card-content">
                                                        <h2 class="replay-card-content-title"><?php echo $parent_comment->comment_author; ?></h2>
                                                        <p class="comment-date"><?php echo get_comment_date('j F, Y', $parent_comment) ?></p>
                                                    </div>
                                                </div>
                                                <div class="comment-wrapper">
                                                    <p class="comment-dsc"><?php echo $parent_comment->comment_content; ?></p>
                                                </div>
                                                <div class="comment-card-reply-button-whapper">
                                                    <?php if (is_user_logged_in()) echo '<a class="reply-button" href="' . get_edit_comment_link($parent_comment->comment_ID) . '">Edit</a>'; ?>
                                                    <a class="reply-button" rel="nofollow" href="<?php echo get_permalink($post_id); ?>/?replytocom=<?php echo $parent_comment->comment_ID; ?>#respond" data-commentid="<?php echo $parent_comment->comment_ID; ?>" data-postid="<?php echo $post_id; ?>" data-belowelement="div-comment-<?php echo $parent_comment->comment_ID; ?>" data-respondelement="respond" data-replyto="Reply to <?php echo $parent_comment->comment_author; ?>" aria-label="Reply to <?php echo $parent_comment->comment_author; ?>">Reply</a>
                                                </div>
                                            </div>
                                            <?php $child_comments = get_comments(array(
                                                'parent'         => $parent_comment->comment_ID,
                                                'hierarchical'  => 'threaded',
                                                'status'        => 'approve',
                                                'orderby'       => 'date',
                                                'order'         => 'ASC'
                                            ));
                                            if (!empty($child_comments)) :
                                                foreach ($child_comments as $child_comment) :
                                                    $comment_number = get_comments(array(
                                                        'parent'       => $child_comment->comment_ID,
                                                        'hierarchical'  => 'threaded',
                                                        'count'         => true,
                                                        'status'        => 'approve',
                                                        'orderby'       => 'date',
                                                        'order'         => 'ASC'
                                                    )); ?>
                                                    <div class="pl-[15px] pb-[24px] mt-[24px]" id="comment-<?php echo $child_comment->comment_ID; ?>">
                                                        <div class="comment-replay-card-deffer">
                                                            <div class="comment-replay-card-deffer-inner">
                                                                <div>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M3.5 14.5H2.5V15.5H3.5V14.5ZM21.7071 15.2071C22.0976 14.8166 22.0976 14.1834 21.7071 13.7929L15.3431 7.42893C14.9526 7.03841 14.3195 7.03841 13.9289 7.42893C13.5384 7.81946 13.5384 8.45262 13.9289 8.84315L19.5858 14.5L13.9289 20.1569C13.5384 20.5474 13.5384 21.1805 13.9289 21.5711C14.3195 21.9616 14.9526 21.9616 15.3431 21.5711L21.7071 15.2071ZM2.5 4.5V14.5H4.5V4.5H2.5ZM3.5 15.5H21V13.5H3.5V15.5Z" fill="#1C3C19" />
                                                                    </svg>
                                                                </div>
                                                                <div class="comment-replay-card-deffer-inner-image-name-date-sec">
                                                                    <figure class="replay-card-image-controller">
                                                                        <img class="image-responsive" src="<?php echo get_avatar_url($child_comment->user_id); ?>" alt="single page author image ">
                                                                    </figure>
                                                                    <div class="replay-card-content-deffer">
                                                                        <h2 class="replay-card-content-title"><?php echo $child_comment->comment_author; ?></h2>
                                                                        <p class="comment-date-deffer"><?php echo get_comment_date('j F, Y', $child_comment) ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="comment-wrapper">
                                                                <p class="comment-dsc"><?php echo $child_comment->comment_content; ?></p>
                                                            </div>

                                                            <div class="comment-replay-card-deffer-reply-button-whapper">
                                                                <?php if (is_user_logged_in()) echo '<a class="reply-button" href="' . get_edit_comment_link($child_comment->comment_ID) . '">Edit</a>'; ?>
                                                                <a class="reply-button" rel="nofollow" href="<?php echo get_permalink($post_id); ?>/?replytocom=<?php echo $child_comment->comment_ID; ?>#respond" data-commentid="<?php echo $child_comment->comment_ID; ?>" data-postid="<?php echo $post_id; ?>" data-belowelement="div-comment-<?php echo $child_comment->comment_ID; ?>" data-respondelement="respond" data-replyto="Reply to <?php echo $child_comment->comment_author; ?>" aria-label="Reply to <?php echo $child_comment->comment_author; ?>">Reply</a>
                                                                <?php $comment_reply_txt = (!empty($comment_number) && $comment_number >= 2) ? '(' . $comment_number . ')More Replies' : '(' . $comment_number . ')More Reply';
                                                                echo (!empty($comment_number)) ? '<span id="load_button_' . $child_comment->comment_ID . '" class="reply-button show-comment cursor-pointer" data-comment_id="' . $child_comment->comment_ID . '" data-post_id="' . $post_id . '">' . $comment_reply_txt . '</span>' : ''; ?>
                                                            </div>
                                                        </div>
                                                        <?php echo (!empty($comment_number)) ? '<div id="load_child_' . $child_comment->comment_ID . '"></div>' : ''; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </section>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
        <?php if (!empty($related_posts)) : ?>
            <div class="single-related-sec">
                <div class="container mx-auto">
                    <h2 class="single-related-underline-title">Featured Resources</h2>
                    <div class="single-related-grid p">
                        <?php foreach ($related_posts as $post) :
                            setup_postdata($post);
                            get_template_part('template-parts/listing', 'card');
                        endforeach;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>