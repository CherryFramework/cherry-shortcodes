<?php
/**
 * Define callback functions for templater
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

	/**
	 * Shortcode attributes array
	 * @var array
	 */
	public $atts = array();

	public $content = null;

	function __construct( $atts, $content ) {
		$this->atts    = $atts;
		$this->content = $content;
	}

	public function title() {
		global $post;

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();

		switch ( $shortcode ) {
			case 'banner':
				$wrap  = '<h2 class="cherry-banner_title"%1$s>%2$s</h2>';
				$title = sanitize_text_field( $this->atts['title'] );

				$title_syle = '';
				if ( ! empty( $this->atts['color'] ) ) {
					$title_syle = ' style="color:' . esc_attr( $this->atts['color'] ) . ';"';
				}

				$title = sprintf(
					$wrap,
					$title_syle,
					$title
				);
				break;

			default:
				$wrap  = ( 'no' === $this->atts['linked_title'] ) ? '%3$s' : '<a href="%1$s" title="%2$s">%3$s</a>';
				$title = get_the_title( $post->ID );

				if ( empty( $title ) ) {
					return;
				}

				$title = sprintf(
					$wrap,
					esc_url( get_permalink( $post->ID ) ),
					esc_attr( the_title_attribute( array( 'before' => '', 'after' => '', 'echo' => false, 'post' => $post->ID ) ) ),
					$title
				);
				break;
		}

		return apply_filters( 'cherry_shortcodes_title_template_callbacks', $title, $this->atts, $shortcode );
	}

	public function date( $format = '' ) {
		global $post;

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();

		if ( empty( $format ) ) {
			$format = get_option( 'date_format' );
		}

		$date = sprintf(
			'<time datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_attr( get_the_date( $format, $post->ID ) )
		);

		return apply_filters( 'cherry_shortcodes_date_template_callbacks', $date, $this->atts, $shortcode );
	}

	public function button( $classes = '' ) {
		global $post;

		$shortcode   = Cherry_Shortcodes_Handler::get_shortcode_name();
		$button_text = sanitize_text_field( $this->atts['button_text'] );

		if ( empty( $button_text ) ) {
			return;
		}

		$button = sprintf(
			'<a href="%1$s" class="%2$s">%3$s</a>',
			esc_url( get_permalink( $post->ID ) ),
			esc_attr( $classes ),
			$button_text
		);

		return apply_filters( 'cherry_shortcodes_button_template_callbacks', $button, $this->atts, $shortcode );
	}

	public function image( $size = '' ) {
		global $post;

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();

		if ( 'banner' == $shortcode ) {
			return esc_url( $this->atts['image'] );
		}

		if ( ! post_type_supports( get_post_type( $post->ID ), 'thumbnail' ) ) {
			return;
		}

		if ( ! has_post_thumbnail( $post->ID ) ) {
			return;
		}

		$url = get_permalink( $post->ID );
		$image_classes   = array();
		$image_classes[] = 'post-thumbnail_link';

		switch ( $shortcode ) {
			case 'posts':

				if ( empty( $size ) ) {
					$size = sanitize_key( $this->atts['image_size'] );
				}

				if ( isset( $this->atts['lightbox_image'] ) && ( 'yes' === $this->atts['lightbox_image'] ) ) {
					$image_classes[] = 'cherry-popup-img';
					$image_classes[] = 'popup-img';

					$thumbnail_id = get_post_thumbnail_id( $post->ID );
					$url          = wp_get_attachment_url( $thumbnail_id );

					if ( ! $url ) {
						$url = get_permalink( $post->ID );
					}

					wp_enqueue_script( 'magnific-popup' );
				}

				$thumbnail = get_the_post_thumbnail( $post->ID, $size );
				break;

			case 'swiper_carousel':
				$post_id     = get_the_ID();
				$crop_image  = ( bool ) ( 'yes' === $this->atts['crop_image'] ) ? true : false;
				$crop_width  = intval( $this->atts['crop_width'] );
				$crop_height = intval( $this->atts['crop_height'] );

				if ( $crop_image ) {
					$img_url   = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
					$thumbnail = Cherry_Shortcodes_Tools::get_crop_image( $img_url, get_post_thumbnail_id(), $crop_width, $crop_height );
				} else {
					$thumbnail = get_the_post_thumbnail( $post->ID, 'large' );
				}
				break;

			default:

				if ( empty( $this->atts['image_size'] ) ) {
					$thumbnail = get_the_post_thumbnail( $post->ID, 'large' );
				} else {
					$thumbnail = get_the_post_thumbnail( $post->ID, sanitize_key( $this->atts['image_size'] ) );
				}
				break;
		}

		$wrap = ( 'no' === $this->atts['linked_image'] ) ? '%3$s' : '<a href="%1$s" title="%2$s" class="%4$s">%3$s</a>';

		$image_classes = apply_filters( 'cherry_shortcodes_image_classes_template_callbacks', $image_classes, $shortcode );
		$image_classes = array_unique( $image_classes );
		$image_classes = array_map( 'sanitize_html_class', $image_classes );

		$image = sprintf(
			$wrap,
			esc_url( $url ),
			esc_attr( the_title_attribute( array( 'before' => '', 'after' => '', 'echo' => false, 'post' => $post->ID ) ) ),
			$thumbnail,
			join( ' ', $image_classes )
		);

		return apply_filters( 'cherry_shortcodes_image_template_callbacks', $image, $this->atts, $shortcode );
	}

	/**
	 * Get post exerpt.
	 *
	 * @since 1.0.0
	 */
	public function excerpt() {
		global $post;

		if ( ! has_excerpt( $post->ID ) ) {
			return;
		}

		if ( ! post_type_supports( get_post_type( $post->ID ), 'excerpt' ) ) {
			return;
		}

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();

		$excerpt = sprintf(
			'<div class="post-excerpt">%s</div>',
			apply_filters( 'the_excerpt', get_the_excerpt() )
		);

		return apply_filters( 'cherry_shortcodes_excerpt_template_callbacks', $excerpt, $this->atts, $shortcode );
	}

	/**
	 * Get post content.
	 *
	 * @since  1.0.0
	 */
	public function content() {
		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();

		switch ( $shortcode ) {
			case 'banner':
				$content = '<div class="cherry-banner_content">' . do_shortcode( $this->content ) . '</div>';
				break;

			default:
				$_content = get_the_content( '' );

				if ( ! $_content ) {
					return;
				}

				$class          = 'post-content';
				$content_type   = sanitize_key( $this->atts['content_type'] );
				$content_length = absint( $this->atts['content_length'] );

				if ( ! $content_length ) {
					return;
				}

				if ( 'full' == $content_type || post_password_required() ) {
					$content = apply_filters( 'the_content', $_content );
					$class   .= ' full';
				} elseif ( 'part' == $content_type ) {
					/* wp_trim_excerpt analog */
					$content = strip_shortcodes( $_content );
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$content = wp_trim_words( $content, $content_length, apply_filters( 'cherry_shortcodes_content_callback_more', '', $this->atts, $shortcode ) );
					$class   .= ' part';
				}

				$content = sprintf(
					'<div class="%1$s">%2$s</div>',
					esc_attr( $class ),
					$content
				);
				break;
		}

		return apply_filters( 'cherry_shortcodes_content_template_callbacks', $content, $this->atts, $shortcode );
	}

	public function comments() {
		global $post;

		if ( ! post_type_supports( get_post_type( $post->ID ), 'comments' ) ) {
			return;
		}

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();
		$comments  = ( comments_open( $post->ID ) && get_comments_number( $post->ID ) ) ? get_comments_number( $post->ID ) : false;

		if ( false === $comments ) {
			return;
		}

		$comments = sprintf(
			'<span class="post-comments-link"><a href="%1$s">%2$s</a></span>',
			esc_url( get_comments_link( $post->ID ) ),
			$comments
		);

		return apply_filters( 'cherry_shortcodes_comments_template_callbacks', $comments, $this->atts, $shortcode );
	}

	public function author() {
		global $post;

		$shortcode  = Cherry_Shortcodes_Handler::get_shortcode_name();
		$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );

		$author = sprintf(
			'<span class="post-author vcard"><a href="%1$s" rel="author">%2$s</a></span>',
			esc_url( $author_url ),
			get_the_author()
		);

		return apply_filters( 'cherry_shortcodes_author_template_callbacks', $author, $this->atts, $shortcode );
	}

	public function taxonomy( $tax = '' ) {
		global $post;

		if ( empty( $tax ) ) {
			return;
		}

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();
		$tax_data  = array();
		$terms     = wp_get_post_terms( $post->ID, $tax );

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
			'<span class="post-tax post-tax-%1$s">%2$s</span>',
			sanitize_html_class( $tax ),
			join( ' ', $tax_data )
		);

		return apply_filters( 'cherry_shortcodes_taxonomy_template_callbacks', $taxonomy, $this->atts, $shortcode );
	}

	public function permalink() {
		global $post;

		$shortcode = Cherry_Shortcodes_Handler::get_shortcode_name();
		$permalink = esc_url( get_permalink( $post->ID ) );

		if ( empty( $permalink ) ) {
			return;
		}

		return apply_filters( 'cherry_shortcodes_permalink_template_callbacks', $permalink, $this->atts, $shortcode );
	}

	public function banner_color() {
		global $post;

		if ( empty( $this->atts['color'] ) ) {
			return;
		}

		return apply_filters( 'cherry_shortcodes_banner_color_template_callbacks', esc_attr( $this->atts['color'] ), $this->atts );
	}

	public function banner_bgcolor() {
		global $post;

		if ( empty( $this->atts['bg_color'] ) ) {
			return;
		}

		return apply_filters( 'cherry_shortcodes_banner_bgcolor_template_callbacks', esc_attr( $this->atts['bg_color'] ), $this->atts );
	}

	public function banner_url() {
		global $post;

		if ( empty( $this->atts['url'] ) ) {
			return;
		}

		$url = str_replace( '%home_url%', home_url(), $this->atts['url'] );

		return apply_filters( 'cherry_shortcodes_banner_url_template_callbacks', esc_url( $url ), $this->atts );
	}

}