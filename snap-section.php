<?php
/*
 * Plugin Name:       Snap Section
 * Plugin URI:        https://capellaweb.com.br/plugins/snap-section/
 * Description:       SnapSection is a WordPress plugin that allows you to share a section of your article quickly.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Eduardo Capella
 * Author URI:        https://capellaweb.com.br
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       snap-section
 * Domain Path:       /languages
 * Requires Plugins:  
 */

Namespace Main;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Constants
define ( '__CWSS_VERSION__', '1.0.0' );



// Include Composer's Autoloader if file exist
$autoload_file = dirname( __FILE__ ) . '/vendor/autoload.php';
if( file_exists( $autoload_file ) ) {
    require_once $autoload_file;
}

// enqueue SnapSection scripts
function cwss_enqueue_scripts() {
    if( is_admin() || is_archive() || is_search() ) {
        return;
    }

    wp_enqueue_script( 'cwss-js', plugin_dir_url( __FILE__ ) . 'src/js/script.min.js', array( 'jquery' ), __CWSS_VERSION__, 'true' );

    wp_localize_script( 'cwss-js', 'cwssData', 
    array( 
        'homeUrl'    => home_url(),
        'currentUrl' => get_the_permalink(),
        'pluginURL'  => plugin_dir_url( __FILE__ )
        ) 
    );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\cwss_enqueue_scripts' );


// enqueue SnapSection styles
function cwss_enqueue_styles() {
    if( is_admin() || is_archive() || is_search() ) {
        return;
    }
    wp_enqueue_style( 'cwss-css', plugin_dir_url( __FILE__ ) . 'src/css/style.min.css', array(), __CWSS_VERSION__ );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\cwss_enqueue_styles' );

// if( !is_admin() && !is_archive() && !is_search() ) {
//     add_action( 'wp_enqueue_scripts', 'cwss_enqueue_styles' );
// }


add_filter( 'the_content', __NAMESPACE__ . '\add_id_to_h3' );

function add_id_to_h3( $content ) {
    $dom = new \DOMDocument();
    @$dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
    $h3s = $dom->getElementsByTagName( 'h3' );

    $i = 0;
    foreach ( $h3s as $h3 ) {
        if ( $h3->hasAttribute( 'id' ) ) {
            continue;
        } else {
            $h3Text = $h3->nodeValue;
            $h3Text = sanitize_title( $h3Text );
            $h3->setAttribute( 'id', $h3Text );
        }
    }

    $html = $dom->saveHTML();
    return $html;
}

