<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Right Sidebar.
 */

$l_area = 'l-sb-right';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-lm';
}

$p_class = $l_area . ' m-full s-full ' . weaverx_area_class('primary', 'pad', '', 'margin-bottom');
$s_class = $l_area . ' m-full s-full sb-float-right ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');


if (weaverx_has_widgetarea('primary-widget-area')) {

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // both top and bottom
        $p_class = 'm-half-rm ' . $p_class;
        $s_class = 'm-half-lm ' . $s_class;

        weaverx_put_widgetarea('primary-widget-area', $p_class);    // show default primary widget area ( upper )
        weaverx_put_widgetarea('secondary-widget-area', $s_class);
        weaverx_clear_both('secondary-widget-area');

    } else { // top only
        $p_class = 'm-full s-full ' . $p_class;
        weaverx_put_widgetarea('primary-widget-area', $p_class);
    }

} else {

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // bottom only
        $s_class = 'm-full s-full ' . $s_class;
        weaverx_put_widgetarea('secondary-widget-area', $s_class);
        weaverx_clear_both('secondary-widget-area');

    } else {
        weaverx_no_sidebars($l_area . ' m-full s-full margin-bottom pad');
    }
}
