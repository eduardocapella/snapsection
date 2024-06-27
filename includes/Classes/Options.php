<?php
namespace Cwss\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Retrieves a specific option from the 'snapsection_dynamic' options array.
 *
 * @return mixed|null The value of the specified option, or null if the option does not exist.
 */
class Options {
    // privacidade: private or public
    public function getOption( $name ) {
    // static function cwss_options() {
        $options = get_option( 'snapsection_dynamic', [] );
        return $options[ $name ] ?? null;
    }

}