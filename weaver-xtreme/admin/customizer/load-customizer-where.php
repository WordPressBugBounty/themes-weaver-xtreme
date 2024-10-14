<?php
/** PHP 7.4 features added */

/* Code used only for What Customizer option interface */

add_action('customize_register', 'weaverx_cz_customize_order_where', 20);

function weaverx_cz_customize_order_where($wp_customize): void
{

    // Re-prioritize and rename the Widgets panel to bottom of options
    if (!isset($wp_customize->get_panel('widgets')->priority)) {
        $wp_customize->add_panel('widgets');
    }

    $wp_customize->get_panel('widgets')->priority = 12900;
    $wp_customize->get_panel('widgets')->title = esc_html__('Active Widget Areas (WP)', 'weaver-xtreme') . WEAVERX_REFRESH_ICON;

    // Re-prioritize and rename the Menus panel
    if (!isset($wp_customize->get_panel('nav_menus')->priority)) {
        $wp_customize->add_panel('nav_menus');
    }

    $wp_customize->get_panel('nav_menus')->priority = 12910;
    $wp_customize->get_panel('nav_menus')->title = esc_html__('Custom Menus Content (WP)', 'weaver-xtreme') . WEAVERX_REFRESH_ICON;

    // disable WP's background-color setting
    $wp_customize->get_control('background_color')->active_callback = function () {
        return false;
    };
}

if (!function_exists('weaverx_customizer_get_panels')) {
    /**
     * Return an array of panel definitions.
     *
     * @return array    The array of panel definitions.
     * @since  1.3.0.
     */
    function weaverx_customizer_get_panels(): array
    {
        /* note: the panel name of each of these is the base file name of the panel
         *
         * To add a new panel:
         *      1. give it a name, such as where-xxx
         *      2. Create where-xxx file from template file
         *      3. Change panel name in file to weaverx_where-xxx
         *      4. Add panel definition here, give priority number to place in on top level menu
         *      5. Add to function weaverx_customizer_get_sections()
         *      Note: need esc_html__ as the strings go directly to WP core.
         */
        $panels = array(

            'starting' => array(
                'title' => esc_html__('Weaver Xtreme: Start Here', 'weaver-xtreme'),
                'priority' => 10000,
                'description' => esc_html__("How to get started with Weaver Xtreme.", 'weaver-xtreme'),
            ),

            'general' => array(
                'title' => esc_html__('Admin Options', 'weaver-xtreme'),
                'priority' => 10100,
                'description' => esc_html__("Admin Options: Site Identity, Homepage, Interface, General Admin, Save/Restore", 'weaver-xtreme'),
            ),

            'where-global' => array(
                'title' => esc_html__('Global Site Settings', 'weaver-xtreme'),
                'priority' => 10200,
                'description' => esc_html__('Settings that apply to entire site.', 'weaver-xtreme'),
            ),

            'where-wrapping' => array(
                'title' => esc_html__('Wrapping Areas', 'weaver-xtreme'),
                'priority' => 10300,
                'description' => esc_html__("Options for Wrapper and Container Areas", 'weaver-xtreme'),
            ),

            'where-sidebars' => array(
                'title' => esc_html__('Sidebars & Widgets', 'weaver-xtreme'),
                'priority' => 10400,
                'description' => esc_html__("Options for Sidebars and Widgets", 'weaver-xtreme'),
            ),

            'where-header' => array(
                'title' => esc_html__('Header', 'weaver-xtreme'),
                'priority' => 10500,
                'description' => esc_html__("Options affecting the Header Area at the top of your site", 'weaver-xtreme'),
            ),

            'where-menus' => array(
                'title' => esc_html__('Menus', 'weaver-xtreme'),
                'priority' => 10600,
                'description' => esc_html__("Options to control how your menus look.", 'weaver-xtreme'),
            ),

            'where-infobar' => array(
                'title' => esc_html__('Info Bar (Above Content Area)', 'weaver-xtreme'),
                'priority' => 10700,
                'description' => esc_html__("Options for the Infobar between the Header and the Content Area.", 'weaver-xtreme'),
            ),

            'where-content' => array(
                'title' => esc_html__('Content Areas', 'weaver-xtreme'),
                'priority' => 10800,
                'description' => esc_html__("Content Areas: Includes options common to both Pages and Posts. Options for Text, Padding, Images, Lists & Tables, and user Comments.", 'weaver-xtreme'),
            ),

            'where-posts' => array(
                'title' => esc_html__('Post Specifics', 'weaver-xtreme'),
                'priority' => 10900,
                'description' => esc_html__("Post Specifics: Options related to Posts, including Background color, Columns displayed on blog pages, Title options, Navigation to earlier and later posts, the post Info Lines, Excerpts, and Featured Image handling.", 'weaver-xtreme'),
            ),

            'where-footer' => array(
                'title' => esc_html__('Footer', 'weaver-xtreme'),
                'priority' => 11000,
                'description' => esc_html__("Footer: Options affecting the Footer area, including Background color, Borders, and the Copyright message.", 'weaver-xtreme'),
            ),

            'where-html-injection' => array(
                'title' => esc_html__('HTML Injection', 'weaver-xtreme'),
                'priority' => 12000,
                'description' => esc_html__("Specify added content: Define added content for HTML areas.", 'weaver-xtreme'),
            ),

            'where-custom' => array(
                'title' => esc_html__('Custom CSS', 'weaver-xtreme'),
                'priority' => 12100,
                'description' => esc_html__('Define Custom CSS rules for whole site or specific areas. Add HTML to several "injection areas" - useful for ads or custom third party scripts. <em>Weaver Xtreme Plus</em> also allows you to define PHP code for WP filters or actions.', 'weaver-xtreme'),
            ),

            'where-obsolete' => array(
                'title' => esc_html__('Obsolete Weaver Xtreme Options', 'weaver-xtreme'),
                'priority' => 12300,
                'description' => esc_html__('Options from previous versions of Weaver Xtreme that are now obsolete.', 'weaver-xtreme'),
            ),
        );

        /**
         * Filter the array of panel definitions for the Customizer.
         *
         * @param array $panels The array of panel definitions.
         *
         * @since 1.3.0.
         *
         */
        return $panels;
    }
}

if (!function_exists('weaverx_customizer_add_panels')) {
    /**
     * Register Customizer panels
     */
    function weaverx_customizer_add_panels($wp_customize): void
    {
        $theme_prefix = 'weaverx_';

        // Get panel definitions
        $panels = weaverx_customizer_get_panels();

        // Add panels
        foreach ($panels as $panel => $data) {
            // Add panel
            if (!empty($data)) {
                $wp_customize->add_panel($theme_prefix . $panel, $data);
            }
        }
    }
}

if (!function_exists('weaverx_customizer_get_sections')) {
    /**
     * Return the master array of Customizer sections
     *
     * @return array    The master array of Customizer sections
     * @since  1.3.0.
     *
     */
    function weaverx_customizer_get_sections(): array
    {
        // Add all the section definitions
        // order here is not meaningful other than organization
        // Each sections has own priority which gives it order on the top level menu

        $starting = weaverx_customizer_define_starting_sections();
        $general = weaverx_customizer_define_general_sections();

        $global = weaverx_customizer_define_w_global_sections();

        $wrapping = weaverx_customizer_define_w_wrapping_sections();

        $sidebars = weaverx_customizer_define_sidebars_sections();
        $header = weaverx_customizer_define_w_header_sections();
        $menus = weaverx_customizer_define_w_menus_sections();
        $w_infobar = weaverx_customizer_define_w_infobar_sections();
        $w_content = weaverx_customizer_define_w_content_sections();
        $w_posts = weaverx_customizer_define_w_posts_sections();
        $w_footer = weaverx_customizer_define_w_footer_sections();

        $html_inject = weaverx_customizer_define_html_sections();
        $custom = weaverx_customizer_define_custom_sections();
        // $pb = weaverx_customizer_define_pagebuilder_sections();
        $obsolete = weaverx_customizer_define_obsolete_sections();


        return array_merge(
            $starting,
            $general,
            $global,
            $wrapping,
            $header,
            $sidebars,
            $menus,
            $w_infobar,
            $w_content,
            $w_posts,
            $w_footer,
            $html_inject,
            $custom,
            //$pb,
            $obsolete
        ); // merge the arrays

    }
}

if (!function_exists('weaverx_customizer_add_sections')) {
    /**
     * Add sections and controls to the customizer.
     *
     * Hooked to 'customize_register' via weaverx_customizer_init().
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     *
     * @return void
     * @since  1.0.0.
     *
     */
    function weaverx_customizer_add_sections($wp_customize): void
    {
        $theme_prefix = 'weaverx_';
        $default_path = get_theme_file_path(WEAVERX_ADMIN_DIR . '/customizer/sections');
        $panels = weaverx_customizer_get_panels();

        // Load section definition files
        foreach ($panels as $panel => $data) {
            $file = trailingslashit($default_path) . $panel . '.php';
            if (file_exists($file)) {
                require_once($file);
            } else {
                weaverx_alert('Missing file: ' . $file);
            }
        }

        // Compile the section definitions
        $sections = weaverx_customizer_get_sections();

        // Register each section and add its options
        $priority = array();
        foreach ($sections as $section => $data) {
            // Get the non-prefixed ID of the current section's panel
            $panel = (isset($data['panel'])) ? str_replace($theme_prefix, '', $data['panel']) : 'none';

            // Store the options
            if (isset($data['options'])) {
                $options = $data['options'];
                unset($data['options']);
            }

            // Determine the priority
            if (!isset($data['priority'])) {
                $panel_priority = ('none' !== $panel && isset($panels[$panel]['priority'])) ? $panels[$panel]['priority'] : 1000;

                // Create a separate priority counter for each panel, and one for sections without a panel
                if (!isset($priority[$panel])) {
                    $priority[$panel] = new weaverx_cz_Prioritizer($panel_priority, 10);
                }

                $data['priority'] = $priority[$panel]->add();
            }

            // Register section
            $wp_customize->add_section($theme_prefix . $section, $data);

            // Add options to the section
            if (isset($options)) {
                weaverx_customizer_add_section_options($theme_prefix . $section, $options);
                unset($options);
            }
        }
    }
}
