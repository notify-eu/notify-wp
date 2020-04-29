<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://notify.eu
 * @since             1.0.0
 * @package           Notify-eu
 *
 * @wordpress-plugin
 * Plugin Name:       Notify-eu
 * Plugin URI:        https://github.com/notify-eu/notify-wp
 * Description:       Notify, a new messaging and notification platform for a user friendly and faster communication in B2B & B2C.
 * Version:           1.0.0
 * Author:            Notify
 * Author URI:        https://notify.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       notify-eu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NOTIFY_EU_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-notify-eu-activator.php
 */
function activate_notify_eu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-notify-eu-activator.php';
	Notify_Eu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-notify-eu-deactivator.php
 */
function deactivate_notify_eu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-notify-eu-deactivator.php';
	Notify_Eu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_notify_eu' );
register_deactivation_hook( __FILE__, 'deactivate_notify_eu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-notify-eu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_notify_eu() {

	$plugin = new Notify_Eu();
	$plugin->run();

}
run_notify_eu();
