<?php
/** PHP 7.4 features added */

/**
 * Define topography settings - Weaver Xtreme Customizer
 */

/**
 * Define the sections and settings for the General panel
 */
function weaverx_customizer_define_typography_sections(): array
{
    $panel = 'weaverx_typography';
    $typography_sections = array();

    /**
     * Global
     */
    $typography_sections['typo-global'] = array(
        'panel' => $panel,
        'title' => esc_html__('Global Typography Options', 'weaver-xtreme'),
        'description' => weaverx_markdown(__('This section covers global typography attributes, including available font families and base font size and spacing. **Default Site Font options:** See the *Typography &rarr; Wrapping Areas* menu.', 'weaver-xtreme')),
        'options' => weaverx_controls_typo_global(),
    );


    /**
     * Wrapping
     */
    $typography_sections['typo-wrapping'] = array(
        'panel' => $panel,
        'title' => esc_html__('Wrapping Areas', 'weaver-xtreme'),
        'description' => esc_html__('Set font and other typography attributes. Use Site Colors to set colors.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_wrapping(),

    );


    /**
     * Links
     */
    $typography_sections['typo-links'] = array(
        'panel' => $panel,
        'title' => esc_html__('Links', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_links(),
    );


    /**
     * Site Header
     */
    $typography_sections['typo-header'] = array(
        'panel' => $panel,
        'title' => esc_html__('Header Area', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_header(),
    );


    /**
     * Main Menu
     */
    $typography_sections['typo-menus'] = array(
        'panel' => $panel,
        'title' => esc_html__('Menus', 'weaver-xtreme'),
        'description' => esc_html__('Set typography for Menus.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_menus(),
    );


    /**
     * Info Bar
     */
    $typography_sections['typo-info-bar'] = array(
        'panel' => $panel,
        'title' => esc_html__('Info Bar', 'weaver-xtreme'),
        'description' => esc_html__('Info Bar with breadcrumbs and paged navigation displayed under Primary Menu.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_infobar(),
    );


    /**
     * Content
     */
    $typography_sections['typo-content'] = array(
        'panel' => $panel,
        'title' => esc_html__('Content', 'weaver-xtreme'),
        'description' => esc_html__('Typography for general page and post content.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_content(),
    );

    /**
     * Post Specific
     */
    $typography_sections['typo-post-specific'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Specific', 'weaver-xtreme'),
        'description' => esc_html__('Post Specific Typography - override Content Typography.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_postspecific(),
    );


    /**
     * Sidebars
     */
    $typography_sections['typo-sidebars'] = array(
        'panel' => $panel,
        'title' => esc_html__('Sidebars &amp; Widget Areas', 'weaver-xtreme'),
        'description' => esc_html__('Main Sidebars and Widget areas. Header and Footer areas options under Header and Footer panels.', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_sidebars(),
    );

    /**
     * Widgets
     */
    $typography_sections['typo-widgets'] = array(
        'panel' => $panel,
        'title' => esc_html__('Individual Widgets', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_widgets(),
    );


    /**
     * Footer
     */
    $typography_sections['typo-footer'] = array(
        'panel' => $panel,
        'title' => esc_html__('Footer Area', 'weaver-xtreme'),
        'options' => weaverx_controls_typo_footer(),
    );


    return $typography_sections;
}

// Now, define all the controls that go in each sub-menu section

function weaverx_controls_typo_global(): array
{

    $opts = array();


    $opts['typo-intro'] = weaverx_cz_heading(
        esc_html__('Using Font Families', 'weaver-xtreme'),
        weaverx_markdown(__('*Weaver Xtreme* includes support for over 30 font family choices: 16 **Web Safe** fonts, and the remaining from a carefully selected set of **Google Fonts**.
The **Google Fonts** will be displayed the same on every browser, *including* Android and iOS devices.
The **Web Safe** will be displayed as specified for most modern browsers, but will likely revert to
one of the three basic fonts supported by Android devices, or a limited set for iOS devices. *We highly recommend selecting **Google Fonts** for your site.*  You can see a demonstration of *Weaver Xtreme\'s* fonts here: ', 'weaver-xtreme')) . weaverx_help_link('font-demo.html', esc_html__('Examples of supported fonts', 'weaver-xtreme'), esc_html__('Font Examples', 'weaver-xtreme'), false)
    );

    $opts['sizing-intro'] = weaverx_cz_group_title(esc_html__('Base Font Size and Spacing', 'weaver-xtreme'), '');

    $opts['site_fontsize_int'] = weaverx_cz_range(
        esc_html__('Site Base Font Size (px)', 'weaver-xtreme'),
        esc_html__("Base font size of standard text. This value determines the default medium font size. Note that visitors can change their browser's font size, so final font size can vary, as expected. Default is 16px.", 'weaver-xtreme'),
        16,
        array(
            'min' => 2,
            'max' => 50,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['moreinfo1'] = weaverx_cz_html_description('<small>' . esc_html__('"Weaver Xtreme Plus" includes options for additional font spacing, and Google Font options.', 'weaver-xtreme') . '</small>', 'plus');


    $opts['site_line_height_dec'] = weaverx_cz_range_float(
        esc_html__(' Site Base Line Height', 'weaver-xtreme'),
        esc_html__('Set the Base line-height. Line heights for various font sizes based on this multiplier. (Default: 1.5 - no units)', 'weaver-xtreme'),
        1.5,
        array(
            'min' => .1,
            'max' => 10.,
            'step' => .1,
        ),
        'postMessage',
        'plus'
    );

    $opts['site_fontsize_tablet_int'] = weaverx_cz_range(
        esc_html__('Site Base Font Size - Small Tablets (px)', 'weaver-xtreme'),
        esc_html__('Small Tablet base font size of standard text. (Default medium font size: 16px)', 'weaver-xtreme'),
        16,
        array(
            'min' => 2,
            'max' => 50,
            'step' => 1,
        ),
        'refresh',
        'plus'
    );

    $opts['site_fontsize_phone_int'] = weaverx_cz_range(
        esc_html__('Site Base Font Size - Phones (px)', 'weaver-xtreme'),
        esc_html__('Phone base font size of standard text. (Default medium font size: 16px)', 'weaver-xtreme'),
        16,
        array(
            'min' => 2,
            'max' => 50,
            'step' => 1,
        ),
        'refresh',
        'plus'
    );

    $opts['custom_fontsize_a'] = weaverx_cz_range_float(
        esc_html__('Custom Font Size A (em)', 'weaver-xtreme'),
        esc_html__('Font Size for Custom Font Size A on the Font Size selection options.', 'weaver-xtreme'),
        1.0,
        array(
            'min' => 0,
            'max' => 20,
            'step' => .1,
        ),
        'refresh',
        'plus'
    );

    $opts['custom_fontsize_b'] = weaverx_cz_range_float(
        esc_html__('Custom Font Size B (em)', 'weaver-xtreme'),
        esc_html__('Font Size for Custom Font Size B on the Font Size selection options.', 'weaver-xtreme'),
        1.0,
        array(
            'min' => 0,
            'max' => 20,
            'step' => .1,
        ),
        'refresh',
        'plus'
    );

    $opts['font_letter_spacing_global_dec'] = weaverx_cz_range_float(
        esc_html__('Character Spacing (em)', 'weaver-xtreme'),
        esc_html__('Add extra spacing between characters. (Default: 0)', 'weaver-xtreme'),
        0.0,
        array(
            'min' => -0.1,
            'max' => .25,
            'step' => .0025,
        ),
        'postMessage',
        'plus'
    );

    $opts['font_word_spacing_global_dec'] = weaverx_cz_range_float(
        esc_html__('Word Spacing (em)', 'weaver-xtreme'),
        esc_html__('Add extra spacing between words. (Default: 0)', 'weaver-xtreme'),
        0.0,
        array(
            'min' => -.5,
            'max' => 1.0,
            'step' => .05,
        ),
        'postMessage',
        'plus'
    );

    $opts['font_color_outline'] = weaverx_cz_color(
        'font_color_outline',
        esc_html__('Outline Fonts Color', 'weaver-xtreme'),
        esc_html__('Color for font body color. Overrides default white color. Hint: use a light color.', 'weaver-xtreme'),
        'refresh'
    );

    if (weaverx_cz_is_old_plus()) {
        $opts['typo-google-font-opts'] = weaverx_cz_group_title(esc_html__('Integrated Google Fonts', 'weaver-xtreme'),
            weaverx_markdown(__('Weaver Xtreme integrates a selected set of Google Font families.  **IMPORTANT NOTE:** Beginning with Weaver Xtreme Version 6, Google Fonts are self-hosted by the theme. This is for EU GDPR compliance. It also improves font loading speed.', 'weaver-xtreme')));


        $opts['typo-lang-intro'] = weaverx_cz_heading(esc_html__('Google Font Language Character Sets', 'weaver-xtreme'),
            esc_html__('The self-hosted Google Fonts support Cryllic, Greek, Hebrew, And Vietnamese, and the previous options for these languages are no longer supported.', 'weaver-xtreme'));

        $opts['typo_plus_vnote'] = weaverx_cz_heading(
            esc_html__('Weaver Xtreme Plus Old Version','weaver-xtreme'),
            weaverx_markdown(__('***IMPORTANT NOTE: You have an older version of Weaver Xtreme Plus.***
While it will work as before, you must use the Plus Font &amp; Custom tab in the Legacy Options Interface to select a font. *In addition, those font
files will be hosted by Google and are not self-hosted which may violate EU privacy laws.* If you upgrade to Weaver Xtreme 6.2 or later, the font selections are
integrated into the Customizer font picker and are self-hosted.', 'weaver-xtreme')));

        $opts['typo-font-family-note2'] = weaverx_cz_heading(
            esc_html__('Add Font Plus Families', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
            wp_kses_post(sprintf(__('<p>The <strong>%1$s</strong> allows you add additional free fonts from
<a href="//www.google.com/webfonts" target="_blank" title="Google Web Fonts"><strong>Google Web Fonts</strong></a>,
<a href="//www.fontsquirrel.com" target="_blank" title="Font Squirrel"><strong>Font Squirrel</strong></a>,
or virtually any other free or commercial font source directly to all the
<em>Font Family</em> selectors found in various text options.</p>
<p>To define Font Families, please "Save &amp; Publish" options you may have set on this Optimizer, then click to open the
<strong>%2$s</strong>, and open the <em>Fonts &amp; Custom</em> tab.
Be sure to <em>Save Settings</em> before leaving the Legacy Weaver Xtreme Admin panel.</p>',
                'weaver-xtreme'),
                weaverx_cz_get_admin_page(esc_html__('Weaver Xtreme Plus Font Control Panel', 'weaver-xtreme')),
                weaverx_cz_get_admin_page(esc_html__('Weaver Xtreme Plus Font Control Panel', 'weaver-xtreme'))))
        );
    } else {
        $opts['typo-google-font-opts'] = weaverx_cz_group_title(esc_html__('Integrated Google Fonts', 'weaver-xtreme'),
            esc_html__('Weaver Xtreme integrates and self-hosts a selected set of Google Font families. Weaver Xtreme Plus adds many other Google Fonts. All supported fonts are displayed in the Font Selection Lists. Plus fonts are indicated with a (+) which is grayed out if you do not have Weaver Xtreme Plus Version 6.2 or later.', 'weaver-xtreme'));
    }


    return $opts;
}

function weaverx_controls_typo_wrapping(): array
{

    // The generalized weaverx_cz_fonts_control generates controls based on the control section being specified.
    // Thus, this controls function varies a bit from the normal pattern as the function will create each
    // element of the $opts array.

    $opts = weaverx_cz_fonts_control('wrapper', esc_html__('Site Wrapper Fonts', 'weaver-xtreme'),
        weaverx_markdown(__('***Default typography for site.*** Set font attributes for the Wrapper that will apply to the entire site. To override other areas, set typography for individual areas and items on other Typography menu panels. (The inherited default Font Family is Open Sans.)', 'weaver-xtreme')), 'postMessage');


    $opts = array_merge($opts, weaverx_cz_fonts_control('container', esc_html__('Container Fonts', 'weaver-xtreme'),
        esc_html__('Container typography for site. Wraps content and sidebars.', 'weaver-xtreme'), 'postMessage')); // no outline

    return $opts;
}

function weaverx_controls_typo_links(): array
{

    // use array_merge to work with font control functions

    $opts = weaverx_cz_fonts_add_link('link', esc_html__('Global Links', 'weaver-xtreme'),
        esc_html__('Global default for link typography ( not including menus and titles ). Set Bold, Italic, and Underline by setting those options for specific areas rather than globally to have more control.', 'weaver-xtreme'), 'refresh');

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('ibarlink', esc_html__('Info Bar Links', 'weaver-xtreme'),
        esc_html__('Typography for links in Info Bar ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('contentlink', esc_html__('Content Links', 'weaver-xtreme'),
        esc_html__('Typography for links in Content ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('ilink', esc_html__('Post Meta Info Links', 'weaver-xtreme'),
        esc_html__('Typography for links in post meta information top and bottom lines. ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('wlink', esc_html__('Individual Widget Links', 'weaver-xtreme'),
        esc_html__('Typography for links in widgets ( uses Standard Link colors if inherit ).', 'weaver-xtreme')));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('footerlink', esc_html__('Footer Area Links', 'weaver-xtreme'),
        esc_html__('Typography for links in Footer ( Uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    return $opts;
}

function weaverx_controls_typo_header(): array
{

    // use array_merge to work with font control functions

    $opts = weaverx_cz_fonts_control('header', esc_html__('Header Area', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('site_title', esc_html__('Site Title', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('tagline', esc_html__('Site Tagline', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('header_sb', esc_html__('Header Widget Area', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('header_html', esc_html__('Header HTML', 'weaver-xtreme'), '', 'postMessage'));

    return $opts;
}

function weaverx_controls_typo_menus(): array
{

    $opts = weaverx_cz_fonts_control('m_primary', esc_html__('Primary Menu', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('m_secondary', esc_html__('Secondary Menu', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('m_header_mini', esc_html__('Header Mini Menu', 'weaver-xtreme'), '', 'postMessage'));

    $cur_page = array(

        'typo-allmenus-heading' => weaverx_cz_group_title(esc_html__('Typography For All Menus', 'weaver-xtreme'),
            esc_html__('These options specify current page attributes for all menus.', 'weaver-xtreme')),

        'menubar_curpage_bold' => weaverx_cz_checkbox(
            esc_html__('Bold Current Page', 'weaver-xtreme'),
            esc_html__('Boldface Current Page and ancestors.', 'weaver-xtreme')
        ),

        'menubar_curpage_em' => weaverx_cz_checkbox(
            esc_html__('Italic Current Page', 'weaver-xtreme'),
            esc_html__('Italic Current Page and ancestors.', 'weaver-xtreme')

        ),

        'menubar_curpage_noancestors' => weaverx_cz_checkbox(
            esc_html__('Do Not Highlight Ancestors', 'weaver-xtreme'),
            esc_html__('Highlight Current Page only - do not also highlight ancestor items.', 'weaver-xtreme')
        ),
    );
    $opts = array_merge($opts, $cur_page);

    if (weaverx_cz_is_plus()) {
        $extra = weaverx_cz_fonts_control('m_extra', esc_html__('Extra Menu', 'weaver-xtreme'), '', 'refresh');
    } else {
        $extra = weaverx_cz_add_plus_message('typo_menus', esc_html__('Extra Menu', 'weaver-xtreme'),
            esc_html__('Add extra menus with <strong>Weaver Xtreme Plus</strong>.', 'weaver-xtreme'));
    }

    $opts = array_merge($opts, $extra);

    return $opts;
}

function weaverx_controls_typo_infobar(): array
{

    $opts = weaverx_cz_fonts_control('info_bar', esc_html__('Info Bar', 'weaver-xtreme'), '', 'postMessage');

    return $opts;
}

function weaverx_controls_typo_content(): array
{

    $opts = weaverx_cz_fonts_control('content', esc_html__('Content Area', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('page_title', esc_html__('Page Title', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    // archive pages title needs refresh due to interaction with page title attributes
    $opts = array_merge($opts, weaverx_cz_fonts_control('archive_title', esc_html__('Archive Pages Title', 'weaver-xtreme'), '', 'refresh', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('content_h', esc_html__('Content Headings', 'weaver-xtreme'),
        esc_html__('Headings ( &lt;h1&gt;-&lt;h6&gt; ) in page and post content.', 'weaver-xtreme'), 'refresh', 'outline'));

    return $opts;
}

function weaverx_controls_typo_postspecific(): array
{

    $opts = weaverx_cz_fonts_control('post', esc_html__('Post Area', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_title', esc_html__('Post Title', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_info_top', esc_html__('Top Post Info Line', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_info_bottom', esc_html__('Bottom Post Info Line', 'weaver-xtreme'), '', 'postMessage'));

    return $opts;
}

function weaverx_controls_typo_sidebars(): array
{

    $opts = weaverx_cz_fonts_control('primary', esc_html__('Primary Sidebar', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('secondary', esc_html__('Secondary Sidebar', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('top', esc_html__('Top Widget Areas', 'weaver-xtreme'),
        esc_html__('Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'), 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('bottom', esc_html__('Bottom Widget Areas', 'weaver-xtreme'),
        esc_html__('Typography for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).', 'weaver-xtreme'), 'postMessage'));

    return $opts;
}

function weaverx_controls_typo_widgets(): array
{

    $opts = weaverx_cz_fonts_control('widget', esc_html__('Individual Widgets', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('widget_title', esc_html__('Individual Widgets Title', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    return $opts;
}

function weaverx_controls_typo_footer(): array
{

    $opts = weaverx_cz_fonts_control('footer', esc_html__('Footer Area', 'weaver-xtreme'), '', 'postMessage');

    $opts = array_merge($opts, weaverx_cz_fonts_control('footer_sb', esc_html__('Footer Widget Area', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('footer_html', esc_html__('Footer HTML', 'weaver-xtreme'), '', 'postMessage'));

    return $opts;
}
