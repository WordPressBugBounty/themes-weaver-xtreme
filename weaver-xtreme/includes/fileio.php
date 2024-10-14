<?php
/** PHP 7.4 features added */
/** @noinspection ALL */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 *
 *
 */

function weaverx_f_file_access_fail($who = '')
{
    static $weaverx_f_file_access_fail_sent = false;
    if ($weaverx_f_file_access_fail_sent) {
        return;
    }    // only show once...
    $weaverx_f_file_access_fail_sent = true;
    ?>
    <div class="error">
        <strong style="color:#f00; line-height:150%;"><?php echo wp_kses_post(__('*** Weaver Xtreme File Access Error! *** <small style="padding-left:20px;">( But don\'t panic! )</small>
	<p>Weaver Xtreme is unable to process a file access request. It is unusual to see this error. It is most commonly displayed	after moving to a new host.</p>
	<p>Possible issues:
	<ul><li>You may have to change the directory permissions on your web hosting server to allow writing.</li>
	<li>If you have defined a custom directory structure (e.g., custom "UPLOADS" in wp_config.php), make sure they are correct.</li>
	<li>If you use an older host or self-host, you may need to set FTP credentials in wp_config.php.</li></ul></p>', 'weaver-xtreme')); ?>
            <?php echo '<p>' . esc_html__('Diagnostics:', 'weaver-xtreme') . "{$who}</p>\n"; ?>
    </div>
    <?php
}

/**
 * @return bool
 */
function weaverx_f_file_access_available(): bool
{
    //
    if (function_exists('weaverxplus_f_file_access')) {
        return true;
    }
    return false;
}


/* following are available to theme support plugin and weaver Xtreme Plus */
/**
 * @param $fn
 * @param $how
 * @return false|mixed|string
 */
function weaverx_f_open($fn, $how)
{
    // 'php://output' - legacy value, 'echo' is current standard ( Changed: 3.1.10 )
    if ($fn == 'php://output' || $fn == 'echo') {
        return 'echo';
    }
    if ($fn == 'wvrx_css_saved') {
        unset($GLOBALS['wvrx_css_saved']);
        $GLOBALS['wvrx_css_saved'] = '';

        return $fn;
    }
    if (function_exists('weaverxplus_f_open')) {
        return weaverxplus_f_open($fn, $how);
    }

    return false;
}

function weaverx_f_write($fn, $data)
{    // used in Plus
    if ($fn == 'echo') {
        echo $data;
        return true;
    } elseif ($fn == 'cat_css') { // weaverx plus compatibility
        weaverx_cat_css($data);
    } elseif ($fn == 'wvrx_css_saved') {
        $GLOBALS['wvrx_css_saved'] .= $data;
    } elseif (function_exists('weaverxplus_f_write')) {
        return weaverxplus_f_write($fn, $data);
    } else {
        return false;
    }
    return true;
}

function weaverx_f_close($fn)
{      // used in Plus
    if ($fn == 'echo' || $fn == 'cat_css' || $fn == 'wvrx_css_saved') {
        return true;
    } elseif (function_exists('weaverxplus_f_close')) {
        return weaverxplus_f_close($fn);
    } else {
        return false;
    }
}

function weaverx_f_delete($fn)
{     // used in Plus
    if ($fn == 'echo') {
        return true;
    }
    if (function_exists('weaverxplus_f_delete')) {
        return weaverxplus_f_delete($fn);
    }

    return false;
}

function weaverx_f_is_writable($fn)
{        // used in Plus
    if ($fn == 'echo') {
        return true;
    }
    if (function_exists('weaverxplus_f_is_writable')) {
        return weaverxplus_f_is_writable($fn);
    }

    return false;
}

function weaverx_f_touch($fn)
{      // used in Plus
    if ($fn == 'echo') {
        return true;
    }
    if (function_exists('weaverxplus_f_touch')) {
        return weaverxplus_f_touch($fn);
    }

    return false;
}

function weaverx_f_mkdir($fn)
{      // used in Plus
    if ($fn == 'echo') {
        return false;
    }
    if (function_exists('weaverxplus_f_mkdir')) {
        return weaverxplus_f_mkdir($fn);
    }

    return false;
}

function weaverx_f_exists($fn)
{      // used in main theme (here!)
    // this one must use native PHP version since it is used at theme runtime as well as admin
    if ($fn == 'echo') {
        return true;
    }
    return @file_exists($fn);
}

function weaverx_f_get_contents($fn)
{    // used in main theme
    if ($fn == 'echo') {
        return '';
    }

    return file_get_contents($fn);      // changed V5.0
}

// =========================== helper functions ===========================
function weaverx_alert($msg)
{
    echo "<script> alert( '" . esc_html($msg) . "' ); </script>";
}

function weaverx_alert_debug($msg)
{
    if (WEAVERX_SHOW_DEBUG)
        echo "<script> alert( '" . esc_html($msg) . "' ); </script>";
}

function weaverx_f_content_dir()
{
    return trailingslashit(WP_CONTENT_DIR);
}

function weaverx_f_plugins_dir()
{
    // delivers appropriate path for using weaverx_f_ functions. WP_PLUGIN_DIR
    return trailingslashit(WP_PLUGIN_DIR);
}

function weaverx_f_themes_dir()
{
    // delivers appropriate path for using weaverx_f_ functions.
    return weaverx_f_content_dir() . 'themes/';
}

function weaverx_f_wp_lang_dir()
{
    // delivers appropriate path for using weaverx_f_ functions. WP_LANG_DIR
    return trailingslashit(WP_LANG_DIR);
}

function weaverx_f_uploads_base_dir()
{
    // delivers appropriate path for using weaverx_f_ functions.
    $upload_dir = wp_upload_dir();

    return trailingslashit($upload_dir['basedir']);
}

function weaverx_f_uploads_base_url()
{
    $wpdir = wp_upload_dir();        // get the upload directory
    return trailingslashit(trim($wpdir['baseurl']));
}

function weaverx_f_wp_filesystem_error()
{
}

function weaverx_f_fail($msg)
{
    weaverx_alert($msg);
    return false;
}

