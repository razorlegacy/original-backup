var origin_id,
	schedule_id,
	content_state;


$j.ajaxSetup({
	type: 'post',
	url: 'index.php?option=com_emc_origin&format=raw'
});


var qtipModal = {
	events: {
		hide: function(event, api) {
			api.destroy();
		}
	},
	hide: false,
	position: {
		at:		'center',
		my:		'center',
		target: $j(window)
	},
	show: {
		modal: {
			blur: false,
			on: true
		},
		ready:	true
	},
	style: {
		classes: 'evolve-bg-secondary evolve-border evolve-shadow origin-tooltip-modal',
		def: false
	}
},
qtipTooltip = {
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

(function($j) {	
	originMain	= {
		init: function() {
			originCreate.embed();
		
			origin_id		= $j('#adminForm input[name="origin_id"]').val();
			schedule_id 	= $j.jStorage.get('schedule_id_'+origin_id);
			content_state	= $j.jStorage.get('content_state_'+origin_id);
			
			if(!schedule_id) {
				schedule_id	= $j('[id^="origin_schedule_"]:first').data('id')
				$j.jStorage.set('schedule_id_'+origin_id, schedule_id);
			}
			
			if(!content_state) {
				$j.jStorage.set('content_state_'+origin_id, 'default');
				content_state = 'default';
			}
			
			originButtons.init();
			originTemplate.init();
			originToolbar.init();
			
			$j(document).on('click', 'a[name="origin_cancel"]', function() {
				$j('.qtip.ui-tooltip').qtip('hide');
				return false;
			});
			
			$j(document).on('click', 'a[name="origin_config_save"]', function() {
				if(evolveJS.validate($j(evolveJS.currentForm($j(this))))) {
					originAjax.config_save(this);
				}
				return false;
			});
			
			$j(document).on('click', 'a[name="schedule_save"]', function() {
				if(evolveJS.validate($j(evolveJS.currentForm($j(this))))) {
					originAjax.schedule_save(this);
				}
				return false;
			});
			
			$j(document).on('click', 'a[name="schedule_duplicate"]', function() {
				if(evolveJS.validate($j(evolveJS.currentForm($j(this))))) {
					originAjax.duplicate(this);
				}
				return false;
			});
			
			$j(document).on('click', 'a[name="origin_content_update"]', function() {
				originAjax.content_update(this);
				return false;
			});
			
			$j(document).on('click', 'a[name="origin_content_delete"]', function() {
				var selector		= $j(this);
				evolveJS.confirm('Are you sure you want to delete?', function(choice){
					if(choice) originAjax.genericDelete(selector, 'contentDelete');
				});
				return false;
			});
			
			$j(document).on('click', 'a[name="schedule_delete"]', function() {
				var selector		= $j(this);
				evolveJS.confirm('Are you sure you want to delete?', function(choice){
					if(choice) originAjax.genericDelete(selector, 'scheduleDelete');
				});
				return false;
			});
		},
		calendar: function(selector, editSelector, editSelectorType) {
			var current_step	= 'start_date',
				maxDate,
				minDate;
			
			//If editing, pull in defaults from selector
			if(editSelector) {
				if($j(editSelector).data('startdate') == 'N/A' || editSelectorType == 'calendarDuplicate') {
					minDate		= 0;
				} else {
					minDate		= $j(editSelector).data('startdate');
					$j(selector).find('input[name="start_date"]').val(minDate);
				}
				
				if($j(editSelector).data('enddate') == 'N/A' || editSelectorType == 'calendarDuplicate') {
					maxDate		= null;
				} else {
					maxDate		= $j(editSelector).data('enddate');
					$j(selector).find('input[name="end_date"]').val(maxDate);
				}
			
				if(editSelectorType != 'calendarDuplicate') {
					$j(selector).find('.evolve-buttons-delete').removeClass('evolve-hidden');
				} else {
					$j(selector).find('a[name="schedule_save"]').hide();
					$j(selector).find('.evolve-buttons-duplicate').removeClass('evolve-hidden');
				}
				
				$j(selector).find('input[name="id"]').val($j(editSelector).data('id'));
			} else {
				maxDate		= null;
				minDate		= 0;
			}
			
			$j(selector).find('input[name="start_date"], input[name="end_date"]').click(function() {
				current_step	= 'start_date';
				evolveCalendar.datepicker('option', {minDate: 0, maxDate: null}).datepicker('setDate', 0);
				return false;
			});
			
			var evolveCalendar 	= $j(selector).find('.evolve-calendar').datepicker({
				dateFormat:		'm/d/yy',
				minDate:		minDate,
				maxDate:		maxDate,
				numberOfMonths:	2,
				onSelect: function(dateText, inst) {
					switch(current_step) {
						case 'end_date':
							current_step	= null;
							$j(selector).find('input[name="end_date"]').val(dateText);
							evolveCalendar.datepicker('option', {maxDate: dateText});
							break;
						
						case 'start_date':
							current_step	= 'end_date';
							start_date		= new Date(dateText);
							$j(selector).find('input[name="start_date"]').val(dateText);
							evolveCalendar.datepicker('option', {minDate: dateText});
							break;
						default:
							break;
					}
				}
			});
		},
		edit: function(qtipSelector, eventSelector) {
			var editObj			= new Object();
				editObj.id		= $j(eventSelector).data('id');
				editObj.oid		= origin_id;
				editObj.sid		= schedule_id;
				
			evolveJS.formEdit(jQuery.extend($j(eventSelector).data('content'), editObj), $j(qtipSelector).find('form[name="form_submit"]'));
			originMain.uploader(qtipSelector);
		},
		link: function() {
			if($j('.origin-tooltip-modal').find('select[name="content"]').length) {
				$j('.origin-tooltip-modal').find('select[name="content"]').change(function() {
					if($j(this).val() != 'link') {
						$j(this).parent().siblings('li').addClass('evolve-hidden');
						//$j(this).parent().siblings('li').find('input[name="link"]').val('');
					} else {
						$j(this).parent().siblings('li').removeClass('evolve-hidden');
					}
				});
			}
		},
		miniColors: function(selector) {
			$j(selector).find('.evolve-miniColors').miniColors({
				change: function() {
					var previewSelector		= '.'+$j(this).data('preview'),
						previewAttribute	= $j(this).data('attribute');
						
						$j(previewSelector).attr('style', previewAttribute+':'+$j(this).val());
				}
			});
		},
		modal: function(selector, type, renderFunc) {
		
			$j(selector).qtip($j.extend(true, {}, qtipModal, {
				content: {
					text: 	$j('#origin_modal_'+type).clone()
				},
				events: {
					render: function(event, api) {
						var qtipSelector		= $j(api.elements.content);
						switch(renderFunc) {
							case 'calendar':
								originMain.calendar(qtipSelector);
								break;
							case 'calendarEdit':
							case 'calendarDuplicate':
								originMain.calendar(qtipSelector, selector, renderFunc);
								break;
							case 'edit':
								originMain.edit(qtipSelector, selector);
								break;
							case 'settings':
								originMain.uploader(qtipSelector);
								$j(qtipSelector).find('.evolve-miniColors').miniColors();
								//originMain.edit(qtipSelector, selector);
								break;
						}
					}
				}
			}));
		},
		uploader: function(selector) {
			//Uploader
			$j(selector).find('.evolve-ajaxFileUploader-form').each(function() {
				$j(this).fileupload({
					url: '/libraries/evolve/classes/ajaxFileUploader.php',
					dataType: 'json',
					add: function (e, data) {
					data.submit();
				}, done: function (e, data) {
					var dataResponse	= data.result[0];
						tempDir			= $j(this).find('input[name="uploadDir"]').val();
						responseForm	= $j(this).data('form'),
						responseInput	= $j(this).data('input');
						
						$j(this).siblings('form[name="'+responseForm+'"]').find('input[name="'+responseInput+'"]').val(dataResponse.name);
						
						$j(this).find('.origin_upload_preview').attr('src', tempDir+dataResponse.name);
				}});
			});
		},
		tiny_mce: function(selector) {
			var path = "/assets/components/com_emc_origin/"+origin_id+"/";
			
			tinyMCE.init({
				mode: 'exact',
				elements: selector,
				skin: 'cirkuit',
				plugin: 'image,media',
				remove_script_host: false,
				convert_urls: false,
				extended_valid_elements : 'object[width|height|classid|codebase],param[name|value],embed[src|type|width|height|flashvars|wmode]',

				file_browser_callback: function filebrowser(field_name, url, type, win) {
		    
				    fileBrowserURL = "/libraries/evolve/js/tiny_mce/plugins/pdw_file_browser/index.php?editor=tinymce&filter=" + type+"&uploadpath="+path;
				      
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
		}
	};
	
	/**
	*
	**/
	originCreate	= {
		init: function() {
			//originCreate.embed();
			
			$j('a[name="origin_create"]').click(function() {
				if(evolveJS.validate($j(this))) originAjax.origin_save($j(this));
				return false;
			});
			
			$j('#evolve-toolbar a[name="toolbar_delete"]').click(function() {
				var id		= $j('#origin_list input:checkbox:checked');
				if(id.length) {
					evolveJS.confirm('Are you sure you want to delete?', function(choice){
						if(choice) originAjax.origin_delete(id);
					});
				}
				
				return false;
			});
			
			$j('#evolve-toolbar a[name="toolbar_help"]').click(function() {
				window.open('http://'+window.location.hostname+'/administrator/components/com_emc_origin/assets/help/OriginHelp.pdf' ,'_blank');
			});
			
			$j('#evolve-toolbar a[name="toolbar_duplicate"]').click(function() {
				var id		= $j('#origin_list input:checkbox:checked');
				if(id.length) {
					originAjax.duplicate_origin(id[0].value);
				}
				
				return false;
			});
		},
		embed: function() {
			
			$j('.origin_list_embed').click(function() {
				$j(this).qtip($j.extend(true, {}, qtipModal, {
					content: {
						text: 	$j('#origin_list_embed_modal').clone()
					},
					events: {
						hide: function(event, api) {
							api.destroy();
						},
						show: function(event, api) {
							var qtipSelector		= $j(api.elements.content),
								parentSelector		= $j(api.elements.target);
								//configObj			= $j.parseJSON(decodeURIComponent($j(parentSelector).closest('td').data('config')));
							
							/*
$j(qtipSelector).find('input[name="id"]').val(configObj.id);
							$j(qtipSelector).find('input[name="configURL"]').val(configObj.configURL);
							$j(qtipSelector).find('input[name="bgHex"]').val(configObj.bgHex);
							$j(qtipSelector).find('a#origin_list_embed_preview').attr('href', configObj.preview);
*/
							generateEmbed($j(qtipSelector).find('form'));
						}
					},
					show: {
						event: 'mousedown',
						ready: true
					},
				}));
				
				return false;
			});
			
			$j(document).on('keyup', '#origin_list_embed_modal input[type="text"]', function() {
				generateEmbed($j(this));
			});
			
			$j(document).on('click', 'a[name="origin_list_embed_email"]', function() {
				originAjax.email(this);
				return false;
			});
			
			//$j(document).on('click', 'a[name="origin_list_embed_generate"]', function() {
			function generateEmbed(form) {
				var embedForm	= $j(form).closest('form'),
					id			= $j(embedForm).find('input[name="id"]').val();
					configURL	= $j(embedForm).find('input[name="configURL"]').val(),
					auto		= $j(embedForm).find('input[name="auto"]').val(),
					close		= $j(embedForm).find('input[name="close"]').val(),
					hover		= $j(embedForm).find('input[name="hover"]').val(),
					bgHex		= $j(embedForm).find('input[name="bgHex"]').val(),
					clickThru	= new Array();
				for(var i = 0; i < 5; i++) {
					clickThru[i] = ($j(embedForm).find('input[name="clickthru'+(i+1)+'"]').val())? $j(embedForm).find('input[name="clickthru'+(i+1)+'"]').val(): '/';
					//clickThru[i] = ($j(embedForm).find('input[name="clickthru'+(i+1)+'"]').val())? $j(embedForm).find('input[name="clickthru'+(i+1)+'"]').val(): 'http://www.google.com/?q=click-thru-'+(i+1);
				}
				
				var params		= "{'emcOriginDomain': '"+document.domain+"', 'bgHex':'"+bgHex+"','auto':'"+auto+"','close':'"+close+"','hover':'"+hover+"','clickthru1':'"+clickThru[0]+"','clickthru2':'"+clickThru[1]+"','clickthru3':'"+clickThru[2]+"','clickthru4':'"+clickThru[3]+"','clickthru5':'"+clickThru[4]+"'}",
					preview 	= configURL+"&view=preview&cache="+new Date().getTime()+"&params="+encodeURIComponent(params);
				
				var embedCode	= "<script type='text/javascript'>(function(){function d(a){top===self?emcOriginCreate.init(e,emcOriginParams"+id+",a):(a='http://'+document.referrer.split('/')[2]+'/',window.name=encodeURIComponent(JSON.stringify(emcOriginParams"+id+")),window.location=a+'emcOriginIframe/emcOriginIframe.html?'+encodeURIComponent(e))}var a=document.createElement('script'),b=document.getElementsByTagName('script')[document.getElementsByTagName('script').length-1],e='"+configURL+"';a.src='http://"+document.domain+"/components/com_emc_origin/assets/js/emcOrigin.min.js';a.id='emcOriginScript';window.emcOriginFlag='undefined'===typeof window.emcOriginFlag?!0:!1;emcOriginParams"+id+"="+params+";if('undefined'!=typeof emcOriginParamsOverride)for(var c in emcOriginParamsOverride)emcOriginParamsOverride[c]&&(emcOriginParams"+id+"[c]=emcOriginParamsOverride[c]);window.emcOriginFlag&&b.parentNode.insertBefore(a,b);a.addEventListener?document.getElementById('emcOriginScript').addEventListener('load',function(){d(b)},!1):a.readyState&&(a.onreadystatechange=function(){'loaded'===a.readyState&&d(b)})})();</script>";				

				$j('.origin-tooltip-modal #origin_list_embed_code').val(embedCode);
				$j('.origin-tooltip-modal #origin_list_embed_preview').attr('href', preview).show();
				$j(embedForm).find('input[name="previewLink"]').val(preview);
				
			//	return false;
			//});
			}
			
			$j(document).on('change', 'input[type="checkbox"]', function() {
				if($j(this).is(':checked')) {
					$j(this).siblings('span').removeClass('list_embed_disabled').find('input').prop('disabled', false);
				} else {
					var defaultValue	= $j(this).siblings('span').find('input').data('default');
					$j(this).siblings('span').addClass('list_embed_disabled').find('input').prop('disabled', true).val(defaultValue);
				}
			});
						
			$j(document).on('click', 'input[type="text"], textarea', function() {
				$j(this).focus().select();
				return false;
			});
			
			$j(document).on('click', 'a[name="origin_cancel"]', function() {
				$j('.qtip.ui-tooltip').qtip('hide');
				return false;
			});	
		},
		embedGenerate: function() {
			
			
		}
	};
	
	
	/**
	* Origin Buttons
	**/
	var originButtons = {
		init: function() {
			originButtons.schedule();
			originButtons.settings();
			originButtons.toolpad();
			originButtons.workspace();
		},
		schedule: function() {
			//Setup
			$j('#origin_schedule a[name="origin_schedule_'+schedule_id+'"]').addClass('origin_schedule_tab_active')
			$j('#origin_schedule_'+schedule_id).removeClass('evolve-hidden');
			
			//Button Event
			$j('.origin_schedule_tab').click(function() {
				var currentSchedule		= $j(this).attr('name');
				
				//Schedule button
				$j('.origin_schedule_tab').removeClass('origin_schedule_tab_active');
				$j(this).addClass('origin_schedule_tab_active');
				
				//Switch viewable
				$j('[id^="origin_schedule_"]').addClass('evolve-hidden');
				$j('#'+currentSchedule).removeClass('evolve-hidden');
				
				//Set global schedule ID
				schedule_id				= $j('#'+currentSchedule).data('id');
				$j.jStorage.set('schedule_id_'+origin_id, schedule_id);
				originButtons.workspace();
				
				return false;
			});
			
			$j('.origin_schedule_tab').bind('contextmenu', function(event){
				var type 		= (!$j(this).data('startdate'))? '#scheduleMenuDefault': '#scheduleMenu';
				originContextMenu.init(type, $j(this), event);
				
				return false; 
			});
				
			$j('.origin_schedule_create').click(function() {
				originMain.modal($j(this), 'calendar', 'calendar');
				return false;
			})
			.qtip($j.extend(true, {}, qtipTooltip, {
				content: {
					text: 'Add new schedule'
				}
			}));
		},
		settings: function() {
			//Setup
			$j('#toolpad_options .origin_view_'+content_state).addClass('origin_view_active');
			
			//Button Event
			$j('.origin_toolpad_view .origin_toolpad_icon').click(function() {		
			
				$j('#toolpad_options .origin_toolpad_icon').removeClass('origin_view_active');
				$j(this).addClass('origin_view_active');
				
				content_state	= $j(this).data('type');
				$j.jStorage.set('content_state_'+origin_id, content_state);
				
				originButtons.workspace();
				return false;
			})
			.qtip($j.extend(true, {}, qtipTooltip, {
				content: {
					text: 'Switch between workspace views'
				}
			}));
			
			$j('.origin_button_settings')
			.click(function() {
				originMain.modal($j(this), 'settings', 'settings');
				return false;
			})
			.qtip($j.extend(true, {}, qtipTooltip, {
				content: {
					text: 'Set global options'
				}
			}));
		},
		toolpad: function() {
			$j('#origin_toolpad_left .origin_toolpad_draggable')
			.mousedown(function() {
				$j(this).addClass('evolve-ios-shake');
				return false;
			})
			.draggable({
				cursor:		'move',
				cursorAt:	{top: 24, left: 24},
				helper: 	'clone',
				start: function(event, ui) {
					$j(this).removeClass('evolve-ios-shake');
					$j(ui.helper).addClass('evolve-ios-shake');
				}
			})
			.mouseup(function() {
				$j(this).removeClass('evolve-ios-shake');
				return false;
			})
			.qtip($j.extend(true, {}, qtipTooltip, {
				content: {
					text: 'Drag and drop icon to add to workspace'
				}
			}));
		},
		workspace: function() {
			//Setup
			$j('[id^="origin_schedule_"] [class^="workspace_"]').addClass('evolve-hidden');
			$j('#origin_schedule_'+schedule_id+' .workspace_'+content_state).removeClass('evolve-hidden');
		}
	};
	
	/**
	* Context Menu
	**/
	var originContextMenu = {
		init: function(type, selector, event) {
			$j(selector).qtip({
				content: $j(type).clone(),
				events: {
					hide: function(event, api) {
						api.destroy();
					},
					show: function(event, api) {
						//tooltip selector
						var qtipSelector		= $j(api.elements.content),
							parentSelector		= $j(api.elements.target),
							type 				= $j(parentSelector).data('type');
						
						//Marker Menu
						$j(qtipSelector).find('a[name="marker_edit"]').click(function() {
							originMain.modal($j(parentSelector), type, 'edit');
							return false;
						});
						
						$j(qtipSelector).find('a[name="marker_front"]').click(function() {
							var zIndex		= originTemplate.zIndex($j(parentSelector).closest('.origin_template'), 'max') + 1;
							$j(parentSelector).css('zIndex', zIndex);
							originTemplate.contentConfig(parentSelector);
							return false;
						});
						
						$j(qtipSelector).find('a[name="marker_back"]').click(function(event) {
							var zIndex		= originTemplate.zIndex($j(parentSelector).closest('.origin_template'), 'min') - 1;
							$j(parentSelector).css('zIndex', zIndex);
							originTemplate.contentConfig(parentSelector);
							return false;
						});
						
						$j(qtipSelector).find('a[name="marker_delete"]').click(function() {
							evolveJS.confirm('Are you sure you want to delete?', function(choice){
								if(choice) originAjax.genericDelete(parentSelector, 'contentDelete');
							});
							return false;
						});
						
						//Schedule Menu
						$j(qtipSelector).find('a[name="schedule_edit"]').click(function() {
							originMain.modal($j(parentSelector), 'calendar', 'calendarEdit');
							return false;
						});
						
						$j(qtipSelector).find('a[name="schedule_copy"]').click(function() {
							originMain.modal($j(parentSelector), 'calendar', 'calendarDuplicate');
							return false;
						});
						
						$j(qtipSelector).find('a[name="schedule_delete"]').click(function() {
							evolveJS.confirm('Are you sure you want to delete?', function(choice){
								if(choice) originAjax.genericDelete(parentSelector, 'scheduleDelete');
							});
							return false;
						});
						
						//Close qtip when clicked
						$j(qtipSelector).find('a').click(function() {
							$j('.qtip.ui-tooltip').qtip('hide');
							return false;
						});
						
						if(event.originalEvent.button !== 2) {
							// IE might throw an error calling preventDefault(), so use a try/catch block.
							try { event.preventDefault(); } catch(e) {}
						}
					}
				},
				hide: {
					event: 'unfocus mouseout'
				},
				position: {
					target: 'mouse',
					adjust: { 
						mouse: false
					}
				},
				show: {
					event: 'mousedown',
					ready: true
				},
				style: {
					def: false,
					classes: 'evolve-contextMenu evolve-bg-secondary evolve-border',
					tip: false
				}
			}, event);
		}
	};
		
	/**
	* Template
	**/
	var originTemplate = {
		init: function() {
			$j('.origin_workspace .origin_toolpad_icon')
			.draggable({
				containment:	'#origin_workspace_wrapper',
				delay:			150,
				start: function(event, ui) {
					$j(ui.helper).css({opacity: .5});
				},
				stop: function(event, ui) {
					$j(ui.helper).css({opacity: 1});
					originTemplate.contentConfig(ui.helper);
				}
			})
			.resizable({
				handles:		'ne, se, sw, nw',
				minHeight:		20,
				minWidth:		20,
				stop: function(event, ui) {
					originTemplate.contentConfig(ui.helper);
				}
			})
			.bind('contextmenu', function(event){ 
				originContextMenu.init('#markerMenu', $j(this), event);
				return false; 
			});
			
			$j('.origin_workspace .origin_toolpad_icon.origin_toolpad_disable').resizable('option', 'disabled', true);
			
			$j('.origin_template').droppable({
				accept: '#origin_toolpad_left .origin_toolpad_draggable',
				drop: function(event, ui) {
				
					var configObj			= new Object();
						configObj.coordX	= Math.floor(event.pageX - $j(this).offset().left - 24);
						configObj.coordY	= Math.floor(event.pageY - $j(this).offset().top - 24);
						configObj.width		= 50;
						configObj.height	= 50;
						configObj.type		= $j(ui.draggable).data('type');
						
					$j(event.target).append($j(ui.draggable).find('.origin_toolpad_icon').clone().addClass('evolve-absolute origin-new').offset({top: configObj.coordY, left: configObj.coordX}));
					
					originAjax.content_create(configObj);
				},
				out: function(event, ui) {
					$j(ui.helper).addClass('evolve-ios-shake').removeClass('evolve-ios-folder');
					$j(event.target).removeClass('evolve-shadow');
				},
				over: function(event, ui) {
					$j(ui.helper).removeClass('evolve-ios-shake').addClass('evolve-ios-folder');
					$j(event.target).addClass('evolve-shadow');
				}
			});
		},
		contentConfig: function(selector) {
			var configObj			= new Object();
				configObj.coordX	= Math.floor($j(selector).position().left);
				configObj.coordY	= Math.floor($j(selector).position().top);
				configObj.width		= $j(selector).width();
				configObj.height	= $j(selector).height();
				configObj.id		= $j(selector).data('id');
				configObj.type 		= $j(selector).data('type');
				configObj.zIndex	= $j(selector).css('zIndex');
				
			originAjax.contentConfig(configObj);
		},
		zIndex: function(selector, type) {
			var zIndexArray		= new Array();
			
			$j(selector).find('.origin_toolpad_icon').each(function() {
				zIndexArray.push(parseInt($j(this).css('zIndex'), 10));
			});
			
			switch(type) {
				case 'max':
					return Math.max.apply(Math, zIndexArray);
					break;
				case 'min':
					return Math.min.apply(Math, zIndexArray);
					break;
			}
		}
	};
	
	/**
	* Toolbar
	**/
	var originToolbar	= {
		init: function() {
			//Functionality
			/*
$j('input[name="origin_url"]').click(function() {
				$j(this).focus().select();
			});
*/
		
/*
			$j('#evolve-toolbar a[name="toolbar_link"]').click(function() {
				$j(this).qtip({
					content: {
						text: $j('#origin_toolbar_link')
					},
					events: {
						render: function(event, api) {
							originToolbar.link($j(api.elements.content));
						}
					},
					hide: {
						event: 'unfocus'	
					},
					position: {
						at: 	'bottom left',
						my: 	'top right'
					},
					show: {
						event: 'click',
						ready: true
					},
					style: {
						classes: 'evolve-bg-primary evolve-border evolve-shadow',
						def: false
					}						
				});
				return false;
			});
*/

			$j('#evolve-toolbar a[name="toolbar_help"]').click(function() {
				window.open('http://'+window.location.hostname+'/administrator/components/com_emc_origin/assets/help/OriginHelp.pdf' ,'_blank');
			});
			
			$j('#evolve-toolbar a[name="toolbar_exit"]').click(function() {
				$j('#adminForm').submit();
				return false;
			});
		}/*
,
		link: function(selector) {
			var newUrl;
			
			$j('#origin_toolbar_link select[name="trigger"]').change(function() {
				if($j(this).val() == 'hoverIntent') {
					$j(this).siblings('input[name="hoverIntentTimer"]').prop('disabled', false);
				} else {
					$j(this).siblings('input[name="hoverIntentTimer"]').prop('disabled', true).val('');
				}
				
				//Call combiner
			});
			
			$j('#origin_toolbar_link :input').change(function() {
				newUrl		= $j('#origin_toolbar_link input[name="baseUrl"]').val()+'&'+$j('#origin_toolbar_link form :input[value!=""]').not(':checkbox').serialize();

				console.log(newUrl);
				
				
				
				
				
				
				
				$j('#origin_toolbar_link input[name="origin_url"]').val(newUrl);
			});
		}
*/
	};
	
	/**
	* Ajax calls to controller
	**/
	var originAjax		= {
		init: function(dataString, callback) {
			$j.ajax({
				data: dataString,
				success: function(output) {
					callback();
				}
			});
		},
		reload: function() {
			location.reload(true);
			//setTimeout('location.reload(true)', 700);
		},
		config_save: function(form) {
			var currentForm		= evolveJS.currentForm(form),
				dataString		= $j(currentForm).serialize()+'&task=configSave';
				
			originAjax.init(dataString, function() {
				//evolveJS.growl('Updated', 'Content positioning updated');
				originAjax.reload();
			});
		},
		contentConfig: function(configObj) {
			var dataString		= '&task=saveContentConfig&oid='+origin_id+'&'+$j.param(configObj);
			originAjax.init(dataString, function() {
				evolveJS.growl('Updated', 'Content positioning updated');
			});
		},
		content_create: function(configObj) {
			var dataString		= '&task=createContent&oid='+origin_id+'&sid='+schedule_id+'&state='+content_state+'&'+$j.param(configObj);
			
			$j.ajax({
				data: dataString,
				success: function(output) {
					var selector	= $j('.origin-new');
					evolveJS.growl('Created', 'New item created');
					$j(selector).data('id', $j.trim(output)).data('type', configObj.type).removeClass('origin-new');
					originMain.modal($j(selector), configObj.type, 'edit');
					originTemplate.init();
				}
			});
		},
		content_delete: function(form) {
			var dataString		= '&task=contentDelete';

			if($j(evolveJS.currentForm(form)).length) {
				dataString		+= '&id='+$j(evolveJS.currentForm(form)).find('input[name="id"]').val();
			} else {
				dataString		+= '&id='+$j(form).data('id');
			}
						
			originAjax.init(dataString, function() {
				originAjax.reload();
			});
		},
		content_update: function(form) {
			var currentForm		= evolveJS.currentForm(form),
				dataString		= $j(currentForm).serialize()+'&task=contentSave';
			
			originAjax.init(dataString, function() {
				originAjax.reload();
			});
		},
		duplicate: function(form) {
			var dataString		= '&task=cloneSchedule&oid='+origin_id+'&'+$j(evolveJS.currentForm(form)).serialize();
			
			originAjax.init(dataString, function() {
				originAjax.reload();
			});
		
		},
		email: function(form) {
			var dataString		= '&task=email&'+$j(evolveJS.currentForm(form)).serialize();
			originAjax.init(dataString, function() {
				$j('.qtip.ui-tooltip').qtip('hide');
				evolveJS.growl('Sent', 'Embed code emailed');
			});
		},
		genericDelete: function(form, task) {
			var dataString		= '&task='+task;
			
			if(task == 'scheduleDelete') $j.jStorage.deleteKey('schedule_id_'+origin_id);
			
			if($j(evolveJS.currentForm(form)).length) {
				dataString		+= '&id='+$j(evolveJS.currentForm(form)).find('input[name="id"]').val();
			} else {
				dataString		+= '&id='+$j(form).data('id');
			}
			
			originAjax.init(dataString, function() {
				originAjax.reload();
			});
		},
		origin_delete: function(id) {
			var dataString		= id.serialize()+'&task=deleteOrigin';
			originAjax.init(dataString, function() {
				evolveJS.growl('Deleted...', 'Origin removed');
				originAjax.reload();
			});
		},
		origin_save: function(path) { 
			var currentForm		= evolveJS.currentForm(path);
			var dataString		= $j(currentForm).serialize()+'&task=saveOrigin';
			
			$j(currentForm).submit();
		},
		schedule_save: function(path) {
			var currentForm		= evolveJS.currentForm(path),
				dataString		= $j(currentForm).serialize()+'&oid='+origin_id+'&task=scheduleSave';
				originAjax.init(dataString, function() {
					//evolveJS.growl('Updated', 'Background updated');
					originAjax.reload();
				});
		},
		duplicate_origin: function(origin_id) {
			var dataString		= '&task=cloneOrigin&oid='+origin_id;
			originAjax.init(dataString, function() {
				originAjax.reload();
			});
		}
	};
	

})(jQuery);