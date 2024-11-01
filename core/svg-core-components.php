<?php
/*
* core folder file do not edit.
* SVGility Plugin
* version 1.1
*/

// kick out if directly accessed.
defined( 'ABSPATH' ) || exit;


// core
require_once( SVGILITY_PLUGIN_PATH . 'core/svg-core-structure.php' );
require_once( SVGILITY_PLUGIN_PATH . 'core/svg-core-options.php' );
require_once( SVGILITY_PLUGIN_PATH . 'core/svg-core-shortcode.php' );

// add all the required external files here.
function svgility_add_infrastructure() {
	wp_register_style( 'svgility-css', SVGILITY_PLUGIN_URL . 'css/svgility-defaults.css');
	wp_enqueue_style( 'svgility-css' );
	wp_register_script( 'svgility-javascript', SVGILITY_PLUGIN_URL . 'js/svgility.js', array(), 1.0, true);
	wp_enqueue_script( 'svgility-javascript' );
}
add_action( 'wp_enqueue_scripts', 'svgility_add_infrastructure',2 );

// admin scripts
function svgility_admin_scripts($hook){
   global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' || $hook == 'edit.php') {
        if ( 'svgility_gallery' === $post->post_type ) {
			wp_register_style( 'custom-css', SVGILITY_PLUGIN_URL . 'css/svgility-custom.css');
			wp_enqueue_style( 'custom-css' );		
			wp_register_script( 'jcopyclick-javascript', SVGILITY_PLUGIN_URL . 'js/clipboard.js', array(), 1.0, true);
			wp_enqueue_script( 'jcopyclick-javascript' );
			add_action('admin_print_footer_scripts','svgility_admin_script_misc');
        }
    }
}
// misc admin JavaScript
add_action('admin_enqueue_scripts', 'svgility_admin_scripts');
function svgility_admin_script_misc(){
	echo '<script type="text/javascript">new Clipboard(".svgscbtn");</script>';
}

// image size annex
function imageSizeannex() {
    add_image_size( 'displaythumb', 150, 150, true ); // 400 pixel wide and 200 pixel tall, resized proportionally
    add_image_size( 'svgility-thumb', 401, 202, true ); // 400 pixel wide and 200 pixel tall, resized proportionally
    add_image_size( 'svgility-thumb2', 801, 402, true ); // 400 pixel wide and 200 pixel tall, resized proportionally	
}
add_action( 'plugins_loaded', 'imageSizeannex' );

function display_image_sizes($sizes) {
$sizes['displaythumb'] = __( '<span style="color: #0000ff;">display thumb Image</span>' );
$sizes['svgility-thumb'] = __( '<span style="color: #0000ff;">svgility-thumb Image</span>' );
$sizes['svgility-thumb2'] = __( '<span style="color: #0000ff;">svgility-thumb2 Image</span>' );
return $sizes;
}
add_filter('image_size_names_choose', 'display_image_sizes');
?>