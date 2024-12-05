<?php get_header();

$cat1_slug = get_option('category_1');
$cat2_slug = get_option('category_2');
$cat3_slug = get_option('category_3');
$cat4_slug = get_option('category_4');
$cat5_slug = get_option('category_5');

$start_article = get_option('start_article_id');
$grow_article = get_option('grow_article_id');
$exit_article = get_option('exit_article_id');

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
$cat5_posts = new WP_Query(array(
    'post_type'        => 'post',
    'category_name'     => $cat5_slug,
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 6
));
$taxonomies = get_terms(array(
    'taxonomy'    => 'idea',
    'orderby'       => 'count',
    'order'         => 'DESC',
    'hide_empty'    => false,
    'number'        => 10
));
?>


<section class="hero-banner">
    <div class=" container mx-auto">
        <div class="hero-banner-inner">
            <div class="banner-info">
                <div class="hero-banner-subtitle-wrapper">
                    <h2 class="hero-banner-title">
                        Discover business
                        <span class="font-bold">
                            Ideas
                        </span>
                        you can
                        <span class="txt-rotate font-bold" data-period="2000" data-rotate='["Grow", "Exit", "Start"]'></span>
                        strategically
                    </h2>
                </div>
                <p class="hero-banner-subtitle line-clamp-3"><?php echo wp_strip_all_tags(get_page_by_path('about-us')->post_content); ?></p>
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


<?php if ($cat1_posts->have_posts()) :
    $cat1 = get_category_by_slug($cat1_slug); ?>
    <section class="home-idea-sec">
        <div class=" container mx-auto ">
            <img class="line-one" src="<?php echo get_template_directory_uri(); ?>/images/line-one.svg" alt="">
            <h2 class="home-page-common-title font-bold home-def-title">
                <img class="home-def-title-image" src="<?php echo get_template_directory_uri(); ?>/images/extra-line-after.svg" alt="def title after image">
                <?php echo $cat1->name; ?>
            </h2>
            <?php echo (!empty($cat1->description)) ? '<div class="common-half-dsc-wrapper"><p class="common-half-dsc">' . $cat1->description . '</p></div>' : ''; ?>
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


<?php if (!empty($taxonomies)) : ?>
    <section class="home-business-ideas-sec">
        <div class="container mx-auto">
            <h2 class="home-page-common-underline-title font-light">
                Business <span class="font-bold">Ideas</span>
            </h2>
            <div class="common-half-dsc-wrapper mt-[20px]">
                <p class="common-half-dsc">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                </p>
            </div>
            <div class="home-business-ideas-grid-wrapper">
                <?php foreach ($taxonomies as $taxonomy) :
                    get_template_part('template-parts/idea', 'card', array('idea' => $taxonomy));
                endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if ($cat2_posts->have_posts()) :
    $cat2 = get_category_by_slug($cat2_slug); ?>
    <section class="home-start-sec">
        <div class=" container mx-auto ">
            <img class="line-tow" src="<?php echo get_template_directory_uri(); ?>/images/line-tow.svg" alt="section line tow">
            <h2 class="home-page-common-title font-bold home-def-title">
                <img class="home-def-title-image" src="<?php echo get_template_directory_uri(); ?>/images/extra-line-after.svg" alt="def title after image">
                <?php echo $cat2->name; ?>
            </h2>
            <?php echo (!empty($cat2->description)) ? '<div class="common-half-dsc-wrapper"><p class="common-half-dsc">' . $cat2->description . '</p></div>' : ''; ?>
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


<?php if (!empty($start_article) && !is_null(get_post($start_article)) && 'publish' === get_post_status($start_article)) :
    $start_article_tips = get_post_meta($start_article, "tips", true);
    if (is_array($start_article_tips) && !empty($start_article_tips)) :
        $start_article_tips = array_values($start_article_tips); ?>
        <section class="home-start-business-sec ">
            <div class=" container mx-auto ">
                <h2 class="home-page-common-underline-title font-light">
                    <span class="font-bold">Start a Business:</span>&nbsp;
                    <span> 10 Reasons To Start a business</span>
                </h2>
                <div class="home-common-slider-wrapper">
                    <div class="swiper2">
                        <div class="swiper-wrapper">
                            <?php foreach ($start_article_tips as $key => $tip) :
                                get_template_part('template-parts/slider', 'card', array('key' => $key, 'tip' => $tip, 'link' => get_permalink($start_article)));
                            endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="home-idea-sec-common-btn-wrapper">
                    <a href="<?php echo get_permalink($start_article); ?>" class="common-btn">
                        view more <span class="icon-arrow"></span>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>


<?php if ($cat3_posts->have_posts()) :
    $cat3 = get_category_by_slug($cat3_slug); ?>
    <section class="home-grow-sec">
        <div class="container mx-auto">
            <img class="line-tow" src="<?php echo get_template_directory_uri(); ?>/images/line-tow.svg" alt="section line tow">
            <h2 class="home-page-common-title font-bold home-def-title">
                <img class="home-def-title-image" src="<?php echo get_template_directory_uri(); ?>/images/extra-line-after.svg" alt="def title after image">
                <?php echo $cat3->name; ?>
            </h2>
            <?php echo (!empty($cat3->description)) ? '<div class="common-half-dsc-wrapper"><p class="common-half-dsc">' . $cat3->description . '</p></div>' : ''; ?>
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


<?php if (!empty($grow_article) && !is_null(get_post($grow_article)) && 'publish' === get_post_status($grow_article)) :
    $grow_article_tips = get_post_meta($grow_article, "tips", true);
    if (is_array($grow_article_tips) && !empty($grow_article_tips)) :
        $grow_article_tips = array_values($grow_article_tips); ?>
        <section class="home-grow-your-business-sec">
            <div class="container mx-auto">
                <h2 class="home-page-common-underline-title font-light">
                    <span class=" font-bold">
                        Grow your Business:
                    </span>
                    10 Actionable Tips
                </h2>
                <div class="home-common-slider-wrapper">
                    <div class="swiper2">
                        <div class="swiper-wrapper">
                            <?php foreach ($grow_article_tips as $key => $tip) :
                                get_template_part('template-parts/slider', 'card', array('key' => $key, 'tip' => $tip, 'link' => get_permalink($grow_article)));
                            endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="home-idea-sec-common-btn-wrapper">
                    <a href="<?php echo get_permalink($grow_article); ?>" class="common-btn">
                        view more <span class="icon-arrow"></span>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>


<?php if ($cat4_posts->have_posts()) :
    $cat4 = get_category_by_slug($cat4_slug); ?>
    <section class="home-exit-sec">
        <div class="container mx-auto ">
            <img class="line-tow" src="<?php echo get_template_directory_uri(); ?>/images/line-tow.svg" alt="section line tow">
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


<?php if (!empty($exit_article) && !is_null(get_post($exit_article)) && 'publish' === get_post_status($exit_article)) :
    $exit_article_tips = get_post_meta($exit_article, "tips", true);
    if (is_array($exit_article_tips) && !empty($exit_article_tips)) :
        $exit_article_tips = array_values($exit_article_tips); ?>
        <section class="home-exit-strategy-sec">
            <div class="container mx-auto">
                <h2 class="home-page-common-underline-title font-light">
                    <span class=" font-bold">
                        Exit Strategy:
                    </span>
                    10 Tips to Exit Strategically
                </h2>
                <div class="home-common-slider-wrapper">
                    <div class="swiper2">
                        <div class="swiper-wrapper">
                            <?php foreach ($exit_article_tips as $key => $tip) :
                                get_template_part('template-parts/slider', 'card', array('key' => $key, 'tip' => $tip, 'link' => get_permalink($exit_article)));
                            endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="home-idea-sec-common-btn-wrapper">
                    <a href="<?php echo get_permalink($exit_article); ?>" class="common-btn">
                        view more <span class="icon-arrow"></span>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>


<?php if ($cat5_posts->have_posts()) :
    $cat5 = get_category_by_slug($cat5_slug); ?>
    <section class="home-blog-sec">
        <div class="container mx-auto">
            <h2 class="home-blog-sec-title"><?php echo $cat5->name; ?></h2>
            <div class="home-blog-grid-wrapper">
                <?php while ($cat5_posts->have_posts()) : $cat5_posts->the_post();
                    get_template_part('template-parts/listing', 'card');
                endwhile; ?>
            </div>
            <!-- need to work this section -->
            <div class="home-blog-sec-cta-wrapper">
                <a href="<?php echo get_category_link($cat5->term_id); ?>" class="common-btn">
                    Explore More <span class="icon-arrow"></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php get_footer(); ?>