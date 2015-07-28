<?php
/**
 * Class for managing shortcodes callback-function.
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

class Cherry_Shortcodes_Handler {

	public static $post_data      = array();
	public static $macros_pattern = '/%%([a-zA-Z]+[^%]{2})(=[\'\"]([a-zA-Z0-9-_,\/\s]+)[\'\"])?%%/';

	public static $tabs = array();
	public static $tab_count = 0;

	function __construct() {}

	public static function button( $atts = null, $content = null ) {
		$atts = shortcode_atts(
			array(
				'text'            => __( 'Read More', 'cherry-shortcodes' ),
				'url'             => '#',
				'style'           => 'primary',
				'size'            => 'medium', // large, medium, small + filter
				'display'         => 'inline', // wide, inline
				'radius'          => 0,
				'centered'        => 'no',
				'fluid'           => 'no',
				'fluid_position'  => 'left',
				'icon'            => '',
				'icon_position'   => 'left',
				'desc'            => '',
				'bg_color'        => '',
				'color'           => '',
				'min_width'       => 0,
				'target'          => '_self',
				'rel'             => '',
				'hover_animation' => 'fade',
				'class'           => '',
			), $atts, 'button'
		);

		// Define button attributes array.
		$btn_atts = array();

		// Prepare button classes.
		$classes   = array();
		$base      = apply_filters( 'cherry_shortcodes_button_base_class', 'cherry-btn', $atts );
		$classes[] = $base;
		$classes[] = $base . '-' . esc_attr( $atts['style'] );
		$classes[] = $base . '-' . esc_attr( $atts['size'] );
		$classes[] = $base . '-' . esc_attr( $atts['display'] );
		$classes[] = $base . '-' . esc_attr( $atts['hover_animation'] );

		if ( 'yes' == esc_attr( $atts['fluid'] ) ) {
			$classes[] = $base . '-' . esc_attr( $atts['fluid_position'] );
		}

		if ( ! empty( $atts['class'] ) ) {
			$classes[] = esc_attr( $atts['class'] );
		}

		// Prepare button inline style.
		$inline_styles = array();

		if ( 0 != (int)$atts['radius'] ) {
			$inline_styles['border-radius'] = (int)$atts['radius'] . 'px';
		}
		if ( !empty($atts['bg_color']) ) {
			$inline_styles['background-color'] = esc_attr( $atts['bg_color'] );
		}
		if ( !empty($atts['color']) ) {
			$inline_styles['color'] = esc_attr( $atts['color'] );
		}
		if ( 0 != (int)$atts['min_width'] ) {
			$inline_styles['min-width'] = (int)$atts['min_width'] . 'px';
		}

		if ( !empty( $inline_styles ) ) {
			$attr_style = '';
			foreach ( $inline_styles as $property => $value ) {
				$attr_style .= $property . ':' . $value . ';';
			}
			unset( $property, $value );
			$btn_atts['style'] = $attr_style;
		}

		$btn_atts['class'] = implode( ' ', $classes );

		if ( ! empty( $atts['target'] ) && in_array( $atts['target'], array( '_self', '_blank' ) ) ) {
			$btn_atts['target'] = esc_attr( $atts['target'] );
		}

		if ( ! empty( $atts['rel'] ) ) {
			$btn_atts['rel'] = esc_attr( $atts['rel'] );
		}

		$btn_atts['href'] = esc_url( str_replace( '%home_url%', home_url(), $atts['url'] ) );

		/**
		 * Filter button attributes before adding to tag.
		 *
		 * @param array $btn_atts Default attributes.
		 * @param array $atts     Current shortcode attributes.
		 */
		$btn_atts = apply_filters( 'cherry_shortcodes_button_atts', $btn_atts, $atts );

		$btn_atts_string = '';

		if ( ! empty( $btn_atts ) && is_array( $btn_atts ) ) {
			foreach ( $btn_atts as $property => $value ) {
				$btn_atts_string .= ' ' . $property . '="' . esc_attr( $value ) . '"';
			}
		}

		$before = '';
		$after  = '';

		if ( 'yes' == $atts['centered'] ) {
			$custom_wraping = ( ! empty( $atts['class'] ) ) ? esc_attr( $atts['class'] ) . '-wrapper' : '';
			$before         = '<div class="aligncenter ' . $custom_wraping . '">';
			$after          = '</div>';
		}

		if ( 'yes' == $atts['fluid'] ) {
			$custom_wraping = ( ! empty( $atts['class'] ) ) ? esc_attr( $atts['class'] ) . '-wrapper' : '';
			$fluid_position = ( ! empty( $atts['fluid_position'] ) ) ? esc_attr( $atts['fluid_position'] ) : 'left';
			$before         = '<div class="fluid-button-' . $fluid_position . ' ' . $custom_wraping . '">';
			$after          = '</div>';
		}

		// Build icon.
		$icon = $atts['icon'];
		if ( ! empty( $atts['icon'] ) ) {
			$icon = Cherry_Shortcodes_Tools::get_icon_html(
				$atts['icon'], $base . '-icon icon-position-' . esc_attr( $atts['icon_position'] )
			);
		}

		$btn_text = sanitize_text_field( $atts['text'] );

		$desc_class = ( 'wide' == $atts['display'] ) ? ' desc-wide' : '';
		$desc       = sanitize_text_field( $atts['desc'] );

		$btn_desc = ( ! empty( $desc ) )
						? '<small class="' . $base . '-desc' . $desc_class . '">' . $desc . '</small>'
						: '';

		// Build open button element.
		$open_el = $before . '<a' . $btn_atts_string . '>';

		// Build button content.
		$btn_content = $btn_text . $btn_desc;

		$content_wrap_open  = '';
		$content_wrap_close = '';

		if ( in_array( $atts['icon_position'], array( 'left', 'right' ) ) ) {
			$content_wrap_open  = '<span class="' . $base . '-content-wrap">';
			$content_wrap_close = '</span>';
		}

		if ( ! empty( $icon ) && in_array( $atts['icon_position'], array( 'left', 'top' ) ) ) {
			$btn_content = $icon . $content_wrap_open . $btn_content . $content_wrap_close;
		} elseif ( ! empty( $icon ) && in_array( $atts['icon_position'], array( 'right', 'bottom' ) ) ) {
			$btn_content = $content_wrap_open . $btn_content . $content_wrap_close . $icon;
		}

		/**
		 * Filter button content before output.
		 *
		 * @param string $btn_content Default button content.
		 * @param array  $atts        Current shortcode attributes.
		 */
		$btn_content = apply_filters( 'cherry_shortcodes_button_content', $btn_content, $atts );

		// Build close button element.
		$close_el = '</a>' . $after;

		// Build final output.
		$output = $open_el . $btn_content . $close_el;

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'button' );
	}

	public static function hr( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'height'        => 1,
			'color'         => '#ddd',
			'indent_top'    => 20,
			'indent_bottom' => 20,
			'class'         => '',
		), $atts, 'hr' );

		$height        = absint( $atts['height'] );
		$color         = esc_attr( $atts['color'] );
		$indent_top    = absint( $atts['indent_top'] );
		$indent_bottom = absint( $atts['indent_bottom'] );
		$class         = esc_attr( $atts['class'] );

		$styles = array();
		$styles['height']           = ( 0 != $height ) ? $height . 'px' : '1px';
		$styles['margin-top']       = ( 0 != $indent_top ) ? $indent_top . 'px' : '20px';
		$styles['margin-bottom']    = ( 0 != $indent_bottom ) ? $indent_bottom . 'px' : '20px';
		$styles['background-color'] = $color;

		$style  = Cherry_Shortcodes_Tools::prepare_styles( $styles );
		$output = sprintf( '<div class="cherry-hr %s" style="%s"></div>', $class, $style );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'hr' );
	}

	public static function icon( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'icon'  => '',
			'size'  => 20,
			'color' => '',
			'class' => '',
		), $atts, 'icon' );

		if ( ! $atts['icon'] ) {
			return;
		}

		$style = array();
		$style['font-size'] = ( 0 != absint( $atts['size'] ) ) ? absint( $atts['size'] ) . 'px' : false;
		$style['color']     = ( !empty( $atts['color'] ) ) ? esc_attr( $atts['color'] ) : false;

		$class  = esc_attr( $atts['class'] );
		$output = Cherry_Shortcodes_Tools::get_icon_html( $atts['icon'], 'cherry-icon ' . $class, null, $style );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'icon' );
	}

	public static function banner( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'image'    => '',
			'title'    => '',
			'url'      => '',
			'color'    => '',
			'bg_color' => '',
			'class'    => '',
			'template' => 'default.tmpl',
		), $atts, 'banner' );

		$template_name = sanitize_file_name( $atts['template'] );

		// Item template's file.
		$template_file = self::get_template_path( $template_name, 'banner' );

		if ( false == $template_file ) {
			return '<h4>' . __( 'Template file (*.tmpl) not found', 'cherry-shortcodes' ) . '</h4>';
		}

		ob_start();
		require( $template_file );
		$template = ob_get_contents();
		ob_end_clean();

		$data = array( 'image', 'title', 'url', 'color', 'bgcolor', 'content' );
		self::setup_template_data( $data, $atts, $content );
		self::$post_data = array_merge( array( 'tag' => 'banner' ), self::$post_data );

		$result = preg_replace_callback( self::$macros_pattern, array( 'self', 'replace_callback' ), $template );
		$result = '<div class="cherry-banner ' . esc_attr( $atts['class'] ) . '">' . $result . '</div>';

		return apply_filters( 'cherry_shortcodes_output', $result, $atts, 'banner' );
	}

	public static function box( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'preset'        => '',
			'bg_color'      => '',
			'bg_image'      => '',
			'bg_position'   => 'center',
			'bg_repeat'     => 'no-repeat',
			'bg_attachment' => 'scroll',
			'fill'          => 'no',
			'class'         => '',
		), $atts, 'box' );

		$classes[] = 'cherry-box';
		$classes[] = esc_attr( $atts['class'] );

		// Prepare preset.
		if ( ! empty( $atts['preset'] ) ) {
			$preset_classes[] = 'box-' . esc_attr( $atts['preset'] );
		}

		if ( 'yes' === $atts['fill'] ) {
			$classes[] = 'row';
			$preset_classes[] = 'container-fluid';
		} else {
			$preset_classes[] = 'inner';
		}

		$classes = array_filter( $classes );
		$class   = implode( ' ', $classes );

		$preset_classes = array_filter( $preset_classes );
		$preset_class   = implode( ' ', $preset_classes );

		// Prepare CSS array.
		$styles = array();

		if ( ! empty( $atts['bg_image'] ) ) {

			$styles['background-image'] = esc_url( $atts['bg_image'] );

			$allowed_repeat     = array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' );
			$allowed_position   = array( 'top left', 'top center', 'top right', 'left', 'center', 'right', 'bottom left', 'bottom center', 'bottom right' );
			$allowed_attachment = array( 'fixed', 'scroll' );

			// Prepare image BG properties.
			$repeat = esc_attr( $atts['bg_repeat'] );
			$repeat = in_array( $repeat, $allowed_repeat ) ? $repeat : 'no-repeat';

			$position = str_replace( '-', ' ', esc_attr( $atts['bg_position'] ) );
			$position = in_array( $position, $allowed_position ) ? $position : 'center';

			$attachment = esc_attr( $atts['bg_attachment'] );
			$attachment = in_array( $attachment, $allowed_attachment ) ? $attachment : 'scroll';

			$styles['background-repeat']     = $repeat;
			$styles['background-position']   = $position;
			$styles['background-attachment'] = $attachment;
		}

		if ( ! empty( $atts['bg_color'] ) ) {
			$styles['background-color'] = esc_attr( $atts['bg_color'] );
		}

		$style  = Cherry_Shortcodes_Tools::prepare_styles( $styles );
		$format = '<div class="%s"><div class="%s" style="%s">%s</div></div>';
		$output = sprintf( $format, $class, $preset_class, $style, do_shortcode( $content ) );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'box' );
	}

	public static function box_inner( $atts = null, $content = null ) {
		$box_inner_class = apply_filters( 'cherry_box_inner_class', 'cherry-box-inner' );

		if ( empty( $atts['class'] ) ) {
			$atts = array_merge( $atts, array( 'class' => $box_inner_class ) );
		} else {
			$atts['class'] = $box_inner_class . ' ' . $atts['class'];
		}

		return self::box( $atts, $content );
	}

	public static function dropcap( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'font_size'   => 20,
			'canvas_size' => 30,
			'color'       => '',
			'background'  => '',
			'align'       => 'left',
			'shape'       => 'circle',
			'radius'      => 5,
			'border'      => 'none',
			'class'       => '',
		), $atts, 'dropcap' );

		$style = array();

		$font_size   = ( 0 != absint( $atts['font_size'] ) ) ? absint( $atts['font_size'] ) : 20;
		$canvas_size = ( 0 != absint( $atts['canvas_size'] ) ) ? absint( $atts['canvas_size'] ) : 30;

		preg_match( '/^(\d+)px.+$/', $atts['border'], $matches );
		if ( isset( $matches[1] ) ) {
			$border_width = absint( $matches[1] );
		} else {
			$border_width = 0;
		}

		$metric = $canvas_size + 2*$border_width;

		$radius = absint( $atts['radius'] );

		$style['font-size']     = $font_size . 'px';
		$style['width']         = $style['height'] = $metric . 'px';
		$style['line-height']   = $canvas_size . 'px';
		$style['color']         = ( !empty( $atts['color'] ) ) ? esc_attr( $atts['color'] ) : false;
		$style['background']    = ( !empty( $atts['background'] ) ) ? esc_attr( $atts['background'] ) : false;
		$style['border']        = esc_attr( $atts['border'] );
		$style['border-radius'] = $radius . 'px';

		$classes = array();

		$classes[] = 'cherry-dropcap';
		$classes[] = esc_attr( $atts['class'] );
		$classes[] = 'align-' . $atts['align'];

		$format  = '<div class="%1$s" style="%2$s">%3$s</div>';
		$classes = implode( ' ', $classes );
		$style   = Cherry_Shortcodes_Tools::prepare_styles( $style );
		$content = do_shortcode( $content );
		$output  = sprintf( $format, $classes, $style, $content );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'dropcap' );
	}

	public static function title_box( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'title'          => '',
			'subtitle'       => '',
			'icon'           => '',
			'icon_size'      => 20,
			'icon_color'     => '',
			'title_color'    => '',
			'subtitle_color' => '',
			'class'          => '',
		), $atts, 'title_box' );

		if ( ! $atts['title'] ) {
			return;
		}

		$format = apply_filters(
			'cherry_shortcodes_title_box_format',
			array(
				'global'   => '<div class="title-box %4$s">%3$s<div class="title-box_content"><h2 class="title-box_title">%1$s</h2>%2$s</div>%5$s</div>',
				'subtitle' => '<h4 class="title-box_subtitle">%s</h4>'
			),
			$atts
		);

		$style = array();

		$style['font-size'] = ( 0 != absint( $atts['icon_size'] ) ) ? absint( $atts['icon_size'] ) . 'px' : false;
		$style['color']     = ( !empty( $atts['icon_color'] ) ) ? esc_attr( $atts['icon_color'] ) : false;

		$icon = Cherry_Shortcodes_Tools::get_icon_html( $atts['icon'], 'title-box_icon', $atts['title'], $style );

		$uniq_class = 'title-box_' . rand(1000,9999);

		$title_color    = esc_attr( $atts['title_color'] );
		$subtitle_color = esc_attr( $atts['subtitle_color'] );

		$title_style  = '<style>';
		if ( $title_color ) {
			$title_style .= '.' . $uniq_class . ' .title-box_title { color: ' . $title_color . '; }';
		}
		if ( $subtitle_color ) {
			$title_style .= '.' . $uniq_class . ' .title-box_subtitle { color: ' . $subtitle_color . '; }';
		}
		$title_style .= '</style>';

		$title    = wp_kses( $atts['title'], 'default' );
		$subtitle = ( ! empty( $atts['subtitle'] ) )
						? sprintf( $format['subtitle'], wp_kses( $atts['subtitle'], 'default' ) )
						: '';
		$class    = esc_attr( $atts['class'] . ' ' . $uniq_class );

		$output = sprintf( $format['global'], $title, $subtitle, $icon, $class, $title_style );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'title_box' );
	}

	public static function spacer( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'size'  => '20',
			'class' => '',
		), $atts, 'spacer' );

		$size = intval( $atts['size'] );

		if ( 0 <= $size ) {
			$prop = 'height';
			$size = (string)$size . 'px';
		} else {
			$prop = 'margin-top';
			$size = (string)$size . 'px';
		}

		$output = '<div class="cherry-spacer' . cherry_esc_class_attr( $atts ) . '" style="' . $prop . ':' . $size . '"></div>';

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'spacer' );
	}

	public static function clear( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'class' => '',
		), $atts, 'clear' );

		$output = '<div class="cherry-clear' . cherry_esc_class_attr( $atts ) . '"></div>';

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'clear' );
	}

	public static function list_( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'icon'  => '',
			'class' => '',
		), $atts, 'list' );

		$icon_type  = ( false === strpos( $atts['icon'], 'icon:' ) ) ? 'image-icon' : 'font-icon';
		$uniq_class = 'cherry-list_' . rand( 1000, 9999 );

		$classes = array(
			'cherry-list',
			$icon_type,
			$uniq_class,
			cherry_esc_class_attr( $atts ),

		);

		$class = implode( ' ', $classes );

		$output  = '<div class="' . $class . '">';
		$output .= Cherry_Shortcodes_Tools::append_icons( $content, $atts['icon'] );
		if ( 'image-icon' == $icon_type ) {

			$style = '.' . $uniq_class . ' ul li:before {background-image: url(' . $atts['icon'] . '); }';

			$output .= sprintf( '<style>%s</style>', $style );
		}
		$output .= '</div>';

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'list' );
	}

	public static function row( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'type'		=> 'full-width',
			'class'		=> '',
			'anchor'	=> ''
		), $atts, 'row' );

		$id			= '';
		$type		= sanitize_key( $atts['type'] );
		$row_class	= apply_filters( 'cherry_shortcodes_output_row_class', 'row', $atts );
		$anchor_data = '';

		if( $atts[ 'anchor' ] ){
			$anchor = preg_replace( '/[^A-Za-z0-9-_]/', '',  $atts[ 'anchor' ] );
			$anchor = str_replace( ' ', '-', $anchor );

			$id = 'data-id="' . $anchor . '" ';
			$anchor_data = 'data-anchor="true"';

			wp_localize_script( 'page-anchor', 'anchor_scroll_speed', array( apply_filters( 'cherry_anchor_scroll_speed', 300 ) ) );
			cherry_query_asset( 'js', 'page-anchor' );
		}

		if ( 'fixed-width' == $type ){
			$container ='<div class="row' . cherry_esc_class_attr( $atts ) . '" ' . $id . $anchor_data . ' ><div class="container">%s</div></div>';
			$class = '';

			$id = '';
			$anchor_data = '';
		}else{
			$container = '%s';
			$class = cherry_esc_class_attr( $atts );
		}

		$output = '<div class="' . $row_class . ' ' . $class . '" ' . $id . $anchor_data . ' >' . do_shortcode( $content ) . '</div>';
		$output = sprintf( $container, $output );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'row' );
	}

	public static function row_inner( $atts = null, $content = null ) {
		return self::row( $atts, $content );
	}

	public static function col( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'size_xs'   => 'none',
			'size_sm'   => 'none',
			'size_md'   => 'none',
			'size_lg'   => 'none',
			'offset_xs' => 'none',
			'offset_sm' => 'none',
			'offset_md' => 'none',
			'offset_lg' => 'none',
			'pull_xs'   => 'none',
			'pull_sm'   => 'none',
			'pull_md'   => 'none',
			'pull_lg'   => 'none',
			'push_xs'   => 'none',
			'push_sm'   => 'none',
			'push_md'   => 'none',
			'push_lg'   => 'none',
			'collapse'  => 'no',
			'class'     => '',
		), $atts, 'col' );

		$class  = '';

		// Size
		$class .= ( 'none' == $atts['size_xs'] )   ? '' : ' col-xs-' . sanitize_key( $atts['size_xs'] );
		$class .= ( 'none' == $atts['size_sm'] )   ? '' : ' col-sm-' . sanitize_key( $atts['size_sm'] );
		$class .= ( 'none' == $atts['size_md'] )   ? '' : ' col-md-' . sanitize_key( $atts['size_md'] );
		$class .= ( 'none' == $atts['size_lg'] )   ? '' : ' col-lg-' . sanitize_key( $atts['size_lg'] );

		// Offset
		$class .= ( 'none' == $atts['offset_xs'] ) ? '' : ' col-xs-offset-' . sanitize_key( $atts['offset_xs'] );
		$class .= ( 'none' == $atts['offset_sm'] ) ? '' : ' col-sm-offset-' . sanitize_key( $atts['offset_sm'] );
		$class .= ( 'none' == $atts['offset_md'] ) ? '' : ' col-md-offset-' . sanitize_key( $atts['offset_md'] );
		$class .= ( 'none' == $atts['offset_lg'] ) ? '' : ' col-lg-offset-' . sanitize_key( $atts['offset_lg'] );

		// Pull
		$class .= ( 'none' == $atts['pull_xs']  )  ? '' : ' col-xs-pull-' . sanitize_key( $atts['pull_xs'] );
		$class .= ( 'none' == $atts['pull_sm']  )  ? '' : ' col-sm-pull-' . sanitize_key( $atts['pull_sm'] );
		$class .= ( 'none' == $atts['pull_md']  )  ? '' : ' col-md-pull-' . sanitize_key( $atts['pull_md'] );
		$class .= ( 'none' == $atts['pull_lg']  )  ? '' : ' col-lg-pull-' . sanitize_key( $atts['pull_lg'] );

		// Push
		$class .= ( 'none' == $atts['push_xs']  )  ? '' : ' col-xs-push-' . sanitize_key( $atts['push_xs'] );
		$class .= ( 'none' == $atts['push_sm']  )  ? '' : ' col-sm-push-' . sanitize_key( $atts['push_sm'] );
		$class .= ( 'none' == $atts['push_md']  )  ? '' : ' col-md-push-' . sanitize_key( $atts['push_md'] );
		$class .= ( 'none' == $atts['push_lg']  )  ? '' : ' col-lg-push-' . sanitize_key( $atts['push_lg'] );

		// Collapse?
		$class .= ( 'yes' != $atts['collapse']  )  ? '' : ' collapse-col';

		$output = '<div class="' . trim( esc_attr( $class ) ) . cherry_esc_class_attr( $atts ) . '">' . do_shortcode( $content ) . '</div>';
		$output = apply_filters( 'cherry_shortcodes_output', $output, $atts, 'col' );

		return $output;
	}

	public static function col_inner( $atts = null, $content = null ) {
		return self::col( $atts, $content );
	}

	public static function posts( $atts = null, $content = null ) {
		static $instance = 0;
		$instance++;

		// Parse attributes.
		$atts = shortcode_atts( array(
				'id'                  => false,
				'posts_per_page'      => get_option( 'posts_per_page' ),
				'post_type'           => 'post',
				'taxonomy'            => 'category',
				'tax_term'            => false,
				'tax_operator'        => 'IN',
				'author'              => '',
				'offset'              => 0,
				'order'               => 'DESC',
				'orderby'             => 'date',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'yes',
				'linked_title'        => 'yes',
				'linked_image'        => 'yes',
				'lightbox_image'      => 'yes',
				'image_size'          => 'thumbnail',
				'content_type'        => 'part',
				'content_length'      => 55,
				'button_text'         => __( 'read more', 'cherry-shortcodes' ),
				'col_xs'              => '12',
				'col_sm'              => '6',
				'col_md'              => '3',
				'col_lg'              => 'none',
				'class'               => '',
				'template'            => 'default.tmpl',
			), $atts, 'posts' );

		$original_atts = $atts;

		$atts['posts_per_page']      = intval( $atts['posts_per_page'] );
		$atts['post_type']           = sanitize_text_field( $atts['post_type'] );
		$atts['taxonomy']            = sanitize_key( $atts['taxonomy'] );
		$atts['tax_term']            = sanitize_text_field( $atts['tax_term'] );
		$atts['author']              = sanitize_text_field( $atts['author'] );
		$atts['offset']              = intval( $atts['offset'] );
		$atts['order']               = sanitize_key( $atts['order'] );
		$atts['orderby']             = sanitize_key( $atts['orderby'] );
		$atts['ignore_sticky_posts'] = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$atts['col_xs']              = sanitize_key( $atts['col_xs'] );
		$atts['col_sm']              = sanitize_key( $atts['col_sm'] );
		$atts['col_md']              = sanitize_key( $atts['col_md'] );
		$atts['col_lg']              = sanitize_key( $atts['col_lg'] );
		$atts['template']            = sanitize_file_name( $atts['template'] );
		$post_types                  = explode( ',', $atts['post_type'] );
		$post_status                 = explode( ', ', $atts['post_status'] );

		// Set up initial query for post.
		$args = array(
			'category_name'  => '',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
			'post_type'      => $post_types,
			'posts_per_page' => $atts['posts_per_page'],
		);

		// Ignore Sticky Posts.
		if ( $atts['ignore_sticky_posts'] ) {
			$args['ignore_sticky_posts'] = true;
		}

		// If Post IDs
		if ( $atts['id'] ) {
			$posts_in = array_map( 'intval', explode( ',', $atts['id'] ) );
			$args['post__in'] = $posts_in;
		}

		// Post Author
		if ( !empty( $atts['author'] ) ) {
			$args['author'] = $atts['author'];
		}

		// Offset
		if ( !empty( $atts['offset'] ) ) {
			$args['offset'] = $atts['offset'];
		}

		// Post Status
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );

		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) {
				$validated[] = $unvalidated;
			}
		}

		if ( !empty( $validated ) ) {
			$args['post_status'] = $validated;
			$args['perm']        = 'readable';
		}

		// If taxonomy attributes, create a taxonomy query.
		if ( !empty( $atts['taxonomy'] ) && !empty( $atts['tax_term'] ) ) {

			// Term string to array.
			$tax_term = explode( ',', $atts['tax_term'] );

			// Taxonomy operator.
			$tax_operator = $atts['tax_operator'];

			// Validate operator.
			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
				$tax_operator = 'IN';
			}
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $atts['taxonomy'],
						'field'    => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms'    => $tax_term,
						'operator' => $tax_operator ) ) );

			// Check for multiple taxonomy queries.
			$count = 2;
			$more_tax_queries = false;

			while ( isset( $original_atts['taxonomy_' . $count] )
				&& !empty( $original_atts['taxonomy_' . $count] )
				&& isset( $original_atts['tax_' . $count . '_term'] )
				&& !empty( $original_atts['tax_' . $count . '_term'] )
				) {

				// Sanitize values.
				$more_tax_queries = true;
				$taxonomy         = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms            = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator     = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts['tax_' . $count . '_operator'] : 'IN';
				$tax_operator     = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $tax_operator,
				);
				$count++;
			}

			if ( $more_tax_queries ) :

				$tax_relation = 'AND';

				if ( isset( $original_atts['tax_relation'] )
					&& in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
					) {
					$tax_relation = $original_atts['tax_relation'];
				}

				$args['tax_query']['relation'] = $tax_relation;

			endif;

			$args = array_merge( $args, $tax_args );
		}

		// If post parent attribute, set up parent.
		if ( $atts['post_parent'] ) {
			if ( 'current' == $atts['post_parent'] ) {
				global $post;
				$atts['post_parent'] = $post->ID;
			}
			$args['post_parent'] = intval( $atts['post_parent'] );
		}

		// Exclude current post/page (fix aborting).
		if ( in_array( get_post_type(), (array) $post_types ) && ( 'full' === $atts['content_type'] ) ) {
			$args['post__not_in'] = array( get_the_ID() );
		}

		/**
		 * Filter the array of arguments for query.
		 *
		 * @since 1.0.0
		 * @param array $args Query arguments.
		 * @param array $atts Shortcode attributes.
		 */
		$args = apply_filters( 'cherry_shortcode_posts_query_args', $args, $atts );

		// Query posts.
		$posts_query = new WP_Query( $args );

		// Prepare string for outputing.
		$output = '';

		if ( $posts_query->have_posts() ) {

			// Item template's file.
			$template_file = self::get_template_path( $atts['template'], 'posts' );

			if ( false == $template_file ) {
				return '<h4>' . __( 'Template file (*.tmpl) not found', 'cherry-shortcodes' ) . '</h4>';
			}

			ob_start();
			require( $template_file );
			$template = ob_get_contents();
			ob_end_clean();

			// Grid columns.
			$grid_columns = apply_filters( 'cherry_shortcodes_grid_columns', 12 );

			// Prepare the main CSS classes for item's.
			$main_item_classes   = array();
			$main_item_classes[] = 'cherry-posts-item';

			// Columns & Clear.
			$col_xs_clear = $col_sm_clear = $col_md_clear = $col_lg_clear = 0;

			if ( 'none' !== $atts['col_xs'] && $atts['col_xs'] ) {
				$col_xs       = intval( $atts['col_xs'] );
				$col_xs_clear = $grid_columns / $col_xs;
				$main_item_classes['col-xs'] = 'col-xs-' . $col_xs;
			}

			if ( 'none' !== $atts['col_sm'] && $atts['col_sm'] ) {
				$col_sm       = intval( $atts['col_sm'] );
				$col_sm_clear = $grid_columns / $col_sm;
				$main_item_classes['col-sm'] = 'col-sm-' . $col_sm;
			}

			if ( 'none' !== $atts['col_md'] && $atts['col_md'] ) {
				$col_md       = intval( $atts['col_md'] );
				$col_md_clear = $grid_columns / $col_md;
				$main_item_classes['col-md'] = 'col-md-' . $col_md;
			}

			if ( 'none' !== $atts['col_lg'] && $atts['col_lg'] ) {
				$col_lg       = intval( $atts['col_lg'] );
				$col_lg_clear = $grid_columns / $col_lg;
				$main_item_classes['col-lg'] = 'col-lg-' . $col_lg;
			}

			// Posts counter.
			$current_post = 0;

			$data = array( 'image', 'title', 'date', 'author', 'comments', 'taxonomy', 'excerpt', 'content', 'button' );
			self::setup_template_data( $data, $atts );
			self::$post_data = array_merge( array( 'tag' => 'posts' ), self::$post_data );

			while ( $posts_query->have_posts() ) :
				$posts_query->the_post();

				// Prepare a data.
				$tpl       = $template;
				$post_id   = get_the_ID();
				$post_type = get_post_type( $post_id );

				// If post is set to private, only show to logged in users.
				if ( 'private' == get_post_status( $post_id ) && ! current_user_can( 'read_private_posts' ) ) {
					continue;
				}

				/**
				 * Filters the array with a current post data.
				 *
				 * @since 1.0.0
				 * @param array  $_postdata Array with a current post data.
				 * @param int    $post_id   Post ID.
				 * @param array  $atts      Shortcode attributes.
				 */
				self::$post_data = apply_filters( 'cherry_shortcode_posts_postdata', self::$post_data, $post_id, $atts );

				// Perform a regular expression.
				$tpl = preg_replace_callback( self::$macros_pattern, array( 'self', 'replace_callback' ), $tpl );

				// Prepare the CSS classes for item's.
				$item_classes   = array();
				$item_classes[] = $post_type . '-item';
				$item_classes[] = 'item-' . $current_post;
				$item_classes[] = ( $current_post % 2 ) ? 'even' : 'odd';

				/**
				 * Filters the CSS classes for item's.
				 *
				 * @since 1.0.0
				 * @param array $item_classes An array of classes.
				 * @param array $atts         Shortcode attributes.
				 * @param int   $post_id      Post ID.
				 */
				$item_classes = apply_filters( 'cherry_shortcode_posts_item_classes', $item_classes, $atts, $post_id );
				$item_classes = array_unique( $item_classes );
				$item_classes = array_map( 'sanitize_html_class', $item_classes );

				// Prepare the CSS classes for clear.
				$clear_classes = array();

				if ( $col_xs_clear ) {
					if ( 0 === ( $col_xs_clear - ( $current_post + 1 ) ) % $col_xs_clear ) {
						$clear_classes[] = 'cherry-xs-clear';
					}
				}

				if ( $col_sm_clear ) {
					if ( 0 === ( $col_sm_clear - ( $current_post + 1 ) ) % $col_sm_clear ) {
						$clear_classes[] = 'cherry-sm-clear';
					}
				}

				if ( $col_md_clear ) {
					if ( 0 === ( $col_md_clear - ( $current_post + 1 ) ) % $col_md_clear ) {
						$clear_classes[] = 'cherry-md-clear';
					}
				}

				if ( $col_lg_clear ) {
					if ( 0 === ( $col_lg_clear - ( $current_post + 1 ) ) % $col_lg_clear ) {
						$clear_classes[] = 'cherry-lg-clear';
					}
				}

				$clear_classes = apply_filters( 'cherry_shortcode_posts_clear_classes', $clear_classes, $atts, $post_id );
				$clear_classes = array_unique( $clear_classes );
				$clear_classes = array_map( 'sanitize_html_class', $clear_classes );

				/**
				 * Filters the HTML-wrap with item's content.
				 *
				 * @since 1.0.0
				 * @param string $item         HTML-formatted item's wrapper.
				 * @param int    $current_post Index of the post currently being displayed.
				 * @param array  $atts         Shortcode attributes.
				 * @param int    $post_id      Post ID.
				 */
				$item = apply_filters(
					'cherry_shortcode_posts_item',
					'<div class="%1$s %2$s"><div class="inner cherry-clearfix">%3$s</div></div>%4$s',
					$posts_query->current_post,
					$atts,
					$post_id
				);

				$clear = '';
				if ( ! empty( $clear_classes ) ) {
					$clear = sprintf( '<div class="%s"></div>', join( ' ', $clear_classes ) );
				}

				$output .= sprintf(
					$item,
					join( ' ', $main_item_classes ),
					join( ' ', $item_classes ),
					$tpl,
					$clear
				);
				$output .= '<!--/.cherry-posts-item-->';

				$current_post++;

			endwhile;

			// Prepare the CSS classes for list.
			$wrap_classes        = array();
			$wrap_classes[]      = 'cherry-posts-list';
			$wrap_classes['row'] = 'row';

			if ( $atts['class'] ) {
				$wrap_classes[] = esc_attr( $atts['class'] );
			}

			/**
			 * Filters the CSS classes for list.
			 *
			 * @since 1.0.0
			 * @param array $wrap_classes An array of classes.
			 * @param array $atts         Shortcode attributes.
			 */
			$wrap_classes = apply_filters( 'cherry_shortcode_posts_list_classes', $wrap_classes, $atts );
			$wrap_classes = array_unique( $wrap_classes );

			/**
			 * Filters the HTML-wrap with list content.
			 *
			 * @since 1.0.0
			 * @param string $wrap HTML-formatted list wrapper.
			 * @param array  $atts Shortcode attributes.
			 */
			$wrap = apply_filters(
				'cherry_shortcode_posts_list',
				'<div id="cherry-posts-list-%1$d" class="%2$s">%3$s</div>',
				$atts
			);

			$output = sprintf( $wrap, $instance, join( ' ', $wrap_classes ), $output );
			$output .= '<!--/.cherry-posts-list-->';

		} else {
			return '<h4>' . __( 'Posts not found', 'cherry-shortcodes' ) . '</h4>';
		}

		// Reset the query.
		wp_reset_postdata();

		/**
		 * Filters $output before return.
		 *
		 * @since 1.0.0
		 * @param string $output
		 * @param array  $atts
		 * @param string $shortcode
		 */
		$output = apply_filters( 'cherry_shortcodes_output', $output, $atts, 'posts' );

		return $output;
	}

	public static function swiper_carousel( $atts = null, $content = null ) {
		static $instance = 0;
		$instance++;

		// Parse attributes.
		$atts = shortcode_atts( array(
			'id'                         => false,
			'posts_per_page'             => get_option( 'posts_per_page' ),
			'post_type'                  => 'post',
			'taxonomy'                   => 'category',
			'tax_term'                   => false,
			'tax_operator'               => 'IN',
			'author'                     => '',
			'offset'                     => 0,
			'order'                      => 'DESC',
			'orderby'                    => 'date',
			'post_parent'                => false,
			'post_status'                => 'publish',
			'ignore_sticky_posts'        => 'no',
			'linked_title'               => 'yes',
			'linked_image'               => 'yes',
			'content_type'               => 'part',
			'content_length'             => 55,
			'button_text'                => __( 'read more', 'cherry-shortcodes' ),
			'class'                      => '',
			'template'                   => 'default.tmpl',
			'crop_image'                 => 'no',
			'crop_width'                 => 540,
			'crop_height'                => 320,
			'slides_per_view'            => 3,
			'slides_per_group'           => 1,
			'slides_per_column'          => 1,
			'space_between_slides'       => 10,
			'swiper_duration_speed'      => 300,
			'swiper_loop'                => 'yes',
			'swiper_free_mode'           => 'no',
			'swiper_grab_cursor'         => 'yes',
			'swiper_mouse_wheel'         => 'no',
			'swiper_centered_slide'      => 'no',
			'swiper_effect'              => 'slide',
			'swiper_pagination'          => 'yes',
			'swiper_navigation'          => 'yes',
			'swiper_navigation_position' => 'inner',
		), $atts, 'swiper_carousel' );

		$id                         = $atts['id'];
		$posts_per_page             = intval( $atts['posts_per_page'] );
		$post_type                  = sanitize_text_field( $atts['post_type'] );
		$post_type                  = explode( ',', $post_type );
		$taxonomy                   = sanitize_key( $atts['taxonomy'] );
		$tax_term                   = sanitize_text_field( $atts['tax_term'] );
		$tax_operator               = $atts['tax_operator'];
		$author                     = sanitize_text_field( $atts['author'] );
		$offset                     = intval( $atts['offset'] );
		$order                      = sanitize_key( $atts['order'] );
		$orderby                    = sanitize_key( $atts['orderby'] );
		$post_parent                = $atts['post_parent'];
		$post_status                = $atts['post_status'];
		$ignore_sticky_posts        = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$template_name              = sanitize_file_name( $atts['template'] );
		$crop_image                 = ( bool ) ( $atts['crop_image'] === 'yes' ) ? true : false;
		$crop_width                 = intval( $atts['crop_width'] );
		$crop_height                = intval( $atts['crop_height'] );
		$slides_per_view            = intval( $atts['slides_per_view'] );
		$slides_per_group           = intval( $atts['slides_per_group'] );
		$slides_per_column          = intval( $atts['slides_per_column'] );
		$space_between_slides       = intval( $atts['space_between_slides'] );
		$swiper_duration_speed      = intval( $atts['swiper_duration_speed'] );
		$swiper_loop                = ( bool ) ( $atts['swiper_loop'] === 'yes' ) ? true : false;
		$swiper_free_mode           = ( bool ) ( $atts['swiper_free_mode'] === 'yes' ) ? true : false;
		$swiper_grab_cursor         = ( bool ) ( $atts['swiper_grab_cursor'] === 'yes' ) ? true : false;
		$swiper_mouse_wheel         = ( bool ) ( $atts['swiper_mouse_wheel'] === 'yes' ) ? true : false;
		$swiper_centered_slide      = ( bool ) ( $atts['swiper_centered_slide'] === 'yes' ) ? true : false;
		$swiper_effect              = sanitize_text_field( $atts['swiper_effect'] );
		$swiper_pagination          = ( bool ) ( $atts['swiper_pagination'] === 'yes' ) ? true : false;
		$swiper_navigation          = ( bool ) ( $atts['swiper_navigation'] === 'yes' ) ? true : false;
		$swiper_navigation_position = $atts['swiper_navigation_position'];

		// Set up initial query for post.
		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
		);

		// Ignore Sticky Posts.
		if ( $ignore_sticky_posts ) {
			$args['ignore_sticky_posts'] = true;
		}

		// If Post IDs
		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}

		// Post Author
		if ( !empty( $author ) ) {
			$args['author'] = $author;
		}

		// Offset
		if ( !empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		// Post Status
		$post_status = explode( ', ', $post_status );
		$validated   = array();
		$available   = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );

		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) {
				$validated[] = $unvalidated;
			}
		}
		if ( !empty( $validated ) ) {
			$args['post_status'] = $validated;
			$args['perm']        = 'readable';
		}

		// If taxonomy attributes, create a taxonomy query.
		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {

			// Term string to array.
			$tax_term = explode( ',', $tax_term );

			// Validate operator.
			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
				$tax_operator = 'IN';
			}
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $taxonomy,
						'field'    => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms'    => $tax_term,
						'operator' => $tax_operator ) ) );

			// Check for multiple taxonomy queries.
			$count = 2;
			$more_tax_queries = false;

			while ( isset( $original_atts['taxonomy_' . $count] )
				&& !empty( $original_atts['taxonomy_' . $count] )
				&& isset( $original_atts['tax_' . $count . '_term'] )
				&& !empty( $original_atts['tax_' . $count . '_term'] )
				) {

				// Sanitize values.
				$more_tax_queries = true;
				$taxonomy         = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms            = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator     = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts['tax_' . $count . '_operator'] : 'IN';
				$tax_operator     = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $tax_operator,
				);
				$count++;
			}

			if ( $more_tax_queries ) :

				$tax_relation = 'AND';

				if ( isset( $original_atts['tax_relation'] )
					&& in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
					) {
					$tax_relation = $original_atts['tax_relation'];
				}

				$args['tax_query']['relation'] = $tax_relation;

			endif;

			$args = array_merge( $args, $tax_args );
		}

		// If post parent attribute, set up parent.
		if ( $post_parent ) {
			if ( 'current' == $post_parent ) {
				global $post;
				$post_parent = $post->ID;
			}
			$args['post_parent'] = intval( $post_parent );
		}

		// Exclude current post/page (fix aborting).
		if ( in_array( get_post_type(), (array) $post_type ) && ( 'full' === $content_type ) ) {
			$args['post__not_in'] = array( get_the_ID() );
		}

		/**
		 * Filter the array of arguments for query.
		 *
		 * @since 1.0.0
		 * @param array $args Query arguments.
		 * @param array $atts Shortcode attributes.
		 */
		$args = apply_filters( 'cherry_shortcode_swiper_carousel_query_args', $args, $atts );

		// Query posts.
		$posts_query = new WP_Query( $args );

		// Prepare string for outputing.
		$output = '';

		if ( $posts_query->have_posts() ) {

			// Item template's file.
			$template_file = self::get_template_path( $template_name, 'swiper_carousel' );

			if ( false == $template_file ) {
				return '<h4>' . __( 'Template file (*.tmpl) not found', 'cherry-shortcodes' ) . '</h4>';
			}

			ob_start();
			require( $template_file );
			$template = ob_get_contents();
			ob_end_clean();

			// Default macros-array.
			$data = array( 'image', 'title', 'date', 'author', 'comments', 'taxonomy', 'excerpt', 'content', 'button' );
			self::setup_template_data( $data, $atts );
			self::$post_data = array_merge( array( 'tag' => 'swiper_carousel' ), self::$post_data );

			while ( $posts_query->have_posts() ) :
				$posts_query->the_post();

				// Prepare a data.
				$tpl        = $template;
				$post_id    = get_the_ID();
				$post_type  = get_post_type( $post_id );

				// If post is set to private, only show to logged in users.
				if ( 'private' == get_post_status( $post_id ) && ! current_user_can( 'read_private_posts' ) ) {
					continue;
				}

				/**
				 * Filters the array with a current post data.
				 *
				 * @since 1.0.0
				 * @param array  $_postdata Array with a current post data.
				 * @param int    $post_id   Post ID.
				 * @param array  $atts      Shortcode attributes.
				 */
				self::$post_data = apply_filters( 'cherry-shortcode-swiper-carousel-postdata', self::$post_data, $post_id, $atts );

				// Perform a regular expression.
				$tpl = preg_replace_callback( self::$macros_pattern, array( 'self', 'replace_callback' ), $tpl );

				// Prepare the CSS classes for item's.
				$item_classes   = array();
				$item_classes[] = 'cherry-swiper-carousel-slide';
				$item_classes[] = 'swiper-slide';
				$item_classes[] = 'post-item';
				$item_classes[] = $post_type . '-item';
				$item_classes[] = 'item-' . $posts_query->current_post;
				$item_classes[] = ( $posts_query->current_post % 2 ) ? 'even' : 'odd';

				/**
				 * Filters the CSS classes for item's.
				 *
				 * @since 1.0.0
				 * @param array $item_classes An array of classes.
				 * @param array $atts         Shortcode attributes.
				 * @param int   $post_id      Post ID.
				 */
				$item_classes = apply_filters( 'cherry_shortcode_swiper_carousel_item_classes', $item_classes, $atts, $post_id );
				$item_classes = array_unique( $item_classes );
				$item_classes = array_map( 'sanitize_html_class', $item_classes );

				/**
				 * Filters the HTML-wrap with item's content.
				 *
				 * @since 1.0.0
				 * @param string $item         HTML-formatted item's wrapper.
				 * @param int    $current_post Index of the post currently being displayed.
				 * @param array  $atts         Shortcode attributes.
				 * @param int    $post_id      Post ID.
				 */
				$item = apply_filters(
					'cherry_shortcode_swiper_carousel_slide',
					'<article class="%1$s"><div class="inner clearfix">%2$s</div></article>',
					$posts_query->current_post,
					$atts,
					$post_id
				);

				$output .= sprintf( $item, join( ' ', $item_classes ), $tpl );
				$output .= '<!--/.cherry-swiper-carousel-item-->';

			endwhile;

			// Prepare the CSS classes for list.
			$wrap_classes   = array();
			$wrap_classes[] = 'cherry-swiper-carousel';
			$wrap_classes[] = 'swiper-container';

			if ( $atts['class'] ) {
				$wrap_classes[] = esc_attr( $atts['class'] );
			}

			/**
			 * Filters the CSS classes for list.
			 *
			 * @since 1.0.0
			 * @param array $wrap_classes An array of classes.
			 * @param array $atts         Shortcode attributes.
			 */
			$wrap_classes = apply_filters( 'cherry_shortcode_posts_list_classes', $wrap_classes, $atts );
			$wrap_classes = array_unique( $wrap_classes );
			$wrap_classes = array_map( 'sanitize_html_class', $wrap_classes );

			$data_attr_line = '';
			$data_attr_line .= 'data-slides-per-view="' . $slides_per_view . '"';
			$data_attr_line .= 'data-slides-per-group="' . $slides_per_group . '"';
			$data_attr_line .= 'data-slides-per-column="' . $slides_per_column . '"';
			$data_attr_line .= 'data-space-between-slides="' . $space_between_slides . '"';
			$data_attr_line .= 'data-duration-speed="' . $swiper_duration_speed . '"';
			$data_attr_line .= 'data-swiper-loop="' . $swiper_loop . '"';
			$data_attr_line .= 'data-free-mode="' . $swiper_free_mode . '"';
			$data_attr_line .= 'data-grab-cursor="' . $swiper_grab_cursor . '"';
			$data_attr_line .= 'data-mouse-wheel="' . $swiper_mouse_wheel . '"';
			$data_attr_line .= 'data-centered-slide="' . $swiper_centered_slide . '"';
			$data_attr_line .= 'data-swiper-effect="' . $swiper_effect . '"';
			$data_attr_line .= 'data-uniq-id="swiper-carousel-' . $instance . '"';

			( $swiper_navigation_position == 'outer' ) ? $outer_class = 'outer' : $outer_class = '';

			$swiper_pagination_html = ( true == $swiper_pagination)  ? '<div id="swiper-carousel-'. $instance . '-pagination" class="swiper-pagination"></div>' : '';
			$swiper_navigation_html = ( true == $swiper_navigation ) ? '<div id="swiper-carousel-'. $instance . '-next" class="swiper-button-next ' . $outer_class . '"></div><div id="swiper-carousel-'. $instance . '-prev" class="swiper-button-prev ' . $outer_class . '"></div>' : '';

			/**
			 * Filters the HTML-wrap with list content.
			 *
			 * @since 1.0.0
			 * @param string $wrap HTML-formatted list wrapper.
			 * @param array  $atts Shortcode attributes.
			 */
			$wrap = apply_filters(
				'cherry_shortcode_swiper_carousel_list',
				'<div class="cherry-swiper-carousel-container"><section id="cherry-swiper-carousel-%1$d" class="%2$s" %3$s><div class="swiper-wrapper">%4$s</div>%5$s</section>%6$s</div>',
				$atts
			);

			$output = sprintf( $wrap, $instance, join( ' ', $wrap_classes ), $data_attr_line, $output, $swiper_pagination_html, $swiper_navigation_html );

		} else {
			return '<h4>' . __( 'Posts not found', 'cherry-shortcodes' ) . '</h4>';
		}

		// Reset the query.
		wp_reset_postdata();

		cherry_query_asset( 'js', array( 'swiper', 'cherry-shortcodes-init' ) );

		$output = apply_filters( 'cherry_shortcodes_output', $output, $atts, 'swiper_carousel' );

		return $output;
	}

	public static function tabs( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'active'   => 1,
				'vertical' => 'no',
				'style'    => 'default', // 3.x
				'class'    => '',
			), $atts, 'tabs' );

		if ( $atts['style'] === '3' ) $atts['vertical'] = 'yes';

		do_shortcode( $content );

		$return = '';
		$tabs   = $panes = array();

		if ( is_array( self::$tabs ) ) {
			if ( self::$tab_count < $atts['active'] ) $atts['active'] = self::$tab_count;
			foreach ( self::$tabs as $tab ) {
				$tabs[] = '<span class="' . cherry_esc_class_attr( $tab ) . $tab['disabled'] . '"' . $tab['anchor'] . $tab['url'] . $tab['target'] . '>' . esc_attr( $tab['title'] ) . '</span>';
				$panes[] = '<div class="cherry-tabs-pane cherry-clearfix' . cherry_esc_class_attr( $tab ) . '">' . $tab['content'] . '</div>';
			}
			$atts['vertical'] = ( $atts['vertical'] === 'yes' ) ? ' cherry-tabs-vertical' : '';
			$return = '<div class="cherry-tabs cherry-tabs-style-' . $atts['style'] . $atts['vertical'] . cherry_esc_class_attr( $atts ) . '" data-active="' . (string) $atts['active'] . '"><div class="cherry-tabs-nav">' . implode( '', $tabs ) . '</div><div class="cherry-tabs-panes">' . implode( "\n", $panes ) . '</div></div>';
		}

		// Reset tabs
		self::$tabs = array();
		self::$tab_count = 0;

		cherry_query_asset( 'js', 'cherry-shortcodes-init' );

		return apply_filters( 'cherry_shortcodes_output', $return, $atts, 'tabs' );
	}

	public static function tab( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'    => __( 'Tab title', 'cherry-shortcodes' ),
				'disabled' => 'no',
				'anchor'   => '',
				'url'      => '',
				'target'   => 'blank',
				'class'    => '',
			), $atts, 'tab' );

		$x = self::$tab_count;

		self::$tabs[$x] = array(
			'title'    => $atts['title'],
			'content'  => do_shortcode( $content ),
			'disabled' => ( $atts['disabled'] === 'yes' ) ? ' cherry-tabs-disabled' : '',
			'anchor'   => ( $atts['anchor'] ) ? ' data-anchor="' . str_replace( array( ' ', '#' ), '', sanitize_text_field( $atts['anchor'] ) ) . '"' : '',
			'url'      => ' data-url="' . $atts['url'] . '"',
			'target'   => ' data-target="' . $atts['target'] . '"',
			'class'    => $atts['class'],
		);

		self::$tab_count++;
		do_action( 'cherry_shortcodes/shortcode/tab', $atts );
	}

	public static function spoiler( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'  => __( 'Spoiler title', 'cherry-shortcodes' ),
				'open'   => 'no',
				'style'  => 'default',
				'anchor' => '',
				'class'  => '',
			), $atts, 'spoiler' );

		$atts['style'] = str_replace( array( '1', '2' ), array( 'default', 'fancy' ), $atts['style'] );
		$atts['anchor'] = ( $atts['anchor'] ) ? ' data-anchor="' . str_replace( array( ' ', '#' ), '', sanitize_text_field( $atts['anchor'] ) ) . '"' : '';

		if ( $atts['open'] !== 'yes' ) $atts['class'] .= ' cherry-spoiler-closed';

		cherry_query_asset( 'js', 'cherry-shortcodes-init' );

		$output = '<div class="cherry-spoiler cherry-spoiler-style-' . $atts['style'] . cherry_esc_class_attr( $atts ) . '"' . $atts['anchor'] . '><div class="cherry-spoiler-title">' . esc_attr( $atts['title'] ) . '</div><div class="cherry-spoiler-content cherry-clearfix" style="display:none">' . do_shortcode( $content ) . '</div></div>';

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'spoiler' );
	}

	public static function accordion( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'class' => ''
			), $atts, 'accordion' );

		$output = '<div class="cherry-accordion' . cherry_esc_class_attr( $atts ) . '">' . do_shortcode( $content ) . '</div>';

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'accordion' );
	}

	public static function google_map( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'geo_address'   => '',
			'lat_value'     => '41.850033',
			'lng_value'     => '-87.6500523',
			'zoom_value'    => '4',
			'scroll_wheel'  => 'no',
			'map_style'     => 'blue-water',
			'map_height'    => '400',
			'pan_control'   => 'yes',
			'zoom_control'  => 'yes',
			'map_draggable' => 'yes',
			'map_marker'    => '',
			'custom_class'  => '',
		), $atts, 'google_map' );

		$random_id     = rand();
		$lat_value     = floatval( $atts['lat_value'] );
		$lng_value     = floatval( $atts['lng_value'] );
		$zoom_value    = floatval( $atts['zoom_value'] );
		$map_height    = intval( $atts['map_height'] );
		$pan_control   = ( bool ) ( $atts['pan_control']   === 'yes' ) ? true : false;
		$zoom_control  = ( bool ) ( $atts['zoom_control']  === 'yes' ) ? true : false;
		$map_draggable = ( bool ) ( $atts['map_draggable'] === 'yes' ) ? apply_filters( 'cherry_shortcodes_google_map_draggable', ! wp_is_mobile(), $atts ) : false;
		$scroll_wheel  = ( bool ) ( $atts['scroll_wheel']  === 'yes' ) ? true : false;
		$addr          = sanitize_text_field( $atts['geo_address'] );
		$map_style     = sanitize_text_field( $atts['map_style'] );
		$custom_class  = sanitize_text_field( $atts['custom_class'] );
		$map_marker    = sanitize_text_field( $atts['map_marker'] );
		$marker_desc   = do_shortcode( $content );
		$style         = Cherry_Shortcodes_Tools::get_map_style_json( $map_style );

		if ( '' !== $addr ) {
			$geo_position = Cherry_Shortcodes_Tools::google_geocoding( $addr );
			$lat_value    = floatval( $geo_position['lat'] );
			$lng_value    = floatval( $geo_position['lng'] );
		}

		$map_marker_attachment_id = Cherry_Shortcodes_Tools::get_attachment_id_from_src( $map_marker );

		if ( isset( $map_marker_attachment_id ) ) {
			$map_marker = wp_get_attachment_image_src( $map_marker_attachment_id );
			$map_marker = json_encode( $map_marker );
		} else {
			$map_marker = 'default';
		}

		$data_attr_line = '';
			$data_attr_line .= 'data-map-id="google-map-' . $random_id . '"';
			$data_attr_line .= 'data-lat-value="' . $lat_value . '"';
			$data_attr_line .= 'data-lng-value="' . $lng_value . '"';
			$data_attr_line .= 'data-zoom-value="' . $zoom_value . '"';
			$data_attr_line .= 'data-scroll-wheel="' . $scroll_wheel . '"';
			$data_attr_line .= 'data-pan-control="' . $pan_control . '"';
			$data_attr_line .= 'data-zoom-control="' . $zoom_control . '"';
			$data_attr_line .= 'data-map-draggable="' . $map_draggable . '"';
			$data_attr_line .= "data-map-marker='" . $map_marker . "'";
			$data_attr_line .= "data-map-style='" . $style . "'";

		$html = '<div class="google-map-container ' . $custom_class.'" style="height:' . $map_height . 'px;" ' . $data_attr_line . '>';
			$html .= '<div id="google-map-' . $random_id . '" class="google-map"></div>';
			$html .= '<div class="marker-desc">' . $marker_desc . '</div>';
		$html .= '</div>';

		cherry_query_asset( 'js', array( 'cherry-google-map', 'cherry-shortcodes-init' ) );

		return apply_filters( 'cherry_shortcodes_output', $html, $atts, 'google_map' );
	}

	public static function parallax_image( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'bg_image'         => '',
			'speed'            => '1.5',
			'invert'           => 'no',
			'min_height'       => '300',
			'custom_class'     => '',
		), $atts, 'parallax_image' );

		$bg_image     = sanitize_text_field( $atts['bg_image'] );
		$speed        = floatval( $atts['speed'] );
		$invert       = ( bool ) ( $atts['invert'] === 'yes' ) ? true : false;
		$min_height   = floatval( $atts['min_height'] );
		$custom_class = sanitize_text_field( $atts['custom_class'] );

		if ( !$bg_image ) {
			return;
		}

		$html = '<section class="parallax-box image-parallax-box ' . esc_attr( $custom_class ) . '" style="min-height: ' . $min_height . 'px">';
			$html .= '<div class="parallax-content">' . do_shortcode( $content ) . '<div class="clear"></div></div>';
			$html .= '<div class="parallax-bg" data-parallax-type="image" data-img-url="'. $bg_image .'" data-speed="' . $speed . '" data-invert="' . $invert . '" ></div>';
		$html .= '</section>';

		cherry_query_asset( 'js', 'cherry-parallax' );

		return apply_filters( 'cherry_shortcodes_output', $html, $atts, 'parallax_image' );
	}

	public static function parallax_html_video( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'poster'       => '',
			'mp4'          => '',
			'webm'         => '',
			'ogv'          => '',
			'speed'        => '1.5',
			'invert'       => 'no',
			'custom_class' => '',
		), $atts, 'parallax_html_video' );

		$poster       = sanitize_text_field( $atts['poster'] );
		$mp4          = sanitize_text_field( $atts['mp4'] );
		$webm         = sanitize_text_field( $atts['webm'] );
		$ogv          = sanitize_text_field( $atts['ogv'] );
		$speed        = floatval( $atts['speed'] );
		$invert       = ( bool ) ( $atts['invert'] === 'yes' ) ? true : false;
		$custom_class = sanitize_text_field( $atts['custom_class'] );

		if ( $mp4 == '' || $webm == '' || $ogv == '' ) {
			return;
		}

		$html = '<section class="parallax-box video-parallax-box ' . esc_attr( $custom_class ) . '" >';
			$html .= '<div class="parallax-content">' . do_shortcode( $content ) . '<div class="clear"></div></div>';
			$html .= '<div class="parallax-bg" data-parallax-type="video" data-img-url="' . $poster . '" data-speed="' . $speed . '" data-invert="' . $invert . '" >';
				$html .= '<video class="parallax_media parallax-bg-inner" poster="' . $poster . '" loop>';
					$html .= '<source src="' . $mp4 . '" type="video/mp4">';
					$html .= '<source src="' . $webm . '" type="video/webm">';
					$html .= '<source src="' . $ogv . '" type="video/ogg">';
				$html .= '</video>';
			$html .= '</div>';
		$html .= '</section>';

		cherry_query_asset( 'js', 'cherry-parallax' );

		return apply_filters( 'cherry_shortcodes_output', $html, $atts, 'parallax_html_video' );
	}

	public static function counter( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'counter_value'  => '100.00',
			'delay'          => '10',
			'time'           => '1000',
			'before_content' => '',
			'after_content'  => '',
			'custom_class'   => '',
		), $atts, 'counter' );

		$counter_value  = (string)$atts['counter_value'];
		$delay          = intval( $atts['delay'] );
		$time           = intval( $atts['time'] );
		$before_content = sanitize_text_field( $atts['before_content'] );
		$after_content  = sanitize_text_field( $atts['after_content'] );
		$custom_class   = sanitize_text_field( $atts['custom_class'] );

		$data_attr_line = '';
			$data_attr_line .= 'data-delay="' . $delay . '" ';
			$data_attr_line .= 'data-time="' . $time . '"';

		$html = '<div class="cherry-counter ' . esc_attr( $custom_class ) . '" ' . $data_attr_line . '>';

			if ('' !==  $before_content ) {
				$html .= '<span class="before">' . $before_content . '</span>';
			}

			$html .= '<span class="count">' . $counter_value . '</span>';

			if ('' !==  $after_content ) {
				$html .= '<span class="after">' . $after_content . '</span>';
			}

		$html .= '</div>';

		cherry_query_asset( 'js', array( 'jquery-counterup', 'cherry-shortcodes-init' ) );

		return apply_filters( 'cherry_shortcodes_output', $html, $atts, 'counter' );
	}

	public static function lazy_load_effect( $atts = null, $content ) {
		global $is_IE;

		if ( wp_is_mobile() || $is_IE && preg_match( '/MSIE [56789]/', $_SERVER['HTTP_USER_AGENT'] ) ) {
			return do_shortcode( $content );
		}

		$atts = shortcode_atts( array(
			'start_position'  => false,
			'rotation'        => false,
			'flip_x'          => false,
			'flip_y'          => false,
			'pivot'           => false,
			'scale'           => 1,
			'opacity'         => 1,
			'easing'          => 'linear',
			'speed'           => 1,
			'delay'           => 0,
			'custom_class'    => '',
		), $atts, 'lazy_load_effect' );

		extract($atts);

		$style = Cherry_Shortcodes_Tools::add_css_prefix('animation-duration: '.$speed.'s');
		$style .= $delay != 0 ?  Cherry_Shortcodes_Tools::add_css_prefix('animation-delay: '.$delay.'s') : '' ;
		//test css property
		//$style .= Cherry_Shortcodes_Tools::add_css_prefix('backface-visibility: hidden;');

		switch ($easing) {
			case 'ease-in-cubic':
				$easing = 'cubic-bezier(0.55, 0.055, 0.675, 0.19)';
			break;

			case 'ease-out-cubic':
				$easing = 'cubic-bezier(0.215, 0.61, 0.355, 1)';
			break;

			case 'ease-in-out-cubic':
				$easing = 'cubic-bezier(0.645, 0.045, 0.355, 1)';
			break;

			case 'ease-in-quart':
				$easing = 'cubic-bezier(0.895, 0.03, 0.685, 0.22)';
			break;

			case 'ease-out-quart':
				$easing = 'cubic-bezier(0.165, 0.84, 0.44, 1)';
			break;

			case 'ease-in-out-quart':
				$easing = 'cubic-bezier(0.77, 0, 0.175, 1)';
			break;

			case 'ease-in-expo':
				$easing = 'cubic-bezier(0.95, 0.05, 0.795, 0.035)';
			break;

			case 'ease-out-expo':
				$easing = 'cubic-bezier(0.19, 1, 0.22, 1)';
			break;

			case 'ease-in-out-expo':
				$easing = 'cubic-bezier(1, 0, 0, 1)';
			break;

			case 'ease-in-back':
				$easing = 'cubic-bezier(0.6, -0.28, 0.735, 0.045)';
			break;

			case 'ease-out-back':
				$easing = 'cubic-bezier(0.175, 0.885, 0.32, 1.275)';
			break;

			case 'ease-in-out-back':
				$easing = 'cubic-bezier(0.68, -0.55, 0.265, 1.55)';
			break;
			default:
				$easing = 'linear';
			break;
		}

		$style .= Cherry_Shortcodes_Tools::add_css_prefix('animation-timing-function: '.$easing);

		if($start_position || $rotation || $flip_x || $flip_y || $pivot || $scale != 1){
			$transform = '';

			switch ($start_position) {
				case 'top':
					$transform .= 'translateY(-500px) ';
				break;
				case 'bottom':
					$transform .= 'translateY(500px) ';
				break;
				case 'left':
					$transform .= 'translateX(-2000px) ';
				break;
				case 'right':
					$transform .= 'translateX(2000px) ';
				break;
				default:
					$transform .= '';
				break;
			}

			//transform rotation
			$transform .= ($rotation) ? 'rotate('.$rotation.'deg) ' : '' ;

			//transform flip_x
			$transform .= ($flip_x) ? 'rotateX('.$flip_x.'deg) ' : '' ;

			//transform flip_y
			$transform .= ($flip_y) ? 'rotateY('.$flip_y.'deg) ' : '' ;

			//transform scale
			$transform .= ($scale != 1) ? 'scale(' . $scale . ') ' : '' ;

			//transform origin
			$pivot = $pivot ? str_replace('_', ' ', $pivot) : 'center' ;
			$style .= Cherry_Shortcodes_Tools::add_css_prefix('transform-origin: '.$pivot);
			$style .= Cherry_Shortcodes_Tools::add_css_prefix('transform:' . $transform);

		}

		$style .= ($opacity != 1) ? 'opacity:' . $opacity . '; ': '' ;

		$output = '<div class="lazy-load-effect"><div class="lazy-load-effect-child' . $custom_class . '" style="' . $style . '">' . do_shortcode( $content ) . '</div></div>';

		cherry_query_asset( 'js', 'cherry-lazy-load-effect' );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'lazy_load_effect' );
	}

	public static function video_preview( $atts = null, $content ) {

		$atts = shortcode_atts( array(
			'poster'				=> '',
			'source'				=> '',
			'control'				=> 'show',
			'show_content_on_hover'	=> 'no',
			'muted'					=> 'no',
			'loop'					=> 'no',
			'preload'				=> 'no',
			'width'					=> '',
			'height'				=> '',
			'custom_class'			=> '',
		), $atts, 'video_preview' );

		$video_preview_class = apply_filters( 'cherry_video_preview_class', array('class_1' => 'fa-play', 'class_2' => 'fa-pause', 'class_3' => 'fa-volume-off', 'class_4' => 'fa-volume-up') );
		$video_preview_text = apply_filters( 'cherry_video_preview_texts', array('text_1' => '', 'text_2' => '', 'text_3' => '', 'text_4' => '') );

		extract($atts);

		$type = strtolower(  preg_replace( '/(^(http(s)?:)?(\/\/)(www.)?)|(([.]\D{2,5})?\/[\S]+)/', '', $source ) );
		$is_mobile = wp_is_mobile() ? 'true' : 'false' ;

		if( $type === 'youtube'){
			cherry_query_asset( 'js', 'video-youtube' );

			global $video_preview_count;
			$video_preview_count += 1;

			$video_id = preg_replace( '/[\S.]+\/[\S.]+[=]|[\S.]+\//', '', $source );

			if($poster){
				$poster = '<div style="background-image: url(\'' . $poster . '\')" class="cherry-video-poster"></div>';
			}

			$video_tag = '<div id="cherry-youtube-' . $video_preview_count . '" class="youtube-player" data-video="' . $video_id . '"></div>' . $poster . '<div class="youtube-player-cap"></div>';
		}else {
			if( $type === 'vimeo' ){
				$video_id = preg_replace( '/([\S.]+\/)/', '', $source );

				$response = Cherry_Shortcodes_Tools::remote_query( 'https://player.vimeo.com/video/' . $video_id . '/config' );

				if( $response ){
					$file_codes = $response->request->files->codecs[0];

					if( strpos( $custom_class, 'full-width' ) !== false && $is_mobile === 'false' ){
						$poster_size = '1280';
						$source = $response->request->files->$file_codes->hd->url;
					}else{
						$poster_size = '640';
						$source = $response->request->files->$file_codes->sd->url;
					}
					if( !$poster ){
						$poster = $response->video->thumbs->$poster_size;
					}
				}
			}

			$poster = $poster ? '<div style="background-image: url(\'' . $poster . '\')" class="cherry-video-poster"></div>' : '' ;
			$muted_attr = $muted !== 'no' ? 'muted ' : '' ;
			$loop_attr = $loop !== 'no' ? 'loop ' : '' ;
			$preload_attr = $preload !== 'no' ? 'preload="auto" ' : '' ;
			$autoplay_attr = $control === 'autoplay' ? 'autoplay ' : '' ;

			$video_tag = $poster;
			$video_tag .= '<video ' . $autoplay_attr  . $muted_attr . $loop_attr . $preload_attr . ' width="100%" height="auto" >';
				$video_tag .= '<source src="'.$source.'" type="video/mp4">';
			$video_tag .= '</video>';
		}

		$control_tag = '';
		if( $control !== 'hide' && $control !== 'play-on-hover' && $control !== 'autoplay' ){

			$control_class = $control === 'show-on-hover' ? 'hidden-element' : '' ;

			$control_tag .= '<div class="video-preview-controls ' . $control_class . '">';
				$control_tag .= '<button class="play-pause fa ' . $video_preview_class['class_1'] . '" data-class="' . $video_preview_class['class_1'] . '" data-sub-class="' . $video_preview_class['class_2'] . '" data-text="' . __( $video_preview_text['text_1'], 'cherry-shortcodes' ) . '" data-sub-text="' . __( $video_preview_text['text_2'], 'cherry-shortcodes' ) . '" type="button">' . __( $video_preview_text['text_1'], 'cherry-shortcodes' ) . '</button>';
				$control_tag .= '<button class="mute fa ' . $video_preview_class['class_3'] . '" data-class="' . $video_preview_class['class_3'] . '" data-sub-class="' . $video_preview_class['class_4'] . '" data-text="' . __( $video_preview_text['text_3'], 'cherry-shortcodes' ) . '" data-sub-text="' . __( $video_preview_text['text_4'], 'cherry-shortcodes' ). '" type="button">' . __( $video_preview_text['text_3'], 'cherry-shortcodes' ) . '</button>';
			$control_tag .= '</div>';
		}

		$content_tag = '';
		if( $content ){
			$content_class = $show_content_on_hover !== 'no' ? 'class="hidden-element"' : '' ;

			$content_tag .= '<figcaption ' . $content_class . ' >' . do_shortcode( $content ) . '</figcaption>';
		}

		$output = apply_filters( 'cherry_video_preview_before', '' );

		$output .= '<figure class="video-preview ' . $custom_class . '" data-settings=\'{"control":"' . $control . '", "muted":"' . $muted . '", "loop":"' . $loop . '", "preload":"' . $preload . '", "type":"' . $type . '", "is_mobile":"' . $is_mobile . '"}\' >';
			$output .= '<div class="video-holder">';
				$output .= '<div class="video-inner-holder">';

					$output .= $video_tag;

					$output .= $control_tag;

				$output .= '</div>';
			$output .= '</div>';

			$output .= $content_tag;

		$output .= '</figure>';

		$output .= apply_filters( 'cherry_video_preview_after', '' );

		if( $type === 'youtube'){
			cherry_query_asset( 'js', 'video-youtube' );
		}
		cherry_query_asset( 'js', 'video-preview' );

		return apply_filters( 'cherry_shortcodes_output', $output, $atts, 'video_preview' );
	}

	/**
	 * Prepare template data to replace
	 *
	 * @since  1.0.0
	 * @param  array  $atts output attributes
	 */
	public static function setup_template_data( $data, $atts, $content = null ) {
		require_once( CHERRY_SHORTCODES_DIR . 'inc/template-callbacks.php' );

		$callbacks = new Cherry_Shortcodes_Template_Callbacks( $atts, $content );

		$full_data = array(
			'title'     => array( $callbacks, 'title' ),
			'date'      => array( $callbacks, 'date' ),
			'button'    => array( $callbacks, 'button' ),
			'image'     => array( $callbacks, 'image' ),
			'excerpt'   => array( $callbacks, 'excerpt' ),
			'content'   => array( $callbacks, 'content' ),
			'author'    => array( $callbacks, 'author' ),
			'comments'  => array( $callbacks, 'comments' ),
			'taxonomy'  => array( $callbacks, 'taxonomy' ),
			'permalink' => array( $callbacks, 'permalink' ),
			'color'     => array( $callbacks, 'banner_color' ),
			'bgcolor'   => array( $callbacks, 'banner_bgcolor' ),
			'url'       => array( $callbacks, 'banner_url' ),
		);

		$_data = array();
		foreach ( $data as $key ) {
			if ( ! empty( $full_data[ $key ] ) ) {
				$_data = array_merge( $_data, array( $key => $full_data[ $key ] ) );
			}
		}

		self::$post_data = apply_filters( 'cherry_shortcodes_data_callbacks', $_data, $atts );
	}

	public static function replace_callback( $matches ) {

		if ( ! is_array( $matches ) ) {
			return '';
		}

		if ( empty( $matches ) ) {
			return '';
		}

		$key = strtolower( $matches[1] );

		// if key not found in data - return nothing
		if ( ! isset( self::$post_data[ $key ] ) ) {
			return '';
		}

		$callback = self::$post_data[ $key ];

		if ( is_array( $callback ) && ! is_callable( $callback ) ) {
			return;
		}

		// if found parameters and has correct callback - process it
		if ( isset( $matches[3] ) ) {
			return call_user_func( $callback, $matches[3] );
		}

		return is_callable( $callback ) ? call_user_func( $callback ) : $callback;
	}

	/**
	 * Retrieve a template's file path.
	 *
	 * @since  1.0.0
	 * @param  string      $template_name Template's file name.
	 * @param  string      $shortcode     Shortcode's name.
	 * @return bool|string                Path to template file.
	 */
	public static function get_template_path( $template_name, $shortcode ) {
		$path       = false;
		$default    = CHERRY_SHORTCODES_DIR . 'templates/shortcodes/' . $shortcode . '/default.tmpl';
		$subdir     = 'templates/shortcodes/' . $shortcode . '/' . $template_name;
		$upload_dir = wp_upload_dir();
		$upload_dir = trailingslashit( $upload_dir['basedir'] );

		if ( file_exists( $upload_dir . $subdir ) ) {
			$path = $upload_dir . $subdir;
		} elseif ( file_exists( CHERRY_SHORTCODES_DIR . $subdir ) ) {
			$path = CHERRY_SHORTCODES_DIR . $subdir;
		} elseif ( file_exists( $default ) ) {
			$path = $default;
		}

		$path = apply_filters( 'cherry_shortcodes_get_template_path', $path, $template_name, $shortcode );

		return $path;
	}

	public static function get_shortcode_name() {
		return ! empty( self::$post_data['tag'] ) ? self::$post_data['tag'] : '';
	}
}

new Cherry_Shortcodes_Handler;