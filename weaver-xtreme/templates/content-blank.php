<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The default template for displaying content
 *
 * Displays content from blank page template - just the content...
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('content-blank'); ?>>
    <?php
    echo weaverx_schema('mainEntityOfPage');
    weaverx_the_page_content('page');
    weaverx_link_pages();    // <!--nextpage-->

    ?>
</div><!-- #post-<?php the_ID(); ?> -->
<?php edit_post_link(esc_html__('Edit', 'weaver-xtreme'), '<span class="edit-link">', '</span>'); ?>
