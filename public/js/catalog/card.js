$( document ).ready(function() {

	function addToCart(id)
	{
		var data = {

			"id": id

		}

		apiRequest('cart/add', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Товар добавлен в корзину');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	function deleteFromCart(id)
	{
		var data = {

			"id": id

		}

		apiRequest('cart/delete', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Товар удален');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	$('#add-product').on('click', function(){

		var id = $(this).parent('article').data('id');

		addToCart(id);
	});

	$('#delete-product').on('click', function(){

		var id = $(this).parent('article').data('id');

		deleteFromCart(id);
	});

});