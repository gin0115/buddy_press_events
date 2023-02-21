<?php

declare(strict_types=1);

/**
 * All custom rules for the DI Container.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/dependency-injection
 *
 * @package Gin0115\BuddyPress_Events
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

use Gin0115_BPE_1\Pixie\Connection;
use Gin0115_BPE_1\Pixie\QueryBuilder\QueryBuilderHandler;

return array(
	QueryBuilderHandler::class => array(
		'constructParams' => array(
			new Connection(
				$GLOBALS['wpdb'],
				array(
					Connection::USE_WPDB_PREFIX => true,
					Connection::SHOW_ERRORS     => false,
				),
			),
		),
	),
);
