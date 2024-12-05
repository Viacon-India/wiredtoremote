<?php $post_ID = get_the_ID();
$cat = get_the_category(); ?>

<div class="blog-card">
    <a href="<?php echo get_the_permalink($post_ID); ?>">
        <figure class="blog-card-figure">
            <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail($post_ID, 'default-thumbnail', array('class' => 'img-responsive')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/blog-1.jpg" alt="blog-img-1" class="img-responsive">
            <?php endif; ?>
        </figure>
    </a>
    <div class="blog-card-content">
        <?php echo '<a class="blog-card-cat" href="'.esc_url(get_category_link($cat[0]->term_id)).'" title="'.$cat[0]->cat_name.'">'.$cat[0]->cat_name.'</a>'; ?>
        <a href="<?php echo get_the_permalink($post_ID); ?>" class="blog-card-title"><?php echo the_title_attribute('echo=0'); ?></a>
    </div>
</div>