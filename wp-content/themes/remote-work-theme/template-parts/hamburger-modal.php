<div id="hamMenu" class="lg:hidden">
    <div class="ham-content" style="width: 100%;">
        <div class=" ham-container ">
            <?php if (isset(get_nav_menu_locations()['header-menu'])) :
                echo '<div class="ham-main">';
                    $header_menu = get_term(get_nav_menu_locations()['header-menu'], 'nav_menu');
                    $header_menu_items = wp_get_nav_menu_items($header_menu->term_id);
                    $menu_items_with_children = array();
                    foreach ($header_menu_items as $menu_item) {
                        if ($menu_item->menu_item_parent && !in_array($menu_item->menu_item_parent, $menu_items_with_children)) {
                            array_push($menu_items_with_children, $menu_item->menu_item_parent);
                        }
                    }
                    foreach ($header_menu_items as $menu_item) :
                        $parent_ID = $menu_item->ID;
                        if ($menu_item->menu_item_parent == 0) :
                            echo '<div class="ham-list">';
                                echo '<h4 class="ham-links';
                                    if(in_array($menu_item->ID, $menu_items_with_children)) echo ' ham-accordion';
                                    echo '">';
                                    echo '<a href="' . $menu_item->url . '">' . $menu_item->title . '<span class="screen-reader-text">Details</span></a>';
                                    if(in_array($menu_item->ID, $menu_items_with_children)) echo "<svg class='ham-links-svg' xmlns='http://www.w3.org/2000/svg' width='15' height='7' fill='none' viewBox='0 0 10 5'><path fill='#091A27' d='m0 0 5 5 5-5H0Z'/></svg>";
                                echo '</h4>';
                                if (in_array($menu_item->ID, $menu_items_with_children)) :
                                    echo '<div class="ham-submenu newPanel">';
                                    foreach ($header_menu_items as $menu_child_item) :
                                        if ($menu_child_item->menu_item_parent == $parent_ID) :
                                            echo '<a class="submenu-list" href="' . $menu_child_item->url . '">' . $menu_child_item->title . '</a>';
                                        endif;
                                    endforeach;
                                    echo '</div>';
                                endif;
                            echo '</div>';
                        endif;
                    endforeach;
                echo '</div>';
            endif; ?>

            <div class="ham-social-copyright">
                <?php if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false) || (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false))) :
                    echo '<div class="ham-social-icon-sec">';
                        if (!empty($facebook) && (filter_var($facebook, FILTER_VALIDATE_URL) !== false)) echo '<a class="ham-social-icon" href="'.$facebook.'" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-facebook"></span></a>';
                        if (!empty($linkedin) && (filter_var($linkedin, FILTER_VALIDATE_URL) !== false)) echo '<a class="ham-social-icon" href="'.$linkedin.'" rel="noopener noreferrer nofollow" target="_blank" aria-label="social_Link"><span class="icon-linkedin"></span></a>';
                    echo '</div>';
                endif; ?>
                <p class="ham-copyright">© <?php echo date('Y'); ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>