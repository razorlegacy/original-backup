'use strict';

angular.module('originApp.filters', [])
	.filter('dateFormat', function () {
		return function (date, type) {
			if($j.datepicker.parseDate('mm/dd/yy', date)) return $j.datepicker.formatDate(type, $j.datepicker.parseDate('mm/dd/yy', date));
        };
    });