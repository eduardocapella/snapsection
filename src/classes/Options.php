<?php 
namespace Cwss\Classes;

class Options {
    // privacidade: private or public
    public static function getOption( $name ) {
    // static function cwss_options() {
        $options = get_option( 'snapsection_dynamic' );
        return $options[ $name ];
        // return $options;
    }

}