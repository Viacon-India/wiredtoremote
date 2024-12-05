<?php get_header();

$total_post_count = $GLOBALS['wp_query']->found_posts;
$post_count = $GLOBALS['wp_query']->post_count;
$paged = get_query_var('paged');
$post_per_page = get_option('posts_per_page');
$page_count = $GLOBALS['wp_query']->max_num_pages;
$search = get_search_query(); ?>

<section class="search-page">
    <div class="container mx-auto">
        <div class="search-page-title-wrapper">
            <h2 class="search-page-title">
                <span class="font-[300]">
                    Search:
                </span>
                <span class="font-bold"><?php echo $search; ?></span>
            </h2>
        </div>
        <?php if (have_posts()) :
            echo '<div id="load_more_div" class="search-page-grid-wrapper">';
            while (have_posts()) : the_post();
                get_template_part('template-parts/listing', 'card');
            endwhile;
            echo '</div>';
            if (!($total_post_count <= $post_per_page) && !($paged >= $page_count)) : ?>
                <div class="search-page-button-wrapper">
                    <button class="common-btn" data-paged="<?php echo $paged; ?>" data-page_count="<?php echo $page_count; ?>" data-search="<?php echo $search; ?>" id="load_more" aria-label="More Post">
                        Load More <span class="icon-arrow"></span>
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
            echo '<p class="condition-msg !text-center">Sorry, but nothing matched your search "<span class="uppercase">' . $search . '</span>". Please try again with some different keywords.</p>';
            echo '</div>';
        endif; ?>
    </div>
</section>

<?php get_footer(); ?>