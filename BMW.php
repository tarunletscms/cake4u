<?php
/**
 * Plugin Name: Binary MLM WooCommerce
 * Plugin URI: https://mlmtrees.com/
 * Description: A Multilevel Marketting wordpress solution with wooCommerce integration, this will help you give multiple commissions on each sell.
 * Version: 2.0.0
 * Author: LetsCMS
 * Author URI: https://letscms.com
 * Text Domain: BMW
 * Domain Path: /i18n/languages/
 * WC requires at least: 2.2
 * WC tested up to: 4.3.0
 * Requires PHP: 5.6
 *
 * @package BMP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define BMP_PLUGIN_FILE.
if ( ! defined( 'BMW_PLUGIN_FILE' ) ) {
	define( 'BMW_PLUGIN_FILE', __FILE__ );
}

// Include the main BMW class.
if ( ! class_exists( 'BMW' ) ) {
	include_once dirname( __FILE__ ) . '/includes/CLASS-BMW.php';
}


function BMW() {
	return BMW::instance();
}

// Global for backwards compatibility.
$GLOBALS['BMW'] = BMW();
