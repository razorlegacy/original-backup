jQuery.noConflict();

slivers = function(){
	jQuery('#system-message').delay(2000).fadeOut('slow');
//variables and methods private to slivers
	
	var public_interface = {
		//public variables and methods
		initialize: function(){
			if (this.isImagesPage()) { this.initializeImagesPage(); }
			if (this.isVideosPage()) { this.initializeVideosPage(); }
			if (this.isPositionerPage()) { this.initializePositionerPage(); }
			if (this.isVideoEditPage()) { this.initializeVideoEditPage(); }
			this.initializeGeneric();
			return this;
		},
		initializeImagesPage: function(){
			jQuery('#addScheduledImageSubmit').click(function(e){
				e.preventDefault();

				if(jQuery('#adminForm').validationEngine('validate'))
				jQuery(this).closest('.addScheduledImage').siblings('.scheduledImage').find('input').each(function(){this.disabled = true;});
				
				submitbutton('scheduledImages+current');
			});

			//TODO: Make this specific to the scheduled Images page
			jQuery('a.update_link').live('click',function(e){
				e.preventDefault();
				var updatedImage_queryString = jQuery(this).closest('.scheduledImage').find('input').serialize();
				var id = jQuery(this).closest('.scheduledImage').find('input[name="id"]').val();
				var sliver_id = jQuery('#sliver_id').val();
				var option = jQuery('#option').val();
				updatedImage_queryString += '&sliver_id='+sliver_id+'&id='+id+'&option='+option+'&task=saveScheduledImages&format=raw&view=setupimages&layout=image.raw';
				var that = this;
				jQuery.post('index.php',updatedImage_queryString,function(data,textstatus,jqxhr){
					if(data && data['actionbar_uri'] && data['flash_uri']){
						var edit = jQuery(that).closest('.images');
						var scheduledDate = jQuery(that).closest('.scheduledImage').find('.nav input.date');
						var flash = edit.find('img.flash');
						var ab = edit.find('img.actionbar');
						scheduledDate.val(data.starts);
						ab.attr('src',data.actionbar_uri);
						flash.attr('src',data.flash_uri);
						joomlaC.message('Image Updated!');
					}else{
						joomlaC.message("Unable to update date","error");
					}
					
				},'json').error(function(jqXHR, textStatus, errorThrown){
					joomlaC.message("Unable to update date","error");
				});
				});

			jQuery('#images .scheduledImage .delete').click(function(e){
				var sid = jQuery(this).closest('.scheduledImage').find('input[name="id"]').val();
				var option = jQuery('#option').val();
				var qs = 'sid='+sid+'&option='+option+'&task=removeImage&format=raw';
				
				var that = this;
				jQuery.post('index.php',qs,function(data){
					jQuery(that).closest('.scheduledImage').hide('blind','slow').remove();
				})
			});

			jQuery('#images .edit input').focus(function(e){
				var focus;
				if (this.name == 'flash_uri') {
					focus = jQuery(this).closest('.images').find('img.flash');
				} else if (this.name == 'actionbar_uri') {
					focus = jQuery(this).closest('.images').find('img.actionbar');
				}
				focus.css('box-shadow', '0 0 13px 6px rgba(0,0,0,0.65)');
			});

			jQuery('#images .edit input').blur(function(e){
				var focus;
				if (this.name == 'flash_uri') {
					focus = jQuery(this).closest('.images').find('img.flash');
				} else if (this.name == 'actionbar_uri') {
					focus = jQuery(this).closest('.images').find('img.actionbar');
				}
				focus.css('box-shadow', 'none');
			});
			return this;
		},
		initializeVideosPage: function(){
			jQuery('#videos .delete').click(function(e){
				e.preventDefault();
				var vid = jQuery(this).siblings('input[name="id"]').val();
				var option = jQuery('#option').val();
				var qs = 'id[]=' + vid + '&option=' + option + '&task=removeVideos&format=raw';
				var that = this;
				jQuery.post('index.php',qs,function(data){
					if (jQuery(that).closest('ul').find('li').length === 1) {
						jQuery(that).closest('.videoplaylist').remove();
					} else {
						jQuery(that).closest('li').hide('blind','slow').remove();
					}
				});
			});

			jQuery('.addvideo, .editvideo, .videotitle').colorbox({
				width:'50%',
				height:'80%',
				iframe:true,
				onClosed: function () {
					window.location.reload(true);
				}
			});

			return this;
		},
		initializeGeneric: function(){
			jQuery('#images .scheduledImage .close, #videos .close, #buttonUpdate .nav .close').click(function(e){
				jQuery(this).toggleClass('readytodelete').siblings('.delete').toggleClass('readytodelete');
			});

			var sliver_id = document.getElementById('sliver_id').value;
			if (!!sliver_id.toInt()) {
				var script_string = '/index.php?option=com_slivers&task=display&format=raw&view=embed&da=1&id=' + sliver_id;
				jQuery('<div />').prependTo('body').attr('id','ao_sliver_header');
				var script = document.createElement('script');
				script.type = 'text/javascript';
				script.onload = function (e) {
					jQuery('body').trigger('ready');
				};
				script.src = script_string;
				document.getElementsByTagName('head')[0].appendChild(script);
			}
			
			if(jQuery('.date').length > 0) jQuery('.date').datepicker({"dateFormat":"yy-mm-dd"});

			jQuery('tr[title],#images [title], #addButtonForm select[title],#buttonUpdate select[title]').tipTip();
			changed = false
			jQuery('form').change(function (e) { changed = true;});
			jQuery('#submenu a').click(function (e) {
				if (changed) {
					return window.confirm('You have not Applied the changes you made to this page are you sure you want to navigate away without saving? Click OK to navigate away without saving.');
				}
				return true;
			});

			jQuery('#advanced').click(
				function(e){
					e.preventDefault();
					if(jQuery('.advanced.show').length > 0){
						jQuery('.advanced.show').removeClass('show');
						jQuery(this).text('Advanced Options');
						document.cookie = 'advanced=0';
					}else{
						jQuery('.advanced').not('.show').addClass('show');
						jQuery(this).text('Basic Options');
						document.cookie = 'advanced=1';
					}
				}
			);

			jQuery('input.milliseconds').change(function(e){
				if (this.value % 1000 == 0) {
					unit = 'second';
				} else {
					unit = 'seconds';
				}
				jQuery(this).parent().siblings('.seconds').text(this.value / 1000 + " " + unit);
			});
			jQuery('input.milliseconds').keyup(function(e){
				if (this.value % 1000 == 0) {
					unit = 'second';
				} else {
					unit = 'seconds';
				}
				jQuery(this).parent().siblings('.seconds').text(this.value / 1000 + " " + unit);
			});
			jQuery('#animation_resolution').keyup(function(e){
				jQuery('#frames_per_second').text((1000/this.value) + " fps");
			});
			jQuery('#animation_resolution').change(function(e){
				jQuery('#frames_per_second').text((1000/this.value) + " fps");
			});

			jQuery('#adminForm,#addButtonForm,#video').validationEngine('attach');
				
			if(jQuery('input[type="text"]').length > 0) jQuery('input[type="text"]').placeholder({'class':'placeholder','preventRefreshIssues':true});

			//TODO: refactor this to be more generic
			jQuery('#addImg').click(function(e){
				e.preventDefault();
				//TODO: refactor scheduled image add html class to be more general second line
				jQuery(this).hide().siblings('.addScheduledImage').show();
				jQuery(this).hide().siblings('.add').show().find('input').each(function(){this.disabled=false;});
			})
			jQuery('#cancelAdd').click(function(e){
				e.preventDefault();
				jQuery(this).closest('fieldset.add').hide().find('input').each(function(){this.disabled=true;}).end().siblings('#addImg').show();
			});

			return this;
		},
		initializePositionerPage: function() {
			if(jQuery('#preview_overlay').length > 0){
				//Form backgrounds to match their db defined sizes
				jQuery('#flashimg').height(jQuery('#sliver_height').val());
				jQuery('#abimg').height(jQuery('#actionbar_height').val());

				for(var i = 0,si;si = scheduled_images[i++];){
					var starts = si.starts.split('-',3);
					
					si.starts = new Date(starts[0],starts[1] - 1, starts[2]);
					//preload the background images
					jQuery('<img />').attr('src',si.flash_uri).load(function(e){jQuery(this).remove()});
					jQuery('<img />').attr('src',si.actionbar_uri).load(function(e){jQuery(this).remove()});
				}
				//When we pick a date find the image scheduled closest to the date picked but still before it.
				jQuery('#positioner_date').datepicker({"dateFormat":"yy-mm-dd"}).change(function(e){
					var starts = jQuery(this).val().split('-',3);
					var userdate = new Date(starts[0],starts[1] - 1, starts[2]);
					var closestkey = false;
					var closestval = false;
					for(var i = 0, si; si = scheduled_images[i++];){
						var howclose;
						var beforePickedDate;
						if((beforePickedDate = si.starts <= userdate) && closestval === false) closestval = userdate - si.starts;
						if(beforePickedDate && (howclose = userdate - si.starts) <= closestval){
							closestval = howclose;
							closestkey = si;
						}
					}
					if(closestkey === false){
						joomlaC.message('No Image is scheduled for this date.','error');
					}else{
						jQuery('#flashimg').attr('src',closestkey.flash_uri);
						jQuery('#abimg').attr('src',closestkey.actionbar_uri);
					}
				});
				jQuery('#positioner_date').change();
				
				//set initial positioner box to match db defined position and dimensions
				if(jQuery('#video_height,#video_width,#posX,#posY').length > 3) jQuery('#videoPositioner').height(jQuery('#video_height').val())
				.width(jQuery('#video_width').val())
				.css('left',jQuery('#posX').val()+"px")
				.css('top',jQuery('#posY').val()+"px");
				
				jQuery('#adminForm .button_data').each(function(index,el){
					var iarea = jQuery(el).find('input[name="button_area[]"]');
					var id = jQuery(el).find('input[name="button_id[]"]').val();
					var ileft = jQuery(el).find('input[name="button_x_offset[]"]');
					var itop  = jQuery(el).find('input[name="button_y_offset[]"]');
					var iwidth = jQuery(el).find('input[name="button_width[]"]');
					var iheight = jQuery(el).find('input[name="button_height[]"]');
					var iname = jQuery(el).find('input[name="button_name[]"]');
					var positioner = jQuery('#button_pos_'+id);
					var areaID = iarea.val() == 'sliver' ? 'flashimg': 'abimg';

					ileft.change(function(e){
						positioner.css('left',jQuery(this).val()+'px');
					});
					itop.change(function(e){
						positioner.css('top',jQuery(this).val()+'px');
					});
					iwidth.change(function(e){
						positioner.width(jQuery(this).val());
					});
					iheight.change(function(e){
						positioner.height(jQuery(this).val());
					});
					iarea.change(function(e){
						var classcss = iarea.val() == 'sliver' ? 'flash':iarea.val();
						var containment = iarea.val() == 'sliver' ? 'flashimg': 'abimg';
						jQuery('#preview_overlay .'+classcss).append(positioner.detach());
						positioner.draggable('option','containment','#'+containment)
						.resizable('option','containment','#'+containment);
					});
					iname.change(function(e){
						positioner.find('label').text(iname.val());
					});
					
					positioner.height(iheight.val())
					.width(iwidth.val())
					.css('left',ileft.val()+'px')
					.css('top',itop.val()+'px')
					.draggable({
							containment:"#"+areaID,
							stop: function(e,ui){
								var left = jQuery(this).css('left');
								ileft.val(left.substring(0,left.indexOf('px')));
								var top = jQuery(this).css('top');
								itop.val(top.substring(0,top.indexOf('px')));
							}
					}).resizable({
						containment:"#"+areaID,
						minHeight:"15",
						minWidth:"15",
						stop: function(e,ui){
							iwidth.val(jQuery(this).width());
							iheight.val(jQuery(this).height());
						}
					});
				});
			}
			
			if(jQuery('#video_height,#video_width,#posX,#posY').length > 3) jQuery('#videoPositioner').draggable({
				containment:"#flashimg",
				stop: function(e,ui){
					var left = jQuery(this).css('left');
					jQuery('#posX').val(left.substring(0,left.indexOf('px')));
					var top = jQuery(this).css('top');
					jQuery('#posY').val(top.substring(0,top.indexOf('px')));
				}
			});
			
			jQuery('#button_uri').change(function(e){
				jQuery('#buttonPositioner').css("background","url(\""+jQuery(this).val()+"\") no-repeat 0 0");
			});
			
			jQuery('#addButtonForm').submit(function(e){
				if(!jQuery('#addButtonForm').validationEngine('validate')){
					e.preventDefault();
					return false;
				}
			});
			
			
			jQuery('#buttonUpdate select[name="action"],#addButtonForm select[name="action"]').change(function(e){
				var url = jQuery(this).closest('form').find('input[name="url"]');
				if(jQuery(this).val() == 'link'){
					url.prop('disabled',false);
				}else{
					url.prop('disabled',true);
				}
			});

			jQuery('#buttonUpdate select[name="area"]').change(function(e){
				var form = jQuery(this).closest('form');
				form.find('input[name="x_offset"]').val(0);
				form.find('input[name="y_offset"]').val(0);
			});
			jQuery('#buttonUpdate select[name="area"],#addButtonForm select[name="area"]').change(function(e){
				var form = jQuery(this).closest('form');
				var on;
				//preventing rollover for flash. Rip this js out once sliver is html
				if(jQuery(this).val() == 'sliver' ){
					form.find('input[name="on"][value="rollover"]').prop('disabled',true).prop('checked',false);
					form.find('input[name="on"][value="click"]').prop('checked',true);
					form.find('select[name="action"] option[value="opensliver"]').prop('disabled',true);
				}else{
					form.find('input[name="on"][value="rollover"]').prop('disabled',false);
					form.find('select[name="action"] option[value="opensliver"]').prop('disabled',false);
				}
			});
			
			jQuery('form[name="buttonupdate"]').submit(function(e){
				e.preventDefault();
				
				var postdata = jQuery(this).serialize();
				var that = this;
				var status = jQuery(this).find('.updateStatus').css('display','inline-block');
				jQuery.post('index.php',postdata).success(function(data,code,jqxhr){
					if(code == 'success'){
						status.addClass('success').delay(1000).fadeOut();
						window.setTimeout(function(){status.removeClass('success');}, 1500);
						var inputWrapper = jQuery('#button_mirror_'+jQuery('input[name="id"]',that).val());
						jQuery('input[type="text"]:not(:disabled,[name="url"]),select,input[type="radio"]:checked',that).each(function(i,el){
							var name = jQuery(el).attr('name');
							inputWrapper.find('input[name="button_'+name+'[]"]').val(jQuery(el).val()).trigger('change');
						});
					}else{
						status.addClass('error').delay(1000).fadeOut().removeClass('error');
					}
				}).error(function(){

					status.addClass('error').delay(1000).fadeOut().removeClass('error');
				});
			});

			jQuery('#buttonUpdate .delete').click(function(e){
				e.preventDefault();
				var bid = jQuery(this).closest('form').find('input[name="id"]').val();
				//var option = jQuery('#option',this).val();
				var qs = 'id[]='+bid+'&option=com_slivers&task=removeButtons&format=raw';
				//console.log(qs);
				var that = this;
				jQuery.post('index.php',qs,function(data){
					jQuery(that).closest('form').hide('blind','slow').remove();
					jQuery('#button_mirror_'+bid).remove();
					jQuery('#button_pos_'+bid).remove();
				});
			});

			
			
			return this;
		},
		initializeVideoEditPage: function () {
			jQuery('#video').submit(function (e) {
				e.preventDefault();
				if (jQuery('#adminForm,#video').validationEngine('validate')) {
					jQuery.post(
						jQuery('#video').attr('action'),
						jQuery('#video').serialize(),
						function (e) {
// put the colorbox close function in here.
							window.top.jQuery.colorbox.close();
					}).error(function (e) {
						//replace colorbox content with the response?
						console.log(e.responseText);
					});
				}
			});
		},
		
		//Stubs for page detection
		//TODO: refactor code to be functionality organized
		//eg. hasVideosUpload(), hasPositioner(), hasImageUploader()
		isVideosPage:function(){
			return jQuery('#videos').length > 0;
		},
		isPositionerPage: function(){
			return jQuery('#preview_overlay').length > 0;
		},
		isGeneralPage: function(){
			return jQuery('#sliverSettings').length > 0;
		},
		isImagesPage: function(){
			return jQuery('#images').length > 0;
		},
		isVideoEditPage: function () {
			return jQuery('#video').length > 0;
		}
		
	};
	return public_interface.initialize();
};

jQuery(function(){
	var instance = slivers();
});
var joomlaC = {
	message: function message(message, messageType, duration) {
		var messageOut;
		var duration = duration || 2000;
		//Clear old message
		jQuery('#system-message').remove();

		var messageOut              = "";
		messageOut              += "<dl id='system-message'>";
		messageOut                      += "<dt class='message'>Message</dt>";
		messageOut                      += "<dd class='" + messageType + " message fade'>";
		messageOut                              += "<ul>";
		messageOut                                      += "<li>" + message + "</li>";
		messageOut                              += "</ul>";
		messageOut                      += "</dd>";
		messageOut              += "</dl>";

		jQuery(messageOut).hide().insertBefore('body').fadeIn('slow');
		jQuery('#system-message').delay(duration).fadeOut('slow');
	}
};

function submitbutton(pressbutton){
	if((pressbutton != 'cancel' && pressbutton != 'add'
		&& pressbutton != 'remove'
		&& pressbutton != 'videos+next'
		&& pressbutton != 'videos+back'
		&& pressbutton != 'final+up'
		&& pressbutton != 'final+back'
		&& pressbutton != 'scheduledImages+continue'
		&& pressbutton != 'scheduledImages+back')
		&& !jQuery('#adminForm,#video').validationEngine('validate')) return false;
	jQuery('#images .scheduledImage input').each(function(){this.disabled = true;});

	submitform(pressbutton);
}
