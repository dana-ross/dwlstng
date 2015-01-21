<?php

class DavesWordPressLiveSearchFrontEndTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\rewrite_endpoint
	 */
	public function test_rewrite_endpoint() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\rewrite_endpoint(),
			com\davidmichaelross\DavesWordPressLiveSearch\FRONT_END_ENDPOINT . '/([^/]*)'
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\rewrite_query_string
	 */
	public function test_rewrite_query_string() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\rewrite_query_string(),
			'index.php?' . com\davidmichaelross\DavesWordPressLiveSearch\FRONT_END_ENDPOINT . '=$matches[1]'
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\add_query_vars
	 */
	public function test_add_query_vars() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\add_query_vars( array(
				'a',
				'b',
			) ),
			array( 'a', 'b', com\davidmichaelross\DavesWordPressLiveSearch\FRONT_END_ENDPOINT )
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\first_img
	 */
	public function test_first_img_valid() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\first_img(
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper est ac lacinia convallis. <img src="test.jpg" />Nullam tortor dolor, viverra ac turpis eget, luctus iaculis orci. Sed fringilla quis libero id interdum. Etiam elementum, turpis quis aliquet aliquet, est leo imperdiet dui, ac vestibulum est nulla eget nisi. Duis rhoncus orci eget nulla luctus tempus. Etiam augue lacus, pharetra in libero non, molestie dignissim sapien. Ut ultrices accumsan massa vitae consectetur. Maecenas ut lobortis sem. Nulla blandit pulvinar gravida. Donec volutpat dui ipsum, eget porttitor nisi egestas sit amet.'
			),
			'test.jpg'
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\first_img
	 */
	public function test_first_img_missing() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\first_img(
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper est ac lacinia convallis. Nullam tortor dolor, viverra ac turpis eget, luctus iaculis orci. Sed fringilla quis libero id interdum. Etiam elementum, turpis quis aliquet aliquet, est leo imperdiet dui, ac vestibulum est nulla eget nisi. Duis rhoncus orci eget nulla luctus tempus. Etiam augue lacus, pharetra in libero non, molestie dignissim sapien. Ut ultrices accumsan massa vitae consectetur. Maecenas ut lobortis sem. Nulla blandit pulvinar gravida. Donec volutpat dui ipsum, eget porttitor nisi egestas sit amet.'
			),
			''
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\first_img
	 */
	public function test_first_two_imgs() {

		$this->assertEquals(
			com\davidmichaelross\DavesWordPressLiveSearch\first_img(
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper est ac lacinia convallis. <img src="test.jpg" />Nullam tortor dolor, viverra ac turpis eget, luctus iaculis orci. Sed fringilla quis libero id interdum. Etiam elementum, turpis quis aliquet aliquet, est leo imperdiet dui, ac vestibulum est nulla eget nisi. Duis rhoncus orci eget nulla luctus tempus. Etiam augue lacus, pharetra in libero non, molestie dignissim sapien. Ut ultrices accumsan massa vitae consectetur. Maecenas ut lobortis sem. Nulla blandit pulvinar <img src="test2.gif" />gravida. Donec volutpat dui ipsum, eget porttitor nisi egestas sit amet.'
			),
			'test.jpg'
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\parse_request
	 */
	public function test_parse_request() {

		global $wp_query;
		$wp_query = new stdClass();
		$wp_query->query_vars = array();
		$wp_query->query_vars[ com\davidmichaelross\DavesWordPressLiveSearch\FRONT_END_ENDPOINT ] = 'Supercalifragilisticexpialidocious';

		$this->assertEquals(
			'Supercalifragilisticexpialidocious',
			com\davidmichaelross\DavesWordPressLiveSearch\parse_request($wp_query)->query_vars['s']
		);

	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\parse_request
	 */
	public function test_parse_request_no_term() {

		global $wp_query;
		$wp_query = new stdClass();
		$wp_query->query_vars = array();

		$this->assertArrayNotHasKey(
			's',
			com\davidmichaelross\DavesWordPressLiveSearch\parse_request($wp_query)->query_vars
		);

	}

}
