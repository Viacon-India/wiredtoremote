<?php get_header();

$cat1_slug = get_option('category_1');
$cat2_slug = get_option('category_2');
$cat3_slug = get_option('category_3');
$cat4_slug = get_option('category_4');

$cat1_posts = new WP_Query(array(
    'post_type'        => 'post',
    'category_name'     => $cat1_slug,
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 6
));
$cat2_posts = new WP_Query(array(
    'post_type'        => 'post',
    'category_name'     => $cat2_slug,
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 6
));
$cat3_posts = new WP_Query(array(
    'post_type'        => 'post',
    'category_name'     => $cat3_slug,
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 6
));
$cat4_posts = new WP_Query(array(
    'post_type'        => 'post',
    'category_name'     => $cat4_slug,
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 6
));
?>


<section class="hero-banner">
    <div class=" container mx-auto">
        <div class="hero-banner-inner">
            <div class="banner-info">
                <div class="hero-banner-subtitle-wrapper">
                    <h2 class="hero-banner-title">
                    Quit
                        <span class="font-bold">
                        CUBICLES
                        </span>
                        . Work From
                        <span class="txt-rotate font-bold" data-period="2000" data-rotate='["Cafes", "Hotels", "Anywhere"]'></span>.
                        <br>Inspire Change
                    </h2>
                </div>
                <p class="hero-banner-subtitle line-clamp-3">
                    A leading platform for digital nomads, remote working enthusiasts, and active job seekers. Make the change, switch To remote.
                    <?php //echo wp_strip_all_tags(get_page_by_path('about-us')->post_content); ?>
                </p>
                <a href="<?php echo home_url('/about-us'); ?>" class="common-btn">About us <span class="icon-arrow"></span></a>
            </div>
            <div class="banner-image-sec">
                <figure class="banner-image-sec-wrapper">
                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/home-hero.svg" alt="hero-banner-img">
                </figure>
            </div>
        </div>
    </div>
</section>


<?php
if ($cat1_posts->have_posts()) :
    $cat1 = get_category_by_slug($cat1_slug); ?>
    <section class="home-idea-sec">
        <div class=" container mx-auto ">
            <h2 class="home-page-common-title font-bold home-def-title">
                <img class="home-def-title-image" src="<?php echo get_template_directory_uri(); ?>/images/extra-line-after.svg" alt="def title after image">
                <?php echo $cat1->name; ?>
            </h2>
            <?php echo (!empty($cat1->description)) ? '<p class="text-[#091A27] text-[18px] italic w-full md:w-[60%]">' . $cat1->description . '</p>' : ''; ?>
            <div class="cat-common-slider-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($cat1_posts->have_posts()) : $cat1_posts->the_post();
                            get_template_part('template-parts/default', 'card');
                        endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="home-idea-sec-common-btn-wrapper">
                <a href="<?php echo get_category_link($cat1->term_id); ?>" class="common-btn">
                    Explore the <?php echo $cat1->name; ?> category <span class="icon-arrow"></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>




<?php if ($cat2_posts->have_posts()) :
    $cat2 = get_category_by_slug($cat2_slug); ?>
    <section class="home-start-sec bg-[#DDF5FF]">
        <div class=" container mx-auto ">
            <h2 class="home-page-common-title separator-sec-title">
                <?php echo $cat2->name; ?>
            </h2>
            <?php echo (!empty($cat2->description)) ? '<p class="text-[#091A27] text-[18px] italic w-full md:w-[60%]">' . $cat2->description . '</p>' : ''; ?>
            <div class="cat-common-slider-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($cat2_posts->have_posts()) : $cat2_posts->the_post();
                            get_template_part('template-parts/default', 'card');
                        endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="home-idea-sec-common-btn-wrapper">
                <a href="<?php echo get_category_link($cat2->term_id); ?>" class="common-btn">
                    Explore the <?php echo $cat2->name; ?> category <span class="icon-arrow"></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>





<section class="home-grow-sec">
    <div class="container mx-auto">
        <div class="flex flex-col items-center lg:flex-row">
            <div class="w-full lg:w-[50%]">
                <h2 class="text-[#091A27] text-[32px] sm:text-[50px] md:text-[54px] leading-[1] font-bold">An Optimized Resume No Employer Can Turn Down</h2>
                <p class="text-[18px] text-[#091A27] italic pt-4 md:pt-6 lg:pt-10 w-full lg:w-[60%]">Your resume could be the reason why the Best Remote Employers are not Contacting You. Get your Current resume Fixed, Or Allow Us to Build One From the Scratch.</p>
                <div class="home-idea-sec-common-btn-wrapper !justify-start">
                <a href="<?php echo home_url('submit-resume'); ?>" class="common-btn">
                        Submit Resume  <span class="icon-arrow"></span>
                    </a>
                </div>
                <figure class="w-full h-fit pt-10">
                    <img class="w-full h-full object-contain" src="<?php echo get_template_directory_uri(); ?>/images/line-art.svg" alt="lineArt">
                </figure>
            </div>
            <div class="w-full lg:w-[50%]">
                <figure class="w-full h-fit">
                    <img class="w-full h-full object-contain" src="<?php echo get_template_directory_uri(); ?>/images/line-art2.svg" alt="lineArt2">
                </figure>
            </div>
        </div>
    </div>
</section>





<?php if ($cat3_posts->have_posts()) :
    $cat3 = get_category_by_slug($cat3_slug); ?>
    <section class="home-exit-sec bg-[#DDF5FF]">
        <div class="container mx-auto ">
            <h2 class="home-page-common-title separator-sec-title">
                <?php echo $cat3->name; ?>
            </h2>
            <?php echo (!empty($cat3->description)) ? '<p class="text-[#091A27] text-[18px] italic w-full md:w-[60%]">' . $cat3->description . '</p>' : ''; ?>
            <div class="cat-common-slider-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($cat3_posts->have_posts()) : $cat3_posts->the_post();
                            get_template_part('template-parts/default', 'card');
                        endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="home-idea-sec-common-btn-wrapper">
                <a href="<?php echo get_category_link($cat3->term_id); ?>" class="common-btn">
                    Explore the <?php echo $cat3->name; ?> category <span class="icon-arrow"></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>



<?php if ($cat4_posts->have_posts()) :
    $cat4 = get_category_by_slug($cat4_slug); ?>
    <section class="home-grow-sec">
        <div class="container mx-auto">
            <h2 class="home-page-common-title font-bold home-def-title">
                <img class="home-def-title-image" src="<?php echo get_template_directory_uri(); ?>/images/extra-line-after.svg" alt="def title after image">
                <?php echo $cat4->name; ?>
            </h2>
            <?php echo (!empty($cat4->description)) ? '<div class="common-half-dsc-wrapper"><p class="common-half-dsc">' . $cat4->description . '</p></div>' : ''; ?>
            <div class="cat-common-slider-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($cat4_posts->have_posts()) : $cat4_posts->the_post();
                            get_template_part('template-parts/default', 'card');
                        endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="home-idea-sec-common-btn-wrapper">
                <a href="<?php echo get_category_link($cat4->term_id); ?>" class="common-btn">
                    Explore the <?php echo $cat4->name; ?> category <span class="icon-arrow"></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>