<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// (Code refactored for Version 4.3.5)

if (weaverx_getopt('m_primary_hide') != 'hide'
    && !weaverx_is_checked_page_opt('_pp_hide_menus')) {


    weaverx_clear_both('menu-primary');

    $class = weaverx_menu_class('m_primary');

    $site_title = '';

    if (weaverx_getopt('m_primary_site_title_left')) {

        $classt = 'site-title-on-menu wvrx-menu-html wvrx-menu-left';

        // font-family
        $val = weaverx_getopt('site_title_font_family');
        if ($val && $val != 'default') {
            $classt .= ' font-' . $val;
        }

        $classt .= weaverx_get_bold_italic('site_title', 'bold');
        $classt .= weaverx_get_bold_italic('site_title', 'italic');

        $site_title = '<span class="' . $classt . '"><a href="' . esc_url(home_url()) . '" alt="Site Home">' . get_bloginfo('name') . '</a></span>';
    }

    $left = weaverx_getopt('m_primary_html_left');
    $right = weaverx_getopt('m_primary_html_right');


    $logo = '';

    if (weaverx_getopt('m_primary_logo_left')) {
        $custom_logo_url = weaverx_get_wp_custom_logo_url();
        // We have a logo. Logo is go.
        if ($custom_logo_url) {
            if (weaverx_getopt('m_primary_logo_home_link')) {
                $logo = apply_filters('weaverx_menu_logo', '<span class="custom-logo-on-menu"><a href="' . esc_url(home_url()) . '" alt="Site Home"><img src="' . $custom_logo_url . '" alt="logo"/></a></span>', $custom_logo_url);    // +since: 3.1.10: add alt=
            } else {
                $logo = apply_filters('weaverx_menu_logo', '<span class="custom-logo-on-menu"><img src="' . $custom_logo_url . '" alt="logo"/></span>', $custom_logo_url);    // +since: 3.1.10: add alt=
            }
        }
    }


    if ($left) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '">' . do_shortcode($left) . '</span>';
        $left = str_replace('%', '%%', $left);    // wp_nav_menu uses sprintf! This will almost always fix the issue.
    } elseif (is_customize_preview()) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '"></span>';
    }

    if ($right) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '">' . do_shortcode($right) . '</span>';
        $right = str_replace('%', '%%', $right);    // wp_nav_menu uses sprintf!
    } elseif (is_customize_preview()) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '"></span>';
    }

    if (weaverx_getopt_checked('m_primary_login')) {
        $login = wp_loginout('', false);
        $login = str_replace('%', '%%', $login); // wp_nav_menu uses sprintf!
        $right = '<span id="menu_login" class="wvrx-menu-login wvrx-menu-right hide-none" style="margin-right:8px;">' . $login . '</span>' . $right;
    }

    if (weaverx_getopt_checked('m_primary_search')) {
        $searchform = get_search_form(false);
        $searchform = str_replace('%', '%%', $searchform); // wp_nav_menu uses sprintf!
        $right = '<span class="menu-search">&nbsp;' . $searchform . '&nbsp;</span>' . $right;
    }
    $left = $logo . $site_title . $left;

    if (weaverx_getopt_checked('use_smartmenus')) {                            // ==================  SMART MENUS ( make any changes in default menu version, too in filters.php )
        $hamburger = apply_filters('weaverx_mobile_menu_name', weaverx_getopt('m_primary_hamburger'));

        if ($hamburger == '') {
            $alt = weaverx_getopt('mobile_alt_label');
            if ($alt == '') {
                $hamburger = '<span class="genericon genericon-menu"></span>';
            } else {
                $hamburger = '<span class="menu-toggle-menu">' . $alt . '</span>';
            }
        }
        $left = '<span class="wvrx-menu-button">' . "{$hamburger}</span>{$left}";            // +since: 3.1.10: remove empty href=""
    }

    $menu_class = apply_filters('weaverx_menu_class', 'weaverx-theme-menu wvrx-menu menu-hover', 'primary');

    $align = weaverx_getopt('m_primary_align');

    switch ($align) {        // add classes for alignment and fixed top
        case 'left':
        case 'alignwide left':
        case 'alignfull left':
            $menu_class .= ' menu-alignleft';
            break;
        case 'center':
        case 'alignwide center':
        case 'alignfull center':
            $menu_class .= ' wvrx-center-menu';
            break;
        case 'right':
        case 'alignwide right':
        case 'alignfull right':
            $menu_class .= ' menu-alignright';
            break;
        default:
            $menu_class .= ' menu-alignleft';
    }

    if (weaverx_getopt('m_primary_move')) {
        $nav_class = 'menu-primary menu-primary-moved menu-type-standard';
    } else {
        $nav_class = 'menu-primary menu-primary-standard menu-type-standard';
    }

    if (weaverx_getopt('m_primary_fixedtop') == 'fixed-top') {    // really is a drop-down value, so need to check for === for backward compat.
        $class .= ' wvrx-fixedtop';
        $nav_class .= ' wvrx-primary-fixedtop';
    }

    echo "\n\n" . '<div id="nav-primary" class="' . $nav_class . '"' . weaverx_schema('menu') . ">\n";

    $alt_menu = weaverx_get_per_page_value('_pp_alt_primary_menu');

    $the_menu = null;           // all except if replacement menu
    $cb = true;
    $walker = null;             // our walker handles alternative cursors

    if ($alt_menu != '') {
        $the_menu = wp_get_nav_menu_object($alt_menu);
        $cb = false;
    } else {
        $locations = get_nav_menu_locations();
        if ($locations && isset($locations['primary'])) {
            $use_menu = wp_get_nav_menu_object($locations['primary']);
            if (!empty($use_menu)) {
                $cb = false;
            }
        }
    }

    if (!$cb) {
        $fb_cb = null;
        $walker = new weaverx_Walker_Nav_Menu();
    } else {
        $fb_cb = 'weaverx_page_menu';
        $walker = null;
    }

    wp_nav_menu(
        array(
            'theme_location' => 'primary',
            'menu' => $the_menu,
            'menu_class' => $menu_class,
            'container' => 'div',
            'container_class' => 'wvrx-menu-container ' . $class,
            'items_wrap' => $left . $right .
                '<div class="wvrx-menu-clear"></div><ul id="%1$s" class="%2$s">%3$s</ul><div style="clear:both;"></div>',
            'fallback_cb' => $fb_cb,
            'walker' => $walker,
        ));

    echo "</div><div class='clear-menu-primary-end' style='clear:both;'></div><!-- /.menu-primary -->\n\n";

    if (weaverx_getopt_checked('use_smartmenus')) {
        //if (function_exists('weaverxplus_plugin_installed')) {
        //    do_action('weaverx_plus_smartmenu', 'nav-primary', 'm_primary');
        //}    // emit required JS to invoke smartmenu
       // else {        // use theme "action"
            weaverx_smartmenu('nav-primary');
       // }
    }
}

