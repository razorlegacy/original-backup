'use strict';

//var listApp	= angular.module('listApp', ['monitorList','monitorTotal','monitorDate','ui']);
var listApp	= angular.module('listApp', ['monitorList','monitorFilter','ui','monitorGAservice']);

//$("#filters").datepicker().on('changeDate', function(ev) { alert(ev.date)});
//var filterApp = angular.module('filterApp', ['monitorFilter', 'ui']);
//var filterApp = angular.module('filterApp', []);

listApp.value('ui.config', {
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
	
/*
//We already have a limitTo filter built-in to angular,
//let's make a startFrom filter
var app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});*/