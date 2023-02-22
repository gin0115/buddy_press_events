<?php

/**
 * PHPUnit bootstrap file
 */

// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once dirname( __DIR__, 2 ) . '/build/php/vendor/autoload.php';

// Include help files.
foreach ( glob( dirname( __DIR__, 1 ) . '/tests/Helper/*.php' ) as $file ) {
	require_once $file;
}

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

// Define the plugin root.
define( 'GIN0115_BUDDYPRESS_EVENTS_ROOT', dirname( __DIR__, 2 ) );

// Load all environment variables into $_ENV
try {
	$dotenv = Dotenv\Dotenv::createUnsafeImmutable( __DIR__ );
	$dotenv->load();
} catch (\Throwable $th) {
	// Do nothing if fails to find env as not used in pipeline.
}

tests_add_filter(
	'muplugins_loaded',
	function() {

	}
);

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
