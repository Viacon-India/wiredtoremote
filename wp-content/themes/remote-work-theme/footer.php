<?php
$footer_text       = get_option('footer_text');
$subscription_text = get_option('subscription_text');
$facebook          = get_option('facebook');
$linkedin          = get_option('linkedin');
$instagram         = get_option('instagram');
$pinterest         = get_option('pinterest');
?>
</main>

<footer class="footer-wrapper">
    <div class="footer-sec">
        <div class="container mx-auto">
            <div class="footer-main">

                <!-- Footer Logo Section -->
                <div class="footer-logo-sec f-common-pt">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <figure class="rounded-none m-0 w-[270px] h-[38px] mb-[22px]">
                            <?php
                            if (function_exists('footer_logo_url') && footer_logo_url()) {
                                $logo_url = footer_logo_url();
                                $logo_path = isset(parse_url($logo_url)['path'])
                                    ? realpath($_SERVER['DOCUMENT_ROOT'] . parse_url($logo_url)['path'])
                                    : false;

                                if ($logo_path && file_exists($logo_path)) {
                                    echo '<img class="w-full h-full object-cover" src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                                } else {
                                    echo '<span class="w-full h-full object-cover">' . esc_html(get_bloginfo('name')) . '</span>';
                                }
                            } else {
                                echo '<span class="w-full h-full object-cover">' . esc_html(get_bloginfo('name')) . '</span>';
                            }
                            ?>
                        </figure>
                    </a>

                    <?php if (!empty($footer_text)) : ?>
                        <p class="footer-desc"><?php echo wp_kses_post($footer_text); ?></p>
                    <?php endif; ?>

                    <br>

                    <p class="footer-desc" style="margin-bottom:1px;">
                        To Reach Out To The <strong>Wired To Remote</strong> Team at
                        <a href="mailto:info@redhatmedia.net"
                           style="color:#fff; text-decoration:none;"
                           onmouseover="this.style.color='#6a5acd'; this.style.textDecoration='underline';"
                           onmouseout="this.style.color='#fff'; this.style.textDecoration='none';">
                            info@redhatmedia.net
                        </a>
                    </p>

                    <br>

                    <!-- Google Badge -->
                    <a href="https://www.google.com/preferences/source?q=wiredtoremote.com"
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       style="position:relative; display:inline-block;"
                       onmouseover="this.querySelector('.tip').style.opacity='1';"
                       onmouseout="this.querySelector('.tip').style.opacity='0';">

                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/wiredtoremote.png'); ?>"
                             alt="Follow us on Google"
                             style="width:220px; height:auto;">

                        <span class="tip"
                              style="
                                position:absolute;
                                bottom:110%;
                                left:50%;
                                transform:translateX(-50%);
                                background:#fff;
                                color:#000;
                                padding:6px 10px;
                                border-radius:6px;
                                font-size:12px;
                                white-space:nowrap;
                                opacity:0;
                                pointer-events:none;
                                transition:opacity .25s ease;
                              ">
                            Follow us on Google
                        </span>
                    </a>
                </div>

                <!-- Footer Menus and Contact -->
                <div class="footer-detail">

                    <?php
                    // Company Menu
                    $locations = get_nav_menu_locations();

                    if (isset($locations['company-menu'])) :
                        $menu = wp_get_nav_menu_object($locations['company-menu']);

                        if ($menu) :
                            $items = wp_get_nav_menu_items($menu->term_id);
                            ?>
                            <div class="footer-detail-small-sec">
                                <h2 class="footer-c-title mb-[1.5rem] md:mb-9">
                                    <?php echo esc_html($menu->name); ?>
                                </h2>
                                <ul>
                                    <?php foreach ($items as $item) :
                                        if ((int) $item->menu_item_parent === 0) : ?>
                                            <li>
                                                <a class="footer-link"
                                                   href="<?php echo esc_url($item->url); ?>">
                                                    <?php echo esc_html($item->title); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    endforeach; ?>
                                </ul>
                            </div>
                        <?php endif;
                    endif;
                    ?>

                    <?php
                    // Categories Menu
                    if (isset($locations['categories-menu'])) :
                        $menu = wp_get_nav_menu_object($locations['categories-menu']);

                        if ($menu) :
                            $items = wp_get_nav_menu_items($menu->term_id);
                            ?>
                            <div class="footer-detail-small-sec">
                                <h2 class="footer-c-title mb-[1.5rem] md:mb-9">
                                    <?php echo esc_html($menu->name); ?>
                                </h2>
                                <ul>
                                    <?php foreach ($items as $item) :
                                        if ((int) $item->menu_item_parent === 0) : ?>
                                            <li>
                                                <a class="footer-link"
                                                   href="<?php echo esc_url($item->url); ?>">
                                                    <?php echo esc_html($item->title); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    endforeach; ?>
                                </ul>
                            </div>
                        <?php endif;
                    endif;
                    ?>

                    <!-- Get in Touch -->
                    <div class="footer-get-in-touch-card">
                        <h2 class="footer-c-title mb-[1.5rem] md:mb-9">Get in Touch</h2>

                        <?php if (!empty($subscription_text)) : ?>
                            <div class="footer-desc-wrapper">
                                <p class="footer-desc">
                                    <?php echo wp_kses_post($subscription_text); ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php
                        if (shortcode_exists('email-subscribers-form')) {
                            echo do_shortcode('[email-subscribers-form id="1"]');
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-copyright-sec">
        <div class="container mx-auto">
            <div class="footer-copyright-sec-inner">

                <p class="copyright">
                    © <?php echo esc_html(date('Y')); ?> Wired To Remote. All rights reserved.
                </p>

                <?php
                $has_social =
                    (!empty($facebook) && filter_var($facebook, FILTER_VALIDATE_URL)) ||
                    (!empty($linkedin) && filter_var($linkedin, FILTER_VALIDATE_URL)) ||
                    (!empty($instagram) && filter_var($instagram, FILTER_VALIDATE_URL)) ||
                    (!empty($pinterest) && filter_var($pinterest, FILTER_VALIDATE_URL));

                if ($has_social) : ?>
                    <div class="footer-icon-sec">

                        <?php if (!empty($facebook) && filter_var($facebook, FILTER_VALIDATE_URL)) : ?>
                            <a class="footer-icon"
                               href="<?php echo esc_url($facebook); ?>"
                               target="_blank"
                               rel="noopener noreferrer nofollow"
                               aria-label="Facebook">
                                <span class="icon-facebook"></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($linkedin) && filter_var($linkedin, FILTER_VALIDATE_URL)) : ?>
                            <a class="footer-icon"
                               href="<?php echo esc_url($linkedin); ?>"
                               target="_blank"
                               rel="noopener noreferrer nofollow"
                               aria-label="LinkedIn">
                                <span class="icon-linkedin"></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($instagram) && filter_var($instagram, FILTER_VALIDATE_URL)) : ?>
                            <a class="footer-icon"
                               href="<?php echo esc_url($instagram); ?>"
                               target="_blank"
                               rel="noopener noreferrer nofollow"
                               aria-label="Instagram">
                                <span class="icon-instagram"></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($pinterest) && filter_var($pinterest, FILTER_VALIDATE_URL)) : ?>
                           <a class="footer-icon"
   href="<?php echo esc_url($pinterest); ?>"
   target="_blank"
   rel="noopener noreferrer nofollow"
   aria-label="Pinterest"
   style="color: #6c747b;">
    <i class="fa fa-pinterest"></i>
</a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
jQuery(document).ready(function ($) {

    if ($('#typed').length && $.fn.typed) {
        $("#typed").typed({
            strings: ["Grow", "Exit", "Start"],
            typeSpeed: 100,
            startDelay: 0,
            backSpeed: 60,
            backDelay: 2000,
            loop: true,
            cursorChar: "|",
            contentType: "html"
        });
    }

    $('.menu_icon').on('click', function () {
        $(this).toggleClass('clicked');
    });

    $('.accordion').on('click', function () {
        $(this).toggleClass('btn-active');
        $(this).parent().next().slideToggle(500);
    });
});
</script>

</body>
</html> 