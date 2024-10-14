<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * Weaver Xtreme does not use this itself, but this is provided for reasonable compatibility with some plugins.
 *
 * Default sidebar area used by some plugins - will default to right sidebar widget areas
 */
get_sidebar('right');
