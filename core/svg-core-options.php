<?php 
/*
* core folder file do not edit.
* SVGility Plugin
* version 1.1
*/

// kick out if directly accessed.
defined( 'ABSPATH' ) || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

//============================================================================

add_action('carbon_register_fields', 'crb_register_custom_fields');
function crb_register_custom_fields() {

Container::make('post_meta', __('Build a gallery'))

    ->show_on_post_type( 'svgility_gallery' )
    ->add_tab(__('Images'), array(
			Field::make('complex', 'svg_image_blocks', '')
				->add_fields(__('Image'), array(
					Field::make("image", "svg_image", __("Image formats only. (jpg, png, gif)"))->set_value_type('url'),
					Field::make('text', 'svg_image_title', __('Title')),
					Field::make('text', 'svg_url', __('URL'))->help_text(__('Defaults to image if left blank. Youtube and Vimeo links will override the image upon popup.')),
					Field::make("checkbox", "svg_image_lightbox", __("Disable Lightbox"))->help_text(__('Turn off lightbox to use URL link instead.'))->set_option_value('yes')
				))
    ))
    ->add_tab(__('Settings'), array(
		Field::make("separator", "svg_shape_options", __("Shape Options")),
		Field::make("select", "svg_shape_block", __("Select Shape"))->help_text(__('Select a shape preset.'))
		->add_options(array(
			'chevrondown' => __('Chevron Down'),
			'circleBase' => __('Circle'),
			'triangleBase' => __('Triangle'),
			'triangleRound' => __('Round Triangle'),
			'pentagonBase' => __('Pentagon'),
			'hexagonBase' => __('Hexagon'),
			'hexagonFlat' => __('Flat Hexagon'),
			'heptagonBase' => __('Heptagon'),
			'octagonBase' => __('Octagon'),
			'fourStar' => __('Four-sided Star'),
			'fiveStar' => __('Five-sided Star'),
			'twentyStar' => __('Twenty-sided Star'),
			'diamondBase' => __('Diamond'),
			'diamondTall' => __('Tall Diamond'),
			'shardPat1' => __('Shard Pattern 1')
		)),
		Field::make("checkbox", "svg_custompoly", __("Custom Shape"))->help_text(__('Overrides default shape selection and requires all fields to work properly.'))->set_option_value('yes'),
		Field::make('text', 'svg_tag_id',__('Tag ID'))->help_text(__('Name the shape pattern.'))->set_required(true)->set_conditional_logic(array(
			'relation' => 'AND',
			array(
				'field' => 'svg_custompoly',
				'value' => 'yes',
				'compare' => '='
			)
		)),
		Field::make('text', 'svg_set_cust_width', __('Set frame width'))->help_text(__('Set the pixel width of the frame from Illustrator, Inkscape or any vector program.'))->set_required(true)->set_conditional_logic(array(
			'relation' => 'AND',
			array(
				'field' => 'svg_custompoly',
				'value' => 'yes',
				'compare' => '='
			)
		)),
		Field::make('text', 'svg_set_cust_height', __('Set frame height'))->help_text(__('Set the pixel height of the frame from Illustrator, Inkscape or any vector program.'))->set_required(true)->set_conditional_logic(array(
			'relation' => 'AND',
			array(
				'field' => 'svg_custompoly',
				'value' => 'yes',
				'compare' => '='
			)
		)),
		Field::make("textarea",  'svg_set_cust_paths', __("Path Points"))->help_text(__('Copy paste of the coordinate points for the shape you wish to use.'))->set_required(true)->set_rows(4)->set_conditional_logic(array(
			'relation' => 'AND',
			array(
				'field' => 'svg_custompoly',
				'value' => 'yes',
				'compare' => '='
			)
		)),
		Field::make("separator", "svg_main_options", __("Main Options")),
        Field::make('text', 'svg_set_column', __('Columns (numbers only)'))->help_text(__('Set any number of columns. Caution this number is unlimited.')),
        Field::make('text', 'svg_set_padding', __('Padding (number + px, %, em, etc)')),
        Field::make('text', 'svg_set_vertical', __('Vertical Trim (numbers only)'))->help_text(__('Adjusts the vertical height of each image block.')),
		Field::make("checkbox", "svg_set_check_rows", __("Checkered Rows"))->help_text(__('Removes one image block from every other row.'))->set_option_value('yes'),
		Field::make("checkbox", "svg_set_center_rows", __("Center Bottom Row"))->help_text(__('Center the last row of the gallery.'))->set_option_value('yes'),
		Field::make("checkbox", "svg_invert", __("Invert Shape"))->help_text(__('Makes every other image block flip shape direction up or down.'))->set_option_value('yes'),
		Field::make("select", "svg_direct", __("Direction"))->add_options(array(
			'normal' => 'normal',
			'reverse' => 'reverse',
			'all' => 'all'
		))
		->set_conditional_logic(array(
			'relation' => 'AND',
			array(
				'field' => 'svg_invert',
				'value' => 'yes',
				'compare' => '='
			)
		)),
		
    ))
    ->add_tab(__('Custom Breakpoints'), array(
		Field::make('text', 'svg_set_target', __('Target this'))->help_text(__('Leave blank to default the browser. Select an element ID or Class to change according to that element\'s width.')),
		Field::make('complex', 'svg_breakpoints','')
			->add_fields('Breakpoint', array(
				Field::make('text', 'svg_set_width', __('Set Width (numbers only)'))->help_text(__('Set the width you wish for this breakpoint to trigger.')),
				Field::make("separator", "svg_shape_options", __("Shape Options")),
				Field::make("select", "svg_shape_block", __("Select Shape"))
				->add_options(array(
					'chevrondown' => __('Chevron Down'),
					'circleBase' => __('Circle'),
					'triangleBase' => __('Triangle'),
					'triangleRound' => __('Round Triangle'),
					'pentagonBase' => __('Pentagon'),
					'hexagonBase' => __('Hexagon'),
					'hexagonFlat' => __('Flat Hexagon'),
					'heptagonBase' => __('Heptagon'),
					'octagonBase' => __('Octagon'),
					'fourStar' => __('Four-sided Star'),
					'fiveStar' => __('Five-sided Star'),
					'twentyStar' => __('Twenty-sided Star'),
					'diamondBase' => __('Diamond'),
					'diamondTall' => __('Tall Diamond'),
					'shardPat1' => __('Shard Pattern 1')
				)),
				Field::make("checkbox", "svg_custompoly", __("Custom Shape"))->set_option_value('yes'),
				Field::make('text', 'svg_tag_id',__('Tag ID'))->set_required(true)->set_conditional_logic(array(
					'relation' => 'AND',
					array(
						'field' => 'svg_custompoly',
						'value' => 'yes',
						'compare' => '='
					)
				)),
				Field::make('text', 'svg_set_cust_width', __('Set frame width'))->set_required(true)->set_conditional_logic(array(
					'relation' => 'AND',
					array(
						'field' => 'svg_custompoly',
						'value' => 'yes',
						'compare' => '='
					)
				)),
				Field::make('text', 'svg_set_cust_height', __('Set frame height'))->set_required(true)->set_conditional_logic(array(
					'relation' => 'AND',
					array(
						'field' => 'svg_custompoly',
						'value' => 'yes',
						'compare' => '='
					)
				)),
				Field::make("textarea",  'svg_set_cust_paths', __("Path Points"))->set_required(true)->set_rows(4)->set_conditional_logic(array(
					'relation' => 'AND',
					array(
						'field' => 'svg_custompoly',
						'value' => 'yes',
						'compare' => '='
					)
				)),
				Field::make("separator", "svg_main_options", __("Main Options")),
				Field::make('text', 'svg_set_column', __('Columns (numbers only)')),
				Field::make('text', 'svg_set_padding', __('Padding (number + px, %, em, etc)')),
				Field::make('text', 'svg_set_vertical', __('Vertical Trim (numbers only)')),
				Field::make("checkbox", "svg_set_check_rows", __("Checkered Rows"))->set_option_value('yes'),
				Field::make("checkbox", "svg_set_center_rows", __("Center Bottom Row"))->set_option_value('yes'),
				Field::make("checkbox", "svg_invert", __("Invert Shape"))->set_option_value('yes'),
				Field::make("select", "svg_direct", __("Direction"))->add_options(array(
					'normal' => 'normal',
					'reverse' => 'reverse',
					'all' => 'all'
				))
				->set_conditional_logic(array(
					'relation' => 'AND',
					array(
						'field' => 'svg_invert',
						'value' => 'yes',
						'compare' => '='
					)
				)),
			)),
    ));
}
?>