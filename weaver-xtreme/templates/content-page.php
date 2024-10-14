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

weaverx_fi('page', 'post-pre');
$pclass = 'content-page';
$cols = weaverx_get_per_page_value('_pp_page_cols');
if ($cols == '') {
    $cols = weaverx_getopt('page_cols');
}
if ($cols != '' && $cols != '1') {
    $pclass .= " cols-{$cols}";
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($pclass); ?>>
    <?php weaverx_page_title(); ?>
    <div class="entry-content clearfix">

        <?php
        echo weaverx_schema('mainEntityOfPage');
        weaverx_the_page_content('page');
        weaverx_link_pages();    // <!--nextpage-->

        weaverx_edit_link(); ?>
    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
<?php weaverx_inject_area('pagecontentbottom'); ?>
