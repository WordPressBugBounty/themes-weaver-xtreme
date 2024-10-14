<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Weaver X
 * @since Weaver Xtreme 1.0
 */
weaverx_per_post_style();
$entry_summary = 'entry-summary';
?>
<article
        id="post-<?php the_ID(); ?>" <?php post_class('post-content content-gallery ' . weaverx_post_class());
echo weaverx_schema('post'); ?>>
    <?php
    if (!weaverx_compact_post()) {
        ?>
        <header class="entry-header">
            <?php
            weaverx_entry_header('gallery');
            weaverx_post_top_meta(); ?>
        </header><!-- .entry-header -->

        <?php
        if (weaverx_show_only_title()) {
            return;
        }

    } else {    // not compact
        $entry_summary .= ' compact-post-format';
    }

    $linked = false;
    ?>
    <div class="<?php echo $entry_summary; ?>">
        <?php
        if ( post_password_required() ) {
            weaverx_the_post_full();
        } else {
            // Let's look for some images from the gallery. (Updated 4.4 to TwentyEleven method.)
            $images = array();

            $galleries = get_post_galleries( get_the_ID(), false );
            if ( isset( $galleries[0]['ids'] ) ) {
                $images = explode( ',', $galleries[0]['ids'] );
            }

            if ( ! $images ) {
                $images = get_children( array(
                    'post_parent'    => get_the_ID(),
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'numberposts'    => 999,
                ) );
            }

            if (! $images ) {
                $images = get_posts(
                    array(
                        'fields'         => 'ids',
                        'numberposts'    => 999,
                        'order'          => 'ASC',
                        'orderby'        => 'menu_order',
                        'post_mime_type' => 'image',
                        'post_parent'    => get_the_ID(),
                        'post_type'      => 'attachment',
                    )
                );
            }

            if ( $images ) {    // found some images
                $total_images = count( $images );
                $image = reset( $images );
                ?>
                <figure class="gallery-thumb">
                    <a href="<?php esc_url( get_permalink()); ?>"><?php echo wp_get_attachment_image( $image, 'thumbnail' ); ?></a>
                </figure><!-- .gallery-thumb -->
                <?php $linked = true;
                if ( weaverx_compact_post() ) {
                    weaverx_clear_both( 'compact-post' );
                }
                ?>
                <p><em> <?php echo '<a href="' . esc_url( get_permalink() ) . '" title="' .
                                   esc_attr(sprintf( __( 'Permalink to %s', 'weaver-xtreme' ), the_title_attribute( 'echo=0' ) )) . '" rel="bookmark"' .
                                   '>' . esc_html__( 'Gallery', 'weaver-xtreme' ) . '</a></em></p>';

            } else {    // did not find any images from the content.
                // using get_children failed to find any gallery image, so let's do it ourselves.

                $content = do_shortcode( apply_filters( 'the_content', get_the_content( '' ) ) );    // pick up wp 3.6 post format
                if ( preg_match( '/<img[^>]+>/i', $content, $images ) ) {    // grab <img>s
                    $src = '';
                    if ( preg_match( '/src="([^"]*)"/', $images[0], $srcs ) ) {
                        $src = $srcs[0];
                    } elseif ( preg_match( "/src='([^']*)'/", $images[0], $srcs ) ) {
                        $src = $srcs[0];
                    }
                    $the_image = '<img class="gallery-thumb" ' . $src . ' alt="post image" />';
                    $linked = true;
                    ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php esc_attr(the_title_attribute( 'echo=1' )); ?>" rel="bookmark"><?php echo $the_image; ?></a>
                    <p><em><?php esc_html_e( 'Gallery', 'weaver-xtreme' ); ?></em></p>
                    <?php
                }
            }

            if ( ( ! weaverx_compact_post() && ! $linked ) || ! $linked ) {
                weaverx_the_post_excerpt();
            }
        }    // display gallery format
        weaverx_link_pages();    // <!--nextpage-->
        ?>
    </div><!-- .entry-summary -->
    <?php if (!weaverx_compact_post()) { ?>
        <footer class="entry-utility">
            <?php weaverx_post_bottom_info(); ?>
        </footer><!-- #entry-utility -->
        <?php weaverx_compact_link('check');
    } else {
        if (!$linked) {
            weaverx_compact_link();
        }
        weaverx_edit_link();
    }
    weaverx_inject_area('postpostcontent');    // inject post comment body
    ?>
    <div style="clear:both;"></div>
    <?php echo weaverx_schema('mainEntityOfPage'); ?>
</article><!-- /#post-<?php the_ID(); ?> -->
