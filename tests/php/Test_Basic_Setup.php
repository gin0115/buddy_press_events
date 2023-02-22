<?php

/**
 * Tests that all basic systems are loaded.
 *
 * @package Gin0115\BuddyPress_Events\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

class Test_Basic_Setup extends \WP_UnitTestCase {

	/** @testdox Wordpress Should be included when running tests. */
	public function test_wordpress_and_plugin_are_loaded() {
		$this->assertTrue( function_exists( 'do_action' ) );
	}

	/** @testdox WP PHPUnit should be included with all expected constants defined. */
	public function test_wp_phpunit_is_loaded_via_composer() {
		$this->assertStringStartsWith(
			dirname( __DIR__, 2 ) . '/vendor/',
			getenv( 'WP_PHPUNIT__DIR' )
		);

		$this->assertStringStartsWith(
			dirname( __DIR__, 2 ) . '/vendor/',
			( new ReflectionClass( 'WP_UnitTestCase' ) )->getFileName()
		);
	}

	/** @testdox Composer libs should be prefixed to avoid conflicts */
	public function test_composer_libs_are_prefixed() {
		$this->assertStringStartsWith(
			'Gin0115_BPE_1\\',
			( new ReflectionClass( 'Gin0115_BPE_1\\Pixie\\Connection' ) )->getNamespaceName()
		);
	}
}
