$( document ).ready(function() {

	$('#toggle-menu').on('click', function(){

		var menu = $('.side-nav');

		menu.slideToggle("slow");
	});

	$('.side-nav li').on('click', function(){

		$(this).siblings('li').children('ul').hide('normal');

		var menu = $(this).children('ul');

		menu.slideToggle('slow');
	});
});