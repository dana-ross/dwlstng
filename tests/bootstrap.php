<?php

define( 'ABSPATH', '/var/www/wordpress/' );
define( 'DWLS_UNIT_TEST', true );

include realpath( __DIR__ . '/../defines.php' );
include realpath( __DIR__ . '/../inc/sanitize.php' );
include realpath( __DIR__ . '/../inc/front-end.php' );
include realpath( __DIR__ . '/../inc/admin.php' );
require realpath( __DIR__ . '/../vendor/autoload.php' );