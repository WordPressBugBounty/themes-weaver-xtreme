<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 *  Category page template
 */
/*! ** DO NOT EDIT THIS FILE! It will be overwritten when the theme is updated! ** */

weaverx_set_cur_page_id(0);    // no page for this type

$sb_layout = weaverx_page_lead('category');

// and next the content area.
weaverx_sb_precontent('category');

if (have_posts()) {
    // translators: %s category title
    $msg = apply_filters('weaverx_category_archives', esc_html__('Category Archives: %s', 'weaver-xtreme'));
    $titlew = '<span class="category-title-label">' .
        sprintf($msg, '</span><span class="archive-info">' . single_cat_title('', false) . '</span>');
    ?>

    <header class="page-header">
        <?php
        weaverx_archive_title($titlew, 'category');
        $category_description = wp_kses_post(category_description());
        $cat_d = apply_filters('category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>');
        if (!empty($category_description)) {
            weaverx_echo_sanitized_html($cat_d);
        }
        ?>
    </header>

    <?php
    weaverx_content_nav('nav-above');

    /* The Loop */
    weaverx_archive_loop('category');

    weaverx_content_nav('nav-below');

} else {
    weaverx_not_found_search();
}

weaverx_sb_postcontent('category');

weaverx_page_tail('category', $sb_layout);    // end of page wrap

