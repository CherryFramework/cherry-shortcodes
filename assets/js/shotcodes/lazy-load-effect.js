(function($){
	"use strict";
	CHERRY_API.utilites.namespace('shortcode.lazy_load_effect');

	CHERRY_API.shortcode.lazy_load_effect = {
		window_height:0,
		element_class:'lazy-load-effect-child',
		element_parent_class:'.lazy-load-effect',
		element_animation_class:'lazy-load-effect-reset',

		//Window load handler
		init: function () {
			var self = this;

			if( CHERRY_API.status.is_ready ){
				self.add_events();
			}else{
				CHERRY_API.variable.$document.ready( self.add_events );
			}
		},

		add_events: function () {
			var self = CHERRY_API.shortcode.lazy_load_effect;

			CHERRY_API.variable.$window.on( 'resize', function(){ self.resize() } ).on( 'scroll', function(){ self.scroll() } ).triggerHandler( 'resize', self.resize );
		},

		//Window resize handler
		resize: function () {
			var self = this;

			self.window_height = window.innerHeight;
			CHERRY_API.variable.$window.triggerHandler( 'scroll', self.scroll );
		},

		//Window scroll handler
		scroll: function(){
			var self = this,
				scroll_position = CHERRY_API.variable.$document.scrollTop()+self.window_height;

			$( self.element_parent_class ).each( function(index){
				var element = $( this ),
					element_center_position = element.offset().top + ( element.outerHeight() / 2 );

				if( element_center_position <= scroll_position ){
					$( "."+self.element_class, element ).addClass( self.element_animation_class ).removeClass( self.element_class );
				}
			} );
		}
	}
	CHERRY_API.shortcode.lazy_load_effect.init();
}(jQuery));