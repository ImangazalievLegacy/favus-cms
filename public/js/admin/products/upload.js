$(document).ready(function(){
     
    //отображение проресса загрузки
	function progressHandlingFunction(e)
	{
		if(e.lengthComputable)
		{
    		var percent = ( e.loaded / e.total ) * 100;

    		var progressbar = $('#image-upload-progress .progress-bar');

			progressbar.css('width', percent + '%');
			progressbar.attr('aria-valuenow', percent);
		}
	}

	//вывод уведомления
	function showMessage(message, type) {

		type = type || 'info';

		var source   = $("#alert-template").html();
		var template = Handlebars.compile(source);

		var context  = {"message": message, "type": type};
		var html     = template(context);

		$('#alerts').html(html);
	}

	function uploadMessage(message, type) {

		type = type || 'info';

		var source   = $("#help-block-template").html();
		var template = Handlebars.compile(source);

		var context  = {"message": message, "type": type};
		var html     = template(context);

		$('#upload-message').html(html);
	}

	$('#upload-dialog').change(function(){

		uploadImage();

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

	//функция отправки файла
	function uploadImage() {

		//создание формы
		var formdata, file, filename;

		formdata = new FormData();
		
		if ($('#upload-dialog')[0].files.length == 0)
		{
			return;
		}

		file = $('#upload-dialog')[0].files[0];
		formdata.append("file", file);

		//отправка
		$.ajax({
			url: $('#upload-dialog').data('url'),
			type: 'POST',
			enctype: 'multipart/form-data',
			contentType: false,
            processData: false,
            data: formdata,
			cache: false,
               
			xhr: function() {  
			
				var myXhr = $.ajaxSettings.xhr();

				// проверка что осуществляется загрузка
				if(myXhr.upload)
				{ 
					//передача в функцию значений
					myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
				}
                
				return myXhr;
			},
			 
			beforeSend: function() {

				$('#image-upload-progress').show();

			},
             
			success: function(dataJson){

				//скрытие прогресс бара и показ уведомления
				$('#image-upload-progress').hide();
				uploadMessage('', 'info');

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
					var html     = template(context);

					$('#thumbnails').append(html);
				}	  
			},
            error: function(xhr) {
            	$('#image-upload-progress').hide();
            	uploadMessage('Ошибка загрузки файлов', 'danger');

                console.log(xhr.responseText);
            }
 
        });

        return false;
	}

});