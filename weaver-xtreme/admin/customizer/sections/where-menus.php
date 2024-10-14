<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the  w_menus panel
 */
function weaverx_customizer_define_w_menus_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-menus';
    $w_menus_sections = array();

    /**
     * Primary
     */

    $w_menus_sections['w_menus-sec-primary'] = array(
        'panel' => $panel,
        'title' => esc_html__('Primary Menu Bar', 'weaver-xtreme'),
        'description' => 'Attributes for the Primary Menu Bar (Default Location: Bottom of Header)',
        'options' => weaverx_controls_w_menus_primary(),

    );

    $w_menus_sections['w_menus-sec-secondary'] = array(
        'panel' => $panel,
        'title' => esc_html__('Secondary Menu Bar', 'weaver-xtreme'),
        'description' => 'Attributes for the Secondary Menu Bar (Default Location: Top of Header)',
        'options' => weaverx_controls_w_menus_secondary(),

    );

    $w_menus_sections['w_menus-sec-all-menus'] = array(
        'panel' => $panel,
        'title' => esc_html__('Options for All Menus', 'weaver-xtreme'),
        'description' => 'Menu Bar enhancements and features',
        'options' => weaverx_controls_w_menus_all(),

    );

    $w_menus_sections['w_menus-sec-mini-menu'] = array(
        'panel' => $panel,
        'title' => esc_html__('Header Mini Menu', 'weaver-xtreme'),
        'description' => 'Horizontal "Mini-Menu" displayed right-aligned of Site Tagline',
        'options' => weaverx_controls_w_menus_mini(),

    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {
        $w_menus_sections['w_menus-sec-extra'] = array(
            'panel' => $panel,
            'title' => esc_html__('Extra Menu', 'weaver-xtreme'),
            'description' => 'Style the [extra_menu] shortcode or Extra Menu Widget (Weaver Xtreme Plus)',
            'options' => weaverx_controls_w_menus_extra(),

        );
    }

    return $w_menus_sections;
}

// the definitions of the controls for each panel follow


function weaverx_controls_w_menus_primary(): array
{
    $opts = array();


    $opts['visibility-mm-heading'] = weaverx_cz_group_title(
        esc_html__('Primary Menu Visibility', 'weaver-xtreme')
    );

    $opts['m_primary_hide'] = weaverx_cz_select(
        esc_html__('Hide Primary Menu', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['m_primary_hide_arrows'] = weaverx_cz_checkbox(
        esc_html__('Hide Primary Menu Arrows', 'weaver-xtreme'),
        ''
    );

    $opts['m_primary_hide_left'] = weaverx_cz_select_plus(
        esc_html__('Hide Primary Menu Left HTML', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );


    $opts['m_primary_hide_right'] = weaverx_cz_select(
        esc_html__('Hide Primary Menu Right HTML', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['m_primary_login'] = weaverx_cz_checkbox(
        esc_html__('Add Login to Right', 'weaver-xtreme'),
        esc_html__('Add Login link to right end of primary menu.', 'weaver-xtreme'));


    $opts['m_primary_search'] = weaverx_cz_checkbox(
        esc_html__('Add Search to Right', 'weaver-xtreme'),
        esc_html__('Add slide open search icon to right end of primary menu.', 'weaver-xtreme'));


    $opts['menu_nohome'] = weaverx_cz_checkbox(
        esc_html__('No Home Menu Item', 'weaver-xtreme'),
        esc_html__("Don't automatically add Home menu item for home page ( as defined in Settings->Reading )", 'weaver-xtreme')
    );

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


    $opts = array_merge($opts, weaverx_cz_fonts_control('m_primary', esc_html__('Primary Menu Typography', 'weaver-xtreme'), '', 'postMessage'));

    // --- Primary Menu Layout

    $opts['layout-primary-heading'] = weaverx_cz_group_title(esc_html__('Primary Menu Layout', 'weaver-xtreme'));


    $opts['m_primary_fixedtop'] = weaverx_cz_select(    // must be refresh because column class applied to specific page id
        esc_html__('Fixed-Top Primary Menu', 'weaver-xtreme'),
        esc_html__('Fix the Primary Menu to top of page. Use the Menu Align setting to make a full width menu. If you have set the Header to Align Full or Wide, you may want to change the alignment for this item as well.', 'weaver-xtreme'),
        array(
            'none' => esc_html__('Standard Position : Not Fixed', 'weaver-xtreme'),
            'fixed-top' => esc_html__('Fixed to Top', 'weaver-xtreme'),
            'scroll-fix' => esc_html__('Fix to Top on Scroll', 'weaver-xtreme'),
        ),
        'none', 'refresh'
    );

    $opts['m_primary_move'] = weaverx_cz_checkbox(
        esc_html__('Move Primary Menu to Top', 'weaver-xtreme'),
        esc_html__('Move Primary Menu at Top of Header Area. This is not the same as a Fixed-Top Menu (Default: Bottom)', 'weaver-xtreme')
    );


    $opts['m_primary_site_title_left'] = weaverx_cz_checkbox(
        esc_html__('Add Site Title to Left of Primary Menu', 'weaver-xtreme'),
        esc_html__('Adds the Site Title to the left end of the primary menu in larger font size.', 'weaver-xtreme')
    );


    $opts['m_primary_logo_left'] = weaverx_cz_checkbox(
        esc_html__('Add Site Logo to Left', 'weaver-xtreme'),
        esc_html__('Add the Site Logo to the primary menu. Add custom CSS for <em>.custom-logo-on-menu</em> to style. (Use Customize : Site Identity to set Site Logo.)', 'weaver-xtreme') . weaverx_get_logo_html()
    );

    $opts['m_primary_logo_height_dec'] = weaverx_cz_range_float(
        esc_html__('Logo on Menu Bar Height (em)', 'weaver-xtreme'),
        esc_html__('Set height of Logo on Menu. Will interact with padding. Default 0 uses current line height.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 10,
            'step' => .1,
        )
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {
        $opts['m_primary_logo_home_link'] = weaverx_cz_checkbox(
            esc_html__('Logo Links to Home', 'weaver-xtreme'),
            esc_html__('Add a link to home page to logo on menu bar ( must use with defined custom menu ).', 'weaver-xtreme')
        );

        $opts['m_primary_search'] = weaverx_cz_checkbox(
            esc_html__('Add Search to Right', 'weaver-xtreme'),
            esc_html__('Add slide open search icon to right end of primary menu.', 'weaver-xtreme')
        );

        $opts['m_primary_layout_html_t'] = weaverx_cz_heading(esc_html__('Left and Right HTML on Menu', 'weaver-xtreme'));

        $opts['m_primary_html_left'] = weaverx_cz_textarea(esc_html__('Left HTML', 'weaver-xtreme'),
            esc_html__('Add HTML to menu bar. Works best with Centered Menu. You can adjust color and top/bottom spacing on the respective panels.', 'weaver-xtreme'),
            '1', esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
            'postMessage', true);

        $opts['m_primary_html_right'] = weaverx_cz_textarea(esc_html__('Right HTML', 'weaver-xtreme'),
            '',
            '2',
            esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
            'postMessage'
        );
    }

    $opts['primary-mm-title'] = weaverx_cz_group_title(
        esc_html__('Primary Menu Alignment and Spacing', 'weaver-xtreme')
    );

    $opts['m_primary_align'] = weaverx_cz_select(
        esc_html__('Align Primary Menu Bar', 'weaver-xtreme'),
        esc_html__('Align this menu on desktop view. Mobile always left aligned.', 'weaver-xtreme'),
        'weaverx_cz_choices_align_menu', 'left'
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {
        $opts['m_primary_menu_bar_pad_dec'] = weaverx_cz_range_float(
            esc_html__('Desktop Menu Bar Padding', 'weaver-xtreme'),
            esc_html__('Add padding to menu bar top and bottom for Desktop devices.', 'weaver-xtreme'),
            0,
            array(
                'min' => 0,
                'max' => 10,
                'step' => .1,
            )
        );

        $opts['m_primary_top_margin_dec'] = weaverx_cz_range(
            esc_html__('Menu Top Margin (px)', 'weaver-xtreme'),
            '',
            0,
            array(
                'min' => 0,
                'max' => 30,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['m_primary_bottom_margin_dec'] = weaverx_cz_range(
            esc_html__('Menu Bottom Margin (px)', 'weaver-xtreme'),
            '',
            0,
            array(
                'min' => 0,
                'max' => 30,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['m_primary_right_padding_dec'] = weaverx_cz_range_float(
            esc_html__('Desktop Menu Spacing (em)', 'weaver-xtreme'),
            esc_html__('Add space between desktop menu bar items. (not on Smart Menus)', 'weaver-xtreme'),
            0,
            array(
                'min' => 0.0,
                'max' => 6,
                'step' => .2,
            )
        );

        $opts['m_primary_html_margin_dec'] = weaverx_cz_range_float(
            esc_html__('Menu HTML: Top Margin (em)', 'weaver-xtreme'),
            esc_html__('Margin above Added Menu HTML (Used to adjust for Desktop menu. Negative values can help.)', 'weaver-xtreme'),
            0,
            array(
                'min' => -5.0,
                'max' => 5.0,
                'step' => .1,
            ),
            'refresh',
            'plus'
        );

        // GRID LAYOUT ----
        if (weaverx_cz_is_plus('6.1')) {

            $opts['layout-primary-grid-heading'] = weaverx_cz_group_title(esc_html__('Primary Sub-Menu Grid Layout', 'weaver-xtreme'),
                esc_html__('You can use a grid layout for menu sub-menus. The sub-menu items will be laid out in a grid centered on the device. The standard vertical submenu layout is used for mobile devices.', 'weaver-xtreme'));

            $opts['m_primary_grid_submenu'] = weaverx_cz_select(
                esc_html__('Use Grid Layout for Primary Menu Sub-Menus', 'weaver-xtreme'),
                esc_html__('Note that this will automatically use Smart Menus, overriding if necessary.', 'weaver-xtreme'),
                'weaverx_cz_choices_grid_width_items',
                '',
                'refresh'
            );

            $opts['m_primary_grid_cols'] = weaverx_cz_range(
                esc_html__('Number of Columns in Grid', 'weaver-xtreme'),
                esc_html__('Each menu item shows in an equal sized column. More rows are automatically added as needed.','weaver-xtreme'),
                8,
                array(
                    'min' => 2,
                    'max' => 16,
                    'step' => 1,
                ),
                'refresh'
            );

            $opts['m_primary_grid_gap'] = weaverx_cz_range(
                esc_html__('Gap between items in px', 'weaver-xtreme'),
                '',
                4,
                array(
                    'min' => 0,
                    'max' => 20,
                    'step' =>2,
                ),
                'refresh'
            );

            $opts['m_primary_grid_align'] = weaverx_cz_select(
                esc_html__('Align Grid Items', 'weaver-xtreme'),
                '',
                'weaverx_cz_choices_align_grid_item',
                'left',
                'refresh'
            );

            $opts['m_primary_grid_lr_padding'] = weaverx_cz_range(
                esc_html__('Side Padding for Grid Menu in vw', 'weaver-xtreme'),
                esc_html__('Adds padding to sides of grid menu. Units are in vw (viewwidth) which is similar to %.', 'weaver-xtreme'),
                5,
                array(
                    'min' => 0,
                    'max' =>20,
                    'step' =>2.5,
                ),
                'refresh'
            );

            $opts['m_primary_grid_tb_padding'] = weaverx_cz_range(
                esc_html__('Vertical Padding for Grid Menu in px', 'weaver-xtreme'),
                esc_html__('Adds padding to top and bottom of grid menu. Units are in px.', 'weaver-xtreme'),
                5,
                array(
                    'min' => 0,
                    'max' => 50,
                    'step' => 5,
                ),
                'refresh'
            );

            $opts['m_primary_grid_top_margin'] = weaverx_cz_range(
                esc_html__('Top Margin for Grid Menu in px', 'weaver-xtreme'),
                esc_html__('Adds Margin above grid menu to provide separation between parent menu and grid menu.', 'weaver-xtreme'),
                1,
                array(
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                ),
                'refresh'
            );

            $opts['m_primary_grid_note'] = weaverx_cz_text(esc_html__('The grid layout uses the standard sub-menu color, background color, and border settings.', 'weaver-xtreme'));

        } else {
            $opts['layout-primary-grid-heading2'] = weaverx_cz_group_title(esc_html__('Primary Sub-Menu Grid Layout (requires Weaver Xtreme Plus)', 'weaver-xtreme'),
                esc_html__('You can use a grid layout for menu sub-menus if you have the Weaver Xtreme Plus Version 6.2 or later plugin.', 'weaver-xtreme'));
        }
        // GRID LAYOUT ----
    } else {
        $opts['m_primary_for_spacing'] = weaverx_cz_text(esc_html__('Set to Full Options Level for padding and spacing options.', 'weaver-xtreme'));
    }


    // --- Primary Menu Style

    $opts['style-m-heading'] = weaverx_cz_group_title(esc_html__('Primary Menu Style', 'weaver-xtreme'));

    $opts['m_primary_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Primary Menu bar', 'weaver-xtreme'));

    $opts['m_primary_sub_border'] = weaverx_cz_checkbox_post(
        esc_html__('Add border to Sub-Menus', 'weaver-xtreme'));

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {
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
    } else {
        $opts['m_primary_for_spacing2'] = weaverx_cz_text(esc_html__('Set to Full Options Level for shadow and rounded options.', 'weaver-xtreme'));
    }


    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['m_primary_add_class'] = weaverx_cz_add_class_menu(esc_html__('Primary Menu Bar: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}

function weaverx_controls_w_menus_secondary(): array
{
    $opts = array();

    $opts['visibility-sm-heading'] = weaverx_cz_group_title(
        esc_html__('Secondary Menu Visibility', 'weaver-xtreme')
    );

    $opts['m_secondary_hide'] = weaverx_cz_select(
        esc_html__('Hide Secondary Menu', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['m_secondary_hide_arrows'] = weaverx_cz_checkbox(
        esc_html__('Hide Secondary Menu Arrows', 'weaver-xtreme')
    );

    $opts['m_secondary_hide_left'] = weaverx_cz_select_plus(
        esc_html__('Hide Secondary Menu Left HTML', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['m_secondary_hide_right'] = weaverx_cz_select_plus(
        esc_html__('Hide Secondary Menu Right HTML', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['color-sec-heading2'] = weaverx_cz_group_title(esc_html__('Secondary Menu Colors', 'weaver-xtreme'),
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


    $opts = array_merge($opts, weaverx_cz_fonts_control('m_secondary', esc_html__('Secondary Menu Typography', 'weaver-xtreme'), '', 'postMessage'));

    // -------- Secondary Menu Layout ------------

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

        $opts['layout-secondary-heading'] = weaverx_cz_group_title(esc_html__('Secondary Menu Layout', 'weaver-xtreme'));

        $opts['m_secondary_fixedtop'] = weaverx_cz_select(    // must be refresh because column class applied to specific page id
            esc_html__('Fixed-Top Secondary Menu', 'weaver-xtreme'),
            esc_html__('Fix the Secondary Menu to top of page. Use the Menu Align setting to make a full width menu. If you have set the Header to Align Full or Wide, you may want to change the alignment for this item as well.', 'weaver-xtreme'),
            array(
                'none' => esc_html__('Standard Position : Not Fixed', 'weaver-xtreme'),
                'fixed-top' => esc_html__('Fixed to Top', 'weaver-xtreme'),
                'scroll-fix' => esc_html__('Fix to Top on Scroll', 'weaver-xtreme'),
            ),
            'none', 'refresh'
        );

        $opts['m_secondary_move'] = weaverx_cz_checkbox(
            esc_html__('Move Secondary Menu to Bottom', 'weaver-xtreme'),
            esc_html__('Move Secondary Menu to Bottom of Header Area (Default: Top)', 'weaver-xtreme')
        );

        $opts['m_secondary_layout_html_t'] = weaverx_cz_heading(esc_html__('Left and Right HTML on Menu', 'weaver-xtreme'),
            esc_html__('You must define a Secondary Menu from the Custom Menus Content menu.', 'weaver-xtreme'));

        $opts['m_secondary_html_left'] = weaverx_cz_textarea(esc_html__('Left HTML', 'weaver-xtreme'),
            esc_html__('Add HTML to menu bar. Works best with Centered Menu. You can adjust color and top/bottom spacing on the respective panels.', 'weaver-xtreme'),
            '1', esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
            'postMessage', true);


        $opts['m_secondary_html_right'] = weaverx_cz_textarea(esc_html__('Right HTML', 'weaver-xtreme'),
            '',
            '1', esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
            'postMessage', true);
    }

    $opts['spacing-sm-heading'] = weaverx_cz_group_title(
        esc_html__('Secondary Menu Alignment and Spacing', 'weaver-xtreme'));

    $opts['m_secondary_align'] = weaverx_cz_select(
        esc_html__('Align Secondary Menu Bar', 'weaver-xtreme'),
        esc_html__('Align this menu on desktop view. Mobile always left aligned.', 'weaver-xtreme'),
        'weaverx_cz_choices_align_menu', 'left'
    );

    $opts['m_secondary_menu_bar_pad_dec'] = weaverx_cz_range_float(
        esc_html__('Desktop Menu Bar Padding', 'weaver-xtreme'),
        esc_html__('Add padding to menu bar top and bottom for Desktop devices.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 10,
            'step' => .1,
        )
    );

    $opts['m_secondary_top_margin_dec'] = weaverx_cz_range(
        esc_html__('Menu Top Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 30,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['m_secondary_bottom_margin_dec'] = weaverx_cz_range(
        esc_html__('Menu Bottom Margin (px)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 30,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['m_secondary_right_padding_dec'] = weaverx_cz_range_float(
        esc_html__('Desktop Menu Spacing (em)', 'weaver-xtreme'),
        esc_html__('Add space between desktop menu bar items. (not on Smart Menus)', 'weaver-xtreme'),
        0,
        array(
            'min' => 0.0,
            'max' => 6,
            'step' => .2,
        )
    );

    $opts['m_secondary_html_margin_dec'] = weaverx_cz_range_float(
        esc_html__('Menu HTML: Top Margin (em)', 'weaver-xtreme'),
        esc_html__('Margin above Added Menu HTML (Used to adjust for Desktop menu. Negative values can help.)', 'weaver-xtreme'),
        0,
        array(
            'min' => -5.0,
            'max' => 5.0,
            'step' => .1,
        ),
        'refresh',
        'plus'
    );

    // GRID LAYOUT ----
    if (weaverx_cz_is_plus('6.1')) {
        $opts['layout-secondary-grid-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sub-Menu Grid Layout', 'weaver-xtreme'),
                esc_html__('You can use a grid layout for menu sub-menus. The sub-menu items will be laid out in a grid centered on the device. The standard vertical submenu layout is used for mobile devices.', 'weaver-xtreme'));

        $opts['m_secondary_grid_submenu'] = weaverx_cz_select(
            esc_html__('Use Grid Layout for Primary Menu Sub-Menus', 'weaver-xtreme'),
            esc_html__('Note that this will automatically use Smart Menus, overriding if necessary.', 'weaver-xtreme'),
            'weaverx_cz_choices_grid_width_items',
            '',
            'refresh'
        );

        $opts['m_secondary_grid_cols'] = weaverx_cz_range(
            esc_html__('Number of Columns in Grid', 'weaver-xtreme'),
            esc_html__('Each menu item shows in an equal sized column. More rows are automatically added as needed.','weaver-xtreme'),
            8,
            array(
                'min' => 2,
                'max' => 16,
                'step' => 1,
            ),
            'refresh'
        );

        $opts['m_secondary_grid_gap'] = weaverx_cz_range(
            esc_html__('Gap between items in px', 'weaver-xtreme'),
            '',
            4,
            array(
                'min' => 0,
                'max' => 20,
                'step' =>2,
            ),
            'refresh'
        );

        $opts['m_secondary_grid_align'] = weaverx_cz_select(
            esc_html__('Align Grid Items', 'weaver-xtreme'),
            '',
            'weaverx_cz_choices_align_grid_item',
            'left',
            'refresh'
        );

        $opts['m_secondary_grid_lr_padding'] = weaverx_cz_range(
            esc_html__('Side Padding for Grid Menu in vw', 'weaver-xtreme'),
            esc_html__('Adds padding to sides of grid menu. Units are in vw (viewwidth) which is similar to %.', 'weaver-xtreme'),
            5,
            array(
                'min' => 0,
                'max' =>20,
                'step' =>2.5,
            ),
            'refresh'
        );

        $opts['m_secondary_grid_tb_padding'] = weaverx_cz_range(
            esc_html__('Vertical Padding for Grid Menu in px', 'weaver-xtreme'),
            esc_html__('Adds padding to top and bottom of grid menu. Units are in px.', 'weaver-xtreme'),
            5,
            array(
                'min' => 0,
                'max' => 50,
                'step' => 5,
            ),
            'refresh'
        );

        $opts['m_secondary_grid_top_margin'] = weaverx_cz_range(
            esc_html__('Top Margin for Grid Menu in px', 'weaver-xtreme'),
            esc_html__('Adds Margin above grid menu to provide separation between parent menu and grid menu.', 'weaver-xtreme'),
            1,
            array(
                'min' => 0,
                'max' => 40,
                'step' => 1,
            ),
            'refresh'
        );

        $opts['m_secondary_grid_note'] = weaverx_cz_text(esc_html__('The grid layout uses the standard sub-menu color, background color, and border settings.', 'weaver-xtreme'));

    } else {
        $opts['layout-secondary-grid-heading2'] = weaverx_cz_group_title(esc_html__('Secondary Sub-Menu Grid Layout (requires Weaver Xtreme Plus plugin)', 'weaver-xtreme'),
            esc_html__('You can use a grid layout for menu sub-menus if you have the Weaver Xtreme Plus Version 6.2 or later plugin.', 'weaver-xtreme'));
    }
    // GRID LAYOUT ----

    // --- Secondary Menu Style

    $opts['style-ms-heading'] = weaverx_cz_group_title(esc_html__('Secondary Menu Style', 'weaver-xtreme')
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


    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['m_secondary_add_class'] = weaverx_cz_add_class_menu(esc_html__('Secondary Menu Bar: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}

function weaverx_controls_w_menus_all(): array
{
    $opts = array();

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

    $opts['typo-allmenus-heading'] = weaverx_cz_group_title(esc_html__('Typography For All Menus', 'weaver-xtreme'),
        esc_html__('These options specify current page attributes for all menus.', 'weaver-xtreme'));

    $opts['menubar_curpage_bold'] = weaverx_cz_checkbox(
        esc_html__('Bold Current Page', 'weaver-xtreme'),
        esc_html__('Boldface Current Page and ancestors.', 'weaver-xtreme')
    );

    $opts['menubar_curpage_em'] = weaverx_cz_checkbox(
        esc_html__('Italic Current Page', 'weaver-xtreme'),
        esc_html__('Italic Current Page and ancestors.', 'weaver-xtreme')

    );

    $opts['menubar_curpage_noancestors'] = weaverx_cz_checkbox(
        esc_html__('Do Not Highlight Ancestors', 'weaver-xtreme'),
        esc_html__('Highlight Current Page only - do not also highlight ancestor items.', 'weaver-xtreme')
    );


    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

        $opts['layout-switch-heading'] = weaverx_cz_group_title(esc_html__('All Menus Layout', 'weaver-xtreme'));

        $opts['mobile_alt_label'] = weaverx_cz_htmlarea(esc_html__('Mobile Menu "Hamburger" Label', 'weaver-xtreme'),
            esc_html__('Alternative label for the default mobile "Hamburger" icon. HTML allowed, e.g. <code>&lt;span class="genericon genericon-menu">&lt;/span> Menu</code>', 'weaver-xtreme'),
            '1',
            'Any HTML',
            'refresh');

        $opts['mobile_alt_switch'] = weaverx_cz_range(
            esc_html__('Menu Mobile/Desktop Switch Point (px)', 'weaver-xtreme'),
            weaverx_markdown(__('Set width for menu bars to switch from desktop to mobile. (Default: 767px. Hint: use 768 to force mobile menu on iPad portrait.)', 'weaver-xtreme')),
            767,
            array(
                'min' => 300,
                'max' => 1200,
                'step' => 1,
            ),
            'refresh',
            'plus'
        );
    }

    $opts['style-allmenus-heading'] = weaverx_cz_group_title(esc_html__('All Menus Style', 'weaver-xtreme'),
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

    // -- smart menus

    $opts['menus-all-smart-ttl'] = weaverx_cz_group_title(esc_html__('Menu Smart Menus', 'weaver-xtreme'));

    $opts['use_smartmenus'] = weaverx_cz_checkbox(
        esc_html__('Use SmartMenus', 'weaver-xtreme'),
        wp_kses_post(__('Use <em>SmartMenus</em> rather than default Weaver Xtreme Menus. <em>SmartMenus</em> provide enhanced menu support, including auto-visibility, and transition effects. This option is recommended. There are additional <em>Smart Menu</em> options available on the <em>Appearance &rarr; +Xtreme Plus</em> menu.', 'weaver-xtreme'))
    );

    return $opts;
}

function weaverx_controls_w_menus_mini(): array
{
    $opts = array();


    $opts['color-minim-heading'] = weaverx_cz_group_title(esc_html__('Header Mini Menu Colors', 'weaver-xtreme'),
        esc_html__('You must define a Header Menu from the Custom Menus Content menu.', 'weaver-xtreme'));

    $opts['m_header_mini_color'] = weaverx_cz_color('m_header_mini_color',
        esc_html__('Header Mini Menu Text Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['m_header_mini_bgcolor'] = weaverx_cz_color('m_header_mini_bgcolor',
        esc_html__('Header Mini Menu BG Color', 'weaver-xtreme'), '', WEAVERX_MENU_UPDATE);

    $opts['m_header_mini_hover_color'] = weaverx_cz_color('m_header_mini_hover_color',
        esc_html__('Header Mini Menu Hover Text Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts = array_merge($opts, weaverx_cz_fonts_control('m_header_mini', esc_html__('Header Mini Menu Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts['spacing-mm-heading'] = weaverx_cz_group_title(
        esc_html__('Header Mini Menu Spacing', 'weaver-xtreme'), '');

    $opts['m_header_mini_top_margin_dec'] = weaverx_cz_range_float(
        esc_html__('Mini Menu Top Margin (em)', 'weaver-xtreme'),
        esc_html__('Top margin for Header Mini Menu. Negative value moves it up. (Default: -1.0em)', 'weaver-xtreme'),
        -1,
        array(
            'min' => -10.0,
            'max' => 10.0,
            'step' => 0.25,
        ),
        'refresh'
    );

    $opts['m_header_mm_vis'] = weaverx_cz_group_title(esc_html__('Header Mini Menu Visibility', 'weaver-xtreme'));

    $opts['m_header_mini_hide'] = weaverx_cz_select(
        esc_html__('Hide Header Mini Menu', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    return $opts;
}

function weaverx_controls_w_menus_extra(): array
{
    $opts = array();

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

            $opts = array_merge($opts, weaverx_cz_fonts_control('m_extra', esc_html__('Extra Menu Typography', 'weaver-xtreme'), '', 'refresh'));

            if (weaverx_cz_is_plus()) {
                $opts['content-xm-heading'] = weaverx_cz_group_title(esc_html__('Extra Menu Layout', 'weaver-xtreme'));


                $opts['m_extra_html_left'] = weaverx_cz_textarea(esc_html__('Left HTML', 'weaver-xtreme'),
                    esc_html__('Add HTML to menu bar. Works best with Centered Menu. You can adjust color and top/bottom spacing on the respective panels.', 'weaver-xtreme'),
                    '1', esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
                    'postMessage', true);


                $opts['m_extra_html_right'] = weaverx_cz_textarea(esc_html__('Right HTML', 'weaver-xtreme'),
                    '',
                    '1', esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
                    'postMessage', true);
            }

            $opts['extra-sm-heading'] = weaverx_cz_group_title(
                esc_html__('Extra Menu Alignment and Spacing', 'weaver-xtreme') . WEAVERX_PLUS_ICON);

            $opts['m_extra_align'] = weaverx_cz_select(
                esc_html__('Align Extra Menu Bar', 'weaver-xtreme'),
                esc_html__('Align this menu on desktop view. Mobile always left aligned.', 'weaver-xtreme'),
                'weaverx_cz_choices_align_menu', 'left'
            );


            $opts['m_extra_top_margin_dec'] = weaverx_cz_range(
                esc_html__('Menu Top Margin (px)', 'weaver-xtreme'),
                '',
                0,
                array(
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                ),
                'postMessage'
            );

            $opts['m_extra_bottom_margin_dec'] = weaverx_cz_range(
                esc_html__('Menu Bottom Margin (px)', 'weaver-xtreme'),
                '',
                0,
                array(
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                ),
                'postMessage'
            );

            $opts['m_extra_right_padding_dec'] = weaverx_cz_range_float(
                esc_html__('Desktop Menu Spacing (em)', 'weaver-xtreme'),
                esc_html__('Add space between desktop menu bar items. (not on Smart Menus)', 'weaver-xtreme'),
                0,
                array(
                    'min' => 0.0,
                    'max' => 6,
                    'step' => .2,
                )
            );

            $opts['m_extra_html_margin_dec'] = weaverx_cz_range_float(
                esc_html__('Menu HTML: Top Margin (em)', 'weaver-xtreme'),
                esc_html__('Margin above Added Menu HTML (Used to adjust for Desktop menu. Negative values can help.)', 'weaver-xtreme'),
                0,
                array(
                    'min' => -5.0,
                    'max' => 5.0,
                    'step' => .1,
                ),
                'refresh',
                'plus'
            );


            $opts['style-xm-heading'] = weaverx_cz_group_title(esc_html__('Extra Menu Style', 'weaver-xtreme')
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


            $opts['visibility-xm-heading'] = weaverx_cz_group_title(
                esc_html__('Extra Menu Visibility', 'weaver-xtreme')
            );

            $opts['m_extra_hide'] = weaverx_cz_select(
                esc_html__('Hide Extra Menu', 'weaver-xtreme'),
                '',
                'weaverx_cz_choices_hide', 'hide-none', 'refresh'
            );


            $opts['m_extra_hide_arrows'] = weaverx_cz_checkbox(
                esc_html__('Hide Extra Menu Arrows', 'weaver-xtreme')
            );

            $opts['m_extra_hide_left'] = weaverx_cz_select_plus(
                esc_html__('Hide Extra Menu Left HTML', 'weaver-xtreme'),
                '',
                'weaverx_cz_choices_hide', 'hide-none', 'refresh'
            );

            $opts['m_extra_hide_right'] = weaverx_cz_select_plus(
                esc_html__('Hide Extra Menu Right HTML', 'weaver-xtreme'),
                '',
                'weaverx_cz_choices_hide', 'hide-none', 'refresh'
            );

            $opts['m_extra_add_class'] = weaverx_cz_add_class(esc_html__('Extra Menu Bar: Add Classes', 'weaver-xtreme'));

        } else {
            $opts = weaverx_cz_add_plus_message('color_menus', esc_html__('Extra Menu', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
                esc_html__('Add extra menus with <strong>Weaver Xtreme Plus</strong>.', 'weaver-xtreme'));
        }
    }

    return $opts;
}

