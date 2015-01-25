<?php

//$_tests_dir = getenv( 'WP_TESTS_DIR' );
//if ( ! $_tests_dir ) {
//	$_tests_dir = '/tmp/wordpress-tests-lib';
//}
//
//$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
//
//require_once rtrim( $_tests_dir, '/' ) . '/includes/functions.php';
//
//define('DOING_DWLS_UNIT_TESTS', true);
//
//function _manually_load_plugin() {
//	require( dirname( __FILE__ ) . '/../dwlstng.php' );
//}
//
//tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );
//
//require( rtrim( $_tests_dir, '/' ) . '/includes/bootstrap.php' );
define('ABSPATH', '/var/www/wordpress/');
define('DWLS_UNIT_TEST', true);
include 'inc/class-daveswordpresslivesearchfrontend.php';
include 'inc/daveswordpresslivesearchadmin.php';
require 'vendor/autoload.php';