var x, y, w, h;
var fileOrigName;
var userId    = $("#userId").val();
var jcrop_api;
var anchoOrig = '';
var altoOrig = '';

    /**************************************************************************************************/
    //                       BOTON EXAMINAR FOTOS DESDE LA COMPUTADORA
    /**************************************************************************************************/

(function ($)
 {
   // Botón para subir las fotos

   new AjaxUpload('#button-browser-image-phraseGraph', {
  		 action: 'web/uploadImagePhraseGraph.php?userId='+userId, //Aqui es cuando le das click al boton Examinar, es una copia de los demas
		 onSubmit : function(file , ext)
                 {
                   //$(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
		   //if (! (ext && /^(jpg|png)$/.test(ext))){
		   if (! (ext && /^(jpg|JPG|png|PNG)$/.test(ext)))
                   {    
		     $.errorExtension();
		   }
                   else
                   {
                     $(".ImageBeforeBlock").hide().removeClass('load');
                     $("#loadingFirstImg").fadeIn(300);
		   }
		 },
		 onComplete: function(file, response)
                 {
		   //btn_firma.text('Cambiar Imagen');
		   if (response.toString().indexOf('NOSSID') >= 0)
                   {
                     $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                     $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                   }
                   else
		   {
                     var respuesta = $.parseJSON(response);
                     anchoOrig = respuesta.anchoOrig;
                     altoOrig = respuesta.altoOrig;
                     
                     if(respuesta.respuesta == 'done')
                     {
                       fileOrigName = respuesta.fileName;
                 
                       if(anchoOrig < 900)
                       {
                         $("#centerBlockImg").addClass('centerBlockImgStyle').css('width',anchoOrig);
                       }
                       $('#ImagePhraseGraphOrig').attr('src',respuesta.fileName);
                       $(".ImagePreviewBlock").removeClass('previewBlock');
                       $('#ImagePhraseGraphOrig').load(function() 
                       {
                         $('#ImagePhraseGraphOrig').Jcrop({
                         setSelect:   [ 50, 50, 200, 200 ],
                          aspectRatio: 1,
                          trueSize: [anchoOrig,altoOrig],
                          boxWidth: 900, 
                          boxHeight: altoOrig,
                          onSelect: showCoords
                         },function(){
                           jcrop_api = this;
                         });
                         $('#titleWelcomePage').text("Selecciona la parte de la imagen que deseas, y cuando termines da click aqui:").removeClass('fontBeforeCenter').addClass('fontNew').addClass("load");
                         $("#loadingFirstImg").hide();
                         $(".ImagePreviewBlock").addClass("load");
                         $('#btn_crop_phraseGraph').addClass("load").attr("disabled",false);
                       });
                      }
                      else
                      {   
                       $.genericAlert(respuesta.mensaje);
                       $(".ImageBeforeBlock").show().addClass('load');
		       $("#loadingFirstImg").hide();
                      }
                    }	
                 }    
               });
    }(jQuery));
    
    
/**************************************************************************************************/
//          SUBIR IMAGEN DESDE UNA URL
/**************************************************************************************************/    

$("#button-add-image-phraseGraph").click(function(){

var urlAddImage = $("#FileUploadBrowserPhraseGraph").val(); 

$(".ImageBeforeBlock").hide().removeClass('load');
$("#loadingFirstImg").fadeIn(300);
        
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
      $.post('../web/uploadImagePhraseGraph_url.php?userId='+userId, 
      {
        urlAddImage: urlAddImage//le envio la url que pegue en el textfield
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
	  anchoOrig = respuesta.anchoOrig;
          altoOrig = respuesta.altoOrig;
          
	  if(respuesta.respuesta == 'done')
          {   
                       fileOrigName = respuesta.fileName;
                       //alert(respuesta.fileName+', '+respuesta.extensionOrig+', '+respuesta.tipo);
                       if(anchoOrig < 900)
                       {
                         $("#centerBlockImg").addClass('centerBlockImgStyle').css('width',anchoOrig);
                       }
                       $('#ImagePhraseGraphOrig').attr('src',respuesta.fileName);
                       $(".ImagePreviewBlock").removeClass('previewBlock');
                       $('#ImagePhraseGraphOrig').load(function() 
                       {
                         $('#ImagePhraseGraphOrig').Jcrop({
                         setSelect:   [ 50, 50, 200, 200 ],
                          aspectRatio: 1,
                          trueSize: [anchoOrig,altoOrig],
                          boxWidth: 900, 
                          boxHeight: altoOrig,
                          onSelect: showCoords
                         },function(){
                           jcrop_api = this;
                         });
                         $('#titleWelcomePage').text("Selecciona la parte de la imagen que deseas, y cuando termines da click aqui:").removeClass('fontBefore').addClass('fontNew').addClass("load");
                         $("#loadingFirstImg").hide();
                         $(".ImagePreviewBlock").addClass("load");
                         $('#btn_crop_phraseGraph').addClass("load").attr("disabled",false);
                       });
          }
	  else
	  {      
        $.genericAlert(respuesta.mensaje);
        $(".ImageBeforeBlock").show().addClass('load');
        $("#loadingFirstImg").hide();	
      }
	}
       });
     }
   });
 });
            


/**************************************************************************************************/
//         EVENTOS CLICK BOTONES: CAMBIAR IMAGEN, CORTAR IMAGEN
/**************************************************************************************************/ 

$("#btn_crop_phraseGraph").click(function()
{ 
   $("#titleWelcomePage").text("Preparando corte...");
   $("#btn_crop_phraseGraph").removeClass("load").attr("disabled","disabled");
   cortarImage();

});                
                
//EVENTO CLICK BOTON: VOLVER A CORTAR
$("#button-returnCrop-phraseGraph").click(function()
{
   $('#titleWelcomePage').text("Selecciona la parte de la imagen que deseas, y cuando termines da click aqui:").removeClass('fontBefore').addClass('fontNew').addClass("load");
   $('#btn_crop_phraseGraph').addClass("load").attr("disabled",false);
   $(".OptionsBlockPos").animate({
       'marginLeft': '-327px'
    },{ 
       duration:500,
       complete: function() 
       {
         $(".OptionsBlockPos").hide();  
         $.post("../web/eliminaImagenesTemp.php",
         {
            FimageCut: 1,
            Fimage: 0
         },
         function(data,status) 
         {
          if(data == 'NOSSID')
          {
           $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');	
           $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
          }
          else
          {
           $(this).hide();
           $(".ImageGraBlock").fadeOut(400,function()
           {
             $(".ImagePreviewBlock").show().addClass('load');
             $("#ImagePhraseGraph").attr('src','').removeClass('load');
           });     
          }
         });
       }
   });
   $(".PosTextArea").hide('slow',function(){
   $(".PosAuthorPhraseIn").hide('slow');
   $("#NotePhraseGraph").hide('slow');
    });
   $(".EditionFase").hide('slow', function() {
   $(".CropFase").fadeIn(1200);
    });         
});


//EVENTO CLICK BOTON: CAMBIAR DE IMAGEN
$("#button-changeImage-phraseGraph").click(function()
{
  jcrop_api.destroy();
  $("#ImagePhraseGraphOrig").attr('src','').removeAttr('style');
  $("#centerBlockImg").removeAttr('style').removeClass('centerBlockImgStyle');
  $('#titleWelcomePage').text("Crea una frase grafica, para inspirar más a tu mundo").removeClass('fontNew').addClass('fontBeforeCenter').removeClass("load");
  $('#btn_crop_phraseGraph').removeClass("load").attr("disabled","disabled");
  $(".ImagePreviewBlock").addClass('previewBlock').show();
  $(".OptionsBlockPos").animate({
     'marginLeft': '-327px'
    },{ 
        duration:500,
        complete: function() 
        {
          $(".OptionsBlockPos").hide();  
          $.post("../web/eliminaImagenesTemp.php",
          {
            FimageCut: 1,
            Fimage: 1
          },
          function(data,status) 
          {
           if(data == 'NOSSID')
           {
            $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');	
            $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
           }
           else
           {
            $(this).hide();
            $(".ImageGraBlock").fadeOut(400,function()
            {
              $(".ImageBeforeBlock").show().addClass('load');
              $("#ImagePhraseGraph").attr('src','').removeClass('load');
            });
           }
          });
        }
    });
    
    $(".PosTextArea").hide('slow',function(){
      $(".PosAuthorPhraseIn").hide('slow');
      $("#NotePhraseGraph").hide('slow');
    });
    
    $(".EditionFase").hide('slow', function() {
       $(".CropFase").fadeIn(1200);
    });        
});


    
    
 /**************************************************************************************************/
 //                                             FUNCIONES
 /**************************************************************************************************/
    
    function showCoords(c)
    {
      x=c.x;
      y=c.y;
      w=c.w;
      h=c.h;
    }
    
    function cortarImage()
    {
        $.ajax({
            url: "../web/uploadImageCrop.php",
            type: "POST",
            data:'x='+x+'&y='+y+'&w='+w+'&h='+h+'&fileOrigName='+fileOrigName+'&userId='+userId,//aqui envio posicion, tamaño del corte, file orginal, y userId para el nombre
            success: function(data) 
            {
               var respuesta = $.parseJSON(data);
               if(respuesta.respuesta == 'done')
               {
                 $(".ImagePreviewBlock").fadeOut(400, function(){
                     $(".OptionsBlockPos").show().animate({
                           'marginLeft': '0px'
                    }, 600);
                    $(".ImageGraBlock").fadeIn(1200,function(){
                        $("#loadingFinalCropImg").show();
                        $(".ListOption").mCustomScrollbar({set_height:488}); 
                    });
                 }).removeClass('load');
                 
                 $("#ImagePhraseGraph").attr('src','../images/graphIns/' + respuesta.fileName);
                 $("#ImagePhraseGraph").load(function() {
                     $("#loadingFinalCropImg").hide();
                     $("#ImagePhraseGraph").addClass("load");
                     $(".PosTextArea").show('slow',function(){
                        $(".PosAuthorPhraseIn").show('slow');
                        $("#NotePhraseGraph").show('slow');
                     });
                     $(".CropFase").hide('slow', function() {
                        $(".EditionFase").fadeIn(1200);
                     });   
                  });
                }
                else
                {
                  $.genericAlert(respuesta.mensaje);
                }
              },
              error: function()
              {
              }
          });
    }

       