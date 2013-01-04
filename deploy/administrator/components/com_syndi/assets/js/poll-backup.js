$j('#poll_add_answer').live('click', function() {
		var btnclass		= $j(this).attr('class');
		var index 			= btnclass.substring(15,18);
		var tab 			= $j('.ui-tabs-selected a').attr('rel');
		var number		= $j('#poll_form_question' + tab + '_' + index).children('.poll_li_answer').length;
		var newNumber	= number + 1;
		var optout			= $j('#poll_li_answer' + index +'_'+ number).clone().attr('id', 'poll_li_answer' + index +'_'+ newNumber);
		optout.find('#poll_form_answer').attr('value', '');
		optout.find('#poll_form_answer').attr('name', 'poll_form_answer['+index+']['+newNumber+']');
		$j(optout).insertAfter('#poll_li_answer' + index +'_'+ number);
		
		//$j('#poll_add_question').remove();
		
		/*var optout;
		optout		= "<li>"
		optout		+= "<label>Answer</label>";
		optout		+= "<input type='text' name='poll_form_answer[]' id='poll_answer' value=''/>";
		//optout		+= "<input type='button' name='poll_add_answer' id='poll_add_answer' value='ADD ANSWER' />"
		optout		+= "</li>";
		
		$j(optout).insertBefore('#poll_add_answer');
			*/	
		//<label><?php echo JText::_('POLL_ANSWER');?></label>
		//		<input type="text" name="" id="" value=""/>
	});
	
	$j('#poll_add_question').live('click', function() {
		
		var optout			= "<br><hr color='#DCD5D5' height='1' width='90%' border='0'><br>";
		
		var tab = $j('.ui-tabs-selected a').attr('rel');
		var number 		= $j('.poll_form' + tab).length;
		var newNumber = number + 1;
		var newoptout	= $j('#poll_form_question' + tab + '_' + number).clone().attr('id', 'poll_form_question' + tab + '_' + newNumber);
		newoptout.find('#poll_form_date_start' + number).attr('value', '');
		newoptout.find('#poll_form_date_end' + number).attr('value', '');
		newoptout.find('#poll_form_question').attr('value', '');
		newoptout.find('#poll_form_answer').attr('value', '');
		
		newoptout.find('#poll_form_date_start' + number).attr('name', 'poll_form_date_start['+newNumber+']');
		newoptout.find('#poll_form_date_end' + number).attr('name', 'poll_form_date_end['+newNumber+']');
		newoptout.find('#poll_form_question').attr('name', 'poll_form_question['+newNumber+']');
		newoptout.find('#poll_form_answer').attr('name', 'poll_form_answer['+newNumber+'][1]');
				
		newoptout.find('#poll_form_date_start' + number).attr('id', 'poll_form_date_start'+newNumber);
		newoptout.find('#poll_form_date_end' + number).attr('id', 'poll_form_date_end'+newNumber);
	
		newoptout.find('#poll_form_calendar_start' + number).attr('onClick', "return showCalendar('poll_form_date_start"+newNumber+"', '%Y-%m-%d');");
		newoptout.find('#poll_form_calendar_start' + number).attr('id', 'poll_form_calendar_start'+newNumber);
		newoptout.find('#poll_form_calendar_end' + number).attr('onclick', "return showCalendar('poll_form_date_end"+newNumber+"', '%Y-%m-%d');");
		newoptout.find('#poll_form_calendar_end' + number).attr('id', 'poll_form_calendar_end'+newNumber);
		
		var numAnswers = newoptout.find('.poll_li_answer').length;
		if(numAnswers > 1) {
			for(i=2 ; i<=numAnswers ; i++) {
				newoptout.find('#poll_li_answer'+number+'_'+i).remove();
			}
		}
		
		newoptout.find('.poll_li_answer').attr('id', 'poll_li_answer' + newNumber + '_1');
		newoptout.find('#poll_add_answer').attr('class', 'poll_add_answer' + newNumber);
		$j(newoptout).insertAfter('#poll_form_question' + tab + '_' + number);
		$j(optout).insertBefore('#poll_form_question' + tab + '_' + newNumber);
		//$j('#poll_form_buttons' + number).children('#poll_add_question').remove();
		$j('#poll_add_question').remove();
		
	});
	
	$j('#poll_reset').live('click', function() {
		$j('#date_start').val("");
		$j('#date_end').val("");
		$j('#poll_question').val("");
		$j('#poll_answer').val("");
		$j('#poll_answer').val("");
	});
	

	$j('#poll_edit').live('click', function() {
			var poll = $j(this).prev('#pollId').val();
			syndiForm.editForm('poll', poll);
	});
	$j('#poll_delete').live('click', function() {
			var poll = $j(this).next('#pollId').val();
			$j(this).fastConfirm({
					position: "right",
					questionText: "Confirm poll deletion",
					onProceed: function() {
						var dataString	= '&task=deleteGeneric&id='+poll+'&typetab=poll&tab_id='+$j('.ui-tabs-selected a').attr('rel');
						syndiForm.deleteForm(dataString, 'Poll Deleted');
					}
				});
					//refreshList
			//syndiForm.deleteForm('poll', poll);
	});
