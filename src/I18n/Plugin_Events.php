<?php

declare(strict_types=1);

/**
 * All translations for plugin events.
 *
 * @package Gin0115\BuddyPress_Events
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\I18n;

class Plugin_Events {

	/**
	 * Error message for when buddy press is not active when activating the plugin.
	 *
	 * @return string
	 */
	public function buddy_press_not_active(): string {
		return _x( 'BuddyPress Events requires BuddyPress to be installed and active.', 'Error message for when buddy press is not active when activating the plugin.', 'gin0115_bp_events' );
	}

	/**
	 * Error message if users php version is below the minimum required.
	 *
	 * @param string $min_version
	 * @return string
	 */
	public function php_version_below_minimum( string $min_version ): string {
		// Translators: %1$s is the minimum php version required, %2$s is the users current php version.
		$template = _x( 'BuddyPress Events requires PHP version %1$s or above. You are running version %2$s.', 'Error message if users php version is below the minimum required.', 'gin0115_bp_events' );
		return sprintf( $template, $min_version, phpversion() );
	}

	/**
	 * Error message if users wp version is below the minimum required.
	 *
	 * @param string $min_version
	 * @return string
	 */
	public function wp_version_below_minimum( string $min_version ): string {
		// Translators: %1$s is the minimum wp version required, %2$s is the users current wp version.
		$template = _x( 'BuddyPress Events requires WordPress version %1$s or above. You are running version %2$s.', 'Error message if users wp version is below the minimum required.', 'gin0115_bp_events' );
		return sprintf( $template, $min_version, get_bloginfo( 'version' ) );
	}

	/**
	 * Error message if users bp version is below the minimum required.
	 *
	 * @param string $min_version
	 * @return string
	 */
	public function bp_version_below_minimum( string $min_version ): string {
		// Translators: %1$s is the minimum bp version required, %2$s is the users current bp version.
		$template = _x( 'BuddyPress Events requires BuddyPress version %1$s or above. You are running version %2$s.', 'Error message if users bp version is below the minimum required.', 'gin0115_bp_events' );
		return sprintf( $template, $min_version, bp_get_version() );
	}
}
