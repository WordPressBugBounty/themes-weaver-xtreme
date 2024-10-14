<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */

weaverx_per_post_style();

weaverx_fi('post', 'post-pre');
?>
    <article
            id="post-<?php the_ID(); ?>" <?php post_class('content-single post-content ' . weaverx_post_class(true));
    echo weaverx_schema('post'); ?>>
        <?php weaverx_single_title('');
        weaverx_post_div('content');
        weaverx_the_post_full_single();
        weaverx_link_pages();    // <!--nextpage-->
        ?>
        </div><!-- .entry-content -->

        <footer class="entry-utility entry-author-info">
            <?php
            weaverx_post_bottom_info('single');
            weaverx_author_info();
            ?>

        </footer><!-- .entry-utility -->
        <?php weaverx_inject_area('postpostcontent');    // inject post comment body ?>
        <?php echo weaverx_schema('mainEntityOfPage'); ?>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php weaverx_inject_area('pagecontentbottom');
