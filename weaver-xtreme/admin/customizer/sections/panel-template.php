<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the panel template panel
 */
function weaverx_customizer_define_template_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-template';
    $template_sections = array();


    /**
     * General
     */

    $template_sections['template-global'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global template Settings', 'weaver-xtreme'),
        'description' => esc_html__('Set template options for Site Wrapper &amp; Container. Use Colors to set colors.','weaver-xtreme'),
        'options' => weaverx_controls_template_global(),

    );

    /**
     * Move WP standard sections to this panel
     */

    //$wp_customize->get_section( 'header_images' )->priority = 10505;
    //$wp_customize->get_section( 'header_images' )->panel = $panel;

    /**
     * template Section1
     */

    $template_sections['template-section1'] = array(
        'panel' => $panel,
        'title' => esc_html__('Section 1', 'weaver-xtreme'),
        'description' => esc_html__('Options for Section1', 'weaver-xtreme'),
        'options' => weaverx_controls_template_section1(),
    );


    /**
     * template Section2
     */

    $template_sections['template-section2'] = array(
        'panel' => $panel,
        'title' => esc_html__('Section 2', 'weaver-xtreme'),
        'description' => esc_html__('Options for Section2', 'weaver-xtreme'),
        'options' => weaverx_controls_template_section2(),
    );


    return $template_sections;
}

// the definitions of the controls for each panel follow


function weaverx_controls_template_global(): array
{
    $opts = array();

    $opts['template-heading-global'] = weaverx_cz_group_title(
        esc_html__('Global template Settings', 'weaver-xtreme'),
        esc_html__('These settings are global.', 'weaver-xtreme'));
    return $opts;
}

function weaverx_controls_template_section1(): array
{
    $opts = array();

    $opts['template-sec1-title'] = weaverx_cz_group_title(
        esc_html__('Section1 Settings', 'weaver-xtreme'),
        esc_html__('These settings are 1111.', 'weaver-xtreme'));
    return $opts;
}

function weaverx_controls_template_section2(): array
{
    $opts = array();

    $opts['template-sec2-title'] = weaverx_cz_group_title(
        esc_html__('Section2 Settings', 'weaver-xtreme'),
        esc_html__('These settings are 2222.', 'weaver-xtreme'));
    return $opts;
}

