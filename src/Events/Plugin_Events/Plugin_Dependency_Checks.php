<?php

declare(strict_types=1);

/**
 * Dependency checks for the plugin.
 *
 * @package Gin0115\BuddyPress_Events
 * @since 0.1.0
 */

namespace Gin0115\BuddyPress_Events\Events\Plugin_Events;

use Gin0115\BuddyPress_Events\I18n\Translations;
use Gin0115_BPE_1\PinkCrab\Perique\Application\App_Factory;
use Gin0115_BPE_1\PinkCrab\Plugin_Lifecycle\Plugin_State_Change;
use Gin0115_BPE_1\PinkCrab\Plugin_Lifecycle\Plugin_State_Controller;

final class Plugin_Dependency_Checks {

	private App_Factory $app;
	private string $min_php_version = '7.4';
	private string $min_wp_version  = '5.9';
	private string $min_bp_version  = '11.0';
	private Translations $translations;
	/** @var Plugin_State_Change[] */
	private array $life_cycle_events;

	public function __construct( App_Factory $app, Translations $translations ) {
		$this->app          = $app;
		$this->translations = $translations;
	}

	/**
	 * Adds an event to the life cycle events array.
	 *
	 * @param Plugin_State_Change $event
	 * @return self
	 */
	public function add_life_cycle_event( Plugin_State_Change $event ): self {
		$this->life_cycle_events[] = $event;
		return $this;
	}

	/**
	 * Sets the minimum php version required.
	 *
	 * @param string $version
	 * @return self
	 */
	public function set_min_php_version( string $version ): self {
		$this->min_php_version = $version;
		return $this;
	}

	/**
	 * Sets the minimum wp version required.
	 *
	 * @param string $version
	 * @return self
	 */
	public function set_min_wp_version( string $version ): self {
		$this->min_wp_version = $version;
		return $this;
	}

	/**
	 * Sets the minimum bp version required.
	 *
	 * @param string $version
	 * @return self
	 */
	public function set_min_bp_version( string $version ): self {
		$this->min_bp_version = $version;
		return $this;
	}

	/**
	 * The invoke method is called when the class is invoked.
	 *
	 * @return void
	 */
	public function __invoke(): void {
		// Check PHP and WP versions.
		if ( ! $this->php_version_check() ) {
			$this->admin_notice( $this->translations->plugin_events()->php_version_below_minimum( $this->min_php_version ) );
			return;
		}

		if ( ! $this->wp_version_check() ) {
			$this->admin_notice( $this->translations->plugin_events()->wp_version_below_minimum( $this->min_wp_version ) );
			return;
		}

		// Check buddy press is active and correct version.
		if ( ! $this->buddy_press_active() ) {
			$this->admin_notice( $this->translations->plugin_events()->buddy_press_not_active() );
			return;
		}

		if ( ! $this->bp_version_check() ) {
			$this->admin_notice( $this->translations->plugin_events()->bp_version_below_minimum( $this->min_bp_version ) );
			return;
		}

		// Initalise the app.
		$this->init_app();

	}

	/**
	 * Initliases the app.
	 *
	 * @return void
	 */
	private function init_app(): void {
		$app = $this->app->boot();

		// If we have any life cycle events, add them to the plugin state controller.
		if ( empty( $this->life_cycle_events ) ) {
			return;
		}

		// Add any life cycle events.
		$plugin_state_controller = new Plugin_State_Controller( $app );
		foreach ( $this->life_cycle_events as $event ) {
			$plugin_state_controller->event( $event );
		}
		$plugin_state_controller->finalise();
	}

	/**
	 * Create wp admin notice.
	 *
	 * @param string $message
	 * @param string $type
	 * @return void
	 */
	public function admin_notice( string $message, string $type = 'error' ): void {
		\add_action(
			'admin_notices',
			function() use ( $message, $type ) {
				echo '<div class="notice notice-' . esc_html( $type ) . ' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
			}
		);
	}

	/**
	 * Checks if BuddyPress is active.
	 *
	 * @return bool
	 */
	public function buddy_press_active(): bool {
		return \function_exists( 'buddypress' );
	}

	/**
	 * Checks if the server has the correct php version.
	 *
	 * @return bool
	 */
	public function php_version_check(): bool {
		return version_compare( phpversion(), $this->min_php_version, '>=' );
	}

	/**
	 * Checks if the server has the correct wp version.
	 *
	 * @return bool
	 */
	public function wp_version_check(): bool {
		return version_compare( get_bloginfo( 'version' ), $this->min_wp_version, '>=' );
	}

	/**
	 * Checks if the server has the correct bp version.
	 *
	 * @return bool
	 */
	public function bp_version_check(): bool {
		return \function_exists( 'bp_get_version' )
		&& version_compare( bp_get_version(), $this->min_bp_version, '>=' );
	}
}
