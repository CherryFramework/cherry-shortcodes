<?php
/**
 * Managing assets.
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
 * Class for managing plugin assets.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Assets {

	/**
	 * Set of queried assets.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var array $assets Array with assets.
	 */
	public static $assets = array(
		'css' => array(),
		'js'  => array(),
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register.
		add_action( 'wp_head',                                    array( __CLASS__, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts',                         array( __CLASS__, 'register_styles' ) );
		add_action( 'cherry_shortcodes/generator/preview/before', array( __CLASS__, 'register_scripts' ) );
		add_action( 'cherry_shortcodes/generator/preview/before', array( __CLASS__, 'register_styles' ) );
		add_action( 'admin_head',                                 array( __CLASS__, 'admin_register_assets' ) );

		// Enqueue.
		add_action( 'wp_footer',          array( __CLASS__, 'enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_action( 'admin_footer',       array( __CLASS__, 'admin_enqueue_assets' ) );

		// Print.
		add_action( 'cherry_shortcodes/generator/preview/after', array( __CLASS__, 'prnt' ) );

		// Pass style handle to CSS compiler.
		add_filter( 'cherry_compiler_static_css', array( $this, 'add_style_to_compiler' ) );
	}

	/**
	 * Register javascripts on front pages.
	 *
	 * @since  1.0.0
	 * @global bool $is_IE Is a Internet Explorer?
	 */
	public static function register_scripts() {
		global $is_IE;

		if ( ! ( wp_is_mobile() || $is_IE && preg_match( '/MSIE [56789]/', $_SERVER['HTTP_USER_AGENT'] ) ) ) {
			// Lazy Load Effect.
			wp_register_script( 'cherry-lazy-load-effect', plugins_url( 'assets/js/shotcodes/lazy-load-effect.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		}

		// Magnific Popup.
		wp_register_script( 'magnific-popup', plugins_url( 'assets/js/jquery.magnific-popup.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );

		// Google Maps.
		wp_register_script( 'googlemapapis', Cherry_Shortcodes_Tools::get_google_map_url(), array(), false, true );
		wp_register_script( 'cherry-google-map', plugins_url( 'assets/js/shotcodes/google-map.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery', 'googlemapapis' ), CHERRY_SHORTCODES_VERSION, true );

		// Swiper.
		wp_register_script( 'swiper', plugins_url( 'assets/js/shotcodes/swiper.jquery.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );

		// Parallax.
		wp_register_script( 'device', plugins_url( 'assets/js/shotcodes/device.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_script( 'cherry-parallax', plugins_url( 'assets/js/shotcodes/parallax.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery', 'device' ), CHERRY_SHORTCODES_VERSION, true );

		// Counter.
		wp_register_script( 'waypoints', plugins_url( 'assets/js/shotcodes/waypoints.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_script( 'jquery-counterup', plugins_url( 'assets/js/shotcodes/jquery.counterup.min.js', CHERRY_SHORTCODES_FILE ), array( 'waypoints' ), CHERRY_SHORTCODES_VERSION, true );

		// Video Preview.
		wp_register_script( 'video-preview', plugins_url( 'assets/js/shotcodes/video-preview.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_script( 'video-youtube', 'https://www.youtube.com/player_api/', array( 'jquery' , 'video-preview' ), null, true );

		// Countdown.
		wp_register_script( 'jquery-countdown', plugins_url( 'assets/js/shotcodes/jquery.countdown.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );

		// Page Anchor.
		wp_register_script( 'page-anchor', plugins_url( 'assets/js/shotcodes/page-anchor.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );

		// Shortcodes init.
		wp_register_script( 'cherry-shortcodes-init', plugins_url( 'assets/js/shotcodes/init.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );

		/**
		 * Hook to deregister javascripts or add custom.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/register_scripts' );
	}

	/**
	 * Register stylesheets on front pages.
	 *
	 * @since 1.0.0
	 */
	public static function register_styles() {

		if ( ! class_exists( 'Cherry_Framework' ) || ( doing_filter( 'cherry_shortcodes/generator/preview/before' ) ) ) {
			wp_register_style( 'cherry-shortcodes-grid', plugins_url( 'assets/css/grid.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );
		}
		// Magnific Popup.
		wp_register_style( 'magnific-popup', plugins_url( 'assets/css/magnific-popup.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );
		// Font Awesome.
		wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '4.4.0', 'all' );
		// Swiper.
		wp_register_style( 'swiper', plugins_url( 'assets/css/swiper.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );
		// Shortcodes style.
		wp_register_style( 'cherry-shortcodes-all', plugins_url( 'assets/css/shortcodes.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );

		/**
		 * Hook to deregister stylesheets or add custom.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/register_styles' );
	}

	/**
	 * Register assets on admin pages.
	 *
	 * @since 1.0.0
	 */
	public static function admin_register_assets() {

		// Simple Slider.
		wp_register_script( 'simple-slider', plugins_url( 'assets/js/simple-slider.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_style( 'simple-slider', plugins_url( 'assets/css/simple-slider.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );

		// Magnific Popup.
		wp_register_script( 'magnific-popup', plugins_url( 'assets/js/jquery.magnific-popup.min.js', CHERRY_SHORTCODES_FILE ), array( 'jquery' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_style( 'magnific-popup', plugins_url( 'assets/css/magnific-popup.css', CHERRY_SHORTCODES_FILE ), false, CHERRY_SHORTCODES_VERSION, 'all' );

		// Font Awesome.
		wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '4.4.0', 'all' );

		wp_register_script( 'cherry-shortcodes-generator', plugins_url( 'assets/js/generator.js', CHERRY_SHORTCODES_FILE ), array( 'wp-color-picker', 'magnific-popup', 'jquery-ui-datepicker' ), CHERRY_SHORTCODES_VERSION, true );
		wp_register_style( 'cherry-shortcodes-generator', plugins_url( 'assets/css/generator.css', CHERRY_SHORTCODES_FILE ), array( 'wp-color-picker', 'magnific-popup' ), CHERRY_SHORTCODES_VERSION, 'all' );

		wp_localize_script( 'cherry-shortcodes-generator', 'cherry_shortcodes_generator', array(
			'upload_title'         => __( 'Choose file', 'cherry-shortcodes' ),
			'upload_insert'        => __( 'Insert', 'cherry-shortcodes' ),
			'isp_media_title'      => __( 'Select images', 'cherry-shortcodes' ),
			'isp_media_insert'     => __( 'Add selected images', 'cherry-shortcodes' ),
			'presets_prompt_msg'   => __( 'Please enter a name for new preset', 'cherry-shortcodes' ),
			'presets_prompt_value' => __( 'New preset', 'cherry-shortcodes' ),
			'last_used'            => __( 'Last used settings', 'cherry-shortcodes' ),
		) );

		/**
		 * Hook to deregister assets or add custom on back-end.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/admin_register_assets' );
	}

	/**
	 * Enqueue javascripts on front pages.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_assets() {
		$assets = self::assets();

		// Enqueue stylesheets.
		foreach ( $assets['css'] as $style ) {
			wp_enqueue_style( $style );
		}

		// Enqueue scripts.
		foreach ( $assets['js'] as $script ) {
			wp_enqueue_script( $script );
		}

		/**
		 * Hook to dequeue javascripts or add custom.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/enqueue_scripts' );
	}

	/**
	 * Enqueue stylesheets on front pages.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'swiper' );
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_style( 'cherry-shortcodes-grid' );
		wp_enqueue_style( 'cherry-shortcodes-all' );

		/**
		 * Hook to dequeue stylesheets or add custom.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/enqueue_styles' );
	}

	/**
	 * Print stylesheets on preview.
	 *
	 * @since 1.0.0
	 */
	public static function prnt() {
		wp_print_styles( 'font-awesome' );
		wp_print_styles( 'swiper' );
		wp_print_styles( 'cherry-shortcodes-grid' );
		wp_print_styles( 'cherry-shortcodes-all' );

		$assets = self::assets();
		wp_print_scripts( $assets['js'] );

		/**
		 * Hook to remove css/js or add custom without enqueuing.
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/print', $assets );
	}

	/**
	 * Enqueue assets on admin pages.
	 *
	 * @since 1.0.0
	 */
	public static function admin_enqueue_assets() {
		$assets = self::assets();

		// Enqueue stylesheets.
		foreach ( $assets['css'] as $style ) {
			wp_enqueue_style( $style );
		}

		// Enqueue scripts.
		foreach ( $assets['js'] as $script ) {
			wp_enqueue_script( $script );
		}

		/**
		 * Hook to remove css/js or add custom (back-end).
		 *
		 * @since 1.0.0
		 */
		do_action( 'cherry_shortcodes/assets/admin_enqueue_assets' );
	}

	/**
	 * Add asset to the query.
	 *
	 * @since 1.0.0
	 * @param string $type   Asset type (css|js).
	 * @param mixed  $handle Asset handle or array with handles.
	 */
	public static function add( $type, $handle ) {

		if ( is_array( $handle ) ) {
			foreach ( $handle as $h ) {
				self::$assets[ $type ][ $h ] = $h;
			}
		} else {
			self::$assets[ $type ][ $handle ] = $handle;
		}
	}

	/**
	 * Get queried assets.
	 *
	 * @since  1.0.0
	 * @return array Set of assets.
	 */
	public static function assets() {
		// Get assets query.
		$assets = self::$assets;

		// Apply filters to assets set.
		$assets['css'] = array_unique( (array) apply_filters( 'cherry_shortcodes/assets/css', (array) array_unique( $assets['css'] ) ) );
		$assets['js'] = array_unique( (array) apply_filters( 'cherry_shortcodes/assets/js', (array) array_unique( $assets['js'] ) ) );

		return $assets;
	}

	/**
	 * Pass style handle to CSS compiler.
	 *
	 * @since  1.0.0
	 * @param  array $handles CSS handles to compile.
	 * @return array
	 */
	public static function add_style_to_compiler( $handles ) {
		$handles = array_merge(
			array( 'cherry-shortcodes-all' => plugins_url( 'assets/css/shortcodes.css', CHERRY_SHORTCODES_FILE ) ),
			$handles
		);

		return $handles;
	}
}

new Cherry_Shortcodes_Assets;

/**
 * Helper function to add asset to the query.
 *
 * @since 1.0.0
 * @param string $type   Asset type (css|js).
 * @param mixed  $handle Asset handle or array with handles.
 */
function cherry_query_asset( $type, $handle ) {
	Cherry_Shortcodes_Assets::add( $type, $handle );
}
