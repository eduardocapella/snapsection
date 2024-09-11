<?php
/*
 * Plugin Name:       SnapSection
 * Plugin URI:        https://www.snapsection.com
 * Description:       SnapSection allows users to swift share specific sections from your article or blog post.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Eduardo Capella
 * Author URI:        https://capellaweb.com.br
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       snapsection
 * Domain Path:       /languages
 * Requires Plugins:  
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Constants
define ( 'CWSS_PLUGIN_VERSION', '1.0.2' );

define ( 'CWSS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define ( 'CWSS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define ( 'CWSS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define ( 'CWSS_CSS_URL', CWSS_PLUGIN_URL . 'dist/css/'  );
define ( 'CWSS_JS_URL', CWSS_PLUGIN_URL . 'dist/js/' );


// Include Composer's Autoloader if file exist
$autoload_file = dirname( __FILE__ ) . '/vendor/autoload.php';
if( file_exists( $autoload_file ) ) {
    require_once $autoload_file;
}

/**
* Creates a Container for the Class PluginInit
*
* @since 1.0.0
* @return instance of PluginInit
*/
function snapSection() {
    static $instance = null;
    if ( is_null( $instance ) ) {
        $instance = new \Cwss\Classes\PluginInit();
    }
    return $instance;
}
snapSection();
