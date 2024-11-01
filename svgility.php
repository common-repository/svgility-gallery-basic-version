<?php
/**
* Plugin Name: SVGILITY Gallery Plus
* Plugin URI: http://www.svgility.com/
* Description: Shape your gallery!
* Version: 1.1
* Author: Bryen (meshsmith)
* Author URI: http://www.svgility.com/
* License: GPL2
*/

// kick out if directly accessed.
defined( 'ABSPATH' ) || exit;

// defined constants
define( 'SVGILITY_PLUGIN_DOMAIN', 'Svgility' );
define( 'SVGILITY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'SVGILITY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SVGILITY_PLUGIN_VERSION', '1.0.0');

// framework
require_once( SVGILITY_PLUGIN_PATH . 'carbon-fields/carbon-fields-plugin.php');

// core loader
require_once( SVGILITY_PLUGIN_PATH . 'core/svg-core-components.php');
?>