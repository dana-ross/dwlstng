<?php

require_once '../inc/class-selectoptionsrenderer.php';

/**
 * Test course_date_to_formatted_dates() in functions.php
 * @covers SelectOptionsRenderer
 * @backupGlobals disabled
 */
class SelectOptionsRendererTest extends PHPUnit_Framework_TestCase {

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

		$option_renderer = new com\davidmichaelross\DavesWordPressLiveSearch\SelectOptionsRenderer( 'down' );

		$expectedDom = new DomDocument;
		// 'down' has selected="" attribute
		$expectedDom->loadHtml('<option value="up">Up</option><option value="right">Right</option><option value="down" selected="selected">Down</option><option value="left">Left</option>');
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml($option_renderer( array(
			'up' => 'Up',
			'right' => 'Right',
			'down' => 'Down',
			'left' => 'Left',
		) ));
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML());

	}

	public function test_render_null_and_assoc_array() {

		$option_renderer = new com\davidmichaelross\DavesWordPressLiveSearch\SelectOptionsRenderer( null );

		$expectedDom = new DomDocument;
		// No selected="" attribute anywhere
		$expectedDom->loadHtml('<option value="up">Up</option><option value="right">Right</option><option value="down">Down</option><option value="left">Left</option>');
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml($option_renderer( array(
			'up' => 'Up',
			'right' => 'Right',
			'down' => 'Down',
			'left' => 'Left',
		) ));
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML());

	}

	public function test_render_nothing_and_assoc_array() {

		$option_renderer = new com\davidmichaelross\DavesWordPressLiveSearch\SelectOptionsRenderer( /* default */ );

		$expectedDom = new DomDocument;
		// No selected="" attribute anywhere
		$expectedDom->loadHtml('<option value="up">Up</option><option value="right">Right</option><option value="down">Down</option><option value="left">Left</option>');
		$expectedDom->preserveWhiteSpace = false;

		$actualDom = new DomDocument();
		$actualDom->loadHtml($option_renderer( array(
			'up' => 'Up',
			'right' => 'Right',
			'down' => 'Down',
			'left' => 'Left',
		) ));
		$actualDom->preserveWhiteSpace = false;

		$this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML());

	}

	public function test_travis_ci_always_fail() {
		$this->assertEquals(true, false);
	}

}