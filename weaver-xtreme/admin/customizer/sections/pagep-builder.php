<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the style panel
 *
 */
function weaverx_customizer_define_pagebuilder_sections(): array
{
    $panel = 'weaverx_pagep-builder';
    $pb_sections = array();

    // global settings

    // ---- Header Replace

    $pb_sections['pb-header-replace'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global Header Area Replacement', 'weaver-xtreme'),
        'description' => esc_html__('Replace Weaver Header Area with Page Builder page.', 'weaver-xtreme'),
        'options' => array(

            'pb-hdr1' => weaverx_cz_group_title(esc_html__('Header Replacement Page', 'weaver-xtreme'),
                esc_html__('You can replace the entire Weaver Header area with the content from a page builder page, or any other standard Page or Post by ID. None of the standard theme header elements except the menu bars will be displayed.  You can also specify a Header Replacement as a Per Page option.', 'weaver-xtreme')),

            'pb_header_hide_menus' => weaverx_cz_checkbox(
                esc_html__('Hide Weaver Menus', 'weaver-xtreme'),
                esc_html__('Check to hide the Weaver Primary Menu normally displayed below the replacement page.', 'weaver-xtreme')
            ),
        ),

    );


    if (defined('ELEMENTOR_VERSION')) {                // only provide if elementor is active
        $pb_sections['pb-header-replace']['options']['elementor_header_replacement'] = weaverx_cz_select(
            esc_html__('Elementor Header Replacement', 'weaver-xtreme'),
            esc_html__('Select an Elementor Page or Post to replace the Header Area.', 'weaver-xtreme'),
            'weaverx_cz_choices_elementor_pages', 'none', 'refresh'
        );
    }

    if (defined('SITEORIGIN_PANELS_VERSION')) {        // only provide if siteorigins is active

        $pb_sections['pb-header-replace']['options']['siteorigin_header_replacement'] = weaverx_cz_select(
            esc_html__('SiteOrigin Header Replacement', 'weaver-xtreme'),
            esc_html__('Select an SiteOrigin Page or Post to replace the Header Area.', 'weaver-xtreme'),
            'weaverx_cz_choices_siteorigin_pages', 'none', 'refresh'
        );
    }

    if (!defined('ELEMENTOR_VERSION') && !defined('SITEORIGIN_PANELS_VERSION')) {
        $pb_sections['pb-header-replace']['options']['no-pb1'] = weaverx_cz_group_title(esc_html__('No Page Builder Detected', 'weaver-xtreme'),
            esc_html__('Sorry, Weaver can only show a list of page builder pages from Elementor or SiteOrigin Page Builder, but you can still provide a page/post ID. Please install and activate one of those plugins.', 'weaver-xtreme'));
    }

    $pb_sections['pb-header-replace']['options']['pb_header_replace_page_id'] = weaverx_cz_textarea(
        esc_html__('Page or Post ID Header Replacement', 'weaver-xtreme'),
        esc_html__('Provide any page or post ID to serve as header replacement. Overrides list selection above. Does not have to be from a page builder.', 'weaver-xtreme'), 1, '',
        'refresh', '', 'weaverx_cz_sanitize_int');


    // ---- Footer Replace

    $pb_sections['footer-pb-replace'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global Footer Area Replacement', 'weaver-xtreme'),
        'description' => esc_html__('Replace Weaver Footer Area with Page Builder page.', 'weaver-xtreme'),
        'options' => array(

            'pb-ftr1' => weaverx_cz_group_title(esc_html__('Footer Replacement', 'weaver-xtreme'),
                esc_html__('You can replace the entire Weaver Footer area with the content from a page builder page. None of the standard theme footer elements will be displayed.  You can also specify a Footer Replacement as a Per Page option.', 'weaver-xtreme')),

        ),

    );


    if (defined('ELEMENTOR_VERSION')) {                // only provide if elementor is active
        $pb_sections['footer-pb-replace']['options']['elementor_footer_replacement'] = weaverx_cz_select(
            esc_html__('Elementor Footer Replacement', 'weaver-xtreme'),
            esc_html__('Select an Elementor Page or Post to replace the Footer Area.', 'weaver-xtreme'),
            'weaverx_cz_choices_elementor_pages', 'none', 'refresh'
        );
    }

    if (defined('SITEORIGIN_PANELS_VERSION')) {        // only provide if siteorigins is active

        $pb_sections['footer-pb-replace']['options']['siteorigin_footer_replacement'] = weaverx_cz_select(
            esc_html__('SiteOrigin Footer Replacement', 'weaver-xtreme'),
            esc_html__('Select an SiteOrigin Page or Post to replace the Footer Area.', 'weaver-xtreme'),
            'weaverx_cz_choices_siteorigin_pages', 'none', 'refresh'
        );
    }

    if (!defined('ELEMENTOR_VERSION') && !defined('SITEORIGIN_PANELS_VERSION')) {
        $pb_sections['footer-pb-replace']['options']['no-pb2'] = weaverx_cz_group_title(esc_html__('No Page Builder Detected', 'weaver-xtreme'),
            esc_html__('Sorry, Weaver can only show a list of page builder pages from Elementor or SiteOrigin Page Builder, but you can still provide a page/post ID. Please install and activate one of those plugins.', 'weaver-xtreme'));
    }

    $pb_sections['footer-pb-replace']['options']['pb_footer_replace_page_id'] = weaverx_cz_textarea(
        esc_html__('Page or Post ID Footer Replacement', 'weaver-xtreme'),
        esc_html__('Provide any page or post ID to serve as footer replacement. Overrides list selection above. Does not have to be from a page builder', 'weaver-xtreme'),
        1, '', 'refresh', false, 'weaverx_cz_sanitize_int');


    // --- Elementor

    if (defined('ELEMENTOR_VERSION')) {
        $pb_sections['pb-elementorx'] = array(
            'panel' => $panel,
            'title' => esc_html__('Elementor', 'weaver-xtreme'),
            'description' => esc_html__('Weaver theme overrides for Elementor Page Builder. Elementor now has options that make these options unnecessary. These will be removed in future versions of Weaver Xtreme.', 'weaver-xtreme'),
            'options' => array(

                'pb-title1x' => weaverx_cz_group_title(esc_html__('Elementor Default Colors (Global)', 'weaver-xtreme'),
                    esc_html__('The Elementor color options now found on the "Obsolete Weaver Xtreme Options Menu".', 'weaver-xtreme')),

            ),

        );
    }


    return $pb_sections;
}
