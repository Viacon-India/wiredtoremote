<?php get_header();

while (have_posts()) : the_post();
    $post_id = get_the_ID(); ?>

    <section class="about-us-page">
        <div class="container mx-auto">
            <div class="breadcrumbs-wrappers">
                <ul class="breadcrumbs">
                    <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                    <li class="bread-list"><?php echo strip_tags(get_the_title()); ?></li>
                </ul>
            </div>

            <div class="about-us-content">
                <span>
                    <h2 class="about-us-page-title"><?php echo strip_tags(get_the_title()); ?></h2>
                </span>
                <?php the_content(); ?>
            </div>
            
            <?php if ( has_post_thumbnail()) :
                echo '<figure class="about-us-bottom-img-wrapper">';
                    echo get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'img-responsive' ) );
                echo '</figure>';
            else :
                if('about-us' == get_post_field( 'post_name', get_post())) :
                    echo '<figure class="about-us-bottom-img-wrapper">';
                        echo '<img class="img-responsive" src="'.get_template_directory_uri().'/images/about.svg" alt="about us image" />';
                    echo '</figure>';
                endif;
            endif; ?>
        </div>
    </section>

<?php endwhile;

get_footer(); ?>