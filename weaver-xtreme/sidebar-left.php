<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The Left Sidebar.
 */
$l_area = 'l-sb-left';

if (weaverx_getopt('primary_smartmargin') || weaverx_getopt('secondary_smartmargin')) {
    $l_area .= '-rm';
}

$wrap = '<div class="' . $l_area . ' s-full m-full">';

$p_class = 'l-full m-half-rm ' . weaverx_area_class('primary', 'pad', '', 'margin-bottom');
$s_class = 'l-full m-half-lm ' . weaverx_area_class('secondary', 'pad', '', 'margin-bottom');

if (weaverx_has_widgetarea('primary-widget-area')) {

    weaverx_echo_sanitized_html($wrap);       // keep the two areas vertical no matter what the content height

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // both top and bottom
        weaverx_put_widgetarea('primary-widget-area', $p_class);
        weaverx_put_widgetarea('secondary-widget-area', $s_class);
    } else {                                                // top only
        $p_class = str_replace('m-half-rm', 'm-full', $p_class);
        weaverx_inject_area('presidebar', $p_class);
        weaverx_put_widgetarea('primary-widget-area', $p_class);
    }
} else {

    if (weaverx_has_widgetarea('secondary-widget-area')) {  // bottom only
        $s_class = str_replace('m-half-lm', 'm-full', $s_class);
        weaverx_echo_sanitized_html($wrap);
        weaverx_put_widgetarea('secondary-widget-area', $s_class);
    } else {
        weaverx_echo_sanitized_html($wrap);
        weaverx_no_sidebars($p_class);
    }
}
echo '</div>';

