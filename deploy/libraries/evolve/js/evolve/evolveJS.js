evolveJS	= {
		
		alias: function(string) {
			string		= string.replace(/ /g, "-").toLowerCase();
			return string;
		},
		currentForm: function(path) {
			var form = $j(path).closest('form');
			return form;
		},
		confirm: function(question, callback) {
		
			var message	= $j('<p/>', {text: question});
			
			var confirm = $j('<a/>', {
					'class': 'evolve-ui-button evolve-bg-primary',
					click: function() {
						callback(true);
						return false;
					},
					html: '<span class="evolve-ui-icon evolve-ui-icon44"></span><span class="evolve-ui-label">Confirm</span></a>',
					href: '#',
					id: 'evolve-dialog-confirm'
				});
				
			var cancel = $j('<a/>', {
					'class': 'evolve-ui-button evolve-bg-primary',
					click: function() {
						callback(false);
						return false;
					},
					html: '<span class="evolve-ui-icon evolve-ui-icon56"></span><span class="evolve-ui-label">Cancel</span>',
					href: '#',
					id: 'evolve-dialog-cancel'
				});
		
			$j(document.body).qtip({
				content: {
					text: message.add(cancel).add(confirm),
					title: 'Confirmation Required'
				},
				events: {
					hide: function(event, api) {
						api.destroy();
					},
					render: function(event, api) {
						$j('.evolve-ui-button', api.elements.content).click(api.hide);
					}
				},
				id: 'evolve-dialog',
				position: {
					at: 'center',
					my: 'center',
					target: $j(window)
				},
				show: {
					modal: {
						blur: false,
						on: true
					},
					ready: true
				},
				hide: false,
				style: {
					classes: 'evolve-dialog evolve-bg-secondary evolve-border',
					def: false
             	}
			});
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
		formEdit: function(contentObj, form) {
			$j.each(contentObj, function(i, item) {
				
				$j(form).find('*[name="'+i+'"]').val(item).change();
				
			});
		},
		growl: function(title, text) {
			var target	= $j('#evolve-growl');
		
			$j(document.body).qtip({
				content: {
					text: text,
					title: {
						text: title,
						button: true
					}
				},
				position: {
					adjust: {
						x: -15,
						y: 15
					},
					at: 'top right',
					my: 'top right',
					target: $j(window)
				},
				show: {
					event: false,
					ready: true,
					effect: function() {
						$j(this).stop(0,1).fadeIn(400);
					},
					delay: 0,
					persistent: false,
					solo: target
				},
				hide: {
					event: false,
					effect: function(api) {
						$j(this).stop(0,1).fadeOut(400).queue(function() {
							api.destroy();							
						});
					}
				},
				style: {
					classes: 'ui-tooltip-rounded evolve-growl evolve-border evolve-shadow',
					def: false,
					tip: false
				},
				events: {
					render: function(event, api) {
						var api			= $j(this).data('qtip');
						var lifespan	= 3500;
						
						clearTimeout(api.timer);
						if(event.type !== 'mouseover') {
							api.timer	= setTimeout(api.hide, lifespan);
						}
					}
				}
			}).removeData('qtip');
		},
		validate: function(path) {
			var currentForm 	= evolveJS.currentForm(path);
			var requiredFlag	= true;
			
				$j(currentForm).find('input.evolve-required').each(function() {
					if(!$j(this).val()) {
						requiredFlag = false;
						$j(this).focus().qtip({
							content: {
								text: 'Required'
							},
							position: {
								at: 'bottom center'
							},
							hide: {
								event: 'unfocus'
							},
							show: {
								event: 'click',
								ready: true
							},
							style: {
								classes: 'evolve-tooltip-validate',
								def: false
							}
						});
						
						$j(this).blur(function() {
							$j(this).qtip('hide');
						});
						
					}
				});
				
				return requiredFlag;
		},
		tooltip: function() {
			$j('.evolve-tooltip').qtip({
				content: {
					attr: 'alt'
				},
				style: {
					classes: 'ui-tooltip-dark ui-tooltip-rounded'
				}
			});
		}/*
,
		inputValidation: function(path) {
					
			if($j(path).find('input.required').val()) {
				return true
			} else {
				websvcHelper.message('Missing item field(s)', 'error');
				return false;
			}
		}
*/
};