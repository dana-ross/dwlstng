<?php if ( !defined( 'ABSPATH' ) ) {
	die( "Cannot access files directly." );
} ?>

<div class="wrap">
	<h2><?php _e( "Dave's WordPress Live Search", 'dwls' ); ?></h2>

	<form method="post" action="">
		<?php
		if ( function_exists( 'wp_nonce_field' ) ) {
			wp_nonce_field( 'daves-wordpress-live-search-config' );
		}
		?>

		<table class="form-table">
			<tbody>
