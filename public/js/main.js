function apiRequest(apiMethod, data, callback)
{
	var apiUrl = 'http://favus.com/api/';

	var url = apiUrl + apiMethod;

	$.post(url, data, callback);
}