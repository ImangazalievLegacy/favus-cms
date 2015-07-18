function apiRequest(apiMethod, data, successCallback, errorCallback)
{
	var apiUrl = 'http://favus.com/api/';

	var url = apiUrl + apiMethod;

	errorCallback = errorCallback || function (xhr) { console.log(xhr.responseText); };

	$.ajax({

		"url": url,
		type: 'POST',
		data: data,

		success: successCallback,
		error: errorCallback
 
	});
}

