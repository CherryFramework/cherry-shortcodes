<?php
/**
 * Filters.
 *
 * @author    Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2012 - 2015, Cherry Team
 * @link      http://www.cherryframework.com/
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'cherry_shortcodes_tools_get_types',      'cherry_shortcodes_unset_type' );
add_filter( 'cherry_shortcodes_tools_get_taxonomies', 'cherry_shortcodes_unset_taxonomy' );
add_filter( 'cherry_templater_target_dirs',           'cherry_templater_add_target_dirs' );
add_filter( 'cherry_templater_macros_buttons',        'cherry_shortcodes_macros_buttons', 10, 2 );
add_filter( 'cherry_general_options_list',            'cherry_shortcodes_add_option_item' );
add_filter( 'nav_menu_link_attributes',               'cherry_shortcodes_modify_nav_menu_args' );

function cherry_shortcodes_unset_type( $types ) {
	unset( $types['nav_menu_item'] );

	return $types;
}

function cherry_shortcodes_unset_taxonomy( $taxes ) {
	unset( $taxes['nav_menu'] );
	unset( $taxes['link_category'] );

	return $taxes;
}

function cherry_templater_add_target_dirs( $target_dirs ) {
	array_push( $target_dirs, CHERRY_SHORTCODES_DIR );

	return $target_dirs;
}

/**
 * Adds a specific macros buttons.
 *
 * @since  1.0.0
 *
 * @param  array  $macros_buttons Array with macros buttons.
 * @param  string $shortcode      Shortcode's name.
 * @return array
 */
function cherry_shortcodes_macros_buttons( $macros_buttons, $shortcode ) {

	switch ( $shortcode ) {
		case 'posts':
			$macros_buttons['image'] = array(
				'id'    => 'cherry_image',
				'value' => __( 'Image', 'cherry-shortcodes' ),
				'open'  => '%%IMAGE%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Image` macros', 'cherry-shortcodes' ),
			);
			$macros_buttons['date'] = array(
				'id'    => 'cherry_date',
				'value' => 'Date',
				'open'  => '%%DATE="' . get_option( 'date_format' ) . '"%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Date` macros', 'cherry-shortcodes' ),
			);
			$macros_buttons['author'] = array(
				'id'    => 'cherry_author',
				'value' => 'Author',
				'open'  => '%%AUTHOR%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Author` macros', 'cherry-shortcodes' ),
			);
			$macros_buttons['comments'] = array(
				'id'    => 'cherry_comments',
				'value' => 'Comments',
				'open'  => '%%COMMENTS%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Comments` macros', 'cherry-shortcodes' ),
			);
			$macros_buttons['taxonomy'] = array(
				'id'    => 'cherry_taxonomy',
				'value' => 'Taxomomy',
				'open'  => '%%TAXONOMY="category|post_tag|custom_taxonomy"%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Taxomomy` macros', 'cherry-shortcodes' ),
			);
			$macros_buttons['excerpt'] = array(
				'id'    => 'cherry_excerpt',
				'value' => 'Excerpt',
				'open'  => '%%EXCERPT%%',
				'close' => '',
				// 'title' => __( 'Helper information for `Excerpt` macros', 'cherry-shortcodes' ),
			);
			break;

		case 'banner':
			$macros_buttons = array();

			$macros_buttons['image'] = array(
				'id'    => 'cherry_image',
				'value' => 'Image URL',
				'open'  => '%%IMAGE%%',
				'close' => '',
				'title' => __( 'Banner image URL', 'cherry-shortcodes' ),
			);
			$macros_buttons['title'] = array(
				'id'    => 'cherry_title',
				'value' => 'Banner title',
				'open'  => '%%TITLE%%',
				'close' => '',
				'title' => __( 'Banner title', 'cherry-shortcodes' ),
			);
			$macros_buttons['url'] = array(
				'id'    => 'cherry_url',
				'value' => 'Banner URL',
				'open'  => '%%URL%%',
				'close' => '',
				'title' => __( 'Banner link URL', 'cherry-shortcodes' ),
			);
			$macros_buttons['color'] = array(
				'id'    => 'cherry_color',
				'value' => 'Text color',
				'open'  => '%%COLOR%%',
				'close' => '',
				'title' => __( 'Banner default text color', 'cherry-shortcodes' ),
			);
			$macros_buttons['bg_color'] = array(
				'id'    => 'cherry_bg_color',
				'value' => 'Background color',
				'open'  => '%%BGCOLOR%%',
				'close' => '',
				'title' => __( 'Banner background color', 'cherry-shortcodes' ),
			);
			$macros_buttons['content'] = array(
				'id'    => 'cherry_content',
				'value' => 'Banner text content',
				'open'  => '%%CONTENT%%',
				'close' => '',
				'title' => __( 'Banner content', 'cherry-shortcodes' ),
			);
			$macros_buttons['class'] = array(
				'id'    => 'cherry_class',
				'value' => 'Custom CSS class',
				'open'  => '%%CLASS"%%',
				'close' => '',
				'title' => __( 'Custom CSS class', 'cherry-shortcodes' ),
			);
			break;

		case 'swiper_carousel':
			$macros_buttons = apply_filters( 'cherry_shortcodes_add_carousel_macros', $macros_buttons );
			break;

		default:
			break;
	}

	return $macros_buttons;
}

function cherry_shortcodes_add_option_item( $general_options ) {
	$all_pages     = array();
	$all_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$all_pages[''] = __( 'Select a page:', 'cherry-shortcodes' );

	foreach ( $all_pages_obj as $page ) {
		$all_pages[$page->ID] = $page->post_title;
	}

	$general_options['general-landing-page'] = array(
		'type'        => 'select',
		'title'       => __( 'Landing page', 'cherry-shortcodes' ),
		'description' => __( 'Please select landing page. (Page with anchor navigation menu.)', 'cherry-shortcodes' ),
		'value'       => '',
		'class'       => 'width-full',
		'options'     => $all_pages,
	);

	$general_options['google-api-key'] = array(
		'type'        => 'text',
		'title'       => __( 'Google Maps API Key (required)', 'cherry-shortcodes' ),
		'description' => sprintf( __( 'This API key can be obtained from the <a href="%s">Google Developers Console</a>.', 'cherry-shortcodes' ), 'https://console.developers.google.com/' ),
		'value'       => '',
		'class'       => 'width-full',
	);

	return $general_options;
}

function cherry_shortcodes_modify_nav_menu_args( $atts ) {

	if ( ! function_exists( 'cherry_get_option' ) ) {
		return $atts;
	}

	$general_landing_page = cherry_get_option('general-landing-page');
	$page_id = get_the_ID();

	if( $general_landing_page && $general_landing_page != $page_id && strpos($atts['href'], '#') === 0
		|| is_page_template( 'templates/template-landing.php' )  && strpos($atts['href'], '#') === 0
		){
		$atts['href'] = get_page_link( $general_landing_page ) . $atts['href'];
	}

	return $atts;
}
