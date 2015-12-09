<?php
/**
 * Shortcode Generator.
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
 * Class for shortcode generator.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Generator {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'media_buttons', array( __CLASS__, 'button' ), 1000 );

		add_action( 'cherry_shortcodes/update',     array( __CLASS__, 'reset' ) );
		add_action( 'cherry_shortcodes/activation', array( __CLASS__, 'reset' ) );
		add_action( 'sunrise/page/before',          array( __CLASS__, 'reset' ) );
		add_action( 'create_term',                  array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'edit_term',                    array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'delete_term',                  array( __CLASS__, 'reset' ), 10, 3 );

		add_action( 'wp_ajax_cherry_shortcodes_generator_settings', array( __CLASS__, 'settings' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_preview',  array( __CLASS__, 'preview' ) );
		add_action( 'cherry_shortcodes/generator/actions',          array( __CLASS__, 'presets' ) );

		add_action( 'wp_ajax_cherry_shortcodes_generator_get_icons',      array( __CLASS__, 'ajax_get_icons' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_get_terms',      array( __CLASS__, 'ajax_get_terms' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_get_taxonomies', array( __CLASS__, 'ajax_get_taxonomies' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_add_preset',     array( __CLASS__, 'ajax_add_preset' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_remove_preset',  array( __CLASS__, 'ajax_remove_preset' ) );
		add_action( 'wp_ajax_cherry_shortcodes_generator_get_preset',     array( __CLASS__, 'ajax_get_preset' ) );
	}

	/**
	 * Generator button.
	 *
	 * @since  1.0.0
	 * @param  array  $args Arguments.
	 * @return string       HTML-markup for new media button.
	 */
	public static function button( $args = array() ) {
		// Check access.
		if ( ! self::access_check() ) {
			return;
		}

		// Prepare button target.
		$target = is_string( $args ) ? $args : 'content';

		// Prepare args.
		$args = wp_parse_args( $args, array(
				'target'    => $target,
				'text'      => __( 'Insert shortcode', 'cherry-shortcodes' ),
				'class'     => 'button',
				'icon'      => '<span class="dashicons dashicons-editor-code" style="width:18px; height:18px; vertical-align:text-top; margin: 0 2px; color: #82878c;"></span>',
				'echo'      => true,
				'shortcode' => false,
			) );

		// Print button.
		$button = '<a href="javascript:void(0);" class="cherry-generator-button ' . $args['class'] . '" title="' . $args['text'] . '" data-target="' . $args['target'] . '" data-mfp-src="#cherry-generator" data-shortcode="' . (string) $args['shortcode'] . '">' . $args['icon'] . '&nbsp;' . $args['text'] . '</a>';

		// Show generator popup.
		add_action( 'wp_footer',    array( __CLASS__, 'popup' ) );
		add_action( 'admin_footer', array( __CLASS__, 'popup' ) );

		// Request assets.
		wp_enqueue_media();

		/**
		 * Filter a stylesheet handles for beck-end.
		 *
		 * @since 1.0.0
		 * @param array $styles Set of stylesheets.
		 */
		$admin_styles = apply_filters(
			'cherry_shortcodes_admin_styles',
			array( 'simple-slider', 'wp-color-picker', 'magnific-popup', 'font-awesome', 'cherry-shortcodes-all', 'cherry-shortcodes-generator', )
		);

		cherry_query_asset( 'css', $admin_styles );
		cherry_query_asset( 'js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'simple-slider', 'wp-color-picker', 'magnific-popup', 'cherry-shortcodes-generator', ) );

		// Print/return result.
		if ( $args['echo'] ) {
			echo $button;
		}

		return $button;
	}

	/**
	 * Cache reset.
	 *
	 * @since 1.0.0
	 */
	public static function reset() {
		// Clear popup cache.
		delete_transient( 'cherry_shortcodes/generator/popup' );

		// Clear shortcodes settings cache.
		foreach ( array_keys( (array) Cherry_Shortcodes_Data::shortcodes() ) as $shortcode ) {
			delete_transient( 'cherry_shortcodes/generator/settings/' . $shortcode );
		}
	}

	/**
	 * Generator popup form.
	 *
	 * @since 1.0.0
	 */
	public static function popup() {
		// Get cache.
		$output = get_transient( 'cherry_shortcodes/generator/popup' );

		if ( $output && CHERRY_SHORTCODES_ENABLE_CACHE ) {
			echo $output;
		} else {
			ob_start();
?>
		<div id="cherry-generator-wrap" style="display:none">
			<div id="cherry-generator">
				<div id="cherry-generator-header">
					<input type="text" name="cherry_generator_search" id="cherry-generator-search" value="" placeholder="<?php _e( 'Search for shortcodes', 'cherry-shortcodes' ); ?>" />
					<div id="cherry-generator-filter">
						<strong><?php _e( 'Filter by type', 'cherry-shortcodes' ); ?></strong>
						<?php foreach ( (array) Cherry_Shortcodes_Data::groups() as $group => $label ) {
							echo '<a href="#" data-filter="' . $group . '">' . $label . '</a>';
						} ?>
					</div>
					<div id="cherry-generator-choices" class="cherry-generator-clearfix">
						<?php
						// Choices loop
						foreach ( (array) Cherry_Shortcodes_Data::shortcodes() as $name => $shortcode ) {
							$icon = ( isset( $shortcode['icon'] ) ) ? $shortcode['icon'] : 'puzzle-piece';
							$shortcode['name'] = ( isset( $shortcode['name'] ) ) ? $shortcode['name'] : $name;
							echo '<span data-name="' . $shortcode['name'] . '" data-shortcode="' . $name . '" title="' . esc_attr( $shortcode['desc'] ) . '" data-desc="' . esc_attr( $shortcode['desc'] ) . '" data-group="' . $shortcode['group'] . '">' . Cherry_Shortcodes_Tools::icon( $icon ) . $shortcode['name'] . '</span>' . "\n";
						} ?>
					</div>
				</div>
				<div id="cherry-generator-settings"></div>
				<input type="hidden" name="cherry-generator-selected" id="cherry-generator-selected" value="<?php echo plugins_url( '', CHERRY_SHORTCODES_FILE ); ?>" />
				<input type="hidden" name="cherry-compatibility-mode-prefix" id="cherry-compatibility-mode-prefix" value="<?php echo CHERRY_SHORTCODES_PREFIX; ?>" />
				<div id="cherry-generator-result" style="display:none"></div>
			</div>
		</div>
	<?php
			$output = ob_get_contents();
			set_transient( 'cherry_shortcodes/generator/popup', $output, 2 * DAY_IN_SECONDS );
			ob_end_clean();
			echo $output;
		}
	}

	/**
	 * Process AJAX request.
	 *
	 * @since 1.0.0
	 */
	public static function settings() {
		self::access();

		// Param check.
		if ( empty( $_REQUEST['shortcode'] ) ) {
			wp_die( __( 'Shortcode not specified', 'cherry-shortcodes' ) );
		}

		// Get cache.
		$output = get_transient( 'cherry_shortcodes/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ) );

		if ( $output && CHERRY_SHORTCODES_ENABLE_CACHE ) {
			echo $output;
		} else {
			// Request queried shortcode.
			$shortcode = Cherry_Shortcodes_Data::shortcodes( sanitize_key( $_REQUEST['shortcode'] ) );

			/**
			 * Filter actions.
			 *
			 * @since 1.0.0
			 * @param array $actions Array with actions.
			 */
			$actions = apply_filters( 'cherry_shortcodes/generator/actions', array(
					'insert' => '<a href="javascript:void(0);" class="button button-primary button-large cherry-generator-insert"><i class="fa fa-check"></i> ' . __( 'Insert shortcode', 'cherry-shortcodes' ) . '</a>',
					'preview' => '<a href="javascript:void(0);" class="button button-large cherry-generator-toggle-preview"><i class="fa fa-eye"></i> ' . __( 'Live preview', 'cherry-shortcodes' ) . '</a>'
				) );

			// Shortcode header.
			$return = '<div id="cherry-generator-breadcrumbs">';

			/**
			 * Filter a breadcrumbs.
			 *
			 * @since 1.0.0
			 * @param string $breadcrumbs HTML-markup with breadcrumbs.
			 */
			$return .= apply_filters( 'cherry_shortcodes/generator/breadcrumbs', '<a href="javascript:void(0);" class="cherry-generator-home" title="' . __( 'Click to return to the shortcodes list', 'cherry-shortcodes' ) . '">' . __( 'All shortcodes', 'cherry-shortcodes' ) . '</a> &rarr; <span>' . $shortcode['name'] . '</span> <small class="alignright">' . $shortcode['desc'] . '</small><div class="cherry-generator-clear"></div>' );

			$return .= '</div>';

			// Shortcode note.
			if ( isset( $shortcode['note'] ) || isset( $shortcode['example'] ) ) {
				$return .= '<div class="cherry-generator-note"><i class="fa fa-info-circle"></i><div class="cherry-generator-note-content">';

				if ( isset( $shortcode['note'] ) ) {
					$return .= wpautop( $shortcode['note'] );
				}

				if ( isset( $shortcode['example'] ) ) {
					$return .= wpautop( '<a href="' . admin_url( 'admin.php?page=cherry-shortcodes-examples&example=' . $shortcode['example'] ) . '" target="_blank">' . __( 'Examples of use', 'cherry-shortcodes' ) . ' &rarr;</a>' );
				}

				$return .= '</div></div>';
			}

			// Shortcode has atts.
			if ( isset( $shortcode['atts'] ) && count( $shortcode['atts'] ) ) {

				// Loop through shortcode parameters.
				$counter         = 0;
				$left_container  = '';
				$right_container = '';
				$half            = ceil( count( $shortcode['atts'] ) / 2 );

				foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {

					$attr_info['name'] = ( isset( $attr_info['name'] ) ) ? $attr_info['name'] : $attr_name;

					// Create field types.
					if ( ! isset( $attr_info['type'] )
						&& isset( $attr_info['values'] )
						&& is_array( $attr_info['values'] )
						&& count( $attr_info['values'] )
						) {
						$attr_info['type'] = 'select';

					} elseif ( ! isset( $attr_info['type'] ) ) {
						$attr_info['type'] = 'text';
					}

					// Prepare default value.
					$item    = '';
					$default = '';

					if ( isset( $attr_info['default'] ) ) {

						if ( is_array( $attr_info['default'] ) ) {
							foreach ( $attr_info['default'] as $key => $value ) {
								$default .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
							}
							$default .= ' data-changed=""';
						} else {
							$default = (string) $attr_info['default'];
							$default = 'data-default="' . esc_attr( $default ) . '"';
						}
					}

					$item .= '<div class="cherry-generator-attr-container cherry-generator-skip" ' . $default . ' data-field-type="' . esc_attr( $attr_info['type'] ) . '">';
					$item .= '<h5>' . $attr_info['name'] . '</h5>';

					if ( is_callable( array( 'Cherry_Shortcodes_Generator_Views', $attr_info['type'] ) ) ) {
						$item .= call_user_func( array( 'Cherry_Shortcodes_Generator_Views', $attr_info['type'] ), $attr_name, $attr_info );

					} elseif ( isset( $attr_info['callback'] ) && is_callable( $attr_info['callback'] ) ) {
						$item .= call_user_func( $attr_info['callback'], $attr_name, $attr_info );
					}

					if ( isset( $attr_info['desc'] ) ) {
						$item .= '<div class="cherry-generator-attr-desc">' . str_replace( array( '<b%value>', '<b_>' ), '<b class="cherry-generator-set-value" title="' . __( 'Click to set this value', 'cherry-shortcodes' ) . '">', $attr_info['desc'] ) . '</div>';
					}

					$item .= '</div>';

					if ( $counter < $half ) {
						$left_container .= $item;
					} else {
						$right_container .= $item;
					}

					$counter++;
				}
			}
			$return .= '<div class="cherry-generator-attr-left-container">' . $left_container . '</div>';
			$return .= '<div class="cherry-generator-attr-right-container">' . $right_container . '</div>';
			$return .= '<div class="cherry-generator-clear"></div>';

			// Single shortcode (not closed).
			if ( $shortcode['type'] == 'single' ) {
				$return .= '<input type="hidden" name="cherry-generator-content" id="cherry-generator-content" value="false" />';
			} else {
				// Wrapping shortcode. Prepare shortcode content
				$shortcode['content'] = ( isset( $shortcode['content'] ) ) ? $shortcode['content'] : '';
				$return .= '<div class="cherry-generator-attr-container"><h5>' . __( 'Content', 'cherry-shortcodes' ) . '</h5><textarea name="cherry-generator-content" id="cherry-generator-content" rows="5">' . esc_attr( str_replace( array( '%prefix_', '__' ), CHERRY_SHORTCODES_PREFIX, $shortcode['content'] ) ) . '</textarea></div>';
			}

			$return .= '<div id="cherry-generator-preview"></div>';
			$return .= '<div class="cherry-generator-actions cherry-generator-clearfix">' . implode( ' ', array_values( $actions ) ) . '</div>';
			set_transient( 'cherry_shortcodes/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ), $return, 2 * DAY_IN_SECONDS );
			echo $return;
		}

		exit;
	}

	/**
	 * Process AJAX request and generate preview HTML.
	 *
	 * @since 1.0.0
	 */
	public static function preview() {
		// Check authentication.
		self::access();

		/**
		 * Fire before preview print.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/generator/preview/before' );

		// Output results.
		echo '<h5>' . __( 'Preview', 'cherry-shortcodes' ) . '</h5>';
		// echo '<hr />' . stripslashes( $_POST['shortcode'] ) . '<hr />'; // Uncomment for debug
		echo do_shortcode( str_replace( '\"', '"', $_POST['shortcode'] ) );
		echo '<div style="clear:both"></div>';

		/**
		 * Fire after preview print.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/generator/preview/after' );

		die();
	}

	/**
	 * Check authentication.
	 *
	 * @since 1.0.0
	 */
	public static function access() {
		if ( ! self::access_check() ) {
			wp_die( __( 'Access denied', 'cherry-shortcodes' ) );
		}
	}

	/**
	 * Check a current user capability.
	 *
	 * @since  1.0.0
	 * @return bool Current user has capability.
	 */
	public static function access_check() {
		$by_role = ( get_option( 'cherry_shortcodes_generator_access' ) ) ? current_user_can( get_option( 'cherry_shortcodes_generator_access' ) ) : true;

		return current_user_can( 'edit_posts' ) && $by_role;
	}

	/**
	 * AJAX-handler for a retrieve the icons.
	 *
	 * @since  1.0.0
	 * @return string HTML-markup string with icons.
	 */
	public static function ajax_get_icons() {
		self::access();

		die( Cherry_Shortcodes_Tools::icons() );
	}

	/**
	 * AJAX-handler for a retrieve the terms.
	 *
	 * @since  1.0.0
	 * @return string HTML-markup for select with terms.
	 */
	public static function ajax_get_terms() {
		self::access();
		$args = array();

		if ( isset( $_REQUEST['tax'] ) ) {
			$args['options'] = (array) Cherry_Shortcodes_Tools::get_terms( sanitize_key( $_REQUEST['tax'] ), 'slug' );
		}

		if ( isset( $_REQUEST['class'] ) ) {
			$args['class'] = (string) sanitize_key( $_REQUEST['class'] );
		}

		if ( isset( $_REQUEST['multiple'] ) ) {
			$args['multiple'] = (bool) sanitize_key( $_REQUEST['multiple'] );
		}

		if ( isset( $_REQUEST['size'] ) ) {
			$args['size'] = (int) sanitize_key( $_REQUEST['size'] );
		}

		if ( isset( $_REQUEST['noselect'] ) ) {
			$args['noselect'] = (bool) sanitize_key( $_REQUEST['noselect'] );
		}

		die( Cherry_Shortcodes_Tools::select( $args ) );
	}

	/**
	 * AJAX-handler for a retrieve the taxonomies.
	 *
	 * @since  1.0.0
	 * @return string HTML-markup for select with taxonomies.
	 */
	public static function ajax_get_taxonomies() {
		self::access();
		$args = array();
		$args['options'] = Cherry_Shortcodes_Tools::get_taxonomies();

		die( Cherry_Shortcodes_Tools::select( $args ) );
	}

	/**
	 * Build a HTML-markup for `Presets`.
	 *
	 * @since  1.0.0
	 * @param  array $actions Set of actons.
	 * @return array
	 */
	public static function presets( $actions ) {
		ob_start(); ?>
<div class="cherry-generator-presets alignright" data-shortcode="<?php echo sanitize_key( $_REQUEST['shortcode'] ); ?>">
	<a href="javascript:void(0);" class="button button-large cherry-gp-button"><i class="fa fa-bars"></i> <?php _e( 'Presets', 'cherry-shortcodes' ); ?></a>
	<div class="cherry-gp-popup">
		<div class="cherry-gp-head">
			<a href="javascript:void(0);" class="button button-small button-primary cherry-gp-new"><?php _e( 'Save current settings as preset', 'cherry-shortcodes' ); ?></a>
		</div>
		<div class="cherry-gp-list">
			<?php self::presets_list(); ?>
		</div>
	</div>
</div>
		<?php
		$actions['presets'] = ob_get_contents();
		ob_end_clean();

		return $actions;
	}

	/**
	 * Dispaly a list of presets.
	 *
	 * @since 1.0.0
	 * @param boolean|string $shortcode Shortcode name.
	 */
	public static function presets_list( $shortcode = false ) {
		// Shortcode isn't specified, try to get it from $_REQUEST.
		if ( ! $shortcode ) {
			$shortcode = $_REQUEST['shortcode'];
		}

		// Shortcode name is still doesn't exists, exit.
		if ( ! $shortcode ) {
			return;
		}

		// Shortcode has been specified, sanitize it.
		$shortcode = sanitize_key( $shortcode );

		// Get presets.
		$presets = get_option( 'cherry_shortcodes_presets_' . $shortcode );

		// Presets has been found.
		if ( is_array( $presets ) && count( $presets ) ) {
			// Print the presets.
			foreach( $presets as $preset ) {
				echo '<span data-id="' . $preset['id'] . '"><em>' . stripslashes( $preset['name'] ) . '</em> <i class="fa fa-times"></i></span>';
			}
			// Hide default text.
			echo sprintf( '<b style="display:none">%s</b>', __( 'Presets not found', 'cherry-shortcodes' ) );
		} else {
			// Presets doesn't found.
			echo sprintf( '<b>%s</b>', __( 'Presets not found', 'cherry-shortcodes' ) );
		}
	}

	/**
	 * AJAX-handler for save a new shortcode preset.
	 *
	 * @since 1.0.0
	 */
	public static function ajax_add_preset() {
		self::access();

		// Check incoming data.
		if ( empty( $_POST['id'] ) ) {
			return;
		}

		if ( empty( $_POST['name'] ) ) {
			return;
		}

		if ( empty( $_POST['settings'] ) ) {
			return;
		}

		if ( empty( $_POST['shortcode'] ) ) {
			return;
		}

		// Clean-up incoming data.
		$id        = sanitize_key( $_POST['id'] );
		$name      = sanitize_text_field( $_POST['name'] );
		$settings  = ( is_array( $_POST['settings'] ) ) ? stripslashes_deep( $_POST['settings'] ) : array();
		$shortcode = sanitize_key( $_POST['shortcode'] );

		// Prepare option name.
		$option = 'cherry_shortcodes_presets_' . $shortcode;

		// Get the existing presets.
		$current = get_option( $option );

		// Create array with new preset.
		$new = array(
			'id'       => $id,
			'name'     => $name,
			'settings' => $settings,
		);

		// Add new array to the option value.
		if ( ! is_array( $current ) ) {
			$current = array();
		}

		$current[ $id ] = $new;

		// Save updated option.
		update_option( $option, $current );

		// Clear cache.
		delete_transient( 'cherry_shortcodes/generator/settings/' . $shortcode );
	}

	/**
	 * AJAX-handler for remove a shortcode preset.
	 *
	 * @since 1.0.0
	 */
	public static function ajax_remove_preset() {
		self::access();

		// Check incoming data.
		if ( empty( $_POST['id'] ) ) {
			return;
		}

		if ( empty( $_POST['shortcode'] ) ) {
			return;
		}

		// Clean-up incoming data.
		$id        = sanitize_key( $_POST['id'] );
		$shortcode = sanitize_key( $_POST['shortcode'] );

		// Prepare option name.
		$option = 'cherry_shortcodes_presets_' . $shortcode;

		// Get the existing presets.
		$current = get_option( $option );

		// Check that preset is exists.
		if ( ! is_array( $current ) || empty( $current[ $id ] ) ) {
			return;
		}

		// Remove preset.
		unset( $current[$id] );

		// Save updated option.
		update_option( $option, $current );

		// Clear cache.
		delete_transient( 'cherry_shortcodes/generator/settings/' . $shortcode );
	}

	/**
	 * AJAX-handler for retrieve a shortcode presets in JSON-format.
	 *
	 * @since  1.0.0
	 * @return array Shortcode presets.
	 */
	public static function ajax_get_preset() {
		self::access();

		// Check incoming data.
		if ( empty( $_GET['id'] ) ) {
			return;
		}

		if ( empty( $_GET['shortcode'] ) ) {
			return;
		}

		// Clean-up incoming data.
		$id        = sanitize_key( $_GET['id'] );
		$shortcode = sanitize_key( $_GET['shortcode'] );

		// Default data.
		$data = array();

		// Get the existing presets.
		$presets = get_option( 'cherry_shortcodes_presets_' . $shortcode );

		// Check that preset is exists.
		if ( is_array( $presets ) && isset( $presets[ $id ]['settings'] ) ) {
			$data = $presets[ $id ]['settings'];
		}

		// Print results.
		die( json_encode( $data ) );
	}
}

new Cherry_Shortcodes_Generator;

?>