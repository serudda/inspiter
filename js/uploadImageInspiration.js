
(function ($) {
    	// Botón para subir las fotos
		var btn_firma = $('#button-browser-image');
    var userId    = $("#userId").val();
			new AjaxUpload('#button-browser-image', {
				action: 'web/uploadImageInspiration.php?userId='+userId,
				onSubmit : function(file , ext){
                                    $(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
					//if (! (ext && /^(jpg|png)$/.test(ext))){
					if (! (ext && /^(jpg|JPG|png|PNG)$/.test(ext))){
						// extensiones permitidas
						//alert personalizado
						$.errorExtension();//error cuando es otra extension
						$('.previewImageBlock').hide();
						$('#descriptionTitleImageBlock').hide();
						$('.add-photo-ico').show();
						// cancela upload
					} else {
					  $('#previewImage').css('background-image','');
					  $('.add-photo-ico').hide();
					  $('.previewImageBlock').show();
					  $('#descriptionTitleImageBlock').show();
					}
				},
				onComplete: function(file, response){
					//btn_firma.text('Cambiar Imagen');
					if (response.toString().indexOf('NOSSID') >= 0)
                                        {
                                            $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                                            $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                                        }
                                        else
					{
                                            var respuesta = $.parseJSON(response);
                                            if(respuesta.respuesta == 'done'){
                                            //$('#fotografia').removeAttr('src');
					    $("#previewImage").attr('data-status','withImage');
					    $('#previewImage').css('background-image','url("'+respuesta.fileName+'")');
					    $(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
					    //$('#Image-Pos').css('background-image','url(../images/perfiles/120x120/'+respuesta.fileName+')');
                                            // $('#Image-Pos').css('background-repeat','no-repeat');
                                            //$('#loaderAjax').show();
						// alert(respuesta.mensaje);
                                                }
                                            else
                                            {
                                               $.genericAlert(respuesta.mensaje);
					       $('.previewImageBlock').hide();
                                               $('#descriptionTitleImageBlock').hide();
					       $('.add-photo-ico').show();
					    }
                                        }
          //window.location.reload();
					//$('#loaderAjax').hide();	
					//this.enable();	
                                        
				}
		});
    }(jQuery));
		
		
		
		//SUBIR IMAGEN INSPIRADORA DESDE UNA URL
		$("#button-add-image").click(function(){//este es el evento click del agregar
                // Botón para subir las fotos
		var urlAddImage = $("#FileUploadBrowser").val(); //guardo lo que tengo en el texfile
                var userId    = $("#userId").val();
		$(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
		$('#previewImage').css('background-image','');//estoy es puro visual
                $('.add-photo-ico').hide();
		$('.previewImageBlock').show();
                $('#descriptionTitleImageBlock').show();
          
          $.post("../web/eliminaImagenesTemp.php",
           function(data,status) 
           {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');	
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else 
            {  
	       $.post('../web/uploadImageInspiration_url.php?userId='+userId, //aqui hago el post a esa url
               {
                 urlAddImage: urlAddImage//le envio la url que pegue en el textfield
               },
               function(data) 
               {
		 //bueno aqui llega con la respuesta buena o mala
		 var respuesta = $.parseJSON(data);
		 if (respuesta.toString().indexOf('NOSSID') >= 0)
		 {
		    $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
		    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
		 }
		 else
		 {
		    if(respuesta.respuesta == 'done')
                    {   
		       $("#previewImage").attr('data-status','withImage');
		       $('#previewImage').css('background-image','url("'+respuesta.fileName+'")');
		       $(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
                       //aqui pues si la respuesta es "done"" hace lo de siempre
                    }
		    else
		    {
                      $.genericAlert(respuesta.mensaje);
                      $('#previewImage').css('background-image','').attr('data-status','withoutImage');
		      $('.previewImageBlock').hide();
		      $('#descriptionTitleImageBlock').hide();
		      $('.add-photo-ico').show();
                    }
		  }
		 });
               }
           });
       });
       