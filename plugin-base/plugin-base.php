<?php
/**
 * Plugin Name: WordPress Plugin Template
 * Description: A WordPress plugin template
 * Author: Mario Kernich
 * Version: 1.0.0
 * Author URI: https://marioke.dev
 * Text Domain: plugin-base
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Repository: https://github.com/marioke/WordPress-Plugin-Template
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

define("PLUGIN_BASE_DIR", WP_PLUGIN_DIR . '/' . basename(__DIR__));
define("PLUGIN_BASE_URL", plugins_url() . '/' . basename(__DIR__));
define('PLUGIN_BASE_VERSION', '1.0.0');

class PluginBase
{
    /**
     * PluginBase constructor.
     */
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'load_textdomain']);
    }

    /**
     * Load plugin textdomain.
     * @return void
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('plugin-base', false, plugin_basename(dirname(__FILE__)) . '/languages');
    }

    /**
     * Register class autoloader.
     * @return void
     */
    public function register_autoload(): void
    {
        spl_autoload_register(static function ($class_name) {
            $namespace = "PluginBase\\";

            if (strpos($class_name, $namespace) !== 0) {
                return;
            }

            $class_name = str_replace(array($namespace, '\\'), array('', '/'), $class_name);
            $path = PLUGIN_BASE_DIR . "/class/$class_name.php";

            require_once $path;
        });
    }
}

new PluginBase();