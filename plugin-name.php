<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, and defines a function that starts the plugin.
 *
 * @since              1.0.0
 * @package            PluginName
 *
 * @wordpress-plugin
 * Plugin Name:        Plugin Name
 * Description:        Plugin boilerplate
 * Version:            1.0.0
 * Author:             Brandon Jones
 * Author URI:         https://brandonsj.ms/
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace PluginName;

use PluginName\Admin;
use PluginName\Lib;

// Plugin file path.
define( 'PlUGINNAME_PLUGIN_FILE', __FILE__ );

// This file can't be accessed directly.
defined( 'WPINC' ) || die;

// Load the autoloader.
include_once( __DIR__ . '/lib/autoloader.php' );
// Load the custom metadata plugin.
include_once( __DIR__ . '/lib/custom-metadata/custom_metadata.php' );

add_action( 'init', __NAMESPACE__ . '\\plugin_start' );
/**
 * Starts the plugin by instantiating each of the classes (which is
 * included via the autoloader).
 */
function plugin_start() {
	/**
	 * Register the custom post type
	 */
	$post_types = new Admin\Post_Types_Config();
	$post_types->init();
	/**
	 * Add custom fields to our custom post types
	 */
	$custom_fields = new Admin\Fields_Config();
	$custom_fields->init();
	/**
	 * Add video endpoint to WP API
	 */
	$custom_endpoint = new Lib\Endpoints();
	$custom_endpoint->init();
}