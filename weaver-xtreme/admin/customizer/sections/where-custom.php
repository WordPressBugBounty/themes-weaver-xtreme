<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the Custom CSS panel
 */

function weaverx_customizer_define_custom_sections(): array
{
    $panel = 'weaverx_where-custom';
    $custom_sections = array();
    global $wp_customize;

    /**
     * Additional CSS - from WP
     */

    $section_id = 'custom_css';
    $section = $wp_customize->get_section($section_id);

    // Bail if the section isn't registered
    if (is_object($section)) {
        $section->panel = $panel;    // Move Static Front Page section to General panel
        $section->title = esc_html__('Additional CSS - WP Setting', 'weaver-xtreme');
        $section->priority = 12990;    // Set Static Front Page section priority
        $cur_des = $section->description;
        $section->description = esc_html__('NOT RECOMMENDED! The standard WordPress "Additional CSS" rules defined here will NOT be saved with your Weaver Xtreme settings. If needed for some specialized circumstances, the "Additional CSS" rules are preserved across all Weaver Xtreme subthemes and settings versions on an individual site, but we suggest always using the "Global Custom CSS" option above.', 'weaver-xtreme') . '<br />' . $cur_des;
    }

    if (weaverx_options_level() >= WEAVERX_LEVEL_ADVANCED) {        // show if advanced

        $custom_sections['custom-help'] = array(
            'panel' => $panel,
            'title' => esc_html__('Help for Custom CSS', 'weaver-xtreme'),
            'options' => array(
                'custom-help-heading' => weaverx_cz_group_title(esc_html__('Introductory Help for Custom CSS', 'weaver-xtreme'),
                    wp_kses_post(__('These Custom CSS sections allow you to add custom CSS for different sections without needing to know the id or class for the section. You should simply enter normal CSS rules enclosed by braces <em>{selector:value;}</em>. You do not need to enter any id or class name. There are other helpful features to this custom CSS feature explained in the Help Documentation. See the link on the desktop <em>Appearance &rarr; Weaver Xtreme Admin &rarr; Theme Help</em> panel. Note that these Custom CSS rules are a very advanced feature of Weaver Xtreme, and most people will not need them. They do allow web designers to build highly customized sites.', 'weaver-xtreme')) . ' <br/><br/>' .
                    esc_html__('Note: Starting with Weaver Xtreme V 6.2.1, the Customizer view will refresh instead of auto-updating. This will likely cause flashing as the view updates. This was necessary because the theme as switched to embedded CSS.','weaver-xtreme')),
            ),
        );
    }

    /**
     * Global Site Custom CSS
     */
    $custom_sections['custom-global'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global Custom CSS', 'weaver-xtreme'),
        'description' => "Set Custom CSS definitions that apply to entire site. Global Custom CSS is live updated, but won't display properly until you've completed a valid CSS rule.",
        'options' => array(

            'add_css' => array(
                'setting' => array(
                    'sanitize_callback' => 'weaverx_cz_sanitize_css',
                    'transport' => 'refresh',
                    'default' => '',
                ),
                'control' => array(
                    'control_type' => 'WeaverX_Textarea_Control',
                    'label' => esc_html__('Global Custom CSS', 'weaver-xtreme')  . WEAVERX_REFRESH_ICON,
                    'description' => esc_html__('You can add arbitrary CSS rules here. These rules will come after other CSS stylesheets included for your site, and can be used to override default CSS rules, or to add new CSS rules for other plugins or content. Note that unlike the per-area Custom CSS rules found on other sections of this panel, the CSS rules you add here must be complete, including the class or id selector.', 'weaver-xtreme'),
                    'type' => 'textarea',
                    'input_attrs' => array(
                        'rows' => '12',
                        'placeholder' => wp_kses_post(__('.selector {font-size:150%;font-weight:bold;} /* for example */', 'weaver-xtreme')),
                    ),
                ),
            ),
        ),
    );

    /**
     * Wrapping
     */
    if (weaverx_options_level() >= WEAVERX_LEVEL_ADVANCED) {        // show if advanced if ( weaverx_options_level() >= WEAVERX_LEVEL_ADVANCED ) {		// show if advanced
        $custom_sections['custom-wrapping'] = array(
            'panel' => $panel,
            'title' => esc_html__('Wrapping Areas', 'weaver-xtreme'),
            'description' => esc_html__('Set Custom CSS for the Wrapper and Container Areas.', 'weaver-xtreme'),
            'options' => array(

                'body_bgcolor_css' => weaverx_cz_css(esc_html__('&lt;body&gt; Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for the &lt;body&gt; tag.', 'weaver-xtreme')),
                'wrapper_bgcolor_css' => weaverx_cz_css(esc_html__('Wrapper Custom CSS', 'weaver-xtreme')),
                'container_bgcolor_css' => weaverx_cz_css(esc_html__('Container Custom CSS', 'weaver-xtreme')),
            ),
        );

        /**
         * Links
         */
        $custom_sections['custom-links'] = array(
            'panel' => $panel,
            'title' => esc_html__('Links', 'weaver-xtreme'),
            'description' => esc_html__('Set Custom CSS for Links.', 'weaver-xtreme'),
            'options' => array(

                'link_color_css' => weaverx_cz_css(esc_html__('Standard Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for standard Links.', 'weaver-xtreme')),
                'link_hover_color_css' => weaverx_cz_css(esc_html__('Standard Links Hover Custom CSS', 'weaver-xtreme')),

                'ibarlink_color_css' => weaverx_cz_css(esc_html__('Info Bar Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for links in Info Bar.', 'weaver-xtreme')),
                'ibarlink_hover_color_css' => weaverx_cz_css(esc_html__('Info Bar Links Hover Custom CSS', 'weaver-xtreme')),

                'contentlink_color_css' => weaverx_cz_css(esc_html__('Content Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for links in content area.', 'weaver-xtreme')),
                'contentlink_hover_color_css' => weaverx_cz_css(esc_html__('Content Links Hover Custom CSS', 'weaver-xtreme')),

                'post_title_hover_color_css' => weaverx_cz_css(esc_html__('Post Title Hover Custom CSS', 'weaver-xtreme'),
                    esc_html__('The Post Title is really a link.', 'weaver-xtreme')),

                'ilink_color_css' => weaverx_cz_css(esc_html__('Post Meta Info Line Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for links in Post Meta Info Lines.', 'weaver-xtreme')),
                'ilink_hover_color_css' => weaverx_cz_css(esc_html__('Post Meta Info Line Links Hover Custom CSS', 'weaver-xtreme')),

                'wlink_color_css' => weaverx_cz_css(esc_html__('Individual Widget Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for links in widgets.', 'weaver-xtreme')),
                'wlink_hover_color_css' => weaverx_cz_css(esc_html__('Individual Widget Links Hover Custom CSS', 'weaver-xtreme')),

                'footerlink_color_css' => weaverx_cz_css(esc_html__('Footer Area Links Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for links in Footer Area.', 'weaver-xtreme')),
                'footerlink_hover_color_css' => weaverx_cz_css(esc_html__('Footer Area Links Hover Custom CSS', 'weaver-xtreme')),
            ),
        );


        /**
         * Site Header
         */
        $custom_sections['custom-header'] = array(
            'panel' => $panel,
            'title' => esc_html__('Header Area', 'weaver-xtreme'),
            'options' => array(

                'header_bgcolor_css' => weaverx_cz_css(esc_html__('Header Area Custom CSS', 'weaver-xtreme')),

                'site_title_bgcolor_css' => weaverx_cz_css(esc_html__('Site Title Custom CSS', 'weaver-xtreme')),

                'tagline_bgcolor_css' => weaverx_cz_css(esc_html__('Site Tagline Custom CSS', 'weaver-xtreme')),

                'title_tagline_bgcolor_css' => weaverx_cz_css(esc_html__('Site Title/Tagline Area Custom CSS', 'weaver-xtreme')),

                'header_sb_bgcolor_css' => weaverx_cz_css(esc_html__('Header Area Widget Area Custom CSS', 'weaver-xtreme')),

                'header_html_bgcolor_css' => weaverx_cz_css(esc_html__('Header Area HTML Area Custom CSS', 'weaver-xtreme')),
            ),
        );


        /**
         * Main Menu
         */
        $custom_sections['custom-menus'] = array(
            'panel' => $panel,
            'title' => esc_html__('Menus', 'weaver-xtreme'),
            'description' => esc_html__('Set custom for Menus.', 'weaver-xtreme'),
            'options' => array(
                'custom-mm-heading' => weaverx_cz_group_title(esc_html__('Primary Menu', 'weaver-xtreme')),

                'm_primary_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Menu Bar Custom CSS', 'weaver-xtreme')),

                'm_primary_link_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Menu Bar Link Custom CSS', 'weaver-xtreme')),

                'm_primary_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Menu Bar Link Hover Custom CSS', 'weaver-xtreme')),

                'm_primary_sub_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Sub-Menu Custom CSS', 'weaver-xtreme')),

                'm_primary_sub_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Sub-Menu Hover Custom CSS', 'weaver-xtreme')),

                'custom-sm-line1' => weaverx_cz_line(),

                // --- secondary

                'custom-sm-heading' => weaverx_cz_group_title(esc_html__('Secondary Menu', 'weaver-xtreme'),
                    esc_html__('You must define a Secondary Menu from the Custom Menus Content menu.', 'weaver-xtreme')),

                'm_secondary_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Menu Bar Custom CSS', 'weaver-xtreme')),

                'm_secondary_link_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Menu Bar Link Custom CSS', 'weaver-xtreme')),

                'm_secondary_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Menu Bar Link Hover Custom CSS', 'weaver-xtreme')),

                'm_secondary_sub_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Sub-Menu Custom CSS', 'weaver-xtreme')),

                'm_secondary_sub_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Sub-Menu Hover Custom CSS', 'weaver-xtreme')),


                'custom-minim-line1' => weaverx_cz_line(),
                // mini-menu

                'custom-minim-heading' => weaverx_cz_group_title(esc_html__('Header Mini Menu', 'weaver-xtreme'),
                    esc_html__('You must define a Header Menu from the Custom Menus Content menu.', 'weaver-xtreme')),

                'm_header_mini_bgcolor_css' => weaverx_cz_css(esc_html__('Header Mini Menu Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for full Mini Menu "bar".', 'weaver-xtreme')),
                'm_header_mini_hover_color_css' => weaverx_cz_css(esc_html__('Mini Menu Links Hover Custom CSS', 'weaver-xtreme'),
                    esc_html__('Custom CSS for for link hover items in Mini Menu.', 'weaver-xtreme')),


                'custom-allm-line1' => weaverx_cz_line(),

                'custom-allmenus-heading' => weaverx_cz_group_title(esc_html__('Custom For All Menus', 'weaver-xtreme'),
                    esc_html__('These options specify current page attributes for all menus.', 'weaver-xtreme')),

                'menubar_curpage_bgcolor_css' => weaverx_cz_css(esc_html__('Current Page', 'weaver-xtreme')),

            ),
        );

        if (weaverx_cz_is_plus()) {
            $new_opts = array(

                'custom-xm-line1' => weaverx_cz_line(),

                'custom-xm-heading' => weaverx_cz_group_title(esc_html__('Extra Menu', 'weaver-xtreme') . WEAVERX_PLUS_ICON),

                'm_extra_bgcolor_css' => weaverx_cz_css(esc_html__('Extra Menu Bar Custom CSS', 'weaver-xtreme')),

                'm_extra_link_bgcolor_css' => weaverx_cz_css(esc_html__('Extra Menu Bar Link Custom CSS', 'weaver-xtreme')),

                'm_extra_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Extra Menu Bar Link Hover Custom CSS', 'weaver-xtreme')),

                'm_extra_sub_bgcolor_css' => weaverx_cz_css(esc_html__('Extra Sub-Menu Custom CSS', 'weaver-xtreme')),

                'm_extra_sub_hover_bgcolor_css' => weaverx_cz_css(esc_html__('Extra Sub-Menu Hover Custom CSS', 'weaver-xtreme')),

            );

        } else {
            $new_opts = weaverx_cz_add_plus_message('spacing_menus', esc_html__('Extra Menu', 'weaver-xtreme'),
                esc_html__('Add extra menus with <strong>Weaver Xtreme Plus</strong>.', 'weaver-xtreme'));
        }
        // add stub or extra menu options
        $custom_sections['custom-menus']['options'] = array_merge($custom_sections['custom-menus']['options'], $new_opts);


        /**
         * Info Bar
         */
        $custom_sections['custom-info-bar'] = array(
            'panel' => $panel,
            'title' => esc_html__('Info Bar', 'weaver-xtreme'),
            'description' => esc_html__('Info Bar with breadcrumbs and paged navigation displayed under Primary Menu.', 'weaver-xtreme'),
            'options' => array(
                'custom-info-bar-heading' => weaverx_cz_heading(esc_html__('Info Bar', 'weaver-xtreme')),

                'infobar_bgcolor_css' => weaverx_cz_css(esc_html__('Info Bar Custom CSS', 'weaver-xtreme')),

            ),
        );

        /**
         * Content
         */
        $custom_sections['custom-content'] = array(
            'panel' => $panel,
            'title' => esc_html__('Content', 'weaver-xtreme'),
            'description' => esc_html__('Custom CSS for general page and post content.', 'weaver-xtreme'),
            'options' => array(
                'custom-content-heading' => weaverx_cz_heading(esc_html__('General Content', 'weaver-xtreme')),

                'content_bgcolor_css' => weaverx_cz_css(esc_html__('Content Custom CSS', 'weaver-xtreme')),

                'page_title_bgcolor_css' => weaverx_cz_css(esc_html__('Page Title Custom CSS', 'weaver-xtreme')),

                'archive_title_bgcolor_css' => weaverx_cz_css(esc_html__('Archive Page Title Custom CSS', 'weaver-xtreme')),

                'content_h_bgcolor_css' => weaverx_cz_css(esc_html__('Content H headings Custom CSS', 'weaver-xtreme')),

                'editor_bgcolor_css' => weaverx_cz_css(esc_html__('Editor Background color', 'weaver-xtreme')),    // really a no-op...

                'search_bgcolor_css' => weaverx_cz_css(esc_html__('Search Box Custom CSS', 'weaver-xtreme')),

                'hr_color_css' => weaverx_cz_css(esc_html__('&lt;HR&gt; Custom CSS', 'weaver-xtreme')),

                'comment_headings_color_css' => weaverx_cz_css(esc_html__('Comment Headings Custom CSS', 'weaver-xtreme')),

                'comment_content_bgcolor_css' => weaverx_cz_css(esc_html__('Comment Content Custom CSS', 'weaver-xtreme')),

                'comment_submit_bgcolor_css' => weaverx_cz_css(esc_html__('Comment Submit Button Custom CSS', 'weaver-xtreme')),

                'content-image-css' => weaverx_cz_heading(esc_html__('Images', 'weaver-xtreme'),
                    esc_html__('Custom CSS for Images is found on "Images : Global Image Settings".', 'weaver-xtreme')),

            ),
        );

        /**
         * Post Specific
         */
        $custom_sections['custom-post-specific'] = array(
            'panel' => $panel,
            'title' => esc_html__('Post Specific', 'weaver-xtreme'),
            'description' => esc_html__('Post Specific custom - override Content custom.', 'weaver-xtreme'),
            'options' => array(

                'custom-postspecific-heading' => weaverx_cz_heading(esc_html__('Post Specific', 'weaver-xtreme')),

                'post_bgcolor_css' => weaverx_cz_css(esc_html__('Post Area Custom CSS', 'weaver-xtreme')),

                'stickypost_bgcolor_css' => weaverx_cz_css(esc_html__('Sticky Posts Custom CSS', 'weaver-xtreme')),

                'post_title_bgcolor_css' => weaverx_cz_css(esc_html__('Post Title BG Custom CSS', 'weaver-xtreme')),

                'post_title_color_css' => weaverx_cz_css(esc_html__('Post Title Text Custom CSS', 'weaver-xtreme'),
                    esc_html__('Remember the Post Title is a link. The Hover Custom CSS found on Links menu.', 'weaver-xtreme')),

                'post_info_top_bgcolor_css' => weaverx_cz_css(esc_html__('Posts Top Meta Info Line Custom CSS', 'weaver-xtreme')),

                'post_info_bottom_bgcolor_css' => weaverx_cz_css(esc_html__('Posts Bottom Meta Info Line Custom CSS', 'weaver-xtreme')),

                'post_author_bgcolor_css' => weaverx_cz_css(esc_html__('Author Bio Custom CSS', 'weaver-xtreme')),

            ),
        );


        /**
         * Sidebars
         */
        $custom_sections['custom-sidebars'] = array(
            'panel' => $panel,
            'title' => esc_html__('Sidebars &amp; Widget Areas', 'weaver-xtreme'),
            'description' => esc_html__('Main Sidebars and Widget areas. Header and Footer areas options under Header and Footer panels.', 'weaver-xtreme'),
            'options' => array(

                'custom-primary-widget-heading' => weaverx_cz_group_title(esc_html__('Primary Widget Area', 'weaver-xtreme')),

                'primary_bgcolor_css' => weaverx_cz_css(esc_html__('Primary Widget Area Custom CSS', 'weaver-xtreme')),

                'custom-secondary-widget-heading' => weaverx_cz_group_title(esc_html__('Secondary Widget Area', 'weaver-xtreme')),

                'secondary_bgcolor_css' => weaverx_cz_css(esc_html__('Secondary Widget Area Custom CSS', 'weaver-xtreme')),

                'custom-top-widget-heading' => weaverx_cz_group_title(esc_html__('Top Widget Areas', 'weaver-xtreme'),
                    esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme')),

                'top_bgcolor_css' => weaverx_cz_css(esc_html__('Top Widget Areas Custom CSS', 'weaver-xtreme')),

                'custom-bottom-widget-heading' => weaverx_cz_group_title(esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
                    esc_html__('Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme')),

                'bottom_bgcolor_css' => weaverx_cz_css(esc_html__('Bottom Widget Areas Custom CSS', 'weaver-xtreme')),
            ),
        );

        /**
         * Widgets
         */
        $custom_sections['custom-widgets'] = array(
            'panel' => $panel,
            'title' => esc_html__('Individual Widgets', 'weaver-xtreme'),
            'options' => array(
                'custom-widgets-heading' => weaverx_cz_heading(esc_html__('Individual Widgets', 'weaver-xtreme')),

                'widget_bgcolor_css' => weaverx_cz_css(esc_html__('Individual Widget Custom CSS', 'weaver-xtreme')),

                'widget_title_bgcolor_css' => weaverx_cz_css(esc_html__('Individual Widget Title Custom CSS', 'weaver-xtreme')),


            ),
        );


        /**
         * Footer
         */
        $custom_sections['custom-footer'] = array(
            'panel' => $panel,
            'title' => esc_html__('Footer Area', 'weaver-xtreme'),
            'options' => array(

                'footer_bgcolor_css' => weaverx_cz_css(esc_html__('Footer Area Custom CSS', 'weaver-xtreme')),

                'footer_sb_bgcolor_css' => weaverx_cz_css(esc_html__('Footer Area Widget Area Custom CSS', 'weaver-xtreme')),

                'footer_html_bgcolor_css' => weaverx_cz_css(esc_html__('Footer Area HTML Area Custom CSS', 'weaver-xtreme')),
            ),
        );

    }

    return $custom_sections;
}

