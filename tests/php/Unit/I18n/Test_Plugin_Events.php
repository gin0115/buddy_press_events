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
}
