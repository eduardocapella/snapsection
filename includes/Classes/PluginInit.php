<?php 
namespace Cwss\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Initializes the SnapSection plugin.
 *  
 * @since 1.0.0
 */
class PluginInit {
    /**
     *  Holds the instance of the SnapSections Settings Class for the plugin.
     */
    public $settings = null;

    /**
     *  Holds the instance of the Class Options for the plugin.
     */
    public $options = null;

    public function __construct() {
        $this->settings = new SettingsPage();

        $this->options = new Options();

        add_action( 'init', array( $this, 'cwss_load_textdomain' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'cwss_enqueue_scripts' ) );

        add_action( 'wp_head', array( $this, 'add_css_vars' ) );
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @return void
     */
    public function cwss_load_textdomain() {
        load_plugin_textdomain( 'snap-section', false, dirname( CWSS_PLUGIN_BASENAME ) . '/languages' );
    }

    /**
     * Add CSS variables to the head of the document
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function add_css_vars() { ?>
        <style>
            :root {
                --cwss-icon-color: <?php echo esc_html( snapSection()->options->getOption( 'color' ) ?? '#0099FF' ) ?> !important;
            }
        </style>
    <?php }

    // enqueue SnapSection scripts
    public function cwss_enqueue_scripts() {
        if( is_admin() || is_archive() || is_search() ) {
            return;
        }
        // Styles
        wp_enqueue_style( 'cwss-css', CWSS_CSS_URL . 'style.min.css', array(), CWSS_PLUGIN_VERSION );

        // Scripts
        wp_enqueue_script( 'cwss-js', CWSS_JS_URL . 'script.min.js', array( 'jquery' ), CWSS_PLUGIN_VERSION, 'true' );
        
        // Localize script
        wp_localize_script( 'cwss-js', 'cwssData', 
            array( 
                'homeUrl'    => home_url(),
                'currentUrl' => get_the_permalink(),
                'iconSVG'    => snapSection()->options->getOption( 'icon' ) ?? 'option1',
                'pluginURL'  => plugin_dir_url( __FILE__ ),
                'iconSize'   => snapSection()->options->getOption( 'size' ) ?? '.7',
                'iconText'   => snapSection()->options->getOption( 'text' ) ?? esc_html__( 'Copied!' )
            ) 
        );
    }

    public function enqueue_admin_scripts( $hook ) {
        if ( 'settings_page_snapsection' != $hook ) {
            return;
        }

        // WordPress Color Picker library script
        wp_enqueue_script( 'wp-color-picker' );

        // WordPress Color Picker library style
        wp_enqueue_style( 'wp-color-picker' );

        // SnapSection Admin CSS
        wp_enqueue_style( 'cwss-admin-css', CWSS_CSS_URL . 'style-admin.min.css', array(), CWSS_PLUGIN_VERSION );
    }

}