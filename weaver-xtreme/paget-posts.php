<?php
/** PHP 7.4 features added */
/** @noinspection PhpSwitchWithCommonPartsInspection */
/** @noinspection PhpIfWithCommonPartsInspection */
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * Template Name: Page With Posts
 * Description: A Page Template that will show posts - pretty much like index
 *
 * inject-infobar won't work right on the page-navi until we restart the loop, so...
 *
 * We create the breadcrumbs part for the page.
 * We buffer the output from the inject-premain up to the end of the page content
 * We create the page-navi part of the infobar after we restart the loop
 * Then output the infobar with the page breadcrumbs and the posts page-navi and the page buffer
 * Finally, start the new loop.
 */

$GLOBALS['weaverx_page_who'] = 'pwp';
get_header('pwp');

// build infobar front part - replace get_template_part('infobar'); with local code
// we need to build it in a buffer

weaverx_container_div('pwp');       // #container

ob_start();            // generate the stuff that comes AFTER the infobar for pwp since we can't generate page nav until later

$sb_layout = weaverx_sb_layout('blog');

// ********* get_template_part('templates/infobar');	// put the info bar

weaverx_sidebar_before($sb_layout, 'blog');          // sidebars if top-stacking
do_action('weaverx_per_page');

$paged = weaverx_get_page();

// and next the content area.

echo '<div id="content" role="main" ' . weaverx_content_class($sb_layout, 'pwp', false) . weaverx_schema('blog') . ">\n";
weaverx_inject_area('precontent');

weaverx_sb_precontent('blog');

$hide_bottom_sb = weaverx_is_checked_page_opt('_pp_sitewide-bottom-widget-area');    // gotta use the PwP page ID, not the last post's ID

weaverx_post_count_clear();
the_post();

if (!is_front_page()) {
    $GLOBALS['weaverx_pwp_title'] = get_the_title();    // Make breadcrumbs work a bit better
}

if ($paged == 1) {    // only show on the first page
    // If we have content for this page, let's display it.
    if (get_the_content() != '' ||
        (get_the_title() != '' && !weaverx_is_checked_page_opt('_pp_hide_page_title'))) {
        get_template_part('templates/content', 'page');
    } else {
        weaverx_edit_link();
    }
}
//weaverx_edit_link();
echo "\n<!-- PwP: End Page content -->\n";


$top_of_pwp = ob_get_clean();            // now get the top sidebar, etc.

if (post_password_required()) {
    get_template_part('templates/infobar');    // put the info bar now that the post's info is available
    echo $top_of_pwp;
    // every thing done, so allow comments?
    // comments_template( '', true );
    weaverx_sb_postcontent('blog');
    ?>
    </div><!-- #content -->
    <?php
    weaverx_sidebar_after($sb_layout, 'blog');
    ?>
    <div class="clear-container-end"
         style="clear:both"></div><</div></div><!-- /#container-end, #container -->
    <?php
    weaverx_get_footer('blog');

} else {        // show posts

    // Now, the posts
    global $wp_query;

    $args = array(
        'ignore_sticky_posts' => false,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
    );

    $filter = weaverx_get_per_page_value('_pp_post_filter');      // ATW Show Posts filter

    // Now, reset $wp_query to the new set of posts. After, use wp_reset_query() to reset.
    if (function_exists('atw_showposts_installed') && $filter != '') {
        /** @noinspection PhpUndefinedFunctionInspection */
        $params = atw_posts_get_filter_params($filter);
        if ($params != '') {        // they specified a $filter arg, so use it and wipe out anything else...
            $fargs = shortcode_parse_atts($params);
        } else {
            $fargs = '';
        }

        /** @noinspection PhpUndefinedFunctionInspection */
        $qargs = atw_posts_get_qargs($fargs, array());
        query_posts(apply_filters('weaverx_pwp_wp_query', $qargs));

    } else {
        $args = weaverx_setup_post_args($args);    // setup custom fields for this page
        query_posts(apply_filters('weaverx_pwp_wp_query', $args));
    }


    // now have to put the sidebar
    get_template_part('templates/infobar');    // put the info bar now that the post's info is available
    echo $top_of_pwp;


    if ($wp_query->have_posts()) {                // same loop as index.php
        global $weaverx_sticky;

        weaverx_content_nav('nav-above');
        $sticky_posts = false;

        // If you specify filters,
        // then the sticky post code is essentially ignored by WP, so we have to do this ourselves.
        // So - if there are sticky posts, we have to move them to the top of the posts list, and
        // manually add 'sticky' to the post's class. (1/11/12)

        if (!weaverx_is_checked_page_opt('_pp_hide_sticky')
            && (weaverx_get_per_page_value('_pp_category')
                || weaverx_get_per_page_value('_pp_tag')
                || weaverx_get_per_page_value('_pp_author')
            )) {    // move sticky posts when cat or tag filters?
            // Put sticky posts at the top of the posts array
            $sticky_posts = get_option('sticky_posts');
            global $page;
            if (is_array($sticky_posts) && !empty($sticky_posts)) {
                $num_posts = count($wp_query->posts);
                $sticky_offset = 0;
                // Loop over posts and relocate stickies to the front.
                for ($i = 0; $i < $num_posts; $i++) {
                    if (in_array($wp_query->posts[$i]->ID, $sticky_posts)) {
                        $sticky_post = $wp_query->posts[$i];
                        // Remove sticky from current position
                        array_splice($wp_query->posts, $i, 1);
                        // Move to front, after other stickies
                        array_splice($wp_query->posts, $sticky_offset, 0, array($sticky_post));
                        // Increment the sticky offset. The next sticky will be placed at this offset.
                        $sticky_offset++;
                    }
                }
            }
        }

        /* Start the Loop */
        $num_cols = weaverx_getopt('blog_cols'); // default
        $pp = weaverx_get_per_page_value('_pp_wvrx_pwp_cols');
        if ($pp) {
            $num_cols = $pp;
        }
        if (!$num_cols || $num_cols > 3) {
            $num_cols = 1;
        }

        $sticky_one = weaverx_getopt_checked('blog_sticky_one') && $paged <= 1;
        $first_one = weaverx_getopt_checked('blog_first_one') && $paged <= 1;
        $masonry_wrap = false;    // need this for one-column posts
        $col = 0;
        $hide_n_posts = weaverx_get_per_page_value('_pp_hide_n_posts');
        if ($hide_n_posts == '' || $hide_n_posts < 1 || $hide_n_posts > 100) {
            $hide_n_posts = 0;
        }

        weaverx_post_count_clear();
        echo("<div class=\"wvrx-posts\">\n");
        while ($wp_query->have_posts()) {
            $wp_query->the_post();

            weaverx_post_count_bump();

            if (weaverx_post_count() <= $hide_n_posts) {
                global $page, $paged;
                if (!($paged >= 2 || $page >= 2)) {
                    continue;
                }            // skip posting
            }

            $weaverx_sticky = false;

            if (is_array($sticky_posts) && !empty($sticky_posts) && in_array(get_the_ID(), $sticky_posts)) {
                $weaverx_sticky = true;
            }

            if ((is_sticky() || $weaverx_sticky) && $sticky_one) {
                get_template_part('templates/content', get_post_format());
            } elseif ($first_one) {
                get_template_part('templates/content', get_post_format());
                $first_one = false;
            } else {
                if (!$masonry_wrap) {
                    $masonry_wrap = true;
                    if (weaverx_masonry('begin-posts')) {
                        $num_cols = 1;
                    }        // force to 1 cols
                }
                weaverx_masonry('begin-post');    // wrap each post
                switch ($num_cols) {
                    case 1:
                        get_template_part('templates/content', get_post_format());
                        $sticky_one = false;
                        break;
                    case 2:
                        $col++;
                        echo('<div class="content-2-col">' . "\n");
                        get_template_part('templates/content', get_post_format());
                        echo("</div> <!-- content-2-col -->\n");

                        $sticky_one = false;
                        break;
                    case 3:
                        $col++;
                        echo('<div class="content-3-col">' . "\n");
                        get_template_part('templates/content', get_post_format());
                        echo("</div> <!-- content-3-col -->\n");

                        $sticky_one = false;
                        break;
                    default:
                        get_template_part('templates/content', get_post_format());
                        $sticky_one = false;
                }    // end switch $num_cols
                weaverx_masonry('end-post');
            }
        }    // end while have posts
        weaverx_masonry('end-posts');
        echo("</div>\n");


        weaverx_content_nav('nav-below');
    } else {
        weaverx_not_found_search();
    }
    // every thing done, so allow comments?
    // comments_template( '', true );

    weaverx_sb_postcontent('blog', $hide_bottom_sb);
    ?>

    </div><!-- #content -->

    <?php

    wp_reset_query();
    //wp_reset_postdata();  // included in wp_reset_query()  // need these so extra-menus work in rightsidebar and footer

    weaverx_sidebar_after($sb_layout, 'blog');
    ?>
    <div class="clear-container-end"
         style="clear:both"></div></div></div><!-- /#container-end, #container -->
    <?php
    weaverx_get_footer('blog');
} // end of show posts section

