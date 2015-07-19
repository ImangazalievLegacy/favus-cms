+function($, window) {
	'use strict';

	var input;

	var Uploader = function(input) {

		this.input = input;

	}

	Uploader.prototype.upload = function(name, before, progress) {

		var formdata, files, file, filename;

		files = this.input[0].files;
		
		if (files.length == 0)
		{
			return false;
		}

		file = files[0];

		//создание формы
		formdata = new FormData();

		formdata.append(name, file);

		//отправка
		var jqxhr = $.ajax({
			url: this.input.data('url'),
			type: 'POST',
			enctype: 'multipart/form-data',
			contentType: false,
            processData: false,
            data: formdata,
			cache: false,
               
			beforeSend: before,
			xhr: progress
        });

        return jqxhr;
	};

	window.Uploader = Uploader;

}(jQuery, window);

+function($, window) {
	'use strict';

	var Alert = {

	}

	Alert.show = function (message, type) {

		type = type || 'info';

		var source   = $("#help-block-template").html();
		var template = Handlebars.compile(source);

		var context  = {"message": message, "type": type};
		var html     = template(context);

		$('#upload-message').html(html);
	}

	window.UploaderAlert = Alert;

}(jQuery, window);

$(document).ready(function(){

	$('#upload-dialog').change(function(){

		var before = function() {

			$('#image-upload-progress').show();

		}

		var progress = function() {  

			//отображение проресса загрузки
			var displayProgress = function (e)
			{
				if(e.lengthComputable)
				{
					var percent = ( e.loaded / e.total ) * 100;

					var progressbar = $('#image-upload-progress .progress-bar');

					progressbar.css('width', percent + '%');
					progressbar.attr('aria-valuenow', percent);
				}
			}
				
			var myXhr = $.ajaxSettings.xhr();

			// проверка что осуществляется загрузка
			if(myXhr.upload)
			{ 
				//передача в функцию значений
				myXhr.upload.addEventListener('progress', displayProgress, false);
			}

			return myXhr;
		}

		var uploader = new Uploader($('#upload-dialog'));

		uploader.upload("file", before, progress)
			.done(function(dataJson){

				//скрытие прогресс бара и показ уведомления
				$('#image-upload-progress').hide();

				//получение url изображения
				var data = $.parseJSON(dataJson);
				console.log(data);

				var path = data.response;

				//добавление превью
				var file = $('#upload-dialog')[0].files[0];
			
				var reader = new FileReader();

				reader.readAsDataURL(file);

				reader.onload = function (e) {

					var src = e.target.result;
					var id  = $("#thumbnails .thumbnail").length;

					var source   = $("#thumbnail-template").html();
					var template = Handlebars.compile(source);
					var context  = {"src": src, "path": path};
					var html	 = template(context);

					$('#thumbnails').append(html);
				}	  
			})
			.fail(function(xhr) {

				$('#image-upload-progress').hide();
				UploaderAlert.show('Ошибка загрузки файлов', 'danger');

				console.log(xhr.responseText);
			});

	});

	$("#thumbnails").delegate(".delete", "click", function() {

		var link = $(this).parent();

		var thumbnail = $(link).parent();

		var id = $(this).index();

		if ($(link).hasClass("selected"))
		{
			var first = $("#thumbnails .thumbnail")[0];

			if (first !== undefined)
			{
				$(first).addClass("selected");
			}
		}

		thumbnail.remove();

		var selectedId = $("#thumbnails .thumbnail.selected").parent().index();

		$("#main-image-id").val(selectedId);
	});

	$("#thumbnails").delegate(".thumbnail", "click", function() {

		var thumbnail = $(this).parent();

		var id = $(thumbnail).index();

		if (id !== -1)
		{
			$("#thumbnails .thumbnail").removeClass("selected");
			$(this).addClass("selected");

			$("#main-image-id").val(id);
		}
	});
});