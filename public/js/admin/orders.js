+function($, window) {
	'use strict';

	var Order = {

	};

	Order.delete = function (id) {
		var data = { "id": id };

		Api.request('order/delete', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Заказ удален');
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

	window.Order = Order;

}(jQuery, window);

$(document).ready(function() {

	$('.delete-order').on('click', function(event){

		event.preventDefault();

		var id = $(this).closest('tr').data('id');

		Order.delete(id);
	});

});