<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * The template for displaying posts in the Status Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Weaver X
 */

weaverx_per_post_style();
?>
<article
        id="post-<?php the_ID(); ?>" <?php post_class('post-content content-status post-format ' . weaverx_post_class());
echo weaverx_schema('post'); ?>>
    <?php
    if (!weaverx_compact_post()) {
        ?>
        <header class="entry-header">
            <?php weaverx_entry_header('status');
            if (comments_open() && !post_password_required()) { ?>
                <div class="comments-link">
                    <?php weaverx_comments_popup_link(); ?>
                </div>
            <?php } ?>
        </header><!-- .entry-header -->

        <?php
        if (weaverx_show_only_title()) {
            return;
        }
    }
    if (weaverx_use_excerpt() && !weaverx_compact_post()) { // Only display Excerpts for Search
        weaverx_post_div('summary');  // <div> start
        weaverx_the_post_excerpt(); ?>
        <br/>
        </div><!-- .entry-summary -->
    <?php } else {
        weaverx_post_div('content');
        ?>
        <span class="post-avatar-status">
<?php echo(get_avatar(get_the_author_meta('user_email'), 32, null, 'avatar')); ?>
			</span><span class="weaver-ml-50">
<?php weaverx_the_post_full(); ?>
			</span>
        <?php
        weaverx_link_pages();    // <!--nextpage-->
        ?>
        </div><!-- .entry-content -->
        <?php
    }
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
