<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/* Weaver Xtreme - admin Help
 *
 * This is the intro form. It won't have any options because it will be outside the main form
 */

function weaverx_admin_help(): void
{
    ?>
    <h2><?php esc_html_e('Weaver Xtreme Help', 'weaver-xtreme'); ?></h2>
    <p>
        <?php esc_html_e('This is the Weaver Xtreme Admin help button: ', 'weaver-xtreme'); ?>
        <?php weaverx_help_link('help.html#top', esc_html__('Weaver Xtreme Help', 'weaver-xtreme')); ?>
        &nbsp;&nbsp;
        <?php esc_html_e('Clicking the ? will open the Weaver Xtreme Help document.', 'weaver-xtreme');
        if (!defined('WVRX_TS_VERSION')) {
            $version = esc_html__('Not Installed', 'weaver-xtreme');
        } else {
            $version = WVRX_TS_VERSION;
        }
        echo '<br>&nbsp;&nbsp;&nbsp;' . esc_html__('Weaver Xtreme Support Plugin Version: ', 'weaver-xtreme') . $version . '</br>';

        ?>
    </p>

    <h2>
        <?php esc_html_e('Please see our active ', 'weaver-xtreme'); ?>
        <?php weaverx_site('', '//forum.weavertheme.com/', esc_html__('Weaver Support Forum', 'weaver-xtreme')); ?>
        <?php esc_html_e('Support Forum for online help.', 'weaver-xtreme'); ?>
    </h2>
    <br/>
    <?php
    do_action('weaverxplus_admin', 'help');
    ?>
    <div style="float:left;width:50%;padding-right:2%">
        <div class="atw-help">

            <p style="color:red;font-weight:bold;">
                <?php esc_html_e("Please note - many of the following help documents date back to older versions of Weaver Xtreme, and may be somewhat outdated or incomplete. They have been retained because they are still useful.", 'weaver-xtreme'); ?>
            </p>

            <h2>
                <?php
                esc_html_e('Please see the ', 'weaver-xtreme');
                weaverx_site('', '//guide.weavertheme.com/', esc_html__('Weaver Xtreme Guide', 'weaver-xtreme'));
                esc_html_e('Online Guide for complete online theme reference.', 'weaver-xtreme');
                ?>
            </h2>
            <p>
                <?php echo wp_kses_post(__('Extensive and searchable online guide for <em>Weaver Xtreme</em>. The best reference for Weaver Xtreme.', 'weaver-xtreme')); ?>
            </p>
            <h2 style="text-decoration:underline;font-weight:bold;">
                <?php weaverx_help_link('help.html', esc_html__('Weaver Xtreme Help', 'weaver-xtreme'), esc_html__('Theme Documentation (Customizer)', 'weaver-xtreme')); ?>
            </h2>
            <p>
                <?php esc_html_e('Complete documentation for using the Weaver Xtreme Theme and the Customizer option interface.', 'weaver-xtreme'); ?>
            </p>

            <h2 style="text-decoration:underline;font-weight:bold;">
                <?php weaverx_help_link('legacy-help.html', esc_html__('Weaver Xtreme Help', 'weaver-xtreme'), esc_html__('Theme Documentation (Legacy Admin)', 'weaver-xtreme')); ?>
            </h2>
            <p>
                <?php esc_html_e('Complete documentation for using the Weaver Xtreme Theme with the Legacy options interface.', 'weaver-xtreme'); ?>
            </p>


            <h2 style="text-decoration:underline;font-weight:bold;">
                <?php weaverx_help_link('css-help.html', esc_html__('Weaver CSS Help', 'weaver-xtreme'), esc_html__('CSS HELP', 'weaver-xtreme')); ?>
            </h2>
            <p>
                <?php esc_html_e('A short CSS Tutorial', 'weaver-xtreme'); ?>
            </p>
            <h2 style="text-decoration:underline;font-weight:bold;">
                <?php weaverx_help_link('font-demo.html', esc_html__('Examples of supported fonts', 'weaver-xtreme'), esc_html__('Font Examples', 'weaver-xtreme')); ?>
            </h2>
            <p>
                <?php
                esc_html_e('Example of Font Families supported by Weaver Xtreme and Weaver Xtreme Plus.', 'weaver-xtreme');
                // Following Release Notes are not wrapped in translation as they are highly variable, and will
                // change with each update of the theme - even minor updates. Just doesn't make sense to translate them.
                ?>
            </p>

            <h3 style="text-decoration:underline;font-weight:bold;">
                <?php esc_html_e('Release Notes', 'weaver-xtreme'); ?>
            </h3>
            <p>
                <em>Please scroll to the end of the release notes to view latest changes.</em>
            </p>
            <?php
            $notes = weaverx_relative_url('') . '/readme.txt';
            ?>
            <p>
            <h3><a href="<?php echo esc_url($notes); ?>" target="_blank">Click here to view most
                    recent release notes.</a></h3>
            </p>

        </div>
    </div>
    <div style="float:right;width:40%;padding-right:1%">

        <h2><b><?php esc_html_e('RECOMMENDED PLUGINS', 'weaver-xtreme'); ?></b></h2>
        <p><strong>
                <?php esc_html_e('Some recommended plugins to use with your Weaver Xtreme Theme', 'weaver-xtreme'); ?>
            </strong></p>
        <ul>
            <li style="font-size:120%;"><a href="//wordpress.org/plugins/weaverx-theme-support/"
                                           target="_blank"><?php esc_html_e('Weaver Xtreme Theme Support', 'weaver-xtreme'); ?></a>
                <?php
                echo wp_kses_post(__('- provides <strong>important</strong> Weaver Xtreme theme options and useful shortcodes. Per Page/Post options are now integrated with the theme, so if you do not need the legacy check-box options interface or the shortcodes, you can probably get by without the Theme Support Plugin.', 'weaver-xtreme'));
                ?>
            </li>
        </ul>
        <p><strong>
                <?php
                esc_html_e('The following plugins are not essential, but can be useful when creating pages, or using Weaver Xtreme shortcodes.', 'weaver-xtreme');
                ?>
            </strong></p>
        <ul>
            <li><a href="//wordpress.org/plugins/show-posts/"
                   target="_blank"><?php esc_html_e('Weaver Show Posts', 'weaver-xtreme'); ?></a>
                <?php
                esc_html_e(
                    '- adds the [show_posts] shortcode to selectively display posts filtered by category, tag, order, id, etc.
Also adds additional filtering options to the Weaver Xtreme Page with Posts page template.
This formerly was integrated with Weaver, and was considered an important part of the theme.',
                    'weaver-xtreme');
                ?>
            </li>
            <li><a href="//wordpress.org/plugins/show-sliders/"
                   target="_blank"><?php esc_html_e('Weaver Show Sliders', 'weaver-xtreme'); ?></a>
                <?php
                esc_html_e('- good for any kind of slideshows - images, posts, [gallery] replacement', 'weaver-xtreme');
                ?>
            </li>
        </ul>

    </div>
    <div class="clear-both"></div>
    <hr/>
    <?php
    $server_mem_lim = get_cfg_var('memory_limit');
    $server_mem_lim = str_ireplace('M', '', $server_mem_lim);
    if ($server_mem_lim > 0 && $server_mem_lim < 128 && !weaverx_getopt('_disable_customizer')) {

        echo wp_kses_post(
        /* translators: %s is a number */
            sprintf(__('<h3>Warning! Your WP host server has only %s of PHP Memory.</h3>
<p>Depending on your WordPress configuration, this could cause settings made in the Customizer to <em>NOT</em> be saved and applied to your live site. Weaver Xtreme recommends at least 128M of PHP memory for the Customizer to work properly. <em>Please verify that settings you make in the Customizer are being applied to your live site.</em></p><h4>HOW TO FIX THIS PROBLEM</h4>
<ul><li><strong>If your Customizer Settings do not save properly:</strong> Contact your site hosting company your hosting company to increase your PHP memory to 128M. This also may be an option on your hosting control panel. After you increase the PHP, please verify Customizer options are being saved.</li>
<li><strong>You do not need to or want to increase PHP Memory:</strong> Install the <em>Weaver Xtreme Theme Support Plugin</em> and check either the <em>Disable Weaver Xtreme Customizer Interface</em> option or the <em>Ignore Customizer PHP Minimum Memory</em> on the <em>Advanced Options : Admin Options</em> tab.',
                'weaver-xtreme'
            ), $server_mem_lim . 'M'
            )
        );
    }
    do_action('weaverx_more_help');
}


