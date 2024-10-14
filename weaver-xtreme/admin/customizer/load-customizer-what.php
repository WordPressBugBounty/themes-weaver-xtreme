<?php
/** PHP 7.4 features added */


/* Code used only for What Customizer option interface */

add_action('customize_register', 'weaverx_cz_customize_order_what', 20);

function weaverx_cz_customize_order_what($wp_customize): void
{

    // Re-prioritize and rename the site identity panel
    //$section_id = 'title_tagline';
    //$section = $wp_customize->get_section( $section_id );

    // Set Site Title & Tagline section priority
    //$section->priority = 10250;

    // Re-prioritize and rename the Widgets panel
    if (!isset($wp_customize->get_panel('widgets')->priority)) {
        $wp_customize->add_panel('widgets');
    }

    $wp_customize->get_panel('widgets')->priority = 11900;
    $wp_customize->get_panel('widgets')->title = esc_html__('Active Widget Areas (WP)', 'weaver-xtreme') . WEAVERX_REFRESH_ICON;

    // Re-prioritize and rename the Menus panel
    if (!isset($wp_customize->get_panel('nav_menus')->priority)) {
        $wp_customize->add_panel('nav_menus');
    }

    $wp_customize->get_panel('nav_menus')->priority = 11910;
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
        $panels = array(

            'starting' => array(
                'title' => esc_html__('Weaver Xtreme: Start Here', 'weaver-xtreme'),
                'priority' => 10100,
                'description' => esc_html__("How to get started with Weaver Xtreme.", 'weaver-xtreme'),
            ),

            'general' => array(
                'title' => esc_html__('Admin Options', 'weaver-xtreme'),
                'priority' => 10200,
                'description' => esc_html__("Admin Options: Site Identity, Homepage, Interface, General Admin, Save/Restore", 'weaver-xtreme'),
            ),

            'layout' => array(
                'title' => esc_html__('Layout', 'weaver-xtreme'),
                'priority' => 10300,
                'description' => esc_html__("Layout controls the overall look of your site. This includes the site width, full width layout option, sidebar layout, and more.", 'weaver-xtreme'),
            ),

            'typography' => array(
                'title' => esc_html__('Typography', 'weaver-xtreme'),
                'priority' => 10400,
                'description' => esc_html__("Typography: font family, font size, bold, italic.", 'weaver-xtreme'),
            ),

            'images' => array(
                'title' => esc_html__('Images', 'weaver-xtreme'),
                'priority' => 10500,
                'description' => esc_html__("Image Options: borders, placement, Featured Images, Header Images, Background Images.", 'weaver-xtreme'),
            ),

            'visibility' => array(
                'title' => esc_html__('Visibility', 'weaver-xtreme'),
                'priority' => 10600,
                'description' => esc_html__("Specify visibility - hide various elements on various devices ( desktop, tablets, phones ).", 'weaver-xtreme'),
            ),

            'site-colors' => array(
                'title' => esc_html__('Colors', 'weaver-xtreme'),
                'priority' => 10700,
                'description' => esc_html__("Specify all colors used on site - both text and background colors. <strong>TIP:</strong> Clicking <em>Default</em> on the color picker will restore the original color set when you loaded the Customizer.", 'weaver-xtreme'),
            ),

            'spacing' => array(
                'title' => esc_html__('Spacing, Widths, Alignment', 'weaver-xtreme'),
                'priority' => 10800,
                'description' => esc_html__("Set margins, padding, spacing, heights, and widths.", 'weaver-xtreme'),
            ),

            'style' => array(
                'title' => esc_html__('Style (borders, etc.)', 'weaver-xtreme'),
                'priority' => 10900,
                'description' => esc_html__("Style: borders, shadows, rounded corners, list bullet style, icons. ( Important note: using rounded corners usually requires specifying a BG color or border. )", 'weaver-xtreme'),
            ),


            'content' => array(
                'title' => esc_html__('Added Content (HTML Areas...)', 'weaver-xtreme'),
                'priority' => 11000,
                'description' => esc_html__("Specify added content: Define added content for HTML areas.", 'weaver-xtreme'),
            ),


            'custom' => array(
                'title' => esc_html__('Custom CSS', 'weaver-xtreme'),
                'priority' => 11100,
                'description' => esc_html__('Define Custom CSS rules for whole site or specific areas. Add HTML to several "injection areas" - useful for ads or custom third party scripts. <em>Weaver Xtreme Plus</em> also allows you to define PHP code for WP filters or actions.', 'weaver-xtreme'),
            ),

            'pagep-builder' => array(
                'title' => esc_html__('Page Builders', 'weaver-xtreme'),
                'priority' => 11200,
                'description' => esc_html__('Options for integration with Page Builders.', 'weaver-xtreme'),
            ),

            'where-obsolete' => array(
                'title' => esc_html__('Obsolete Weaver Xtreme Options', 'weaver-xtreme'),
                'priority' => 12300,
                'description' => esc_html__('Options for integration with Page Builders.', 'weaver-xtreme'),
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
        $pb = weaverx_customizer_define_pagebuilder_sections();
        $content = weaverx_customizer_define_content_sections();    // get array for each section
        $custom = weaverx_customizer_define_custom_sections();
        $general = weaverx_customizer_define_general_sections();
        $image = weaverx_customizer_define_image_sections();
        $layout = weaverx_customizer_define_layout_sections();
        $colorscheme = weaverx_customizer_define_colorscheme_sections();
        $spacing = weaverx_customizer_define_spacing_sections();
        $starting = weaverx_customizer_define_starting_sections();
        $style = weaverx_customizer_define_style_sections();
        $typography = weaverx_customizer_define_typography_sections();
        $visibility = weaverx_customizer_define_visibility_sections();
        $obsolete = weaverx_customizer_define_obsolete_sections();


        return array_merge($pb, $content, $custom, $general, $image, $layout, $colorscheme, $spacing, $starting, $style, $typography, $visibility, $obsolete); // merge the arrays
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
