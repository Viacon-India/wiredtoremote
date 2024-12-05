<?php $post_ID = get_the_ID();
$cat = get_the_category(); ?>

<div class="swiper-slide">
    <div class="category-card">
        <a href="<?php echo get_the_permalink($post_ID); ?>">
            <figure class="category-card-figure">
                <?php if (has_post_thumbnail()) : ?>
                    <?php echo get_the_post_thumbnail($post_ID, 'default-thumbnail', array('class' => 'img-responsive')); ?>
                <?php else : ?>
                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/c4.jpg" alt="">
                <?php endif; ?>
            </figure>
        </a>
        <div class="category-card-content">
            <?php echo '<a class="category-card-cat" href="'.esc_url(get_category_link($cat[0]->term_id)).'" title="'.$cat[0]->cat_name.'">'.$cat[0]->cat_name.'</a>'; ?>
            <a href="<?php echo get_the_permalink($post_ID); ?>" class="category-card-title"><?php echo the_title_attribute('echo=0'); ?></a>
        </div>
    </div>
</div>