<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the panel sidebars panel
 */
function weaverx_customizer_define_sidebars_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-sidebars';
    $sidebars_sections = array();

    $sidebars_sections['sidebars-layout'] = array(
        'panel' => $panel,
        'title' => esc_html__('Sidebar & Widget Area Layout', 'weaver-xtreme'),
        'description' => esc_html__('Site Sidebar &amp; Widget Area Layouts.', 'weaver-xtreme'),
        'options' => weaverx_controls_w_sidebars(),
    );


    $sidebars_sections['sidebars-primary'] = array(
        'panel' => $panel,
        'title' => esc_html__('Primary Sidebar Settings', 'weaver-xtreme'),
        'description' => esc_html__('Options for the Primary Sidebar', 'weaver-xtreme'),
        'options' => weaverx_controls_w_sidebars_primary(),
    );

    $sidebars_sections['sidebars-secondary'] = array(
        'panel' => $panel,
        'title' => esc_html__('Secondary Sidebar Settings', 'weaver-xtreme'),
        'description' => esc_html__('Options for the Secondary Sidebar', 'weaver-xtreme'),
        'options' => weaverx_controls_w_sidebars_secondary(),
    );


    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $sidebars_sections['sidebars-top-widget-area'] = array(
            'panel' => $panel,
            'title' => esc_html__('Top Widget Areas Settings', 'weaver-xtreme'),
            'description' => esc_html__('Options for the Top Widget Areas', 'weaver-xtreme'),
            'options' => weaverx_controls_w_top_widgets(),
        );

        $sidebars_sections['sidebars-bottom-widget-area'] = array(
            'panel' => $panel,
            'title' => esc_html__('Bottom Widget Areas Settings', 'weaver-xtreme'),
            'description' => esc_html__('Options for the Bottom Widget Areas', 'weaver-xtreme'),
            'options' => weaverx_controls_w_bottom_widgets(),
        );
    }

    $sidebars_sections['sidebars-individual-widgets'] = array(
        'panel' => $panel,
        'title' => esc_html__('Individual Widget Settings', 'weaver-xtreme'),
        'description' => esc_html__('Options for individual widgets in any sidebar or widget area.', 'weaver-xtreme'),
        'options' => weaverx_controls_w_individual_widgets(),
    );

    return $sidebars_sections;
}

// the definitions of the controls for each panel follow

function weaverx_controls_w_sidebars(): array
{
    $opts = array();
    $opts['layout-primary-all-heading'] = weaverx_cz_group_title(esc_html__('Sidebar Layout for Page Types', 'weaver-xtreme'),
        esc_html__('Sidebar Layout for each type of page ( "stack top" used for mobile view ).', 'weaver-xtreme')
    );

    $opts['layout_default'] = weaverx_cz_select(
        esc_html__('Blog, Post, Page Default', 'weaver-xtreme'),
        esc_html__('Select the default theme layout for blog, single post, attachments, and pages.', 'weaver-xtreme'),
        'weaverx_cz_choices_sb_layout', 'right', 'refresh'
    );


    $opts['layout_default_archive'] = weaverx_cz_select(
        esc_html__('Archive-like Default', 'weaver-xtreme'),
        esc_html__('Select the default theme layout for all other pages - archives, search, etc.', 'weaver-xtreme'),
        'weaverx_cz_choices_sb_layout', 'right', 'refresh'
    );

    $opts['layout_page'] = weaverx_cz_select(
        esc_html__('Page', 'weaver-xtreme'),
        esc_html__('Layout for normal Pages on your site.', 'weaver-xtreme'),
        'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
    );

    $opts['layout_blog'] = weaverx_cz_select(
        esc_html__('Blog', 'weaver-xtreme'),
        esc_html__('Layout for main blog page. Includes "Page with Posts" Page templates.', 'weaver-xtreme'),
        'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
    );

    $opts['layout_single'] = weaverx_cz_select(
        esc_html__('Post Single Page', 'weaver-xtreme'),
        esc_html__('Layout for Posts displayed as a single page.', 'weaver-xtreme'),
        'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
    );

    $opts['layout_full_note1'] = weaverx_cz_html_description(
        esc_html__('Weaver Xtreme Plus includes options for other archive-like pages.', 'weaver-xtreme'), 'plus');

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

        $opts['layout_attachments'] = weaverx_cz_select_plus(
            esc_html__('Attachments', 'weaver-xtreme'),
            esc_html__('Layout for attachment pages such as images.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );

        $opts['layout_archive'] = weaverx_cz_select_plus(
            esc_html__('Date Archive', 'weaver-xtreme'),
            esc_html__('Layout for archive by date pages.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );

        $opts['layout_category'] = weaverx_cz_select_plus(
            esc_html__('Category Archive', 'weaver-xtreme'),
            esc_html__('Layout for category archive pages.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );

        $opts['layout_tag'] = weaverx_cz_select_plus(
            esc_html__('Tags Archive', 'weaver-xtreme'),
            esc_html__('Layout for tag archive pages.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );

        $opts['layout_author'] = weaverx_cz_select_plus(
            esc_html__('Author Archive', 'weaver-xtreme'),
            esc_html__('Layout for author archive pages.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );

        $opts['layout_search'] = weaverx_cz_select_plus(
            esc_html__('Search Results, 404', 'weaver-xtreme'),
            esc_html__('Layout for search results and 404 pages.', 'weaver-xtreme'),
            'weaverx_cz_choices_sb_layout_default', 'default', 'refresh'
        );
    }


    $opts['spacing-sidbars-heading'] = weaverx_cz_group_title(esc_html__('Sidebar Widths', 'weaver-xtreme'),
        esc_html__('Width of the left and right vertical sidebars in the Container Area. Note that the width of the adjoining Content area is automatically determined by the sidebar layouts and widths.', 'weaver-xtreme'));

    $opts['left_sb_width_int'] = weaverx_cz_range_float(
        esc_html__('Left Sidebar Width (%)', 'weaver-xtreme'),
        '',
        25.,
        array(
            'min' => 0,
            'max' => 90,
            'step' => .5,
        )
    );

    $opts['right_sb_width_int'] = weaverx_cz_range_float(
        esc_html__('Right Sidebar Width (%)', 'weaver-xtreme'),
        '',
        25.,
        array(
            'min' => 0,
            'max' => 90,
            'step' => .5,
        )
    );

    $opts['left_split_sb_width_int'] = weaverx_cz_range_float(
        esc_html__('Width for Split Sidebar, Left Side', 'weaver-xtreme'),
        '',
        25.,
        array(
            'min' => 10,
            'max' => 100,
            'step' => .5,
        )
    );

    $opts['right_split_sb_width_int'] = weaverx_cz_range_float(
        esc_html__('Width for Split Sidebar, Right Side', 'weaver-xtreme'),
        '',
        25.,
        array(
            'min' => 10,
            'max' => 100,
            'step' => .5,
        )
    );

    $opts['flow_color'] = weaverx_cz_checkbox(
        esc_html__('Flow Color to Bottom', 'weaver-xtreme'),
        esc_html__('If checked, Content and Sidebar bg colors will flow to bottom of the Container ( that is, equal heights ). You must provide background colors for the Content and Sidebars or the default bg color will be used.', 'weaver-xtreme'),
        'plus'
    );

    return $opts;
}

function weaverx_controls_w_sidebars_primary(): array
{

    $opts = array();

    $opts['layout-primary-color-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar Colors', 'weaver-xtreme')
    );

    $opts['primary_color'] = weaverx_cz_color(
        'primary_color',
        esc_html__('Primary Sidebar Text Color', 'weaver-xtreme')
    );

    $opts['primary_bgcolor'] = weaverx_cz_color(
        'primary_bgcolor',
        esc_html__('Primary Sidebar BG Color', 'weaver-xtreme')
    );

    $opts['layout-primary-widget-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar Columns', 'weaver-xtreme')
    );

    $opts['primary_cols_int'] = weaverx_cz_range(
        esc_html__('Columns of Widgets', 'weaver-xtreme'),
        '',
        1,
        array(
            'min' => 1,
            'max' => 8,
            'step' => 1,
        )
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full


        $opts['layout-primary-custom-widths'] = weaverx_cz_heading(esc_html__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
            esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme')
        );

        $opts['_primary_lw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Desktop Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths separated by comma. Use semi-colon ( ; ) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
            '1',
            esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
            'refresh',
            'plus'
        );

        $opts['_primary_mw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );

        $opts['_primary_sw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Phone Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );


        $opts['primary_no_widget_margins'] = weaverx_cz_checkbox(
            esc_html__('No Smart Widget Margins', 'weaver-xtreme'),
            esc_html__('Do not use "smart margins" between  multi-column widgets on rows.', 'weaver-xtreme')
        );


        $opts['primary_eq_widgets'] = weaverx_cz_checkbox(
            esc_html__('Equal Height Widget Rows', 'weaver-xtreme'),
            esc_html__('Make widgets equal height rows if &gt; 1 column.', 'weaver-xtreme'),
            'plus'
        );

        $opts['primary_add_class'] = weaverx_cz_add_class(esc_html__('Primary Widget Area: Add Classes', 'weaver-xtreme'));

    }

    $opts = array_merge($opts, weaverx_cz_fonts_control('primary', esc_html__('Primary Sidebar Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts['spacing-primary-widget-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar Spacing', 'weaver-xtreme'));

    $opts['primary_padding_T'] = weaverx_cz_range(
        esc_html__('Top Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['primary_padding_B'] = weaverx_cz_range(
        esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['primary_padding_L'] = weaverx_cz_range(
        esc_html__('Left Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['primary_padding_R'] = weaverx_cz_range(
        esc_html__('Right Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['primary_margin_T'] = weaverx_cz_range(
        esc_html__('Top Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['primary_margin_B'] = weaverx_cz_range(
        esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
        '',
        10,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['spacing-primary-widthinfo'] = weaverx_cz_heading(esc_html__('Width', 'weaver-xtreme'),
        esc_html__('The width of this area is automatically determined by the enclosing area.', 'weaver-xtreme'));

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['primary_smartmargin'] = weaverx_cz_checkbox(
            esc_html__('Add Side Margin(s)', 'weaver-xtreme'),
            esc_html__('Automatically add left/right "smart" margins for separation of areas ( sidebar/content ). This is normally used only if you have borders or BG colors for your sidebars.', 'weaver-xtreme')
        );
    }

    $opts['style-primary-widget-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar Style', 'weaver-xtreme'));

    $opts['primary_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border', 'weaver-xtreme')
    );

    $opts['primary_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['primary_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['sb_primary_hide_m'] = weaverx_cz_group_title(esc_html__('Primary Sidebar Visibility', 'weaver-xtreme'));

    $opts['primary_hide'] = weaverx_cz_select(
        esc_html__('Hide Primary Sidebar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

        if (weaverx_cz_is_plus()) {
            $opts = array_merge($opts,
                weaverx_cz_add_image('widgets_primary', esc_html__('Primary Sidebar Area BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for primary widget area (#primary-widget-area)', 'weaver-xtreme')
                )
            );
        }
    }

    return $opts;
}

function weaverx_controls_w_sidebars_secondary(): array
{
    $opts = array();

    $opts['layout-secondary-color-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar Colors', 'weaver-xtreme')
    );

    $opts['secondary_color'] = weaverx_cz_color(
        'secondary_color',
        esc_html__('Secondary Sidebar Text Color', 'weaver-xtreme')
    );

    $opts['secondary_bgcolor'] = weaverx_cz_color(
        'secondary_bgcolor',
        esc_html__('Secondary Sidebar BG Color', 'weaver-xtreme')
    );

    $opts = array_merge($opts, weaverx_cz_fonts_control('secondary', esc_html__('Secondary Sidebar Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts['layout-secondary-widget-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar Columns', 'weaver-xtreme'));

    $opts['secondary_cols_int'] = weaverx_cz_range(
        esc_html__('Columns of Widgets', 'weaver-xtreme'),
        '',
        1,
        array(
            'min' => 1,
            'max' => 8,
            'step' => 1,
        )
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

        $opts['layout-secondary-custom-widths'] = weaverx_cz_heading(esc_html__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
            esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme'));

        $opts['_secondary_lw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Desktop Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths separated by comma. Use semi-colon ( ; ) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
            '1',
            esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
            'refresh',
            'plus'
        );

        $opts['_secondary_mw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );

        $opts['_secondary_sw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Phone Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );


        $opts['secondary_no_widget_margins'] = weaverx_cz_checkbox(
            esc_html__('No Smart Widget Margins', 'weaver-xtreme'),
            esc_html__('Do not use "smart margins" between multi-column widgets on rows.', 'weaver-xtreme')
        );


        $opts['secondary_eq_widgets'] = weaverx_cz_checkbox(
            esc_html__('Equal Height Widget Rows', 'weaver-xtreme'),
            esc_html__('Make widgets equal height rows if &gt; 1 column.', 'weaver-xtreme'),
            'plus'
        );
    }

    $opts['spacing-secondary-widget-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar Spacing', 'weaver-xtreme'));

    $opts['secondary_padding_T'] = weaverx_cz_range(
        esc_html__('Top Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['secondary_padding_B'] = weaverx_cz_range(
        esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['secondary_padding_L'] = weaverx_cz_range(
        esc_html__('Left Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['secondary_padding_R'] = weaverx_cz_range(
        esc_html__('Right Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['secondary_margin_T'] = weaverx_cz_range(
        esc_html__('Top Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['secondary_margin_B'] = weaverx_cz_range(
        esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
        '',
        10,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['spacing-secondary-widthinfo'] = weaverx_cz_heading(
        esc_html__('Width', 'weaver-xtreme'),
        esc_html__('The width of this area is automatically determined by the enclosing area.', 'weaver-xtreme'));

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['secondary_smartmargin'] = weaverx_cz_checkbox(
            esc_html__('Add Side Margin(s)', 'weaver-xtreme'),
            esc_html__('Automatically add left/right "smart" margins for separation of areas ( sidebar/content ). This is normally used only if you have borders or BG colors for your sidebars.', 'weaver-xtreme')
        );
    }

    $opts['style-secondary-widget-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar Style', 'weaver-xtreme'));

    $opts['secondary_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border', 'weaver-xtreme')
    );

    $opts['secondary_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['secondary_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['sb_secondary_hide_m2'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar Visibility', 'weaver-xtreme'));

    $opts['secondary_hide'] = weaverx_cz_select(
        esc_html__('Hide Secondary Sidebar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

        $opts['secondary_add_class'] = weaverx_cz_add_class(esc_html__('Secondary Sidebar Area: Add Classes', 'weaver-xtreme'));

        if (weaverx_cz_is_plus()) {
            $opts = array_merge($opts,
                weaverx_cz_add_image('widgets_secondary', esc_html__('Secondary Sidebar Areas BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for secondary widget areas (#secondary-widget-area)', 'weaver-xtreme'))
            );
        }
    }

    return $opts;
}


if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show top_widgets if full
    function weaverx_controls_w_top_widgets(): array
    {
        $opts = array();

        // Top Widget areas


        $opts['sidebar-top-widget-heading'] = weaverx_cz_group_title(esc_html__('Top Widget Areas', 'weaver-xtreme'),
            esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

        $opts['top_color'] = weaverx_cz_color(
            'top_color',
            esc_html__('Top Widget Areas Text Color', 'weaver-xtreme')
        );

        $opts['top_bgcolor'] = weaverx_cz_color(
            'top_bgcolor',
            esc_html__('Top Widget Areas BG Color', 'weaver-xtreme')
        );

        $opts = array_merge($opts, weaverx_cz_fonts_control('top', esc_html__('Top Widget Areas Typography', 'weaver-xtreme'),
            esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'), 'postMessage'));


        $opts['sidebar-top-widget-cols'] = weaverx_cz_group_title(esc_html__('Width &amp; Columns', 'weaver-xtreme')
        );

        $opts['top_cols_int'] = weaverx_cz_range(
            esc_html__('Columns of Widgets', 'weaver-xtreme'),
            '',
            1,
            array(
                'min' => 1,
                'max' => 8,
                'step' => 1,
            )
        );


        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

            $opts['layout-top-custom-widths'] = weaverx_cz_heading(esc_html__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
                esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme'));

            $opts['_top_lw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Desktop Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths separated by comma. Use semi-colon ( ; ) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
                '1',
                esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
                'refresh',
                'plus'
            );

            $opts['_top_mw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
                '1',
                '',
                'refresh',
                'plus'
            );

            $opts['_top_sw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
                '1',
                '',
                'refresh',
                'plus'
            );

            $opts['top_no_widget_margins'] = weaverx_cz_checkbox(
                esc_html__('No Smart Widget Margins', 'weaver-xtreme'),
                esc_html__('Do not use "smart margins" between multi-column widgets on rows.',
                    'weaver-xtreme')
            );

            $opts['top_eq_widgets'] = weaverx_cz_checkbox(
                esc_html__('Equal Height Widget Rows', 'weaver-xtreme'),
                esc_html__('Make widgets equal height rows if &gt; 1 column.',
                    'weaver-xtreme'),
                'plus'
            );
        }

        $opts['spacing-top-widget-heading'] = weaverx_cz_group_title(esc_html__('Top Widget Areas Spacing', 'weaver-xtreme'),
            esc_html__('Spacing for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

        $opts['top_width_int'] = weaverx_cz_range_float(
            esc_html__('Top Widget Areas Width (%)', 'weaver-xtreme'),
            esc_html__('Width of Area in % of enclosing area on desktop and small tablet. Hint: use with Container "Center align" setting. (Default: 0, means auto)', 'weaver-xtreme'),
            0,
            array(
                'min' => 0,
                'max' => 100,
                'step' => .5,
            )
        );


        $opts['top_align'] = weaverx_cz_select(
            esc_html__('Align Widget Area', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_align', 'float-left', 'refresh'
        );

        $opts['top_padding_T'] = weaverx_cz_range(
            esc_html__('Top Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['top_padding_B'] = weaverx_cz_range(
            esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['top_padding_L'] = weaverx_cz_range(
            esc_html__('Left Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['top_padding_R'] = weaverx_cz_range(
            esc_html__('Right Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['top_margin_T'] = weaverx_cz_range(
            esc_html__('Top Margin (px)', 'weaver-xtreme'),
            '',
            10,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['top_margin_B'] = weaverx_cz_range(
            esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
            '',
            10,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['style-top-widget-style'] = weaverx_cz_group_title(esc_html__('Top Widget Areas Style', 'weaver-xtreme'),
            esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme')
        );

        $opts['top_border'] = weaverx_cz_checkbox_post(
            esc_html__('Add border', 'weaver-xtreme')
        );

        $opts['top_shadow'] = weaverx_cz_select(
            esc_html__('Add shadow', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_shadow', '-0', 'postMessage'
        );

        $opts['top_rounded'] = weaverx_cz_select(
            esc_html__('Add rounded corners', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
        );


        $opts['sb_topwa_hide_m'] = weaverx_cz_group_title(esc_html__('Top Widget Areas Visibility', 'weaver-xtreme'));

        $opts['top_hide'] = weaverx_cz_select(
            esc_html__('Hide Top Widget Areas', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_hide', 'hide-none', 'refresh'
        );

        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
            $opts['top_add_class'] = weaverx_cz_add_class(esc_html__('Top Widget Areas: Add Classes', 'weaver-xtreme'));
        }

        return $opts;
    }
}

if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show bottom widgets if full

    function weaverx_controls_w_bottom_widgets(): array
    {
        $opts = array();

// Bottom Widget areas

        $opts['layout-bottom-widget-heading'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
            esc_html__('Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

        $opts['bottom_color'] = weaverx_cz_color(
            'bottom_color',
            esc_html__('Bottom Widget Areas Text Color', 'weaver-xtreme')
        );

        $opts['bottom_bgcolor'] = weaverx_cz_color(
            'bottom_bgcolor',
            esc_html__('Bottom Widget Areas BG Color', 'weaver-xtreme')
        );

        $opts = array_merge($opts, weaverx_cz_fonts_control('bottom', esc_html__('Bottom Widget Areas Typography', 'weaver-xtreme'),
            esc_html__('Typography for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'), 'postMessage'));


        $opts['spacing-bot-widget-wide'] = weaverx_cz_group_title(esc_html__('Columns &amp; Width', 'weaver-xtreme'));

        $opts['bottom_cols_int'] = weaverx_cz_range(
            esc_html__('Columns of Widgets', 'weaver-xtreme'),
            '',
            1,
            array(
                'min' => 1,
                'max' => 8,
                'step' => 1,
            )
        );


        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full

            $opts['layout-bottom-custom-widths'] = weaverx_cz_heading(esc_html__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
                esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme'));

            $opts['_bottom_lw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Desktop Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths separated by comma. Use semi-colon ( ; ) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
                '1',
                esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
                'refresh',
                'plus'
            );

            $opts['_bottom_mw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
                '1',
                '',
                'refresh',
                'plus'
            );

            $opts['_bottom_sw_cols_list'] = weaverx_cz_textarea(
                esc_html__('Small Tablet Widget Widths', 'weaver-xtreme'),
                esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
                '1',
                '',
                'refresh',
                'plus'
            );

            $opts['bottom_no_widget_margins'] = weaverx_cz_checkbox(
                esc_html__('No Smart Widget Margins', 'weaver-xtreme'),
                esc_html__('Do not use "smart margins" between multi-column widgets on rows.',
                    'weaver-xtreme')
            );

            $opts['bottom_eq_widgets'] = weaverx_cz_checkbox(
                esc_html__('Equal Height Widget Rows', 'weaver-xtreme'),
                esc_html__('Make widgets equal height rows if &gt; 1 column.',
                    'weaver-xtreme'),
                'plus'
            );
        }

// Bottom Widget Areas

        $opts['spacing-bot-widget-heading'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas Spacing', 'weaver-xtreme'),
            esc_html__('Spacing for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

        $opts['bottom_width_int'] = weaverx_cz_range_float(
            esc_html__('Bottom Widget Areas Width (%)', 'weaver-xtreme'),
            esc_html__('Width of Area in % of enclosing area on desktop and small tablet. Hint: use with Container "Center align" setting. (Default: 0, means auto)', 'weaver-xtreme'),
            0,
            array(
                'min' => 0,
                'max' => 100,
                'step' => .5,
            )
        );


        $opts['bottom_align'] = weaverx_cz_select(
            esc_html__('Align Widget Area', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_align', 'float-left', 'refresh'
        );

        $opts['bottom_padding_T'] = weaverx_cz_range(
            esc_html__('Top Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['bottom_padding_B'] = weaverx_cz_range(
            esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['bottom_padding_L'] = weaverx_cz_range(
            esc_html__('Left Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['bottom_padding_R'] = weaverx_cz_range(
            esc_html__('Right Padding (px)', 'weaver-xtreme'),
            '',
            8,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['bottom_margin_T'] = weaverx_cz_range(
            esc_html__('Top Margin (px)', 'weaver-xtreme'),
            '',
            10,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['bottom_margin_B'] = weaverx_cz_range(
            esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
            '',
            10,
            array(
                'min' => 0,
                'max' => 150,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['style-bottom-widget-style'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas Style', 'weaver-xtreme')
        );

        $opts['bottom_border'] = weaverx_cz_checkbox_post(
            esc_html__('Add border', 'weaver-xtreme')
        );

        $opts['bottom_shadow'] = weaverx_cz_select(
            esc_html__('Add shadow', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_shadow', '-0', 'postMessage'
        );

        $opts['bottom_rounded'] = weaverx_cz_select(
            esc_html__('Add rounded corners', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
        );

        $opts['sb_bot_hide_m'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas Visibility', 'weaver-xtreme'));

        $opts['bottom_hide'] = weaverx_cz_select(
            esc_html__('Hide Bottom Widget Areas', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_hide', 'hide-none', 'refresh'
        );

        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
            $opts['bottom_add_class'] = weaverx_cz_add_class(esc_html__('Bottom Widget Areas: Add Classes', 'weaver-xtreme'));
        }


        return $opts;
    }
}

function weaverx_controls_w_individual_widgets(): array
{
    $opts = array();

    $opts['widget_color_title01x'] = weaverx_cz_group_title(esc_html__('Individual Widgets Colors', 'weaver-xtreme'));

    $opts['widget_color'] = weaverx_cz_color(
        'widget_color',
        esc_html__('Individual Widgets Text Color', 'weaver-xtreme')
    );

    $opts['widget_bgcolor'] = weaverx_cz_color(
        'widget_bgcolor',
        esc_html__('Individual Widgets BG Color', 'weaver-xtreme')
    );

    $opts['widget_title_color'] = weaverx_cz_color(
        'widget_title_color',
        esc_html__('Individual Widgets Title Text Color', 'weaver-xtreme')
    );

    $opts['widget_title_bgcolor'] = weaverx_cz_color(
        'widget_title_bgcolor',
        esc_html__('Individual Widgets Title BG Color', 'weaver-xtreme')
    );

    $opts['wlink_color'] = weaverx_cz_color(
        'wlink_color',
        esc_html__('Individual Widgets Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['wlink_hover_color'] = weaverx_cz_color(
        'wlink_hover_color',
        esc_html__('Individual Widgets Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts = array_merge($opts, weaverx_cz_fonts_control('widget', esc_html__('Individual Widgets Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('widget_title', esc_html__('Individual Widgets Title Typography', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('wlink', esc_html__('Individual Widget Links Typography', 'weaver-xtreme'),
        esc_html__('Typography for links in widgets ( uses Standard Link colors if inherit ).', 'weaver-xtreme')));

    $opts['widget-style-heading11'] = weaverx_cz_group_title(esc_html__('Widget Style Spacing', 'weaver-xtreme'));

    $opts['widget_padding_T'] = weaverx_cz_range(
        esc_html__('Top Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget_padding_B'] = weaverx_cz_range(
        esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget_padding_L'] = weaverx_cz_range(
        esc_html__('Left Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget_padding_R'] = weaverx_cz_range(
        esc_html__('Right Padding (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget_margin_T'] = weaverx_cz_range(
        esc_html__('Top Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget_margin_B'] = weaverx_cz_range(
        esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widget-style-heading1'] = weaverx_cz_group_title(esc_html__('Widget Style', 'weaver-xtreme'));

    $opts['widget_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border', 'weaver-xtreme')
    );

    $opts['widget_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Individual Widgets', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['widget_rounded'] = weaverx_cz_select(
        esc_html__('Rounded corners', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['widget_title_underline_int'] = weaverx_cz_range(
        esc_html__('Bar under Widget Titles (px)', 'weaver-xtreme'),
        esc_html__('Enter size in px if you want a bar under Widget Titles. Leave 0 for no bar. Color matches title.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 20,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['widgetlist_bullet'] = weaverx_cz_select(
        esc_html__('Widget List Bullet', 'weaver-xtreme'),
        esc_html__('Bullet used for Unordered Lists in Widget areas.', 'weaver-xtreme'),
        'weaverx_cz_choices_list_bullets', 'disc', 'postMessage'
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['content-widgetarea-heading'] = weaverx_cz_group_title(
            esc_html__('Define Per Page Extra Widget Areas', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_OBSOLETE,
            wp_kses_post(__('<p>This option can be set only from the Legacy Interface on the <em>Main Options &rarr; Sidebars &amp; Layout</em> menu. This option is fairly difficult to use, so please see the help file.</p><p>Essentially, you may define extra widget areas that can then be used in the <em>Per Page</em> settings, or in the <em>Weaver Xtreme Plus</em> [widget_area] shortcode. (&diams;)</p>', 'weaver-xtreme'))
        );

        $opts['widget_add_class'] = weaverx_cz_add_class(esc_html__('Individual Widget: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}

