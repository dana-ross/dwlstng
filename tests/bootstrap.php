<?php

define( 'ABSPATH', '/var/www/wordpress/' );
define( 'DWLS_UNIT_TEST', true );

include realpath( __DIR__ . '/../inc/sanitize.php' );
include realpath( __DIR__ . '/../inc/class-daveswordpresslivesearchfrontend.php' );
include realpath( __DIR__ . '/../inc/daveswordpresslivesearchadmin.php' );
require realpath( __DIR__ . '/../vendor/autoload.php' );