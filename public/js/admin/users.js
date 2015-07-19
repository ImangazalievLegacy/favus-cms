+function($, window) {
	'use strict';

	var User = {

	};

	User.delete = function (id) {
		var data = { "id": id };

		Api.request('user/delete', data)
			.done(function(data){

				var response = $.parseJSON(data);

				console.log(response);

				if (response.status == 200)
				{
					alert('Пользователь удален');
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

	window.User = User;

}(jQuery, window);

$(document).ready(function() {

	$('.delete-user').on('click', function(event){

		event.preventDefault();

		var id = $(this).closest('tr').data('id');

		User.delete(id);
	});
});