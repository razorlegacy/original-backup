websvcHelper	= {
		
		alias: function(string) {
			string		= string.replace(/ /g, "-").toLowerCase();
			return string;
		},
		currentForm: function(path) {
			var form = $j(path).closest('form');
			return form;
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
		validate: function(path) {
			var currentForm 	= websvcHelper.currentForm(path);
			var requiredFlag	= true;
			
				$j(currentForm).find('input.websvc-required').each(function() {
					if(!$j(this).val()) {
						requiredFlag = false;
						$j(this).tipTip({activation: 'focus'}).focus();
					}
				});
				
				return requiredFlag;
		},
		inputValidation: function(path) {
					
			if($j(path).find('input.required').val()) {
				return true
			} else {
				websvcHelper.message('Missing item field(s)', 'error');
				return false;
			}
		}
};