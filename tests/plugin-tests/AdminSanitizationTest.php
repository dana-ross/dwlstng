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

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction('checked', array(
			'times' => 1,
			'return' => 'checked="checked"',
		));
		\WP_Mock::wpPassthruFunction('wp_kses');

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

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction('checked', array(
			'return_in_order' => array(
				'',
				'checked="checked"',
			),
		));
		\WP_Mock::wpPassthruFunction('wp_kses');

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

		\WP_Mock::wpPassthruFunction( 'esc_attr' );
		\WP_Mock::wpPassthruFunction( 'esc_html' );
		\WP_Mock::wpFunction('checked', array(
			'times' => 1,
			'return' => 'checked="checked"',
		));
		\WP_Mock::wpPassthruFunction('wp_kses');

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
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\text_field
	 */
	public function test_text_field() {

		\WP_Mock::wpPassthruFunction( 'esc_attr' );

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\text_field( array(
			'type'  => 'text',
			'name'  => 'test_name',
			'id'    => 'test_id',
			'value' => 'test_value',
			'class' => 'test_class',
		) );
		$text_field_html = ob_get_clean();

		$this->assertXmlStringEqualsXmlString(
			'<input type="text" id="test_id" name="test_name" value="test_value" class="test_class" />',
			$text_field_html
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\text_field
	 */
	public function test_text_field_number() {

		\WP_Mock::wpPassthruFunction( 'esc_attr' );

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\text_field( array(
			'type'  => 'number',
			'name'  => 'test_name',
			'id'    => 'test_id',
			'value' => 'test_value',
			'class' => 'test_class',
		) );
		$text_field_html = ob_get_clean();

		$this->assertXmlStringEqualsXmlString(
			'<input type="number" id="test_id" name="test_name" value="test_value" class="test_class" />',
			$text_field_html
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\default_id_from_name
	 */
	public function test_default_id_from_name() {
		$options = com\davidmichaelross\DavesWordPressLiveSearch\default_id_from_name( array( 'name' => 'test' ) );

		$this->assertArrayHasKey( 'id', $options );

		$this->assertEquals(
			$options['id'],
			'test'
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes
	 */
	public function test_default_input_field_attributes() {

		$this->assertArrayHasKey(
			'name',
			com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes( array() )
		);

		$this->assertArrayHasKey(
			'class',
			com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes( array() )
		);

		$this->assertArrayHasKey(
			'value',
			com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes( array() )
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes
	 */
	public function test_default_input_field_attributes_extra() {

		$this->assertArrayHasKey(
			'marco',
			com\davidmichaelross\DavesWordPressLiveSearch\default_input_field_attributes( array( 'marco' => 'polo' ) )
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\select_field
	 */
	public function test_select_field() {

		\WP_Mock::wpFunction('selected', array(
			'return' => 'selected="selected"',
		));

		\WP_Mock::wpPassthruFunction('wp_kses');
		\WP_Mock::wpPassthruFunction('esc_html');
		\WP_Mock::wpPassthruFunction('esc_attr');

		ob_start();
		com\davidmichaelross\DavesWordPressLiveSearch\select_field( array(
			'id'      => 'test_id',
			'name'    => 'test_name',
			'options' => array( 'test_value' => 'test_label' ),
			'value'   => 'test_value',
		) );
		$select_field_html = ob_get_clean();

		$this->assertXmlStringEqualsXmlString(
			'<select id="test_id" name="test_name">' .
			'<option value="test_value" selected="selected">test_label</option>' .
			'</select>',
			$select_field_html
		);

	}
}