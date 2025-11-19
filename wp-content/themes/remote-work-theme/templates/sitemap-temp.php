<?php 
/* Template Name: Sitemap Page
*/ 
get_header();

$categories = get_categories(array(
    'hide_empty' => true,
));
?>

<section class="sitemap-sec py-8 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <!-- Page Title -->
        <div class="page-title text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>
            <div class="w-20 h-1 bg-gray-300 mx-auto"></div>
        </div>

        <div class="sitemap-content">
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                
                <!-- Left Column - Main Pages -->
                <div class="sitemap-column">
                    <ul class="space-y-4">
                        <!-- Static Links -->
                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/'); ?>">
                                Home
                            </a>
                        </li>
                        
                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/about-us'); ?>">
                                About Us
                            </a>
                        </li>

                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/contact-us'); ?>">
                                Contact Us
                            </a>
                        </li>

                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/write-for-us'); ?>">
                                Write For Us
                            </a>
                        </li>

                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/advertise'); ?>">
                                Advertise
                            </a>
                        </li>

                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/terms-and-conditions'); ?>">
                                Terms And Conditions
                            </a>
                        </li>

                        <li class="sitemap-item">
                            <a class="sitemap-link" href="<?php echo home_url('/privacy-policy'); ?>">
                                Privacy Policy
                            </a>
                        </li>

                        <!-- Categories Heading -->
                        <li class="sitemap-item">
                            <span class="sitemap-heading">Category</span>
                        </li>
                    </ul>
                </div>

                <!-- Right Column - Categories -->
                <div class="sitemap-column">
                    <ul class="space-y-4">
                        <?php foreach ($categories as $category) : ?>
                            <li class="sitemap-item">
                                <a class="sitemap-link" href="<?php echo get_category_link($category->term_id); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
.sitemap-item {
    position: relative;
    padding-left: 0;
}

.sitemap-link {
    display: block;
    padding: 8px 0;
    color: #374151;
    text-decoration: none;
    font-size: 16px;
    line-height: 1.5;
    transition: all 0.3s ease;
    border-bottom: 1px solid transparent;
}

.sitemap-link:hover {
    color: #1A2A6C;
    border-bottom-color: #1A2A6C;
    padding-left: 8px;
}

.sitemap-heading {
    display: block;
    padding: 8px 0;
    color: #1A2A6C;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.5;
    border-bottom: 2px solid #1A2A6C;
}

/* Simple bullet points for links */
.sitemap-item:not(:last-child) .sitemap-link::before {
    content: "•";
    color: #9CA3AF;
    margin-right: 8px;
    transition: all 0.3s ease;
}

.sitemap-item .sitemap-link:hover::before {
    color: #1A2A6C;
    transform: scale(1.2);
}

/* Remove bullet from heading */
.sitemap-heading::before {
    display: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sitemap-sec {
        padding: 2rem 1rem;
    }
    
    .grid-cols-2 {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .sitemap-link {
        font-size: 15px;
        padding: 10px 0;
    }
}
</style>

<?php get_footer(); ?>