<?php
/** PHP 7.4 features added */

/* This loads the Admin stuff. It is invoked from functions.php.
 *
 * This ultimately will be used to load different admin interfaces -
 * like the a default Customizer version for WP.org, or the traditional Theme Options version ( which it does now )
 */

if (current_user_can('edit_theme_options')) {

    add_action('admin_menu', 'weaverx_add_admin', 5);

    weaverx_load_admin_aux();

    do_action('weaverx_check_updates');

    function weaverx_add_admin(): void
    {    // action definition
        /* adds our admin panel  ( add_action: admin_menu ) */
        // 'edit_theme_options' works for both single and multisite
        $page = add_theme_page('WeaverX', wp_kses_post(__('Weaver Xtreme <small>Admin</small>', 'weaver-xtreme')), 'edit_theme_options', 'WeaverX', 'weaverx_admin_theme_page');
        /* using registered $page handle to hook stylesheet loading for this admin page */
        add_action('admin_print_styles-' . $page, 'weaverx_admin_scripts');
    }

// callback for add_theme_page
    function weaverx_admin_theme_page(): void
    {

        $cur_vers = weaverx_wp_version();

        if (version_compare($cur_vers, WEAVERX_MIN_WPVERSION, '<')) {
            echo '<br><br><h2 style="padding:4px;background:pink;">' . esc_html__('ERROR: You are using WordPress Version ', 'weaver-xtreme') . $GLOBALS['wp_version'] .
                esc_html__(' Weaver Xtreme requires WordPress Version ', 'weaver-xtreme') . WEAVERX_MIN_WPVERSION .
                esc_html__(' or above. You should always upgrade to the latest version of WordPress for maximum site performance and security.', 'weaver-xtreme') .
                '</h2>';    // admin message

            return;
        }

        require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/admin-core/admin-top.php')); // NOW - load the admin stuff
        do_action('weaverxplus_add_admin');
        weaverx_do_admin();
    }

    function weaverx_wp_version()
    {
        $wp_vers = $GLOBALS['wp_version'];
        $cur_vers = $wp_vers;
        $beta = strpos($cur_vers, '-');
        if ($beta > 0) {
            $cur_vers = substr($cur_vers, 0, $beta);    // strip the beta part if there
        }

        return $cur_vers;
    }

// callback for admin_print_styles in add_admin above
    function weaverx_admin_scripts(): void
    {

        /* called only on the admin page, enqueue our special style sheet here ( for tabbed pages ) */
        wp_enqueue_style('wvrxaStylesheet', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/admin-core/assets/css/admin-style.css'));
        if (is_rtl()) {
            wp_enqueue_style('wvrxartlStylesheet', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/admin-core/assets/css/admin-style-rtl.css'));
        }

        wp_enqueue_style("thickbox");
        wp_enqueue_script("thickbox");

        //wp_enqueue_style( 'jquery-ui-dialog' );
        //wp_enqueue_style( 'jquery-ui-dialog' );

        // jsColor only needed from theme support plugin - Version 4.2

        wp_enqueue_script('wvrxJscolor', get_theme_file_uri('/assets/js/jscolor/jscolor.js'), WEAVERX_VERSION); // .min fails

        // wvrxCombined includes yetii, hide-css, and media-lib - changed for V 4.2
        wp_enqueue_script('wvrxCombined', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/admin-core/assets/js/theme/weaver-combined' . WEAVERX_MINIFY . '.js'), WEAVERX_VERSION);
    }

//--

    add_action('admin_init', 'weaverx_admin_init_cb');

    function weaverx_admin_init_cb(): void
    {    // action definition

        if (function_exists('wvrx_ts_installed')) {
            require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/admin-core/lib-admin-legacy.php'));
        } else {
            require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/admin-core/lib-admin.php'));
        }

        weaverx_sapi_options_init(); // This must come first as it hooks update_option used elsewhere

    }

//--
    /**
     * Hook into the 'admin_notices' action to render a generic HTML notice.
     */
    function weaverx_admin_notice(): void
    {
        $screen = get_current_screen();
        // Only render this notice in the post editor.
        if (!$screen || function_exists('wvrx_ts_installed')) {
            return;
        }

        if ('post' == $screen->base || 'page' == $screen->base) {
            // Render the notice's HTML.
            // Each notice should be wrapped in a <div>
            // with a 'notice' class.
            echo '<div class="notice notice-success is-dismissible"><p>';
            echo '<span style="font-weight:bold; color:#ff8000">NOTICE:</span> Please install the <b>Weaver Xtreme Theme Support</b> plugin to enable content styling in the Classic Editor. You will also then need to re-save your theme options.';
            echo '</p></div>';
        }
    }

    add_action('admin_notices', 'weaverx_admin_notice');

}    // END IF CAN EDIT POSTS ---------------------------------------------------------------------

function weaverx_load_admin_aux(): void
{

    if (current_user_can('edit_posts')) { // allows only admin to see, also avoids loading at runtime
        require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/admin-core/admin-page-posts.php'));    // per page-posts admin
    }

}

if (current_user_can('edit_posts') && !has_action('weaverx_load_customizer')) {

    add_action('weaverx_load_customizer', 'weaverx_load_customizer_action');

    function weaverx_load_customizer_action(): void
    {

        require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/customizer/load-customizer.php')); // start by loading customizer features
    }

}

