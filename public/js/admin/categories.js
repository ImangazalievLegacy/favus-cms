$( document ).ready(function() {

	function deleteCategory(id)
	{
		var data = {

			"id": id

		}

		apiRequest('category/delete', data, function(data){

			response = $.parseJSON(data);

			if (response.status == 200)
			{
				alert('Категория удалена');
			}
			else
			{
				alert('Ошибка');
			}

		});
	}

	$('.delete-category').on('click', function(event){

		event.preventDefault();

		var id = $(this).parent('li').data('id');

		deleteCategory(id);
	});

});