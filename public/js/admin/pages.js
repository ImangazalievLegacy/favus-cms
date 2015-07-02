$( document ).ready(function() {

	function deletePage(id)
	{
		var data = {

			"id": id

		}

		apiRequest('page/delete', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Страница удалена');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	$('.delete-page').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		deletePage(id);
	});

});