jQuery.noConflict();
jQuery(function(){
	jQuery('#imagelist').sortable({
		update:function (event,ui){
			updatePageOrder(this);
		}
	});
	function updatePageOrder(list){
		jQuery.post('index.php',jQuery(list).closest("form").serialize(),function(){
			coloringBook.message('Page order successfully updated','message');
		})
	}

	jQuery('#adminForm').submit(function(e){
		e.preventDefault();
		if(coloringBook.adminFormValid()){
			jQuery.post('index.php', jQuery(this).serialize()+'&format=raw',function(data,textStatus,jqXHR){
				jQuery('#adminForm input[name="id"]').val(data.id);
				uploader.setParams({
					'cid[]':data.id,
					'option':'com_coloringbooks',
					'task':'uploadImage',
					'format':'raw'
				});
				if(jQuery('#adminForm input[type="submit"]').val() == 'update') coloringBook.message('Coloring Book updated','message');
				else coloringBook.message('Coloring Book created.','message');
				jQuery('#adminForm input[type="submit"]').val('update');
				jQuery('#file_upload').show();
			}).error(function(e){
				coloringBook.message('Error submitting form.');
			});
		}
	});
	jQuery('#imagelist li .delete').live('click',function(e){
		e.preventDefault();
		that= this;
		var jqxhr = jQuery.post('index.php',jQuery(this).siblings('input').serialize()+'&option=com_coloringbooks&task=deleteImage&format=raw',function(){
			jQuery(that).closest('li').hide('blind','slow').remove();
		});
		jqxhr.error(function(){ColoringBook.message('Error Deleting Image','error')});
	})

	if(typeof(qq) !== 'undefined'){
		var uploader = new qq.FileUploader({
			element: document.getElementById('file_upload'),
			action: 'index.php',
			sizeLimit:2097152,
			showMessage: function(msg){ coloringBook.message(msg,'notice'); },
			params: {
				'option':'com_coloringbooks',
				'task':'uploadImage',
				'cid[]':jQuery('#adminForm input[name="id"]').val(),
				'format':'raw'
			},
			onComplete: function(id,fileName,responseJSON){
				if(responseJSON.success){
					jQuery('#imagelist').append(jQuery('<li class="ui-state-default" >').
						append(jQuery('<img />').attr('src',responseJSON.uri_thumb)).
						append(jQuery('<input type="hidden" name="id[]">').val(responseJSON.id)).
						append(jQuery('<a href="#" class="delete"><image src="/administrator/images/publish_x.png" alt="delete image" /></a>'))
					);
				}
			}
		});
	}
	jQuery('#preview').overlay({
		onBeforeLoad: function(){
			var iframe = jQuery('<iframe />')
			.attr('src',location.protocol+'//'+location.host+'/index.php?option=com_coloringbooks&view=embed&format=raw&cid='+jQuery('#adminForm input[name="id"]').val())
			.attr('width',parseInt(jQuery('#embed_width').val())+'px')
			.attr('height',parseInt(jQuery('#embed_height').val())+'px')
			.attr('id','previewFrame');
			this.getOverlay().find('.overlaywrapper').append(iframe);
		},
		onClose: function(){
			jQuery('#previewFrame').remove();
		}
	});

	jQuery('.embed_link').overlay({
		closeOnClick: true
		});
	// jQuery('#email_enabled').button().change(function(e){
		// jQuery(this).filter(':checked').button('option','label','enabled');
		// jQuery(this).not(':checked').button('option','label','disabled');
	// });
	
});
var coloringBook = {
	adminFormValid: function adminFormValid(){
			if(jQuery('#name').val().length > 0) return true;

			this.message('Please enter a name','notice');
			return false;
		},
	message: function message(message, messageType, duration) {
		var messageOut;
		duration = duration || 2000;
		//Clear old message
		jQuery('#system-message').remove();

		messageOut              = "";
		messageOut              += "<dl id='system-message'>";
		messageOut                      += "<dt class='message'>Message</dt>";
		messageOut                      += "<dd class='"+messageType+" message fade'>";
		messageOut                              += "<ul>";
		messageOut                                      += "<li>"+message+"</li>";
		messageOut                              += "</ul>";
		messageOut                      += "</dd>";
		messageOut              += "</dl>";

		jQuery(messageOut).hide().insertBefore('#element-box').fadeIn('slow');
		jQuery('#system-message').delay(duration).fadeOut('slow');
	}
};

function submitbutton(pressbutton){
	if(pressbutton == 'save' && !coloringBook.adminFormValid()) return false;
	
	submitform(pressbutton);
}
