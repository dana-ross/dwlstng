<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

if ( ! defined( 'DWLS_UNIT_TEST' ) ) {
	register_front_end_hooks();
}

if ( ! defined( 'DWLS_UNIT_TEST' ) && is_admin() ) {
	register_admin_hooks();
}
