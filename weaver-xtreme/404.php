<?php
/** PHP 7.4 features added */
/**
 *  404 page output template.
 *
 * @package weaverx
 */

/*! ** DO NOT EDIT THIS FILE! It will be overwritten when the theme is updated! ** */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


weaverx_set_cur_page_id(0);    // no page for this type

$sb_layout = weaverx_page_lead('404');

weaverx_sb_precontent('404');

// and next the content area.
?>
    <article id="post-0" class="post error404 not-found">
        <?php
        $msg = apply_filters('weaverx_404_title', esc_html__('Sorry, no such page.', 'weaver-xtreme'));
        weaverx_page_title($msg);

        if (!weaverx_getopt('_hide_not_found_search')) {
            ?>
            <div class="entry-content clearfix">
                <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'weaver-xtreme'); ?>
                </p>
                <?php
                get_search_form();
                echo "<p></p>\n";
                the_widget(
                    'WP_Widget_Recent_Posts',
                    array(
                        'number' => 10,
                    ),
                    array(
                        'widget_id' => '404',
                    )
                );
                ?>
                <div class="widget">
                    <h2 class="widgettitle"><?php esc_html_e('Most Used Categories', 'weaver-xtreme'); ?></h2>
                    <ul>
                        <?php
                        wp_list_categories(
                            array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'show_count' => 1,
                                'title_li' => '',
                                'number' => 10,
                            )
                        );
                        ?>
                    </ul>
                </div>

                <?php
                /* translators: %1$s: smiley */
                $archive_content = '<p>' . esc_html(sprintf(__('Try looking in the monthly archives. %1$s', 'weaver-xtreme'), convert_smilies(':)'))) . '</p>';
                the_widget(
                    'WP_Widget_Archives',
                    array(
                        'count' => 0,
                        'dropdown' => 1,
                    ),
                    array(
                        'after_title' => '</h2>' . $archive_content,
                    )
                );
                the_widget('WP_Widget_Tag_Cloud');
                ?>

            </div><!-- .entry-content -->
            <?php
        }   // End if.
        ?>
    </article><!-- #post-0 -->

<?php
weaverx_page_tail('404', $sb_layout);    // end of page wrap

