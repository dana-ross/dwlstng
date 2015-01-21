<?php

/**
 * Test replacement for sanitize_hex_color in WordPress core
 * @covers        ::com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color
 * @backupGlobals disabled
 */
class SanitizeHexColorTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function test_valid_hex_color() {
		$this->assertEquals( '#11aa33', com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( '#11aa33' ) );
	}

	public function test_valid_short_hex_color() {
		$this->assertEquals( '#1a3', com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( '#1a3' ) );
	}

	public function test_not_hex() {
		$this->assertEmpty( com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( '#11gg33' ) );
	}

	public function test_not_a_color() {
		$this->assertEmpty( com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( 'test' ) );
	}

	public function test_empty_string() {
		$this->assertEmpty( com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( '' ) );
	}

	public function test_null() {
		$this->assertEmpty( com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( null ) );
	}

	public function test_missing_hash() {
		$this->assertEmpty( com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color( '11aa33' ) );
	}

}
