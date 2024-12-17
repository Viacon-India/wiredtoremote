<?php get_header();

$archive_object = get_queried_object();
$desc = tag_description(get_the_archive_description());
$total_post_count = $GLOBALS['wp_query']->found_posts;
$post_count = $GLOBALS['wp_query']->post_count;
$paged = get_query_var('paged');
$page_count = $GLOBALS['wp_query']->max_num_pages;
$post_per_page = get_option('posts_per_page');
$archive_id = $archive_object->term_id;
$parent_id = $archive_object->parent;
$grand_parent_id = (!empty($parent_id)) ? get_category($parent_id)->parent : '';
$tag_id = (is_tag()) ? $archive_id : '';
$author_id = (is_author()) ? $archive_id : '';
$cat_id = (is_category()) ? $archive_id : ''; ?>


<section class="search-page">
    <div class="container mx-auto">
        <figure class="w-full h-[200px] md:h-[450px] mb-6 md:mb-8">
            <img class="w-full h-full object-cover rounded-[6px]" src="<?php echo get_template_directory_uri(); ?>/images/jobListing.jpg" alt=" footer bg" />
        </figure>
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
        <div class="search-page-title-wrapper">
            <div class="category-page-title-wrapper">
                <h2 class="category-page-title"><?php echo wp_strip_all_tags(single_cat_title('', false)); ?></h2>
            </div>
            <p class="text-[16px] md:text-[18px] text-[#091A27] pt-4 w-[95%]">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            <?php echo (!empty($desc)) ? '<div class="category-page-dsc-wrapper"><p class="category-page-dsc">' . $desc . '</p></div>' : ''; ?>
        </div>
        <?php if (have_posts()) :
            echo '<div id="load_more_div" class="search-page-grid-wrapper">';
            while (have_posts()) : the_post();
                get_template_part('template-parts/listing', 'card');
            endwhile;
            echo '</div>';
            if (!($total_post_count <= $post_per_page) && !($paged >= $page_count)) : ?>
                <div class="search-page-button-wrapper">
                    <button class="common-btn" data-paged="<?php echo $paged; ?>" data-page_count="<?php echo $page_count; ?>" data-user_id="<?php echo $author_id; ?>" data-tag_id="<?php echo $tag_id; ?>" data-cat_id="<?php echo $cat_id; ?>" id="load_more" aria-label="More Post">
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
            echo '<div class="search-page-button-wrapper">';
            echo '<p class="condition-msg !text-center">Sorry, but no articles available with "<span class="uppercase">' . wp_strip_all_tags(single_cat_title('', false)) . '</span>".</p>';
            echo '</div>';
        endif; ?>
    </div>
</section>

<?php get_footer(); ?>