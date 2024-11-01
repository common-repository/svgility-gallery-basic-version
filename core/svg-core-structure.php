<?php
/*
* core folder file do not edit.
* SVGility Plugin
* version 1.1
*/

// kick out if directly accessed.
defined( 'ABSPATH' ) || exit;

// Svgility Block Structure
class SVGILITY_BLOCK {

	private static $instance = null;
	
	// Establish instance
	public static function get_ignited() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	// initialize plugin systems
	private function __construct() {
		if (is_admin()) {
			add_action('init', array($this, 'register_svgility_post_type'));
		}
	}
	
	//============================================================================
	// register Svgility Custom Post Type
	public function register_svgility_post_type() {

		$labels = array(
			'name'               => _x( 'Svgility Galleries', SVGILITY_PLUGIN_DOMAIN ),
			'singular_name'      => _x( 'New Svgility Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'add_new'            => _x( 'Create Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'add_new_item'       => __( 'New Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'edit_item'          => __( 'Editing Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'new_item'           => __( 'New Svgility Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'view_item'          => __( 'View Svgility Gallery', SVGILITY_PLUGIN_DOMAIN ),
			'search_items'       => __( 'Search Galleries', SVGILITY_PLUGIN_DOMAIN ),
			'not_found'          => __( 'No galleries found', SVGILITY_PLUGIN_DOMAIN ),
			'not_found_in_trash' => __( 'No galleries found in Trash', SVGILITY_PLUGIN_DOMAIN ),
			'parent_item_colon'  => __( 'Parent Svgility Gallery:', SVGILITY_PLUGIN_DOMAIN ),
			'menu_name'          => __( 'Svgility Galleries', SVGILITY_PLUGIN_DOMAIN ),
		);

		$args = array(
			'labels'  => $labels,
			'public' => true,
			'publicly_queryable' => false,
			'supports' => array('title'),
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 66,
			'menu_icon' => SVGILITY_PLUGIN_URL . 'images/svgility_icon_16x16.png',
			'capability_type' => 'post',
			'rewrite' => false
		);		

		register_post_type('svgility_gallery', $args);
		add_filter('manage_svgility_gallery_posts_columns', array($this, 'svgility_gallery_list'));
		add_action('manage_svgility_gallery_posts_custom_column', array($this, 'svgility_shortcode_annexation'), 10, 2);
		add_filter("manage_edit-svgility_gallery_sortable_columns", array($this, 'svgility_gallery_sortable_columns'));
	}
	
	//============================================================================
	//Custom Post Column
	function svgility_gallery_list($columns){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Gallery'),			'leadimage' => __('First Image'),
			'shortcode' => __('Shortcode'),
			'date' => __('Created')
		);
		return $columns;
	}
	function svgility_shortcode_annexation($column,$post_id){
		global $post;
		$imageGrab = carbon_get_post_meta($post_id, 'svg_image_blocks', 'complex');
		if (preg_match("/.jpg/", $imageGrab[0]['svg_image']) || preg_match("/.jpeg/", $imageGrab[0]['svg_image'])) {
			$formatDrop = substr($imageGrab[0]['svg_image'], 0, -4);
			$formatUp = $formatDrop . "-150x150.jpg"; 
		} else if (preg_match("/.gif/", $imageGrab[0]['svg_image'])) {
			$formatDrop = substr($imageGrab[0]['svg_image'], 0, -4);
			$formatUp = $formatDrop . "-150x150.gif"; 			
		} else if (preg_match("/.png/", $imageGrab[0]['svg_image'])) {
			$formatDrop = substr($imageGrab[0]['svg_image'], 0, -4);
			$formatUp = $formatDrop . "-150x150.png"; 			
		}
		switch($column) {
			case 'shortcode':
				echo '<span>'. __('Click to copy') . '</span>' . '<a class="svgscbtn svgshortcode" href="#" data-clipboard-text="[' .SVGILITY_PLUGIN_DOMAIN. ' id=&#34;' .esc_html($post_id). '&#34;]">[' .SVGILITY_PLUGIN_DOMAIN. ' id=&#34;' .esc_html($post_id). '&#34;]</a>';
				break;
			case 'leadimage':
				echo '<a href="'. esc_url(get_edit_post_link($post_id)) .'"><img class="svgimagethumb" src="' . esc_url( $formatUp ) . '" /></a>';				
				break;
			default :
				break;
		};
	}
	function svgility_gallery_sortable_columns( $columns ) {
		$columns['shortcode'] = 'shortcode';
		return $columns;
	}
	//============================================================================
}
SVGILITY_BLOCK::get_ignited();
?>