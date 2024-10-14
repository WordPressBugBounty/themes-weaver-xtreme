<?php
/** PHP 7.4 features added */
/** @noinspection PhpRedundantOptionalArgumentInspection */
/** @noinspection GrazieInspection */
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
/** @noinspection PhpUnnecessaryStringCastInspection */
/** @noinspection PhpUndefinedConstantInspection */
/** @noinspection PhpParamsInspection */
/** @noinspection PhpConditionCheckedByNextConditionInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpUndefinedFunctionInspection */
/** @noinspection PhpUnusedParameterInspection */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/* Weaver Xtreme - runtime utils
 *
 *  __ added - 12/11/14
 * needed both at admin time and runtime
 */

// # CONTENTS

// # OPTIONS
// # PER PAGE OPTIONS
// # WIDGET AREA OPTIONS
// # HTML CODE AREAS
// # RUNTIME SAPI HELPER FUNCTIONS
// # PAGE WITH POSTS
// # FILTERS
// # MISC
// # OTHER UTILS

// # Weaver Xtreme Globals ==============================================================
$weaverx_opts_cache = false;    // internal cache for all settings
$weaverx_cur_page_ID = '';    // the ID of the current page
$weaverx_cur_post_count = 0;    // to keep track of even/odd
$weaverx_cur_template = '';    // current page template - set in functions.php setup
$weaverx_header = array();       // as of WP 3.4
$weaverx_sticky = false;

// # OPTIONS ==============================================================

function weaverx_getopt($opt)   // : string
{
    global $weaverx_opts_cache;

    weaverx_opt_cache();

    if (!isset($weaverx_opts_cache[$opt])) {    // handle changes to data structure
        return '';
    }

    return $weaverx_opts_cache[$opt];
}

function weaverx_getopt_plus($opt, $vers = '3.0')   // : string
{
    global $weaverx_opts_cache;

    weaverx_opt_cache();

    if (!isset($weaverx_opts_cache[$opt]) || !weaverx_cz_is_plus($vers)) {    // handle changes to data structure
        return '';
    }

    return $weaverx_opts_cache[$opt];
}

function weaverx_getopt_array($opt)
{
    $val = weaverx_getopt($opt);
    if (!$val) {
        return array();
    }

    return unserialize($val);
}


function weaverx_getopt_default($opt, $default = false) // : string
{
    $val = weaverx_getopt($opt);
    if ((!$val && strlen($val) == 0) || $val == 'default') {
        return $default;
    } else {
        return $val;
    }
}

function weaverx_getopt_checked($opt): bool
{
    global $weaverx_opts_cache;
    weaverx_opt_cache();

    if (!isset($weaverx_opts_cache[$opt])) {    // handles changes to data structure
        return false;
    }
    if (!$weaverx_opts_cache[$opt]) {
        return false;
    }

    return true;
}

// function weaverx_getopt_expand( $opt ) removed v5

function weaverx_opt_cache(): void
{
    // load the options cache - only weaverx_settings in basic version
    global $weaverx_opts_cache;

    if (!$weaverx_opts_cache) {
        $weaverx_opts_cache = weaverx_get_db_options();
        //weaverx_alert( 'Options Loaded' );
    }
}

function weaverx_clear_opt_cache($who = 'unknown'): void
{
    global $weaverx_opts_cache;
    $weaverx_opts_cache = false;
    //weaverx_alert( 'Cache cleared:' . $who );
}

function weaverx_setopt($opt, $val, $save = false): void
{
    global $weaverx_opts_cache;
    weaverx_opt_cache();

    $weaverx_opts_cache[$opt] = $val;
    if ($save) {
        weaverx_wpupdate_option(WEAVER_SETTINGS_NAME, $weaverx_opts_cache, false);
    }
}

function weaverx_setopt_array($opt, $val, $save = false): void
{
    weaverx_setopt($opt, serialize($val), $save);
}

function weaverx_delete_all_options($no_save = false): void
{
    // $no_save used by Xtreme Plus
    weaverx_clear_opt_cache('weaverx_delete_all_options');

    if (!$no_save && current_user_can('manage_options')) {
        $opt_func = WEAVER_DELETE_OPTION;
        $opt_func(apply_filters('weaverx_options', WEAVER_SETTINGS_NAME));
    }
}


function weaverx_optlen($opt): int
{
    if (!is_array($opt))     // opts can contain arrays
    {
        return strlen($opt);
    } else {
        return 1;
    }
}

function weaverx_update_options($who = 'unknown'): void
{
    global $weaverx_opts_cache;
    if (!$weaverx_opts_cache) {
        $weaverx_opts_cache = weaverx_get_db_options();
    }
    weaverx_wpupdate_option(WEAVER_SETTINGS_NAME, $weaverx_opts_cache, false);
}


function weaverx_save_opts($who = '', $bump = true): void
{
    // Save options
    // Here's the strategy. Using weaverx_getopt always loads the cache if it hasn't been.
    // Using weaverx_setopt will save the cache to the database by default
    // So we take advantage of this by bumping the style version, and using weaverx_setopt,
    // which saves to the database

    //weaverx_alert_debug('weaverx_save_opts, who = ' . $who ); //@@@@@dev:
    $vers = weaverx_getopt('style_version');
    if ($who == 'customizer') {                // really need to refresh the cache
        weaverx_clear_opt_cache($who);
        $force_cache = weaverx_getopt('style_date'); // and reload the cache
    }

    weaverx_setopt('last_option', WEAVERX_THEMENAME);        // just be sure - needed for first time install

    if ($bump) {
        $vers = $vers ? $vers + 1 : 1;    // bump or init
        weaverx_setopt('style_version', $vers);

        // put the CSS into the DB
        require_once(get_theme_file_path('/includes/generatecss.php'));

        unset($GLOBALS['weaverx_gen_css']);
        $GLOBALS['weaverx_gen_css'] = '';

        //$GLOBALS['weaverx_gen_css'] = '/* -wvrx_css- */'; // prefix info


        weaverx_generate_style_css();
        $current_css = '';
        if (WEAVERX_MINIFY == '') $current_css = sprintf("/* vvv--- Weaver Xtreme 6 generated styles - Version %s vvv */\n", weaverx_getopt('style_version'));
        $current_css .= weaverx_minify_css($GLOBALS['weaverx_gen_css']);
        if (WEAVERX_MINIFY == '') $current_css .= sprintf("\n/* ^^^--- Weaver Xtreme 6 generated styles - Version %s ^^^ */\n", weaverx_getopt('style_version'));
        weaverx_setopt('wvrx_css_saved', $current_css);
        unset($GLOBALS['weaverx_gen_css']);
        $GLOBALS['weaverx_gen_css'] = '';
    }

    weaverx_setopt('style_date', date('Y-m-d-H:i:s'), $bump);

    // and now is the time to update the style file
    weaverx_save_classic_editor_css();
}

function weaverx_e_opt($opt, $str): void
{
    if (weaverx_getopt_checked($opt)) {
        echo $str;
    }
}

function weaverx_e_notopt($opt, $str): void
{
    if (!weaverx_getopt_checked($opt)) {
        echo $str;
    }
}

function weaverx_get_db_options()
{
    $opt_func = WEAVER_GET_OPTION;  // function to get options

    return apply_filters('weaverx_switch_theme',
        $opt_func(apply_filters('weaverx_options', WEAVER_SETTINGS_NAME), array()));    // start with the default
}

function weaverx_wpupdate_option($name, $opts, $write_css = true): void
{

    if (current_user_can('edit_theme_options')) {
        $compressed = array_filter($opts, 'weaverx_optlen'); // filter out all null options ( strlen == 0 )
        $option = apply_filters('weaverx_options', $name);
        $opt_func = WEAVER_UPDATE_OPTION;
        $opt_func($option, $compressed, 'yes');           // updated for new autoload standard
        weaverx_clear_opt_cache();

        if ($write_css) { // need to update style files as well...
            weaverx_save_classic_editor_css();
        }
    }
}

// # PER PAGE OPTIONS =========================================================
function weaverx_get_cur_page_id(): string
{
    global $weaverx_cur_page_ID;

    // V 6.6 fix for WP-CLI problem
    if (isset($weaverx_cur_page_ID) && !is_null($weaverx_cur_page_ID)) {
        return $weaverx_cur_page_ID;
    }

    return '';
}

function weaverx_set_cur_page_id($id): void
{
    global $weaverx_cur_page_ID;
    $weaverx_cur_page_ID = $id;
}

function weaverx_is_archive(): bool
{
    if ($GLOBALS['weaverx_wooshop'] > 0) {
        return true;
    } else {
        return is_archive();
    }
}

function weaverx_get_per_page_value($name)
{

    if (!($id = weaverx_get_cur_page_id())) {
        return false;
    }

    return get_post_meta($id, $name, true);
}

function weaverx_is_checked_page_opt($meta_name): bool
{
    // the standard is to check options to hide things

    if (!($id = weaverx_get_cur_page_id())) {
        return false;
    }

    $val = get_post_meta($id, $meta_name, true);  // retrieve meta value

    return !empty($val);    // if value exists - 'on'
}

function weaverx_get_per_post_value($meta_name)
{
    return get_post_meta(get_the_ID(), $meta_name, true);  // retrieve meta value
}

function weaverx_is_checked_post_opt($meta_name): bool
{
    // the standard is to check options to hide things
    $val = get_post_meta(get_the_ID(), $meta_name, true);  // retrieve meta value

    return !empty($val);    // if value exists - 'on'
}


// # PAGE WITH POSTS ==============================================================

function weaverx_page_posts_error($info = ''): void
{
    echo('<h2 style="color:red;">' . esc_html__('WARNING: error defining Custom Field on Page with Posts.', 'weaver-xtreme') . '</h2>');
    if (strlen($info) > 0) {
        echo('More info: ' . $info . '<br />');
    }
}

function weaverx_get_page()
{
    /* get the current posts display number
     needed for when Page with Posts is front page
    */
    $paged = get_query_var('paged');
    if (!isset($paged) || empty($paged)) {
        $paged = 1;
    }
    $page = get_query_var('page');
    if ($page > 1) {
        $paged = $page;
    }

    return $paged;
}

function weaverx_setup_post_args($args)
{
    /* setup WP_Query arg list */

    $cats = weaverx_get_page_categories();
    if (!empty($cats)) {
        $args['cat'] = $cats;
    }

    $tags = weaverx_get_page_tags();
    if (!empty($tags)) {
        $args['tag'] = $tags;
    }

    $onepost = weaverx_get_page_onepost();
    if (!empty($onepost)) {
        $args['name'] = $onepost;
    }

    $orderby = weaverx_get_page_orderby();
    if (!empty($orderby)) {
        $args['orderby'] = $orderby;
    }

    $order = weaverx_get_page_order();
    if (!empty($order)) {
        $args['order'] = $order;
    }

    $author_name = weaverx_get_page_author();
    if (!empty($author_name)) {
        $nosp = str_replace(' ', '', $author_name);
        $id_list = str_replace(',', '', $nosp);
        if (is_numeric($id_list)) {
            $args['author'] = $author_name;
        } else {
            $args['author_name'] = $author_name;
        }
    }

    $posts_per_page = weaverx_get_page_posts_per();
    if (!empty($posts_per_page)) {
        $args['posts_per_page'] = $posts_per_page;
    }

    $post_type = weaverx_get_per_page_value('_pp_post_type');
    if ($post_type) {
        $args['post_type'] = $post_type;
    }

    if (weaverx_is_checked_page_opt('_pp_hide_sticky')) {
        $args['ignore_sticky_posts'] = true;
    }

    return $args;
}

function weaverx_get_page_categories(): string
{
    $cats = weaverx_get_per_page_value('_pp_category');
    if (empty($cats)) {
        return '';
    }

    // now convert slugs to ids
    return weaverx_cat_slugs_to_ids($cats);
}

function weaverx_cat_slugs_to_ids($cats): string
{
    if (empty($cats)) {
        return '';
    }

    // now convert slugs to numbers
    $cats = str_replace(' ', '', $cats);
    $clist = explode(',', $cats);    // break into a list
    $cat_list = '';
    foreach ($clist as $slug) {
        $neg = 1;    // not negative
        if ($slug[0] == '-') {
            $slug = substr($slug, 1);    // zap the -
            $neg = -1;
        }
        if (strlen($slug) > 0 && is_numeric($slug)) { // allow both slug and id
            $cat_id = $neg * ( int )$slug;
            if ($cat_list == '') {
                $cat_list = strval($cat_id);
            } else {
                $cat_list .= ',' . strval($cat_id);
            }
        } else {
            $cur_cat = get_category_by_slug($slug);
            if (is_object($cur_cat)) {
                $cat_id = $neg * ( int )$cur_cat->cat_ID;
                if ($cat_list == '') {
                    $cat_list = strval($cat_id);
                } else {
                    $cat_list .= ',' . strval($cat_id);
                }
            }
        }
    }
    if (empty($cat_list)) {
        $cat_list = '99999999';
    }

    return $cat_list;
}

function weaverx_get_page_tags()
{
    $tags = weaverx_get_per_page_value('_pp_tag');
    if (empty($tags)) {
        return '';
    }

    return str_replace(' ', '', $tags);
}

function weaverx_get_page_onepost()
{
    $the_post = weaverx_get_per_page_value('_pp_onepost');
    if (empty($the_post)) {
        return '';
    }

    return $the_post;
}

function weaverx_get_page_orderby()
{
    $orderby = weaverx_get_per_page_value('_pp_orderby');
    if (empty($orderby)) {
        return '';
    }

    if ($orderby == 'author' || $orderby == 'date' || $orderby == 'title' || $orderby == 'rand') {
        return $orderby;
    }
    weaverx_page_posts_error(esc_html__('orderby must be author, date, title, or rand. You used: ', 'weaver-xtreme') . $orderby);

    return '';
}

function weaverx_get_page_order()
{
    $order = weaverx_get_per_page_value('_pp_sort_order');
    if (empty($order)) {
        return '';
    }
    if ($order == 'ASC' || $order == 'DESC') {
        return $order;
    }
    weaverx_page_posts_error(esc_html__('order value must be ASC or DESC. You used: ', 'weaver-xtreme') . $order);

    return '';
}

function weaverx_get_page_posts_per()
{
    $ppp = weaverx_get_per_page_value('_pp_posts_per_page');
    if (empty($ppp)) {
        return '';
    }

    // now convert slugs to numbers
    return $ppp;
}

function weaverx_get_page_author()
{
    $author = weaverx_get_per_page_value('_pp_author');
    if (empty($author)) {
        return '';
    }

    return $author;
}


// # FILTERS ==============================================================

//  ============ validation filters ===============

function weaverx_filter_textarea($text): string
{
    // virtually all option text input from Weaver Xtreme can be code, and thus must not be
    // content filtered. Treat like code for now....
    return weaverx_filter_code($text);
}

function weaverx_filter_text($string): string
{
    // filter text, mostly from translations, to allowed html - excludes things like <script>, <style>, <inline>
    return wp_kses_post($string);
}

function weaverx_esc_textarea($text, $echo = true): string
{
    if (current_user_can('unfiltered_html')) {
        $out = esc_textarea($text);
    } else {
        $out = esc_textarea(stripslashes($text));
    }
    if ($echo) {
        echo $out;
        return '';
    } else {
        return $out;
    }
}

function weaverx_filter_head($text): string
{
    $allowed_head_tags = array(
        'title' => array(),
        'style' => array('media' => true, 'scoped' => true, 'type' => true),
        'meta' => array(
            'charset' => true,
            'content' => true,
            'http-equiv' => true,
            'name' => true,
            'scheme' => true,
            'property' => true,
        ),
        'link' => array('href' => true, 'rel' => true, 'type' => true, 'title' => true, 'media' => true, 'id' => true, 'class' => true, 'sizes' => true, 'crossorigin' => true, 'hreflang' => true),
        'script' => array('async' => true, 'charset' => true, 'defer' => true, 'src' => true, 'type' => true),
        'noscript' => array(),
        'base' => array('href' => true, 'target' => true),
    );

    // restrict head code to valid stuff for <head>

    $noslash = trim(stripslashes($text));

    if ($noslash == '') {
        return '';
    }

    if (current_user_can('unfiltered_html')) {
        if (strpos($noslash, '<script') !== false) {
            return wp_check_invalid_utf8($noslash);
        }    // stop <script>s from being broken

        return wp_kses($noslash, $allowed_head_tags);
    } else {
        return ''; // wp_filter_post_kses() handles slashes
    }
}

function weaverx_filter_code($text): string
{

    // Much option input from Weaver Xtreme can be code, and thus must not be
    // content filtered - at least for admins. The utf8 check is about the extent of it, although even
    // that is more restrictive than the standard text widget uses.
    // Note: this check also works OK for simple checkboxes/radio buttons/selections,
    // so it is ok to blindly pass those options in here, too.
    //$noslash = trim( stripslashes( $text ) );
    $trimmed = trim($text);

    if ($trimmed == ' ') {
        return '';
    }

    if (current_user_can('unfiltered_html')) {      // only superadmin on multisite, or single site admin
        return wp_check_invalid_utf8($trimmed);
    } else {
        return wp_filter_post_kses($trimmed); // wp_filter_post_kses() handles slashes
    }
}

function weaverx_echo_css($css): void
{
    if (is_multisite()) {
        // non-superadmins have some filtering on CSS - this will fix it.
        //$css = stripslashes( $css );
        $css = str_replace(array('&lt;', '&gt;'), array('<', '>'), $css);
    }
    echo $css;
}

function weaverx_echo_sanitized_html($echo_is_safe): void
{
    // This is used to echo trusted text that usually has HTML tags in it, possibly including trusted <script> or <style>.
    // Trusted text is most often generated by the theme code, but can originate from options set by a site admin.
    // It is also used to avoid flagging by Theme Sniffer, which essentially flags all occurrences of echo, even
    // if the code is obviously safe when read by a human - In other words, all the text used here.
    // It never is used for content that originates with translated text.
    echo $echo_is_safe;
}


function weaverx_markdown($string)
{
    // This allows *, **, and *** markdown in option descriptions. It looks fine left unprocessed, or it can
    // change the *text* to <em>text</em>, **text** to <b>text</b>, and ***text*** to <em><b>text</b></em>.
    //
    // Assumes correctly formatted strings.
    //
    // This function is mostly used for translatable (__) text, and will ultimately be sanitized before
    // output by wp_kses - sometimes wp_kses_data, sometimes wp_kses_post.
    // If more markdown tags are added, assume the output is sanitized with wp_kses_data(), which is very limited
    // in the HTML tags it allows.

    $str = $string;     // work on local copy

    while (strpos($str, '***') !== false) {
        $pos = strpos($str, '***');
        $str = substr_replace($str, '<em><b>', $pos, 3);
        $pos = strpos($str, '***');       // replace in pairs
        if ($pos !== false) {
            $str = substr_replace($str, '</b></em>', $pos, 3);
        }
    }
    while (strpos($str, '**') !== false) {
        $pos = strpos($str, '**');
        $str = substr_replace($str, '<b>', $pos, 2);
        $pos = strpos($str, '**');       // replace in pairs
        if ($pos !== false) {
            $str = substr_replace($str, '</b>', $pos, 2);
        }
    }
    while (strpos($str, '*') !== false) {
        $pos = strpos($str, '*');
        $str = substr_replace($str, '<em>', $pos, 1);
        $pos = strpos($str, '*');       // replace in pairs
        if ($pos !== false) {
            $str = substr_replace($str, '</em>', $pos, 1);
        }
    }

    return wp_kses_post($str);
}

// # MISC ==============================================================

function weaverx_minify_css($css = ''): string
{
    // Return if no CSS
    if (!$css || WEAVERX_MINIFY == '') {
        return $css;
    }

    // Normalize whitespace
    $css = preg_replace('/\s+/', ' ', $css);

    // Remove ; before }
    $css = preg_replace('/;(?=\s*})/', '', $css);

    // Remove space after , : ; { } */ >
    $css = preg_replace('/(,|:|;|\{|}|\*\/|>) /', '$1', $css);

    // Remove space before , ; { }
    $css = preg_replace('/ (,|;|\{|})/', '$1', $css);

    // Strips leading 0 on decimal values (converts 0.5px into .5px)
    $css = preg_replace('/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css);

    // Strips units if value is 0 (converts 0px to 0)
    $css = preg_replace('/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css);

    // Trim
    // Return minified CSS
    return trim($css);
}

function weaverx_add_classic_editor_styles()
{
    if (!current_user_can('edit_posts')) {  // don't bother if can't edit
        return;
    }

    $editor_styles = array(
        'editor-style.css',        // classic editor
        'assets/css/blocks-editor-base-style' . WEAVERX_MINIFY . '.css',   // gutenberg
        'assets/css/fonts/google/google-fonts' . WEAVERX_MINIFY . '.css',
    );

    if (weaverx_getopt('_hide_editor_style')) {
        // Enqueue editor styles - without theme editor styles
        add_editor_style($editor_styles);
    } else {
        weaverx_check_editor_style();        // see if we need an update...
        $vers = weaverx_getopt('style_version'); // need version for cloudflare or other caching services
        if (!$vers) {
            $vers = '1';
        } else {
            $vers = sprintf("%d", $vers);
        }


        // get generated classic editor styles
        $upload_dir = wp_upload_dir(); // Grab uploads folder array
        $dir = trailingslashit($upload_dir['basedir']) . WEAVERX_SUBTHEMES_DIR . DIRECTORY_SEPARATOR; // Set storage directory path
        $url = trailingslashit($upload_dir['baseurl']) . WEAVERX_SUBTHEMES_DIR . DIRECTORY_SEPARATOR; // Set storage directory path

        $file_name = $dir . 'classic-editor-style-wvrx.css'; // filename
        $css_url = $url . 'classic-editor-style-wvrx.css'; // filename

        if (@file_exists($file_name)) {              // need to see if the generated classic editor .css file has been generated
            $editor_styles[] = $css_url . '?ver=' . $vers;
            //weaverx_alert('classic editor css url: ' . $css_url);
        }

        if (weaverx_cz_is_plus('6.1')) {           // add google fonts for Plus 6+
            if (weaverx_cz_is_plus('6.1')) {     // add Plus fonts if Plus installed
                $plus_vers = weaverxplus_plugin_installed();
                $plus_dir = trailingslashit(plugin_dir_url('')) . 'weaver-xtreme-plus/includes/fonts/google-plus-fonts' . WEAVERX_MINIFY . '.css';
                //weaverx_alert('plus css url: ' . $plus_dir);
                //echo "<link href='$plus_dir' rel='stylesheet' type='text/css'>\n";
                $editor_styles[] = $plus_dir . '?ver=' . $plus_vers;
            }
        }

        add_editor_style($editor_styles);
    }
}

function weaverx_load_google_fonts()
{
    // SELF HOST GOOGLE FONTS
    // Note: Self-hosting Google fonts is likely the fastest way to serve them
    //          Because each font is a separate class, the actual font definition is not
    //          loaded until the font is actually used.

    // code for google hosting removed

    $fontUrl = get_template_directory_uri() . '/assets/css/fonts/google/google-fonts' . WEAVERX_MINIFY . '.css' . '?ver=' . WEAVERX_VERSION;
    // fixed 6.2.1.5
    echo "<!-- Self-host Google Fonts -->\n";
    echo "<link href='$fontUrl' rel='stylesheet' type='text/css'>\n";

    if (weaverx_cz_is_plus('6.1')) {     // add Plus fonts if Plus installed
        $plus_vers = weaverxplus_plugin_installed();
        $plus_dir = trailingslashit(plugin_dir_url('')) . 'weaver-xtreme-plus/includes/fonts/google-plus-fonts' . WEAVERX_MINIFY . '.css?ver=' . $plus_vers;
        echo "<link href='$plus_dir' rel='stylesheet' type='text/css'>\n";
    }


}

/** @noinspection PhpDuplicateSwitchCaseBodyInspection */
function weaverx_schema($who, $aux = '')
{        // added 3.1.13
    // apply schema.org info where we can.
    // NOTE: This filter MUST be defined or else the $who arg will be echoed.
    //return '';

    if (weaverx_getopt_checked('_no_schemea'))    // Oops! This is misspelled. Too late now, must stay that way...
    {
        return $aux;
    }                                // return $aux if not emitting - i.e., 'image', 'person'

    switch ($who) {
        case 'archive':
        case 'author':
        case 'blog':
        case 'category':
        case 'single':
        case 'tag':
            return ' itemtype="https://schema.org/Blog" itemscope';

        case 'body':
            if (is_search()) {
                return ' itemtype="https://schema.org/SearchResultsPage" itemscope';
            } else {
                return ' itemtype="https://schema.org/WebPage" itemscope';
            }

        case 'branding':
            return ' itemtype="https://schema.org/WPHeader" itemscope';

        case 'entry-content':
            return '';    // doesnt work?? ' itemprop="mainEntityOfPage"';

        case 'footer':
            return ' itemtype="https://schema.org/WPFooter" itemscope';

        case 'headline':
            return ' itemprop="headline name"';

        case 'image':
            $fix = str_replace('src=', 'itemprop="url" src=', $aux);    // add in url prop

            return '<span itemtype="https://schema.org/ImageObject" itemprop="image" itemscope>' . $fix . '</span>';

        case 'attachment':
            return ' itemtype="https://schema.org/ImageObject" itemprop="image" itemscope';

        case 'mainEntityOfPage':
            return '<link itemprop="mainEntityOfPage" href="' . get_permalink() . '" />';

        case 'menu':
            return ' itemtype="https://schema.org/SiteNavigationElement" itemscope';

        case 'person':
            return '<span itemtype="https://schema.org/Person" itemscope itemprop="author"><span itemprop="name">'
                . $aux . '</span></span>';

        case 'post':
            if (is_search()) {
                return ' itemtype="https://schema.org/Article" itemscope';        // searches don't want to be Blogs, just articles
            } else {
                return ' itemtype="https://schema.org/BlogPosting" itemscope itemprop="blogPost"';
            }

        case 'page':
            return ' itemtype="https://schema.org/WebPageElement" itemscope itemprop="mainContentOfPage"';

        case 'published':// <meta itemprop="datePublished" content="2009-05-08">
            $schema = '<meta itemprop="datePublished" content="' . esc_attr(get_the_date('c')) . '"/>' . "\n"
                . '<meta itemprop="dateModified" content="' . esc_attr(get_the_modified_date('c')) . '"/>' . "\n"
                . '<span style="display:none" itemscope itemprop="publisher" itemtype="https://schema.org/Organization">'
                . '<span itemprop="name">' . get_bloginfo('name') . "</span>";

            $logo = weaverx_get_wp_custom_logo_url();
            if ($logo != '') {
                $schema .= '<img itemprop="logo" src="' . esc_url($logo) . '" />';
            } else {
                $schema .= '<!-- no logo defined -->';
            }
            $schema .= "</span>\n";
            break;

        case 'show_posts_begin':
            return '<div class="atw-show-posts-schema" itemtype="https://schema.org/Blog" itemscope > <!-- begin Blog -->' . "\n";

        case 'show_posts_end':
            return '</div> <!-- end Blog -->';

        case 'sidebar':
            return ' itemtype="https://schema.org/WPSideBar" itemscope';

        default:
            return '';
    }

    return $schema;
}


function weaverx_get_the_author()
{
    // to allow person schema

    return weaverx_schema('person', esc_attr(get_the_author()));
}

function weaverx_header_widget_area($where_now): void
{    // header.php support
    // 'top' => 'Top of Header'
    // 'after_header' => 'After Header Image'
    // 'after_html' => 'After HTML Block'
    // 'after_menu' => 'After Main Menu'

    $sb_position = weaverx_getopt_default('header_sb_position', 'top');

    if ($sb_position == $where_now) {
        do_action('weaverx_alt_header_image');                // support plugins to add alternate header image
        if (weaverx_has_widgetarea('header-widget-area')) {
            $p_class = weaverx_area_class('header_sb', 'notpad', '-none', 'margin-none');

            if (weaverx_getopt('header_sb_fixedtop')) {
                $p_class .= ' wvrx-fixedtop';
            }

            //weaverx_clear_both( 'header_sb' );
            weaverx_put_widgetarea('header-widget-area', $p_class, 'header');
            if (weaverx_getopt('header_sb_align') == 'float-right') {
                weaverx_clear_both('header-widget-area');
            }
        }
    }
}

function weaverx_cz_is_old_plus()
{
    if (function_exists('weaverxplus_plugin_installed')) {
        return version_compare(WEAVER_XPLUS_VERSION, '4.9', '<=');
    } else {
        return false;
    }
}

function weaverx_cz_is_plus($version = '1.0') // default version is '1'
{
    if (!function_exists('weaverxplus_plugin_installed')) {
        return false;
    }

    if ($version == '1.0') {
        return true;
    }

    $vers = weaverxplus_plugin_installed(); // returns WEAVER_XPLUS_VERSION

    return version_compare($vers, $version, '>=');
}

function weaverx_site($sub = '', $site = '//weavertheme.com', $title = '', $echo = true): string
{
    if ($site == '') {
        $site = '//weavertheme.com';
    }
    if ($title == '') {
        $title = $site;
    }
    $link = '<a href="' . esc_url($site . $sub) . '" target="_blank" title="' . $title . '" rel="nofollow">' . $title . '</a> ';
    if ($echo) {
        echo $link;

        return '';
    } else {
        return $link;
    }
}


function weaverx_post_count_clear(): void
{
    global $weaverx_cur_post_count;
    $weaverx_cur_post_count = 0;
}


function weaverx_post_count_bump(): void
{
    global $weaverx_cur_post_count;
    $weaverx_cur_post_count++;
}


function weaverx_post_count(): int
{
    global $weaverx_cur_post_count;

    return $weaverx_cur_post_count;
}

if (!function_exists('weaverx_archive_loop')) :
    function weaverx_archive_loop($type): void
    {
        // output loop for archive-like pages.

        $num_cols = weaverx_getopt('blog_cols');
        $archive_cols = weaverx_getopt('archive_cols');

        if (!$num_cols || $num_cols > 3) {
            $num_cols = 1;
        }

        if (!$archive_cols) {
            $num_cols = 1;
        }

        $col = 0;

        weaverx_post_count_clear();
        echo("<div class=\"wvrx-posts\">\n");        // needed here, and all post loops to make content-n-col work with :nth-of-type

        if ($archive_cols && weaverx_masonry('begin-posts'))    // wrap all posts
        {
            $num_cols = 1;
        }        // force to 1 cols

        while (have_posts()) {
            the_post();
            weaverx_post_count_bump();

            if ($archive_cols) {
                weaverx_masonry('begin-post');
            }    // wrap each post
            switch ($num_cols) {
                case 1:
                    get_template_part('templates/content', get_post_format());
                    break;

                case 2:
                    $col++;
                    echo('<div class="content-2-col">' . "\n");
                    get_template_part('templates/content', get_post_format());
                    echo("</div> <!-- content-2-col -->\n");
                    break;

                case 3:
                    $col++;
                    echo('<div class="content-3-col">' . "\n");
                    get_template_part('templates/content', get_post_format());
                    echo("</div> <!-- content-3-col -->\n");
                    break;

                default:
                    get_template_part('templates/content', get_post_format());
            }   // end switch num cols
            if ($archive_cols) {
                weaverx_masonry('end-post');
            }

        }    // end while have posts
        if ($archive_cols) {
            weaverx_masonry('end-posts');
        }
        echo("</div> <!-- .wvrx-posts -->\n");
    }
endif;

function weaverx_post_class($hidecount = false): string
{
    global $weaverx_cur_post_count;
    global $weaverx_sticky;

    if ($weaverx_sticky)    // For page with posts - re-ordering sticky posts
    {
        $postclass = 'post-area sticky ';
    } else {
        $postclass = 'post-area ';
    }

    if (has_post_thumbnail()) {
        $fi = weaverx_get_per_post_value('_pp_post_fi_location');
        if (!$fi) {
            $fi = weaverx_getopt_default('post_fi_location', 'content-top');
        }
        if (strpos($fi, 'parallax-full') !== false) {
            $postclass .= 'wvrx-fullwidth wvrx-parallax ';
        } elseif (strpos($fi, 'parallax') !== false) {
            $postclass .= 'wvrx-parallax ';
        }

        $postclass .= "post-fi-{$fi} ";
    }

    if ($weaverx_cur_post_count != 0 && !$hidecount) {
        $postclass .= 'post-' . (($weaverx_cur_post_count % 2) ? 'odd' : 'even') . ' post-order-' . $weaverx_cur_post_count
            . ' ';
    }

    $author_id = get_the_author_meta('ID');
    if ($author_id) {
        $postclass .= "post-author-id-{$author_id} ";
    }

    if ($hidecount && weaverx_getopt('style_single_like_content')) {           // called from single page view of one post
        // Note: this means that most styling comes from the content settings instead of post styling
        return $postclass . weaverx_area_class('content', 'pad', '-tb', 'margin-bottom');
    }
    return $postclass . weaverx_area_class('post', 'pad', '-tb', 'margin-bottom');
}

function weaverx_use_inline_css($css_file): bool
{
    //fake out stub for some versions of PLUS
    return true;       // don't add file from Plus, need to do it from top level theme now
}

function weaverx_get_css_filename(): string
{

    return '';  // only used by Weaver Xtreme Plus - just a fake blank.
}

function weaverx_use_inline_css_v5($css_file): bool
{

    return (weaverx_getopt_checked('_inline_style')
        || !weaverx_f_exists($css_file)
        || is_customize_preview());     // also force inline from customizer ( Changed: 3.1.10 - used is_customize_preface() );
}

function weaverx_allow_file_read(): bool
{
    // Check for Reading User defined file name - not allowed by default for Multi-Site regular Admin
    // doesn't allow WVRX_MULTISITE_RESTRICT_OPTIONS test

    return ((!is_multisite() && current_user_can('install_plugins'))
        || (is_multisite() && current_user_can('manage_network_themes')));
}

function weaverx_allow_multisite(): bool
{
    // return true if it is allowed to use on MultiSite

    $restrict = (defined('WVRX_MULTISITE_RESTRICT_OPTIONS')) ? WVRX_MULTISITE_RESTRICT_OPTIONS : false;

    return ((!is_multisite() && current_user_can('install_themes'))
        || (is_multisite() && current_user_can('manage_network_themes'))
        || !$restrict);
}


function weaverx_help_link($link, $info, $alt_label = '', $echo = true): string
{

    $t_dir = get_theme_file_uri('help/' . $link);

    $alt_trans = $link;

    $hash = strpos($alt_trans, '#');
    if ($hash !== false) {
        $alt_trans = substr($alt_trans, 0, $hash); // kill off any # anchor
    }

    $locale = apply_filters('theme_locale', get_locale(), 'weaver-xtreme');
//weaverx_alert( 'ALT TRANS:' . WP_LANG_DIR . '/weaver-xtreme/' . $locale . '_' . $alt_trans );

    if (weaverx_f_exists(WP_LANG_DIR . '/weaver-xtreme/' . $locale . '_' . $alt_trans)) {    // works for default installation
        $t_dir = content_url() . '/languages/weaver-xtreme/' . $locale . '_' . $link;
    }

    if (!$alt_label) {
        $alt_label = '<span style="color:red; vertical-align: middle; margin-left:.25em;" class="dashicons dashicons-editor-help"></span>';
    }

    $out = '<a style="text-decoration:none;" href="' . esc_url($t_dir) . '" target="_blank" title="' . $info . '">'
        . $alt_label . '</a>';
    if ($echo) {
        echo $out;

        return '';
    } else {
        return $out;
    }
}


function weaverx_html_br($count = 1): void
{
    for ($i = 0; $i < $count; $i++) {
        echo ' <br /> ';
    }
}


function weaverx_compact_post(): bool
{
    return weaverx_getopt('compact_post_formats') || weaverx_is_checked_page_opt('_pp_pwp_compact');
}


function weaverx_get_first_post_image($content = ''): string
{
    if (has_post_thumbnail()) {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');

        return '<img class="format-image-img" src="' . esc_url($img[0]) . '" alt="post image" />';
    }

    if ($content == '') {
        $content = do_shortcode(apply_filters('the_content', get_the_content('')));
    }    // pick up wp 3.6 post format meta image
    if (preg_match('/<img[^>]+>/i', $content, $images)) {    // grab <img>s
        $src = '';
        if (preg_match('/src="([^"]*)"/', $images[0], $srcs)) {
            $src = $srcs[0];
        } elseif (preg_match("/src='([^']*)'/", $images[0], $srcs)) {
            $src = $srcs[0];
        }

        return '<img class="format-image-img" ' . $src . 'alt="post image" />';
    } else {
        return '';
    }
}


function weaverx_compact_link($check = ''): void
{
    if ($check == 'check' && !weaverx_is_checked_post_opt('_pp_post_add_link')) {
        return;
    }

    $link_img = weaverx_relative_url('') . 'assets/images/expand.png';
    ?>
    <div><a href="<?php echo esc_url(get_permalink()); ?>"
            title="<?php the_title_attribute('echo=1'); ?>" rel="bookmark">
            <img src="<?php echo esc_url($link_img); ?>" alt="link"/></a></div>
    <?php
}


if (!function_exists('weaverx_breadcrumb')) {
    /** @noinspection PhpUndefinedVariableInspection */
    function weaverx_breadcrumb($echo = true, $pwp = '')
    {
        /* Breadcrumbs
         * Credit: Dimox
         *	http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
         */
        $wrap = 'breadcrumbs';

        $containerBefore = '<span id="' . $wrap . '">';
        $containerAfter = '</span>';
        $containerCrumb = '<span class="crumbs">';
        $containerCrumbEnd = '</span>';
        $delimiter = apply_filters('weaverx_breadcrumb_delimiter', '&rarr;'); //' &raquo; ';

        $hierarchy = '';
        $currentLocation = '';
        $currentBefore = '<span class="bcur-page">';
        $currentAfter = '</span>';
        $crumbPagination = '';

        if (weaverx_getopt('menu_nohome')) {
            $name = weaverx_getopt('info_home_label') ? weaverx_getopt('info_home_label') : esc_attr(get_bloginfo('name', 'display'));
        } else {
            $name = weaverx_getopt('info_home_label') ? weaverx_getopt('info_home_label') : esc_html__('Home', 'weaver-xtreme'); //text for the 'Home' link
        }


        global $post;

        if ($pwp) {
            $name = $pwp;
        }

        $bc = '';
        // Output the Base Link
        if (is_front_page()) {
            $bc .= $currentBefore . $name . $currentAfter;
        } else {
            $home = home_url('/');
            $baseLink = '<a href="' . esc_url($home) . '">' . $name . '</a>';
            $bc .= $baseLink;
        }

        // Define Category Hierarchy Crumbs for Category Archive
        if (is_category()) {
            global $wp_query;
            if (is_object($wp_query->get_queried_object())) {
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0) {
                    $hierarchy = $delimiter . esc_html__('Categories', 'weaver-xtreme') . ' ' . get_category_parents($parentCat, true, $delimiter);
                } else {
                    $hierarchy = $delimiter . esc_html__('Categories', 'weaver-xtreme') . ' ';
                }
            } else {
                $hierarchy = '';
            }
            // Set $currentLocation to the current category
            $currentLocation = single_cat_title('', false);

        } // Define Crumbs for Day/Year/Month Date-based Archives
        elseif (is_date()) {
            // Define Year/Month Hierarchy Crumbs for Day Archive
            if (is_day()) {
                $date_string = '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ' . '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ';
                $date_string .= $delimiter . ' ';
                $currentLocation = get_the_time('d');
            } // Define Year Hierarchy Crumb for Month Archive
            elseif (is_month()) {
                $date_string = '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ';
                $date_string .= $delimiter . ' ';
                $currentLocation = get_the_time('F');
            } // Set CurrentLocation for Year Archive
            elseif (is_year()) {
                $date_string = '';
                $currentLocation = get_the_time('Y');
            }
            $hierarchy = $delimiter . esc_html__('Published', 'weaver-xtreme') . ' ' . $date_string;
        } // Define Category Hierarchy Crumbs for Single Posts
        elseif (is_single() && !is_attachment()) {
            $cats = get_the_category();
            if ($cats) {
                $cur_cat = $cats[0];
            } else {
                $cur_cat = '';
            }
            if ($cats) {
                foreach ($cats as $cat) {
                    $children = get_categories(array('parent' => $cat->term_id));
                    if (count($children) == 0) {
                        $cur_cat = $cat;
                        break;
                    }
                }
            }
            if ($cur_cat) {
                $hierarchy = $delimiter . get_category_parents($cur_cat, true, $delimiter);
            } else {
                $hierarchy = $delimiter . '';
            }
            // Note: get_the_title() is filtered to output a
            // default title if none is specified
            $currentLocation = get_the_title();
        } // Define Category and Parent Post Crumbs for Post Attachments
        elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat_parents = '';
            if (get_the_category($parent->ID)) {
                $cat = get_the_category($parent->ID);
                $cat = $cat ? $cat[0] : '';
                $cat_parents = get_category_parents($cat, true, $delimiter);
            }
            $hierarchy = $delimiter . $cat_parents . '<a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a> ' . $delimiter;
            // Note: Titles are forced for attachments; the
            // filename will be used if none is specified
            $currentLocation = get_the_title();
        } // Define Current Location for Parent Pages
        elseif (!is_front_page() && is_page() && !$post->post_parent) {
            $hierarchy = $delimiter;
            // Note: get_the_title() is filtered to output a
            // default title if none is specified
            $currentLocation = get_the_title();
        } // Define Parent Page Hierarchy Crumbs for Child Pages
        elseif (!is_front_page() && is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                //$page = get_page( $parent_id );
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                $hierarchy = $hierarchy . $delimiter . $crumb;
            }
            $hierarchy = $hierarchy . $delimiter;
            // Note: get_the_title() is filtered to output a
            // default title if none is specified
            $currentLocation = get_the_title();
        } // Define current location for Search Results page
        elseif (is_search()) {
            $hierarchy = $delimiter . esc_html__('Search Results', 'weaver-xtreme') . ' ';
            $currentLocation = get_search_query();
        } // Define current location for Tag Archives
        elseif (is_tag()) {
            $hierarchy = $delimiter . esc_html__('Tags', 'weaver-xtreme') . ' ';
            $currentLocation = single_tag_title('', false);
        } // Define current location for Author Archives
        elseif (is_author()) {
            $hierarchy = $delimiter . esc_html__('Author', 'weaver-xtreme') . ' ';
            $currentLocation = esc_attr(get_the_author_meta('display_name', get_query_var('author')));
        } // Define current location for 404 Error page
        elseif (is_404()) {
            $hierarchy = $delimiter . esc_html__('404', 'weaver-xtreme') . ' ';
            $currentLocation = esc_html__('Page not found', 'weaver-xtreme');
        } // Define current location for Post Format Archives
        elseif (get_post_format() && !is_home()) {
            $hierarchy = $delimiter . esc_html__('Post Formats', 'weaver-xtreme') . ' ';
            $currentLocation = get_post_format_string(get_post_format()) . 's';
        } else {
            if (isset($GLOBALS['weaverx_pwp_title'])) {
                $currentLocation = $delimiter . $GLOBALS['weaverx_pwp_title'];
            }

        }

// Build the Current Location Link markup
        $currentLocationLink = $currentBefore . $currentLocation . $currentAfter;

// Define breadcrumb pagination

// Define pagination for paged Archive pages
        if (get_query_var('paged') && !function_exists('wp_paginate')) {
            $crumbPagination = ' - ' . esc_html__('Page', 'weaver-xtreme') . ' ' . get_query_var('paged');
        }

        // Define pagination for Paged Posts and Pages
        if (get_query_var('page')) {
            $crumbPagination = ' - ' . esc_html__('Page', 'weaver-xtreme') . ' ' . get_query_var('page') . ' ';
        }

// Output the resulting Breadcrumbs

        $bc .= $hierarchy; // Output Hierarchy
        $bc .= $currentLocationLink; // Output Current Location
        $bc .= $crumbPagination; // Output page number, if Post or Page is paginated

        if (is_rtl()) {
            $list = explode($delimiter, $bc);    // split on the arrow
            $list = array_reverse($list);
            $larrow = apply_filters('weaverx_breadcrumb_delimiter_rtl', '&larr;');
            $bc = implode($larrow, $list);
        }
        // Wrap crumbs
        $bc = apply_filters('weaverx_breadcrumbs', $containerBefore . $containerCrumb . $bc . $containerCrumbEnd . $containerAfter, $bc);

        if ($echo) {
            echo $bc;
        } else {
            return $bc;
        }

        return '';
    }
}

if (!function_exists('weaverx_get_paginate_archive_page_links')) {
    function weaverx_get_paginate_archive_page_links($type = 'plain', $endsize = 1, $midsize = 1)
    {
        /**
         * Paginate Archive Index Page Links
         *
         * Code based on codex examples
         */
        global $wp_query;

        if (isset($wp_query->query_vars['paged'])) {
            $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
        } else {
            $current = 1;
        }

        // Sanitize input argument values
        if (!in_array($type, array('plain', 'list', 'array'))) {
            $type = 'plain';
        }
        $endsize = ( int )$endsize;
        $midsize = ( int )$midsize;

        $big = 999999999;    // from codex - an unlikely number, then str_replace. Makes archive no permalinks work

        if (is_search()) { // works for search on non-permalinks...
            $base = '%_%';
        } else {
            $base = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));
        }

        // Setup argument array for paginate_links()
        $pagination = array(
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $wp_query->max_num_pages,
            'current' => $current,
            'show_all' => false,
            'end_size' => $endsize,
            'mid_size' => $midsize,
            'type' => $type,
            'prev_text' => '&lt;&lt;',
            'next_text' => '&gt;&gt;',
        );

        if (!empty($wp_query->query_vars['s'])) {
            $pagination['add_args'] = array('s' => get_query_var('s'));
        }

        return paginate_links($pagination);
    }
}


// # MENU ==============================================================
class weaverx_Walker_Nav_Menu extends Walker
{
    public $tree_type = array('post_type', 'taxonomy', 'custom');
    public $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $class = 'sub-menu sub-menu-depth-' . $depth;
        $output .= "\n$indent<ul class=\"{$class}\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : ( array )$item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class( es ) applied to a menu item's list item element.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $megamenu = strpos($class_names, 'mega-menu') !== false && function_exists('weaverxplus_plugin_installed');
        if ($megamenu) {
            $class_names = str_replace('mega-menu', '', $class_names);
        }    // have to move it down

        /**
         * Filter the ID applied to a menu item's list item element.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         */
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        $aclass = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                if ($attr === 'href' && $value === '#' && weaverx_getopt('placeholder_cursor')) {
                    $aclass = ' style="cursor:' . weaverx_getopt('placeholder_cursor') . ';"';
                }
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }


        $item_output = $args->before;
        $item_output .= "<a{$attributes}{$aclass}>";
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . do_shortcode(apply_filters('the_title', $item->title, $item->ID)) . $args->link_after;
        $item_output .= "</a>";
        $item_output .= $args->after;

        if ($megamenu) {
            $desc = !empty($item->description) ? $item->description :
                esc_html__('Please enter MegaMenu content to Description.', 'weaver-xtreme');
            $item_output .= '<ul class="mega-menu"><li>' . do_shortcode($desc) . '</li></ul>';
        }

        /**
         * Filter a menu item's starting output.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }

} // Walker_Nav_Menu


// # FILE BLOCK I/O UTILS ==============================================================

/**
 * Save a big string to a file in the uploads/weaverx-subthemes directory
 *
 * @param string $filename , string $output
 *
 * @since Version 4
 *
 */

function weaverx_write_to_upload(string $filename, $output): bool
{

    if (function_exists('weaverx_ts_write_to_upload')) {
        return weaverx_ts_write_to_upload($filename, $output);
    }
    return true;
}

// # OTHER UTILS ==============================================================

function weaverx_debug_comment($msg): void
{
    echo "\n<!-- *************************::: {$msg} ::: ********************** -->\n";
}

function weaverx_get_footer($who): void
{
    get_footer($who);
}

//--

function weaverx_generate_id()
{
    if (!isset($GLOBALS['wvrx_gen_id'])) {
        $GLOBALS['wvrx_gen_id'] = 1;
    } else {
        $GLOBALS['wvrx_gen_id']++;
    }

    return $GLOBALS['wvrx_gen_id'];
}

//--

function weaverx_clear_both($class = ''): void
{
    if ($class) {
        echo '<div class="clear-' . $class . ' clear-both"></div>';
    } else {
        echo '<div class="clear-both"></div>';
    }
}

function weaverx_relative_url($subpath)
{
    // generate a relative URL from the site's root
    return parse_url(get_theme_file_uri($subpath), PHP_URL_PATH);
}

function weaverx_filter_css($css)
{
    // filter user added CSS for root relative file paths

    if (strpos($css, '%template_directory%') !== false) {
        $css = str_replace('%template_directory%',
            parse_url(get_theme_file_uri(), PHP_URL_PATH),
            $css);
    }
    if (strpos($css, '%stylesheet_directory%') !== false) {
        $css = str_replace('%stylesheet_directory%',
            parse_url(trailingslashit(get_stylesheet_directory_uri()), PHP_URL_PATH),
            $css);
    }
    if (strpos($css, '%addon_directory%') !== false) {
        $css = str_replace('%addon_directory%',
            parse_url(trailingslashit(weaverx_f_uploads_base_url()) . WEAVERX_SUBTHEMES_DIR . '/addon-subthemes/', PHP_URL_PATH),
            $css);
    }

    return $css;
}

add_filter('weaverx_css', 'weaverx_filter_css');

// =============================== transient options =============================
if (!function_exists('weaverx_globals')) {
    function weaverx_globals($glb = 'aspen_temp_opts')
    {
        return $GLOBALS[$glb] ?? '';
    }
}

if (!function_exists('weaverx_t_set')) {
    function weaverx_t_set($opt, $val): void
    {
        $GLOBALS['aspen_temp_opts'][$opt] = $val;
    }
}

if (!function_exists('weaverx_t_get')) {
    function weaverx_t_get($opt)
    {
        return $GLOBALS['aspen_temp_opts'][$opt] ?? '';
    }
}

if (!function_exists('weaverx_t_clear')) {
    function weaverx_t_clear($opt): void
    {
        unset($GLOBALS['aspen_temp_opts'][$opt]);
    }
}

if (!function_exists('weaverx_t_clear_all')) {
    function weaverx_t_clear_all(): void
    {
        unset($GLOBALS['aspen_temp_opts']);
    }
}

// # MASONRY ==============================================================

function weaverx_masonry($act = false): bool
{
    global $weaverx_cur_template;

    $is_pwp = false;

    if (strpos($weaverx_cur_template, 'paget-posts.php') !== false) {
        $is_pwp = true;
    }
    if (is_singular() && !$is_pwp) {    // don't emit anything for non-blog pages
        return false;
    }

    $usem = weaverx_get_per_page_value('_pp_pwp_masonry');    // per page to override...
    if ($usem < 2) {
        if ($is_pwp && weaverx_get_per_page_value('_pp_wvrx_pwp_cols') > 0)    // let per page value override global
        {
            return false;
        }
        $usem = weaverx_getopt('masonry_cols');
    }
    if ($usem < 2) {
        return false;
    }
    switch ($act) {
        case 'begin-posts':    // wrap all posts
            echo '<div id="blog-posts" class="cf">';
            break;
        case 'begin-post' :    // wrap one post
            if (weaverx_is_checked_post_opt('_pp_masonry_span2')) {    // span 2 columns
                $usem .= '-span-2';
            }
            echo '<div class="cf blog-post blog-post-cols-' . $usem . '">';    // for masonry
            break;
        case 'end-post':    // end of one post
            echo "</div> <!-- .blog-post -->\n";
            break;
        case 'end-posts':    // end of all posts
            echo '</div> <!-- #blog-posts -->' . "\n";
            break;
        case 'invoke-code':
            ?>
            <!--suppress JSUnresolvedFunction -->
            <script type='text/javascript'>
                jQuery(function () {
                    var $container = jQuery('#blog-posts');
                    $container.imagesLoaded(function () {
                        $container.masonry({itemSelector: '.blog-post'});
                    });
                });
                jQuery(window).resize(function () {
                    jQuery('#blog-posts').masonry({itemSelector: '.blog-post'});
                });
            </script>
            <?php
            break;

        case 'enqueue-script':
            wp_enqueue_script('jquery-masonry', null, array('jquery'), null, true);

            break;
    }    // end switch

    return true;
}

function weaverx_check_editor_style(): void
{        // see if we need an update...
    if (!(current_user_can('edit_theme_options') && current_user_can('activate_plugins')) || is_customize_preview()) {
        return;
    }

    // if ( ! @file_exists( $dir ) || weaverx_getopt( 'settings_version' ) != WEAVERX_SETTINGS_VERSION ) {    // save latest version )  {
    if (weaverx_getopt('settings_version') != WEAVERX_SETTINGS_VERSION) {    // save latest version )  {
        if (weaverx_getopt('settings_version') != WEAVERX_SETTINGS_VERSION) {
            weaverx_setopt('settings_version', WEAVERX_SETTINGS_VERSION);        // save latest version
        }
        weaverx_save_opts('customizer', true); // using customizer helps force for all situations
    }
}

/*
 * If we don't have WEAVER_SETTINGS_NAME saved, and we might have existing settings saved
 * from a previous version of Weaver Xtreme (e.g., 4), then read theme from 'weaverx_settings' in options,
 * and convert them to Weaver Xtreme 5+ settings in theme_mods.
 *
 */


function weaverx_convert4_to_5($old, $from_v4_db = false)
{
    // this will convert Weaver Xtreme 4.4 (and earlier) settings to Weaver Xtreme 5 or 6 equivalents
    // returns new converted settings

    // The settings are obsolete, and are not handled in Weaver Xtreme 5

    remove_theme_mod("background_color");   // remove obsolete setting
    if (empty($old)) {
        return $old;
    }
    $converted = 0;

    if (isset($old['settings_version']) && WEAVERX_SETTINGS_VERSION == $old['settings_version']) {
        return $old;
    }

    // Restore WP Custom CSS because we may be loading from a .wxt file

    if (isset($old['wp_css'])) {
        wp_update_custom_css_post($old['wp_css']);   // replace with saved version
    }
    // else if not set, then leave custom css alone as we're most likely converting
    // from V4 to V5 via settings.


    if ($from_v4_db) {        // for testing, while using weaver 4 version

        $mods = get_option('theme_mods_weaver-xtreme-4');

        if (isset($mods ['custom_css_post_id'])) {
            $css_id = $mods['custom_css_post_id'];

            if ($css_id > 0) {
                $post_contents = get_post($css_id)->post_content;
                if ($post_contents) {
                    wp_update_custom_css_post($post_contents);
                }
            }
        }

        if (isset($mods ['nav_menu_locations'])) {
            set_theme_mod('nav_menu_locations', $mods ['nav_menu_locations']);
        }
        if (isset($mods ['_options_level'])) {
            $level = $mods['_options_level'];
            if ($level > 0) {
                set_theme_mod('_options_level', $level);
            }
        }
    }


    $new = $old;

    /* fix extend options */
    $extend = array(
        'header',
        'header_sb',
        'header_html',
        'container',
        'infobar',
        'footer',
        'footer_sb',
        'footer_html',
        'post',
    );

    $extend_bgcolor = array(
        // extend provided bgcolor
        'header_extend_bgcolor',
        'm_primary_extend_bgcolor',
        'm_secondary_extend_bgcolor',
        'm_extra_extend_bgcolor',
        'container_extend_bgcolor',
        'content_extend_bgcolor',
        'footer_extend_bgcolor',
    );

    $expand = array(
        // stretch options
        'expand_header',
        'expand_header-image',
        'expand_header-widget-area',
        'expand_header-html',
        'expand_container',
        'expand_post',
        'expand_footer',
        'expand_footer_sb',
        'expand_footer_html',
        'expand_site-ig-wrap',
        'expand_container',
        'expand_m_primary',
        'expand_m_secondary',
        'expand_m_extra',
    );


    /* first conversion is old, obsolete one-step layout */

    if (!empty($new['site_layout']) && $new['site_layout'] == 'fullwidth') {
        $converted++;
        $new['header_align'] = 'wvrx-fullwidth';
        $new['footer_align'] = 'wvrx-fullwidth';
        foreach (array('m_primary', 'm_secondary') as $menu) {
            $align = $new[$menu . '_align'];
            if ($align != 'right') {
                $align = 'center';
            }
            $new[$menu . '_align'] = 'alignfull ' . $align;
            unset($new[$menu . '_extend_width']);
        }
    } elseif (!empty($new['site_layout']) && $new['site_layout'] == 'stretched') {
        $converted++;
        $new['header_align'] = 'alignfull';
        $new['footer_align'] = 'alignfull';
        $new['m_primary_align'] = 'center';
        $new['m_secondary_align'] = 'center';
        unset ($new['expand_header']);
        unset ($new['expand_footer']);
    }
    /*
     * FIX individual expand and extend options, set by user or by old site_layout options.
     * In Version 4, all of these options are cleared by generatecss if fullwidth or stretched is used,
     * but may have values otherwise. We want all of them cleared for V5, but they will have values only
     * if fullwidth or stretched options set.
     * */

    foreach ($extend as $val) {
        $name = $val . '_extend_width';
        if (!empty($new[$name]) && $new[$name] != '') {
            $converted++;
            $new[$val . '_align'] = 'wvrx-fullwidth';
            unset ($new[$val . '_extend_bgcolor']);
        }
        unset($new[$name]);
    }

    /* fix expand (stretch) options */

    foreach ($expand as $val) {
        if (!empty($new[$val]) && $new[$val] != '') {
            $converted++;
            $name = substr($val, 7);
            $new[$name . '_align'] = 'alignfull';
            unset ($new[$val]);
        }
        unset($new[$val]);
    }

    /* fix wrapper_fullwidth */

    if (!empty($new['wrapper_fullwidth']) && $new['wrapper_fullwidth'] != '') {
        $converted++;
        $new['wrapper_align'] = 'alignfull';
    }

    unset($new['wrapper_fullwidth']); // remove any value

    unset($new['site_layout']);       // clear any site_layout value

    unset($new['m_primary_extend_width']); // remove these, too
    unset($new['m_secondary_extend_width']);
    unset($new['m_extra_extend_width']);
    unset($new['wvrx_css_saved']);    // always wipe out old generated CSS

    $new['settings_version'] = WEAVERX_SETTINGS_VERSION;          // mark as converted

    unset($new['last_option']);   // make last option the last option again.
    $new['last_option'] = WEAVERX_THEMENAME;

    //$new = array_filter( $new, 'weaverx_optlen' ); // filter out all null options ( strlen == 0 )
    unset($GLOBALS['weaverx_gen_css']);
    $GLOBALS['weaverx_gen_css'] = '';
    weaverx_wpupdate_option(WEAVER_SETTINGS_NAME, $new);  // only writes if admin, including css files

    // save a backup set of options so can revert to Weaver Xtreme 4

    if (current_user_can('edit_theme_options') || current_user_can('install_themes')) {
        delete_option('weaverx_settings-v4-backup'); // make it clean - delete the entire old one
        update_option('weaverx_settings-v4-backup', $old, false);   // 6.6: autoupdate fix

        if ($converted > 0) {
            $alert = esc_html__('INFORMATION: The settings you are using are from Weaver Xtreme V4. They have been automatically converted to new equivalents. It is possible that you will find some small differences in how your site looks. You should also save these converted settings from the settings interface.', 'weaver-xtreme');
            weaverx_alert($alert);
        }
    }

    return $new;
}

function weaverx_unset_list($opts, $list, $add = ''): void
{
    foreach ($list as $index) {
        unset ($opts[$index . $add]);
    }
}

if (!function_exists('weaverx_media_lib_button')) {     // added 6.2.1.5 - strange bug on some plugin combo
    function weaverx_media_lib_button($fillin = ''): void
    {
        ?>
        &nbsp;
        <a style='text-decoration:none;'
           title="<?php echo esc_attr__('Select image from Media Library. Click \'Insert into Post\' to paste url here.', 'weaver-xtreme'); ?>"
           href="javascript:weaverx_media_lib( '<?php echo $fillin; ?>' );"><span
                    style="font-size:16px;margin-top:2px;" class="dashicons dashicons-format-image"></span></a>
        <?php
    }
}

require_once(get_theme_file_path('/includes/fileio.php'));


