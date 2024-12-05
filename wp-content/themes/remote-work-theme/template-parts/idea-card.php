<?php $taxonomy =  $args['idea'];
$thumbnail_id = get_term_meta( $taxonomy->term_id, 'tax_image_id', true );
$image = ($thumbnail_id)?wp_get_attachment_image_url( $thumbnail_id, 'idea-thumbnail' ):''; ?>

<a href="<?php echo get_term_link($taxonomy->term_id, 'idea'); ?>">     
    <div class="square-icon-card skew glow">
        <figure>
            <?php if(!empty($thumbnail_id)) :
                echo '<img src="'.$image.'" alt="card" />';
            endif; ?>
        </figure>
        <h2 class="square-icon-title"><?php echo $taxonomy->name; ?></h2>
    </div>
</a>


