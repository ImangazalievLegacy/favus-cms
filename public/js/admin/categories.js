+function($, window) {
	'use strict';

	var Category = {

	};

	Category.delete = function (id) {
		var data = { "id": id };

		Api.request('category/delete', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Категория удалена');
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

	window.Category = Category;

}(jQuery, window);

$( document ).ready(function() {

	$('.delete-category').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		Category.delete(id);
	});

});