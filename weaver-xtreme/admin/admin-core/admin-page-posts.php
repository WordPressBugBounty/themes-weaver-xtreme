<?php
/** PHP 7.4 features added */

/**
 * Display per page and per post options.
 *
 * @since 12/10/14
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
// Admin panel that gets added to the page edit page for per page options


add_action('admin_menu', 'weaverx_pp_add_page_fields', 11);    // allow X-Plus to override us
/**
 * Add per page and per post meta_boxes
 *
 */
function weaverx_pp_add_page_fields(): void
{

    $per_post_label = defined('WEAVER_XPLUS_VERSION') ? esc_html__(' (with Weaver Xtreme Plus Options)', 'weaver-xtreme') : '';
    add_meta_box('page-box', esc_html__('Weaver Xtreme Options For This Page', 'weaver-xtreme') . $per_post_label,
        'weaverx_pp_page_extras_load', 'page', 'normal', 'high');

    add_meta_box('post-box', esc_html__('Weaver Xtreme Options For This Post', 'weaver-xtreme') . $per_post_label, 'weaverx_pp_post_extras_load', 'post', 'normal', 'high');

    $i = 1;
    $args = array('public' => true, '_builtin' => false);
    $post_types = get_post_types($args, 'names', 'and');
    foreach ($post_types as $post_type) {
        add_meta_box('post-box' . $i, esc_html__('Weaver Xtreme Options For This Post Type', 'weaver-xtreme') . $per_post_label,
            'weaverx_pp_post_extras_pt', $post_type, 'normal', 'high');
        $i++;
    }

    require_once(get_theme_file_path('/admin/admin-core/admin-page-posts-meta-boxes.php'));    // per page-posts admin - needs to be here
}

function weaverx_pp_page_extras_load(): void
{
    weaverx_pp_page_extras();
}

function weaverx_pp_post_extras_load(): void
{
    weaverx_pp_post_extras();
}

function weaverx_pp_post_extras_pt(): void
{
    // special handling for non-Weaver Custom Post Types
    $opts = weaverx_get_db_options();
    if ((isset($opts['_show_per_post_all']) && $opts['_show_per_post_all']) || function_exists('atw_slider_plugins_loaded')) {
        weaverx_pp_post_extras();
    } else {
        echo '<p>' . esc_html__('You can enable Weaver Xtreme Per Post Options for Custom Post Types on the Weaver Xtreme:Advanced Options:Admin Options tab.', 'weaver-xtreme') .
            '</p>';
    }
}

add_action('admin_enqueue_scripts', 'weaverx_pp_enqueue_admin_scripts');

function weaverx_pp_enqueue_admin_scripts($hook): void
{
    //weaverx_alert(' enqueue hook: ' . $hook);

    if ($hook != 'appearance_page_weaverxplus' && $hook != 'post.php' && $hook != 'post-new.php') {     // only load script if on my admin page or page/post editor
        return;
    }

    wp_enqueue_script('weaverxYetii', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/admin-core/assets/js/yetii/yetii.js'), false, WEAVERX_VERSION);
    wp_enqueue_style('weaverxYetiiCSS', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/admin-core/assets/js/yetii/yetii-weaver' . WEAVERX_MINIFY . '.css'), false, WEAVERX_VERSION);
}

