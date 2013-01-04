var $j	= jQuery.noConflict();

var syndiGeneral, syndiCreate, syndiTabs, ajaxURL, syndiForm, syndiUpload, syndiConfig;

(function($j) {

	ajaxURL			= 'index.php?option=com_syndi&format=raw';
	uploadifyBtn	= '/administrator/components/com_syndi/assets/images/btn_upload.png';
	
	syndiGeneral	= {
		
		alias: function(string) {
			string		= string.replace(/ /g, "-").toLowerCase();
			return string;
		},
		message: function(message, messageType) {
			var messageOut;
			
			//Clear old message
			$j('#system-message').remove();
			
			messageOut		= "";
			messageOut		+= "<dl id='system-message'>";
			messageOut			+= "<dt class='message'>Message</dt>";
			messageOut			+= "<dd class='"+messageType+" message fade'>";
			messageOut				+= "<ul>";
			messageOut					+= "<li>"+message+"</li>";
			messageOut				+= "</ul>";
			messageOut			+= "</dd>";
			messageOut		+= "</dl>";
			
			$j(messageOut).insertBefore('#element-box');
						
			setTimeout(function() { 
				$j('#system-message').fadeOut('slow'); 
			}, 2000);		
		},
		currentForm: function(path) {
			var form = $j(path).closest('form');
			return form;
		},
		resetForm: function(path) {
			var form 	= syndiGeneral.currentForm(path);
			$j(form)[0].reset();
			syndiGeneral.resetImage(form);
		},
		resetImage: function(path) {
			//Reset image
			var form 				= path;
			var placeholderImage	= $j(form).find('#syndi_tab_left .image_preview, #syndi_tab_left .liveImagePreview, #tab_image_preview').attr('rel');
			$j(form).find('#syndi_tab_left .image_preview, #syndi_tab_left .liveImagePreview, #tab_image_preview').attr('src', placeholderImage);
			$j(form).find('#syndi_tab_left, #image').attr('value', '');
			$j(form).find('#syndi_tab_left, #id').attr('value', '');
			$j(form).find('#tab_bg').attr('value', '');
			$j(form).find('#preview_wrapper').empty();
		},
		inputValidation: function(path) {			
			if($j(path).find('input.required').val()) {
				return true
			} else {
				syndiGeneral.message('Missing item field(s)', 'error');
				return false;
			}
		},
		upload: function() {	
			$j('input[id^="image_upload"]').each(function() {
				var formPath			= syndiGeneral.currentForm($j(this));
				var folderPath			= '/assets/components/com_syndi/'+$j(formPath).find('#sid').val()+'/'+$j(formPath).find('#tab_id').val();
				
				$j(this).uploadify({
					'folder'		: folderPath,
					'auto'			: true,
					'buttonText'	: 'Upload',
					'buttonImg'		: uploadifyBtn,
					'onComplete'	: function(event, ID, fileObj, response, data) {
						$j(formPath).find('#syndi_tab_left .image_preview').attr('src', fileObj.filePath);
						$j(formPath).find('input#image').val(fileObj.filePath);
					}
				});
			});
		},
		rebind: function() {
			syndiForm.init();
			syndiList.init();
			syndiGeneral.upload();
			syndiGeneral.collapse();
			syndiGeneral.refreshPreview();
		},
		currentTab: function() {
			return '#'+$j('.ui-state-active').attr('title');
		},
		refreshPreview: function() {
			var timestamp	= new Date();
			$j('#syndi_iframe').attr('src', $j('#syndi_iframe').attr('title')+'&cache='+timestamp.getTime());
		},
		collapse: function() {
			$j('.collapse span').hide();
			
			$j('.collapse label').collapser({
				target: 'next',
				effect: 'slide',
				expandHtml: 'Content <small>[click to expand]</small>',
				collapseHtml: 'Content <small>[click to expand]</small>'
			},
			function(){
				$j('.collapse span').slideUp();
			});
		},
		urlParam: function(url, param) {
			var results = new RegExp('[\\?&]'+param+'=([^&#]*)').exec(url);
			if(!results) {
				return 0;
			} else {
				return results[1] || 0;
			}
		}
	};
	
	syndiCreate	= {
		init: function() {
			$j('a.editSyndi').click(function() {
				syndiCreate.modal($j(this).attr('href'));
				return false;
			});
			
			$j('a.colorbox').click(function() {
				$j.colorbox({href: $j(this).attr('href'), width: '360px', height: '310px', iframe: true});
				return false;
			});
		},
		modal: function(link) {
			$j.colorbox({href: link, width: '50%', height: '50%'});	
		},		
		edit: function(link) {
			var link 	= 'index.php?option=com_syndi&task=createSyndi&format=raw';
			$j.colorbox({href: link, width: '50%', height: '50%'});	
		},
		form: function() {
			
			$j('input[name="syndi_add"]').click(function() {
				var form 	= syndiGeneral.currentForm($(this));
				if(syndiGeneral.inputValidation(form)) {
					$j(form).submit();
				}
			}).button();
			
			var folderPath			= '/assets/components/com_syndi/temp';
			
			$j('input[id="image_upload"]').uploadify({
				'folder'		: folderPath,
				'auto'			: true,
				'buttonText'	: 'Upload',
				'buttonImg'		: uploadifyBtn,
				'onComplete'	: function(event, ID, fileObj, response, data) {
					$j('#syndi_tab_right .image_preview').attr('src', response);
					$j('input#syndi_bg').val(response);
				}
			});
			
		}
	};
	
	syndiConfig = {
		init: function() {
			$j('#syndi_config').accordion({
				fillSpace: true
			});
			
			$j('#syndi_preview_tab').tabs();
/*
			
			$j('#syndi_iframe').load(function() {
				syndiConfig.outline();
			});
*/
			
			$j('#save_config').click(function() {
				var dataString		= syndiGeneral.currentForm($j(this)).serialize();
					dataString		+= '&task=updateSyndiConfig';

				$j.ajax({
					url: ajaxURL,
					data: dataString,
					type: 'post',
					success: function() {
						syndiGeneral.message('Config Updated', '');
						syndiGeneral.refreshPreview();
						$j('#syndi_preview_tab').tabs({selected: 0});
					}
				});
			});
			
			$j('#syndi_preview_refresh').click(function() {
				syndiGeneral.refreshPreview();
				return false;
			});
			
			$j('.colorPicker').miniColors();
		},
		outline: function() {
		
			$j('#syndi_config input.preview_outline').focus(function() {
				var syndiIframe			= $j('#syndi_iframe').contents();
				var syndiSelector		= $j(this).attr('title');
				var syndiSelectorWidth	= $j(syndiIframe).find('#'+syndiSelector).width();
				var syndiSelectorHeight	= $j(syndiIframe).find('#'+syndiSelector).height();
				var syndiSelectorX		= $j(syndiIframe).find('#'+syndiSelector).position().left;
				var syndiSelectorY		= $j(syndiIframe).find('#'+syndiSelector).position().top;
				
				$j('#syndi_preview_selector').html('<div class="selector_outline" style="width: '+syndiSelectorWidth+'px; height: '+syndiSelectorHeight+'px; left: '+syndiSelectorX+'px; right: '+syndiSelectorY+'px"></div>').addClass('preview_top').removeClass('preview_bottom');
				$j('#syndi_iframe').addClass('preview_bottom').removeClass('preview_top');
				
			}).blur(function() {
				$j('#syndi_iframe').addClass('preview_top').removeClass('preview_bottom');
				$j('#syndi_preview_selector').empty().addClass('preview_bottom').removeClass('preview_top');
			});
		}
	};
	syndiForm	= {
		init: function() {
			$j('input:button').button();
			
			$j('input[name="form_add"]').click(function() {
				var form	= syndiGeneral.currentForm($(this));
				if(syndiGeneral.inputValidation(form)) {
					syndiForm.save(this);
				}
			});
			
			$j('input[name="form_reset"]').click(function() {
				syndiGeneral.resetForm(this);
			});
			
			$j('input[name="image_upload_clear"]').click(function() {
				var parentDiv = $j(this).parent();
				var placeholderImage 		= parentDiv.find('#tab_image_preview').attr('rel');				
				parentDiv.find('#tab_image_preview').attr('src', placeholderImage);
				parentDiv.find('#tab_bg').attr('value', '');
			});
			
			$j('.livePreviewInput').keyup(function() {
				var form 		= syndiGeneral.currentForm($j(this));
				var typeTab		= $j(form).find('input[name="typetab"]').val();
				syndiPreview.init(form, typeTab, false);
			});
			
/*
			$j('.videoParams').change(function() {
				var form 		= syndiGeneral.currentForm($j(this));
				var typeTab		= $j(form).find('input[name="typetab"]').val();
				syndiPreview.init(form, typeTab, false);
			});
*/
			
			$j('input.headerCheck').change(function() {
				var form	= syndiGeneral.currentForm($(this));
				
				if($j('input.headerCheck').attr('checked')) {
						$j(form).find('input[name="header"]').attr('value','true');
				}
				else {
						$j(form).find('input[name="header"]').attr('value','false');
				}
				
			});
			
			$j('input.check').change(function() { 
				var form	= syndiGeneral.currentForm($(this));
				var element = $(this).id;
				
				if($j('input#'+element).attr('checked')) {
						$j(form).find('input[name='+element+']').attr('value','true');
				}
				else {
						$j(form).find('input[name='+element+']').attr('value','false');
				}
			});
			
			
			$j('input[name="form_preview"]').click(function() {
				var form	= syndiGeneral.currentForm($(this));
				var currentType		= $j(form).find('*[name="typetab"]').val()

				syndiPreview.init(form, currentType, true);
				
				return false;
			});
						
			$j('#save_social').click(function() {
				var dataString		= syndiGeneral.currentForm($j(this)).serialize();
					dataString		+= '&task=saveSocialForm';
				var currentTab		= syndiGeneral.currentTab();

				$j.ajax({
					url: ajaxURL,
					data: dataString,
					type: 'post',
					success: function() {
						syndiGeneral.message('Form Updated', '');
						syndiTabs.loadTabs(currentTab);
					}
				});
			});
			
		},
		save: function(path) {
			var form 				= syndiGeneral.currentForm(path);
			var dataString		= $j(form).serialize();
			var currentTab		= syndiGeneral.currentTab();

			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					syndiGeneral.message('Form Updated');
					syndiTabs.loadTabs(currentTab);
				}
			});
		},
/*
		refreshList: function(tabId) {
			jQuery.ajax({
				url: 'index.php?option=com_syndi&format=raw',		
				data: '&task=loadList&typetab=poll&tab_id='+tabId,
				type: 'post',
				success: function(output) {
					$j('.syndi_list').html(output);
				}
			});
		},
*/
		edit: function(path) {
			var listItem		= $j(path).parent();
			var dataString		= $j(listItem).find('div[name="syndi_data_list_serialize"]').html();
			var dataObj			= $j.parseJSON(dataString);
			
			syndiForm.editForm(path, dataObj);
		},
		
		editForm: function(path, dataObj) {			
			var form			= syndiGeneral.currentForm(path);

			$j.each(dataObj, function(i, item) {
				$j(form).find('*[name="'+i+'"]').val(item);
				if(i == 'image' || i == 'screenURL') {
					if(item!="") {
						$j(form).find('#syndi_tab_left img.image_preview, #syndi_tab_left img.liveImagePreview').attr('src', item);
					}
					else {
						var placeholderImage	= $j(form).find('#syndi_tab_left .image_preview, #syndi_tab_left .liveImagePreview').attr('rel');
						$j(form).find('#syndi_tab_left img.image_preview, #syndi_tab_left img.liveImagePreview').attr('src', placeholderImage);
					}
				}
				
				if(i == 'header') { 
					switch($j(form).find('#header').attr('value')) {
						case 'true':	$j('input.headerCheck').attr('checked', 'checked');
											break;
						default:		$j('input.headerCheck').removeAttr('checked');
											
					}
				}
				
				if(i == 'avatar' || i == 'twitter_timestamp' || i == 'hashtag') {
					switch($j(form).find('input[name='+i+']').attr('value')) {
						case 'true':	$j('input#'+i).attr('checked', 'checked');
											break;
						default:		$j('input#'+i).removeAttr('checked');
											
					}
				}
				
			});
			$j('textarea').elastic();
			
		},
		deleteForm: function(dataObj, listItem) {
			
			var listVars		= $j(listItem).parent();
			var listVarsTypeTab	= $j(listVars).find('input[name="typetab"]').val();
			var listVarsTabId	= $j(listVars).find('input[name="tab_id"]').val();
			
			var dataString		= '&task=deleteGeneric&id='+dataObj[listVarsTypeTab+'_id']+'&typetab='+listVarsTypeTab+'&tab_id='+listVarsTabId;
			var currentTab		= syndiGeneral.currentTab();
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					syndiGeneral.message('Delete complete', '');
					syndiTabs.loadTabs(currentTab);
				}
			});
		}
		
	};
	
	syndiTabs	= {
		init: function() {		
			syndiTabs.refreshTabs();
		},
		refreshTabs: function() {
			//$j('body, #tabs :not(li.ui-state-edit)').unbind('click');
			$j('.accordion').accordion();
			$j('#tabs').tabs('destroy');
			$j('#tabs').tabs();
						
			$j('#syndi_tabs').sortable({
				update: function() {
					syndiTabs.saveTabsOrder();
					syndiGeneral.refreshPreview();
				},
				items: 'li:not(.ui-state-stationary)',
				axis: 'x'
			});

			$j('.ui-tab-delete').click(function() {
				syndiTabs.deleteTab(this);
				return false;
			});
			
			$j('.ui-tab-edit').click(function() {
				syndiTabs.editTab(this);
				return false;
			});
			
			$j('#new_tab').click(function() {
				if(syndiGeneral.inputValidation(syndiGeneral.currentForm($(this)))) {
					syndiTabs.addTab();
				}
			});
			
			$j('input[name="tab_bg_add"]').click(function() {
				var formPath			= syndiGeneral.currentForm($j(this));
				var dataString			= '&task=updateTab&update_task=updateTab&sid='+$j(formPath).find('#sid').val()+'&tab_id='+$j(formPath).find('#tab_id').val()+'&tab_bg='+$j(formPath).find('#tab_bg').val();
				//console.log(dataString);
				
				syndiTabs.saveTab(dataString, 'Tab BG Updated');
				
/*
				$j.ajax({
					url: ajaxURL,
					data: dataString,
					type: 'post',
					success: function(output) {
						
					}
				});
*/
				
			});
			
			
			$j('input[name="tab_bg_upload"]').each(function() {
				var formPath			= syndiGeneral.currentForm($j(this));
				var folderPath			= '/assets/components/com_syndi/'+syndiGeneral.currentForm($j(this)).find('#sid').val();
				
				$j(this).uploadify({
					'folder'		: folderPath,
					'auto'			: true,
					'buttonText'	: 'Upload',
					'buttonImg'		: uploadifyBtn,
					'onComplete'	: function(event, ID, fileObj, response, data) {
						$j(formPath).find('#tab_image_preview').attr('src', fileObj.filePath);
						$j(formPath).find('#tab_bg').val(fileObj.filePath);
					}
				});
					
			});
/*
			var folderPath			= '/assets/components/com_syndi/'+$j('#adminForm').find('#sid').val();
			$j('input#tab_bg_upload').uploadify({
				'folder'		: folderPath,
				'auto'			: true,
				'buttonText'	: 'Upload',
				'buttonImg'		: uploadifyBtn,
				'onComplete'	: function(event, ID, fileObj, response, data) {
					$j('#tab_image_preview').attr('src', fileObj.filePath);
					//$j(formPath).find('#syndi_tab_left .image_preview').attr('src', fileObj.filePath);
					$j('#adminForm #tab_bg').val(fileObj.filePath);
				}
			});
*/
			
			
			
			$j('textarea.elastic').elastic();
			
			
			syndiGeneral.rebind();
		},
		deleteTab: function(path) {
			$j(path).fastConfirm({
				position: "right",
				questionText: "Confirm tab deletion",
				onProceed: function() {
					var dataString	= '&task=updateTab&update_task=deleteTab&sid='+$j('#adminForm').find('input#sid').val()+'&tab_id='+$j('.ui-tabs-selected a').attr('rel')+'&typetab='+$j(path).parent().find('input[name="typetab[]"]').val();
					syndiTabs.saveTab(dataString, 'Tab Deleted');
				}
			});
		},
		editTab: function(path) {
			var path 			= $j(path).parent();
			var currentTab		= syndiGeneral.currentTab();
			var sid				= $j('#sid').val();
			var originalField	= $j(path).html();
			var inputField		= '<span class="ui-icon ui-icon-disk ui-tab-save" title="Save">Save Tab</span><span class="ui-icon ui-icon-cancel ui-tab-cancel" title="Cancel">Cancel</span><input type="text" name="'+$j(path).find('.ui-tab-name').attr("rel")+'" id="tab_name_edit" value="'+$j(path).find('.ui-tab-name').html()+'"/>';

			//FIGURE OUT HOW TO DISABLE
			//$j('#tabs').tabs({disabled: [1, 2] });
			
			$j(path).addClass('ui-state-edit');
			$j(path).empty();
			$j(path).html(inputField);
			
			$j('#tab_name_edit').focus();
			
			$j('.ui-tab-save').click(function() {
				var tabTitle	= $j('#tab_name_edit').val();
				if(tabTitle.length > 0) {
					var dataString	= '&task=updateTab&update_task=updateTab&sid='+sid+'&tab_id='+$j('#tab_name_edit').attr("name")+'&title='+tabTitle+'&alias='+syndiGeneral.alias(tabTitle);
					syndiTabs.saveTab(dataString, 'Tab Updated');
				}
								
				return false;
			});
			
			$j('#tab_name_edit').keydown(function(e) {
				if(e.keyCode == '13') {
					var tabTitle	= $j('#tab_name_edit').val();
					if(tabTitle.length > 0) {
						var dataString	= '&task=updateTab&update_task=updateTab&sid='+sid+'&tab_id='+$j('#tab_name_edit').attr("name")+'&title='+tabTitle+'&alias='+syndiGeneral.alias(tabTitle);
						syndiTabs.saveTab(dataString, 'Tab Updated');
					}
								
					return false;
				}
			});
			
			$j('.ui-tab-cancel').click(function() {
				var currentTab		= syndiGeneral.currentTab();
				syndiTabs.loadTabs(currentTab);
				
				$j('body').unbind('click');
				return false;
			});
		},
		
		loadTabs: function(currentTab) {
			var dataString		= '&task=loadTabs&template=tabs&sid='+$j('#sid').val();			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#syndi_tab_wrapper').html(output);
					syndiTabs.refreshTabs();
					$j('#tabs').tabs('select', currentTab);
				}
			});
		},
		addTab: function() {
			var dataString	= $j('#adminForm').serialize() + '&alias=' + syndiGeneral.alias($j('#tabsTitle').val());
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				//data: '&task=addTab&typetab='+$j('#tabsType').val()+'&title='+$j('#tabsTitle').val()+'&sid='+$j('#sid').val()+'&alias='+syndiGeneral.alias($j('#tabsTitle').val()),
				type: 'post',
				success: function(output) {
					syndiGeneral.message('Tab Added', '');
					syndiTabs.loadTabs();
				}
			});
		},
		saveTabsOrder: function() {
			var dataString	= $j('#syndi_tabs input[name="tab_id[]"]').serialize();
			$j.ajax({
				url: ajaxURL,
				data: '&task=saveTabsOrder&'+dataString,
				type: 'post',
				success: function(output) {
					syndiGeneral.message('Tab Order Updated');
				}
			});
		},
		saveTab: function(dataString, message) {
			var currentTab		= syndiGeneral.currentTab();
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					syndiGeneral.message(message, '');
					syndiTabs.loadTabs(currentTab);
				}
			});		
		}		
	};
	
	syndiList = {
		init: function() {
			$j('.sortable').sortable({
				 update: function(event, ui) {
					syndiList.saveOrder(ui);
					syndiGeneral.refreshPreview();
				 },
				axis: 'y'
			});
		
			$j('.syndi_list_edit').click(function() {
				syndiForm.edit(this);
				return false;
			});
			
			$j('.syndi_list_delete').click(function() {
				var listItem		= $j(this).parent();
				var dataString		= $j(listItem).find('div[name="syndi_data_list_serialize"]').html();
				var dataObj			= $j.parseJSON(dataString);
				
				$j(this).fastConfirm({
					position: "right",
					questionText: "Confirm item deletion",
					onProceed: function() {
						syndiForm.deleteForm(dataObj, listItem);
					}
				});
				return false;
			});
		},
		saveOrder: function(ui) {
			var dataString		= $j(ui.item).parent().find('input[name="ordering[]"]').serialize();
				dataString		+= '&task=saveOrdering&'+$j(ui.item).parent().parent().find('input[name="typetab"]').serialize();
			
			$j.ajax({
				url: 	ajaxURL,
				data: 	dataString,
				type:	'post',
				success: function(output) {
					syndiGeneral.message('List Order Updated');
					//Reset
					$j(ui.item).parent().find('.syndi_data_list').each(function(i) {
						$j(this).removeClass('even odd');
						var rowClass 	= (i%2 == 0) ? 'even': 'odd';
						$j(this).addClass(rowClass);
					});
				}
			});
		}
	};
	
	syndiPreview = {	
		init: function(form, formType, showModal) {
			formObj 	= form;
			type 		= formType;
			
			$j(formObj).find('#preview_wrapper').html(syndiPreview._content(type, formObj));
			//console.log($j(formObj).find('#preview_wrapper'));		
			if(showModal) {
				$j.colorbox({
					inline:true, 
					href: $j(formObj).find('#preview_wrapper'),
					cbox_complete: function() {
						syndiPreview._flowplayer();
					},
					cbox_cleanup: function() {
						$j('emcSyndi_flowplayer').flowplayer().each(function() {
							this.stop();
						});
					}
				});
			}
		},
		_content: function(type, formObj, showModal) {
			switch(type) {
				case 'facebook': 	return syndiPreview._facebook(formObj);
									break;
				case 'twitter':		return syndiPreview._twitter(formObj);
									break;
				case 'video':		return syndiPreview._video(formObj);
									break;
				case 'poll':		return syndiPreview._poll(formObj);
									break;
				case 'rss':		return syndiPreview._rss(formObj);
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
		_twitter: function(formObj) {
			var username 		= $j(formObj).find('#username').val();
			var tweets				= $j(formObj).find('#tweets').val();
			var avatar 			= $j(formObj).find('input[name="avatar"]').val();
			var timestamp		= $j(formObj).find('input[name="twitter_timestamp"]').val();
			var hashtag			= $j(formObj).find('input[name="hashtag"]').val();
			var twitter 			= '';
			
			twitter		+= '<iframe src="/components/com_syndi/assets/syndi/helper/twittertest.php?username='+username+'&tweets='+tweets+'&avatar='+avatar+'&timestamp='+timestamp+'&hashtag='+hashtag+'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:169px;" allowTransparency="true"></iframe>';
/*
			$j.ajax({
				url: '/components/com_syndi/assets/syndi/helper/twittertest.php',
				data: '&username='+username+'&avatar='+avatar+'&timestamp='+timestamp,
				type: 'post',
				async: false,
				success: function(output) {
					twitter 			+= output;
					//console.log(output);
					$j(formObj).find('#preview_wrapper').html(twitter);
				}
			});*/
			return twitter;
		},
		_video: function(formObj, showModal) {
			var textareaVal		= $j(formObj).find('textarea').val();
			var urlString		= $j(textareaVal).find('param[name="movie"]').val();
			
			var siteId			= syndiGeneral.urlParam(urlString, 'siteId');
			var videoId			= syndiGeneral.urlParam(urlString, 'videoId');
			var videoEmbed		= '';
			
			$j(formObj).find('input[name="siteId"]').val(siteId);
			$j(formObj).find('input[name="videoId"]').val(videoId);
	
			$j.ajax({
				url: '/components/com_syndi/assets/syndi/helper/flowplayer.php',
				data: '&siteId='+siteId+'&videoId='+videoId,
				dataType: 'json',
				type: 'post',
				success: function(output) {
					$j(formObj).find('input[name="sbFeed"]').val(output.link);
					videoEmbed		+= '<a href="'+output.link+'" class="emcSyndi_flowplayer"></a>';
					$j(formObj).find('#preview_wrapper').html(videoEmbed);
				}
			});
		},
		_flowplayer: function() {
			$j('.emcSyndi_flowplayer').flowplayer("/libraries/evolve/assets/flash/flowplayer.swf", {
				plugins: {
					controls: {
						url: '/libraries/evolve/assets/flash/flowplayer.controls.swf',
						backgroundColor: "transparent",
						backgroundGradient: "none",
						time: false,
						scrubber: false,
						volume: false,
						fullscreen: false
					}
				},
				clip: {
					autoPlay: true,
					autoBuffering: true,
					onStart: function() {
						this.unmute();
					}
				},
			});	
		},
		_poll: function(formObj) {
			var textareaVal		= $j(formObj).find('textarea').val();
			var src 					= $j(textareaVal).attr('src');
			var polldaddyID 		= src.substring(src.lastIndexOf("/")+1, src.lastIndexOf("."));
			
			$j(formObj).find('input[name="polldaddy_key"]').val(polldaddyID);
			$j(formObj).find('input[name="polldaddy_feed"]').val(src);
			
			var polldaddy 		= '';
			
			polldaddy		+= '<iframe src="/components/com_syndi/assets/syndi/helper/poll.php?poll_id='+polldaddyID+'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:169px;" allowTransparency="true"></iframe>';
			
			return polldaddy;
		},
		_rss: function(formObj, showModal) {
			var feedUrl	= $j(formObj).find('#feed_url').val();
			var items		= $j(formObj).find('#articles_number').val();
			var rss			= '';
			
			$j.ajax({
				url: '/components/com_syndi/assets/syndi/helper/rss.php',
				data: '&feed_url='+feedUrl+'&items='+items,
				type: 'post',
				
				success: function(output) {
					rss 			+= output;
					//console.log(output);
					$j(formObj).find('#preview_wrapper').html(rss);
				}
			});
		}
		
	};	

})(jQuery);