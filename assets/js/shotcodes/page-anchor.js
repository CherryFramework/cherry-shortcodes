(function($){
	"use strict";

	$.extend( $.expr[ ':' ], {
		'position_fixed': function( element, index, match ) {
			return $( element ).css( 'position' ) === 'fixed';
		}
	});

	CHERRY_API.utilites.namespace( 'shortcode.row.page_anchor' );

	CHERRY_API.shortcode.row.page_anchor = {
		$window: CHERRY_API.variable.$window,
		html_body: $('html, body'),
		wp_menu: '.menu',
		wp_menu_item: '.menu-item-type-custom',

		speed: anchor_scroll_speed,
		anchors: {},
		items: $( '[data-anchor][data-id]' ),
		window_height: 0,
		do_animation: true,
		timer: null,
		temp_anchor: '',

		//Window load handler
		init: function () {
			if( CHERRY_API.status.is_ready ){
				this.events.do_script();
			}else{
				CHERRY_API.variable.$document.ready( this.do_script.bind( this ) );
			}
		},

		do_script:function(){
			this.set_page_anchor();

			$( this.wp_menu_item, this.wp_menu ).on('click', 'a[href^="#"]', this.on_anchor_change);

			this.$window
				.on( 'resize.page_anchor', $.proxy( this.set_window_height, this ) )
				.on( 'mousedown.page_anchor', $.proxy( this.on_mousedown, this ) )
				.on( 'mouseup.page_anchor', $.proxy( this.on_mouseup, this ) )
				.on( 'hashchange.page_anchor', $.proxy( this.on_anchor_change, this ) )
				.on( 'hashchange.page_anchor', $.proxy( this.set_activ_button, this ) )
				.on( 'scroll.page_anchor', $.proxy( this.on_scroll, this ) )
				.trigger( 'resize.page_anchor' );

			if ( 'onwheel' in document ) {
				window.addEventListener( 'wheel', $.proxy( this.on_wheel, this ) );
			}else if ( 'onmousewheel' in document ) {
				window.addEventListener( 'mousewheel', $.proxy( this.on_wheel, this ) );
			}else if ( 'ontouchmove' in document ) {
				window.addEventListener("touchmove", $.proxy( this.on_wheel, this ), false);
			}

			this.on_anchor_change();
			this.set_activ_button();
		},

		on_mousedown:function(){
			this.do_animation = false;
		},

		on_mouseup:function(){
			this.do_animation = true;
		},

		on_anchor_change:function(){
			var hash = '',
				scroll_to = null,
				current_position = 0,
				coef,
				self = CHERRY_API.shortcode.row.page_anchor;

			if( this === self){
				hash = window.location.hash.slice(1);
			}else{
				hash = $( this ).attr( 'href' ).slice( 1 );
			}

			if(self.do_animation){
				self.do_animation = false;

				scroll_to = self.get_target_offset( $( '[data-anchor][data-id="' + hash + '"]' ) );

				if( scroll_to ){
					current_position = self.$window.scrollTop();
					coef = self.speed * ( Math.abs( scroll_to - current_position ) / self.window_height );
					self.animation_stop().html_body.animate( { 'scrollTop': scroll_to }, coef , 'linear', function(){
						self.do_animation = true;
					});
				}
			}
		},

		on_wheel:function(event){
			var self = this;

			self.do_animation = false;
			self.animation_stop();

			clearTimeout( self.timer )
			this.timer = setTimeout(function(){
				self.do_animation = true;
			}, 100)
		},

		set_activ_button:function(){
			$( '.current-menu-item, .current_page_item', this.wp_menu ).removeClass('current-menu-item current_page_item');
			$( this.wp_menu_item + ' a[href$="' + window.location.hash + '"]', this.wp_menu ).parent().addClass('current-menu-item current_page_item');
		},

		set_window_height:function(){
			this.window_height = window.innerHeight;
			this.set_page_anchor();
		},

		on_scroll:function(){
			var salf = this,
				anchor,
				do_animation = this.do_animation;

			for (anchor in this.anchors) {
				if ( this.anchors.hasOwnProperty( anchor ) ) {
					if( salf.in_viewport( anchor ) ) {
						if ( anchor !== this.temp_anchor ) {
							this.temp_anchor = anchor;
							//console.log(anchor);
							window.location.hash = anchor;
						}
					};
				};
			};
		},

		set_page_anchor:function(){
			var self = this;

			self.items.each( function(){
				var $this = $(this);
				self.anchors[$this.data('id')] = [ self.get_target_offset( $this ), $this.outerHeight() ];
			} );
		},

		animation_stop:function(){
			this.html_body.stop().clearQueue();
			return this;
		},

		get_target_offset:function( target ){
			var position = 0;
			if( sticky_data.args.active ){
				//var fixed_header = $('header#header');
				var fixed_header = $( sticky_data.selector );
				position = target[0] ? target.offset().top - fixed_header.outerHeight() - fixed_header.position().top  : false ;
			}else{
				position = target[0] ? target.offset().top : false ;
			}

			return Math.round( position );
		},

		in_viewport:function( target ){
			var start_position = this.anchors[target][0],
				end_position = this.anchors[target][2],
				top_point = this.$window.scrollTop(),
				bottom_point = top_point + this.window_height / 2;

			if( start_position > top_point && start_position < bottom_point || end_position > top_point && end_position < bottom_point){
				return true;
			}else{
				return false;
			}
		}
	}
	CHERRY_API.shortcode.row.page_anchor.init();
}(jQuery));