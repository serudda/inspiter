$(window).load(function()
{
   /****************************************************************************************/
   //                           VARIABLES GLOBALES
   /****************************************************************************************/
   var vSessionId = $("#sessionId");
   var doc = $(document);
   //var FirstInspiterId = 0;
   var $content = $("#content");
       doc.data('FirstInspiterId','0');
       doc.data('OptionInspiterType','all');
   //var OptionSelected = 'seguidores'; 
       doc.data('OptionSelected','seguidores');//opciones (siguendo,top,populares,aleatorios,todo)
   var inspiterSeguidores = $("#PhrasesSiguiendo");
   var inspiterTop10 = $("#PhrasesTop10");
   var inspiterPopulares = $("#PhrasesPopulares");
   var inspiterAleatorios = $("#PhrasesAleatorios");
   var inspiterRecientes = $("#PhrasesTodo");
   /****************************************************************************************/
   //                            DATOS DEL USUARIO LOOGUEADO
   /****************************************************************************************/

   var userId         = $("#userId").val();
   var provincia      = $("#city").val();

   //new variables
   var allOptionSort = $('#allOptionSort');
   var textOptionSort = $('#textOptionSort');
   var mediaOptionSort = $('#mediaOptionSort');
   //var OptionInspiterType = 'all'; //opciones (all, text, media)
	
    
    $('#Bigloading').show();

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opcion "Recientes" del menu superior
    //             - Muestra las inspiraciones al seleccionar la opcion "Recientes"
    /*****************************************************************************************/
    inspiterRecientes.on({
        click: function(){
            $("#LoadingInspirations").hide();
            $("#menu_siguiendo").removeClass("active-menu");
            $("#menu_top").removeClass("active-menu");
            $("#menu_populares").removeClass("active-menu");
            $("#menu_aleatorios").removeClass("active-menu");
            $("#menu_todo").addClass("active-menu");
            $('#Bigloading').show();            
            $(".grid-feed-contest-item").remove();
	    $(".comment-wrapper").remove();
	    $(".allPartInspiration").remove();
	    $('#content').masonry('destroy');
            
            allOptionSort.show();
            textOptionSort.show();
            mediaOptionSort.show();
            
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "RECIENTES"
            /****************************************************************************************/

                $("#message_item_no_result").remove();
                
                $.ajax({
                    url: "../web/showInspiters.php", 
                    data: {
                        "sessionId": vSessionId.val(),
                        "type": 'recientes',
                        "inspType": doc.data('OptionInspiterType')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          if(data.length > 0)
                          {
                           verMas = false;
                           $.BuildInspiterProfile(data, verMas);
			   $("#LoadingInspirations").show();
                          }
                          else
                          {
                              setTimeout(function() {
                              $('#Bigloading').hide();
                              }, 1000);
                          }
                        }
                    },
                    error: function()
                    {
                        verificarSesion();
                    }
                });
                doc.data('OptionSelected','recientes');
        }
    });

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opcion "Top 10" del menu superior
    //             - Muestra las inspiraciones al seleccionar la opcion "Top 10"
    /*****************************************************************************************/ 
    inspiterTop10.on({
        click: function(){
            $("#LoadingInspirations").hide();
            $("#menu_siguiendo").removeClass("active-menu");
            $("#menu_top").addClass("active-menu");
            $("#menu_populares").removeClass("active-menu");
            $("#menu_aleatorios").removeClass("active-menu");
            $("#menu_todo").removeClass("active-menu");
            $('#Bigloading').show();

            $(".grid-feed-contest-item").remove();
	    $(".comment-wrapper").remove();
	    $(".allPartInspiration").remove();
            $('#content').masonry('destroy');
            
            allOptionSort.show();
            textOptionSort.show();
            mediaOptionSort.show();
            
	    doc.data('OptionInspiterType','all');
			 
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "TOP 10"
            /****************************************************************************************/		

                $("#message_item_no_result").remove();
                $.ajax({
                    url: "../web/showInspiters.php",
                    data: {
                        "sessionId": vSessionId.val(), 
                        "type": 'top',
                        "inspType": doc.data('OptionInspiterType')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          $.BuildInspiterProfile(data,false);
                        }
                    },
                    error: function()
                    {
                       verificarSesion();
                    }
                });
                doc.data('OptionSelected','top');
                //OptionSelected = "top";
        }
    });

    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci???n???"Populares" del menu superior
    //             - Muestra las inspiraciones al seleccionar la opcion "Populares"
    /*****************************************************************************************/
    inspiterPopulares.on({
        click: function(){
            $("#LoadingInspirations").hide();
            $("#menu_siguiendo").removeClass("active-menu");
            $("#menu_top").removeClass("active-menu");
            $("#menu_populares").addClass("active-menu");
            $("#menu_aleatorios").removeClass("active-menu");
            $("#menu_todo").removeClass("active-menu");
      
            $('#Bigloading').show();

            $(".grid-feed-contest-item").remove();
	    $(".comment-wrapper").remove();
	    $(".allPartInspiration").remove();
            $('#content').masonry('destroy');
            
            allOptionSort.hide();
            textOptionSort.hide();
            mediaOptionSort.hide();
            
	    doc.data('OptionInspiterType','all');
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "POPULARES"
            /****************************************************************************************/		

                $("#message_item_no_result").remove();
                $.ajax({
                    url: "../web/showInspiters.php",
          
                    data: {
                        "sessionId": vSessionId.val(),
                        "type": 'populares',
                        "inspType": doc.data('OptionInspiterType')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          $.BuildInspiterProfile(data,false);
                        }
                    },
                    error: function()
                    {
                       verificarSesion();
                    }
                });
                doc.data('OptionSelected','populares');
                //OptionSelected = "populares";
        }
    });

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci???n???"Aleatorios" del menu superior
    //             - Muestra las inspiraciones al seleccionar la opcion "Aleatorios"
    /*****************************************************************************************/
    inspiterAleatorios.on({
        click: function(){
	    $("#LoadingInspirations").hide();
            $("#menu_siguiendo").removeClass("active-menu");
            $("#menu_top").removeClass("active-menu");
            $("#menu_populares").removeClass("active-menu");
            $("#menu_aleatorios").addClass("active-menu");
            $("#menu_todo").removeClass("active-menu");
            $('#Bigloading').show();
   
            $(".grid-feed-contest-item").remove();
	    $(".comment-wrapper").remove();
	    $(".allPartInspiration").remove();
            $('#content').masonry('destroy');
            
            allOptionSort.show();
            textOptionSort.show();
            mediaOptionSort.show();			
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "ALEATORIOS"
            /****************************************************************************************/		

                $("#message_item_no_result").remove();
                $.ajax({
                    url: "../web/showInspiters.php",

                    data: {
                        "sessionId": vSessionId.val(),
                        "type": 'aleatorios',
                        "inspType": doc.data('OptionInspiterType')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          $.BuildInspiterProfile(data,false);
                        }
                    },
                    error: function()
                    {
                        verificarSesion();
                    }
                });
                doc.data('OptionSelected','aleatorios');
                //OptionSelected = "aleatorios";                 
               }
    });


    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci???n???"Seguidores" del menu superior
    //             - Muestra las inspiraciones al seleccionar la opcion "Seguidores"
    /*****************************************************************************************/
    inspiterSeguidores.on({
        click: function(){
	    $("#LoadingInspirations").hide();
            $("#menu_siguiendo").addClass("active-menu");
            $("#menu_top").removeClass("active-menu");
            $("#menu_populares").removeClass("active-menu");
            $("#menu_aleatorios").removeClass("active-menu");
            $("#menu_todo").removeClass("active-menu");
            $('#Bigloading').show();
            $(".grid-feed-contest-item").remove();
	    $(".comment-wrapper").remove();
	    $(".allPartInspiration").remove();
            $('#content').masonry('destroy');
            
            allOptionSort.show();
            textOptionSort.show();
            mediaOptionSort.show();
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "SEGUIDORES"
            /****************************************************************************************/   

                $("#message_item_no_result").remove();
                $.ajax({
                    url: "../web/showInspiters.php",
                    data: {
                        "userId": userId,
                        "sessionId": vSessionId.val(),
                        "type": 'seguidores',
                        "inspType": doc.data('OptionInspiterType')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          if(data.length > 0)
                          {
                            verMas = false;
                            $.BuildInspiterProfile(data, verMas);
														$("#LoadingInspirations").show();
                          }
                          else
                          {
                              var msgNP = '<div id="message_item_no_result" class="message_item_no_result"><span id="textResultcero">Aun no estas siguiendo a nadie o las personas que sigues no tienen a\u00fan inspiraciones publicadas.</span></div>';
                              $content.prepend(msgNP, function(){$('#Bigloading').hide();});
                          }
                        }
                     },
                    error: function()
                    {
                       verificarSesion();
                    }
                });
                doc.data('OptionSelected','seguidores');
                //OptionSelected = "seguidores"; 
        }
    });
      
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Muestra las inspiraciones al cargar la pagina  
    /*****************************************************************************************/
   allOptionSort.show();
   textOptionSort.show();
   mediaOptionSort.show();
   $.ajax({
        url: "../web/showInspiters.php",
        data: {
                   "userId": userId,
                   "sessionId": vSessionId.val(),
                   "type": 'seguidores',
                   "inspType": 'all'
               },
        type: "POST",
        dataType: "json",
        success: function(data)  
        {
            if(data.length > 0)
            {
		verMas = false;
                $.BuildInspiterProfile(data,verMas);
            }
            else
            {
                  setTimeout(function() {
                   $('#Bigloading').hide();
                   }, 1000);
            }
        },
        error: function()
        {
            verificarSesion();
            $('#Bigloading').hide();
         }
		 
    });  
		//$('#content').masonry('reload');               
    /****************************************************************************************/
    //                            EVENTOS
    /****************************************************************************************/                  

    var verMas = true;

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Evento Click del boton "Ver Mas"
    //             
    /*****************************************************************************************/   

  $(window).scroll(function()
  {
    if ($(window).scrollTop() == $(document).height() - $(window).height())
    {
        $("#LoadingInspirations").animate({
            opacity: '1'
         },100);
        if((doc.data('OptionSelected') == 'seguidores') || (doc.data('OptionSelected') == 'recientes'))
        {
           $(".loading-ico-more").show();
           $(".load-more-inspiration").text("Cargando más inspiraciones para ti...");
           $.ajax({  
            url: '../web/showInspiters.php',  
           data: {
           "userId": userId,
           "sessionId": vSessionId.val(),
           "firstInspiterId": doc.data('FirstInspiterId'),
           "type": doc.data('OptionSelected'),
           "inspType": doc.data('OptionInspiterType')
           }, 
           type: "POST",  
           dataType: "json",
           cache: false,  
           success: function(data) 
           {
              if (data.toString().indexOf('NOSSID') >= 0)
              {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
              }
              else
              {
                if(data.length > 0)
                {
                  verMas = true; 
                  $.BuildInspiterProfile(data, verMas);
                }
                else
                {
                  $(".loading-ico-more").hide();
                  $(".load-more-inspiration").text("No hay más resultados");
                }
              }
            },  
           error: function() {  
           window.location.reload();
           }     
           });	
         }
         else
         {
            $(".loading-ico-more").hide();
         }	 
      }			
    });


      
  function addEvenToNewElementSeguidores(pDadId, pSunId)
  {	
        var flagFollowUser = $('#followUser_'+pDadId+pSunId); //0 aun no inspirada, tiene q inspirar  
				// //1 ya inspirada, tiene q ya no inspirar
        $('#follow_'+pDadId+pSunId).on({
				
            click: function(){
                if(flagFollowUser.val() == '1'){
                    leaveToFollow(pDadId,pSunId);
                    return false;
                }else{
                    startToFollow(pDadId,pSunId);
                    return false;
                }		
            }	
        });
    }    
   
    function leaveToFollow(pDadId,pSunId)
    {
        $.post("../web/add_del_seg_sig.php", {
            LFdadId: pDadId, 
            LFsunId: pSunId
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data == 'YES')
                {
                    $('#follow_'+pDadId+pSunId).text("Seguir");
                    $('#followUser_'+pDadId+pSunId).val("0");
                }
            }
        });
    }

    function startToFollow(pDadId,pSunId)
    {
        $.post("../web/add_del_seg_sig.php", {
            FdadId: pDadId, 
            FsunId: pSunId
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data == 'YES')
                {
                    $('#follow_'+pDadId+pSunId).text("Dejar de Seguir");
                    $('#followUser_'+pDadId+pSunId).val("1");
                    $.verifAddNotification(pDadId,pSunId,0,4);
                }
                else
                {
                }
            }
        });
    }
    

    /****************************************************************************************/
    //      ENVIAR MENSAJE AL MURO DEL FACEBOOK DEL USUARIO CUANDO SE REGISTRA POR PRIMERA VEZ
    /****************************************************************************************/
    function sendRequestViaMultiFriendSelector() {
        FB.ui({
            method: 'apprequests',
            message: 'Hey, estoy usando Inspiter. Reg\u00EDstrate y disfruta inspirando a gente',
            description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las inspiraciones m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con inspiraciones que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.'
        }, requestCallback);
    }
      
    function requestCallback(response) {
        $.post("../web/inviteFriends.php", {
            IFuserId: userId, 
            IFband: 'NO'
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if (data != null && response != ''){
                   $.ConfigAlert("Tus invitaciones fueron enviadas a tus amigos, esperemos que se registren y puedas compartir inspiraciones", "Exitoso");
                 }
                else
                {
                
                }
            }
        });
    }
    
    /****************************************************************************************/
    //      ENVIAR MENSAJE AL MURO DEL FACEBOOK DEL USUARIO CUANDO SE REGISTRA POR PRIMERA VEZ
    /****************************************************************************************/
    function sendNotificationFacebook()
    {
         FB.api('/me/feed', 'post', { 
           message:  'Me acabo de registrar en Inspiter. Reg\u00CDstrate tu tambien y comparte las inspiraciones mas inspiradoras',
           description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las inspiraciones m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con inspiraciones que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
           picture:'http://www.inspiter.com/images/logo/inspiter-logo-face2.jpg',
           name:  'Inspiter.com',
           link:'www.inspiter.com/register.php',
           actions: [
           {
              name: 'Inspiter', 
              link: 'http://www.inspiter.com'
           }
                    ]
           }, function(response) {  
                if (response)
                {
                  $.afterRegiter("Gracias por Reg\u00EDstrate en Inspiter, disfruta compartir inspiraciones con tus amigos","Bienvenido");
                }
                });
    }
 
 /****************************************************************************************/
 //@Author:       Inspiter
 //Create Date:   18/11/2012
 //Purpose:     - Verifica si la sesion esta activa
 /*****************************************************************************************/   
 function verificarSesion()
 {
      $.post("../web/verificarSesion.php",
        function(data)
        {
             if (data.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            { 
               
            }
        });
 }
 
 /* comienzo opciones all media texto ********/
   allOptionSort.on({
        click: function()
        {
      $("#LoadingInspirations").hide();
      $(".grid-feed-contest-item").remove();
      $(".comment-wrapper").remove();
      $(".allPartInspiration").remove();
      $('#content').masonry('destroy');
      $('#Bigloading').show();
      doc.data('OptionInspiterType','all');
            $.ajax({
             url: "../web/showInspiters.php",  
             data: {
                      "userId": userId,
                      "sessionId": vSessionId.val(),
                      "type": doc.data('OptionSelected'),
                      "inspType": doc.data('OptionInspiterType')
                    },
            type: "POST",
            dataType: "json",
            success: function(data)  
            {
              if(data.length > 0)
              {
		  verMas = false;
                 $.BuildInspiterProfile(data,verMas);
		 if((doc.data('OptionSelected') == 'seguidores') || (doc.data('OptionSelected') == 'recientes')){$("#LoadingInspirations").show();}
		  //$('#content').masonry('reload');
               }
               else
               {
                  setTimeout(function() {
                   $('#Bigloading').hide();
                   }, 1000);
               }
            },
            error: function()
            {
	       verificarSesion();
	       $('#Bigloading').hide();
            }
         });  
        }
    });

 textOptionSort.on({
        click: function()
        {
            $("#LoadingInspirations").hide();
            $(".grid-feed-contest-item").remove();
            $(".comment-wrapper").remove();
            $(".allPartInspiration").remove();
            $('#content').masonry('destroy');
            $('#Bigloading').show(); 
            doc.data('OptionInspiterType','text');
            $.ajax({
             url: "../web/showInspiters.php",  
             data: {
                      "userId": userId,
                      "sessionId": vSessionId.val(),
                      "type": doc.data('OptionSelected'),
                      "inspType": doc.data('OptionInspiterType')
                    },
            type: "POST",
            dataType: "json",
            success: function(data)  
            {
              if(data.length > 0)
              {
		 verMas = false;
                 $.BuildInspiterProfile(data,verMas);
                 if((doc.data('OptionSelected') == 'seguidores') || (doc.data('OptionSelected') == 'recientes')){$("#LoadingInspirations").show();}
               }
               else
               {
                  setTimeout(function() {
                   $('#Bigloading').hide();
                   }, 1000);
               }
            },
            error: function()
            {
		verificarSesion();
		$('#Bigloading').hide();
            }
         });
        }
    });
    
mediaOptionSort.on({
        click: function()
        {
           $("#LoadingInspirations").hide();
           $(".grid-feed-contest-item").remove();
           $(".comment-wrapper").remove();
           $(".allPartInspiration").remove();
           $('#content').masonry('destroy');
           $('#Bigloading').show(); 
            doc.data('OptionInspiterType','media');
           $.ajax({
           url: "../web/showInspiters.php",  
           data: {
                    "userId": userId,
                    "sessionId": vSessionId.val(),
                    "type": doc.data('OptionSelected'),
                    "inspType": doc.data('OptionInspiterType')
                 },
           type: "POST",
           dataType: "json",
           success: function(data)  
           {
             if(data.length > 0)
             {
		verMas = false;
                $.BuildInspiterProfile(data,verMas);
		if((doc.data('OptionSelected') == 'seguidores') || (doc.data('OptionSelected') == 'recientes')){$("#LoadingInspirations").show();}
	     }
             else
             {
                setTimeout(function() {
                  $('#Bigloading').hide();
                  }, 1000);
             }
            },
            error: function()
            {
	       verificarSesion();
	       $('#Bigloading').hide();
            }
         });  
     }  
  });
  /* fin opciones all media texto ********/
});