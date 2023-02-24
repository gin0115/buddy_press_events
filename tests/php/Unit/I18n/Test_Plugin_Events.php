<?php

/**
 * Tests for the plugin events translations class.
 *
 * @package Gin0115\BuddyPress_Events\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\Tests\Unit\I18n;

require_once __DIR__ . '/Translations_Testcase.php';

use Gin0115\BuddyPress_Events\I18n\Plugin_Events;
use Gin0115\BuddyPress_Events\Tests\Unit\I18n\Translations_Testcase;

/**
 * @group unit
 * @group i18n
 */
class Test_Plugin_Events extends Translations_Testcase {

	/** @inheritDoc */
	protected function get_namespace(): string {
		return Plugin_Events::class;
	}

	/** @testdox When generating the message for invalid PHP version, the message should contain both the current version, plus the passed version */
	public function test_invalid_php_version_message() {
		$string = ( new Plugin_Events() )->php_version_below_minimum( '7.0.0' );
		$this->assertStringContainsString( PHP_VERSION, $string );
		$this->assertStringContainsString( '7.0.0', $string );
	}

	/** @testdox When generating the message for invalid WordPress version, the message should contain both the current version, plus the passed version */
	public function test_invalid_wp_version_message() {
		$string = ( new Plugin_Events() )->wp_version_below_minimum( '5.0.0' );
		$this->assertStringContainsString( get_bloginfo( 'version' ), $string );
		$this->assertStringContainsString( '5.0.0', $string );
	}

	/** @testdox When generating the message for invalid BuddyPress version, the message should contain both the current version, plus the passed version */
	public function test_invalid_bp_version_message() {
		$string = ( new Plugin_Events() )->bp_version_below_minimum( '5.0.0' );
		$this->assertStringContainsString( function_exists( 'bp_get_version' ) ? bp_get_version() : '##ERROR## - BP NOT LOADED', $string );
		$this->assertStringContainsString( '5.0.0', $string );
	}
}
