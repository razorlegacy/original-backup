jQuery(function() { 	

	//Closes contest at specified date
	dateCheck();

	$("#websvc_form_"+websvc_sid).submit(function() {
		//jQuery inline-validation
		if($("#websvc_form_"+websvc_sid).validationEngine({returnIsValid:true, promptPosition: "centerRight"})) {
			var	dataString		= $("#websvc_form_"+websvc_sid).serialize();
			var webserviceURL	= 'http://webservices.evolvemediacorp.com/index.php?format=raw';		
			$.ajax({
				url: webserviceURL,
				data: dataString,
				dataType: 'jsonp',
				jsonp: 'jsonCB',
				jsonpCallback: 'validation'
			});//End ajax
		}
		return false;				
	});//End Submit
						
});//End Ready
	
/**
* Parses webservice response to submission
*/	
function validation(data) {
	//Wipes error messages
	$('span[id*=websvc_error_]').each(function() {
		$(this).remove();
	});
	 
	if(data.length) {
		var errorMessage	= (data.length > 1) ? "Please check the following fields" : "Please check the following field";
	
		$("#websvc_response").html(errorMessage);
		$("#websvc_response").removeClass("websvc_hidden");
		//Tag fields that didn't pass validation
		for(var id in data) {
			//Gets Label field
			var label	= $("#"+data[id]).parent().find("label");
			label.addClass("websvc_error");
			//label.append("*");
		}
	} else {
		//Output success
		$("#websvc_response").removeClass("websvc_hidden");
		$("#websvc_response").html("Thank you for entering!");
		
		//Wipes form fields
		$(':input','#websvc_form_'+websvc_sid)
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
	}
}

/**
* Checks to see if sweepstake is supposed to be open
*/
function dateCheck() {
	websvc_endDate		= websvc_endDate.replace(/-/g, '/');
	var endDate			= new Date(websvc_endDate);
	var currentDate		= new Date();
	
	if(currentDate > endDate) {
		$("#websvc_form_"+websvc_sid).fadeOut(0, function() {
			$("#websvc_closed").removeClass("websvc_hidden");
		});
	}
}