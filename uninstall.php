<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

$option_name = 'snap_section_dynamic';
delete_option( $option_name );