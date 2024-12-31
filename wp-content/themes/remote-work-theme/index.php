<?php get_header();

$total_post_count = $GLOBALS['wp_query']->found_posts;
$post_count = $GLOBALS['wp_query']->post_count;
$paged = get_query_var('paged');
$page_count = $GLOBALS['wp_query']->max_num_pages;
$post_per_page = get_option('posts_per_page'); ?>


<section class="search-page">
    <div class="container mx-auto">
        <div class="breadcrumbs-wrappers">
            <?php echo '<ul class="breadcrumbs">';
                echo '<li class="bread-list"><a href="'.home_url().'">Home</a></li>';
                echo '<li class="bread-list">Blog</li>';
            echo '</ul>'; ?>
        </div>
        <div class="search-page-title-wrapper">
            <div class="category-page-title-wrapper">
                <h1 class="category-page-title">Blog</h1>
            </div>
        </div>
        <?php if(have_posts()) :
            echo '<div id="load_more_div" class="search-page-grid-wrapper">';
                while (have_posts()) : the_post();
                    get_template_part('template-parts/listing', 'card');
                endwhile;
            echo '</div>';
            if (!($total_post_count<= $post_per_page) && !($paged >= $page_count)) : ?>
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
                echo '<p class="condition-msg !text-center">Sorry, but no latest articles available.</p>';
            echo '</div>';
        endif; ?>
    </div>
</section>

<?php get_footer(); ?>