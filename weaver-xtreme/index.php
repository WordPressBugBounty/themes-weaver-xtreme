<?php
/** PHP 7.4 features added */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The default template file for blogs.
 *
 */
/*! ** DO NOT EDIT THIS FILE! It will be overwritten when the theme is updated! ** */

$sb_layout = weaverx_page_lead('blog');    // blog is archive for layout purposes

weaverx_set_cur_page_id(0);    // no page for this type

weaverx_sb_precontent('blog');  // and next the content area.

if (have_posts()) {

    $pagedw = weaverx_get_page();

    weaverx_content_nav('nav-above');

    $num_cols = weaverx_getopt('blog_cols');
    if (!$num_cols || $num_cols > 3) {
        $num_cols = 1;
    }

    $sticky_one = weaverx_getopt_checked('blog_sticky_one') && $pagedw <= 1;
    $first_one = weaverx_getopt_checked('blog_first_one') && $pagedw <= 1;
    $masonry_wrap = false;    // need this for one-column posts
    $col = 0;

    /* Start the Loop */

    weaverx_post_count_clear();

    echo("<div class=\"wvrx-posts\">\n");        // needed here, and all post loops to make content-n-col work with :nth-of-type

    while (have_posts()) {
        the_post();
        weaverx_post_count_bump();

        if (is_sticky() && $sticky_one) {
            get_template_part('templates/content', get_post_format());
        } elseif ($first_one) {
            get_template_part('templates/content', get_post_format());
            $first_one = false;
        } else {
            if (!$masonry_wrap) {
                $masonry_wrap = true;
                if (weaverx_masonry('begin-posts'))    // wrap all posts
                {
                    $num_cols = 1;
                }        // force to 1 cols
            }
            weaverx_masonry('begin-post');    // wrap each post
            switch ($num_cols) {
                case 1:
                    get_template_part('templates/content', get_post_format());
                    break;

                case 2:
                    $col++;
                    echo('<div class="content-2-col">' . "\n");
                    get_template_part('templates/content', get_post_format());
                    echo("</div> <!-- content-2-col -->\n");

                    break;

                case 3:
                    $col++;
                    echo('<div class="content-3-col">' . "\n");
                    get_template_part('templates/content', get_post_format());
                    echo("</div> <!-- content-3-col -->\n");

                    break;

                default:
                    get_template_part('templates/content', get_post_format());
            }
            $sticky_one = false;   // end switch num cols
            weaverx_masonry('end-post');
        } /* end first one col */

    }    // end while have posts
    weaverx_masonry('end-posts');
    echo("</div>\n");

    weaverx_content_nav('nav-below');
} else {
    weaverx_not_found_search();
}

weaverx_sb_postcontent('blog');

weaverx_page_tail('blog', $sb_layout);    // end of page wrap
