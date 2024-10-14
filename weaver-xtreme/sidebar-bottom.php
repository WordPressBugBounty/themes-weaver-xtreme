<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Bottom Sidebar

// Bottom Widget Area
$l_area = 'l-sb-right';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-lm';
}
$class = $l_area . ' m-full s-full sb-float-right ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');

echo '<div style="clear:right;"></div>';
weaverx_put_widgetarea('secondary-widget-area', $class);
weaverx_clear_both('secondary-widget-area');
