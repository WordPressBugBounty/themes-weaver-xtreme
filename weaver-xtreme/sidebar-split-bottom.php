<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Right Split Sidebar.
 *
 */
// Bottom Widget Area

$l_area = 'l-sb-right-split';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-lm';
}

$class = $l_area . ' m-full s-full sb-float-right ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');

weaverx_put_widgetarea('secondary-widget-area', $class);
weaverx_clear_both('secondary-widget-area');

