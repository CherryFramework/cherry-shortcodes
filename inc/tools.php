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

	/**
	 * Retrieve a select with data.
	 *
	 * @since  1.0.0
	 * @param  array  $args Arguments.
	 * @return string       HTML-markup for select tag with data.
	 */
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
				'style'    => '',
				'format'   => 'keyval', // keyval/idtext
				'noselect' => '', // return options without <select> tag
			) );

		$options = array();

		if ( ! is_array( $args['options'] ) ) {
			$args['options'] = array();
		}

		if ( $args['id'] ) {
			$args['id'] = ' id="' . $args['id'] . '"';
		}

		if ( $args['name'] ) {
			$args['name'] = ' name="' . $args['name'] . '"';
		}

		if ( $args['class'] ) {
			$args['class'] = ' class="' . $args['class'] . '"';
		}

		if ( $args['style'] ) {
			$args['style'] = ' style="' . esc_attr( $args['style'] ) . '"';
		}

		if ( $args['multiple'] ) {
			$args['multiple'] = ' multiple="multiple"';
		}

		if ( $args['disabled'] ) {
			$args['disabled'] = ' disabled="disabled"';
		}

		if ( $args['size'] ) {
			$args['size'] = ' size="' . $args['size'] . '"';
		}

		if ( $args['none'] && 'keyval' === $args['format'] ) {
			$args['options'][0] = $args['none'];
		}

		if ( $args['none'] && 'idtext' === $args['format'] ) {
			array_unshift( $args['options'], array( 'id' => '0', 'text' => $args['none'], ) );
		}

		/**
		 * keyval loop
		 * 	$args['options'] = array(
		 * 		id => text,
		 * 		id => text,
		 * 	);
		 */
		if ( 'keyval' === $args['format'] ) {
			foreach ( $args['options'] as $id => $text ) {
				$options[] = '<option value="' . (string) $id . '">' . (string) $text . '</option>';
			}
		}

		/**
		 * idtext loop
		 * 	$args['options'] = array(
		 * 		array( id => id, text => text, ),
		 * 		array( id => id, text => text, ),
		 * 	);
		 */
		elseif ( $args['format'] === 'idtext' ) foreach ( $args['options'] as $option ) {
			if ( isset( $option['id'] ) && isset( $option['text'] ) ) {
				$options[] = '<option value="' . (string) $option['id'] . '">' . (string) $option['text'] . '</option>';
			}
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

	/**
	 * Retrieve a list of registered taxonomies.
	 *
	 * @since  1.0.0
	 * @return array A list of taxonomy in format array( 'taxonomy_name' => 'taxonomy_label' ).
	 */
	public static function get_taxonomies() {
		$taxes = array();

		foreach ( (array) get_taxonomies( '', 'objects' ) as $tax ) {
			$taxes[ $tax->name ] = $tax->label;
		}

		/**
		 * Filter a list of registered taxonomies.
		 *
		 * @since 1.0.0
		 * @param array $taxes Taxonomy names.
		 */
		return apply_filters( 'cherry_shortcodes_tools_get_taxonomies', $taxes );
	}

	/**
	 * Retrieve the terms in a taxonomy.
	 *
	 * @since  1.0.0
	 * @param  string $tax The taxonomies to retrieve terms from.
	 * @param  string $key Key for array - `id` or `slug`.
	 * @return array       Array with term names.
	 */
	public static function get_terms( $tax = 'category', $key = 'id' ) {
		$terms = array();

		if ( 'id' === $key ) {
			foreach ( (array) get_terms( $tax, array( 'hide_empty' => false ) ) as $term ) {
				$terms[ $term->term_id ] = $term->name;
			}
		} elseif ( 'slug' === $key ) {
			foreach ( (array) get_terms( $tax, array( 'hide_empty' => false ) ) as $term ) {
				$terms[ $term->slug ] = $term->name;
			}
		}

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

		if ( ! $icon || 'none' == $icon ) {
			return false;
		}

		$output = '';

		if ( false !== strpos( $icon, 'icon:' ) ) {

			$icon       = trim( str_replace( 'icon:', '', $icon ) );
			$style      = Cherry_Shortcodes_Tools::prepare_styles( $style );
			$rand_class = Cherry_Shortcodes_Tools::rand_class( 'icon' );
			$style      = sprintf( '%s{%s}', $rand_class, $style );
			$class     .= ' ' . Cherry_Shortcodes_Tools::esc_class( $rand_class );

			$output = Cherry_Shortcodes_Tools::print_styles( $style );
			$output .= sprintf(
				'<span class="%1$s %2$s"></span>',
				esc_attr( $icon ), esc_attr( $class )
			);

		} else {
			$alt    = Cherry_Shortcodes_Tools::get_image_alt( $icon, $alt );
			$icon   = Cherry_Shortcodes_Tools::get_image_url( $icon );
			$output = sprintf(
				'<span class="%2$s"><img src="%1$s" alt="%3$s"></span>',
				esc_url( $icon ), esc_attr( $class ), esc_attr( $alt )
			);
		}

		return $output;
	}

	/**
	 * Try to get alt attribute for passed image
	 *
	 * @param  mixed  $image    Image ID ot URL.
	 * @param  string $user_alt User provided alt attribute (higher priority than default image alt).
	 * @return string
	 */
	public static function get_image_alt( $image, $user_alt = null ) {

		if ( null !== $user_alt ) {
			return $user_alt;
		}

		if ( ! is_numeric( $image ) ) {
			return $user_alt;
		}

		$data = wp_prepare_attachment_for_js( $image );

		if ( ! empty( $data['alt'] ) ) {
			return esc_attr( $data['alt'] );
		}

		return $user_alt;

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

	/**
	 * Grab all shortcode styles for current page into separate tag and iclude it in footer
	 * or directly print style if grabbing logic not defined
	 *
	 * @since  1.0.7
	 * @since  1.0.7.1 Added a filter `cherry_shortcodes_use_generated_style`.
	 * @param  string $style CSS styles set.
	 * @return string
	 */
	public static function print_styles( $style = null ) {

		if ( ! $style ) {
			return '';
		}

		/**
		 * Filter a flag for using generated style feature.
		 *
		 * @since 1.0.7.1
		 * @param bool $use_generated_style
		 */
		$use_generated_style = apply_filters( 'cherry_shortcodes_use_generated_style', true );

		if ( $use_generated_style && function_exists( 'cherry_add_generated_style' ) ) {

			cherry_add_generated_style( $style );

			return '';
		}

		return sprintf( '<style scoped>%s</style>', $style );
	}

	/**
	 * Get random CSS class for specific shortcode
	 *
	 * @since  1.0.7
	 * @param  string $shortcode shortcode name.
	 * @return string
	 */
	public static function rand_class( $shortcode = 'cherry' ) {

		$num = rand( 100, 999 );

		return esc_attr( sprintf( '.%s-%d', $shortcode, $num ) );

	}

	/**
	 * Escape CSS class name to use in HTML string
	 *
	 * @since  1.0.7
	 * @param  string $css_class CSS class name.
	 * @return string
	 */
	public static function esc_class( $css_class = null ) {
		return esc_attr( trim( $css_class, '.' ) );
	}

	/**
	 * Retrieve a HTML-markup string with icons.
	 *
	 * @since  1.0.0
	 * @return string Icons.
	 */
	public static function icons() {
		$icons = array();

		if ( is_callable( array( 'Cherry_Shortcodes_Data', 'icons' ) ) ) {
			foreach ( (array) Cherry_Shortcodes_Data::icons() as $icon ) {
				$icons[] = '<i class="' . $icon . '" title="' . $icon . '"></i>';
			}
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

	/**
	 * Retrieve a URI for Google Maps API.
	 *
	 * @since 1.0.7.5
	 * @return string
	 */
	public static function get_google_map_url() {
		$url     = '//maps.googleapis.com/maps/api/js';
		$api_key = '';

		if ( function_exists( 'cherry_get_option' ) ) {
			$api_key = cherry_get_option( 'google-api-key' );
		}

		$query = apply_filters( 'cherry_shortcodes_google_map_url_query', array(
			'v'         => 3,
			'signed_in' => 'false',
			'key'       => $api_key,
		) );

		$url = add_query_arg( $query, $url );

		return apply_filters( 'cherry_shortcodes_google_map_url', $url, $query );
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

		if( !$croped_image_url ){
			$croped_image_url = $img_url;
		}

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

	/**
	 * Get CSS class name for shortcode by template name
	 *
	 * @since  1.0.6
	 * @param  string $template template name
	 * @return string|bool false
	 */
	public static function get_template_class( $template ) {

		if ( ! $template ) {
			return false;
		}

		$prefix = apply_filters( 'cherry_shortcodes_template_class_prefix', 'template' );
		$class  = sprintf( '%s-%s', esc_attr( $prefix ), esc_attr( str_replace( '.tmpl', '', $template ) ) );

		return $class;
	}

	/**
	 * Get spacer div with specific CSS classes and tr
	 *
	 * @since  1.0.6
	 * @param  string $size    spacer value.
	 * @param  array  $classes spacer block CSS classes.
	 * @return string
	 */
	public static function get_spacer_block( $size, $classes ) {

		$size = intval( $size );

		if ( 0 <= $size ) {
			$prop = 'height';
			$size = (string)$size . 'px';
		} else {
			$prop = 'margin-top';
			$size = (string)$size . 'px';
		}

		return sprintf(
			'<div class="%3$s" style="%1$s:%2$s;"></div>',
			$prop, $size, esc_attr( implode( ' ', $classes ) )
		);

	}

	/**
	 * Get image by id or url (backward compatibility)
	 *
	 * @since  1.0.0
	 * @param  string $source attachment id or image url
	 * @param  string $image_size image size
	 * @return string
	 */
	public static function get_image_url( $source, $image_size = 'full') {
		if( !is_numeric( $source ) ){
			return esc_url( $source );
		}else{
			$attachment_image = wp_get_attachment_image_src( intval( $source ), $image_size );
			return esc_url( $attachment_image[0] );
		}
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