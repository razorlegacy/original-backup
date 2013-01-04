var loadLive;
var emcCartographerTooltip = {
	events: {
		hide: function(event, api) {
			var tooltipContent		= $j(api.elements.tooltip).find('.ui-tooltip-content');
			tooltipContent.hide().html('').show();
		},
		show: function(event, api) {
			if(loadLive && $j(api.elements.target).data('link')) {
				event.preventDefault();
				window.open($j(api.elements.target).data('link'), '');
			} else {
				api.set('content.text', $j(api.elements.target).data('content').content);
				
				var tooltipHeight	= $j(api.elements.tooltip).height();
				var titleHeight		= $j(api.elements.titlebar).height();
				var maxHeight		= $j(api.elements.content).css('max-height');
				var contentHeight	= (tooltipHeight - titleHeight - 10) + 'px';
				if(contentHeight >= maxHeight) {	
					$j(api.elements.content).slimScroll();
				}
			}
		}
	},
	hide: {
		event: 'click unfocus',
		fixed: true
	},
	position: {
		adjust: {
			method: 'shift'
		},
		at: 'center center',
		effect: false,
		my: 'top left'
	},
	show: {
		event: 'click',
		solo: true
	},
	style: {
		def: false
 	}
}

emcCartographer	= {
	init: function() {
		loadLive	= true;
		emcCartographer.qtip();
		emcCartographer.analytics('load', '');
		emcCartographerGroups.init();
	},
	analytics: function(type, param) {
		switch(type) {
			case 'load':		_gaq.push(['_trackEvent', '[Cartographer] '+emcCartographer_id+'-'+emcCartographer_name, '[Load]']);
								break;
			case 'tooltip':		_gaq.push(['_trackEvent', '[Cartographer] '+emcCartographer_id+'-'+emcCartographer_name, '[Tooltip] '+param]);
								break;
		}
	},
	qtip: function() {
		$j('.emcCartographer_marker').each(function() {
			var markerLink		= $j(this).data('link');
			
			$j(this).qtip($j.extend(true, {}, emcCartographerTooltip, {
				content: {
					text: $j(this).data('content').content,
					title: {
						button: true,
						text: '<h4>'+$j(this).data('content').title+'</h4>'
					}
				},
				id: 'emcCartographer_tooltip_'+$j(this).data('id'),
				position: {
					target: 'event',
					viewport: $j('#emcCartographer_markers_'+$j(this).parent().data('id'))
				},
				show: {
					event: cartographerMarkerTrigger
				},
				style: {
					classes: 'emcCartographer_tooltip emcCartographer_tooltip_'+$j(this).parent().data('id')+' emcCartographer_tooltip_'+$j(this).data('content').tooltip_size_type
				}
			}));
		});
	}
}

emcCartographerGroups = {
	init: function() {
		emcCartographerGroups.tabs();
	},
	tabs: function() {
			$j('#emcCartographer_group_list li').click(function() {
				$j('.emcCartographer_group').hide();
				$j('#'+$j(this).data('group')).show();
				
				return false;
			});
		}

}
