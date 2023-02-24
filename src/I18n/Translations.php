<?php

declare(strict_types=1);

/**
 * Parent service used to provide all translations
 *
 * @package Gin0115\BuddyPress_Events
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\I18n;

final class Translations {

	/**
	 * Gets an instance of class.
	 *
	 * @return Translations
	 */
	public static function get_instance(): Translations {
		return new self();
	}

	/**
	 * Returns the translations for Plugin Events
	 *
	 * @return Plugin_Events
	 */
	public function plugin_events(): Plugin_Events {
		return new Plugin_Events();
	}
}
