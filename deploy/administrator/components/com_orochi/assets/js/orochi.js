var $j	= jQuery.noConflict();

var orochiCreate, orochiConfig, orochiContent;//, orochiForm;
var orochiAjax, orochiRefesh;

(function($j) {
	ajaxURL			= 'index.php?option=com_orochi&format=raw';
	uploadifyBtn		= '/administrator/components/com_orochi/assets/images/btn_upload.png';
	folderPathTemp = '/assets/components/com_orochi/temp';
	imageName 		= '';
	/**
	* General functions
	*/
	orochiGeneral	= {
		init: function(gid) {
			orochiLayout.init(gid);
			orochiGroups.init();
		},
		currentForm: function(path) {
				var form = $j(path).closest('form');
				return form;
		},
		edit: function(form, metaObj, contentObj) {
			$j.each(contentObj, function(i, item) {
				if(i=='image' && item != '') {
					var uploadifyWrapper	= $j(form).find('.orochi-uploadify');
					
					$j(uploadifyWrapper).find('input.uploadify_input').val(item);
					$j(uploadifyWrapper).find('div.orochi-uploadify-placeholder').empty().append('<img src="'+item+'"/>');
				}
				if(i=='embed' && item != '') {
					item	= item;//decodeURIComponent(item);
				}

				
				$j(form).find('*[name="'+i+'"]').val(item);
			});
			
			$j(form).find('input[name="id"]').val(metaObj['id']);
		},
		upload: function(form) {
			var formPath 	= $j('#'+form);
			var uploadList 	= $j(formPath).find('input[name="image_upload"]');
			
			$j(uploadList).each(function(index) {
				//var folderPath			= '/assets/components/com_orochi/temp';
				$j(uploadList[index]).uploadify({
						'auto'			: true,
						'buttonImg'		: uploadifyBtn,
						'folder'		: folderPathTemp,
						'height'		: 26,
						'onComplete'	: function(event, ID, fileObj, response, data) {
							//$j(uploadList[index]).parent().find('.image_preview').attr('src', folderPathTemp+'/'+response);
							$j(uploadList[index]).parent().find('input.uploadify_input').val(response);
							imageName = response;
							var uploadifyWrapper	= $j(uploadList[index]).closest('.orochi-uploadify');
							
							//$j(uploadifyWrapper).find('.orochi-uploadify-preview').removeClass('orochi-hidden');
							
							if($j(uploadifyWrapper).find('.orochi-uploadify-placeholder').length > 0) {
								//console.log($j(uploadifyWrapper).find('.orochi-uploadify-placeholder'));
								//$j(uploadifyWrapper).find('.orochi-uploadify-placeholder .orochi-uploadify-placeholder-text').hide();
								$j(uploadifyWrapper).find('.orochi-uploadify-placeholder').empty().append('<img src="'+imageName+'"/>');
							} else {
								$j(uploadifyWrapper).find('.orochi-uploadify-preview').removeClass('orochi-hidden');
							}
						},
						'width'			: 100
				});
			});
		},
		resetForm: function(path) {
			var form 	= orochiGeneral.currentForm(path);
			$j(form)[0].reset();
			//orochiGeneral.resetImage(form);
		},
		resetForms: function() {
			$j('#orochi_forms_content form[name="orochi_content_form"]').each(function() {
				$j(this)[0].reset();
				$j(this).find('.orochi-uploadify-placeholder').empty();
				//$j(this).find('.orochi-uploadify-placeholder .orochi-uploadify-placeholder-text').show();
				$j(this).find('input[name="image"]').val('');
				$j(this).find('input[name="id"]').val('');
			});
		
			
			
			
			/*
var form 	= orochiGeneral.currentForm(path);
			
			console.log(form);
			
			$j.each(form.parents('#orochi_content').find('#orochi_add').find('form'), function(key, value) {
				orochiform = form.parents('#orochi_content').find('#orochi_add').find('form')[key];
				orochiform.reset();
				//orochiGeneral.resetImage(orochiform);
			});
*/
		},
		/*resetImage: function(path) {
			var form 				= path;
			var placeholderImage	= $j(form).find('.image_preview, .liveImagePreview').attr('rel');
			$j(form).find('.image_preview, #orochi_tab_left .liveImagePreview, #tab_image_preview').attr('src', placeholderImage);
			$j(form).find('#image').attr('value', '');
			$j(form).find('#id').attr('value', '');
			$j(form).find('#tab_bg').attr('value', '');
			$j(form).find('#preview_wrapper').empty();
		},*/
		tiptip: function() {
			 $j('.orochi-tips').tipTip({delay: 0});
		},
		valueImage: function(currentForm) {
			var folderPath	= '../assets/components/com_orochi/'+$j('#orochi_id').val()+'/';
			$j(currentForm).find('input#image').val(folderPath+imageName);
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					//$j(currentForm).find('input#image').val(folderPath+imageName);
					//orochiGeneral.valueImage(currentForm);
				}
			});

		}
	};

	/**
	* Ajax calls to controller
	**/
	orochiAjax		= {
		orochi_save: function(path) {
			var currentForm		= orochiGeneral.currentForm(path);
			var dataString		= $j(currentForm).serialize();
				dataString		+= '&task=saveOrochi';
			
			$j(currentForm).submit();
		},
		orochi_delete: function(id) {
			var dataString	= id.serialize()+'&task=remove';
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					setTimeout('location.reload(true)', 100);
				}
			});
		},
		config_save: function(path) {
			var currentForm		= orochiGeneral.currentForm(path);
			//var folderPath	= '../assets/components/com_orochi/'+$j('#orochi_id').val()+'/';
			var dataString		= $j(currentForm).serialize();
				dataString		+= '&task=saveConfig&id='+$j('#orochi_id').val();
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					orochiRefresh.workspace();
					orochiRefresh.config();
					//$j(currentForm).find('input#image').val(folderPath+imageName);
					//orochiGeneral.valueImage(currentForm);
				}
			});

		},
		content_save: function(path) {
			var form 			= orochiGeneral.currentForm(path);
			var gid				= $j('#orochi_forms_groups_content input[name="gid"]').val()
			var mid				= $j('#orochi_forms_groups_content input[name="mid"]').val();
			
			var dataString		= $j(form).serialize()+'&task=saveForm&mid='+mid+'&gid='+gid+'&oid='+$j('#orochi_id').val();
			//dataString = encodeURI(dataString);
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					orochiGeneral.resetForms(path);
					orochiRefresh.content(mid, gid);
				}
			});

		},
		group_create: function(path) {
			var mid				= $j(path).closest('.workspace_unit_wrapper').find('.orochi_workspace_menu li.ui-tabs-selected input[name="ordering[]"]').val();
			var dataString		= '&task=genericSave&table=groups&oid='+$j('#orochi_id').val()+'&mid='+mid+'&size=1';
			
			if($j(path).closest('.workspace_unit_wrapper').attr('id') == 'workspace_unit_wrapper_250') dataString += '&link=1';
			
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					orochiRefresh.workspace();
				}
			});


		},
		group_size: function(path) {
			var dataString		= $j(path).find('input').serialize();
				dataString		+= '&task=genericSave&table=groups&id='+$j(path).find('input[name="ordering[]"]').val();
				
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					//orochiRefresh.workspace();
				}
			});

		},
		menu_save: function(path) {
			var currentForm		= orochiGeneral.currentForm(path);
			var dataString		= $j(currentForm).serialize();
				dataString		+= '&task=saveMenu&tmpl=workspace&oid='+$j('#orochi_id').val();
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					orochiGeneral.resetForm(path);
					orochiRefresh.workspace();
					//orochiGeneral.valueImage(currentForm);
				}
			});
		},
		order_content: function(path) {
			//var currentForm		= orochiGeneral.currentForm(path);
			var dataString		= $j(path).find('input[name="ordering[]"]').serialize();
				dataString		+= '&task=saveOrdering&type=content';
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					//orochiRefresh.group($j(currentForm).find('input[name="gid"]').val());
				}
			});

		},
		order_groups: function(path) {
			var dataString		= $j(path).parent().find('input[name="ordering[]"]').serialize();
				dataString		+= '&task=saveOrdering&type=groups';

			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					//orochiRefresh.workspace();
				}
			});

		},
		order_tabs: function(path) {
			var dataString		= $j(path).find('input[name="ordering[]"]').serialize();
				dataString		+= '&task=saveOrdering&type=menu';
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					orochiRefresh.workspace();
				}
			});
		},
		remove: function(path) {
			var currentForm		= orochiGeneral.currentForm(path);
			var dataString		= $j(currentForm).serialize();
				dataString		+= '&task=genericDelete';
				
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function() {
					//NEEDS SWITCH STATEMENT
					//orochiRefresh.workspace();
				}
			});

		},
		resetImage: function(path) {
			var imagePath = $j(path).parent().parent().find('input.uploadify_input').val();
			var dataString		= '&task=deleteFile&path='+imagePath;
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				dataType: 'text',
				async: false,
				success: function() {
					$j(path).parent().parent().find('input.uploadify_input').attr('value','');
				}
			});
		}
	};
	/**
	* Controller response refresh
	**/
	orochiRefresh	= {
		admin: function() {
			
		},
		config: function() {
			var dataString		= '&task=refreshWorkspace&tmpl=forms_config&oid='+$j('#orochi_id').val();
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#orochi_forms_config').empty().append(output);
					orochiForms.init();
					$j('#orochi_forms_config .orochi-confirm-message').show().delay(3000).fadeOut('slow');
				}
			});

		},
		content: function(mid, gid) {
			var dataString		= '&task=refreshContent&tmpl=modal_group&mid='+mid+'&gid='+gid;
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#orochi_forms_groups_content.orochi-scrollable').jScrollPane().data().jsp.destroy();
					$j('#orochi_forms_groups_content').empty().append(output);
					$j('#orochi_forms_groups_content.orochi-scrollable').jScrollPane();

					orochiModal.group();
				}
			});
		},
		form: function() {
			var dataString		= '&task=refreshForm&tmpl=modal_content';
			//orochiForms.edit();
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#orochi_forms_content').empty().append(output);
					orochiModal.form();
					orochiGeneral.tiptip();
				}
			});
		},
		menu: function(mid) {
			var dataString		= '&task=refreshMenuForm&tmpl=forms_menu&mid='+mid+'&oid='+$j('#orochi_id').val();
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#orochi_forms_menu').empty().append(output);
					orochiGeneral.upload('orochi_setup_menu');
					orochiLayout.preview();
				}
			});
		},
		workspace: function() {
			var dataString		= '&task=refreshWorkspace&tmpl=workspace&oid='+$j('#orochi_id').val();
			
			$j.ajax({
				url: ajaxURL,
				data: dataString,
				type: 'post',
				success: function(output) {
					$j('#orochi_workspace').empty().append(output);
					orochiWorkspace.init();
				}
			});
		}
	};
	
	
	
	//Dashboard Helper
	orochiHelp = {
		init: function() {
			
			$j('#evolve-toolbar a[name="toolbar_help"]').click(function() {
				window.open('http://'+window.location.hostname+'/administrator/components/com_orochi/assets/documentation/help.pdf' ,'_blank');
			});
			
			$j('#evolve-toolbar a[name="toolbar_delete"]').click(function() {
				var id		= $j('#orochi_list input:checkbox:checked');
				//if(id.length) cartographerAjax.cartographer_delete(id);
				//console.log(id);
				
				if(id.length) orochiAjax.orochi_delete(id);
				return false;
			});
			
			$j('#evolve-toolbar a[name="toolbar_exit"]').click(function() {
				$j('#adminForm').submit();
				return false;
			});
		}
	};
	
	
	
	
	
	orochiCreate	= {
		init: function() {
			$j('a[name="orochi_create"]').click(function() {
				if(evolveJS.validate($j(this))) orochiAjax.orochi_save($j(this))
				return false;
			});
			
			$j('.orochi_list_preview input[type="text"]').click(function() {
				$j(this).focus().select();
			});
			
			$j('.syndi_list_embed').click(function() {
				$j(this).qtip({
					content: {
						text: $j('#syndi_list_embed_modal').clone()	
					},
					events: {
						hide: function(event, api) {
							api.destroy();
						},
						show: function(event, api) {
							var qtipSelector	= $j(api.elements.content),
								parentSelector	= $j(api.elements.target);
								
								$j(qtipSelector).find('input[name="id"]').val($j(parentSelector).closest('td').data('id'));
								$j(qtipSelector).find('input[name="link"]').val($j(parentSelector).closest('td').data('config'));
								orochiCreate.generateEmbed($j(qtipSelector).find('form'));
						}
					},
					hide: false,
					position: {
						at:		'center',
						my:		'center',
						target: $j(window)
					},
					show: {
						event: 'mousedown',
						modal: {
							blur: false,
							on: true
						},
						ready:	true
					},
					style: {
						classes: 'evolve-bg-secondary evolve-border evolve-shadow',
						def: false
					}
				});
				
				
				$j(document).on('click', 'a[name="syndi_cancel"]', function() {
					$j('.syndi_list_embed').qtip('hide');
					return false;
				});
				
				$j(document).on('click', '#syndi_list_embed_modal textarea', function() {
					$j(this).focus().select();
					return false;
				});
				
				$j(document).on('change', 'select[name="syndi_height"]', function() {
					orochiCreate.generateEmbed($j(this));
				});
				
				$j(document).on('click', 'a[name="syndi_list_embed_email"]', function() {
					var dataString		= '&task=email&'+$j(evolveJS.currentForm($j(this))).serialize();
						
						$j.ajax({
							type: 'post',
							url: 'index.php?option=com_orochi&format=raw',
							data: dataString,
							success: function() {
								$j('.syndi_list_embed').qtip('hide');
								evolveJS.growl('Sent', 'Embed code emailed');
							}
						});
						
						
						/*
originAjax.init(dataString, function() {
							$j('.syndi_list_embed').qtip('hide');
							evolveJS.growl('Sent', 'Embed code emailed');
						});
*/
					return false;
				});
				
			});

			
			$j('.orochi-tips').tipTip();
		},
		generateEmbed: function(form) {
			var embedForm	= $j(form).closest('form'),
				link 		= $j(embedForm).find('input[name="link"]').val(),
				height		= $j(embedForm).find('select[name="syndi_height"]').val();
				embedCode	= "<iframe src='"+link+"#header_2=%c%u' width='300px' height='"+height+"px' frameborder='0' scrolling='0'></iframe>";
			
				$j(embedForm).find('#syndi_list_embed_code').val(embedCode);
				
		},
		//NEEDED?
		form: function() {
/*
			$j('input[name="o_add"]').click(function() {
				var form 	= orochiGeneral.currentForm($(this));
				//if(orochiGeneral.inputValidation(form)) {
					$j(form).submit();
				//}
			}).button();
*/
			
			var form	= orochiGeneral.currentForm($(this));
			var folderPath	= '/assets/components/com_orochi/'+$j(form).find('#id]').val();
		
			/*$j('input[id="image_upload"]').uploadify({
				'folder'		: folderPath,
				'auto'			: true,
				'buttonText'	: 'Upload',
				'buttonImg'		: uploadifyBtn,
				'onComplete'	: function(event, ID, fileObj, response, data) {
					$j('.image_preview').attr('src', fileObj.filePath);
					$j('input#orochi_bg').val(fileObj.name);
					//$j('input#background_image_name').val(fileObj.name);
				}
			});*/
		}
	};
})(jQuery);