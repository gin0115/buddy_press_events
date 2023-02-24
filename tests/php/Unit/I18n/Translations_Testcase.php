<?php

/**
 * Test case for all translations.
 *
 * Can be extends to add in additional tests for translations.
 *
 * What this will do is go through every method in the translations class and
 * ensure that the values returns are string and passed through get_text() as
 * expected.
 */

namespace Gin0115\BuddyPress_Events\Tests\Unit\I18n;

abstract class Translations_Testcase extends \WP_UnitTestCase {

	/**
	 * Return the full namespace of the translations class.
	 *
	 * @return string
	 */
	abstract protected function get_namespace(): string;

	/**
	 * Filter the gettext function to return a string.
	 *
	 * @param string ...$a Any value are ignored.
	 * @return string
	 */
	public function filter_gettext( ...$a ): string {
		return 'MODIFIED FOR TEST';
	}

	/**
	 * Setup the test case.
	 *
	 * Adds a filters.
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		add_filter( 'gettext_with_context', array( $this, 'filter_gettext' ), 20, 4 );
		add_filter( 'gettext', array( $this, 'filter_gettext' ), 20, 3 );
	}

	/**
	 * Teardown the test case.
	 *
	 * Removes the filters.
	 *
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();
		remove_filter( 'gettext_with_context', array( $this, 'filter_gettext' ), 20 );
		remove_filter( 'gettext', array( $this, 'filter_gettext' ), 20 );
	}

	/**
	 * Tests that every method will return a string.
	 *
	 * @return void
	 */
	public function test_all_methods_return_string(): void {
		$classname = $this->get_namespace();
		$instance  = new $classname();

		// Get all the public methods and test that they return a string.
		$class = new \ReflectionClass( $this->get_namespace() );
		foreach ( $class->getMethods() as $method ) {
			if ( $method->isPublic() ) {
				// Generate faux args for the method.
				$args = array();
				foreach ( $method->getParameters() as $param ) {
					// If basic scala type, add a value.
					switch ( $param->getType()->getName() ) {
						case 'string':
							$args[] = 'string';
							break;
						case 'int':
							$args[] = 1;
							break;
						case 'float':
							$args[] = 1.1;
							break;
						case 'bool':
							$args[] = true;
							break;
						case 'array':
							$args[] = array( 'array' );
							break;

						case 'object':
							$args[] = new \stdClass();
							break;
						case 'callable':
							$args[] = function() {};
							break;
						default:
							continue 2;
							break;
					}
				}
				$this->assertIsString( $instance->{$method->name}( ...$args ) );
				$this->assertEquals( 'MODIFIED FOR TEST', $instance->{$method->name}( ...$args ) );
			}
		}
	}
}
