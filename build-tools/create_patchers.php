<?php

/**
 * Creates the needed patchers from stubs.
 */

$vendor_dir = dirname( __DIR__, 1 ) . '/vendor';
require_once $vendor_dir . '/autoload.php';
require_once __DIR__ . '/Patcher_Manger/IdentifierExtractor.php';
require_once __DIR__ . '/Patcher_Manger/Patcher_Builder.php';

$builder = new Patcher_Builder( $vendor_dir );
$builder->set_stubs(
	array(
		array(
			'package'     => 'php-stubs/wordpress-stubs',
			'stubsPath'   => array( $vendor_dir . '/php-stubs/wordpress-stubs/wordpress-stubs.php' ),
			'destination' => __DIR__ . '/patchers/wp_patcher.do',
		),
		array(
			'package'     => 'php-stubs/woocommerce-stubs',
			'stubsPath'   => array( $vendor_dir . '/php-stubs/woocommerce-stubs/woocommerce-stubs.php' ),
			'destination' => __DIR__ . '/patchers/wc_patcher.do',
		),
		array(
			'package'     => 'php-stubs/acf-pro-stubs',
			'stubsPath'   => array( $vendor_dir . '/php-stubs/acf-pro-stubs/acf-pro-stubs.php' ),
			'destination' => __DIR__ . '/patchers/acf_patcher.do',
		),
	)
);
$builder->execute();
