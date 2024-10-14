<?php
/** PHP 7.4 features added */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/*	Weaver Xtreme Theme

  This file contains the functions needed to interact with the different
  options and settings in both the core admin page, and on the sapi options from
  the Weaver Xtreme Theme Support plugin.

  Options are saved in the WP DB in one option called 'weaverx_main_settings'.

	This file includes the interface to the WP Settings API.

   Because the SAPI is quite limiting on the format of the output fields
   supported by add_settings_field, we will not use that part.

   Settings that need validation and nonce handling, we use our function weaverx_sapi_main_name() that
   generates the <input name="weaverx_main_settings[option_name]" ...> format required for
   processing by the sapi handlers. They create an array called $_POST['weaverx_main_settings']. Each
   setting in that array corresponds to a Weaver Xtreme option value, and will be passed to the
   validation function.

   We will wrap the main form ( Main Options ) with our functions
   weaverx_sapi_form_top() and weaverx_sapi_form_bottom() that generates required calls to sapi.

   All other forms will use submit buttons that include their own nonce definition. Other forms generally
   do not change individual settings, but take actions such as save/restore or setting a subtheme.
*/

// # RUNTIME SAPI HELPER FUNCTIONS ============================================

function weaverx_sapi_options_init(): void
{
    /* this will initialize the SAPI stuff, must be called from the admin_init cb function .
    In reality, we really only need to register one setting - 'weaverx_main_settings_group',
    and the settings will be saved in the WP DB as 'weaverx_main_settings'. The SAPI uses
    the name param of any <input> fields to figure out where to store the input value.

    The validation will have to scan the ENTIRE list of options and lookup the kind of
    validation each parameter needs.

    NOTE: This code is here to support Legacy Weaver Xtreme Theme options settings.
    Version 2.0 does not use or call these validation functions directly, but the are needed
    to support the legacy options interface.
    */
    //@@@dev weaverx_alert('weaverx_sami_options_init');

    register_setting('weaverx_settings_group',    /* the group name of our settings */
        apply_filters('weaverx_options', WEAVER_SETTINGS_NAME),    /* the get_option name */
        'weaverx_validate_cb');            /* a validation call back */
}

function weaverx_validate_cb($in)
{
    return weaverx_validate_all_options($in);
}

/*
	================= nonce helpers =====================
*/
function weaverx_submitted($submit_name): bool
{
    // do a nonce check for each form submit button
    // pairs 1:1 with weaverx_nonce_field
    $nonce_act = $submit_name . '_act';
    $nonce_name = $submit_name . '_nonce';

    if (isset($_POST[$submit_name])) {
        if (isset($_POST[$nonce_name]) && wp_verify_nonce($_POST[$nonce_name], $nonce_act)) {
            return true;
        } else {
            die(esc_html__('WARNING: invalid form submit detected. Probably caused by session time-out, or, rarely, a failed security check. Please contact WeaverTheme.com if you continue to receive this message.', 'weaver-xtreme') . '(' . $submit_name . ')');
        }
    } else {
        return false;
    }
}

function weaverx_nonce_field($submit_name, $echo = true): string
{
    // pairs 1:1 with submitted
    // will be one for each form submit button

    return wp_nonce_field($submit_name . '_act', $submit_name . '_nonce', $echo);
}

/*
	================= Main SAPI helper functions =================
*/

function weaverx_sapi_form_top($group, $form_name = ''): void
{
    /* beginning of a form */
    $name = '';
    if ($form_name != '') {
        $name = 'name="' . $form_name . '"';
    }

    echo("<form action=\"options.php\" $name method=\"post\">\n");    /* <form action="options.php" method="post"> */
    settings_fields($group);        // use our one set of settings
}

function weaverx_sapi_form_bottom($form_name = 'end of form'): void
{
    // Customizer only version (support plugin not installed) does not need these, but leave for symmetry
    $non_sapi = apply_filters('weaverx_non_sapi_options',
        array(// non-sapi elements in the db


        ));

    /*	The following code allows the SAPI to save the non-sapi values. If you don't do this here,
        then the values will be set to false, and be lost! SAPI is not tolerant of submitting a form
        that doesn't include EVERY setting for the form group. */

    weaverx_setopt('last_option', WEAVERX_THEMENAME);    // Safety check for limited PHP $_POST variables

    foreach ($non_sapi as $name) {
        ?>
        <input name="<?php weaverx_sapi_main_name($name); ?>" id="<?php echo $name; ?>"
               type="hidden" value="<?php echo weaverx_getopt($name); ?>"/>
        <?php
    }
    echo("</form> <!-- $form_name -->\n");
}

function weaverx_sapi_submit($before = '', $after = '', $show_more_opts = false): void
{
// generate a submit button for the form
    $submit_label = esc_html__('-Save Settings!-', 'weaver-xtreme');

    echo $before . printf("<span style='display:inline;'><input name='save_options' type='submit' style='margin-top:10px;' class='button-primary' value='$submit_label' />" . "</span>\n") . $after;

}

function weaverx_form_submit($value): void
{
    weaverx_sapi_submit('</table>', '<table style="margin-top:10px;">');
}

function weaverx_sapi_main_name($id, $echo = true): string
{
    /* generate the SAPI name for WEAVER_SETTINGS_NAME */
    $name = apply_filters('weaverx_options', WEAVER_SETTINGS_NAME);
    if ($echo) {
        echo $name . '[' . $id . ']';
    }

    return $name . '[' . $id . ']';
}

/*
	============== Validation =====================
*/
function weaverx_validate_all_options($in)
{

    if (function_exists('wvrx_ts_installed')) {
        return weaverx_validate_all_options_ts();
    }   // theme support has full options

    /* validation for all options  */

    if (empty($in)) {
        wp_die(esc_html__('You attempted to save options, but something has gone wrong. Please be sure you are logged in and your host is correctly configured. See the "Weaver Doesn\'t Save Settings" FAQ on weavertheme.com.', 'weaver-xtreme'));
    }

    if (!current_user_can('edit_theme_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to manage options for this site.', 'weaver-xtreme'));
    }

    return $in;
}

// ========================== utils ==================================

function weaverx_end_of_section($who = ''): void
{
    echo '<hr />';
    $name = weaverx_getopt('themename');
    if (!$name) {
        $name = esc_html__('Please set theme name on the Advanced Options &rarr; Admin Options tab.', 'weaver-xtreme');
    }
    $local_mem_lim = ini_get('memory_limit');
    $server_mem_lim = get_cfg_var('memory_limit');

    echo wp_kses_post(sprintf(__('%1$s %2$s | Options Version: %3$s | Subtheme: %4$s | PHP Memory Limit: Local - %5$s / Server - %6$s', 'weaver-xtreme'), WEAVERX_THEMENAME, WEAVERX_VERSION, weaverx_getopt('style_version'), $name, $local_mem_lim, $server_mem_lim));
    echo "\n";

    $last = weaverx_getopt('last_option');
    if ($last != WEAVERX_THEMENAME && $last != 'Weaver Xtreme') // check for case of limited PHP $_POST values
    {
        ?>
        <?php echo wp_kses_post(__("<p>Please open the Weaver Xtreme admin page again to synchronize theme settings. If you continue to see this message, please contact us on the support forum at https://forum.weavertheme.com for help.</p>", 'weaver-xtreme'));
    }

}

function weaverx_donate_button(): void
{

    if ( ! weaverx_getopt_checked( '_hide_donate' ) && ! function_exists( 'weaverxplus_plugin_installed' ) ) {
        $img = WP_CONTENT_URL . '/themes/weaver-xtreme/assets/images/donate-button.png';
        ?>
        <div style="float:right;padding-right:30px;display:inline-block;">
            <div style="font-size:14px;font-weight:bold;display:inline-block;vertical-align: top;"><?php echo wp_kses_post( __( 'Like <em>Weaver Xtreme</em>? Please', 'weaver-xtreme' ) ); ?></div>&nbsp;&nbsp;<a href='//weavertheme.com/donate' target='_blank' alt='Please Donate'><img src="<?php echo $img; ?>" alt="donate" style="max-height:28px;"/></a>
        </div>

    <?php }
}


function weaverx_clear_messages(): void
{
    ?>
    <form style="float:right;margin-right:15px;" name="clearweaverx_form" method="post">
        <?php
        if ( ! function_exists( 'weaverxplus_plugin_installed' ) ) {
            echo '<strong style="border:1px solid blue;background:yellow;padding:4px;margin:5px;">';
            weaverx_site( '', '//plus.weavertheme.com/', esc_html__( 'Weaver Xtreme Plus', 'weaver-xtreme' ) );
            echo esc_html__( 'Get Weaver Xtreme Plus!', 'weaver-xtreme' ) . '</a> </strong>';
        }
        do_action( 'weaverx_check_licenses' );

        ?>
        <span class="submit"><input class="button-primary" type="submit" name="weaverx_clear_messages" value="<?php echo esc_attr__( 'Clear Messages', 'weaver-xtreme' ); ?>"/></span>
        <?php weaverx_nonce_field( 'weaverx_clear_messages' ); ?>
    </form> <!-- resetweaverx_form -->
    <?php
}

function weaverx_abs_file_path($http_path): string
{
    return untrailingslashit(ABSPATH) . parse_url($http_path, PHP_URL_PATH);
}

/*
	==================== SAVE / RESTORE THEMES AND BACKUPS ==========================
*/
function weaverx_get_save_settings($is_theme): string
{
    // serialize current settings
    global $weaverx_opts_cache;

    weaverx_update_options('write_backup');

    if ($is_theme) {
        $header = 'WXT-V01.00';            /* Save theme settings: 10 byte header */
        $theme_opts = array();
        $theme_opts['weaverx_base'] = $weaverx_opts_cache;
        foreach ($weaverx_opts_cache as $opt => $val) {
            if ($opt[0] == '_') {
                $theme_opts['weaverx_base'][$opt] = false;
            }
        }
    } else {
        $header = 'WXB-V01.00';            /* Save all settings: 10 byte header */
        $theme_opts = array();
        $theme_opts['weaverx_base'] = $weaverx_opts_cache;

    }
    /* serialize full set of options right now */
    return $header . serialize($theme_opts);
}

function weaverx_clear_cache_settings(): void
{
    /* clear all settings */
    global $weaverx_opts_cache;
    foreach ($weaverx_opts_cache as $key => $value) {
        $weaverx_opts_cache[$key] = false;        // clear everything
    }
}

function weaverx_save_msg($msg): void
{
    echo '<div id="message" class="updated fade"><p><strong>' . $msg .
        '</strong></p></div>';
}

function weaverx_error_msg($msg): void
{
    echo '<div id="message" class="updated fade" style="background:#F88;"><p><strong>' . $msg .
        '</strong></p></div>';
}

function weaverx_check_support_plugin_version(): void
{
    if (function_exists('wvrx_ts_installed')) {
        if (defined('WEAVERX_TSL_VERSION') && version_compare(WEAVERX_TSL_VERSION, '3.9', '<')) {
            weaverx_alert(esc_html(sprintf(__('           ***** CRITICAL WARNING ******\r\n\r\nYou have an old version of the Weaver Xtreme Theme Support plugin Installed ( %s ).\r\n\r\nIt is VERY IMPORTANT that you update to the latest version from the WordPress Plugins Update notice! Your site may not display properly with the old version.\r\n\r\nThis notice will continue to appear until you update the Weaver Xtreme Support plugin.', 'weaver-xtreme'), WEAVERX_TSL_VERSION)));
        }
    }
}


function weaverx_elink($href, $title, $label, $before = '', $after = ''): void
{
    echo $before . '<a href="' . esc_url($href) . '" title="' . $title . '">' . $label . '</a>' . $after;
}

function weaverx_tab_title($title, $help_link, $help_title): void
{
    echo '<h3>' . $title;
    weaverx_help_link($help_link, $help_title);
    echo '</h3>';
}


if (!function_exists('weaverx_options_level')) :
    function weaverx_options_level()
    {    // current options level value
        global $wp_customize;

        if (isset($wp_customize) && !$wp_customize->is_theme_active()) {
            return WEAVERX_LEVEL_BEGINNER;
        } else {
            return get_theme_mod('_options_level', '');
        }
    }
endif;

?>
