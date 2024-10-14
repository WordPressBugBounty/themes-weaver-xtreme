<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The default template for displaying content
 *
 * Displays content from page builder - just the content...
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('content-page-builder'); ?>>
    <?php
    echo weaverx_schema('mainEntityOfPage');
    //weaverx_the_page_content( 'page' );
    the_content();

    ?>
</div><!-- #post-<?php the_ID(); ?> -->
<?php weaverx_edit_link(); ?>
