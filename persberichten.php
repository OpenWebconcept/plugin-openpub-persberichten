<?php

/**
 * Plugin Name:       Yard | Persberichten
 * Plugin URI:        https://www.openwebconcept.nl/
 * Description:       Press releases are a variation on OpenPub items. A press release can be added to a laposta campaign based on the connected taxonomy. This only happens when the press release is saved for the first time.
 * Version:           2.3.6
 * Requires PHP:      7.4
 * Author:            Yard | Digital Agency
 * Author URI:        https://www.yard.nl/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       persberichten
 * Domain Path:       /languages
 */

/**
 * If this file is called directly, abort.
 */
if (! defined('WPINC')) {
	die;
}

define('PRESS_DIR', __DIR__);

/**
 * Manual loaded file: the autoloader.
 */
require_once __DIR__ . '/autoloader.php';
$autoloader = new OWC\Persberichten\Autoloader();

/**
 * Begin execution of the plugin
 *
 * Booting is deferred to `after_setup_theme`: the config files call __() at
 * include time, and WordPress 6.7+ flags translation loading triggered before
 * that hook with a "_load_textdomain_just_in_time was called incorrectly" notice.
 */
\add_action('plugins_loaded', function () {
	\add_action('after_setup_theme', function () {
		$plugin = (new OWC\Persberichten\Foundation\Plugin(__DIR__))->boot();
	});
}, 10);
