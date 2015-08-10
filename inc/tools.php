<?php
/**
 * Plugin tools.
 *
 * @author    Vladimir Anokhin
 * @author    Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2013 - 2015, Vladimir Anokhin
 * @link      http://gndev.info/shortcodes-ultimate/
 * @link      http://www.cherryframework.com
 * @license   http://gndev.info/licensing/gpl/
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Extra CSS class helper.
 *
 * @param  array  $atts Shortcode attributes.
 * @return string
 */
function cherry_esc_class_attr( $atts ) {
	return ( $atts['class'] ) ? ' ' . esc_attr( $atts['class'] ) : '';
}

class Cherry_Shortcodes_Tools {
	function __construct() {}

	public static function select( $args ) {
		$args = wp_parse_args( $args, array(
				'id'       => '',
				'name'     => '',
				'class'    => '',
				'multiple' => '',
				'size'     => '',
				'disabled' => '',
				'selected' => '',
				'none'     => '',
				'options'  => array(),
				'style' => '',
				'format'   => 'keyval', // keyval/idtext
				'noselect' => '' // return options without <select> tag
			) );
		$options = array();
		if ( !is_array( $args['options'] ) ) $args['options'] = array();
		if ( $args['id'] ) $args['id'] = ' id="' . $args['id'] . '"';
		if ( $args['name'] ) $args['name'] = ' name="' . $args['name'] . '"';
		if ( $args['class'] ) $args['class'] = ' class="' . $args['class'] . '"';
		if ( $args['style'] ) $args['style'] = ' style="' . esc_attr( $args['style'] ) . '"';
		if ( $args['multiple'] ) $args['multiple'] = ' multiple="multiple"';
		if ( $args['disabled'] ) $args['disabled'] = ' disabled="disabled"';
		if ( $args['size'] ) $args['size'] = ' size="' . $args['size'] . '"';
		if ( $args['none'] && $args['format'] === 'keyval' ) $args['options'][0] = $args['none'];
		if ( $args['none'] && $args['format'] === 'idtext' ) array_unshift( $args['options'], array( 'id' => '0', 'text' => $args['none'] ) );
		// keyval loop
		// $args['options'] = array(
		//   id => text,
		//   id => text
		// );
		if ( $args['format'] === 'keyval' ) foreach ( $args['options'] as $id => $text ) {
				$options[] = '<option value="' . (string) $id . '">' . (string) $text . '</option>';
			}
		// idtext loop
		// $args['options'] = array(
		//   array( id => id, text => text ),
		//   array( id => id, text => text )
		// );
		elseif ( $args['format'] === 'idtext' ) foreach ( $args['options'] as $option ) {
				if ( isset( $option['id'] ) && isset( $option['text'] ) )
					$options[] = '<option value="' . (string) $option['id'] . '">' . (string) $option['text'] . '</option>';
			}
		$options = implode( '', $options );
		$options = str_replace( 'value="' . $args['selected'] . '"', 'value="' . $args['selected'] . '" selected="selected"', $options );
		return ( $args['noselect'] ) ? $options : '<select' . $args['id'] . $args['name'] . $args['class'] . $args['multiple'] . $args['size'] . $args['disabled'] . $args['style'] . '>' . $options . '</select>';
	}

	public static function get_categories() {
		$cats = array();
		foreach ( (array) get_terms( 'category', array( 'hide_empty' => false ) ) as $cat ) $cats[$cat->slug] = $cat->name;
		return $cats;
	}

	public static function get_types() {
		$types = array();
		foreach ( (array) get_post_types( '', 'objects' ) as $cpt => $cpt_data ) $types[$cpt] = $cpt_data->label;
		return apply_filters( 'cherry_shortcodes_tools_get_types', $types );
	}

	public static function get_taxonomies() {
		$taxes = array();
		foreach ( (array) get_taxonomies( '', 'objects' ) as $tax ) $taxes[$tax->name] = $tax->label;
		return apply_filters( 'cherry_shortcodes_tools_get_taxonomies', $taxes );
	}

	public static function get_terms( $tax = 'category', $key = 'id' ) {
		$terms = array();
		if ( $key === 'id' ) foreach ( (array) get_terms( $tax, array( 'hide_empty' => false ) ) as $term ) $terms[$term->term_id] = $term->name;
			elseif ( $key === 'slug' ) foreach ( (array) get_terms( $tax, array( 'hide_empty' => false ) ) as $term ) $terms[$term->slug] = $term->name;
				return $terms;
	}

	public static function icon( $src = 'file' ) {
		return ( strpos( $src, '/' ) !== false ) ? '<img src="' . $src . '" alt="" />' : '<i class="fa fa-' . str_replace( 'icon: ', '', $src ) . '"></i>';
	}

	public static function get_icon( $args ) {
		$args = wp_parse_args( $args, array(
				'icon' => '',
				'size' => '',
				'color' => '',
				'style' => ''
			) );
		// Check for icon param
		if ( !$args['icon'] ) return;
		// Add trailing ; to the style param
		if ( $args['style'] ) $args['style'] = rtrim( $args['style'], ';' ) . ';';
		// Font Awesome icon
		if ( strpos( $args['icon'], 'icon:' ) !== false ) {
			// Add size
			if ( $args['size'] ) $args['style'] .= 'font-size:' . $args['size'] . 'px;';
			// Add color
			if ( $args['color'] ) $args['style'] .= 'color:' . $args['color'] . ';';
			// Query font-awesome stylesheet
			cherry_query_asset( 'css', 'font-awesome' );
			// Return icon
			return '<i class="fa fa-' . trim( str_replace( 'icon:', '', $args['icon'] ) ) . '" style="' . $args['style'] . '"></i>';
		}
		// Image icon
		elseif ( strpos( $args['icon'], '/' ) !== false ) {
			// Add size
			if ( $args['size'] ) $args['style'] .= 'width:' . $args['size'] . 'px;height:' . $args['size'] . 'px;';
			// Return icon
			return '<img src="' . $args['icon'] . '" alt="" style="' . $args['style'] . '" />';
		}
		// Icon is not detected
		return false;
	}

	/**
	 * Get icon HTML markup from icon attr value in shortcode.
	 * Get icon HTML for Cherry shortcodes.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $icon  Passed icon.
	 * @param  string $class Custom class for icon.
	 * @param  string $alt   Alt attribute value if icon is image.
	 * @return string        Icon HTML markup.
	 */
	public static function get_icon_html( $icon, $class = 'cherry-icon', $alt = null, $style = array() ) {

		if ( ! $icon ) {
			return false;
		}

		if ( false !== strpos( $icon, 'icon:' ) ) {

			$icon  = trim( str_replace( 'icon:', '', $icon ) );
			$style = sprintf( ' style="%s"', Cherry_Shortcodes_Tools::prepare_styles( $style ) );

			return sprintf(
				'<span class="%1$s %2$s"%3$s></span>',
				esc_attr( $icon ), esc_attr( $class ), $style
			);

		} else {
			return sprintf(
				'<span class="%2$s"><img src="%1$s" alt="%3$s"></span>',
				esc_url( $icon ), esc_attr( $class ), esc_attr( $alt )
			);
		}

	}

	public static function append_icons( $content = null, $icon = null ) {

		if ( ! $icon || ( false === strpos( $icon, 'icon:' ) ) ) {
			return do_shortcode( $content );
		}

		$font_icon = self::get_icon_html( $icon, 'list-icon' );

		$content = preg_replace( '/(<li>)/', '$1' . $font_icon, $content );

		return do_shortcode( $content );
	}

	/**
	 * Grab CSS styles from styles array into CSS string.
	 *
	 * @since 1.0.0
	 *
	 * @param array $style Defined styles array.
	 */
	public static function prepare_styles( $style = array() ) {

		if ( empty( $style ) ) {
			__return_empty_string();
		}

		$result = '';
		foreach ( $style as $property => $value ) {

			if ( empty( $value ) ) {
				continue;
			}

			if ( 'background-image' == $property ) {
				$value = 'url(' . $value . ')';
			}

			$result .= $property . ':' . $value . ';';
		}

		return $result;

	}

	public static function icons() {
		$icons = array();
		if ( is_callable( array( 'Cherry_Shortcodes_Data', 'icons' ) ) ) foreach ( (array) Cherry_Shortcodes_Data::icons() as $icon ) {
				$icons[] = '<i class="' . $icon . '" title="' . $icon . '"></i>';
			}
		return implode( '', $icons );
	}

	public static function access() {
		if ( !self::access_check() ) wp_die( __( 'Access denied', 'cherry-shortcodes' ) );
	}

	public static function access_check() {
		return current_user_can( 'edit_posts' );
	}

	public static function error( $prefix = false, $message = false ) {
		if ( !$prefix && !$message ) return '';
		$return = array( '<div class="su-error" style="padding:10px;border:1px solid #f03;color:#903;background:#fde">' );
		if ( $prefix ) $return[] = '<strong>' . $prefix . '</strong><br/>';
		$return[] = $message;
		$return[] = '</div>';
		return implode( '', $return );
	}

	public static function get_google_map_styles() {
		$map_style_array = array();

		$plugin_path = CHERRY_SHORTCODES_DIR . '/assets/googlemap/';
		$theme_path  = get_stylesheet_directory() . '/assets/googlemap/';

		if ( file_exists( $plugin_path ) && is_dir( $plugin_path ) ) {
			$plugin_map_styles = scandir( $plugin_path );
			$plugin_map_styles = array_diff( $plugin_map_styles, array( '.', '..', 'index.php' ) );
		}

		if ( file_exists( $theme_path ) && is_dir( $theme_path ) ) {
			$theme_map_styles = scandir( $theme_path );
			$theme_map_styles = array_diff( $theme_map_styles, array( '.', '..', 'index.php' ) );
			$map_style_array  = array_merge( $theme_map_styles, $plugin_map_styles );
		} else {
			$map_style_array = $plugin_map_styles;
		}

		foreach ( $map_style_array as $key => $value) {
			$result_array[ str_replace( '.json', '', $value ) ] = $value;
		}

		return $result_array;
	}

	public static function get_map_style_json( $map_style ){
		$theme_path  = get_stylesheet_directory() . '/assets/googlemap/';
		$plugin_path = CHERRY_SHORTCODES_DIR . 'assets/googlemap/';

		$map_style_path = $theme_path . $map_style . '.json';

		if ( file_exists( $map_style_path ) ) {
			$style = file_get_contents( $map_style_path );

			return $style;
		}

		$map_style_path = $plugin_path . $map_style . '.json';

		if ( file_exists( $map_style_path ) ) {
			$style = file_get_contents( $map_style_path );

			return $style;
		}

		return '';
	}

	public static function google_geocoding( $addr ){
		$cache_key = md5( $addr );

		$return = get_transient( $cache_key );

		if ( $return ) {
			return $return;
		}

		$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . urlencode( $addr );
		$response = wp_remote_get( $url );

		if ( ! $response ) {
			return false;
		}

		$json_arr = json_decode( $response['body'], true );

		if ( $json_arr["status"] != "OK" ) {
			return false;
		}

		$result = $json_arr["results"][0];
		$return = array(
			"addr"  => $addr,
			"faddr" => $result["formatted_address"],
			"lat"   => $result["geometry"]["location"]["lat"],
			"lng"   => $result["geometry"]["location"]["lng"],
		);

		set_transient( $cache_key, $return, DAY_IN_SECONDS );

		return $return;
	}

	public static function image_sizes() {
		$_sizes = get_intermediate_image_sizes();

		$sizes = array();
		$sizes = array_combine( $_sizes, $_sizes );
		$sizes['full'] = 'full';

		return $sizes;
	}

	public static function add_css_prefix( $css_property ) {
		$css_prefix = array( '-ms-', '-webkit-', '' );
		$output     = '';

		foreach ( $css_prefix as $prefix_value ) {
			$output .= $prefix_value.$css_property.'; ';
		}

		return $output;
	}

	/**
	 * Get cropped image.
	 *
	 * @since  1.0.0
	 * @param  string|int|int|string|string $args Image url, cropped width value, cropped height value,
	 *                                            custom class name, image alt name.
	 * @return string (HTML-formatted).
	 */
	public static function get_crop_image( $img_url = '', $attachment_id = null, $width = 100, $height = 100, $custom_class = '', $alt_value = '' ) {

		// check if $attachment_id exist
		if ( $attachment_id == null ) {
			return false;
		}

		$image = '';
		//resize & crop img
		$croped_image_url = aq_resize( $img_url, $width, $height, true );
		// get $pathinfo
		$pathinfo = pathinfo( $croped_image_url );
		//get $attachment metadata
		$attachment_metadata = wp_get_attachment_metadata( $attachment_id );
		// create new custom size
		$attachment_metadata['sizes']['croped-image-' . $width . '-' . $height] = array(
			'file'			=> $pathinfo['basename'],
			'width'			=> $width,
			'height'		=> $height,
			'mime-type'		=> get_post_mime_type($attachment_id)
		);
		// wp update attachment metadata
		wp_update_attachment_metadata( $attachment_id, $attachment_metadata );

		$ratio_value = $height / $width;
		$image .= '<img class="wp-post-image croped-image ' . $custom_class . '" data-ratio="' . $ratio_value . '" width="' . $width . '" height="' . $height .'" src="' . $croped_image_url . '" alt="'. $alt_value .'">';

		return $image;
	}

	public static function get_attachment_id_from_src( $image_src ) {
		global $wpdb;

		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var($query);

		return $id;
	}

	public static function remote_query( $url ) {
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != '200') {
			return false;
		}

		$response = json_decode( $response[ 'body' ] );

		return $response;
	}

}

new Cherry_Shortcodes_Tools;