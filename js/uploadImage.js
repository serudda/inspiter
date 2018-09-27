
(function ($) 
{
  var btn_firma = $('#button-browser-image');
  var userId    = $("#userId").val();
  new AjaxUpload('#addImage', 
  {
    action: 'web/uploadFile.php?userId='+userId,
    onSubmit : function(file , ext)
    {
       if (! (ext && /^(jpg|JPG)$/.test(ext)))
       { 
	 $.errorExtension();
       }
       else
       {
  	 $('#fotografia').attr('src','').hide();
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
           $('#fotografia').attr('src','../images/perfiles/data/'+respuesta.fileName).show();
	 }
         else
         {
           $.genericAlert(respuesta.mensaje);
	   $('#fotografia').show();
	 }
        }
       }
  });
} (jQuery));