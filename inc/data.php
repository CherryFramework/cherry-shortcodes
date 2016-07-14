<?php
/**
 * Managing data.
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
 * Class for managing plugin data.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Data {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {}

	/**
	 * Retrive a shortcode groups.
	 *
	 * @since  1.0.0
	 * @return array Shortcode groups.
	 */
	public static function groups() {
		/**
		 * Filter a shortcode groups.
		 *
		 * @since 1.0.0
		 * @param array $groups Shortcode groups.
		 */
		return apply_filters( 'cherry_shortcodes/data/groups', array(
				'all'        => __( 'All', 'cherry-shortcodes' ),
				'grid'       => __( 'Grid', 'cherry-shortcodes' ),
				'typography' => __( 'Typography', 'cherry-shortcodes' ),
				'content'    => __( 'Content', 'cherry-shortcodes' ),
				'media'      => __( 'Media', 'cherry-shortcodes' ),
				'components' => __( 'Components', 'cherry-shortcodes' ),
				'other'      => __( 'Other', 'cherry-shortcodes' ),
			) );
	}

	/**
	 * Retrive a border styles.
	 *
	 * @since  1.0.0
	 * @return array Border styles.
	 */
	public static function borders() {
		/**
		 * Filter a border styles.
		 *
		 * @since 1.0.0
		 * @param array $borders Border styles.
		 */
		return apply_filters( 'cherry_shortcodes/data/borders', array(
			'none'   => __( 'None', 'cherry-shortcodes' ),
			'solid'  => __( 'Solid', 'cherry-shortcodes' ),
			'dotted' => __( 'Dotted', 'cherry-shortcodes' ),
			'dashed' => __( 'Dashed', 'cherry-shortcodes' ),
			'double' => __( 'Double', 'cherry-shortcodes' ),
			'groove' => __( 'Groove', 'cherry-shortcodes' ),
			'ridge'  => __( 'Ridge', 'cherry-shortcodes' ),
		) );
	}

	/**
	 * Retrieve a Font-Awesome icons.
	 *
	 * @since  1.0.0
	 * @return array Font-Awesome icons.
	 */
	public static function icons() {
		/**
		 * Filter a Font-Awesome icons.
		 *
		 * @since 1.0.0
		 * @param array $icons Font-Awesome icons.
		 */
		return apply_filters( 'cherry_shortcodes/data/icons', array( 'fa fa-glass', 'fa fa-music', 'fa fa-search', 'fa fa-envelope-o', 'fa fa-heart', 'fa fa-star', 'fa fa-star-o', 'fa fa-user', 'fa fa-film', 'fa fa-th-large', 'fa fa-th', 'fa fa-th-list', 'fa fa-check', 'fa fa-remove', 'fa fa-close', 'fa fa-times', 'fa fa-search-plus', 'fa fa-search-minus', 'fa fa-power-off', 'fa fa-signal', 'fa fa-gear', 'fa fa-cog', 'fa fa-trash-o', 'fa fa-home', 'fa fa-file-o', 'fa fa-clock-o', 'fa fa-road', 'fa fa-download', 'fa fa-arrow-circle-o-down', 'fa fa-arrow-circle-o-up', 'fa fa-inbox', 'fa fa-play-circle-o', 'fa fa-rotate-right', 'fa fa-repeat', 'fa fa-refresh', 'fa fa-list-alt', 'fa fa-lock', 'fa fa-flag', 'fa fa-headphones', 'fa fa-volume-off', 'fa fa-volume-down', 'fa fa-volume-up', 'fa fa-qrcode', 'fa fa-barcode', 'fa fa-tag', 'fa fa-tags', 'fa fa-book', 'fa fa-bookmark', 'fa fa-print', 'fa fa-camera', 'fa fa-font', 'fa fa-bold', 'fa fa-italic', 'fa fa-text-height', 'fa fa-text-width', 'fa fa-align-left', 'fa fa-align-center', 'fa fa-align-right', 'fa fa-align-justify', 'fa fa-list', 'fa fa-dedent', 'fa fa-outdent', 'fa fa-indent', 'fa fa-video-camera', 'fa fa-photo', 'fa fa-image', 'fa fa-picture-o', 'fa fa-pencil', 'fa fa-map-marker', 'fa fa-adjust', 'fa fa-tint', 'fa fa-edit', 'fa fa-pencil-square-o', 'fa fa-share-square-o', 'fa fa-check-square-o', 'fa fa-arrows', 'fa fa-step-backward', 'fa fa-fast-backward', 'fa fa-backward', 'fa fa-play', 'fa fa-pause', 'fa fa-stop', 'fa fa-forward', 'fa fa-fast-forward', 'fa fa-step-forward', 'fa fa-eject', 'fa fa-chevron-left', 'fa fa-chevron-right', 'fa fa-plus-circle', 'fa fa-minus-circle', 'fa fa-times-circle', 'fa fa-check-circle', 'fa fa-question-circle', 'fa fa-info-circle', 'fa fa-crosshairs', 'fa fa-times-circle-o', 'fa fa-check-circle-o', 'fa fa-ban', 'fa fa-arrow-left', 'fa fa-arrow-right', 'fa fa-arrow-up', 'fa fa-arrow-down', 'fa fa-mail-forward', 'fa fa-share', 'fa fa-expand', 'fa fa-compress', 'fa fa-plus', 'fa fa-minus', 'fa fa-asterisk', 'fa fa-exclamation-circle', 'fa fa-gift', 'fa fa-leaf', 'fa fa-fire', 'fa fa-eye', 'fa fa-eye-slash', 'fa fa-warning', 'fa fa-exclamation-triangle', 'fa fa-plane', 'fa fa-calendar', 'fa fa-random', 'fa fa-comment', 'fa fa-magnet', 'fa fa-chevron-up', 'fa fa-chevron-down', 'fa fa-retweet', 'fa fa-shopping-cart', 'fa fa-folder', 'fa fa-folder-open', 'fa fa-arrows-v', 'fa fa-arrows-h', 'fa fa-bar-chart-o', 'fa fa-bar-chart', 'fa fa-twitter-square', 'fa fa-facebook-square', 'fa fa-camera-retro', 'fa fa-key', 'fa fa-gears', 'fa fa-cogs', 'fa fa-comments', 'fa fa-thumbs-o-up', 'fa fa-thumbs-o-down', 'fa fa-star-half', 'fa fa-heart-o', 'fa fa-sign-out', 'fa fa-linkedin-square', 'fa fa-thumb-tack', 'fa fa-external-link', 'fa fa-sign-in', 'fa fa-trophy', 'fa fa-github-square', 'fa fa-upload', 'fa fa-lemon-o', 'fa fa-phone', 'fa fa-square-o', 'fa fa-bookmark-o', 'fa fa-phone-square', 'fa fa-twitter', 'fa fa-facebook-f', 'fa fa-facebook', 'fa fa-github', 'fa fa-unlock', 'fa fa-credit-card', 'fa fa-rss', 'fa fa-hdd-o', 'fa fa-bullhorn', 'fa fa-bell', 'fa fa-certificate', 'fa fa-hand-o-right', 'fa fa-hand-o-left', 'fa fa-hand-o-up', 'fa fa-hand-o-down', 'fa fa-arrow-circle-left', 'fa fa-arrow-circle-right', 'fa fa-arrow-circle-up', 'fa fa-arrow-circle-down', 'fa fa-globe', 'fa fa-wrench', 'fa fa-tasks', 'fa fa-filter', 'fa fa-briefcase', 'fa fa-arrows-alt', 'fa fa-group', 'fa fa-users', 'fa fa-chain', 'fa fa-link', 'fa fa-cloud', 'fa fa-flask', 'fa fa-cut', 'fa fa-scissors', 'fa fa-copy', 'fa fa-files-o', 'fa fa-paperclip', 'fa fa-save', 'fa fa-floppy-o', 'fa fa-square', 'fa fa-navicon', 'fa fa-reorder', 'fa fa-bars', 'fa fa-list-ul', 'fa fa-list-ol', 'fa fa-strikethrough', 'fa fa-underline', 'fa fa-table', 'fa fa-magic', 'fa fa-truck', 'fa fa-pinterest', 'fa fa-pinterest-square', 'fa fa-google-plus-square', 'fa fa-google-plus', 'fa fa-money', 'fa fa-caret-down', 'fa fa-caret-up', 'fa fa-caret-left', 'fa fa-caret-right', 'fa fa-columns', 'fa fa-unsorted', 'fa fa-sort', 'fa fa-sort-down', 'fa fa-sort-desc', 'fa fa-sort-up', 'fa fa-sort-asc', 'fa fa-envelope', 'fa fa-linkedin', 'fa fa-rotate-left', 'fa fa-undo', 'fa fa-legal', 'fa fa-gavel', 'fa fa-dashboard', 'fa fa-tachometer', 'fa fa-comment-o', 'fa fa-comments-o', 'fa fa-flash', 'fa fa-bolt', 'fa fa-sitemap', 'fa fa-umbrella', 'fa fa-paste', 'fa fa-clipboard', 'fa fa-lightbulb-o', 'fa fa-exchange', 'fa fa-cloud-download', 'fa fa-cloud-upload', 'fa fa-user-md', 'fa fa-stethoscope', 'fa fa-suitcase', 'fa fa-bell-o', 'fa fa-coffee', 'fa fa-cutlery', 'fa fa-file-text-o', 'fa fa-building-o', 'fa fa-hospital-o', 'fa fa-ambulance', 'fa fa-medkit', 'fa fa-fighter-jet', 'fa fa-beer', 'fa fa-h-square', 'fa fa-plus-square', 'fa fa-angle-double-left', 'fa fa-angle-double-right', 'fa fa-angle-double-up', 'fa fa-angle-double-down', 'fa fa-angle-left', 'fa fa-angle-right', 'fa fa-angle-up', 'fa fa-angle-down', 'fa fa-desktop', 'fa fa-laptop', 'fa fa-tablet', 'fa fa-mobile-phone', 'fa fa-mobile', 'fa fa-circle-o', 'fa fa-quote-left', 'fa fa-quote-right', 'fa fa-spinner', 'fa fa-circle', 'fa fa-mail-reply', 'fa fa-reply', 'fa fa-github-alt', 'fa fa-folder-o', 'fa fa-folder-open-o', 'fa fa-smile-o', 'fa fa-frown-o', 'fa fa-meh-o', 'fa fa-gamepad', 'fa fa-keyboard-o', 'fa fa-flag-o', 'fa fa-flag-checkered', 'fa fa-terminal', 'fa fa-code', 'fa fa-mail-reply-all', 'fa fa-reply-all', 'fa fa-star-half-empty', 'fa fa-star-half-full', 'fa fa-star-half-o', 'fa fa-location-arrow', 'fa fa-crop', 'fa fa-code-fork', 'fa fa-unlink', 'fa fa-chain-broken', 'fa fa-question', 'fa fa-info', 'fa fa-exclamation', 'fa fa-superscript', 'fa fa-subscript', 'fa fa-eraser', 'fa fa-puzzle-piece', 'fa fa-microphone', 'fa fa-microphone-slash', 'fa fa-shield', 'fa fa-calendar-o', 'fa fa-fire-extinguisher', 'fa fa-rocket', 'fa fa-maxcdn', 'fa fa-chevron-circle-left', 'fa fa-chevron-circle-right', 'fa fa-chevron-circle-up', 'fa fa-chevron-circle-down', 'fa fa-anchor', 'fa fa-unlock-alt', 'fa fa-bullseye', 'fa fa-ellipsis-h', 'fa fa-ellipsis-v', 'fa fa-rss-square', 'fa fa-play-circle', 'fa fa-ticket', 'fa fa-minus-square', 'fa fa-minus-square-o', 'fa fa-level-up', 'fa fa-level-down', 'fa fa-check-square', 'fa fa-pencil-square', 'fa fa-external-link-square', 'fa fa-share-square', 'fa fa-compass', 'fa fa-toggle-down', 'fa fa-caret-square-o-down', 'fa fa-toggle-up', 'fa fa-caret-square-o-up', 'fa fa-toggle-right', 'fa fa-caret-square-o-right', 'fa fa-euro', 'fa fa-eur', 'fa fa-gbp', 'fa fa-dollar', 'fa fa-usd', 'fa fa-rupee', 'fa fa-inr', 'fa fa-cny', 'fa fa-rmb', 'fa fa-yen', 'fa fa-jpy', 'fa fa-ruble', 'fa fa-rouble', 'fa fa-rub', 'fa fa-won', 'fa fa-krw', 'fa fa-bitcoin', 'fa fa-btc', 'fa fa-file', 'fa fa-file-text', 'fa fa-sort-alpha-asc', 'fa fa-sort-alpha-desc', 'fa fa-sort-amount-asc', 'fa fa-sort-amount-desc', 'fa fa-sort-numeric-asc', 'fa fa-sort-numeric-desc', 'fa fa-thumbs-up', 'fa fa-thumbs-down', 'fa fa-youtube-square', 'fa fa-youtube', 'fa fa-xing', 'fa fa-xing-square', 'fa fa-youtube-play', 'fa fa-dropbox', 'fa fa-stack-overflow', 'fa fa-instagram', 'fa fa-flickr', 'fa fa-adn', 'fa fa-bitbucket', 'fa fa-bitbucket-square', 'fa fa-tumblr', 'fa fa-tumblr-square', 'fa fa-long-arrow-down', 'fa fa-long-arrow-up', 'fa fa-long-arrow-left', 'fa fa-long-arrow-right', 'fa fa-apple', 'fa fa-windows', 'fa fa-android', 'fa fa-linux', 'fa fa-dribbble', 'fa fa-skype', 'fa fa-foursquare', 'fa fa-trello', 'fa fa-female', 'fa fa-male', 'fa fa-gittip', 'fa fa-gratipay', 'fa fa-sun-o', 'fa fa-moon-o', 'fa fa-archive', 'fa fa-bug', 'fa fa-vk', 'fa fa-weibo', 'fa fa-renren', 'fa fa-pagelines', 'fa fa-stack-exchange', 'fa fa-arrow-circle-o-right', 'fa fa-arrow-circle-o-left', 'fa fa-toggle-left', 'fa fa-caret-square-o-left', 'fa fa-dot-circle-o', 'fa fa-wheelchair', 'fa fa-vimeo-square', 'fa fa-turkish-lira', 'fa fa-try', 'fa fa-plus-square-o', 'fa fa-space-shuttle', 'fa fa-slack', 'fa fa-envelope-square', 'fa fa-wordpress', 'fa fa-openid', 'fa fa-institution', 'fa fa-bank', 'fa fa-university', 'fa fa-mortar-board', 'fa fa-graduation-cap', 'fa fa-yahoo', 'fa fa-google', 'fa fa-reddit', 'fa fa-reddit-square', 'fa fa-stumbleupon-circle', 'fa fa-stumbleupon', 'fa fa-delicious', 'fa fa-digg', 'fa fa-pied-piper', 'fa fa-pied-piper-alt', 'fa fa-drupal', 'fa fa-joomla', 'fa fa-language', 'fa fa-fax', 'fa fa-building', 'fa fa-child', 'fa fa-paw', 'fa fa-spoon', 'fa fa-cube', 'fa fa-cubes', 'fa fa-behance', 'fa fa-behance-square', 'fa fa-steam', 'fa fa-steam-square', 'fa fa-recycle', 'fa fa-automobile', 'fa fa-car', 'fa fa-cab', 'fa fa-taxi', 'fa fa-tree', 'fa fa-spotify', 'fa fa-deviantart', 'fa fa-soundcloud', 'fa fa-database', 'fa fa-file-pdf-o', 'fa fa-file-word-o', 'fa fa-file-excel-o', 'fa fa-file-powerpoint-o', 'fa fa-file-photo-o', 'fa fa-file-picture-o', 'fa fa-file-image-o', 'fa fa-file-zip-o', 'fa fa-file-archive-o', 'fa fa-file-sound-o', 'fa fa-file-audio-o', 'fa fa-file-movie-o', 'fa fa-file-video-o', 'fa fa-file-code-o', 'fa fa-vine', 'fa fa-codepen', 'fa fa-jsfiddle', 'fa fa-life-bouy', 'fa fa-life-buoy', 'fa fa-life-saver', 'fa fa-support', 'fa fa-life-ring', 'fa fa-circle-o-notch', 'fa fa-ra', 'fa fa-rebel', 'fa fa-ge', 'fa fa-empire', 'fa fa-git-square', 'fa fa-git', 'fa fa-hacker-news', 'fa fa-tencent-weibo', 'fa fa-qq', 'fa fa-wechat', 'fa fa-weixin', 'fa fa-send', 'fa fa-paper-plane', 'fa fa-send-o', 'fa fa-paper-plane-o', 'fa fa-history', 'fa fa-genderless', 'fa fa-circle-thin', 'fa fa-header', 'fa fa-paragraph', 'fa fa-sliders', 'fa fa-share-alt', 'fa fa-share-alt-square', 'fa fa-bomb', 'fa fa-soccer-ball-o', 'fa fa-futbol-o', 'fa fa-tty', 'fa fa-binoculars', 'fa fa-plug', 'fa fa-slideshare', 'fa fa-twitch', 'fa fa-yelp', 'fa fa-newspaper-o', 'fa fa-wifi', 'fa fa-calculator', 'fa fa-paypal', 'fa fa-google-wallet', 'fa fa-cc-visa', 'fa fa-cc-mastercard', 'fa fa-cc-discover', 'fa fa-cc-amex', 'fa fa-cc-paypal', 'fa fa-cc-stripe', 'fa fa-bell-slash', 'fa fa-bell-slash-o', 'fa fa-trash', 'fa fa-copyright', 'fa fa-at', 'fa fa-eyedropper', 'fa fa-paint-brush', 'fa fa-birthday-cake', 'fa fa-area-chart', 'fa fa-pie-chart', 'fa fa-line-chart', 'fa fa-lastfm', 'fa fa-lastfm-square', 'fa fa-toggle-off', 'fa fa-toggle-on', 'fa fa-bicycle', 'fa fa-bus', 'fa fa-ioxhost', 'fa fa-angellist', 'fa fa-cc', 'fa fa-shekel', 'fa fa-sheqel', 'fa fa-ils', 'fa fa-meanpath', 'fa fa-buysellads', 'fa fa-connectdevelop', 'fa fa-dashcube', 'fa fa-forumbee', 'fa fa-leanpub', 'fa fa-sellsy', 'fa fa-shirtsinbulk', 'fa fa-simplybuilt', 'fa fa-skyatlas', 'fa fa-cart-plus', 'fa fa-cart-arrow-down', 'fa fa-diamond', 'fa fa-ship', 'fa fa-user-secret', 'fa fa-motorcycle', 'fa fa-street-view', 'fa fa-heartbeat', 'fa fa-venus', 'fa fa-mars', 'fa fa-mercury', 'fa fa-transgender', 'fa fa-transgender-alt', 'fa fa-venus-double', 'fa fa-mars-double', 'fa fa-venus-mars', 'fa fa-mars-stroke', 'fa fa-mars-stroke-v', 'fa fa-mars-stroke-h', 'fa fa-neuter', 'fa fa-facebook-official', 'fa fa-pinterest-p', 'fa fa-whatsapp', 'fa fa-server', 'fa fa-user-plus', 'fa fa-user-times', 'fa fa-hotel', 'fa fa-bed', 'fa fa-viacoin', 'fa fa-train', 'fa fa-subway', 'fa fa-medium', ) );
	}

	/**
	 * Retrieve a shortcodes.
	 *
	 * @since  1.0.0
	 * @param  bool|string $shortcode Shortcode tag. False - returned all shortcodes.
	 * @return array                  Shortcode settings.
	 */
	public static function shortcodes( $shortcode = false ) {
		/**
		 * Filter a shortcode settings.
		 *
		 * @since 1.0.0
		 * @param array $shortcodes All shortcode settings.
		 */
		$shortcodes = apply_filters( 'cherry_shortcodes/data/shortcodes', array(

				// [row][/row]
				'row' => array(
					'name'  => __( 'Row', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'type' => array(
							'type'   => 'select',
							'values' => array(
								'fixed-width' => __( 'Fixed Width', 'cherry-shortcodes' ),
								'full-width'  => __( 'Full Width', 'cherry-shortcodes' ),
							),
							'default' => 'full-width',
							'name'    => __( 'Type', 'cherry-shortcodes' ),
							'desc'    => __( 'Type width', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						),
						'anchor' => array(
							'default' => '',
							'name'    => __( 'Anchor', 'cherry-shortcodes' ),
							'desc'    => __( 'This option defines menu item marker.', 'cherry-shortcodes' ),
						)
					),
					'content' => __( "[%prefix_col size_md=\"4\"]Column content[/%prefix_col]\n[%prefix_col size_md=\"4\"]Column content[/%prefix_col]\n[%prefix_col size_md=\"4\"]Column content[/%prefix_col]", 'cherry-shortcodes' ),
					'desc'    => __( 'Row for flexible columns', 'cherry-shortcodes' ),
					'icon'    => 'columns',
				),

				// [row_inner][/row_inner]
				'row_inner' => array(
					'name'  => __( 'Row Inner', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'type' => array(
							'type'   => 'select',
							'values' => array(
								'fixed-width' => __( 'Fixed Width', 'cherry-shortcodes' ),
								'full-width'  => __( 'Full Width', 'cherry-shortcodes' ),
							),
							'default' => 'full-width',
							'name'    => __( 'Type', 'cherry-shortcodes' ),
							'desc'    => __( 'Type width', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						),
						'anchor' => array(
							'default' => '',
							'name'    => __( 'Anchor', 'cherry-shortcodes' ),
							'desc'    => __( 'This option defines menu item marker.', 'cherry-shortcodes' ),
						)
					),
					'content' => __( "[%prefix_col_inner size_md=\"4\"]Column content[/%prefix_col_inner]\n[%prefix_col_inner size_md=\"4\"]Column content[/%prefix_col_inner]\n[%prefix_col_inner size_md=\"4\"]Column content[/%prefix_col_inner]", 'cherry-shortcodes' ),
					'desc'    => __( 'Row for flexible columns', 'cherry-shortcodes' ),
					'icon'    => 'columns',
				),

				// [col][/col]
				'col' => array(
					'name'  => __( 'Column', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'size' => array(
							'type'    => 'responsive',
							'default' => array(
								'size_xs' => 'none',
								'size_sm' => 'none',
								'size_md' => 'none',
								'size_lg' => 'none',
							),
							'name'    => __( 'Size', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column width.', 'cherry-shortcodes' ),
						),
						'offset' => array(
							'type'    => 'responsive',
							'default' => array(
								'offset_xs' => 'none',
								'offset_sm' => 'none',
								'offset_md' => 'none',
								'offset_lg' => 'none',
							),
							'name'    => __( 'Offset', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column offset.', 'cherry-shortcodes' ),
						),
						'pull' => array(
							'type'    => 'responsive',
							'default' => array(
								'pull_xs' => 'none',
								'pull_sm' => 'none',
								'pull_md' => 'none',
								'pull_lg' => 'none',
							),
							'name'    => __( 'Pull', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column pull.', 'cherry-shortcodes' ),
						),
						'push' => array(
							'type'    => 'responsive',
							'default' => array(
								'push_xs' => 'none',
								'push_sm' => 'none',
								'push_md' => 'none',
								'push_lg' => 'none',
							),
							'name'    => __( 'Push', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column push.', 'cherry-shortcodes' ),
						),
						'collapse' => array(
							'type'   => 'select',
							'values' => array(
								'no'  => __( 'No', 'cherry-shortcodes' ),
								'yes' => __( 'Yes', 'cherry-shortcodes' )
							),
							'default' => 'no',
							'name'    => __( 'Collapse column paddings', 'cherry-shortcodes' ),
							'desc'    => __( 'Collapse column paddings', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Column content', 'cherry-shortcodes' ),
					'desc'    => __( 'Flexible and responsive columns', 'cherry-shortcodes' ),
					// 'note'    => __( 'Did you know that you need to wrap columns with [row] shortcode?', 'cherry-shortcodes' ),
					'icon'    => 'columns',
				),

				// [col_inner][/col_inner]
				'col_inner' => array(
					'name'  => __( 'Column Inner', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'size' => array(
							'type'    => 'responsive',
							'default' => array(
								'size_xs' => 'none',
								'size_sm' => 'none',
								'size_md' => 'none',
								'size_lg' => 'none',
							),
							'name'    => __( 'Size', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column width.', 'cherry-shortcodes' ),
						),
						'offset' => array(
							'type'    => 'responsive',
							'default' => array(
								'offset_xs' => 'none',
								'offset_sm' => 'none',
								'offset_md' => 'none',
								'offset_lg' => 'none',
							),
							'name'    => __( 'Offset', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column offset.', 'cherry-shortcodes' ),
						),
						'pull' => array(
							'type'    => 'responsive',
							'default' => array(
								'pull_xs' => 'none',
								'pull_sm' => 'none',
								'pull_md' => 'none',
								'pull_lg' => 'none',
							),
							'name'    => __( 'Pull', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column pull.', 'cherry-shortcodes' ),
						),
						'push' => array(
							'type'    => 'responsive',
							'default' => array(
								'push_xs' => 'none',
								'push_sm' => 'none',
								'push_md' => 'none',
								'push_lg' => 'none',
							),
							'name'    => __( 'Push', 'cherry-shortcodes' ),
							'desc'    => __( 'Select column push.', 'cherry-shortcodes' ),
						),
						'collapse' => array(
							'type'   => 'select',
							'values' => array(
								'no'  => __( 'No', 'cherry-shortcodes' ),
								'yes' => __( 'Yes', 'cherry-shortcodes' )
							),
							'default' => 'no',
							'name'    => __( 'Collapse column paddings', 'cherry-shortcodes' ),
							'desc'    => __( 'Collapse column paddings', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Column content', 'cherry-shortcodes' ),
					'desc'    => __( 'Flexible and responsive columns', 'cherry-shortcodes' ),
					// 'note'    => __( 'Did you know that you need to wrap columns with [row_inner] shortcode?', 'cherry-shortcodes' ),
					'icon'    => 'columns',
				),

				// [spacer]
				'spacer' => array(
					'name'  => __( 'Spacer', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'grid',
					'atts'  => array(
						'size'  => array(
							'type'    => 'number',
							'min'     => -100,
							'max'     => 300,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Size', 'cherry-shortcodes' ),
							'desc'    => __( 'Spacer height', 'cherry-shortcodes' ),
						),
						'size_sm'  => array(
							'type'    => 'number',
							'min'     => -100,
							'max'     => 300,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Size for tablets', 'cherry-shortcodes' ),
							'desc'    => __( 'Spacer height for tablets', 'cherry-shortcodes' ),
						),
						'size_xs'  => array(
							'type'    => 'number',
							'min'     => -100,
							'max'     => 300,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Size for mobile devices', 'cherry-shortcodes' ),
							'desc'    => __( 'Spacer height for mobile devices', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'desc' => __( 'Vertical spacer between blocks', 'cherry-shortcodes' ),
					'icon' => 'arrows-v',
				),

				// [clear]
				'clear' => array(
					'name'  => __( 'Clear', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'grid',
					'atts'  => array(
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'desc' => __( 'Clearing block', 'cherry-shortcodes' ),
					'icon' => 'eraser',
				),

				// [icon]
				'icon' => array(
					'name'  => __( 'Icon', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'typography',
					'atts'  => array(
						'icon' => array(
							'type'    => 'icon',
							'default' => '',
							'name'    => __( 'Icon', 'cherry-shortcodes' ),
							'desc'    => __( 'You can upload custom icon for this button or pick a built-in icon', 'cherry-shortcodes' ),
						),
						'size' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Icon size', 'cherry-shortcodes' ),
							'desc'    => __( 'Font size in px (only for font icons)', 'cherry-shortcodes' ),
						),
						'align' => array(
							'type'   => 'select',
							'values' => array(
								'none'   => __( 'None', 'cherry-shortcodes' ),
								'left'   => __( 'Left', 'cherry-shortcodes' ),
								'center' => __( 'Center', 'cherry-shortcodes' ),
								'right'  => __( 'Right', 'cherry-shortcodes' ),
							),
							'default' => 'no',
							'name'    => __( 'Alignment', 'cherry-shortcodes' ),
							'desc'    => __( 'Select icon alignment', 'cherry-shortcodes' ),
						),
						'color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#333333',
							'name'    => __( 'Icon Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Font icon color', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' )
						)
					),
					'desc' => __( 'Insert custom icon', 'cherry-shortcodes' ),
					'icon' => 'info-circle',
				),

				// [box][/box]
				'box' => array(
					'name'  => __( 'Box', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'preset' => array(
							'type'   => 'select',
							'values' => array(
								'primary'          => __( 'Primary', 'cherry-shortcodes' ),
								'secondary'        => __( 'Secondary', 'cherry-shortcodes' ),
								'gray'             => __( 'Gray', 'cherry-shortcodes' ),
								'primary-border'   => __( 'Primary border', 'cherry-shortcodes' ),
								'secondary-border' => __( 'Secondary border', 'cherry-shortcodes' ),
								'gray-border'      => __( 'Gray border', 'cherry-shortcodes' ),
							),
							'default' => '',
							'name'    => __( 'Box styling preset', 'cherry-shortcodes' ),
							'desc'    => __( 'Select box styling preset', 'cherry-shortcodes' ),
						),
						'bg_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#ffffff',
							'name'    => __( 'Background Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Select box background color', 'cherry-shortcodes' ),
						),
						'bg_image' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'Background Image', 'cherry-shortcodes' ),
							'desc'    => __( 'Upload box background image', 'cherry-shortcodes' ),
						),
						'bg_position' => array(
							'type'   => 'select',
							'values' => array(
								'top-left'      => __( 'Top Left', 'cherry-shortcodes' ),
								'top-center'    => __( 'Top Center', 'cherry-shortcodes' ),
								'top-right'     => __( 'Top Right', 'cherry-shortcodes' ),
								'left'          => __( 'Middle Left', 'cherry-shortcodes' ),
								'center'        => __( 'Middle Center', 'cherry-shortcodes' ),
								'right'         => __( 'Middle Right', 'cherry-shortcodes' ),
								'bottom-left'   => __( 'Bottom Left', 'cherry-shortcodes' ),
								'bottom-center' => __( 'Bottom Center', 'cherry-shortcodes' ),
								'bottom-right'  => __( 'Bottom Right', 'cherry-shortcodes' ),
							),
							'default' => 'center',
							'name'    => __( 'Background image position', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image position', 'cherry-shortcodes' ),
						),
						'bg_repeat' => array(
							'type'   => 'select',
							'values' => array(
								'no-repeat' => __( 'No Repeat', 'cherry-shortcodes' ),
								'repeat'    => __( 'Repeat All', 'cherry-shortcodes' ),
								'repeat-x'  => __( 'Repeat Horizontally', 'cherry-shortcodes' ),
								'repeat-y'  => __( 'Repeat Vertically', 'cherry-shortcodes' ),
							),
							'default' => 'no-repeat',
							'name'    => __( 'Background image repeat', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image repeat', 'cherry-shortcodes' ),
						),
						'bg_attachment' => array(
							'type'   => 'select',
							'values' => array(
								'scroll' => __( 'Scroll normally', 'cherry-shortcodes' ),
								'fixed'  => __( 'Fixed in place', 'cherry-shortcodes' ),
							),
							'default' => 'scroll',
							'name'    => __( 'Background image attachment', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image attachment', 'cherry-shortcodes' ),
						),
						'bg_size' => array(
							'type'   => 'select',
							'values' => array(
								'auto'    => __( 'Auto', 'cherry-shortcodes' ),
								'cover'   => __( 'Cover', 'cherry-shortcodes' ),
								'contain' => __( 'Contain', 'cherry-shortcodes' ),
							),
							'default' => 'auto',
							'name'    => __( 'Background image size', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image size', 'cherry-shortcodes' ),
						),
						'fill' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Fill', 'cherry-shortcodes' ),
							'desc'    => __( 'Fill a parent container?', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Your content goes here', 'cherry-shortcodes' ),
					'desc'    => __( 'Box', 'cherry-shortcodes' ),
					'icon'    => 'file-o',
				),

				// [box_inner][/box_inner]
				'box_inner' => array(
					'name'  => __( 'Box Inner', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'grid',
					'atts'  => array(
						'preset' => array(
							'type'   => 'select',
							'values' => array(
								''                 => __( 'No preset', 'cherry-shortcodes' ),
								'primary'          => __( 'Primary', 'cherry-shortcodes' ),
								'secondary'        => __( 'Secondary', 'cherry-shortcodes' ),
								'gray'             => __( 'Gray', 'cherry-shortcodes' ),
								'primary-border'   => __( 'Primary border', 'cherry-shortcodes' ),
								'secondary-border' => __( 'Secondary border', 'cherry-shortcodes' ),
								'gray-border'      => __( 'Gray border', 'cherry-shortcodes' ),
							),
							'default' => '',
							'name'    => __( 'Box styling preset', 'cherry-shortcodes' ),
							'desc'    => __( 'Select box styling preset', 'cherry-shortcodes' ),
						),
						'bg_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#ffffff',
							'name'    => __( 'Background Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Select box background color', 'cherry-shortcodes' ),
						),
						'bg_image' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'Background Image', 'cherry-shortcodes' ),
							'desc'    => __( 'Upload box background image', 'cherry-shortcodes' ),
						),
						'bg_position' => array(
							'type'   => 'select',
							'values' => array(
								'top-left'      => __( 'Top Left', 'cherry-shortcodes' ),
								'top-center'    => __( 'Top Center', 'cherry-shortcodes' ),
								'top-right'     => __( 'Top Right', 'cherry-shortcodes' ),
								'left'          => __( 'Middle Left', 'cherry-shortcodes' ),
								'center'        => __( 'Middle Center', 'cherry-shortcodes' ),
								'right'         => __( 'Middle Right', 'cherry-shortcodes' ),
								'bottom-left'   => __( 'Bottom Left', 'cherry-shortcodes' ),
								'bottom-center' => __( 'Bottom Center', 'cherry-shortcodes' ),
								'bottom-right'  => __( 'Bottom Right', 'cherry-shortcodes' ),
							),
							'default' => 'center',
							'name'    => __( 'Background image position', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image position', 'cherry-shortcodes' ),
						),
						'bg_repeat' => array(
							'type'   => 'select',
							'values' => array(
								'no-repeat' => __( 'No Repeat', 'cherry-shortcodes' ),
								'repeat'    => __( 'Repeat All', 'cherry-shortcodes' ),
								'repeat-x'  => __( 'Repeat Horizontally', 'cherry-shortcodes' ),
								'repeat-y'  => __( 'Repeat Vertically', 'cherry-shortcodes' ),
							),
							'default' => 'no-repeat',
							'name'    => __( 'Background image repeat', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image repeat', 'cherry-shortcodes' ),
						),
						'bg_attachment' => array(
							'type'   => 'select',
							'values' => array(
								'scroll' => __( 'Scroll normally', 'cherry-shortcodes' ),
								'fixed'  => __( 'Fixed in place', 'cherry-shortcodes' ),
							),
							'default' => 'scroll',
							'name'    => __( 'Background image attachment', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image attachment', 'cherry-shortcodes' ),
						),
						'bg_size' => array(
							'type'   => 'select',
							'values' => array(
								'auto'    => __( 'Auto', 'cherry-shortcodes' ),
								'cover'   => __( 'Cover', 'cherry-shortcodes' ),
								'contain' => __( 'Contain', 'cherry-shortcodes' ),
							),
							'default' => 'auto',
							'name'    => __( 'Background image size', 'cherry-shortcodes' ),
							'desc'    => __( 'Select background image size', 'cherry-shortcodes' ),
						),
						'fill' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Fill', 'cherry-shortcodes' ),
							'desc'    => __( 'Fill a parent container?', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Your content goes here', 'cherry-shortcodes' ),
					'desc'    => __( 'Box Inner', 'cherry-shortcodes' ),
					'icon'    => 'file-o',
				),

				// [banner][/banner]
				'banner' => array(
					'name'  => __( 'Banner', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'media',
					'atts'  => array(
						'image' => array(
							'type'    => 'upload',
							'default' => '',
							'data_type' => 'id',
							'name'    => __( 'Banner Image', 'cherry-shortcodes' ),
							'desc'    => __( 'Select attachment banner image', 'cherry-shortcodes' ),
						),
						'title' => array(
							'default' => '',
							'name'    => __( 'Banner Title', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter banner title', 'cherry-shortcodes' ),
						),
						'url' => array(
							'default' => '/',
							'name'    => __( 'Banner URL', 'cherry-shortcodes' ),
							'desc'    => __( 'Banner link URL', 'cherry-shortcodes' )
						),
						'color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#444444',
							'name'    => __( 'Text color', 'cherry-shortcodes' ),
							'desc'    => __( 'Banner text color', 'cherry-shortcodes' ),
						),
						'bg_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#DDDDDD',
							'name'    => __( 'Background color', 'cherry-shortcodes' ),
							'desc'    => __( 'Banner background color', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						),
						'template' => array(
							'type'   => 'select',
							'values' => array(
								'default.tmpl' => 'default.tmpl',
							),
							'default' => 'default.tmpl',
							'name'    => __( 'Template', 'cherry-shortcodes' ),
							'desc'    => __( 'Shortcode template', 'cherry-shortcodes' ),
						),
					),
					'content' => __( 'Banner content goes here', 'cherry-shortcodes' ),
					'desc'    => __( 'Banner', 'cherry-shortcodes' ),
					'icon'    => 'picture-o',
				),

				// [hr]
				'hr' => array(
					'name'  => __( 'Horizontal Rule', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'typography',
					'atts'  => array(
						'height' => array(
							'type'    => 'number',
							'min'     => 1,
							'max'     => 30,
							'step'    => 1,
							'default' => 1,
							'name'    => __( 'Line height', 'cherry-shortcodes' ),
							'desc'    => __( 'Horizontal rule height', 'cherry-shortcodes' ),
						),
						'color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#dddddd',
							'name'    => __( 'Line color', 'cherry-shortcodes' ),
							'desc'    => __( 'Horizontal rule color', 'cherry-shortcodes' ),
						),
						'indent_top' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Indent before', 'cherry-shortcodes' ),
							'desc'    => __( 'Indent before horizontal rule', 'cherry-shortcodes' ),
						),
						'indent_bottom' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Indent after', 'cherry-shortcodes' ),
							'desc'    => __( 'Indent after horizontal rule', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'desc'    => __( 'Horizontal Rule', 'cherry-shortcodes' ),
					'icon'    => 'arrows-h'
				),

				// [title_box]
				'title_box' => array(
					'name'  => __( 'Title Box', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'typography',
					'atts'  => array(
						'title' => array(
							'default' => '',
							'name'    => __( 'Title', 'cherry-shortcodes' ),
							'desc'    => __( 'Title text', 'cherry-shortcodes' ),
						),
						'subtitle' => array(
							'default' => '',
							'name'    => __( 'Subtitle', 'cherry-shortcodes' ),
							'desc'    => __( 'Subtitle text', 'cherry-shortcodes' ),
						),
						'icon' => array(
							'type'    => 'icon',
							'default' => '',
							'name'    => __( 'Icon', 'cherry-shortcodes' ),
							'desc'    => __( 'You can upload custom icon for this button or pick a built-in icon', 'cherry-shortcodes' ),
						),
						'icon_size' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Icon size', 'cherry-shortcodes' ),
							'desc'    => __( 'Font size in px (only for font icons)', 'cherry-shortcodes' ),
						),
						'title_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#444444',
							'name'    => __( 'Title Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Title text color', 'cherry-shortcodes' ),
						),
						'subtitle_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#444444',
							'name'    => __( 'Subtitle Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Subtitle text color', 'cherry-shortcodes' ),
						),
						'icon_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#333333',
							'name'    => __( 'Icon Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Font icon color', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'desc' => __( 'Title box', 'cherry-shortcodes' ),
					'icon' => 'header',
				),

				// [dropcap][/dropcap]
				'dropcap' => array(
					'name'  => __( 'Dropcap', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'typography',
					'atts'  => array(
						'font_size' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Text size', 'cherry-shortcodes' ),
							'desc'    => __( 'Text size in px', 'cherry-shortcodes' ),
						),
						'canvas_size' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 150,
							'step'    => 1,
							'default' => 20,
							'name'    => __( 'Canvas size', 'cherry-shortcodes' ),
							'desc'    => __( 'Canvas size in px', 'cherry-shortcodes' ),
						),
						'color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#FFFFFF',
							'name'    => __( 'Text Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Dropcap text color', 'cherry-shortcodes' ),
						),
						'background' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#2D89EF',
							'name'    => __( 'Background Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Dropcap background color', 'cherry-shortcodes' ),
						),
						'align' => array(
							'type'   => 'select',
							'values' => array(
								'left'   => __( 'Left', 'cherry-shortcodes' ),
								'right'  => __( 'Right', 'cherry-shortcodes' ),
								'center' => __( 'Center', 'cherry-shortcodes' ),
							),
							'default' => 'left',
							'name'    => __( 'Align', 'cherry-shortcodes' ),
							'desc'    => __( 'Dropcap alignment', 'cherry-shortcodes' ),
						),
						'radius' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 150,
							'step'    => 1,
							'default' => 5,
							'name'    => __( 'Border radius', 'cherry-shortcodes' ),
							'desc'    => __( 'Border radius size in px', 'cherry-shortcodes' ),
						),
						'border' => array(
							'type'    => 'border',
							'default' => 'none',
							'name'    => __( 'Border', 'cherry-shortcodes' ),
							'desc'    => __( 'Setup dropcap border', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' )
						)
					),
					'content' => __( 'A', 'cherry-shortcodes' ),
					'desc'    => __( 'Dropcap box', 'cherry-shortcodes' ),
					'icon'    => 'question-circle',
				),

				// [button]
				'button' => array(
					'name'  => __( 'Button', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'typography',
					'atts'  => array(
						'text' => array(
							'default' => __( 'Read more', 'cherry-shortcodes' ),
							'name'    => __( 'Text', 'cherry-shortcodes' ),
							'desc'    => __( 'Button text', 'cherry-shortcodes' ),
						),
						'url' => array(
							'default' => '#',
							'name'    => __( 'Link', 'cherry-shortcodes' ),
							'desc'    => __( 'Button link', 'cherry-shortcodes' ),
						),
						'style' => array(
							'type'   => 'select',
							'values' => apply_filters(
								'cherry_shortcodes_button_style_presets',
								array(
									'primary'       => __( 'Primary', 'cherry-shortcodes' ),
									'primary-light' => __( 'Primary-light', 'cherry-shortcodes' ),
									'default'       => __( 'Default', 'cherry-shortcodes' ),
									'gray'          => __( 'Gray', 'cherry-shortcodes' ),
									'success'       => __( 'Success', 'cherry-shortcodes' ),
									'info'          => __( 'Info', 'cherry-shortcodes' ),
									'warning'       => __( 'Warning', 'cherry-shortcodes' ),
									'danger'        => __( 'Danger', 'cherry-shortcodes' ),
									'link'          => __( 'Link', 'cherry-shortcodes' ),
								)
							),
							'default' => 'primary',
							'name'    => __( 'Style', 'cherry-shortcodes' ),
							'desc'    => __( 'Button style preset', 'cherry-shortcodes' ),
						),
						'size' => array(
							'type'   => 'select',
							'values' => apply_filters(
								'cherry_shortcodes_button_size_presets',
								array(
									'extra-small' => __( 'Extra Small', 'cherry-shortcodes' ),
									'small'       => __( 'Small', 'cherry-shortcodes' ),
									'medium'      => __( 'Medium', 'cherry-shortcodes' ),
									'large'       => __( 'Large', 'cherry-shortcodes' ),
									'extra-large' => __( 'Extra Large', 'cherry-shortcodes' )
								)
							),
							'default' => 'medium',
							'name'    => __( 'Size', 'cherry-shortcodes' ),
							'desc'    => __( 'Button size preset', 'cherry-shortcodes' )
						),
						'display' => array(
							'type'   => 'select',
							'values' => array(
								'inline' => __( 'Inline', 'cherry-shortcodes' ),
								'wide'   => __( 'Wide', 'cherry-shortcodes' )
							),
							'default' => 'inline',
							'name'    => __( 'Display', 'cherry-shortcodes' ),
							'desc'    => __( 'Button display type', 'cherry-shortcodes' )
						),
						'radius' => array(
							'type'    => 'slider',
							'min'     => 0,
							'max'     => 60,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Border radius', 'cherry-shortcodes' ),
							'desc'    => __( 'Button border radius', 'cherry-shortcodes' ),
						),
						'centered' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Centered', 'cherry-shortcodes' ),
							'desc'    => __( 'Is button centered on the page', 'cherry-shortcodes' ),
						),
						'fluid' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Fluid', 'cherry-shortcodes' ),
							'desc'    => __( 'Is button fluid', 'cherry-shortcodes' ),
						),
						'fluid_position' => array(
							'type'   => 'select',
							'values' => array(
								'left'  => __( 'Left', 'cherry-shortcodes' ),
								'right' => __( 'Right', 'cherry-shortcodes' ),
							),
							'default' => 'left',
							'name'    => __( 'Fluid Position', 'cherry-shortcodes' ),
							'desc'    => __( 'Button fluid position', 'cherry-shortcodes' ),
						),
						'icon' => array(
							'type'    => 'icon',
							'default' => '',
							'name'    => __( 'Icon', 'cherry-shortcodes' ),
							'desc'    => __( 'You can upload custom icon for this button or pick a built-in icon', 'cherry-shortcodes' ),
						),
						'icon_position' => array(
							'type'   => 'select',
							'values' => array(
								'left'   => __( 'Left', 'cherry-shortcodes' ),
								'top'    => __( 'Top', 'cherry-shortcodes' ),
								'right'  => __( 'Right', 'cherry-shortcodes' ),
								'bottom' => __( 'Bottom', 'cherry-shortcodes' ),
							),
							'default' => 'left',
							'name'    => __( 'Icon Position', 'cherry-shortcodes' ),
							'desc'    => __( 'Button icon position', 'cherry-shortcodes' ),
						),
						'desc' => array(
							'default' => '',
							'name'    => __( 'Description', 'cherry-shortcodes' ),
							'desc'    => __( 'Small description under button text.', 'cherry-shortcodes' ),
						),
						'bg_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#2D89EF',
							'name'    => __( 'Background', 'cherry-shortcodes' ),
							'desc'    => __( 'Button background color', 'cherry-shortcodes' ),
						),
						'color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#FFFFFF',
							'name'    => __( 'Text color', 'cherry-shortcodes' ),
							'desc'    => __( 'Button text color', 'cherry-shortcodes' ),
						),
						'min_width' => array(
							'type'    => 'slider',
							'min'     => 0,
							'max'     => 400,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Min width', 'cherry-shortcodes' ),
							'desc'    => __( 'Button minimal width', 'cherry-shortcodes' ),
						),
						'target' => array(
							'type'   => 'select',
							'values' => array(
								'_self'  => __( 'Same tab', 'cherry-shortcodes' ),
								'_blank' => __( 'New tab', 'cherry-shortcodes' ),
							),
							'default' => 'self',
							'name'    => __( 'Target', 'cherry-shortcodes' ),
							'desc'    => __( 'Button link target', 'cherry-shortcodes' ),
						),
						'rel' => array(
							'default' => '',
							'name'    => __( 'Rel attribute', 'cherry-shortcodes' ),
							'desc'    => __( 'Here you can add value for the rel attribute.', 'cherry-shortcodes' ),
						),
						'hover_animation' => array(
							'type'   => 'select',
							'values' => apply_filters(
								'cherry_shortcodes_button_hover_presets',
								array(
									'fade' => __( 'Fade', 'cherry-shortcodes' ),
								)
							),
							'default' => 'fade',
							'name'    => __( 'Hover animation', 'cherry-shortcodes' ),
							'desc'    => __( 'Button hover aniamtion type', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'desc' => __( 'Styled button', 'cherry-shortcodes' ),
					'icon' => 'heart',
				),

				// [list][/list]
				'list' => array(
					'name'  => __( 'List', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'box',
					'atts'  => array(
						'icon' => array(
							'type'    => 'icon',
							'default' => '',
							'name'    => __( 'Icon', 'cherry-shortcodes' ),
							'desc'    => __( 'You can upload custom icon for this button or pick a built-in icon', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' )
						)
					),
					'content'  => sprintf( '<ul><li>%s</li></ul>', __( 'List Item', 'cherry-shortcodes' ) ),
					'desc'     => __( 'List', 'cherry-shortcodes' ),
					'icon'     => 'list-ul',
					'function' => array( 'Cherry_Shortcodes_Handler', 'list_' )
				),

				// [swiper_carousel]
				'swiper_carousel' => array(
					'name'  => __( 'Swiper carousel', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'media',
					'desc'  => __( 'Customizable post carousel', 'cherry-shortcodes' ),
					'icon'  => 'photo',
					'atts'  => array(
						'posts_per_page' => array(
							'type'    => 'number',
							'min'     => -1,
							'max'     => 10000,
							'step'    => 1,
							'default' => get_option( 'posts_per_page' ),
							'name'    => __( 'Posts per page', 'cherry-shortcodes' ),
							'desc'    => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'cherry-shortcodes' ),
						),
						'post_type' => array(
							'type'     => 'select',
							'multiple' => true,
							'values'   => Cherry_Shortcodes_Tools::get_types(),
							'default'  => 'post',
							'name'     => __( 'Post types', 'cherry-shortcodes' ),
							'desc'     => __( 'Select post types. Hold Ctrl key to select multiple post types', 'cherry-shortcodes' ),
						),
						'taxonomy' => array(
							'type'    => 'select',
							'values'  => Cherry_Shortcodes_Tools::get_taxonomies(),
							'default' => 'category',
							'name'    => __( 'Taxonomy', 'cherry-shortcodes' ),
							'desc'    => __( 'Select taxonomy to show posts from', 'cherry-shortcodes' ),
						),
						'tax_term' => array(
							'type'     => 'select',
							'multiple' => true,
							'values'   => array(), // stay empty
							'default'  => '',
							'name'     => __( 'Terms', 'cherry-shortcodes' ),
							'desc'     => __( 'Select terms to show posts from', 'cherry-shortcodes' ),
						),
						'tax_operator' => array(
							'type'    => 'select',
							'values'  => array(
								'IN'     => 'IN',
								'NOT IN' => 'NOT IN',
								'AND'    => 'AND',
							),
							'default' => 'IN',
							'name'    => __( 'Taxonomy term operator', 'cherry-shortcodes' ),
							'desc'    => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that  do not have any of selected terms<br/>AND - posts that have all selected terms', 'cherry-shortcodes' ),
						),
						'author' => array(
							'default' => '',
							'name'    => __( 'Authors', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'cherry-shortcodes' ),
						),
						'offset' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10000,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Offset', 'cherry-shortcodes' ),
							'desc'    => __( 'Specify offset to start posts loop not from first post', 'cherry-shortcodes' ),
						),
						'order' => array(
							'type'   => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'cherry-shortcodes' ),
								'asc'  => __( 'Ascending', 'cherry-shortcodes' ),
							),
							'default' => 'DESC',
							'name'    => __( 'Order', 'cherry-shortcodes' ),
							'desc'    => __( 'Posts order', 'cherry-shortcodes' ),
						),
						'orderby' => array(
							'type'   => 'select',
							'values' => array(
								'none'          => __( 'None', 'cherry-shortcodes' ),
								'id'            => __( 'Post ID', 'cherry-shortcodes' ),
								'author'        => __( 'Post author', 'cherry-shortcodes' ),
								'title'         => __( 'Post title', 'cherry-shortcodes' ),
								'name'          => __( 'Post slug', 'cherry-shortcodes' ),
								'date'          => __( 'Date', 'cherry-shortcodes' ),
								'modified'      => __( 'Last modified date', 'cherry-shortcodes' ),
								'parent'        => __( 'Post parent', 'cherry-shortcodes' ),
								'rand'          => __( 'Random', 'cherry-shortcodes' ),
								'comment_count' => __( 'Comments number', 'cherry-shortcodes' ),
								'menu_order'    => __( 'Menu order', 'cherry-shortcodes' ),
							),
							'default' => 'date',
							'name'    => __( 'Order by', 'cherry-shortcodes' ),
							'desc'    => __( 'Order posts by', 'cherry-shortcodes' ),
						),
						'post_parent' => array(
							'default' => '',
							'name'    => __( 'Post parent', 'cherry-shortcodes' ),
							'desc'    => __( 'Show children of entered post (enter post ID)', 'cherry-shortcodes' ),
						),
						'post_status' => array(
							'type'   => 'select',
							'values' => array(
								'publish'    => __( 'Published', 'cherry-shortcodes' ),
								'pending'    => __( 'Pending', 'cherry-shortcodes' ),
								'draft'      => __( 'Draft', 'cherry-shortcodes' ),
								'auto-draft' => __( 'Auto-draft', 'cherry-shortcodes' ),
								'future'     => __( 'Future post', 'cherry-shortcodes' ),
								'private'    => __( 'Private post', 'cherry-shortcodes' ),
								'inherit'    => __( 'Inherit', 'cherry-shortcodes' ),
								'trash'      => __( 'Trashed', 'cherry-shortcodes' ),
								'any'        => __( 'Any', 'cherry-shortcodes' ),
							),
							'default' => 'publish',
							'name'    => __( 'Post status', 'cherry-shortcodes' ),
							'desc'    => __( 'Show only posts with selected status', 'cherry-shortcodes' ),
						),
						'ignore_sticky_posts' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Ignore sticky', 'cherry-shortcodes' ),
							'desc'    => __( 'Select Yes to ignore posts that are sticked', 'cherry-shortcodes' ),
						),
						'linked_title' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Linked title', 'cherry-shortcodes' ),
							'desc'    => __( 'Linked title description', 'cherry-shortcodes' ),
						),
						'linked_image' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Linked featured image', 'cherry-shortcodes' ),
							'desc'    => __( 'Linked featured image description', 'cherry-shortcodes' ),
						),
						'content_type' => array(
							'type'   => 'select',
							'values' => array(
								'part' => __( 'Part of content', 'cherry-shortcodes' ),
								'full' => __( 'Full content', 'cherry-shortcodes' ),
							),
							'default' => 'part',
							'name'    => __( 'Post content', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose to display a part or full content ', 'cherry-shortcodes' ),
						),
						'content_length' => array(
							'type'    => 'number',
							'min'     => 1,
							'max'     => 10000,
							'step'    => 1,
							'default' => 55,
							'name'    => __( 'Content Length', 'cherry-shortcodes' ),
							'desc'    => __( 'Insert the number of words you want to show in the post content.', 'cherry-shortcodes' ),
						),
						'button_text' => array(
							'default' => __( 'read more', 'cherry-shortcodes' ),
							'name'    => __( 'Button text', 'cherry-shortcodes' ),
							'desc'    => __( 'Button text description', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						),
						'template' => array(
							'type'   => 'select',
							'values' => array(
								'default.tmpl' => 'default.tmpl',
							),
							'default' => 'default.tmpl',
							'name'    => __( 'Template', 'cherry-shortcodes' ),
							'desc'    => __( 'Shortcode template', 'cherry-shortcodes' ),
						),
						'crop_image' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Using cropped image', 'cherry-shortcodes' ),
							'desc'    => __( 'Slider Loop Mode', 'cherry-shortcodes' ),
						),
						'crop_width' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 10000,
							'step'    => 1,
							'default' => 540,
							'name'    => __( 'Cropping image width', 'cherry-shortcodes' ),
							'desc'    => __( 'Width value(px)' ),
						),
						'crop_height' => array(
							'type'    => 'number',
							'min'     => 10,
							'max'     => 10000,
							'step'    => 1,
							'default' => 320,
							'name'    => __( 'Cropping image height', 'cherry-shortcodes' ),
							'desc'    => __( 'Height value(px)' ),
						),
						'slides_per_view' => array(
							'type'    => 'slider',
							'min'     => 1,
							'max'     => 25,
							'step'    => 1,
							'default' => 3,
							'name'    => __( 'Number of slides per view', 'cherry-shortcodes' ),
							'desc'    => __( 'Specify number of slides per view', 'cherry-shortcodes' ),
						),
						'slides_per_group' => array(
							'type'    => 'slider',
							'min'     => 1,
							'max'     => 25,
							'step'    => 1,
							'default' => 1,
							'name'    => __( 'Number slides per group', 'cherry-shortcodes' ),
							'desc'    => __( 'Set numbers of slides to define and enable group sliding. Useful to use with slidesPerView > 1', 'cherry-shortcodes' ),
						),
						'slides_per_column' => array(
							'type'    => 'slider',
							'min'     => 1,
							'max'     => 5,
							'step'    => 1,
							'default' => 1,
							'name'    => __( 'Multi Row Slides Layout', 'cherry-shortcodes' ),
							'desc'    => __( 'Multi Row Slides Layout', 'cherry-shortcodes' ),
						),
						'space_between_slides' => array(
							'type'    => 'slider',
							'min'     => 0,
							'max'     => 500,
							'step'    => 1,
							'default' => 10,
							'name'    => __( 'Space Between Slides', 'cherry-shortcodes' ),
							'desc'    => __( 'Width of the space between slides(px)', 'cherry-shortcodes' ),
						),
						'swiper_duration_speed' => array(
							'type'    => 'slider',
							'min'     => 0,
							'max'     => 10000,
							'step'    => 100,
							'default' => 300,
							'name'    => __( 'Duration of transition', 'cherry-shortcodes' ),
							'desc'    => __( 'Duration of transition between slides (ms)', 'cherry-shortcodes' ),
						),
						'swiper_loop' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Slider Infinite Loop', 'cherry-shortcodes' ),
							'desc'    => __( 'Slider Loop Mode', 'cherry-shortcodes' ),
						),
						'swiper_free_mode' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Free Mode sliding', 'cherry-shortcodes' ),
							'desc'    => __( 'No fixed positions for slides', 'cherry-shortcodes' ),
						),
						'swiper_grab_cursor' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Grab Cursor', 'cherry-shortcodes' ),
							'desc'    => __( 'Using Grab Cursor for slider', 'cherry-shortcodes' ),
						),
						'swiper_mouse_wheel' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Mousewheel Control', 'cherry-shortcodes' ),
							'desc'    => __( 'Mousewheel control mode', 'cherry-shortcodes' ),
						),
						'swiper_centered_slide' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Centered Slides', 'cherry-shortcodes' ),
							'desc'    => __( 'Centered slides mode', 'cherry-shortcodes' ),
						),
						'swiper_effect' => array(
							'type'   => 'select',
							'values' => array(
								'slide'     => __( 'Slide', 'cherry-shortcodes' ),
								//'fade'      => __( 'Fade', 'cherry-shortcodes' ),
								'cube'      => __( 'Cube', 'cherry-shortcodes' ),
								'coverflow' => __( 'Coverflow', 'cherry-shortcodes' ),
							),
							'default' => 'slide',
							'name'    => __( 'Effect Layout', 'cherry-shortcodes' ),
							'desc'    => __( 'Could be "slide", "fade", "cube" or "coverflow" effect', 'cherry-shortcodes' ),
						),
						'swiper_pagination' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Slider pagination', 'cherry-shortcodes' ),
							'desc'    => __( 'Displaying slider pagination', 'cherry-shortcodes' ),
						),
						'swiper_navigation' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Slider navigation', 'cherry-shortcodes' ),
							'desc'    => __( 'Displaying slider navigation', 'cherry-shortcodes' ),
						),
						'swiper_navigation_position' => array(
							'type' => 'select',
							'values' => array(
								'inner' => __( 'Inner', 'cherry-shortcodes' ),
								'outer' => __( 'Outer', 'cherry-shortcodes' ),
							),
							'default' => 'inner',
							'name'    => __( 'Slider navigation position', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose slider navigation position', 'cherry-shortcodes' ),
						),
						'swiper_autoplay' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Autoplay', 'cherry-shortcodes' ),
							'desc'    => __( 'Autoplay', 'cherry-shortcodes' ),
						),
						'swiper_autoplay_delay' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 50000,
							'step'    => 10,
							'default' => 5000,
							'name'    => __( 'Autoplay delay', 'cherry-shortcodes' ),
							'desc'    => __( 'Delay between transitions (in ms)' ),
						),
						'swiper_stop_autoplay_on_interaction' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Stop Autoplay on Interaction', 'cherry-shortcodes' ),
							'desc'    => __( 'Set to false and autoplay will not be disabled after user interactions', 'cherry-shortcodes' ),
						),
					)
				),

				// [posts]
				'posts' => array(
					'name'  => __( 'Posts', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'content',
					'atts'  => array(
						'id' => array(
							'default' => '',
							'name'    => __( 'Post ID\'s', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter comma separated ID\'s of the posts that you want to show', 'cherry-shortcodes' ),
						),
						'posts_per_page' => array(
							'type'    => 'number',
							'min'     => -1,
							'max'     => 10000,
							'step'    => 1,
							'default' => get_option( 'posts_per_page' ),
							'name'    => __( 'Posts per page', 'cherry-shortcodes' ),
							'desc'    => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'cherry-shortcodes' ),
						),
						'post_type' => array(
							'type'     => 'select',
							'multiple' => true,
							'values'   => Cherry_Shortcodes_Tools::get_types(),
							'default'  => 'post',
							'name'     => __( 'Post types', 'cherry-shortcodes' ),
							'desc'     => __( 'Select post types. Hold Ctrl key to select multiple post types', 'cherry-shortcodes' ),
						),
						'taxonomy' => array(
							'type'    => 'select',
							'values'  => Cherry_Shortcodes_Tools::get_taxonomies(),
							'default' => 'category',
							'name'    => __( 'Taxonomy', 'cherry-shortcodes' ),
							'desc'    => __( 'Select taxonomy to show posts from', 'cherry-shortcodes' ),
						),
						'tax_term' => array(
							'type'     => 'select',
							'multiple' => true,
							'values'   => array(), // stay empty
							'default'  => '',
							'name'     => __( 'Terms', 'cherry-shortcodes' ),
							'desc'     => __( 'Select terms to show posts from', 'cherry-shortcodes' ),
						),
						'tax_operator' => array(
							'type'    => 'select',
							'values'  => array(
								'IN'     => 'IN',
								'NOT IN' => 'NOT IN',
								'AND'    => 'AND',
							),
							'default' => 'IN',
							'name'    => __( 'Taxonomy term operator', 'cherry-shortcodes' ),
							'desc'    => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that  do not have any of selected terms<br/>AND - posts that have all selected terms', 'cherry-shortcodes' ),
						),
						'author' => array(
							'default' => '',
							'name'    => __( 'Authors', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'cherry-shortcodes' ),
						),
						'offset' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10000,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Offset', 'cherry-shortcodes' ),
							'desc'    => __( 'Specify offset to start posts loop not from first post', 'cherry-shortcodes' ),
						),
						'order' => array(
							'type'   => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'cherry-shortcodes' ),
								'asc'  => __( 'Ascending', 'cherry-shortcodes' ),
							),
							'default' => 'DESC',
							'name'    => __( 'Order', 'cherry-shortcodes' ),
							'desc'    => __( 'Posts order', 'cherry-shortcodes' ),
						),
						'orderby' => array(
							'type'   => 'select',
							'values' => array(
								'none'          => __( 'None', 'cherry-shortcodes' ),
								'id'            => __( 'Post ID', 'cherry-shortcodes' ),
								'author'        => __( 'Post author', 'cherry-shortcodes' ),
								'title'         => __( 'Post title', 'cherry-shortcodes' ),
								'name'          => __( 'Post slug', 'cherry-shortcodes' ),
								'date'          => __( 'Date', 'cherry-shortcodes' ),
								'modified'      => __( 'Last modified date', 'cherry-shortcodes' ),
								'parent'        => __( 'Post parent', 'cherry-shortcodes' ),
								'rand'          => __( 'Random', 'cherry-shortcodes' ),
								'comment_count' => __( 'Comments number', 'cherry-shortcodes' ),
								'menu_order'    => __( 'Menu order', 'cherry-shortcodes' ),
							),
							'default' => 'date',
							'name'    => __( 'Order by', 'cherry-shortcodes' ),
							'desc'    => __( 'Order posts by', 'cherry-shortcodes' ),
						),
						'post_parent' => array(
							'default' => '',
							'name'    => __( 'Post parent', 'cherry-shortcodes' ),
							'desc'    => __( 'Show children of entered post (enter post ID)', 'cherry-shortcodes' ),
						),
						'post_status' => array(
							'type'   => 'select',
							'values' => array(
								'publish'    => __( 'Published', 'cherry-shortcodes' ),
								'pending'    => __( 'Pending', 'cherry-shortcodes' ),
								'draft'      => __( 'Draft', 'cherry-shortcodes' ),
								'auto-draft' => __( 'Auto-draft', 'cherry-shortcodes' ),
								'future'     => __( 'Future post', 'cherry-shortcodes' ),
								'private'    => __( 'Private post', 'cherry-shortcodes' ),
								'inherit'    => __( 'Inherit', 'cherry-shortcodes' ),
								'trash'      => __( 'Trashed', 'cherry-shortcodes' ),
								'any'        => __( 'Any', 'cherry-shortcodes' ),
							),
							'default' => 'publish',
							'name'    => __( 'Post status', 'cherry-shortcodes' ),
							'desc'    => __( 'Show only posts with selected status', 'cherry-shortcodes' ),
						),
						'ignore_sticky_posts' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Ignore sticky', 'cherry-shortcodes' ),
							'desc'    => __( 'Select Yes to ignore posts that are sticked', 'cherry-shortcodes' ),
						),
						'linked_title' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Linked title', 'cherry-shortcodes' ),
							'desc'    => __( 'Linked title description', 'cherry-shortcodes' ),
						),
						'linked_image' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Linked featured image', 'cherry-shortcodes' ),
							'desc'    => __( 'Linked featured image description', 'cherry-shortcodes' ),
						),
						'lightbox_image' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Open featured image in a lightbox?', 'cherry-shortcodes' ),
							'desc'    => __( 'Open featured image in a lightbox?', 'cherry-shortcodes' ),
						),
						'image_size' => array(
							'type'    => 'select',
							'values'  => Cherry_Shortcodes_Tools::image_sizes(),
							'default' => 'thumbnail',
							'name'    => __( 'Featured image size', 'cherry-shortcodes' ),
							'desc'    => __( 'Select size for a Featured image', 'cherry-shortcodes' ),
						),
						'content_type' => array(
							'type' => 'select',
							'values' => array(
								'part'    => __( 'Part of content', 'cherry-shortcodes' ),
								'full'    => __( 'Full content', 'cherry-shortcodes' ),
							),
							'default' => 'part',
							'name'    => __( 'Post content', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose to display a part or full content ', 'cherry-shortcodes' ),
						),
						'content_length' => array(
							'type'    => 'number',
							'min'     => 1,
							'max'     => 10000,
							'step'    => 1,
							'default' => 55,
							'name'    => __( 'Content Length', 'cherry-shortcodes' ),
							'desc'    => __( 'Insert the number of words you want to show in the post content.', 'cherry-shortcodes' ),
						),
						'button_text' => array(
							'default' => __( 'read more', 'cherry-shortcodes' ),
							'name'    => __( 'Button text', 'cherry-shortcodes' ),
							'desc'    => __( 'Button text description', 'cherry-shortcodes' ),
						),
						'col' => array(
							'type'    => 'responsive',
							'default' => array(
								'col_xs' => 'none',
								'col_sm' => 'none',
								'col_md' => 'none',
								'col_lg' => 'none',
							),
							'name'    => __( 'Column class', 'cherry-shortcodes' ),
							'desc'    => __( 'Column class for each item.', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						),
						'template' => array(
							'type'   => 'select',
							'values' => array(
								'default.tmpl' => 'default.tmpl',
							),
							'default' => 'default.tmpl',
							'name'    => __( 'Template', 'cherry-shortcodes' ),
							'desc'    => __( 'Shortcode template', 'cherry-shortcodes' ),
						),
					),
					'desc' => __( 'Custom posts query with customizable template', 'cherry-shortcodes' ),
					'icon' => 'th-list',
				),

				// [tabs][/tabs]
				'tabs' => array(
					'name'  => __( 'Tabs', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'components',
					'atts'  => array(
						'style' => array(
							'type'   => 'select',
							'values' =>  apply_filters('cherry_shortcodes_tabs_styles', array(
								'default' => __( 'Default', 'cherry-shortcodes' ),
								'simple'  => __( 'Simple', 'cherry-shortcodes' ),
							)),
							'default' => 'default',
							'name'    => __( 'Style', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose style for these tabs', 'cherry-shortcodes' ),
						),
						'active' => array(
							'type'    => 'number',
							'min'     => 1,
							'max'     => 100,
							'step'    => 1,
							'default' => 1,
							'name'    => __( 'Active tab', 'cherry-shortcodes' ),
							'desc'    => __( 'Select which tab is open by default', 'cherry-shortcodes' ),
						),
						'vertical' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Vertical', 'cherry-shortcodes' ),
							'desc'    => __( 'Show tabs vertically', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'cherry-shortcodes' ),
					'desc'    => __( 'Tabs container', 'cherry-shortcodes' ),
					// 'example' => 'tabs',
					'icon'    => 'list-alt',
				),

				// [tab][/tab]
				'tab' => array(
					'name'  => __( 'Tab', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'components',
					'atts'  => array(
						'title' => array(
							'default' => __( 'Tab name', 'cherry-shortcodes' ),
							'name'    => __( 'Title', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter tab name', 'cherry-shortcodes' ),
						),
						'disabled' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Disabled', 'cherry-shortcodes' ),
							'desc'    => __( 'Is this tab disabled', 'cherry-shortcodes' ),
						),
						'anchor' => array(
							'default' => '',
							'name'    => __( 'Anchor', 'cherry-shortcodes' ),
							'desc'    => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'cherry-shortcodes' ),
						),
						'url' => array(
							'default' => '',
							'name'    => __( 'URL', 'cherry-shortcodes' ),
							'desc'    => __( 'You can link this tab to any webpage. Enter here d URL to switch this tab into link', 'cherry-shortcodes' ),
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'  => __( 'Open link in the same window/tab', 'cherry-shortcodes' ),
								'blank' => __( 'Open link in a new window/tab', 'cherry-shortcodes' ),
							),
							'default' => 'blank',
							'name'    => __( 'Link target', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose how to open the custom tab link', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Tab content', 'cherry-shortcodes' ),
					'desc'    => __( 'Single tab', 'cherry-shortcodes' ),
					// 'note'    => __( 'Did you know that you need to wrap single tabs with [tabs] shortcode?', 'cherry-shortcodes' ),
					// 'example' => 'tabs',
					'icon'    => 'list-alt',
				),

				// [spoiler][/spoiler]
				'spoiler' => array(
					'name'  => __( 'Spoiler', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'components',
					'atts'  => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'cherry-shortcodes' ),
							'name'    => __( 'Title', 'cherry-shortcodes' ),
							'desc'    => __( 'Text in spoiler title', 'cherry-shortcodes' ),
						),
						'open' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Open', 'cherry-shortcodes' ),
							'desc'    => __( 'Is spoiler content visible by default', 'cherry-shortcodes' ),
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'cherry-shortcodes' ),
								'simple'  => __( 'Simple', 'cherry-shortcodes' ),
							),
							'default' => 'default',
							'name'    => __( 'Style', 'cherry-shortcodes' ),
							'desc'    => __( 'Choose style for this spoiler', 'cherry-shortcodes' ),
						),
						'anchor' => array(
							'default' => '',
							'name'    => __( 'Anchor', 'cherry-shortcodes' ),
							'desc'    => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be opened and scrolled in', 'cherry-shortcodes' ),
						),
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( 'Hidden content', 'cherry-shortcodes' ),
					'desc'    => __( 'Spoiler with hidden content', 'cherry-shortcodes' ),
					// 'note'    => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'cherry-shortcodes' ),
					// 'example' => 'spoilers',
					'icon'    => 'list-ul',
				),

				// [accordion][/accordion]
				'accordion' => array(
					'name'  => __( 'Accordion', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'components',
					'atts'  => array(
						'class' => array(
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Extra CSS class', 'cherry-shortcodes' ),
						)
					),
					'content' => __( "[%prefix_spoiler title=\"Spoiler Title\"]Content[/%prefix_spoiler]\n[%prefix_spoiler title=\"Spoiler Title\"]Content[/%prefix_spoiler]\n[%prefix_spoiler title=\"Spoiler Title\"]Content[/%prefix_spoiler]", 'cherry-shortcodes' ),
					'desc'    => __( 'Accordion with spoilers', 'cherry-shortcodes' ),
					// 'note'    => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'cherry-shortcodes' ),
					// 'example' => 'spoilers',
					'icon'    => 'list',
				),

				// [google_map][/google_map]
				'google_map' => array(
					'name'  => __( 'Google map', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'other',
					'atts'  => array(
						'geo_address' => array(
							'type'    => 'text',
							'default' => 'London',
							'name'    => __( 'Address', 'cherry-shortcodes' ),
							'desc'    => __( 'The display options for the Pan control.', 'cherry-shortcodes' ),
						),
						'lat_value' => array(
							'type'    => 'number',
							'min'     => -90,
							'max'     => 90,
							'step'    => 0.001,
							'default' => 40.7143528,
							'name'    => __( 'Latitude  geographical coordinates', 'cherry-shortcodes' ),
							'desc'    => __( 'Latitude ranges between -90 and 90 degrees, inclusive. Values above or below this range will be clamped to the range [-90, 90]. This means that if the value specified is less than -90, it will be set to -90. And if the value is greater than 90, it will be set to 90.', 'cherry-shortcodes' ),
						),
						'lng_value' => array(
							'type'    => 'number',
							'min'     => -180,
							'max'     => 180,
							'step'    => 0.001,
							'default' => -74.0059731,
							'name'    => __( 'Longitude geographical coordinates', 'cherry-shortcodes' ),
							'desc'    => __( 'Longitude ranges between -180 and 180 degrees, inclusive. Values above or below this range will be wrapped so that they fall within the range. For example, a value of -190 will be converted to 170. A value of 190 will be converted to -170. This reflects the fact that longitudes wrap around the globe.', 'cherry-shortcodes' ),
						),
						'zoom_value' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10,
							'step'    => 0.1,
							'default' => 4,
							'name'    => __( 'Map zoom level', 'cherry-shortcodes' ),
							'desc'    => __( 'The initial Map zoom level. Required.', 'cherry-shortcodes' ),
						),
						'scroll_wheel' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Scroll wheel', 'cherry-shortcodes' ),
							'desc'    => __( 'If false, disables scrollwheel zooming on the map. The scrollwheel is enabled by default.', 'cherry-shortcodes' ),
						),
						'map_style' => array(
							'type'    => 'select',
							'values'  => Cherry_Shortcodes_Tools::get_google_map_styles(),
							'default' => '',
							'name'    => __( 'Map Style', 'cherry-shortcodes' ),
							'desc'    => __( 'Styles to apply to each of the default map types. Note that for Satellite/Hybrid and Terrain modes, these styles will only apply to labels and geometry.', 'cherry-shortcodes' ),
						),
						'map_height' => array(
							'type'    => 'number',
							'min'     => 50,
							'max'     => 1000,
							'step'    => 10,
							'default' => 400,
							'name'    => __( 'Map height', 'cherry-shortcodes' ),
							'desc'    => __( 'Map height value(px)', 'cherry-shortcodes' ),
						),
						'pan_control' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Pan control', 'cherry-shortcodes' ),
							'desc'    => __( 'The display options for the Pan control.', 'cherry-shortcodes' ),
						),
						'zoom_control' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Zoom control', 'cherry-shortcodes' ),
							'desc'    => __( 'The enabled/disabled state of the Zoom control.', 'cherry-shortcodes' ),
						),
						'map_draggable' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Draggable map', 'cherry-shortcodes' ),
							'desc'    => __( 'If false, prevents the map from being dragged. Dragging is enabled by default.', 'cherry-shortcodes' ),
						),
						'map_marker' => array(
							'type'    => 'upload',
							'default' => '',
							'data_type' => 'id',
							'name'    => __( 'Marker source', 'cherry-shortcodes' ),
							'desc'    => __( 'Select marker id attachment', 'cherry-shortcodes' ),
						),
					),
					'desc' => __( 'Google Map', 'cherry-shortcodes' ),
					'icon' => 'map-marker',
				),

				// [parallax_image][/parallax_image]
				'parallax_image' => array(
					'name'  => __( 'Parallax image', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'media',
					'atts'  => array(
						'bg_image' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'Parallax image', 'cherry-shortcodes' ),
							'desc'    => __( 'Upload parallax image url source', 'cherry-shortcodes' ),
						),
						'speed' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10,
							'step'    => 0.1,
							'default' => 1.5,
							'name'    => __( 'Parallax speed', 'cherry-shortcodes' ),
							'desc'    => __( 'Parallax speed value (s)', 'cherry-shortcodes' ),
						),
						'invert' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Parallax invert', 'cherry-shortcodes' ),
							'desc'    => __( 'Parallax invert direction move', 'cherry-shortcodes' ),
						),
						'min_height' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 1000,
							'step'    => 1,
							'default' => 300,
							'name'    => __( 'Parallax container min-height', 'cherry-shortcodes' ),
							'desc'    => __( 'container min-height value (px)', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter custom class', 'cherry-shortcodes' ),
						),
					),
					'content' => __( 'Your content goes here', 'cherry-shortcodes' ),
					'desc'    => __( 'Parallax block', 'cherry-shortcodes' ),
					'icon'    => 'star-half-o',
				),

				// [parallax_html_video][/parallax_html_video]
				'parallax_html_video' => array(
					'name'  => __( 'Parallax html video', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'media',
					'atts'  => array(
						'poster' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'Poster', 'cherry-shortcodes' ),
							'desc'    => __( 'Poster image url', 'cherry-shortcodes' ),
						),
						'mp4' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'mp4 file', 'cherry-shortcodes' ),
							'desc'    => __( 'URL to mp4 video-file', 'cherry-shortcodes' ),
						),
						'webm' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'webm file', 'cherry-shortcodes' ),
							'desc'    => __( 'URL to webm video-file', 'cherry-shortcodes' ),
						),
						'ogv' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'ogv file', 'cherry-shortcodes' ),
							'desc'    => __( 'URL to ogv video-file', 'cherry-shortcodes' ),
						),
						'speed' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10,
							'step'    => 0.1,
							'default' => 1.5,
							'name'    => __( 'Parallax speed', 'cherry-shortcodes' ),
							'desc'    => __( 'Parallax speed value (s)', 'cherry-shortcodes' ),
						),
						'invert' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Parallax invert', 'cherry-shortcodes' ),
							'desc'    => __( 'Parallax invert direction move', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter custom class', 'cherry-shortcodes' ),
						),
					),
					'content' => __( 'Your content goes here', 'cherry-shortcodes' ),
					'desc'    => __( 'Parallax block', 'cherry-shortcodes' ),
					'icon'    => 'star-half-o',
				),

				// [counter]
				'counter' => array(
					'name'  => __( 'Counter', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'components',
					'atts'  => array(
						'counter_value' => array(
							'type'    => 'text',
							'default' => '100.00',
							'name'    => __( 'Value', 'cherry-shortcodes' ),
							'desc'    => __( 'Value for counter', 'cherry-shortcodes' ),
						),
						'delay' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 100,
							'step'    => 1,
							'default' => 10,
							'name'    => __( 'Counter delay', 'cherry-shortcodes' ),
							'desc'    => __( 'Counter delay (ms)', 'cherry-shortcodes' ),
						),
						'time' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10000,
							'step'    => 100,
							'default' => 1000,
							'name'    => __( 'Speed time', 'cherry-shortcodes' ),
							'desc'    => __( 'Speed time (ms)', 'cherry-shortcodes' ),
						),
						'before_content' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Before content', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter before custom content', 'cherry-shortcodes' ),
						),
						'after_content' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'After content', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter after custom content', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter custom class', 'cherry-shortcodes' ),
						),
					),
					'desc' => __( 'Counter', 'cherry-shortcodes' ),
					'icon' => 'dot-circle-o',
				),

				// [counter]
				'countdown' => array(
					'name'  => __( 'Countdown', 'cherry-shortcodes' ),
					'type'  => 'single',
					'group' => 'components',
					'atts'  => array(
						'start_date' => array(
							'type'    => 'date',
							'default' => date('d/n/Y'),
							'name'    => __( 'Start date', 'cherry-shortcodes' ),
							'desc'    => __( 'Insert shortcode date', 'cherry-shortcodes' ),
						),
						'countdown_date' => array(
							'type'    => 'date',
							'default' => '25/10/2020',
							'name'    => __( 'Countdown date', 'cherry-shortcodes' ),
							'desc'    => __( 'Select countdown date', 'cherry-shortcodes' ),
						),
						'countdown_hour' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 23,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Countdown hours', 'cherry-shortcodes' ),
							'desc'    => __( 'Select countdown hours', 'cherry-shortcodes' ),
						),
						'countdown_minutes' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 59,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Countdown minutes', 'cherry-shortcodes' ),
							'desc'    => __( 'Select countdown minute', 'cherry-shortcodes' ),
						),
						'countdown_seconds' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 59,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Countdown seconds', 'cherry-shortcodes' ),
							'desc'    => __( 'Select countdown seconds', 'cherry-shortcodes' ),
						),
						'circle_mode' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Circle mode', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show circle progress', 'cherry-shortcodes' ),
						),
						'show_year' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show year', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the year counter', 'cherry-shortcodes' ),
						),
						'show_month' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show month', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the month counter', 'cherry-shortcodes' ),
						),
						'show_week' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show week', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the week counter', 'cherry-shortcodes' ),
						),
						'show_day' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show day', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the day counter', 'cherry-shortcodes' ),
						),
						'show_hour' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show hour', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the hours counter', 'cherry-shortcodes' ),
						),
						'show_minute' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show minute', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the minute counter', 'cherry-shortcodes' ),
						),
						'show_second' => array(
							'type'    => 'bool',
							'default' => 'yes',
							'name'    => __( 'Show second', 'cherry-shortcodes' ),
							'desc'    => __( 'If true, then show the second counter', 'cherry-shortcodes' ),
						),
						'item_size' => array(
							'type'    => 'number',
							'min'     => 50,
							'max'     => 500,
							'step'    => 1,
							'default' => 100,
							'name'    => __( 'Countdown item size', 'cherry-shortcodes' ),
							'desc'    => __( 'Item container size(px)', 'cherry-shortcodes' ),
						),
						'stroke_width' => array(
							'type'    => 'number',
							'min'     => 1,
							'max'     => 50,
							'step'    => 1,
							'default' => 3,
							'name'    => __( 'Stroke width', 'cherry-shortcodes' ),
							'desc'    => __( 'Stroke width(px)', 'cherry-shortcodes' ),
						),
						'stroke_color' => array(
							'type'    => 'color',
							'values'  => array(),
							'default' => '#4DB6FD',
							'name'    => __( 'Stroke Color', 'cherry-shortcodes' ),
							'desc'    => __( 'Select stroke color', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Enter custom class', 'cherry-shortcodes' ),
						),
					),
					'desc' => __( 'Countdown', 'cherry-shortcodes' ),
					'icon' => 'calendar-o',
				),

				// [lazy_load_effect][/lazy_load_effect]
				'lazy_load_effect' => array(
					'name'  => __( 'Lazy Load Effect', 'cherry-shortcodes' ),
					'type'  => 'wrap',
					'group' => 'components',
					'atts'  => array(
						'start_position' => array(
							'type'   => 'select',
							'values' => array(
								'not_changed' => __( 'Not changed', 'cherry-shortcodes' ),
								'top'         => __( 'Top', 'cherry-shortcodes' ),
								'right'       => __( 'Right', 'cherry-shortcodes' ),
								'bottom'      => __( 'Bottom', 'cherry-shortcodes' ),
								'left'        => __( 'Left', 'cherry-shortcodes' ),
							),
							'default' => 'not_changed',
							'name'    => __( 'Start Position', 'cherry-shortcodes' ),
							'desc'    => __( 'Element position at the animation start.', 'cherry-shortcodes' ),
						),
						'rotation' => array(
							'type'    => 'number',
							'min'     => -360,
							'max'     => 360,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Out rotation', 'cherry-shortcodes' ),
							'desc'    => __( 'Initial element angle (min - -360&#176; max 360&#176;)', 'cherry-shortcodes' ),
						),
						'flip_x' => array(
							'type'    => 'number',
							'min'     => -360,
							'max'     => 360,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Flip X', 'cherry-shortcodes' ),
							'desc'    => __( 'Initial element angle Flip X (X-axis rotation min - -360&#176; max 360&#176;)', 'cherry-shortcodes' ),
						),
						'flip_y' => array(
							'type'    => 'number',
							'min'     => -360,
							'max'     => 360,
							'step'    => 1,
							'default' => 0,
							'name'    => __( 'Flip Y', 'cherry-shortcodes' ),
							'desc'    => __( 'Initial element angle Flip Y (Y-axis rotation min - -360&#176; max 360&#176;)', 'cherry-shortcodes' ),
						),
						'pivot' => array(
							'type'   => 'select',
							'values' => array(
								'center'       => __( 'Center', 'cherry-shortcodes' ),
								'top_left'     => __( 'Top Left', 'cherry-shortcodes' ),
								'top_right'    => __( 'Top Right', 'cherry-shortcodes' ),
								'bottom_left'  => __( 'Bottom Left', 'cherry-shortcodes' ),
								'bottom_right' => __( 'Bottom Right', 'cherry-shortcodes' ),
							),
							'default' => 'center',
							'name'    => __( 'Pivot', 'cherry-shortcodes' ),
							'desc'    => __( 'Element rotation point.', 'cherry-shortcodes' ),
						),
						'scale' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 10,
							'step'    => 0.1,
							'default' => 1,
							'name'    => __( 'Scale', 'cherry-shortcodes' ),
							'desc'    => __( 'Element scale value (min - 0; max 10;)', 'cherry-shortcodes' ),
						),
						'opacity' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 1,
							'step'    => 0.1,
							'default' => 1,
							'name'    => __( 'Opacity', 'cherry-shortcodes' ),
							'desc'    => __( 'Element opacity value (min - 0; max 1;)', 'cherry-shortcodes' ),
						),
						'easing' => array(
							'type'   => 'select',
							'values' => array(
								'none'              => __( 'Ease None', 'cherry-shortcodes' ),
								'ease-in-cubic'     => __( 'Ease In Cubic', 'cherry-shortcodes' ),
								'ease-out-cubic'    => __( 'Ease Out Cubic', 'cherry-shortcodes' ),
								'ease-in-out-cubic' => __( 'Ease In Out Cubic', 'cherry-shortcodes' ),
								'ease-in-quart'     => __( 'Ease In Quart', 'cherry-shortcodes' ),
								'ease-out-quart'    => __( 'Ease Out Quart', 'cherry-shortcodes' ),
								'ease-in-out-quart' => __( 'Ease In Out Quart', 'cherry-shortcodes' ),
								'ease-in-expo'      => __( 'Ease In Expo', 'cherry-shortcodes' ),
								'ease-out-expo'     => __( 'Ease Out Expo', 'cherry-shortcodes' ),
								'ease-in-out-expo'  => __( 'Ease In Out Expo', 'cherry-shortcodes' ),
								'ease-in-back'      => __( 'Ease In Back', 'cherry-shortcodes' ),
								'ease-out-back'     => __( 'Ease Out Back', 'cherry-shortcodes' ),
								'ease-in-out-back'  => __( 'Ease In Out Back', 'cherry-shortcodes' ),
							),
							'default' => 'none',
							'name'    => __( 'Easing', 'cherry-shortcodes' ),
							'desc'    => __( 'Animation easing.', 'cherry-shortcodes' ),
						),
						'speed' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 1000,
							'step'    => 0.1,
							'default' => 1,
							'name'    => __( 'Animation Speed', 'cherry-shortcodes' ),
							'desc'    => __( 'Animation speed in seconds.(Example: 0.2 or 1)', 'cherry-shortcodes' ),
						),
						'delay' => array(
							'type'    => 'number',
							'min'     => 0,
							'max'     => 1000,
							'step'    => 0.1,
							'default' => 0,
							'name'    => __( 'Animation Delay', 'cherry-shortcodes' ),
							'desc'    => __( 'Animation Delay in seconds', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Element custom class', 'cherry-shortcodes' ),
						),
					),
					'desc' => __( 'This shortcode adds show animations on any page element.', 'cherry-shortcodes' ),
					'icon' => 'magic',
				),
				// [video_preview][/video_preview]
				'video_preview' => array(
					'name'  => __( 'Video Preview', 'cherry-shortcodes' ),
					'desc'  => __( 'Video Preview', 'cherry-shortcodes' ),
					'icon'  => 'film',
					'type'  => 'wrap',
					'group' => 'media',
					'atts'  => array(
						'source' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'URL or File', 'cherry-shortcodes' ),
							'desc'    => __( 'To use video from YouTube or Vimeo input video URL. You can also upload video file from media library', 'cherry-shortcodes' ),
						),
						'poster' => array(
							'type'    => 'upload',
							'default' => '',
							'name'    => __( 'Poster', 'cherry-shortcodes' ),
							'desc'    => __( 'Poster image URL', 'cherry-shortcodes' ),
						),
						'control' => array(
							'type'   => 'select',
							'values' => array(
								'hide'          => __( 'Hide control buttons', 'cherry-shortcodes' ),
								'show'          => __( 'Show control buttons', 'cherry-shortcodes' ),
								'show-on-hover' => __( 'Show control button on mouse hover', 'cherry-shortcodes' ),
								'autoplay'      => __( 'Video Autoplay', 'cherry-shortcodes' ),
								'play-on-hover' => __( 'Play video on mouse hover', 'cherry-shortcodes' ),
							),
							'default' => 'show',
							'name'    => __( 'Controls', 'cherry-shortcodes' ),
						),
						'show_content_on_hover' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Show content on mouse hover?', 'cherry-shortcodes' ),
						),
						'muted' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Muted?', 'cherry-shortcodes' ),
						),
						'loop' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Loop?', 'cherry-shortcodes' ),
						),
						'preload' => array(
							'type'    => 'bool',
							'default' => 'no',
							'name'    => __( 'Preload?', 'cherry-shortcodes' ),
						),
						'custom_class' => array(
							'type'    => 'text',
							'default' => '',
							'name'    => __( 'Class', 'cherry-shortcodes' ),
							'desc'    => __( 'Element custom class. You can use "full-width" class for video', 'cherry-shortcodes' ),
						),
					),
				),
			)
		);

		// Return result.
		return ( is_string( $shortcode ) ) ? $shortcodes[ sanitize_text_field( $shortcode ) ] : $shortcodes;
	}
}
