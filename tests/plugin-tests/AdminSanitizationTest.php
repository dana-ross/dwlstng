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

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field
	 */
	public function test_checkbox_field_checked() {

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field( array(
			'name'  => 'test_name',
			'id'    => 'test_id',
			'class' => 'test_class',
			'value' => 'true',
		) );
		$checkbox_html = '<div>' . ob_get_clean() . '</div>';

		$this->assertXmlStringEqualsXmlString(
			'<div>' .
			'<input type="hidden" name="test_name" id="test_id" value="false" />' .
			'<input type="checkbox" name="test_name" id="test_id" class="test_class" value="true" checked="checked" />' .
			'</div>',
			$checkbox_html
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field
	 */
	public function test_checkbox_field_not_checked() {

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field( array(
			'name'  => 'test_name',
			'id'    => 'test_id',
			'class' => 'test_class',
			'value' => 'false',
		) );
		$checkbox_html = '<div>' . ob_get_clean() . '</div>';

		$this->assertXmlStringEqualsXmlString(
			'<div>' .
			'<input type="hidden" name="test_name" id="test_id" value="false" />' .
			'<input type="checkbox" name="test_name" id="test_id" class="test_class" value="true" />' .
			'</div>',
			$checkbox_html
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field
	 */
	public function test_checkbox_field_no_id() {

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\checkbox_field( array(
			'name'  => 'test_name',
			'class' => 'test_class',
			'value' => 'true',
		) );
		$checkbox_html = '<div>' . ob_get_clean() . '</div>';

		$this->assertXmlStringEqualsXmlString(
			'<div>' .
			'<input type="hidden" name="test_name" id="test_name" value="false" />' .
			'<input type="checkbox" name="test_name" id="test_name" class="test_class" value="true" checked="checked" />' .
			'</div>',
			$checkbox_html
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\default_id_from_name
	 */
	public function test_default_id_from_name() {
		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\default_id_from_name(array('name' => 'test'))['id'],
			'test'
		);
	}

}