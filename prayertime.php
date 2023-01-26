<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/naeem-akhtar-cs/
 * @since             1.0.0
 * @package           Prayertime
 *
 * @wordpress-plugin
 * Plugin Name:       PrayerTime
 * Plugin URI:        https://www.linkedin.com/in/naeem-akhtar-cs/
 * Description:       Shows prayer times of any city. Shortcode [PrayerTime country='PAK' city='Lahore', method=4], [PrayerTimeFaq country='PAK' city='Lahore', method=4]. Please note plugin uses a free third-party API to fetch prayer time data. In case API changes your plugin will be directly affected and will need an upgrade.
 * Version:           1.0.0
 * Author:            Naeem Akhtar
 * Author URI:        https://www.linkedin.com/in/naeem-akhtar-cs/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prayertime
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PRAYERTIME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-prayertime-activator.php
 */
function activate_prayertime()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-prayertime-activator.php';
    Prayertime_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-prayertime-deactivator.php
 */
function deactivate_prayertime()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-prayertime-deactivator.php';
    Prayertime_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_prayertime');
register_deactivation_hook(__FILE__, 'deactivate_prayertime');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-prayertime.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_prayertime()
{

    $plugin = new Prayertime();
    $plugin->run();

}
run_prayertime();
