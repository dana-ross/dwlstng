<?php

/*
Plugin Name: DWLS TNG
Description:
Version: 1.0
Author: Dave Ross
Author URI: http://davidmichaelross.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( "Please don't try to access this file directly." );
}

define( 'DWLS_TNG_VERSION', '0.1.1' );
define( 'DWLS_TNG_URL', plugin_dir_url( __FILE__ ) );
define( 'DWLS_TNG_PATH', dirname( __FILE__ ) );

include DWLS_TNG_PATH . '/inc/class-daveswordpresslivesearchfrontend.php';

if ( is_admin() || ( defined( 'DOING_DWLS_UNIT_TESTS' ) && DOING_DWLS_UNIT_TESTS ) ) {
	include DWLS_TNG_PATH . '/inc/class-daveswordpresslivesearchadmin.php';
}
