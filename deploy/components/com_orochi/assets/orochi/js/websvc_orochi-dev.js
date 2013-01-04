var $j	= jQuery.noConflict();

var gaTrack;
var scrollTimer;
var currentTabId;
var iframeContent 	= new Array();
var	flowplayer		= new Object();

var bitlyObj = {
	version:    '2.0.1',
	login:      'sitech',
	apiKey:     'R_f280841d77f892adb1b2fae2c47ae78f',
	history:    '0'
};

var _gaq = _gaq || [];
  	_gaq.push(['_setAccount', 'UA-12310597-3']);
  	_gaq.push(['_trackPageview']);
  	
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

(function($j) {
	var hostName			= 'http://'+window.location.hostname;
	var orochiUrl			= window.location.href;

	emcOrochi		= {
		_analyticTracker: function(type, param) {
			if(gaTrack && (typeof param != 'undefined')) {
				switch(type) {
					case 'click':	_gaq.push(['_trackEvent', '[Syndi] '+cfgObj.title+'-'+cfgObj.id+' [300x'+orochiType+']', '[Link] '+param]);
									break;
					case 'cycle':	var groupIndex		= $j(param).closest('.emcOrochi_group_wrapper').index();
									var contentIndex	= $j(param).index();
									var content_title	= $j.parseJSON(dataObj[currentTabId].group[groupIndex].content[contentIndex].content).title;
									_gaq.push(['_trackEvent', '[Syndi] '+cfgObj.title+'-'+cfgObj.id+' [300x'+orochiType+']', '[Page] '+content_title]);
									break;
					case 'tabs':	_gaq.push(['_trackEvent', '[Syndi] '+cfgObj.title+'-'+cfgObj.id+' [300x'+orochiType+']', '[Tab] '+param]);
									break;
					case 'init':	_gaq.push(['_trackEvent', '[Syndi] '+cfgObj.title+'-'+cfgObj.id+' [300x'+orochiType+']', 'Load']);
									break;
				}
			}
		},
		_convertHex: function(hex, alpha) {
			if(hex != null) {
				var rgba;
				var patt 	= /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
				var matches = patt.exec(hex);
				
				if(alpha != null) {
					return 'rgba('+parseInt(matches[1], 16)+', '+parseInt(matches[2], 16)+', '+parseInt(matches[3], 16)+', '+alpha+')';
				} else {
					return 'rgb('+parseInt(matches[1], 16)+', '+parseInt(matches[2], 16)+', '+parseInt(matches[3], 16)+')';
				}
			}
		},
		_getHashParams: function() {
			var hash	= window.location.hash.substring(1);
				hash	= decodeURIComponent(hash.replace('header_2=', ''));
			return hash;
		},
		_iframeFunc: function(path, command) {
			if($j(path).contents().find('body').attr('style') == undefined) {
				$j(path).load(function() {
					$j(path)[0].contentWindow.emcOrochi_iframe.init(command);	
				});
			} else {
				$j(path)[0].contentWindow.emcOrochi_iframe.init(command);
			}
		
		},
		_scrollbar: function() {

			if(scrollTimer) {
				clearTimeout(scrollTimer);
				scrollTimer		= 0;
			}
			
			$j('.jspDrag').fadeIn(300);
			
			scrollTimer = setTimeout(function() {
				$j('.jspDrag').fadeOut(500)
			}, 1000);
		},
		init: function(dataURL, type) {
			$j.getJSON(dataURL, '', function(data) {
				orochiObj				= data;
				orochiObj['dfp']		= emcOrochi._getHashParams();
				cfgObj					= orochiObj.config;
				dataObj					= orochiObj.data;
				//dfpObj					= window.location.hash.substring(1);
				orochiType				= type;
				gaTrack					= true;
				
				emcOrochi._analyticTracker('init', '');
				
				emcOrochiTemplate.body();
				emcOrochi.groups(cfgObj);
				emcOrochi.tabs();
			});
		},
		groups: function(cfgObj) {
			$j('.emcOrochi_group').each(function() {
				if($j(this).children('.emcOrochi_cycle').length > 1) {
					var path 		= $j(this);
					$j(this).siblings('.emcOrochi_group_pager').removeClass('emcOrochi-hidden');
					
					$j(this).siblings('.emcOrochi_group_pager').find('.emcOrochi_group_pager_index').empty();
					
					$j(path).cycle({
						after: function(currentSlide, nextSlide, options, forwardFlag) {
							$j(this).removeClass('emcOrochi_cycle_hide');
							$j(this).siblings().addClass('emcOrochi_cycle_hide');
						},
						before: function() {
							//$j(this).siblings().addClass('emcOrochi_cycle_hide');
							//$j(this).removeClass('emcOrochi_cycle_hide');
						},
						fx: cfgObj.cycle_fx,
						manualTrump: false,
						next: $j(path).siblings('.emcOrochi_group_pager').find('.emcOrochi_group_pager_next'),
						onPagerEvent: function(slideIndex, slideElement) {
							//Show current iframe (if applicable)
							$j(slideElement).find('.emcOrochi_iframe').each(function() {
								emcOrochi._iframeFunc($j(this), 'show');
							});
							
							//Hide all other iframes in current group
							$j(slideElement).siblings('.emcOrochi_cycle').find('.emcOrochi_iframe').each(function() {
								emcOrochi._iframeFunc($j(this), 'hide');
							});
						
							//GA Track
							emcOrochi._analyticTracker('cycle', slideElement);
						},
						onPrevNextEvent: function(isNext, slideIndex, slideElement) {
							//Show current iframe (if applicable)
							$j(slideElement).find('.emcOrochi_iframe').each(function() {
								emcOrochi._iframeFunc($j(this), 'show');
							});
							
							//Hide all other iframes in current group
							$j(slideElement).siblings('.emcOrochi_cycle').find('.emcOrochi_iframe').each(function() {
								emcOrochi._iframeFunc($j(this), 'hide');
							});
							
							//GA track
							emcOrochi._analyticTracker('cycle', slideElement);
						},
						pager: $j(path).siblings('.emcOrochi_group_pager').find('.emcOrochi_group_pager_index'),
						pagerAnchorBuilder: function(idx, slide) {
							return '<a href="#" class="emcOrochi-inline">'+idx+'</a>';
						},
						prev: $j(path).siblings('.emcOrochi_group_pager').find('.emcOrochi_group_pager_prev'),
						speed: cfgObj.cycle_speed,
						timeout: 0
					});
				}
			});
		},
		tabs: function() {
			$j('#emcOrochi_body').tabs({
				select: function(event, ui) {
								
			        var url = $j.data(ui.tab, 'load.tabs');
			        if( url) {
			            window.open(url, '_blank');
			            return false;
			        } else {
			        	emcOrochi._analyticTracker('tabs', $j(ui.tab).text());
			        	return true;
			        }
			    },
			    show: function(event, ui) {
			    	currentTabId 	= ui.index;
			    	currentTabText	= ui.tab.text;
			    	
					//if first group item is iframe, show
					/*
$j(ui.panel).find('.emcOrochi_group').each(function() {
						if($j(this).find('>:first-child .emcOrochi_iframe')) {
							//emcOrochi._iframeFunc($j(this).find('>:first-child .emcOrochi_iframe'), 'show');
						} else {
							//emcOrochi._iframeFunc($j(this).find('.emcOrochi_cycle_hide .emcOrochi_iframe'), 'hide');
						}
					});
*/
					
					$j(ui.panel).find('.emcOrochi_cycle .emcOrochi_iframe').not('.emcOrochi_cycle_hide .emcOrochi_iframe').each(function() {
						emcOrochi._iframeFunc($j(this), 'show');
					});
					
					
					$j('.ui-tabs-hide').find('.emcOrochi_iframe').each(function() {
						emcOrochi._iframeFunc($j(this), 'hide');
					});
			    }
			});
		}
	},
	emcOrochiTemplate = {
		_groupContent: function(gid, data) {
			var group	= '';
			//Loops through content
			var groupData = '';
			for(cid in data[gid].content) {
				groupData = $j.parseJSON(data[gid].content[cid].content);
				groupData['id'] = data[gid].content[cid].id;
				group += emcOrochiTypes.init(groupData, groupData['id']);
			}
			
			return group;
		},
		_scrollable: function() {
			//$j('.emcOrochi-scrollable').jScrollPane().data().jsp.destroy();
			$j('.emcOrochi-scrollable').jScrollPane({autoReinitialise: true});
			$j('#emcOrochi_wrapper').mousemove(function() {emcOrochi._scrollbar();}).scroll(function() {emcOrochi._scrollbar();});
		},
		body: function() {
			emcOrochiTemplate.css(cfgObj);
			$j('#emcOrochi_header').append(emcOrochiTemplate.header());
			$j('#emcOrochi_body').append(emcOrochiTemplate.pages());
			
			emcOrochiTemplate._scrollable();
			
			$j('a.emcClickOff').click(function() {
				emcOrochi._analyticTracker('click', $j(this).attr('href'));
				setTimeout('window.open("'+$j(this).attr('href')+'")', 100);
				//window.open($j(this).attr('href'));
				return false;
			});
			
			if(cfgObj.social_show == 'true') emcOrochiTemplate.social();
		},
		css: function(cfgObj) {
			var	css 		= '<style>';
				if(cfgObj.syndi_bg_250)	css += '.emcOrochi_250{background:transparent url('+hostName+cfgObj.syndi_bg_250+') no-repeat 0 0;}';
				if(cfgObj.syndi_bg_600)	css += '.emcOrochi_600{background:transparent url('+hostName+cfgObj.syndi_bg_600+') no-repeat 0 0;}';
				css 			+= '.emcOrochi_tab{background:'+cfgObj.tab_bg_hex+';}';
				css 			+= '.emcOrochi_tab a{color:'+cfgObj.tab_text_hex+'}';
				css 			+= '.emcOrochi_tab:hover,.emcOrochi_tab.ui-tabs-selected{background:'+cfgObj.tab_bg_hover_hex+'}';
				css 			+= '.emcOrochi_tab:hover a,.emcOrochi_tab.ui-tabs-selected a {color:'+cfgObj.tab_text_hover_hex+'}';
				css 			+= '.emcOrochi_title{color:'+cfgObj.title_hex+'}';
				css 			+= '.emcOrochi_content{color:'+cfgObj.content_hex+'}';
				css 			+= 'a.emcOrochi_link{color:'+cfgObj.link_hex+'}';
				css 			+= 'a.emcOrochi_link:hover{color:'+cfgObj.link_hover_hex+'}';
				css 			+= '.emcOrochi_group_pager{background-color:'+emcOrochi._convertHex(cfgObj.pagination_bg_hex, cfgObj.pagination_bg_opacity/100)+'}';
				css 			+= '.emcOrochi_group_pager a{color:'+cfgObj.pagination_link_hex+'}';
				css 			+= '.emcOrochi_group_pager a:hover{color:'+cfgObj.pagination_link_hover_hex+'}'
				css 			+= '.emcOrochi_group_pager_index a{background-color:'+cfgObj.pagination_link_hex+'}';
				css 			+= '.emcOrochi_group_pager_index a:hover,.emcOrochi_group_pager_index a.activeSlide{background-color:'+cfgObj.pagination_link_hover_hex+'}';
				css 			+= '.emcOrochi-scrollable .jspDrag{background-color:'+cfgObj.scrollbar_hex+'}';
				css 			+= cfgObj.css;
				css 		+= '</style>';
			//return css;
			$j('head').append(css);
		},
		header: function() {
			var header 		= '';
			
			if(cfgObj.header_click_1) header += '<a href="'+cfgObj.header_click_1+'" id="emcOrochi_headerClick_left" class="emcClickOff"></a>';
			if(orochiObj['dfp']) header += '<a href="'+orochiObj['dfp']+'" id="emcOrochi_headerClick" class="emcClickOff"></a>';
		
		    return header;
        },
		groups: function(data) {
			var group		= '';
					
				//Loops through groups
				for(gid in data.group) {
					group	+= '<div class="emcOrochi_group_wrapper">';
					if(orochiType == '250' && data.group[gid].link == 1 && data.group[gid].content) {
						group	+= '<div class="emcOrochi_group emcOrochi_group_size_1">';
						group		+= emcOrochiTemplate._groupContent(gid, data.group);
						group	+= '</div>';
					} else if(orochiType == '600') {
						group	+= '<div class="emcOrochi_group emcOrochi_group_size_'+data.group[gid].size+'">';
						group		+= emcOrochiTemplate._groupContent(gid, data.group);
						group	+= '</div>';
					}
					group		+= emcOrochiTemplate.pager();
					group	+= '</div>';
				}
				
				return group;
		},
		pager: function() {
			var pager;
				pager		= '<div class="emcOrochi_group_pager emcOrochi-hidden">';
				pager			+= '<a href="#" class="emcOrochi_group_pager_prev emcOrochi-inline"><</a>';
				pager			+= '<div class="emcOrochi_group_pager_index emcOrochi-inline"></div>';
				pager			+= '<a href="#" class="emcOrochi_group_pager_next emcOrochi-inline">></a>';
				pager		+= '</div>';
				
			return pager;
		},
		pages: function() {
			var pages, content;
			var tabWidth		= 100/dataObj.length;
			var menuPosition	= (orochiType == '250')? cfgObj.tab_position_250: cfgObj.tab_position_600;
				pages		= '<ul id="emcOrochi_menu" class="emcOrochi-list-inline emcOrochi_menu_'+menuPosition+'">';
				for(id in dataObj) {
					content 	= $j.parseJSON(dataObj[id].content);
					var tabBg	= (content.menu_bg)? 'background-image: url('+content.menu_bg+'); font-size:0px': '';
					var tabClass= (content.menu_bg)? 'emcOrochi_tab_bg': 'emcOrochi_tab_hex';
					var link	= (content.link)? content.link: "#emcOrochi_"+dataObj[id].id;
					
					pages		+= '<li style="width: '+tabWidth+'%;height: 100%;'+tabBg+'" class="emcOrochi_tab '+tabClass+'">';
					pages			+= '<a href="'+link+'">'+content.title+'</a>';
					pages		+= '</li>';
				};
				pages		+= '</ul>';
				
				for(id in dataObj) {
					content = $j.parseJSON(dataObj[id].content);
					
					if(!content.link) {
						var pageBg	= (content.menu_page_bg)? 'background-image: url('+content.menu_page_bg+'); ': '';
						pages	+= '<div id="emcOrochi_'+dataObj[id].id+'" class="ui-tabs-hide emcOrochi_page emcOrochi_page_'+menuPosition+'" style="'+pageBg+'">';
						pages		+= emcOrochiTemplate.groups(dataObj[id]);
						pages	+= '</div>';
					}
				};
				
			return pages;
		},
		social: function() {
			var socialXCoor	= $j('.emcOrochi_page').position().top;
		
			var social		= '';
			var daurl		= 'http://api.bit.ly/shorten?'
								+'&longUrl='+encodeURIComponent(orochiUrl)
								+'&login='+bitlyObj.login
								+'&apiKey='+bitlyObj.apiKey
								+'&format=json&callback=?';
				$j.getJSON(daurl, function(data) {
					var emcOrochiShortUrl	= encodeURIComponent(data.results[orochiUrl].shortUrl);
					
					social		+= '<div id="emcOrochi_social" style="top: '+socialXCoor+'px">';
					social			+='<a href="https://www.facebook.com/sharer.php?u='+emcOrochiShortUrl+'" class="emcOrochi_social_facebook emcClickOff">Facebook</a>';
					social			+='<a href="https://twitter.com/share?url='+emcOrochiShortUrl+'&text='+cfgObj.social_description+'" class="emcOrochi_social_twitter emcClickOff">Twitter</a>';
					social		+= '</div>';	
					
					$j('#emcOrochi_body').prepend(social);
				});
		}
	},
	emcOrochiTypes = {
		init: function(contentObj, id) {
			var content 	= '';
				content		+='<div id="" class="emcOrochi_'+contentObj.type+' emcOrochi_cycle">';
				content 		+= emcOrochiTypes.load(contentObj, id);
				content  	+='</div>';
			return content;
		},
		load: function(contentObj, id) {
			switch(contentObj.type) {
				case 'article':		return emcOrochiTypes.article(contentObj, id);
									break;
				case 'embed':		
				case 'video':		return emcOrochiTypes.iframe(contentObj, id);
									break;
				case 'facebook':	return emcOrochiTypes.facebook(contentObj);
									break;
				case 'image':		return emcOrochiTypes.image(contentObj);
									break;
				case 'rss':			return emcOrochiTypes.rss(contentObj, id);
									break;
				case 'twitter':		return emcOrochiTypes.twitter(contentObj, id);
									break;
			}
		},
		article: function(contentObj, id) {
			var article		= '';
				article			+= '<div class="emcOrochi_full">';
				article				+= '<div class="emcOrochi-scrollable">';
				
				if(contentObj.image) article += '<img src="'+hostName+contentObj.image+'" class="emcOrochi_article_image"/>';
				
				article					+= '<div class="emcOrochi_content">';
				if(contentObj.link) article += '<a href="'+contentObj.link+'" class="emcClickOff">';
				article						+= '<h2 class="emcOrochi_title">'+contentObj.title+'</h2>';
				if(contentObj.link) article += '</a>';
				article						+= contentObj.content;
				article					+= '</div>';
				article				+= '</div>';
				if(contentObj.link) article	+= '<a href="'+contentObj.link+'" class="emcOrochi_link emcClickOff">Read More</a>';
				article			+= '</div>';

			return article;
		},
		iframe: function(contentObj, id) {
			iframeContent['emcContent_'+id]	= contentObj;
			
			var iframe	= '<iframe class="emcOrochi_iframe" id="emcOrochi_iframe_'+id+'" src="'+hostName+'/components/com_orochi/assets/orochi/helper/iframe.php?cid='+id+'" scrolling="no" frameBorder="0" width="100%" height="100%" allowTransparency="true"></iframe>';
			
			return iframe;
		},
		image: function(contentObj) {
			var image		= '';
				image 		+= (contentObj.clickURL)? '<a href="'+contentObj.clickURL+'" class="emcClickOff">': '';
				image	 		+= '<img src="'+contentObj.image+'"/>';
				image	 	+= (contentObj.clickURL)? '</a>': '';
				
			return image;
		},
		rss: function(contentObj, id) {

			rss		= '<iframe src="'+hostName+'/components/com_orochi/assets/orochi/helper/rss.php?feed_url='+contentObj.feed_url+'&items='+contentObj.articles_number+'" frameborder="0" width="300px" height="95%"></iframe>';
			return rss;
		},
		twitter: function(contentObj, id) {
			var twitter			= '';
				twitter			+= '<div class="emcOrochi_full">';
				twitter				+= '<div class="emcOrochi-scrollable">';
				twitter					+= '<div id="emcOrochi_twitter_'+id+'" class="emcOrochi_tweets"></div>';
				twitter 				+= '<scr'+'ipt>$j(".emcOrochi_250 #emcOrochi_twitter_'+id+', .emcOrochi_600 #emcOrochi_twitter_'+id+'").liveTwitter("'+contentObj.username+'", {mode: "user_timeline", refresh: false});</scr'+'ipt>';
				twitter				+= '</div>';
				twitter			+= '</div>';
			return twitter;		
		}
	}
})(jQuery);