+function($, window) {
	'use strict';

	var Product = {

	};

	Product.delete = function (id) {
		var data = { "id": id };

		Api.request('product/delete', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Товар удален');
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

	window.Product = Product;

}(jQuery, window);

$( document ).ready(function() {

	$('.delete-product').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		Product.delete(id);
	});
});