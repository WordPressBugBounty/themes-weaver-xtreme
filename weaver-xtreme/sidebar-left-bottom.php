<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Right Split Sidebar.
 */
echo '<div style="clear:left;"></div>';
$l_area = 'l-sb-left';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-rm';
}
$class = $l_area . ' m-full s-full ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');
weaverx_put_widgetarea('secondary-widget-area', $class);    // Lower Widget Area

