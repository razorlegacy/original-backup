<!DOCTYPE HTML>
<html>
	<head>
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_orochi/assets/orochi/js/websvc_orochi.js"></script>
		<script type="text/javascript">
			window.onload=function(){if(parent)for(var c=document.getElementsByTagName("head")[0],b=parent.document.getElementsByTagName("style"),a=0;a<b.length;a++)c.appendChild(b[a].cloneNode(!0))};
			
			var $j				= jQuery.noConflict();
			var contentObj		= window.parent.iframeContent['emcContent_<?php echo $_GET['cid'];?>'];
			var contentEmbed	= contentObj.embed;
			var emcOrochi_iframe;
				
			if("video"==contentObj.type){var flowplayer={},sbEmbed="<div>"+contentEmbed+"</div>",playerClass=$j("object.SpringboardPlayer",sbEmbed).attr("id");flowplayer.fireEvent=function(a,b){if("onLoad"==b&&!parent.document.getElementById("orochi")){var d=document[playerClass].fp_getPlaylist(),c=[],e;for(e in d)c.push(d[e].completeUrl);"true"==contentObj.playlistRandom&&c.sort(function(){return 0.5-Math.random()});"true"==contentObj.autoplay&&document[playerClass].fp_play(c);"true"==contentObj.automute?document[playerClass].fp_mute():
document[playerClass].fp_unmute()}}}(function(a){emcOrochi_iframe={init:function(b){switch(b){case "hide":a("body").empty();a("body").addClass("emcOrochi_iframe_hidden");break;case "show":a("body").append(a("body").data("iframe_clone")),a("body").removeClass("emcOrochi_iframe_hidden")}}}})(jQuery);
$j(function(){parent.document.getElementById("orochi")&&$j("body").append(contentEmbed);$j("head").append("<style>iframe{height: "+$j(window.frameElement).height()+"px}</style>");$j("body").data("iframe_clone",contentEmbed)});

		</script>
	</head>
	<body id="" class="" style="margin:0;padding:0;"></body>
</html>