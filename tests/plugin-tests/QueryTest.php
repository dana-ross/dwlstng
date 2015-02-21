<?php

class QueryTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
		global $wp_query;
		unset( $wp_query );
	}

	public function tearDown() {
		\WP_Mock::tearDown();
		global $wp_query;
		unset( $wp_query );
	}

	/**
	 * @covers ::com\davidmichaelross\DavesWordPressLiveSearch\do_search
	 */
	public function test_do_search() {

		global $wp_query;

		$mock_post = $this->mock_post();

		$wp_query = Mockery::mock( 'WP_Query' );
		$wp_query->shouldReceive( 'get_posts' )->once()->andReturn( array( $mock_post ) );

		\WP_Mock::wpFunction( 'get_permalink', array(
			'tries'  => 1,
			'return' => 'http://www.example.com/blog/1',
		) );
		\WP_Mock::wpFunction( 'get_post_thumbnail' );
		\WP_Mock::wpPassthruFunction( 'wp_trim_words' );
		\WP_Mock::wpFunction( 'get_post_meta', array( 'tries' => 1, 'return' => '' ) );
		\WP_Mock::wpFunction( 'wp_is_post_revision', array( 'tries' => 1, 'return' => false ) );
		\WP_Mock::wpFunction( 'get_post' );
		\WP_Mock::wpFunction( 'get_option', array( 'tries' => 1, 'return' => false ) );
		\WP_Mock::wpFunction( 'update_post_meta', array( 'tries' => 1, 'return' => null ) );

		$search_results      = com\davidmichaelross\DavesWordPressLiveSearch\do_search();
		$first_search_result = array_pop( $search_results );

		$this->assertEquals(
			$this->mock_post()->ID,
			$first_search_result['ID']
		);

		$this->assertEquals(
			$this->mock_post()->post_title,
			$first_search_result['title']
		);

		$this->assertEquals(
			$this->mock_post()->post_content,
			$first_search_result['excerpt']
		);

		$this->assertEquals(
			$this->mock_post()->post_date,
			$first_search_result['date']
		);

		$this->assertEquals(
			$this->mock_post()->post_type,
			$first_search_result['post_type']
		);

	}

	/**
	 * @return WP_Post
	 */
	public function mock_post() {

		$post               = Mockery::mock( 'WP_Post' );
		$post->ID           = 1234;
		$post->post_title   = 'Hello World';
		$post->post_content = 'Lorem ipsum dolor sit amet.';
		$post->post_date    = '2015-01-24';
		$post->post_type    = 'post';

		return $post;

	}

}