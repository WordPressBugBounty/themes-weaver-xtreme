<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the Site Colors panel
 * Customize_Alpha_Color_Control
 * WP_Customize_Color_Control
 */


function weaverx_customizer_define_colorscheme_sections(): array
{
    $panel = 'weaverx_site-colors';
    $colorscheme_sections = array();

    /**
     * General
     */
    $colorscheme_sections['color-wrapping'] = array(
        'panel' => $panel,
        'title' => esc_html__('Wrapping Areas', 'weaver-xtreme'),
        'description' => esc_html__('Set colors. Use Typography to set fonts.','weaver-xtreme'),
        'options' => weaverx_controls_colors_wrapping(),
    );

    /**
     * Links
     */
    $colorscheme_sections['color-links'] = array(
        'panel' => $panel,
        'title' => esc_html__('Links', 'weaver-xtreme'),
        'description' => esc_html__('Set colors for links. Use Typography to set fonts.','weaver-xtreme'),
        'options' => weaverx_controls_colors_links(),
    );

    /**
     * Site Header
     */
    $colorscheme_sections['color-header'] = array(
        'panel' => $panel,
        'title' => esc_html__('Header Area', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_header(),
    );

    /**
     * Main Menu
     */

    $colorscheme_sections['color-menus'] = array(
        'panel' => $panel,
        'title' => esc_html__('Menus', 'weaver-xtreme'),
        'description' => esc_html__('Set text, background, and hover colors for menus.', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_menus(),
    );


    /**
     * Info Bar
     */
    $colorscheme_sections['color-info-bar'] = array(
        'panel' => $panel,
        'title' => esc_html__('Info Bar', 'weaver-xtreme'),
        'description' => esc_html__('Info Bar has breadcrumbs and paged navigation displayed under Primary Menu.', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_infobar(),
    );

    /**
     * Content
     */
    $colorscheme_sections['color-content'] = array(
        'panel' => $panel,
        'title' => esc_html__('Content', 'weaver-xtreme'),
        'description' => esc_html__('Colors for general page and post content. You can override post specific colors on the "Post Specific Colors" panel.', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_content(),
    );

    /**
     * Post Specific
     */
    $colorscheme_sections['color-post-specific'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Specific', 'weaver-xtreme'),
        'description' => esc_html__('Post Specific Colors - override Content colors.', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_postspecific(),
    );


    /**
     * Sidebars
     */
    $colorscheme_sections['color-sidebars'] = array(
        'panel' => $panel,
        'title' => esc_html__('Sidebars &amp; Widget Areas', 'weaver-xtreme'),
        'description' => esc_html__('Colors for Primary and Secondary Sidebars, and Widget Areas.', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_sidebars(),
    );

    /**
     * Widgets
     */
    $colorscheme_sections['color-widgets'] = array(
        'panel' => $panel,
        'title' => esc_html__('Individual Widgets', 'weaver-xtreme'),
        'description' => esc_html__('Properties for individual widgets (e.g., Text, Recent Posts, etc.)','weaver-xtreme'),
        'options' => weaverx_controls_colors_widgets(),
    );


    /**
     * Footer
     */
    $colorscheme_sections['color-footer'] = array(
        'panel' => $panel,
        'title' => esc_html__('Footer Area', 'weaver-xtreme'),
        'options' => weaverx_controls_colors_footer(),
    );


    return $colorscheme_sections;
}

// define controls for sections

function weaverx_controls_colors_wrapping(): array
{
    $opts = array();

    $opts['body_bgcolor'] = weaverx_cz_color(
        'body_bgcolor',
        esc_html__('Site Background Color', 'weaver-xtreme'),
        esc_html__('Background color for &lt;body&gt;, wraps entire page.', 'weaver-xtreme'));

    $opts['fadebody_bg'] = weaverx_cz_checkbox(
        esc_html__('Fade Outside BG', 'weaver-xtreme'),
        esc_html__('Will fade the Outside BG color, darker at top to lighter at bottom.', 'weaver-xtreme')
    );

    $opts['wrapper_color'] = weaverx_cz_color(
        'wrapper_color',
        esc_html__('Wrapper Text Color', 'weaver-xtreme'),
        weaverx_markdown(__('**Global Text Color** - You can override other text colors for individual areas and items below.', 'weaver-xtreme')));

    $opts['wrapper_bgcolor'] = weaverx_cz_color(
        'wrapper_bgcolor',
        esc_html__('Wrapper BG Color', 'weaver-xtreme'),
        weaverx_markdown(__('**Background Color** - wraps entire content area. To override, set BG colors for individual areas.', 'weaver-xtreme')));

    $opts['container_color'] = weaverx_cz_color(
        'container_color',
        esc_html__('Container Text Color', 'weaver-xtreme'),
        esc_html__('Container ( #container div ) wraps content and sidebars.', 'weaver-xtreme'));

    $opts['container_bgcolor'] = weaverx_cz_color(
        'container_bgcolor',
        esc_html__('Container BG Color', 'weaver-xtreme'));

    $opts['color-border-heading'] = weaverx_cz_line();

    $opts['color-border-headingbc'] = weaverx_cz_heading(esc_html__('Border Color', 'weaver-xtreme'),
        weaverx_markdown(__('Border Color option found on *Style&rarr;Global Style Options* panel.', 'weaver-xtreme'))
    );

    return $opts;
}

function weaverx_controls_colors_links(): array
{
    $opts = array();

    $opts['link_color'] = weaverx_cz_color(
        'link_color',
        esc_html__('Standard Links', 'weaver-xtreme'),
        esc_html__('Sitewide default color for links. To override for links in specific areas, set colors for individual links below.', 'weaver-xtreme'), 'refresh');

    $opts['link_hover_color'] = weaverx_cz_color(
        'link_hover_color',
        esc_html__('Standard Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    // info bar
    $opts['color-info-line-1'] = weaverx_cz_line();

    $opts['ibarlink_color'] = weaverx_cz_color(
        'ibarlink_color',
        esc_html__('Info Bar Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['ibarlink_hover_color'] = weaverx_cz_color(
        'ibarlink_hover_color',
        esc_html__('Info Bar Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['color-info-line-2'] = weaverx_cz_line();

    // content

    $opts['contentlink_color'] = weaverx_cz_color(
        'contentlink_color',
        esc_html__('Content Links Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['contentlink_hover_color'] = weaverx_cz_color(
        'contentlink_hover_color',
        esc_html__('Content Links Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['color-info-line-3'] = weaverx_cz_line();

    // post meta info bar
    $opts['ilink_color'] = weaverx_cz_color(
        'ilink_color',
        esc_html__('Post Meta Info Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['ilink_hover_color'] = weaverx_cz_color(
        'ilink_hover_color',
        esc_html__('Post Meta Info Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['color-info-line-4'] = weaverx_cz_line();

    // individual widgets

    $opts['wlink_color'] = weaverx_cz_color(
        'wlink_color',
        esc_html__('Individual Widgets Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['wlink_hover_color'] = weaverx_cz_color(
        'wlink_hover_color',
        esc_html__('Individual Widgets Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['color-info-line-5'] = weaverx_cz_line();

    $opts['footerlink_color'] = weaverx_cz_color(
        'footerlink_color',
        esc_html__('Footer Links Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['footerlink_hover_color'] = weaverx_cz_color(
        'footerlink_hover_color',
        esc_html__('Footer Links Hover Color', 'weaver-xtreme'),
        '', 'refresh');


    return $opts;
}

function weaverx_controls_colors_header(): array
{
    $opts = array();

    $opts['header_color'] = weaverx_cz_color(
        'header_color',
        esc_html__('Header Text Color', 'weaver-xtreme'),
        '');

    $opts['header_bgcolor'] = weaverx_cz_color(
        'header_bgcolor',
        esc_html__('Header Area BG Color', 'weaver-xtreme'),
        'The Header BG Color is used for full width BG color on header.');

    $opts['site_title_color'] = weaverx_cz_color(
        'site_title_color',
        esc_html__('Site Title Text Color', 'weaver-xtreme'),
        '');

    $opts['site_title_bgcolor'] = weaverx_cz_color(
        'site_title_bgcolor',
        esc_html__('Site Title BG Color', 'weaver-xtreme'),
        esc_html__('Site Title BG Color', 'weaver-xtreme'));

    $opts['tagline_color'] = weaverx_cz_color(
        'tagline_color',
        esc_html__('Site Tagline Text Color', 'weaver-xtreme'),
        '');

    $opts['tagline_bgcolor'] = weaverx_cz_color(
        'tagline_bgcolor',
        esc_html__('Site Tagline BG Color', 'weaver-xtreme'),
        '');

    $opts['title_tagline_bgcolor'] = weaverx_cz_color(
        'title_tagline_bgcolor',
        esc_html__('Title/Tagline Area BG', 'weaver-xtreme'),
        esc_html__('BG Color for the Title, Tagline, and Search area.', 'weaver-xtreme'));

    $opts['header_sb_color'] = weaverx_cz_color(
        'header_sb_color',
        esc_html__('Header Widget Area Text Color', 'weaver-xtreme'),
        '');

    $opts['header_sb_bgcolor'] = weaverx_cz_color(
        'header_sb_bgcolor',
        esc_html__('Header Widget Area BG Color', 'weaver-xtreme'),
        '');

    $opts['header_html_color'] = weaverx_cz_color(
        'header_html_color',
        esc_html__('Header HTML Area Text Color', 'weaver-xtreme'));

    $opts['header_html_bgcolor'] = weaverx_cz_color(
        'header_html_bgcolor',
        esc_html__('Header HTML Area BG Color', 'weaver-xtreme'));

    return $opts;
}

function weaverx_controls_colors_menus(): array
{
    $opts = array();

    $opts['color-mm-heading'] = weaverx_cz_group_title(esc_html__('Primary Menu Colors', 'weaver-xtreme'));

    $opts['m_primary_color'] = weaverx_cz_color(
        'm_primary_color',
        esc_html__('Primary Menu Bar Text Color', 'weaver-xtreme'),
        esc_html__('Text Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_primary_bgcolor'] = weaverx_cz_color(
        'm_primary_bgcolor',
        esc_html__('Primary Menu Bar BG Color', 'weaver-xtreme'),
        esc_html__('Background Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_primary_link_bgcolor'] = weaverx_cz_color(
        'm_primary_link_bgcolor',
        esc_html__('Item BG Color', 'weaver-xtreme'),
        esc_html__('Background Color for menu bar items.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_primary_hover_color'] = weaverx_cz_color(
        'm_primary_hover_color',
        esc_html__('Primary Menu Bar Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_primary_hover_bgcolor'] = weaverx_cz_color(
        'm_primary_hover_bgcolor',
        esc_html__('Primary Menu Bar Hover BG Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_primary_html_color'] = weaverx_cz_color(
        'm_primary_html_color',
        esc_html__('HTML: Text Color', 'weaver-xtreme'),
        esc_html__('Text Color for Left/Right Menu Bar HTML.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE
    );

    $opts['m_primary_sub_color'] = weaverx_cz_color(
        'm_primary_sub_color',
        esc_html__('Primary Sub-Menu Text Color', 'weaver-xtreme'),
        '', WEAVERX_MENU_UPDATE);

    $opts['m_primary_sub_bgcolor'] = weaverx_cz_color(
        'm_primary_sub_bgcolor',
        esc_html__('Primary Sub-Menu BG Color', 'weaver-xtreme'),
        '', WEAVERX_MENU_UPDATE);

    $opts['m_primary_sub_hover_color'] = weaverx_cz_color(
        'm_primary_sub_hover_color',
        esc_html__('Primary Sub-Menu Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_primary_sub_hover_bgcolor'] = weaverx_cz_color(
        'm_primary_sub_hover_bgcolor',
        esc_html__('Primary Sub-Menu Hover BG Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_primary_clickable_bgcolor'] = weaverx_cz_color(
        'm_primary_clickable_bgcolor',
        esc_html__('Open Submenu Arrow BG', 'weaver-xtreme'),
        esc_html__('Clickable mobile open submenu arrow BG. Contrasting BG color required for proper user interface. Not used by SmartMenus. (Default: rgba( 255,255,255,0.2)', 'weaver-xtreme'), 'refresh');

    $opts['m_primary_dividers_color'] = weaverx_cz_color(
        'm_primary_dividers_color',
        esc_html__('Dividers between menu items', 'weaver-xtreme'),
        esc_html__('Add colored dividers between menu items. Leave blank for none.', 'weaver-xtreme'),
        'refresh'
    );

    // Secondary

    $opts['color-mm-heading2'] = weaverx_cz_group_title(esc_html__('Secondary Menu Colors', 'weaver-xtreme'),
        esc_html__('You must define a Secondary Menu from the Custom Menus Content menu.', 'weaver-xtreme')
    );

    $opts['m_secondary_color'] = weaverx_cz_color(
        'm_secondary_color',
        esc_html__('Secondary Menu Bar Text Color', 'weaver-xtreme'),
        esc_html__('Text Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_secondary_bgcolor'] = weaverx_cz_color(
        'm_secondary_bgcolor',
        esc_html__('Secondary Menu Bar BG Color', 'weaver-xtreme'),
        esc_html__('Background Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_secondary_link_bgcolor'] = weaverx_cz_color(
        'm_secondary_link_bgcolor',
        esc_html__('Item BG Color', 'weaver-xtreme'),
        esc_html__('Background Color for menu bar items.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

    $opts['m_secondary_hover_color'] = weaverx_cz_color(
        'm_secondary_hover_color',
        esc_html__('Secondary Menu Bar Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_secondary_hover_bgcolor'] = weaverx_cz_color(
        'm_secondary_hover_bgcolor',
        esc_html__('Secondary Menu Bar Hover BG Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_secondary_html_color'] = weaverx_cz_color(
        'm_secondary_html_color',
        esc_html__('HTML: Text Color', 'weaver-xtreme'),
        esc_html__('Text Color for Left/Right Menu Bar HTML.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE
    );

    $opts['m_secondary_sub_color'] = weaverx_cz_color(
        'm_secondary_sub_color',
        esc_html__('Secondary Sub-Menu Text Color', 'weaver-xtreme'),
        '', WEAVERX_MENU_UPDATE);

    $opts['m_secondary_sub_bgcolor'] = weaverx_cz_color(
        'm_secondary_sub_bgcolor',
        esc_html__('Secondary Sub-Menu BG Color', 'weaver-xtreme'),
        '', WEAVERX_MENU_UPDATE);

    $opts['m_secondary_sub_hover_color'] = weaverx_cz_color(
        'm_secondary_sub_hover_color',
        esc_html__('Secondary Sub-Menu Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_secondary_sub_hover_bgcolor'] = weaverx_cz_color(
        'm_secondary_sub_hover_bgcolor',
        esc_html__('Secondary Sub-Menu Hover BG Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['m_secondary_clickable_bgcolor'] = weaverx_cz_color(
        'm_secondary_clickable_bgcolor',
        esc_html__('Open Submenu Arrow BG', 'weaver-xtreme'),
        esc_html__('Clickable mobile open submenu arrow BG. Contrasting BG color required for proper user interface. Not used by SmartMenus. (Default: rgba( 255,255,255,0.2)', 'weaver-xtreme'), 'refresh');

    $opts['m_secondary_dividers_color'] = weaverx_cz_color(
        'm_secondary_dividers_color',
        esc_html__('Dividers between menu items', 'weaver-xtreme'),
        esc_html__('Add colored dividers between menu items. Leave blank for none.', 'weaver-xtreme'),
        'refresh'
    );

    //  Mini menu

    $opts['content-linem1'] = weaverx_cz_line();

    $opts['color-minim-heading'] = weaverx_cz_group_title(esc_html__('Header Mini Menu Colors', 'weaver-xtreme'),
        esc_html__('You must define a Header Menu from the Custom Menus Content menu.', 'weaver-xtreme'));

    $opts['m_header_mini_color'] = weaverx_cz_color('m_header_mini_color',
        esc_html__('Header Mini Menu Text Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['m_header_mini_bgcolor'] = weaverx_cz_color('m_header_mini_bgcolor',
        esc_html__('Header Mini Menu BG Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['m_header_mini_hover_color'] = weaverx_cz_color('m_header_mini_hover_color',
        esc_html__('Header Mini Menu Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    // All Menus

    $opts['color-allmenus-heading'] = weaverx_cz_group_title(esc_html__('Colors For All Menus', 'weaver-xtreme'),
        esc_html__('These options specify current page attributes for all menus.', 'weaver-xtreme'));

    $opts['menubar_curpage_color'] = weaverx_cz_color('menubar_curpage_color',
        esc_html__('Menus Current Page Text Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['menubar_curpage_bgcolor'] = weaverx_cz_color('menubar_curpage_bgcolor',
        esc_html__('Menus Current Page BG Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['m_retain_hover'] = weaverx_cz_checkbox(
        esc_html__('Retain Menu Bar Hover BG Color', 'weaver-xtreme'),
        esc_html__('Retain the menu bar item hover BG color when sub-menus are opened.', 'weaver-xtreme')
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {
        if (weaverx_cz_is_plus()) {
            $opts['color-mm-heading3'] = weaverx_cz_group_title(esc_html__('Extra Menu Colors', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
                esc_html__('You must define a Extra Menu from the Custom Menus Content menu.', 'weaver-xtreme')
            );

            $opts['m_extra_color'] = weaverx_cz_color(
                'm_extra_color',
                esc_html__('Extra Menu Bar Text Color', 'weaver-xtreme'),
                esc_html__('Text Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

            $opts['m_extra_bgcolor'] = weaverx_cz_color(
                'm_extra_bgcolor',
                esc_html__('Extra Menu Bar BG Color', 'weaver-xtreme'),
                esc_html__('Background Color for Entire menu bar.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

            $opts['m_extra_link_bgcolor'] = weaverx_cz_color(
                'm_extra_link_bgcolor',
                esc_html__('Item BG Color', 'weaver-xtreme'),
                esc_html__('Background Color for menu bar items.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE);

            $opts['m_extra_hover_color'] = weaverx_cz_color(
                'm_extra_hover_color',
                esc_html__('Extra Menu Bar Hover Text Color', 'weaver-xtreme'),
                '', 'refresh');

            $opts['m_extra_hover_bgcolor'] = weaverx_cz_color(
                'm_extra_hover_bgcolor',
                esc_html__('Extra Menu Bar Hover BG Color', 'weaver-xtreme'),
                '', 'refresh');

            $opts['m_extra_html_color'] = weaverx_cz_color(
                'm_extra_html_color',
                esc_html__('HTML: Text Color', 'weaver-xtreme'),
                esc_html__('Text Color for Left/Right Menu Bar HTML.', 'weaver-xtreme'), WEAVERX_MENU_UPDATE
            );

            $opts['m_extra_sub_color'] = weaverx_cz_color(
                'm_extra_sub_color',
                esc_html__('Extra Sub-Menu Text Color', 'weaver-xtreme'),
                '', WEAVERX_MENU_UPDATE);

            $opts['m_extra_sub_bgcolor'] = weaverx_cz_color(
                'm_extra_sub_bgcolor',
                esc_html__('Extra Sub-Menu BG Color', 'weaver-xtreme'),
                '', WEAVERX_MENU_UPDATE);

            $opts['m_extra_sub_hover_color'] = weaverx_cz_color(
                'm_extra_sub_hover_color',
                esc_html__('Extra Sub-Menu Hover Text Color', 'weaver-xtreme'),
                '', 'refresh');

            $opts['m_extra_sub_hover_bgcolor'] = weaverx_cz_color(
                'm_extra_sub_hover_bgcolor',
                esc_html__('Extra Sub-Menu Hover BG Color', 'weaver-xtreme'),
                '', 'refresh');

            $opts['m_extra_clickable_bgcolor'] = weaverx_cz_color(
                'm_extra_clickable_bgcolor',
                esc_html__('Open Submenu Arrow BG', 'weaver-xtreme'),
                esc_html__('Clickable mobile open submenu arrow BG. Contrasting BG color required for proper user interface. Not used by SmartMenus. (Default: rgba( 255,255,255,0.2)', 'weaver-xtreme'), 'refresh');

            $opts['m_extra_dividers_color'] = weaverx_cz_color(
                'm_extra_dividers_color',
                esc_html__('Dividers between menu items', 'weaver-xtreme'),
                esc_html__('Add colored dividers between menu items. Leave blank for none.', 'weaver-xtreme'),
                'refresh'
            );

        } else {
            $opts = weaverx_cz_add_plus_message('color_menus', esc_html__('Extra Menu', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
                esc_html__('Add extra menus with <strong>Weaver Xtreme Plus</strong>.', 'weaver-xtreme'));
        }
    }


    return $opts;
}

function weaverx_controls_colors_infobar(): array
{
    $opts = array();

    $opts['infobar_color'] = weaverx_cz_color(
        'infobar_color',
        esc_html__('Info Bar Text Color', 'weaver-xtreme')
    );

    $opts['infobar_bgcolor'] = weaverx_cz_color(
        'infobar_bgcolor',
        esc_html__('Info Bar BG Color', 'weaver-xtreme')
    );

    return $opts;
}

function weaverx_controls_colors_content(): array
{
    $opts = array();


    $opts['content_color'] = weaverx_cz_color(
        'content_color',
        esc_html__('Content Area Text Color', 'weaver-xtreme')
    );

    $opts['content_bgcolor'] = weaverx_cz_color(
        'content_bgcolor',
        esc_html__('Content Area BG Color', 'weaver-xtreme')
    );

    $opts['page_title_color'] = weaverx_cz_color(
        'page_title_color',
        esc_html__('Page Title Text Color', 'weaver-xtreme'),
        esc_html__('Page titles, including pages, post single pages, and archive-like pages.', 'weaver-xtreme')
    );

    $opts['page_title_bgcolor'] = weaverx_cz_color(
        'page_title_bgcolor',
        esc_html__('Page Title BG Color', 'weaver-xtreme')
    );

    $opts['archive_title_color'] = weaverx_cz_color(
        'archive_title_color',
        esc_html__('Archive Pages Title Text Color', 'weaver-xtreme'),
        esc_html__('Archive-like page titles: archives, categories, tags, searches.', 'weaver-xtreme')
    );

    $opts['archive_title_bgcolor'] = weaverx_cz_color(
        'archive_title_bgcolor',
        esc_html__('Archive Pages Title BG Color', 'weaver-xtreme')
    );

    $opts['content_h_color'] = weaverx_cz_color(
        'content_h_color',
        esc_html__('Content Headings Text Color', 'weaver-xtreme'),
        esc_html__('Headings ( &lt;h1&gt;-&lt;h6&gt; ) in page and post content.', 'weaver-xtreme')
    );

    $opts['content_h_bgcolor'] = weaverx_cz_color(
        'content_h_bgcolor',
        esc_html__('Content Headings BG', 'weaver-xtreme'),
        esc_html__('Headings ( &lt;h1&gt;-&lt;h6&gt; ) in page and post content.', 'weaver-xtreme')
    );

    $opts['content-line1'] = weaverx_cz_line();

    $opts['input_color'] = weaverx_cz_color(
        'input_color',
        esc_html__('Text Input Areas Color', 'weaver-xtreme')
    );

    $opts['input_bgcolor'] = weaverx_cz_color(
        'input_bgcolor',
        esc_html__('Text Input Areas BG Color', 'weaver-xtreme')
    );

    $opts['search_color'] = weaverx_cz_color(
        'search_color',
        esc_html__('Search Input Text Color', 'weaver-xtreme')
    );

    $opts['search_bgcolor'] = weaverx_cz_color(
        'search_bgcolor',
        esc_html__('Search Input BG Color', 'weaver-xtreme')
    );

    $opts['search_icon_msg'] = weaverx_cz_heading(esc_html__('Search Icon Color', 'weaver-xtreme'),
        esc_html__('The Search Icon color is inherited from wrapping areas text color, including the header area and menu bar.', 'weaver-xtreme'));

    $opts['content-line1a'] = weaverx_cz_line();

    $opts['hr_color'] = weaverx_cz_color(
        'hr_color',
        esc_html__('&lt;HR&gt; color', 'weaver-xtreme'),
        esc_html__('Color of horizontal ( &lt;hr&gt; ) lines in posts and pages. Use the "Custom CSS &rarr; Content" panel to customize the style of the &lt;hr&gt;.', 'weaver-xtreme')
    );

    $opts['content-line1b'] = weaverx_cz_line();

    $opts['comment_headings_color'] = weaverx_cz_color(
        'comment_headings_color',
        esc_html__('Color for headings in comment form', 'weaver-xtreme')
    );

    $opts['comment_content_bgcolor'] = weaverx_cz_color(
        'comment_content_bgcolor',
        esc_html__('Comment content area BG Color', 'weaver-xtreme')
    );

    $opts['comment_submit_bgcolor'] = weaverx_cz_color(
        'comment_submit_bgcolor',
        esc_html__('"Post Comment" submit button BG Color', 'weaver-xtreme')
    );

    $opts['content-line2'] = weaverx_cz_line();

    $opts['editor_bgcolor'] = weaverx_cz_color(
        'editor_bgcolor',
        esc_html__('Page/Post Editor BG', 'weaver-xtreme'),
        esc_html__("Alternative Background Color to use for Page/Post editor if you're using transparent or image backgrounds.", 'weaver-xtreme'),
        'refresh'
    );


    return $opts;
}

function weaverx_controls_colors_postspecific(): array
{
    $opts = array();


    $opts['color-post-heading'] = weaverx_cz_heading(esc_html__('Post Specific', 'weaver-xtreme'));

    $opts['post_color'] = weaverx_cz_color(
        'post_color',
        esc_html__('Post Area Text Color', 'weaver-xtreme')
    );

    $opts['post_bgcolor'] = weaverx_cz_color(
        'post_bgcolor',
        esc_html__('Post Area BG Color', 'weaver-xtreme')
    );

    $opts['stickypost_bgcolor'] = weaverx_cz_color(
        'stickypost_bgcolor',
        esc_html__('Sticky Post Area BG Color', 'weaver-xtreme')
    );

    $opts['post_title_color'] = weaverx_cz_color(
        'post_title_color',
        esc_html__('Post Title Text Color', 'weaver-xtreme')
    );

    $opts['post_title_bgcolor'] = weaverx_cz_color(
        'post_title_bgcolor',
        esc_html__('Post Title BG Color', 'weaver-xtreme')
    );

    $opts['post_title_hover_color'] = weaverx_cz_color(
        'post_title_hover_color',
        esc_html__('Post Title Hover Color', 'weaver-xtreme'),
        esc_html__('Color if you want the Post Title to show alternate color for hover.', 'weaver-xtreme'),
        'refresh'
    );

    $opts['post_info_top_color'] = weaverx_cz_color(
        'post_info_top_color',
        esc_html__('Top Post Meta Info Text Color', 'weaver-xtreme')
    );

    $opts['post_info_top_bgcolor'] = weaverx_cz_color(
        'post_info_top_bgcolor',
        esc_html__('Top Post Meta Info BG Color', 'weaver-xtreme')
    );

    $opts['post_info_bottom_color'] = weaverx_cz_color(
        'post_info_bottom_color',
        esc_html__('Bottom Post Meta Info Text Color', 'weaver-xtreme')
    );

    $opts['post_info_bottom_bgcolor'] = weaverx_cz_color(
        'post_info_bottom_bgcolor',
        esc_html__('Bottom Post Meta Info BG Color', 'weaver-xtreme')
    );

    $opts['post_icons_color'] = weaverx_cz_color(
        'post_icons_color',
        esc_html__('Post Font Icons Color', 'weaver-xtreme'),
        esc_html__('Set Font Icon color if Font Icons on Info Lines specified on the *Style &rarr; Post Specific* panel.', 'weaver-xtreme')
    );

    $opts['post_author_bgcolor'] = weaverx_cz_color(
        'post_author_bgcolor',
        esc_html__('Author Info BG Color', 'weaver-xtreme'),
        esc_html__('Background color used for Author Bio.', 'weaver-xtreme')
    );

    return $opts;
}

function weaverx_controls_colors_sidebars(): array
{
    $opts = array();


    $opts['color-primary-widget-heading'] = weaverx_cz_group_title(esc_html__('Primary Sidebar (Widget Area)', 'weaver-xtreme'));

    $opts['primary_color'] = weaverx_cz_color(
        'primary_color',
        esc_html__('Primary Sidebar Text Color', 'weaver-xtreme')
    );

    $opts['primary_bgcolor'] = weaverx_cz_color(
        'primary_bgcolor',
        esc_html__('Primary Sidebar BG Color', 'weaver-xtreme')
    );

    $opts['color-secondary-widget-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sidebar (Widget Area)', 'weaver-xtreme'));

    $opts['secondary_color'] = weaverx_cz_color(
        'secondary_color',
        esc_html__('Secondary Sidebar Text Color', 'weaver-xtreme')
    );

    $opts['secondary_bgcolor'] = weaverx_cz_color(
        'secondary_bgcolor',
        esc_html__('Secondary Sidebar BG Color', 'weaver-xtreme')
    );

    $opts['flow_color'] = weaverx_cz_checkbox(
        esc_html__('Flow Color to Bottom', 'weaver-xtreme'),
        esc_html__('If checked, Content and Sidebar bg colors will flow to bottom of the Container ( that is, equal heights ). You must provide background colors for the Content and Sidebars or the default bg color will be used.', 'weaver-xtreme'),
        'plus'
    );

    $opts['content-linemtb'] = weaverx_cz_line();

    // Top / Bottom Widget areas

    $opts['color-top-widget-heading'] = weaverx_cz_group_title(esc_html__('Top Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

    $opts['top_color'] = weaverx_cz_color(
        'top_color',
        esc_html__('Top Widget Areas Text Color', 'weaver-xtreme')
    );

    $opts['top_bgcolor'] = weaverx_cz_color(
        'top_bgcolor',
        esc_html__('Top Widget Areas BG Color', 'weaver-xtreme')
    );

    $opts['color-bottom-widget-heading'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

    $opts['bottom_color'] = weaverx_cz_color(
        'bottom_color',
        esc_html__('Bottom Widget Areas Text Color', 'weaver-xtreme')
    );

    $opts['bottom_bgcolor'] = weaverx_cz_color(
        'bottom_bgcolor',
        esc_html__('Bottom Widget Areas BG Color', 'weaver-xtreme')
    );

    return $opts;
}

function weaverx_controls_colors_widgets(): array
{
    $opts = array();

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

    return $opts;
}

function weaverx_controls_colors_footer(): array
{

    $opts = array();

    $opts['footer_color'] = weaverx_cz_color(
        'footer_color',
        esc_html__('Footer Area Text Color', 'weaver-xtreme')
    );

    $opts['footer_bgcolor'] = weaverx_cz_color('header_bgcolor',
        esc_html__('Footer Area BG Color', 'weaver-xtreme'),
        'The Footer Area BG Color is used for full width BG color on header.');

    $opts['footer_sb_color'] = weaverx_cz_color(
        'footer_sb_color',
        esc_html__('Footer Widget Area Text Color', 'weaver-xtreme')
    );

    $opts['footer_sb_bgcolor'] = weaverx_cz_color(
        'footer_sb_bgcolor',
        esc_html__('Footer Widget Area BG Color', 'weaver-xtreme')
    );

    $opts['footer_html_color'] = weaverx_cz_color(
        'footer_html_color',
        esc_html__('Footer HTML Area Text Color', 'weaver-xtreme')
    );

    $opts['footer_html_bgcolor'] = weaverx_cz_color(
        'footer_html_bgcolor',
        esc_html__('Footer HTML Area BG Color', 'weaver-xtreme')
    );

    return $opts;
}
