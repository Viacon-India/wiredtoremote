<?php $post_ID = get_the_ID(); ?>

<a href="<?php echo get_the_permalink($post_ID); ?>" class="side-card">
    <figure class="side-card-mg-controller">
        <?php if (has_post_thumbnail()) : ?>
            <?php echo get_the_post_thumbnail($post_ID, 'sidebar-thumbnail', array('class' => 'img-responsive')); ?>
        <?php else : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/side.jpg" class="img-responsive" alt="Radiant Beauty" decoding="async">
        <?php endif; ?>
    </figure>
    <div class="side-card-content">
        <h4 class="side-card-content-title"><?php echo the_title_attribute('echo=0'); ?></h4>
    </div>
</a>