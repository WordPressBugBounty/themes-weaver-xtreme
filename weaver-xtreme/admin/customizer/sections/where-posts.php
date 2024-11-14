<?php
/** PHP 7.4 features added */

/**
 * Define the sections and settings for the panel w_posts panel
 */
function weaverx_customizer_define_w_posts_sections(): array
{
    global $wp_customize;

    $panel = 'weaverx_where-posts';
    $w_posts_sections = array();

    $w_posts_sections['w_posts-post-area'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Area', 'weaver-xtreme'),
        'description' => esc_html__('Use these settings to override Content Area settings for Posts (blog entries).','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_posts(),
    );

    $w_posts_sections['w_posts-post-title'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Title', 'weaver-xtreme'),
        'description' => esc_html__('Options for the Post Title.','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_title(),
    );

    $w_posts_sections['w_posts-post-layout'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Layout', 'weaver-xtreme'),
        'description' => esc_html__('Layout of Posts.','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_layout(),
    );

    $w_posts_sections['w_posts-post-excerpts'] = array(
        'panel' => $panel,
        'title' => esc_html__('Excerpts / Full Posts', 'weaver-xtreme'),
        'description' => esc_html__('How to display posts in Blog / Archive Views','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_excerpts(),
    );

    $w_posts_sections['w_posts-post-fi'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Featured Image', 'weaver-xtreme'),
        'description' => esc_html__('Options for Post Featured Images.', 'weaver-xtreme'),
        'options' => weaverx_controls_w_posts_fi(),
    );

    $w_posts_sections['w_posts-post-meta'] = array(
        'panel' => $panel,
        'title' => esc_html__('Post Meta Info Lines', 'weaver-xtreme'),
        'description' => esc_html__('Top and Bottom Post Meta Information lines.','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_meta(),
    );

    $w_posts_sections['w_posts-post-custom-meta'] = array(
        'panel' => $panel,
        'title' => esc_html__('Custom Post Meta Lines', 'weaver-xtreme'),
        'description' => esc_html__('Replace Post Meta Info Lines with custom info line templates. Advanced options: see help file.','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_custom_meta(),
    );


    $w_posts_sections['w_posts-post-other'] = array(
        'panel' => $panel,
        'title' => esc_html__('Other Post Related Options', 'weaver-xtreme'),
        'description' => esc_html__('Other options related to post display, including single pages.','weaver-xtreme'),
        'options' => weaverx_controls_w_posts_other(),
    );

    return $w_posts_sections;
}

// the definitions of the controls for each panel follow


function weaverx_controls_w_posts_posts(): array
{
    $opts = array();

    $opts['color-post-heading'] = weaverx_cz_group_title(esc_html__('Post Specific Colors', 'weaver-xtreme'));

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

    $opts = array_merge($opts, weaverx_cz_fonts_control('post', esc_html__('Post Area Typography', 'weaver-xtreme'), '', 'postMessage'));


    $opts['w_posts-heading-alsp'] = weaverx_cz_group_title(esc_html__('Post Spacing', 'weaver-xtreme'));

    $opts['post_padding_T'] = weaverx_cz_range(
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

    $opts['post_padding_B'] = weaverx_cz_range(
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

    $opts['post_padding_L'] = weaverx_cz_range_float(
        esc_html__('Left Padding (%)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 30,
            'step' => .25,
        ),
        'postMessage'
    );

    $opts['post_padding_R'] = weaverx_cz_range(
        esc_html__('Right Padding (%)', 'weaver-xtreme'),
        '',
        0,
        array(
            'min' => 0,
            'max' => 30,
            'step' => .25,
        ),
        'postMessage'
    );

    $opts['post_margin_T'] = weaverx_cz_range(
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

    $opts['post_margin_B'] = weaverx_cz_range(
        esc_html__('Bottom Margin (px)', 'weaver-xtreme'),
        '',
        15,
        array(
            'min' => 0,
            'max' => 150,
            'step' => 1,
        ),
        'postMessage'
    );

    $opts['w_post-widthinfo'] = weaverx_cz_heading(esc_html__('Width', 'weaver-xtreme'),
        esc_html__('The width of this area is automatically determined by the enclosing area.', 'weaver-xtreme'));

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['post_smartmargin'] = weaverx_cz_checkbox(
            esc_html__('Add Side Margin(s)', 'weaver-xtreme'),
            esc_html__('Automatically add left/right "smart" margins for separation of areas ( sidebar/content ). This is normally used only if you have borders or BG colors for your sidebars.', 'weaver-xtreme')
        );
    }

    $opts['post_title_bottom_margin_dec'] = weaverx_cz_range_float(
        esc_html__('Space Between Post Title and Content (em)', 'weaver-xtreme'),
        esc_html__('Space between Post title and beginning of content. This will adjust/override the equivalent Content setting.', 'weaver-xtreme'),
        0.2,
        array(
            'min' => -5.0,
            'max' => 20.0,
            'step' => 0.1,
        ),
        'postMessage'
    );


    $opts['w_posts-heading-posts'] = weaverx_cz_group_title(esc_html__('Post Style', 'weaver-xtreme'));

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

    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
        $opts['style_single_like_content'] = weaverx_cz_checkbox(
            esc_html__('Style Single Page View to match Content', 'weaver-xtreme'),
            esc_html__('Allows Single Page post view to match normal content page styling while allowing different styling for post blog-like list views. Includes typography, colors, borders, shadows, and rounded corners.', 'weaver-xtreme')
        );
        $opts['post_add_class'] = weaverx_cz_add_class(esc_html__('Post Area: Add Classes', 'weaver-xtreme'));
    }

    return $opts;
}

function weaverx_controls_w_posts_title(): array
{
    $opts = array();

    $opts['w_posts-heading-title'] = weaverx_cz_group_title(
        esc_html__('Posts Title Colors', 'weaver-xtreme'));

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

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_title', esc_html__('Post Title Typography', 'weaver-xtreme'), '', 'postMessage', 'outline'));

    return $opts;
}

function weaverx_controls_w_posts_layout(): array
{
    $opts = array();

    $opts['w_posts-heading-layout'] = weaverx_cz_group_title(
        esc_html__('Post Layout', 'weaver-xtreme'));

    $opts['layout-post-cols'] = weaverx_cz_group_title(esc_html__('Columns', 'weaver-xtreme'),
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


        $opts['layout-post-nav'] = weaverx_cz_group_title(esc_html__('Post Navigation', 'weaver-xtreme'),
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

function weaverx_controls_w_posts_excerpts(): array
{
    $opts = array();


    $opts['layout-post-excerpt'] = weaverx_cz_group_title(esc_html__('Excerpts / Full Posts', 'weaver-xtreme'),
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


    if (weaverx_options_level() >= WEAVERX_LEVEL_ADVANCED) {        // show if full

        $opts['fullpost_first'] = weaverx_cz_range(
            esc_html__('Full text for first "n" Posts', 'weaver-xtreme'),
            esc_html__('Display the full post for the first "n" posts on Blog pages. Does not override manually added &lt;--more--> breaks.', 'weaver-xtreme'),
            0,
            array('min' => 0, 'max' => 20, 'step' => 1)
        );

        $opts['excerpt_more_msg'] = weaverx_cz_htmlarea(esc_html__('"Continue reading" Message', 'weaver-xtreme'),
            wp_kses_post(__('Change default <em>Continue reading &rarr;</em> message for excerpts. You can include HTML ( e.g., &lt;img> ).', 'weaver-xtreme')),
            '1');
    }

    return $opts;
}

function weaverx_controls_w_posts_meta(): array
{
    $opts = array();

    $opts['w_posts-heading-meta'] = weaverx_cz_group_title(
        esc_html__('Meta Info Colors', 'weaver-xtreme'));

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


    // post meta info bar
    $opts['ilink_color'] = weaverx_cz_color(
        'ilink_color',
        esc_html__('Post Meta Info Link Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['ilink_hover_color'] = weaverx_cz_color(
        'ilink_hover_color',
        esc_html__('Post Meta Info Link Hover Color', 'weaver-xtreme'),
        '', 'refresh');

    $opts['post_icons'] = weaverx_cz_select(
        esc_html__('Text or Icons for Post Info', 'weaver-xtreme'),
        esc_html__('Use Icons instead of Text descriptions in Post Meta Info.', 'weaver-xtreme'),
        array(
            'text' => esc_html__('Text Descriptions', 'weaver-xtreme'),
            'fonticons' => esc_html__('Font Icons', 'weaver-xtreme'),
            'graphics' => esc_html__('Graphic Icons', 'weaver-xtreme'),
        ),
        'text', 'refresh'
    );

    $opts['post_icons_color'] = weaverx_cz_color(
        'post_icons_color',
        esc_html__('Post Font Icons Color', 'weaver-xtreme'),
        esc_html__('Set Font Icon color if Font Icons on Info Lines specified.', 'weaver-xtreme')
    );

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_info_top', esc_html__('Top Post Info Line Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_control('post_info_bottom', esc_html__('Bottom Post Info Line Typography', 'weaver-xtreme'), '', 'postMessage'));

    $opts = array_merge($opts, weaverx_cz_fonts_add_link('ilink', esc_html__('Post Meta Info Links Typography', 'weaver-xtreme'),
        esc_html__('Typography for links in post meta information top and bottom lines. ( uses Standard Link colors if left inherit ).', 'weaver-xtreme')));


    $opts['visibility-posts-metax-heading'] = weaverx_cz_group_title(esc_html__('Post Meta Info Lines Visibility', 'weaver-xtreme'));

    $opts['post_info_hide_top'] = weaverx_cz_checkbox(
        esc_html__('Hide top post meta info line', 'weaver-xtreme'),
        esc_html__('Hide entire top info line ( posted on, by ) of post.', 'weaver-xtreme')
    );

    $opts['post_info_hide_bottom'] = weaverx_cz_checkbox(
        esc_html__('Hide bottom post meta info line', 'weaver-xtreme'),
        esc_html__('Hide entire bottom info line ( posted in, comments ) of post.', 'weaver-xtreme')
    );

    $opts['show_post_bubble'] = weaverx_cz_checkbox(
        esc_html__('Show Comment Bubble', 'weaver-xtreme'),
        esc_html__('Show comment bubble with link to comments on the post info line.', 'weaver-xtreme')
    );

    $opts['show_post_avatar'] = weaverx_cz_select(
        esc_html__('Show Author Avatar', 'weaver-xtreme'),
        esc_html__('Show author avatar on the post info line ( also can be set per post with post editor ).', 'weaver-xtreme'),
        'weaverx_cz_choices_hide', 'hide', 'refresh'
    );

    $opts['visibility-posts-note-meta-heading'] = weaverx_cz_heading(esc_html__('NOTE:', 'weaver-xtreme'),
        esc_html__('Hiding any meta info item will force using Icons instead of text descriptions.', 'weaver-xtreme'));

    $opts['post_hide_date'] = weaverx_cz_checkbox(
        esc_html__('Hide Post Date', 'weaver-xtreme')
    );

    $opts['post_hide_author'] = weaverx_cz_checkbox(
        esc_html__('Hide Post Author', 'weaver-xtreme')
    );

    $opts['post_hide_categories'] = weaverx_cz_checkbox(
        esc_html__('Hide Post Categories', 'weaver-xtreme')
    );

    $opts['post_hide_tags'] = weaverx_cz_checkbox(
        esc_html__('Hide Post Tags', 'weaver-xtreme')
    );

    $opts['hide_permalink'] = weaverx_cz_checkbox(
        esc_html__('Hide Permalink', 'weaver-xtreme')
    );

    $opts['hide_singleton_category'] = weaverx_cz_checkbox(
        esc_html__('Hide Category if Only One', 'weaver-xtreme'),
        esc_html__("If there is only one overall category defined ( Uncategorized ), don't show Category of post.", 'weaver-xtreme')
    );

    $opts['post_hide_single_author'] = weaverx_cz_checkbox(
        esc_html__('Hide Author for Single Author Site', 'weaver-xtreme'),
        esc_html__("Hide author information if site has only a single author.", 'weaver-xtreme')
    );

    $opts['post_info_line1'] = weaverx_cz_line();

    $opts['post_avatar_int'] = weaverx_cz_range(
        esc_html__('Author Avatar Size (px)', 'weaver-xtreme'),
        esc_html__('Size of Author Avatar in px - only for Post Info line. (Default: 28px)', 'weaver-xtreme'),
        28,
        array(
            'min' => 10,
            'max' => 60,
            'step' => 1,
        ),
        'postMessage',
        'plus'
    );


    return $opts;
}

function weaverx_controls_w_posts_fi(): array
{
    $opts = array();

    $opts['images-fi-post-h'] = weaverx_cz_group_title(esc_html__('Post Featured Image Options', 'weaver-xtreme'),
        esc_html__('Options for Post Featured Images.', 'weaver-xtreme'));

    $opts['post_fi_nolink'] = weaverx_cz_checkbox(esc_html__("Don't add link to FI", 'weaver-xtreme'),
        esc_html__('Do not add link to Featured Image for any post layout.', 'weaver-xtreme'), 'plus');


    $opts['images-content-FI-full'] = weaverx_cz_group_title(esc_html__('Featured Image - Full Blog Posts', 'weaver-xtreme'),
        esc_html__('Display of Post Featured Images when Post is displayed as a Full Post.', 'weaver-xtreme'));

    $opts['post_full_fi_location'] = weaverx_cz_select(
        esc_html__('Featured Image Location - Full Post', 'weaver-xtreme'),
        esc_html__('Where to display Featured Image.', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_location', 'content-top', 'refresh'

    );

    $opts['post_blog_min_height'] = weaverx_cz_range(
        esc_html__('Post Height - Blog View (px)', 'weaver-xtreme'),
        esc_html__('Minimum Height of Post, full or excerpt, with Parallax BG in blog views.', 'weaver-xtreme'),
        0,
        array(
            'min' => 10,
            'max' => 2000,
            'step' => 10,
        ),
        'refresh',
        'plus'
    );

    $opts['post_full_fi_align'] = weaverx_cz_select(
        esc_html__('Align Featured Image - Full Post', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_fi_align', 'fi-alignleft', 'refresh'
    );

    $opts['post_full_fi_hide'] = weaverx_cz_select(
        esc_html__('Hide Featured Image - Full Post', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['post_full_fi_size'] = weaverx_cz_select(
        esc_html__('Page Featured Image Size - Full Post', 'weaver-xtreme'),
        esc_html__('Media Library Image Size for Featured Image. ( Header uses full size ).', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_size', 'thumbnail', 'refresh'
    );


    $opts['post_full_fi_width'] = weaverx_cz_range_float(
        esc_html__('Featured Image Width (%) - Full Post', 'weaver-xtreme'),
        esc_html__('Width of Featured Image. Max Width in %, overrides FI Size selection. Set to 0 to avoid overriding above Featured Image Size setting.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 100,
            'step' => 0.5,
        ),
        'refresh',
        'plus'
    );


    $opts['images-content-FI-excerpt'] = weaverx_cz_group_title(esc_html__('Featured Image - Excerpt Posts', 'weaver-xtreme'),
        esc_html__('Display of Post Featured Images when Post is displayed as an Excerpt.', 'weaver-xtreme'));

    $opts['post_excerpt_fi_location'] = weaverx_cz_select(
        esc_html__('Featured Image Location - Excerpt', 'weaver-xtreme'),
        esc_html__('Where to display Featured Image.', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_location', 'content-top', 'refresh'
    );

    $opts['post_excerpt_fi_align'] = weaverx_cz_select(
        esc_html__('Align Featured Image - Excerpt', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_fi_align', 'fi-alignleft', 'refresh'
    );

    $opts['post_excerpt_fi_hide'] = weaverx_cz_select(
        esc_html__('Hide Featured Image - Excerpt', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['post_excerpt_fi_size'] = weaverx_cz_select(
        esc_html__('Page Featured Image Size - Excerpt', 'weaver-xtreme'),
        esc_html__('Media Library Image Size for Featured Image. ( Header uses full size ).', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_size', 'thumbnail', 'refresh'
    );


    $opts['post_excerpt_fi_width'] = weaverx_cz_range_float(
        esc_html__('Featured Image Width (%) - Excerpt', 'weaver-xtreme'),
        esc_html__('Width of Featured Image. Max Width in %, overrides FI Size selection. Set to 0 to avoid overriding above Featured Image Size setting.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 100,
            'step' => 0.5,
        ),
        'refresh',
        'plus'
    );

    $opts['images-content-FI-single'] = weaverx_cz_group_title(esc_html__('Featured Image - Single Page', 'weaver-xtreme'),
        esc_html__('Display of Post Featured Images when Post is displayed on the Single Page.', 'weaver-xtreme'));

    $opts['post_fi_location'] = weaverx_cz_select(
        esc_html__('Featured Image Location - Single Page', 'weaver-xtreme'),
        esc_html__('Where to display Featured Image.', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_location', 'content-top', 'refresh'
    );

    $opts['post_min_height'] = weaverx_cz_range(
        esc_html__('Post Height - Single Page (px)', 'weaver-xtreme'),
        esc_html__('Minimum Height of Post with Parallax BG in Single Page view.', 'weaver-xtreme'),
        0,
        array(
            'min' => 10,
            'max' => 2000,
            'step' => 10,
        ),
        'refresh',
        'plus'
    );

    $opts['post_fi_align'] = weaverx_cz_select(
        esc_html__('Align Featured Image - Single Page', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_fi_align', 'fi-alignleft', 'refresh'
    );

    $opts['post_fi_hide'] = weaverx_cz_select(
        esc_html__('Hide Featured Image - Single Page', 'weaver-xtreme'),
        '',
        'weaverx_cz_choices_hide', 'hide-none', 'refresh'
    );

    $opts['post_fi_size'] = weaverx_cz_select(
        esc_html__('Page Featured Image Size - Single Page', 'weaver-xtreme'),
        esc_html__('Media Library Image Size for Featured Image. ( Header uses full size ).', 'weaver-xtreme'),
        'weaverx_cz_choices_fi_size', 'thumbnail', 'refresh'
    );

    $opts['post_fi_width'] = weaverx_cz_range_float(
        esc_html__('Featured Image Width (%) - Single Page', 'weaver-xtreme'),
        esc_html__('Width of Featured Image. Max Width in %, overrides FI Size selection. Set to 0 to avoid overriding above Featured Image Size setting.', 'weaver-xtreme'),
        0,
        array(
            'min' => 0,
            'max' => 100,
            'step' => 0.5,
        ),
        'refresh',
        'plus'
    );

    return $opts;
}

function weaverx_controls_w_posts_other(): array
{
    $opts = array();


    $opts['post_author_bgcolor'] = weaverx_cz_color(
        'post_author_bgcolor',
        esc_html__('Author Info BG Color', 'weaver-xtreme'),
        esc_html__('Background color used for Author Bio.', 'weaver-xtreme')
    );


    $opts['visibility-posts-misc-heading'] = weaverx_cz_group_title(esc_html__('Other Post Visibility Options', 'weaver-xtreme'));

    $opts['hide_post_format_icon'] = weaverx_cz_checkbox(
        esc_html__('Hide Post Format Icons', 'weaver-xtreme'),
        esc_html__('Hide the icons for posts with Post Format specified.', 'weaver-xtreme'),
        'plus');

    $opts['show_comments_closed'] = weaverx_cz_checkbox(
        esc_html__('Show "Comments are closed"', 'weaver-xtreme'),
        wp_kses_post(__('If comments are off, and no comments have been made, show the <em>Comments are closed.</em> message.', 'weaver-xtreme'))
    );

    $opts['allow_attachment_comments'] = weaverx_cz_checkbox(
        esc_html__('Allow comments for attachments', 'weaver-xtreme'),
        esc_html__('Allow visitors to leave comments for attachments (usually full size media image - only if comments allowed).', 'weaver-xtreme')
    );

    $opts['hide_author_bio'] = weaverx_cz_checkbox(
        esc_html__('Hide Author Bio', 'weaver-xtreme'),
        esc_html__('Hide display of author bio box on Author Archive and Single Post page views.', 'weaver-xtreme')
    );

    $opts = array_merge($opts,
        weaverx_cz_add_image('post', esc_html__('Post BG Image', 'weaver-xtreme'),
            esc_html__('Background image for Post content area (#content .post)', 'weaver-xtreme'))
    );

    return $opts;
}

function weaverx_controls_w_posts_custom_meta(): array
{
    $opts = array();


    $opts['content-post-meta'] = weaverx_cz_group_title(esc_html__('Custom Post Info Lines', 'weaver-xtreme') . WEAVERX_PLUS_ICON,
        esc_html__('Replace Info Lines with custom info line templates. Advanced options: see help file.', 'weaver-xtreme'));

    $opts['custom_posted_on'] = array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_html',
            'transport' => 'refresh',
            'default' => '',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXTAREA_CONTROL,
            'label' => esc_html__('Top Post Info Line', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'description' => esc_html__('Custom template for top post info line. (&#9734;Plus)', 'weaver-xtreme'),
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => '1',
                'placeholder' => esc_html__('Please see help file for info line template info.', 'weaver-xtreme'),
            ),
        ),
    );

    $opts['custom_posted_in'] = array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_html',
            'transport' => 'refresh',
            'default' => '',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXTAREA_CONTROL,
            'label' => esc_html__('Bottom Post Info Line', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'description' => esc_html__('Custom template for bottom post info line. (&#9734;Plus)', 'weaver-xtreme'),
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => '1',
                'placeholder' => esc_html__('Please see help file for info line template info.', 'weaver-xtreme'),
            ),
        ),
    );

    $opts['custom_posted_on_single'] = array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_html',
            'transport' => 'refresh',
            'default' => '',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXTAREA_CONTROL,
            'label' => esc_html__('Top Post Info Line (Single)', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'description' => esc_html__('Custom template for top post info line on single pages.(&#9734;Plus)', 'weaver-xtreme'),
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => '1',
                'placeholder' => esc_html__('Please see help file for info line template info.', 'weaver-xtreme'),
            ),
        ),
    );

    $opts['custom_posted_in_single'] = array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_html',
            'transport' => 'refresh',
            'default' => '',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXTAREA_CONTROL,
            'label' => esc_html__('Bottom Post Info Line (Single)', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'description' => esc_html__('Custom template for bottom post info line on single pages. (&#9734;Plus)', 'weaver-xtreme'),
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => '1',
                'placeholder' => esc_html__('Please see help file for info line template info.', 'weaver-xtreme'),
            ),
        ),
    );


    return $opts;
}

