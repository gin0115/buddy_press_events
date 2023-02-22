<?php

/**
 * @wordpress-plugin
 * Plugin Name:     BuddyPress Events
 * Plugin URI:      https://github.com/gin0115/stock-managment
 * Description:     A plugin for making stock management with WooCommerce much easier from a warehousing persoective
 * Version:         0.1.0
 * Author:          Glynn Quelch
 * Author URI:      https://github.com/gin0115
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     pc_stock_man
 */
use Gin0115_BPE_1\PinkCrab\Ajax\Ajax_Bootstrap;
use Gin0115_BPE_1\PinkCrab\BladeOne\BladeOne_Bootstrap;
use Gin0115_BPE_1\PinkCrab\Perique\Application\App_Factory;
use Gin0115_BPE_1\PinkCrab\Ajax\Registration_Middleware\Ajax_Middleware;
use Gin0115_BPE_1\PinkCrab\Route\Registration_Middleware\Route_Middleware;
use Gin0115_BPE_1\PinkCrab\Perique_Admin_Menu\Registration_Middleware\Page_Middleware;
use Gin0115_BPE_1\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware;

require_once __DIR__ . '/function_pollyfills.php';
require_once __DIR__ . '/build/php/vendor/autoload.php';

// Bootstrap all required modules (sets up DI Rules)
Ajax_Bootstrap::use();
BladeOne_Bootstrap::use( __DIR__ . DIRECTORY_SEPARATOR );

// Boot the application
$app = ( new App_Factory( __DIR__ ) )->with_wp_dice( true )
	->di_rules( require __DIR__ . '/config/dependencies.php' )
	->app_config( require __DIR__ . '/config/settings.php' )
	->registration_classes( require __DIR__ . '/config/registration.php' )
	->construct_registration_middleware( Page_Middleware::class )
	->construct_registration_middleware( Ajax_Middleware::class )
	->construct_registration_middleware( Route_Middleware::class )
	->construct_registration_middleware( Registerable_Middleware::class )
	->boot();
