(function($){
	"use strict";
	CHERRY_API.utilites.namespace( 'shortcode.video_preview' );

	CHERRY_API.shortcode.video_preview = {
		wrap: '.video-preview',
		play_on_hover: '.play-on-hover',
		controls: '.video-preview-controls',
		controls_visible: '.controls-visible',
		button_play_pause: '.play-pause',
		button_mute: '.mute',
		video: 'video',
		full_width_class: '.full-width',
		youtube_players:{},

		//Window load handler
		init: function () {
			if( CHERRY_API.status.is_ready ){
				this.player_init();
				this.init_youtube_player();
			}else{
				CHERRY_API.variable.$document.ready( $.proxy( this.player_init, this ) );
			}
		},

		player_init: function () {
			var obj = this;

			$( this.wrap ).each(function(){
				var $this = $(this),
					data= $this.data('settings'),
					poster = $('.cherry-video-poster', $this);

				if( data.type !== 'youtube' ){
					//resize inner holder
					CHERRY_API.variable.$window.on( 'resize.video_preview', $.proxy( obj.resize, obj ) ).trigger( 'resize.video_preview' );
					$this.filter( obj.full_width_class ).on( 'load', obj.video, $.proxy( obj.resize, obj ) );

					this.getElementsByTagName("video")[0].addEventListener("pause", function( event ){
						var $wrap = $( event.target ).parents( CHERRY_API.shortcode.video_preview.wrap ),
							button = $(CHERRY_API.shortcode.video_preview.button_play_pause, $wrap);

						obj.chenge_style( button );
					 }, true)
					this.getElementsByTagName("video")[0].addEventListener("play", function( event ){
						var $wrap = $( event.target ).parents( CHERRY_API.shortcode.video_preview.wrap ),
							button = $(CHERRY_API.shortcode.video_preview.button_play_pause, $wrap);

						obj.chenge_style( button );
					 }, true);
				}

				//controls event
				if( data.control === 'show' || data.control === 'show-on-hover' ){
					$this
						.on( 'click', obj.button_play_pause, obj.play_stop )
						.on( 'click', obj.button_mute, obj.muted )
						.on( 'click', obj.video, obj.play_stop );

				}else if( data.control === 'play-on-hover' ){
					$this.on( 'mouseover', '.video-inner-holder', obj.play_stop ).on( 'mouseout', '.video-inner-holder', obj.play_stop );
				}

				//switch button style
				if( data.control === 'autoplay' ){
					if(poster[0]){ poster.remove(); }
					obj.chenge_style( $( obj.button_play_pause, $this ) );
				}
				if( data.muted !== 'no' ){
					obj.chenge_style( $( obj.button_mute, $this ) );
				}

				$this.on( 'click', '.video-holder, iframe', obj.remove_poster );
			})
		},

		init_youtube_player:function(){
			var obj = this;
			$( this.wrap ).each(function(){
				var $this = $(this),
					data= $this.data('settings');

				if(data.type === 'youtube'){
					var youtube_player = $('.youtube-player', $this),
						settings= {
							id: youtube_player.attr('id'),
							video_id: youtube_player.data('video'),
							mute:data.muted !== 'no' ? true : false ,
							loop: data.loop !=='no' ? 1 : 0 ,
							autoplay: data.control==='autoplay' ? 1 : 0,
							is_mobile:data.is_mobile,
							is_full_width:$this.hasClass( obj.full_width_class.replace( '.', '' ) )
						};

					obj.add_youtube_player(settings, obj);
				}
			});
		},

		add_youtube_player: function(settings, obj){
			var player = new YT.Player( settings.id, {
				width: '100%',
				playerVars : {
					'autoplay' : settings.autoplay,
					'showinfo' : 0,
					'controls' : 0,
					'loop' : settings.loop,
					'iv_load_policy' : 3,
					'disablekb' : 1,
					'enablejsapi' : 0,
					'html5' : 1,
					'autohide' :0,
					'rel' :0,
					'playlist':settings.video_id,
					'modestbranding ' : 1,
					'showsearch' : 0
				},
				videoId: settings.video_id,
				events: {
					'onReady': function(event){
						var corrent_video = event.target,
							$wrap = $(corrent_video.f).parents(obj.wrap);

						CHERRY_API.variable.$window.trigger( 'resize.video_preview' );


						if(settings.mute){
							event.target.mute();
						}

						if(settings.is_mobile === 'false' && settings.is_full_width){
							corrent_video.setPlaybackQuality('hd1080');
						}else{
							corrent_video.setPlaybackQuality('large');
						}

						if(settings.autoplay){
							corrent_video.playVideo();
						}else{
							//corrent_video.seekTo(0, true).stopVideo();
						}
					},
					'onStateChange':function(event){
						var $wrap = $(event.target.f).parents(obj.wrap),
							button = $(obj.button_play_pause, $wrap);

						if(event.data === 0 && settings.loop !== 1 ){
								//event.target.seekTo(0, true).stopVideo();
						}

						if(event.data === 0
							|| event.data === 1
							|| event.data === 2){
							obj.chenge_style( button );
						}

						CHERRY_API.shortcode.video_preview.remove_poster( $wrap );
					}
				}
				});

			obj.youtube_players[ settings.id ] = player;
		},

		play_stop: function () {
			var $wrap = $( this ).parents( CHERRY_API.shortcode.video_preview.wrap ),
				data = $wrap.data('settings'),
				corrent_video,
				button = $(CHERRY_API.shortcode.video_preview.button_play_pause, $wrap);

			if( data.type === 'youtube' ){
				var frame_id = $('iframe', $wrap ).attr('id');

				corrent_video = CHERRY_API.shortcode.video_preview.youtube_players[ frame_id ];

				if( corrent_video.getPlayerState() === 1 ){
					corrent_video.pauseVideo();
				}else{
					corrent_video.playVideo();
				}
			}else{
				corrent_video = $wrap.find( 'video' )[ 0 ];

				if( corrent_video.paused ){
					corrent_video.play();
				}else{
					corrent_video.pause();
				}
			}
			CHERRY_API.shortcode.video_preview.remove_poster( $wrap );
		},

		muted: function () {
			var $wrap = $( this ).parents( CHERRY_API.shortcode.video_preview.wrap ),
				data = $wrap.data('settings'),
				corrent_video;

			if( data.type === 'youtube' ){
				var frame_id = $('iframe', $wrap ).attr('id');

				corrent_video = CHERRY_API.shortcode.video_preview.youtube_players[frame_id];

				if( corrent_video.isMuted() ){
					corrent_video.unMute()
				}else{
					corrent_video.mute();
				}
			}else{
				corrent_video = $( this ).parents( CHERRY_API.shortcode.video_preview.wrap ).find( 'video' )[ 0 ];

				if( corrent_video.muted ){
					corrent_video.muted = false
				}else{
					corrent_video.muted = true
				}
			}

			CHERRY_API.shortcode.video_preview.chenge_style( $( this ) );
		},

		chenge_style: function( target ){
			var $button_class = target.data('class'),
				$button_sub_class = target.data('sub-class')/*,
				$button_text = target.data('text'),
				$button_sub_text = target.data('sub-text')*/;

			target.toggleClass($button_class+' '+$button_sub_class);
		},

		remove_poster: function( target ){
			var poster = $('.cherry-video-poster', target);

			if( poster[0] ){
				poster.remove();
			 }
		},

		resize: function(){
			var obj = this,
				$wrap = $(obj.wrap);
			$wrap.each(function(){
				var $this = $(this),
					corrent_video,
					data;

				if( $this.hasClass( obj.full_width_class.replace( '.', '' ) ) ){
					data = $(this).data('settings');
					corrent_video;

					if( data.type === 'youtube'){
						corrent_video = $('iframe', $this);

						$( '.video-holder, iframe', $this ).height( corrent_video.width()/16*9 );
					} else {
						corrent_video = $('video', $this);

						$( '.video-holder', $this ).height( corrent_video.height() );
					}
				}
			})
		}
	}
	CHERRY_API.shortcode.video_preview.init();

}(jQuery));

function onYouTubeIframeAPIReady() {
	if(typeof CHERRY_API.shortcode.video_preview === 'object'){
		CHERRY_API.shortcode.video_preview.init_youtube_player();
	}
}