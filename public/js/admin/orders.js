$(document).ready(function() {

	function deleteOrder(id)
	{
		var data = {

			"id": id

		}

		apiRequest('order/delete', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Заказ удален');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	$('.delete-order').on('click', function(event){

		event.preventDefault();

		var id = $(this).closest('tr').data('id');

		deleteOrder(id);
	});

});