<?php

/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Prevent direct file access
defined('ABSPATH') or exit;


function _nekomc_load_plugin()
{
    global $nekomc;


    // don't run if PHP version is lower than 5.3
    if (!function_exists('array_replace')) {
        return;
    }

    // bootstrap the core plugin
    define('NEKOMC_VERSION', '1.0.0');
    define('NEKOMC_PLUGIN_DIR', __DIR__ . '/');
    define('NEKOMC_PLUGIN_URL', plugins_url('/', __FILE__));
    define('NEKOMC_PLUGIN_FILE', __FILE__);

    require NEKOMC_PLUGIN_DIR . '/includes/class-admin.php';
    require NEKOMC_PLUGIN_DIR . '/includes/functions.php';

    if (is_admin()) {
        $admin = new NEKOMC_Admin();
        $admin->add_hooks();
    }

    return;
}


add_action('plugins_loaded', '_nekomc_load_plugin', 8);
