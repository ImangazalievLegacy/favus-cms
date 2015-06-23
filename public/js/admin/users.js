$( document ).ready(function() {

	function deleteUser(id)
	{
		var data = {

			"id": id

		}

		apiRequest('user/delete', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Пользователь удален');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	$('.delete-user').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('tr').data('id');

		deleteUser(id);
	});

});