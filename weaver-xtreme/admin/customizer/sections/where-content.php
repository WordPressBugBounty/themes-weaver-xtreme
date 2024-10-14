<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the panel w_content panel
 */
function weaverx_customizer_define_w_content_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-content';
    $w_content_sections = array();

    $w_content_sections['w_content-content'] = array(
        'panel' => $panel,
        'title' => esc_html__('Content Area', 'weaver-xtreme'),
        'description' => 'Area properties for page and post content.',
        'options' => weaverx_controls_w_content_content(),
    );


    $w_content_sections['w_content-links'] = array(
        'panel' => $panel,
        'title' => esc_html__('Links', 'weaver-xtreme'),
        'description' => 'Options for content area links',
        'options' => weaverx_controls_w_content_links(),
    );

    $w_content_sections['w_content-search-boxes'] = array(
        'panel' => $panel,
        'title' => esc_html__('Search Boxes', 'weaver-xtreme'),
        'description' => 'Search box related options.',
        'options' => weaverx_controls_w_content_search_boxes(),
    );

    $w_content_sections['w_content-images'] = array(
        'panel' => $panel,
        'title' => esc_html__('BG Images', 'weaver-xtreme'),
        'description' => 'Background Images for Content area and Pages..',
        'options' => weaverx_controls_w_content_images(),
    );

    $w_content_sections['w_content-fi-pages'] = array(
        'panel' => $panel,
        'title' => esc_html__('Featured Image - Pages', 'weaver-xtreme'),
        'description' => 'Display of Page Featured Images.',
        'options' => weaverx_controls_w_content_fi_pages(),
    );

    $w_content_sections['w_content-lists'] = array(
        'panel' => $panel,
        'title' => esc_html__('Lists - &lt;HR&gt; - Tables', 'weaver-xtreme'),
        'description' => 'Other options related to content.',
        'options' => weaverx_controls_w_content_lists(),
    );

    $w_content_sections['w_content-comments'] = array(
        'panel' => $panel,
        'title' => esc_html__('Comments', 'weaver-xtreme'),
        'description' => 'Settings for displaying comments.',
        'options' => weaverx_controls_w_content_comments(),

    );

    return $w_content_sections;
}

// the definitions of the controls for each panel follow

function weaverx_controls_w_content_content(): array
{
    $opts = array();

    $opts['w_content-heading-colors'] = weaverx_cz_group_title(
        esc_html__('Content Area Colors', 'weaver-xtreme'));

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

    $opts['input_color'] = weaverx_cz_color(
        'input_color',
        esc_html__('Text Input Areas Color', 'weaver-xtreme')
    );

    $opts['input_bgcolor'] = weaverx_cz_color(
        'input_bgcolor',
        esc_html__('Text Input Areas BG Color', 'weaver-xtreme')
    );

    $opts['editor_bgcolor'] = weaverx_cz_color(
        'editor_bgcolor',
        esc_html__('Page/Post Editor BG', 'weaver-xtreme'),
        esc_html__("Alternative Background Color to use for Page/Post editor if you're using transparent or image backgrounds.", 'weaver-xtreme'),
        'refresh'
    );

    $opts = array_merge($opts, weaverx_cz_fonts_control('content', esc_html__('Content Area Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts['content-spacing-t2'] = weaverx_cz_group_title(
        esc_html__('Other Spacing', 'weaver-xtreme')
    );

    $opts['w_content-widthinfo'] = weaverx_cz_heading(esc_html__('Width', 'weaver-xtreme'),
        esc_html__('The width of this area is automatically determined by the enclosing area.', 'weaver-xtreme'));

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['content_smartmargin'] = weaverx_cz_checkbox(
            esc_html__('Add Side Margin(s)', 'weaver-xtreme'),
            esc_html__('Automatically add left/right "smart" margins for separation of areas ( sidebar/content ). This is normally used only if you have borders or BG colors for your sidebars.', 'weaver-xtreme')
        );
    }

    $opts['space_after_title_dec'] = weaverx_cz_range_float(
        esc_html__('Space Between Title and Content (em)', 'weaver-xtreme'),
        esc_html__('Space between Page or Post title and beginning of content.', 'weaver-xtreme'),
        1.0,
        array(
            'min' => 0,
            'max' => 20.0,
            'step' => 0.1,
        ),
        'postMessage'
    );

    $opts = array_merge($opts, weaverx_cz_fonts_control('page_title', esc_html__('Page Title Typography', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    // archive pages title needs refresh due to interaction with page title attributes
    $opts = array_merge($opts, weaverx_cz_fonts_control('archive_title', esc_html__('Archive Pages Title Typography', 'weaver-xtreme'), '', 'refresh', 'outline'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('content_h', esc_html__('Content Headings Typography', 'weaver-xtreme'),
        esc_html__('Headings ( &lt;h1&gt;-&lt;h6&gt; ) in page and post content.', 'weaver-xtreme'), 'refresh', 'outline'));


    $opts['w_content-heading-style0'] = weaverx_cz_group_title(esc_html__('Content Style', 'weaver-xtreme'));

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

    if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, intermediate
        $opts['page_cols'] = weaverx_cz_select(    // must be refresh because column class applied to specific page id
            esc_html__('Content Columns', 'weaver-xtreme'),
            esc_html__('Automatically split all page content into columns. You can also use the Per Page option. This option does not apply to posts.', 'weaver-xtreme'),
            'weaverx_cz_choices_columns', '1', 'refresh');
    }

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['hyphenate'] = weaverx_cz_checkbox(
            esc_html__('Auto Hyphenate Content', 'weaver-xtreme'),
            esc_html__('Allow browsers to automatically hyphenate text for appearance.', 'weaver-xtreme')
        );

        $opts['content_add_class'] = weaverx_cz_add_class(esc_html__('Content: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}

function weaverx_controls_w_content_links(): array
{
    $opts = array();

    $opts['w_content-links-h'] = weaverx_cz_group_title(
        esc_html__('Content Links Colors', 'weaver-xtreme'));

    $opts['contentlink_color'] = weaverx_cz_color(
        'contentlink_color',
        esc_html__('Content Links Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['contentlink_hover_color'] = weaverx_cz_color(
        'contentlink_hover_color',
        esc_html__('Content Links Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('contentlink', esc_html__('Content Links Typography', 'weaver-xtreme'),
        esc_html__('Typography for links in Content ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));

    return $opts;
}

function weaverx_controls_w_content_search_boxes(): array
{
    $opts = array();

    $opts['w_content-heading-search'] = weaverx_cz_group_title(
        esc_html__('Search Colors', 'weaver-xtreme'));

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


    return $opts;
}

function weaverx_controls_w_content_images(): array
{
    $opts = array();

    $opts = array_merge($opts,
        weaverx_cz_add_image('content', esc_html__('Content BG Image', 'weaver-xtreme'),
            esc_html__('Background image for Content - wraps page/post area (#content)', 'weaver-xtreme'))
    );

    $opts = array_merge($opts,
        weaverx_cz_add_image('page', esc_html__('Page content BG Image', 'weaver-xtreme'),
            esc_html__('Background image for Page content area (#content .page)', 'weaver-xtreme'))
    );

    $opts['content_images_note'] = weaverx_cz_group_title(esc_html__('Sitewide Image Options', 'weaver-xtreme'),
        esc_html__('Note: Sitewide options that apply to all images are found on the Global Site Settings &rarr; Images menu.', 'weaver-xtreme'));

    return $opts;
}

function weaverx_controls_w_content_fi_pages(): array
{
    $opts = array();

    $opts['images-content-FI'] = weaverx_cz_group_title(esc_html__('Featured Image - Pages', 'weaver-xtreme'));


    $opts['page_fi_location'] = weaverx_cz_select(
        esc_html__('Featured Image Location', 'weaver-xtreme'),
        esc_html__('Where to display Featured Image for Pages', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_location', 'content-top', 'refresh'
    );


    $opts['page_min_height'] = weaverx_cz_range(
        esc_html__('Page Content Height (px)', 'weaver-xtreme'),
        esc_html__('Minimum Height Page Content with Parallax BG.', 'weaver-xtreme'),
        0,
        array(
            'min' => 10,
            'max' => 2000,
            'step' => 10,
        ),
        'refresh',
        'plus'
    );

    $opts['page_fi_align'] = weaverx_cz_select(
        esc_html__('Align Featured Image', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_fi_align', 'fi-alignleft', 'refresh'
    );


    $opts['page_fi_hide'] = weaverx_cz_select(
        esc_html__('Hide Featured Image', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );


    $opts['page_fi_size'] = weaverx_cz_select(
        esc_html__('Page Featured Image Size', 'weaver-xtreme'),
        esc_html__('Media Library Image Size for Featured Image on pages. ( Header uses full size ).', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_size', 'thumbnail', 'refresh'
    );


    $opts['page_fi_width'] = weaverx_cz_range_float(
        esc_html__('Featured Image Width (%)', 'weaver-xtreme'),
        esc_html__('Width of Featured Image on Pages. Max Width in %, overrides FI Size selection. Set to 0 to avoid overriding above Featured Image Size setting.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 100,
            'step' => 0.5,
        ),
        'refresh',
        'plus'
    );


    $opts['page_fi_nolink'] = weaverx_cz_checkbox(esc_html__("Don't add link to FI", 'weaver-xtreme'),
        esc_html__('Do not add link to Featured Image.', 'weaver-xtreme'), 'plus');


    return $opts;
}

function weaverx_controls_w_content_lists(): array
{
    $opts = array();

    $opts['contentlist_bullet'] = weaverx_cz_select(
        esc_html__('Content List Bullet Style', 'weaver-xtreme'),
        esc_html__('Bullet used for Unordered Lists in Content.', 'weaver-xtreme'),
        'weaverx_cz_choices_list_bullets', 'disc', 'postMessage'
    );

    $opts['hr_color'] = weaverx_cz_color(
        'hr_color',
        esc_html__('&lt;HR&gt; color', 'weaver-xtreme'),
        esc_html__('Color of horizontal ( &lt;hr&gt; ) lines in posts and pages. Use the "Custom CSS &rarr; Content" panel to customize the style of the &lt;hr&gt;.', 'weaver-xtreme')
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

    return $opts;
}

function weaverx_controls_w_content_comments(): array
{
    $opts = array();

    $opts['w_content-heading-comments'] = weaverx_cz_group_title(
        esc_html__('Comment Colors', 'weaver-xtreme'));

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

    $opts['w_content-comment-style'] = weaverx_cz_group_title(
        esc_html__('Comment Style', 'weaver-xtreme'));

    $opts['show_comment_borders'] = weaverx_cz_checkbox(
        esc_html__('Show Borders on Comments', 'weaver-xtreme'),
        esc_html__('Show Borders around comment sections - improves visual look of comments.', 'weaver-xtreme'),
        'plus',
        'postMessage'
    );

    $opts['visibility-content-comments-heading'] = weaverx_cz_group_title(esc_html__('Comments Visibility', 'weaver-xtreme'),
        esc_html__('Visibility settings for Comments area.', 'weaver-xtreme'));

    $opts['hide_old_comments'] = weaverx_cz_checkbox(
        esc_html__('Hide Old Comments When Closed', 'weaver-xtreme'),
        esc_html__('Hide previous comments after closing comments for page or post. (Default: show old comments after closing.)', 'weaver-xtreme')
    );

    $opts['form_allowed_tags'] = weaverx_cz_checkbox(
        esc_html__('Show Allowed HTML', 'weaver-xtreme'),
        esc_html__('Show the allowed HTML tags below comment input box.', 'weaver-xtreme')
    );

    $opts['hide_comment_bubble'] = weaverx_cz_checkbox(
        esc_html__('Hide Comment Title Icon', 'weaver-xtreme'),
        esc_html__('Hide the comment icon ( bubble ) before the Comments title.', 'weaver-xtreme')
    );

    $opts['hide_comment_hr'] = weaverx_cz_checkbox(
        esc_html__('Hide Separator Above Comments', 'weaver-xtreme'),
        esc_html__('Hide the &lt;hr> separator line above the Comments area.', 'weaver-xtreme')
    );


    $opts['visibility-content-comments-note'] = weaverx_cz_heading(esc_html__('Hiding/Enabling Page and Post Comments', 'weaver-xtreme'),
        wp_kses_post(__('Controlling "Reply/Leave a Comment" visibility for pages and posts is <strong>not</strong> a theme function. It is controlled by WordPress on the <em>Settings &rarr; Discussion</em> menu.', 'weaver-xtreme')));

    return $opts;
}


