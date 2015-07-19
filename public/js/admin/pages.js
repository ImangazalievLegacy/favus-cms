+function($, window) {
	'use strict';

	var Page = {

	};

	Page.delete = function (id) {
		var data = { "id": id };

		Api.request('page/delete', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Страница удален');
				}
				else
				{
					alert('Ошибка');
				}

			})
			.fail(function(jqXHR, textStatus){

				alert('Ошибка');
			});
	};

	window.Page = Page;

}(jQuery, window);

$( document ).ready(function() {

	$('.delete-page').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		Page.delete(id);
	});
});