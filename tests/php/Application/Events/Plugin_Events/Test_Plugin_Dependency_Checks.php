<?php

/**
 * Tests that all basic systems are loaded.
 *
 * @package Gin0115\BuddyPress_Events\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\Tests\Application\Events\Plugin_Events;

use Gin0115\WPUnit_Helpers\Output;
use Gin0115\WPUnit_Helpers\WP\WP_Dependencies;
use Gin0115\BuddyPress_Events\I18n\Translations;
use Gin0115\BuddyPress_Events\I18n\Plugin_Events;
use Gin0115_BPE_1\PinkCrab\Perique\Application\App;

/**
 * @group application
 * @group plugin_life_cycle
 */
class Test_Plugin_Dependency_Checks extends \WP_UnitTestCase {

	public static function deleteDir( $dir ) {
		$it    = new \RecursiveDirectoryIterator( $dir, \RecursiveDirectoryIterator::SKIP_DOTS );
		$files = new \RecursiveIteratorIterator(
			$it,
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ( $files as $file ) {
			if ( $file->isDir() ) {
				rmdir( $file->getRealPath() );
			} else {
				unlink( $file->getRealPath() );
			}
		}
		rmdir( $dir );
	}

	/**
	 * Ensure BUddyPress and BuddyPress Events are deactivated.
	 *
	 * @before
	 */
	public function set_up() {
		// If buddy press is active, deactivate it.
		if ( WP_Dependencies::plugin_active( 'buddypress/bp-loader.php' ) ) {
			// Deactivate.
			deactivate_plugins( 'buddypress/bp-loader.php' );
		}

	}

	/**
	 * Clear the plugins directory after each test.
	 *
	 * @after
	 */
	public function tear_down() {
		// Empty the plugins directory.
		$plugin_dir = ABSPATH . 'wp-content/plugins';
		if ( is_dir( $plugin_dir ) ) {
			self::deleteDir( $plugin_dir );
		}
	}

	/**
	 * @testdox Attempting to activate the plugin when BuddyPress is not active, should see the plugin no activated and an admin notice thrown
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_plugin_not_activated_when_buddypress_not_active() {
		// Look for the admin notice.
		$this->expectOutputRegex( '#' . ( new Plugin_Events() )->buddy_press_not_active() . '#' );

		// Mock activating the plugin.
		require_once GIN0115_BUDDYPRESS_EVENTS_ROOT . '/plugin.php';
		do_action( 'plugins_loaded' );
		do_action( 'admin_notices' );
	}

	/**
	 * @testdox Attempting to activate the plugin with an unsupported version of WP should result in the plugin not being initialised and an admin notice thrown
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_plugin_not_activated_when_wp_version_not_supported() {
		// Mock the WP version to 5.0
		global $wp_version;
		$wp_version = '5.0';

		// Look for the admin notice.
		$this->expectOutputRegex( '#BuddyPress Events requires WordPress version#' );

		// Mock activating the plugin.
		require_once GIN0115_BUDDYPRESS_EVENTS_ROOT . '/plugin.php';
		do_action( 'plugins_loaded' );
		do_action( 'admin_notices' );
	}

	/**
	 * @testdox Attempting to activate the plugin with an unsupported version of BuddyPress should result in the plugin not being initialised and an admin notice thrown
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_plugin_not_activated_when_buddypress_version_not_supported() {

		// Install & Activate BuddyPress.
		Output::buffer(
			function() {
				$old_version = 'https://downloads.wordpress.org/plugin/buddypress.9.0.0.zip';
				WP_Dependencies::install_remote_plugin_from_zip( $old_version, ABSPATH );
				WP_Dependencies::activate_plugin( 'buddypress/bp-loader.php' );
				require_once \ABSPATH . 'wp-content/plugins/buddypress/bp-loader.php';

			}
		);

		$this->expectOutputRegex( '#BuddyPress Events requires BuddyPress version#' );

		// Mock activating the plugin.
		require_once GIN0115_BUDDYPRESS_EVENTS_ROOT . '/plugin.php';
		do_action( 'plugins_loaded' );
		do_action( 'admin_notices' );
	}

	/**
	 * @testdox If all dependency requirements are met, the plugin should activate.
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_plugin_activated_when_all_requirements_met() {
		
		// Install & Activate BuddyPress.
		Output::buffer(
			function() {
				$valid_version = 'https://downloads.wordpress.org/plugin/buddypress.11.0.0.zip';
				WP_Dependencies::install_remote_plugin_from_zip( $valid_version, ABSPATH );
				WP_Dependencies::activate_plugin( 'buddypress/bp-loader.php' );
				require_once \ABSPATH . 'wp-content/plugins/buddypress/bp-loader.php';

			}
		);

		// Mock activating the plugin.
		require_once GIN0115_BUDDYPRESS_EVENTS_ROOT . '/plugin.php';
		do_action( 'plugins_loaded' );

		// Check the plugin is active.
		$this->assertTrue(App::is_booted());
	}

}
