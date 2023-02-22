<?php

declare(strict_types=1);

/**
 * Holds all custom app config values.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/app_config
 *
 * @package Gin0115\BuddyPress_Events
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */


return array(
	'taxonomies' => array(),
	'meta'       => array(
		'post' => array(),
		'user' => array(),
		'term' => array(),
	),
	'plugin'     => array( 'version' => '0.1.0' ),
	'namespaces' => array(
		'rest'  => 'gin0115/bp_events/v1',
		'cache' => 'gin0115_bp_events',
	),
);
