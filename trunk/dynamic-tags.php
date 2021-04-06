<?php

namespace DynamicTags;

use DynamicTags\Lib\DynamicTags;
use DynamicTags\Lib\Activator;
use DynamicTags\Lib\Deactivator;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.rto.de
 * @since             1.0.0
 * @package           DynamicTags
 *
 * @wordpress-plugin
 * Plugin Name:       DynamicTags
 * Plugin URI:        https://github.com/RTO-Websites/dynamic-tags/
 * Description:       Dynamic Tags is an Elementor addon that adds some useful dynamic tags.
 * Version:           1.2.0
 * Author:            RTO GmbH
 * Author URI:        https://www.rto.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dynamic-tags
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

define( 'DynamicTags_VERSION', '1.2.0' );

define( 'DynamicTags_DIR', str_replace( '\\', '/', __DIR__ ) );
define( 'DynamicTags_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * The class responsible for auto loading classes.
 */
require_once DynamicTags_DIR . '/vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in Lib/Activator.php
 */
register_activation_hook( __FILE__, [ Activator::class, 'activate' ] );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Lib/Deactivator.php
 */
register_deactivation_hook( __FILE__, [ Deactivator::class, 'deactivate' ] );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
DynamicTags::run();
