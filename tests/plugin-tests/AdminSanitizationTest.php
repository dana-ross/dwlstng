<?php

class AdminSanitizationTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string
	 */
	public function test_validate_boolean_string_true() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string( 'true' ),
			'true'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string
	 */
	public function test_validate_boolean_string_false() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string( 'false' ),
			'false'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string
	 */
	public function test_validate_boolean_string_actual_boolean_true() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string( true ),
			'false'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction
	 */
	public function test_validate_results_direction_up() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction( 'up' ),
			'up'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction
	 */
	public function test_validate_results_direction_down() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction( 'down' ),
			'down'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction
	 */
	public function test_validate_results_direction_bad_string() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction( 'test' ),
			'down'
		);
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction
	 */
	public function test_validate_results_direction_array() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\validate_results_direction( array( 'up' ) ),
			'down'
		);
	}

}