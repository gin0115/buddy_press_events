<?php

/**
 * Tests for the primary translations class.
 *
 * @package Gin0115\BuddyPress_Events\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\Tests\Unit\I18n;

use Gin0115\BuddyPress_Events\I18n\Translations;
use Gin0115\BuddyPress_Events\I18n\Plugin_Events;

/**
 * @group unit
 * @group i18n
 */
class Test_Translations extends \WP_UnitTestCase {

    /** @testdox It should be possible to access the Plugin Events Translations from the parent translations class. */
    public function test_access_plugin_events_translations() {
        $this->assertInstanceOf(
            Plugin_Events::class,
            Translations::get_instance()->plugin_events()
        );
    }
}