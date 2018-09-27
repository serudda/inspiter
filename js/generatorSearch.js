$(document).ready(function(){

    /****************************************************************************************/
    //                           VARIABLES GLOBALES
    /****************************************************************************************/
 
    var QuickInspBoxSmall = $(".quick-inspiration-box");
    var shareInspiterBtnSmall = $("#sharePhrase-btn-mini");
    var shareInspiterAutorSmall = $("#sharePhrase-autor-small");
    var CharCountSmall = $(".charCount-small");
    var vSessionId = $("#sessionId");
    var doc = $(document);
    doc.data('FirstInspiterId','0');
    var InspiterArray = new Array();
    var UsersArray = new Array();
    var OptionSelected = 'inspiraciones'; //opciones (recientes,top,populares,aleatorios,seguidores)
    var inspiracionesOption = $("#inspiracionesli");
    var personasOption = $("#personasli");
    var autoresOption = $("#autoresli");
    var searchWord    = $("#searchQuery");
    var min=100000000;
    var mouse_is_inside = false;
    var OptionMenuInvAmigos = $("#inviteFriendOption");

    /****************************************************************************************/
    //                            DATOS DEL USUARIO LOOGUEADO
    /****************************************************************************************/
    var userIdLogged  = $("#userIdLogged").val();
    var fullnameLogged = $("#fullnameHidden").val();
    var usernameHidden = $("#usernameHidden").val();
    var userId        = $("#userId").val();
    var fullname      = $("#fullname").val();
    var username      = $("#userLogin").val();
    var provincia     = $("#city").val();
    var photoProfile  = $("#photo").val();
    var paisProvincia = pais+', '+provincia;
    var inviteFriends = $("#inviteFriends").val();
    var userFaceId    = $("#userFaceid").val();
    var $photosmall = $("#photosmall");
    $('#Bigloading').show();
    $('#load-more').hide();
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci�n�"inspiraciones" del menu de la derecha
    //             - Muestra las frases al seleccionar la opcion "inspiraciones" para filtrar la busqueda
    /*****************************************************************************************/
    
    inspiracionesOption.on({
        click: function()
        {  
          //$("#LoadingInspirations").hide();
          $("#menu-tope-insp").addClass("option-selected");
          $("#menu-tope-pers").removeClass("option-selected");
          $("#menu-tope-aut").removeClass("option-selected");
          $('#Bigloading').show();
          $('#message_item_no_result').remove();
          $(".grid-feed-contest-item").remove();
          $(".grid-feed-follow").remove();
	  $(".comment-wrapper").remove();
          InspiterArray = new Array();
          UsersArray  = new Array();
          /****************************************************************************************/
          //                            CREAR LAS FRASES CUANDO ESTOY EN "INSPIRACIONES"
          /****************************************************************************************/
          if(OptionSelected != "inspiraciones")
          {
              $.ajax({
                  url: "../web/mostrarPhrasesSearch.php",      
                  data: 
                      {
                        "sessionId": vSessionId.val(),
                        "type": 'inspiraciones',
                        "searchWord": searchWord.text()
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
                           BuildInspiter(data, verMas); 
                          // $("#LoadingInspirations").show();
                        }
                        else
                        {
                              setTimeout(function() {
                              $('#Bigloading').hide();
                              var msgNP = '<div id="message_item_no_result" class="message_item_no_result"><span id="textResultcero">No se encontraron inspiraciones con "'+searchWord.text()+'"</span><span style="float:left">Comprueba que el texto que especificaste no contiene errores o busca con otro texto.</span></div>';
                              $("#content").append(msgNP);
                              }, 1000);
                          }
                        }
                    },
                    error: function()
                    {
                        verificarSesion();
                        $('#Bigloading').hide();
                    }
                });
                              
                OptionSelected = "inspiraciones";
                
                return false;
            
            }else{
                setTimeout(function() {
                    $('#Bigloading').hide();
                }, 1000);
            }
        }
    });




    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci�n�"personas" del menu de la derecha
    //             - Muestra las personas al seleccionar la opcion "personas" filtrando la busqueda
    /*****************************************************************************************/
    personasOption.on({
        click: function(){
            $("#menu-tope-insp").removeClass("option-selected");
            $("#menu-tope-pers").addClass("option-selected");
            $("#menu-tope-aut").removeClass("option-selected");
            $('#Bigloading').show();
            $('#message_item_no_result').remove();
            $(".grid-feed-contest-item").remove();
            $(".grid-feed-follow").remove();
	    $(".comment-wrapper").remove();
            InspiterArray = new Array();
            UsersArray  = new Array();
            /****************************************************************************************/
            //       CREAR LOS CONTENEDORES DE PERSONAS CUANDO ESTOY EN "PERSONAS"
            /****************************************************************************************/					
            if(OptionSelected != "personas")
            {
               $.ajax({
                    url: "../web/mostrarPhrasesSearch.php",
                    
                    data: {
                        "sessionId": vSessionId.val(),
                        "type": 'personas',
                        "searchWord": searchWord.text()
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
                              BuildUsers(data);
                              //$("#LoadingInspirations").show();
                          }
                          else{
                              setTimeout(function() {
                              $('#Bigloading').hide();
                              var msgNP = '<div id="message_item_no_result" class="message_item_no_result"><span id="textResultcero">No se encontraron personas con "'+searchWord.text()+'"</span><span style="float:left">Comprueba que el texto que especificaste no contiene errores o busca con otro texto.</span></div>';
														  $("#content").append(msgNP); //TODO SERGIO, AQUI VA MENSAJE CUANDO NO SE ENCUENTRAN PERSONAS
                              }, 1000);
                             }
                         
                        }
                    },
                    error: function()
                    {
                       verificarSesion();
                       $('#Bigloading').hide();
                    }
                });
                
                OptionSelected = "personas";
                
                return false;

            }else{
                setTimeout(function() {
                    $('#Bigloading').hide();
                }, 1000);
            }
        }
    });

    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci�n�"Autores" del menu superior
    //             - Muestra los contenedores de autores al seleccionar la opcion "Autores"
    /*****************************************************************************************/
    autoresOption.on({
        click: function()
        {
            $("#menu-tope-insp").removeClass("option-selected");
            $("#menu-tope-pers").removeClass("option-selected");
            $("#menu-tope-aut").addClass("option-selected");
            $('#Bigloading').show();
            $('#message_item_no_result').remove();
            $(".comment-wrapper").remove();
            $(".grid-feed-contest-item").remove();
            $(".grid-feed-follow").remove();
            InspiterArray = new Array();
            UsersArray  = new Array();
            /****************************************************************************************/
            //      CREAR LOS CONTENEDORES DE AUTORES CUANDO ESTOY EN "AUTORES"
            /****************************************************************************************/
					
            if(OptionSelected != "autores")
            {
               $.ajax({
                    url: "../web/mostrarPhrasesSearch.php",
                    
                    data: {
                        "sessionId": vSessionId.val(),
                        "type": 'autores',
                        "searchWord": searchWord.text()
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
                             BuildInspiter(data);
                             //$("#LoadingInspirations").show();
                          }
                          else
                          {
                              setTimeout(function() {
                              $('#Bigloading').hide();
															var msgNP = '<div id="message_item_no_result" class="message_item_no_result"><span id="textResultcero">No se encontraron autores con "'+searchWord.text()+'"</span><span style="float:left">Comprueba que el texto que especificaste no contiene errores o busca con otro texto.</span></div>';
                              $("#content").append(msgNP); //TODO SERGIO, AQUI VA MENSAJE CUANDO NO SE ENCUENTRAN AUTORES
                              }, 1000);
                          }
                        }
                    },
                    error: function()
                    {
                       verificarSesion();
                       $('#Bigloading').hide();
                    }
                });

                OptionSelected = "autores";
                
                return false;
            
            }
            else{
                setTimeout(function() {
                    $('#Bigloading').hide();
                }, 1000);
            }
        }
    });

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Muestra las frases al cargar la pagina  
    /*****************************************************************************************/
   $.ajax({
       url: "../web/mostrarPhrasesSearch.php",
       data: {
               "sessionId": vSessionId.val(),
               "type": 'inspiraciones',
               "searchWord": searchWord.text()
              },
        type: "POST",
        dataType: "json",
        success: function(data) 
        {
            $('#message_item_no_result').remove();
            if(data.length > 0)
	    {
                verMas = false;
                BuildInspiter(data);
               // $("#LoadingInspirations").show();
            }
            else
            {
                setTimeout(function() 
                {
                  $('#Bigloading').hide();
 		  var msgNP = '<div id="message_item_no_result" class="message_item_no_result"><span id="textResultcero">No se encontraron inspiraciones con "'+searchWord.text()+'"</span><span style="float:left">Comprueba que el texto que especificaste no contiene errores o busca con otro texto.</span></div>';
                  $("#content").append(msgNP); 
                }, 1000);
            }
        },
        error: function()
        {
          $('#Bigloading').hide();
        }
    });
	      
		 
                    
                   
    /****************************************************************************************/
    //                            EVENTOS
    /****************************************************************************************/
                    


    var verMas = true;


    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Deshabilitar el boton "Publicar" del contenedor peque�o cuando no hay texto
    //               en el textarea.
    /*****************************************************************************************/
    QuickInspBoxSmall.keyup(function() { 
	
	
        if((QuickInspBoxSmall.val().length > 0) && (QuickInspBoxSmall.val() != ' ') ) {   
			
            shareInspiterBtnSmall.attr('disabled', false);
            shareInspiterBtnSmall.removeClass("disabled");
			
        } else {  
		
            QuickInspBoxSmall.val('');
            shareInspiterBtnSmall.attr('disabled', true);
            shareInspiterBtnSmall.addClass("disabled");
			
        }  
    });
	 

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Evitar que el usuario mantenga presionado "space key" en el textarea peque�o
    //               en el textarea.
    /*****************************************************************************************/
    QuickInspBoxSmall.keypress(function() { 

        if(QuickInspBoxSmall.val() == ' ') {
            QuickInspBoxSmall.val('');
        }
    });	

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Crear la frase despues de dar click en el boton publicar del textarea del
    //               contenedor peque�o.
    /*****************************************************************************************/

    shareInspiterBtnSmall.livequery("click", function () { //Si el usuario da click en el boton Publicar
	
        var textarea_content_small = QuickInspBoxSmall.val(); // Obtener el texto que el usuario tipio( en el textarea)
		
        //Obtener el valor en el text field del Autor
		
        var autor_content_small = shareInspiterAutorSmall.val().toUpperCase(); // Obtengo el texto del textfield del Autor y lo convierte en mayuscula
        autor_content_small = deleteSimpleBlockQuote(autor_content_small);
		
        if(autor_content_small.length == 0){    // Si el campo de Autor es vacio, asignele ANONIMO
		
            autor_content_small = 'ANONIMO';
		
        }
        textarea_content_small = deleteSimpleBlockQuote(textarea_content_small);
        //textarea_content_small = MaysPrimera(textarea_content_small);
		
        if (textarea_content_small != '') { // Si el textarea no es vacio		
            createInspiterContSmall(textarea_content_small,autor_content_small,photoProfile,fullname,username,paisProvincia);
		
            QuickInspBoxSmall.val(''); // remueve el texto en el textarea
            shareInspiterAutorSmall.val(''); // remueve el texto en el textfield del autor
            QuickInspBoxSmall.css("height","64px");
            $('#ajax_content').empty(); // vacio el textarea
            $('#ajax_flag').val(0); //reset  this to zero

            CharCountSmall.text(300);
            //Activamos el loading
            $('#loadingInspiterSmall').show();
            
		   
        } else {
	   
            $.TextareaEmpty();
		   
        }

    });



   
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Evento Click del boton "Ver Mas"
    //               contenedor peque�o.
    /*****************************************************************************************/
   
   /*
    loadMore.click(function(){
        loadMore.text('Cargando...'); 
        $.ajax({  
            url: '../web/mostrarPhrasesSearch.php',  
            data: {
                "sessionId": vSessionId.val(),
                "firstInspiterId": doc.data('FirstInspiterId'),
                "type": 'inspiraciones',
                "searchWord": searchWord.text()
            }, 
            type: "POST",  
            dataType: "json", 
            cache: false,  
            success: function(data) { 
                if (data.toString().indexOf('NOSSID') >= 0)
                 {
                   $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                   $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                 }
                 else
                 {
                    verMas = true;
                    BuildInspiter(data, verMas);
                    loadMore.text('Ver Mas');
                 }
            },  
            
            error: function() {  
            
                window.location.reload();
            }  
             
        });  
        return false;
    });

    */
    
    
    
    /****************************************************************************************/
    //                            FUNCIONES
    /****************************************************************************************/ 
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Construye las frases por partes, esta funcion es llamada por todas las demas
    //               al darle click a cada opcion (Recientes, Top 10, Aleatorios, Ver Mas, Frases Seguidores, etc)
    /*****************************************************************************************/
    
    function BuildInspiter(data,verMas)
    {
       var $content = $("#content");
       min=100000000;
       $.each(data,function(index,value) 
       {
          var wall_post_dato = '<div class="allPartInspiration" style="margin-top: 20px!important;">';
          if(data[index].IP_Type == "text")
          {
            wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';
            //dropdown menu
            wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption"><div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'"><dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'"></div><span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt><dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';
            if(data[index].SS_User_Logged != data[index].US_User_Id)
            {
               wall_post_dato += '<dd id="multi-denun_'+data[index].IP_Inspiter_Id+'" class="multi-share den"><div class="ico-multiDen"></div>Denunciar inspiraci\u00F3n</dd>';
            } 
            if(data[index].SS_User_Logged == data[index].US_User_Id)
            {
               wall_post_dato += '<dt class="multi-delete" id="multi-delete_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiDel"></div>Eliminar<div class="Del-loading" id="Del-loading_'+data[index].IP_Inspiter_Id+'"></div></dt>';
            }							
            wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><div class="phrase-box"><div class="comillas-background-right" style="margin:3px 0 0 388px!important;"><img src="images/comillas-right.png" alt=""></div> <div class="comillas-background-left"><img src="images/comillas-left.png" alt=""></div><div style="min-height:50px" class="inner-phrase"><blockquote class="pullquote">'+data[index].IP_Value1+'</blockquote><div style="position: relative; height: 26px;"><a href="#" class="autor-name">'+ data[index].IP_Value2 +'</a></div></div></div><div class="border-div"></div><div class="extra-tile-info"><div class="avatar-inspiter"><a href="/'+data[index].US_User_Login+'"><img alt="" src="'+data[index].US_Photo_Small+'" class="img-user-inspiter"></a></div><div class="avatar-user-info"><input type="hidden" value="'+data[index].US_User_Id+'" id="UserId_'+data[index].US_User_Id+'"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box">'+data[index].US_Full_Name+'</a></h4><p class="user-inspiter-city-country">'+data[index].IP_Time_Ago+'</p></div>';
            //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
            wall_post_dato += '<div class="textCountFav Count_Fav" id="Count_Fav_'+data[index].IP_Inspiter_Id+'"><ul class="countsIns" id="countsIns_'+data[index].IP_Inspiter_Id+'"><li class="inspired-button"><strong><span class="count-badge inspired-count" id="pCount_'+data[index].IP_Inspiter_Id+'">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a id="inspired_button_'+data[index].IP_Inspiter_Id+'" class="inspired-button inspired-button" href="javascript:;"><span>inspirar</span><b></b><div class="icoInsp"></div><span id="i_inspired" class="i-inspired"></span></a></li>';
            //Construimos el contador de cantidad de comentarios
            wall_post_dato += '<li class="comment-count"><strong><span id="comment_count_'+data[index].IP_Inspiter_Id+'" class="count-badge comment-count">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a id="comment_button_'+data[index].IP_Inspiter_Id+'" class="comment-button" href="javascript:;"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
            wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"><a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a><input type="hidden" value="'+data[index].IN_Inspire_Inspiter+'" id="inspireInspiter_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].FV_Is_In_Favourite+'" id="favouriteInspiter_'+data[index].IP_Inspiter_Id+'"><a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
            //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
            wall_post_dato += '<div id="comment-wrapper_'+data[index].IP_Inspiter_Id+'" class="comment-wrapper"><div class="media-inspired smallbox"><h2><span id="inspired-count_'+data[index].IP_Inspiter_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].IP_Inspiter_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].IP_Inspiter_Id+'" class="comment-container"><ul id="comment-list_'+data[index].IP_Inspiter_Id+'" class="comment-list smallul"><div id="loadingInspired_Com_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div>';
            wall_post_dato += '<p id="inspired-notice_'+data[index].IP_Inspiter_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
            wall_post_dato += '<li id="comment-loading_'+data[index].IP_Inspiter_Id+'" class="comment comload"></li></ul></div>';
            //Construye el form y el textarea para escribir un comentario
            wall_post_dato += '<form id="media_addcomment" class="media-addcomment addsmallcontainer"><label>Commentarios</label><span style="background-image: url('+$photosmall.val()+');" class="img img-inset inspired-avatar"><b></b></span><textarea name="comment_text" id="comment_text_'+data[index].IP_Inspiter_Id+'" class="placeholder" style="height: 24px;" placeholder="Opinar sobre esta inspiracion"></textarea></form></div></div>';
            if(verMas)
            {
               var $boxes = $(wall_post_dato);
               $('#content').append( $boxes ).masonry( 'appended', $boxes);
            }
            else
            {
               $content.prepend(wall_post_dato);						
            } 
            $('#comment-wrapper_'+data[index].IP_Inspiter_Id+' .comment-container').mCustomScrollbar({
              set_height:200												
            });
            //LLAMA A LA FUNCION QUE ASIGNA LOS EVENTOS A CADA UNO DE LOS ELEMENTOS DE LAS INSPIRACIONES
            $.addEvenToNewElement(data[index].IP_Inspiter_Id,data[index].SS_User_Logged,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
            if (data[index].IN_Inspire_Inspiter == 1)
            {
               $('#ins_'+data[index].IP_Inspiter_Id).addClass("dontInspire");
            }
            else
            {
               $('#ins_'+data[index].IP_Inspiter_Id).removeClass("dontInspire");
            }
           if(data[index].FV_Is_In_Favourite == 1)
           {
               $('#ico-multiFav_'+data[index].IP_Inspiter_Id).css("background-position","-23px -18px");
               $('#textFav_'+data[index].IP_Inspiter_Id).text("Quitar de Favoritos");
           }
           else
           {
           }
         }
         /*CONSTRUYE LAS IMAGENES EN LA OPCION "TODO"*/
         else if(data[index].IP_Type == "image")
         {
            wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
            //dropdown menu
            wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption"><div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'" ><dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'" ></div><span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt><dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';
            if(data[index].SS_User_Logged != data[index].US_User_Id)
            {
               wall_post_dato += '<dd id="multi-denun_'+data[index].IP_Inspiter_Id+'" class="multi-share den"><div class="ico-multiDen"></div>Denunciar inspiraci\u00F3n</dd>';
            }
            if(data[index].SS_User_Logged == data[index].US_User_Id)
            {
              wall_post_dato += '<dt class="multi-delete" id="multi-delete_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiDel"></div>Eliminar<div class="Del-loading" id="Del-loading_'+data[index].IP_Inspiter_Id+'"></div></dt>';
            }
            //fin dropdown menu
            wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><div id="phrase-box_'+data[index].IP_Inspiter_Id+'" class="phrase-box mediaPadd"><div style="height:'+data[index].IP_Value5+'px;" class="inner-phrase"><img class="lazy-load" data-src="'+data[index].IP_Value1+'" data-src-mobile="'+data[index].IP_Value1+'" src="'+data[index].IP_Value1+'" height="'+data[index].IP_Value5+'"/><div id="title-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText title-image">';
            wall_post_dato += '<p class="text-FooterImgText" id="textTitleImage">'+data[index].IP_Value4+'</p></div><div id="description-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText description-image"><p class="text-FooterImgText" id="textDescriptionImage">'+data[index].IP_Value2+'</p></div></div></div>';
            wall_post_dato += '<div class="border-div"></div><div class="extra-tile-info"><div class="avatar-inspiter">';
            wall_post_dato += '<a href="/'+data[index].US_User_Login+'"> <img alt="" src="'+data[index].US_Photo_Small+'" class="img-user-inspiter"> </a> </div>';  
            wall_post_dato += '<div class="avatar-user-info"><input type="hidden" value="'+data[index].US_User_Id+'" id="UserId_'+data[index].US_User_Id+'"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box">'+data[index].US_Full_Name+'</a></h4>';
            wall_post_dato += '<p class="user-inspiter-city-country">'+data[index].IP_Time_Ago+'</p></div>';
            //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
            wall_post_dato += '<div class="textCountFav Count_Fav" id="Count_Fav_'+data[index].IP_Inspiter_Id+'"><ul class="countsIns" id="countsIns_'+data[index].IP_Inspiter_Id+'"><li class="inspired-button"><strong><span class="count-badge inspired-count" id="pCount_'+data[index].IP_Inspiter_Id+'">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a id="inspired_button_'+data[index].IP_Inspiter_Id+'" class="inspired-button inspired-button" href="javascript:;"><span>inspirar</span><b></b><div class="icoInsp"></div><span id="i_inspired" class="i-inspired"></span></a></li>';
            //Construimos el contador de comentarios
            wall_post_dato += '<li class="comment-count"><strong><span id="comment_count_'+data[index].IP_Inspiter_Id+'" class="count-badge comment-count">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a id="comment_button_'+data[index].IP_Inspiter_Id+'" class="comment-button" href="javascript:;"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
            wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"> <a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a><input type="hidden" value="'+data[index].IN_Inspire_Inspiter+'" id="inspireInspiter_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].FV_Is_In_Favourite+'" id="favouriteInspiter_'+data[index].IP_Inspiter_Id+'">';
            wall_post_dato += '<a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
            //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
            wall_post_dato += '<div id="comment-wrapper_'+data[index].IP_Inspiter_Id+'" class="comment-wrapper"><div class="media-inspired smallbox"><h2><span id="inspired-count_'+data[index].IP_Inspiter_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].IP_Inspiter_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].IP_Inspiter_Id+'" class="comment-container"><ul id="comment-list_'+data[index].IP_Inspiter_Id+'" class="comment-list smallul"><div id="loadingInspired_Com_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div>';
            wall_post_dato += '<p id="inspired-notice_'+data[index].IP_Inspiter_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
            wall_post_dato += '<li id="comment-loading_'+data[index].IP_Inspiter_Id+'" class="comment comload"></li></ul></div>';
            //Construye el form y el textarea para escribir un comentario
            wall_post_dato += '<form id="media_addcomment" class="media-addcomment addsmallcontainer"><label>Commentarios</label><span style="background-image: url('+$photosmall.val()+');" class="img img-inset inspired-avatar"><b></b></span><textarea name="comment_text" id="comment_text_'+data[index].IP_Inspiter_Id+'" class="placeholder" style="height: 24px;" placeholder="Opinar sobre esta inspiracion"></textarea></form></div></div>';
            if(verMas)
            {
              $boxes = $(wall_post_dato);
              $('#content').append( $boxes ).masonry( 'appended', $boxes);
            }
            else
            {
              $content.prepend(wall_post_dato);
            }   
            $('#comment-wrapper_'+data[index].IP_Inspiter_Id+' .comment-container').mCustomScrollbar({
              set_height:200												
            });
            //LLAMA A LA FUNCION QUE ASIGNA LOS EVENTOS A CADA UNO DE LOS ELEMENTOS DE LAS INSPIRACIONES
            //$.addEvenToNewElement(data[index].IP_Inspiter_Id,data[index].SS_User_Logged,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
            if (data[index].IN_Inspire_Inspiter == 1)
            {
              $('#ins_'+data[index].IP_Inspiter_Id).addClass("dontInspire");
            }
            else
            {
              $('#ins_'+data[index].IP_Inspiter_Id).removeClass("dontInspire");
            }
            if(data[index].FV_Is_In_Favourite == 1)
            {
              $('#ico-multiFav_'+data[index].IP_Inspiter_Id).css("background-position","-23px -18px");
              $('#textFav_'+data[index].IP_Inspiter_Id).text("Quitar de Favoritos");
            }
            else
            {}
          }
          //obtener el minimo
          if(parseInt(data[index].IP_Inspiter_Id) < parseInt(min))
          {
            min=parseInt(data[index].IP_Inspiter_Id);
          }
      }); 
       console.log("minimo es: "+min);
       doc.data('FirstInspiterId',parseInt(min));
       /*$('#content').masonry({
                                isFitWidth: true,
                                columnWidth: 435,
                                gutterWidth: 10,
                                itemSelector:'.allPartInspiration'
                             });*/
       $('#Bigloading').hide();
    }  
             
      /**
     * Funcion que se ejecuta cuando se esta en Personas
     * //DAD = data[index].US_User_Id = OTRO 
       //SUN = userId                 = YO
      */
    function BuildUsers(data)
    {
        $.each(data,function(index,value)
        {   
            var wall_post_users = '<div id="gridUsers_'+data[index].US_User_Id+userId+'" class="grid-feed-follow feed-item-follow boxFo feed-item-newFo"><div class="border-divFo"></div><div class="btn-SeeProfile"><a href="/'+data[index].US_User_Login+'">Ver Perfil</a></div><a href="#" class="btn-Follow" id="follow_'+data[index].US_User_Id+userId+'">Seguir</a><div class="extra-tile-info-follow"><div class="avatar-inspiter-follow"><a href="/'+data[index].US_User_Login+'"><img alt="" src="'+data[index].US_Photo+'" class="img-user-inspiter-follow" alt=""></img></a></div><div class="avatar-user-info-follow"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box-follow">'+data[index].US_Full_Name+'</a></h4><a href="/'+data[index].US_User_Login+'" class="username-box-follow">'+data[index].US_User_Login+'</a><p class="follow-inspiter-city-country">'+data[index].US_City+'</p></div></div><input type="hidden" id="followUser_'+data[index].US_User_Id+userId+'" value="'+data[index].FW_Follow_Flag+'"></input></div>';
            $('#content').prepend(wall_post_users);
            UsersArray.push('gridUsers_'+data[index].US_User_Id+userId);
            addEvenToNewElementUsers(data[index].US_User_Id,userId);
            setTimeout(function() {
                $('#Bigloading').hide();
            }, 1000);
            if(data[index].FW_Follow_Flag == '1')
            {
                $('#follow_'+data[index].US_User_Id+userId).addClass("following");
                $('#follow_'+data[index].US_User_Id+userId).text('Siguiendo');								   
            }
            else
            {  
                $('#follow_'+data[index].US_User_Id+userId).removeClass("unfollowing");
                $('#follow_'+data[index].US_User_Id+userId).text('Seguir');
            }							   
        });
    }
    

    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Se remueven las comillas dobles y simples de las frases si el user las coloca
    /*****************************************************************************************/

    function checkBlockQuote(Frase)
    {      
        var fraseReturn = Frase;
	
        if(fraseReturn.substring(0,1) != '"')
        {
            fraseReturn = '"'+fraseReturn;
        } 

        if(fraseReturn.substring(fraseReturn.length-1,fraseReturn.length) != '"')
        {
            fraseReturn = fraseReturn+'"';
        }
	
        return fraseReturn;
    }

    function deleteSimpleBlockQuote(Frase)
    {
        var i = 0;    
        var fraseReturn = Frase;
	
        if(fraseReturn.substring(0,1) == '"')
        {
            fraseReturn = fraseReturn.substring(1,fraseReturn.length);
        } 

        if(fraseReturn.substring(fraseReturn.length-1,fraseReturn.length) == '"')
        {
            fraseReturn = fraseReturn.substring(0,fraseReturn.length-1);
        }
	
        for(i=0;i<5;i++)
        {
            if(fraseReturn.substring(0,1) == "'")
            {
                fraseReturn = fraseReturn.substring(1,fraseReturn.length);
            } 

            if(fraseReturn.substring(fraseReturn.length-1,fraseReturn.length) == "'")
            {
                fraseReturn = fraseReturn.substring(0,fraseReturn.length-1);
            }
	 
            i++;
        }
	
        if(fraseReturn.substring(0,1) == '"')
        {
            fraseReturn = fraseReturn.substring(1,fraseReturn.length);
        } 

        if(fraseReturn.substring(fraseReturn.length-1,fraseReturn.length) == '"')
        {
            fraseReturn = fraseReturn.substring(0,fraseReturn.length-1);
        }
	
        return fraseReturn;
    }

    function MaysPrimera(string){
        string = string.toLowerCase();
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Comparte la frase en Facebook
    /*****************************************************************************************/

    function graphStreamPublish(pFrase,vAuthor,userId,inspiterId,pFullname,pUserIdOtro,pUsername){
      if (userFaceId == null || userFaceId == '' || userFaceId == 0)
        {
           
           $.genericAlert("Debes asociar tu cuenta de facebook desde el men\u00fa configurar para poder realizar esta acci\u00f3n.");
       }
      else
      {    
        var nArray=vAuthor.split(" ");
        var NewAuthor='';
		
        if (nArray.length > 1)
        {
            for (i=0;i<nArray.length;i++)
            {
                if(i==0)
                    NewAuthor = MaysPrimera(nArray[i]);
                else
                    NewAuthor += ' '+MaysPrimera(nArray[i]);
            }
        }
        else
        {
            NewAuthor =  MaysPrimera(vAuthor);
        }
	 
        var body = pFrase + '. --'+ NewAuthor;
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
            if(userFaceId==uid)
            {     
                FB.api('/me/feed', 'post', { 
                    message:  body,
                    description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                    picture:'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                    name:  'Frase compartida de '+pFullname,
                    link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                    actions: [
                    {
                        name: 'Inspiter', 
                        link: 'http://www.inspiter.com'
                    }
                    ]
                }, function(response) {  
                    if (response)
                    {
                        verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                        $.AfterShareFace();
                        
                    }
                });
            }
             else
             {
                 $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de inspiter');
               
             }
	   
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
                $.genericAlert('Usuario no autorizado. Registrate primero');
            } else {
                FB.login(function(response) {
                    if(response.authResponse) {
                       if(userFaceId==response.authResponse.userID)
                       {
                         var body = pFrase + '. --'+ NewAuthor;  
                         FB.api('/me/feed', 'post', { 
                             message:  body,
                             description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                             picture:'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                             name:  'Frase compartida de '+pFullname,
                             link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                             actions: [
                             {
                                 name: 'Inspiter', 
                                 link: 'http://www.inspiter.com'
                             }
                             ]
                         }, function(response) {
                             if (response)
                             {
                                 verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                                 $.AfterShareFace();
                                
                             }
                         });
                       }
                       else
                           {
                               $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de inspiter');
                               
                           }
                    }
                });
            }
        }, true);
      }
    }



    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Asignar los tooltips de cada elemento en los contenedores de frase. 
    //               esta funcion es invocada cuando se esta construyendo la frase (BuildPhrase)
    /*****************************************************************************************/
    
    function AsignarTooltips() {

        $(".fb").tooltip();
        $(".tw").tooltip();

    }

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Se agregan todos los eventos a los nuevos elementos creados dinamicamente
    //               esta funcion es invocada cuando se esta construyendo la frase (BuildPhrase)
    /*****************************************************************************************/
   
	function addEvenToNewElement(pInspiterId, pUserId, pInspiterContent, pAuthor, pFullname,pUserIdOtro,pUsername, pPhotoProfile, pFullnameLogged, pUsernameLogged){
           
        /****************************************************************************************/
        //       AGREGAR EFECTO SUBE Y BAJA A LOS BOTONES SOCIALES DE COMPARTIR
        /****************************************************************************************/   
           
        $('.social-icons-share a').on({
				
            mouseenter: function(){
				
                $(this).animate({
                    marginTop:'0px'
                },100);
                $(".fb").tooltip();
                $(".tw").tooltip();
            },
				
            mouseleave: function(){
                $(this).animate({
                    marginTop:'-28px'
                },100);
            }
        });
			
        
             
        /****************************************************************************************/
        //  AGREGA EL EFECTO DE HACER APARECER Y DESAPARECER EL BOTON MULTIOPCION EN CADA FRASE 
        /****************************************************************************************/ 
		
        var $multiOptionMenu = "multiOptionMenu_"+pInspiterId;
        var $multiOptionList = "multiOptionList_"+pInspiterId;
        
	
        $('#grid_feed_contest_item_'+pInspiterId).on({
				
            mouseenter: function(){  
               /* $("#"+$multiOptionMenu).animate({
                    opacity:'1'
                },500); */
                 $("#"+$multiOptionMenu).fadeIn(200);
					
            },
				
            mouseleave: function(){ 
               /* $("#"+$multiOptionMenu).animate({
                    opacity:'0'
                },500);*/
                 $("#"+$multiOptionMenu).fadeOut(200);
            }
				  
        });
		
        /****************************************************************************************/
        //          AGREGA EL EVENTO AL BOTON MULTIOPCION PARA APARECER Y OCULTARSE 
        /****************************************************************************************/ 
        
        $("#"+$multiOptionMenu).on({
            mouseover: function(){
               $("#"+$multiOptionList).show();  
            },
            mouseleave: function(){
                $("#"+$multiOptionList).hide(); 
            }
        });
        
        
        /****************************************************************************************/
        //               AGREGA EL EVENTO CLICK AL BOTON ELIMINAR
        /****************************************************************************************/ 
        
        var idDeleteInspiter = 'multi-delete_'+pInspiterId;
        var $idDeleteLoading = 'Del-loading_'+pInspiterId;
        
        $('#'+idDeleteInspiter).on({
				
            click: function(){
				
                $('#'+$idDeleteLoading).show();
                eliminaFrase(pInspiterId,pUserId);
                return false;
            }
        });
	
	
        /****************************************************************************************/
        //     AGREGA EL EVENTO CLICK AL CONTENEDOR DE CANT DE COMENTARIOS E INSPIRACIONES
        /****************************************************************************************/
				
			
        $('#comment_button_'+pInspiterId+',#inspired_button_'+pInspiterId).on({
            click: function(){
				 
                if($('#comment-wrapper_'+pInspiterId).css("max-height") == "324px" )
                {
		
                    $('#comment-wrapper_'+pInspiterId).animate({
                        maxHeight:'0px'
                    },600);
										
					
                    //Elimina los div creados
                    $('#comment-wrapper_'+pInspiterId+' .inspired').remove();
                    
                   
		
                }
                else
                {
                    //elimina los contenediores de los comentarios
	             $('.comment').not('.comload').remove();	
                     
                    //Bajamos el contenedor
                    $('#comment-wrapper_'+pInspiterId).animate({
                        maxHeight:'324px'
                    },500);
								 
                    //Activamos los loading
                    $('.media-inspired .loadingInspired').animate({
                        opacity:'1'
                    },900);
								 
                    $('.comment-list .loadingInspired').animate({
                        opacity:'1'
                    },900);
								 
                    //Llamamos a la funcion: ShowInspired y ShowComment
		                $('#inspired_list_'+pInspiterId).addClass('inspired-slide');
                    ShowInspired(pInspiterId);
                    
                    //recupera los comentarios
                    getCommentData(pInspiterId,pUserId,pUserIdOtro);
																 
                }
              return false;
            },
            mouseenter:function(){
                mouse_is_inside=true;
            },
            mouseleave:function(){
                mouse_is_inside=false;
            }
         });
					 

        /****************************************************************************************/
        //     PARA CERRAR O ABRIR LOS COMMENT BOX SI LE DOY CLICK A CUALQUIER PARTE DE DOCUMENTO
        /****************************************************************************************/
			
        $('#comment-wrapper_'+pInspiterId).on({ 
            mouseenter:function(){
                mouse_is_inside=true;
            },
            mouseleave:function(){
                mouse_is_inside=false;
            } 
        });

        //Agrega el evento click al documento, para cuando le de click en cualquier lugar excepto 
        //los comment-wrapper, me cierre los commment-wrappers
        doc.click(function(){ 
            if(!mouse_is_inside){
                $('#comment-wrapper_'+pInspiterId).animate({
                    maxHeight:'0px'
                },300);
                setTimeout(function() {
                    $('#comment-wrapper_'+pInspiterId+' .inspired').remove();
                }, 1000);
								$('#inspired-notice_'+pInspiterId).fadeOut();
            } 
        });
	
				
        
        
        /****************************************************************************************/
        //               AGREGA EL EVENTO CLICK AL BOTON SHARE TO FACEBOOK
        /****************************************************************************************/ 
	
        $('#faceShareInspiter_'+pInspiterId).on({
		
            click: function() {
                var inspiterOk = checkBlockQuote(pInspiterContent); 
                $.post("../web/verificarSesion.php",
                function(data)
                {
                  if (data.toString().indexOf('NOSSID') < 0)
                  {graphStreamPublish(inspiterOk,pAuthor,pUserId,pInspiterId,pFullname,pUserIdOtro,pUsername);}
                  else
                  {$.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');}     
                });
                return false;
            }
        });
	
	
	
        /****************************************************************************************/
        //               EFECTO ME INSPIRA Y YA NO ME INSPIRA CUANDO LE DOY CLICK AL BOTON
        /****************************************************************************************/ 
        var flagInspireInspiter = $('#inspireInspiter_'+pInspiterId); //0 aun no inspirada, tiene q inspirar
        //1 ya inspirada, tiene q ya no inspirar
        $('#ins_'+pInspiterId).on({
				
            click: function(){
						 var  CantMeIns;
                if(flagInspireInspiter.val() == '1'){//Ya le habia dado Me Inspira
										
                    //Aqui busque si ya el user logueado le habia dado Me Inspira a esa frase, asi le elimino
                    //la foto peque?a.
                    $('#inspired_list_'+pInspiterId+' li').not('.new-inspired').each(function(index){
										
                        var $MyImage = jQuery(this).find("a").attr('href');
										
                        if($MyImage == '/'+usernameHidden){
                            jQuery(this).remove();
                        }
										 
                    });
										
                    $('#pCount_'+pInspiterId).text(parseInt($('#pCount_'+pInspiterId).text())-1);
                    $('#inspired-count_'+pInspiterId).text(parseInt($('#inspired-count_'+pInspiterId).text())-1);
									  CantMeIns = $('#pCount_'+pInspiterId).text();
                    $('#inspired_list_'+pInspiterId).addClass('inspired-slide');
                    DeleteInspiration(pInspiterId,pUserId);	
                    $(this).removeClass("dontInspire");
                    flagInspireInspiter.val("0");
						
										//Si nadie le habia dado me inspira
										if (CantMeIns == 0){
										$('#comment-wrapper_'+pInspiterId+' .media-inspired .inspired-notice').animate({
                        opacity:'1'
                    },800);
										}
										
                    return false;
		
                }else{//No le habia dado Me Inspira
                    
										 CantMeIns = $('#pCount_'+pInspiterId).text();
										//Si nadie le habia dado me inspira
										if (CantMeIns == 0){
										$('#comment-wrapper_'+pInspiterId+' .media-inspired .inspired-notice').animate({
                        opacity:'0'
                    },500);
										}
										
                    $('#pCount_'+pInspiterId).text(parseInt($('#pCount_'+pInspiterId).text())+1);
                    $('#inspired-count_'+pInspiterId).text(parseInt($('#inspired-count_'+pInspiterId).text())+1);
                    $('#inspired_list_'+pInspiterId).removeClass('inspired-slide');
                    AddInspiration(pInspiterId,pUserId,pUserIdOtro);
                    $(this).addClass("dontInspire");
                    flagInspireInspiter.val("1");
                    return false;
                
                }	
					
            }
				
        });

				
       /****************************************************************************************/
        //            AGREGA EL EVENTO PARA OBTENER EL LINK DE LA FRASE
        /****************************************************************************************/
        var obt_link = $('#multi-link_'+pInspiterId);
        var $likeButton = $('.linkButton');
        var $likeField = $('.linkField');
        var $textfieldLink = $('.textfieldLink');
        
        obt_link.on({
            click: function() {
                var serverName = $('#urlcomienzo').val();
                var url = serverName+'/'+pUsername+'&post='+pInspiterId;
                $likeButton.hide();
                $textfieldLink.show();
                $likeField.attr("value",url);
                
               //share(url,pFullname); 
            },
            mouseleave:function(){
                 
                $textfieldLink.hide();
                 $likeButton.show();
            }
        });
        
        /****************************************************************************************/
        //               AGREGA EL EVENTO PARA AGREGAR UNA FRASE A MIS FAVORITOS
        /****************************************************************************************/
        var agg_fav = $('#multi-fav_'+pInspiterId);
        //var $iconMultiFav = $('#ico-multiFav_'+pInspiterId);
        var $iconFav = $('#ico-Fav-Inspiter_'+pInspiterId);
        //var $textFav = $('#textFav_'+pInspiterId);
        var is_favourited = $('#favouriteInspiter_'+pInspiterId);
        
        agg_fav.on({
            click: function() {
                if(is_favourited.val() == 1)
                   deleteToFavourite(pInspiterId,pUserId);
                else
                   addToFavourite(pInspiterId,pUserId,pUserIdOtro);
            }
        });
        
        // Agregar/Elimina a favoritos dandole click a la estrella encima del contador de Me Inspira
        
        $iconFav.on({
            click: function() {
                if(is_favourited.val() == 1)
                   deleteToFavourite(pInspiterId,pUserId);
                else
                   addToFavourite(pInspiterId,pUserId,pUserIdOtro);
            }
        });
        
        /****************************************************************************************/
        //               AGREGA EL EVENTO PARA DEDICAR UNA FRASE
        /****************************************************************************************/
        var ded_inspiter= $('#multi-dedic_'+pInspiterId);
        
        ded_inspiter.on({
            click: function() {
               $('#dedicUsername').val(pUsername);
               $('#dedicInspiterId').val(pInspiterId);
               $('#modal-background').fadeIn(200)
               $('#modalDed').fadeIn(200)
            }
        });
        
        /****************************************************************************************/
        //               AGREGA EL EVENTO PARA CERRAR EL MODAL DEL DEDICAR
        /****************************************************************************************/
        $('#closeModalDedic').on ({
            click: function() {
               $('#modal-background').fadeOut(200)
               $('#modalDed').fadeOut(200)}
        });
        $('#modal-background').on ({
            click: function() {
               $('#modal-background').fadeOut(200)
               $('#modalDed').fadeOut(200)}
        });
				
				       /****************************************************************************************/
        //               AGREGA EL EVENTO PARA COMMENTAR CON ENTER
        /****************************************************************************************/
        var comment_text = $('#comment_text_'+pInspiterId);
				var CurrentResultCom = $('#comment_count_'+pInspiterId).text();
         comment_text.on ({
            keydown: function(e) {
								var keycodeCom = (e.keyCode ? e.keyCode : e.which);
                if(keycodeCom == 13) {      
								 var commenText = comment_text.val();
								 if(commenText != ""){
                
									 comment_text.val("");
									
									if(CurrentResultCom == '0'){ //Quiere decir que nadie a comentado
										 $('#inspired-notice_'+pInspiterId).fadeOut();
										 $('#comment-loading_'+pInspiterId).fadeOut();
										 $('#comment_container_'+pInspiterId).removeClass("NoResultCom");
										 
                }
									 insertComment(pInspiterId,pUserId,commenText,pUsernameLogged,pFullnameLogged,pPhotoProfile,pUserIdOtro)
									 e.preventDefault();

                }
         
								 e.preventDefault();
                }
               }
         
        });
        
          /****************************************************************************************/
        //               AGREGA EL EVENTO PARA DENUNCIAR UNA INSPIRACION
        /****************************************************************************************/
        var denunciar_insp = $('#multi-denun_'+pInspiterId);
        denunciar_insp.on({
            click: function() {

                $.confirm({
                               'title'		: 'Advertencia',
                               'message'	: '\u00bfSeguro que quieres denunciar esta inspiraci\u00f3n?',
                               'buttons'	: {
                                                   'Denunciar'	: {
                                                                    'class'	: 'btn btn-success',
                                                                    'action': function(){
                                                                                          denunciarInspiracion(pUserIdOtro,pInspiterId);
                                                                                        }
                                                                    },
                                                    'No denunciar'	: {
                                                                             'class'	: 'btn btn-cancel-option',
                                                                             'action': function(){}
                                                                          }
                                                }
                });
            }
        })
    } 
		
		
    
    /****************************************************************************************/
    //               ELIMINA UNA FRASE POR SU AUTOR Y POR SU ID DE FRASE
    /****************************************************************************************/
    function eliminaFrase(pInspiterId,pUserId)
    {
        $.post("../web/eliminaFrase.php", {
            inspiterId: pInspiterId, 
            userId: pUserId
        },
        function(data)
        {
            if (data.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
		$('#comment-wrapper_'+pInspiterId).fadeOut(600).remove();
                $('#grid_feed_contest_item_'+pInspiterId).fadeOut(600, function () 
                {
                  $('#grid_feed_contest_item_'+pInspiterId).remove();
                  InspiterArray.remove('grid_feed_contest_item_'+pInspiterId);
                  var resultFrases = parseInt($('#pInspiraciones').text())-1;
                  $('#pInspiraciones').text(resultFrases); 
                });
            }
        })
    }
    
    Array.prototype.remove=function(s){
        for(i=0;i<this.length;i++) if(s==this[i]) this.splice(i, 1);
    }

    /****************************************************************************************/
    //              AGREGA UN "ME INSPIRA" A LA FRASE
    /****************************************************************************************/
   
    function AddInspiration(pInspiterId,pUserId,pUserIdotro)
    {
        $.post("../web/add_delete_Inspire.php", {
            IinspiterId: pInspiterId, 
            IuserId: pUserId
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
                if(data != 'NO')
                {
                    verifAddNotification(pUserIdotro, pUserId, pInspiterId, 3);
                    return true;
                }
                else
                {
                    return false;
                }
            }
        });
    }

    
    /****************************************************************************************/
    //              ELIMINA UN "ME INSPIRA" CUANDO SE LE DA CLICK A UNA FRASE QUE YA FUE INSPIRADA
    /****************************************************************************************/
   
    function DeleteInspiration(pInspiterId,pUserId)
    {
        $.post("../web/add_delete_Inspire.php", {
            DinspiterId: pInspiterId, 
            DuserId: pUserId
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
                if(data != 'NO')
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        });
    }
    
    /****************************************************************************************/
    //  AGREGA LOS EVENTOS PARA SEGUIR, DEJAR DE SEGUIR, ANIMACIONES DE SEGUIDORES Y SIGUIENDO
    /****************************************************************************************/
   
    function addEvenToNewElementUsers(pDadId, pSunId){
        $('#follow_'+pDadId+pSunId).hover(function(){
            if($('#follow_'+pDadId+pSunId).text() == "Siguiendo")
            {
                $('#follow_'+pDadId+pSunId).removeClass("following");
                $('#follow_'+pDadId+pSunId).addClass("unfollowing");
                $('#follow_'+pDadId+pSunId).text('Dejar de Seguir');	
            }
        }, function() 
        {	
            if($('#follow_'+pDadId+pSunId).text() == "Dejar de Seguir")
            {
                $('#follow_'+pDadId+pSunId).removeClass("unfollowing");
                $('#follow_'+pDadId+pSunId).addClass("following");
                $('#follow_'+pDadId+pSunId).text('Siguiendo');
            }
        });
        var flagFollowUser = $('#followUser_'+pDadId+pSunId);
        //0 aun no inspirada, tiene q inspirar
        //1 ya inspirada, tiene q ya no inspirar
        $('#follow_'+pDadId+pSunId).on({
				
            click: function(){
                if(pDadId != pSunId)
                {
                    if(flagFollowUser.val() == '1'){
                        leaveToFollow(pDadId,pSunId);
                        $('#follow_'+pDadId+pSunId).removeClass("unfollowing");
                        $('#follow_'+pDadId+pSunId).text('Seguir');
                        $('#followUser_'+pDadId+pSunId).val("0");
                        var resultSeguidores = parseInt($('#pFollowing').text())-1;
                        $('#pFollowing').text(resultSeguidores); 
                        return false;
		
                    }else{
                        startToFollow(pDadId,pSunId);
                        $('#follow_'+pDadId+pSunId).addClass("following");
                        $('#follow_'+pDadId+pSunId).text('Siguiendo');
                        $('#followUser_'+pDadId+pSunId).val("1");
                        resultSeguidores = parseInt($('#pFollowing').text())+1;
                        $('#pFollowing').text(resultSeguidores); 
                        return false;
                    }	
                }
                else
                {
                    $.genericAlert('No puedes realizar esta acci\u00f3n');
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
                    verifAddNotification(pDadId,pSunId,0,4);
                }
                else
                {
                
                }
            }
        });
    }

    function requestCallback(response) {
        $.post("../web/inviteFriends.php", {
            IFuserId: userId, 
            IFband: 'NO' //AQUI VA NO
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
                   $.ConfigAlert("Tus invitaciones fueron enviadas a tus amigos, esperemos que se registren y puedas compartir frases", "Exitoso");
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
           message:  'Me acabo de registrar en Inspiter. Registrate tu tambien y comparte las frases mas inspiradoras',
           description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
           picture:'http://www.inspiter.com/images/logo/inspiter-logo-face2.jpg',
           name:  'Inspiter.com',
           link:'www.inspiter.com/register.php',
            description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
           actions: [
           {
              name: 'Inspiter', 
              link: 'http://www.inspiter.com'
           }
                    ]
           }, function(response) {  
                if (response)
                {
                  $.afterRegiter("Gracias por Reg\u00EDstrate en Inspiter, disfruta compartir frases inspiradoras con tus amigos","Bienvenido");
                }
                });
    }
	  
/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   18/11/2012
//Purpose:     - Envia invitaciones a amigos via facebook pro medio del boton invitar amigos del menu  
/*****************************************************************************************/
function sendRequestFriendFaceOption() {
         FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
               var uid = response.authResponse.userID;
               if(userFaceId == response.authResponse.userID)
               {
                 FB.ui({
                        method: 'apprequests',
                        display: 'iframe', 
                        message: 'Hey, estoy usando Inspiter. Reg\u00EDstrate y disfruta inspirando a gente',
                        title: "Inspiter on Facebook",
                        description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.'
                    }, function requestCallback(response) {
                        if (response != null && response != '' && response.hasOwnProperty('to')){
                            var opts = {
                             message: 'Estoy usando Inspiter. Reg\u00EDstrate y comparte con tus amigos las mejores frases',
                             name:  'Inspiter.com',
                             picture: 'http://www.inspiter.com/images/logo/inspiter-logo-face2.jpg',
                             link: 'http://www.inspiter.com',
                             description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                             caption: 'Inspiter'
                             };
                            for(i = 0; i < response.to.length; i++) {                         
                                FB.api('/' + response.to[i] + '/feed', 'post', opts, function(response){$.ConfigAlert("Tus invitaciones fueron enviadas a tus amigos, esperemos que se registren y puedas compartir frases", "Exitoso");}); 
                          }
                        }
                    });
                 }
               else
               {
                $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de inspiter');
               }
         }
    else
        {
            FB.login(function(response) {
              if(response.authResponse) {
               if(userFaceId == response.authResponse.userID)
               {      
                 FB.ui({
                        method: 'apprequests',
                        display: 'iframe', 
                        message: 'Hey, estoy usando Inspiter. Reg\u00EDstrate y disfruta inspirando a gente',
                        title: "Inspiter on Facebook"
                    }, function requestCallback(response) {
                        if (response != null && response != '' && response.hasOwnProperty('to')){
                            var opts = {
                             message: 'Estoy usando Inspiter. Reg\u00EDstrate y comparte con tus amigos las mejores frases',
                             name:  'Inspiter.com',
                             picture: 'http://www.inspiter.com/images/logo/inspiter-logo-face2.jpg',
                             link: 'http://www.inspiter.com',
                              description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                             caption: 'Inspiter'
                             };
                            for(i = 0; i < response.to.length; i++) {                         
                                FB.api('/' + response.to[i] + '/feed', 'post', opts, function(response){$.ConfigAlert("Tus invitaciones fueron enviadas a tus amigos, esperemos que se registren y puedas compartir frases", "Exitoso");}); 
                          }
                        }
                    });
                }
                else
               {
                 $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de inspiter');
               }
             }
  }, {scope: 'email,publish_stream,user_birthday'});
 }
   },{scope: 'email,publish_stream,user_birthday'});
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
 
  /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   18/11/2012
  //Purpose:     - Agrega una frase a mis favoritos  
  /*****************************************************************************************/   
  function addToFavourite(pInspiterId,pUserId,pUserIdOtro)
  {
       $.post("../web/add_Favourite.php", {
            inspiterId: pInspiterId,
            userId: pUserId
        },
        function(data)
        {
            if(data.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data.toString().indexOf('YES') >= 0)
                {
                    $('#favouriteInspiter_'+pInspiterId).val('1');
                    $('#ico-Fav-Inspiter_'+pInspiterId).css("background-position","-23px -20px");
                    $('#ico-multiFav_'+pInspiterId).css("background-position","-24px -19px");
                    $('#textFav_'+pInspiterId).text("Quitar de Favoritos");
                    verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 5);
                }
                else
                {
                     $.genericAlert('En este momento no se puede realizar esta acci\u00f3n. Intentelo mas tarde');
                }
            }
        });
  }
  
   /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   22/11/2012
  //Purpose:     - Quita una frase de mis favoritos  
  /*****************************************************************************************/   
  function deleteToFavourite(pInspiterId,pUserId)
  {
       $.post("../web/delete_Favourite.php", {
            inspiterId: pInspiterId,
            userId: pUserId
        },
        function(data)
        {
            if(data.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data.toString().indexOf('YES') >= 0)
                {
                    $('#favouriteInspiter_'+pInspiterId).val('0');
                    $('#ico-Fav-Inspiter_'+pInspiterId).css("background-position","-3px -20px");
                    $('#ico-multiFav_'+pInspiterId).css("background-position","-28px -41px");
                    $('#textFav_'+pInspiterId).text("Agregar a Favoritos");
                    
                    
                     //TODO --> CONTROLAR ESTO, AQUI SE TIENE Q PONER EN 0 EL ITEM OCULTO, ESTO SI LO ESTA HACIENDO, LUEGO
                    //QUITAR LA ESTRELLA BRILLANTE Y DEJAR LA NEGRA Y CAMBIAR EL TEXTO DEL MENU POR QUITAR A FAVORITOS
                }
                else
                {
                     $.genericAlert('En este momento no se puede realizar esta acci\u00f3n. Intentelo mas tarde');
                }
            }
        });
  }
  
   
 /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   07/12/2012
  //Purpose:     - Verifica cada uno de los llamados para chequear si se generan notificaciones o no   
  /*****************************************************************************************/   
  function verifAddNotification(pUserIdotro,pUserId,pInspiterId,pType)
  {
      if(pType == '1')
      { 
           $.ajax({
            url: "../web/add_del_seg_sig.php",
            data: {
                "seSessionId":+ vSessionId.val(),
                "seUserId":+userId
            },
            type: "POST",
            dataType: "json",
            success: function(data) 
            {
                if(data.length > 0)
                
                 if(data.toString().indexOf('NOSSID') >= 0)
                 {
                    $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                 }
                 else
                 {
                     $.each(data,function(index,value)
                      { 
                        addNotification(data[index].FW_Sun_Id, pUserId, pInspiterId, pType);
                      });
                 }
            },
            error: function(data)
            {
            									 
            }
        });
      }
     else if(pType == '2') //share to facebook
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotification(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '3') //me inspira
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotification(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '4') //seguir
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotification(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '5') //agregar a favoritos
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotification(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '6') //dedicar una frase
     {}
      else if(pType == '7')
        {
             if(pUserIdotro.toString() != pUserId.toString())
                addNotification(pUserIdotro, pUserId, pInspiterId, pType);
        }
        else if(pType == '8')
        {
            $.ajax({
                url: "../web/mostrarCommentPerfil.php",
                data: {
                     "sessionId": vSessionId.val(),
                     "inspiterId": pInspiterId
                     },
                type: "POST",
                dataType: "json",
                success: function(data) 
                {
                    if(data.length > 0)
                
                        if(data.toString().indexOf('NOSSID') >= 0)
                        {
                            $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                            $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                            $.each(data,function(index,value)
                            { 
                                 if(data[index].CM_User_id.toString() != data[index].PH_User_Id.toString() && data[index].CM_User_id != pUserId)
                                 {
                                     addNotification(data[index].CM_User_id,pUserId,data[index].CM_Inspiter_id,8);
                                 }
                            });
                        }
                },
                error: function(data)
                {
            		//alert('error');							 
                }
            });
        }
  }
  
  /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   07/12/2012
  //Purpose:     - Genera una notificacion de algun tipo  
  /*****************************************************************************************/   
  function addNotification(pUserIdotro,pUserId,pInspiterId,pType)
  {
       $.post("../web/add_notification.php", {
             userEventId: pUserId,
             userNotifiedId: pUserIdotro,
             inspiterId: pInspiterId,
             typeId: pType,
             dedicationId: '0'
         },
         function(data)
         {
             if(data.toString().indexOf('NOSSID') >= 0)
             {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
             }
             else
             {
                 if(data.toString().indexOf('YES') >= 0)
                 {
                   
                 }
                 else
                 {
                      //$.genericAlert('En este momento no se puede realizar esta acción. Intentelo mas tarde');
                 }
             }
         });
  }

	
/****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   17/12/2012
  //Purpose:     - Funcion que trae las personas que le dieron me Inspira a una frase
  /*****************************************************************************************/ 
      function ShowInspired(pInspiterId)
      {			
        var ListaUserSearch='';
              
        var dataString = 'inspiterId='+ pInspiterId;
				
        //var cacheInspired = doc.data('Inspired'+Inspiter);	 
				
        $.ajax({
            type: "POST",
            url: "/web/buscarUserInspirados.php",
            data: dataString,
            dataType: "json",
            
            
            success: function(arrayData)
            {	 
                //Siempre me tiene que traer mi imagen, para cuando le de me Inspira en el mismo instante
								
                //ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired new-inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired last">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired new-inspired"><a id="inspired_0" href="/'+usernameHidden+'"><span style="background-image: url('+$photosmall.val()+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_0" class="tooltipInspired">'+fullnameLogged+'</strong></a></li>';
								//TODO: Quitar el hardcode de mi nombre y colocar el username de la persona logueada
								
                if(arrayData.length == 0){					
								
                    $('#comment-wrapper_'+pInspiterId+' .media-inspired .inspired-notice').animate({
                        opacity:'1'
                    },600);
										
										$('#inspired_list_'+pInspiterId+' ul').append(ListaUserSearch);
                }
                else{    
                    var i=0;

                    $.each(arrayData,function(index,value) {

                        if(i<10){
											 
                            if((i == 9)){
												
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired last">'+arrayData[index].US_Full_Name+'</strong></a></li>';
												
                            }
                            else
                            {
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                            }
                        }
											

                        i++;                                                                                

                    });

                    if(i>10){
                        i = i-10;
                        //ListaUserSearch += 'y '+i+' personas m\u00e1s...';
                        ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired more"><a href="#"><span class="moreInspired">y <strong>'+i+'</strong> m\u00e1s...<b></b></span></a></li>';
                    }
               
                    $('#inspired_list_'+pInspiterId+' ul').append(ListaUserSearch); 
								 
								 
                    $.each(arrayData,function(index,value) {
										     
                        $('#inspired_'+arrayData[index].IN_Inspire_id).on({
                            mouseenter:function(){
                                $('#tooltip_'+arrayData[index].IN_Inspire_id).animate({
                                    opacity:'1'
                                },50);
                            },
                            mouseleave:function(){
                                $('#tooltip_'+arrayData[index].IN_Inspire_id).animate({
                                    opacity:'0'
                                },50);
                            }
                        });
										                                                                               
                    });					
                }
								
                $('.media-inspired .loadingInspired').animate({
                    opacity:'0'
                },100);
                
                $('.inspired').animate({
                    opacity:'1'
                },1000);						 
            }
         
        });			
    }

	
/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   29/12/2012
//Purpose:     - Funcion que recupera los comentarios de una frase especificada por parametro
/*****************************************************************************************/ 
//C1
function getCommentData(pInspiterId,pUserId,pUserIdOtro)
{
   $.ajax({
   url: "../web/mostrarCommentPerfil.php",
    data: {
            "sessionId": vSessionId.val(),
            "inspiterId": pInspiterId
          },
    type: "POST",
    dataType: "json",
    success: function(data) 
    {
      if(data.length) 
        {		
            $('.comment-list .loadingInspired').animate({
                    opacity:'0'
            },100);
            $('#comment-loading_'+pInspiterId).fadeOut(200);
            $('#inspired-notice_'+pInspiterId).fadeOut();
            buildCommentList(data,pInspiterId,pUserId,pUserIdOtro);
						
        }else{
            
             $('#comment_container_'+pInspiterId).addClass("NoResultCom");
	     $('.comment-list .loadingInspired').animate({
                    opacity:'0'
                },100);
             $('#inspired-notice_'+pInspiterId).fadeIn(800);  
        }
    
    }
 });
 
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   29/12/2012
//Purpose:     - Funcion que construye los comentarios de una frase especificada por parametro
/*****************************************************************************************/ 
//C2
function buildCommentList(data,pInspiterId,pUserId,pUserIdOtro)
{
    
    $.each(data,function(index,value) 
    {
      var list_comment =  '<li id="comment_'+data[index]['CM_Comm_id']+'" class="comment">';
          list_comment += '<div class="thumb"><a href="/'+data[index]['US_User_Login']+'"><img src="'+data[index]['US_Photo']+'"></a></div>'
          list_comment += '<div class="comment-block"><h4>';
          list_comment += '<a class="userCommented" href="/'+data[index]['US_User_Login']+'">'+data[index]['US_Full_Name']+'</a>';
          list_comment += '<div class="timestamp">'+data[index]['CM_Time_Ago']+'</div>';
          list_comment += '<p>'+data[index]['CM_Comment']+'</p>';
          list_comment += '<div class="comment-links">';
          list_comment += '<span class="script" style="display: inline;">';
          if(data[index]['US_User_Login'].toString() != usernameHidden)
          {
              list_comment += '<a id="denComment_'+data[index]['CM_Comm_id']+'" class="reply-to" href="#" title="Reportar como ofensivo u otro tipo de acto inadecuado">Reportar</a>';
          }
          if(data[index]['US_User_Login'].toString() == usernameHidden || pUserId == pUserIdOtro)
          {
              if(data[index]['US_User_Login'].toString() != usernameHidden)
              {
                  list_comment += ' - ';
              }
              list_comment += '<a id="delComment_'+data[index]['CM_Comm_id']+'" class="collapse" href="#">Eliminar</a>';
              
          }
          list_comment += '</span></div></h4></div></li>';
          
          $('#comment-list_'+pInspiterId).append(list_comment);
	
          addEvenToNewElementComment(data[index]['CM_Comm_id'],data[index]['US_User_Id'],data[index]['CM_Inspiter_id']);

    });
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   30/12/2012
//Purpose:     - Funcion que agrega los eventos de los comentarios por frase
/*****************************************************************************************/ 
//C3
function addEvenToNewElementComment(pCommentId,pUserId,pInspiterId)
{
   var idDeleteComment = 'delComment_'+pCommentId;
   $('#'+idDeleteComment).on({
     click: function(){	 
        eliminaComment(pCommentId,pUserId,pInspiterId);
        return false;
        }
   }); 
	 $('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");

 var idDenunciarComment = 'denComment_'+pCommentId;
   $('#'+idDenunciarComment).on({
     click: function(){	 
       
				$.confirm({
													 'title'		: 'Advertencia',
													 'message'	: '\u00bfSeguro que quieres denunciar este comentario?',
													 'buttons'	: {
				
								           'Denunciar'	: {
												   'class'	: 'btn btn-success',
													 'action': function(){
																			  denunciarComment(pCommentId,pUserId,pInspiterId);
																		 }
													},
								
									 				'No denunciar'	: {
													 'class'	: 'btn btn-cancel-option',
												   'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
													}
												}
								});
        return false;
        }
   }); 
   
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   30/12/2012
//Purpose:     - Funcion que elimina un comentario de una frase especifica
/*****************************************************************************************/ 
//C4
function eliminaComment(pCommentId,pUserId,pInspiterId)
{
     $.post("../web/eliminaComment.php", {
            commentId: pCommentId, 
            userId: pUserId
        },
        function(data)
        {
            if (data.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {	
                $('#comment_'+pCommentId).fadeOut(600, function () {
                    $('#comment_'+pCommentId).remove();
                    var resultCountComment = parseInt($('#comment_count_'+pInspiterId).text())-1;
                    $('#comment_count_'+pInspiterId).text(resultCountComment); 
	             switch(resultCountComment){	 
			 case 0:
				$('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");
				$('#comment_container_'+pInspiterId).addClass("NoResultCom");
											//Como destruyo el contenedor del scroll se elimina mi mensaje de "Nadie a comentado aun". Tengo que crearlo de nuevo
											//var newNoComment = '<p class="inspired-notice" id="inspired-notice_'+pPhraseId+'" style="display: block;"><span>Nadie ha comentado a?n.</span></p>';
											$('#inspired-notice_'+pInspiterId).fadeIn(800);
									
				break;
											default:
											 
											 break;
		     }
                });
                $('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");
            }
        })
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   30/12/2012
//Purpose:     - Funcion que inserta un comentario de una frase especifica
/*****************************************************************************************/ 
function insertComment(pInspiterId,pUserId,pComment,pUsername,pFullName,pPhoto,pUserIdOtro)
{
     var commentId1;
     $.post("../web/add_Comment.php", {
            inspiterId: pInspiterId,
            userId: pUserId,
            comment: pComment 
        },
        function(data)
        {
            commentId1 = data;
            if (commentId1.toString().indexOf('NOSSID') >= 0)
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {	
               if(commentId1.toString().indexOf('NO') < 0)
               {
                        var commentId = $.trim(commentId1.toString());
                        var list_comment =  '<li id="comment_'+commentId+'" class="comment">';
                            list_comment += '<div class="thumb"><a href="/'+pUsername+'"><img src="'+pPhoto+'"></a></div>'
                            list_comment += '<div class="comment-block"><h4>';
                            list_comment += '<a class="userCommented" href="/'+pUsername+'">'+pFullName+'</a>';
                            list_comment += '<div class="timestamp">Hace un instante</div>';
                            list_comment += '<p>'+pComment+'</p>';
                            list_comment += '<div class="comment-links">';
                            list_comment += '<span class="script" style="display: inline;">';
                            list_comment += ' - <a id="delComment_'+commentId+'" class="collapse" href="#">Eliminar</a>';
                            list_comment += '</span></div></h4></div></li>';       
                            $('#comment-list_'+pInspiterId).append(list_comment);	
                            var resultCountComment = parseInt($('#comment_count_'+pInspiterId).text())+1;
                            $('#comment_count_'+pInspiterId).text(resultCountComment); 
                            addEvenToNewElementComment(commentId,pUserId,pInspiterId);
                            verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 7);
                            verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 8);
                 }
             }
           });
   }
   
   /****************************************************************************************/
//@Author:       Inspiter
//Create Date:   09/01/2013
//Purpose:     - Funcion que elimina una dedicatoria
/*****************************************************************************************/ 
function eliminaDedication(pDedicationId)
{
     $.post("../web/eliminaDedication.php", {
          dedicationId: pDedicationId
       },
       function(data)
       {
          if (data.toString().indexOf('NOSSID') >= 0)
          {
              $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
              $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
           }
          else
          {	
             $('#dedInspiter_container_'+pDedicationId).fadeOut(600).remove();
             $('#dedic_container_'+pDedicationId).fadeOut(600, function () {
             $('#dedic_container_'+pDedicationId).remove();
           });
          }
        })
 }
 
 /****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/02/2013
//Purpose:     - Funcion que denuncia una inspiracion
/*****************************************************************************************/ 
function denunciarInspiracion(pUserId,pInspiterId)
{   
    $.post("../web/denunciasManager.php", {
           accuserId: userIdLogged,
           userId: pUserId,
           inspiterId: pInspiterId,
           commentId: '0',
           motive: ''
       },
       function(data)
       {
          if (data.toString().indexOf('NOSSID') >= 0)
          {
              $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
              $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
           }
          else
          {	
	      $.afterRegiter('Ud ha denunciado la inspiraci\u00f3n, estaremos analizando su denuncia.','Exitoso');
          }
        });
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/02/2013
//Purpose:     - Funcion que denuncia un comentario
/*****************************************************************************************/ 
function denunciarComment(pCommentId,pUserId,pInspiterId)
{
    $.post("../web/denunciasManager.php", {
           accuserId: userIdLogged,
           userId: pUserId,
           inspiterId: pInspiterId,
           commentId: pCommentId,
           motive: ''
       },
       function(data)
       {
          if (data.toString().indexOf('NOSSID') >= 0)
          {
              $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
              $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
           }
          else
          {	
	      $.afterRegiter('Usted ha denunciado este comentario, estaremos analizando su denuncia.','Exitoso');
          }
        });
}

});