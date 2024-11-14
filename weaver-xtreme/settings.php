<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/* --- MULTI-SITE Control ---
  All non-checkbox options for this theme are filtered based on the 'unfiltered_html' capability,
  so non-admins and non-editors can only add safe html to the various options. It should be
  fairly safe to leave all theme options available on your Multi-site installation. If you want
  to eliminate most of the options that let users enter HTML,
  then set WVRX_MULTISITE_RESTRICT_OPTIONS to true.

  You can uncomment the const WVRX_MULTISITE_RESTRICT_OPTIONS = true;
  ( remove the // in front ) in this file, but that change will be
  overwritten when you update the theme. You can also copy the uncommented line to the wp-config.php
  file for your WP installation ( anywhere before the "That's all, stop editing! Happy blogging." line ),
  and the setting will then survive WP and theme updates.
*/

// const WVRX_MULTISITE_RESTRICT_OPTIONS = true;

/* Version Information */

const WEAVERX_VERSION = '6.7';      // change here, style.css and readme.txt
const WEAVERX_VERSION_ID = 100;
const WEAVERX_THEMENAME = 'Weaver Xtreme'; // do not change in child theme!


//  +++++++++++++++++++++++
const WEAVERX_THEMEVERSION = WEAVERX_THEMENAME . ' ' . WEAVERX_VERSION;
const WEAVERX_MIN_WPVERSION = '6.0';

const WVRX_PAGEBUILDERS = true;    // support for page builders

const WEAVERX_THEME_WIDTH = 1100;    /* manually fix in style-weaverx.css */

const WEAVERX_PHP_MEMORY_LIMIT = 128;

const WEAVERX_DEV_MODE = false;

// if DEV MODE THEN UNCOMMENT FOLLOWING
//const WEAVERX_DEFAULT_THEME_FILE = 'none';

// if NOT DEV MODE THEN UNCOMMENT FOLLOWING
const WEAVERX_DEFAULT_THEME_FILE = '/subthemes/ahead.wxt';

const WEAVERX_DEFAULT_THEME = 'ahead';

/* WARNING: Editing any of the following settings may break the theme, including by child themes */

/* Settings definitions */
const WEAVERX_SETTINGS_VERSION = 'Settings:5.0';   // update settings conversion if change

const WEAVERX_LEVEL_BEGINNER = 1;
const WEAVERX_LEVEL_INTERMEDIATE = 5;
const WEAVERX_LEVEL_ADVANCED = 10;

// Version dependent options for plugin compatibility
// Weaver Xtreme used options

const WEAVER_CUSTOMIZER_TYPE = 'option';   // can't use theme_mod: Legacy Interface uses Options API
const WEAVER_CUSTOMIZER_DEFAULT_INTERFACE = 'where'; // where or what

const WEAVER_GET_OPTION = 'get_option';
const WEAVER_DELETE_OPTION = 'delete_option';
const WEAVER_UPDATE_OPTION = 'update_option';

const WEAVER_SETTINGS_NAME = 'weaverx5_settings';   // IMPORTANT: must also edit customizer-preview.js api()'s to use this value!

// Weaver theme directories and generated files

const WEAVERX_ADMIN_DIR = '/admin';

const WEAVERX_SUBTHEMES_DIR = 'weaverx6-subthemes';
const WEAVERX_STYLE_FILE = 'style-weaverxt.css';

const WEAVERX_OBSOLETE = '* OBSOLETE *';
const WEAVERX_SHOW_DEBUG = false;       // display weaverx_alert_debug()?

const WEAVERX_MINIFY = '.min'; // dev: '', production: '.min'

