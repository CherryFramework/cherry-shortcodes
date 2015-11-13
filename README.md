# Cherry Shortcodes
A pack of WordPress shortcodes.
Сompatibility: Cherry Framework v.4+

##Change log##

#### v1.0.7 ####

* NEW: `[countdown]` shortcode
* ADD: New shortcodes dynamic style management logic
* ADD: New additional variable for filter `cherry_shortcode_box_format`
* ADD: `scoped` attribute to the style tag
* UPD: Localized files
* FIX: `content_type` values in `[posts]` shortcode
* FIX: Correctly process icon when `none` value passed
* FIX: Backward compatibility for `[title_box]` shortcode

#### v1.0.6.1 ####

* FIX: Trouble with page anchor stickup selector

#### v1.0.6 ####

* UPD: Pass additional parameters into `cherry_shortcodes_comments_template_callbacks` filter
* UPD: `class` attribute name for all ahortcodes
* UPD: Compressed assets
* UPD: `color-picker` interface element (backend)
* FIX: Crop image tool
* FIX: `[carousel]` shortcode
* FIX: Anchor button selector
* FIX: `[video-preview]` shortcode
* FIX: Image icon processing
* ADD: Attributes `size_sm` and `size_xs` for `[spacer]` shortcode
* ADD: Pass current template name into shortcode wrapper CSS classes (for `posts`, `swiper_carousel` and `banner` shortcodes)
* ADD: `align` attribute for `[icon]` shortcode
* ADD: Filter to the `[box]` shortcode format
* ADD: Filter `cherry_shortcodes_list_classes` to modify `[list]` shortcode classes
* ADD: `[google_map]` multi marker possibility

#### v1.0.5 ####

* NEW: Attribute in `box` and `box_inner` shortcode - background-size
* UPD: Compressed css/js
* UPD: Set of default attributes in `posts` shortcode
* FIX: Correctly get image URL for image icon in `list` shortcode
* ADD: `get_image_url` static method to shortcode tools

#### v1.0.4 ####

* FIX: Updater class logic
* FIX: `video_preview` shortcode
* FIX: WP 4.3.0 compatibility - updated constructor method for WP_Widget
* FIX: image size attribute for a `banner` shortcode
* FIX: default attributes value for `col` shortcode - offset, pull, push
* UPD: Font Awesome to 4.4.0

#### v1.0.3 ####

* UPD: Optimize a shortcode registration
* UPD: Shortcode descriptions
* UPD: Element with type `upload` (added a new attribute - `data_type`)
* FIX: Dependence plugin

#### v1.0.2 ####

* FIX: https://github.com/CherryFramework/cherry-shortcodes/issues/1
* FIX: returned filters
* FIX: `crop_image` function
* UPD: raname .pot file

#### v1.0.1 ####

* ADD: `[video_preview]` shortcode
* ADD: `lightbox_image` attribute for `[posts]` shortcode
* ADD: callback for `lightbox` macros
* ADD: a filter for tab style selector
* ADD: a landing page functional
* UPD: callback-functions
* UPD: waypoint.js
* UPD: parallax.js
* FIX: type in `[counter]` shortcode