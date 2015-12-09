<?php
/**
 * Shortcode Generator Views.
 *
 * @author    Vladimir Anokhin
 * @author    Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2013 - 2015, Vladimir Anokhin
 * @link      http://gndev.info/shortcodes-ultimate/
 * @link      http://www.cherryframework.com
 * @license   http://gndev.info/licensing/gpl/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class for Shortcode Generator Views.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Generator_Views {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {}

	/**
	 * Retrieve a `text` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `text` element.
	 */
	public static function text( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => '',
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr" />';

		return $return;
	}

	/**
	 * Retrieve a `textarea` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `textarea` element.
	 */
	public static function textarea( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'rows'    => 3,
			'default' => '',
		) );
		$return = '<textarea name="' . $id . '" id="cherry-generator-attr-' . $id . '" rows="' . $field['rows'] . '" class="cherry-generator-attr">' . esc_textarea( $field['default'] ) . '</textarea>';

		return $return;
	}

	/**
	 * Retrieve a `select` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `select` element.
	 */
	public static function select( $id, $field ) {
		// Multiple selects.
		$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
		$return   = '<select name="' . $id . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr"' . $multiple . '>';

		// Create options.
		foreach ( $field['values'] as $option_value => $option_title ) {
			// Is this option selected.
			$selected = ( $field['default'] == $option_value ) ? ' selected="selected"' : '';

			// Create option.
			$return .= '<option value="' . $option_value . '"' . $selected . '>' . $option_title . '</option>';
		}
		$return .= '</select>';

		return $return;
	}

	/**
	 * Retrieve a `bool` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `bool` element.
	 */
	public static function bool( $id, $field ) {
		$return = '<span class="cherry-generator-switch cherry-generator-switch-' . $field['default'] . '"><span class="cherry-generator-yes">' . __( 'Yes', 'cherry-shortcodes' ) . '</span><span class="cherry-generator-no">' . __( 'No', 'cherry-shortcodes' ) . '</span></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr cherry-generator-switch-value" />';

		return $return;
	}

	/**
	 * Retrieve a `upload` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `upload` element.
	 */
	public static function upload( $id, $field ) {
		$data_type = isset( $field['data_type'] ) && 'id' == $field['data_type'] ? 'data-type="id"' : 'data-type="url"';
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr cherry-generator-upload-value" /><div class="cherry-generator-field-actions"><a href="javascript:;" class="button cherry-generator-upload-button" ' . $data_type . '><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'cherry-shortcodes' ) . '" />' . __( 'Media manager', 'cherry-shortcodes' ) . '</a></div>';

		return $return;
	}

	/**
	 * Retrieve a `icon` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `icon` element.
	 */
	public static function icon( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr cherry-generator-icon-picker-value" /><div class="cherry-generator-field-actions"><a href="javascript:;" class="button cherry-generator-upload-button cherry-generator-field-action"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'cherry-shortcodes' ) . '" />' . __( 'Media manager', 'cherry-shortcodes' ) . '</a> <a href="javascript:;" class="button cherry-generator-icon-picker-button cherry-generator-field-action"><img src="' . admin_url( '/images/media-button-other.gif' ) . '" alt="' . __( 'Icon picker', 'cherry-shortcodes' ) . '" />' . __( 'Icon picker', 'cherry-shortcodes' ) . '</a></div><div class="cherry-generator-icon-picker cherry-generator-clearfix"><input type="text" class="widefat" placeholder="' . __( 'Filter icons', 'cherry-shortcodes' ) . '" /></div>';

		return $return;
	}

	/**
	 * Retrieve a `color` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `color` element.
	 */
	public static function color( $id, $field ) {
		$return = '<span class="cherry-generator-select-color"><input type="text" name="' . $id . '" value="' . $field['default'] . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr cherry-generator-select-color-value" /></span>';

		return $return;
	}

	/**
	 * Retrieve a `date` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `date` element.
	 */
	public static function date( $id, $field ) {
		$return = '<span class="cherry-generator-select-date"> <input type="text" name="' . $id . '" value="' . $field['default'] . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr cherry-generator-select-date-value" /></span>';

		return $return;
	}

	/**
	 * Retrieve a `gallery` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `gallery` element.
	 */
	public static function gallery( $id, $field ) {
		$shult = shortcodes_ultimate();

		// Prepare galleries list.
		$galleries = $shult->get_option( 'galleries' );
		$created   = ( is_array( $galleries ) && count( $galleries ) ) ? true : false;
		$return    = '<select name="' . $id . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr" data-loading="' . __( 'Please wait', 'cherry-shortcodes' ) . '">';

		// Check that galleries is set.
		if ( $created ) {
			// Create options.
			foreach ( $galleries as $g_id => $gallery ) {
				// Is this option selected.
				$selected = ( $g_id == 0 ) ? ' selected="selected"' : '';

				// Prepare title.
				$gallery['name'] = ( $gallery['name'] == '' ) ? __( 'Untitled gallery', 'cherry-shortcodes' ) : stripslashes( $gallery['name'] );

				// Create option.
				$return .= '<option value="' . ( $g_id + 1 ) . '"' . $selected . '>' . $gallery['name'] . '</option>';
			}
		} else {
			// Galleries not created.
			$return .= '<option value="0" selected>' . __( 'Galleries not found', 'cherry-shortcodes' ) . '</option>';
		}

		$return .= '</select><small class="description"><a href="' . $shult->admin_url . '#tab-3" target="_blank">' . __( 'Manage galleries', 'cherry-shortcodes' ) . '</a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="cherry-generator-reload-galleries">' . __( 'Reload galleries', 'cherry-shortcodes' ) . '</a></small>';

		return $return;
	}

	/**
	 * Retrieve a `number` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `number` element.
	 */
	public static function number( $id, $field ) {
		$return = '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="cherry-generator-attr" />';

		return $return;
	}

	/**
	 * Retrieve a `slider` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `slider` element.
	 */
	public static function slider( $id, $field ) {
		$return = '<div class="cherry-generator-range-picker cherry-generator-clearfix"><input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="cherry-generator-attr" /></div>';

		return $return;
	}

	/**
	 * Retrieve a `shadow` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `shadow` element.
	 */
	public static function shadow( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', '0', '0', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$return = '<div class="cherry-generator-shadow-picker"><span class="cherry-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="cherry-generator-sp-hoff" /><small>' . __( 'Horizontal offset', 'cherry-shortcodes' ) . ' (px)</small></span><span class="cherry-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="cherry-generator-sp-voff" /><small>' . __( 'Vertical offset', 'cherry-shortcodes' ) . ' (px)</small></span><span class="cherry-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="cherry-generator-sp-blur" /><small>' . __( 'Blur', 'cherry-shortcodes' ) . ' (px)</small></span><span class="cherry-generator-shadow-picker-field cherry-generator-shadow-picker-color"><input type="text" value="' . $defaults[3] . '" class="cherry-generator-shadow-picker-color-value" /><small>' . __( 'Color', 'cherry-shortcodes' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr" /></div>';

		return $return;
	}

	/**
	 * Retrieve a `border` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `border` element.
	 */
	public static function border( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', 'solid', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );

		$borders = Cherry_Shortcodes_Tools::select( array(
				'options'  => Cherry_Shortcodes_Data::borders(),
				'class'    => 'cherry-generator-bp-style',
				'selected' => $defaults[1],
			) );

		$return = '<div class="cherry-generator-border-picker"><span class="cherry-generator-border-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="cherry-generator-bp-width" /><small>' . __( 'Border width', 'cherry-shortcodes' ) . ' (px)</small></span><span class="cherry-generator-border-picker-field">' . $borders . '<small>' . __( 'Border style', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-border-picker-field cherry-generator-border-picker-color"><input type="text" value="' . $defaults[2] . '" class="cherry-generator-border-picker-color-value" /><small>' . __( 'Border color', 'cherry-shortcodes' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr" /></div>';

		return $return;
	}

	/**
	 * Retrieve a `image_source` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `image_source` element.
	 */
	public static function image_source( $id, $field ) {
		$field = wp_parse_args( $field, array(
				'default' => 'none',
			) );

		$sources = Cherry_Shortcodes_Tools::select( array(
				'options'  => array(
					'media'         => __( 'Media library', 'cherry-shortcodes' ),
					'posts: recent' => __( 'Recent posts', 'cherry-shortcodes' ),
					'category'      => __( 'Category', 'cherry-shortcodes' ),
					'taxonomy'      => __( 'Taxonomy', 'cherry-shortcodes' ),
				),
				'selected' => '0',
				'none'     => __( 'Select images source', 'cherry-shortcodes' ) . '&hellip;',
				'class'    => 'cherry-generator-isp-sources',
			) );

		$categories = Cherry_Shortcodes_Tools::select( array(
				'options'  => Cherry_Shortcodes_Tools::get_terms( 'category' ),
				'multiple' => true,
				'size'     => 10,
				'class'    => 'cherry-generator-isp-categories',
			) );

		$taxonomies = Cherry_Shortcodes_Tools::select( array(
				'options'  => Cherry_Shortcodes_Tools::get_taxonomies(),
				'none'     => __( 'Select taxonomy', 'cherry-shortcodes' ) . '&hellip;',
				'selected' => '0',
				'class'    => 'cherry-generator-isp-taxonomies',
			) );

		$terms = Cherry_Shortcodes_Tools::select( array(
				'class'    => 'cherry-generator-isp-terms',
				'multiple' => true,
				'size'     => 10,
				'disabled' => true,
				'style'    => 'display:none',
			) );

		$return = '<div class="cherry-generator-isp">' . $sources . '<div class="cherry-generator-isp-source cherry-generator-isp-source-media"><div class="cherry-generator-clearfix"><a href="javascript:;" class="button button-primary cherry-generator-isp-add-media"><i class="fa fa-plus"></i>&nbsp;&nbsp;' . __( 'Add images', 'cherry-shortcodes' ) . '</a></div><div class="cherry-generator-isp-images cherry-generator-clearfix"><em class="description">' . __( 'Click the button above and select images.<br>You can select multimple images with Ctrl (Cmd) key', 'cherry-shortcodes' ) . '</em></div></div><div class="cherry-generator-isp-source cherry-generator-isp-source-category"><em class="description">' . __( 'Select categories to retrieve posts from.<br>You can select multiple categories with Ctrl (Cmd) key', 'cherry-shortcodes' ) . '</em>' . $categories . '</div><div class="cherry-generator-isp-source cherry-generator-isp-source-taxonomy"><em class="description">' . __( 'Select taxonomy and it\'s terms.<br>You can select multiple terms with Ctrl (Cmd) key', 'cherry-shortcodes' ) . '</em>' . $taxonomies . $terms . '</div><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="cherry-generator-attr-' . $id . '" class="cherry-generator-attr" /></div>';

		return $return;
	}

	/**
	 * Retrieve a `responsive` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `responsive` element.
	 */
	public static function responsive( $id, $field ) {

		if ( ! isset( $field['values'] ) ) :

			$count = 1;

			/**
			 * Filter a column number.
			 *
			 * @since 1.0.0
			 * @param int $grid_column
			 */
			$grid_column = apply_filters( 'cherry_shortcodes_grid_columns', 12 );
			$_values     = array( 'none' );

			while ( $count <= $grid_column ) {
				array_push( $_values, $count );
				$count++;
			}

			$values = array_values( $_values );
			$values = array_combine( $values, $values );

			$field['values'] = $values;

		endif;

		$field_xs = $field_sm = $field_md = $field_lg = $field;
		$field_xs['default'] = $field['default'][ $id . '_xs' ];
		$field_sm['default'] = $field['default'][ $id . '_sm' ];
		$field_md['default'] = $field['default'][ $id . '_md' ];
		$field_lg['default'] = $field['default'][ $id . '_lg' ];

		$return = '<div class="cherry-generator-responsive"><span class="cherry-generator-responsive-field">' . self::select( $id . '_xs', $field_xs ) . '<small>' . __( 'Extra small devices (Phones)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_sm', $field_sm ) . '<small>' . __( 'Small devices (Tablets)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_md', $field_md ) . '<small>' . __( 'Medium devices (Desktops)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_lg', $field_lg ) . '<small>' . __( 'Large devices (Desktops)', 'cherry-shortcodes' ) . '</small></span></div>';

		return $return;
	}

	/**
	 * Retrieve a `responsive_invert` interface element.
	 *
	 * @since  1.0.0
	 * @param  int|string $id    Element ID.
	 * @param  array      $field Element arguments.
	 * @return string            HTML-markup for `responsive_invert` element.
	 */
	public static function responsive_invert( $id, $field ) {

		if ( ! isset( $field['values'] ) ) :

			$count = ( $id === 'size' ) ? 1 : 0;

			/**
			 * Filter a column number.
			 *
			 * @since 1.0.0
			 * @param int $grid_column
			 */
			$grid_column = apply_filters( 'cherry_shortcodes_grid_columns', 12 );

			$_values = array();

			while ( $count <= $grid_column ) {
				array_push( $_values, $count );
				$count++;
			}

			$values = array_values( $_values );
			$keys   = array_reverse( $values );
			$values = array_merge( array( 'none' => 'none'), $values );
			$keys   = array_merge( array( 'none' => 'none'), $keys );

			$field['values'] = array_combine( $keys, $values );

		endif;

		$field['default'] = ( $field['default'] === 'none' ) ? array( 'none', 'none', 'none', 'none' ) : explode( ' ', $field['default'] );
		$field_0 = $field_1 = $field_2 = $field_3 = $field;

		for ( $i = 0; $i < count( $field['default'] ); $i++ ) {
			${'field_' . $i}['default'] = ( $field['default'][ $i ] == 'none' ) ? 'none' : absint( $field['default'][ $i ] );
		}

		$return = '<div class="cherry-generator-responsive"><span class="cherry-generator-responsive-field">' . self::select( $id . '_xs', $field_0 ) . '<small>' . __( 'Extra small devices (Phones)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_sm', $field_1 ) . '<small>' . __( 'Small devices (Tablets)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_md', $field_2 ) . '<small>' . __( 'Medium devices (Desktops)', 'cherry-shortcodes' ) . '</small></span><span class="cherry-generator-responsive-field">' . self::select( $id . '_lg', $field_3 ) . '<small>' . __( 'Large devices (Desktops)', 'cherry-shortcodes' ) . '</small></span></div>';

		return $return;
	}
}
