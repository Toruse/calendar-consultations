<?php
/**
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Calendar_Consultations
 *
 * @wordpress-plugin
 * Plugin Name:       Calendar of consultations
 * Plugin URI:        http://example.com/calendar-consultations-uri/
 * Description:       This plugin allows you to make an appointment. Example: [calendar-consultations] .
 * Version:           1.0.0
 * Author:            Noname
 * Author URI:        http://noname.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       calendar-consultations
 */

use plugin\calendar\consultations\Application;

if (!defined('WPINC')) {
    die;
}

define('PLUGIN_CALENDAR_CONSULTATIONS_PATH', plugin_dir_path( __FILE__ ));

define('PLUGIN_CALENDAR_CONSULTATIONS_URL', plugin_dir_url( __FILE__ ));

define('PLUGIN_CALENDAR_PLUGIN_NAME', 'calendar-consultations');

require PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/Application.php';

$plugin = new Application();
$plugin->run();

register_activation_hook( __FILE__, [Application::class, 'install']);