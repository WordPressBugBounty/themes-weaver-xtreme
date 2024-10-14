<?php
/** PHP 7.4 features added */
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array. return wp_unique_id( $prefix );
 *
 * <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'weaver-xtreme' ); ?>" />
 */
$weaverx_unique_id = wp_unique_id('search-form-');
$weaverx_aria_label = !empty($args['label']) ? 'aria-label="' . esc_attr($args['label']) . '"' : '';
$searchw = esc_html__('Search for:', 'weaver-xtreme');
?>
<form role="search" <?php echo $weaverx_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?>
      method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="<?php echo esc_attr($weaverx_unique_id); ?>">
        <span class="screen-reader-text"><?php echo $searchw; ?></span>
        <input type="search" id="<?php echo esc_attr($weaverx_unique_id); ?>" class="search-field"
               placeholder="<?php echo $searchw; ?>" value="<?php echo get_search_query(); ?>"
               name="s"/>
    </label>
    <button type="submit" class="search-submit"><span class="genericon genericon-search"></span>
    </button>

</form>

