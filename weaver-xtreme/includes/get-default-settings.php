<?php
/** PHP 7.4 features added */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!function_exists('weaverx_get_default_settings')) {

    function weaverx_get_default_settings(): bool
    {
        // This function loads the settings for the default theme. None of the settings are saved, so this meets
        // the WP theme requirements of not touching the DB until the user clicks something.

        global $weaverx_opts_cache;
        $weaverx_opts_cache = array();

        // OK, are we running Weaver Xtreme 5 for the first time? See if V4 settings are available.

        $v4opts = get_option('weaverx_settings', array());
        if (!empty($v4opts)) {
            // we have some v4 opts!
            weaverx_clear_opt_cache();
            global $weaverx_opts_cache;
            $weaverx_opts_cache = weaverx_convert4_to_5($v4opts, true);
            return true;
        }

        // read from static file name: WEAVERX_DEFAULT_THEME_FILE -- no user input

        $filename = apply_filters('weaverx_default_subtheme', get_theme_file_path(WEAVERX_DEFAULT_THEME_FILE));

        if (!weaverx_f_exists($filename)) {
            return false;
        }

        $contents = weaverx_f_get_contents($filename);
        if (empty($contents)) {
            return false;
        }

        if (substr($contents, 0, 10) != 'WXT-V01.00' && substr($contents, 0, 10) != 'WVA-V01.00') {
            return false;
        }

        $restore = unserialize(substr($contents, 10));

        $opts = $restore['weaverx_base'];    // fetch base opts
        foreach ($opts as $opt => $val) {
            $weaverx_opts_cache[$opt] = $val;
        }

        return true;
    }
}
