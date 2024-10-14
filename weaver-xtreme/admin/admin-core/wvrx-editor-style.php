<?php
/** PHP 7.4 features added */

// ======================================= EDITOR CSS  GENERATION ================================

/**
 *    Generate Block Editor and Classic Editor Styles based on options
 *
 *    The Classic Editor only supports CSS styles from a file, so it requires that a file be generated,
 *    which means the theme support editor is required, so only default styling shown if no theme support.
 *
 *    Gutenberg supports inline styles, so weaverx_get_block_editor_style() simply needs to return a style.
 */


function weaverx_save_classic_editor_css(): void
{
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    // Attempt to save Classic Editor generated CSS. This requires the Weaver Xtreme Theme Support plugin (because Themes can't write files.)

        weaverx_write_to_upload('classic-editor-style-wvrx.css', weaverx_get_mce_style());
 }


function weaverx_get_mce_style(): string
{
    /* Because of the internal manipulation of classes by the block editor, some styles need to be included
    * with the initial editor style load ( using add_editor_style() ). Include those styles here.
    *
    */

    $put = sprintf("/* This CSS for MCE editor generated using %s %s subtheme: %s */\n", WEAVERX_THEMENAME, WEAVERX_VERSION, weaverx_getopt('themename'));

    /**  THEME WIDTHS ====================================================================== */

    if (($twidth = weaverx_getopt_default('theme_width_int', WEAVERX_THEME_WIDTH)) && $twidth != WEAVERX_THEME_WIDTH) {
        /*  figure out a good width - we will please most of the users, most of the time
            We're going to assume that mostly people will use the default layout -
            we can't actually tell if the editor will be for a page or a post at this point.
            And let's just assume the default sidebar widths.
        */
        //  calculate theme width based on default layout and width of sidebars for mce legacy editor.

        $sb_layout = weaverx_getopt_default('layout_default', 'right');
        switch ($sb_layout) {
            case 'left':
            case 'left-top':
                $sb_width = weaverx_getopt_default('left_sb_width_int', 25);
                break;
            case 'split':
            case 'split-top':
                $sb_width = weaverx_getopt_default('left_split_sb_width_int', 25)
                    . weaverx_getopt_default('right_split_sb_width_int', 25);
                break;
            case 'one-column':
                $sb_width = 0;
                break;
            default:            // right
                $sb_width = weaverx_getopt_default('right_sb_width_int', 25);
                break;
        }

        $content_w = $twidth - ($twidth * ( float )($sb_width / 95.0));   // .95 by trial and error

        $put .= "html .mce-content-body{max-width:96%;width:" . $content_w . "px;}\n";
        $put .= "#content html .mce-content-body {max-width:96%;width:96%;}\n";

        // For the Block Editor,won't handle sidebars - just show full/wide styling
        $twidth_wide = $twidth + 200;        // work around for Gutenberg's wide formatting in the editor.
        $put .= ".wp-block{max-width:{$twidth}px;}";
        $put .= '.wp-block[data-align="wide"] {max-width: calc( ' . $twidth_wide . 'px + 15% );}';
    }


    /** FONT FAMILIES ====================================================================== */

    // ==== body fonts ==== The font for the general content area. These are NOT specialized to pages vs. posts.

    $body_font_family = weaverx_get_cascade_opt('_font_family', 'inherit');

    $body_selector = 'body, body figcaption,body#tinymce.wp-editor, body#tinymce.wp-editor figcaption,.mce-content-body, .mce-content-body figcaption';

    $put .= weaverx_put_font_family($body_font_family, $body_selector, ' !important');

    // ==== Headings ( h ) Font Family needs more specialized selectors

    $hdr_font_family = weaverx_getopt_default('content_h_font_family', 'inherit');
    if ($hdr_font_family == 'inherit') {
        $hdr_font_family = $body_font_family;
    }

    $mce_h_sel = ".mce-content-body h1,.mce-content-body h2,.mce-content-body h3,.mce-content-body h4,.mce-content-body h5,.mce-content-body h6";

    $put .= weaverx_put_font_family($hdr_font_family, $mce_h_sel, ' !important');    // and classic editor

    // headings italic/bold
    $h_style = weaverx_getopt_default('content_h_italic','off');
    if ($h_style == 'on') {
        $put .= "{$mce_h_sel}{font-style:italic;}\n";
    }
    $h_style = weaverx_getopt_default('content_h_bold','off');
    if ($h_style == 'on') {
        $put .= "{$mce_h_sel}{font-style:bold;}\n";
    }

    // body italic/bold
    $font_style = weaverx_get_cascade_opt('_italic', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'italic' : 'normal';
        $put .= "{$body_selector}{font-style:{$italic};}\n";
    }

    $font_style = weaverx_get_cascade_opt('_bold', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'bold' : 'normal';
        $put .= "{$body_selector}{font-weight:{$italic};}\n";
    }

    /** bg color =================================== */
    $bg = '';
    if (($val = weaverx_getopt_default('editor_bgcolor', 'inherit')) && $val != 'inherit') {           /* alt bg color */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('content_bgcolor', 'inherit')) && $val != 'inherit') {    /* #content */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('container_bgcolor', 'inherit')) && $val != 'inherit') { /* #container */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('wrapper_bgcolor', 'inherit')) && $val != 'inherit') {    /* #wrapper */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('body_bgcolor', 'inherit')) && $val != 'inherit') {    /* Outside BG */
        $bg = $val;
    }
    if ($bg != 'inherit') {
        $put .= "{$body_selector}{background-color:" . $bg . " !important;}\n";
    }

    // add italic/bold for overall
    $font_style = weaverx_get_cascade_opt('_italic', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'italic' : 'normal';
        $put .= "{$body_selector}{font-style:{$italic};}\n";
    }

    $font_style = weaverx_get_cascade_opt('_bold', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'bold' : 'normal';
        $put .= "{$body_selector}{font-weight:{$italic};}\n";
    }

    /** TEXT COLOR ====================================================================== */

    $text_color = weaverx_get_cascade_opt('_color', 'inherit');        // text color for code

    if ($text_color != 'inherit') {
        $put .= "{$body_selector}{color:" . $text_color . " !important;}\n";
    }


    /** HEADINGS COLORS ========== **/

    $color = weaverx_getopt_default('content_h_color', 'inherit');
    if ($color != 'inherit') {
        $put .= "{$mce_h_sel}{color: {$color};}\n";
    }

    /**  <hr> COLOR =================================================================== **/

    if (($color = weaverx_getopt('hr_color')) && $color != 'inherit') {
        $put .= "hr,hr.wp-block-separator{background-color:{$color};}\n";
    }
    if (($css = weaverx_getopt('hr_color_css'))) {
        $put .= "hr,hr.wp-block-separator{$css}\n";
    }

    $bgcolor = weaverx_getopt_default('content_h_bgcolor', 'inherit');
    if ($bgcolor != 'inherit') {
        $put .= "{$mce_h_sel}{background-color: {$bgcolor};}\n";
    }

    $css = weaverx_getopt('content_h_bgcolor_css');
    if ($css) {
        $put .= "{$mce_h_sel}{$css}\n";
    }

    return weaverx_minify_css(apply_filters('weaverx_early_editor_style', $put));
} //# early style


function weaverx_get_block_editor_style()
{
    // This dynamically generates Block Editor Styling


    $put = sprintf("/* This CSS for Block Editor generated using %s %s subtheme: %s */\n", WEAVERX_THEMENAME, WEAVERX_VERSION, weaverx_getopt('themename'));

    $content_body = '.mce-content-body ';
    $selector_tr = ".mce-content-body,.mce-content-body *[class^='wp-block-'],.mce-content-body p,.mce-content-body tr,.mce-content-body td,.mce-content-body label,.mce-content-body th,.mce-content-body thead th ";
    $selector_font = $selector_tr . ',.editor-block-list__block:not( .is-multi-selected ) .wp-block-paragraph,.edit-post-visual-editor,.edit-post-visual-editor p,.edit-post-layout .editor-post-title textarea,.editor-styles-wrapper .block-editor-block-list__layout';
    $selector_bg = '.editor-styles-wrapper';
    //$selector_bg = '.editor-styles-wrapper, .editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper';

    // ** default FONT FAMILY **/

    $body_font_family = weaverx_get_cascade_opt('_font_family', 'inherit');   // "body" font for editor

    $body_selector = 'body#tinymce.wp-editor,.mce-content-body';

    //$put .= weaverx_put_font_family($body_font_family, $body_selector);

    //$put .= weaverx_put_font_family($body_font_family, $selector_bg); // and duplicate default for page/post
    $put .= weaverx_put_font_family($body_font_family, $selector_bg);
    // ** FONT SIZE **

    if (($base_font_px = weaverx_getopt('site_fontsize_int')) == '') {
        $base_font_px = 16;
    }
    if ($base_font_px != 16) {
        $put .= "body{font-size:{$base_font_px}px;}";
    }

    // Changed for V5 to work properly with block editor over classic editor
    $put .= "{$selector_font}{font-size:" . $base_font_px . "px;}\n";


    // ** FONT STYLE / WEIGHT **
    // valusew will be 'on' or 'off' or '', unless checkbox
    // wrapper_bold, wrapper_italic, container_bold, container_italic, content_bold, content_italic, page_title_italic, page_title_normal ( weight - checkbox )
    // content_h_italic, content_h_normal ( weight, checkbox )

    $font_style = weaverx_get_cascade_opt('_italic', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'italic' : 'normal';
        $put .= "{$selector_font}{font-style:{$italic};}\n";
    }

    $font_style = weaverx_get_cascade_opt('_bold', '');
    if ($font_style != '') {
        $italic = ($font_style == 'on') ? 'bold' : 'normal';
        $put .= "{$selector_font}{font-weight:{$italic};}\n";
    }


    // ====== BG/fg COLOR ====

    /* need to handle bg color of content area - need to do the cascade */

    $bg = '';
    $fg = '';
    if (($val = weaverx_getopt_default('editor_bgcolor', 'inherit')) && $val != 'inherit') {           /* alt bg color */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('content_bgcolor', 'inherit')) && $val != 'inherit') {    /* #content */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('container_bgcolor', 'inherit')) && $val != 'inherit') { /* #container */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('wrapper_bgcolor', 'inherit')) && $val != 'inherit') {    /* #wrapper */
        $bg = $val;
    } elseif (($val = weaverx_getopt_default('body_bgcolor', 'inherit')) && $val != 'inherit') {    /* Outside BG */
        $bg = $val;
    }

    if (($val = weaverx_getopt_default('content_color', 'inherit')) && $val != 'inherit') {    /* #content */
        $fg = $val;
    } elseif (($val = weaverx_getopt_default('container_color', 'inherit')) && $val != 'inherit') { /* #container */
        $fg = $val;
    } elseif (($val = weaverx_getopt_default('wrapper_color', 'inherit')) && $val != 'inherit') {    /* #wrapper */
        $fg = $val;
    } elseif (($val = weaverx_getopt_default('body_color', 'inherit')) && $val != 'inherit') {    /* Outside BG */
        $fg = $val;
    }

    if ($bg != '') {
        $put .= "{$selector_bg}{background:{$bg} !important}\n";
    }

    if ($fg != '') {
        $put .= "{$selector_bg}{color:{$fg} !important}\n";
    }


    // ==== text color ====

    /* ================================== Heading Styling ==============================
     *
     * Generate all the styling for content headings h1-h6
     *
     */

    // ---- bold

    $h_sel = "h1.wp-block-heading,h2.wp-block-heading,h3.wp-block-heading,h4.wp-block-heading,h5.wp-block-heading,h6.wp-block-heading";

    if (weaverx_getopt_checked('content_h_normal'))        // bold off?
    {
        $put .= "$h_sel{font-weight:normal !important;}\n";
    }

    // ---- italic

    $italic = weaverx_getopt_default('content_h_italic', 'off');
    if ($italic == 'off') {
        //$put .= "$h_sel{font-style:normal;}\n";
    } elseif ($italic == 'on') {
       // $put .= "$h_sel{font-style:italic;}\n";
    }

    // ====== PAGE/POST h1-h6 ========

    // content header font
    $hdr_font_family = weaverx_getopt_default('content_h_font_family', 'inherit');

    if ($hdr_font_family != 'inherit') {
        $put .= weaverx_put_font_family($hdr_font_family, $h_sel, ' !important');    // and classic editor
    }

    $hdr_bold = weaverx_getopt_default('content_h_bold', 'off');
    if ($hdr_bold == 'on') {
        $put .= $h_sel . "{font-weight: bold;}";
    }

    $hdr_italic = weaverx_getopt_default('content_h_italic', 'off');
    if ($hdr_italic == 'on') {
        $put .= $h_sel . "{font-style: italic;}";
    }


    /** TEXT COLOR ====================================================================== */

    $text_color = weaverx_get_cascade_opt('_color', 'inherit');        // text color for code

    if ($text_color != 'inherit') {
        $put .= "{$h_sel}{text-color:" . $text_color . " !important;}\n";
    }

    /** HEADINGS COLORS ========== **/

    $color = weaverx_getopt_default('content_h_color', 'inherit');
    if ($color != 'inherit') {
        $put .= "{$h_sel}{color: $color; }\n";
    }

    $color = weaverx_getopt_default('content_h_bgcolor', 'inherit');
    if ($color != 'inherit') {
        $put .= "{$h_sel}{background: {$color};}\n";
    }

    /* ^^^^^^^^^^^^^^^^^^^^^^^^ END Heading Styling ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
     *
     * Generate all the styling for content headings h1-h6
     *
     */

    // ====== PAGE TITLE ( Don't use post values ) ======

    // page_title_bgcolor, page_title_color, page_title_font_size, page_title_font_family, page_title_normal ( weight/checkbox ), page_title_italic


    // set font family for header title
    $selector_title = '.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper .editor-post-title';
    $font_style = '';
    $title_font_family = weaverx_getopt_default('page_title_font_family', 'inherit');
    if ($title_font_family != 'inherit') {
        $put .= weaverx_put_font_family($title_font_family, $selector_title); // use $put, not $font_style
    }

    $title_color = weaverx_getopt_default('page_title_color', 'inherit');
    if ($title_color == 'inherit') {
        $title_color = weaverx_get_cascade_opt('_color', 'inherit');
    }
    $font_style .= "color:{$title_color} !important;";


    $title_bgcolor = weaverx_getopt_default('page_title_bgcolor', 'inherit');
    if ($title_bgcolor != 'inherit') {
        $font_style .= "background-color:{$title_bgcolor} !important;";
    }


    $title_css = weaverx_getopt('page_title_bgcolor_css');
    if ($title_css) {
        $font_style .= $title_css;
    }

    $font_size = weaverx_getopt_default('page_title_font_size', 'xl-font-size-title');
    $em_fontmult = weaverx_fontsize_mult($font_size, 'title');
    $em_font_size = ($base_font_px / 16.0) * $em_fontmult;
    $font_style .= "font-size:" . $em_font_size . "em !important;"; //height:1.8em !important;";
    //$put .= ".edit-post-layout .editor-post-title textarea{font-size:" . $em_font_size . "em;}\n";

    if (weaverx_getopt_checked('page_title_normal')) {        // bold off?
        $font_style .= "font-weight:normal !important;";
    }

    $italic = weaverx_getopt('page_title_italic');
    if ($italic == 'off') {
        $font_style .= "font-style:normal !important;";
    } elseif ($italic == 'on') {
        $font_style .= "font-style:italic !important;";
    }

    // bar under some titles
    if (($val = ( int )weaverx_getopt('page_title_underline_int'))) {
        $font_style .= "text-decoration: underline !important;";  // not exact, but shows underline
    }
    $put .= $selector_title . '{' . $font_style . "}\n";


    // ====== OTHER ELEMENTS ======

    if (($val = weaverx_getopt('input_bgcolor'))) {    // input area
        $put .= "input, textarea, ins, pre{background:" . $val . ";}\n";
    }

    if (($val = weaverx_getopt('input_color'))) {
        $put .= "input, textarea, ins, del, pre {color:" . $val . ";}\n";
    }


    //  ====== TABLES ======

    /*  weaverx_tables   - not really critical for block editor */
    //$table = weaverx_getopt('weaverx_tables');


    // ====== LISTS ======

    if (($val = weaverx_getopt('contentlist_bullet'))) {    // list bullet
        if ($val != '' && $val != 'disc') {
            if ($val != 'custom') {
                $put .= "ul {list-style-type:{$val} !important;}\n";
                /*$put .= ".block-editor-block-breadcrumb ul {list-style-type:{$val} !important;}\n"; */
            }
        }
    }

    if (($val = weaverx_getopt('content_p_list_dec'))) {    // list/paragraph margin
        if ($val != '') {
            /* $put .= ".block-editor-editor-skeleton__content ul, .block-editor-editor-skeleton__content ol, .block-editor-editor-skeleton__content p {margin-bottom:{$val}em;}\n"; */
            $put .= "ul, ol, p {margin-bottom:{$val}em;}\n";
        }
    }

    if (($val = weaverx_getopt('content_block_margin_T'))) {    // block top
        if ($val != '') {
            $put .= "*[class^=\"wp-block-\"]{margin-top:{$val}em !important;}\n";
            $put .= ".wp-block-cover {margin-top:0 !important;}\n";
        }
    }

    if (($val = weaverx_getopt('content_block_margin_B'))) {    // block bottom
        if ($val != '') {
            $put .= "*[class^=\"wp-block-\"]{margin-bottom:{$val}em !important;}\n";
            $put .= ".wp-block-cover {margin-bottom:0 !important;}\n";
        }
    }

    // ====== images ======

    // these work for both tinyMCE and Gutenberg

    if (($val = weaverx_getopt('caption_color'))) {    // image caption, border color, width
        $put .= ".wp-caption p.wp-caption-text,.wp-caption-dd, figure.wp-block-image figcaption, .wp-block-gallery .blocks-gallery-image figcaption, .wp-block-gallery .blocks-gallery-item figcaption {color:{$val};}\n";
    }

    if (($val = weaverx_getopt('media_lib_border_color'))) {
        $put .= ".wp-caption, img {background:{$val};}\n";
    }
    if (($val = weaverx_getopt('media_lib_border_int'))) {
        $caplr = $val - 5;
        if ($caplr < 0) {
            $caplr = 0;
        }
        $put .= "img {padding:{$val}px;}\n";
        $put .= sprintf(".wp-caption {padding: %dpx %dpx %dpx %dpx;}\n", $val, $caplr, $val, $caplr);
    }
    if (weaverx_getopt_checked('show_img_shadows')) {
        $put .= 'img {box-shadow: 0 0 2px 1px rgba( 0,0,0,0.25 ) !important;}' . "\n";
    }


    // ====== <hr> ======

    if (($color = weaverx_getopt('hr_color')) && $color != 'inherit') {
        $put .= "hr,hr.wp-block-separator{background-color:{
		$color};}\n";
    }
    if (($css = weaverx_getopt('hr_color_css'))) {
        $put .= "hr,hr.wp-block-separator{$css}\n";
    }

    // ====== LINKS - link_color, link_strong, link_em, link_u, link_u_h, link_hover_color ======

    $link_color = weaverx_getopt_default('contentlink_color', 'inherit');
    if ($link_color == 'inherit') {
        $link_color = weaverx_getopt_default('link_color', 'inherit');
    }
    if ($link_color == 'inherit') {
        $link_color = '#0000FF';
    }

    $link_strong = weaverx_getopt_default('contentlink_strong', 'inherit');
    if ($link_strong == 'inherit') {
        $link_strong = weaverx_getopt_default('link_strong', 'inherit');
    }

    $link_em = weaverx_getopt_default('contentlink_em', 'inherit');
    if ($link_em == 'inherit') {
        $link_em = weaverx_getopt_default('link_em', 'inherit');
    }

    $link_u = weaverx_getopt('contentlink_u');
    if (!$link_u) {
        $link_u = weaverx_getopt('link_u');
    }

    $link_hover_color = weaverx_getopt_default('contentlink_hover_color', 'inherit');
    if ($link_hover_color == 'inherit') {
        $link_hover_color = weaverx_getopt_default('link_hover_color', 'inherit');
    }
    if ($link_hover_color == 'inherit') {
        $link_hover_color = '#FF0000';
    }

    $link_hover_u_h = weaverx_getopt('contentlink_u_h');
    if (!$link_hover_u_h) {
        $link_hover_u_h = weaverx_getopt('link_u_h');
    }

    // Todo: are these really used???
    $asel = ".editor-block-list__block:not( .is-multi-selected ) .wp-block-paragraph a,.editor-styles-wrapper a,.editor-styles-wrapper p a";

    $asel_h = ".mce-content-body a:hover,.mce-content-body *[class^='wp-block-'] a:hover,.mce-content-body p a:hover,
.editor-block-list__block:not( .is-multi-selected ) .wp-block-paragraph a:hover,.editor-styles-wrapper a:hover,.editor-styles-wrapper p a:hover";

    $put .= "{$asel}{";
    $put .= "color:{$link_color}!important;";

    $val = $link_strong;
    if ($val == 'on') {
        $put .= "font-weight:bold!important;";
    } elseif ($val == 'off' || $val == 'inherit') {
        $put .= "font-weight:normal!important;";
    }

    $val = $link_em;
    if ($val == 'on') {
        $put .= "font-style:italic;";
    } elseif ($val == 'off' || $val == 'inherit') {
        $put .= "font-style:normal!important;";
    }

    if ($link_u) {
        $put .= "text-decoration:underline!important;";
    }

    $put .= "}\n{$asel_h}{";

    $put .= "color:{$link_hover_color}!important;";

    if ($link_hover_u_h) {
        $put .= "text-decoration:underline!important;";
    }

    $put .= "}\n";

    return weaverx_minify_css(apply_filters('weaverx_editor_style', $put));

}

// ==================================================

/** generate general font styling */
function weaverx_put_font_family($font_family, $selector, $important = ''): string
{

    $put = '';

    if ($font_family != 'inherit') {        // found a font {
        // these are not translatable - the values are used to define the actual font definition

        $fonts = weaverx_get_font_list();

        if (isset($fonts[$font_family])) {
            $font = $fonts[$font_family];
        } else {
            $font = "'Open Sans', sans-serif";   // fallback
            // scan Google Fonts
            $gfonts = weaverx_getopt_array('fonts_added');
            if (!empty($gfonts)) {
                foreach ($gfonts as $gfont) {
                    $slug = sanitize_title($gfont['name']);
                    if ($slug == $font_family) {
                        $font = str_replace('font-family:', '', $gfont['family']);
                        break;
                    }
                }
            }
        }
        $put .= "{$selector}{font-family:{$font}{$important};}\n";
    } else {
        $put .= "{$selector}{font-family:'Open Sans', sans-serif{$important};}";
    }

    // outline fonts - only page/post title hand headers h1-h6
    $font_opts = array(
        //'content_h' => '.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6',
        'content_h' => "h1.wp-block-heading,h2.wp-block-heading,h3.wp-block-heading,h4.wp-block-heading,h5.wp-block-heading,h6.wp-block-heading",
        'page_title' => 'h1.wp-block-post-title',
        'post_title' => 'h1.wp-block-post-title',
    );

    foreach ($font_opts as $fopt => $selector) {
        $space = weaverx_getopt($fopt . '_word_spacing');
        if ($space && $space != 0) {
            $put .= sprintf($selector . "{word-spacing:%.5fem;}\n", $space);
        }

        $space = weaverx_getopt($fopt . '_letter_spacing');
        if ($space && $space != 0) {
            $put .= sprintf($selector . "{letter-spacing:%.5fem;}\n", $space);
        }

        $trans = weaverx_getopt($fopt . '_transform');
        if ($trans && $trans != '') {
            $put .= sprintf($selector . "{text-transform:%s;}\n", $trans);
        }

        if (weaverx_getopt_checked($fopt.'_outline')) { // show font as outlined
            $out_color = weaverx_getopt('font_color_outline');
            if (!$out_color || $out_color == '' || $out_color == 'inherit') {
                $out_color = '#f8f8f8';
            } else {
                $out_color .= ' !important';
            }
            $put .= $selector . "{color: $out_color;font-weight: bold;letter-spacing: 0.18rem;text-shadow:-1px -1px 0 #080808,1px -1px 0 #080808,-1px 1px 0 #080808,1px 1px 0 #080808;}";
        }

    }

    return $put;
}

/**
 * Get list of fonts
 *
 * @return array
 * @since 4.0
 *
 */
function weaverx_get_font_list(): array
{
    $fonts = array(
        'sans-serif' => 'Arial,sans-serif',
        'arialBlack' => '"Arial Black",sans-serif',
        'arialNarrow' => '"Arial Narrow",sans-serif',
        'lucidaSans' => '"Lucida Sans",sans-serif',
        'trebuchetMS' => '"Trebuchet MS", "Lucida Grande",sans-serif',
        'verdana' => 'Verdana, Geneva,sans-serif',
        'alegreya-sans' => "'Alegreya Sans', sans-serif",
        'alegreya-sans-sc' => "'Alegreya Sans SC', sans-serif",
        'roboto' => "'Roboto', sans-serif",
        'roboto-condensed' => "'Roboto Condensed', sans-serif",
        'source-sans-pro' => "'Source Sans Pro', sans-serif",


        'serif' => 'TimesNewRoman, "Times New Roman",serif',
        'cambria' => 'Cambria,serif',
        'garamond' => 'Garamond,serif',
        'georgia' => 'Georgia,serif',
        'lucidaBright' => '"Lucida Bright",serif',
        'palatino' => '"Palatino Linotype",Palatino,serif',
        'alegreya' => "'Alegreya', serif",
        'alegreya-sc' => "'Alegreya SC', serif",
        'roboto-slab' => "'Roboto Slab', serif",
        'source-serif-pro' => "'Source Serif Pro', serif",

        'monospace' => '"Courier New",Courier,monospace',
        'consolas' => 'Consolas,monospace',
        'inconsolata' => "'Inconsolata', monospace",
        'roboto-mono' => "'Roboto Mono', monospace",

        'papyrus' => 'Papyrus,cursive,serif',
        'comicSans' => '"Comic Sans MS",cursive,serif',
        'handlee' => "'Handlee', cursive",

        'open-sans' => "'Open Sans', sans-serif",
        'open-sans-condensed' => "'Open Sans Condensed', sans-serif",
        'droid-sans' => "'Droid Sans', sans-serif",
        'droid-serif' => "'Droid Serif', serif",
        'exo-2' => "'Exo 2', sans-serif",
        'lato' => "'Lato', sans-serif",
        'lora' => "'Lora', serif",
        'arvo' => "'Arvo', serif",
        'archivo-black' => "'Archivo Black', sans-serif",
        'vollkorn' => "'Vollkorn', serif",
        'ultra' => "'Ultra', serif",
        'arimo' => "'Arimo', serif",
        'tinos' => "'Tinos', serif",
    );
    if (weaverx_cz_is_plus('6.1')) {
        $plus_fonts = array(
            'oswald' => "'Oswald', sans-serif",
            'pt-sans' => "'PT Sans', sans-serif",
            'raleway' => "'Raleway', sans-serif",
            'ubuntu' => "'Ubuntu', sans-serif",
            'montserrat' => "'Montserrat', sans-serif",
            'pt-sans-narrow ' => "'PT Sans Narrow', sans-serif",
            'yanone-kaffeesatz' => "'Yanone Kaffeesatz', sans-serif",
            'oxygen' => "'Oxygen', sans-serif",
            'titillium-web' => "'Titillium Web', sans-serif",
            'noto-sans' => "'Noto Sans', sans-serif",
            'dosis' => "'Dosis', sans-serif",
            'bitter' => "'Bitter', serif",
            'merriweather' => "'Merriweather', serif",
            'pt-serif' => "'PT serif, serif",
            'playfair-display' => "'Playfair Display', serif",
            'rokkitt' => "'Rokkitt', serif",
            'noto-serif' => "'Noto serif', serif",
            'indie-flower' => "'Indie Flower', cursive",
            'dancing-script' => "'Dancing Script', cursive",
            'droid-sans-mono' => "'Droid Sans Mono', Courier, monospace",
            'ubuntu-mono' => "'Ubuntu Mono', Courier, monospace",
            'nova-mono' => "'Nova Mono', Courier, monospace",
        );
        $fonts = array_merge($fonts, $plus_fonts);
    }
    return $fonts;
}


/**
 * Get option value for content cascade
 *
 * @since:    4.0
 *
 */
function weaverx_get_cascade_opt($option, $default): string
{
    // we need to get the option from the wrapper -> container -> content CSS cascade

    $val = weaverx_getopt_default("content{$option}", $default);    // content 1st
    if ($val != $default) {
        return $val;
    }
    $val = weaverx_getopt_default("container{$option}", $default);    // then container
    if ($val != $default) {
        return $val;
    }

    return weaverx_getopt_default("wrapper{$option}", $default);    // wrapper or default last
}

//--

/**
 * Set the font size multiplier for title fonts
 *
 * @param string $font_size The name of the font size
 *
 * @returns float The title font multiplier
 *
 * @since 4.0
 *
 */
function weaverx_fontsize_mult($font_size, $type = 'standard'): float
{
    // font multiplier for titles
    // uses same font size tags as normal, but with different multipliers

    switch ($font_size) {        // find conversion factor
        case 'xxs-font-size':
            $title_fontmult = 0.875;
            $std_fontmult = 0.625;
            break;
        case 'xs-font-size':
            $title_fontmult = 1.0;
            $std_fontmult = 0.75;
            break;
        case 's-font-size':
            $title_fontmult = 1.25;
            $std_fontmult = 0.875;
            break;
        case 'l-font-size':
            $title_fontmult = 1.875;
            $std_fontmult = 1.125;
            break;
        case 'xl-font-size':
            $title_fontmult = 2.25;
            $std_fontmult = 1.25;
            break;
        case 'xxl-font-size':
            $title_fontmult = 2.625;
            $std_fontmult = 1.5;
            break;
        case 'huge-font-size':
            $title_fontmult = 3.25;
            $std_fontmult = 2.0;
            break;
        case 'm-font-size':
        default:
            $title_fontmult = 1.5;
            $std_fontmult = 1.0;
            break;
    }

    if ($type == 'standard') {
        return $std_fontmult;
    }

    return $title_fontmult;
}

