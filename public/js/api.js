+function($, window) {
	'use strict';

	var Api = {

	};

	Api.apiUrl = $('meta[name="api-url"]').attr('content');

	Api.request = function(method, parameters) {

		var parameters = parameters || {};

		var url = this.apiUrl + '/' + method;

		var jqxhr = $.ajax({

			"url": url,
			type: 'POST',
			data: parameters
		});

		return jqxhr;
	};

	window.Api = Api;
}(jQuery, window);