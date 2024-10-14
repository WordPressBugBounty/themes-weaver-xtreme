<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Right Split Sidebar.
 *
 */

$l_area_left = 'l-sb-left-split';
$l_area_right = 'l-sb-right-split';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area_left .= '-rm';
    $l_area_right .= '-lm';
}

$p_class = $l_area_left . ' m-half-rm s-full ' . weaverx_area_class('primary', 'pad', '', 'margin-bottom');

$s_class = $l_area_right . ' m-half-lm s-full ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');

if (weaverx_has_widgetarea('primary-widget-area')) {

    weaverx_put_widgetarea('primary-widget-area', $p_class);

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // both top and bottom
        // show default top
        weaverx_put_widgetarea('secondary-widget-area', $s_class);
        weaverx_clear_both('secondary-widget-area');
    } else {                                                // top only
        weaverx_clear_both('primary-widget-area');
    }

} else {

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // bottom only

        $s_class = $l_area_right . ' m-full s-full sb-float-right ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');
        weaverx_put_widgetarea('secondary-widget-area', $s_class);

    } else {
        weaverx_no_sidebars($p_class);
    }
    weaverx_clear_both('secondary-widget-area');
}

