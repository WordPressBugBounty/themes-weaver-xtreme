<?php
/** PHP 7.4 features added */

/**
 * Customizer Support for Weaver Xtreme
 *
 * Panel, Section, and control definition structures inspired by Make theme
 * Some custom Customizer control classes inspired by
 */

global $wp_customize;

if (isset($wp_customize) && current_user_can('manage_options') && !weaverx_getopt('_disable_customizer')) { //dev-fix
    // if ( isset( $wp_customize ) && ! weaverx_getopt( '_disable_customizer' ) ) {

    /* Start with code  common to both WHAT and WHERE */

    add_action('customize_register', 'weaverx_add_customizer_content');

    function weaverx_add_customizer_content($wp_customize): void
    {  // action for customize_register

        // Fail safe is safe
        if (!isset($wp_customize)) {
            return;
        }

        weaverx_cz_cache_opts();        // we want to get the existing options before filtered.

        $path = get_theme_file_path(WEAVERX_ADMIN_DIR . '/customizer/');

        // Include the Alpha Color Picker control file.
        require_once($path . 'alpha-color-picker/alpha-color-picker.php');
        require_once($path . 'save-restore/customizer-save-restore.php');
        require_once($path . 'lib-controls.php');
        require_once($path . 'lib-choices-definitions.php');


        weaverx_customizer_add_panels($wp_customize);
        weaverx_customizer_add_sections($wp_customize);
        weaverx_customizer_set_transport($wp_customize);

        weaverx_clear_opt_cache('customizer');
    }


    add_action('customize_controls_enqueue_scripts', 'weaverx_enqueue_customizer_scripts');


    /*
 * Customizer scripts
 */
    function weaverx_enqueue_customizer_scripts(): void
    {

        // Styles
        wp_enqueue_style(
            'weaverx-customizer-jquery-ui',
            get_template_directory_uri(WEAVERX_ADMIN_DIR . '/customizer/css/jquery-ui/jquery-ui-1.10.4.custom.css'),
            array(),
            '1.10.4'
        );
        wp_enqueue_style(
            'weaverx-customizer-chosen',
            get_template_directory_uri(WEAVERX_ADMIN_DIR . '/customizer/css/chosen/chosen.css'),
            array(),
            '1.3.0'
        );

        if (weaverx_options_interface() == 'what') {
            // What code

            wp_enqueue_style(
                'weaverx-customizer-sections',
                get_theme_file_uri('/admin/customizer/css/customizer-sections' . WEAVERX_MINIFY . '.css'),
                array('weaverx-customizer-jquery-ui', 'weaverx-customizer-chosen'),
                WEAVERX_VERSION
            );

        } else {
            // Where code
            wp_enqueue_style(
                'weaverx-customizer-sections',
                get_theme_file_uri('/admin/customizer/css/customizer-sections-where' . WEAVERX_MINIFY . '.css'),
                array('weaverx-customizer-jquery-ui', 'weaverx-customizer-chosen'),
                WEAVERX_VERSION
            );

        }


        // stylesheet for customizer

        wp_enqueue_style('dashicons');

        // Scripts

        wp_enqueue_script(
            'weaverx-customizer-chosen',
            get_template_directory_uri(WEAVERX_ADMIN_DIR . '/customizer/js/chosen.jquery.js'),
            array('jquery', 'customize-controls'),
            '1.3.0',
            true
        );

        wp_enqueue_script(
            'weaverx-customizer-sections',
            get_template_directory_uri(WEAVERX_ADMIN_DIR . '/customizer/js/customizer-sections' . WEAVERX_MINIFY . '.js'),
            array('jquery', 'customize-controls', 'weaverx-customizer-chosen'),
            WEAVERX_VERSION,
            true
        );


        // Save/Restore scripts
        WeaverX_Save_WX_Settings::enqueue_scripts();
        // WeaverX_Restore_WX_Settings::enqueue_scripts();

    }


    add_action('customize_preview_init', 'weaverx_customizer_preview_script');

    function weaverx_customizer_preview_script(): void
    {
        /**
         * Enqueue customizer preview script
         *
         * Hooked to 'customize_preview_init' via weaverx_customizer_init()
         *
         */
        //weaverx_alert('enqueue script: --' . get_template_directory_uri() . WEAVERX_ADMIN_DIR . '/customizer/js/customizer-preview' . WEAVERX_MINIFY . '.js');
        wp_enqueue_script(
            'weaverx_cz-customizer-preview',
            get_template_directory_uri() . WEAVERX_ADMIN_DIR . '/customizer/js/customizer-preview' . WEAVERX_MINIFY . '.js',
            array(),
            WEAVERX_VERSION,
            true
        );

        $date = getdate();
        $year = $date['year'];
        $cp = weaverx_getopt('copyright');        // so can restore default from customizer
        if (!$cp) {
            $cp = '&copy;' . $year . ' - <a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) .
                '" rel="home">' . esc_attr(get_bloginfo('name', 'display')) . '</a>';
        }

        $local = array(
            'copyright' => $cp,
            'more_msg' => esc_html__('Continue reading &rarr;', 'weaver-xtreme'),
        );
        wp_localize_script('weaverx_cz-customizer-preview', 'wvrxPRE', $local);
    }


    add_action('customize_register', 'WeaverX_Save_WX_Settings::process_save', 999999);
    add_action('customize_register', 'WeaverX_Restore_WX_Settings::process_restore', 999999);
    add_action('customize_register', 'WeaverX_Load_WX_Subtheme::process_load_theme', 999999);
    add_action('customize_register', 'WeaverX_Set_Customizer_Level::process_set_level', 999999);


    add_action('customize_controls_print_footer_scripts', 'weaverx_customize_preview_js');

    function weaverx_customize_preview_js(): void
    {

        // @@@ possibly add Loading message....

        WeaverX_Restore_WX_Settings::controls_print_scripts();

        weaverx_check_customizer_memory();

        if (weaverx_options_level() < 1) {        // show if not set
            weaverx_alert(wp_kses_post(__('Thank you for using Weaver Xtreme!\r\n\r\n        IMPORTANT NOTE  -- \r\n\r\nThis theme has 3 Customizer Option Interface Levels: Basic, Standard, and Full. If you are just getting started, using the Basic Level can simplify the learning curve.\r\n\r\nAfter the Customizer loads, please open the **General Options / Admin** panel, and then the **Set Options Interface Level** panel, and select an Interface Level.\r\n\r\nThis message will continue to be displayed until you select a level.', 'weaver-xtreme')));
        }

    }

    add_action('customize_save_after', 'weaverx_cz_save_after');

    function weaverx_cz_save_after(): void
    {
        weaverx_save_opts('customizer', true);    // have to save things - generate css setting and file, for example.
    }

    /* END OF COMMON CODE */

    // ############################################
    //
    // Here's the actual code


    if (weaverx_options_interface() == 'what') {
        // What code
        require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/customizer/load-customizer-what.php'));
    } else {
        // Where code
        require_once(get_theme_file_path(WEAVERX_ADMIN_DIR . '/customizer/load-customizer-where.php'));

    }

    // other functions...


    function weaverx_cz_settings_name($id): string
    {

        $theme_opts = WEAVER_SETTINGS_NAME;

        return $theme_opts . '[' . $id . ']';

        //return $id;
    }

    if (!function_exists('weaverx_customizer_add_section_options')) {
        /**
         * Register settings and controls for a section.
         */
        function weaverx_customizer_add_section_options($section, $args, $initial_priority = 100)
        {
            global $wp_customize;

            $priority = new weaverx_cz_Prioritizer($initial_priority, 5);
            $theme_prefix = 'weaverx_';

            foreach ($args as $setting_id => $option) {
                if (isset($option['setting'])) {
                    $defaults = array(
                        'type' => WEAVER_CUSTOMIZER_TYPE,        //'option' or 'theme_mod'
                        'capability' => 'edit_theme_options',
                        'theme_supports' => '',
                        'default' => false,
                        'transport' => 'refresh',
                        'sanitize_callback' => WEAVERX_DEFAULT_SANITIZE,
                        'sanitize_js_callback' => '',
                    );
                    $setting = wp_parse_args($option['setting'], $defaults);

                    // Add the setting arguments in array to add_setting call so Theme Check can verify the presence of sanitize_callback

                    $wp_customize->add_setting(new WP_Customize_Setting($wp_customize, weaverx_cz_settings_name($setting_id),
                        array(
                            'type' => $setting['type'],
                            'capability' => $setting['capability'],
                            'theme_supports' => $setting['theme_supports'],
                            'default' => $setting['default'],
                            'transport' => $setting['transport'],
                            'sanitize_callback' => $setting['sanitize_callback'],
                            'sanitize_js_callback' => $setting['sanitize_js_callback'],
                        )));

                }

                // Add control
                if (isset($option['control'])) {
                    $control_id = $theme_prefix . $setting_id;

                    $defaults = array(
                        'section' => $section,
                        'priority' => $priority->add(),
                        'settings' => weaverx_cz_settings_name($setting_id),
                    );

                    if (!isset($option['setting'])) {
                        unset($defaults['settings']);
                    }

                    $control = wp_parse_args($option['control'], $defaults);

                    // Check for a specialized control class - create new instance
                    if (isset($control['control_type'])) {
                        $class = $control['control_type'];
                        if (class_exists($class)) {
                            unset($control['control_type']);

                            // Dynamically generate a new class instance
                            $class_instance = new $class($wp_customize, $control_id, $control);
                            $wp_customize->add_control($class_instance);
                        } else {
                            if (true || WEAVERX_DEV_MODE) {
                                echo '<h2>MISSING CLASS DEFINITON: ' . $class . '</h2>';
                            }
                        }
                    } else {
                        $wp_customize->add_control($control_id, $control);
                    }
                }
            }

            return $priority->get();
        }
    }

    if (!function_exists('weaverx_customizer_set_transport')) :
        /**
         * Add postMessage support for certain built-in settings in the Theme Customizer.
         *
         * Allows these settings to update asynchronously in the Preview pane.
         */
        function weaverx_customizer_set_transport($wp_customize): void
        {
            $wp_customize->get_setting('blogname')->transport = 'postMessage';
            $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        }
    endif;


// lib

    function weaverx_cz_cache_opts(): void
    {
        if (!isset($GLOBALS['weaverx_cz_cache'])) {
            $GLOBALS['weaverx_cz_cache'] = array();
        }

        $opts = weaverx_get_db_options();

        if (!isset($opts['themename'])) {
            $opts = weaverx_cz_getdefaults();
        }

        $GLOBALS['weaverx_cz_cache'] = $opts;
    }

    function weaverx_cz_getdefaults(): array
    {
        // read from static file name: WEAVERX_DEFAULT_THEME_FILE -- no user input
        $filename = apply_filters('weaverx_default_subtheme', get_theme_file_path() . WEAVERX_DEFAULT_THEME_FILE);

        if (!weaverx_f_exists($filename)) {
            return array();
        }

        $contents = weaverx_f_get_contents($filename);

        if (empty($contents)) {
            return array();
        }

        if (substr($contents, 0, 10) != 'WXT-V01.00' && substr($contents, 0, 10) != 'WVA-V01.00') {
            return array();
        }

        $restore = unserialize(substr($contents, 10));

        $ret = array();
        $opts = $restore['weaverx_base'];    // fetch base opts
        foreach ($opts as $opt => $val) {
            $ret[$opt] = $val;
        }

        return $ret;
    }

    function weaverx_cz_getopt(string $opt): string
    {
        if (!isset($GLOBALS['weaverx_cz_cache'][$opt])) {    // handles changes to data structure
            return '';
        }
        $val = $GLOBALS['weaverx_cz_cache'][$opt];

        return $val ? $val : '';
    }

} // disable customizer?

