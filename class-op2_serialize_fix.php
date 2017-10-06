<?php

class Op_Serialize_Fix {

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since   1.0.0
     *
     * @const   string
     */
    const VERSION = '1.1.0';

    /**
     * Unique identifier for your plugin.
     *
     * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
     * match the Text Domain file header in the main plugin file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_slug = 'op-serialize-fix';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    protected $layout_dir = 'inc/install_templates/';

    /**
     * Initialize the plugin by setting localization, filters, and administration functions.
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        add_action('init', array($this, 'load_plugin_textdomain' ) );
        add_action('admin_menu', array($this, 'add_plugin_admin_menu' ) );
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        $domain = $this->plugin_slug;
        $locale = apply_filters('plugin_locale', get_locale(), $domain );

        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain($domain, FALSE, basename(dirname(__FILE__ ) ) . '/lang/' );
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {
        $this->plugin_screen_hook_suffix = add_management_page(
            __('Op Serialize fix', $this->plugin_slug ),
            __('Op Serialize fix', $this->plugin_slug ),
            'update_core',
            $this->plugin_slug,
            array($this, 'display_plugin_admin_page' )
        );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page()
    {
        if (isset($_POST['opfix'])) {
            $this->fixHeaders();
        }

        include_once('views/admin.php' );
    }

    protected function fixHeaders()
    {
        global $wpdb;

        $opSettings = $wpdb->get_results(
            "
            SELECT * FROM $wpdb->postmeta
              WHERE meta_key 
              LIKE '_optimizepress_%' 
              AND meta_value LIKE 's:%' 
            "
        );

        foreach ($opSettings as $setting) {
            // we first look for s:1:"1"; problem and fix that
            if ($setting->meta_key == '_optimizepress_theme' && $setting->meta_value == 's:1:"1";') {
                $this->fix($setting->meta_value, $setting->meta_id);
            }
            if (!empty($setting->meta_value)) {
                $this->fix($setting->meta_value, $setting->meta_id);
            }
        }

        return '';
    }

    public function fixTheme($metaId)
    {
        global $wpdb;

        $output = 's:51:"a:2:{s:4:"type";s:9:"marketing";s:3:"dir";s:1:"1";}";';

        $wpdb->update(
            $wpdb->prefix . 'postmeta',
            array(
                'meta_value' => $output
            ),
            array( 'meta_id' => $metaId ),
            array(
                '%s'
            ),
            array( '%d' )
        );
    }

    public function fix($data, $metaId)
    {
        global $wpdb;

        if ($data == 's:1:"1";') {
            $output = 's:51:"a:2:{s:4:"type";s:9:"marketing";s:3:"dir";s:1:"1";}";';

            $wpdb->update(
                $wpdb->prefix . 'postmeta',
                array(
                    'meta_value' => $output
                ),
                array( 'meta_id' => $metaId ),
                array(
                    '%s'
                ),
                array( '%d' )
            );

            $data = $output;
        }

        $output = preg_replace_callback(
            '/^(s:)(\d+)(:)(")(.*)(")(.*)$/',
            function($match) {
                return $match[1] . strlen($match[5]) . $match[3] . $match[4] . $match[5] . $match[6] . $match[7];
            },
            $data
        );

        $wpdb->update(
            $wpdb->prefix . 'postmeta',
            array(
                'meta_value' => $output
            ),
            array( 'meta_id' => $metaId ),
            array(
                '%s'
            ),
            array( '%d' )
        );
    }

    public function slug()
    {
        return $this->plugin_slug;
    }


}
