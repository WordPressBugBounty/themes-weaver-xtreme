<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * The default template for displaying content
 *
 * This will display unmatched post-type blog posts from main blog page and archive-type pages
 * Note - if you are building a custom content-xxx.php page for a custom post type, you should
 * be sure that Feature Images are processed correctly via weaverx_the_post_full().
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */

weaverx_per_post_style();
$do_excerpt = weaverx_use_excerpt();

$me = ($do_excerpt) ? 'post_excerpt' : 'post_full';

weaverx_fi($me, 'post-pre');

// ------------------------------------------------- COMPACT POSTS ---------------------------------------

if (weaverx_is_checked_page_opt('_pp_pwp_compact_posts')
    && ($the_image = weaverx_get_first_post_image()) != '') {  // = Compact Posts
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('post-content content-default content-compact-post ' . weaverx_post_class());
    echo weaverx_schema('post'); ?>>

    <header class="entry-header">
        <?php weaverx_entry_header(''); // compact header ?>
    </header><!-- .entry-header -->
    <div class="entry-compact"> <!-- Compact Post -->
        <a href="<?php echo esc_url(get_permalink()); ?>"
           title="<?php esc_attr(printf(__('Permalink to %s', 'weaver-xtreme'),
               the_title_attribute('echo=0'))); ?>" rel="bookmark">
            <?php echo $the_image; ?>
        </a>
    </div><!-- .entry-compact -->

    <?php
} else {
// -------------------------------------------------- REGULAR POSTS ---------------------------------------
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('content-default ' . weaverx_post_class());
    echo weaverx_schema('post'); ?>><!-- POST: standard -->
    <header class="entry-header">
        <?php
        weaverx_entry_header('', $do_excerpt);

        weaverx_post_top_meta('');

        ?>
    </header><!-- .entry-header -->

    <?php

    if (weaverx_show_only_title()) {        // -------------------- TITLE ONLY? --------------------
        return;
    }

    if ($do_excerpt) {                    // -------------------- EXCERPT ------------------------
        weaverx_post_div('summary');
        weaverx_the_post_excerpt();
        ?>
        </div><!-- .entry-summary -->
        <?php
    } else {                                // ------------------ FULL POST ------------------------
        weaverx_post_div('content');
        weaverx_the_post_full();
        weaverx_link_pages();    // <!--nextpage-->
        ?>
        </div><!-- .entry-content -->
        <?php
    } ?>

    <footer class="entry-utility"><!-- bottom meta -->
        <?php
        weaverx_post_bottom_info();
        weaverx_compact_link('check');
        ?>
    </footer><!-- #entry-utility -->
    <?php
    weaverx_inject_area('postpostcontent');    // inject post comment body
}
?>
    <div class="clear-post-end" style="clear:both;"></div>
<?php echo weaverx_schema('mainEntityOfPage'); ?>
    </article><!-- /#post-<?php the_ID(); ?> -->

<?php
// need the trailing clear:both instead of clearfix on the article to make outside FIs work right

