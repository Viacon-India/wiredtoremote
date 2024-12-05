<?php get_header();

$archive_object = get_queried_object();
$cat_id = $archive_object->term_id;
$desc = wp_strip_all_tags(category_description());
$total_post_count = $GLOBALS['wp_query']->found_posts;
$post_count = $GLOBALS['wp_query']->post_count;
$paged = get_query_var('paged');
$page_count = $GLOBALS['wp_query']->max_num_pages;
$post_per_page = get_option('posts_per_page');
$children = get_terms($archive_object->taxonomy, array('parent' => $cat_id, 'orderby' => 'count', 'order' => 'DESC')); ?>

<section class="category-page">
    <div class="container mx-auto">
        <div class="breadcrumbs-wrappers">
            <?php echo '<ul class="breadcrumbs">';
            echo '<li class="bread-list"><a href="' . home_url() . '">Home</a></li>';
            $parent_id = $archive_object->parent;
            $breadcrumb = '<li class="bread-list">' . wp_strip_all_tags(single_cat_title('', false)) . '</li>';
            while ($parent_id > 0) {
                $parent_cat = get_category($parent_id);
                $breadcrumb = '<li class="bread-list"><a href="' . get_category_link($parent_id) . '" title="' . $parent_cat->name . '">' . $parent_cat->name . '</a></li>' . $breadcrumb;
                $parent_id = $parent_cat->parent;
            }
            echo $breadcrumb;
            echo '</ul>'; ?>
        </div>
        <div class="category-page-title-wrapper">
            <h2 class="category-page-title"><?php echo wp_strip_all_tags(single_cat_title('', false)); ?></h2>
        </div>
        <?php echo (!empty($desc)) ? '<div class="category-page-dsc-wrapper"><p class="category-page-dsc">' . $desc . '</p></div>' : ''; ?>
        <?php if (!empty($children)) :
            echo '<div class="cat-page-common-all-slider-wrapper ">';
            foreach ($children as $subcat) :
                $child_posts = new WP_Query(array(
                    'post_type'        => 'post',
                    'cat'               => $subcat->term_id,
                    'post_status'       => 'publish',
                    'orderby'           => 'date',
                    'order'             => 'DESC',
                    'posts_per_page'    => 6
                )); ?>
                <div class="cat-sec">
                    <div class="category-page-common-slider-title-wrapper">
                        <h3 class="category-page-common-slider-title"><a href="<?php echo esc_url(get_term_link($subcat, $subcat->taxonomy)); ?>"><?php echo $subcat->name; ?></a></h3>
                    </div>
                    <?php if (!empty($subcat->description)) echo '<div class="common-half-dsc-wrapper"><p class="category-page-common-slider-dsc">' . $subcat->description . '</p></div>'; ?>
                    <div class="category-idea-common-slider-wrapper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php while ($child_posts->have_posts()) : $child_posts->the_post();
                                    get_template_part('template-parts/default', 'card');
                                endwhile; ?>
                            </div>
                        </div>
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
        elseif (have_posts()) :
            echo '<div id="load_more_div" class="home-blog-grid-wrapper">';
            while (have_posts()) : the_post();
                get_template_part('template-parts/listing', 'card');
            endwhile;
            echo '</div>';
            if (!($total_post_count <= $post_per_page) && !($paged >= $page_count)) : ?>
                <div class="search-page-button-wrapper">
                    <button class="common-btn" data-paged="<?php echo $paged; ?>" data-page_count="<?php echo $page_count; ?>" data-cat_id="<?php echo $cat_id; ?>" id="load_more" aria-label="More Post">
                        Explore More <span class="icon-arrow"></span>
                    </button>
                </div>
                <div class="hidden">
                    <?php the_posts_pagination(array(
                        'mid_size' => 10,
                        'end_size'  => 10,
                        'total' => ceil($post_count / $post_per_page),
                        'prev_text' => '<<',
                        'next_text' => '>>'
                    )); ?>
                </div>
        <?php endif;
        else :
            echo '<div class="cat-page-common-all-slider-wrapper ">';
            echo '<p class="condition-msg !text-center">Sorry, but no articles available with "<span class="uppercase">' . wp_strip_all_tags(single_cat_title('', false)) . '</span>".</p>';
            echo '</div>';
        endif; ?>
    </div>
</section>

<?php get_footer(); ?>