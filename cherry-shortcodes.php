<?php
/**
 * Plugin Name: Cherry Shortcodes
 * Plugin URI:  http://www.cherryframework.com/
 * Description: A pack of WordPress shortcodes.
 * Version:     1.0.7.6
 * Author:      Cherry Team
 * Author URI:  http://www.cherryframework.com/
 * Text Domain: cherry-shortcodes
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// If class 'Cherry_Shortcodes' not exists.
if ( !class_exists( 'Cherry_Shortcodes' ) ) {

	/**
	 * Sets up and initializes the Cherry Shortcodes plugin.
	 *
	 * @since 1.0.0
	 */
	class Cherry_Shortcodes {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Set the constants needed by the plugin.
			add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

			// Make plugin available for translation.
			add_action( 'plugins_loaded', array( $this, 'lang' ),      2 );

			// Load the functions files.
			add_action( 'plugins_loaded', array( $this, 'includes' ),  3 );

			add_action( 'init', array( $this, 'register' ), 11 );
			add_action( 'init', array( $this, 'update' ),   20 );

			// Enable shortcodes in text widgets.
			add_filter( 'widget_text', 'do_shortcode' );

			// Apply custom formatter function.
			add_filter( 'the_content', array( $this, 'clean_shortcodes' ) );

			register_activation_hook( __FILE__,   array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Defines constants for the plugin.
		 *
		 * @since 1.0.0
		 */
		function constants() {

			/**
			 * Set constant path to the plugin main file.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_FILE', __FILE__ );

			/**
			 * Set the version number of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_VERSION', '1.0.7.6' );

			/**
			 * Set the slug of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_SLUG', basename( dirname( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin directory.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin URI.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			/**
			 * Set prefix for shortcodes.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_PREFIX', 'cherry_' );

			/**
			 * Use or not Transients API cache.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SHORTCODES_ENABLE_CACHE', false );
		}

		/**
		 * Loads the plugin's translated strings.
		 *
		 * @since 1.0.0
		 */
		function lang() {
			load_plugin_textdomain( 'cherry-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Loads files from the 'inc' folder.
		 *
		 * @since 1.0.0
		 */
		function includes() {
			require_once( CHERRY_SHORTCODES_DIR . 'inc/vendor/sunrise.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/assets.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/shortcodes.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/data.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/tools.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/generator-views.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/generator.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/widget.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/filters.php' );
			require_once( CHERRY_SHORTCODES_DIR . 'inc/extensions/aq_resizer.php' );

			if ( is_admin() ) {
				require_once( CHERRY_SHORTCODES_DIR . 'admin/includes/class-cherry-update/class-cherry-plugin-update.php' );

				$Cherry_Plugin_Update = new Cherry_Plugin_Update();
				$Cherry_Plugin_Update->init( array(
						'version'         => CHERRY_SHORTCODES_VERSION,
						'slug'            => CHERRY_SHORTCODES_SLUG,
						'repository_name' => CHERRY_SHORTCODES_SLUG,
				) );
			}
		}

		/**
		 * Register shortcodes.
		 *
		 * @since 1.0.0
		 */
		public function register() {

			foreach ( ( array ) Cherry_Shortcodes_Data::shortcodes() as $id => $data ) {

				if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) {
					$func = $data['function'];
				} elseif ( is_callable( array( 'Cherry_Shortcodes_Handler', $id ) ) ) {
					$func = array( 'Cherry_Shortcodes_Handler', $id );
				} elseif ( is_callable( array( 'Cherry_Shortcodes_Handler', CHERRY_SHORTCODES_PREFIX . $id ) ) ) {
					$func = array( 'Cherry_Shortcodes_Handler', CHERRY_SHORTCODES_PREFIX . $id );
				} else continue;

				// Register shortcode.
				add_shortcode( CHERRY_SHORTCODES_PREFIX . $id, $func );
			}

			/**
			 * Adds a fallback-compatibility after renaming shortcodes.
			 *
			 * @since 1.0.2
			 * @see   https://github.com/CherryFramework/cherry-shortcodes/issues/1
			 */
			add_shortcode( CHERRY_SHORTCODES_PREFIX . 'paralax_image', array( 'Cherry_Shortcodes_Handler', 'parallax_image' ) );
			add_shortcode( CHERRY_SHORTCODES_PREFIX . 'paralax_html_video', array( 'Cherry_Shortcodes_Handler', 'parallax_html_video' ) );

			// Class Cherry API JS
			require_once( CHERRY_SHORTCODES_DIR . 'inc/class-cherry-api-js.php' );
		}

		/**
		 * Plugin update hook.
		 *
		 * @since 1.0.0
		 */
		public function update() {
			$option = get_option( 'cherry_shortcodes_version' );

			if ( $option !== CHERRY_SHORTCODES_VERSION ) {
				update_option( 'cherry_shortcodes_version', CHERRY_SHORTCODES_VERSION );
				do_action( 'cherry_shortcodes/update' );
			}
		}

		/**
		 * Plugin activation.
		 *
		 * @since 1.0.0
		 */
		public function activation() {
			$this->timestamp();
			do_action( 'cherry_shortcodes/activation' );
		}

		/**
		 * Plugin deactivation.
		 *
		 * @since 1.0.0
		 */
		public function deactivation() {
			do_action( 'cherry_shortcodes/deactivation' );
		}

		/**
		 * Add timestamp.
		 *
		 * @since 1.0.0
		 */
		public function timestamp() {
			if ( !get_option( 'cherry_shortcodes_installed' ) ) {
				update_option( 'cherry_shortcodes_installed', time() );
			}
		}

		/**
		 * Custom formatter function.
		 *
		 * @since  1.0.0
		 *
		 * @param  string  $content
		 * @return string           Formatted content with clean shortcodes content
		 */
		function clean_shortcodes( $content ) {
			$array = array (
				'<p>[' => '[',
				']</p>' => ']',
				']<br />' => ']'
			);
			$content = strtr( $content, $array );

			return $content;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance )
				self::$instance = new self;

			return self::$instance;
		}
	}

	Cherry_Shortcodes::get_instance();
}
