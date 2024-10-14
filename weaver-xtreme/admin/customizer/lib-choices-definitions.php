<?php
/** PHP 7.4 features added */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/* Weaver Xtreme - admin choices definitions
 *
 * This file contains definitions of all the choices available for pull-down option.
 * It is based, and should be kept in sync with, the choices definitions in the Customizer code
 */
/* ==================================================== Choices + Sanitizers ===================================== */

function weaverx_cz_choices_align(): array
{
    return array(
        'float-left' => esc_html__('Align Left', 'weaver-xtreme'),
        'align-center' => esc_html__('Center', 'weaver-xtreme'),
        'float-right' => esc_html__('Align Right', 'weaver-xtreme'),
        'alignnone' => esc_html__('No Alignment', 'weaver-xtreme'),
        'alignwide' => esc_html__('Align Wide', 'weaver-xtreme'),
        'alignfull' => esc_html__('Align Full', 'weaver-xtreme'),
        'wvrx-fullwidth' => esc_html__('Extend BG to Full width', 'weaver-xtreme')
    );
}

function weaverx_cz_choices_align_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_align();

    return (isset($choices[$val])) ? $val : '';
}


function weaverx_cz_choices_align_standard(): array
{
    return array(
        'float-left' => esc_html__('Align Left', 'weaver-xtreme'),
        'align-center' => esc_html__('Center', 'weaver-xtreme'),
        'float-right' => esc_html__('Align Right', 'weaver-xtreme'),
        'alignnone' => esc_html__('No Alignment', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_align_standard_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_align_standard();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_align_menu(): array
{
    return array(
        'left' => esc_html__('Align Left', 'weaver-xtreme'),
        'center' => esc_html__('Center', 'weaver-xtreme'),
        'right' => esc_html__('Align Right', 'weaver-xtreme'),
        'alignwide' => esc_html__('Align Wide', 'weaver-xtreme'),
        'alignwide left' => esc_html__('Align Wide, Items Left', 'weaver-xtreme'),
        'alignwide center' => esc_html__('Align Wide, Items Center', 'weaver-xtreme'),
        'alignwide right' => esc_html__('Align Wide, Items Right', 'weaver-xtreme'),
        'alignfull' => esc_html__('Align Full', 'weaver-xtreme'),
        'alignfull left' => esc_html__('Align Full, Items Left', 'weaver-xtreme'),
        'alignfull center' => esc_html__('Align Full, Items Center', 'weaver-xtreme'),
        'alignfull right' => esc_html__('Align Full, Items Right', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_align_menu_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_align_menu();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_align_grid_item(): array
{
    return array(
        'left' => esc_html__('Left', 'weaver-xtreme'),
        'center' => esc_html__('Center', 'weaver-xtreme'),
        'right' => esc_html__('Right', 'weaver-xtreme'),
        'none' => esc_html__('None', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_grid_width_items_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_grid_width_items();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_grid_width_items(): array
{
    return array(
        '' => esc_html__('No Grid Menu - Use Normal Menu', 'weaver-xtreme'),
        '100' => esc_html__('Grid: Full Width', 'weaver-xtreme'),
        '92' => esc_html__('Grid: Wide Width', 'weaver-xtreme'),
        '80' => esc_html__('Grid: Medium Width', 'weaver-xtreme'),
        '68' => esc_html__('Grid: Narrow Width', 'weaver-xtreme'),
    );
}
function weaverx_cz_choices_align_grid_item_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_align_menu();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_hide(): array
{
    return array(
        'hide-none' => esc_html__('Do Not Hide', 'weaver-xtreme'),
        's-hide' => esc_html__('Hide: Phones', 'weaver-xtreme'),
        'm-hide' => esc_html__('Hide: Small Tablets', 'weaver-xtreme'),
        'm-hide s-hide' => esc_html__('Hide: Phones+Tablets', 'weaver-xtreme'),
        'l-hide' => esc_html__('Hide: Desktop', 'weaver-xtreme'),
        'l-hide m-hide' => esc_html__('Hide: Desktop+Tablets', 'weaver-xtreme'),
        'hide' => esc_html__('Hide on All Devices', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_hide_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_hide();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_render_header(): array
{        // coordinate these options with generatecss.php!
    return array(
        'header-as-img' => esc_html__('As img in header', 'weaver-xtreme'),
        'header-as-bg' => esc_html__('As static BG image', 'weaver-xtreme'),
        'header-as-bg-responsive' => esc_html__('As responsive BG image', 'weaver-xtreme'),
        'header-as-bg-parallax' => esc_html__('As parallax BG image', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_render_header_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_render_header();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_render_header_video(): array
{        // coordinate these options with generatecss.php!
    return array(
        'has-header-video' => esc_html__('As video in header only', 'weaver-xtreme'),
        'has-header-video-cover' => esc_html__('As full cover Parallax BG Video', 'weaver-xtreme'),
        'has-header-video-none' => esc_html__('Disable Header Video', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_render_header_video_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_render_header_video();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_header_video_aspect(): array
{        // coordinate these options with generatecss.php!
    return array(
        '16:9' => esc_html__('16:9 HDTV', 'weaver-xtreme'),
        '4:3' => esc_html__('4:3 Std TV', 'weaver-xtreme'),
        '3:2' => esc_html__('3:2 35mm Photo', 'weaver-xtreme'),
        '5:3' => esc_html__('5:3 Alternate Photo', 'weaver-xtreme'),
        '64:27' => esc_html__('2.37:1 Cinemascope', 'weaver-xtreme'),
        '37:20' => esc_html__('1.85:1 VistaVision', 'weaver-xtreme'),
        '3:1' => esc_html__('3:1 Banner', 'weaver-xtreme'),
        '4:1' => esc_html__('4:1 Banner', 'weaver-xtreme'),
        '9:16' => esc_html__('9:16 Vertical HD (Please avoid!)', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_header_video_aspect_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_header_video_aspect();

    return (isset($choices[$val])) ? $val : '';
}


function weaverx_cz_choices_repeat(): array
{
    return array(
        'repeat' => esc_html__('Tile', 'weaver-xtreme'),
        'repeat-x' => esc_html__('Tile Horizontally', 'weaver-xtreme'),
        'repeat-y' => esc_html__('Tile Vertically', 'weaver-xtreme'),
        'no-repeat' => esc_html__('No Tiling', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_repeat_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_repeat();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_border_style(): array
{
    return array(
        'solid' => esc_html__('Solid', 'weaver-xtreme'),
        'dotted' => esc_html__('Dotted', 'weaver-xtreme'),
        'dashed' => esc_html__('Dashed', 'weaver-xtreme'),
        'double' => esc_html__('Double', 'weaver-xtreme'),
        'groove' => esc_html__('Groove', 'weaver-xtreme'),
        'ridge' => esc_html__('Ridge', 'weaver-xtreme'),
        'inset' => esc_html__('Inset', 'weaver-xtreme'),
        'outset' => esc_html__('Outset', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_border_style_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_border_style();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_nav_style(): array
{
    return array(
        'old_new' => esc_html__('Older/Newer', 'weaver-xtreme'),
        'prev_next' => esc_html__('Previous/Next', 'weaver-xtreme'),
        'paged_left' => esc_html__('Paged - Left', 'weaver-xtreme'),
        'paged_right' => esc_html__('Paged - Right', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_nav_style_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_nav_style();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_single_nav_style(): array
{
    return array(
        'title' => esc_html__('Post Titles', 'weaver-xtreme'),
        'prev_next' => esc_html__('Previous/Next', 'weaver-xtreme'),
        'hide' => esc_html__('None - no display', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_single_nav_style_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_single_nav_style();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_columns(): array
{
    return array(
        '1' => esc_html__('1 Column', 'weaver-xtreme'),
        '2' => esc_html__('2 Columns', 'weaver-xtreme'),
        '3' => esc_html__('3 Columns', 'weaver-xtreme'),
        '4' => esc_html__('4 Columns', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_columns_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_columns();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_post_columns(): array
{
    return array(
        '1' => esc_html__('1 Column', 'weaver-xtreme'),
        '2' => esc_html__('2 Columns', 'weaver-xtreme'),
        '3' => esc_html__('3 Columns', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_post_columns_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_post_columns();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_masonry_columns(): array
{
    return array(
        '0' => esc_html__('Do Not Use Masonry', 'weaver-xtreme'),
        '2' => esc_html__('2 Columns', 'weaver-xtreme'),
        '3' => esc_html__('3 Columns', 'weaver-xtreme'),
        '4' => esc_html__('4 Columns', 'weaver-xtreme'),
        '5' => esc_html__('5 Columns', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_masonry_columns_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_masonry_columns();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_pointer(): array
{
    return array(
        'pointer' => esc_html__('Pointer (indicates link)', 'weaver-xtreme'),
        'context-menu' => esc_html__('Context Menu available', 'weaver-xtreme'),
        'text' => esc_html__('Text', 'weaver-xtreme'),
        'none' => esc_html__('No pointer', 'weaver-xtreme'),
        'not-allowed' => esc_html__('Action not allowed', 'weaver-xtreme'),
        'default' => esc_html__('The default cursor', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_pointer_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_pointer();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_fi_location(): array
{
    return array(
        'content-top' => esc_html__('With Content - top', 'weaver-xtreme'),
        'content-bottom' => esc_html__('With Content - bottom', 'weaver-xtreme'),
        'title-before' => esc_html__('With Title', 'weaver-xtreme'),
        'title-banner' => esc_html__('Banner above Title', 'weaver-xtreme'),
        'header-image' => esc_html__('Header Image Replacement', 'weaver-xtreme'),
        'post-before' => esc_html__('Before Page/Post, no wrap', 'weaver-xtreme'),
        'post-bg' => esc_html__('As BG Image, Tile', 'weaver-xtreme'),
        'post-bg-cover' => esc_html__('As BG Image, Cover', 'weaver-xtreme'),
        'post-bg-parallax' => esc_html__('As BG Image, Parallax', 'weaver-xtreme'),
        'post-bg-parallax-full' => esc_html__('As BG Image, Parallax Full', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_fi_location_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_fi_location();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_fi_size(): array
{
    return array(
        'thumbnail' => esc_html__('Thumbnail', 'weaver-xtreme'),
        'medium' => esc_html__('Medium', 'weaver-xtreme'),
        'large' => esc_html__('Large', 'weaver-xtreme'),
        'full' => esc_html__('Full', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_fi_size_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_fi_size();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_fi_align(): array
{
    return array(
        'fi-alignleft' => esc_html__('Align Left', 'weaver-xtreme'),
        'fi-aligncenter' => esc_html__('Center', 'weaver-xtreme'),
        'fi-alignright' => esc_html__('Align Right', 'weaver-xtreme'),
        'alignwide' => esc_html__('Align Wide', 'weaver-xtreme'),
        'alignfull' => esc_html__('Align Full', 'weaver-xtreme'),
        'fi-alignnone' => esc_html__('No Align', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_fi_align_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_fi_align();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_show_avatar(): array
{
    return array(
        'hide' => esc_html__('Do Not Show', 'weaver-xtreme'),
        'start' => esc_html__('Start of Info Line', 'weaver-xtreme'),
        'end' => esc_html__('End of Info Line', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_show_avatar_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_show_avatar();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_post_icons(): array
{
    return array(
        'text' => esc_html__('Text Descriptions', 'weaver-xtreme'),
        'fonticons' => esc_html__('Font Icons', 'weaver-xtreme'),
        'graphics' => esc_html__('Graphic Icons', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_post_icons_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_post_icons();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_font_size(): array
{
    return array(
        'default' => esc_html__('Inherit', 'weaver-xtreme'),
        'm-font-size' => esc_html__('Medium Font', 'weaver-xtreme'),
        'xxs-font-size' => esc_html__('XX-Small Font', 'weaver-xtreme'),
        'xs-font-size' => esc_html__('X-Small Font', 'weaver-xtreme'),
        's-font-size' => esc_html__('Small Font', 'weaver-xtreme'),
        'l-font-size' => esc_html__('Large Font', 'weaver-xtreme'),
        'xl-font-size' => esc_html__('X-Large Font', 'weaver-xtreme'),
        'xxl-font-size' => esc_html__('XX-Large Font', 'weaver-xtreme'),
        'huge-font-size' => esc_html__('Huge Font', 'weaver-xtreme'),
        'customA-font-size' => esc_html__('Custom Size A', 'weaver-xtreme'),
        'customB-font-size' => esc_html__('Custom Size B', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_font_size_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_font_size();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_list_bullets(): array
{
    return array(
        'disc' => esc_html__('Filled Disc', 'weaver-xtreme'),
        'circle' => esc_html__('Circle', 'weaver-xtreme'),
        'square' => esc_html__('Square', 'weaver-xtreme'),
        'none' => esc_html__('None', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_list_bullets_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_list_bullets();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_fixed_menu(): array
{
    return array(
        'none' => esc_html__('Standard Position : Not Fixed', 'weaver-xtreme'),
        'fixed-top' => esc_html__('Fixed to Top', 'weaver-xtreme'),
        'scroll-fix' => esc_html__('Fix to Top on Scroll', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_fixed_menu_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_fixed_menu();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_transform(): array
{

    return array(
        '' => esc_html__('No text transform. (Default)', 'weaver-xtreme'),
        'capitalize' => esc_html__('Uppercase first character of words', 'weaver-xtreme'),
        'uppercase' => esc_html__('Uppercase all characters', 'weaver-xtreme'),
        'lowercase' => esc_html__('Lowercase all characters', 'weaver-xtreme'),
        'inherit' => esc_html__('Inherit from parent element', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_transform_sanitize(string $val): string
{

    $choices = weaverx_cz_choices_transform();

    return (isset($choices[$val])) ? $val : '';

}


function weaverx_cz_choices_font_family(): array
{

    // Now need 3 sets of choices: one compatible with the Old Weaver Xtreme Plus (non-integrated fonts)
    // one compatible with the newer versions of Plus that have integrated selection, and
    // one compatible with Weaver Xtreme

   if (weaverx_cz_is_plus('6.1')) {
        $base = array(

            'inherit' => esc_html__('Inherit', 'weaver-xtreme'),
            'plus-indicator' => esc_html__('---- Weaver Xtreme Plus indicated with (+)', 'weaver-xtreme'),
          );
    } else {    // no plus
        $base = array(
            'updateit' => esc_html__('---- Weaver Xtreme Plus V6 integrates -', 'weaver-xtreme'),
            'updateit2' => esc_html__('---- more Plus fonts into this list   -', 'weaver-xtreme'),
            'updateit3' => '--- ',
            'inherit' => esc_html__('Inherit', 'weaver-xtreme'),
        );
    }


    if (weaverx_cz_is_old_plus()) {
        $google = array(
            'google' => esc_html__('---* Google Fonts ( For All Browsers ) *', 'weaver-xtreme'),
            'sans-g' => esc_html__('--- -- Sans-Serif Google Fonts --', 'weaver-xtreme'),

            'open-sans' => esc_html__('Open Sans', 'weaver-xtreme'),
            'open-sans-condensed' => esc_html__('Open Sans Condensed', 'weaver-xtreme'),
            'alegreya-sans' => esc_html__('Alegreya Sans', 'weaver-xtreme'),
            'alegreya-sans-sc' => esc_html__('Alegreya Sans SC', 'weaver-xtreme'),
            'archivo-black' => esc_html__('Archivo Black', 'weaver-xtreme'),
            'arimo' => esc_html__('Arimo', 'weaver-xtreme'),
            'droid-sans' => esc_html__('Droid Sans', 'weaver-xtreme'),
            'exo-2' => esc_html__('Exo 2', 'weaver-xtreme'),
            'lato' => esc_html__('Lato', 'weaver-xtreme'),
            'roboto' => esc_html__('Roboto', 'weaver-xtreme'),
            'roboto-condensed' => esc_html__('Roboto Condensed', 'weaver-xtreme'),
            'source-sans-pro' => esc_html__('Source Sans Pro', 'weaver-xtreme'),

            'serif-g' => esc_html__('--- -- Serif Google Fonts --', 'weaver-xtreme'),

            'alegreya' => esc_html__('Alegreya', 'weaver-xtreme'),
            'alegreya-sc' => esc_html__('Alegreya SC', 'weaver-xtreme'),
            'arvo' => esc_html__('Arvo Slab', 'weaver-xtreme'),

            'droid-serif' => esc_html__('Droid Serif', 'weaver-xtreme'),
            'lora' => esc_html__('Lora', 'weaver-xtreme'),

            'roboto-slab' => esc_html__('Roboto Slab', 'weaver-xtreme'),
            'source-serif-pro' => esc_html__('Source Serif Pro', 'weaver-xtreme'),
            'tinos' => esc_html__('Tinos', 'weaver-xtreme'),
            'vollkorn' => esc_html__('Vollkorn', 'weaver-xtreme'),
            'ultra' => esc_html__('Ultra Black', 'weaver-xtreme'),

            'mono-g' => esc_html__('--- -- Monospace Google Fonts --', 'weaver-xtreme'),

            'inconsolata' => esc_html__('Inconsolata', 'weaver-xtreme'),
            'roboto-mono' => esc_html__('Roboto Mono', 'weaver-xtreme'),

            'cursive-g' => esc_html__('--- -- "Cursive" Google Fonts --', 'weaver-xtreme'),

            'handlee' => esc_html__('Handlee', 'weaver-xtreme'),

            'blank-w' => esc_html__('--- ', 'weaver-xtreme'),

        );

    } else if (weaverx_cz_is_plus('6.1')) {        // Plus fonts integrated to theme Customizer
        $google = array(
            'google' => esc_html__('---* Google Fonts ( For All Browsers ) *', 'weaver-xtreme'),
            'plus-indicator' => esc_html__('---- Weaver Xtreme Plus indicated with (+)', 'weaver-xtreme'),
            'sans-g' => esc_html__('--- -- Sans-Serif Google Fonts --', 'weaver-xtreme'),


            'open-sans' => esc_html__('Open Sans', 'weaver-xtreme'),
            'open-sans-condensed' => esc_html__('Open Sans Condensed', 'weaver-xtreme'),
            'dosis' => 'Dosis (+)',
            'alegreya-sans' => esc_html__('Alegreya Sans', 'weaver-xtreme'),
            'alegreya-sans-sc' => esc_html__('Alegreya Sans SC', 'weaver-xtreme'),
            'archivo-black' => esc_html__('Archivo Black', 'weaver-xtreme'),
            'arimo' => esc_html__('Arimo', 'weaver-xtreme'),
            'droid-sans' => esc_html__('Droid Sans', 'weaver-xtreme'),
            'exo-2' => esc_html__('Exo 2', 'weaver-xtreme'),
            'lato' => esc_html__('Lato', 'weaver-xtreme'),
            'montserrat' => 'Montserrat (+)',
            'noto-sans' => 'Noto Sans (+)',
            'oswald' => 'Oswald (+)',
            'oxygen' => 'Oxygen (+)',
            'pt-sans' => 'PT Sans (+)',
            'pt-sans-narrow' => 'PT Sans Narrow (+)',
            'raleway' => 'Raleway (+)',
            'roboto' => esc_html__('Roboto', 'weaver-xtreme'),
            'roboto-condensed' => esc_html__('Roboto Condensed', 'weaver-xtreme'),
            'source-sans-pro' => esc_html__('Source Sans Pro', 'weaver-xtreme'),
            'titillium-web' => 'Titillium Web (+)',
            'ubuntu' => 'Ubuntu (+)',
            'yanone-kaffeesatz' => 'Yanone Kaffeesatz (+)',

            'serif-g' => esc_html__('--- -- Serif Google Fonts --', 'weaver-xtreme'),

            'alegreya' => esc_html__('Alegreya', 'weaver-xtreme'),
            'alegreya-sc' => esc_html__('Alegreya SC', 'weaver-xtreme'),
            'arvo' => esc_html__('Arvo Slab', 'weaver-xtreme'),
            'bitter' => 'Bitter (+)',
            'droid-serif' => esc_html__('Droid Serif', 'weaver-xtreme'),
            'lora' => esc_html__('Lora', 'weaver-xtreme'),
            'merriweather' => 'Merriweather (+)',
            'noto-serif' => 'Noto Serif (+)',
            'playfair-display' => 'Playfair Display (+)',
            'pt-serif' => 'PT Serif (+)',
            'roboto-slab' => esc_html__('Roboto Slab', 'weaver-xtreme'),
            'rokkitt' => 'Rokkitt (+)',
            'source-serif-pro' => esc_html__('Source Serif Pro', 'weaver-xtreme'),
            'tinos' => esc_html__('Tinos', 'weaver-xtreme'),
            'vollkorn' => esc_html__('Vollkorn', 'weaver-xtreme'),
            'ultra' => esc_html__('Ultra Black', 'weaver-xtreme'),

            'mono-g' => esc_html__('--- -- Monospace Google Fonts --', 'weaver-xtreme'),

            'droid-sans-mono' => 'Droid Sans Mono (+)',
            'inconsolata' => esc_html__('Inconsolata', 'weaver-xtreme'),
            'nova-mono' => 'Nova Mono (+)',
            'roboto-mono' => esc_html__('Roboto Mono', 'weaver-xtreme'),
            'ubuntu-mono' => 'Ubuntu Mono (+)',

            'cursive-g' => esc_html__('--- -- "Cursive" Google Fonts --', 'weaver-xtreme'),

            'dancing-script' => 'Dancing Script (+)',
            'handlee' => esc_html__('Handlee', 'weaver-xtreme'),
            'indie-flower' => 'Indie Flower (+)',

            'blank-w' => esc_html__('--- ', 'weaver-xtreme'),

        );
    } else {        // NO Plus
        $google = array(
            'google' => esc_html__('---* Google Fonts ( For All Browsers ) *', 'weaver-xtreme'),

            'sans-g' => esc_html__('--- -- Sans-Serif Google Fonts --', 'weaver-xtreme'),

            'open-sans' => esc_html__('Open Sans', 'weaver-xtreme'),
            'open-sans-condensed' => esc_html__('Open Sans Condensed', 'weaver-xtreme'),
            'dosis' => '---  Dosis (+)',
            'alegreya-sans' => esc_html__('Alegreya Sans', 'weaver-xtreme'),
            'alegreya-sans-sc' => esc_html__('Alegreya Sans SC', 'weaver-xtreme'),
            'archivo-black' => esc_html__('Archivo Black', 'weaver-xtreme'),
            'arimo' => esc_html__('Arimo', 'weaver-xtreme'),
            'droid-sans' => esc_html__('Droid Sans', 'weaver-xtreme'),
            'exo-2' => esc_html__('Exo 2', 'weaver-xtreme'),
            'lato' => esc_html__('Lato', 'weaver-xtreme'),
            'montserrat' => '---  Montserrat (+)',
            'noto-sans' => '---  Noto Sans (+)',
            'oswald' => '---  Oswald (+)',
            'oxygen' => '---  Oxygen (+)',
            'pt-sans' => '---  PT Sans (+)',
            'pt-sans-narrow' => '---  PT Sans Narrow (+)',
            'raleway' => '---  Raleway (+)',
            'roboto' => esc_html__('Roboto', 'weaver-xtreme'),
            'roboto-condensed' => esc_html__('Roboto Condensed', 'weaver-xtreme'),
            'source-sans-pro' => esc_html__('Source Sans Pro', 'weaver-xtreme'),
            'titillium-web' => '---  Titillium Web (+)',
            'ubuntu' => '---  Ubuntu (+)',
            'yanone-kaffeesatz' => '---  Yanone Kaffeesatz',

            'serif-g' => esc_html__('--- -- Serif Google Fonts --', 'weaver-xtreme'),

            'alegreya' => esc_html__('Alegreya', 'weaver-xtreme'),
            'alegreya-sc' => esc_html__('Alegreya SC', 'weaver-xtreme'),
            'arvo' => esc_html__('Arvo Slab', 'weaver-xtreme'),
            'bitter' => '---  Bitter (+)',
            'droid-serif' => esc_html__('Droid Serif', 'weaver-xtreme'),
            'lora' => esc_html__('Lora', 'weaver-xtreme'),
            'merriweather' => '---  Merriweather (+)',
            'noto-serif' => '---  Noto Serif (+)',
            'playfair-display' => '---  Playfair Display (+)',
            'pt-serif' => '---  PT Serif (+)',
            'roboto-slab' => esc_html__('Roboto Slab', 'weaver-xtreme'),
            'rokkitt' => '---  Rokkitt (+)',
            'source-serif-pro' => esc_html__('Source Serif Pro', 'weaver-xtreme'),
            'tinos' => esc_html__('Tinos', 'weaver-xtreme'),
            'vollkorn' => esc_html__('Vollkorn', 'weaver-xtreme'),
            'ultra' => esc_html__('Ultra Black', 'weaver-xtreme'),

            'mono-g' => esc_html__('--- -- Monospace Google Fonts --', 'weaver-xtreme'),

            'droid-sans-mono' => '---  Droid Sans Mono (+)',
            'inconsolata' => esc_html__('Inconsolata', 'weaver-xtreme'),
            'nova-mono' => '---  Nova Mono (+)',
            'roboto-mono' => esc_html__('Roboto Mono', 'weaver-xtreme'),
            'ubuntu-mono' => '---  Ubuntu Mono (+)',

            'cursive-g' => esc_html__('--- -- "Cursive" Google Fonts --', 'weaver-xtreme'),

            'dancing-script' => '---  Dancing Script (+)',
            'handlee' => esc_html__('Handlee', 'weaver-xtreme'),
            'indie-flower' =>  esc_html__('---  Indie Flower', 'weaver-xtreme'),

            'blank-w' => esc_html__('--- ', 'weaver-xtreme'),
        );
    }

    $web = array(           // standard web fonts

        'web' => esc_html__('---* Web Fonts *', 'weaver-xtreme'),
        'web-not' => esc_html__('--- - - - NOT RECOMMENDED! - - -', 'weaver-xtreme'),
        'web-host' => esc_html__('--- - May not match on Android/iOS -', 'weaver-xtreme'),
        'sans-w' => esc_html__('--- -- Sans-Serif Web Fonts --', 'weaver-xtreme'),


        'sans-serif' => esc_html__('Arial', 'weaver-xtreme'),
        'arialBlack' => esc_html__('Arial Black', 'weaver-xtreme'),
        'arialNarrow' => esc_html__('Arial Narrow', 'weaver-xtreme'),
        'lucidaSans' => esc_html__('Lucida Sans', 'weaver-xtreme'),
        'trebuchetMS' => esc_html__('Trebuchet MS', 'weaver-xtreme'),
        'verdana' => esc_html__('Verdana', 'weaver-xtreme'),

        'serif-w' => esc_html__('--- -- Serif Web Fonts --', 'weaver-xtreme'),

        'serif' => esc_html__('Times', 'weaver-xtreme'),
        'cambria' => esc_html__('Cambria', 'weaver-xtreme'),
        'garamond' => esc_html__('Garamond', 'weaver-xtreme'),
        'georgia' => esc_html__('Georgia', 'weaver-xtreme'),
        'lucidaBright' => esc_html__('Lucida Bright', 'weaver-xtreme'),
        'palatino' => esc_html__('Palatino', 'weaver-xtreme'),

        'mono-w' => esc_html__('--- -- Monospace Web Fonts --', 'weaver-xtreme'),

        'monospace' => esc_html__('Courier', 'weaver-xtreme'),
        'consolas' => esc_html__('Consolas', 'weaver-xtreme'),

        'cursive-w' => esc_html__('--- -- "Cursive" Web Fonts --', 'weaver-xtreme'),

        'papyrus' => esc_html__('Papyrus', 'weaver-xtreme'),
        'comicSans' => esc_html__('Comic Sans MS', 'weaver-xtreme'),

    );

    $gfonts = weaverx_getopt_array('fonts_added');

    if (!empty($gfonts)) {
        foreach ($gfonts as $gfont => $val) {
            // $gfont has slug, $val has vals
            $base[$gfont] = $val['name'] . ' (' . WEAVERX_PLUS_ICON . 'font)';
        }
    }

    $base = array_merge($base, $google);

    $base = array_merge($base, $web);

    return $base;
}

function weaverx_cz_choices_font_family_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_font_family();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_bold_italic(): array
{
    return array(
        '' => esc_html__('Inherit', 'weaver-xtreme'),
        'on' => esc_html__('On', 'weaver-xtreme'),
        'off' => esc_html__('Off', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_bold_italic_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_bold_italic();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_sb_layout(): array
{
    return array(
        'right' => esc_html__('Sidebars on Right', 'weaver-xtreme'),
        'right-top' => esc_html__('Sidebars on Right (stack top)', 'weaver-xtreme'),
        'left' => esc_html__('Sidebars on Left', 'weaver-xtreme'),
        'left-top' => esc_html__('Sidebars on Left (stack top)', 'weaver-xtreme'),
        'split' => esc_html__('Split - Sidebars on Right and Left', 'weaver-xtreme'),
        'split-top' => esc_html__('Split (stack top)', 'weaver-xtreme'),
        'one-column' => esc_html__('No sidebars, content only', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_sb_layout_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_sb_layout();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_elementor_pages(): array
{
    $pargs = array(
        'post_type' => 'page',
    );
    $posts = get_pages($pargs);
    $post_list = array();
    $post_list[''] = esc_html__('None', 'weaver-xtreme');


    foreach ($posts as $post) {
        if (!!get_post_meta($post->ID, '_elementor_edit_mode', true)) {
            $post_list[$post->ID] = substr($post->post_title, 0, 60);
        }
    }

    $posts = get_posts(array(
        'post_type' => 'post',
    ));

    foreach ($posts as $post) {
        if (!!get_post_meta($post->ID, '_elementor_edit_mode', true)) {
            $post_list[$post->ID] = substr($post->post_title, 0, 60) . esc_html__(' (post)', 'weaver-xtreme');
        }
    }

    $posts = '';

    return $post_list;
}

function weaverx_cz_choices_elementor_pages_sanitize(string $val): string
{
    return $val;
}

function weaverx_cz_choices_siteorigin_pages(): array
{
    $pargs = array(
        'post_type' => 'page',
    );
    $posts = get_pages($pargs);
    $post_list = array();
    $post_list[''] = esc_html__('None', 'weaver-xtreme');

    foreach ($posts as $post) {
        if (!!get_post_meta($post->ID, 'panels_data', true)) {
            $post_list[$post->ID] = substr($post->post_title, 0, 60);
        }
    }
    $posts = '';

    return $post_list;
}

function weaverx_cz_choices_siteorigin_pages_sanitize(string $val): string
{
    return $val;
}

function weaverx_cz_choices_sb_layout_default(): array
{
    return array(
        'default' => esc_html__('Sidebars on Use Default', 'weaver-xtreme'),
        'right' => esc_html__('Sidebars on Right', 'weaver-xtreme'),
        'right-top' => esc_html__('Sidebars on Right (stack top)', 'weaver-xtreme'),
        'left' => esc_html__('Sidebars on Left', 'weaver-xtreme'),
        'left-top' => esc_html__('Sidebars on Left (stack top)', 'weaver-xtreme'),
        'split' => esc_html__('Split - Sidebars on Right and Left', 'weaver-xtreme'),
        'split-top' => esc_html__('Split (stack top)', 'weaver-xtreme'),
        'one-column' => esc_html__('No sidebars, content only', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_shadow(): array
{
    return array(
        "-0" => esc_html__('No Shadow', 'weaver-xtreme'),
        "-1" => esc_html__('All Sides, 1px', 'weaver-xtreme'),
        "-2" => esc_html__('All Sides, 2px', 'weaver-xtreme'),
        "-3" => esc_html__('All Sides, 3px', 'weaver-xtreme'),
        "-4" => esc_html__('All Sides, 4px', 'weaver-xtreme'),
        "-rb" => esc_html__('Right + Bottom', 'weaver-xtreme'),
        "-lb" => esc_html__('Left + Bottom', 'weaver-xtreme'),
        "-tr" => esc_html__('Top + Right', 'weaver-xtreme'),
        "-tl" => esc_html__('Top + Left', 'weaver-xtreme'),
        "-custom" => esc_html__('Custom Shadow', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_shadow_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_shadow();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_rounded(): array
{
    return array(
        "none" => esc_html__('None', 'weaver-xtreme'),
        "-all" => esc_html__('All Corners', 'weaver-xtreme'),
        "-left" => esc_html__('Left Corners', 'weaver-xtreme'),
        "-right" => esc_html__('Right Corners', 'weaver-xtreme'),
        "-top" => esc_html__('Top Corners', 'weaver-xtreme'),
        "-bottom" => esc_html__('Bottom Corners', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_rounded_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_rounded();

    return (isset($choices[$val])) ? $val : '';
}

function weaverx_cz_choices_tables(): array
{
    return array(
        'default' => esc_html__('Theme Default', 'weaver-xtreme'),
        'bold' => esc_html__('Bold Headings', 'weaver-xtreme'),
        'noborders' => esc_html__('No Border', 'weaver-xtreme'),
        'fullwidth' => esc_html__('Wide', 'weaver-xtreme'),
        'wide' => esc_html__('Wide 2', 'weaver-xtreme'),
        'plain' => esc_html__('Minimal', 'weaver-xtreme'),
    );
}

function weaverx_cz_choices_tables_sanitize(string $val): string
{
    $choices = weaverx_cz_choices_tables();

    return (isset($choices[$val])) ? $val : '';
}
