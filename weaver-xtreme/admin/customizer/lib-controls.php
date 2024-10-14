<?php
/** PHP 7.4 features added */

//----------------------- customizer defines
const WEAVERX_COLOR_CONTROL = 'Customize_Alpha_Color_Control'; //'WP_Customize_Color_Control' );
const WEAVERX_COLOR_TRANSPORT = 'postMessage'; // 'postMessage' );
const WEAVERX_SELECT_CONTROL = 'WeaverX_Select_Control';
const WEAVERX_ROUNDED_TRANSPORT = 'refresh';

const WEAVERX_REFRESH_ICON = ' &#8635;';    // add "recycle" icon for options that refresh instead of postMessage
const WEAVERX_MENU_UPDATE = 'refresh';


const WEAVERX_DEFAULT_SANITIZE = 'weaverx_default_sanitize';
const WEAVERX_CZ_SANITIZE_COLOR = 'weaverx_cz_sanitize_color';
const WEAVERX_CHOICE_SANITIZE = '_sanitize';

if (weaverx_cz_is_plus()) {

    //define( 'WEAVERX_PLUS_ICON', ' &#8901;+&#8901;' );
    define('WEAVERX_PLUS_ICON', ' &#10012;');
    define('WEAVERX_PLUS_COLOR_CONTROL', WEAVERX_COLOR_CONTROL);

    define('WEAVERX_PLUS_SELECT_CONTROL', 'WeaverX_Select_Control');
    define('WEAVERX_PLUS_CHECKBOX_CONTROL', null);
    define('WEAVERX_PLUS_TEXT_CONTROL', null);
    define('WEAVERX_PLUS_TEXTAREA_CONTROL', 'WeaverX_Textarea_Control');

    define('WEAVERX_PLUS_RANGE_CONTROL', 'WeaverX_Range_Control');
    define('WEAVERX_PLUS_IMAGE_CONTROL', 'WP_Customize_Image_Control');
    define('WEAVERX_PLUS_MISC_CONTROL', 'WeaverX_Misc_Control');


} else {    // plus not active

    define('WEAVERX_PLUS_ICON', ' (&#10012;)');
    define('WEAVERX_PLUS_COLOR_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_SELECT_CONTROL', 'WeaverX_XPlus_Control');//
    define('WEAVERX_PLUS_CHECKBOX_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_TEXT_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_TEXTAREA_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_RANGE_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_IMAGE_CONTROL', 'WeaverX_XPlus_Control');
    define('WEAVERX_PLUS_MISC_CONTROL', 'WeaverX_XPlus_Control');
}


function weaverx_cz_line(): array
{
    return array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'type' => 'line',
        ),
    );
}

function weaverx_cz_rawhtml($label, $description): array
{

    $control = 'WeaverX_RawHTML_Control';

    return array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_default_sanitize',
            'transport' => 'postMessage',
        ),
        'control' => array(
            'control_type' => $control,
            'label' => $label,
            'description' => $description,
        ),
    );

}


/**
 * @param        $label
 * @param        $description
 * @param        $default
 * @param        $range
 * @param string $transport
 * @param string $plus
 *
 * @return array
 */
function weaverx_cz_range($label, $description, $default, $range, $transport = 'refresh', $plus = ''): array
{

    if ($plus == 'plus') {
        $label .= WEAVERX_PLUS_ICON;
    }

    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    $control = apply_filters('weaverx_plus_control', 'WeaverX_Range_Control', $plus);

    return array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_int',
            'transport' => $transport,
            'default' => $default,
        ),
        'control' => array(
            'control_type' => $control,
            'label' => $label,
            'description' => $description,
            'input_attrs' => $range,
        ),
    );
}

/**
 * @param        $label
 * @param        $description
 * @param        $default
 * @param        $range
 * @param string $transport
 * @param string $plus
 *
 * @return array
 */
function weaverx_cz_range_float($label, $description, $default, $range, $transport = 'refresh', $plus = ''): array
{

    if ($plus == 'plus') {
        $label .= WEAVERX_PLUS_ICON;
    }

    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    $control = apply_filters('weaverx_plus_control', 'WeaverX_Range_Control', $plus);

    return array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_float',
            'transport' => $transport,
            'default' => $default,
        ),
        'control' => array(
            'control_type' => $control,
            'label' => $label,
            'description' => $description,
            'input_attrs' => $range,
        ),
    );

}

// Classes ***********************************************

if (class_exists('WP_Customize_Control') && !class_exists('WeaverX_Textarea_Control')) :
    class WeaverX_Textarea_Control extends WP_Customize_Control
    {
        public $type = 'textarea';

        public function render_content()
        {
            if (isset($this->input_attrs['rows'])) {
                $rows = $this->input_attrs['rows'];
            } else {
                $rows = 4;
            }
            if (isset($this->input_attrs['placeholder'])) {
                $placeholder = $this->input_attrs['placeholder'];
            } else {
                $placeholder = '';
            }

            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php
                if ('' !== $this->description) {
                    echo '<span class="description customize-control-description">' . $this->description . '</span>';
                }
                ?>
                <textarea rows="<?php echo $rows; ?>"
                          placeholder="<?php echo esc_html($placeholder); ?>"
                          style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php   /* 6/23 fix** */
        }
    }
endif;

if (class_exists('WP_Customize_Control') && !class_exists('WeaverX_Misc_Control')) :
    /**
     * Class WeaverX_Misc_Control
     *
     * These controls are based on the standard WP_Customize_Control class.
     *
     * There area two main reasons for creating these custom controls:
     *
     * 1. To allow HTML Markup in the $descriptions
     * 2. To add a few very simple controls to simplify the section controls definitions
     *
     */
    class WeaverX_Misc_Control extends WP_Customize_Control
    {
        /**
         * The current setting name.
         */
        public $settings = 'blogname';

        /**
         * The current setting description.
         */
        public $description = '';

        /**
         * Render the description and title for the section.
         *
         */
        public function render_content()
        {
            switch ($this->type) {
                case 'group-title' :
                    if ('' !== $this->label) {
                        echo '<h4 class="weaverx-control-group-title">' . esc_html($this->label) . '</h4>';
                    }
                    if ('' !== $this->description) {
                        echo '<span class="description customize-control-description">' . wp_kses_post($this->description) . '</span>';
                    }
                    break;

                case 'heading':
                    if ('' !== $this->label) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    }
                    if ('' !== $this->description) {
                        echo '<span class="description customize-control-description">' . wp_kses_post($this->description) . '</span>';
                    }
                    break;

                case 'HTML':
                case 'html':
                    if ('' !== $this->description) {
                        echo '<span class="custom-html customize-control-html">' . wp_kses_post($this->description) . '</span>';
                    }
                    break;

                case 'radio-icons':
                    if ('' !== $this->label) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    }

                    if ('' !== $this->description) {
                        echo '<span class="custom-radio customize-control-description">' . esc_html($this->description) . '</span>';
                    }

                    if (empty($this->choices)) {
                        return;
                    }

                    $name = '_customize-radio-' . $this->id;

                    echo '<br />';


                    foreach ($this->choices as $value => $label) {
                        ?>
                        <label>
                            <input type="radio" value="<?php echo esc_attr($value); ?>"
                                   name="<?php echo esc_attr($name); ?>" <?php $this->link();
                            checked($this->value(), $value); ?> />
                            <?php echo esc_html($label); ?><span
                                    style="margin-right:.5em;">&nbsp;</span>
                            <br/>
                        </label>
                        <?php
                    }
                    break;

                case 'select-fontfamily':
                    if ('' !== $this->label) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    }
                    if ('' !== $this->description) {
                        echo '<span class="custom-html customize-control-description">' . esc_html($this->description) . '</span>';
                    }

                    if (empty($this->choices)) {
                        return;
                    }

                    $name = '_customize-select-' . $this->id;
                    echo '<br /><select>';

                    foreach ($this->choices as $value => $label) {
                        ?>
                        <label>
                            <option value="<?php echo esc_attr($value); ?>"
                                    name="<?php echo esc_attr($name); ?>"
                                    selected=" <?php checked($this->value(), $value); ?>">
                                <?php echo wp_kses_data($label); ?></option>
                        </label>
                        <?php
                    }
                    echo '</select>';
                    break;

                case 'line':
                    echo '<hr />';
                    break;

                case 'text':
                default:
                    if ('' !== $this->label) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    }
                    echo '<p class="description customize-control-description">' . wp_kses_post($this->description) . '</p>';
                    break;
            }
        }
    }
endif;

if (class_exists('WP_Customize_Control') && !class_exists('WeaverX_XPlus_Control')) :
    /**
     * Class WeaverX_XPlus_Control
     *
     * Only displays title and description for XPlus
     *
     */
    class WeaverX_XPlus_Control extends WP_Customize_Control
    {

        public $description = '';

        /**
         * Render the description and title for the section.
         *
         * displays special message for Weaver Plus
         *
         */
        public function render_content()
        {

            $lbl = $this->label;
            $lbl = str_replace('&#8635;', '', $lbl);

            if (!defined('WEAVERX_SHOW_PLUS')) {
                define('WEAVERX_SHOW_PLUS', 'hide');
            }      /* 'hide', 'min', 'all' */

            switch (WEAVERX_SHOW_PLUS) {

                case 'min':
                    echo '<span class="description" style="color:green;">' . esc_html__('Plus Option:', 'weaver-xtreme') . '</span> ' . esc_html($lbl);
                    break;

                case 'all':
                    echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    if ('' !== $this->description && $this->type != 'HTML') {
                        echo '<span class="description customize-control-description">' . esc_html($this->description) . '</span>';
                    }

                    $link = "<a style='text-decoration:none;font-weight:bold;font-style:italic;background-color:#FFE4B5;padding:1px 4px;' href='//shop.weavertheme.com' target='_blank'>Weaver Xtreme Plus.</a>";

                    // translators: $s: link
                    echo '<span class="description customize-control-description">' . wp_kses_post(sprintf(weaverx_markdown(__('**&#9733; *Add this setting!* Get %s**', 'weaver-xtreme')), wp_kses_post($link))) .
                        '</span>';
                    break;

                case 'hide':
                default;
                    echo '<span class="description"></span>';   // have to the span anyway, otherwise parent will echo anyway
                    break;
            }
        }
    }
endif;

if (class_exists('WP_Customize_Control') && !class_exists('WeaverX_Select_Control')) :
    /**
     * Class WeaverX_Select_Control
     *
     * Specialized select control to enable disabled option support.
     *
     */
    class WeaverX_Select_Control extends WP_Customize_Control
    {
        public $type = 'range';

        protected function render_content()
        {
            if (empty($this->choices)) {
                return;
            }
            if (isset($this->input_attrs['before'])) {
                echo $this->input_attrs['before'];
            }
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif;
                if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                <?php endif; ?>

                <select <?php $this->link(); ?>>
                    <?php
                    foreach ($this->choices as $value => $label) {
                        $disabled = '';
                        if (strpos($label, '---') !== false) {
                            $disabled = ' disabled';
                            $label = str_replace('---', '', $label);
                        }
                        echo '<option value="' . esc_attr($value) . '"' . selected($this->value(), $value, false) . $disabled . '>' . $label . '</option>';
                    }
                    ?>
                </select>
            </label>
            <?php
            if (isset($this->input_attrs['after'])) {
                echo $this->input_attrs['after'];
            }
        }
    }
endif;


/**
 * Class WeaverX_RawHTML_Control
 *
 */
class WeaverX_RawHTML_Control extends WP_Customize_Control
{
    public $type = 'rawhtml';

    protected function render()
    {
        $id = 'customize-control-' . str_replace('[', '-', str_replace(']', '', $this->id));
        $this->render_content();
    }

    protected function render_content()
    {
        add_filter('wp_kses_allowed_html', 'weaverx_raw_html_filter', 10, 2);
        if (!empty($this->label)) {
            echo wp_kses_post($this->label);
        }
        if (!empty($this->description)) {
            echo wp_kses_post($this->description);
        }
        remove_filter('wp_kses_allowed_html', 'weaverx_raw_html_filter', 10);
    }
}

function weaverx_raw_html_filter($allowed, $context): array
{

    if ('post' === $context) {
        $allowed['a']['onclick'] = true;
    }

    return $allowed;
}

/**
 * Class WeaverX_Range_Control
 *
 * Specialized range control to enable a slider with an accompanying number field.
 *
 * Inspired by Kirki.
 * @link https://github.com/aristath/kirki/blob/0.5/includes/controls/class-Kirki_Customize_Sliderui_Control.php
 *
 */
class WeaverX_Range_Control extends WP_Customize_Control
{
    public $type = 'range';
    public $mode = 'slider';


    public function enqueue()
    {
        wp_enqueue_script('jquery-ui-slider');
    }

    public function active_callback(): bool
    {
        // This callback allows use of Left/Right Padding n % for alignwide and align full wrapping areas
        // For other ranges and non-wrapping padding, the regular L/R padding in px will be used.
        global $wp_customize;

        return true;
    }


    protected function render()
    {
        $id = 'customize-control-' . str_replace('[', '-', str_replace(']', '', $this->id));
        $class = 'customize-control customize-control-' . $this->type . ' customize-control-' . $this->type . '-' . $this->mode;

        ?>
    <li id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>">
        <?php $this->render_content(); ?>
        </li><?php
    }


    protected function render_content()
    { ?>
        <label>
            <?php if (!empty($this->label)) : ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif;
            if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo wp_kses_data($this->description); ?></span>
            <?php endif; ?>
            <div id="slider_<?php echo $this->id; ?>" class="weaverx-range-slider"></div>
            <input id="input_<?php echo $this->id; ?>" class="weaverx-control-range"
                   type="number" <?php $this->input_attrs(); ?>
                   value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
        </label>
        <?php
    }
}


if (!class_exists('weaverx_cz_Prioritizer')) :
    /**
     * Class weaverx_cz_Prioritizer
     *
     * Increment upward from a starting number with each call to add().
     *
     */
    class weaverx_cz_Prioritizer
    {
        var $initial_priority = 0;        // The starting priority.

        var $increment = 0;                // The amount to increment for each step.

        var $current_priority = 0;        // Holds the reference to the current priority value.

        /**
         * Set the initial properties on init.
         */
        function __construct($initial_priority = 100, $increment = 100)
        {
            $this->initial_priority = absint($initial_priority);        // Value to begin the counter.
            $this->increment = absint($increment);                // Value to increment the counter by.
            $this->current_priority = $this->initial_priority;
        }

        public function get()
        {
            return $this->current_priority;    // The current priority value.
        }

        public function inc($increment = 0): void
        {        // Increment the priority.
            if (0 === $increment) {
                $increment = $this->increment;
            }
            $this->current_priority += absint($increment);
        }

        public function add()
        {            // Increment by the $this->increment value.
            $priority = $this->get();
            $this->inc();

            return $priority;
        }

        /**
         * Change the current priority and/or increment value.
         */
        public function set($new_priority = null, $new_increment = null): void
        {
            if (!is_null($new_priority)) {
                $this->current_priority = absint($new_priority);
            }
            if (!is_null($new_increment)) {
                $this->increment = absint($new_increment);
            }
        }

        /**
         * Reset the counter.
         */
        public function reboot(): void
        {
            $this->current_priority = $this->initial_priority;
        }
    }
endif;

class WeaverX_Customize_Setting extends WP_Customize_Setting
{
    /**
     * custom Customize Setting class.
     *
     * Handles saving and sanitizing of settings - work around for O( n^2 ) issue in WP 4.3 and before
     *
     */
    static $cache = array();

    static $filter_added = false;


    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);    // set up the id_data, etc.

        if (!WeaverX_Customize_Setting::$filter_added) {
            add_filter('pre_option_' . $this->id_data['base'], 'WeaverX_Customize_Setting::_preview_filter_cache');
            add_filter('option_' . $this->id_data['base'], 'WeaverX_Customize_Setting::_preview_filter_cache');
            add_filter('default_option_' . $this->id_data['base'], 'WeaverX_Customize_Setting::_preview_filter_cache');
            WeaverX_Customize_Setting::$filter_added = true;
        }

    }

    static function _preview_filter_cache($original)
    {
        if (!isset(WeaverX_Customize_Setting::$cache) || empty($original)) // nothing to do
        {
            return $original;
        }

        foreach (WeaverX_Customize_Setting::$cache as $set_this) {
            $id = $set_this->id_data['keys'][0];    // may need to fix this if value is an array.

            $undefined = new stdClass(); // symbol hack
            $post_value = $set_this->post_value($undefined);
            if ($undefined === $post_value) {
                $value = $set_this->_original_value;
            } else {
                $value = $post_value;
            }

            if (empty($value))    // if new is empty, then unset the original, too.
            {
                unset($original[$id]);
            } else {
                $original[$id] = $value;
            }
        }

        return $original;
    }

    public function preview()
    {
        if (!isset($this->_original_value)) {
            $this->_original_value = $this->value();
        }
        if (!isset($this->_previewed_blog_id)) {
            $this->_previewed_blog_id = get_current_blog_id();
        }

        switch ($this->type) {
            case 'theme_mod' :
                add_filter('theme_mod_' . $this->id_data['base'], array($this, '_preview_filter'));
                break;

            case 'option' :
                if (!is_array(WeaverX_Customize_Setting::$cache)) {
                    WeaverX_Customize_Setting::$cache = array();    // make it an array once
                }
                WeaverX_Customize_Setting::$cache[] = $this;
                break;
            default :
                /**
                 * Fires when the {@see WP_Customize_Setting::preview()} method is called for settings
                 * not handled as theme_mods or options.
                 *
                 * The dynamic portion of the hook name, `$this->id`, refers to the setting ID.
                 *
                 * @param WP_Customize_Setting $this {@see WP_Customize_Setting} instance.
                 *
                 * @since 3.4.0
                 *
                 */
                do_action("customize_preview_{$this->id}", $this);

                /**
                 * Fires when the {@see WP_Customize_Setting::preview()} method is called for settings
                 * not handled as theme_mods or options.
                 *
                 * The dynamic portion of the hook name, `$this->type`, refers to the setting type.
                 *
                 * @param WP_Customize_Setting $this {@see WP_Customize_Setting} instance.
                 *
                 * @since 4.1.0
                 *
                 */
                do_action("customize_preview_{$this->type}", $this);
        }
    }
} // end WeaverX_Customize_Setting


// ++++++++++++++++++++++++++++++++  Controls + Sanitizers

function weaverx_cz_add_image($root, $label = '', $description = '', $transport = 'postMessage', $version = 'XPlus'): array
{
    $opt = array();

    if ($version == 'XPlus') {
        $label .= WEAVERX_PLUS_ICON;
    }
    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    $opt[$root . '-headingbg'] = weaverx_cz_group_title($label);


    if ($description) {
        $opt[$root . '-desc'] = array(
            'control' => array(
                'control_type' => 'WeaverX_Misc_Control',
                'description' => $description,
                'type' => 'text',
            ),
        );
    }


    $opt["_bg_{$root}_url"] = array(
        'setting' => array(
            'transport' => $transport,
            'sanitize_callback' => 'esc_url_raw',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_IMAGE_CONTROL,
            'label' => '',
            //'type'  => 'checkbox',
        ),
    );

    $opt["_bg_{$root}_rpt"] = array(
        'setting' => array(
            'transport' => $transport,
            'default' => 'repeat',
        ),
        'control' => array(
            'control_type' => WEAVERX_PLUS_SELECT_CONTROL,
            'label' => esc_html__('Tile BG Image', 'weaver-xtreme'),
            'type' => 'select',
            'choices' => weaverx_cz_choices_repeat(),
        ),
    );

    $opt["_bg_{$root}_rpt_css"] = array(
        'setting' => array('sanitize_callback' => 'weaverx_cz_sanitize_css', 'transport' => 'refresh', 'default' => ''),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXT_CONTROL,
            'label' => esc_html__('Additional CSS', 'weaver-xtreme') . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'type' => 'text',
        ),
    );


    return $opt;

}

/**
 * @param string $label
 * @param string $description
 * @param string $plus
 * @param string $transport (default: refresh)
 *
 * @return array
 */
function weaverx_cz_checkbox($label, $description = '', $plus = '', $transport = 'refresh'): array
{

    if ($plus == 'plus') {
        $label .= WEAVERX_PLUS_ICON;
    }

    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    $control = apply_filters('weaverx_plus_control', null, $plus);

    return array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_int',
            'transport' => $transport,
        ),
        'control' => array(
            'control_type' => $control,
            'label' => $label,
            'description' => $description,  // native checkbox does esc_html
            'type' => 'checkbox',
        ),
    );

}

function weaverx_cz_checkbox_refresh($label, $description = '', $plus = ''): array
{
    return weaverx_cz_checkbox($label, $description, $plus, 'refresh');
}

function weaverx_cz_checkbox_post($label, $description = '', $plus = ''): array
{
    return weaverx_cz_checkbox($label, $description, $plus, 'postMessage');
}

function weaverx_cz_color($opt, $label, $description = '', $transport = WEAVERX_COLOR_TRANSPORT): array
{
    /*
    'coloropt' => weaverx_cz_color(
                'opt',
                label,
                description,
                transport
            ),
    */
    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }
    $default = weaverx_cz_getopt($opt);
    if (!$default) {
        $default = 'inherit';
    }

    return array(
        'setting' => array(
            'sanitize_callback' => WEAVERX_CZ_SANITIZE_COLOR,
            'transport' => $transport,
            'default' => $default,
        ),
        'control' => array(
            'control_type' => WEAVERX_COLOR_CONTROL,
            'label' => $label,
            'description' => $description,
        ),
    );
}

function weaverx_cz_color_plus($opt, $label, $description = '', $transport = WEAVERX_COLOR_TRANSPORT): array
{

    $label .= WEAVERX_PLUS_ICON;
    if (weaverx_cz_is_plus()) {
        return weaverx_cz_color($opt, $label, $description, $transport);
    }

    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    return weaverx_cz_heading($label, $description);
}

function weaverx_cz_css($label, $description = ''): array
{
    return array(
        'setting' => array('sanitize_callback' => 'weaverx_cz_sanitize_css', 'transport' => 'refresh', 'default' => ''),
        'control' => array(
            'control_type' => 'WeaverX_Textarea_Control',
            'label' => $label,
            'description' => $description,
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => '2',
                'placeholder' => esc_html__('{font-size:150%;font-weight:bold;} /* for example */', 'weaver-xtreme'),
            ),
        ),
    );
}

function weaverx_cz_add_class($label, $description = ''): array
{
    if ($description == '') {
        $description = esc_html__('Space separated class names to add to this area.', 'weaver-xtreme');
    }

    return array(
        'setting' => array('sanitize_callback' => 'weaverx_cz_sanitize_css', 'transport' => 'refresh', 'default' => ''),
        'control' => array(
            'control_type' => WEAVERX_PLUS_TEXT_CONTROL,
            'label' => $label . WEAVERX_PLUS_ICON . WEAVERX_REFRESH_ICON,
            'description' => $description,
            'type' => 'text',
            'input_attrs' => array(
                'style' => 'width:85%;',
            ),
        ),
    );
}

function weaverx_cz_add_class_menu($label, $description = ''): array
{
    if ($description == '') {
        $description = esc_html__('Class names to add for the menu. Use "wvrx-fullwidth" class here and "Align Left" above to create "Extend BG" menus found in previous theme versions.', 'weaver-xtreme');
    }

    return array(
        'setting' => array('sanitize_callback' => 'weaverx_cz_sanitize_css', 'transport' => 'refresh', 'default' => ''),
        'control' => array(
            'label' => $label . WEAVERX_REFRESH_ICON,
            'description' => $description,
            'type' => 'text',
            'input_attrs' => array(
                'style' => 'width:85%;',
            ),
        ),
    );
}

/**
 * @param        $root
 * @param string $label
 * @param string $description
 * @param string $transport
 * @param string $show_outline
 *
 * @return array
 */
function weaverx_cz_fonts_control($root, $label = '', $description = '', $transport = 'refresh', $show_outline = 'normal'): array
{

    /* called from:
    'wrapper', 'container',
    'site_title', 'tagline', 'header_sb', 'header_html',
    'm_primary', 'm_secondary', 'm_header_mini', 'm_extra', 'info_bar'
    'content', 'page_title', 'archive_title', 'content_h',
    'post', 'post_title', 'post_info_top', 'post_info_bottom',
    'primary', 'secondary', 'top', 'bottom', 'widget', 'widget_title',
    'footer', 'footer_sb', 'footer_html'
     */

    $opt = array();

    $glabel = $label;
    if ($transport == 'refresh') {
        $glabel .= WEAVERX_REFRESH_ICON;
    }

    $opt[$root . '-font-hdrm'] = weaverx_cz_group_title($glabel, $description);


    // Font Family

    $t_dir = get_theme_file_uri('help/font-demo.html');

    // all $opt

    $opt[$root . '_font_family'] = weaverx_cz_select(
        '',
        '<strong>' . wp_kses_post(__('Select <span style="font-size:120%;">Font Family</span> for ', 'weaver-xtreme')) . "{$label}&nbsp;&nbsp;<a href='{$t_dir}' target='_blank'><span class='dashicons dashicons-info'></span></a>",
        'weaverx_cz_choices_font_family', '', $transport
    );

    // Font Size
    $opt[$root . '_font_size'] = weaverx_cz_select(
        '',
        '<strong>' . wp_kses_post(__('Select <span style="font-size:120%;">Font Size</span> for ', 'weaver-xtreme')) . esc_html($label) . '</strong>',
        'weaverx_cz_choices_font_size',
        '', $transport
    );

    // Bold / Normal

    if ($root == 'tagline' || $root == 'content_h' || strpos($root, '_title') > 0) {
        if ($transport == 'refresh') {
            $opt[$root . '_normal'] = weaverx_cz_checkbox(
                esc_html__('Normal Weight for ', 'weaver-xtreme') . $label,
                ''
            );
        } else {
            $opt[$root . '_normal'] = weaverx_cz_checkbox_post(
                esc_html__('Normal Weight for ', 'weaver-xtreme') . $label,
                ''
            );
        }
    } else {
        $opt[$root . '_bold'] = weaverx_cz_select(
            '',
            '<strong>' . wp_kses_post(__('Use <span style="font-size:120%;font-weight:bold;">Bold</span> for ', 'weaver-xtreme')) . '</strong>' . $label,
            'weaverx_cz_choices_bold_italic', '', $transport
        );
    }

    // Italic
    $opt[$root . '_italic'] = weaverx_cz_select(
        '',
        '<strong>' . wp_kses_post(__('Use <span style="font-size:120%;"><em>Italic</em></span> for ', 'weaver-xtreme')) . '</strong>' . $label,
        'weaverx_cz_choices_bold_italic', '', $transport
    );

    // Outline
    if ($show_outline == 'outline') {
        $opt[$root . '_outline'] = weaverx_cz_checkbox(esc_html__('Display as Outline Font', 'weaver-xtreme'),
            weaverx_markdown(__('Show font as outline font. Does not necessarily look good with some fonts. *Set font color in Global Typography Options.*', 'weaver-xtreme')),
            '',
            'refresh'
        );
    }


    if (weaverx_options_level() > WEAVERX_LEVEL_INTERMEDIATE && !in_array($root, array('content_h', 'post_info_top', 'post_info_bottom', 'm_extra'))) {
        if (weaverx_cz_is_plus('4.0')) {        // new xplus 4.0 options

            $opt[$root . '_transform'] = weaverx_cz_select(
                esc_html__('Text Transform', 'weaver-xtreme'), '',
                'weaverx_cz_choices_transform', '', 'refresh', 'plus'
            );

            $opt[$root . '_letter_spacing'] = weaverx_cz_range_float(
                esc_html__('Character Spacing (em)', 'weaver-xtreme'),
                '',
                0.0,
                array(
                    'min' => -0.1,
                    'max' => .25,
                    'step' => .0025,
                ),
                'refresh',
                'plus'
            );

            $opt[$root . '_word_spacing'] = weaverx_cz_range_float(
                esc_html__('Word Spacing (em)', 'weaver-xtreme'),
                '',
                0.0,
                array(
                    'min' => -.5,
                    'max' => 1.0,
                    'step' => .05,
                ),
                'refresh',
                'plus'
            );
        } else {
            $opt[$root . '_font-xpx'] = weaverx_cz_heading(esc_html__('Get Weaver Xtreme Plus 4.0 or later to add Transform and font spacing options.', 'weaver-xtreme'));
        }
    }

    return $opt;

}

function weaverx_cz_fonts_add_link($root, $label = '', $description = '', $transport = 'postMessage'): array
{

    // called for: link, ibarlink, contentlink, ilink, wlink, footerlink

    $opt = array();

    $tlabel = ($transport == 'postMessage') ? '' : WEAVERX_REFRESH_ICON;

    $opt[$root . '-fontlink-hdm'] = weaverx_cz_group_title($label, $description);


    // Bold
    $opt[$root . '_strong'] = weaverx_cz_select(
        '',
        '<strong>' . esc_html__('Use Bold for ', 'weaver-xtreme') . $label . '</strong>' . $tlabel,
        'weaverx_cz_choices_bold_italic', '', $transport
    );


    // Italic
    $opt[$root . '_em'] = weaverx_cz_select(
        '',
        '<strong>' . wp_kses_post(__('Use <em>Italic</em> for ', 'weaver-xtreme')) . $label . '</strong>' . $tlabel,
        'weaverx_cz_choices_bold_italic', '', $transport
    );


    // Underline

    $opt[$root . '_u'] = array(
        'setting' => array(
            'transport' => $transport,
        ),
        'control' => array(
            'label' => esc_html__('Underline Link', 'weaver-xtreme') . $tlabel,
            'description' => '<strong>' . wp_kses_post(__('Use <u>Underline</u> link for ', 'weaver-xtreme')) . $label . '</strong>',
            'type' => 'checkbox',
        ),
    );

    // Underline

    $opt[$root . '_u_h'] = array(
        'setting' => array(
            'transport' => 'refresh'    // this one is refresh
        ),
        'control' => array(
            'label' => esc_html__('Underline Hover', 'weaver-xtreme') . WEAVERX_REFRESH_ICON,
            'description' => '<strong>' . wp_kses_post(__('Use <u>Underline</u> on Hover.', 'weaver-xtreme')) . '</strong>',
            'type' => 'checkbox',
        ),
    );


    return $opt;

}

function weaverx_cz_group_title($label, $description = ''): array
{
    /*
    'group_title' => weaverx_cz_group_title(
                label,
                description
            ),
    */
    return array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => $label,
            'description' => $description,
            'type' => 'group-title',
        ),
    );
}

/**
 * @param        $label
 * @param string $description
 * @param string $rows
 * @param string $placeholder
 * @param string $transport
 * @param string $plus
 * @param string $sanitize
 *
 * @return array
 */
function weaverx_cz_htmlarea($label, $description = '', $rows = '1', $placeholder = '',
                             $transport = 'refresh', $plus = '', $sanitize = 'wp_kses_post'): array
{
    // use wp_kses_post for filter
    if ($placeholder == '') {
        $placeholder = esc_html__('Any HTML', 'weaver-xtreme');
    }

    return weaverx_cz_textarea($label, $description, $rows, $placeholder,
        $transport, $plus, $sanitize);
}

function weaverx_cz_html_textarea($label, $description = '', $rows = '1', $transport = 'postMessage'): array
{
    /*
    weaverx_cz_html_textarea( $label,
                $description,
                $rows ),
    */
    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    return array(
        'setting' => array(
            'sanitize_callback' => 'weaverx_cz_sanitize_html',
            'transport' => $transport,
            'default' => '',
        ),
        'control' => array(
            'control_type' => 'WeaverX_Textarea_Control',
            'label' => $label,
            'description' => $description,
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => $rows,
                'placeholder' => esc_html__('Any HTML, including shortcodes.', 'weaver-xtreme'),
            ),
        ),
    );
}

function weaverx_cz_heading($label, $description = ''): array
{
    /*
    'heading' => weaverx_cz_heading(
                label,
                description
            ),
    */
    return array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => $label,
            'description' => $description,
            'type' => 'heading',
        ),
    );
}

/**
 * @param string $description
 *
 * @return array
 */
function weaverx_cz_html_description($description = '', $plus = ''): array
{

    return array(
        'control' => array(
            'control_type' => apply_filters('weaverx_plus_control', 'WeaverX_Misc_Control', $plus),
            'label' => '',
            'description' => $description,
            'type' => 'HTML',
        ),
    );
}

function weaverx_cz_html($label, $description = ''): array
{
    /*
    'html' => weaverx_cz_heading(
                label,
                description
            ),
    */
    return array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => $label,
            'description' => $description,
            'type' => 'HTML',
        ),
    );
}

//-----------@@@@@@@@@@@@@@@@dev:

function weaverx_cz_radio_icon($label, $description, $choices, $default = '', $transport = 'refresh', $plus = ''): array
{

    if ($plus == 'plus' && $label) {
        $label .= WEAVERX_PLUS_ICON;
    }

    if ($transport == 'refresh' && $label) {
        $label .= WEAVERX_REFRESH_ICON;
    }


    if (!is_array($choices) && function_exists($choices . '_sanitize')) {
        $sanitize = $choices . '_sanitize';
    } else {
        $sanitize = 'weaverx_cz_sanitize_select';
    }


    if (is_array($choices)) {
        $list = $choices;
    } else {
        $list = $choices();
    }

    return array(
        'setting' => array(
            'default' => $default,
            'sanitize_callback' => $sanitize,
            'transport' => $transport,
        ),
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => esc_html($label),
            'description' => wp_kses_post($description),
            'type' => 'radio-icons',
            'choices' => $list,
        ),
    );
}


/**
 * @param        $label
 * @param        $description
 * @param        $choices
 * @param string $default
 * @param string $transport
 * @param string $plus
 *
 * @return array
 */
function weaverx_cz_select($label, $description, $choices, $default = '', $transport = 'refresh', $plus = ''): array
{

    if ($plus == 'plus' && $label) {
        $label .= WEAVERX_PLUS_ICON;
    }

    if ($transport == 'refresh' && $label) {
        $label .= WEAVERX_REFRESH_ICON;
    }


    if (!is_array($choices) && function_exists($choices . '_sanitize')) {
        $sanitize = $choices . '_sanitize';
    } else {
        $sanitize = 'weaverx_cz_sanitize_select';
    }

    $control = apply_filters('weaverx_plus_control', 'WeaverX_Select_Control', $plus);

    if (is_array($choices)) {
        $list = $choices;
    } else {
        $list = $choices();
    }

    return array(
        'setting' => array(
            'default' => $default,
            'sanitize_callback' => $sanitize,
            'transport' => $transport,
        ),
        'control' => array(
            'control_type' => $control,
            'label' => esc_html($label),
            'description' => wp_kses_post($description),
            'type' => 'select',
            'choices' => $list,
        ),
    );
}


function weaverx_cz_sanitize_select($input, $setting): string
{
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    return sanitize_key($input);
}

/**
 * @param        $label
 * @param        $description
 * @param        $choices
 * @param string $default
 * @param string $transport
 *
 * @return array
 */
function weaverx_cz_select_plus($label, $description, $choices, $default = '', $transport = 'refresh'): array
{

    return weaverx_cz_select($label, $description, $choices, $default, $transport, 'plus');
}

function weaverx_cz_text($description = ''): array
{
    /*
    'group_title' => weaverx_cz_group_title(
                label,
                description
            ),
    */
    return array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => '',
            'description' => $description,
            'type' => 'text',
        ),
    );
}

function weaverx_cz_text_int($label, $description = ''): array
{
    return array(
        'setting' => array('sanitize_callback' => 'weaverx_cz_sanitize_int', 'transport' => 'refresh', 'default' => ''),
        'control' => array(
            'control_type' => 'WeaverX_Textarea_Control',
            'label' => $label . WEAVERX_REFRESH_ICON,
            'description' => $description,
            'type' => 'text',
        ),
    );

}

function weaverx_cz_textarea($label, $description = '', $rows = '1', $placeholder = '',
                             $transport = 'postMessage', $plus = false, $sanitize = 'weaverx_cz_sanitize_html'): array
{
    /*
    weaverx_cz_textarea( $label,
                $description,
                $rows , $placeholder,
                $refresh, $plus ),

    */
    if ($plus) {
        $control_type = WEAVERX_PLUS_TEXTAREA_CONTROL;
    } else {
        $control_type = 'WeaverX_Textarea_Control';
    }
    if ($plus) {
        $label .= WEAVERX_PLUS_ICON;
    }
    if ($transport == 'refresh') {
        $label .= WEAVERX_REFRESH_ICON;
    }

    return array(
        'setting' => array(
            'sanitize_callback' => $sanitize,
            'transport' => $transport,
            'default' => '',
        ),
        'control' => array(
            'control_type' => $control_type,
            'label' => $label,
            'description' => $description,
            'type' => 'textarea',
            'input_attrs' => array(
                'rows' => $rows,
                'placeholder' => $placeholder,
            ),
        ),
    );

}


// other sanitization ************************


function weaverx_cz_sanitize_float($value): float
{
    /**
     * Sanitize a string to ensure that it is a float number.
     *
     */
    if (!$value) {
        return 0.0;
    }    // need to be able detect '0' vs 0 or false
    else {
        return floatval($value);
    }
}

function weaverx_cz_sanitize_int($value): int
{
    if (!$value) {
        return 0;
    } else {
        return absint($value);
    }
}

function weaverx_default_sanitize(string $in): string
{
    // called for checkboxes, which must be okay
    return $in;
}

function weaverx_cz_sanitize_text($string): string
{
    /**
     * Allow only certain tags and attributes in a string.
     */
    $allowedtags = wp_kses_allowed_html();
    $allowedtags['a']['target'] = true;

    // span
    $allowedtags['span'] = array();

    // Enable id, class, and style attributes for each tag
    foreach ($allowedtags as $tag => $attributes) {
        $allowedtags[$tag]['id'] = true;
        $allowedtags[$tag]['class'] = true;
        $allowedtags[$tag]['style'] = true;
    }

    // br ( doesn't need attributes )
    $allowedtags['br'] = array();

    return wp_kses($string, $allowedtags);
}

function weaverx_cz_sanitize_html($string): string
{
    /**
     * Allow only certain tags and attributes in a string.
     */

    return weaverx_filter_code($string);

}

function weaverx_cz_sanitize_head_code($string): string
{

    return weaverx_filter_code($string);

}

function weaverx_cz_sanitize_code($string): string
{

    return weaverx_filter_code($string);

}

function weaverx_cz_sanitize_css($string): string
{

    return weaverx_filter_code($string);

}

function weaverx_cz_sanitize_color(string $color): string
{
    // sanitize color - allow rgb, rgba, color names, otherwise force to hashed hex

    $color_names = array(
        'aliceblue',
        'antiquewhite',
        'aqua',
        'aquamarine',
        'azure',
        'beige',
        'bisque',
        'black',
        'blanchedalmond',
        'blue',
        'blueviolet',
        'brown',
        'burlywood',
        'cadetblue',
        'chartreuse',
        'chocolate',
        'coral',
        'cornflowerblue',
        'cornsilk',
        'crimson',
        'cyan',
        'darkblue',
        'darkcyan',
        'darkgoldenrod',
        'darkgray',
        'darkgreen',
        'darkkhaki',
        'darkmagenta',
        'darkolivegreen',
        'darkorange',
        'darkorchid',
        'darkred',
        'darksalmon',
        'darkseagreen',
        'darkslateblue',
        'darkslategray',
        'darkturquoise',
        'darkviolet',
        'deeppink',
        'deepskyblue',
        'dimgray',
        'dodgerblue',
        'firebrick',
        'floralwhite',
        'forestgreen',
        'fuchsia',
        'gainsboro',
        'ghostwhite',
        'gold',
        'goldenrod',
        'gray',
        'green',
        'greenyellow',
        'honeydew',
        'hotpink',
        'indianred',
        'indigo',
        'ivory',
        'khaki',
        'lavender',
        'lavenderblush',
        'lawngreen',
        'lemonchiffon',
        'lightblue',
        'lightcoral',
        'lightcyan',
        'lightgoldenrodyellow',
        'lightgreen',
        'lightgrey',
        'lightpink',
        'lightsalmon',
        'lightseagreen',
        'lightskyblue',
        'lightslategray',
        'lightsteelblue',
        'lightyellow',
        'lime',
        'limegreen',
        'linen',
        'magenta',
        'maroon',
        'mediumaquamarine',
        'mediumblue',
        'mediumorchid',
        'mediumpurple',
        'mediumseagreen',
        'mediumslateblue',
        'mediumspringgreen',
        'mediumturquoise',
        'mediumvioletred',
        'midnightblue',
        'mintcream',
        'mistyrose',
        'moccasin',
        'navajowhite',
        'navy',
        'oldlace',
        'olive',
        'olivedrab',
        'orange',
        'orangered',
        'orchid',
        'palegoldenrod',
        'palegreen',
        'paleturquoise',
        'palevioletred',
        'papayawhip',
        'peachpuff',
        'peru',
        'pink',
        'plum',
        'powderblue',
        'purple',
        'red',
        'rosybrown',
        'royalblue',
        'saddlebrown',
        'salmon',
        'sandybrown',
        'seagreen',
        'seashell',
        'sienna',
        'silver',
        'skyblue',
        'slateblue',
        'slategray',
        'snow',
        'springgreen',
        'steelblue',
        'tan',
        'teal',
        'thistle',
        'tomato',
        'turquoise',
        'violet',
        'wheat',
        'white',
        'whitesmoke',
        'yellow',
        'yellowgreen',
        'inherit',
        'transparent',
    );

    $color = str_replace(' ', '', strtolower($color));
    if (!$color) {
        return 'inherit';
    }

    if (strpos($color, 'rgb') === 0) {        // rgb value
        return $color;
    } else {
        if (in_array($color, $color_names)) {    // CSS color names
            return $color;
        } else {
            // force leading #
            // 3 or 6 hex digits, or the empty string.
            if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
                return ($color[0] == '#') ? $color : '#' . $color;
            } else {
                return 'inherit';
            }
        }
    }
}

// utility

function weaverx_cz_add_plus_message($root, $label = '', $description = ''): array
{
    $opt = array();
    $opt[$root . '-heading'] = array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'label' => $label . ' (Plus Feature)',
            'type' => 'group-title',
        ),
    );

    if ($description) {
        $opt[$root . '-desc'] = array(
            'control' => array(
                'control_type' => 'WeaverX_Misc_Control',
                'description' => $description,
                'type' => 'text',
            ),
        );
    }
    $xplus = home_url('/wp-admin/themes.php?page=WeaverX', 'relative');
    $weaversite = '//shop.weavertheme.com';
    $opt[$root . 'extra-plus'] = array(
        'control' => array(
            'control_type' => 'WeaverX_Misc_Control',
            'description' => wp_kses_post(sprintf(__('See the <a href="%1$s" ><em>Appearance &rarr; Weaver Xtreme Admin</em></a> panel for related settings. Get <strong><a href="%2$s" target="_blank">Weaver Xtreme Plus</strong></a> to add this feature.', 'weaver-xtreme'), $xplus, $weaversite)),
            'type' => 'text',
        ),
    );

    return $opt;
}

function weaverx_cz_get_admin_page($link = 'default', $section = '', $target = '_self'): string
{
    // eventually we might be able to link to a $section of the Weaver Xtreme Admin page
    if ($link == 'default') {
        $link = esc_html__('Weaver Xtreme Admin Panel', 'weaver-xtreme');
    }

    return '<a href="' . home_url('/wp-admin/themes.php?page=WeaverX', 'relative') . '" title="' . $link . " target=" . $target . '">' . $link . '</a>';
}

function weaverx_check_customizer_memory(): void
{
    global $wp_customize;

    if (isset($wp_customize) && !$wp_customize->is_theme_active()) {
        return;
    }            // Not for preview!

    if (isset($wp_customize) && !weaverx_getopt('_disable_customizer')
        && !weaverx_getopt('_ignore_PHP_memory') && !weaverx_getopt('_PHP_warning_displayed')) {

        $memlim = get_cfg_var('memory_limit');        // the server memory limit.

        $memlim = str_ireplace('M', '', $memlim);    // kill the M

        if ($memlim > 0 && $memlim < WEAVERX_PHP_MEMORY_LIMIT) {        // show if not set
            weaverx_alert(wp_kses_post(sprintf(__('**** WARNING! ****\r\n\r\nYour WP host server has only %s of PHP Memory. Depending on your WordPress configuration, this could cause settings made in the Weaver Xtreme Customizer Interface to fail to be saved and applied to your live site.\r\n\r\nPlease verify that settings you make in the Customizer are being applied to your live site.\r\n\r\nThere are solutions if this issue applies to you. Please see the [Appearance : Weaver Xtreme Admin : Help] tab for more information about the possible PHP Memory problem.\r\n', 'weaver-xtreme'), $memlim . 'M')));
            weaverx_setopt('_PHP_warning_displayed', true); // hide for rest of this customizer session, redisplay next time.
        }
    }
}

function weaverx_get_logo_html(): string
{

    $wp_logo = weaverx_get_wp_custom_logo_url();

    if ($wp_logo) {
        return '<br />' . esc_html__('Current Site Logo: ', 'weaver-xtreme') . "<img alt= 'WP Logo' src='{$wp_logo}' style='max-height:36px;margin-left:10px;' />";
    } else {
        return '<br />' . wp_kses_post(__('<strong><span style="font-size:120%;">Site Logo has not been set.</span> You can set the Site Logo on the General Options & Admin -> Site Identity menu.</strong>', 'weaver-xtreme'));
    }
}

