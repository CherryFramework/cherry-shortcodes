<?php
/**
 * Cherry Shortcodes widget.
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
 * Class for special widget with Cherry Shortcodes.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'cherry-shortcodes',
			'description' => __( 'Special widget with Cherry Shortcodes.', 'cherry-shortcodes' ),
		);

		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'cherry-shortcodes',
		);

		parent::__construct( 'cherry-shortcodes', __( 'Cherry Shortcodes', 'cherry-shortcodes' ), $widget_ops, $control_ops );
	}

	/**
	 * Widget registration.
	 *
	 * @since 1.0.0
	 */
	public static function register() {
		register_widget( 'Cherry_Shortcodes_Widget' );
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 1.0.0
	 * @param array $args     The array of form elements.
	 * @param array $instance The current instance of the widget.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title   = apply_filters( 'widget_title', $instance['title'] );
		$content = $instance['content'];

		echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			echo '<div class="textwidget">' . do_shortcode( $content ) . '</div>';
		echo $after_widget;
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since  1.0.0
	 * @param  array $new_instance The new instance of values to be generated via the update.
	 * @param  array $old_instance The previous instance of values before the update.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['content'] = $new_instance['content'];

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @since 1.0.0
	 * @param array $instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'   => '',
			'content' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'cherry-shortcodes' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
		<?php Cherry_Shortcodes_Generator::button( array( 'target' => $this->get_field_id( 'content' ) ) ); ?><br/>
			<textarea name="<?php echo $this->get_field_name( 'content' ); ?>" id="<?php echo $this->get_field_id( 'content' ); ?>" rows="7" class="widefat" style="margin-top:10px"><?php echo $instance['content']; ?></textarea>
		</p>
		<?php
	}
}

add_action( 'widgets_init', array( 'Cherry_Shortcodes_Widget', 'register' ) );

?>