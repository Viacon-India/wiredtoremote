<?php $facebook = get_option('facebook');
$linkedin = get_option('linkedin');
$exclude = (!empty($post)) ? array($post->ID) : '';
$taxonomy_list = (!empty($post)) ? get_the_terms($post->ID, 'idea') : '';
$taxonomy = (!empty($post) && is_array(($taxonomy_list))) ? get_the_terms($post->ID, 'idea')[0] : '';
$categories = array(get_option('category_1'), get_option('category_2'), get_option('category_3'), get_option('category_4')); ?>

<div class="side-bar-wrapper">

    <aside class="aside">
        <?php if (!empty($categories) && !empty($taxonomy)) :
            foreach ($categories as $cat_slug) :
                $child_posts = new WP_Query(array(
                    'post_type'       => 'post',
                    'category_name'     => $cat_slug,
                    'post_status'       => 'publish',
                    'post__not_in'      => $exclude,
                    'orderby'           => 'date',
                    'order'             => 'DESC',
                    'taxonomy'          => 'idea',
                    'term'              => $taxonomy->slug,
                    'posts_per_page'    => 4
                ));
                if ($child_posts->have_posts()) : ?>
                    <div class="aside-common-bg-wrapper">
                        <div class="aside-common-bg-title-wrapper aside-title-wrapper-under-line">
                            <h2 class="aside-common-bg-wrapper-title"><?php echo ucwords($cat_slug); ?></h2>
                            <button class="accordion">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/down-icon.svg" alt="side bar icon">
                            </button>
                        </div>

                        <div class="panel">
                            <div class="side-bar-card-sec-wrapper ">
                                <?php while ($child_posts->have_posts()) : $child_posts->the_post();
                                    get_template_part('template-parts/sidebar', 'card');
                                endwhile; ?>
                            </div>
                        </div>
                    </div>
        <?php endif;
            endforeach;
        endif; ?>

        <?php if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false) || (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false))) : ?>
            <div class="aside-common-bg-wrapper">
                <div class="aside-common-bg-title-wrapper">
                    <h2 class="aside-common-bg-wrapper-title-follow">
                        Follow Us
                    </h2>
                </div>
                <?php echo '<div class="aside-social-icon-wrapper">';
                if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false)) echo '<a class="share-icon" href="' . $facebook . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-facebook"></span></a>';
                if (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false)) echo '<a class="share-icon" href="' . $linkedin . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-linkedin"></span></a>';
                echo '</div>'; ?>
            </div>
        <?php endif; ?>
    </aside>
</div>