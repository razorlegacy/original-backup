var $j				= jQuery.noConflict();

$j.ajaxSetup({
	type: 'post',
	url: 'index.php?option=com_emc_origin'
});

var azureModal = {
	events: {
		hide: function(event, api) {
			//api.destroy();
		}
	},
	hide: false,
	position: {
		at:		'center',
		my:		'center',
		target: $j(window)
	},
	show: {
		event: 'click',
		modal: {
			blur: false,
			on: true
		}
		//ready:	true
	},
	style: {
		classes: 'ui-tooltip-plain azure-ui-modal',
		def: false
	}
},
azureTooltip = {
	hide: {
		event: 'mouseleave'
	},
	show: {
		event: 'mouseenter'
	},
	style: {
		classes: 'evolve-bg-tertiary evolve-border evolve-shadow origin-tooltip',
		def: false
	}
};



;(function($) {
	/***** Private Methods *****/
	var origin = {
		cancel: function() {
		}
	}
	
	/**
	* AJAX posts
	**/
	var ajax = {
		init: function(dataString, callback) {
			$j.ajax({
				data: dataString,
				success: function(output) {
					callback();
				}
			});
		},
		_reload: function() {
			location.reload(true);
			//setTimeout('location.reload(true)', 700);
		},
		create: function(data) {
			var dataString		= $j.param(data) + '&task=create';
			ajax.init(dataString, function(){});
		}
	};
	
	
	
	/***** Public Methods *****/
	
	/**
	* List View functionality
	**/
	list = {
		_init: function() {
			$j('.azure-btn-no').click(function() {
				$j('#create').qtip('hide');
				return false;
			});
			
			$j('.azure-btn-yes').click(function() {
				if(evolveJS.validate($j(evolveJS.currentForm($j(this))))) {
					ajax.create($j('#create-modal').scope().origin);
				}
				return false;
			});
		
			$j('#create').qtip($j.extend(true, {}, azureModal, {
				content: {
					text: $j('#create-modal')
				},
				id: 'create-modal',
				events: {
					render: function(event, api) {
						//$j('#create-form').find('input[name="name"]').select().focus();
					},
					show: function(event, api) {
						$j('#create-form').find('input[name="name"]').select().focus();
					}
				}
			}));
		}	
	};
	
	
	
	

})(jQuery);