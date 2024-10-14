<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */

weaverx_per_post_style();

if (weaverx_compact_post()) {
?>
<article
        id="post-<?php the_ID(); ?>" <?php post_class('post-content format-image-compact ' . weaverx_post_class()); ?>>
    <?php
    $use_link = true;
    $content = do_shortcode(apply_filters('the_content', get_the_content('')));    // pick up wp 3.6 post format meta image
    $the_image = weaverx_get_first_post_image($content);
    if ($the_image == '') {
        $the_image = $content;
        $use_link = false;
    }
    ?>
    <div class="entry-content clearfix">
        <?php
        if ($use_link) {
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>"
               title="<?php the_title_attribute('echo=1'); ?>"
               rel="bookmark"><?php echo $the_image; ?></a>
            <?php
        } else {
            echo $the_image;
        }
        weaverx_compact_link('check');
        weaverx_edit_link();
        ?>
    </div><!-- .entry-content -->
    <?php
    } else {    // Regular Image Layout
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('content-image ' . weaverx_post_class());
    echo weaverx_schema('post'); ?>>
        <header class="page-header">
            <?php weaverx_entry_header('image'); ?>
        </header><!-- .page-header -->

        <?php
        if (weaverx_show_only_title()) {
            return;
        }
        weaverx_post_div('content');
        weaverx_the_post_full();
        weaverx_link_pages();    // <!--nextpage-->
        ?>
        </div><!-- .entry-content -->
        <?php
        if (!weaverx_is_checked_post_opt('_pp_hide_top_post_meta')
            && !weaverx_is_checked_post_opt('_pp_hide_bottom_post_meta')
            && !weaverx_is_checked_page_opt('_pp_hide_infotop')
            && !weaverx_is_checked_page_opt('_pp_hide_infobottom')) {
            ?>
            <footer class="entry-utility-wrap">
                <div class="entry-utility<?php echo weaverx_text_class('post_info_bottom'); ?>">
                    <?php
                    echo wp_kses_post(sprintf(__('<a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s" rel="author">%6$s</a></span></span>', 'weaver-xtreme'),
                        esc_url(get_permalink()),
                        get_the_date('c'),
                        get_the_date(),
                        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                        esc_attr(sprintf(__('View all posts by %s', 'weaver-xtreme'), get_the_author())),
                        weaverx_get_the_author()
                    ));

                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list(esc_html__(', ', 'weaver-xtreme'));
                    if ($categories_list):
                        ?>
                        <span class="cat-links">
					<?php printf(wp_kses_post(__('<span class="%1$s">Posted in</span> %2$s', 'weaver-xtreme')), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list); ?>
				</span>
                    <?php endif; // End if categories ?>
                    <?php
                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list('', esc_html__(', ', 'weaver-xtreme'));
                    if ($tags_list): ?>
                        <span class="tag-links">
					<?php printf(wp_kses_post(__('<span class="%1$s">Tagged</span> %2$s', 'weaver-xtreme')), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
				</span>
                    <?php endif; // End if $tags_list ?>

                    <?php if (comments_open()) : ?>
                        <span class="comments-link"><?php comments_popup_link('<span class="leave-reply">' . esc_html__('Reply', 'weaver-xtreme') . '</span>', wp_kses_post(__('<strong>1</strong> Reply', 'weaver-xtreme')), wp_kses_post(__('<strong>%</strong> Replies', 'weaver-xtreme'))); ?></span>
                    <?php endif; // End if comments_open() ?>
                </div><!-- .entry-utility -->

                <?php weaverx_compact_link('check');
                weaverx_edit_link(); ?>
            </footer><!-- #entry-utility -->
            <?php
        } else {
            weaverx_compact_link('check');
            weaverx_edit_link();
        }
        ?>
        <?php
        }
        weaverx_inject_area('postpostcontent');    // inject post comment body
        ?>
        <div style="clear:both;"></div>
        <?php echo weaverx_schema('mainEntityOfPage'); ?>
    </article><!-- /#post-<?php the_ID(); ?> -->
