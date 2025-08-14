<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://api.fontshare.com/v2/css?f%5B%5D=supreme@1,2&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">


  <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3ENKD4L34K"></script>
    <script>window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}   gtag('js', new Date());   gtag('config', 'G-3ENKD4L34K'); </script>

  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
  <header class="relative">
    <nav class="navbar">
      <div class="container mx-auto">
        <div class="w-full flex justify-between items-center relative py-4 sm:py-[1.25rem] md:py-[1.5rem] lg:py-0">

          <div class="navbar-start">
            <a href="<?php echo home_url(); ?>" class="navbar-nav-logo-wrapper">
              <figure>
                <?php if (function_exists('logo_url')) {
                  if (is_file(realpath($_SERVER["DOCUMENT_ROOT"]) . parse_url(logo_url())['path'])) {
                    echo '<img class="w-full h-full object-cover" src="' . logo_url() . '" alt="logo" />';
                  } else {
                    echo '<span class="w-full h-full object-cover">' . get_bloginfo('name') . '</span>';
                  }
                } else {
                  echo '<span class="w-full h-full object-cover">' . get_bloginfo('name') . '</span>';
                } ?>
              </figure>
            </a>
          </div>

          <?php if (isset(get_nav_menu_locations()['header-menu'])) :
            echo '<div class="navbar-center hidden lg:flex">';
            $header_menu = get_term(get_nav_menu_locations()['header-menu'], 'nav_menu');
            $header_menu_items = wp_get_nav_menu_items($header_menu->term_id);
            $menu_items_with_children = array();
            foreach ($header_menu_items as $menu_item) {
              if ($menu_item->menu_item_parent && !in_array($menu_item->menu_item_parent, $menu_items_with_children)) {
                array_push($menu_items_with_children, $menu_item->menu_item_parent);
              }
            }
            echo '<ul class="desk-top-menu">';
            foreach ($header_menu_items as $menu_item) :
              $parent_ID = $menu_item->ID;
              if ($menu_item->menu_item_parent == 0) :
                echo '<li class="desk-top-menu-li">';
                if (!in_array($menu_item->ID, $menu_items_with_children)) :
                  echo '<a href="' . $menu_item->url . '" class="nav-links">' . $menu_item->title . '</a>';
                else :
                  echo '<a href="' . $menu_item->url . '" class="nav-links">' . $menu_item->title . '</a>';
                  echo '<ul class="desk-top-menu-dropdown">';
                  foreach ($header_menu_items as $menu_child_item) :
                    if ($menu_child_item->menu_item_parent == $parent_ID) :
                      echo '<li class="desk-top-menu-dropdown-li"><a class="dropdown-options" href="' . $menu_child_item->url . '">' . $menu_child_item->title . '</a></li>';
                    endif;
                  endforeach;
                  echo '</ul>';
                endif;
                echo '</li>';
              endif;
            endforeach;
            echo '</ul>';
            echo '</div>';
          endif; ?>

          <div class="navbar-end ">
            <button class="search-btn" onclick="document.getElementById('deskTopSearchModal').style.visibility='visible'" aria-label="search-button">
              <span class="search-btn-text">
                Search
              </span>
              <span class="like-search-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M15.2583 14.075L12.425 11.25C13.3392 10.0854 13.8352 8.64721 13.8333 7.16667C13.8333 5.84813 13.4423 4.5592 12.7098 3.46287C11.9773 2.36654 10.9361 1.51206 9.71789 1.00747C8.49972 0.502889 7.15927 0.370866 5.86607 0.628101C4.57286 0.885336 3.38497 1.52027 2.45262 2.45262C1.52027 3.38497 0.885336 4.57286 0.628101 5.86607C0.370866 7.15927 0.502889 8.49972 1.00747 9.71789C1.51206 10.9361 2.36654 11.9773 3.46287 12.7098C4.5592 13.4423 5.84813 13.8333 7.16667 13.8333C8.64721 13.8352 10.0854 13.3392 11.25 12.425L14.075 15.2583C14.1525 15.3364 14.2446 15.3984 14.3462 15.4407C14.4477 15.4831 14.5567 15.5048 14.6667 15.5048C14.7767 15.5048 14.8856 15.4831 14.9871 15.4407C15.0887 15.3984 15.1809 15.3364 15.2583 15.2583C15.3364 15.1809 15.3984 15.0887 15.4407 14.9871C15.4831 14.8856 15.5048 14.7767 15.5048 14.6667C15.5048 14.5567 15.4831 14.4477 15.4407 14.3462C15.3984 14.2446 15.3364 14.1525 15.2583 14.075ZM2.16667 7.16667C2.16667 6.17776 2.45991 5.21106 3.00932 4.38882C3.55873 3.56657 4.33962 2.92571 5.25325 2.54727C6.16688 2.16883 7.17222 2.06982 8.14212 2.26274C9.11203 2.45567 10.0029 2.93187 10.7022 3.63114C11.4015 4.3304 11.8777 5.22131 12.0706 6.19122C12.2635 7.16112 12.1645 8.16646 11.7861 9.08009C11.4076 9.99372 10.7668 10.7746 9.94452 11.324C9.12227 11.8734 8.15558 12.1667 7.16667 12.1667C5.84059 12.1667 4.56882 11.6399 3.63114 10.7022C2.69345 9.76452 2.16667 8.49275 2.16667 7.16667Z" fill="#222222" />
                </svg>
              </span>
            </button>

            <div id="deskTopSearchModal" class="h-full" style="visibility: hidden;">
              <div class="desk-top-search-modal-inaner">
                <div class="desk-top-search-from-wrapper">
                  <?php get_search_form(); ?>
                  <div class="desk-top-search-toggle-cut">
                    <span onclick="document.getElementById('deskTopSearchModal').style.visibility='hidden'" class="desk-top-search-modal-close">
                      <svg width="22" height="22" viewBox="0 0 22 22" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.22387 1.0321L10.9999 8.8081L18.7439 1.0641C19.0181 0.772258 19.3994 0.604738 19.7999 0.600098C20.6835 0.600098 21.3999 1.31642 21.3999 2.2001C21.4074 2.59658 21.2511 2.97866 20.9679 3.2561L13.1439 11.0001L20.9679 18.8241C21.2315 19.082 21.3863 19.4315 21.3999 19.8001C21.3999 20.6838 20.6835 21.4001 19.7999 21.4001C19.3875 21.4172 18.9871 21.2604 18.6959 20.9681L10.9999 13.1921L3.23987 20.9521C2.96675 21.2342 2.59235 21.3955 2.19987 21.4001C1.31619 21.4001 0.599869 20.6838 0.599869 19.8001C0.592349 19.4036 0.748669 19.0215 1.03187 18.7441L8.85587 11.0001L1.03187 3.1761C0.768189 2.91818 0.613469 2.56874 0.599869 2.2001C0.599869 1.31642 1.31619 0.600098 2.19987 0.600098C2.58451 0.604738 2.95203 0.759778 3.22387 1.0321Z" fill=""></path>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- header Dropdown -->
            <button class="menu_icon  ham-dropdown" aria-label="drop down button">
              <span class="one"></span>
              <span class="two"></span>
              <span class="three"></span>
              <!-- mobile nav bat on click animation -->
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <?php get_template_part('template-parts/hamburger', 'modal'); ?>

  <main>