+function($, window) {
	'use strict';

	var Cart = {

	};

	Cart.add = function (id) {
		var data = { "id": id };

		Api.request('cart/add', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Товар добавлен в корзину');
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

	Cart.delete = function (id) {
		var data = { "id": id };

		Api.request('cart/delete', data)
			.done(function(data){

			var response = $.parseJSON(data);

			console.log(response);

			if (response.status == 200)
			{
				alert('Товар удален из корзины');
			}
			else
			{
				alert('Ошибка');
			}

		})
		.fail(function(jqXHR, textStatus){

				alert('Ошибка');
		});
	}

	window.Cart = Cart;

}(jQuery, window);