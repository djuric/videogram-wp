<?php
/**
 * The plugin bootstrap file
 *
 * @since             1.0.0
 * @package           Videogram
 *
 * Plugin Name:       VideoGram
 * Plugin URI:        https://github.com/djuric/videogram-plugin
 * Description:       Back-end videos in WordPress for access via GraphQL
 * Version:           1.0.0
 * Author:            Zarko
 * Author URI:        http://zarko.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       videogram
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin constants.
define( 'VIDEOGRAM_VERSION', '1.0.0' );
define( 'VIDEOGRAM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VIDEOGRAM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'VIDEOGRAM_VIDEO_POST_TYPE', 'vgvideo' );

/**
 * Actions to run on activation.
 */
function activate_videogram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-videogram-activator.php';
	Videogram_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_videogram' );

// Core class.
require plugin_dir_path( __FILE__ ) . 'includes/class-videogram.php';

/**
 * Kick off the plugin.
 */
function run_videogram() {

	$plugin = new Videogram();
	$plugin->run();

}
run_videogram();
