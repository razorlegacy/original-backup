'use strict';

angular.module('listApp.ui', ['ui'])
	.value('ui.config', {
	date:{
		   defaultDate:null,
			changeMonth:true,
			changeYear:true,
			yearRange: 'c-2:c+2',
			showWeek:true,
			dateFormat: 'M dd, yy',
			numberOfMonths:3
		}
	});
