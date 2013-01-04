var $j	= jQuery.noConflict();

var orochiLayout, orochiGroup, orochiAdd, orochiPreview, orochiSetup;

(function($j) {
	orochiContent = {
		init: function() {
		
		},
		edit: function(path) {	
			var metaObj			= $j(path).data($j(path).find('input[name="ordering[]"]').val());
			var contentObj		= $j.parseJSON(metaObj['content']);
			
			var form 			= $j('#orochi_forms_edit form#orochi_content_form_'+contentObj['type']);
			
			//Tab selection
			var tabIndex		= $j('#orochi_type_pager li#add_type_'+contentObj['type']).index();
			$j('#orochi_forms_content').tabs('select', tabIndex);
			
			orochiGeneral.edit(form, metaObj, contentObj);
		}
	};
	orochiForms = {
		init: function() {
			orochiForms.colorPicker();
			orochiForms.paginatePreview();
			orochiGeneral.tiptip();
			
			//Thumbnail Previews			
			orochiLayout.preview();
			
			var configTab	= ($j.cookie('orochiWebsvcConfig_'+$j('#orochi_id').val()))? $j.cookie('orochiWebsvcConfig_'+$j('#orochi_id').val()): 0;
			
			
			//Type Selection
			$j('.orochi_type_buttons a.button').click(function() {
				var currentButton		= $j(this);
				orochiForms.type($j(this).attr('name'));
				return false;
			});	
			
			$j(document).off('click', '.orochi_uploadify_reset');
			$j(document).on('click', '.orochi_uploadify_reset', function() {
			//$j('.orochi_uploadify_reset').live('click', function() {
				//console.log('here');
				$j(this).closest('.orochi-uploadify').find('.orochi-uploadify-input input.uploadify_input').val('');
				$j(this).closest('.orochi-uploadify').find('.orochi-uploadify-preview').addClass('orochi-hidden');
				return false;
			});
					
			//Menu modal
			$j(document).off('click', 'a[name="menu_reset"]');
			$j(document).on('click', 'a[name="menu_reset"]', function() {
				orochiGeneral.resetForm($j(this));
				return false;
			});
			
			$j(document).off('click', 'a[name="menu_add"]');
			$j(document).on('click', 'a[name="menu_add"]', function() {
				if(websvcHelper.validate($j(this))) {
					orochiAjax.menu_save($j(this));
				}
				return false;
			});

			
			$j('.workspace_tab_add a.button').click(function() {
				orochiWorkspace.tabs_modal('');
				return false;
			});
			
			$j('#orochiConfig a[name="reset_config"]').click(function() {
				$j(orochiGeneral.currentForm($j(this)))[0].reset();
				$j('.orochi-preview-message').hide();
				return false;
			});
			
			$j('#orochiConfig a[name="save_config"]').click(function() {
				if(websvcHelper.validate($j(this))) orochiAjax.config_save($j(this));
				//$j('.orochi-preview-message').hide();
				return false;
			});
						
			$j('#orochiConfig').tabs({
				selected: configTab,
				show: function(event, ui) {
					$j.cookie('orochiWebsvcConfig_'+$j('#orochi_id').val(), ui.index)
				}
			});
			
			$j('#orochiConfig input[name="cssModal"]').focus(function() {
				$j.colorbox({
					href: '#orochiSetup_css',
					inline: true,
					onCleanup: function() {
						$j('#orochiSetup_css').val($j('#orochiSetup_css').val().replace(/\n\r?/g, ''));
					},
					transition: 'none'
				});	
			});
			
			//$j('textarea.elastic').elastic();
		},
		colorPicker: function() {
			$j('.colorPicker').miniColors({
				change: function() {
					if($j(this).hasClass('orochi-preview-live')) {
						var selectorJSON	= $j.parseJSON($j(this).siblings('.orochi-preview-selector').html());
						$j('#orochi_workspace').find(selectorJSON.className).css(selectorJSON.type, $j(this).val());
						$j(this).siblings('.orochi-preview-message').show();
					}
				}
			});
		},
		dialog: function(msg, task, id) {
			$j('#orochi_forms_confirm #forms_confirm_message').html(msg);
			$j('#orochi_forms_confirm input[name="deleteType"]').val(task);
			$j('#orochi_forms_confirm input[name="id"]').val(id);
		
			$j('#orochi_forms_confirm a[name="forms_confirm_no"]').click(function() {
				$j.fn.colorbox.close();
				return false;
			});
			
			$j('#orochi_forms_confirm a[name="forms_confirm_yes"]').click(function() {
				orochiAjax.remove($j(this));
				orochiRefresh.workspace();
				return false;
			});
		
			$j.colorbox({
				href: '#orochi_forms_confirm',
				inline: true,
				onClosed: function() {
					//orochiRefresh.workspace();
				},
				onLoad: function() {
				
				},
				transition: 'none'
			});
		},
		edit: function(path) {
			var metaObj			= $j.parseJSON($j(path).siblings('.orochi_menu_meta').html());
			var contentObj		= $j.parseJSON(metaObj['content']);
			var form 			= $j('form#orochi_setup_menu');			
			
			orochiGeneral.edit(form, metaObj, contentObj);
		},
		paginatePreview: function() {
			var defaultValue	= $j('.orochi-slider-opacity').siblings('input.orochi-slider-value').val();
			
			$j('.orochi-slider-opacity').slider({
				change: function(event, ui) {
					$j('div#orochi_workspace').find('div.emcOrochi_group_pager').css('background-color', websvcHelper.convertHex($j('input[name="pagination_bg_hex"]').val(), ui.value/100));
				},
				min: 0,
				max: 100,
				range: 'min',
				slide: function(event, ui) {
					$j(this).siblings('input.orochi-slider-value').val(ui.value);
				},
				start: function() {
					$j(this).siblings('label.orochi-preview-message').show();
				},
				value: defaultValue
			});
			
			$j('input.orochi-slider-value').change(function() {
				$j('.orochi-slider-opacity').slider('value', $j(this).val());
			});
						
			$j('input[name="pagination_bg_hex"]').miniColors({
				change: function() {
					$j('#orochi_workspace').find('div.emcOrochi_group_pager').css('background-color', websvcHelper.convertHex($j(this).val(), $j('input[name="pagination_bg_opacity"]').val()/100));
					$j(this).siblings('.orochi-preview-message').show();
				}
			});

		},
		type: function(type) {
			$j('#orochi').addClass('orochi-half');
			$j('#orochi_workspace').addClass('orochi-workspace-half');
		
			$j('.orochi_type_buttons a.button').removeClass('active');
			$j('.orochi_type_buttons a.button[name="'+type+'"]').addClass('active');
		
			$j.cookie('orochiWebsvcType_'+$j('#orochi_id').val(), type);
			
			switch(type) {
			
				case 'orochi_type_250': 	$j('#orochi_workspace_250_wrapper').show();
											$j('#orochi_workspace_600_wrapper').hide();
											break;
											
				case 'orochi_type_600': 	$j('#orochi_workspace_250_wrapper').hide();
											$j('#orochi_workspace_600_wrapper').show();
											break;
											
				case 'orochi_type_both': 	$j('#orochi_workspace_250_wrapper').show();
											$j('#orochi_workspace_600_wrapper').show();
											$j('#orochi').removeClass('orochi-half');
											$j('#orochi_workspace').removeClass('orochi-workspace-half');
											break;
			}
		}
	};
	orochiModal = {
		_rowColors: function() {
			$j('#orochi_forms_groups_content .orochi_group_item').each(function(i) {
				var row 	= Boolean(i%2)? 'orochi-bg-secondary': 'orochi-bg-tertiary';
				
				$j(this).removeClass('orochi-bg-secondary orochi-bg-tertiary');
				$j(this).addClass(row);
			});
		},
		init: function() {
			orochiModal.form();
			orochiModal.group();
		},
		form: function() {
			$j('#orochi_forms_content').tabs('destroy');
			$j('#orochi_forms_content').tabs();
			
			orochiGeneral.upload('orochi_forms_content');
			
			$j('form[name="orochi_content_form"] a[name="form_reset"]').click(function() {
				orochiGeneral.resetForms();
				return false;
			});
			
			$j('form[name="orochi_content_form"] a[name="form_add"]').click(function() {
				if(websvcHelper.validate($j(this))) orochiAjax.content_save($j(this));
				return false;
			});
			
/*
			$j('form[name="orochi_content_form"] textarea[name="videoURL"]').change(function() {
				var videoCode = $j('form[name="orochi_content_form"] textarea[name="videoURL"]').val();
				var videoURL = $j(videoCode).find('embed').attr('src');
				$j('form[name="orochi_content_form"] input[name="sbFeed"]').attr('value',videoURL);
			});
*/
			
			$j('form[name="orochi_content_form"] input.inputCheck').change(function() {
				if($j(this).attr('checked')) {
						$j(this).next('.check').attr('value','true');
				}
				else {
						$j(this).next('.check').attr('value','false');
				}
			});
			
			$j('form[name="orochi_content_form"] select[name="template"]').change(function() {
				var embed = $j('form[name="orochi_content_form"] select[name="template"]').val();
				//embed =  $j.base64.encode(embed);
				switch(embed) {
					case 'poll': $j('form[name="orochi_content_form"] textarea[name="embed"]').load('/components/com_orochi/assets/orochi/helper/poll_tmpl.php');
										break;
					case 'chatterbox':	$j('form[name="orochi_content_form"] textarea[name="embed"]').load('/components/com_orochi/assets/orochi/helper/cb_tmpl.php');
												break;
					default: $j('form[name="orochi_content_form"] textarea[name="embed"]').html('');
				}
				
				//$j('form[name="orochi_content_form"] textarea[name="embed"]').html('hola');
				
			});
			
			$j('form[name="orochi_content_form"] textarea[name="embed"]').change(function() {
				//var embedValue = $j.base64.encode($j('form[name="orochi_content_form"] textarea[name="embed"]').text());
				var embedValue = $j('form[name="orochi_content_form"] textarea[name="embed"]').text();
				$j('form[name="orochi_content_form"] input[name="embed_code"]').attr('value',embedValue);
			});
			
		},
		group: function() {
			$j('#orochi_forms_groups_content').sortable('destroy');
			$j('#orochi_forms_groups_content .jspPane').sortable({
				//handle: '.orochi_group_item_handle',
				update: function(event, ui) {
					orochiAjax.order_content($j(ui.item).parent());
					orochiModal._rowColors();
				}
			});
			
			$j('#orochi_forms_groups_content .orochi_group_item_config .orochi_group_item_delete').click(function() {
				$j(this).closest('.orochi_group_item').remove();
				orochiAjax.remove($j(this));	
				return false;
			});
			
			$j('#orochi_forms_groups_content .orochi_group_item_config .icon_edit, #orochi_forms_groups_content .orochi_group_item_edit').click(function() {
				orochiContent.edit($j(this).closest('.orochi_group_item'));
				return false;
			});
		},
		load: function(path) {
			var gid			= $j(path).closest('.orochi_workspace_group').find('input[name="ordering[]"]').val();
			var mid			= $j(path).closest('.workspace_unit_wrapper').find('.orochi_workspace_menu li.ui-tabs-selected input[name="ordering[]"]').val();
			
			$j('#orochi_forms_content').empty();
			$j('#orochi_forms_groups_list').empty();
			$j('#orochi_forms_groups_content').empty();
			orochiRefresh.form();
			orochiRefresh.content(mid, gid);
		}
	};
	orochiWorkspace = {
		init: function() {
			//Cleanups
			$j.fn.colorbox.close();
			
			//Cookie to remember type state
			var cookieValue		= ($j.cookie('orochiWebsvcType_'+$j('#orochi_id').val()))? $j.cookie('orochiWebsvcType_'+$j('#orochi_id').val()): 'orochi_type_250';
			var orochiWebsvcWorkspace250		= ($j.cookie('orochiWebsvcWorkspace250_'+$j('#orochi_id').val()))? parseInt($j.cookie('orochiWebsvcWorkspace250_'+$j('#orochi_id').val())): 0;
			var orochiWebsvcWorkspace600		= ($j.cookie('orochiWebsvcWorkspace600_'+$j('#orochi_id').val()))? parseInt($j.cookie('orochiWebsvcWorkspace600_'+$j('#orochi_id').val())): 0;
			
			//Reinits
			orochiForms.type(cookieValue);
			orochiGeneral.tiptip();
			orochiWorkspace.tabs(orochiWebsvcWorkspace250, orochiWebsvcWorkspace600);
			orochiWorkspace.sortable();
			orochiWorkspace.load();
			orochiWorkspace.resizable();
			
			//Live Workspace
			emcOrochiTemplate._scrollable();
			
			//Functionality
			$j('.orochi_trafficking').click(function() {
				$j(this).focus().select();
			});
			
			$j('.orochi_workspace_menu .icon_edit').click(function() {
				var menuId			= $j(this).siblings('input[name="ordering[]"]').val();
				orochiWorkspace.tabs_modal(menuId);
				return false;
			});
			
			$j('.orochi_workspace_menu .icon_delete').click(function() {
				var mid			= $j(this).siblings('input[name="ordering[]"]').val();
				orochiForms.dialog('Delete Menu? All content in the corresponding Syndi unit will also be deleted.', 'deleteMenu', mid);
				return false;
			});
			
			$j('.workspace_group_add').click(function() {
				orochiAjax.group_create($j(this));
				return false;
			});
				
			$j('.workspace_group_edit').click(function() {
				var groupEdit		= $j(this);
				//orochiWorkspace.tabs_modal(groupEdit);
				$j.colorbox({
					href: '#orochi_forms_edit',
					inline: true,
					onClosed: function() {
						orochiRefresh.workspace();
						$j('#orochi_forms_groups_content.orochi-scrollable').jScrollPane().data().jsp.destroy();
					},
					onLoad: function() {
						orochiModal.load(groupEdit);
					},
					transition: 'none'
				});	

				return false;
			});
			
			$j('.workspace_group_delete').click(function() {
				var gid			= $j(this).closest('.orochi_workspace_group').find('input[name="ordering[]"]').val();
				orochiForms.dialog('Delete Group? Corresponding group on the other Syndi unit and content will also be deleted.', 'deleteGroup', gid);		
				return false;
			});
		},
		load: function() {
			$j('.emcOrochi_group .emcOrochi_cycle').each(function() {
				//console.log();
				//var gid 	= $j(this).closest('.orochi_workspace_group').find('input[name="ordering[]"]').val();
				var cid		= $j(this).find('input[name="cid"]').val();
				$j(this).html(emcOrochiTypes.load($j(this).data(cid), cid));
				
				//var gid 	= $j(this).closest('.orochi_workspace_group').find('input[name="ordering[]"]').val();
				//var id		= $j(this).find('input[name="cid"]').val();
				//if(groupObj[id].length) $j(this).html(emcOrochiTypes.load($j.parseJSON(groupObj[id]), gid));
				
				
				
				
				
				//var contentJSON		= $j.parseJSON($j(this).find('.orochi-hidden').html());
				//var id 				= $j(this).closest('.orochi_workspace_group').find('input[name="ordering[]"]').val();
				
				//if(contentJSON) $j(this).html(emcOrochiTypes.load(contentJSON, gid));
			});
		},
		resizable: function() {
			$j('#workspace_unit_wrapper_600 .orochi_workspace_group').resizable({
				handles: 'se',
				helper: 'ui-resizable-helper orochi-border',
				maxHeight: 517,
				maxWidth: 300,
				minHeight: 169,
				minWidth: 300,
				stop: function(event, ui) {
					$j(ui.element).attr('style', '');
				
					var newHeight		= ui.size.height;
					var originalHeight	= ui.originalSize.height;
					var type 			= (newHeight > originalHeight)? 'increase': 'decrease';
					//var currentSize		= $j(ui.element).find('input[name="size"]').val();
										
					if(newHeight > 0 && newHeight <= 169) {
						//var resizeSize	= 1;
						orochiWorkspace.size(ui, 1, type);
					} else if(newHeight >= 169 && newHeight <= 343) {
						//var resizeSize	= 2;
						orochiWorkspace.size(ui, 2, type);
					} else if (newHeight >= 343 && newHeight <= 517) {					
						//var resizeSize	= 3;
						orochiWorkspace.size(ui, 3, type);
					}
				}
			});
		},
		size: function(ui, resizeSize, type) {
			var totalSize		= 0;
			var maxSize			= 3;
			var currentSize		= parseInt($j(ui.element).find('input[name="size"]').val());
			
			if(type == 'increase') {
				$j(ui.element).closest('.orochi_workspace_page').children('.orochi_workspace_group').each(function() {
					totalSize	+= parseInt($j(this).find('input[name="size"]').val());
				});
				
				var availableSize	= maxSize - totalSize;
				var newSize			= (resizeSize <= availableSize)? resizeSize: currentSize + availableSize;
			} else {
				var newSize			= resizeSize;
			}
				$j(ui.element).find('input[name="size"]').val(newSize);
				$j(ui.element).removeClass('emcOrochi_group_size_1 emcOrochi_group_size_2 emcOrochi_group_size_3');
				$j(ui.element).addClass('emcOrochi_group_size_'+newSize);
				orochiAjax.group_size($j(ui.element).closest('.orochi_workspace_group'));
			
				$j(ui.element).find('.workspace_group_size').html($j(ui.element).css('height'));
			//var totalSize		= 0;
			//var maxSize			= 3;
			//var minSize			= 1;
			
			//var currentSize		= parseInt($j(ui.element).find('input[name="size"]').val());
			
			
/*
			
			if(type == 'increase') {
				$j(ui.element).closest('.orochi_workspace_page').children('.orochi_workspace_group').each(function() {
					totalSize	+= parseInt($j(this).find('input[name="size"]').val());
				});

				if(totalSize < maxSize) {
					currentSize	+= 1;
				}
			} else if(type == 'decrease') {
				if(currentSize > minSize) {
					currentSize -= 1;
				}
			}
			
*/
/*
			$j(ui.element).find('input[name="size"]').val(currentSize);
			$j(ui.element).removeClass('emcOrochi_group_size_1 emcOrochi_group_size_2 emcOrochi_group_size_3');
			$j(ui.element).addClass('emcOrochi_group_size_'+currentSize);
			orochiAjax.group_size($j(ui.element).closest('.orochi_workspace_group'));
*/
		},
		sortable: function() {
			$j('#workspace_unit_wrapper_600 .orochi_workspace_page').sortable({
				forcePlaceholderSize: true,
				//handle: ':not(.workspace_group_config)',
				items: 'div.orochi_workspace_group:not(.orochi_placeholder)',
				placeholder: 'orochi-border-dashed orochi-bg-tertiary orochi_group_placeholder_active',
				update: function(event, ui) {
					orochiAjax.order_groups($j(ui.item));
				}
			});
		},
		tabs: function(orochiWebsvcWorkspace250, orochiWebsvcWorkspace600) {
			$j('.orochi_tabs').tabs('destroy');
			$j('.orochi_tabs').tabs({
				create: function(event, ui) {
					switch($j(this).attr('id')) {
						case "workspace_unit_wrapper_250":	$j(this).tabs('option', 'selected', orochiWebsvcWorkspace250);
															break;
						case "workspace_unit_wrapper_600":	$j(this).tabs('option', 'selected', orochiWebsvcWorkspace600);
															break;
					}
				},
				select: function(event, ui) {
			        var url = $j.data(ui.tab, 'load.tabs');
			        if( url) {
			            window.open(url, '_blank');
			            return false;
			        }
			        return true;
			    },
			    show: function(event, ui) {
			    	switch($j(this).attr('id')) {
			    		case "workspace_unit_wrapper_250":	$j.cookie('orochiWebsvcWorkspace250_'+$j('#orochi_id').val(), ui.index);
			    											break;
			    		case "workspace_unit_wrapper_600":	$j.cookie('orochiWebsvcWorkspace600_'+$j('#orochi_id').val(), ui.index);
			    											break;
			    	}
			    				    	
			    	currentTabId = ui.index;
			    	//_gaq.push(['_trackEvent', '[Syndi] '+cfgObj.title+'-'+cfgObj.id+' [300x'+orochiType+']', '[Tab] '+ui.tab.text]);
			    	
			    	//Show current tab's iframe (if any)
			    	$j(ui.panel).find('.emcOrochi_iframe').each(function() {
			    		emcOrochi._iframeFunc($j(this), 'show');
			    	});
			    	
			    	//Hide all others
			    	$j(ui.panel).siblings('.emcOrochi_page').find('.emcOrochi_iframe').each(function() {
			    		emcOrochi._iframeFunc($j(this), 'hide');
			    	});
			    	
			    }
			}).find('.orochi_workspace_menu').sortable({
				//handle: '.menu_handle',
				items: 'li.unit_menu_item',
				update: function(event, ui) {
					orochiAjax.order_tabs($j(ui.item).parent());
				}
			});
		},
		tabs_modal: function(menuId) {
			$j.colorbox({
				href: '#orochi_forms_menu',
				inline: true,
				onCleanup: function() {
					//orochiRefresh.menu(menuId);
				},
				onComplete: function() {
				},
				onLoad: function() {
					orochiRefresh.menu(menuId);
				},
				transition: 'none'
			});	
		},
		tabs_modal_auto: function() {
			$j.colorbox({
				escKey: false,
				href: '#orochi_forms_menu',
				inline: true,
				onCleanup: function() {
					//orochiRefresh.menu(menuId);
				},
				onComplete: function() {
					//orochiRefresh.menu(menuId);
					//orochiGeneral.upload('orochi_setup_menu');
					//Thumbnail Previews			
				},
				onLoad: function() {
					orochiRefresh.menu();
					$j('#cboxClose').remove();
				},
				overlayClose: false,
				transition: 'none'
			});	
		}
	};
	/****************/
	orochiLayout = {
		init: function(gid) {
			orochiForms.init();
			orochiWorkspace.init();
			
/*
			$j('.orochi_uploadify_reset').click(function() {
				orochiAjax.resetImage($j(this));
				return false;
			});
*/
			
			//Hide scrollbars on modal open
			$j(document).bind('cbox_open', function(){
				$j('body').css({overflow:'hidden'});
			}).bind('cbox_closed', function(){
				$j('body').css({overflow:'auto'});
			
			}); 
			
			
			/*
$j('input[name="form_preview"]').click(function() {
				var form = $j($(this)).closest('form');
				var currentType		= $j(form).find('*[name="type"]').val()

				orochiPreview.init(form, currentType, true);
				
				return false;
			});
*/
			
		},
		preview: function() {
			$j('.orochi_tiptip_preview').click(function() {
				return false;
			});
						
			$j('.orochi_tiptip_preview').tipTip({
				activation: 'hover',
				content: function(e) {
					return '<img class="orochi-preview" src="'+$j(this).closest('.orochi-uploadify').find('input.uploadify_input').val()+'"/>';
				},
				defaultPosition: 'right',
				delay: 0
			});		
		}
	};
	/*
orochiPreview = {
		init: function(formObj, formType, showModal) {
			$j(formObj).find('#preview_wrapper').html(orochiPreview._content(formType, formObj));
			
			if(showModal) {
				$j.colorbox({
					inline:true, 
					href: $j(formObj).find('#preview_wrapper'),
				});
			}
		},
		_content: function(type, formObj, showModal) {
			switch(type) {
				case 'facebook': 	return orochiPreview._facebook(formObj);
									break;
				case 'poll': 	return orochiPreview._poll(formObj);
									break;
				case 'twitter': 	return orochiPreview._twitter(formObj);
									break;
			}
		},
		_facebook: function(formObj) {
			var feedURL 		= $j(formObj).find('#facebook_feed_url').val();
			var header 			= $j(formObj).find('#facebook_header').val();
			var colorscheme		= $j(formObj).find('#colorscheme').val();
			var facebook 		= '';
			
			facebook		+= '<iframe src="http://www.facebook.com/plugins/activity.php?site='+feedURL+'&amp;width=300&amp;height=169&amp;header='+header+'&amp;colorscheme='+colorscheme+'&amp;font&amp;border_color&amp;recommendations=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:169px;" allowTransparency="true"></iframe>';

			return facebook;
		},
		_poll: function(formObj) {
			var textareaVal		= $j(formObj).find('textarea').val();
			var src 					= $j(textareaVal).attr('src');
			var polldaddyID 		= src.substring(src.lastIndexOf("/")+1, src.lastIndexOf("."));
			
			$j(formObj).find('input[name="polldaddy_key"]').val(polldaddyID);
			$j(formObj).find('input[name="polldaddy_feed"]').val(src);
			
			var polldaddy 		= '';
			
			polldaddy		+= '<iframe src="/components/com_orochi/assets/orochi/helper/poll.php?poll_id='+polldaddyID+'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:169px;" allowTransparency="true"></iframe>';
			
			return polldaddy;
		
		},
		_twitter: function(formObj) {
			var username 		= $j(formObj).find('#username').val();
			var tweets				= $j(formObj).find('#tweets').val();
			var avatar 			= $j(formObj).find('input[name="avatar"]').val();
			var timestamp		= $j(formObj).find('input[name="twitter_timestamp"]').val();
			var hashtag			= $j(formObj).find('input[name="hashtag"]').val();
			var twitter 			= '';
			
			twitter		+= '<iframe src="/components/com_orochi/assets/orochi/helper/twitter.php?username='+username+'&tweets='+tweets+'&avatar='+avatar+'&timestamp='+timestamp+'&hashtag='+hashtag+'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:169px;" allowTransparency="true"></iframe>';
			
			return twitter;
		}
	};
*/
	
})(jQuery);