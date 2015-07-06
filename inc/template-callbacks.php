<?php
/**
 * Define callback functions for templater.
 *
 * @package   Cherry_Team
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2015 Cherry Team
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Callbcks for team shortcode templater
 *
 * @since  1.0.0
 */
class Cherry_Shortcodes_Template_Callbacks {

	function __construct() {}

	public static function title( $args = array() ) {
		global $post;

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_title_template_defaults', array(
			'wrap' => '<a href="%1$s" title="%2$s">%3$s</a>',
		), $shortcode_name );

		$args  = wp_parse_args( $args, $defaults );
		$title = get_the_title( $post->ID );

		if ( empty( $title ) ) {
			return;
		}

		$title = sprintf(
			$args['wrap'],
			esc_url( get_permalink( $post->ID ) ),
			esc_attr( the_title_attribute( array( 'before' => '', 'after' => '', 'echo' => false, 'post' => $post->ID ) ) ),
			$title
		);

		return apply_filters( 'cherry_shortcodes_title_template_callbacks', $title, $args, $shortcode_name );
	}

	public static function date( $args = array() ) {
		global $post;

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		// Gets data format.
		$format = func_num_args() ? func_get_arg(0) : get_option( 'date_format' );

		$defaults = apply_filters( 'cherry_shortcodes_date_template_defaults', array(
			'wrap' => '<time datetime="%1$s">%2$s</time>',
		), $shortcode_name, $format );

		$args = wp_parse_args( $args, $defaults );

		$date = sprintf(
			$args['wrap'],
			esc_attr( get_the_date( 'c' ) ),
			esc_attr( get_the_date( $format, $post->ID ) )
		);

		return apply_filters( 'cherry_shortcodes_date_template_callbacks', $date, $args, $shortcode_name );
	}

	public static function button( $args = array() ) {
		global $post;

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_button_template_defaults', array(
			'wrap'  => '<a href="%1$s" class="%2$s">%3$s</a>',
			'class' => 'btn btn-default',
			'text'  => '',
		), $shortcode_name );

		$args = wp_parse_args( $args, $defaults );

		if ( empty( $args['text'] ) ) {
			return;
		}

		$button = sprintf(
				$args['wrap'],
				esc_url( get_permalink( $post->ID ) ),
				esc_attr( $args['class'] ),
				apply_filters( 'cherry_shortcodes_translate', $args['text'], 'button_text' )
			);

		return apply_filters( 'cherry_shortcodes_button_template_callbacks', $button, $args, $shortcode_name );
	}

	public static function image( $args = array() ) {
		global $post;

		if ( ! post_type_supports( get_post_type( $post->ID ), 'thumbnail' ) ) {
			return;
		}

		if ( ! has_post_thumbnail( $post->ID ) ) {
			return;
		}

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_image_template_defaults', array(
			'wrap'     => '<a href="%1$s" title="%2$s" class="%4$s">%3$s</a>',
			'size'     => 'large',
			'lightbox' => false,
		), $shortcode_name );

		$args = wp_parse_args( $args, $defaults );

		$url             = get_permalink( $post->ID );
		$image_classes   = array();
		$image_classes[] = 'post-thumbnail_link';

		if ( isset( $args['lightbox'] ) && ( true === $args['lightbox'] ) ) {
			$image_classes[] = 'cherry-popup-img';
			$image_classes[] = 'popup-img';

			$image_classes = apply_filters( 'cherry_shortcodes_image_classes_template_callbacks', $image_classes );
			$image_classes = array_unique( $image_classes );
			$image_classes = array_map( 'sanitize_html_class', $image_classes );

			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$url          = wp_get_attachment_url( $thumbnail_id );

			if ( ! $url ) {
				$url = get_permalink( $post->ID );
			}

			wp_enqueue_script( 'magnific-popup' );
		}

		$image = sprintf(
			$args['wrap'],
			esc_url( $url ),
			esc_attr( the_title_attribute( array( 'before' => '', 'after' => '', 'echo' => false, 'post' => $post->ID ) ) ),
			get_the_post_thumbnail( $post->ID, $args['size'] ),
			join( ' ', $image_classes )
		);

		return apply_filters( 'cherry_shortcodes_image_template_callbacks', $image, $args, $shortcode_name );
	}

	/**
	 * Get post exerpt.
	 *
	 * @since 1.0.0
	 */
	public static function excerpt( $args = array() ) {
		global $post;

		if ( ! has_excerpt( $post->ID ) ) {
			return;
		}

		if ( ! post_type_supports( get_post_type( $post->ID ), 'excerpt' ) ) {
			return;
		}

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_excerpt_template_defaults', array(
			'wrap'  => '<div class="%1$s">%2$s</div>',
			'class' => 'post-excerpt',
		), $shortcode_name );

		$args = wp_parse_args( $args, $defaults );

		$excerpt = sprintf(
			$args['wrap'],
			$args['class'],
			apply_filters( 'the_excerpt', get_the_excerpt() )
		);

		return apply_filters( 'cherry_shortcodes_excerpt_template_callbacks', $excerpt, $args, $shortcode_name );
	}

	/**
	 * Get post content.
	 *
	 * @since  1.0.0
	 */
	public static function content( $args = array() ) {
		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_content_template_defaults', array(
			'wrap'   => '<div class="%1$s">%2$s</div>',
			'class'  => 'post-content',
			'length' => -1,
		), $shortcode_name );

		$args     = wp_parse_args( $args, $defaults );
		$_content = get_the_content( '' );

		if ( ! $_content ) {
			return;
		}

		$args['length'] = intval( $args['length'] );

		if ( -1 == $args['length'] || post_password_required() ) {
			$content       = apply_filters( 'the_content', $_content );
			$args['class'] .= ' full';
		} else {
			/* wp_trim_excerpt analog */
			$content = strip_shortcodes( $_content );
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			$content = wp_trim_words( $content, $args['length'], apply_filters( 'cherry_shortcodes_content_callback_more', '', $args, $shortcode_name ) );
			$args['class'] .= ' part';
		}

		$content = sprintf( $args['wrap'], esc_attr( $args['class'] ), $content );

		return apply_filters( 'cherry_shortcodes_content_template_callbacks', $content, $args, $shortcode_name );
	}

	public static function comments( $args = array() ) {
		global $post;

		if ( ! post_type_supports( get_post_type( $post->ID ), 'comments' ) ) {
			return;
		}

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_comments_template_defaults', array(
			'wrap'  => '<span class="%1$s"><a href="%2$s">%3$s</a></span>',
			'class' => 'post-comments-link',
		), $shortcode_name );

		$args = wp_parse_args( $args, $defaults );

		$comments = ( comments_open( $post->ID ) && get_comments_number( $post->ID ) ) ? get_comments_number( $post->ID ) : false;

		if ( false === $comments ) {
			return;
		}

		$comments = sprintf( $args['wrap'], $args['class'], esc_url( get_comments_link( $post->ID ) ), $comments );

		return apply_filters( 'cherry_shortcodes_comments_template_callbacks', $comments, $args, $shortcode_name );
	}

	public static function author( $args = array() ) {
		global $post;

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_author_template_defaults', array(
			'wrap'  => '<span class="%1$s vcard"><a href="%2$s" rel="author">%3$s</a></span>',
			'class' => 'post-author',
		), $shortcode_name );

		$args = wp_parse_args( $args, $defaults );

		$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
		$author     = sprintf( $args['wrap'], $args['class'], esc_url( $author_url ), get_the_author() );

		return apply_filters( 'cherry_shortcodes_author_template_callbacks', $author, $args, $shortcode_name );
	}

	public static function taxonomy( $args = array() ) {
		global $post;

		if ( ! func_num_args() ) {
			return;
		}

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$tax = func_get_arg(0);

		$defaults = apply_filters( 'cherry_shortcodes_taxonomy_template_defaults', array(
			'wrap'  => '<span class="%1$s %1$s-%2$s">%3$s</span>',
			'class' => 'post-tax',
		), $shortcode_name, $tax );

		$args = wp_parse_args( $args, $defaults );

		$tax_data = array();
		$terms    = wp_get_post_terms( $post->ID, $tax );

		if ( empty( $terms ) ) {
			return;
		}

		if ( is_wp_error( $terms ) ) {
			return;
		}

		foreach ( $terms as $term ) {
			$tax_data[] = '<a href="' . get_term_link( $term->slug, $tax ) . '">' . $term->name . '</a>';
		}

		$taxonomy = sprintf(
			$args['wrap'],
			esc_attr( $args['class'] ),
			sanitize_html_class( $tax ),
			join( ' ', $tax_data )
		);

		return apply_filters( 'cherry_shortcodes_taxonomy_template_callbacks', $taxonomy, $args, $shortcode_name );
	}

	public static function permalink( $args = array() ) {
		global $post;

		// Gets a current shortcode name.
		$shortcode_name = Cherry_Shortcodes_Handler::get_shortcode_name();

		$defaults = apply_filters( 'cherry_shortcodes_title_template_defaults', array(
			'wrap' => '%s',
		), $shortcode_name );

		$args      = wp_parse_args( $args, $defaults );
		$permalink = get_permalink( $post->ID );

		if ( empty( $permalink ) ) {
			return;
		}

		$permalink = sprintf(
			$args['wrap'],
			esc_url( $permalink )
		);

		return apply_filters( 'cherry_shortcodes_permalink_template_callbacks', $permalink, $args, $shortcode_name );
	}

}