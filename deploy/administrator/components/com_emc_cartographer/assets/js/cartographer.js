var $j				= jQuery.noConflict();
var cartographer_id;
(function($j) {

	//var ajaxURL			= 'index.php?option=com_emc_cartographer&format=raw';
	var cartographerStyles = {
		craveonline: {
			popup_bg_hex: 		'#4579C5',
			popup_border_hex: 	'#000000',
			popup_title_hex:	'#FFFFFF',
			popup_text_hex: 	'#FFFFFF',
			popup_link_hex: 	'#FFFFFF'
		},
		momtastic: {
			popup_bg_hex: 		'#D4DEE3',
			popup_border_hex: 	'#FFFFFF',
			popup_title_hex:	'#0B386C',
			popup_text_hex: 	'#000000',
			popup_link_hex: 	'#000000'
		},
		ringtv: {
			popup_bg_hex: 		'#F4F4F4',
			popup_border_hex: 	'#F4F4F4',
			popup_title_hex:	'#870D0C',
			popup_text_hex: 	'#000000',
			popup_link_hex: 	'#870D0C'
		},
		superherohype: {
			popup_bg_hex: 		'#FFFFFF',
			popup_border_hex: 	'#FFFFFF',
			popup_title_hex:	'#0C386C',
			popup_text_hex: 	'#000000',
			popup_link_hex: 	'#0C386C'
		},
		thefashionspot: {
			popup_bg_hex: 		'#FFFFFF',
			popup_border_hex: 	'#83618D',
			popup_title_hex:	'#688F93',
			popup_text_hex: 	'#535859',
			popup_link_hex: 	'#83618D'
		},
		wrestlezone: {
			popup_bg_hex: 		'#191919',
			popup_border_hex: 	'#CCCCCC',
			popup_title_hex:	'#FFFFFF',
			popup_text_hex: 	'#FFFFFF',
			popup_link_hex: 	'#C65200'
		}
	};

	var cartographerDashboard = {
		hide: {
			event: 'click',
			fixed: true
		},
		position: {
			adjust: {
				y: -5
			},
			at: 'bottom center'
		},
		show: {
			event: 'click',
			solo: true
		},
		style: {
			classes: 'evolve-bg-secondary evolve-border evolve-shadow cartographer_options',
			//classes: 'emcCartographer_tooltip',
			def: false
 		}
	};
	
	$j.fn.qtip.defaults = $j.extend(true, {}, $j.fn.qtip.defaults, {
		position: {
			adjust: {
				method: 'shift'
			},
			at: 'bottom right',
			effect: false,
			my: 'top left'
		}
	});
	
	$j.ajaxSetup({
		type: 'post',
		url: 'index.php?option=com_emc_cartographer&format=raw'
	});
	
	cartographerMain	= {
		init: function() {
			cartographer_id		= $j('#adminForm input[name="cartographer_id"]').val();
		
			cartographerConfig.init();
			cartographerHelp.init();
			cartographerMarker.init();
			cartographerGroups.init();
		},
		ajax: function(dataString, callback) {
			$j.ajax({
				data: dataString,
				success: function() {
					callback();
				}
			});
		},
		uploader: function(path) {
			//Uploader
			$j(path).find('.evolve-ajaxFileUploader-form').each(function() {
				$j(this).fileupload({
					url: '/libraries/evolve/classes/ajaxFileUploader.php',
					add: function (e, data) {
					data.submit();
				}, done: function (e, data) {
					var dataResponse	= $j.parseJSON(data.result);
						
					$j(data.form).find('img').attr('src', '/assets/components/com_emc_cartographer/temp/'+dataResponse[0].name);
					
					switch($j(data.form).parent().attr('id')) {
						case 'marker_upload_default':	$j(data.form).closest('.ui-tooltip-content').find('input[name="icon"]').val(dataResponse[0].name);
														break;
						case 'marker_upload_hover':		$j(data.form).closest('.ui-tooltip-content').find('input[name="icon_hover"]').val(dataResponse[0].name);
														break;
					}
				}});
			});
		}
	};
	
	//Dashboard Config Options
	cartographerConfig	= {
		init: function() {
			cartographerConfig.miniColors();
			//cartographerConfig.qtip();
		
			$j('#cartographer_styles').qtip($j.extend(true, {}, cartographerDashboard, {
				content: $j('#popup_styles'),
				events: {
					render: function(event, api) {
						cartographerMain.uploader($j(api.elements.content));
					}
				},
				position: {
					my: 'top left'
				},
				style: {
					//classes: 'evolve-bg-secondary evolve-border evolve-shadow cartographer_options'
            	}
			}));
			
			$j('#cartographer_groups').qtip($j.extend(true, {}, cartographerDashboard, {
				content: $j('#popup_group'),
				position: {
					my: 'top right'
				},
				style: {
					//classes: 'evolve-bg-secondary evolve-border evolve-shadow cartographer_options'
				}
			}));
			
			$j('#cartographer_settings').qtip($j.extend(true, {}, cartographerDashboard, {
				content: $j('#popup_settings'),
				position: {
					my: 'top right'
				},
				style: {
					//classes: 'evolve-bg-secondary evolve-border evolve-shadow cartographer_options'
            	}
			}));
			
			$j('select[name="tooltip_style"]').change(function() {
				var styleObj	= cartographerStyles[$j(this).val()];
				for (var attribute in styleObj) {
					$j('input[name="'+attribute+'"]').miniColors('value', styleObj[attribute])
				}
			});
			
			$j(document).on('click', 'a[name="styles_save"], a[name="settings_save"]', function() {
				if(evolveJS.validate($j('#save_settings_form'))) {
					cartographerAjax.config_save();
					$j('#cartographer_options').qtip('hide');
				}
				return false;
			});
			
			$j(document).on('click', 'a[name="styles_cancel"], a[name="settings_cancel"], a[name="css_cancel"]', function() {
				$j('#cartographer_styles, #cartographer_settings, #save_settings_form input[name="css_modal"]').qtip('hide');
				location.reload();
				
				return false;
			});
			
			$j(document).on('click', 'a[name="css_save"]', function() {
				$j('#save_settings_form input[name="css_modal"]').qtip('hide');
				$j('#css').val($j('#cartographer_setup_css').val().replace(/\n\r?/g, ''));
				cartographerAjax.config_save();
				return false;
			});
				
			$j('#save_settings_form input[name="css_modal"]').qtip($j.extend(true, {}, cartographerDashboard, {
				content: {
					 text: $j('#css_modal'),
					 title: 'CSS Override'
				},
				position: {
					my: 'center',
				   	at: 'center',
				   	target: $j(window)
				},
			   show: {
				  modal: {
				  	blur: false,
					on: true
				  },
				  solo: false
			   },
			   style: {
				  classes: 'ui-tooltip-light ui-tooltip-shadow ui-tooltip-rounded',
				  tip: {
					corner: false
				  }
				}
			}));
		},
		miniColors: function() {
			$j('.evolve-miniColors').miniColors({
				change: function() {
					switch($j(this).attr('name')) {
						case "popup_border_hex": 	$j('#cartographer_tooltip_preview').css('border', '1px solid '+$j(this).val());
													break;
						case "popup_bg_hex":		$j('#cartographer_tooltip_preview').css('background-color', $j(this).val());
													break;
						case "popup_title_hex":		$j('#cartographer_tooltip_preview :header').css('color', $j(this).val());
													break;
						case "popup_text_hex":		$j('#cartographer_tooltip_preview').css('color', $j(this).val());
													break;
						case "popup_link_hex":		$j('#cartographer_tooltip_preview a').css('color', $j(this).val());
													break;
					}
				}
			});
		},
					
	};
	
	//Dashboard Helper
	cartographerHelp = {
		init: function() {
			
			$j('#evolve-toolbar a[name="toolbar_help"]').click(function() {
				window.open('http://'+window.location.hostname+'/administrator/components/com_emc_cartographer/assets/documentation/cartographer.pdf' ,'_blank');
			});
			
			
			$j('#evolve-toolbar a[name="toolbar_preview"]').click(function() {
				var height	= $j('#cartographer_group_'+$j('#adminForm input[name="group_id"]').val()).data('height');
				var width	= $j('#cartographer_group_'+$j('#adminForm input[name="group_id"]').val()).data('width');
				
				$j(this).qtip({
					content: {
						text: $j('<iframe frameBorder="no" scrolling="no" id="cartographer_preview" width="'+width+'px" height="'+height+'px" src="'+'http://'+window.location.hostname+'/index.php?option=com_emc_cartographer&view=display&id='+$j('#adminForm input[name="cartographer_id"]').val()+'&format=raw&cache="/>'),
						title: '<a href="http://'+window.location.hostname+'/index.php?option=com_emc_cartographer&view=display&id='+$j('#adminForm input[name="cartographer_id"]').val()+'&format=raw" target="_blank">Link</a>'
					},
					id: 'cartographer_preview',
					events: {
						hide: function(event, api) {
							api.destroy();
						}
					},
					position: {
						at: 'center',
						my: 'center',
						target: $j(window)
					},
					show: {
						modal: true,
						ready: true
					},
					hide: 'unfocus',
					style: {
						classes: 'evolve-bg-secondary',
						def: false,
						height: height+'px',
						width: width+'px'
	             	}
				});
			
				return false;
			});
			
			$j('#evolve-toolbar a[name="toolbar_exit"]').click(function() {
				$j('#adminForm').submit();
				return false;
			});
		}
	};
	
	//Dashboard Marker Options
	cartographerMarker = {
		init: function() {
			cartographerMarker.draggable();
			cartographerMarker.qtip();
			
			$j('#cartographer_add_marker').qtip($j.extend(true, {}, cartographerDashboard, {
				content: $j('#cartographer_dashboard #popup_marker').clone(),
				hide: {
					event: 'click'
				},			
				events: {
					render: function(event, api) {
						$j(api.elements.content).find('textarea#marker_text').attr('id', 'marker_text_0');
					},
					show: function(event, api) {
						cartographerMarker.create(0);
						cartographerMain.uploader($j(api.elements.content));
					}
				},
				position: {
					my: 'top center'
				},
				style: {
					classes: 'evolve-bg-secondary evolve-border evolve-shadow evolve-border cartographer_add_marker'
				}
			}));
			
			$j(document).on('change', 'select[name="tooltip_size_type"]', function() {
				$j(this).closest('#popup_marker_config').find('#tooltip_size_custom').addClass('evolve-hidden');
				
				switch($j(this).val()) {
					case 'default':		
										break;
					case 'full':
										break;
					case 'custom':	//$j(this).siblings('#tooltip_size_custom').show();
									$j(this).closest('#popup_marker_config').find('#tooltip_size_custom').removeClass('evolve-hidden');
									break;
				}
			});
			
			$j(document).on('click', '.marker_edit', function(event) {
				var id		= $j(this).parent().data('id');
				var path 	= $j('#emcCartographer_marker_'+$j(this).parent().data('id'));
				
				$j(this).qtip({
					content: $j('#cartographer_dashboard #popup_marker').clone(),
					events: {
						render: function(event, api) {
							var id				= $j(api.elements.target).parent().data('id');
							var path 			= '/assets/components/com_emc_cartographer';
							
							$j(api.elements.content).find('textarea#marker_text').attr('id', 'marker_text_'+id);
							evolveJS.formEdit($j('#emcCartographer_marker_'+id).data('content'), $j(api.elements.content).find('#popup_marker_form'));
							
							var iconDefault		= $j(api.elements.content).find('#popup_marker_form input[name="icon"]').val();
							var iconHover		= $j(api.elements.content).find('#popup_marker_form input[name="icon_hover"]').val();
							
							//image previews
							if(iconDefault.length) {
								$j(api.elements.content).find('#marker_upload_default .marker_upload_preview').attr('src', path+'/'+$j('#adminForm input[name="group_id"]').val()+'/'+iconDefault);
							}
							
							if(iconHover.length) {
								$j(api.elements.content).find('#marker_upload_hover .marker_upload_preview').attr('src', path+'/'+$j('#adminForm input[name="group_id"]').val()+'/'+iconHover);
							}
							
							$j(api.elements.content).find('#popup_marker_form').append('<input type="hidden" name="id" value="'+id+'"/>');
							
							cartographerMarker.create(id);
							cartographerMain.uploader($j(api.elements.content));
						}
					},
					hide: false,
					overwrite: false,
					position: {
						at: 'center',
						my: 'center',
						target: $j(window)
					},
					show: {
						event: event.type,
						solo: false,
						modal: {
							blur: false,
							on: true
						},
						ready: true
					},
					style: {
						classes: 'evolve-bg-secondary evolve-border evolve-shadow evolve-border cartographer_add_marker',
						def: false
					}
				});

				return false;
			});
			
			$j(document).on('click', '.marker_delete', function() {
				var id		= $j(this).parent().data('id');
				var path 	= $j('#emcCartographer_marker_'+$j(this).parent().data('id'));
			
				evolveJS.confirm('Are you sure you want to delete this marker?', function(choice){
					if(choice) {
						cartographerAjax.marker_delete(id, path);
					}
				});
				
				return false;
			});
			
			$j(document).on('click', 'a[name="popup_close"]', function() {
				$j('#cartographer_add_marker, .marker_edit, #cartographer_groups').qtip('hide');
				return false;
			});
			
			$j(document).on('click', 'a[name="marker_save"]', function() {
				var arrKeys 		= new Array();
				var currentForm		= evolveJS.currentForm($j(this));
				
				if($j(currentForm).find('input[name="icon"]').val()!='') arrKeys.push("icon");
				if($j(currentForm).find('input[name="icon_hover"]').val()!='') arrKeys.push("icon_hover");
				$j(currentForm).find('input[name="image_key"]').attr('value', arrKeys.toString());
				
				tinyMCE.triggerSave(true, true);
				
				if(evolveJS.validate($j(this))) {
					cartographerAjax.marker_save($j(this));
					$j('#cartographer_add_marker, .marker_edit').qtip('hide');
				}
				return false;
			});
		},
		create: function(id) {
			$path = "/assets/components/com_emc_cartographer/"+$j('#adminForm input[name="cartographer_id"]').val()+"/";
			tinyMCE.init({
				mode: 'exact',
				elements: 'marker_text_'+id,
				width: '300',
				height: '175',
				skin: 'cirkuit',
				plugin: 'image,media',
				remove_script_host: false,
				convert_urls: false,
				extended_valid_elements : 'object[width|height|classid|codebase],param[name|value],embed[src|type|width|height|flashvars|wmode]',

				file_browser_callback: function filebrowser(field_name, url, type, win) {
		    
				    fileBrowserURL = "/libraries/evolve/js/tiny_mce/plugins/pdw_file_browser/index.php?editor=tinymce&filter=" + type+"&uploadpath="+$path;
				      
				    tinyMCE.activeEditor.windowManager.open({
				        title: "PDW File Browser",
				        url: fileBrowserURL,
				        width: 950,
				        height: 650,
				        inline: 0,
				        maximizable: 1,
				        close_previous: 0
				      },{
				        window : win,
				        input : field_name
				      });
			  	},
				
				theme: 'advanced',
				theme_advanced_buttons1: 'formatselect,fontsizeselect,forecolor,|,bold,italic',
		        theme_advanced_buttons2: 'bullist,numlist,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,code,image',
		        theme_advanced_buttons3: '',
		        theme_advanced_buttons4: '',
		        theme_advanced_blockformats : 'h1,h2,h3,h4,h5,h6,p',
		        theme_advanced_toolbar_location: 'top',
		        theme_advanced_toolbar_align: 'left'
			});
			
				
		},
		draggable: function() {
			$j('.emcCartographer_marker').draggable({
				containment: 'parent',
				delay: 150,
				stop: function(event, ui) {
					var coordX	= Math.round(ui.position.left);
					var coordY	= Math.round(ui.position.top);
					
					$j(this).qtip('reposition');
					cartographerAjax.marker_coordinate_save($j(this).data('id'), coordX, coordY, $j('#cid').val());
				}
			
			});
		},
		qtip: function() {
			$j('.emcCartographer_marker').each(function() {
			
				$j(this).qtip($j.extend(true, {}, emcCartographerTooltip, {
					content: {
						text: $j(this).data('content').content+' ',
						title: '<div class="marker_buttons evolve-relative" data-id="'+$j(this).data('id')+'"><div class="marker_delete evolve-bg-primary evolve-border evolve-absolute" alt="Delete">delete</div><h4 class="marker_title evolve-absolute">'+$j(this).data('content').title+'</h4><div class="marker_edit evolve-bg-primary evolve-border evolve-absolute" alt="Edit">edit</div></div>'
					},
					id: 'emcCartographer_tooltip_'+$j(this).data('id'),
					position: {
						target: 'event',
						viewport: $j('#workspace_markers')
					},
					style: {
						classes: 'emcCartographer_tooltip emcCartographer_tooltip_'+$j(this).parent().data('id')
					}
				}));	
			
			});
		}
	};

	//Dashboard Group Options
	cartographerGroups = {
		init: function() {
			
			
			if($j.cookie('cartographerGroup_'+cartographer_id)) {
				$j('#adminForm input[name="group_id"]').val($j.cookie('cartographerGroup_'+cartographer_id));
			} else {
				$j.cookie('cartographerGroup_'+cartographer_id, $j('#adminForm input[name="group_id"]').val());
			}
			
			var currentId	= $j('#adminForm input[name="group_id"]').val();
			$j('#cartographer_group_'+currentId).show();
			$j('#cartographer_group_list li[data-id="'+currentId+'"]').addClass('evolve-buttons-active');
		
		
			$j(document).on('click', 'a[name="group_create"]', function() {
				cartographerAjax.group_save();
				return false;
			});
			
			$j(document).on('click', 'a[name="group_delete"]', function() {
				evolveJS.confirm('Are you sure you want to delete this group?', function(choice){
					if(choice) {
						cartographerAjax.group_delete();
					}
				});
				
				return false;
			});
		
			cartographerGroups.sortable();
			cartographerGroups.tabs();
		},
		sortable: function() {
			$j('#cartographer_group_list').sortable({
				stop: function(event, ui) {
					cartographerAjax.order_groups($j(ui.item));
				}
			});
		},
		tabs: function() {
			$j('#cartographer_group_list li').click(function() {
				$j('.cartographer_group').hide();
				$j('#'+$j(this).data('group')).show();
			
				$j.cookie('cartographerGroup_'+$j('#adminForm input[name="cartographer_id"]').val(), $j(this).data('id'));
				
				$j('#cartographer_group_list li').removeClass('evolve-buttons-active');
				$j(this).addClass('evolve-buttons-active');
				$j('#adminForm input[name="group_id"]').val($j(this).data('id'));
			});
		}
	};
	
	cartographerCreate	= {
		init: function() {
			cartographerHelp.init();
		
			$j('a[name="cartographer_create"]').click(function() {
				if(evolveJS.validate($j(this))) cartographerAjax.cartographer_save($j(this));
				return false;
			});
			
			$j('#evolve-toolbar a[name="toolbar_delete"]').click(function() {
				var id		= $j('#cartographer_list input:checkbox:checked');
				if(id.length) cartographerAjax.cartographer_delete(id);
				return false;
			});
			
			$j('.evolve-publish-status').click(function() {
				var published;
				
				switch($j(this).data('status')) {
					case 'evolve-published':	published = 0;
												break;
					case 'evolve-unpublished':	published = 1;
												break;
				}
				
				cartographerAjax.published_update($j(this).data('id'), published);
			});
		}
	};
	
	
	/**
	* Ajax calls to controller
	**/
	cartographerAjax		= {
		reload: function() {
			setTimeout('location.reload(true)', 700);
		},
		background_save: function(path) {
			var currentForm			= evolveJS.currentForm(path);
			var dataString			= $j(currentForm).serialize()+'&task=saveGroup';
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Uploaded...', 'Background image uploaded');
				cartographerAjax.reload();
			});
		},
		cartographer_delete: function(id) {
			var dataString		= id.serialize()+'&task=deleteCartographer';
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Deleted...', 'HotSpot removed');
				cartographerAjax.reload();
			});
		},
		cartographer_save: function(path) { 
			var currentForm		= evolveJS.currentForm(path);
			var dataString		= $j(currentForm).serialize()+'&task=saveCartographer';
			
			$j(currentForm).submit();
		},
		config_save: function() {
			var dataString			= $j('#save_style_form, #save_settings_form').serialize();
				dataString			+= '&task=saveConfig&id='+$j('#adminForm input[name="cartographer_id"]').val();
			
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Saved...', 'Configuration saved');
				cartographerAjax.reload();
			});
		},
		marker_coordinate_save: function(marker_id, coordX, coordY, cartographer_id) {
			var dataString		= '&task=saveCoordinates&id='+marker_id+'&coordX='+coordX+'&coordY='+coordY+'&cid='+cartographer_id;
			
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Updated...', 'Marker position updated ('+coordX+', '+coordY+')');
			});
		},
		marker_delete: function(id, marker) {
			var dataString		= '&task=deleteMarker&id='+id;
			cartographerMain.ajax(dataString, function() {
				$j(marker).remove();
				evolveJS.growl('Deleted...', 'Marker removed');
			});
		},
		marker_save: function(path) {
			var dataString		= $j(evolveJS.currentForm(path)).serialize()+'&task=saveMarker&cid='+$j('#adminForm input[name="cartographer_id"]').val()+'&gid='+$j('#adminForm input[name="group_id"]').val();
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Saved...', 'Content saved');
				cartographerAjax.reload();
			});
		},
		published_update: function(id, published) {
			var dataString		= 'task=updatePublished&id='+id+'&published='+published;
			
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Updated...', 'Publish status updated');
				cartographerAjax.reload();
			});
		},
		group_save: function() {
			var dataString			= 'task=saveGroup&cid='+$j('#adminForm input[name="cartographer_id"]').val();
				cartographerMain.ajax(dataString, function() {
					evolveJS.growl('Creating...', 'Group created');
					cartographerAjax.reload();
				});
		},
		group_delete: function() {
			var dataString			= 'task=deleteGroup&id='+$j('#adminForm input[name="group_id"]').val();
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Deleted...', 'Group removed');
				cartographerAjax.reload();
			});
		},
		order_groups: function(path) {
			var dataString		= $j(path).parent().find('input[name="ordering[]"]').serialize();
				dataString		+= '&task=saveOrdering&type=groups';
			
			cartographerMain.ajax(dataString, function() {
				evolveJS.growl('Updated...', 'Groups order saved');
				//cartographerAjax.reload();
			});
		}
	};
	

})(jQuery);