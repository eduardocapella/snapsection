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

Namespace Cwss;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Constants
define ( 'PLUGIN_VERSION', '1.0.1' );

define ( 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define ( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define ( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define ( 'CSS_URL', PLUGIN_URL . 'src/css/'  );
define ( 'JS_URL', PLUGIN_URL . 'src/js/' );


// Include Composer's Autoloader if file exist
$autoload_file = dirname( __FILE__ ) . '/vendor/autoload.php';
if( file_exists( $autoload_file ) ) {
    require_once $autoload_file;
}


// quando mudar o nome de uma das opções, tem que deletar a antiga. Quando se cria uma linha só (array ou json), o índice depreciado/deletado não vai pro banco de dados

$snapSectionDynamic = get_option( 'snapsection_dynamic' ); ?>

<style>
    :root {
        --icon-color: <?php echo $snapSectionDynamic[ 'color' ] ?> !important;
        --icon-top: <?php echo $snapSectionDynamic[ 'top' ] ?> !important;
        }
</style>


<?php function cwss() {
    // static é uma palavra mágica do PHP que mantém o valor da variável entre as chamadas da função
    // essa variável é usada para armazenar a instância da classe dentro dessa função
    static $instance = null;
    if ( is_null( $instance ) ) {
        $instance = new Classes\PluginInit();
    }
    return $instance;
}

cwss();

// to create only one row in the database, use get_option() only one time and use an array as the second parameter
// add_action( 'init', function() {

//     $args = array(
//         'icon'  => 'icon1.svg',
//         'color' => '#0099FF',
//         'top'   => '5',
//         'size'  => '1'
//     );

//     // get_option( 'snap_section_dynamic', array(
//     //     'icon'  => 'icon1.svg',
//     //     'color' => '#FF0000',
//     //     'top'   => '10',
//     //     'size'  => '1'
//     // ));

//     update_option( 'snap_section_dynamic', $args );

//     // colocar isso no uninstall.php
//     // delete_option( 'snap_section_dynamic' );

// });

// function my_plugin_activation() {
    // add_option( 'snapsection_icon_color', '#0099FF' );
    // add_option( 'snapsection_icon_top', '0' );
    // add_option( 'snapsection_icon_size', '1' );

    // salvar quando o plugin foi ativado, por exemplo, faz sentido
    // $activationDate = date( 'Y-m-d H:i:s' );
    //  dá pra adicionar essa data como internal, o que significa que é salvo para uso interno, mas não é exibido para o usuário
    // exemplo: add_option( 'snapsection_activation_date_internal', $activationDate, '', 'no' );
// }
// register_activation_hook( __FILE__, array( 'Cwss\SnapSectionSettinsPage', 'field_top_position_callback' ) );
// o WordPress executa o callback em outro arquivo, por isso que precisamos do caminho completo da casa