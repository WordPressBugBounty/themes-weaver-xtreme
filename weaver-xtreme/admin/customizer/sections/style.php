<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the style panel
 *
 */
function weaverx_customizer_define_style_sections(): array
{
    $panel = 'weaverx_style';
    $style_sections = array();

    // global settings
    $style_sections['style-global'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global Style Options', 'weaver-xtreme'),
        'description' => 'Set some global settings that affect style.',
        'options' => weaverx_controls_style_global(),
    );


    /**
     * Wrapping
     */
    $style_sections['style-wrapping'] = array(
        'panel' => $panel,
        'title' => esc_html__('Wrapping Areas', 'weaver-xtreme'),
        'description' => esc_html__('Set borders, shadows, and rounded corners for main Wrapper and Container wrapping areas.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_wrapping(),
    );


    /**
     * Site Header
     */
    $style_sections['style-header'] = array(
        'panel' => $panel,
        'title' => esc_html__('Header Area', 'weaver-xtreme'),
        'options' => weaverx_controls_style_header(),
    );


    /**
     * Main Menu
     */
    $style_sections['style-menus'] = array(
        'panel' => $panel,
        'title' => esc_html__('Menus', 'weaver-xtreme'),
        'description' => esc_html__('Set style for Menus.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_menus(),

    );


    /**
     * Info Bar
     */
    $style_sections['style-info-bar'] = array(
        'panel' => $panel,
        'title' => esc_html__('Info Bar', 'weaver-xtreme'),
        'description' => esc_html__('Info Bar with breadcrumb and paged navigation displayed under Primary Menu.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_infobar(),
    );


    /**
     * Content
     */
    $style_sections['style-content'] = array(
        'panel' => $panel,
        'title' => esc_html__('Content', 'weaver-xtreme'),
        'description' => esc_html__('style for general page and post content.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_content(),
    );


    /**
     * Post Specific
     */
    $style_sections['style-post-specific'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Specific', 'weaver-xtreme'),
        'description' => esc_html__('Post Specific style - override Content style.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_postspecific(),
    );


    /**
     * Sidebars
     */
    $style_sections['style-sidebars'] = array(
        'panel' => $panel,
        'title' => esc_html__('Sidebars &amp; Widget Areas', 'weaver-xtreme'),
        'description' => esc_html__('Style for Main Sidebars and Widget areas.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_sidebars(),
    );


    /**
     * Widgets
     */
    $style_sections['style-widgets'] = array(
        'panel' => $panel,
        'title' => esc_html__('Individual Widgets', 'weaver-xtreme'),
        'description' => esc_html__('Styling for individual widgets.', 'weaver-xtreme'),
        'options' => weaverx_controls_style_widgets(),
    );


    /**
     * Footer
     */
    $style_sections['style-footer'] = array(
        'panel' => $panel,
        'title' => esc_html__('Footer Area', 'weaver-xtreme'),
        'options' => weaverx_controls_style_footer(),
    );

    return $style_sections;
}

function weaverx_controls_style_global(): array
{
    $opts = array();


    $opts['border_color'] = weaverx_cz_color(
        'border_color',
        esc_html__('Border Color...', 'weaver-xtreme'),
        esc_html__('Color for all borders.', 'weaver-xtreme')
    );

    $opts['border_width_int'] = weaverx_cz_range(
        esc_html__('Border Width (px)', 'weaver-xtreme'),
        '',
        1,
        array(
            'min' => 1,
            'max' => 20,
            'step' => 1,
        ),
        'postMessage'
    );


    $opts['border_style'] = weaverx_cz_select_plus(
        esc_html__('Border Style', 'weaver-xtreme'),
        esc_html__('Style of borders - width needs to be &gt; 1 and color other than black for some styles to work correctly.', 'weaver-xtreme'),
        array(
            'solid' => esc_html__('Solid', 'weaver-xtreme'),
            'dotted' => esc_html__('Dotted', 'weaver-xtreme'),
            'dashed' => esc_html__('Dashed', 'weaver-xtreme'),
            'double' => esc_html__('Double', 'weaver-xtreme'),
            'groove' => esc_html__('Groove', 'weaver-xtreme'),
            'ridge' => esc_html__('Ridge', 'weaver-xtreme'),
            'inset' => esc_html__('Inset', 'weaver-xtreme'),
            'outset' => esc_html__('Outset', 'weaver-xtreme'),
        ),
        'solid', 'refresh'
    );

    $opts['rounded_corners_radius'] = weaverx_cz_range(
        esc_html__('Corner Radius (px)', 'weaver-xtreme'),
        esc_html__('Controls how "round" corners are. Specify a value ( 5 to 15 look best ) for corner radius.', 'weaver-xtreme'),
        8,
        array(
            'min' => 1,
            'max' => 20,
            'step' => 1,
        ),
        'refresh',
        'plus'
    );

    $opts['custom_shadow'] = weaverx_cz_textarea(
        esc_html__('Custom Shadow', 'weaver-xtreme'),
        weaverx_markdown(__('This defines the **Custom Shadow** shown on the **Add shadow** options. You will have to select **Custom Shadow** to use the shadow style you define here. Specify full **box-shadow** CSS rule.', 'weaver-xtreme')),
        1,
        esc_html__('{box-shadow: 0 0 3px 1px rgba( 0,0,0,0.25 );} /* for example */', 'weaver-xtreme'),
        'refresh',
        'plus',
        'weaverx_cz_sanitize_css'
    );

    return $opts;
}

function weaverx_controls_style_wrapping(): array
{
    $opts = array();

    $opts['wrapper-style-genopts'] = weaverx_cz_group_title(esc_html__('General Style Global Options', 'weaver-xtreme'),
        esc_html__('These settings control global attributes of borders, etc.', 'weaver-xtreme'));

    $opts['wrapper-style-heading'] = weaverx_cz_group_title(esc_html__('Wrapper Area', 'weaver-xtreme'),
        esc_html__('The Wrapper is the &lt;div&gt; that wraps entire site.', 'weaver-xtreme'));

    $opts['wrapper_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border', 'weaver-xtreme')
    );

    $opts['wrapper_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['wrapper_rounded'] = weaverx_cz_select(
        esc_html__('Rounded corners', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['container-style-heading'] = weaverx_cz_group_title(esc_html__('Container Area', 'weaver-xtreme'),
        esc_html__('The Container is the &lt;div&gt; that wraps site content areas, including sidebars. Does not include Header and Footer.', 'weaver-xtreme'));

    $opts['container_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border around Container', 'weaver-xtreme')
    );

    $opts['container_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['container_rounded'] = weaverx_cz_select(
        esc_html__('Rounded corners', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    return $opts;
}

function weaverx_controls_style_header(): array
{
    $opts = array();

    $opts['style-heading-header'] = weaverx_cz_group_title(esc_html__('Site Header Area Borders', 'weaver-xtreme'));

    $opts['header_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to entire Header Area', 'weaver-xtreme')
    );

    $opts['header_sb_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Header Widget Area', 'weaver-xtreme')
    );

    $opts['header_html_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Header HTML Area', 'weaver-xtreme')
    );


    $opts['style-shadow-header'] = weaverx_cz_group_title(esc_html__('Site Header Area Shadows', 'weaver-xtreme'));

    $opts['header_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to header', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['header_sb_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Header Widget Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );


    $opts['header_html_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Header HTML Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );


    //  rounded

    $opts['style-rounded-header'] = weaverx_cz_group_title(esc_html__('Site Header Rounded Corners', 'weaver-xtreme'),
        esc_html__('Note that rounded corners require borders or bg color to show, and interact with surrounding areas. You may have to set several options to get rounded corners to display.', 'weaver-xtreme'));

    $opts['header_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Header Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['header_sb_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Header Widget Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['header_html_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Header HTML Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    return $opts;
}

function weaverx_controls_style_menus(): array
{
    $opts = array();


    $opts['style-m-heading'] = weaverx_cz_group_title(
        esc_html__('Primary Menu', 'weaver-xtreme')
    );

    $opts['m_primary_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Primary Menu bar', 'weaver-xtreme'));

    $opts['m_primary_sub_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Sub-Menus', 'weaver-xtreme'));

    $opts['m_primary_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to menu bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['m_primary_sub_noshadow'] = weaverx_cz_heading(
        esc_html__('Add Shadow to Sub-Menus', 'weaver-xtreme'),
        esc_html__('Sub-Menus do not support shadows.', 'weaver-xtreme')
    );

    $opts['m_primary_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to menu bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['m_primary_sub_rounded'] = weaverx_cz_checkbox(
        esc_html__('Rounded Primary Sub-Menu corners', 'weaver-xtreme')
    );

    // Secondary Menu

    $opts['style-ms-heading'] = weaverx_cz_group_title(
        esc_html__('Secondary Menu', 'weaver-xtreme')
    );

    $opts['m_secondary_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Secondary Menu bar', 'weaver-xtreme'));

    $opts['m_secondary_sub_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Sub-Menus', 'weaver-xtreme'));

    $opts['m_secondary_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to menu bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['m_secondary_sub_noshadow'] = weaverx_cz_heading(
        esc_html__('Add Shadow to Sub-Menus', 'weaver-xtreme'),
        esc_html__('Sub-Menus do not support shadows.', 'weaver-xtreme')
    );

    $opts['m_secondary_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to menu bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['m_secondary_sub_rounded'] = weaverx_cz_checkbox(
        esc_html__('Rounded Secondary Sub-Menu corners', 'weaver-xtreme')
    );


    $opts['style-allmenus-heading'] = weaverx_cz_group_title(esc_html__('Style For All Menus', 'weaver-xtreme'),
        esc_html__('These options specify current page attributes for all menus.', 'weaver-xtreme'));

    $opts['placeholder_cursor'] = weaverx_cz_select(
        esc_html__('Placeholder Menu Hover Cursor', 'weaver-xtreme'),
        esc_html__('Cursor :hover attribute for placeholder menu items ( only with Custom Menu Items with URL==# ).', 'weaver-xtreme'),
        array(
            'pointer' => esc_html__('Pointer ( indicates link)', 'weaver-xtreme'),
            'context-menu' => esc_html__('Context Menu available', 'weaver-xtreme'),
            'text' => esc_html__('Text', 'weaver-xtreme'),
            'none' => esc_html__('No pointer', 'weaver-xtreme'),
            'not-allowed' => esc_html__('Action not allowed', 'weaver-xtreme'),
            'default' => esc_html__('The default cursor', 'weaver-xtreme'),
        ),
        'pointer', 'refresh'
    );


    if (weaverx_cz_is_plus()) {

        $opts['style-xm-line1'] = weaverx_cz_line();

        // secondary menu

        $opts['style-xm-heading'] = weaverx_cz_group_title(
            esc_html__('Extra Menu', 'weaver-xtreme')
        );

        $opts['m_extra_border'] = weaverx_cz_checkbox_post(
            esc_html__('Add border to Extra Menu bar', 'weaver-xtreme'));

        $opts['m_extra_sub_border'] = weaverx_cz_checkbox_post(
            esc_html__('Add border to Sub-Menus', 'weaver-xtreme'));

        $opts['m_extra_shadow'] = weaverx_cz_select(
            esc_html__('Add shadow to menu bar', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_shadow', '-0', 'postMessage'
        );

        $opts['m_extra_sub_noshadow'] = weaverx_cz_heading(
            esc_html__('Add Shadow to Sub-Menus', 'weaver-xtreme'),
            esc_html__('Sub-Menus do not support shadows.', 'weaver-xtreme')
        );

        $opts['m_extra_rounded'] = weaverx_cz_select(
            esc_html__('Add rounded corners to menu bar', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
        );

        $opts['m_extra_sub_rounded'] = weaverx_cz_checkbox(
            esc_html__('Rounded Extra Sub-Menu corners', 'weaver-xtreme')
        );

    } else {
        $opts['style_menu_plus_msg_1'] = weaverx_cz_add_plus_message('style_menus', esc_html__('Extra Menu', 'weaver-xtreme'),
            esc_html__('Add extra menus with <strong>Weaver Xtreme Plus</strong>.', 'weaver-xtreme'));
    }


    return $opts;
}

function weaverx_controls_style_infobar(): array
{
    $opts = array();

    $opts['infobar_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Info Bar', 'weaver-xtreme')
    );

    $opts['infobar_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Info Bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['infobar_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Info Bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    return $opts;
}

function weaverx_controls_style_content(): array
{
    $opts = array();

    $opts['content_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Content Area', 'weaver-xtreme')
    );

    $opts['content_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Content Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['content_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Content Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['page_title_underline_int'] = weaverx_cz_range(
        esc_html__('Bar under Page Title (px)', 'weaver-xtreme'),
        esc_html__('Enter size in px if you want a bar under Page Titles. Leave 0 for no bar. Color matches title.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 20,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['contentlist_bullet'] = weaverx_cz_select(
        esc_html__('Content List Bullet Style', 'weaver-xtreme'),
        esc_html__('Bullet used for Unordered Lists in Content.', 'weaver-xtreme'),
        'weaverx_cz_choices_list_bullets', 'disc', 'postMessage'
    );

    $opts['weaverx_tables'] = weaverx_cz_select(
        esc_html__('Table Style', 'weaver-xtreme'),
        weaverx_markdown(__('Style used for tables in content. ***WARNING!*** Tables are inherently non-responsive, and *do not* work well for mobile devices. We advise you to avoid using tables.', 'weaver-xtreme')),
        array(
            'default' => esc_html__('Theme Default', 'weaver-xtreme'),
            'bold' => esc_html__('Bold Headings', 'weaver-xtreme'),
            'noborders' => esc_html__('No Border', 'weaver-xtreme'),
            'fullwidth' => esc_html__('Wide', 'weaver-xtreme'),
            'wide' => esc_html__('Wide 2', 'weaver-xtreme'),
            'plain' => esc_html__('Minimal', 'weaver-xtreme'),
        ),
        'default', 'refresh'
    );

    $opts['show_comment_borders'] = weaverx_cz_checkbox(
        esc_html__('Show Borders on Comments', 'weaver-xtreme'),
        esc_html__('Show Borders around comment sections - improves visual look of comments.', 'weaver-xtreme'),
        'plus',
        'postMessage'
    );

    return $opts;
}

function weaverx_controls_style_postspecific(): array
{
    $opts = array();


    $opts['post_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Posts', 'weaver-xtreme')
    );

    $opts['post_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to posts', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['post_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to posts', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['style_single_like_content'] = weaverx_cz_checkbox(
            esc_html__('Style Single Page View to match Content', 'weaver-xtreme'),
            esc_html__('Allows Single Page post view to match normal content page styling while allowing different styling for post blog-like list views. Includes typography, colors, borders, shadows, and rounded corners.', 'weaver-xtreme')
        );
    }

    $opts['post_icons'] = weaverx_cz_select(
        esc_html__('Text or Icons for Post Info', 'weaver-xtreme'),
        esc_html__('Use Icons instead of Text descriptions in Post Meta Info. You can specify a color for the Font Icons on the "Color &rarr; Post Specific" panel.', 'weaver-xtreme'),
        array(
            'text' => esc_html__('Text Descriptions', 'weaver-xtreme'),
            'fonticons' => esc_html__('Font Icons', 'weaver-xtreme'),
            'graphics' => esc_html__('Graphic Icons', 'weaver-xtreme'),
        ),
        'text', 'refresh'
    );

    $opts['post_title_underline_int'] = weaverx_cz_range(
        esc_html__('Bar under Post Titles (px)', 'weaver-xtreme'),
        esc_html__('Enter size in px if you want a bar under Post Titles. Leave 0 for no bar. Color matches title.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 20,
            'step' => 1,
        ),
        'postMessage'
    );

    return $opts;
}

function weaverx_controls_style_sidebars(): array
{
    $opts = array();

    $opts['style-primary-widget-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar', 'weaver-xtreme'));

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

    $opts['style-secondary-widget-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar', 'weaver-xtreme'));

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

    $opts['style-top-widget-heading'] = weaverx_cz_group_title(esc_html__('Top Widget Areas', 'weaver-xtreme'),
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

    $opts['style-bottom-widget-heading'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme')
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

    return $opts;
}

function weaverx_controls_style_widgets(): array
{
    $opts = array();


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

    return $opts;
}

function weaverx_controls_style_footer(): array
{
    $opts = array();

    $opts['style-footer-heading'] = weaverx_cz_group_title(esc_html__('Footer Borders', 'weaver-xtreme'));

    $opts['footer_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Footer Area', 'weaver-xtreme')
    );

    $opts['footer_sb_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Footer Widget Area', 'weaver-xtreme')
    );

    $opts['footer_html_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Footer HTML Area', 'weaver-xtreme')
    );

    $opts['style-footer-shadow-heading'] = weaverx_cz_group_title(esc_html__('Footer Shadows', 'weaver-xtreme'));

    $opts['footer_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Footer Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['footer_sb_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to Footer Widget Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['footer_html_shadow'] = weaverx_cz_select(
        esc_html__('Add shadow to HTML Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_shadow', '-0', 'postMessage'
    );

    $opts['style-footer-rounded-heading'] = weaverx_cz_group_title(esc_html__('Footer Rounded Corners', 'weaver-xtreme'));

    $opts['footer_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Footer Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['footer_sb_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Footer Widget Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    $opts['footer_html_rounded'] = weaverx_cz_select(
        esc_html__('Add rounded corners to Footer HTML Area', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_rounded', 'none', WEAVERX_ROUNDED_TRANSPORT
    );

    return $opts;
}

