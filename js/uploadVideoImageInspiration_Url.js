/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   06/04/2013
//Purpose:     - Verifica si la url pasada por parametro es una url de youtube valida
/*****************************************************************************************/
function isYoutubeURL(url)
{
    var matches = url.match(/^((http|https):\/\/)?(www.youtube.com)|(youtu.be)\/*?/i);
    return matches;
};

//SUBIR IMAGEN PARA VIDEO DESDE UNA URL
$("#button-add-video").click(function()
{
  var urlVideo = $("#VideoUploadBrowser").val();
  
  if(isYoutubeURL(urlVideo))
  {
    var userId    = $("#userId").val();
    $(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
    $('#previewVideo').css('background-image','');//estoy es puro visual
    $('.add-video-ico').hide();
    $('.previewVideoBlock').show();
    $('#descriptionTitleVideoBlock').show();
    
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
        $.post('../web/uploadVideoImageInspiration_url.php',
        {
          userId: userId,
          urlVideo: urlVideo
        },
        function(data) 
        {
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
		$("#previewVideo").attr('data-status','withImage');
		$('#previewVideo').css('background-image','url("../images/videoImageIns/' + respuesta.fileName+'")');
		$(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
             }
	     else
             {
                $.genericAlert(respuesta.mensaje);
                $('#previewVideo').css('background-image','').attr('data-status','withoutImage');
		$('.previewVideoBlock').hide();
		$('#descriptionTitleVideoBlock').hide();
		$('.add-video-ico').show();
             }
	   }
	 });
        }
      });
    }
    else
    { $.genericAlert('Verifique la URL del video que deseas publicar');}
   });


