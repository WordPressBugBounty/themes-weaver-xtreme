<?php
/** PHP 7.4 features added */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
//  __ added - 12/11/14
// revised 3.2.0 - reordered actions, callbacks, filters alphabetical order

/*  --------------------------------- ACTIONS -------------------------------
 *
 */


// =============================== >>> ACTION: weaverx_disable_visual_editor <<< ================================
add_action('load-page.php', 'weaverx_disable_visual_editor');
add_action('load-post.php', 'weaverx_disable_visual_editor');

function weaverx_disable_visual_editor(): void
{
    global $wp_rich_edit;

    if (!isset($_GET['post'])) {
        return;
    }
    $post_id = $_GET['post'];
    $value = get_post_meta($post_id, '_pp_hide_visual_editor', true);
    $raw = get_post_meta($post_id, '_pp_raw_html', true);
    if ($value == 'on' || $raw == 'on') {
        $wp_rich_edit = false;
    }
}

//--

if (!has_action('weaverx_load_fonts')) {
    add_action('weaverx_load_fonts', 'weaverx_load_fonts_action');

    function weaverx_load_fonts_action(): void
    {
        weaverx_load_google_fonts();
    }
}
//--

// =============================== >>> ACTION: weaverx_nav <<< ================================
if (!has_action('weaverx_nav')) :                        // plugin can override
    add_action('weaverx_nav', 'weaverx_nav_action');

    function weaverx_nav_action($where): void
    {
        // displays primary and secondary menus in the proper place

        switch ($where) {
            case 'top':
                if (!weaverx_getopt('m_secondary_move')) {
                    get_template_part('templates/menu', 'secondary');
                }

                if (weaverx_getopt('m_primary_move')) {
                    get_template_part('templates/menu', 'primary');
                }
                break;

            case 'bottom':
            default:
                if (weaverx_getopt('m_secondary_move')) {
                    get_template_part('templates/menu', 'secondary');
                }

                if (!weaverx_getopt('m_primary_move')) {
                    get_template_part('templates/menu', 'primary');
                }

                break;
        }
    }
endif;
//--

// =============================== >>> ACTION: weaverx_after_theme_activate <<< ================================
// remember some things when switching themes

add_action('after_switch_theme', 'weaverx_after_theme_activate_action');

function weaverx_after_theme_activate_action(): void
{
    // fires when theme activated

    // restore our last set of saved settings
    $fix = get_theme_mod('saved_nav_menu_locations');

    set_theme_mod('nav_menu_locations', $fix);
}

add_action('switch_theme', 'weaverx_theme_deactivate_action');

function weaverx_theme_deactivate_action(): void
{
    // fires when new theme has switched in. Theme settings will be for NEW theme
    $old_theme = get_option('theme_switched');

    $old = weaverx_get_theme_mod('nav_menu_locations', $old_theme);
    weaverx_set_theme_mod('saved_nav_menu_locations', $old, $old_theme);

    $old = weaverx_get_theme_mod('sidebars_widgets', $old_theme);
    weaverx_set_theme_mod('saved_sidebars_widgets', $old, $old_theme);

}


function weaverx_get_theme_mods(string $theme_slug)
{

    return get_option("theme_mods_$theme_slug");
}

/**
 * Retrieve theme modification value for the OLD theme.
 */
function weaverx_get_theme_mod($name, $theme)
{
    $mods = weaverx_get_theme_mods($theme);

    if (isset($mods[$name])) {
        /**
         * Filters the theme modification, or 'theme_mod', value.
         */
        return apply_filters("theme_mod_{$name}", $mods[$name]);
    }

    return false;
}

/**
 * Update theme modification value for the Specified theme.
 *
 */
function weaverx_set_theme_mod($name, $value, $theme): void
{
    $mods = weaverx_get_theme_mods($theme);
    $old_value = $mods[$name] ?? false;

    /**
     * Filters the theme mod value on save.
     *
     */
    $mods[$name] = apply_filters("pre_set_theme_mod_{$name}", $value, $old_value);

    //**** $theme = get_option( 'stylesheet' );
    update_option("theme_mods_$theme", $mods, null);    // 6.6: autoload - keep WP's theme_mods value
}


/*  --------------------------------- CALLBACKS -------------------------------
 *
 */


// ============================================= >>> CALLBACK: weaverx_page_menu <<< ======================================

/** @noinspection PhpUnused  - it is a callback */
function weaverx_page_menu($args = array()): string
{

    // this is the callback for the default menu

    $defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'wvrx-menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
    $args = wp_parse_args($args, $defaults);
    $menu = '';
    $list_args = $args;
    if (weaverx_getopt('menu_nohome')) {
        $args['show_home'] = false;
    } else {
        $args['show_home'] = true;
    }

    // look for pages to hide from menu
    $ex_list = '';
    $hide_pages = get_pages(array('hierarchical' => 0, 'meta_key' => '_pp_hide_on_menu'));  // get list of excluded pages
    if (!empty($hide_pages)) {
        foreach ($hide_pages as $page) {
            $ex_list .= $page->ID . ',';    /* trailing , doesn't matter */
        }
    }

    if ($ex_list != '') {
        if (!empty($list_args['exclude'])) {
            $list_args['exclude'] .= ',';
        } else {
            $list_args['exclude'] = '';
        }
        $list_args['exclude'] .= $ex_list;
    }

    // Show Home in the menu
    if ($args['show_home']) {
        $text = esc_html__('Home', 'weaver-xtreme');
        $class = 'class="default-home-menu-item"';
        if (is_home() || is_front_page()) {
            $class = 'class="default-home-menu-item current_page_item"';
        }

        $menu .= '<li ' . $class . '><a href="' . esc_url(home_url('/')) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

        // If the front page is a page, add it to the exclude list
        if (get_option('show_on_front') == 'page') {
            if (!empty($list_args['exclude'])) {
                $list_args['exclude'] .= ',';
            } else {
                $list_args['exclude'] = '';
            }
            $list_args['exclude'] .= get_option('page_on_front');
        }
    }

    $list_args['echo'] = false;
    $list_args['title_li'] = '';

    $menu .= str_replace(array("\r", "\n", "\t"), '', wp_list_pages($list_args));

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

        $site_title = '<span class="' . $classt . '"><a href="' . esc_url(home_url()) . '">' . get_bloginfo('name') . '</a></span>';
    }


    $left = weaverx_getopt('m_primary_html_left');
    $right = weaverx_getopt('m_primary_html_right');

    $logo = '';

    if (weaverx_getopt('m_primary_logo_left')) {
        $custom_logo_url = weaverx_get_wp_custom_logo_url();
        // We have a logo. Logo is go.
        if ($custom_logo_url) {
            if (weaverx_getopt('m_primary_logo_home_link')) {
                $logo = apply_filters('weaverx_menu_logo', '<span class="custom-logo-on-menu"><a href="' . esc_url(home_url()) . '"><img src="' . $custom_logo_url . '" alt="logo"/></a></span>', $custom_logo_url);
            } else {
                $logo = apply_filters('weaverx_menu_logo', '<span class="custom-logo-on-menu"><img src="' . $custom_logo_url . '" alt="' . esc_attr__('logo', 'weaver-xtreme') . '"/></span>', $custom_logo_url);    // +since: 3.1.10: add alt=
            }
        }
    }


    if ($left) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '">' . do_shortcode($left) . '</span>';
    }

    if (weaverx_getopt_checked('use_smartmenus')) {     // Plus option
        $hamburger = apply_filters('weaverx_mobile_menu_name', weaverx_getopt('m_primary_hamburger'));
        if ($hamburger == '') {
            $alt = weaverx_getopt('mobile_alt_label');
            if ($alt == '') {
                $hamburger = '<span class="genericon genericon-menu"></span>';
            } else {
                $hamburger = '<span class="menu-toggle-menu">' . $alt . '</span>';
            }
        }

        $left = '<span class="wvrx-menu-button">' . "{$hamburger}</span>{$left}";       // +since: 3.1.10: remove empty href=""
    }

    if (!$left && is_customize_preview()) {
        $hide = ' ' . weaverx_getopt('m_primary_hide_left');
        $left = '<span class="wvrx-menu-html wvrx-menu-left' . $hide . '"></span>';
    }

    if ($right) {
        $hide = weaverx_getopt('m_primary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '">' . do_shortcode($right) . '</span>';
    }
    if (!$right && is_customize_preview()) {
        $hide = weaverx_getopt('m_primary_hide_right');
        $right = '<span class="wvrx-menu-html wvrx-menu-right ' . $hide . '"></span>';
    }

    if (weaverx_getopt('m_primary_search')) {
        $right = '<span class="menu-search">&nbsp;' . get_search_form(false) . '&nbsp;</span>' . $right;
    }

    $left = $logo . $left;

    if ($menu) {
        $menu = $left . $site_title . $right . '<div class="wvrx-menu-clear"></div><ul class="' . esc_attr($args['menu_class']) . '">'
            . $menu . '</ul><div class="clear-menu-end clear-both" ></div>';
    }

    // add the styling classes here

    $menu = '<div class="wvrx-default-menu ' . esc_attr($args['container_class']) . '">' . $menu . "</div>\n";

    if ($args['echo']) {
        echo $menu;

        return '';
    } else {
        return $menu;
    }
}

//--


// ------ smart menus ------

function weaverx_smartmenu($menu_id): void
{

    $def = "{subIndicatorsText:'',subMenusMinWidth:'1em',subMenusMaxWidth:'25em'}";

    // build jQuery script to invoke menu
    ?>
    <script type='text/javascript'>
        jQuery('#<?php echo $menu_id; ?> .weaverx-theme-menu').smartmenus( <?php echo $def; ?> );
        jQuery('#<?php echo $menu_id;?> span.wvrx-menu-button').click(function () {
            var $this = jQuery(this), $menu = jQuery('#<?php echo $menu_id;?> ul');
            if (!$this.hasClass('collapsed')) {
                $menu.addClass('collapsed');
                $this.addClass('collapsed mobile-menu-closed');
                $this.removeClass('mobile-menu-open');
            } else {
                $menu.removeClass('collapsed');
                $this.removeClass('collapsed mobile-menu-closed');
                $this.addClass('mobile-menu-open');
            }
            return false;
        }).click();</script><?php
}

/*  --------------------------------- FILTERS -------------------------------
 *
 */

add_filter('weaverx_menu_class', 'weaverx_menu_class_filter_theme', 10, 3);

/** @noinspection PhpUnusedParameterInspection */
function weaverx_menu_class_filter_theme(string $class, $menu): string
{
    $use_smart = weaverx_getopt_checked('use_smartmenus'); //--- && !function_exists('weaverxplus_plugin_installed'); // plus filter not available, use ours
    if ($use_smart) {
        $add_menu = "$menu";
        if (weaverx_getopt("m_{$menu}_grid_submenu") != '') { // check if grid
            $add_menu .= " $menu-grid";
        }

        $menu_class = "weaverx-theme-menu sm wvrx-menu menu-$add_menu collapsed";
        if (is_rtl()) {
            $menu_class .= ' sm-rtl';
        }

        return $menu_class;
    }

    return $class;
}

// =============================== >>> FILTER: weaverx_get_custom_logo <<< ================================

add_filter('get_custom_logo', 'weaverx_get_custom_logo', 10, 2);

/** @noinspection PhpUnusedParameterInspection */
function weaverx_get_custom_logo(string $html, $notused): string
{
    // I think WP has the itemprop='logo' wrong since it applies ONLY to images.

    return str_replace(' itemprop="logo"', '', $html);
}

// =============================== >>> FILTER: weaverx_body_classes <<< ================================

add_filter('body_class', 'weaverx_body_classes');

/*
 * Add classes to body depending of page type to make sidebar templates work and full widths work.
 *
 */
function weaverx_body_classes($classes)
{

//    if ( is_customize_preview() ) {
//        $classes[] = 'wvr-wp-customizer';
//    }

    $pwp = in_array('page-template-paget-posts-php', $classes);
    $has_posts = false;

    if ($pwp) {                // page with posts - add stuff like blog
        $classes[] = 'blog';
        $has_posts = true;
    }

    if (!is_multi_author()) {
        $classes[] = 'single-author';
    }

    if (is_singular() && !is_home() && !$pwp) {   // don't make pwp singular
        $classes[] = 'singular';
    }

    if (!is_user_logged_in()) {
        $classes[] = 'not-logged-in';
    }

    // these classes get removed by JS at runtime

    $classes[] = 'weaverx-theme-body wvrx-not-safari is-menu-desktop is-menu-default';      // Changed 3.1.11 to handle Safari extended width bug

    if (is_single() && weaverx_get_per_post_value('_pp_bodyclass') != '')  // add body class per post single page
    {
        $classes[] = weaverx_get_per_post_value('_pp_bodyclass');
    } elseif (weaverx_get_per_page_value('_pp_bodyclass') != '')  // add body class per page
    {
        $classes[] = weaverx_get_per_page_value('_pp_bodyclass');
    }

    if (isset($GLOBALS['weaverx_page_who'])) { // Changed: 4.4 - check if archive is set
        if (weaverx_is_archive()) {
            $sb_layout = weaverx_sb_layout_archive($GLOBALS['weaverx_page_who']);
            if ($GLOBALS['weaverx_page_who'] != '404') {
                $has_posts = true;
            }
        } else {
            $sb_layout = weaverx_sb_layout($GLOBALS['weaverx_page_who']);
        }

        $classes[] = 'weaverx-page-' . $GLOBALS['weaverx_page_who'];
        $GLOBALS['weaverx_sb_layout'] = $sb_layout;
        $classes[] = 'weaverx-sb-' . $sb_layout;
        if ($sb_layout != 'one-column') {
            $classes[] = 'weaverx-has-sb';
        }
        if ($has_posts || $GLOBALS['weaverx_page_who'] == 'single' || $GLOBALS['weaverx_page_who'] == 'blog') {
            $classes[] = 'has-posts';
        }
    }

    return $classes;
}

//--


// =============================== >>> FILTER: weaverx_comment_form_defaults <<< ================================
/** @noinspection PhpRedundantOptionalArgumentInspection */
add_filter('comment_form_defaults', 'weaverx_comment_form_defaults', 10, 1);

function weaverx_comment_form_defaults($defaults)
{       // filter definition
    $defaults['title_reply'] = apply_filters('weaverx_leave_reply_form', $defaults['title_reply']);
    $defaults['cancel_reply_link'] = apply_filters('weaverx_cancel_reply_form', $defaults['cancel_reply_link']);
    $defaults['label_submit'] = apply_filters('weaverx_post_comment_form', $defaults['label_submit']);

    return $defaults;
}

//--


// =============================== >>> FILTER: default_hidden_meta_boxes <<< ================================
// Change what's hidden by default - show Custom Fields and Discussion by default!
add_filter('default_hidden_meta_boxes', 'weaverx_hidden_meta_boxes', 10, 2);

function weaverx_hidden_meta_boxes($hidden, $screen)
{    // filter definition
    if ('post' == $screen->base || 'page' == $screen->base) {
        $hidden = array('slugdiv', 'trackbacksdiv', 'postexcerpt', 'commentsdiv', 'authordiv', 'revisionsdiv');
    }

    // removed 'postcustom', 'commentstatusdiv',
    return $hidden;
}

//--


// =============================== >>> FILTER: excerpt_length <<< ================================

add_filter('excerpt_length', 'weaverx_excerpt_length');

/** @noinspection PhpUnusedParameterInspection */
function weaverx_excerpt_length($length)
{
    /**
     * Sets the post excerpt length to 40 words.
     *
     * To override this length in a child theme, remove the filter and add your own
     * function tied to the excerpt_length filter hook.
     */
    $val = weaverx_t_get('excerpt_length');
    if (!$val) {
        $val = weaverx_getopt('excerpt_length');
    }
    if ($val > 0 || $val === '0') {
        return $val;
    }

    return 40;
}

//--


// =============================== >>> FILTER: header_video_settings <<< ================================

if (!function_exists('weaverx_video_controls')) :

    add_filter('header_video_settings', 'weaverx_video_controls');
    /**
     * Customize video play/pause button in the custom header.
     */
    function weaverx_video_controls($settings): array
    {

        // modify the video parameters

        $settings['l10n']['play'] = '<span class="screen-reader-text">' . esc_html__('Play background video', 'weaver-xtreme') . '</span>';
        $settings['l10n']['pause'] = '<span class="screen-reader-text">' . esc_html__('Pause background video', 'weaver-xtreme') . '</span>';

        $ratio = weaverx_get_per_page_value('_pp_video_aspect');
        if (!$ratio) {
            $ratio = weaverx_getopt_default('header_video_aspect', '16:9');
        }
        $ratio = explode(':', $ratio);
        $settings['width'] = $ratio[0];
        $settings['height'] = $ratio[1];

        $settings['minWidth'] = 800;

        $hdr_bg = weaverx_fi('page', 'header-image');

        if ($hdr_bg) {
            $settings['posterUrl'] = esc_url($hdr_bg);    // supply the FI image url
        }

        if (weaverx_get_per_page_value('_pp_video_url') != '') {
            $settings['videoUrl'] = esc_url(weaverx_get_per_page_value('_pp_video_url'));   // supply the FI image url
        }

        return $settings;
    }

endif;
//--

// =============================== >>> FILTER: is_header_video_active <<< ================================

if (!function_exists('weaverx_is_header_video_active')) :

    add_filter('is_header_video_active', 'weaverx_is_header_video_active');
    function weaverx_is_header_video_active($active)
    {
        // allow per page active video
        $pp = weaverx_get_per_page_value('_pp_video_active'); // $pp can be '', 'yes', 'no'
        if (!$pp || $GLOBALS['weaverx_page_who'] == 'search') {
            return $active;
        } else {
            return $pp == 'yes';
        }
    }


endif;

function weaverx_get_video_render(): string
{
    $render = weaverx_get_per_page_value('_pp_video_render');
    if (!$render) {
        $render = weaverx_getopt_default('header_video_render', 'has-header-video');
    }

    return $render;
}

function weaverx_has_header_video(): bool
{
    return weaverx_get_video_render() != 'has-header-video-none' && function_exists('is_header_video_active') && is_header_video_active()  // This checks for either front page active or per page setting
        && (has_header_video() || weaverx_get_per_page_value('_pp_video_url') != '');
}


// =============================== >>> FILTER: weaverx_mce_css <<< ================================
// ToDo: add_filter('mce_css', 'weaverx_mce_css_filter');

/* route tinyMCE to our stylesheet */
function weaverx_mce_css_filter(string $default_style): string
{
    // ToDo: maybe see if can get to work again, but block editor supersedes necessity
    //return $default_style;

    // replace the default editor-style.css with custom CSS generated on the fly by the php version
    if (weaverx_getopt('_hide_editor_style')) {
        return $default_style;
    }

    // To here, then can a generated style file

    return $default_style;

    /* do we need to do anything about rtl? */
    /* on-the-fly CSS removed Version 4.0 */
}

//--

// =============================== >>> ACTION: weaverx_enqueue_gutenberg_style <<< ================================

/**
 * Action:  Enqueue style sheets and fonts for Gutenberg Editor only.
 *
 * @since 4.0
 *
 */
function weaverx_enqueue_gutenberg_block_editor_assets(): void
{
    // add our element styles to gutenberg. enqueues for editor only

    if (weaverx_getopt('_hide_editor_style')) {
        return;
    }

    weaverx_check_editor_style();      // see if we need an update...

    // enqueue style files
    // removed google font hosting if() code

    $fontPath = weaverx_relative_url('assets/css/fonts/google/google-fonts' . WEAVERX_MINIFY . '.css') . '?ver=' . WEAVERX_VERSION;
    $url = esc_url(get_site_url());

    wp_enqueue_style('weaverx_gutenberg_fonts', "$url$fontPath");    // load the Google Fonts the theme uses so they are available to the editor
    if (weaverx_cz_is_plus('6.1')) {
        $plus_vers = weaverxplus_plugin_installed();
        $plus_dir = trailingslashit(plugin_dir_url('')) . 'weaver-xtreme-plus/includes/fonts/google-plus-fonts' . WEAVERX_MINIFY . '.css?ver=' . $plus_vers;

        wp_enqueue_style('weaverx_gutenberg_plus_fonts', "$plus_dir");    // load the Google Fonts the theme uses so they are available to the editor
    }

    $editor_file = get_theme_file_uri('/assets/css/blocks-editor-base-style' . WEAVERX_MINIFY . '.css');
    wp_enqueue_style('weaverx_blocks_base_style', $editor_file, array(), WEAVERX_VERSION);

    wp_add_inline_style('weaverx_blocks_base_style', weaverx_minify_css(weaverx_get_block_editor_style()));
}

add_action('enqueue_block_editor_assets', 'weaverx_enqueue_gutenberg_block_editor_assets');   // Gutenberg invokes this action

/**
 * Action:  Enqueue style sheets for Gutenberg Editor and Front end.
 *
 * @since 4.0
 *
 */
function weaverx_enqueue_gutenberg_block_assets(): void
{
    // enqueue for BOTH editor and front-end
    $style_file = get_theme_file_uri('/assets/css/blocks-theme-blocks' . WEAVERX_MINIFY . '.css');
    wp_enqueue_style('weaverx_blocks_block', $style_file, array(), WEAVERX_VERSION);
}

//#@@@ add_action( 'enqueue_block_assets', 'weaverx_enqueue_gutenberg_block_assets' );              // Gutenberg invokes this action


// =============================== >>> FILTER: weaverx_replace_widget_area <<< ================================
add_filter('weaverx_replace_widget_area', 'weaverx_replace_widget_area_filter');


function weaverx_replace_widget_area_filter(string $area_name): string
{
    // If a replacement widget area has been specified, then use it instead.
    $replace = weaverx_get_per_page_value('_' . $area_name);

    if ($replace) {       // see if the replacement widget area actually exists...
        if (!is_active_sidebar($replace)) {
            ?>
            <h3><?php esc_html_e('Notice: Widget Area Not Found:', 'weaver-xtreme'); ?>
                <em><?php echo $replace; ?> &larr; <?php echo $area_name; ?></em></h3>
            <p><?php echo wp_kses_post(__('You probably have not defined it as a Per Page Widget area at the bottom of the Weaver Xtreme
        <em>Main Options &rarr; Sidebars &amp; Layout</em> tab, or you may need to add
        widgets to the area.', 'weaver-xtreme')); ?></p>
            <?php
            return $area_name;
        }
        return $replace;
    }

    return $area_name;
}

//--


// =============================== >>> FILTER: weaverx_unlink_page <<< ================================
add_filter('page_link', 'weaverx_unlink_page', 10, 2);        // for stay on page

function weaverx_unlink_page(string $link, $id): string
{    // filter definition
    $stay = get_post_meta($id, '_pp_stay_on_page', true);
    if ($stay) {
        return "#";
    } else {
        return $link;
    }
}

//--


// =============================== >>> FILTER: weaverx_xtra_type_filter <<< ================================
add_filter('weaverx_xtra_type', 'weaverx_xtra_type_filter');
function weaverx_xtra_type_filter(string $type): string
{
    if ($type[0] == '+') {
        return 'inactive';
    }

    return $type;
}

//--

// =======================================>>> PAGE BUILDERS <<<==============================================

// Page Builder Filters - used to filter stuff for the header

// apply_filters( 'weaverx_replace_footer_area', 'keep_footer' ) == 'keep_footer' )
//          echo apply_filters( 'weaverx_page_builder_content', $post_id, 'footer-html', $c_class );


function weaverx_page_builder_content_filter($post_id, $where = 'pb-content', $class = ''): string
{

    $post_id = ( int )$post_id;

    if (!is_string(get_post_status($post_id))) {
        return wp_kses_post(sprintf(__('<h3>Oops! Post ID does not exist: %s</h3>', 'weaver-xtreme'), $post_id));
    }
    $out = '';

    // this code is independent of page builder - will display correctly because using the_content

    $id = ($where) ? " id='{$where}'" : '';

    $out .= "<div {$id} class=pb-content-{$where} {$class} {$where}'>\n";

    // okay, gotta fetch the_post for this post so that it will be properly intercepted by the page builder
    $args = array(
        'p' => $post_id, // ID of a page, post, or custom type
        'post_type' => 'any',
    );

    $use_posts = new WP_Query($args);
    while ($use_posts->have_posts()) {
        $use_posts->the_post();

        $out .= '<div id="post-' . $post_id . '" class="' . join(' ', get_post_class('content-page-builder')) . '">';
        $out .= apply_filters('the_content', get_the_content());
        $out .= "</div>\n";
    }
    wp_reset_query();      // undo our WP_Query
    wp_reset_postdata();
    $out .= "</div> <!-- #{$where}: {$post_id} -->\n";


    return $out;
}

add_filter('weaverx_page_builder_content', 'weaverx_page_builder_content_filter', 10, 3);

function weaverx_replace_pb_area_filter(string $area): string
{
    //if have echoed content successfully, otherwise, return $area
    //return $area;     // default - no replacement

    $use_id = weaverx_area_replacement_id($area);
    if ($use_id == 'none')                // no replacement area defined
    {
        return $area;
    }

    $before = '';
    $after = '';
    if ($area == 'header') {
        $before = '<header id="branding" ' . weaverx_schema('branding') . ' class=" ' . $area . '">';
        $after = "</header> <!-- /#branding -->\n";
    }

    switch ($area) {
        case 'header':

            $title = apply_filters('weaverx_site_title', esc_html(get_bloginfo('name', 'display')));

            $before .= "<h1 id='site-title' class='hide'>{$title}</h1>";

            $hide_menus = false;
            if (weaverx_get_per_page_value('_pp_pb_header_hide_menus') == 'show') {
                $hide_menus = false;
            } elseif (weaverx_get_per_page_value('_pp_pb_header_hide_menus') == 'hide' || weaverx_getopt('pb_header_hide_menus')) {
                $hide_menus = true;
            }

            if (!$hide_menus) {
                do_action('weaverx_nav', 'top');
            }      // ======== TOP MENU
            echo $before;
            echo weaverx_page_builder_content_filter($use_id, $area);
            echo $after;

            if (!$hide_menus) {
                do_action('weaverx_nav', 'bottom');
            }       // ======== BOTTOM MENU

            break;

        case 'footer':
            echo $before;
            echo weaverx_page_builder_content_filter($use_id, $area);
            echo $after;

            break;

        default:
            return $area;       // return name in if not legal
    }

    return 'displayed';         // different than $area in

}

add_filter('weaverx_replace_pb_area', 'weaverx_replace_pb_area_filter');

function weaverx_area_replacement_id(string $area): string
{
    // build a value for a pabe builder header/footer replacement page/post
    // per page first...
    // 'pb_header_replace_page_id' and 'pb_footer_replace_page_id' have 1st priority
    // 'elementor_header_replacement' and 'elementor_footer_replacement' are 2nd
    // 'siteorigin_header_replacement' and 'siteorigin_footer_replacement' are 3rd
    // return 'none' if none are set

    $use_id = weaverx_get_per_page_value("_pp_pb_{$area}_replace_page_id");
    if (!$use_id || $use_id == 'none') {
        $use_id = weaverx_get_per_page_value("_pp_elementor_{$area}_replacement");
    }
    if (!$use_id || $use_id == 'none') {
        $use_id = weaverx_get_per_page_value("_pp_siteorigin_{$area}_replacement");
    }

    if (!$use_id || $use_id == 'none') {
        $use_id = weaverx_getopt("pb_{$area}_replace_page_id");
    }
    if (!$use_id || $use_id == 'none') {
        $use_id = weaverx_getopt("elementor_{$area}_replacement");
    }
    if (!$use_id || $use_id == 'none') {
        $use_id = weaverx_getopt("siteorigin_{$area}_replacement");
    }

    if (!$use_id || $use_id == 'none') {
        return 'none';
    }

    return $use_id;
}

add_filter('tiny_mce_before_init', 'weaverx_theme_editor_dynamic_styles');
function weaverx_theme_editor_dynamic_styles($mceInit)
{
    $styles = 'body.mce-content-body { background-color: #ffffff}';
    if (isset($mceInit['content_style'])) {
        $mceInit['content_style'] .= ' ' . $styles . ' ';
    } else {
        $mceInit['content_style'] = $styles . ' ';
    }
    return $mceInit;
}


