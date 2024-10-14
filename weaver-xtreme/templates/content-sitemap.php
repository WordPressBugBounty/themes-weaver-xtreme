<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */

weaverx_per_post_style();
weaverx_fi('page', 'post-pre');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
    <?php weaverx_page_title(); ?>

    <div class="entry-content clearfix">

        <?php weaverx_the_page_content('page');

        // sitemap specific code
        echo("<div id=\"weaver-sitemap\">\n");
        echo("<div id='sitemap-pages'><h3>" . wp_kses_post(__('Pages', 'weaver-xtreme')) . "</h3><ul class='xoxo sitemap-pages'>\n");
        $args = array('title_li' => false);
        if (weaverx_getopt('_sitemap_exclude_pages') != '') {
            $args['exclude'] = str_replace(' ', '', weaverx_getopt('_sitemap_exclude_pages'));
        }
        wp_list_pages($args);
        echo("</ul></div>\n");

        echo("<div id='sitemap-posts'><br /><h3>" . wp_kses_post(__('Posts', 'weaver-xtreme')) . "</h3><ul class='xoxo sitemap-pages-month'>\n");
        wp_get_archives(array('type' => 'monthly', 'show_post_count' => true));
        echo("</ul></div>\n");

        if (!weaverx_getopt('post_hide_categories')) {
            echo("<div id='sitemap-categories'><br /><h3>" . wp_kses_post(__('Categories', 'weaver-xtreme')) . "</h3><ul class='xoxo sitemap-categories'>\n");
            wp_list_categories(array('show_count' => true, 'use_desc_for_title' => true, 'title_li' => false));
            echo("</ul></div>\n");
        }


        if (!weaverx_getopt('post_hide_tags')) {

            echo("<div id='sitemap-tags'><br /><h3>" . wp_kses_post(__('Tag Cloud', 'weaver-xtreme')) . "</h3><ul class='xoxo sitemap-tag'>\n");
            wp_tag_cloud(array('number' => 0));
            echo("</ul></div>\n");
        }

        if (!weaverx_getopt('post_hide_author')) {
            echo("<div id='sitemap-authors'><br /><h3>" . wp_kses_post(__('Authors', 'weaver-xtreme')) . "</h3><ul class='xoxo sitemap-authors'>\n");
            wp_list_authors(array('exclude_admin' => false, 'optioncount' => true, 'title_li' => false));
            echo("</ul></div>\n");
        }

        echo("</div><!-- weaver-sitemap -->\n");

        ?>
    </div><!-- .entry-content -->
    <footer class="entry-utility-page">
        <?php
        weaverx_edit_link();
        ?>
    </footer><!-- .entry-utility-page -->
    <?php echo weaverx_schema('mainEntityOfPage'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
