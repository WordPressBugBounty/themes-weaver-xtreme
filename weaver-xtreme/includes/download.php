<?php
/** PHP 7.4 features added */

// will down load current settings based on db setting
// __ added - 12/11/14

$wp_root = dirname(__FILE__) . '/../../../../';
if (file_exists($wp_root . 'wp-load.php')) {
    require_once($wp_root . "wp-load.php");
} elseif (file_exists($wp_root . 'wp-config.php')) {
    require_once($wp_root . "wp-config.php");
} else {
    exit;
}

function weaverx_filter_strip_default($var): bool
{
    return strlen($var) && $var != 'default';
}

@error_reporting(0);
$weaverx_is_theme = false;

if (isset($_GET['_wpnonce'])) {
    $nonce = $_GET['_wpnonce'];
} elseif (isset($_GET['_wpnoncet'])) {
    $nonce = $_GET['_wpnoncet'];
    $weaverx_is_theme = true;
} else {
    $nonce = '';
}
if (!wp_verify_nonce($nonce, 'weaverx_download')) {
    @header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
    wp_die(esc_html__('Sorry - download must be initiated from admin panel.', 'weaver-xtreme'));
}

if (headers_sent()) {
    @header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
    wp_die(esc_html__('Headers Sent: The headers have been sent by another plugin - there may be a plugin conflict.', 'weaver-xtreme'));
}

$weaverx_opts = weaverx_get_db_options();
$weaverx_header = '';

$weaverx_save = array();

// @@@@@@@  $weaverx_opts['style_version'] = '1';

$weaverx_opts = array_filter($weaverx_opts, 'weaverx_filter_strip_default');

unset($weaverx_opts['wvrx_css_saved']);

$weaverx_save['weaverx_base'] = $weaverx_opts;

$a_pro = (function_exists('weaverxplus_plugin_installed')) ? '-plus' : '';

if ($weaverx_is_theme) {
    $weaverx_header .= 'WXT-V01.00';
    $weaverx_fn = 'weaverx-theme-settings' . $a_pro . '.wxt';
    foreach ($weaverx_opts as $opt => $val) {
        if ($opt[0] == '_') {
            $weaverx_save['weaverx_base'][$opt] = false;
        }
    }
} else {
    $weaverx_header .= 'WXB-V01.00';            /* Save all settings: 10 byte header */
    $weaverx_fn = 'weaverx-backup-settings' . $a_pro . '.wxb';
}

$weaverx_settings = $weaverx_header . serialize($weaverx_save);    /* serialize full set of options right now */

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $weaverx_fn);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . strlen($weaverx_settings));
echo $weaverx_settings;
exit;

