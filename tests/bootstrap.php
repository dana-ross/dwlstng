<?php

define('ABSPATH', '/var/www/wordpress/');
define('DWLS_UNIT_TEST', true);

include 'inc/sanitize.php';
include 'inc/class-daveswordpresslivesearchfrontend.php';
include 'inc/daveswordpresslivesearchadmin.php';
require 'vendor/autoload.php';