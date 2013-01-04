var hoverIntent,
	paramAutoClose;
	//mcOriginConfig	= JSON.parse(decodeURIComponent(window.name)),
	
var adAssets		= 'http://'+document.domain+'/assets/components/com_emc_origin',
	adCurrentDate	= new Date(),
	adOriginObj		= new Object(),
	adSelectorHide,
	adSelectorShow,
	adTrigger		= 'open',
	adTypes			= ['default', 'expand'],
	adUrl			= 'http://'+document.domain+'/index.php?option=com_emc_origin&task=content';
	

/***** TEMPLATE *****/
var emcOriginAdTemplate = (function() {
	function create(source, data) {
		var handlebars	= Handlebars.compile(source);
		return handlebars(data);
	}
	
	function embedParams() {
		return '&id=<%=content_data.id%>&oid=<%=content_data.oid%>&sid=<%=content_data.sid%>';
	}
	
	function style() {
		return ' style="width:<%=content_config.width%>px;height:<%=content_config.height%>px;top:<%=content_config.coordY%>px;left:<%=content_config.coordX%>px;z-index:<%=content_config.zIndex%>;" ';
		//return ' style="width:{{content_config.width}}px;height:{{content_config.height}}px;top:{{content_config.coordY}}px;left:{{content_config.coordX}}px;z-index:{{content_config.zIndex}};" ';
	}
	
	return {
		embed: function(data) {
			return _.template('<iframe id="" class="data-embed" src="'+adUrl+'&template=embed'+embedParams()+'"'+style()+' frameborder=0 scrolling=0></iframe>')(data);
		},
		flash: function(data) {
			return _.template('<iframe id="" class="data-embed" src="'+adUrl+'&template=flash'+embedParams()+'"'+style()+' frameborder=0 scrolling=0></iframe>')(data);
		},
		image: function(data) {
			return _.template('<img src="'+adAssets+'/<%=content_data.oid%>/<%=content_data.imageDefault%>"'+style()+'/>')(data);
		},
		link: function(data) {
			var source		= '';
			return create(source, data);
		},
		remove: function(data) {
			var source		= '';
			return create(source, data);	
		},
		trigger: function(data) {
			return _.template('<div class="data-embed"'+style()+'><div class="trigger" data-type="<%=content_data.content%>"></a></div>')(data);
		}
	}
})();

/***** METHODS *****/
var emcOriginAd = (function() {

	function animate(type, triggerWrapper) {
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
				case 'default':
					toggle.hide('default');
					emcOriginAd.unbind('default');
					toggle.show('expand');
					emcOriginAd.bind('expand');
					break;
				case 'expand':
					toggle.hide('expand');
					emcOriginAd.unbind('expand');
					toggle.show('default');
					emcOriginAd.bind('default');
					break;
			}
		},
		hide: function(selector) {
			$('#'+selector+' .data-flash').each(function() {
				$(this).data('content', encodeURIComponent($(this).html()));
				$(this).hide().empty();
			});
			
			$('#'+selector+' .data-embed').each(function() {
				$(this).data('content', encodeURIComponent($(this).attr('src')));
				$(this).attr('src', '');
			});
		},
		show: function(selector) {
			$('#'+selector+' .data-flash').each(function() {
				$(this).show().html(decodeURIComponent($(this).data('content')));
			});
			$('#'+selector+' .data-embed').each(function() {
				$(this).attr('src', decodeURIComponent($(this).data('content')));
			});
		}
	}

	var trigger = {
		bind: function(selector) {
			$('#'+selector+' .trigger').each(function() {
				if($(this).data('type') === 'mouseenter') {
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
			$('#'+selector+' .trigger').each(function() {
				$(this).unbind('click', trigger.event);
				$(this).unbind('mousemove', trigger.event);
				//$(this).unbind('click', privateMethods.adRemove)
			});
		},
		event: function(e) {
			var triggerWrapper		= $(e.target).closest('.wrapper').attr('id');
			clearTimeout(paramAutoClose);
			switch(e.type) {
				case 'click':
					animate(params.type, triggerWrapper);
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
		
		//Insert template
		adTypes.forEach(function(type) {
			adOriginObj.content[type].forEach(function(content) {
				var content_data	= JSON.parse(content.content_data),
					content_config	= JSON.parse(content.content_config),
					item			= emcOriginAdTemplate[content_config.type]({content_data: content_data, content_config: content_config});
				$('#'+type+' .content').append(item);
			});
		});
		
		switch(params.type) {
			case 'ascend':
				break;
			case 'eclipse':
				break;
			case 'horizon':
				//Hide expanded data
				emcOriginAd.hide('expand');
				
				//Enable triggers
				emcOriginAd.bind('default');
				break;
			case 'meridian':
				break;
			case 'nova':
				break;
		}

	});
}
