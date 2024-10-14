<?php
/** PHP 7.4 features added */

if (!function_exists('weaverx_customizer_define_image_sections')) :
    /**
     * Define the sections and settings for the Images panel
     */
    function weaverx_customizer_define_image_sections(): array
    {
        global $wp_customize;

        $panel = 'weaverx_images';
        $image_sections = array();


        /**
         * General
         */

        $image_sections['images-global'] = array(
            'panel' => $panel,
            'title' => esc_html__('Global Image Settings', 'weaver-xtreme'),
            'description' => 'Set Image options for Site Wrapper &amp; Container. Use Colors to set colors.',
            'options' => weaverx_controls_images_global(),

        );

        /**
         * Header Image (use WP standard)
         */

        $wp_customize->get_section('header_image')->priority = 10505;
        $wp_customize->get_section('header_image')->panel = $panel;

        /**
         * Header Image Layout
         */

        $image_sections['images-header'] = array(
            'panel' => $panel,
            'title' => esc_html__('Header Image Layout', 'weaver-xtreme'),
            'options' => weaverx_controls_images_header_layout(),
        );


        /**
         * Content
         */

        $image_sections['images-content'] = array(
            'panel' => $panel,
            'title' => esc_html__('Content', 'weaver-xtreme'),
            'description' => esc_html__('Featured Image display on page content.', 'weaver-xtreme'),
            'options' => weaverx_controls_images_content(),
        );


        /**
         * Post Specific
         */
        $image_sections['images-post-specific'] = array(
            'panel' => $panel,
            'title' => esc_html__('Post Specific', 'weaver-xtreme'),
            'description' => esc_html__('Featured Image display with posts.', 'weaver-xtreme'),
            'options' => weaverx_controls_images_postspecific(),
        );

        /**
         *  Background Image (Xtreme Plus)
         */

        $image_sections['images-xtreme-bg'] = array(
            'panel' => $panel,
            'title' => esc_html__('Background Images for Areas', 'weaver-xtreme'),
            'description' => esc_html__('Advanced Area Background Images supported by Weaver Xtreme Plus', 'weaver-xtreme'),
            'options' => weaverx_controls_images_xtremebg(),
        );

        /**
         * Background Image (use WP standard)
         */

        $wp_customize->get_section('background_image')->priority = 10590;
        $wp_customize->get_section('background_image')->title = esc_html__('Background Image - Standard WP', 'weaver-xtreme');

        $wp_customize->get_section('background_image')->panel = $panel;


        return $image_sections;
    }

    // the definitions of the controls for each panel follow


    function weaverx_controls_images_global(): array
    {
        $opts = array();

        $opts['images-heading-global'] = weaverx_cz_group_title(esc_html__('Global Image Settings', 'weaver-xtreme'),
            esc_html__('These settings control images in both the Container ( including content and sidebars ) and Footer Areas. They do not include the Header Area.', 'weaver-xtreme'));

        $opts['media_lib_border_color'] = weaverx_cz_color(
            'media_lib_border_color',
            esc_html__('Image Border Color', 'weaver-xtreme'),
            esc_html__('Border color for images in Container and Footer. You need to make Image Border Width > 0!', 'weaver-xtreme')
        );


        $opts['media_lib_border_int'] = weaverx_cz_range(
            esc_html__('Image Border Width (px)', 'weaver-xtreme'),
            weaverx_markdown(__('Border width for images in Container and Footer. There will be **no** borders unless you set this value above 0px.', 'weaver-xtreme')),
            0,
            array(
                'min' => 0,
                'max' => 50,
                'step' => 1,
            ),
            'postMessage'
        );

        $opts['show_img_shadows'] = weaverx_cz_checkbox_post(esc_html__('Add Image Shadow', 'weaver-xtreme'),
            esc_html__('Add a shadow to images in Container and Footer. Add custom CSS for custom shadow.', 'weaver-xtreme'));

        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
            $opts['restrict_img_border'] = weaverx_cz_checkbox(
                esc_html__('Restrict Borders to Media Library', 'weaver-xtreme'),
                esc_html__('For Container and Footer, restrict border and shadows to images from Media Library. Manually entered &lt;img&gt; HTML without Media Library classes will not have borders.', 'weaver-xtreme')
            );

            $opts['media_lib_border_color_css'] = weaverx_cz_css(
                esc_html__('Custom CSS for Images.', 'weaver-xtreme'),
                esc_html__('Note: this custom CSS will live-update for ALL images, even if the above Restrict Borders is checked.
The normal site view will respect the Restrict Borders setting.', 'weaver-xtreme')
            );
        }

        $opts['caption_color'] = weaverx_cz_color(
            'caption_color',
            esc_html__('Caption Text Color', 'weaver-xtreme'),
            esc_html__('Color of captions - e.g., below media images.', 'weaver-xtreme')
        );

        if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
            $opts['caption_color_css'] = weaverx_cz_css(
                esc_html__('Custom CSS for Captions.', 'weaver-xtreme')
            );
        }

        return $opts;
    }


    function weaverx_controls_images_header_layout(): array
    {
        $opts = array();


        $opts['images-heading-header'] = weaverx_cz_group_title(esc_html__('Site Header Media', 'weaver-xtreme'),
            weaverx_markdown(__('You can set the header image on the *Images : Header Media* menu, one level up from here. The Site Logo is set on the *General Options & Admin : Site Identity* menu.', 'weaver-xtreme')));


        $opts['images-heading-altimg'] = weaverx_cz_heading(
            esc_html__('Alternate Header Images', 'weaver-xtreme'),
            weaverx_markdown(__('You can specify alternate header images using the Content and Post Specific *Featured Image Location* option on the *Images* panel, as well as Per Page and Per Post options.', 'weaver-xtreme'))
        );


        $opts['images-header-image-title'] = weaverx_cz_group_title(
            esc_html__('Header Image', 'weaver-xtreme'),
            wp_kses_post(__('Settings for Site Header Image. <em style="color:red;">These Image settings DO NOT apply to the Header Video.</em>', 'weaver-xtreme'))
        );


        $opts['link_site_image'] = weaverx_cz_checkbox(esc_html__('Header Image Links to Site', 'weaver-xtreme'),
            weaverx_markdown(__('Check to add a link to site home page for Header Image. **Note:** If used with *Move Title/Tagline over Image*, parts of the header image will not be clickable.', 'weaver-xtreme')));


        $opts['header_image_align'] = weaverx_cz_select(
            esc_html__('Align Header Image', 'weaver-xtreme'),
            esc_html__('How to align header image. Wide and Full do not apply to BG header image.', 'weaver-xtreme'),
            'weaverx_cz_choices_align', 'float-left', 'refresh'
        );

        $opts['header_image_render'] = weaverx_cz_select_plus(
            esc_html__('Header Image Rendering', 'weaver-xtreme'),
            weaverx_markdown(__('How to render header image: as img in header or as header area bg image. When rendered as a BG image, other options such as moving Title/Tagline or having image link to home page are not meaningful. Optionally, use *Suggested Header Image Height* above to control BG image height.', 'weaver-xtreme')),
            array(
                'header-as-img' => esc_html__('As img in header', 'weaver-xtreme'),
                'header-as-bg' => esc_html__('As static BG image', 'weaver-xtreme'),
                'header-as-bg-responsive' => esc_html__('As responsive BG image', 'weaver-xtreme'),
                'header-as-bg-parallax' => esc_html__('As parallax BG image', 'weaver-xtreme'),
            ),
            'header-as-img', 'refresh'
        );

        if (weaverx_options_level() >= WEAVERX_LEVEL_INTERMEDIATE) {        // show if full, standard
            $opts['header_min_height'] = weaverx_cz_range(
                esc_html__('Minimum Header Height (px)', 'weaver-xtreme'),
                esc_html__('Set Minimum Height for Header Area. Most useful used with Parallax Header BG Image. Adding Top Margin to Primary Menu bar can also add height.', 'weaver-xtreme'),
                0,
                array(
                    'min' => 0,
                    'max' => 1000,
                    'step' => 10,
                ),
                'refresh',
                'plus'
            );


            $opts['header_image_max_width_dec'] = weaverx_cz_range_float(
                esc_html__('Maximum Image Width (%)', 'weaver-xtreme'),
                esc_html__('Maximum width of Header Image. Can be useful to change Header Image alignment.', 'weaver-xtreme'),
                100.0,
                array(
                    'min' => 10,
                    'max' => 100,
                    'step' => .5,
                ),
                'refresh',
                'plus'
            );


            $opts['header_actual_size'] = weaverx_cz_checkbox_post(esc_html__('Use Actual Image Size', 'weaver-xtreme'),
                esc_html__('Check to use actual header image size. (Default: theme width)', 'weaver-xtreme'), 'plus');


            if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE) {        // show if full
                $opts['header_image_height_int'] = weaverx_cz_range(
                    esc_html__('Suggested Header Image Height (px)', 'weaver-xtreme'),
                    weaverx_markdown(__('Change the suggested height of the Header Image. Standard size is 188. This height is only a suggestion, and only affects the clipping window on the Customizer *Images &rarr; Header Banner Images* panel after you refresh the whole Customize interface. Header images will always be responsively sized. (Default header image width: theme width)', 'weaver-xtreme')),
                    188,
                    array(
                        'min' => 10,
                        'max' => 2400,
                        'step' => 5,
                    )
                );
            }

            $opts['header-image-html-rep-head'] = weaverx_cz_group_title(
                esc_html__('Replace Header Image with HTML', 'weaver-xtreme'),
                ''
            );

            $opts['header_image_html_text'] = weaverx_cz_html_textarea(
                esc_html__('Image HTML Replacement', 'weaver-xtreme'),
                esc_html__('Replace Header image with arbitrary HTML. Useful for slider shortcodes in place of image. FI as Header Image has priority over HTML replacement. Extreme Plus also supports this option on a Per Page/Post basis.', 'weaver-xtreme'),
                '2', 'refresh'
            );

            $opts['header_image_html_home_only'] = weaverx_cz_checkbox(
                esc_html__('Show Replacement only on Front Page', 'weaver-xtreme'),
                esc_html__('Check to use the Image HTML Replacement only on your Front/Home page. Extreme Plus support Per Page/Post control.', 'weaver-xtreme')
            );

            $opts['header_image_html_plus_bg'] = weaverx_cz_checkbox(esc_html__('Also show BG Header Image', 'weaver-xtreme'),
                wp_kses_post(__('If you have Image HTML Replacement defined - including Per Page/Post - and also have set the standard Header Image to display as a BG image, then show <em>both</em> the BG image and the replacement HTML.', 'weaver-xtreme')), 'plus');
        }

        $wp_logo = weaverx_get_wp_custom_logo_url();

        if ($wp_logo) {
            $logo = '<br /><br />' . esc_html__('Current Site Logo: ', 'weaver-xtreme') . "<img alt='Site Logo' src='" . esc_url($wp_logo) . "' style='max-height:36px;margin-left:10px;' />";
        } else {
            $logo = '<br /><br />' . weaverx_markdown(__('***Site Logo has not been set.***', 'weaver-xtreme'));
        }

        // Site Logo

        $opts['images-heading-header-logo'] = weaverx_cz_group_title(esc_html__('Site Logo', 'weaver-xtreme'),
            weaverx_markdown(__('You can set the Site Logo on the **Customize : General Options : Site Identity** menu. Logo visibility set on **Visibility : Header**.', 'weaver-xtreme')
                . $logo));

        $opts['wplogo_for_title'] = weaverx_cz_checkbox(esc_html__('Replace Title with Site Logo', 'weaver-xtreme'),
            esc_html__('Replace the Site Title text with the WP Custom Logo Image', 'weaver-xtreme'));


        $opts['header_logo_height_dec'] = weaverx_cz_range(
            esc_html__('Logo as Title Replacement Height (px)', 'weaver-xtreme'),
            esc_html__('Set height of Logo on Menu. Will interact with padding. (Default: 32px)', 'weaver-xtreme'),
            32,
            array(
                'min' => 10,
                'max' => 200,
                'step' => 1,
            )
        );

        // Video

        $opts['images-heading-header-video'] = weaverx_cz_group_title(
            esc_html__('Header Video', 'weaver-xtreme'),
            wp_kses_post(__('You can set the Header Video on the <em>Customize : Images : Header Media</em> menu.', 'weaver-xtreme'))
        );

        if (function_exists('has_header_video') && has_header_video()) {

            $opts['header_video_render'] = weaverx_cz_select(
                esc_html__('Header Video Rendering', 'weaver-xtreme'),
                wp_kses_post(__('How to render Header Video: as image substitute in header or as full browser background cover image will parallax effect. <em style="color:red;">Note that the Header Image options above do not apply to the Header Video media.</em>', 'weaver-xtreme')),
                'weaverx_cz_choices_render_header_video', 'has-header-video',
                'refresh'
            );

            $opts['header_video_aspect'] = weaverx_cz_select(
                esc_html__('Header Video Aspect Ratio', 'weaver-xtreme'),
                wp_kses_post(__('<strong style="color:red;">CRITICAL SETTING!</strong> It is critical to select aspect ratio of your video. HD 16:9 is the default. This setting should correspond to the native aspect ratio of your video. YouTube allows you to upload any aspect ratio. Most aspect ratios work will for the full cover BG display, or a Banner ratio may work better for the header only view. Ideally, the matching header image will have the same aspect ratio, but it is not critical. If you see letterboxing black bars, you have the wrong aspect ratio selected.', 'weaver-xtreme')),
                'weaverx_cz_choices_header_video_aspect',
                '16:9',
                'refresh'
            );
        }

        // Related

        $opts['images-heading-other'] = weaverx_cz_group_title(
            esc_html__('Related Settings', 'weaver-xtreme')
        );

        $opts['images-heading-srch'] = weaverx_cz_heading(
            esc_html__('Search Box Icon', 'weaver-xtreme'),
            wp_kses_post(__('The icon used in search boxes can be changed in the <em>Colors &rarr; Content</em> section.', 'weaver-xtreme'))
        );

        return $opts;
    }


    function weaverx_controls_images_content(): array
    {
        $opts = array();

        $opts['images-content-heading'] = weaverx_cz_heading(esc_html__('General Image Settings', 'weaver-xtreme'),
            weaverx_markdown(__('General image settings found on the *Global Image Settings* panel.', 'weaver-xtreme')));


        $opts['images-pgextendbg-heading'] = weaverx_cz_heading(esc_html__('Full Width Featured Image BG', 'weaver-xtreme'),
            weaverx_markdown(__('Check the *Content Full Width BG Attributes* option on the *Spacing, Width, Alignment : Full Width Site* menu to get full width Featured Image BG.', 'weaver-xtreme')));


        $opts['images-content-FI'] = weaverx_cz_group_title(esc_html__('Featured Image - Pages', 'weaver-xtreme'),
            esc_html__('Display of Page Featured Images', 'weaver-xtreme'));


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


    function weaverx_controls_images_postspecific(): array
    {
        $opts = array();

        $opts['images-postspecific-heading'] = weaverx_cz_group_title(esc_html__('General Image Settings', 'weaver-xtreme'),
            weaverx_markdown(__('General image settings found on the *Global Image Settings* panel.', 'weaver-xtreme')));


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

        $opts['images-fi-post-h'] = weaverx_cz_group_title(esc_html__('Post Featured Image Options', 'weaver-xtreme'),
            esc_html__('Options for Post Featured Images.', 'weaver-xtreme'));

        $opts['post_fi_nolink'] = weaverx_cz_checkbox(esc_html__("Don't add link to FI", 'weaver-xtreme'),
            esc_html__('Do not add link to Featured Image for any post layout.', 'weaver-xtreme'), 'plus');


        $opts['images-extendbg-heading'] = weaverx_cz_heading(esc_html__('Full Width Featured Image BG', 'weaver-xtreme'),
            weaverx_markdown(__('Check the *Extend Width BG Attributes for all Posts* option on the *Spacing, Width, Alignment : Full Width Site* menu to get full width Featured Image BG.', 'weaver-xtreme')));

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


    function weaverx_controls_images_xtremebg(): array
    {

        $opts = array();

        $opts['xbg-title'] = weaverx_cz_group_title(
            esc_html__('Weaver Xtreme Plus Background Images', 'weaver-xtreme'),
            wp_kses_post(__('<p>Weaver Xtreme Plus supports Background Images for the areas Wrapper, Container, Content, Page, Posts, Sidebars, and Footer.</p>', 'weaver-xtreme'))
        );

        if (weaverx_cz_is_plus()) {

            // weaverx_cz_add_image is a compound function that returns several array elements and thus needs the array_merge
            $opts = array_merge($opts,
                weaverx_cz_add_image('wrapper', esc_html__('Wrapper BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for outer wrapper (#wrapper)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('header', esc_html__('Header BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for header (#header)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('container', esc_html__('Container BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for Container - (#container)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('content', esc_html__('Content BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for Content - wraps page/post area (#content)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('page', esc_html__('Page content BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for Page content area (#content .page)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('post', esc_html__('Post BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for Post content area (#content .post)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('widgets_primary', esc_html__('Primary Sidebar Area BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for primary widget area (#primary-widget-area)', 'weaver-xtreme')
                )
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('widgets_secondary', esc_html__('Secondary Sidebar Areas BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for secondary widget areas (#secondary-widget-area)', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('footer', esc_html__('Footer BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for Footer area (#colophon)', 'weaver-xtreme'))
            );

            $opts['xbg-obsolete'] = weaverx_cz_heading(
                esc_html__('Plus Site BG Image Obsolete', 'weaver-xtreme'),
                wp_kses_post(__('<large style="color:red;">WARNING!</large> use of <em>Site BG Image</em> here is obsolete and can conflict with using the much better <em>Background Images - Standard WP</em> found on the options one level back from here. Using this option is NOT recommended.', 'weaver-xtreme'))
            );

            $opts = array_merge($opts,
                weaverx_cz_add_image('body', esc_html__('Site BG Image', 'weaver-xtreme'),
                    esc_html__('Background image for entire site (body)', 'weaver-xtreme'))
            );
        }

        return $opts;
    }

endif;
