
(function ($) {
    		
                var userId    = $("#userId").val();
                var ConfigImagePredef= $("#imagePredef");
		new AjaxUpload('#changePhraseImage', {
				action: 'web/uploadImagePhraseIn.php?userId='+userId,
				name: 'changePhraseImg',
				onSubmit : function(file , ext){
					if (! (ext && /^(jpg|JPG)$/.test(ext)))
                                        {
				          $.errorExtension();
					} else 
                                        {
					  $('#ImagePhraseIn').attr('src','').hide();
					}
				},
				onComplete: function(file, response)
                                {
					if (response.toString().indexOf('NOSSID') >= 0)
                                        {
                                            $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                                            $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                                        }
                                        else
					{
					  var respuesta = $.parseJSON(response);
					  if(respuesta.respuesta == 'done')
                                          {
                                             $('#ImagePhraseIn').attr('src','/images/PhraseIns/'+respuesta.fileName).show();
					     ConfigImagePredef.val("");
					  }
                                          else
                                          {
                                              $.genericAlert(respuesta.mensaje);
					      $('#ImagePhraseIn').show();
					  }
                                        }
				}
		});
    } (jQuery));