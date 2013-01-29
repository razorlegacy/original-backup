var hoverIntent,
	paramAutoClose;
	//mcOriginConfig	= JSON.parse(decodeURIComponent(window.name)),
	
var adAssets		= 'http://'+document.domain+'/assets/components/com_emc_origin', //WHERE IS THIS USED?
	adCurrentDate	= new Date(),
	adOriginObj		= new Object(),
	adOriginConfig	= JSON.parse(decodeURIComponent(window.name)),
	adSelectorHide, //WHERE IS THIS USED?
	adSelectorShow, //WHERE IS THIS USED?
	adTrigger		= 'open',
	adTypes,
	adUrl			= 'http://'+document.domain+'/index.php?option=com_emc_origin&task=content';//WHERE IS THIS USED?

/***** METHODS *****/
var emcOriginAd = (function() {
	function xd() {
		//Cross-domain communication
		XD.postMessage(JSON.stringify(params), adOriginConfig.source);
	}
	
	function animate(type, triggerWrapper) {
		//Deactivates trigger to prevent duplicates
		trigger.unbind();
		
		//Sets response parameter
		params.toggle	= triggerWrapper;
		
		//Sends crossdomain call
		xd();
		
		switch(type) {
			case 'horizon':
				switch(adTrigger) {
					case 'close':
						start			= params.animateEnd;
						end				= params.animateStart;
						time			= params.animateTime;
						adTrigger		= 'open';
						break;
					case 'open':
						start			= params.animateStart;
						end				= params.animateEnd;
						time			= params.animateTime;
						adTrigger		= 'close';
						break;
				}
				
				$('#'+params.animateSelector).animate({
					top: end
				}, time, function() {
					toggle.auto(triggerWrapper);
				});
				break;
		}
	}

	var toggle = {
		auto: function(triggerWrapper) {
			switch(triggerWrapper) {
				case 'initial':
					toggle.hide('initial');
					trigger.unbind('initial');
					toggle.show('triggered');
					trigger.bind('triggered');
					break;
				case 'triggered':
					toggle.hide('triggered');
					trigger.unbind('triggered');
					toggle.show('initial');
					trigger.bind('initial');
					break;
			}
		},
		hide: function(selector) {
			/*
$('#'+selector+' .data-flash').each(function() {
				$(this).data('content', encodeURIComponent($(this).html()));
				$(this).hide().empty();
			});
*///IS THIS STILL RELEVANT?
			
			$('#'+selector+' .data-embed').each(function() {
				$(this).data('content', encodeURIComponent($(this).attr('src')));
				$(this).attr('src', '');
			});
		},
		show: function(selector) {
			/*
$('#'+selector+' .data-flash').each(function() {
				$(this).show().html(decodeURIComponent($(this).data('content')));
			});
*///IS THIS STILL RELEVANT?
			
			$('#'+selector+' .data-embed').each(function() {
				$(this).attr('src', decodeURIComponent($(this).data('content')));
			});
		}
	}

	var trigger = {
		bind: function(selector) {
			if(typeof selector === 'undefined' ) {
				selector 	= 'body';
			} else {
				selector	= '#'+selector;
			}
		
			$(selector+' .trigger').each(function() {
				if($(this).data('type') === 'hover') {
					$(this).bind('mousemove', trigger.event);
					//$(this).bind('mouseout', function(){clearTimeout(trigger)});
				} else if ($(this).data('type') === 'click') {
					$(this).bind($(this).data('type'), trigger.event);
				} else {
					//Remove ad
					//$(this).bind('click', privateMethods.adRemove);
				}
			});
		},
		unbind: function(selector) {
			if(typeof selector === 'undefined' ) {
				selector 	= 'body';
			} else {
				selector	= '#'+selector;
			}
			
			$(selector+' .trigger').each(function() {
				$(this).unbind('click', trigger.event);
				$(this).unbind('mousemove', trigger.event);
				//$(this).unbind('click', privateMethods.adRemove)
			});
		},
		event: function(e) {
			var triggerWrapper		= $(e.target).closest('.wrapper').attr('id');
			//clearTimeout(paramAutoClose);
			clearTimeout(adOriginConfig.close)
			switch(e.type) {
				case 'click':
					animate(adOriginConfig.type, triggerWrapper);
					break;
				case 'mouseover':
					var onmousestop = function() {
						//privateMethods.triggerUnbind();
						//pubicMethods.toggle();
						triger = false;
					};
					return function() {
						clearTimeout(trigger);
						trigger = setTimeout(onmousestop, emcOriginConfig.hover * 1000);
					}();
					break;
			}
		}	
	}
	
	return {
		video: function(id) {
			//var embed	= window.frames.embed;
			//embed.$sb(id).play();
			
			//$('#embed-137')[0].contentWindow.$sb(id).play();
			//$('#embed-137')[0].contentWindow.$sb(id).seek(140);
		},
		hide: function(selector) {
			toggle.hide(selector);
		},
		show: function(selector) {
			toggle.show(selector);
		},
		bind: function(selector) {
			trigger.bind(selector);
		},
		unbind: function(selector) {
			trigger.unbind(selector);
		}
	}
})();

/***** INIT *****/
function initialize(jsonURL) {
	$.getJSON(jsonURL, function(data) {
		adOriginObj.config	= data.config;
		adOriginObj.config.config 	= JSON.parse(data.config.config);
		
		//Filter out outside dates
		var insertDate		= false;
		for(var i in data.content) {
			var start_date	= new Date(data.content[i].start_date),
				end_date	= new Date(data.content[i].end_date);
			
			if(adCurrentDate >= start_date && adCurrentDate <= end_date) {
				adOriginObj.content = data.content[i];
				insertDate	= true;
			}
			
			if(!insertDate) {
				adOriginObj.content = data.content[0];
			}
		}
		
		//Filter out non-related platforms
		var mobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
              if (mobile) {
                  var userAgent = navigator.userAgent.toLowerCase();
                  if (((userAgent.search("android") > -1) && (userAgent.search("mobile") > -1)) || userAgent.search('iphone') > -1){
                        //console.log("MOBILE");
                        adTypes = ['initial_mobile', 'triggered_mobile'];
                  } else if (((userAgent.search("android") > -1) && !(userAgent.search("mobile") > -1)) || userAgent.search('ipad') > -1) {
                       //console.log("TABLET");
                       adTypes = ['initial_tablet', 'triggered_tablet'];
                  }
              }
              else {
                  //Remove tablet and mobile data
                  adTypes = ['initial_desktop', 'triggered_desktop'];
              }
			
		//Insert template
		adTypes.forEach(function(type) {
			adOriginObj.content[type].forEach(function(content) {
				/* content_data	= content.content_data,
					content_config	= content.content_config, */
				var itemCSS = 'style="width:'+content.content_config.width+';height:'+content.content_config.height+';top:'+content.content_config.top+';left:'+content.content_config.left+';z-index:'+content.content_config.zIndex+';"',
					item 	= content.content_render.replace('<%=style%>', itemCSS);
					//item	= emcOriginAdTemplate[content_config.type]({content_data: content_data, content_config: content_config});
				$('#'+type.split('_')[0]+' .content').append(item);
			});
			
			//Insert background images
			$('#'+type.split('_')[0]).css('background-image', 'url(/assets/components/com_emc_origin/'+adOriginObj.config.id+'/'+adOriginObj.config.config[type]+')');
		});
		
		switch(adOriginConfig.type) {
			case 'ascend':
				break;
			case 'eclipse':
				break;
			case 'horizon':
				//Hide expanded data
				emcOriginAd.hide('triggered');
				
				//Enable triggers
				emcOriginAd.bind('initial');
				break;
			case 'meridian':
				break;
			case 'nova':
				break;
		}

		//Run auto-open functions
		
		
		
		/*
		//Ignore overlay expanded
		if((data.format === 'overlay' && data.toggle === 'expand') || data.format === 'expansion') {
		
			//Setup auto-initialize
			//Increment counter and open
			var cookieValue 	= ($.cookie('emcOrigin-'+data.id))? JSON.parse($.cookie('emcOrigin-'+data.id)): {'auto': 0, 'expiration': 1},
				cookieAuto		= cookieValue.auto,
				cookieExpiration= cookieValue.expiration;
	
			//If not at frequency cap
			if(cookieAuto < emcOriginConfig.auto) {
				
				if(cookieExpiration == 1) {
					var now		= new Date(),
						expire 	= new Date();
						expire.setFullYear(now.getFullYear());
						expire.setMonth(now.getMonth());
						expire.setDate(now.getDate()+1);
						expire.setHours(now.getHours());
					cookieExpiration = expire;
				} else {
					cookieExpiration = new Date(cookieExpiration);
				}
				
				var cookieValue	= JSON.stringify({'auto': cookieAuto + 1, 'expiration': cookieExpiration});
				
				$.cookie('emcOrigin-'+data.id, cookieValue, { expires: cookieExpiration});
				
				if(data.auto === 1) emcOriginAd.adOpen();
				autoOpen	= true;
			}
			
			//Embed pixel
			if(emcOriginConfig.pixel) $('body').append('<img src="'+emcOriginConfig.pixel+'" width="0" height="0"/>');
		}//end if-overlay expanded
		
		//Setup auto-close
		if(emcOriginConfig.close > 0 && emcOriginConfig.auto > 0) {	
			if((data.format === 'overlay' && data.auto === 0) || data.format === 'expansion') {
				autoClose 		= setTimeout(function() {emcOriginAd.adClose();}, emcOriginConfig.close * 1000);
			}
		}
		*/
	});
}
