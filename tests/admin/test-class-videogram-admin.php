<?php
/**
 * Videogram admin class test.
 *
 * @package    Videogram
 */

/**
 * Test of the admin-specific functionality of the plugin.
 *
 * @package    Videogram
 */
class Test_Videogram_Admin extends WP_UnitTestCase {

	/**
	 * Check if video post type exists in global list of post types.
	 */
	public function test_register_post_types() {

		$post_types = get_post_types();
		$this->assertArrayHasKey( 'vgvideo', $post_types );

	}

	/**
	 * Check if video category exists in global list of taxonomies.
	 */
	public function test_register_taxonomies() {

		$taxonomies = get_taxonomies();
		$this->assertArrayHasKey( 'video-category', $taxonomies );
		
	}

	/**
	 * Check if defined menus exist.
	 */
	public function test_register_menus() {

		$menus = get_registered_nav_menus();
		$this->assertArrayHasKey( 'videogram_header_main', $menus );

	}

}
