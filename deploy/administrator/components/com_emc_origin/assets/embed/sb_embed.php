<div class="emcOrigin_sbPlayer_brandedCanvas">
	<div id="sb_video_player_sidh029"></div> 
	<script src="http://cdn.springboard.gorillanation.com/storage/js/list_widget/teaser.sb.lib.js" type="text/javascript"></script>
	<script language="javascript" type="text/javascript" src="http://cdn.springboard.gorillanation.com/storage/js/sb.html5.js"></script>
	<div id="sbTeaser_112850">
		<script type="text/javascript">
			var emcOrigin_sbPlayerConfig = {
				behavior : "teaser",
				partnerId : 515,
				mode: "playlist",
				contentId : "2719",
				itemsPerPage: 4,
				items: 10,
				teaser : {
					width: 560,
					height: 100,
					search: false,
					horizontal: true,
					itemWidth: 114,
					itemHeight: 66,
					id: "sbTeaser_112850",
					videoNamesColor: "#FFFFFF",
					color: "#084c5d;#2e7283;#5398a9;#79becf;#d5d5d4",
					imgType: "snapshot",
					thumbWidth: 114,
					thumbHeight: 66,
					radius: 5,
					errorImg: "http://cms.springboard.gorillanation.com/img/snapshot_default.png",
					referrer: "",
					onSamePage: "true",
					html5: true,
					lightbox: false
				},
				player : {
					width: 560,
					height: 353,
					id: "sb_video_player_sidh029",
					playerId: "sidh029"
				},
				cdnPath : "http://cdn.springboard.gorillanation.com",
				cmsPath : "http://cms.springboard.gorillanation.com",
				storagePath : "http://cdn.springboard.gorillanation.com/storage",
				prettyPath : "http://si-general.springboardplatform.com/mediaplayer/springboard/"
			}
			SbTeaserWidget.init(emcOrigin_sbPlayerConfig);
		</script>
	</div>
</div>


<!-- STANDALONE VERSION -->

<script language="javascript" type="text/javascript" src="http://www.springboardplatform.com/jsapi/embed"></script>
<div class="videoPlayer" id="sidh029_485b7268678f2774ef53cdd422f45fb8"></div>
<script type="text/javascript">$sb("sidh029_485b7268678f2774ef53cdd422f45fb8",{"sbFeed":{"partnerId":515,"type":"video","contentId":496933,"cname":"si-general"},"style":{"width":558,"height":352}});emcOriginAd.springboard("sidh029_485b7268678f2774ef53cdd422f45fb8", {"autoPlay": true, "startMute": true, "unmuteHover": true, "unmuteRestart": true, "onFinish": true})</script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script><script type="text/javascript">google.load("ima", "1");</script>



		autoPlay: function(id) {
			$sb(id).play();
		},
		onFinish: function(id) {
			//Flag to auto-close only when auto-opened
			$sb(id).onFinish(function() {
				if(autoOpen) {
					emcOriginAd.adClose();
				}
			});
		},
		startMute: function(id) {
			//Only automute on auto-open. If user initiated, play audio
			if(autoOpen) {
				$sb(id).mute();
			} else {
				$sb(id).unmute();
			}
		},
		unmuteHover: function(id) {
			//Unmute video upon mouse-over
			$sb(id).onMouseOver(function() {
				if($sb(id).getStatus().muted) {
					$sb(id).unmute();
				}
			});
		},
		unmuteRestart: function(id) {
			//Restart video when unmute
			$sb(id).onUnmute(function() {
				$sb(id).seek(0);
			});
		}