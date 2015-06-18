$( document ).ready(function() {

	function deleteProduct(id)
	{
		var data = {

			"id": id

		}

		apiRequest('product/delete', data, function(data){

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

	$('.delete-product').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		deleteProduct(id);
	});

});