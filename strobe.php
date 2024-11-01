<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/strobe-ticketing
 * @since             1.0.0
 * @package           Strobe
 *
 * @wordpress-plugin
 * Plugin Name:       Ticketing Widget
 * Plugin URI:        https://www.strobelabs.com
 * Description:       Display a Strobe org's current events directly through WordPress.
 * Version:           1.0.0
 * Author:            Strobe Labs
 * Author URI:        https://www.strobelabs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       strobe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-strobe-activator.php
 */
function activate_strobe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strobe-activator.php';
	Strobe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-strobe-deactivator.php
 */
function deactivate_strobe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strobe-deactivator.php';
	Strobe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_strobe' );
register_deactivation_hook( __FILE__, 'deactivate_strobe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-strobe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_strobe() {

	$plugin = new Strobe();
	$plugin->run();

}
run_strobe();
