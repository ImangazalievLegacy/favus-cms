$(document).ready(function(){
     
	function progressHandlingFunction(e)
	{
		if(e.lengthComputable)
		{
    		var percent = ( e.loaded / e.total ) * 100;

			$('.progress-bar').css('width', percent + '%');
		}
	}

	$('.upload-image').on('click', function(event){

		event.preventDefault();

		var formdata, file, filename;

		formdata = new FormData();
		
		if ($('input[name="uploader"]')[0].files.length == 0)
		{
			return;
		}

		file = $('input[name="uploader"]')[0].files[0];
		formdata.append("file", file);

		filename = file.name;

		$.ajax({
			url: $(this).data('url'),
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
					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); //передача в функцию значений
				}
                
				return myXhr;
			},
			 
			beforeSend: function() {
			  $('.progress-bar').show();   
			},
             
			success: function(dataJson){
				$('.progress-bar').hide();
			    $('.upload-message').html('Изображение успешно загружено');
			    $('.uploaded-images').append('<li>' + filename + '</li>');

			    data = $.parseJSON(dataJson);
			    console.log(data);

			    var path = data.response;

			    $('.add-product').prepend('<input type="hidden" name="product_images[]" value="' + path + '">');			  
			},
            error: function(xhr) {
            	$('.progress-bar').hide();
                $('.upload-message').html('Ошибка загрузки файлов');

                console.log(xhr.responseText);
            }
 
        });

        return false;
	});

});