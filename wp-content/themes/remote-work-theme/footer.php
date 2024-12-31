        </main>
        <?php $footer_text = get_option('footer_text');
        $subscription_text = get_option('subscription_text');
        $facebook = get_option('facebook');
        $linkedin = get_option('linkedin'); ?>
        <footer class="footer-wrapper">
            <div class="footer-sec">
                <div class="container mx-auto">
                    <div class="footer-main">
                        <div class="footer-logo-sec f-common-pt">
                            <a href="<?php echo home_url(); ?>">
                                <figure class="rounded-none m-0 w-[270px] h-[38px] mb-[22px]">
                                    <?php if (function_exists('footer_logo_url')) {
                                        if (is_file(realpath($_SERVER["DOCUMENT_ROOT"]) . parse_url(footer_logo_url())['path'])) {
                                            echo '<img class="w-full h-full object-cover" src="' . footer_logo_url() . '" alt="logo" />';
                                        } else {
                                            echo '<span class="w-full h-full object-cover">' . get_bloginfo('name') . '</span>';
                                        }
                                    } else {
                                        echo '<span class="w-full h-full object-cover">' . get_bloginfo('name') . '</span>';
                                    } ?>
                                </figure>
                            </a>
                            <?php if (!empty($footer_text)) echo '<p class="footer-desc">' . $footer_text . '</p>'; ?>
                        </div>
                        <div class="footer-detail">
                            <?php if (isset(get_nav_menu_locations()['company-menu'])) :
                                echo '<div class="footer-detail-small-sec">';
                                $useful_menu = get_term(get_nav_menu_locations()['company-menu'], 'nav_menu');
                                $useful_menu_items = wp_get_nav_menu_items($useful_menu->term_id);
                                $menu_items_with_children = array();
                                echo '<h2 class="footer-c-title mb-[1.5rem] md:mb-9">' . $useful_menu->name . '</h2>';
                                echo '<ul>';
                                foreach ($useful_menu_items as $menu_item) {
                                    if ($menu_item->menu_item_parent && !in_array($menu_item->menu_item_parent, $menu_items_with_children)) {
                                        array_push($menu_items_with_children, $menu_item->menu_item_parent);
                                    }
                                }
                                foreach ($useful_menu_items as $menu_item) :
                                    $parent_ID = $menu_item->ID;
                                    if ($menu_item->menu_item_parent == 0) :
                                        echo '<li><a class="footer-link" href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                                    endif;
                                endforeach;
                                echo '</ul>';
                                echo '</div>';
                            endif; ?>
                            <?php if (isset(get_nav_menu_locations()['categories-menu'])) :
                                echo '<div class="footer-detail-small-sec">';
                                $footer_menu = get_term(get_nav_menu_locations()['categories-menu'], 'nav_menu');
                                $footer_menu_items = wp_get_nav_menu_items($footer_menu->term_id);
                                $menu_items_with_children = array();
                                echo '<h2 class="footer-c-title mb-[1.5rem] md:mb-9">' . $footer_menu->name . '</h2>';
                                echo '<ul>';
                                foreach ($footer_menu_items as $menu_item) {
                                    if ($menu_item->menu_item_parent && !in_array($menu_item->menu_item_parent, $menu_items_with_children)) {
                                        array_push($menu_items_with_children, $menu_item->menu_item_parent);
                                    }
                                }
                                foreach ($footer_menu_items as $menu_item) :
                                    $parent_ID = $menu_item->ID;
                                    if ($menu_item->menu_item_parent == 0) :
                                        echo '<li><a class="footer-link" href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                                    endif;
                                endforeach;
                                echo '</ul>';
                                echo '</div>';
                            endif; ?>
                            <div class="footer-get-in-touch-card ]">
                                <h2 class="footer-c-title mb-[1.5rem] md:mb-9">Get in Touch</h2>
                                <?php if (!empty($subscription_text)) echo '<div class="footer-desc-wrapper"><p class="footer-desc">' . $subscription_text . '</p></div>'; ?>
                                <?php if (shortcode_exists('email-subscribers-form')) :
                                    echo do_shortcode('[email-subscribers-form id="1"]');
                                endif; ?>
                                <!-- <div class="flex items-start md:items-center gap-2 h-fit">
                                    <input class="mt-[4px] md:mt-[0px]" type="checkbox" aria-label="check">
                                    <p class="footer-desc">I consent to the terms and conditions</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-copyright-sec">
                <div class="container mx-auto ">
                    <div class="footer-copyright-sec-inner">
                        <p class="copyright">© <?php echo date('Y'); ?> Wired To Remote. All rights reserved.</p>
                        <?php if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false) || (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false))) :
                            echo '<div class="footer-icon-sec">';
                            if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false)) echo '<a class="footer-icon" href="' . $facebook . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-facebook"></span></a>';
                            if (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false)) echo '<a class="footer-icon" href="' . $linkedin . '" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-linkedin"></span></a>';
                            echo '</div>';
                        endif; ?>
                    </div>
                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>




        <script>
            jQuery("#typed").typed({
                strings: ["Grow", "Exit", "Start"],
                typeSpeed: 100,
                startDelay: 0,
                backSpeed: 60,
                backDelay: 2000,
                loop: true,
                cursorChar: "|",
                contentType: "html",
            });

            let icon = document.querySelector(".menu_icon");
            icon.addEventListener("click", () => {
                icon.classList.toggle("clicked");
            });
        </script>

        <script>
            $(document).ready(function() {
                $(".accordion").on("click", function() {
                    $(this).toggleClass("btn-active");
                    $(this).parent().next().slideToggle(500);

                });
            });
        </script>



        </body>

        </html>