<?php

/**
 * Test course_date_to_formatted_dates() in functions.php
 * @covers        ::com\davidmichaelross\DavesWordPressLiveSearch\render_select_options
 * @backupGlobals disabled
 */
class RenderSelectOptionsTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * Test normal behavior, where the function is passed an associative array of values & labels
	 */
	public function test_render_string_and_assoc_array() {

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction( 'selected', array(
			'return_in_order' => array(
				'',
				'',
				'selected="selected"',
				'',
			),
		) );

		$expectedDom = new DomDocument();
		// 'down' has selected="" attribute
		$expectedDom->loadHtml( '<option value="up">Up</option><option value="right">Right</option><option value="down" selected="selected">Down</option><option value="left">Left</option>' );
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml( com\davidmichaelross\DavesWordPressLiveSearch\render_select_options( array(
			'up'    => 'Up',
			'right' => 'Right',
			'down'  => 'Down',
			'left'  => 'Left',
		), 'down' ) );
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals( $expectedDom->saveHTML(), $actualDom->saveHTML() );

	}

	public function test_render_null_and_assoc_array() {

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction( 'selected', array(
			'return' => '',
		) );

		$expectedDom = new DomDocument;
		// No selected="" attribute anywhere
		$expectedDom->loadHtml( '<option value="up">Up</option><option value="right">Right</option><option value="down">Down</option><option value="left">Left</option>' );
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml( com\davidmichaelross\DavesWordPressLiveSearch\render_select_options( array(
			'up'    => 'Up',
			'right' => 'Right',
			'down'  => 'Down',
			'left'  => 'Left',
		) ) );
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals( $expectedDom->saveHTML(), $actualDom->saveHTML() );

	}

	public function test_render_nothing_and_assoc_array() {

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction( 'selected', array(
			'return' => '',
		) );

		$expectedDom = new DomDocument;
		// No selected="" attribute anywhere
		$expectedDom->loadHtml( '<option value="up">Up</option><option value="right">Right</option><option value="down">Down</option><option value="left">Left</option>' );
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml( com\davidmichaelross\DavesWordPressLiveSearch\render_select_options( array(
			'up'    => 'Up',
			'right' => 'Right',
			'down'  => 'Down',
			'left'  => 'Left',
		) ) );
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals( $expectedDom->saveHTML(), $actualDom->saveHTML() );

	}

}