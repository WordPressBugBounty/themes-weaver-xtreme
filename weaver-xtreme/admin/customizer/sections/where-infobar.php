<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the panel infobar panel
 */
function weaverx_customizer_define_w_infobar_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-infobar';
    $infobar_sections = array();

    $infobar_sections['infobar-settings'] = array(
        'panel' => $panel,
        'title' => esc_html__('Infobar Settings', 'weaver-xtreme'),
        'description' => esc_html__('Set Infobar options.','weaver-xtreme'),
        'options' => weaverx_controls_w_infobar_settings(),
    );

    return $infobar_sections;
}

// the definitions of the controls for each panel follow


function weaverx_controls_w_infobar_settings(): array
{
    $opts = array();

    $opts['info_vis_title'] = weaverx_cz_group_title(
        esc_html__('Info Bar Visibility', 'weaver-xtreme'),
        esc_html__('The Infobar is at the top of the Container, before the Content Area.', 'weaver-xtreme')
    );

    $opts['infobar_hide'] = weaverx_cz_select(
        esc_html__('Hide Info Bar', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['infobar-heading-global'] = weaverx_cz_group_title(
        esc_html__('Infobar Colors', 'weaver-xtreme'));

    $opts['infobar_color'] = weaverx_cz_color(
        'infobar_color',
        esc_html__('Info Bar Text Color', 'weaver-xtreme')
    );

    $opts['infobar_bgcolor'] = weaverx_cz_color(
        'infobar_bgcolor',
        esc_html__('Info Bar BG Color', 'weaver-xtreme')
    );

    $new = weaverx_cz_fonts_control('info_bar', esc_html__('Info Bar Typography', 'weaver-xtreme'), '', 'postMessage');
    $opts = array_merge($opts, $new);

    $opts['spacing-info-bar-heading'] =
        weaverx_cz_group_title(esc_html__('Info Bar Alignment and Spacing', 'weaver-xtreme'));

    $opts['infobar_width_int'] = weaverx_cz_range_float(
        esc_html__('Info Bar Width (%)', 'weaver-xtreme'),
        esc_html__('Width of Area in % of enclosing area on desktop and small tablet. Hint: use with Info Bar "Center align" setting. (Default: 100%, use 0 for auto)', 'weaver-xtreme'),
        100,
        array(
            'min' => 0,
            'max' => 100,
            'step' => 0.5,
        ),
        'postMessage'
    );

    $opts['infobar_align'] = weaverx_cz_select(
        esc_html__('Align Info Bar Area', 'weaver-xtreme'),
        esc_html__('Info Bar alignment options obvious only with no sidebars on page, or width &lt; 100%.', 'weaver-xtreme'),
        'weaverx_cz_choices_align', 'float-left', 'refresh'
    );

    $opts['infobar_padding_T'] = weaverx_cz_range(
        esc_html__('Top Padding (px)', 'weaver-xtreme'),
        esc_html__('These options control the padding ( inner space ) around the area.', 'weaver-xtreme'),
        5,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['infobar_padding_B'] = weaverx_cz_range(
        esc_html__('Bottom Padding (px)', 'weaver-xtreme'),
        '',
        5,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['infobar_padding_L'] = weaverx_cz_range(
        esc_html__('Left Padding (px)', 'weaver-xtreme'),
        '',
        5,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['infobar_padding_R'] = weaverx_cz_range(
        esc_html__('Right Padding (px)', 'weaver-xtreme'),
        '',
        5,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['infobar_margin_T'] = weaverx_cz_range(
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

    $opts['infobar_margin_B'] = weaverx_cz_range(
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

    $opts['infobar-heading-style'] = weaverx_cz_group_title(
        esc_html__('Infobar Style', 'weaver-xtreme'));

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

    $opts['info_xtra_title'] = weaverx_cz_group_title(esc_html__('Info Bar Extra Items', 'weaver-xtreme'));

    $opts['info_hide_breadcrumbs'] = weaverx_cz_checkbox(
        esc_html__('Hide Breadcrumbs', 'weaver-xtreme'),
        esc_html__('Do not display the Breadcrumbs on the Infobar', 'weaver-xtreme')
    );

    $opts['info_hide_pagenav'] = weaverx_cz_checkbox(
        esc_html__('Hide Page Navigation', 'weaver-xtreme'),
        esc_html__('Do not display the numbered Page navigation on the Infobar', 'weaver-xtreme')
    );

    $opts['info_search'] = weaverx_cz_checkbox(
        esc_html__('Show Search Icon', 'weaver-xtreme'),
        esc_html__('Include slide open Search icon on the right.', 'weaver-xtreme')
    );

    $opts['info_addlogin'] = weaverx_cz_checkbox(
        esc_html__('Show Log In', 'weaver-xtreme'),
        esc_html__('Include a simple Log In link on the right.', 'weaver-xtreme')
    );

    $opts['info_home_label'] = weaverx_cz_textarea(esc_html__('Breadcrumb label for Home', 'weaver-xtreme'),
        esc_html__('This lets you change the breadcrumb label for your home page. (Default: Home)', 'weaver-xtreme'),
        '1', '',
        'refresh');

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('ibarlink', esc_html__('Info Bar Links', 'weaver-xtreme'),
        esc_html__('Typography for links in Info Bar ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    $opts['ibarlink_color'] = weaverx_cz_color(
        'ibarlink_color',
        esc_html__('Info Bar Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['ibarlink_hover_color'] = weaverx_cz_color(
        'ibarlink_hover_color',
        esc_html__('Info Bar Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['infobar_add_class'] = weaverx_cz_add_class(esc_html__('Info Bar: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}
