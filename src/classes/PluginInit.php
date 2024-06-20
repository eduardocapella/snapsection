<?php 
namespace Cwss\Classes;

class PluginInit {

    public $settings = null;
    public $options = null;

    function __construct() {

        $this->settings = new SnapSectionSettingsPage();

        $this->options = new Options();

        add_action( 'wp_enqueue_scripts', array( $this, 'cwss_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'cwss_enqueue_scripts' ) );

        add_action( 'wp_head', array( $this, 'addCssVars' ) );

    }

    // enqueue SnapSection styles
    function cwss_enqueue_styles() {
        if( is_admin() || is_archive() || is_search() ) {
            return;
        }
        wp_enqueue_style( 'cwss-css', CWSS_CSS_URL . 'style.min.css', array(), CWSS_PLUGIN_VERSION );

    }

    function addCssVars() { ?>
        <style>
            :root {
                --cwss-icon-color: <?php echo esc_html( cwss()->options->getOption( 'color' ) ) ?? '#0099FF' ?> !important;
            }
        </style>
        <!-- Snap Section CSS -->
    <?php }

    // enqueue SnapSection scripts
    function cwss_enqueue_scripts() {
        if( is_admin() || is_archive() || is_search() ) {
            return;
        }

        wp_enqueue_script( 'cwss-js', CWSS_JS_URL . 'script.min.js', array( 'jquery' ), CWSS_PLUGIN_VERSION, 'true' );
        

        wp_localize_script( 'cwss-js', 'cwssData', 
            array( 
                'homeUrl'    => home_url(),
                'currentUrl' => get_the_permalink(),
                'iconSVG'    => cwss()->options->getOption( 'icon' ) ?? 'option1',
                'pluginURL'  => plugin_dir_url( __FILE__ ),
                'iconSize'   => cwss()->options->getOption( 'size' ) ?? '.7',
                'iconText'   => cwss()->options->getOption( 'text' ) ?? 'Copied!'
            ) 
        );
    }

    function enqueue_admin_scripts( $hook ) {
        
        // Since I used the add_menu_page() function, the settings page slug must have the prefix 'toplevel_page_'
        if ( 'toplevel_page_snapsection' != $hook ) {
            return;
        }

        // Adicione o script de seleção de cores
        wp_enqueue_script( 'wp-color-picker' );

        // Adicione o estilo de seleção de cores
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_style( 'cwss-admin-css', CWSS_CSS_URL . 'style-admin.min.css', array(), CWSS_PLUGIN_VERSION );
    }

}