<?php

define('ABSPATH', '/var/www/wordpress/');
define('DWLS_UNIT_TEST', true);

include __DIR__ . '/../inc/sanitize.php';
include __DIR__ . '/../inc/class-daveswordpresslivesearchfrontend.php';
include __DIR__ . '/../inc/daveswordpresslivesearchadmin.php';
require __DIR__ . '/../vendor/autoload.php';