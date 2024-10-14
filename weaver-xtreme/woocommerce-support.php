<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 *    Action: Support for Woo Commerce
 *
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'weaverx_woo_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'weaverx_woo_wrapper_end', 10);

function weaverx_woo_wrapper_start()
{
    echo '<div id="container" class="container"><div id="content" class="weaver-woo" role="main">';
}


function weaverx_woo_wrapper_end()
{
    echo '</div></div> <!-- end weaver-woo -->';
}

add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

