<?php
/** @noinspection ALL */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 *  Link
 */

weaverx_per_post_style();

?>
<article
        id="post-<?php the_ID(); ?>" <?php post_class('content-link post-content post-format ' . weaverx_post_class());
echo weaverx_schema('post'); ?>>
    <?php
    if (!weaverx_compact_post()) {
        ?>
        <header class="entry-header">
            <?php weaverx_entry_header('link'); ?>
        </header><!-- .entry-header -->

        <?php
        if (weaverx_show_only_title()) {
            return;
        }
    }
    if (weaverx_use_excerpt() && !weaverx_compact_post()) { // Only display Excerpts for Search
        weaverx_post_div('summary');
        weaverx_the_post_excerpt(); ?>
        <br/>
        </div><!-- .entry-summary -->
    <?php } else {
        weaverx_post_div('content');
        weaverx_the_post_full();
        weaverx_link_pages();    // <!--nextpage-->
        ?>
        </div><!-- .entry-content -->
    <?php }
    if (!weaverx_compact_post()) {
        weaverx_format_posted_on_footer();
        weaverx_compact_link('check');
    } else {
        weaverx_compact_link();
        weaverx_edit_link();
    }
    ?>


    <?php weaverx_inject_area('postpostcontent');    // inject post comment body ?>
    <div style="clear:both;"></div>
    <?php echo weaverx_schema('mainEntityOfPage'); ?>
</article><!-- /#post-<?php the_ID(); ?> -->
