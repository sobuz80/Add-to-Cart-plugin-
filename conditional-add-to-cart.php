<?php

/**
 * Plugin Name:     MMR Add To Cart
 * Plugin URI:      https://www.facebook.com/sobuz801/
 * Description:      disable, customize, or replace "Add to Cart" button for WooCommerce.
 * Author:          Nabil Lemsieh
 * Author URI:      https://www.facebook.com/sobuz801/
 * Text Domain:     conditional-add-to-cart
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Conditional_Add_To_Cart
 */

defined( 'ABSPATH' ) || exit;

require_once( __DIR__ . '/vendor/autoload.php' );
use \ConditionalAddToCart\Plugin;

add_action('plugins_loaded', [ Plugin::instance(), 'run']);
    

