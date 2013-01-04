jQuery(function() {
	//Rules Colorbox popup
	$(".websvc_rules").colorbox({iframe: true, width: "50%", height: "80%"});

	//Closes contest at specified date
	dateCheck();
	
	$("#websvc_form_"+websvc_sid).submit(function() {
			
		//jQuery inline-validation
		if($("#websvc_form_"+websvc_sid).validationEngine({returnIsValid:true, promptPosition: "centerRight"}) && entrantCheck()) {
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
	
	//Resets any CSS error class
	$("#websvc_form_"+websvc_sid+" *").removeClass('websvc_error');

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
		if(websvc_me == 0) {
			//Save Cookie
			entrantSave();
		}
		formWipe();
	}
}

/**
* Wipes form fields
*/
function formWipe() {
	//Wipes form fields
	$(':input','#websvc_form_'+websvc_sid)
		.not(':button, :submit, :reset, :hidden')
		.val('')
		.removeAttr('checked')
		.removeAttr('selected');
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

/**
* Searches form for email input ID
*/
function emailFind() {
	var inputID;
	
	$("#websvc_form_"+websvc_sid+" li").each(function(cnt) {				
		//Strips out special characters
		if($(this).text().toLowerCase().replace(/[^a-z0-9 ]/g, '') == "email") {
			//Break as soon as we find the match
			inputID		= cnt;
			return false;
		}
	});
	
	//Returns ID of matching input field
	return $("#websvc_form_"+websvc_sid+" input").eq(inputID).attr("id");
}

/**
* Checks for entrant cookie and emails stored inside
*/
function entrantCheck() {
	var c_name			= "websvc_"+websvc_sid; //Cookie Name
	
	//Check for multiple entrants flag
	if(websvc_me == 0) {
		//Sees if sweeps cookie exists
		var c_value		= ($.cookie(c_name) == null) ? "" : $.cookie(c_name);
		if(c_value == "") {
			return true;
		} else {
			//Checks to see if email has been stored
			var inputID		= emailFind();
			var inputEmail	= $("#"+inputID).val();
				c_emails	= c_value.split(','); //Pulls email values from cookie
				
			if(jQuery.inArray(xor_str(inputEmail, 5), c_emails) >= 0) {
				//Security wipe
				$("#websvc_response").removeClass("websvc_hidden");
				$("#websvc_response").html("Thank you for entering!");		
				formWipe();
				return false;
			} else {
				return true;
			}
		}
	} else {					
		return true;
	}
}

/**
* Enters in entrant emails after success response
*/
function entrantSave() {
	var inputID		= emailFind();
	var	inputEmail	= $("#"+inputID).val();
	var c_name		= "websvc_"+websvc_sid;
	var c_endDate	= new Date(websvc_endDate.replace(/-/g, '/'));
	
	var	c_value		= ($.cookie(c_name) == null) ? "" : $.cookie(c_name);
	if(c_value == "") {
		//create cookie
		$.cookie(c_name, xor_str(inputEmail, 5), {path: '/', expires: c_endDate});
	} else {
		//append value at end of cookie value string
		var emailAdd	= xor_str(inputEmail, 5);
		$.cookie(c_name, c_value+","+emailAdd, {path: '/', expires: c_endDate});
	}
}

/**
* XOR encrypt a string
*/
function xor_str(toEncrypt, key) {	
	var encrypt		= "";//the result will be here
	
	for(i=0; i<toEncrypt.length; ++i) {
		encrypt		+= String.fromCharCode(key^toEncrypt.charCodeAt(i));
	}
	
	return encrypt;
}