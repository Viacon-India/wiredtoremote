<?php get_header();

$taxonomy = get_queried_object();
$idea = $taxonomy->name;
$desc = $taxonomy->description;
$page_count = $GLOBALS['wp_query']->max_num_pages;
$post_count = $GLOBALS['wp_query']->found_posts;
$post_per_page = get_option('posts_per_page');

$cat1_slug = get_option('category_1');
$cat2_slug = get_option('category_2');
$cat3_slug = get_option('category_3');
$cat4_slug = get_option('category_4');
$business = (isset($_GET['business'])) ? $_GET['business'] : $cat1_slug;
$cat_id = get_category_by_slug($business)->term_id;
$children = get_terms('category', array('parent' => $cat_id, 'orderby' => 'count', 'order' => 'DESC')); ?>


<section class="category-page">
    <div class="container mx-auto">
        <div class="breadcrumbs-wrappers">
            <ul class="breadcrumbs">
                <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="bread-list"><?php echo $idea; ?></li>
            </ul>
        </div>
        <div class="cat-common-button-grid">
            <?php echo ($business == $cat1_slug) ? '<span class="cat-common-button cat-common-button-active">' . ucwords($cat1_slug) . '</span>' : '<a href="' . get_term_link($taxonomy->term_id, 'idea') . '" class="cat-common-button">' . ucwords($cat1_slug) . '</a>'; ?>
            <?php echo ($business == $cat2_slug) ? '<span class="cat-common-button cat-common-button-active">' . ucwords($cat2_slug) . '</span>' : '<a href="' . get_term_link($taxonomy->term_id, 'idea') . '?business=' . $cat2_slug . '" class="cat-common-button">' . ucwords($cat2_slug) . '</a>'; ?>
            <?php echo ($business == $cat3_slug) ? '<span class="cat-common-button cat-common-button-active">' . ucwords($cat3_slug) . '</span>' : '<a href="' . get_term_link($taxonomy->term_id, 'idea') . '?business=' . $cat3_slug . '" class="cat-common-button">' . ucwords($cat3_slug) . '</a>'; ?>
            <?php echo ($business == $cat4_slug) ? '<span class="cat-common-button cat-common-button-active">' . ucwords($cat4_slug) . '</span>' : '<a href="' . get_term_link($taxonomy->term_id, 'idea') . '?business=' . $cat4_slug . '" class="cat-common-button">' . ucwords($cat4_slug) . '</a>'; ?>
        </div>
        <div class="cat-cb-sec">
            <h2 class="cat-cb-sec-title cat-cb-sec-title-underline"><?php echo $idea; ?></h2>
            <?php echo (!empty($desc)) ? '<div class="cat-cb-sec-dsc-wrapper"><p class="cat-cb-sec-dsc">' . $desc . '</p></div>' : ''; ?>
        </div>

        <?php if (!empty($children)) :
            echo '<div class="cat-page-common-all-slider-wrapper ">';
            foreach ($children as $subcat) :
                $child_posts = new WP_Query(array(
                    'post_type'        => 'post',
                    'cat'               => $subcat->term_id,
                    'post_status'       => 'publish',
                    'orderby'           => 'date',
                    'order'             => 'DESC',
                    'taxonomy'          => 'idea',
                    'term'              => $taxonomy->slug,
                    'posts_per_page'    => 6
                )); ?>
                <div class="cat-sec">
                    <div class="category-page-common-slider-title-wrapper">
                        <h3 class="category-page-common-slider-title"><a href="<?php echo esc_url(get_term_link($subcat, $subcat->taxonomy)); ?>"><?php echo $subcat->name; ?></a></h3>
                        <!-- <a href="<?php // echo get_category_link($subcat->term_id); ?>" class="small-common-btn">view more <span class="icon-arrow"></span></a> -->

                    </div>
                    <?php if (!empty($subcat->description)) echo '<div class="common-half-dsc-wrapper"><p class="category-page-common-slider-dsc">' . $subcat->description . '</p></div>'; ?>
                    <div class="category-idea-common-slider-wrapper">
                        <?php if ($child_posts->have_posts()) : ?>
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?php while ($child_posts->have_posts()) : $child_posts->the_post();
                                        get_template_part('template-parts/default', 'card');
                                    endwhile; ?>
                                </div>
                            </div>
                        <?php else :
                            echo '<p class="condition-msg !text-center">Sorry, but no articles available with "<span class="uppercase">' . $subcat->name . '</span>" under "<span class="uppercase">' . $idea . '</span>". Please go for different "IDEA"</p>';
                        endif; ?>
                    </div>
                    <!-- <div class="category-slider-pagination-wrapper">
                                <ul class="slider-pagination">
                                    <a href="#"><span class="icon-arrow-left"></span></a>
                                    <a href="#">1</a>
                                    <a class="pagination-active" href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#"><span class="icon-arrow-right "></span></a>
                                </ul>
                            </div> -->
                </div>
        <?php endforeach;
            echo '</div>';
        else :
            echo '<div class="cat-page-common-all-slider-wrapper ">';
            echo '<p class="condition-msg !text-center">Sorry, but no articles available with "<span class="uppercase">' . ucwords($business) . '</span>" under "<span class="uppercase">' . wp_strip_all_tags(single_cat_title('', false)) . '</span>".</p>';
            echo '</div>';
        endif; ?>

    </div>
</section>

<?php get_footer(); ?>