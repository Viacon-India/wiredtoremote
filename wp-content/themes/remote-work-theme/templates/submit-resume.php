<?php
/* Template Name: Submit Resume Temp */
get_header();
?>

<section class="contact-us-page">
    <div class="container mx-auto">
        <div class="author-page-breadcrumbs-wrappers">
            <ul class="breadcrumbs">
                <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="bread-list"><?php echo strip_tags(get_the_title()); ?></li>
            </ul>
        </div>
        <div class="contact-us-page-inner">
            <div class="contact-us-content-sec">
                <h2 class="contact-us-page-underline-title"><?php echo strip_tags(get_the_title()); ?></h2>
                <div class="contact-us-page-dsc-wrapper">
                    <?php the_content(); ?>
                </div>
            </div>

            <div class="contact-us-image-sec">
                <figure class="contact-us-image-wrapper">
                    <?php if ( has_post_thumbnail()) :
                        echo get_the_post_thumbnail( $post_id, 'full');
                    else :
                        echo '<img src="'.get_template_directory_uri().'/images/submit-resume.png" alt="Resume Upload image" />';
                    endif; ?>
                </figure>
            </div>
        </div>
    </div>
</section>



<?php
get_footer();
?>