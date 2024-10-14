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
function weaverx_submitted($submit_name)
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
    // customizer only, keep values, preserve values, save values, not legacy ( search terms for these kinds of settings )
    // Legacy Settings Fix
    $non_sapi = apply_filters('weaverx_non_sapi_options',
        array(
            // non-sapi elements in the db
            'weaverx_version_id',
            'style_version',
            'theme_filename',
            'addon_name',
            '_hide_theme_thumbs',
            'm_primary_hamburger',
            'm_secondary_hamburger',
            'font_set_vietnamese',
            'font_set_cryllic',
            'font_set_greek',
            'font_set_hebrew',
            'font_word_spacing_global_dec',
            'font_letter_spacing_global_dec',
            '_options_level',
            '_PHP_warning_displayed',
            'last_option',
            'settings_version',
            /* settings using cz_fonts */
            'wrapper_transform',
            'container_transform',
            'site_title_transform',
            'tagline_transform',
            'header_sb_transform',
            'header_html_transform',
            'm_primary_transform',
            'm_secondary_transform',
            'm_header_mini_transform',
            'm_extra_transform',
            'info_bar_transform',
            'content_transform',
            'page_title_transform',
            'archive_title_transform',
            'content_h_transform',
            'post_transform',
            'post_title_transform',
            'post_info_top_transform',
            'post_info_bottom_transform',
            'primary_transform',
            'secondary_transform',
            'top_transform',
            'bottom_transform',
            'widget_transform',
            'widget_title_transform',
            'footer_transform',
            'footer_sb_transform',
            'footer_html_transform',

            'wrapper_letter_spacing',
            'container_letter_spacing',
            'site_title_letter_spacing',
            'tagline_letter_spacing',
            'header_sb_letter_spacing',
            'header_html_letter_spacing',
            'm_primary_letter_spacing',
            'm_secondary_letter_spacing',
            'm_header_mini_letter_spacing',
            'm_extra_letter_spacing',
            'info_bar_letter_spacing',
            'content_letter_spacing',
            'page_title_letter_spacing',
            'archive_title_letter_spacing',
            'content_h_letter_spacing',
            'post_letter_spacing',
            'post_title_letter_spacing',
            'post_info_top_letter_spacing',
            'post_info_bottom_letter_spacing',
            'primary_letter_spacing',
            'secondary_letter_spacing',
            'top_letter_spacing',
            'bottom_letter_spacing',
            'widget_letter_spacing',
            'widget_title_letter_spacing',
            'footer_letter_spacing',
            'footer_sb_letter_spacing',
            'footer_html_letter_spacing',

            'wrapper_word_spacing',
            'container_word_spacing',
            'site_title_word_spacing',
            'tagline_word_spacing',
            'header_sb_word_spacing',
            'header_html_word_spacing',
            'm_primary_word_spacing',
            'm_secondary_word_spacing',
            'm_header_mini_word_spacing',
            'm_extra_word_spacing',
            'info_bar_word_spacing',
            'content_word_spacing',
            'page_title_word_spacing',
            'archive_title_word_spacing',
            'content_h_word_spacing',
            'post_word_spacing',
            'post_title_word_spacing',
            'post_info_top_word_spacing',
            'post_info_bottom_word_spacing',
            'primary_word_spacing',
            'secondary_word_spacing',
            'top_word_spacing',
            'bottom_word_spacing',
            'widget_word_spacing',
            'widget_title_word_spacing',
            'footer_word_spacing',
            'footer_sb_word_spacing',
            'footer_html_word_spacing',

            'siteorigin_footer_replacement',
            'elementor_footer_replacement',
            'siteorigin_header_replacement',
            'elementor_header_replacement',
            'content_block_margin_B',
            'content_block_margin_T',

            // new options for Weaver Xtreme 6.2

            'font_color_outline',
            'site_title_outline',
            'content_h_outline',
            'page_title_outline',
            'archive_title_outline',
            'post_title_outline',
            'widget_title_outline',

            'm_primary_sub_bgcolor',
            'm_primary_grid_cols',
            'm_primary_grid_gap',
            'm_primary_grid_align',
            'm_primary_grid_top_margin',
            'm_primary_grid_tb_padding',
            'm_primary_grid_lr_padding',
            'm_primary_grid_lr_padding',
            'm_primary_grid_tb_padding',

            'm_secondary_sub_bgcolor',
            'm_secondary_grid_cols',
            'm_secondary_grid_gap',
            'm_secondary_grid_align',
            'm_secondary_grid_top_margin',
            'm_secondary_grid_tb_padding',
            'm_secondary_grid_lr_padding',
            'm_secondary_grid_lr_padding',
            'm_secondary_grid_tb_padding',

            'theme_css_vers'
        ));

    /*	The following code allows the SAPI to save the non-sapi values. If you don't do this here,
        then the values will be set to false, and be lost! SAPI is not tolerant of submitting a form
        that doesn't include EVERY setting for the form group. */

    weaverx_setopt('last_option', WEAVERX_THEMENAME);    // Safety check for limited PHP $_POST variables
    foreach ($non_sapi as $fname) {
        ?>
        <input name="<?php weaverx_sapi_main_name($fname); ?>"
               id="<?php echo $fname; ?>"
               type="hidden"
               value="<?php echo weaverx_getopt($fname); ?>"/>
        <?php
    }
    echo("</form> <!-- $form_name -->\n");
}

function weaverx_sapi_submit($before = '', $after = '', $show_more_opts = false): void
{
// generate a submit button for the form
    $submit_label = esc_html__('Save Settings', 'weaver-xtreme');

    echo $before . "<span style='display:inline;'><input name='save_options' type='submit' style='margin-top:10px;' class='button-primary' value='{$submit_label}' />" . "</span>" . $after;

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

    /* validation for all options  */
    $err_msg = '';            // no error message yet

    if (empty($in)) {
        wp_die(esc_html__('You attempted to save options, but something has gone wrong. Please be sure you are logged in and your host is correctly configured. See the "Weaver Doesn\'t Save Settings" FAQ on weavertheme.com.', 'weaver-xtreme'));
    }

    if (!current_user_can('edit_theme_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to manage options for this site.', 'weaver-xtreme'));
    }


    $wvr_last = '';

    foreach ($in as $key => $value) {
        //$cur_key = $key;
        switch ($key) {

            /* -------- integer -------- */
            case 'excerpt_length':

                if (!empty($value) && (!is_numeric($value) || !is_int(( int )$value))) {
                    $opt_id = str_replace('', '', $key);
                    $opt_id = str_replace('_', ' ', $opt_id);
                    $err_msg .= esc_html__('Option must be an integer value: ', 'weaver-xtreme') . '"' . $opt_id . '" = "' . $value . '".'
                        . esc_html__(' Value has been cleared to blank value', 'weaver-xtreme') . '<br />';
                    $in[$key] = '';
                }
                break;

            /* ---------- text ----------- */
            case 'excerpt_more_msg':
            case 'header_maxwidth':

                if (!empty($value)) {
                    $in[$key] = wp_kses_post($value);
                }
                break;

            case 'themename':       // can't be empty!
                if (empty($value)) {
                    $in[$key] = 'please-give-this-a-name';
                } else {
                    $in[$key] = wp_kses_post($value);
                }
                break;


            /* code */
            case 'copyright':        // Alternate copyright
            case '_css_rows':
                if (!empty($value)) {
                    $in[$key] = weaverx_filter_code($value);
                }
                break;


            case '_perpagewidgets':        // Add widget areas for per page - names must be lower case
                if (!empty($value)) {
                    $in[$key] = strtolower(str_ireplace(' ', '', weaverx_filter_code($value)));
                }
                break;

            case '_althead_opts':
            case 'head_opts':
                if (!empty($value)) {
                    $in[$key] = weaverx_filter_head($value);
                }
                break;

            case 'wvrx_css_saved':
                if (!empty($value)) {
                    $in[$key] = weaverx_filter_code($value);
                }
                break;


            /* must not have <style .... </style> */
            case 'add_css':                // Add CSS Rules to Weaver Xtreme's style rules

                if (!empty($value)) {
                    $val = weaverx_filter_code($value);
                    $in[$key] = $val;
                    if (stripos($val, '<style') !== false || stripos($val, '</style') !== false ||
                        stripos($val, '<script') !== false || stripos($val, '</script') !== false) {
                        $err_msg .= esc_html__('&lt;style&gt; or &lt;script&gt; tags have been automatically stripped from your "Add CSS Rules"!', 'weaver-xtreme')
                            . ' ' . esc_html__('Please correct your entry.', 'weaver-xtreme') . '<br />';
                        $in[$key] = wp_filter_post_kses(trim(stripslashes($val)));
                    }
                }
                break;

            case '_fonts_google':
                $in[$key] = $value;
                break;

            case 'last_option':        // check for last_option...
                if (!empty($value)) {
                    $wvr_last = $value;
                }
                break;

            default:                /* to here, then colors, _css, or checkbox/selectors */
                $keylen = strlen($key);

                if (strrpos($key, '_css') == $keylen - 4) {    // all _css settings
                    if (!empty($value)) {
                        $val = weaverx_filter_code($value);
                        if (stripos($val, '<style') !== false || stripos($val, '</style') !== false ||
                            stripos($val, '<script') !== false || stripos($val, '</script') !== false) {
                            $err_msg .= esc_html__('&lt;style&gt; or &lt;script&gt; tags have been automatically stripped from your CSS+ rules,', 'weaver-xtreme')
                                . ' ' . esc_html__('Please correct your entry.', 'weaver-xtreme') . '<br />';
                            $val = wp_filter_post_kses(trim($val));
                        }

                        $in[$key] = $val;

                        if (strpos($val, '{') === false || strpos($val, '}') === false) {
                            $opt_id = str_replace('_css', '', $key);    // kill _css
                            $opt_id = str_replace('', '', $opt_id);
                            $opt_id = str_replace('_', ' ', $opt_id);
                            $err_msg .= esc_html__('CSS options must be enclosed in {}\'s: ', 'weaver-xtreme') . '"' . $opt_id . '" = "' . $value . '". '
                                . esc_html__('Please correct your entry.', 'weaver-xtreme') . '<br />';
                        }
                    }
                    break;
                } // _css

                if (strrpos($key, '_insert') == $keylen - 7) {    // all _insert settings
                    if (!empty($value)) {
                        $val = weaverx_filter_code($value);
                        $in[$key] = $val;
                    }
                    break;
                } // _insert

                if (strrpos($key, '_url') == $keylen - 4) {    // all _url settings
                    if (!empty($value)) {
                        $val = weaverx_filter_code($value);    // can't use esc_url because that forces a leading html{background-image: url( %template_directory%assets/images/addon_themes.png );}
                        $in[$key] = $val;
                    }
                    break;
                } // _insert

                if (strrpos($key, '_dec') == $keylen - 4) {
                    if (!empty($value) && !is_numeric($value)) {
                        $opt_id = str_replace('', '', $key);
                        $opt_id = str_replace('_dec', '', $opt_id);
                        $opt_id = str_replace('_', ' ', $opt_id);
                        $err_msg .= esc_html__('Option must be a numeric value: ', 'weaver-xtreme') . '"' . $opt_id . '" = "' . $value . '". '
                            . esc_html__('Value has been cleared to blank value.', 'weaver-xtreme') . '<br />';
                        $in[$key] = '';
                    }
                    break;
                }

                if (strrpos($key, '_int') == $keylen - 4 ||    // _int settings
                    strrpos($key, '_X') == $keylen - 2 ||
                    strrpos($key, '_Y') == $keylen - 2 ||
                    strrpos($key, '_L') == $keylen - 2 ||
                    strrpos($key, '_R') == $keylen - 2 ||
                    strrpos($key, '_T') == $keylen - 2 ||
                    strrpos($key, '_B') == $keylen - 2) {
                    if (!empty($value) && (!is_numeric($value) || !is_int(( int )$value))) {
                        $opt_id = str_replace('', '', $key);
                        $opt_id = str_replace('_int', '', $opt_id);
                        $opt_id = str_replace('_', ' ', $opt_id);
                        $err_msg .= esc_html__('Option must be a numeric value: ', 'weaver-xtreme') . '"' . $opt_id . '" = "' . $value . '". '
                            . esc_html__('Value has been cleared to blank value.', 'weaver-xtreme') . '<br />';
                        $in[$key] = '';
                    }
                    break;
                }

                if (strrpos($key, 'color') == $keylen - 5) {    // _bgcolor and _color ( order here important - after _css, etc. )
                    if (!empty($value)) {

                        $val = trim(weaverx_filter_code($value));
                        if (preg_match('/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $val)) {    // hex value
                            $val = strtoupper($val);        // force hex values to upper case, just to be tidy
                            if ($val[0] != '#') {
                                $val = '#' . $val;
                            }
                            $in[$key] = $val;
                        } elseif (preg_match("/^([a-zA-Z])+$/i", $val)) {    // name - all letters
                            $in[$key] = $val;
                        } else {        // only legal things left are rgb and rgba
                            $isrgb = strpos($val, 'rgb');
                            $ishsa = strpos($val, 'hsl');
                            if ($isrgb === false && $ishsa === false) {
                                if ($value == ' ') {
                                    $in[$key] = '';
                                } else {
                                    $err_msg .= esc_html__('Color must be a valid # hex value, rgb value, or color name ( a-z ): ', 'weaver-xtreme') .
                                        '"' . $key . '" = "' . bin2hex($value) . '". (' . $val . ')' .
                                        esc_html__('Value has been cleared to blank value.', 'weaver-xtreme') . '<br />';
                                }
                                $in[$key] = '';
                            } else {
                                $in[$key] = $val;
                            }
                        }
                    }
                    break;
                }

                if (!empty($value) && is_string($value) && !is_numeric($value)) {
                    $in[$key] = weaverx_filter_textarea($value);
                }

                break;
        }
    }

    if ($wvr_last != 'Weaver Xtreme' && $wvr_last != WEAVERX_VERSION && $wvr_last != '4.2' && $wvr_last != WEAVERX_THEMENAME) {
        $vars = ini_get('max_input_vars');
        $newvars = $vars + 1000;
        $posts = isset($GLOBALS['WVRX_POSTS']) ? $GLOBALS['WVRX_POSTS'] : '?';
        $gets = isset($GLOBALS['WVRX_GETS']) ? $GLOBALS['WVRX_GETS'] : '?';
        $cookies = isset($GLOBALS['WVRX_COOKIES']) ? $GLOBALS['WVRX_COOKIES'] : '?';

        $msg = wp_kses_post(sprintf(
            __("<h3 style='color:red;text-align:center;'>WARNING - Your current settings have NOT been saved!<br /> Your previous settings are unchanged.</strong>
</h3><p>Your host seems to be configured to limit how many input form options you are allowed to use with PHP. This is usually controlled by the PHP <em>max_input_vars</em> configuration setting. The current value of <em> %1\$s </em> is too small for your current <em>WordPress</em> and <em>Weaver Xtreme</em> installation. It should be increased to <em> %2\$s </em>. <strong>Until you increase the value, you cannot save your Weaver Xtreme settings using the Legacy Interface.</strong> The <em>Customizer</em> will still work, as will the options on the <em>Save/Restore</em> tab. Your site is still functional.
</p><p style='text-align:center;font-weight:bold;padding:1em;border:1px solid black;'>
For help on how to increase the <em>max_input_vars</em> PHP setting, please click to see the
<a href='//guide.weavertheme.com/host-configuration-php-max_input_vars/' target='_blank'>Host&nbsp;Configuration:&nbsp;PHP&nbsp; max_input_vars</a> article on the Weaver Xtreme guide site.</p>
<p style='color:blue;font-weight:bold;text-align:center;'>
PLEASE USE THE BROWSER BACK BUTTON TO RETURN TO WP ADMIN.</p><p><small>Code: V-%3\$s/P-%4\$s/G-%5\$s/C-%6\$s/K-%7\$s/L-%8\$s </small></p>", 'weaver-xtreme'),
            $vars, $newvars, $vars, $posts, $gets, $cookies, $key, $wvr_last));
        wp_die($msg);
    }


    if (!empty($err_msg)) {
        add_settings_error(WEAVER_SETTINGS_NAME, 'settings_error', 'ERROR: ' . $err_msg, 'error');
    } else {
        add_settings_error(WEAVER_SETTINGS_NAME, 'settings_updated', esc_html__('Weaver Xtreme Settings Saved.', 'weaver-xtreme'), 'updated');
    }

    return $in;
}

// ========================== utils ==================================

function weaverx_end_of_section($who = ''): void
{
    echo '<hr />';
    $tname = weaverx_getopt('themename');
    if (!$tname) {
        $tname = esc_html__('Please set theme name on the Advanced Options &rarr; Admin Options tab.', 'weaver-xtreme');
    }
    $local_mem_lim = ini_get('memory_limit');
    $server_mem_lim = get_cfg_var('memory_limit');

    echo esc_html(sprintf(__('%1$s %2$s | Options Version: %3$s | Subtheme: %4$s | PHP Memory Limit: Local - %5$s / Server - %6$s', 'weaver-xtreme'), WEAVERX_THEMENAME, WEAVERX_VERSION, weaverx_getopt('style_version'), $tname, $local_mem_lim, $server_mem_lim));
    echo "\n";

    $last = weaverx_getopt('last_option');
    if ($last != WEAVERX_THEMENAME && $last != 'Weaver Xtreme') // check for case of limited PHP $_POST values
    {
        ?>
        <?php wp_kses_post(__("<p>Please open the Weaver Xtreme admin page again to synchronize theme settings. If you continue to see this message, please contact us on the support forum at https://forum.weavertheme.com for help.</p>", 'weaver-xtreme'));
    }

}

function weaverx_donate_button(): void
{

    if (!weaverx_getopt_checked('_hide_donate') && !function_exists('weaverxplus_plugin_installed')) {
        $img = WP_CONTENT_URL . '/themes/weaver-xtreme/assets/images/donate-button.png';
        ?>
        <div style="float:right;padding-right:30px;display:inline-block;">
            <div style="font-size:14px;font-weight:bold;display:inline-block;vertical-align: top;"><?php echo wp_kses_post(__('Like <em>Weaver Xtreme</em>? Please', 'weaver-xtreme')); ?></div>&nbsp;&nbsp;<a
                    href='//weavertheme.com/donate' target='_blank' alt='Please Donate'><img src="<?php echo $img; ?>"
                                                                                             alt="donate"
                                                                                             style="max-height:28px;"/></a>
        </div>

    <?php }
}


function weaverx_clear_messages(): void
{
    ?>
    <form style="float:right;margin-right:15px;"
          name="clearweaverx_form"
          method="post">
        <?php
        if (!function_exists('weaverxplus_plugin_installed')) {
            echo '<strong style="border:1px solid blue;background:yellow;padding:4px;margin:5px;">';
            weaverx_site('', '//plus.weavertheme.com/', esc_html__('Weaver Xtreme Plus', 'weaver-xtreme'));
            echo esc_html__('Get Weaver Xtreme Plus!', 'weaver-xtreme') . '</a> </strong>';
        }

        do_action('weaverx_check_licenses');

        ?>
        <span class="submit"><input
                    class="button-primary"
                    type="submit"
                    name="weaverx_clear_messages"
                    value="<?php echo esc_attr__('Clear Messages', 'weaver-xtreme'); ?>"/></span>
        <?php weaverx_nonce_field('weaverx_clear_messages'); ?>
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

        /* serialize full set of options right now */
    } else {
        $header = 'WXB-V01.00';            /* Save all settings: 10 byte header */
        $theme_opts = array();
        $theme_opts['weaverx_base'] = $weaverx_opts_cache;

        /* serialize full set of options right now */
    }
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
            weaverx_alert(sprintf(esc_html__('           ***** CRITICAL WARNING ******\r\n\r\nYou have an old version of the Weaver Xtreme Theme Support plugin Installed ( %s ).\r\n\r\nIt is VERY IMPORTANT that you update to the latest version from the WordPress Plugins Update notice! Your site may not display properly with the old version.\r\n\r\nThis notice will continue to appear until you update the Weaver Xtreme Support plugin.', 'weaver-xtreme'), WEAVERX_TSL_VERSION));
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

function weaverx_2_add_fonts($fonts)
{
    // this code adds all the new Google Fonts to the Legacy plugin Font picker.
    $base = array(
        array('val' => 'inherit', 'desc' => esc_html__('Inherit', 'weaver-xtreme')),
        array('val' => 'open-sans', 'desc' => esc_html__('Open Sans', 'weaver-xtreme')),
        array('val' => 'open-sans-condensed', 'desc' => esc_html__('Open Sans Condensed', 'weaver-xtreme')),
        array('val' => 'alegreya-sans', 'desc' => esc_html__('Alegreya Sans', 'weaver-xtreme')),
        array('val' => 'alegreya-sans-sc', 'desc' => esc_html__('Alegreya Sans SC', 'weaver-xtreme')),
        array('val' => 'archivo-black', 'desc' => esc_html__('Archivo Black', 'weaver-xtreme')),
        array('val' => 'arimo', 'desc' => esc_html__('Arimo', 'weaver-xtreme')),
        array('val' => 'droid-sans', 'desc' => esc_html__('Droid Sans', 'weaver-xtreme')),
        array('val' => 'exo-2', 'desc' => esc_html__('Exo 2', 'weaver-xtreme')),
        array('val' => 'lato', 'desc' => esc_html__('Lato', 'weaver-xtreme')),
        array('val' => 'roboto', 'desc' => esc_html__('Roboto', 'weaver-xtreme')),
        array('val' => 'roboto-condensed', 'desc' => esc_html__('Roboto Condensed', 'weaver-xtreme')),
        array('val' => 'source-sans-pro', 'desc' => esc_html__('Source Sans Pro', 'weaver-xtreme')),

        //'serif-g' => esc_html__( '--- -- Serif Google Fonts --', 'weaver-xtreme' ),
        array('val' => 'alegreya', 'desc' => esc_html__('Alegreya (Serif)', 'weaver-xtreme')),
        array('val' => 'alegreya-sc', 'desc' => esc_html__('Alegreya SC', 'weaver-xtreme')),
        array('val' => 'arvo', 'desc' => esc_html__('Arvo Slab', 'weaver-xtreme')),
        array('val' => 'droid-serif', 'desc' => esc_html__('Droid Serif', 'weaver-xtreme')),
        array('val' => 'lora', 'desc' => esc_html__('Lora', 'weaver-xtreme')),
        array('val' => 'roboto-slab', 'desc' => esc_html__('Roboto Slab', 'weaver-xtreme')),
        array('val' => 'source-serif-pro', 'desc' => esc_html__('Source Serif Pro', 'weaver-xtreme')),
        array('val' => 'tinos', 'desc' => esc_html__('Tinos', 'weaver-xtreme')),
        array('val' => 'vollkorn', 'desc' => esc_html__('Vollkorn', 'weaver-xtreme')),
        array('val' => 'ultra', 'desc' => esc_html__('Ultra Black', 'weaver-xtreme')),

        //'mono-g' => esc_html__( '--- -- Monospace Google Fonts --', 'weaver-xtreme' ),

        array('val' => 'inconsolata', 'desc' => esc_html__('Inconsolata (Mono)', 'weaver-xtreme')),
        array('val' => 'roboto-mono', 'desc' => esc_html__('Roboto Mono', 'weaver-xtreme')),

        //'cursive-g' => esc_html__( '--- -- "Cursive" Google Fonts --', 'weaver-xtreme' ) ),

        array('val' => 'handlee', 'desc' => esc_html__('Handlee (Cursive)', 'weaver-xtreme')),
    );


    if (!empty($fonts)) {               // this merge is for Plus V4 compatibility
        unset($fonts[0]);
    }    // kill original 'default'

    return array_merge($base, $fonts);    // put the new fonts at the top


}

add_filter('weaverx_add_font_family', 'weaverx_2_add_fonts');

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
