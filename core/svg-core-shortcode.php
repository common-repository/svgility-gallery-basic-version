<?php 
/*
* core folder file do not edit.
* SVGility Plugin
* version 1.1
*/

// kick out if directly accessed.
defined( 'ABSPATH' ) || exit;

//============================================================================
// meta box for shortcode
function load_meta_shortcode_box() {
	add_meta_box(__('Click to Copy Shortcode', SVGILITY_PLUGIN_DOMAIN), __('Click to Copy Shortcode', SVGILITY_PLUGIN_DOMAIN), 'svgillty_shortcode_metablocks', 'svgility_gallery', 'side', 'high');
}
function svgillty_shortcode_metablocks(){
	echo '<a class="svgscbtn svgshortcode" href="#" data-clipboard-text="['. SVGILITY_PLUGIN_DOMAIN . ' ' . "id=&#34;" . esc_html(get_the_ID()) . '&#34;]">['. SVGILITY_PLUGIN_DOMAIN . ' ' . "id=&#34;" . esc_html(get_the_ID()) . '&#34;]</a>';
}
add_action( 'add_meta_boxes', 'load_meta_shortcode_box', 0 );
//============================================================================
// shortcode structure
class svgility_shortcore {
	
	public function __construct() {
		add_shortcode("Svgility", array( $this, "svgility_shortcode_core"));
	}

	public function svgility_shortcode_core($atts) {

		ob_start();
		
		extract( shortcode_atts(array(
			'id' => null
		), $atts, 'Svgility'));
		 
		$post = get_post($id);
		$imageGrab = carbon_get_post_meta($post->ID, 'svg_image_blocks', 'complex');
		
		?>
			<div id="<?php echo 'gal-' . esc_html($post->ID); ?>">
				<div class="fallset svgility-box">
					<div class="svgility-set">
					
						<?php
							if ( $imageGrab ) {
								foreach ($imageGrab as $slide) {
									?>
										<div class="svgility-block<?php if ($slide['svg_image_lightbox'] == 'yes') { echo ''; } else { echo ' svg-media'; }; ?>">
											<a href="<?php 
											if($slide['svg_url'] !== '' && $slide['svg_image_lightbox'] == 'yes') { 
												echo esc_url($slide['svg_url']); 
											} else {
												if(preg_match("/youtu.be/",$slide['svg_url']) || preg_match("/youtube.com/",$slide['svg_url']) || preg_match("/vimeo.com/",$slide['svg_url'])){
													echo esc_url($slide['svg_url']);
												} else {
													if($slide['svg_image'] == '') {
														echo esc_url(SVGILITY_PLUGIN_URL . 'images/noimage.jpg');
													} else {
														echo esc_url($slide['svg_image']);
													};
												};
											}; ?>" target="_blank">
												<div>
													<span><?php echo esc_html(__($slide['svg_image_title'], SVGILITY_PLUGIN_DOMAIN)); ?></span>
												</div>
												<img src="<?php
													if($slide['svg_image'] == '') {
														if(preg_match("/youtu.be/",$slide['svg_url']) || preg_match("/youtube.com/",$slide['svg_url'])) {
															echo esc_url(SVGILITY_PLUGIN_URL . 'images/ytvid.jpg');													
														} else if(preg_match("/vimeo.com/",$slide['svg_url'])) {
															echo esc_url(SVGILITY_PLUGIN_URL . 'images/vvid.jpg');
														} else {
															echo esc_url(SVGILITY_PLUGIN_URL . 'images/noimage.jpg');
														};
													} else {
														echo esc_url($slide['svg_image']);
													};
												?>" alt="<?php echo esc_html(__($slide['svg_image_title'], SVGILITY_PLUGIN_DOMAIN)); ?>" />
											</a>
										</div>
									<?php
								}
							}
						?>

					</div>
				</div>
			</div>
		<?php
		
		add_action('wp_footer', array( $this, 'svgility_javascript_set'),100,1);
		
		$svgility_html = ob_get_clean();
		return $svgility_html;			

	}

	public function svgility_javascript_set( $attributes ){
		
		if ( shortcode_exists( 'Svgility' ) ) {
			ob_start();
			
			global $wp_query;	
			$posts = $wp_query->posts;
			$pattern = get_shortcode_regex();
			
			foreach ($posts as $post){
				if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $traceit ) && array_key_exists( 2, $traceit ) && in_array( 'Svgility', $traceit[2] ) ) {
					/* Load Settings to JavaScript */
					?><script type="text/javascript"><?php						
					
					if (is_array($traceit[0])){
					
						foreach($traceit[0] as $traceas) {

							if (strpos($traceas, 'Svgility') !== false) {
								if (preg_match('/id="(.*?)"/', $traceas, $svgIDNum) === 1) {

									$post = get_post($svgIDNum[1]);

?>svgility.ignite(<?php echo '"#gal-' . $post->ID . '"'; ?>,{
<?php echo "polyShape: '" . esc_js( carbon_get_post_meta($post->ID, 'svg_shape_block') ). "'," . "\n"; ?>
<?php if (carbon_get_post_meta($post->ID, 'svg_custompoly') == 'yes') {
echo "customPolyShape: { 
clipId: '" . esc_js( carbon_get_post_meta($post->ID, 'svg_tag_id')). "',
shapeWidth: " . esc_js( carbon_get_post_meta($post->ID, 'svg_set_cust_width')) . ",	
shapeHeight: " . esc_js( carbon_get_post_meta($post->ID, 'svg_set_cust_height')). ",
pathPoints: '" . esc_js( preg_replace('/\s+/', '', carbon_get_post_meta($post->ID, 'svg_set_cust_paths') ) ). "'}," . "\n";	
}; ?>
<?php if(carbon_get_post_meta($post->ID, 'svg_set_column') !== '') {
echo 'columns: ' . esc_js( carbon_get_post_meta($post->ID, 'svg_set_column')). ',' . "\n"; }; ?>
<?php if(carbon_get_post_meta($post->ID, 'svg_set_padding') !== '') {
echo 'padding: "' . esc_js( carbon_get_post_meta($post->ID, 'svg_set_padding')) . '"' . ',' . "\n"; }; ?>
<?php if (carbon_get_post_meta($post->ID, 'svg_set_vertical') !== '') {
echo 'verticalTrim: ' . esc_js( carbon_get_post_meta($post->ID, 'svg_set_vertical')) . ',' . "\n"; }; ?>
<?php if (carbon_get_post_meta($post->ID, 'svg_set_check_rows') == 'yes') {
echo 'evenOdd: true,' . "\n"; }; ?>
<?php if (carbon_get_post_meta($post->ID, 'svg_set_center_rows') == 'yes') {
echo 'centerBottom: true,' . "\n"; }; ?>
<?php if (carbon_get_post_meta($post->ID, 'svg_invert') == 'yes') {
	echo "invert: {active: true, 
	direction: '" . esc_js( carbon_get_post_meta($post->ID, 'svg_direct') ). "'}," . "\n";
}; ?>
<?php
$breakGrabs = carbon_get_post_meta($post->ID, 'svg_breakpoints', 'complex');
if($breakGrabs) {

	echo 'breakpoints: {' . "\n";
	if ( carbon_get_post_meta($post->ID, 'svg_set_target') !== '') {
		echo 'targetThis: "' . esc_js( carbon_get_post_meta($post->ID, 'svg_set_target')) . '",' . "\n";
	} else {
		echo 'targetThis: ""'  . ',' . "\n";
	}
	echo 'breakHere: [';
	foreach($breakGrabs as $breakGrab) {
		
		if ($breakGrabs !== '') {

			echo '{'. "\n";
			echo "setWidth: " . esc_js( $breakGrab['svg_set_width']) . "," . "\n";
			echo "polyShape: '" . esc_js( $breakGrab['svg_shape_block']) . "'," . "\n";
			if ($breakGrab['svg_custompoly'] == 'yes') {
			echo "customPolyShape: { 
			clipId: '" . esc_js( $breakGrab['svg_tag_id'] ). "',
			shapeWidth: " . esc_js( $breakGrab['svg_set_cust_width']) . ",	
			shapeHeight: " . esc_js( $breakGrab['svg_set_cust_height']) . ",
			pathPoints: '" . esc_js( preg_replace('/\s+/', '', $breakGrab['svg_set_cust_paths']))  . "'}," . "\n";};
			if($breakGrab['svg_set_column'] !== '') {
			echo 'column: ' . esc_js( $breakGrab['svg_set_column']). ',' . "\n"; };	
			if($breakGrab['svg_set_padding'] !== '') {
			echo 'padding: "' . esc_js( $breakGrab['svg_set_padding']) . '"' . ',' . "\n"; } else { echo 'padding: "0",' . "\n" ;};	
			if ($breakGrab['svg_set_vertical'] !== '') {
			echo 'verticalTrim: ' . esc_js( $breakGrab['svg_set_vertical']) . ',' . "\n"; } else { echo 'verticalTrim: 0,' . "\n" ;}; 
			if ($breakGrab['svg_set_check_rows'] == 'yes') {
			echo 'evenOdd: true,' . "\n"; } else { echo 'evenOdd: false,' . "\n" ;}; 
			if ($breakGrab['svg_set_center_rows'] == 'yes') {
			echo 'centerBottom: true,' . "\n"; } else { echo 'centerBottom: false,' . "\n" ;};
			if ($breakGrab['svg_invert'] == 'yes') {
				echo "invert: {active: true, 
				direction: '" . esc_js( $breakGrab['svg_direct']) . "'}," . "\n";
			} else { echo 'invert: {active: false},' . "\n" ;};
			echo '},';
			
		}
	
	}
	echo ']}';
}
?>
});
<?php echo "\n";
								};
							};

						};
					};
					?></script><?php
					break;	
				}    
			} 

			$scriptGrab = ob_get_clean();
			echo $scriptGrab;			
		};
	}
	
}
$shortcore = new svgility_shortcore();
	
?>