<?php
/** PHP 7.4 features added */

/** @noinspection PhpConditionAlreadyCheckedInspection */
/** @noinspection PhpRedundantOptionalArgumentInspection */
/** @noinspection PhpUnusedParameterInspection */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/* lib-layout.php
 * Layout functions for Weaver X
 *  __ added - 12/11/14
 */
// Weaver Xtreme Layout Support


// determine classes for areas
function weaverx_inject_area($name, $extra_class = ''): void
{
    $area_name = '' . $name . '_insert';
    $hide_front = 'hide_front_' . $name;
    $hide_rest = 'hide_rest_' . $name;

    if (weaverx_getopt_checked($hide_front) && is_front_page()) {
        return;
    }
    if (weaverx_getopt_checked($hide_rest) && !is_front_page()) {
        return;
    }

    $idinj = 'inject_' . $name;
    $add_class = "weaverx_inject_area {$extra_class}";        // give them all this wrapping class
    $more_class = weaverx_getopt('inject_add_class_' . $name);
    if ($more_class) {
        $add_class .= " {$more_class}";
    }
    $add_class = rtrim($add_class);

    $html = apply_filters('weaverx_inject_area', weaverx_getopt($area_name), $name);
    $per_page_code = apply_filters('weaverx_inject_area', weaverx_get_per_page_value($name), $name);    /* per page values */

    if (!empty($html) || !empty($per_page_code)) {
        if ($name != 'postpostcontent') {
            if ($add_class != '') {
                echo("\t<div id=\"{$idinj}\" class=\"{$add_class}\">\n");
            } else {
                echo("\t<div id=\"{$idinj}\">\n");
            }
        } else {
            echo("\t<div class=\"{$idinj} {$add_class}\">\n");
        }
        if (!empty($html)) {    /* area insert defined? */
            if (is_front_page()) {
                weaverx_e_notopt($hide_front, do_shortcode($html));
            } else {
                weaverx_e_notopt($hide_rest, do_shortcode($html));
            }
        }
        if (!empty($per_page_code)) {
            echo do_shortcode($per_page_code);
        }
        echo("\t</div><!-- #{$idinj} -->\n");
    } elseif (is_customize_preview()) {        // emit an empty class
        if ($name != 'postpostcontent') {
            if ($add_class != '') {
                echo("\t<div id=\"{$idinj}\" class=\"{$add_class}\">\n");
            } else {
                echo("\t<div id=\"{$idinj}\">\n");
            }
        } else {
            echo("\t<div class=\"{$idinj} {$add_class}\">\n");
        }
        $add_css = weaverx_getopt("inject_{$name}_bgcolor_css");    // if the div has a border, it will show, so add message
        if (stripos($add_css, 'border') !== false) {
            esc_html_e('This empty injection area with a border is displayed only in the Customizer preview.', 'weaver-xtreme');
        }

        echo("\t</div><!-- #{$idinj} -->\n");

    }
}

//--

// >>>>> weaverx_area_class <<<<<
function weaverx_area_class($area, $p_default = 'pad', $sides = '', $margin = ''): string
{
    $class = '';

    $cols = weaverx_getopt_default($area . '_cols_int', 1);
    if ($cols > 1) {
        $l_smart = ' widget-smart-rm';
        $m_smart = ' m-widget-smart-rm';
        if (weaverx_getopt($area . '_no_widget_margins')) {
            $l_smart = '';
            $m_smart = '';
        }
        $l_class = 'widget-cols-' . $cols;
        $m_class = ' m-widget-cols-2';

        if (weaverx_getopt('_' . $area . '_lw_cols_list') != '') {
            $l_class = '';
            $l_smart = '';
        }

        if (weaverx_getopt('_' . $area . '_mw_cols_list') != '') {
            $m_class = '';
            $m_smart = '';
        }

        $class = $l_class . $l_smart . $m_class . $m_smart;
    }

    // top/bottom margin

    // Handle single post view depending on inherit from page settings setting


    // border
    if (weaverx_getopt($area . '_border')) {
        $class .= ' border';
    }
    // shadow
    $val = weaverx_getopt($area . '_shadow');
    if ($val && $val != '-0') {
        $class .= ' shadow' . $val;
    }

    // rounded
    $val = weaverx_getopt($area . '_rounded');
    if ($val && $val != 'none') {
        $class .= ' rounded' . $val;
    }

    // font-size
    $val = weaverx_getopt($area . '_font_size');
    if ($val && $val != 'default') {
        $class .= ' ' . $val;
    }

    // font-family
    $val = weaverx_getopt($area . '_font_family');
    if ($val && $val != 'default') {
        $class .= ' font-' . $val;
    }

    $class .= weaverx_get_bold_italic($area, 'bold');
    $class .= weaverx_get_bold_italic($area, 'italic');

    // hide
    $val = weaverx_getopt($area . '_hide');
    if ($val && $val != 'hide-none') {
        $class .= ' ' . $val;
    }

    // align - changed for v 4.4 due to new #wrapper alignment option
    $align = weaverx_getopt_default($area . '_align', '');
    if ($area == 'wrapper') {
        if (!$align)
            $align = 'align-center';
        $class .= ' ' . $align;         // must add align-left...
    } elseif ($align && $align != 'float-left') {
        if ($align == 'center') {
            $align = 'align-center';
        }
        $class .= ' ' . $align;
    }

    // eq height

    if (weaverx_getopt($area . '_eq_widgets')) {
        $class .= ' widget-eq';
    }

    // extend bg - removed v5


    // full width pp area (changed for V5 to alignfull)

    //if ( ( $area == 'header' || $area == 'footer' || $area == 'container') && weaverx_is_checked_page_opt( "_pp_{$area}_full" ) ) {        // look for per page settings for header and footer
    if (weaverx_is_checked_page_opt("_pp_{$area}_full")) {   // look for per page settings for full width
        $class .= ' alignfull';
    }


    // add classes
    $val = weaverx_getopt($area . '_add_class');
    if ($val) {
        $val = trim($val);
        str_replace('.', '', $val);   // no .'s allowed, so kill them hoping it will fix user errors
        str_replace(',', ' ', $val);   // and allow , separators instead of blanks
        $class .= ' ' . trim($val);
    }


    // add classes
    $val = weaverx_get_per_page_value("_pp_{$area}_add_class");
    if ($val) {
        $val = trim($val);
        str_replace('.', '', $val);   // no .'s allowed, so kill them hoping it will fix user errors
        str_replace(',', ' ', $val);   // and allow , separators instead of blanks
        $class .= ' ' . trim($val);
    }

    return trim($class);
}

//--


// >>>>> weaverx_get_bold_italic <<<<<
function weaverx_get_bold_italic($area, $which): string
{
    if ($which == 'bold') {
        $val = weaverx_getopt("{$area}_normal");    // if have a normal, there won't be a 'bold'
        if ($val) {
            return " font-weight-normal";
        }
        $val = weaverx_getopt("{$area}_bold");
        if ($val == 'on') {
            return " font-bold";
        } else {
            return '';
        }
    }

    $val = weaverx_getopt("{$area}_italic");
    if ($val == 'on') {
        return " font-italic";
    }

    return '';
}


// >>>>> weaverx_area_div <<<<<
function weaverx_area_div($who, $x_class = ''): void
{

    $c_class = $who . ' ' . weaverx_area_class($who, 'not-pad', '', '');
    if ($x_class) {
        $c_class .= ' ' . $x_class;
    }
    echo "\n" . '<div id="' . $who . '" class="' . trim($c_class) . '">';
    echo "\n";
}

//--


// >>>>> weaverx_container_div <<<<<
function weaverx_container_div($who): void
{

    $full = '';                            // handle parallax options
    if ($who == 'page') {

        $fi_loc = weaverx_get_per_page_value('_pp_fi_location');

        if (!$fi_loc) {
            $fi_loc = weaverx_getopt('page_fi_location');
        }

        if (strpos($fi_loc, 'parallax') !== false)        // parallax
        {
            $full = 'wvrx-parallax ';
        }

        if (strpos($fi_loc, '-full') !== false)        // full parallax
        {
            $full .= 'wvrx-fullwidth ';
        }

    } elseif ($who == 'single') {

        $fi_loc = weaverx_get_per_post_value('_pp_post_fi_location');

        if (!$fi_loc) {
            $fi_loc = weaverx_getopt('post_fi_location');
        }

        if (strpos($fi_loc, 'parallax-full') !== false)        // full parallax
        {
            $full = 'wvrx-parallax wvrx-fullwidth ';
        } elseif (strpos($fi_loc, 'parallax') !== false)        // full parallax
        {
            $full = 'wvrx-parallax ';
        }

    } elseif ($who == 'page-builder' || weaverx_get_per_page_value('_pp_container_full') != '') {    // make the area full width, no padding/margins

        $full = 'alignfull container-expand ';

    }

    $class = 'class="container container-' . $who . " relative {$full}"
        . weaverx_area_class('container', 'not-pad', '', '') . '"';

    echo "\n" . '<div id="container" ' . $class . '><div id="container-inside" class="block-inside">' . "\n";
    weaverx_inject_area('container_top');
}

//--


// >>>>> weaverx_content_class <<<<<
function weaverx_content_class($sb_layout, $who, $echo = true): string
{

    $c_class = weaverx_area_class('content', 'pad', '-rbl', '');
    $smart = '';
    if (weaverx_getopt('content_smartmargin')) {
        $smart = '-m';
    }

    $class = 'content ';
    switch ($sb_layout) {
        case 'right':
        case 'right-top':
            $l_content = 'l-content-rsb' . $smart;
            $class .= $l_content . ' m-full s-full ' . $c_class;
            break;

        case 'left':
        case 'left-top':
            $l_content = 'l-content-lsb' . $smart;
            $class .= $l_content . ' m-full s-full sb-float-right ' . $c_class;
            break;

        case 'split':
            $l_content = 'l-content-ssb' . $smart;
            $class .= $l_content . ' m-full s-full ' . $c_class;
            break;

        case 'split-top':
            $l_content = 'l-content-ssbs' . $smart;
            $class .= $l_content . ' m-full s-full ' . $c_class;
            break;

        case 'one-column':
            $l_content = 'l-content' . $smart;
            $class .= $l_content . ' ' . $c_class;
            break;
    }

    $class = ' class="' . trim($class) . '"';
    if ($echo) {
        echo $class;
    }

    return $class;
}

//--


// >>>>> weaverx_menu_class <<<<<
function weaverx_menu_class($who, $no_hide = false): string
{

    // for the main menu bar - submenus must be done via CSS...

    $class = '';
    // font-size
    $val = weaverx_getopt($who . '_font_size');
    if ($val && $val != 'default') {
        $class .= $val;
    }

    // font-family
    $val = weaverx_getopt($who . '_font_family');
    if ($val && $val != 'default') {
        $class .= ' font-' . $val;
    }

    $class .= weaverx_get_bold_italic($who, 'bold');
    $class .= weaverx_get_bold_italic($who, 'italic');


    // border
    if (weaverx_getopt($who . '_border')) {
        $class .= ' border';
    }

    // shadow
    $val = weaverx_getopt($who . '_shadow');
    if ($val && $val != '-0') {
        $class .= ' shadow' . $val;
    }

    // rounded
    $val = weaverx_getopt($who . '_rounded');
    if ($val && $val != 'none') {
        $class .= ' rounded' . $val;
    }

    // hide - subject to override by [show_if]
    $val = weaverx_getopt($who . '_hide');
    if ($val && $val != 'hide-none' && !$no_hide) {
        $class .= ' ' . $val;
    }

    // expand, extend removed for V5

    // fullwidth

    $wide = weaverx_getopt($who . '_align');        // added V 4.0
    if (strpos($wide, 'alignwide') !== false) {
        $class .= ' alignwide';
    } elseif (strpos($wide, 'alignfull') !== false) {
        $class .= ' alignfull';
    }

    // add classes - !important - do these LAST so will override other classes
    $val = weaverx_getopt($who . '_add_class');
    if ($val) {
        $val = trim($val);
        str_replace('.', '', $val);   // no .'s allowed, so kill them hoping it will fix user errors
        str_replace(',', ' ', $val);   // and allow , separators instead of blanks
        $class .= ' ' . trim($val);
    }

    return trim($class);
}

//--


// >>>>> weaverx_page_lead <<<<<
function weaverx_page_lead($who)
{
    // common lead in for all pages with infobar and top widget area

    $GLOBALS['weaverx_page_who'] = $who;

    get_header($who);

    if (weaverx_is_archive() || $who == 'archive_woo') {
        $sb_layout = weaverx_sb_layout_archive($who);
    } else {
        $sb_layout = weaverx_sb_layout($who);
    }

    weaverx_container_div($who);       // #container

    if ($who != 'page-builder') {
        get_template_part('templates/infobar');
    }

    weaverx_sidebar_before($sb_layout, $who);          // sidebars if top-stacking

    do_action('weaverx_per_page');

    echo '<div id="content" role="main"' . weaverx_content_class($sb_layout, $who, false) . weaverx_schema($who) . "> <!-- {$who} -->\n";
    weaverx_inject_area('precontent');

    return $sb_layout;
}

//--


// >>>>> weaverx_page_tail <<<<<
function weaverx_page_tail($who, $sb_layout): void
{

    echo "\n</div><!-- /#content -->\n";                // do not clear:both!

    weaverx_sidebar_after($sb_layout, $who);          // sidebars after content

    echo "\n<div class='clear-container-end clear-both'></div></div></div><!-- /#container-inside, #container -->\n";
    weaverx_get_footer($who);

}

//--


// >>>>> weaverx_title_class <<<<<
function weaverx_title_class($who, $class_only = false, $front = ''): string
{

    $class = $front;

    // font-size
    $val = weaverx_getopt($who . '_font_size');
    if ($val && $val != 'default') {
        $class .= ' ' . $val . '-title';
    }

    // font-family
    $val = weaverx_getopt($who . '_font_family');
    if ($val && $val != 'default') {
        $class .= ' font-' . $val;
    }

    $class .= weaverx_get_bold_italic($who, 'bold');
    $class .= weaverx_get_bold_italic($who, 'italic');


    if ($class) {
        return $class_only ? trim($class) : ' class="' . trim($class) . '"';
    } else {
        return '';
    }

}

//--


// >>>>> weaverx_text_class <<<<<
function weaverx_text_class($who, $class_only = true): string
{
    // 'title' option used for plain text
    $class = '';
    // font-size
    $val = weaverx_getopt($who . '_font_size');
    if ($val && $val != 'default') {
        $class .= $val;
    }

    // font-family
    $val = weaverx_getopt($who . '_font_family');
    if ($val && $val != 'default') {
        $class .= ' font-' . $val;
    }

    $class .= weaverx_get_bold_italic($who, 'bold');
    $class .= weaverx_get_bold_italic($who, 'italic');


    if ($class) {
        return $class_only ? ' ' . trim($class) : ' class="' . trim($class) . '"';
    } else {
        return '';
    }

}

//--


// ================================= sidebars ======================================

// >>>>> weaverx_sb_layout <<<<<
function weaverx_sb_layout($who, $is_index = false)
{
    // get sb layout for page-like content: 'layout_default', 'layout_page', 'layout_blog', 'layout_single'
    //
    // possible values: 'right', 'right-top', 'left', 'left-top', 'split', 'split-top', 'one-column'


    $per_page = '';

    if ($who == 'woocommerce') {
        $per_page = weaverx_get_per_post_value('_pp_page_layout');
    } else if (!$per_page) {
        $per_page = $is_index ? '' : weaverx_get_per_page_value('_pp_page_layout');
    }

    if ($who == '404') {
        $who = 'search';
    }   // sigh - they are the same layout
    if ($who == 'page-builder') {
        $who = 'page';    // page builder same as page
        if ($per_page == '' || $per_page == 'default') {
            $per_page = 'one-column';
        }    // default to one-column for page-builder
    }

    $layout = ($per_page) ? $per_page : weaverx_getopt_default('layout_' . $who, 'default');

    // weaverx_debug_comment( "weaverx_sb_layout  - who: {$who} layout: {$layout} per_page: {$per_page}" );

    if ($layout == 'default') {
        $layout = weaverx_getopt_default('layout_default', 'right');
    }

    return apply_filters('weaverx_sb_layout', $layout, $who);
}

//--

// >>>>> weaverx_sb_layout_archive <<<<<
function weaverx_sb_layout_archive($who)
{
    // get sb layout for archive-like content: 'layout_default_archive', 'layout_archive', 'layout_category', 'layout_tag'
    //                                         'layout_author', 'layout_search', 'layout_image'
    // same possible values

    if ($who == '404') {
        $who = 'search';
    }   // they are the same layout

    $layout = weaverx_getopt_default('layout_' . $who, 'default');

    if ($who == 'archive_woo') {
        if ($layout == 'default') {
            $layout = weaverx_getopt_default('layout_default_archive', 'default');
        }
    }


    if ($layout == 'default') {
        if ($who == 'blog') {
            $layout = weaverx_getopt('layout_default');
            if (!$layout) {
                $layout = 'right';
            }  // fallback
        } else {
            $layout = weaverx_getopt('layout_default_archive');
            if (!$layout) {
                $layout = 'one-column';
            }  // fallback
        }
    }

    return apply_filters('weaverx_sb_layout_archive', $layout, $who);
}

//---


// >>>>> weaverx_sidebar_before <<<<<
function weaverx_sidebar_before($sb_layout, $who): void
{

    switch ($sb_layout) {

        case 'right-top':           // for "top" sidebars, emit the upper sidebar before the content
        case 'split-top':
        case 'left-top':
            get_sidebar($sb_layout);
            break;

        default:
            break;

    }
}

//--


// >>>>> weaverx_sidebar_after <<<<<
function weaverx_sidebar_after($sb_layout, $who): void
{

    switch ($sb_layout) {

        case 'right':                       // for non-top sidebars, both upper and lower get emitted here together
        case 'left':
        case 'split':
            get_sidebar($sb_layout);
            break;

        case 'right-top':                   // for "top" sidebars, only the lower one gets emitted here
            get_sidebar('bottom');
            break;

        case 'split-top':
            get_sidebar('split-bottom');
            break;

        case 'left-top':
            get_sidebar('left-bottom');
            break;

        default:    // 'one-column'
            break;
    }
}

//--


if (!function_exists('weaverx_sb_precontent')) {
    function weaverx_sb_precontent($who): void
    {

        $class = 'l-widget-area-top m-widget-area-top s-widget-area-top ' . weaverx_area_class('top', 'pad');

        weaverx_put_widgetarea('sitewide-top-widget-area', $class, 'top');    // sitewide top

        if (!weaverx_is_checked_page_opt('_pp_top-widget-area')) {    // per-page hide?
            switch ($who) {
                case 'blog':
                case 'pwp':
                case 'single':
                    weaverx_put_widgetarea('blog-top-widget-area', $class, 'top');
                    break;

                case 'page':
                case 'page-builder':
                    weaverx_put_widgetarea('page-top-widget-area', $class, 'top');
                    break;

                case 'archive':
                case 'author':
                case 'category':
                case 'search':
                case 'tag':
                    weaverx_put_widgetarea('postpages-widget-area', $class, 'top');
                    break;

                case '404':
                case 'attachment':
                case 'image':
                case 'iframe':
                default:
                    break;
            }
        } // end not per page hide
    }
}
//--


// >>>>> weaverx_sb_postcontent <<<<<
function weaverx_sb_postcontent($who, $hide_sitewide = false): void
{

    weaverx_clear_both('sb-postcontent-' . $who);

    $class = 'l-widget-area-bottom m-widget-area-bottom s-widget-area-bottom ' . weaverx_area_class('bottom', 'pad');

    if (!weaverx_is_checked_page_opt('_pp_bottom-widget-area')) {
        switch ($who) {
            case 'blog':
            case 'pwp':
            case 'single':
                weaverx_put_widgetarea('blog-bottom-widget-area', $class, 'bottom');
                break;

            case 'page':
            case 'page-builder':
                weaverx_put_widgetarea('page-bottom-widget-area', $class, 'bottom');
                break;

            case 'archive':
            case 'author':
            case 'category':
            case 'tag':
            case 'search':

            case '404':
            case 'attachment':
            case 'image':
            case 'iframe':
            default:
                break;
        }
    } // end not hide bottom per page

    if (!$hide_sitewide) {
        weaverx_put_widgetarea('sitewide-bottom-widget-area', $class, 'bottom');
    }        // sitewide bottom

    weaverx_clear_both('sitewide-bottom-widget-area');
}

//--


// >>>>> weaverx_put_widgetarea <<<<<
function weaverx_put_widgetarea($area_name, $class = '', $area_class_name = ''): void
{

    $area = apply_filters('weaverx_replace_widget_area', $area_name);

    if (!weaverx_is_archive() && weaverx_is_checked_page_opt('_pp_' . $area_name)) {
        return;
    }        // hide area option checked

    unset($GLOBALS['wvr_widget_number']);     // clear for each widget
    $GLOBALS['wvr_widget_number'] = false;

    if ($area != $area_name) {   // replacement area?
        $class .= ' ' . $area;
        weaverx_t_set('use_widget_area', $area_name);                   // save state for weaverx_add_widget_classes to use later
    }

    if ($area_class_name) {
        $class .= ' widget-area-' . $area_class_name;
    }
    $class = ' ' . $class;


    if (is_active_sidebar($area)) { /* add top and bottom widget areas */
        ob_start();                 /* let's use output buffering to allow use of Dynamic Widgets plugin and not have empty sidebar */
        $success = dynamic_sidebar($area);
        $content = ob_get_clean();
        if ($success && $content) {
            ?>

            <div id="<?php echo $area_name; ?>" class="widget-area<?php echo $class; ?>"
                 role="complementary"<?php echo weaverx_schema('sidebar'); ?>>
                <?php
                if ($area_name == 'primary-widget-area') {
                    weaverx_inject_area('presidebar');
                }
                echo($content);
                weaverx_clear_both($area_name);
                ?>
            </div><!-- <?php echo $area_name; ?> -->
            <?php
            if ($area_class_name == 'top') {
                weaverx_clear_both($area_name);
            }
        }
    }
    weaverx_t_clear('use_widget_area'); // gotta do this
}

//--

// # WIDGET AREA OPTIONS

add_filter('dynamic_sidebar_params', 'weaverx_add_widget_classes');
/**
 * Adds the classes to the widget in the front-end
 */
function weaverx_add_widget_classes($params)
{

    $arr_registered_widgets = wp_get_sidebars_widgets();    // Get an array of ALL registered widgets
    $sb_id = $params[0]['id'];                              // Get the id for the current sidebar we're processing

    // add first, last, even, and odd, and widget classes

    $area_map = array(
        'primary-widget-area' => 'primary',
        'secondary-widget-area' => 'secondary',
        'sitewide-top-widget-area' => 'top',
        'page-top-widget-area' => 'top',
        'postpages-widget-area' => 'top',
        'blog-top-widget-area' => 'top',
        'sitewide-bottom-widget-area' => 'bottom',
        'page-bottom-widget-area' => 'bottom',
        'blog-bottom-widget-area' => 'bottom',
        'header-widget-area' => 'header_sb',
        'footer-widget-area' => 'footer_sb',
        'primary' => 'primary',
        'secondary' => 'secondary',
        'widget' => 'widget',
        'header' => 'header_sb',
        'footer' => 'footer_sb',
        'top' => 'top',
        'bottom' => 'bottom'                // these to simplify [extra_widget_area]
    );

    $opt_name = 'widget';                       // default styling option name: widget-xxx

    $search_sb_id = $sb_id;

    if (weaverx_t_get('use_widget_area'))    // map from replacement area or [extra_widget_area]
    {
        $search_sb_id = weaverx_t_get('use_widget_area');
    }

    foreach ($area_map as $area => $opt) {     // need to find name to use for option values
        if ($search_sb_id == $area) {
            $opt_name = $opt;
            break;
        }
    }

    $cols = weaverx_getopt($opt_name . '_cols_int');
    if (!$cols || $cols < 1) {
        $cols = 1;
    }
    if ($cols > 8) {
        $cols = 8;
    }     // sanity check

    $show_evenodd = true;

    if (!isset($arr_registered_widgets[$sb_id]) || !is_array($arr_registered_widgets[$sb_id])) {
        return $params;
    }

    if (empty($GLOBALS['wvr_widget_number']) || !isset($GLOBALS['wvr_widget_number']) || !$GLOBALS['wvr_widget_number']) {  // global to keep track of which widget this is
        $GLOBALS['wvr_widget_number'] = array();
    }
    if (isset($GLOBALS['wvr_widget_number'][$sb_id])) {        // initialize or bump widget number
        $GLOBALS['wvr_widget_number'][$sb_id]++;
    } else {
        $GLOBALS['wvr_widget_number'][$sb_id] = 1;
    }

    $is_sidebar = in_array($sb_id,
        array('primary-widget-area', 'secondary-widget-area'));        // this is a vertical widget
    $no_smart = weaverx_getopt($opt_name . '_no_widget_margins');

    $is_vert = ($cols == 1);

    $per_row_tail = ($is_vert || $no_smart) ? ' ' : '-m ';

    $class = '';

    $sides = ($is_sidebar) ? '-b' : '-rb';

    $cur_widget = $GLOBALS['wvr_widget_number'][$sb_id];
    $widget_count = count($arr_registered_widgets[$sb_id]);

    $first = ($cur_widget == 1);
    $last = ($cur_widget == $widget_count);

    $def_bottom = 'margin-bottom';
    if ($opt_name == 'header_sb') {
        $def_bottom = 'no-margin-vertical ';
    }

    $area_class = weaverx_area_class('widget', 'not-pad', $sides, $def_bottom) . ' ';

    if ($area_class) {
        $class .= $area_class;
    }


    if (!$is_vert) {
        $class .= 'per-row-' . $cols . $per_row_tail;

        $end_of_row = ($cur_widget % $cols) == 0;

        if ($widget_count > 1 && !$end_of_row && !$no_smart) {
            $class .= 'smart-rm ';
        }

        if ($end_of_row) {
            $class .= 'end-of-row ';
        }

        if (($cur_widget % $cols) == 1) {
            $class .= 'begin-of-row ';
        }
    }

    $class .= 'widget-' . $GLOBALS['wvr_widget_number'][$sb_id] . ' ';


    if ($is_vert) {
        $widget_first = 'widget-first widget-first-vert ';
        $widget_last = 'widget-last widget-last-vert ';
    } else {
        $widget_first = 'widget-first ';
        $widget_last = 'widget-last ';
    }

    if ($first) {
        $class .= $widget_first;
    }

    if ($last) {
        $class .= $widget_last;
    }

    if ($show_evenodd) {
        $widget_even = 'widget-even ';
        $widget_odd = 'widget-odd ';
        $class .= (($cur_widget % 2) ? $widget_odd : $widget_even);
    }

    // need no-margin-bottom if $cols > 1

    $params[0]['before_widget'] = str_replace('">', ' ' . trim($class) . '">', $params[0]['before_widget']);

    $title_class = weaverx_title_class('widget_title', true);
    if ($title_class) {
        $params[0]['before_title'] = str_replace('">', ' ' . trim($title_class) . '">', $params[0]['before_title']);
    }


    return $params;
}

//--


// >>>>> weaverx_no_sidebars <<<<<
function weaverx_no_sidebars($class): void
{
    if (weaverx_is_checked_page_opt('_pp_secondary-widget-area')) {
        return;
    }        // hide area option checked
    ?>
    <div id="primary-widget-area" class="widget-area <?php echo $class; ?>" role="complementary">
        <aside id="primary-widget-area" class="widget">
            <h3 class="widget-title"><?php echo('Sidebar Area'); ?></h3>
            <ul>
                <li>
                    <?php echo wp_kses_post(__('<strong>Add Some Widgets!</strong><br /><small>This theme has been designed to be used with sidebars. <span style="color:red">This message will no longer be displayed after
you add at least one widget to one of the Sidebar Widget Areas using the Appearance &rarr; Widgets control panel.</span>
<br />You can also change the sidebar layout for this page using theme options.
<br />Note: If you have added widgets, be sure you\'ve not hidden all sidebars on the Per Page options. You could switch this page to One Column.</small>', 'weaver-xtreme')); ?></li>
                <li>
                    <?php wp_loginout(); ?>
                </li>
            </ul>
        </aside>
    </div>
    <?php
}

//--


// >>>>> weaverx_has_widgetarea <<<<<
function weaverx_has_widgetarea($area_name): bool
{
    // see if a widget area is available to show...

    $area = apply_filters('weaverx_replace_widget_area', $area_name);

    if (!weaverx_is_archive() && weaverx_is_checked_page_opt('_pp_' . $area_name)) {
        return false;        // hide area option checked
    }

    if (is_active_sidebar($area)) {
        return true;
    }

    return false;
}

