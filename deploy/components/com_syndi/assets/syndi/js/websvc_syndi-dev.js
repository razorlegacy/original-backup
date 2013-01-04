var $j	= jQuery.noConflict();

var syndiWebsvc, syndiObj, syndiVideo, syndiTemplate, syndiStandalone, scrollTimer;

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
	var hostName	= 'http://'+window.location.hostname;
	var syndiUrl	= window.location.href;
	
	syndiWebsvc	= {
		init: function(dataURL) {
			$j.getJSON(dataURL, '', function(data) {
				syndiObj	= data;
							
				if(syndiObj.tabs.length == 1) {
					$j('head').append('<link>');
					css 	= $j('head').children(':last');
					css.attr({
						rel: 'stylesheet',
						type: 'text/css',
						href: hostName+'/components/com_syndi/assets/syndi/css/websvc_syndi_standalone.css'
					});
					syndiStandalone = true;
				} else {
					syndiStandalone = false;
				}
				
				syndiObj['dfp']	= syndiWebsvc.getHashParams();
				syndiTemplate.init(syndiObj);
			});
		},
		getHashParams: function() {
			var hash	= window.location.hash.substring(1);
				hash	= decodeURIComponent(hash.replace('header_2=', ''));
			
			return hash;
		    /*
var hashParams = {};
		    var e,
		        a = /\+/g,  // Regex for replacing addition symbol with a space
		        r = /([^&;=]+)=?([^&;]*)/g,
		        d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
		        q = window.location.hash.substring(1);
		
		    while (e = r.exec(q))
		       hashParams[d(e[1])] = d(e[2]);
		
		    return hashParams;
*/
		},
		email: function(index) {
		
			var dataString	= '';
			
			if($j('#emcSyndi_qa_question_'+index).attr('value')!='') {
			
				dataString		+= '&configData=[Syndi Webservice - '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid+']&'+$j('#emcSyndi_qa_form_'+index).serialize();
							
				$j.ajax({
					url: hostName+"/components/com_syndi/assets/syndi/helper/mail.php?",
					data: dataString,
					type: 'post',
					success: function(output) {
						$j('#emcSyndi_qa_response_'+index).fadeToggle(200);
						setTimeout(function() { $j('#emcSyndi_qa_response_'+index).fadeOut('slow'); }, 2000);
						$j('#emcSyndi_qa_question_'+index).attr('value','');
					}
				});
				
				data = $j('#emcSyndi_qa_form_'+index).serializeArray();
				syndiWebsvc.track('Email', data[4].value);
			} else {
				$j('#emcSyndi_qa_check_'+index).fadeToggle(200);
				setTimeout(function() { $j('#emcSyndi_qa_check_'+index).fadeOut('slow'); }, 2000);
			}
		},
		rss: function(index, item) {
			var rss = '';
			var items = item.content.length;
			var jsons = [];
			$j.each(item.content, function(index, content) {
				$j.ajax({
					url: '/components/com_syndi/assets/syndi/helper/rss.php',
					data: '&feed_url='+content.feed_url+'&items='+content.articles_number,
					type: 'post',
					dataType: 'json',
					async: false,
					success: function(output) {
						jsons = jsons.concat(output);
					}
				});
			});
		
			jsons = jsons.sort(function(a, b) {   
				if (a.pubDate > b.pubDate) { return -1 };
				if (a.pubDate < b.pubDate) { return 1 };                
				return 0;
			});
			
			rss += syndiTemplate._rss(index, item, jsons);
			
			return rss;
		},
		tabs: function() {
			$j('#emcSyndi_body').tabs({
				show: function(event, ui) {		
					$j('.emcSyndi_cycle').cycle('destroy');		
					syndiWebsvc.cycle(ui.panel);
					if(ui.panel.attributes['rel'].nodeValue == 'video') {
						syndiVideo.stop();
						syndiVideo.init(ui.panel.id);
						_gaq.push(['_trackEvent', '[Syndi Webservice] '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid, '[Tab Click] '+ui.tab.text]);
					}
				}
			});
		},
		twitter: function() {
			$j('.emcSyndi_twitter').each(function() {
				var usernameArray	=  $j.parseJSON($j(this).find('input[name="twitter_username"]').val());
				var usernameString	= '';
				
				for(i in usernameArray) {
					usernameString	+= (i == 0)? 'from:'+usernameArray[i]: ' OR from:'+usernameArray[i];
				}
				
				$j('.emcSyndi_tweets').liveTwitter(usernameString, {imageSize: 32, refresh: false}, function() {
					$j('.emcSyndi_tweets').jScrollPane({autoReinitialise: true});
				});
			
			});
		},        
		cycle: function(path) {
			var paginationCnt		= $j(path).find('.emcSyndi_cycle_item').size();
			
			if(paginationCnt > 1) {
				$j('.emcSyndi_cycle_nav').removeClass('emcSyndi_hidden');
				
				if(paginationCnt > 9) {
					$j('.emcSyndi_cycle_pagination').addClass('emcSyndi_hidden');
					$j('.emcSyndi_cycle_count').removeClass('emcSyndi_hidden');
				} else {
					$j('.emcSyndi_cycle_pagination').removeClass('emcSyndi_hidden');
					$j('.emcSyndi_cycle_count').addClass('emcSyndi_hidden');
				}
				
				$j(path).cycle({
					after: function(curr, next, opts) {
						$j('.emcSyndi_cycle_count').html((opts.currSlide+1)+'/'+opts.slideCount);
					},
					fx: cfgObj.cycle_fx,
					manualTrump: false,
					next: '.emcSyndi_cycle_next',
					onPagerEvent: function(id, slice) {
						syndiVideo.stop();
						var tabName = $j(path).find('#emcSyndi_tab').val();
						_gaq.push(['_trackEvent', '[Syndi Webservice] '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid, '[Page Click] '+tabName+' - Page - '+(id+1)]);
					},
					pager: '.emcSyndi_cycle_pagination',
					prev: '.emcSyndi_cycle_prev',
					speed: cfgObj.cycle_speed,
					timeout: 0
				});
			} else {
				$j('.emcSyndi_cycle_nav').addClass('emcSyndi_hidden');
			}
		},
		convertHex: function(hex, alpha) {
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
		track : function(name, content) {
			_gaq.push(['_trackEvent', '[Syndi Webservice] '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid, '['+name+' Click] ' + content]);
		},
		trackVideo : function(name, action, tabName, videoId) {
			_gaq.push(['_trackEvent', '[Syndi Webservice] '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid, '['+name+' '+action+'] [Tab - '+tabName+'] - ['+videoId+']' ]);
		},
		clickOff: function(path) {
			_gaq.push(['_trackEvent', '[Syndi Webservice] '+syndiObj.config.syndi_name+'-'+syndiObj.config.sid, '[Link Click] ' + $j(path).attr('href') ]);
		}
	},
	syndiVideo = {

		init: function(tabId) {
			var videoId;
			var listVideos 			= new Array();
			var tab			 		= $j('#'+tabId).find('#emcSyndi_tab').val();
			var playlistControls 	= false;
			
			listVideos				= $j.parseJSON($j('#'+tabId+' #playlist').html());
			playlistControls		= (listVideos.length>1)? true: false;

			$j('#'+tabId+' .emcSyndi_flowplayer').flowplayer("/libraries/evolve/assets/flash/flowplayer.swf", {
				plugins: {
					controls: {
						url: '/libraries/evolve/assets/flash/flowplayer.controls.swf',
						backgroundColor: "transparent",
						backgroundGradient: "none",
						playlist: playlistControls,
						time: false,
						scrubber: false,
						volume: false,
						fullscreen: false
					}
				},
				clip: {
					autoBuffering: true,
					onStart: function(clip) {
						if((cfgObj.video_autoMute == 'true')? true: false) {
							this.mute();
						} else {
							this.unmute();
						}
						
						videoId = clip.title;
						
						syndiWebsvc.trackVideo('Video', 'Play', tab, videoId);
						
						cuepoints = syndiVideo.getPercent(clip.duration);
						
						clip.onCuepoint(cuepoints, function(clip, cuepoint){
							syndiWebsvc.trackVideo("Video", cuepoint.title, tab, videoId);
						});
					},
					onResume: function() {
						syndiWebsvc.trackVideo('Video', 'Play', tab, videoId);
					},
					onPause: function() {					
						syndiWebsvc.trackVideo('Video', 'Pause', tab, videoId);
					}
				},
				playlist: listVideos
			});	
		},
		stop: function() {
			$j('.emcSyndi_flowplayer').flowplayer().each(function() {
				this.stop();
			});
		},
		getPercent: function(duration) {
			var _50 = duration/2;
			var _25 = duration/4;
			var _75 = parseInt(_50) + parseInt(_25);
			var _97 = (duration*97)/100;
			var cuepoint =  [];
			cuepoint.push({time: parseInt(_25)*1000, title: '25%'});
			cuepoint.push({time: parseInt(_50)*1000, title: '50%'});
			cuepoint.push({time: parseInt(_75)*1000, title: '75%'});
			cuepoint.push({time: parseInt(_97)*1000, title: '100%'});
		
			return cuepoint;
		}
		
	},
	syndiTemplate = {
		init: function(syndiObj) {
			cfgObj					= syndiObj.config;
			tabsObj					= syndiObj.tabs;
			dfpObj					= syndiObj.dfp;

			$j('#emcSyndi_wrapper').append(syndiTemplate._css());
			$j('#emcSyndi_wrapper').append(syndiTemplate._header());
			$j('#emcSyndi_wrapper').append(syndiTemplate._content());
			
			if(cfgObj.social_show == 'true') syndiTemplate._social();
			
			syndiWebsvc.tabs();
			syndiWebsvc.twitter();
			
			$j('.emcSyndi_article_content, .emcSyndi_rss_content').jScrollPane({autoReinitialise: true});
			$j('#emcSyndi_wrapper').mousemove(function() {syndiTemplate._scrollbar();}).scroll(function() {syndiTemplate._scrollbar();});	

			$j('.clickOff').click(function() {syndiWebsvc.clickOff(this);});
		},
		_css: function() {
			var	css 		= '<style>';
				css 			+= '#emcSyndi_wrapper {background: transparent url('+hostName+'/assets/components/com_syndi/'+cfgObj.sid+'/'+cfgObj.syndi_bg+') no-repeat; color: '+cfgObj.article_content_hex+'}';
				css 			+= '#emcSyndi_wrapper a, #emcSyndi_iframe span.pds-links a, #emcSyndi_iframe a.pds-return-poll {color: '+cfgObj.link_hex+'}';
				css 			+= '#emcSyndi_wrapper a:hover, #emcSyndi_iframe span.pds-links a:hover, #emcSyndi_iframe a.pds-return-poll:hover {color: '+cfgObj.link_hover_hex+'}';
				css 			+= '#emcSyndi_tabs .emcSyndi_tabs_hex a {color: '+cfgObj.tab_text_hex+'; background-color: '+cfgObj.tab_bg_hex+';}';
				css 			+= '#emcSyndi_tabs .emcSyndi_tabs_hex.ui-state-active a, #emcSyndi_tabs .emcSyndi_tabs_hex a:hover {color: '+cfgObj.tab_text_hover_hex+'; background-color: '+cfgObj.tab_bg_hover_hex+'}';
				css 			+= '.emcSyndi_header, #emcSyndi_iframe .pds-question-top {color: '+cfgObj.article_title_hex+' !important}';
				css 			+= '#emcSyndi_iframe  .pds-input-label, #emcSyndi_iframe .pds-answer-text, #emcSyndi_iframe .pds-feedback-per {color: '+cfgObj.article_content_hex+' !important;}'
				css 			+= '.emcSyndi_cycle_nav {background: '+syndiWebsvc.convertHex(cfgObj.cycle_pagination_bg)+'; background: '+syndiWebsvc.convertHex(cfgObj.cycle_pagination_bg, .5)+';}';
				css 			+= '.emcSyndi_tweets .tweet {border-bottom: 1px dotted '+cfgObj.cycle_pagination_bg+'}';
				css 			+= '#emcSyndi_wrapper .emcSyndi_cycle_nav a {color: '+cfgObj.cycle_pagination_hex+';}';
				css 			+= '#emcSyndi_wrapper .emcSyndi_cycle_nav a.activeSlide, #emcSyndi_wrapper .emcSyndi_cycle_nav a:hover {color: '+cfgObj.cycle_pagination_hover_hex+';}';
				css 			+= '#emcSyndi_wrapper .jspDrag {background-color: '+cfgObj.cycle_pagination_bg+'}';
				css 		+= '</style>';
			return css;
		},
		_scrollbar: function() {

			if(scrollTimer) {
				clearTimeout(scrollTimer);
				scrollTimer		= 0;
			}
			
			$j('.jspDrag').fadeIn(500);
			
			scrollTimer = setTimeout(function() {
				$j('.jspDrag').fadeOut(500)
			}, 1000);
		},
		_social: function() {
			var socialTemplate	= '';
			
			var daurl = 'http://api.bit.ly/shorten?'
				+'&longUrl='+encodeURIComponent(syndiUrl)
				+'&login='+bitlyObj.login
				+'&apiKey='+bitlyObj.apiKey
				+'&format=json&callback=?';
			
			$j.getJSON(daurl, function(data){
				var syndiShortUrl	= data.results[syndiUrl].shortUrl;
					syndiShortUrl	= encodeURIComponent(syndiShortUrl);
				
				socialTemplate 		= '<div id="emcSyndi_social_icon">';
				socialTemplate			+='<a href="https://www.facebook.com/sharer.php?u='+syndiShortUrl+'" class="emcSyndi_share_facebook clickOff" target="_blank">Facebook</a>';
				socialTemplate			+='<a href="https://twitter.com/share?url='+syndiShortUrl+'&text='+cfgObj.social_description+'" class="emcSyndi_share_twitter clickOff" target="_blank">Twitter</a>';
				socialTemplate		+='</div>';
				
				$j('#emcSyndi_body').prepend(socialTemplate);
			});
		},
		_header: function() {
			var header_click_1		= cfgObj.header_click_1;
			var header_click_2		= (dfpObj)? dfpObj: cfgObj.header_click_2;
            var header;
                header          = '<div id="emcSyndi_header">';
                header                  += (header_click_1)? '<a href="'+header_click_1+'" id="emcSyndi_headerClick_1" class="clickOff" target="_blank"></a>': '';
                header                  += (header_click_2)? '<a href="'+header_click_2+'" id="emcSyndi_headerClick_2" class="clickOff" target="_blank"></a>': '';
                header          += '</div>';
            return header;
        },
		_content: function() {
			var content;
			
				content 	= '<div id="emcSyndi_body">';
				content		+= (cfgObj.tab_position == 'top')? syndiTemplate._menu(): '';
				content 		+= '<div id="emcSyndi_panel">';
								
				$j.each(tabsObj, function(i, item) {
					content 		+= '<div id="emcSyndi_'+item.tab_id+'" class="emcSyndi_cycle" rel="'+item.typetab+'">';
					switch(item.typetab) {
						case 'article': 	content	+= syndiTemplate._article(i, item);
											break;
						case 'facebook': 	content += syndiTemplate._facebook(i, item);
											break;
						case 'image': 		content += syndiTemplate._image(i, item);
											break;
						case 'poll':		content += syndiTemplate._polldaddy(i, item);
											break;
						case 'qa': 			content += syndiTemplate._qa(i, item);
											break;
						case 'rss':			content += syndiWebsvc.rss(i, item);
											break;
						case 'twitter':		content += syndiTemplate._twitter(i, item);
											break;
						case 'video':		content += syndiTemplate._video(i, item);
											break;
					}
					content			+= '</div>';
				});
				content 			+= '<div class="emcSyndi_cycle_nav emcSyndi_hidden">';
				content					+= '<a href="#" class="emcSyndi_cycle_prev emcSyndi_cycle_button"><</a>';
				content 				+= '<div class="emcSyndi_cycle_count"></div>';
				content 				+= '<div class="emcSyndi_cycle_pagination"></div>';
				content 				+= '<a href="#" class="emcSyndi_cycle_next emcSyndi_cycle_button">></a>';
				content 			+= '</div>';
				content 		+= '</div>';	
				content		+= (cfgObj.tab_position == 'bottom')? syndiTemplate._menu(): '';
				content		+= '</div>';
				
			return content;
		},
		_menu: function() {
			var tabWidth	= 100/tabsObj.length;
		
			var tabs;
				tabs		= '<ul id="emcSyndi_tabs">';
				$j.each(tabsObj, function(i, item) {
					tabsClass 	= (item.tab_bg.length > 0)? 'emcSyndi_tabs_bg': 'emcSyndi_tabs_hex';
					tabsStyle	= (item.tab_bg.length > 0)? ' background-image: url('+item.tab_bg+'); background-repeat: no-repeat;': '';
					
					tabs		+= '<li style="width: '+tabWidth+'%; height: 100%;'+tabsStyle+'" class="'+tabsClass+'">';
					tabs			+= '<a href="#emcSyndi_'+item.tab_id+'">'+item.title+'</a>';
					tabs		+= '</li>';
				});
				tabs		+= '</ul>';
			return tabs;
		},
		_article: function(i, item) {
			var article = '';

				$j.each(item.content, function(i, content) {
				
					article		+= '<div id="emcSyndi_'+item.alias+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
					article		+= '<input type="hidden" id="emcSyndi_tab" value="'+item.title+'"/>';
					if(content.image) {
						article		+= '<div class="emcSyndi_left">';
						article			+= (content.articleURL)? '<a href="'+content.articleURL+'" target="_blank" class="clickOff">': '';
						article				+= '<img src="'+hostName+content.image+'"/>';
						article			+= (content.articleURL)? '</a>': '';
						article		+= '</div>';
						article		+= '<div class="emcSyndi_right">';
					} else {
						article		+= '<div class="emcSyndi_full">';
					}
					
					article				+= '<h3 class="emcSyndi_header">'+content.title+'</h3>';
					article					+= '<div class="emcSyndi_article_content"><p>'+content.content+'</p></div>';
					article				+= (content.articleURL)? '<a href="'+content.articleURL+'" target="_blank" class="clickOff">Read More</a>': '';
					article			+= '</div>';
					article		+= '</div>';
					
				});
				
			return article;
		},
		_facebook: function(i, item) {
			var facebook 		= '';
			var facebookHeight	= (syndiStandalone)? '200': '169';
			
			$j.each(item.content, function(i, content) {
				facebook 	+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
				facebook		+= '<input type="hidden" id="emcSyndi_tab" value="'+item.title+'"/>';
				facebook		+= '<iframe src="http://www.facebook.com/plugins/activity.php?site='+content.feedURL+'&amp;width=300&amp;height='+facebookHeight+'&amp;header='+content.header+'&amp;colorscheme='+content.colorscheme+'&amp;font&amp;border_color&amp;recommendations=false" scrolling="no" frameborder="0" width="300px" height="169px" allowTransparency="true"></iframe>';
				facebook	+= '</div>';
			});

			return facebook;
		},
		_image: function(i, item) {
			var image = '';

				$j.each(item.content, function(i, content) {
					image 		+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';				
					image			+= '<input type="hidden" id="emcSyndi_tab" value="'+item.title+'"/>';					
					image 			+= (content.clickURL)? '<a href="'+content.clickURL+'" target="_blank" class="clickOff">': '';
					image 				+= '<img src="'+hostName+content.image+'"/>';
					image 			+= (content.clickURL)? '</a>': '';
					image 		+= '</div>';
				});
				
			return image;
		},
		_polldaddy: function(i, item) {
			var polldaddy		= '';
							
				$j.each(item.content, function(i, content) {
					polldaddy	+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
					polldaddy		+= '<iframe src="'+hostName+'/components/com_syndi/assets/syndi/helper/poll.php?poll_id='+content.polldaddy_key+'&standalone='+syndiStandalone+'" scrolling="no" frameborder="0" width="300" height="169" allowTransparency="true"/>';
					polldaddy	+= '</div>';
				});
				
				return polldaddy;
		},
		_qa: function(i, item) {
			var qa = '';
			$j.each(item.content, function(i, content) {
				qa 	+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
				qa 		+= '<form id="emcSyndi_qa_form_'+i+'" class="emcSyndi_qa_form">';
				qa			+= '<h3 class="emcSyndi_header">'+content.title+'</h3>';
				qa			+= '<p class="emcSyndi_'+item.typetab+'_desc">'+content.description+'</p>';
				qa			+= '<textarea name="emcSyndi_qa_question" id="emcSyndi_qa_question_'+i+'"/></textarea>';
				qa			+= '<input type="button" class="emcSyndi_button" id="email_submit" value="Send" onClick="syndiWebsvc.email('+i+')"/>';
				qa			+= '<input type="hidden" name="email_to" id="email_to" value="'+content.email+'"/>';
				qa			+= '<input type="hidden" name="email_title" id="email_title" value="'+content.title+'"/>';
				qa			+= '<input type="hidden" name="emcSyndi_tab" id="emcSyndi_tab" value="'+item.title+'"/>';
				qa			+= '<input type="hidden" name="emcSyndi_content_id" id="emcSyndi_content_id" value="'+content.qa_id+'"/>';
				qa			+= '</form>';
				qa		+= '<div id="emcSyndi_qa_response_'+i+'" class="emcSyndi_qa_response" style="display: none">';
				qa			+= '<p>Thank You! Your e-mail has been sent!</p>';
				qa		+= '</div>';
				qa		+= '<div id="emcSyndi_qa_check_'+i+'" class="emcSyndi_qa_response" style="display: none">';
				qa			+= '<span class="emcSyndi_check">* The question field is empty</span>';
				qa		+= '</div>';
				qa	+= '</div>';
			});
			
			return qa;
		},
		_rss: function(i, tab, rssObj) {
				var rss	= '';
				$j.each(rssObj, function(i, item) {
					rss		+= '<div id="emcSyndi_'+tab.typetab+'_'+i+'" class="emcSyndi_'+tab.typetab+' emcSyndi_cycle_item">';
					rss 		+= '<input type="hidden" id="emcSyndi_tab" value='+tab.title+'/>';
					rss			+= '<div class="emcSyndi_full">';
					rss				+= '<h3 class="emcSyndi_header">'+item.title[0]+'</h3>';
					rss					+= '<div class="emcSyndi_rss_content"><p>'+item.description+'</p></div>';
					rss				+= (item.link[0])? '<a href="'+item.link[0]+'" target="_blank" class="clickOff">Read More</a>': '';
					rss			+= '</div>';
					rss		+= '</div>';
				});
			
			return rss;
		},
		_twitter: function(i, item) {
			var twitter			= '';
			var arrUsername		= new Array();
			
			$j.each(item.content, function(i, content) {
				var twitter_config = $j.parseJSON(content.twitter_config);
				arrUsername.push(twitter_config.username);
			});	

			twitter 	+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
			twitter			+= '<input type="hidden" id="emcSyndi_tab" value="'+item.title+'"/>';
			twitter			+= "<input type='hidden' name='twitter_username' value='"+$j.stringify(arrUsername)+"'/>";
			twitter			+= '<div class="emcSyndi_tweets"></div>';
			twitter		+= '</div>';
			
			return twitter;		
		},
		_video: function(i, item) {	
			var video			= '';
			var arrVideos 	= new Array();
			
			$j.each(item.content, function(i, content) {
				autoplay 	= (cfgObj.video_autoStart == 'true' || i > 0)? true: false;
				arrVideos.push({url: content.sbFeed, title: content.videoId, autoPlay: autoplay});
			});
			
			video 	+= '<div id="emcSyndi_'+item.typetab+'_'+i+'" class="emcSyndi_'+item.typetab+' emcSyndi_cycle_item">';
			video		+= '<input type="hidden" id="emcSyndi_tab" value="'+item.title+'"/>';
			video		+= '<div id="playlist" style="display: none;">'+$j.stringify(arrVideos)+'</div>';
			video		+= '<div id="emcSyndi_flowplayer" class="emcSyndi_flowplayer"></div>';
			video	+= '</div>';

			return video;
		}
	}
})(jQuery);