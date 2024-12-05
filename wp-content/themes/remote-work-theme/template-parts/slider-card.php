<?php $key =  $args['key'];
$tip =  $args['tip']; ?>

<div class="swiper-slide">
    <a href="<?php echo $args['link']; ?>">
        <div class="cloud-icon-card">
            <figure class="cloud-icon-card-wrapper">
                <img class="img-responsive z-[1]" src="<?php echo get_template_directory_uri(); ?>/images/icon-cloud.svg" alt="cloud-icon-img">
                <span class="cloud-icon-text z-[2]"><?php echo $key+1;?></span>
            </figure>
            <h2 class="cloud-icon-card-title"><?php echo $tip['title']; ?></h2>
            <p class="cloud-icon-card-dsc"><?php echo $tip['content']; ?></p>
        </div>
    </a>
</div>