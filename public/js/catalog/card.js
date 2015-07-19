$( document ).ready(function() {

	$('#add-product').on('click', function(){

		var id = $(this).parent('article').data('id');

		Cart.add(id);
	});

	$('#delete-product').on('click', function(){

		var id = $(this).parent('article').data('id');

		Cart.delete(id);
	});
});