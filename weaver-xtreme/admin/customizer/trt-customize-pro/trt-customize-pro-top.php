<?php

/**
 * Singleton class for handling the theme's customizer integration.
 * Based on trt-customize-pro
 *
 * @since  1.0.0
 * @access public
 */
final class WeaverX_Customize_Plus
{

    /**
     * Returns the instance.
     *
     * @return object
     * @since  1.0.0
     * @access public
     */
    public static function get_instance()
    {

        static $instance = null;

        if (is_null($instance)) {
            $instance = new self;
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Constructor method.
     *
     * @return void
     * @since  1.0.0
     * @access private
     */
    private function __construct()
    {
    }

    /**
     * Sets up initial actions.
     *
     * @return void
     * @since  1.0.0
     * @access private
     */
    private function setup_actions()
    {

        // Register panels, sections, settings, controls, and partials.
        add_action('customize_register', array($this, 'sections'));

        // Register scripts and styles for the controls.
        add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 0);
    }

    /**
     * Sets up the customizer sections.
     *
     * @param object $manager
     * @return void
     * @since  1.0.0
     * @access public
     */
    public function sections($manager)
    {

        // Load custom sections.
        //require_once(  get_theme_file_path( 'trt-customize-pro/weaver-x-plus/section-pro.php' ) );

        // Register custom section types.
        $manager->register_section_type('WeaverX_Customize_Plus_Section');

        // Register sections.
        // figure out what to show on top bar

        // !weaverx_getopt( '_disable_customizer' )
        $cur_vers = weaverx_wp_version();

        $content = '';

        $level = weaverx_options_level();
        $interface = weaverx_options_interface();


        if (weaverx_getopt('_disable_customizer')) {
            $content .= "<span style=\";text-align:center;border-bottom: solid 1px #eee;display: block; font-size: 100%;padding: 10px 8px;color:black;background:yellow;\">" . esc_html__('Weaver Xtreme Customizer Options Disabled', 'weaver-xtreme') . "</span>";
        } elseif ($level == 0) {    // not set yet...
            $content .= "<span style=\";text-align:center;border-bottom: solid 1px #eee;display: block; font-size: 100%;padding: 10px 8px;color:yellow;background:red;\"><strong>Please set the <em style=\"text-decoration:underline;cursor:pointer;\" onclick=\"wp.customize.section( 'weaverx_general_options_level' ).focus();\">Options Level &amp Interface</em></span>";
        } else {
            switch ($level) {
                case WEAVERX_LEVEL_ADVANCED:
                    $msgpost = '<em style="background-color:black;color:white;padding:3px;">' . esc_html__('Full', 'weaver-xtreme') . '</em>';
                    break;
                case WEAVERX_LEVEL_INTERMEDIATE:
                    $msgpost = '<em style="background-color:blue;color:white;padding:3px;">' . esc_html__('Standard', 'weaver-xtreme') . '</em>';
                    break;
                case WEAVERX_LEVEL_BEGINNER:
                default:
                    $msgpost = '<em style="background-color:green;color:white;padding:3px;">' . esc_html__('Basic', 'weaver-xtreme') . '</em>';
                    break;
            }

            switch ($interface) {
                case 'what':
                    $msginterface = '<em style="background-color:silver;color:black;padding:3px;">' . esc_html__('What', 'weaver-xtreme') . '</em>';
                    break;
                default;
                    $msginterface = '<em style="background-color:gold;color:black;padding:3px;">' . esc_html__('Where', 'weaver-xtreme') . '</em>';

            }

            $content .= "<span style=\"text-align:center; display:block;margin:0; padding: 2px 4px;color:white;background:#298cba;font-size:80%;\"><strong><span style=\"cursor:pointer;color:white;\" onclick=\"wp.customize.section( 'weaverx_general_options_level' ).focus();\">"
                . esc_html__('Options Level:', 'weaver-xtreme') . " {$msgpost}&nbsp;&nbsp;"
                . esc_html__('Interface:', 'weaver-xtreme') . " {$msginterface}</span></span>";
        }


        if (function_exists('weaverxplus_plugin_installed')) {
            $manager->add_section(
                new WeaverX_Customize_Plus_Section(
                    $manager,
                    'weaverx_plus_section',
                    array(
                        'title' => esc_html__('Thanks for installing Xtreme Plus.', 'weaver-xtreme'),
                        'pro_description' => $content
                    )
                )
            );
        } else {
            $manager->add_section(
                new WeaverX_Customize_Plus_Section(
                    $manager,
                    'weaverx_plus_section',
                    array(
                        'title' => esc_html__('Weaver Xtreme Plus', 'weaver-xtreme'),
                        'pro_text' => esc_html__('Get Plus', 'weaver-xtreme'),
                        'pro_url' => 'http://shop.weavertheme.com',
                        'pro_url_title' => esc_html__('Add over 100 new features to Weaver Xtreme with the Xtreme Plus plugin!', 'weaver-xtreme'),
                        'pro_description' => $content
                    )
                )
            );

        }

    }

    /**
     * Loads theme customizer CSS.
     *
     * @return void
     * @since  1.0.0
     * @access public
     */
    public function enqueue_control_scripts()
    {

        wp_enqueue_script('weaver-x-plus-customize-controls', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/customizer/trt-customize-pro/customize-controls.js'), array('customize-controls'));

        wp_enqueue_style('weaver-x-plus-customize-controls', get_theme_file_uri(WEAVERX_ADMIN_DIR . '/customizer/trt-customize-pro/customize-controls.css'));
    }
}


/**
 * Pro customizer section.
 * Based on trt-customize-pro
 *
 * @since  1.0.0
 * @access public
 */
if (class_exists('WP_Customize_Section')) {
    class WeaverX_Customize_Plus_Section extends WP_Customize_Section
    {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'weaverx-plus-add';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';
        public $pro_url_title = '';
        public $pro_description = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function json()
        {
            $json = parent::json();

            $json['pro_text'] = $this->pro_text;
            $json['pro_url'] = esc_url($this->pro_url);
            $json['pro_url_title'] = $this->pro_url_title;
            $json['pro_description'] = $this->pro_description;

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @return void
         * @since  1.0.0
         * @access public
         */
        protected function render_template()
        { ?>

            <li id="accordion-section-{{ data.id }}"
                class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

                <h3 class="accordion-section-title">
                    {{ data.title }}

                    <# if ( data.pro_text && data.pro_url ) { #>
                    <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank"
                       title="{{ data.pro_url_title }}">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
                <# if ( data.pro_description ) { #>
                <p>{{{ data.pro_description }}}</p>
                <# } #>
            </li>
        <?php }
    }


    WeaverX_Customize_Plus::get_instance();        // use trt-customize-pro class to load top menu item
}

function weaverx_options_level()
{    // current options level value
    global $wp_customize;

    if (isset($wp_customize) && !$wp_customize->is_theme_active())
        return WEAVERX_LEVEL_BEGINNER;
    else
        return get_theme_mod('_options_level');
}

function weaverx_options_interface()
{    // current options interface
    global $wp_customize;

    if (isset($wp_customize) && !$wp_customize->is_theme_active())
        return WEAVER_CUSTOMIZER_DEFAULT_INTERFACE;
    else
        return get_theme_mod('_options_interface');
}



