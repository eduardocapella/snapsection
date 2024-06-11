<?php 
namespace Cwss\Classes;

class PluginInit {

    public $settings = null;

    function __construct() {
        // cria uma instância da classe SnapSectionSettingsPage
        // garanto que todas as Classes sejam instanciadas apenas uma vez
        // e posso chamar a classe SnapSectionSettingsPage() chamando a função cwss()
        $this->settings = new SnapSectionSettingsPage();
        
        add_action( 'wp_enqueue_scripts', array( $this, 'cwss_enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'cwss_enqueue_scripts' ) );

    }

    // enqueue SnapSection styles
    function cwss_enqueue_styles() {
        if( is_admin() || is_archive() || is_search() ) {
            return;
        }
        wp_enqueue_style( 'cwss-css', CSS_URL . 'style.min.css', array(), PLUGIN_VERSION );
    }

    // enqueue SnapSection scripts
    function cwss_enqueue_scripts() {
        if( is_admin() || is_archive() || is_search() ) {
            return;
        }

        wp_enqueue_script( 'cwss-js', JS_URL . 'script.min.js', array( 'jquery' ), PLUGIN_VERSION, 'true' );


        $snapSectionDynamic = get_option( 'snapsection_dynamic' );
        print_r( '<pre>' );
        print_r( $snapSectionDynamic );
        print_r( '</pre>' );


        wp_localize_script( 'cwss-js', 'cwssData', 
            array( 
                'homeUrl'    => home_url(),
                'currentUrl' => get_the_permalink(),
                'iconSVG'    => $snapSectionDynamic['icon'],
                'pluginURL'  => plugin_dir_url( __FILE__ ),
                'iconSize'   => $snapSectionDynamic['size']
            ) 
        );
    }

    // get_option( string $option, mixed $default_value = false ): mixed
    // o 1º parâmetro é obrigatório pois ele não tem um valor atribuído
    // o 2º parâmetro tem o valor false atribuído, por isso ele não é obrigatório. Caso não passem esse parâmetro, ele vai assumir o valor false
    // mixed recebe qualquer tipo de dado. 
    // : o que vem depois dos parênteses representa o que a função retorna
    // :mixed retorna um tipo qualquer de dado


    function enqueue_admin_scripts( $hook ) {
        
        // Since I used the add_menu_page() function, the settings page slug must have the prefix 'toplevel_page_'
        if ( 'toplevel_page_snapsection' != $hook ) {
            return;
        }

        // Adicione o script de seleção de cores
        wp_enqueue_script( 'wp-color-picker' );

        // Adicione o estilo de seleção de cores
        wp_enqueue_style( 'wp-color-picker' );

    }

}