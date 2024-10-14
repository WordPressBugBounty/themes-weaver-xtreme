<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template used for displaying 2 col page content in page.php
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */

weaverx_fi('page', 'post-pre');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
    <?php
    weaverx_page_title();
    ?>
    <div class="entry-content clearfix">
        <?php
        weaverx_fi('page', 'content-top');


        $content = get_the_content('', false); //arguments remove 'more' text

        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        // the first "more" is converted to a span with ID
        $columns = preg_split('/(<span id="more-\d+"><\/span>)|(<!--more-->)<\/p>/', $content);
        $col_count = count($columns);


        if ($col_count > 1) {
            for ($i = 0; $i < $col_count; $i++) {
                // check to see if there is a final </p>, if not add it
                if (!preg_match('/<\/p>\s?$/', $columns[$i])) {
                    $columns[$i] .= '</p>';
                }
                // check to see if there is an appending </p>, if there is, remove
                $columns[$i] = preg_replace('/^\s?<\/p>/', '', $columns[$i]);
                // now add the div wrapper
                if (( int )($i % 2) == 0) {
                    $coldiv = 'left';
                } else {
                    $coldiv = 'right';
                }
                if ($coldiv == 'right' && ($i + 1) < $col_count) {
                    $break_cols = '<hr class="atw-2-col-divider"/>';
                } else {
                    $break_cols = '';
                }
                $columns[$i] = '<div class="cf content-2-col-' . $coldiv . '">' . $columns[$i] . '</div>' . $break_cols;
            }
            $content = implode("\n", $columns);
        } else {
            // this page does not have dynamic columns
            $content = wpautop($content);
        }
        // remove any left over empty <p> tags
        $content = str_replace('<p></p>', '', $content);
        $content = str_replace('-right"><br />', '-right"><p>', $content);
        echo $content;

        weaverx_fi('page', 'content-bottom');
        weaverx_link_pages();    // <!--nextpage-->
        ?>
    </div>
    <div style="clear:both;"></div><!-- .entry-content -->
    <footer class="entry-utility-page">
        <?php weaverx_edit_link(); ?>
    </footer><!-- .entry-utility-page -->
    <?php echo weaverx_schema('mainEntityOfPage'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php weaverx_inject_area('pagecontentbottom'); ?>
