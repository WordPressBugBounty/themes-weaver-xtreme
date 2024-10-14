<?php
/** PHP 7.4 features added */

/** @noinspection GrazieInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpDuplicateSwitchCaseBodyInspection */
/** @noinspection PhpFormatCallWithSingleArgumentInspection */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
// This file generates the CSS overrides from the admin interface. It will be included only
// when needed.
// _() - 12/11/14

// define default values

const WEAVERX_DEF_BORDER_COLOR = '#222';
const WEAVERX_DEF_BORDER_WIDTH = 1;
const WEAVERX_DEF_BORDER_STYLE = 'solid';
const WEAVERX_DEF_CORNER_RADIUS = 8;

const WEAVERX_DEF_TITLE_MX = 7;
const WEAVERX_DEF_TITLE_MY = 0;

const WEAVERX_DEF_TAG_MX = 10;
const WEAVERX_DEF_TAG_MY = 0; // new tagline margins


// ----------------------------------------------------------------------------------------------------------


/**
 * Generate override CSS rules based on options
 *
 */

function weaverx_generate_style_css($to_file = false): void
{
    /* This outputs the CSS overrides. It will output to a global variable, so it can be used later to write to a .css file saved
      in the user's upload directory. It is included via a standard css include. It needs to be loaded only for the admin page.
    */
    global $wvrx_css_plus;
    $wvrx_css_plus = '';

    unset($GLOBALS['weaverx_gen_css']); // release garbage
    $GLOBALS['weaverx_gen_css'] = ''; // start with blank added style


    $themew = weaverx_getopt_default('theme_width_int', WEAVERX_THEME_WIDTH);        // this is set only here

    weaverx_cat_css(sprintf("#wrapper{max-width:%dpx;}\n", $themew));

    // flaky fix for grid menus and smart menus
    if (!weaverx_getopt_checked('use_smartmenus') && current_user_can('edit_theme_options')) {
        if (weaverx_getopt('m_primary_grid_submenu') != '' || weaverx_getopt('m_secondary_grid_submenu') != '') {
            weaverx_setopt('use_smartmenus', 1);   // check it!
        }
    }

// =========================== FIXUPS: FULL WIDTH THEME ===============================
// the full width options will clear and set appropriate stretch and expand options


    // Create alignwide min-width @media

    if ($themew != WEAVERX_THEME_WIDTH) { // need to generate new alignwide rule

        $minw = (int)($themew * 1.08);    /* add 8% to width */
        $maxw = $minw - 1;

        /* reset default value for 1188px = default + 8% */

        weaverx_cat_css("@media (min-width: 1188px) {
.weaverx-sb-one-column .alignwide,#header .alignwide,#header.alignwide,#colophon.alignwide,#colophon .alignwide,
#container .alignwide,#container.alignwide,#wrapper .alignwide,#wrapper.alignwide,#infobar .alignwide,.alignwide {
margin-left: inherit;margin-right: inherit;max-width:none;width:100%;} }\n");

        weaverx_cat_css("@media (max-width: 1187px) {
.alignwide {margin-left: inherit;margin-right: inherit;max-width:none;width:100%;} }\n");

        weaverx_cat_css("@media (min-width: {$minw}px) {
.weaverx-sb-one-column .alignwide,#header .alignwide,#header.alignwide,#colophon.alignwide,#colophon .alignwide,
#container .alignwide,#container.alignwide,#wrapper .alignwide,#wrapper.alignwide,#infobar .alignwide,.alignwide {
margin-left: calc(50% - 46vw);margin-right: calc(50% - 46vw);max-width:10000px;width: 92vw;} }\n");

        weaverx_cat_css("@media (max-width: {$maxw}px) {
.alignwide {margin-left:0 !important;margin-right:0 !important;max-width:100% !important;width:100% !important;} }\n");

    }


// =========================== LINKS ===============================
//	Important. Links must come before any other rules that might define a tag - such as the menu bars, so just
//	put them here, near the top.


    weaverx_put_link('link', 'a, .wrapper a', 'a:hover, .wrapper a:hover');
    weaverx_put_link('contentlink', '.content a', '.content a:hover');
    weaverx_put_link('ilink', '.wrapper .entry-meta a, .wrapper .entry-utility a',
        '.wrapper .entry-meta a:hover,.wrapper .entry-utility a:hover');
    weaverx_put_link('wlink', '.wrapper .widget a', '.wrapper .widget a:hover');
    weaverx_put_link('ibarlink', '#infobar a', '#infobar a:hover');
    weaverx_put_link('footerlink', '.colophon a', '.colophon a:hover');


// ========================= GENERAL APPEARANCE ===============================

    $b_c = weaverx_getopt_default('border_color', WEAVERX_DEF_BORDER_COLOR);    //+
    $b_w = weaverx_getopt_default('border_width_int', WEAVERX_DEF_BORDER_WIDTH);
    $b_s = weaverx_getopt_default('border_style', WEAVERX_DEF_BORDER_STYLE);
    $menus = array(
        /* can't use multiple selectors here! */
        'm_primary' => '.menu-primary',
        'm_secondary' => '.menu-secondary',
        'm_extra' => '.menu-extra',
    );

    if ($b_c != '#222' || $b_w != 1 || $b_s != 'solid') {
        weaverx_cat_css(sprintf(".border {border:%dpx %s %s;}.border-bottom{border-bottom:%dpx %s %s;}\n", $b_w, $b_s, $b_c, $b_w, $b_s, $b_c));
    }
    foreach ($menus as $id => $tag) {
        if (weaverx_getopt("{$id}_sub_border")) {
            weaverx_cat_css(sprintf("@media ( min-width:768px) { $tag ul ul,{$tag} ul.mega-menu li {border:%dpx %s %s;}
{$tag} ul ul.mega-menu{border:none;} }\n", $b_w, $b_s, $b_c));
        }
    }


    /*  rounded_corners  */

    $r = weaverx_getopt_default('rounded_corners_radius', WEAVERX_DEF_CORNER_RADIUS);
    if ($r != 8) {
        if ($r >= 8) {
            $rm = ( int )(.75 * $r);
        } else {
            $rm = $r;
        }

        // It's time: no -moz or -webkitv ( Changed: 3.1.10 )

        $rounded = '.rounded,.rounded-all,.rounded-custom{border-radius:8px !important;}
.rounded-top{border-top-left-radius:8px; border-top-right-radius: 8px;}
.rounded-bottom {border-bottom-left-radius:8px; border-bottom-right-radius:8px;}
.rounded-left{border-top-left-radius:8px;border-bottom-left-radius:8px;}
.rounded-right{border-top-right-radius:8px;border-bottom-right-radius:8px;}';

        weaverx_cat_css(str_replace('8', $rm, $rounded) . "\n");
    }


    /*  fadebody_bg  */

    if (weaverx_getopt('fadebody_bg')) {
        weaverx_cat_css(sprintf("body {background-image: url( %s ); background-attachment: scroll; background-repeat: repeat-x;}\n",
            weaverx_relative_url('assets/images/gr.png')));
    }


// =========================== HEADER OPTIONS ===============================

    weaverx_css_style_val('#site-title,.site-title', '{max-width:%.5f%%;}',
        'site_title_max_w');

    weaverx_css_style_val('#site-tagline,.site-title', '{max-width:%.5f%%;}',
        'tagline_max_w');

    /* Site Title/Description

        Site Title' => 'title_color'
        Title Position => 'site_title_position_xy'
        Move Title over Header Image => 'title_over_image'

        Site Description => 'desc_color'
        Description Position => 'tagline_xy'

        Header Extra HTML => 'header_html'
    */


    $tx = weaverx_getopt_default('site_title_position_xy_X', WEAVERX_DEF_TITLE_MX);
    $ty = weaverx_getopt_default('site_title_position_xy_Y', WEAVERX_DEF_TITLE_MY); // new title margins

    if ($tx != 7 || $ty != 0) {
        if (is_rtl()) {
            weaverx_cat_css(sprintf("#site-title,.site-title{margin-right:%.5f%% !important;margin-top:%.5f%% !important;}\n", $tx, $ty));
        } else {
            weaverx_cat_css(sprintf("#site-title,.site-title{margin-left:%.5f%% !important;margin-top:%.5f%% !important;}\n", $tx, $ty));
        }
    }

    $tx = weaverx_getopt_default('tagline_xy_X', WEAVERX_DEF_TAG_MX);
    $ty = weaverx_getopt_default('tagline_xy_Y', WEAVERX_DEF_TAG_MY); // new tagline margins

    if ($tx != 10 || $ty != 0) {
        if (is_rtl()) {
            weaverx_cat_css(sprintf("#site-tagline{ margin-right:%.5f%% !important; margin-top:%.5f%% !important;}\n", $tx, $ty));
        } else {
            weaverx_cat_css(sprintf("#site-tagline{ margin-left:%.5f%% !important; margin-top:%.5f%% !important;}\n", $tx, $ty));
        }
    }

    $tx = weaverx_getopt('title_tagline_xy_T');
    $ty = weaverx_getopt('title_tagline_xy_B'); // title tagline padding

    if ($tx || $ty) {
        weaverx_cat_css(sprintf("#title-tagline{ padding-top:%dpx;padding-bottom:%dpx;}\n", $tx, $ty));
    }


    $align = weaverx_getopt_default('header_image_align', 'float-left');   // alignment

    switch ($align) {
        case 'align-center':
            weaverx_cat_css('#branding #header-image img{margin-left:auto;margin-right:auto;} /* ' . $align . '*/');
            weaverx_cat_css('#header.header-as-bg-parallax,#header.header-as-bg-responsive,#header.header-as-bg{background-position-x:center;}');
            break;
        case 'float-left':
            weaverx_cat_css('#branding #header-image img{float: left;} /* ' . $align . '*/');
            break;
        case 'float-right':
            weaverx_cat_css('#branding #header-image img{margin-left:auto;margin-right:0;} /* ' . $align . '*/');
            weaverx_cat_css('#header.header-as-bg-parallax,#header.header-as-bg-responsive,#header.header-as-bg{background-position-x:right;}');
            break;
        case 'alignnone':
        case 'alignwide':
        case 'alignfull':
            weaverx_cat_css('#branding #header-image img{float:none;} /* ' . $align . '*/');
            break;

        default:            // default is left and already is in style sheet.
            break;
    }

    if (($val = weaverx_getopt('header_min_height'))) {
        weaverx_cat_css("#header{min-height: {$val}px;}");
    }

    if (weaverx_getopt('header_actual_size')) {
        weaverx_cat_css('#branding #header-image img{width:auto;}');
    }

    if (($val = weaverx_getopt('header_image_max_width_dec'))) {
        weaverx_cat_css(sprintf("#branding #header-image img{max-width:%.5f%%;}\n", $val));
    }

    if (weaverx_getopt_default('header_html_align', 'float-left') == 'center') {
        weaverx_cat_css("#header-html {display:block !important;}\n");
    }

    if (weaverx_getopt_default('header_html_center_content')) {
        weaverx_cat_css("#header-html {text-align:center;}\n");
    }


    if (weaverx_getopt_default('footer_html_center_content')) {
        weaverx_cat_css("#footer-html {text-align:center;}\n");
    }

    $ratio = weaverx_getopt_default('header_video_aspect', '16:9');

    if ($ratio != '16:9') {
        $ratio = explode(':', $ratio);
        if ($ratio[0]) {
            $r_pc = ($ratio[1] / $ratio[0]) * 100.0;
        } else {
            $r_pc = 56.25;
        }
        weaverx_cat_css(sprintf(".has-header-video .header-image .wp-custom-header{padding-bottom:%.5f%%;}\n", $r_pc));
    }


// =========================== MENU OPTIONS ===============================
    /*
    text_color = 0.213 * this.rgb[0] +
            0.715 * this.rgb[1] +
            0.072 * this.rgb[2]
            < 0.5 ? '#FFF' : '#000';
    */


    $cur_page = weaverx_getopt('menubar_curpage_noancestors')
        ? '.weaverx-theme-menu .current_page_item > a,.weaverx-theme-menu .current-menu-item > a,.weaverx-theme-menu .current-cat > a'

        : '.weaverx-theme-menu .current_page_item > a,.weaverx-theme-menu .current-menu-item > a,.weaverx-theme-menu .current-cat > a,.weaverx-theme-menu .current_page_ancestor > a,' .
        '.weaverx-theme-menu .current-category-ancestor > a,.weaverx-theme-menu .current-menu-ancestor > a,.weaverx-theme-menu .current-menu-parent > a,.weaverx-theme-menu .current-category-parent > a';

    weaverx_put_color('menubar_curpage_color', $cur_page, true);    // menubar_curpage_color
    weaverx_put_bgcolor('menubar_curpage_bgcolor', $cur_page, true);

    weaverx_put_rule_if_checked('menubar_curpage_em', $cur_page . '{font-style:italic}');    // menubar_curpage_em
    weaverx_put_rule_if_checked('menubar_curpage_bold', $cur_page . '{font-weight:bold}');


// =========================== CONTENT AREAS ===============================

    // Images

    if (weaverx_getopt('restrict_img_border')) {
        $img_tag = '.comment-content img[height],.container img[class*="align"],.container img[class*="wp-image-"],.container img[class*="attachment-"],.container img.featured-image,.container img.avatar,.colophon img[class*="align"],.colophon img[class*="wp-image-"],.colophon img[class*="attachment-"],.colophon img.featured-image,.colophon img.avatar';
    } else {
        $img_tag = '.container img, .colophon img';
    }

    weaverx_css_style_val($img_tag, '{padding:%dpx;}',
        'media_lib_border_int');

    $img_w = weaverx_getopt('media_lib_border_int');
    if ($img_w > 3) {
        $half = $img_w / 2 + 1;
        $small_border_tag = '.container .gallery-icon img,.container .gallery-thumb img,#content img.gallery-thumb,#content img.avatar';
        weaverx_cat_css(sprintf("{$small_border_tag}{padding:{$half}px;}\n")); // make the thumbs smaller
    }


    if (weaverx_getopt_checked('show_img_shadows')) {
        weaverx_cat_css($img_tag .
            '{box-shadow: 0 0 2px 1px rgba( 0,0,0,0.25 );}' . "\n");
    }

    weaverx_put_bgcolor('media_lib_border_color', $img_tag);


    $val = weaverx_getopt('contentlist_bullet');
    if ($val != '' && $val != 'disc') {
        weaverx_cat_css(sprintf("#content ul {list-style-type:%s;}\n", $val));
    }
    weaverx_css_style_val('.entry-summary,.entry-content', '{padding-top:%.5fem;}',
        'space_after_title_dec');

    $val = weaverx_getopt('content_p_list_dec');

    if ($val && $val != 0) {  // treat 0 as default because of previous bug
        weaverx_css_style_val('#content ul,#content ol, #content p', '{margin-bottom:%.5fem;}',
            'content_p_list_dec');
    }

    weaverx_css_style_val('#content *[class^="wp-block-"]', '{margin-top:%.5fem;}',
        'content_block_margin_T');
    weaverx_css_style_val('#content *[class^="wp-block-"]', '{margin-bottom:%.5fem;}',
        'content_block_margin_B');

    if (weaverx_getopt('hyphenate')) {
        weaverx_cat_css('#content{hyphens:auto;}');
    }

    $fi_min_height = array(
        'page_min_height' => '.container-page.parallax',
        'post_blog_min_height' => '.post-area.post-fi-post-bg-parallax-full,.post-area.post-fi-post-bg-parallax',
        'post_min_height' => '.container-single.post-bg-parallax-full,.container-single.post-bg-parallax',
    );

    foreach ($fi_min_height as $name => $selector) {
        if (weaverx_getopt($name)) {
            $val = weaverx_getopt($name);
            weaverx_cat_css("$selector{min-height:{$val}px;}\n");
        }
    }


    /* Comments */
    weaverx_put_rule_if_checked('form_allowed_tags', '#commentform .form-allowed-tags, .commentform-allowed-tags {display:block;}');

    $b_c = weaverx_getopt('border_color');    //
    if (!$b_c) {
        $b_c = '#222';
    }
    $b_w = weaverx_getopt('border_width_int'); //
    if (!$b_w) {
        $b_w = 1;
    }
    weaverx_put_rule_if_checked('show_comment_borders', ".commentlist li.comment,#respond,.commentlist li.comment .comment-author img.avatar,.commentlist .comment.bypostauthor{border:{$b_w}px solid $b_c;}.commentlist li.comment .comment-meta{border-bottom:1px solid $b_c;}");


    weaverx_put_rule_if_checked('hide_comment_bubble', '#comments-title h3{background-image:none;padding-left:0px;}');
    weaverx_put_rule_if_checked('hide_comment_hr', 'hr.comments-hr {display:none;}');

    weaverx_put_color('comment_headings_color', '#comments-title h3, #comments-title h4, #respond h3');
    weaverx_put_bgcolor('comment_content_bgcolor', '.commentlist li.comment, #respond');
    weaverx_put_bgcolor('comment_submit_bgcolor', '#respond input#submit');


    /*  weaverx_tables  */
    $table = weaverx_getopt('weaverx_tables');

    if ($table == 'wide') {    // make backward compatible with 1.4 and before when Twenty Ten was default
        weaverx_cat_css(sprintf("#content table {border: 1px solid #e7e7e7;margin: 0 -1px 24px 0;text-align: left;width: 100%%;}
#content tr th, #content thead th {color: #888;font-size: 12px;font-weight: bold;line-height: 18px;padding: 9px 24px;}
#content tr td {border-style:none; border-top: 1px solid #e7e7e7; padding: 6px 24px;}
#content tr.odd td {background: rgba( 0,0,0,0.1 );}\n"));
        //weaverx_cat_css"#content tr.odd td{background:transparent;}\n" );
    } elseif ($table == 'bold') {
        weaverx_cat_css(sprintf("#content table {border: 2px solid #888;}
#content tr th, #content thead th {font-weight: bold;}
#content tr td {border: 1px solid #888;}\n"));
    } elseif ($table == 'noborders') {
        weaverx_cat_css(sprintf("#content table {border-style:none;}
#content tr th, #content thead th {font-weight: bold;border-bottom: 1px solid #888;background-color:transparent;}
#content tr td {border-style:none;}table,td,th{border:none}\n"));
    } elseif ($table == 'fullwidth') {
        weaverx_cat_css(sprintf("#content table {width:100%%;}
#content tr th, #content thead th {font-weight:bold;}\n"));
    } elseif ($table == 'plain') {
        weaverx_cat_css(sprintf(
            "#content table {border: 1px solid #888;text-align:left;margin: 0 0 0 0;width:auto;}
#content tr th, #content thead th {color: inherit;background:none;font-weight:normal;line-height:normal;padding:4px;}
#content tr td {border: 1px solid #888; padding:4px;}\n"));
    }


    /*  caption_color  */
    weaverx_put_color('caption_color', '.wp-caption p.wp-caption-text, #content .gallery .gallery-caption,.entry-attachment .entry-caption, #content figure figcaption');


// =========================== POST SPECIFIC AREAS ===============================

    weaverx_put_rule_if_checked('show_comments_closed', '.nocomments {display:block;}');

    // single/post navigation links

    weaverx_put_rule_if_checked('nav_show_first', '#nav-above{display:block;}'); // put this one first, so hide can override
    weaverx_put_rule_if_checked('nav_hide_above', '#nav-above,.paged #nav-above{display:none;margin:0;}');
    weaverx_put_rule_if_checked('nav_hide_below', '#nav-below{display:none;margin:0;}');

    if (weaverx_getopt('single_nav_style') == 'hide' || weaverx_getopt_checked('single_nav_hide_above')) {
        weaverx_cat_css(".single #nav-above{display:none;margin:0;}\n");
    }
    if (weaverx_getopt('single_nav_style') == 'hide' || weaverx_getopt_checked('single_nav_hide_below')) {
        weaverx_cat_css(".single #nav-below{display:none;margin:0;}\n");
    }
    $nav = weaverx_getopt('nav_style');    // paged can take more than 50%
    if ($nav == 'paged_left') {
        weaverx_cat_css(".nav-previous {width:95%;}\n");
    }
    if ($nav == 'paged_right') {
        weaverx_cat_css(".nav-next {width:95%;}\n");
    }


    weaverx_put_color('post_icons_color',
        '.entry-meta-gicons .entry-date:before,.entry-meta-gicons .by-author:before,.entry-meta-gicons .cat-links:before,.entry-meta-gicons .tag-links:before,.entry-meta-gicons .comments-link:before,.entry-meta-gicons .permalink-icon:before');

    weaverx_put_rule_if_checked('post_hide_single_author', '.single-author .entry-meta .by-author {display:none;}');

    if (($val = weaverx_getopt_default('post_avatar_int', 28)) != 28) {
        weaverx_cat_css('.post-avatar img {max-width:' . $val . "px;}\n");
    }

// ============================== WIDGET AREAS ===================================


    $val = weaverx_getopt('widgetlist_bullet');
    if ($val != '' && $val != 'disc') {
        weaverx_cat_css(sprintf(".widget ul {list-style-type:%s;}\n", $val));
    }

// ================================== FONTS =====================================

    // 0.0625 assumes standard default font size of 16
    $font_size = weaverx_getopt('site_fontsize_int');
    if ($font_size) {
        weaverx_cat_css(sprintf("body{font-size:%.5fem;}\n", $font_size * 0.0625));
    }

    $font_size = weaverx_getopt('site_fontsize_tablet_int');  // tablet
    if ($font_size) {
        weaverx_cat_css(sprintf('@media ( min-width: 581px) and ( max-width: 767px) {body{font-size:%.5fem;}}', $font_size * 0.0625));
    }

    $font_size = weaverx_getopt('site_fontsize_phone_int');   // .is-phone
    if ($font_size) {
        weaverx_cat_css(sprintf('@media (max-width: 580px) {body{font-size:%.5fem;}}', $font_size * 0.0625));
    }

    if (($site_h = weaverx_getopt('site_line_height_dec'))) {
        weaverx_cat_css(sprintf('body{line-height:%.5f;}', $site_h));
        weaverx_cat_css(sprintf('.widget-area{line-height:%.5f;}', ($site_h * .85)));
    }

    $space = weaverx_getopt('font_letter_spacing_global_dec');
    if ($space && $space != 0) {
        weaverx_cat_css(sprintf("body{letter-spacing:%.5fem;}\n", $space));
    }

    $space = weaverx_getopt('font_word_spacing_global_dec');
    if ($space && $space != 0) {
        weaverx_cat_css(sprintf("body{word-spacing:%.5fem;}\n", $space));
    }


    $font_opts = array(
        'wrapper' => '#wrapper, .wrapper',
        'container' => '#container',
        'header' => '#header',
        'site_title' => '#wrapper #site-title a,.wrapper .site-title a',
        'tagline' => '#site-tagline > span,.site-tagline > span',
        'header_sb' => '#header-widget-area',
        'header_html' => '#header-html',
        'm_primary' => '#nav-primary',
        'm_secondary' => '#nav-secondary',
        'm_header_mini' => '#nav-header-mini',
        'm_extra' => '.extra-men-xplus',
        'info_bar' => '#infobar',
        'content' => '#content',
        'content_h' => '.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6',
        'page_title' => '.page-title',
        'archive_title' => '.archive-title',
        'post' => '.post-area',
        'post_title' => '.post-title',
        'primary' => '#primary-widget-area',
        'secondary' => '#secondary-widget-area',
        'top' => '.widget-area-top',
        'bottom' => '.widget-area-bottom',
        'widget' => '.widget',
        'widget_title' => '.widget_title',
        'footer' => '#colophon',
        'footer_sb' => '#footer-widget-area',
        'footer_html' => '#footer_html',
    );

    foreach ($font_opts as $fopt => $selector) {
        $space = weaverx_getopt($fopt . '_word_spacing');
        if ($space && $space != 0) {
            weaverx_cat_css(sprintf($selector . "{word-spacing:%.5fem;}\n", $space));
        }

        $space = weaverx_getopt($fopt . '_letter_spacing');
        if ($space && $space != 0) {
            weaverx_cat_css(sprintf($selector . "{letter-spacing:%.5fem;}\n", $space));
        }

        $trans = weaverx_getopt($fopt . '_transform');
        if ($trans && $trans != '') {
            weaverx_cat_css(sprintf($selector . "{text-transform:%s;}\n", $trans));
        }

        if (weaverx_getopt_checked($fopt . '_outline')) { // show font as outlined
            $out_color = weaverx_getopt('font_color_outline');
            if (!$out_color || $out_color == '' || $out_color == 'inherit') {
                $out_color = '#f8f8f8';
            } else {
                $out_color .= ' !important';
            }
            weaverx_cat_css($selector . "{color: $out_color;font-weight: bold;letter-spacing: 0.18rem;text-shadow:-1px -1px 0 #080808,1px -1px 0 #080808,-1px 1px 0 #080808,1px 1px 0 #080808;}");
        }

    }

// ============================== CUSTOM OPTIONS =================================

    if (($val = weaverx_getopt('custom_fontsize_a'))) {
        weaverx_cat_css('.customA-font-size{font-size:' . $val . 'em;}');
        weaverx_cat_css(sprintf('.customA-font-size-title{font-size:%.5fem;}', $val * 1.5));
    }
    if (($val = weaverx_getopt('custom_fontsize_b'))) {
        weaverx_cat_css('.customB-font-size{font-size:' . $val . 'em;}');
        weaverx_cat_css(sprintf('.customB-font-size-title{font-size:%.5fem;}', $val * 1.5));
    }

    if (($val = weaverx_getopt('custom_shadow'))) {
        weaverx_cat_css('.shadow-custom ' . weaverx_fix_braces($val));
    }


// ================================ AREAS ========================================

    weaverx_put_bgcolor('body_bgcolor', 'body');   // start with the body colors/css+
    weaverx_put_bgcolor('title_tagline_bgcolor', '#title-tagline');


    $menu_bars = array(
        'm_primary' => '.menu-primary .wvrx-menu-container,.menu-primary .site-title-on-menu,.menu-primary .site-title-on-menu a',
        'm_secondary' => '.menu-secondary .wvrx-menu-container',
        'm_extra' => '.menu-extra .wvrx-menu-container',
        'm_primary_sub' => '.menu-primary .wvrx-menu ul li a,.menu-primary .wvrx-menu ul.mega-menu li',
        'm_secondary_sub' => '.menu-secondary .wvrx-menu ul li a,.menu-secondary .wvrx-menu ul.mega-menu li',
        'm_extra_sub' => '.menu-extra .wvrx-menu ul li a,.menu-extra .wvrx-menu ul.mega-menu li',
    );

    $menu_links_bg = array(
        // xxx_link_bgcolor
        'm_primary' => '.menu-primary .wvrx-menu > li > a',
        'm_secondary' => '.menu-secondary .wvrx-menu > li > a',
        'm_extra' => '.menu-extra .wvrx-menu > li > a',
    );

    $menu_links = array(
        // color, _hover_color, _hover_bg_color
        'm_primary' => '.menu-primary .wvrx-menu > li > a',
        'm_secondary' => '.menu-secondary .wvrx-menu > li > a',
        'm_extra' => '.menu-extra .wvrx-menu > li > a',
        'm_primary_sub' => '.menu-primary .wvrx-menu ul li a',
        'm_secondary_sub' => '.menu-secondary .wvrx-menu ul li a',
        'm_extra_sub' => '.menu-extra .wvrx-menu ul li a',
    );

    $menu_detail = array(
        /* can't use multiple selectors here! */
        'm_primary' => '.menu-primary',
        'm_secondary' => '.menu-secondary',
        'm_extra' => '.menu-extra',
    );

// =Menus ------------------------------------------------------------

    foreach ($menu_bars as $id => $tag) {
        weaverx_put_bgcolor($id . '_bgcolor', $tag);
        weaverx_put_color($id . '_color', $tag);
    }

    foreach ($menu_links_bg as $id => $tag) {
        weaverx_put_bgcolor($id . '_link_bgcolor', $tag);
    }

    foreach ($menu_links as $id => $tag) {
        weaverx_put_color($id . '_color', $tag);
        weaverx_put_color($id . '_hover_color', $tag . ':hover', true);
        if (weaverx_getopt('m_retain_hover') && strpos($id, '_sub') === false) {
            $rule = str_replace('> li', 'li:hover', $tag);
            weaverx_put_bgcolor($id . '_hover_bgcolor', $rule, true);

        } else {
            weaverx_put_bgcolor($id . '_hover_bgcolor', $tag . ':hover', true); // important to override current item bg

        }
    }

    // menu logo height
    $h = weaverx_getopt('m_primary_logo_height_dec');
    if ($h && $h != 0) {
        weaverx_cat_css(sprintf('.menu-primary .custom-logo-on-menu img {height:%.5fem;}', $h));
    }
    $h = weaverx_getopt('header_logo_height_dec');
    if ($h && $h != 0) {
        //weaverx_cat_css( sprintf( '#site-title img.site-title-logo{max-height:%.5fem;height:100%%;width:100%%;padding-right:1%%;}', $h ) );
        weaverx_cat_css(sprintf('#site-title img.site-title-logo {max-height:%dpx;}', $h));
    }


    foreach ($menu_detail as $id => $tag) {
        weaverx_put_color($id . '_color', $tag . ' .menu-toggle-button');

        weaverx_put_color($id . '_html_color', $tag . ' .wvrx-menu-html');              // Extra menu HTML Left/Right
        $val = weaverx_getopt($id . '_html_margin_dec');

        if ($val) {
            weaverx_cat_css(sprintf($tag . " .wvrx-menu-html{margin-top:%.5fem;}\n", $val));
        } else {
            $font_size = weaverx_getopt($id . '_font_size');    // generate new top margin based on font_size
            switch ($font_size) {
                case 'xxs-font-size':
                    weaverx_cat_css($tag . " .wvrx-menu-html{margin-top:.375em;}\n");
                    break;
                case 'xs-font-size':
                    weaverx_cat_css($tag . " .wvrx-menu-html{margin-top:.425em;}\n");
                    break;
                case 's-font-size':
                    weaverx_cat_css($tag . " .wvrx-menu-html{margin-top:.5em;}\n");
                    break;
                case 'l-font-size':
                case 'xl-font-size':
                case 'xxl-font-size':
                case 'huge-font-size':
                    weaverx_cat_css($tag . " .wvrx-menu-html{margin-top:.425em;}\n");
                    break;
                default:
                    break;
            }
        }


        // padding
        $pad = weaverx_getopt($id . '_menu_bar_pad_dec');
        if ($pad) {
            weaverx_cat_css(sprintf("{$tag} .wvrx-menu-container{padding-top:%.5fem;padding-bottom:%.5fem;}\n", $pad, $pad));
        }


        $pad = weaverx_getopt($id . '_menu_pad_dec');
        $dcolor = weaverx_getopt($id . '_dividers_color');
        $rpad = weaverx_getopt($id . '_right_padding_dec');
        $hide_arrows = weaverx_getopt($id . '_hide_arrows');

        weaverx_cat_css("@media( min-width:768px) {\n");    // following are really .is-desktop. Note last align rule has closing }


        if ($pad != '') {
            weaverx_cat_css(sprintf("{$tag} .wvrx-menu a{padding-top:%.5fem;padding-bottom:%.5fem;}\n", $pad, $pad));

            if ($pad > 1.9)       // arrows need adjustments - these are for Genericons
            {
                weaverx_cat_css(sprintf("{$tag} .menu-arrows .toggle-submenu:after{top:%.5fem;}\n", ($pad + 1.2)));
            } elseif ($pad > 0.6) {
                weaverx_cat_css(sprintf("{$tag} .menu-arrows .toggle-submenu:after{top:%.5fem;}\n", ($pad + 0.75)));
            } elseif ($pad < 0.6) {
                weaverx_cat_css(sprintf("{$tag} .menu-arrows .toggle-submenu:after{top:%.5fem;}\n", ($pad + 0.5)));
            }
        }

        // dividers

        if ($dcolor != '') {

            weaverx_cat_css("{$tag} .wvrx-menu a{border-right:1px solid {$dcolor};}\n");
            weaverx_cat_css("{$tag} ul.wvrx-menu > li:first-child {border-left:1px solid {$dcolor};}\n");
            // only desktop?
            weaverx_cat_css("{$tag} .wvrx-menu ul > li:first-child{border-top:1px solid {$dcolor};}\n");
            weaverx_cat_css("{$tag} .wvrx-menu ul a {border-top:none;border-left:none;border-right:none;border-bottom:1px solid {$dcolor};}\n");
        }

        // menu padding - ADD space to end of menu item

        if ($rpad != '') {
            $rpad_arrow = $rpad + 1.5;
            $rpad_a = $rpad + 0.75;
            weaverx_cat_css("{$tag} .wvrx-menu-container li a{padding-right:{$rpad_a}em;}\n");
            weaverx_cat_css("{$tag} .menu-hover.menu-arrows .has-submenu > a{padding-right:{$rpad_arrow}em;}\n");
            weaverx_cat_css("{$tag} .menu-arrows.menu-hover .toggle-submenu{margin-right:{$rpad}em;}\n");
        }

        // menu margins

        $mtop = weaverx_getopt($id . '_top_margin_dec');
        $mbot = weaverx_getopt($id . '_bottom_margin_dec');
        if ($mtop != '') {
            weaverx_cat_css("{$tag} .wvrx-menu-container{margin-top:{$mtop}px;}\n");
        }


        if ($mbot != '') {
            $align = weaverx_getopt($id . '_align');    // emit different  code depending on align
            if (strstr($align, '-fixed') === false)    // standard menu margin
            {
                weaverx_cat_css("{$tag} .wvrx-menu-container{margin-bottom:{$mbot}px;}\n");
            }
        }


        // Menu Arrows

        if ($hide_arrows) {
            weaverx_cat_css("{$tag} .menu-arrows .toggle-submenu:after{content:'';display:none;}\n");
            if ($rpad == '') {
                weaverx_cat_css("{$tag} .menu-hover.menu-arrows .has-submenu > a {padding-right:0.75em;}\n");
            }
            weaverx_cat_css("{$tag} .wvrx-menu a span.sub-arrow:after{display:none;}\n");
        }

        // special case - generate a .wvrx-menu text align for main menus to get rid of initial menu jumping
        $align = weaverx_getopt_default("{$id}_align", 'left');
        $align = str_replace('alignwide ', '', $align);
        $align = str_replace('alignfull ', '', $align);
        $lh = '';
        if ($align == 'center')        // compensate for centered display:inline-block
        {
            $lh = 'line-height:0;';
        }

        weaverx_cat_css("{$tag} .wvrx-menu,{$tag} .wvrx-menu-container{text-align:{$align};{$lh}}\n}\n");    // NOTE! Has @media close }


        $color = weaverx_getopt($id . '_color');

        if ($color) {
            weaverx_cat_css(
                sprintf("{$tag} .menu-arrows .toggle-submenu:after{color:{$color};}\n"));
            weaverx_cat_css(
                sprintf("{$tag} .menu-arrows ul .toggle-submenu:after{color:{$color};}\n"));
            weaverx_cat_css(
                sprintf("{$tag} .menu-arrows.is-mobile-menu.menu-arrows ul a .toggle-submenu:after{color:{$color};}\n"));
        }

        $color = weaverx_getopt("{$id}_sub_color");    // sub-menu arrow takes special handling to override
        if ($color) {
            weaverx_cat_css(sprintf("{$tag} .menu-arrows ul .toggle-submenu:after{color:{$color};}\n"));
        }

        // alternative mobile menu arrow clickable
        weaverx_put_bgcolor($id . '_clickable_bgcolor', "{$tag} .is-mobile-menu.menu-arrows .toggle-submenu");
    }


// End of Menus

// ================================ MARGINS/PADDING/SMART WIDGETS ===================================

    /*
     *
    .l-content {width:100%;}
    .l-content-m {width:98%;margin-left:1%;margin-right:1%;}

    .l-sb-left, .l-sb-right, .l-sb-left-split, .l-sb-right-split {width:25%;}
    .l-sb-left-lm, .l-sb-right-lm, .l-sb-left-split-lm, .l-sb-right-split-lm {width:24%;margin-left:1%;}
    .l-sb-left-rm, .l-sb-right-rm, .l-sb-left-split-rm, .l-sb-right-split-rm {width:24%;margin-right:1%;}

    .l-widget-area-top, .l-widget-area-bottom {width:100%;}

    */
    // smart -lm, -rm, -m   : value is 'smart_margin_int'

    $smart = weaverx_getopt_default('smart_margin_int', 1);
    if ($smart > 25 || $smart < 1) {
        $smart = 1;
    }  // some sanity check


    if ($smart != 1) {
        weaverx_cat_css('@media ( min-width:768px) {');    // .is-desktop
        for ($i = 2; $i <= 8; $i++) {
            $w = ((99.9999 / $i) - $smart) + ($smart / $i);  // 99.9999 just a little rounding fudge factor */
            weaverx_cat_css(sprintf(".per-row-%d-m{width:%.5f%%;}", $i, $w));
        }
        weaverx_cat_css("}\n@media ( min-width:581px) and ( max-width:767px) { ");    // small tablets
        weaverx_cat_css(sprintf(".per-row-2-m.per-row-3-m.per-row-4-m,.per-row-5-m.per-row-6-m,.per-row-7-m,.per-row-8-m{width:%.5f%%;}", 49.999 - ($smart / 2.0)));
        weaverx_cat_css("\n.m-widget-smart-rm aside{margin-right:{$smart}%;} }
.widget-smart-rm aside{margin-right:{$smart}%;}\n");    // global
    }

    weaverx_sidebar_style();      // generate sidebar style


    /* _bgcolor, _color : MUST BE AFTER OTHER AREA OPTIONS BECAUSE OF CSS+ */


    $sb_areas = array(
        'primary' => '#primary-widget-area',
        'alt:primary' => '.widget-area-primary',
        'secondary' => '#secondary-widget-area',
        'alt:secondary' => '.widget-area-secondary',
        'top' => '.widget-area-top',
        'bottom' => '.widget-area-bottom',
        'header' => '#header',
        'header_html' => '#header-html',
        'header_sb' => '#header-widget-area',
        'alt:header_sb' => '.widget-area-header',
        'footer' => '#colophon',
        'footer_html' => '#footer-html',
        'footer_sb' => '#footer-widget-area',
        'alt:footer_sb' => '.widget-area-footer',
        'content' => '#content',
        'container' => '#container',
        'infobar' => '#infobar',
        'wrapper' => '#wrapper',
        'post' => '.post-area',
        'widget' => '.widget',
    );

    foreach ($sb_areas as $area => $tag) {
        $id = str_replace('alt:', '', $area);    // allow double rules
        weaverx_put_bgcolor($id . '_bgcolor', $tag);
        weaverx_put_color($id . '_color', $tag);


        if ($area == 'content' || $area == 'post') {     // #content is % instead of px
            weaverx_css_style_val($tag, '{padding-left:%.5f%%;}', $id . '_padding_L');
            weaverx_css_style_val($tag, '{padding-right:%.5f%%;}', $id . '_padding_R');
        } elseif (!weaverx_align_wf($area)) {
            weaverx_css_style_val($tag, '{padding-left:%dpx;}', $id . '_padding_L');
            weaverx_css_style_val($tag, '{padding-right:%dpx;}', $id . '_padding_R');
        } else {
            $padLR = weaverx_getopt($id . '_padding_LRp');
            if ($padLR != 0) {
                weaverx_cat_css('@media( min-width: 768px) {' .
                    $tag . '{padding-left:' . $padLR . '%;padding-right:' . $padLR . '%;}');
                weaverx_cat_css('} @media( max-width: 767px) {' .
                    "{$tag}{padding-left:.5%;padding-right:.5%}}\n");
            }
        }

        weaverx_css_style_val($tag, '{padding-top:%dpx;}', $id . '_padding_T');
        weaverx_css_style_val($tag, '{padding-bottom:%dpx;}', $id . '_padding_B');

        weaverx_css_style_val($tag, '{margin-top:%dpx;}', $id . '_margin_T');
        weaverx_css_style_val($tag, '{margin-bottom:%dpx;}', $id . '_margin_B');
    }

    $max_w_areas = array(
        // special areas with px max-width and extend bg color
        'header' => '#header',
        'footer' => '#colophon',
        'container' => '#container',
        'm_primary' => '.menu-primary',
        'm_secondary' => '.menu-secondary',
        'm_extra' => '.menu-extra',
    );

    foreach ($max_w_areas as $id => $tag) {
        if (!weaverx_align_wf($id)) {

            $w = weaverx_getopt($id . '_max_width_int');
            if ($w) {
                weaverx_cat_css("{$tag}" . "{max-width:{$w}px;}\n");
            }

            $xbg = weaverx_getopt($id . '_extend_bgcolor');               // deprecated - remove in future versions
            if ($xbg && $xbg != 'inherit') {
                $cname = "{$tag}";
                weaverx_cat_css(
                    "{$cname}{position:relative;overflow:visible;}
{$cname}:before{content:'';position:absolute;top:0;bottom:0;left:-9998px;right:0;
border-left:9999px solid {$xbg};box-shadow:9999px 0 0 {$xbg};z-index:-1;}\n"
                );
            }
        }
    }

// custom widths for header, footer widget areas

    $hf_sb = array(
        '_header_sb_' => '#header-widget-area',
        '_footer_sb_' => '#footer-widget-area',
        'alt:_header_sb_' => '.widget-area-header',
        'alt:_footer_sb_' => '.widget-area-footer',
        '_primary_' => '#primary-widget-area',
        '_secondary_' => '#secondary-widget-area',
        'alt:_primary_' => '.widget-area-primary',
        'alt:_secondary_' => '.widget-area-secondary',
        '_top_' => '.widget-area-top',
        '_bottom_' => '.widget-area-bottom',
    );
    $hf_sb_w = array('lw_' => '@media (min-width:768px)', 'mw_' => '@media ( min-width:581px) and (max-width:767px)', 'sw_' => '@media (max-width:580px)');

    foreach ($hf_sb as $sbval => $area) {                // process each area with custom widget widths;
        foreach ($hf_sb_w as $sb_w => $media) {         // process each device

            $sb = str_replace('alt:', '', $sbval);       // Allow double rules

            $list = trim(weaverx_getopt($sb . $sb_w . 'cols_list'));

            if ($list == '') {
                continue;
            }
            $list = str_replace('%', '', $list);      // kill %'s
            $list = str_replace(',', ' ', $list);     // change ,'s to blanks
            $list = str_replace(' ;', ';', $list);    // be sure the ; is right after the value
            $list = str_replace(';', '; ', $list);    // be sure have space after ;
            $list = array_filter(explode(' ', $list), 'strlen');   // explode list, filter null strings

            weaverx_cat_css("{$media} {\n");        // wrap rules in media

            $m = $smart;

            if (weaverx_getopt(substr($sbval, 1) . 'no_widget_margins')) // no margins? ( fixed for 3.0, had wrong prefix )
            {
                $m = 0;
            }

            weaverx_cat_css("{$area} .widget {float:left;margin-left:0;margin-right:0}\n");  // reset previous list margins

            $clear = 'clear:both';
            $i = 0;
            foreach ($list as $val) {              // step through the list of values
                $i++;

                $w = str_replace(';', '', $val);    // strip ;
                $at_end = ($w != $val);          // force end if was a ; before

                if ($w === '0') {                 // hide this widget
                    weaverx_cat_css($area . ' .widget-' . $i . "{display:none;}\n");
                } elseif (is_numeric($w)) {     // small check for bad user values
                    if ($at_end) {            // at end of row
                        weaverx_cat_css(sprintf("%s .widget-%d{width:%.5f%%;%s;}\n", $area, $i, $w, $clear));
                        $clear = 'clear:both;';
                    } else {
                        weaverx_cat_css(sprintf("%s .widget-%d{width:%.5f%%;margin-right:%.5f%%;%s}\n", $area, $i, ($w - $m), $m, $clear));
                        $clear = '';
                    }
                }
            }
            weaverx_cat_css("}\n");    // end of @media wrap

        }    // end for each device type
    }        // end of each area


// ==================================== EXPAND &  EXTEND BG TO FULL WIDTH ==================================
// No longer needed with Weaver Xtreme V5


// ================================ COLORS ===================================
// Colors need to go last because they might have CSS +

    $titles = array(
        'site_title' => '.wrapper #site-title a,.wrapper .site-title a',
        'tagline' => '#site-tagline > span,.site-tagline > span',
        'page_title' => '.page-title',
        'post_title' => '.wrapper .post-title',
        'archive_title' => '.archive-title',
        'widget_title' => '.widget-title',
        'm_header_mini' => '#nav-header-mini',
        'content_h' => '.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6',
    );

    foreach ($titles as $title => $rule) {
        weaverx_put_bgcolor($title . '_bgcolor', $rule);

        // bar under some titles
        if (($val = ( int )weaverx_getopt($title . '_underline_int'))) {
            $titleColor = weaverx_getopt($title . '_color');
            if ($titleColor == '' || $titleColor == 'inherit') {
                $titleColor = weaverx_getopt('content_color');
            }   // content_color, etc, colors are generated by $area . '_color'
            if ($titleColor == '' || $titleColor == 'inherit') {
                $titleColor = weaverx_getopt('container_color');
            }
            if ($titleColor == '' || $titleColor == 'inherit') {
                $titleColor = weaverx_getopt('wrapper_color');
            }
            if ($titleColor == '' || $titleColor == 'inherit') {
                $titleColor = '#222';
            } /* if they want a border, this is the fallback color */
            weaverx_cat_css(sprintf($rule . "{border-bottom: {$val}px solid {$titleColor};}\n"));
        }

        if ($title == 'content_h') {       // these aren't handled by adding a style
            weaverx_put_rule_if_checked($title . '_normal', $rule . '{font-weight:normal !important;}'); // not bold?

            $val = weaverx_getopt($title . '_italic');
            if ($val == 'on') {
                weaverx_cat_css("{$rule}{font-style:italic;}\n");
            } elseif ($val == 'off') {
                weaverx_cat_css("{$rule}{font-style:normal;}\n");
            }
        }

        if ($title == 'post_title' || $title == 'm_header_mini')   // stupid special cases because want the bg to work right ...
        {
            $rule = $rule . ' a,' . $rule . ' a:visited';
        }

        weaverx_put_color($title . '_color', $rule);
    }

    weaverx_put_color('post_title_hover_color', '.wrapper .post-title a:hover');
    weaverx_put_color('m_header_mini_hover_color', '#nav-header-mini a:hover');
    $val = weaverx_getopt('m_header_mini_top_margin_dec');
    if ($val != '') {
        weaverx_cat_css(sprintf("#nav-header-mini{margin-top:%.5fem}\n", $val));
    }

    weaverx_put_bgcolor('stickypost_bgcolor', '.blog .sticky');

    weaverx_put_bgcolor('post_author_bgcolor', '#author-info');


    weaverx_put_bgcolor('hr_color', 'hr');
    weaverx_put_bgcolor('post_info_top_bgcolor', '.entry-meta');
    weaverx_put_color('post_info_top_color', '.entry-meta');

    weaverx_put_bgcolor('post_info_bottom_bgcolor', '.entry-utility');
    weaverx_put_color('post_info_bottom_color', '.entry-utility');

    weaverx_put_bgcolor('input_bgcolor', 'input,textarea');
    weaverx_put_color('input_color', 'input,textarea');

// ==================== SEARCH =====================

    weaverx_put_bgcolor('search_bgcolor', '.search-field,#header-search .search-field:focus,.menu-search .search-field:focus');
    weaverx_put_color('search_color', '.search-field, #header-search .search-field:focus');

    $search_areas = array(
        /* search box icon color */

        'primary' => '#primary-widget-area',
        'secondary' => '#secondary-widget-area',
        'm_primary' => '.menu-primary .wvrx-menu-container',
        'top' => '.widget-area-top',
        'bottom' => '.widget-area-bottom',
        'header_sb' => '.widget-area-header',
        'footer' => '#colophon',
        'footer_sb' => '.widget-area-footer',
        'content' => '#content',
        'container' => '#container',
        'infobar' => '#infobar',
        'wrapper' => '#wrapper',
        'widget' => '.widget',
    );

    foreach ($search_areas as $area => $tag) {
        weaverx_put_color($area . '_color', $tag . ' .search-form .search-submit');
    }
    weaverx_put_color('header_color', '#header-search .search-form::before');

    weaverx_put_elementor_colors();


// =============================== TITLES ==================================

// injection area bg colors

    $htmls = array(
        'preheader',
        'header',
        'prewrapper',
        'container_top',
        'postinfobar',
        'precontent',
        'postpostcontent',
        'precomments',
        'pagecontentbottom',
        'postcomments',
        'prefooter',
        'postfooter',
        'presidebar',
        'fixedtop',
        'fixedbottom',
        'postheader',
    );
    foreach ($htmls as $val) {             // includes areas from Weaver Xtreme Plus, too.
        $prefix = ($val == 'postpostcontent') ? '.' : '#';
        weaverx_put_bgcolor('inject_' . $val . '_bgcolor', $prefix . 'inject_' . $val);
    }

    if (($val = weaverx_getopt('post_title_bottom_margin_dec'))) {
        weaverx_cat_css(".post-title{margin-bottom:{$val}em;}\n");
    }


    weaverx_cat_css("#inject_fixedtop,#inject_fixedbottom,.wvrx-fixedtop,.wvrx-fixonscroll{max-width:{$themew}px;}\n");

// Set position when browser below site-width

    weaverx_cat_css("@media ( max-width:{$themew}px) {.wvrx-fixedtop,.wvrx-fixonscroll,#inject_fixedtop,#inject_fixedbottom {left:0px;margin-left:0 !important;margin-right:0 !important;}}\n");

// ==================== SINGLE PAGE POST OVERRIDES =====================

    if (weaverx_getopt('style_single_like_content')) {
        weaverx_cat_css(".content-single {background-color:inherit;color:inherit;}\n");
    }

//----------------FIXED TOP Positioning rules --------------------------
//V1.1 Adds correction of the FixedTop areas when the Header has limited width ( please review the code for correctness! )
//Margin adjustment needed for Fixed areas when header/footer are not Expanded
//Adjust Fixed areas margins for wrapper and header padding so they are properly aligned with the edges of the Site
//Without these negative margins, if there are paddings on the wrapper or the header, fixed top areas inside with be shifted
    $hdpadl = weaverx_getopt_default('header_padding_L', 0);
    $hdpadr = weaverx_getopt_default('header_padding_R', 0);
    $wrpadl = weaverx_getopt_default('wrapper_padding_L', 0);
    $wrpadr = weaverx_getopt_default('wrapper_padding_R', 0);

    $allpadl = $hdpadl + $wrpadl;
    $allpadr = $hdpadr + $wrpadr;
//Adding the unit and sign in a different variable as limited width calculations need the one without sign and unit
    $allpadl_x = -$allpadl . 'px';    //Default values if no header width reduction
    $allpadr_x = -$allpadr . 'px';    //Default values if no header width reduction

//limited header calculations
//These are only for when browser is wider than sitewidth. Below that, they are left:0 positionned with existing rules
    $align = weaverx_getopt_default('header_align', 'left');
    $width = weaverx_getopt_default('header_width_int', 100);
    $max_width = weaverx_getopt_default('header_max_width_int', 0);
    $reduct = ($themew - ($width / 100) * ($themew - $wrpadl - $wrpadr)) . 'px';  // This is the width reduction when browser is larger than sitewidth

//!! We cant support both a width% and max-width at the same time, it would be way too complicated.
// Depending which one of if( $width ) or if( $max_width ) is last below, it will be the winning one ( revert order between if( $width ) and if( $max_width ) )
    switch ($align) {
        case 'center':                // Centered case
            if ($width) {
                $allpadl_x = "calc( 0px - {$hdpadl}px - {$reduct} / 2 )";
                $allpadr_x = "calc( 0px - {$hdpadr}px - {$reduct} / 2 )";
            } elseif ($max_width) {
                $allpadl_x = -$allpadl - ($themew - $wrpadl - $wrpadr - $max_width) / 2 . 'px';
                $allpadr_x = -$allpadr - ($themew - $wrpadl - $wrpadr - $max_width) / 2 . 'px';
            }
            break;

        case 'float-right':            // Aligned right case
            if ($width) {
                $allpadl_x = "calc( {$wrpadl}px - {$hdpadl}px - {$reduct} )";
            } elseif ($max_width) {
                $allpadl_x = -$allpadl - ($themew - $wrpadl - $wrpadr - $max_width) . 'px';
            }
            break;

        default:                    // Aligned left case
            if ($width) {
                $allpadr_x = "calc( {$wrpadr}px - {$hdpadr}px - {$reduct} )";
            } elseif ($max_width) {
                $allpadr_x = -$allpadr - ($themew - $wrpadl - $wrpadr - $max_width) . 'px';
            }
            break;
    }

// Rules for TOP Fixed Areas
    // check for 'expand_header' removed V5
    weaverx_cat_css("@media ( min-width:{$themew}px) {
			#inject_fixedtop {margin-left:-{$wrpadl}px;margin-right:-{$wrpadr}px}
			.wvrx-fixedtop,.wvrx-fixonscroll{margin-left:{$allpadl_x};margin-right:{$allpadr_x}}
			}\n");

// Rules for BOTTOM Fixed areas
    // check for 'expand_footer' removed V5
    weaverx_cat_css("@media ( min-width:{$themew}px) {
			#inject_fixedbottom {margin-left:-{$wrpadl}px;margin-right:-{$wrpadr}px}
			}\n");

//------------------ End of Fixed Top Positioning rules ----------------------

// ================================ END RULES ===================================
// These rules need to be at the end

//  GRID MENUS ----------------
    foreach ($menus as $id => $tag) {
        if (weaverx_getopt("{$id}_sub_rounded")) {
            weaverx_cat_css('@media ( min-width:768px) { ');
            // 3 kinds of rounding: whole box + hover, top sub-item, bottom sub-item
            $round_sub = str_replace('8', $r, "{border-radius:8px;z-index:2001;");
            $menu = "{$tag} ul.sub-menu, {$tag} ul.children";
            $mega = "{$tag} ul.mega-menu li";

            $pad = ( int )($r - ($r * .25));    // pad it to avoid anchor bg from overwriting rounding
            $bg = weaverx_getopt("{$id}_sub_bgcolor");
            if ($bg == '') {
                $bg = 'transparent';
            }

            $round_end = "padding-top:{$pad}px;padding-bottom:{$pad}px;background-color:{$bg};}";
            weaverx_cat_css($menu . $round_sub . $round_end);
            weaverx_cat_css($mega . $round_sub . "} }\n");
        }
    }

    $add_word_wrap = false;
    foreach ($menus as $id => $tag) {       // Grid Menus
        if (!weaverx_cz_is_plus('6.1')) {
            break;
        }
        if ($id == 'm_extra') {
            continue;           // skip extra menuu
        }
        // 'm_primary_grid_submenu', 'm_primary_grid_cols', 'm_primary_grid_gap' + secondary

        // justify-items: start | end | center | stretch;

        $menu_grid_width = weaverx_getopt($id . '_grid_submenu');

        if ($menu_grid_width != '') {     // add CSS for grid layout

            if (weaverx_getopt("{$id}_sub_border")) {
                $g_border = "{$b_w}px $b_s $b_c";
            } else {
                $g_border = "none";
            }

            $width = (int)$menu_grid_width;        // will be 100, 92, 84, or 76 for full, wide, medium, narrow
            weaverx_cat_css(
                sprintf("/* grid menu styling for $tag */
                .is-menu-desktop $tag ul.sub-menu {
                    background-color:%s;
                    border:$g_border;
                    display:grid;
                    grid-template-columns:repeat(%s, 1fr);
                    grid-gap:%spx;
                    justify-items:%s;
                    margin-left: calc(50%% - %dvw) !important;
                    margin-right: calc(50%% - %dvw) !important;
                    margin-top:%spx !important;
                    padding-bottom:%spx;
                    padding-left: %svw !important;
                    padding-right: %svw !important;
                    padding-top:%spx;
                    max-width: 10000px !important;
                    width: %dvw !important; }",
                    weaverx_getopt_default("{$id}_sub_bgcolor", 'transparent'), // background color
                    weaverx_getopt_default("{$id}_grid_cols", '8'),     // grid columns
                    weaverx_getopt_default("{$id}_grid_gap", '4'),  //grid-gap
                    weaverx_getopt_default("{$id}_grid_align", 'center'),   // justify-items
                    $width / 2, // margin left
                    $width / 2, // margin right
                    weaverx_getopt_default("{$id}_grid_top_margin", '10'),  // margin top
                    weaverx_getopt_default("{$id}_grid_tb_padding", '10'),    // padding bottom
                    weaverx_getopt_default("{$id}_grid_lr_padding", '5'),    // padding left vw
                    weaverx_getopt_default("{$id}_grid_lr_padding", '5'),    // padding right vw
                    weaverx_getopt_default("{$id}_grid_tb_padding", '10'), // padding top
                    $width
                )
            );
            // break on whitespace for long menu items, unset position so the previous css works
            weaverx_cat_css(
                ".is-menu-desktop $tag .wvrx-menu ul li a,
                .is-menu-desktop $tag .wvrx-menu ul.mega-menu li a {white-space: break-spaces !important;}
                .is-menu-desktop $tag ul.sm li {position:unset;}
                .is-menu-desktop $tag ul.sm {position:unset;}"
            );
        }
    } // end grid menus
//  GRID MENUS ----------------

    if (weaverx_getopt('_print_show_widgets')) {
        weaverx_cat_css("@media print { /* print widget areas */
.widget-area{border:1px solid black !important;display:block !important; margin:.5em auto .75em auto !important;padding:.5em !important;width:98%!important;}
#colophon{border:1px solid black !important;display:block !important;margin:1em !important;padding:.5em !important;width:100% !important;}
.widget{margin-bottom:.75em !important;}
#primary-widget-area,#secondary-widget-area{float:left !important;width:48% !important;margin-left:2% !important;}
#footer-widget-area.widget-area{width:100% !important;margin:0 !important;}}\n");
    }

    if (weaverx_getopt('reset_content_opts')) {
        weaverx_cat_css(".has-posts #content {border:none; box-shadow: none;background:transparent;padding:0;margin-top:0;margin-bottom:0;}\n");
    }


// ================================ PRO AREAS ===================================

    do_action('weaverxplus_css', 'cat_css');

// need to handle inline code generation a bit differently for the customizer. In normal mode, we put all the generated
// CSS in one <style> block. For the customizer, we put the plus and global css in separate named ( id ) style blocks
// so the customizer javascript can directly manipulate those in the DOM.

    if (is_customize_preview()) { // wrap these guys in ids so can more easily manipulate the DOM
        if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* <!-- CSS+ RULES --> */");
        weaverx_cat_css($wvrx_css_plus);
        if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* <!-- CSS+ RULES END --> */\n");

        $add_css = weaverx_getopt('add_css');
        if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* <!-- ******* Global CSS Rules --> */\n");
        weaverx_cat_css(apply_filters('weaverx_css', $add_css));


    } else {    // standard site - only output CSS if really there
        if ($wvrx_css_plus != '') {
            if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* <!-- CSS+ RULES --> */\n");
            weaverx_cat_css($wvrx_css_plus);
            if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* <!--CSS+ RULES END --> */\n");    // need this comment for Customizer to work
        }

        $add_css = weaverx_getopt('add_css');
        if (!empty($add_css)) {
            if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* ******* Global CSS Rules */\n");
            weaverx_cat_css(apply_filters('weaverx_css', $add_css));
        }
    }

    if (WEAVERX_MINIFY == '') weaverx_cat_css("\n/* End Weaver Xtreme CSS */\n");


} // end weaverx_output_style
//-----------------------------------------------------------------------------------------


// ************************************ SUPPORT FUNCTIONS **************************


function weaverx_cat_css($css): void
{
    $GLOBALS['weaverx_gen_css'] .= $css;
}

// function weaverx_css_style( $name, $style ): removed V5.0

/** @noinspection PhpFormatFunctionParametersMismatchInspection */
function weaverx_css_style_val($name, $style, $opt): void
{
    /* output a css rule style with one value ( include {}'s in style ) */
    $val = weaverx_getopt($opt);
    /** @noinspection PhpConditionAlreadyCheckedInspection */
    if ($val == '' || $val === false || !$style || !$name) {
        return;
    }
    weaverx_cat_css(sprintf("$name $style\n", $val));
}

//--


function weaverx_fix_braces($val): string
{
    $fix = str_replace('{', '', $val);
    $fix = str_replace('}', '', $fix);

    return '{' . $fix . '}';
}

//--


function weaverx_sidebar_style($override = 0): void
{
    // allow per page sidebar width overrides
    // @@@@ dev: is override ever used?

    $smart = weaverx_getopt_default('smart_margin_int', 1);
    if ($smart > 25) {
        $smart = 1;
    }  // some sanity check

    if (!$override) {
        $l_sb_w = weaverx_getopt_default('left_sb_width_int', '25');
        $r_sb_w = weaverx_getopt_default('right_sb_width_int', '25');
        $ls_sb_w = weaverx_getopt_default('left_split_sb_width_int', '25');
        $rs_sb_w = weaverx_getopt_default('right_split_sb_width_int', '25');
    } else {
        $l_sb_w = $override;        // using per page override - forces symmetrical split, but that's better than nothing
        $r_sb_w = $override;
        $ls_sb_w = $override;
        $rs_sb_w = $override;
    }

    // emit code for .is-desktop to resize widget areas ( need .is-desktop to make IE8 work on free or in-line CSS )

    // Version 2.0.10 change: Because of significant degradation of desktop refresh using .is-desktop for these rules,
    // they are now wrapped with the @media for desktops. This means that full support for non-default ( non-25% ) sidebars
    // on the desktop is no longer supportd for IE8. Instead, we allow IE8 to gracefully degrade to only showing default widths.
    // All the rules between the @media }{} formerly had .is-desktop leading each rule. These have been removed.

    weaverx_cat_css("@media screen and ( min-width:768px) {\n"); // .is-desktop
    if ($r_sb_w != 25 || $smart != 1 || $override) {      // changed right sidebar width ( or smart width )
        $cw = 100 - $r_sb_w;
        $cw_m = $cw - $smart;
        $r_sb_m = $r_sb_w - $smart;
        weaverx_cat_css(sprintf(".l-content-rsb{width:%.5f%%;}.l-content-rsb-m{width:%.5f%%;margin-right:%.5f%%;}
.l-sb-right{width:%.5f%%;}.l-sb-right-lm{width:%.5f%%;margin-left:%.5f%%;}.l-sb-right-rm {width:%.5f%%;margin-right:%.5f%%;}\n",
            $cw, $cw_m, $smart, $r_sb_w, $r_sb_m, $smart, $r_sb_m, $smart));

    }

    if ($l_sb_w != 25 || $smart != 1 || $override) {      // changed left sidebar width
        $cw = 100 - $l_sb_w;
        $cw_m = $cw - $smart;
        $l_sb_m = $l_sb_w - $smart;
        weaverx_cat_css(sprintf(".l-content-lsb{width:%.5f%%;}.l-content-lsb-m{width:%.5f%%;margin-left:%.5f%%;}
.l-sb-left{width:%.5f%%;}.l-sb-left-lm{width:%.5f%%;margin-left:%.5f%%;}.l-sb-left-rm {width:%.5f%%;margin-right:%.5f%%;}\n",
            $cw, $cw_m, $smart, $l_sb_w, $l_sb_m, $smart, $l_sb_m, $smart));

    }

    if ($ls_sb_w != 25 || $rs_sb_w != 25 || $smart != 1 || $override) {     // changed a split width
        $cw = 100 - $ls_sb_w - $rs_sb_w;
        $lsb_margin = $cw + $rs_sb_w;
        $cw_l_m = $ls_sb_w + $smart;
        $cw_m = $cw - $smart - $smart;
        $l_m = $ls_sb_w - $smart;
        $r_m = $rs_sb_w - $smart;

        weaverx_cat_css(
            sprintf(".l-sb-right-split{width:%.5f%%}\n", $rs_sb_w) .
            sprintf(".l-sb-right-split-lm{width:%.5f%%;margin-left:%.5f%%;}\n", $rs_sb_w - $smart, $smart) .
            sprintf(".l-content-ssb{width:%.5f%%;margin-left:%.5f%%;}\n", $cw, $ls_sb_w) .
            sprintf(".l-content-ssb-m{width:%.5f%%;margin-left:%.5f%%;margin-right:%.5f%%;}\n", $cw - $smart - $smart, $ls_sb_w + $smart, $smart) .
            sprintf(".l-content-ssbs{width:%.5f%%;}\n", $cw) .
            sprintf(".l-content-ssbs-m{width:%.5f%%;margin-left:%.5f%%;margin-right:%.5f%%;}\n", $cw - $smart - $smart, $smart, $smart) .
            sprintf(".l-sb-left-split{margin-left:-%.5f%%;width:%.5f%%}\n", 100 - $rs_sb_w, $ls_sb_w) .
            sprintf(".l-sb-left-split-top{width:%.5f%%}\n", $ls_sb_w) .
            sprintf(".l-sb-left-split-rm{margin-left:-%.5f%%;width:%.5f%%}\n", 100 - $rs_sb_w, $ls_sb_w - $smart) .
            sprintf(".l-sb-left-split-top-rm {margin-right:%.5f%%;width:%.5f%%;}\n", $smart, $ls_sb_w - $smart));
    }
    weaverx_cat_css("}\n");


    if (!$override) {
        $sb_horizontal_areas = array(
            'top' => '.widget-area-top',
            'bottom' => '.widget-area-bottom',
            'container' => '#container',
            'footer' => '#colophon',
            'footer_html' => '#footer-html',
            'footer_sb' => '#footer-widget-area',
            'alt:footer_sb' => '.widget-area-footer',
            'header' => '#header',
            'header_html' => '#header-html',
            'header_sb' => '#header-widget-area',
            'alt:header_sb' => '.widget-area-header',
            'infobar' => '#infobar',
        );

        foreach ($sb_horizontal_areas as $id => $tag) {     // horizontal area widths
            $id = str_replace('alt:', '', $id);
            if (!weaverx_align_wf($id)) {
                $w = weaverx_getopt($id . '_width_int');
                $ltag = str_replace('.', '.l-', $tag);
                if ($w === 0 || $w === '0')    // detects 0 rather than false
                {
                    weaverx_cat_css("{$ltag}{width:auto;}\n");
                } // changed to 100%: version 2.0.10
                elseif ($w > 0) {
                    weaverx_cat_css("{$ltag}{width:{$w}%;}@media (max-width: 580px) {{$ltag}{width:100%}}\n"); // .is-phone
                } // changed to 100%: version 2.0.10
            }

        }
    }

}

//--


function weaverx_put_link($id, $a, $ahover): void
{
    weaverx_put_color($id . '_color', $a);
    weaverx_put_color($id . '_hover_color', $ahover);

    weaverx_put_rule_if_checked($id . '_u', $a . '{text-decoration:underline;}');        // link

    $hover_ul = weaverx_getopt($id . '_u_h');        // hover underline?
    if ($hover_ul) {
        weaverx_cat_css("{$ahover}{text-decoration:underline;}\n");
        if ($id == 'link') {
            weaverx_cat_css(".wvrx-menu-container a:hover, #nav-header-mini a:hover{text-decoration:none;}\n");
        }
    }

    $val = weaverx_getopt($id . '_em');
    if ($val == 'on') {
        weaverx_cat_css("{$a}{font-style:italic;}\n");
    } elseif ($val == 'off') {
        weaverx_cat_css("{$a}{font-style:normal;}\n");
    }

    $val = weaverx_getopt($id . '_strong');
    if ($val == 'on') {
        weaverx_cat_css("{$a}{font-weight:bold;}\n");
    } elseif ($val == 'off') {
        weaverx_cat_css("{$a}{font-weight:normal;}\n");
    }
}

//--


function weaverx_put_bgcolor($opt, $tag, $important = false): void
{
    // put bgcolor and CSS+

    $imp = ($important) ? ' !important' : '';

    if (($color = weaverx_getopt($opt)) && $color != 'inherit') {

        weaverx_cat_css(sprintf("$tag {background-color:{$color}{$imp};}\n"));
    }
    weaverx_put_css_plus($opt, $tag);
}

//--

function weaverx_align_wf($id): bool
{
    // true if area align is full or wide
    $align = weaverx_getopt($id . '_align');

    return $align == 'alignfull' || $align == 'alignwide';
}

//--


function weaverx_put_color($id, $tag, $important = false): void
{
    // put color and CSS+

    if (($color = weaverx_getopt($id)) && $color != 'inherit') {
        if ($important) {
            weaverx_cat_css(sprintf("$tag {color:$color !important;}\n"));
        } else {
            weaverx_cat_css(sprintf("$tag {color:$color;}\n"));
        }
    }

    weaverx_put_css_plus($id, $tag);
}


function weaverx_put_css_plus($id, $tag): void
{

    if (($style = weaverx_getopt($id . '_css'))) {
        global $wvrx_css_plus;
        $prefix = '';
        $suffix = '';

        if (is_customize_preview()) {    // Generate a rule that can be easily modified in the DOM
            $prefix = "/*-=:{$id}_css:=-*/";
            $suffix = "/*-:{$id}_css:-*/";
        }

        if (strpos($style, '%selector') !== false) {     // user is using $selectors
            $tags = explode(',', $tag);
            foreach ($tags as $selector) {
                $replaced = str_replace('%selector%', trim($selector), $style);
                $wvrx_css_plus .= apply_filters('weaverx_css', sprintf("%s%s %s%s\n", $prefix, $selector, $replaced, $suffix));
            }
        } else {
            $wvrx_css_plus .= apply_filters('weaverx_css', sprintf("%s%s %s%s\n", $prefix, $tag, $style, $suffix));
        }
    }
}


function weaverx_put_rule_if_checked($id, $rule): void
{
    // put just a rule if checked

    if (weaverx_getopt_checked($id)) {
        weaverx_cat_css($rule . "\n");
    }
}


function weaverx_put_rule_if_not_checked($id, $rule): void
{     // notused ?
    // put just a rule if not checked

    if (!weaverx_getopt_checked($id)) {
        weaverx_cat_css($rule . "\n");
    }
}

function weaverx_put_elementor_colors(): void
{
    /* generate CSS to override Elementor styling */

    $color_1 = weaverx_getopt('elementor_primary_color');
    $color_2 = weaverx_getopt('elementor_secondary_color');

    $color_3 = weaverx_getopt('elementor_text_color');
    $color_4 = weaverx_getopt('elementor_accent_color');


    /* PRIMARY COLOR */
    if ($color_1) {
        weaverx_cat_css(
            "/*PRIMARY*/.elementor-widget-heading .elementor-heading-title{color:{$color_1};}
.elementor-widget-text-editor.elementor-drop-cap-view-stacked .elementor-drop-cap{background-color:{$color_1};}
.elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap, .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap{color:{$color_1};border-color:{$color_1};}
.elementor-widget-image-box .elementor-image-box-content .elementor-image-box-title{color:{$color_1};}
.elementor-widget-icon.elementor-view-stacked .elementor-icon{background-color:{$color_1};}
.elementor-widget-icon.elementor-view-framed .elementor-icon, .elementor-widget-icon.elementor-view-default .elementor-icon{color:{$color_1};border-color:{$color_1};}
.elementor-widget-icon-box.elementor-view-stacked .elementor-icon{background-color:{$color_1};}
.elementor-widget-icon-box.elementor-view-framed .elementor-icon, .elementor-widget-icon-box.elementor-view-default .elementor-icon{color:{$color_1};border-color:{$color_1};}
.elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-title{color:{$color_1};}
.elementor-widget-icon-list .elementor-icon-list-icon i{color:{$color_1};}
.elementor-widget-counter .elementor-counter-number-wrapper{color:{$color_1};}
.elementor-widget-progress .elementor-progress-wrapper .elementor-progress-bar{background-color:{$color_1};}
.elementor-widget-progress .elementor-title{color:{$color_1};}
.elementor-widget-testimonial .elementor-testimonial-name{color:{$color_1};}
.elementor-widget-tabs .elementor-tab-title{color:{$color_1};}
.elementor-widget-accordion .elementor-accordion .elementor-tab-title{color:{$color_1};}
.elementor-widget-toggle .elementor-toggle .elementor-tab-title{color:{$color_1};}
");
    }


    /* SECONDARY COLOR */
    if ($color_2) {
        weaverx_cat_css(
            "/*SECONDARY*/.elementor-widget-icon-list .elementor-icon-list-text{color:{$color_2};}
.elementor-widget-counter .elementor-counter-title{color:{$color_2};}
.elementor-widget-testimonial .elementor-testimonial-job{color:{$color_2};}
");
    }


    /* TEXT COLOR */
    if ($color_3) {
        weaverx_cat_css(
            "/*TEXT*/.elementor-widget-image .widget-image-caption{color:{$color_3};}
.elementor-widget-text-editor{color:{$color_3};}
.elementor-widget-divider .elementor-divider-separator{border-top-color:{$color_3};}
.elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description{color:{$color_3};}
.elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-description{color:{$color_3};}
.elementor-widget-icon-list .elementor-icon-list-item:not( :last-child ):after{border-top-color:{$color_3};}
.elementor-widget-testimonial .elementor-testimonial-content{color:{$color_3};}
.elementor-widget-tabs .elementor-tab-content{color:{$color_3};}
.elementor-widget-accordion .elementor-accordion .elementor-tab-content{color:{$color_3};}
.elementor-widget-toggle .elementor-toggle .elementor-tab-content{color:{$color_3};}
");
    }

    /* ACCENT COLOR */
    if ($color_4) {
        weaverx_cat_css(
            "/*ACCENT*/.elementor-widget-button a.elementor-button, .elementor-widget-button .elementor-button{background-color:{$color_4};}
.elementor-widget-tabs .elementor-tab-title.elementor-active{color:{$color_4};}
.elementor-widget-accordion .elementor-accordion .elementor-tab-title.elementor-active{color:{$color_4};}
.elementor-widget-toggle .elementor-toggle .elementor-tab-title.elementor-active{color:{$color_4};}
");
    }
}
