<?php 
namespace Cwss\Classes;

class Options {
    // privacidade: private or public
    public function getOption( $name ) {
    // static function cwss_options() {
        $options = get_option( 'snapsection_dynamic', [] );
        return $options[ $name ] ?? null;
    }

}