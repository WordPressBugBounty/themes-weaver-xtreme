<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Right Split Sidebar.
 */

$l_area = 'l-sb-right';
if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-lm';
}

$class = $l_area . ' m-full s-full l-flow-opposite ' . weaverx_area_class('primary', 'pad', '', 'margin-bottom');

if (weaverx_has_widgetarea('primary-widget-area')) {
    weaverx_put_widgetarea('primary-widget-area', $class);
} elseif (!weaverx_has_widgetarea('secondary-widget-area')) {
    weaverx_no_sidebars($class);
}
