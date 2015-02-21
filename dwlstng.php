<?php

/*
Plugin Name: DWLS TNG
Description:
Version: 1.0
Author: Dave Ross
Author URI: http://davidmichaelross.com
*/

include __DIR__ . '/defines.php';
include __DIR__ . '/inc/sanitize.php';
include __DIR__ . '/inc/front-end.php';

if ( is_admin() || ( defined( 'DOING_DWLS_UNIT_TESTS' ) && DOING_DWLS_UNIT_TESTS ) ) {
	include DWLS_TNG_PATH . '/inc/admin.php';
}
