<?php
/** PHP 7.4 features added */

if (!function_exists('weaverx_customizer_define_layout_sections')) :
    /**
     * Define the sections and settings for the Layout panel
     */
    function weaverx_customizer_define_layout_sections(): array
    {
        $panel = 'weaverx_layout';
        $layout_sections = array();


        /* ==================================== Core Site Layout and Styling (obsolete) ==============================
         ****** REMOVED IN 6.2
         * */

        /* =========================================== Layout: Header Area ======================================== */

        /**
         * Site Header
         */
        $layout_sections['layout-header'] = array(
            'panel' => $panel,
            'title' => esc_html__('Header Area', 'weaver-xtreme'),
            'options' => weaverx_layout_headerarea_opts(),
        );


        /* =========================================== Layout: Menus ======================================== */


        $layout_sections['layout-menus'] = array(
            'panel' => $panel,
            'title' => esc_html__('Menus', 'weaver-xtreme'),
            'description' => esc_html__('Set layout for Menus. Standard and Full Interface Levels have options for the Secondary Menu.', 'weaver-xtreme'),
            'options' => weaverx_layout_menus_opts(),
        );


        /* ================================== Layout: Content ============================ */

        /**
         * Content
         */
        $layout_sections['layout-content'] = array(
            'panel' => $panel,
            'title' => esc_html__('Content', 'weaver-xtreme'),
            'description' => esc_html__('Layout for general page and post content.', 'weaver-xtreme'),
            'options' => weaverx_layout_content_opts(),
        );


        /* ================================== Layout: Post Specific ============================ */

        /**
         * Post Specific
         */
        $layout_sections['layout-post-specific'] = array(
            'panel' => $panel,
            'title' => esc_html__('Post Specific', 'weaver-xtreme'),
            'description' => esc_html__('Post Specific layout - override Content layout.', 'weaver-xtreme'),
            'options' => weaverx_layout_postspecific_opts(),
        );

        /* ================================== Layout: Sidebars ============================ */

        /**
         * Sidebars
         */
        $layout_sections['layout-sidebars'] = array(
            'panel' => $panel,
            'title' => esc_html__('Sidebars & Widget Areas', 'weaver-xtreme'),
            'description' => esc_html__('Main Sidebars and Widget areas. Header and Footer areas options under Header and Footer panels. Note: General Sidebar Layout for different page types is shown first. Layout options for specific Widget Areas ( Primary, Secondary, Top, Bottom ) are shown after that, so scroll down!', 'weaver-xtreme'),
            'options' => weaverx_layout_sidebars_opts(),
        );

        /* ================================== Layout: Footer ============================ */

        /**
         * Footer
         */
        $layout_sections['layout-footer'] = array(
            'panel' => $panel,
            'title' => esc_html__('Footer Area', 'weaver-xtreme'),
            'options' => weaverx_layout_footer_opts(),
        );


        return $layout_sections;

    }
endif;

/* ########################################### Options Implementation ####################################### */


/* =========================================== Layout: Header Area ========================================== */

function weaverx_layout_headerarea_opts(): array
{
    $opts = array();

    $opts['layout-heading-wheader'] = weaverx_cz_group_title(esc_html__('Header Widget Area', 'weaver-xtreme')
    );

    $opts['header_sb_cols_int'] = weaverx_cz_range(
        esc_html__('Header Columns of Widgets', 'weaver-xtreme'),
        '',
        1,
        array('min' => 1, 'max' => 8, 'step' => 1),
        'refresh'
    );

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

        $opts['header_sb_fixedtop'] = weaverx_cz_checkbox(
            esc_html__('Fixed-Top Header Widget Area', 'weaver-xtreme'),
            esc_html__('Fix Header Widget are to top of page. If primary/secondary menus also fixed-top, header widget area will always be after secondary and before primary. If you have set the Header to Align Full or Wide, you may want to change the alignment for this item as well.', 'weaver-xtreme')
        );

    }

    $opts['header_sb_position'] = weaverx_cz_select_plus(
        esc_html__('Header Widget Area Position', 'weaver-xtreme'),
        esc_html__('Change where Header Widget Area is displayed within the Header Area. You can move it to one of seven positions in the Header.', 'weaver-xtreme'),
        array(
            'top' => esc_html__('Top of Header', 'weaver-xtreme'),
            'before_header' => esc_html__('Before Header Image', 'weaver-xtreme'),
            'after_header' => esc_html__('After Header Image', 'weaver-xtreme'),
            'after_html' => esc_html__('After HTML Block', 'weaver-xtreme'),
            'after_menu' => esc_html__('After Lower Menu', 'weaver-xtreme'),
            'pre_header' => esc_html__('Pre-#header &lt;div&gt;', 'weaver-xtreme'),
            'post_header' => esc_html__('Post-#header &lt;div&gt;', 'weaver-xtreme'),
        ),
        'top',
        'refresh'
    );

    $opts['layout-header-custom-widths'] = weaverx_cz_heading(__('Header Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
        esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme'));

    $opts['_header_sb_lw_cols_list'] = weaverx_cz_textarea(
        esc_html__('Header Desktop Widget Widths', 'weaver-xtreme'),
        esc_html__('List of widget widths separated by comma. Use semi-colon (;) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
        '1',
        esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
        'refresh',
        'plus');

    $opts['_header_sb_mw_cols_list'] = weaverx_cz_textarea(
        esc_html__('Header Small Tablet Widget Widths', 'weaver-xtreme'),
        esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
        '1',
        '',
        'refresh',
        'plus'
    );

    $opts['_header_sb_sw_cols_list'] = weaverx_cz_textarea(
        esc_html__('Header Phone Widget Widths', 'weaver-xtreme'),
        esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
        '1',
        '',
        'refresh',
        'plus'
    );

    $opts['header_sb_no_widget_margins'] = weaverx_cz_checkbox(
        esc_html__('Header No Smart Widget Margins', 'weaver-xtreme'),
        esc_html__('Do not use "smart margins" between  multi-column widgets on rows.',
            'weaver-xtreme'));

    $opts['header_sb_eq_widgets'] = weaverx_cz_checkbox(
        esc_html__('Header Equal Height Widget Rows', 'weaver-xtreme'),
        esc_html__('Make widgets equal height rows if &gt; 1 column.',
            'weaver-xtreme'),
        'plus'
    );

    return $opts;
}

/* =========================================== Layout: Menus ================================================ */

function weaverx_layout_menus_opts(): array
{
    $opts = array();

    $opts['layout-primary-heading'] = weaverx_cz_group_title(__('Layout For Primary Menu', 'weaver-xtreme'));


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

    $opts['m_primary_logo_home_link'] = weaverx_cz_checkbox(
        esc_html__('Logo Links to Home', 'weaver-xtreme'),
        esc_html__('Add a link to home page to logo on menu bar ( must use with defined custom menu ).', 'weaver-xtreme')
    );

    $opts['m_primary_login'] = weaverx_cz_checkbox(
        esc_html__('Add Login to Right', 'weaver-xtreme'),
        esc_html__('Add Login link to right end of primary menu.', 'weaver-xtreme'));

    $opts['m_primary_search'] = weaverx_cz_checkbox(
        esc_html__('Add Search to Right', 'weaver-xtreme'),
        esc_html__('Add slide open search icon to right end of primary menu.', 'weaver-xtreme')
    );

    /* add this someday - needs CSS help...
    $opts['mobile_to_right'] = weaverx_cz_checkbox(
         esc_html__('Move mobile "Hamburger" icon to right side of menu.', 'weaver-xtreme')
    );
    */
    // GRID LAYOUT ----
    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {
        if (weaverx_cz_is_plus('6.1')) {


            $opts['layout-primary-grid-heading'] = weaverx_cz_group_title(esc_html__('Primary Sub-Menu Grid Layout', 'weaver-xtreme'),
                esc_html__('You can use a grid layout for menu sub-menus. This works only one level deep for any top-level menu choice. The sub-menu items will be laid out in a grid centered on the full width of the screen. The standard vertical submenu layout is used for mobile devices.', 'weaver-xtreme'));


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
        $opts['layout-primary-grid-heading2'] = weaverx_cz_group_title(esc_html__('Primary Sub-Menu Grid Layout (requires Weaver Xtreme Plus plugin)', 'weaver-xtreme'),
            esc_html__('You can use a grid layout for menu sub-menus if you have the Weaver Xtreme Plus Version 6.2 or later plugin.', 'weaver-xtreme'));
    }

} else {
    $opts['m_primary_for_spacing'] = weaverx_cz_text(esc_html__('Set to Full Options Level for padding and spacing options.', 'weaver-xtreme'));
}
    // GRID LAYOUT ----

    // -------- secondary menu ------------

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

        $opts['layout-secondary-heading'] = weaverx_cz_group_title(esc_html__('Layout For Secondary', 'weaver-xtreme'));

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

    }

    // GRID LAYOUT ----
    if (weaverx_cz_is_plus('6.1')) {
        $opts['layout-secondary-grid-heading'] = weaverx_cz_group_title(esc_html__('Secondary Sub-Menu Grid Layout', 'weaver-xtreme'),
            esc_html__('You can use a grid layout for secondary menu sub-menus. The sub-menu items will be laid out in a grid centered on the display. The standard vertical submenu layout is used for mobile devices.', 'weaver-xtreme'));

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


    $opts['layout-switch-heading'] = weaverx_cz_group_title(esc_html__('Layout For All Menus', 'weaver-xtreme'));

    $opts['mobile_alt_label'] = weaverx_cz_htmlarea(__('Mobile Menu "Hamburger" Label', 'weaver-xtreme'),
        esc_html__('Alternative label for the default mobile "Hamburger" icon. HTML allowed, e.g. <code>&lt;span class="genericon genericon-menu">&lt;/span> Menu</code>', 'weaver-xtreme'),
        '1',
        'Any HTML',
        'refresh');

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

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

        $opts['use_smartmenus'] = weaverx_cz_checkbox(
            esc_html__('Use SmartMenus', 'weaver-xtreme'),
            wp_kses_post(__('Use <em>SmartMenus</em> rather than default Weaver Xtreme Menus. <em>SmartMenus</em> provide enhanced menu support, including auto-visibility, and transition effects. This option is recommended. There are additional <em>Smart Menu</em> options available on the <em>Appearance &rarr; +Xtreme Plus</em> menu.', 'weaver-xtreme'))
        );
    }

    return $opts;
}

/* ========================================== Layout: Content ============================================== */

function weaverx_layout_content_opts(): array
{
    $opts = array();

    $opts['page_cols'] = weaverx_cz_select(    // must be refresh because column class applied to specific page id
        esc_html__('Content Columns', 'weaver-xtreme'),
        esc_html__('Automatically split all page content into columns. You can also use the Per Page option. This option does not apply to posts.', 'weaver-xtreme'),
        'weaverx_cz_choices_columns', '1', 'refresh'
    );

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['hyphenate'] = weaverx_cz_checkbox(
            esc_html__('Auto Hyphenate Content', 'weaver-xtreme'),
            esc_html__('Allow browsers to automatically hyphenate text for appearance.', 'weaver-xtreme')
        );
    }

    return $opts;
}

/* ========================================== Layout: Post Specific ======================================== */

function weaverx_layout_postspecific_opts(): array
{
    $opts = array();

    $opts['layout-post-excerpt'] = weaverx_cz_group_title(__('Excerpts / Full Posts', 'weaver-xtreme'),
        esc_html__('How to display posts in Blog and Archive views.', 'weaver-xtreme'));

    $opts['excerpt_length'] = weaverx_cz_range(
        esc_html__('Excerpt length', 'weaver-xtreme'),
        esc_html__('Change post excerpt length.', 'weaver-xtreme'),
        40,
        array('min' => 2, 'max' => 100, 'step' => 1)
    );

    $opts['fullpost_blog'] = weaverx_cz_checkbox(
        esc_html__('Show Full Blog Posts', 'weaver-xtreme'),
        weaverx_markdown(__('Will display full blog post instead of excerpts on *blog pages*. Does not override manually added &lt;--more--> breaks.', 'weaver-xtreme'))
    );


    $opts['fullpost_archive'] = weaverx_cz_checkbox(
        esc_html__('Full Post for Archives', 'weaver-xtreme')
    );

    $opts['fullpost_search'] = weaverx_cz_checkbox(
        esc_html__('Full Post for Searches', 'weaver-xtreme')
    );

    $opts['fullpost_first'] = weaverx_cz_range(
        esc_html__('Full text for first "n" Posts', 'weaver-xtreme'),
        esc_html__('Display the full post for the first "n" posts on Blog pages. Does not override manually added &lt;--more--> breaks.', 'weaver-xtreme'),
        0,
        array('min' => 0, 'max' => 20, 'step' => 1)
    );

    $opts['layout-post-cols'] = weaverx_cz_group_title(__('Columns', 'weaver-xtreme'),
        esc_html__('Posts in columns.', 'weaver-xtreme'));

    $opts['post_cols'] = weaverx_cz_select(    // must be refresh because column class applied to specific page id
        esc_html__('Post Content Columns', 'weaver-xtreme'),
        esc_html__('Split all post content into columns for both blog and single page views. This applies to individual post content only. Uses CSS for this layout. This is not the same as Columns of Posts.', 'weaver-xtreme'),
        'weaverx_cz_choices_columns', '1', 'refresh'
    );

    $opts['blog_cols'] = weaverx_cz_select(
        esc_html__('Columns of Posts', 'weaver-xtreme'),
        esc_html__('Display posts on blog page with this many columns. HINT: Adjust "Blog pages show at most n posts" on Settings:Reading to be a multiple of columns.', 'weaver-xtreme'),
        array(
            '1' => esc_html__('1 Column', 'weaver-xtreme'),
            '2' => esc_html__('2 Columns', 'weaver-xtreme'),
            '3' => esc_html__('3 Columns', 'weaver-xtreme'),
        ),
        '1', 'refresh'
    );

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard

        $opts['masonry_cols'] = weaverx_cz_select(
            esc_html__('Use Masonry for Posts', 'weaver-xtreme'),
            wp_kses_post(__('Use the <em>Masonry</em> blog layout option to show dynamically packed posts on blog and archive-like pages. Overrides "Columns of Posts" setting. <em>Not compatible with full width FI BG images.</em>', 'weaver-xtreme')),
            'weaverx_cz_choices_masonry_columns', '0', 'refresh'
        );

        $opts['archive_cols'] = weaverx_cz_checkbox(
            esc_html__('Use Columns on Archive Pages', 'weaver-xtreme'),
            esc_html__('Display posts on archive-like pages using columns. (Archive, Author, Category, Tag)', 'weaver-xtreme')
        );

        $opts['blog_first_one'] = weaverx_cz_checkbox(
            esc_html__('First Post One Column', 'weaver-xtreme'),
            esc_html__('Display the first post in one column.', 'weaver-xtreme')
        );

        $opts['blog_sticky_one'] = weaverx_cz_checkbox(
            esc_html__('Sticky Posts One Column', 'weaver-xtreme'),
            esc_html__('Display opening Sticky Posts in one column. If First Post One Column also checked, then first non-sticky post will also be one column.', 'weaver-xtreme')
        );
    }

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard
        $opts['compact_post_formats'] = weaverx_cz_checkbox(
            esc_html__('Compact "Post Format" Posts', 'weaver-xtreme'),
            wp_kses_post(__('Use compact layout for <em>Post Format</em> posts ( Image, Gallery, Video, etc. ). Useful for photo blogs and multi-column layouts. Looks great with <em>Masonry</em>.', 'weaver-xtreme'))
        );


        $opts['layout-post-nav'] = weaverx_cz_group_title(__('Post Navigation', 'weaver-xtreme'),
            esc_html__('Navigation for moving between Posts.', 'weaver-xtreme'));

        $opts['nav_style'] = weaverx_cz_select(
            esc_html__('Blog Navigation Style', 'weaver-xtreme'),
            esc_html__('Style of navigation links on blog pages: "Older/Newer posts", "Previous/Next Post", or by page numbers.', 'weaver-xtreme'),
            array(
                'old_new' => esc_html__('Older/Newer', 'weaver-xtreme'),
                'prev_next' => esc_html__('Previous/Next', 'weaver-xtreme'),
                'paged_left' => esc_html__('Paged - Left', 'weaver-xtreme'),
                'paged_right' => esc_html__('Paged - Right', 'weaver-xtreme'),
            ),
            'old_new', 'refresh'
        );

        $opts['nav_hide_above'] = weaverx_cz_checkbox(
            esc_html__('Hide Top Nav Links', 'weaver-xtreme'),
            esc_html__('Hide the blog navigation links at the top.', 'weaver-xtreme'),
            'plus'
        );

        $opts['nav_hide_below'] = weaverx_cz_checkbox(
            esc_html__('Hide Bottom Nav Links', 'weaver-xtreme'),
            esc_html__('Hide the blog navigation links at the bottom.', 'weaver-xtreme'),
            'plus'
        );

        $opts['Show Top Nav on First Page'] = weaverx_cz_checkbox(
            esc_html__('Show Top Nav on First Page', 'weaver-xtreme'),
            esc_html__('Show navigation at top even on the first page.', 'weaver-xtreme'),
            'plus'
        );


        $opts['single_nav_style'] = weaverx_cz_select(
            esc_html__('Single Page Navigation Style', 'weaver-xtreme'),
            esc_html__('Style of navigation links on post Single pages: Previous/Next, by title, or none.', 'weaver-xtreme'),
            array(
                'title' => esc_html__('Post Titles', 'weaver-xtreme'),
                'prev_next' => esc_html__('Previous/Next', 'weaver-xtreme'),
                'hide' => esc_html__('None - no display', 'weaver-xtreme'),
            ),
            'title', 'refresh'
        );

        $opts['single_nav_link_cats'] = weaverx_cz_checkbox(
            esc_html__('Nav Links to Same Categories', 'weaver-xtreme'),
            esc_html__('Single Page navigation links point to posts with same categories', 'weaver-xtreme')
        );


        $opts['single_nav_hide_above'] = weaverx_cz_checkbox(
            esc_html__('Hide Top Nav Links', 'weaver-xtreme'),
            esc_html__('Hide the single page navigation links at the top.', 'weaver-xtreme'),
            'plus'
        );

        $opts['single_nav_hide_below'] = weaverx_cz_checkbox(
            esc_html__('Hide Bottom Nav Links', 'weaver-xtreme'),
            esc_html__('Hide the single page navigation links at the bottom.', 'weaver-xtreme'),
            'plus'
        );

        $opts['reset_content_opts'] = weaverx_cz_checkbox(
            esc_html__('Clear Major Content Options', 'weaver-xtreme') . WEAVERX_OBSOLETE,
            wp_kses_post(__('<em>ADVANCED OPTION!</em> Clear wrapping Content Area bg, borders, padding, and top/bottom margins for views with posts. Allows more flexible post styling. Most people will not need this.', 'weaver-xtreme'))
        );

    }


    return $opts;
}

/* ========================================== Layout: Sidebars ============================================= */

function weaverx_layout_sidebars_opts(): array
{
    $opts = array();
    $opts['layout-primary-all-heading'] = weaverx_cz_group_title(__('Sidebar Layout for Page Types', 'weaver-xtreme'),
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

    $opts['layout-primary-widget-heading'] = weaverx_cz_group_title(__('Primary Sidebar', 'weaver-xtreme')
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

        $opts['layout-primary-custom-widths'] = weaverx_cz_heading(__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
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
    }

    $opts['layout-secondary-widget-heading'] = weaverx_cz_group_title(__('Secondary Sidebar', 'weaver-xtreme'));

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

        $opts['layout-secondary-custom-widths'] = weaverx_cz_heading(__('Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
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

    // Top Widget areas


    $opts['layout-top-widget-heading'] = weaverx_cz_group_title(esc_html__('Top Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

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

    // Bottom Widget areas

    $opts['layout-bottom-widget-heading'] = weaverx_cz_group_title(esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'));

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

    return $opts;
}

/* ================================== Layout: Footer ============================ */

function weaverx_layout_footer_opts(): array
{
    $opts = array();

    $opts['footer_sb_cols_int'] = weaverx_cz_range(
        esc_html__('Footer Columns of Widgets', 'weaver-xtreme'),
        '',
        1,
        array(
            'min' => 1,
            'max' => 8,
            'step' => 1,
        )
    );

    $opts['layout_full_note3'] = weaverx_cz_html_description(
        '<small>' . wp_kses_post(__('<em>Weaver Xtreme Plus</em> includes options for custom column widths, and smart margins.', 'weaver-xtreme')) . '</small>', 'plus');


    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['layout-footer-custom-widths'] = weaverx_cz_heading(__('Footer Custom Widget Widths', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
            esc_html__('You can optionally specify widget widths, including for specific devices. Overrides the Columns of Widgets setting. Please read the help entry!', 'weaver-xtreme')
        );

        $opts['_footer_sb_lw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Footer Desktop Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths separated by comma. Use semi-colon ( ; ) for end of each row. Widths are % of each row. (&diams;)', 'weaver-xtreme'),
            '1',
            esc_html__('25,25,50; 60,40; - for example', 'weaver-xtreme'),
            'refresh',
            'plus'
        );


        $opts['_footer_sb_mw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Footer Small Tablet Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );

        $opts['_footer_sb_sw_cols_list'] = weaverx_cz_textarea(
            esc_html__('Footer Phone Widget Widths', 'weaver-xtreme'),
            esc_html__('List of widget widths. (&diams;)', 'weaver-xtreme'),
            '1',
            '',
            'refresh',
            'plus'
        );

        $opts['footer_sb_no_widget_margins'] = weaverx_cz_checkbox(
            esc_html__('Footer No Smart Widget Margins', 'weaver-xtreme'),
            esc_html__('Do not use "smart margins" between  multi-column widgets on rows.', 'weaver-xtreme')
        );


        $opts['footer_sb_eq_widgets'] = weaverx_cz_checkbox(
            esc_html__('Footer Equal Height Widget Rows', 'weaver-xtreme'),
            esc_html__('Make widgets equal height rows if &gt; 1 column.', 'weaver-xtreme'),
            'plus'
        );
    }


    return $opts;
}
