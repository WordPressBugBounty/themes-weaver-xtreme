<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * Template Name: For Your Page Builder Plugin
 *
 */

$post_idw = get_the_ID();

$sb_layout = weaverx_page_lead('page-builder');

// and next the content area.

weaverx_sb_precontent('page-builder');

// Page Builders detection
// $is_elementor = ! ! get_post_meta( $post_id, '_elementor_edit_mode', true );
// $is_siteorigin = ! ! get_post_meta( $post_id, 'panels_data', true );

$is_elementor = !!get_post_meta($post_idw, '_elementor_edit_mode', true);
if ($is_elementor) {
    do_action('elementor/page_templates/canvas/before_content');
}

while (have_posts()) :
    the_post();
    get_template_part('templates/content', 'builder');    // treat these like pages
    //the_content();
endwhile;

if ($is_elementor) {
    do_action('elementor/page_templates/canvas/after_content');
}

weaverx_sb_postcontent('page-builder');

weaverx_page_tail('page-builder', $sb_layout);    // end of page wrap
