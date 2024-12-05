<?php get_header(); ?>
<section class="error-page">
    <div class=" container mx-auto h-full">
        <div class="error-page-inner">

            <figure class="error-page-img-wrapper">
                <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/404.svg" alt="404 page image">
            </figure>

            <div class="error-page-dsc-wrapper">
                <p class="error-page-dsc">
                    WE ARE SORRY, BUT THE PAGE YOU REQUESTED
                    WAS NOT FOUND
                </p>
            </div>

            <div class="error-page-btn-wrapper">
                <a href="<?php echo home_url(); ?>" class="error-btn">
                    go to home page <span class="icon-arrow"></span>
                </a>
            </div>

        </div>
    </div>
</section>


<?php get_footer(); ?>