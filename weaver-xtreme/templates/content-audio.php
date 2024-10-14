<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template for displaying posts in the Audio Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */
weaverx_per_post_style();
?>
<article
        id="post-<?php the_ID(); ?>" <?php post_class('post-content content-audio ' . weaverx_post_class());
echo weaverx_schema('post'); ?>>
    <?php
    if (!weaverx_compact_post()) {
        ?>
        <header class="entry-header">
            <?php weaverx_entry_header('audio'); ?>
        </header><!-- .entry-header -->

        <?php
        if (weaverx_show_only_title()) {
            return;
        }
    }

    weaverx_post_div('content');
    weaverx_the_post_full();

    weaverx_link_pages();    // <!--nextpage-->
    ?>
    </div><!-- .entry-content -->
    <?php
    if (!weaverx_compact_post()
        && !weaverx_is_checked_post_opt('hide_bottom_post_meta')
        && !weaverx_is_checked_page_opt('ttw_hide__pp_infobot')) {
        ?>
        <footer class="entry-utility<?php echo weaverx_text_class('post_info_bottom'); ?>">

            <?php
            echo wp_kses_post(sprintf(__('<a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s" rel="author">%6$s</a></span></span>', 'weaver-xtreme'),
                esc_url(get_permalink()),
                esc_attr(get_the_date('c')),
                esc_attr(get_the_date()),
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                esc_attr(sprintf(__('View all posts by %s', 'weaver-xtreme'), get_the_author())),
                weaverx_get_the_author()
            ));
            ?>

            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'weaver-xtreme'));
            if ($categories_list):
                ?>
                <span class="cat-links">
					<?php
                    $pi = sprintf(__('<span class="%1$s">Posted in</span> %2$s', 'weaver-xtreme'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list);
                    echo wp_kses_post($pi);
                    ?>
				</span>
            <?php endif; // End if categories ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'weaver-xtreme'));
            if ($tags_list): ?>
                <span class="tag-links">
					<?php
                    $ti = sprintf(__('<span class="%1$s">Tagged</span> %2$s', 'weaver-xtreme'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                    echo wp_kses_post($ti);
                    ?>
				</span>
            <?php endif; // End if $tags_list ?>

            <?php if (comments_open()) : ?>
                <span class="comments-link"><?php
                    comments_popup_link('<span class="leave-reply">' . esc_html__('Reply', 'weaver-xtreme') . '</span>', wp_kses_post(__('<strong>1</strong> Reply', 'weaver-xtreme')), wp_kses_post(__('<strong>%</strong> Replies', 'weaver-xtreme'))); ?></span>
            <?php endif; // End if comments_open() ?>

            <?php
            weaverx_compact_link('check');
            weaverx_edit_link();
            ?>
        </footer><!-- #entry-utility -->

        <?php
    } else {
        weaverx_compact_link();
        weaverx_edit_link();
    }
    weaverx_inject_area('postpostcontent');    // inject post comment body ?>
    <div style="clear:both;"></div>
    <?php echo weaverx_schema('mainEntityOfPage'); ?>
</article><!-- /#post-<?php the_ID(); ?> -->
