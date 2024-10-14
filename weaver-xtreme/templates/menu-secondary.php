<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// This code similar to primary menu (Code refactored for Version 4.3.5)

$alt_menu = weaverx_get_per_page_value('_pp_alt_secondary_menu');

if (weaverx_getopt('m_secondary_hide') != 'hide'
    && (has_nav_menu('secondary') || $alt_menu != '')
    && !weaverx_is_checked_page_opt('_pp_hide_menus')) {

    weaverx_clear_both('menu-secondary');

    $class = weaverx_menu_class('m_secondary');

    $left = weaverx_getopt('m_secondary_html_left');
    $right = weaverx_getopt('m_secondary_html_right');

    if ($left) {
        $hide = ' ' . weaverx_getopt('m_secondary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '">' . do_shortcode($left) . '</span>';
        $left = str_replace('%', '%%', $left);    // wp_nav_menu uses sprintf! This will almost always fix the issue.
    } elseif (is_customize_preview()) {
        $hide = ' ' . weaverx_getopt('m_secondary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '"></span>';
    }

    if ($right) {
        $hide = ' ' . weaverx_getopt('m_secondary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '">' . do_shortcode($right) . '</span>';
        $right = str_replace('%', '%%', $right);    // wp_nav_menu uses sprintf!
    } elseif (is_customize_preview()) {
        $hide = ' ' . weaverx_getopt('m_secondary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '"></span>';
    }

    if (weaverx_getopt_checked('use_smartmenus')) {                            // ==================  SMART MENUS ( make any changes in default menu version, too in filters.php )
        $hamburger = apply_filters('weaverx_mobile_menu_name', weaverx_getopt('m_secondary_hamburger'));

        if ($hamburger == '') {
            $alt = weaverx_getopt('mobile_alt_label');
            if ($alt == '')
                $hamburger = '<span class="genericon genericon-menu"></span>';
            else
                $hamburger = '<span class="menu-toggle-menu">' . $alt . '</span>';
        }
        $left = '<span class="wvrx-menu-button">' . "{$hamburger}</span>{$left}";
    }

    $menu_class = apply_filters('weaverx_menu_class', 'weaverx-theme-menu wvrx-menu menu-hover', 'secondary');

    $align = weaverx_getopt('m_secondary_align');

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

    if (weaverx_getopt('m_secondary_move')) {
        $nav_class = 'menu-secondary menu-secondary-moved menu-type-standard';
    } else {
        $nav_class = 'menu-secondary menu-secondary-standard menu-type-standard';
    }

    if (weaverx_getopt('m_secondary_fixedtop') == 'fixed-top') {
        $class .= ' wvrx-fixedtop';
        $nav_class .= ' wvrx-secondary-fixedtop';
    }

    echo "\n\n" . '<div id="nav-secondary" class="' . $nav_class . '"' . weaverx_schema('menu') . ">\n";

    $the_menu = wp_get_nav_menu_object($alt_menu ? $alt_menu : 'secondary');

    wp_nav_menu(
        array(
            'theme_location' => 'secondary',
            'menu' => $the_menu,
            'menu_class' => $menu_class,
            'container' => 'div',
            'container_class' => 'wvrx-menu-container ' . $class,
            'items_wrap' => $left . $right .
                '<div class="wvrx-menu-clear"></div><ul id="%1$s" class="%2$s">%3$s</ul><div style="clear:both;"></div>',
            'walker' => new weaverx_Walker_Nav_Menu(),
        ));

    echo "</div><div class='clear-menu-secondary-end' style='clear:both;'></div><!-- /.menu-secondary -->\n\n";

    if (weaverx_getopt_checked('use_smartmenus')) {
        //if (function_exists('weaverxplus_plugin_installed'))
        //    do_action('weaverx_plus_smartmenu', 'nav-secondary', 'm_secondary');    // emit required JS to invoke smartmenu
        //else {        // use theme "action"
            weaverx_smartmenu('nav-secondary');
        //}
    }
}

