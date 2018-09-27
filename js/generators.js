
$(window).load(function()
{
    /****************************************************************************************/
    //                           VARIABLES GLOBALES
    /****************************************************************************************/

    var vSessionId = $("#sessionId");
    var $content = $("#content");
    var doc = $(document);
        doc.data('FirstInspiterId','0');
    var inspiracionesLi = $("#inspiracionesli");
    var siguiendoLi = $("#siguiendoli");
    var seguidoresLi = $("#seguidoresli"); 
    var favoritosLi = $("#favoritosli");
    var dedicacionesLi = $("#dedicationli");
    var v_typeMenu = $("#typeMenu");
    var v_inspiterId = $("#inspiterId").val();
    var v_dedicId = $("#dedicId").val();
    var OptionSelected = 'inspiraciones';
    var FollowSegArray = new Array();
    var FollowSigArray = new Array();
    var $profile_body = $('.profile-body');
    var verMas;
    
    var allOptionSort = $('#allOptionSort');
    var ico_all_inspirations = $(".ico-all-inspirations");
    var ico_text_inspirations = $(".ico-text-inspirations");
    var ico_media_inspirations = $(".ico-media-inspirations");
    var textOptionSort = $('#textOptionSort');
    var mediaOptionSort = $('#mediaOptionSort');
    var $textImgPhrase = $("#textImgPhrase");
    var $textImgAuthor = $("#textImgAuthor");
    var $PhraseInfoBlock = $(".PhraseInfoBlock");
    //var $imagenPhrase = 'url("'+$("#imagenPhrase").val()+'")';
    var $imagenPhrase = $("#imagenPhrase").val();
	doc.data('OptionInspiterType','all');
    var fullnameHidden      = $("#fullnameHidden").val();
    var usernameHidden = $("#usernameHidden").val();
    var IPSAmount = $("#IPSAmount").val();
    var ips_value_div = $("#ips_value_div");
    var slide_control = $(".slide-control");
    var stateProfileFriend = $("#stateProfileFriend");
    /****************************************************************************************/
    //                            DATOS DE USUARIO
    /****************************************************************************************/
    var userId         = $("#useridhidden").val();
    var fullname       = $("#fullnameInput").val();
    var username       = $("#usernameInput").val();
    var paisProvincia  = $("#cityInput").val();
    var photoProfile   = $("#photoUrl").val();
    var photosmall =    $("#photosmall");
    var userIdLogged   = $("#userIdLogged").val();
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   02/01/2013
    //Purpose:     - A?ade dos funciones para obtener los parametros de de una url por GET. 
    /*****************************************************************************************/
    $.extend({
       getUrlVars: function(){
       var vars = [], hash;
       var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
       for(var i = 0; i < hashes.length; i++)
       {
         hash = hashes[i].split('=');
         vars.push(hash[0]);
         vars[hash[0]] = hash[1];
       }
       return vars;
       },
       getUrlVar: function(name){
         return $.getUrlVars()[name];
       }
     });
    
    var byName = $.getUrlVar('postFace');
    if(byName == 'yes')
    { 
        $.ajax({
                    url: "../web/sendFaceDedication.php",
                    data: {
                        "dedicId": $.getUrlVar('dedicId')
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        var inspiterComment =  data[0].DD_Comment;
                        graphStreamPublishDedication(
                        inspiterComment,'author',data[0].IP_By_User_Id,
                        data[0].DD_Inspiter_Id,data[0].US_Full_Name,data[0].DD_To_User_Id,
                        data[0].IP_User_Login,data[0].DD_Dedications_Id,data[0].DD_From_User_Id,
                        data[0].DD_Full_Name_From,data[0].US_Face_Id,data[0].US_User_Login,data[0].DD_Inspiter_Type);
                    }
         });
     }
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   21/03/2013
    //Purpose:     - Aplica el estilo de la frase insignia, el autor y la imagen de fondo
    /*****************************************************************************************/
     $.ajax({
            url: "../web/getStyles.php", 
            data: {
                     "userId": userId
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
                           $("#loadingPhraseIns").show();
                           
                           $textImgPhrase.css({
                             'top':data[0].phraseTop,
                                   'left':data[0].phraseLeft,
                                   'font-family':data[0].fontFamily,
                                   'font-size':data[0].fontSize,
                                   'font-weight':data[0].fontWeight,
                                   'font-style' :data[0].fontStyle
                            });

                            $textImgAuthor.css({
                                   'top':data[0].authorTop,
                                   'left':data[0].authorLeft
                            });

                            /*$PhraseInfoBlock.css({
                                   'background-position':'0px '+data[0].imageTop,
                                   'background-image': $imagenPhrase
                            });*/ 
                                
                            if($imagenPhrase == ''){    
                                $("#loadingPhraseIns").hide();    
                                $("#NoPhraseInsText").addClass("load");  
                            }
                            else{
                                $("#ImagePhraseProfile").attr('src',$imagenPhrase).css({
                                       'top':data[0].imageTop
                                }).load(function(){
                                    $("#loadingPhraseIns").hide();
                                    $(this).addClass("load",function(){
                                        $("#textBlockPhraseIns").addClass("load"); 
                                    }); 
                                });
                            }
                            
                            /*MUESTRA LA FRASE INSIGNIA SI EL USER DEJO EL SWITCH ACTIVADO*/
                           if(stateProfileFriend.val() == 1)
                           {
                             slide_control.css({top:"150px"});
                             $PhraseInfoBlock.css("z-index","2"); 
                             $PhraseInfoBlock.css({opacity:"1"});
                           }
                           else
                           {
                             slide_control.css({top:"7px"});
                             $PhraseInfoBlock.css("z-index","0")
                             $PhraseInfoBlock.css({opacity:"0"});
                           }
                           /*END: MUESTRA LA FRASE INSIGNIA SI EL USER DEJO EL SWITCH ACTIVADO*/
                          }
                          else
                          {
                             
                          }
                        }
                    },
                    error: function()
                    {
                        verificarSesion();
                    }
            });
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Pregunta que opcion viene por par?metro para mostrar inspiraciones, siguiendo o seguidores de un usuario espec?fico
    //             - Opciones: flol->siguiendo fler->seguidores <sin parametro>->inspiraciones
    /*****************************************************************************************/
    if(v_typeMenu.val() == 'flol')
    {
        OptionSelected = 'siguiendo';
    }
    else
    if(v_typeMenu.val() == 'fler')  
    {
        OptionSelected = 'seguidores';
    }
    else
    if(v_typeMenu.val() == 'favo')
    {
        OptionSelected = 'favoritos';
    }
    else
    if(v_typeMenu.val() == 'dedic' || (v_dedicId != 0 && v_dedicId != null))
    {
        OptionSelected = 'dedicaciones';
    }
    else
    {
        OptionSelected = "inspiraciones";
    }
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Agrega el evento click a la opci?n "Mis inspiraciones" del menu de la derecha
    //             - Muestra las inspiraciones del usuario logueado
    /*****************************************************************************************/
    inspiracionesLi.on({  
        click: function(){
                $("#LoadingInspirations").hide();
                $("#menu-tope-insp").addClass("active-menu");
                $("#menu-tope-seg").removeClass("active-menu");
                $("#menu-tope-sig").removeClass("active-menu");
                $("#menu-tope-pref").removeClass("active-menu");
                $("#menu-tope-ded").removeClass("active-menu");
                $('#Bigloading').show();
                /****************************************************************************************/
                //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "MIS INSPIRACIONES"
                /****************************************************************************************/
                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
		$(".comment-wrapper").remove();
		$(".allPartInspiration").remove();
		$('#content').masonry('destroy');
                $('.ded-wrapper').remove();
				
		allOptionSort.show();
                textOptionSort.show();
		mediaOptionSort.show();

                $.ajax({
                    url: "../web/showInspiters.php",
                    
                    data: {
                        "userId": userId,
                        "sessionId": vSessionId.val(),
                        "inspiterId": v_inspiterId,
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
                                $.BuildInspiterProfile(data, verMas);  // Se construyen los contenedores de "MIS INSPIRACIONES" 
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
                    error: function(data)
                    {
                        verificarSesion();
                    }
                });
            OptionSelected = "inspiraciones";
            return false;
        }
    });
	  
	  
    /****************************************************************************************/
    //Author:      Inspiter
    //Create Date: 15/09/2012
    //Purpose:     - Agrega el evento click a la opci?n "Seguidores" del menu de la derecha
    //             - Muestra los seguidores del usuario logueado
    /*****************************************************************************************/
    
    seguidoresLi.on({
        click: function(){
            $("#menu-tope-insp").removeClass("active-menu");
            $("#menu-tope-seg").addClass("active-menu");
            $("#menu-tope-sig").removeClass("active-menu");
            $("#menu-tope-pref").removeClass("active-menu");
            $("#menu-tope-ded").removeClass("active-menu");
	    $("#LoadingInspirations").hide();
            $('#Bigloading').show();
            
            /****************************************************************************************/
            //           CREAR LOS CONTENEDORES CUANDO ESTOY EN "MIS SEGUIDORES"
            /****************************************************************************************/
            
                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
		$(".allPartInspiration").remove();
                $('.ded-wrapper').remove();
                $(".comment-wrapper").remove();
								
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
		$('#content').masonry('destroy');
                
                allOptionSort.hide();
                textOptionSort.hide();
		mediaOptionSort.hide();
                
                FollowSegArray = new Array();
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
                                BuildSeg(data); // Se construyen los contenedores de "SEGUIDORES"
                            }
                            else
                            {
                                setTimeout(function() {
                                    $('#Bigloading').hide();
                                    var msgNP = '<div id="message_item_no_result_seg"><div class="imgPosWall Ifollow"></div><div class="message_item_no_result profile"><span id="textResultcero">';
                                     if(userIdLogged == userId)
                                      msgNP += 'Aun no tienes seguidores, publica tus inspiraciones, sigue a otras personas, de esa manera te empezar\u00e1n a seguir.';
                                     else
                                      msgNP += fullname+' aun no tiene seguidores. Siguela y haz que la sigan tus amigos tambi\u00E9n.';
                                     msgNP+='</span></div></div>';
                                    $('#content').prepend(msgNP);
                                }, 1000);
                            }
                        }  
                    },
                    error: function(data)
                    {
                        $('#Bigloading').hide();
			verificarSesion();						
                    }
                });

            OptionSelected = "seguidores";
            return false;
        }
    });
	



    /****************************************************************************************/
    //Author:      Inspiter
    //Create Date: 15/09/2012
    //Purpose:     - Agrega el evento click a la opci?n "Siguiendo" del menu de la derecha
    //             - Muestra los usuarios que sigue el usuario logueado
    /*****************************************************************************************/
    siguiendoLi.on({	
        click: function(){
            $("#menu-tope-insp").removeClass("active-menu");
            $("#menu-tope-seg").removeClass("active-menu");
            $("#menu-tope-sig").addClass("active-menu");
            $("#menu-tope-pref").removeClass("active-menu");
            $("#menu-tope-ded").removeClass("active-menu");
            $('#Bigloading').show();
	    $("#LoadingInspirations").hide();
                                 
            /****************************************************************************************/
            //           CREAR LOS CONTENEDORES CUANDO ESTOY EN "SIGUIENDO"
            /****************************************************************************************/

                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
                $(".comment-wrapper").remove();
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
		$(".allPartInspiration").remove();
		$('#content').masonry('destroy');
                $('.ded-wrapper').remove();
                
                allOptionSort.hide();
                textOptionSort.hide();
		mediaOptionSort.hide();
								
                FollowSigArray = new Array();
                $.ajax({
                    url: "../web/add_del_seg_sig.php",
                    data: {
                        "siSessionId":+ vSessionId.val(),
                        "siUserId":+userId
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
                                BuildSig(data); // Se construyen los contenedores de "SIGUIENDO"
                            }
                            else
                            {
                                setTimeout(function() {
                                    $('#Bigloading').hide();
                                     var msgNP = '<div id="message_item_no_result_sig"><div class="imgPosWall Ifollow"></div><div class="message_item_no_result profile"><span id="textResultcero">';
                                     if(userIdLogged == userId)
                                      msgNP += 'Aun no estas siguiendo a nadie. ¿Qu\u00e9 esperas?, sigue a diferentes personas para poder ver sus inspiraciones.';
                                     else
                                      msgNP += fullname+' aun no esta siguiendo a nadie. Cont\u00e1ctala y recomendale personas a seguir.';
                                     msgNP+='</span></div></div>';
                                    
                                    $('#content').prepend(msgNP);
                                }, 1000);
                            }
                        }    
                    },
                    error: function(data)
                    {
                        $('#Bigloading').hide();
                    }
                });
            
            OptionSelected = "siguiendo";
            return false;
        }
    });
    
   
    /****************************************************************************************/
    //Author:      Inspiter
    //Create Date: 23/09/2012
    //Purpose:     - Agrega el evento click a la opci?n "Preferidos" del menu de la derecha
    //             - Muestra las inspiraciones que tu agregaste a favoritos
    /*****************************************************************************************/
    favoritosLi.on({	
        click: function(){
				    $("#LoadingInspirations").hide();
            $("#menu-tope-insp").removeClass("active-menu");
            $("#menu-tope-seg").removeClass("active-menu");
            $("#menu-tope-sig").removeClass("active-menu");
            $("#menu-tope-pref").addClass("active-menu");
            $("#menu-tope-ded").removeClass("active-menu");
            $('#Bigloading').show();
            /****************************************************************************************/
            //                            CREAR LAS INSPIRACIONES CUANDO ESTOY EN "MIS PREFERIDOS"
            /****************************************************************************************/
            	
                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
		$(".allPartInspiration").remove();
                $(".comment-wrapper").remove();
		$('#content-second').show().css("height","92px");
                
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
                $('#content').masonry('destroy');
                $('.ded-wrapper').remove();
                
                allOptionSort.show();
                textOptionSort.show();
		mediaOptionSort.show();
                
                $.ajax({
                    url: "../web/showInspiters.php",
                    data: {
                        "userId": userId,
                        "sessionId": vSessionId.val(),
                        "inspiterId": v_inspiterId,
                        "type": 'favoritos',
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
                              $.BuildInspiterProfile(data, verMas);  // Se construyen los contenedores de "MIS FAVORITOS" 
																$("#LoadingInspirations").show();
                            }
                            else
                            {
                                setTimeout(function() {
                                    $('#Bigloading').hide();
                                    var msgNP = '<div id="message_item_no_result_fav"><div class="imgPosWall IFav"></div><div class="message_item_no_result profile"><span id="textResultcero">';
                                     if(userIdLogged == userId)
                                      msgNP += 'Aun no tienes favoritos. Agrupa las mejores inspiraciones de cada persona en un solo lugar, para que las puedas encontrar mucho m\u00e1s r\u00e1pido.';
                                     else
                                      msgNP += fullname+' aun no tiene favoritos. Hazle saber que agrupando las mejores inspiraciones en favoritos, luego las encontrar\u00e1 de una manera mas f\u00e1cil';
                                     msgNP+='</span></div>';
                                    $('#content').prepend(msgNP);
                                }, 1000);
                            } 
                        }
                    },
                    error: function(data)
                    {
                        $('#Bigloading').hide();
                    }
                });

            OptionSelected = "favoritos";
            return false;
        }
    })
    
       
    /****************************************************************************************/
    //Author:      Inspiter
    //Create Date: 23/09/2012
    //Purpose:     - Agrega el evento click a la opci?n "Favoritos" del menu de la derecha
    //             - Muestra las dedicatorias que te hicieron los usuarios
    /*****************************************************************************************/
   dedicacionesLi.on({	
        click: function(){
	    $("#LoadingInspirations").hide();
            $("#menu-tope-insp").removeClass("active-menu");
            $("#menu-tope-seg").removeClass("active-menu");
            $("#menu-tope-sig").removeClass("active-menu");
            $("#menu-tope-pref").removeClass("active-menu");
            $("#menu-tope-ded").addClass("active-menu");
            $('#Bigloading').show();
            
            /****************************************************************************************/
            //             CREAR LAS DEDICATORIAS CUANDO ESTOY EN "MIS DEDICACIONES"
            /****************************************************************************************/

                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
                $(".comment-wrapper").remove();
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
		$(".allPartInspiration").remove();
		$('#content').masonry('destroy');
                $('.ded-wrapper').remove();
                
                allOptionSort.hide();
                textOptionSort.hide();
		mediaOptionSort.hide();
                $.ajax({
                    url: "../web/mostrarDedicPerfil.php",
                    data: {
                        "userId": userId,
                        "sessionId": vSessionId.val(),
                        "dedicId": v_dedicId
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
                                BuildDedicationProfile(data, verMas);  // Se construyen los contenedores de "MIS DEDICACIONES"                  
														$("#LoadingInspirations").show();
                            }
                            else
                            {
                                    setTimeout(function() {
                                    $('#Bigloading').hide();
                                    var msgNP = '<div id="message_item_no_result_ded"><div class="imgPosWall IDedic"></div><div class="message_item_no_result profile"><span id="textResultcero">Aun no te han dedicado algo. No te preocupes, cuando menos te lo esperes, te sorprender\u00e1n.</span></div></div>';
                                    $('#content').prepend(msgNP);
                                }, 1000);
                            } 
                        }
                    },
                    error: function(data)
                    {
                        $('#Bigloading').hide();
                    }
                });

            OptionSelected = "dedicaciones";
            return false;
        }
    })
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Muestra las inspiraciones, seguidores o siguiendo al cargar la pagina  segun un criterio
    //  - Criterio: Si la variable OptionSelected tiene el valor "inspiraciones" muestra las inspiraciones del usuario del perfil
    //  - Si la variable OptionSelected tiene el valor "seguidores" muestra los seguidores del usuario del perfil
    //  -Si la variable OptionSelected tiene el valor "siguiendo" muestra los usuarios que sigue el usuario del perfil
    /*****************************************************************************************/
   if(OptionSelected == "dedicaciones")
   {
       $("#LoadingInspirations").hide();
            $("#menu-tope-insp").removeClass("active-menu");
            $("#menu-tope-seg").removeClass("active-menu");
            $("#menu-tope-sig").removeClass("active-menu");
            $("#menu-tope-pref").removeClass("active-menu");
            $("#menu-tope-ded").addClass("active-menu");
            $('#Bigloading').show();
            
            /****************************************************************************************/
            //             CREAR LAS DEDICATORIAS CUANDO ESTOY EN "MIS DEDICACIONES"
            /****************************************************************************************/

                $(".grid-feed-follow").remove();
                $(".grid-feed-contest-item").remove();
                $(".comment-wrapper").remove();
                $("#message_item_no_result_seg").remove();
                $("#message_item_no_result_sig").remove();
                $("#message_item_no_result_fav").remove();
                $("#message_item_no_result_ded").remove();
		$(".allPartInspiration").remove();
		$('#content').masonry('destroy');
                $('.ded-wrapper').remove();
                
                allOptionSort.hide();
                textOptionSort.hide();
		mediaOptionSort.hide();
                $.ajax({
                    url: "../web/mostrarDedicPerfil.php",
                    data: {
                        "userId": userId,
                        "sessionId": vSessionId.val(),
                        "dedicId": v_dedicId
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
                                BuildDedicationProfile(data, verMas);  // Se construyen los contenedores de "MIS DEDICACIONES"                  
														$("#LoadingInspirations").show();
                            }
                            else
                            {
                                    setTimeout(function() {
                                    $('#Bigloading').hide();
                                    var msgNP = '<div id="message_item_no_result_ded"><div class="imgPosWall IDedic"></div><div class="message_item_no_result profile"><span id="textResultcero">Aun no te han dedicado algo. No te preocupes, cuando menos te lo esperes, te sorprender\u00e1n.</span></div></div>';
                                    $('#content').prepend(msgNP);
                                }, 1000);
                            } 
                        }
                    },
                    error: function(data)
                    {
                        $('#Bigloading').hide();
                    }
                });

            OptionSelected = "dedicaciones";
            return false;
   }
   else
   {
        $("#menu-tope-insp").addClass("active-menu");
        $("#menu-tope-seg").removeClass("active-menu");
        $("#menu-tope-sig").removeClass("active-menu");
        $("#menu-tope-pref").removeClass("active-menu");
        $("#menu-tope-ded").removeClass("active-menu");
        $('#Bigloading').show();
        
        $("#message_item_no_result_seg").remove();
        $("#message_item_no_result_sig").remove();
        $("#message_item_no_result_fav").remove();
        $("#message_item_no_result_ded").remove();
        
       if(v_inspiterId != '0')
         {
           //doc.data('OptionInspiterType','text');
           allOptionSort.hide();
           textOptionSort.hide();
	   mediaOptionSort.hide();
           $('#userMenu').hide();
         }
         else
         {
           allOptionSort.show();
           textOptionSort.show();
	   mediaOptionSort.show();
           $('#userMenu').show();
         }
        $.ajax({
            url: "../web/showInspiters.php",
            data: 
            {
                "userId": userId,
                "sessionId": vSessionId.val(),
                "inspiterId": v_inspiterId,
                "inspType": doc.data('OptionInspiterType')
            },
            type: "POST",
            dataType: "json",
            success: function(data) 
            {
                if(data.length > 0)
                {
                    verMas = false;
                   $.BuildInspiterProfile(data, verMas);  // Se construyen los contenedores de "MIS INSPIRACIONES"
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
            }
        });
   }
	

    /****************************************************************************************/
    //                            EVENTOS
    /****************************************************************************************/
     
   
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   23/09/2012
    //Purpose:     - Evento Click del boton "Ver Mas" para las inspiraciones y los favoritos
    /*****************************************************************************************/
     
    $(window).scroll(function(){
         
		  if ($(window).scrollTop() == $(document).height() - $(window).height()){
                      if(OptionSelected != "dedicaciones" && (v_inspiterId == null || v_inspiterId == 0)){
				
				$("#LoadingInspirations").animate({
					 opacity: '1'
				 },100);
				
        switch(OptionSelected){
				 
				 case 'inspiraciones':
					$(".loading-ico-more").show();
			      $(".load-more-inspiration").text("Cargando más inspiraciones para ti...");
					$.ajax({  
                url: '../web/showInspiters.php',  
                data: {
                    "userId": userId,
                    "sessionId": vSessionId.val(),
                    "firstInspiterId": doc.data('FirstInspiterId'),
                    "inspType": doc.data('OptionInspiterType')
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
										    if(data.length > 0){
                        verMas = true;
                      $.BuildInspiterProfile(data,verMas);
												}else{
												 $(".loading-ico-more").hide();
												 $(".load-more-inspiration").text("No hay más resultados");
												}
                    }   
          
                },  
                //failure class  
                error: function() {  
                }
            });
						
						$("#LoadingInspirations").animate({
					    opacity: '0'
					  },3000);
						
					break;
				 case 'favoritos':
					$(".loading-ico-more").show();
			      $(".load-more-inspiration").text("Cargando más inspiraciones para ti...");
					$.ajax({  
                url: '../web/showInspiters.php',  
                data: {
                    "userId": userId,
                    "sessionId": vSessionId.val(),
                    "firstInspiterId": doc.data('FirstInspiterId'),
                    "type": 'favoritos',
                    "inspType": doc.data('OptionInspiterType')
                }, 
                type: "POST",  
                dataType: "json",  
                cache: false,  
                success: function(data) {  //en data vienen las 20 nuevas inspiraciones
                    if (data.toString().indexOf('NOSSID') >= 0)
                    {
                        $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                        $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                    }
                    else
                    {
										 if(data.length > 0){
                        verMas = true;
                       $.BuildInspiterProfile(data,verMas);
												}else{
												 $(".loading-ico-more").hide();
												 $(".load-more-inspiration").text("No hay más resultados");
												}
                    }   
          
                },  
                //failure class  
                error: function() {  
                }
            });
						$("#LoadingInspirations").animate({
					    opacity: '0'
					  },3000);
					break;
					default:
					 break;
				}

		}
    }
    });
	
	
    /****************************************************************************************/
    //                            FUNCIONES
    /****************************************************************************************/ 
    
    /**
 * Funcion que se ejecuta cuando se esta en SIGUIENDO
 */
    function BuildSig(data) {
    
        $.each(data,function(index,value)
        { // SUN YO,DAD OTRO
            var wall_post_siguiendo = '<div class="allPartPerson"><div id="gridSiguiendo_'+userIdLogged+data[index].FW_Dad_Id+'" class="grid-feed-follow feed-item-follow boxFo feed-item-newFo"><div class="border-divFo"></div><div class="btn-SeeProfile"><a href="/'+data[index].US_User_Login+'">Ver Perfil</a></div><a href="#" class="btn-Follow" id="follow_'+userIdLogged+data[index].FW_Dad_Id+'">Seguir</a><div class="extra-tile-info-follow"><div class="avatar-inspiter-follow"><a href="/'+data[index].US_User_Login+'"><img alt="" src="'+data[index].US_Photo+'" class="img-user-inspiter-follow" alt="../images/perfiles/avatar-inspiter.jpg"></img></a></div><div class="avatar-user-info-follow"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box-follow">'+data[index].US_Full_Name+'</a></h4><a href="/'+data[index].US_User_Login+'" class="username-box-follow">'+data[index].US_User_Login+'</a><p class="follow-inspiter-city-country">'+data[index].US_City+'</p></div><div class="BlockIpsPerson"><table><tbody><tr><td><span id="ipsPerson">'+data[index].CF_IPS+'</span> ips</td></tr></tbody></table></div></div><input type="hidden" id="followUser_'+userIdLogged+data[index].FW_Dad_Id+'" value="'+data[index].FW_Follow_Flag+'"></input></div></div>';
            $('#content').prepend(wall_post_siguiendo);
            FollowSigArray.push('gridSiguiendo_'+userIdLogged+data[index].FW_Dad_Id);
            addEvenToNewElementSiguiendo(userIdLogged,data[index].FW_Dad_Id);
            
            if(data[index].FW_Follow_Flag == '1')
            {
                $('#follow_'+userIdLogged+data[index].FW_Dad_Id).addClass("following");
                $('#follow_'+userIdLogged+data[index].FW_Dad_Id).text('Siguiendo');
            // textBtnFollow = "Siguiendo";
										   
            }
            else
            {
                $('#follow_'+userIdLogged+data[index].FW_Dad_Id).removeClass("unfollowing");
                $('#follow_'+userIdLogged+data[index].FW_Dad_Id).text('Seguir');
            // textBtnFollow = "Seguir";
            }
        });
			
						$('#content').masonry({
									 isFitWidth: true,
									 columnWidth: 450,
									 gutterWidth: 10,
									 itemSelector:'.allPartPerson'
									 });
									 
						setTimeout(function() {
                $('#Bigloading').hide();
            }, 1000);
                        
    }
        
    /**
     * Funcion que se ejecuta cuando se esta en SEGUIDORES
    */
    function BuildSeg(data){
    
        $.each(data,function(index,value)
        { //DAD YO, SUN OTRO
            //US_User_Id,US_User_Login,US_Full_Name,US_City,US_Photo,FW_Sun_Id
            var wall_post_seguidores = '<div class="allPartSeg"><div id="gridSeguidores_'+userIdLogged+data[index].FW_Sun_Id+'" class="grid-feed-follow feed-item-follow boxFo feed-item-newFo"><div class="border-divFo"></div><div class="btn-SeeProfile"><a href="/'+data[index].US_User_Login+'">Ver Perfil</a></div><a href="#" class="btn-Follow" id="follow_'+userIdLogged+data[index].FW_Sun_Id+'">Seguir</a><div class="extra-tile-info-follow"><div class="avatar-inspiter-follow"><a href="/'+data[index].US_User_Login+'"><img alt="" src="'+data[index].US_Photo+'" class="img-user-inspiter-follow" alt=""></img></a></div><div class="avatar-user-info-follow"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box-follow">'+data[index].US_Full_Name+'</a></h4><a href="/'+data[index].US_User_Login+'" class="username-box-follow">'+data[index].US_User_Login+'</a><p class="follow-inspiter-city-country">'+data[index].US_City+'</p></div><div class="BlockIpsPerson"><table><tbody><tr><td><span id="ipsPerson">'+data[index].CF_IPS+'</span> ips</td></tr></tbody></table></div></div><input type="hidden" id="followUser_'+userIdLogged+data[index].FW_Sun_Id+'" value="'+data[index].FW_Follow_Flag+'"></input></div></div>';
            $('#content').prepend(wall_post_seguidores);
            FollowSegArray.push('gridSeguidores_'+userIdLogged+data[index].FW_Sun_Id);
            addEvenToNewElementSeguidores(userIdLogged,data[index].FW_Sun_Id);
						
            if(data[index].FW_Follow_Flag == '1')
            {
                $('#follow_'+userIdLogged+data[index].FW_Sun_Id).addClass("following");
                $('#follow_'+userIdLogged+data[index].FW_Sun_Id).text('Siguiendo');								   
            }
            else
            {  
                $('#follow_'+userIdLogged+data[index].FW_Sun_Id).removeClass("unfollowing");
                $('#follow_'+userIdLogged+data[index].FW_Sun_Id).text('Seguir');
            }
									   
        });
				$('#content').masonry({
									 isFitWidth: true,
									 columnWidth: 450,
									 gutterWidth: 10,
									 itemSelector:'.allPartSeg'
									 });
			  setTimeout(function() {
                $('#Bigloading').hide();
            }, 1000);
    }
    

    /****************************************************************************************/
    //  AGREGA LOS EVENTOS DE SEGUIDORES
    /****************************************************************************************/
    function addEvenToNewElementSeguidores(pDadId, pSunId){	
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
                        leaveToFollow(pSunId,pDadId);
                        $('#follow_'+pDadId+pSunId).removeClass("unfollowing");
                        $('#follow_'+pDadId+pSunId).text('Seguir');
                        $('#followUser_'+pDadId+pSunId).val("0");
                        if (userIdLogged == userId)
                        {
                            var resultSeguidores = parseInt($('#pFollowing').text())-1;
                            $('#pFollowing').text(resultSeguidores); 
                        }
                        return false;
		
                    }else{
                        startToFollow(pSunId,pDadId);
                        $('#follow_'+pDadId+pSunId).addClass("following");
                        $('#follow_'+pDadId+pSunId).text('Siguiendo');
                        $('#followUser_'+pDadId+pSunId).val("1");
                        if (userIdLogged == userId)
                        {
                            resultSeguidores = parseInt($('#pFollowing').text())+1;
                            $('#pFollowing').text(resultSeguidores); 
                        }
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

    /****************************************************************************************/
    //  AGREGA LOS EVENTOS DE SIGUIENDO
    /****************************************************************************************/
    function addEvenToNewElementSiguiendo(pDadId, pSunId){	

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
				var resultSiguiendo;
        //0 aun no inspirada, tiene q inspirar  
        //1 ya inspirada, tiene q ya no inspirar
        $('#follow_'+pDadId+pSunId).on({			
            click: function(){
                if(pDadId != pSunId)
                {
                    if(flagFollowUser.val() == '1'){
                        leaveToFollow(pSunId,pDadId);
                        $('#follow_'+pDadId+pSunId).removeClass("unfollowing");
                        $('#follow_'+pDadId+pSunId).text('Seguir');
                        $('#followUser_'+pDadId+pSunId).val("0");
                        if (userIdLogged == userId)
                        {
                            resultSiguiendo = parseInt($('#pFollowing').text())-1;
                            $('#pFollowing').text(resultSiguiendo); 
                        }
                        return false;
		
                    }else{
                        startToFollow(pSunId,pDadId);
                        $('#follow_'+pDadId+pSunId).addClass("following");
                        $('#follow_'+pDadId+pSunId).text('Siguiendo');
                        $('#followUser_'+pDadId+pSunId).val("1");
                        if (userIdLogged == userId)
                        {
                            resultSiguiendo = parseInt($('#pFollowing').text())+1;
                            $('#pFollowing').text(resultSiguiendo); 
                        }
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

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   18/11/2012
    //Purpose:     - Funcion para dejar de seguir a una persona
    /*****************************************************************************************/   
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
                addIPSNegative(11,0,pDadId);
                if(pDadId == userId)
                  $("#pFollower").text(parseInt($("#pFollower").text())-1);
                if(pSunId == userIdLogged)
                  $("#pFollowing").text(parseInt($("#pFollowing").text())-1);
            }
        });
    }
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   18/11/2012
    //Purpose:     - Funcion para seguir a una persona
    /*****************************************************************************************/   
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
                if(data.toString() == 'YES')
                {
                    $.verifAddNotification(pDadId,pSunId,0,4);
                    if(pDadId == userId)
                      $("#pFollower").text(parseInt($("#pFollower").text())+1);
                    
                    if(pSunId == userIdLogged)
                      $("#pFollowing").text(parseInt($("#pFollowing").text())+1);
                }
                else
                {
                }
            }
        });
    }
    
 

   
/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/01/2013
//Purpose:     - Funcion que publica una dedicatoria a facebook
/*****************************************************************************************/ 
function graphStreamPublishDedication(DedicationInspiter,Author,UserIdInspiter,inspiterId,FullNameTo,UserIdTo,
inspiterUsername,DedicationId,UserIdFrom,FullNameFrom,FaceIdTo,UsernameTo,InspiterType)
{
   if (FaceIdTo == null || FaceIdTo == '' || FaceIdTo == 0)
   {
         $.genericAlert("Esta persona no tiene una cuenta de facebook asociada");
   }
   else
   {       var articulo = "un";
           if(InspiterType == "video")
               articulo = "un";
           else
               articulo = "una";
           
           if(InspiterType == 'image')
               InspiterType = 'imagen';
           
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    if(FaceIdTo!=uid)
                    {
                        FB.ui({ method: 'feed',
                                name:  FullNameFrom+' te ha enviado '+articulo+' '+InspiterType+' como dedicatoria',
                                link:'http://www.inspiter.com/'+UsernameTo+'&dedic='+DedicationId,
                                picture: 'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                                caption: 'Haz click en el enlace para ver la dedicatoria',
                                description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                                to: FaceIdTo,
                                actions: [
                                {
                                 name: 'Inspiter', 
                                 link:'http://www.inspiter.com'
                                }
                                ]
                               }, function(response) {  
                               if (response)
                               {
                                  $(location).attr('href','/'+inspiterUsername+'&post='+inspiterId);
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
                    $.genericAlert('Usuario no autorizado');
                } else {
                    FB.login(function(response) {
                        if(response.authResponse) {
                            if(FaceIdTo!=response.authResponse.userID)
                            {
                                FB.ui({ method: 'feed',
                                 name:  FullNameFrom+' te ha enviado '+articulo+' '+InspiterType+' como dedicatoria',
                                link:'http://www.inspiter.com/'+UsernameTo+'&dedic='+DedicationId,
                                picture: 'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                                caption: 'Haz click en el enlace para ver la dedicatoria',
                                description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                                to: FaceIdTo,
                                actions: [
                                {
                                 name: 'Inspiter', 
                                 link:'http://www.inspiter.com'
                                }
                                ]
                               }, function(response) {  
                               if (response)
                               {
                                  $(location).attr('href','/'+inspiterUsername+'&post='+inspiterId);
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
//Create Date:   05/01/2013
//Purpose:     - Funcion que construye las dedicatorias que le hicieron a un usuario
/*****************************************************************************************/ 
function BuildDedicationProfile(data, verMas)
{
    $.each(data,function(index,value) 
    { 
       var wall_post_dato =  '<div class="allPartDed"><div id="dedInspiter_container_'+data[index].DD_Dedications_Id+'" class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small">';
       if(data[index].IP_Type == 'text')
       {
           wall_post_dato += '<div class="multiOption" id="multiOptionMenuDedic_'+data[index].DD_Dedications_Id+'"><div class="ico-multiOpt"></div><dl id="multiOptionListDedic_'+data[index].DD_Dedications_Id+'" class="multiOptionList"><dd id="inspiterLink_'+data[index].DD_Dedications_Id+'" class="multi-link"><div class="linkButton"><div class="ico-multiLin"></div>Ir a la inspiracion</div><div class="textfieldLink"><input class="input linkField" value="" type="text" name="" id="inputLink" /><p>Comparte este link con tus amigos</p></div></dd>';    
           if(userIdLogged == data[index].DD_To_User_Id)
           {
              wall_post_dato += '<dt id="delete_dedic_'+data[index].DD_Dedications_Id+'" class="multi-delete"><div class="ico-multiDel"></div>Eliminar<div id="Del-loading_'+data[index].DD_Dedications_Id+'" class="Del-loading"></div></dt>';
           }
	   wall_post_dato +=  '</dl></div>';
           wall_post_dato += '<div class="phrase-box"><div class="comillas-background-right" style="margin:3px 0 0 388px!important;" ><img src="images/comillas-right.png" alt="select"></img></div><div class="comillas-background-left"><img src="images/comillas-left.png" alt="select"></img></div><div class="inner-phrase" style="min-height:50px">';
           wall_post_dato += '<blockquote class="pullquote">'+data[index].IP_Value1+'</blockquote>';
           wall_post_dato += '<div style="position: relative; height: 26px;"><a class="autor-name" href="#">'+data[index].IP_Value2+'</a></div></div></div></div>';
           wall_post_dato += '<div id="dedic_container_'+data[index].DD_Dedications_Id+'" class="ded-wrapper text-ded"><div id="dedFromBox" class="media-inspired">';
           wall_post_dato += '<div class="dedFromText"><h4>Dedicado por</h4><div class="InfoDedUser">';
           wall_post_dato += '<span class="img img-inset inspired-avatar" style="background-image: url('+data[index].US_Photo_Small+');"><b></b></span>';
           wall_post_dato += '<span style="color: rgb(38, 38, 38); width:140px; position: relative; bottom: 1px;">'+data[index].US_Full_Name+'</span>';
           wall_post_dato += '<span style="font-size: 11px; position: relative; bottom: 5px;  min-width: 65px;">'+data[index].US_City+'</span>';
           wall_post_dato += '</div></div><div class="timestamp">'+data[index].DD_Time_Ago+'</div></div>';
           wall_post_dato += '<ul class="ded-list"><li class="dedMessage"><div class="ded-block">';
           wall_post_dato += '<h4>Dedicatoria</h4><p>'+data[index].DD_Comment+'</p></div></li></ul></div></div>';
           if(verMas)
           {
               $('#content').append(wall_post_dato); 
           }
           else
           {
               $('#content').prepend(wall_post_dato);  
           }
       }
       else if(data[index].IP_Type == 'image')
       {
           wall_post_dato += '<div class="multiOption" id="multiOptionMenuDedic_'+data[index].DD_Dedications_Id+'"><div class="ico-multiOpt"></div><dl id="multiOptionListDedic_'+data[index].DD_Dedications_Id+'" class="multiOptionList"><dd id="inspiterLink_'+data[index].DD_Dedications_Id+'" class="multi-link"><div class="linkButton"><div class="ico-multiLin"></div>Ir a la inspiracion</div><div class="textfieldLink"><input class="input linkField" value="" type="text" name="" id="inputLink" /><p>Comparte este link con tus amigos</p></div></dd>';    
           if(userIdLogged == data[index].DD_To_User_Id)
           {
              wall_post_dato += '<dt id="delete_dedic_'+data[index].DD_Dedications_Id+'" class="multi-delete"><div class="ico-multiDel"></div>Eliminar<div id="Del-loading_'+data[index].DD_Dedications_Id+'" class="Del-loading"></div></dt>';
           }
	   wall_post_dato +=  '</dl></div><input id="IpType_'+data[index].DD_Dedications_Id+'" type="hidden" value="image">';
           wall_post_dato += '<div id="phrase-box_'+data[index].DD_Dedications_Id+'" class="phrase-box mediaPadd"><div class="inner-phrase"><img height="'+data[index].IP_Value5+'" src="'+data[index].IP_Value1+'" data-src-mobile="'+data[index].IP_Value1+'" data-src="'+data[index].IP_Value1+'" class="lazy-load" style="opacity: 1; visibility: visible;"><span class="loadingPost">Cargando...</span>';
           
           if(data[index].IP_Value4 != ''){
            wall_post_dato += '<div class="FooterImgText title-image" id="title-image_'+data[index].DD_Dedications_Id+'" style="display: none;"><p id="textTitleImage" class="text-FooterImgText">'+data[index].IP_Value4+'</p></div>';
           }
           if(data[index].IP_Value2 != ''){
            wall_post_dato += '<div class="FooterImgText description-image" id="description-image_'+data[index].DD_Dedications_Id+'" style="display: none;"><p id="textDescriptionImage" class="text-FooterImgText">'+data[index].IP_Value2+'</p></div>';
           }
           wall_post_dato += '</div></div></div><div id="dedic_container_'+data[index].DD_Dedications_Id+'" class="ded-wrapper text-ded"><div id="dedFromBox" class="media-inspired">';
           wall_post_dato += '<div class="dedFromText"><h4>Dedicado por</h4><div class="InfoDedUser">';
           wall_post_dato += '<span class="img img-inset inspired-avatar" style="background-image: url('+data[index].US_Photo_Small+');"><b></b></span>';
           wall_post_dato += '<span style="color: rgb(38, 38, 38); position: relative; bottom: 1px; width:140px;">'+data[index].US_Full_Name+'</span>';
           wall_post_dato += '<span style="font-size: 11px; position: relative; bottom: 5px; min-width: 65px;">'+data[index].US_City+'</span>';
           wall_post_dato += '</div></div><div class="timestamp">'+data[index].DD_Time_Ago+'</div></div>';
           wall_post_dato += '<ul class="ded-list"><li class="dedMessage"><div class="ded-block">';
           wall_post_dato += '<h4>Dedicatoria</h4><p>'+data[index].DD_Comment+'</p></div></li></ul></div></div>';
           if(verMas)
           {
               $('#content').append(wall_post_dato); 
           }
           else
           {
               $('#content').prepend(wall_post_dato);  
           }
       }
       else if(data[index].IP_Type == 'video')
       {
           var wall_post_dato =  '<div class="allPartDed"><div id="dedInspiter_container_'+data[index].DD_Dedications_Id+'" class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small video">';
           wall_post_dato += '<div class="multiOption" id="multiOptionMenuDedic_'+data[index].DD_Dedications_Id+'"><div class="ico-multiOpt"></div><dl id="multiOptionListDedic_'+data[index].DD_Dedications_Id+'" class="multiOptionList"><dd id="inspiterLink_'+data[index].DD_Dedications_Id+'" class="multi-link"><div class="linkButton"><div class="ico-multiLin"></div>Ir a la inspiracion</div><div class="textfieldLink"><input class="input linkField" value="" type="text" name="" id="inputLink" /><p>Comparte este link con tus amigos</p></div></dd>';    
           if(userIdLogged == data[index].DD_To_User_Id)
           {
              wall_post_dato += '<dt id="delete_dedic_'+data[index].DD_Dedications_Id+'" class="multi-delete"><div class="ico-multiDel"></div>Eliminar<div id="Del-loading_'+data[index].DD_Dedications_Id+'" class="Del-loading"></div></dt>';
           }
	   wall_post_dato +=  '</dl></div><input id="IpType_'+data[index].DD_Dedications_Id+'" type="hidden" value="video">';
           wall_post_dato += '<div id="phrase-box_'+data[index].DD_Dedications_Id+'" class="phrase-box mediaPadd"><div class="inner-phrase"><img height="320px" src="'+data[index].IP_Value6+'" data-src-mobile="'+data[index].IP_Value6+'" data-src="'+data[index].IP_Value6+'" class="lazy-load" style="opacity: 1; visibility: visible;"><span class="loadingPost">Cargando...</span><span class="post-video-play"></span>';
           wall_post_dato += '<div class="FooterImgText title-image" id="title-image_'+data[index].DD_Dedications_Id+'" style="display: none;"><p id="textTitleImage" class="text-FooterImgText">'+data[index].IP_Value4+'</p></div>';
           wall_post_dato += '<div class="FooterImgText description-image" id="description-image_'+data[index].DD_Dedications_Id+'" style="display: none;"><p id="textDescriptionImage" class="text-FooterImgText">'+data[index].IP_Value2+'</p></div></div></div></div>';
           wall_post_dato += '<div id="dedic_container_'+data[index].DD_Dedications_Id+'" class="ded-wrapper text-ded"><div id="dedFromBox" class="media-inspired">';
           wall_post_dato += '<div class="dedFromText"><h4>Dedicado por</h4><div class="InfoDedUser">';
           wall_post_dato += '<span class="img img-inset inspired-avatar" style="background-image: url('+data[index].US_Photo_Small+');"><b></b></span>';
           wall_post_dato += '<span style="color: rgb(38, 38, 38); width:140px; position: relative; bottom: 1px;">'+data[index].US_Full_Name+'</span>';
           wall_post_dato += '<span style="font-size: 11px; position: relative; bottom: 5px; min-width: 65px;">'+data[index].US_City+'</span>';
           wall_post_dato += '</div></div><div class="timestamp">'+data[index].DD_Time_Ago+'</div></div>';
           wall_post_dato += '<ul class="ded-list"><li class="dedMessage"><div class="ded-block">';
           wall_post_dato += '<h4>Dedicatoria</h4><p>'+data[index].DD_Comment+'</p></div></li></ul></div></div>';
           if(verMas)
           {
               $('#content').append(wall_post_dato); 
           }
           else
           {
               $('#content').prepend(wall_post_dato);  
           }
       }    
           addEvenToNewElementDedic(data[index].DD_Dedications_Id,data[index].DD_From_User_Id,data[index].US_User_Login,data[index].US_Full_Name,data[index].US_Photo_Small,data[index].DD_To_User_Id,data[index].DD_Inspiter_Id,data[index].DD_Comment,data[index].IP_Username,data[index].IP_Value1,data[index].IP_Value2,data[index].IP_Value4,data[index].IP_Value6);
           $('#Bigloading').hide();			 
       
    });
    $('#content').masonry({
			 isFitWidth: true,
                         columnWidth: 435,
			 gutterWidth: 10,
			 itemSelector:'.allPartDed'
			 });
 	      
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   10/01/2013
//Purpose:     - Funcion que agrega los eventos de las dedicatorias por inspiracion
/*****************************************************************************************/
function addEvenToNewElementDedic(pDedicationId,pUserFrom,pUserNameFrom,pUserFromNameComplete,pPhotoFrom,pUserTo,pInspiterId,pComment,pUsernameInspiter,pValue1,pValue2,pValue4,pValue6)
{
    /****************************************************************************************/ 
    //  AGREGA EL EFECTO DE HACER APARECER Y DESAPARECER EL BOTON MULTIOPCION EN CADA DEDICATORIA 
    /****************************************************************************************/ 
    var $title_image_ded     = "title-image_"+pDedicationId;
    var $description_image_ded = "description-image_"+pDedicationId;
    $('#dedInspiter_container_'+pDedicationId).on({
   
      mouseenter: function(){
            $("#multiOptionMenuDedic_"+pDedicationId).fadeIn(200);
            $("#"+$title_image_ded).fadeIn(100);
            $("#"+$description_image_ded).fadeIn(100);
            },
				
      mouseleave: function(){ 
            $("#multiOptionMenuDedic_"+pDedicationId).fadeOut(200);
            $("#"+$title_image_ded).fadeOut(100);
            $("#"+$description_image_ded).fadeOut(100);
            }			  
        });
    
     /****************************************************************************************/
     //               AGREGA EL EVENTO AL BOTON MULTIOPCION DE LA DEDICATORIA PARA APARECER Y OCULTARSE 
     /****************************************************************************************/ 
     $("#multiOptionMenuDedic_"+pDedicationId).on({
            mouseover: function(){
                $("#multiOptionListDedic_"+pDedicationId).show();  
            },
            mouseleave: function(){
                $("#multiOptionListDedic_"+pDedicationId).hide(); 
            }
        });
		
        /****************************************************************************************/
        //               AGREGA EL EVENTO CLICK AL BOTON ELIMINAR
        /****************************************************************************************/ 
        $('#delete_dedic_'+pDedicationId).on({		
            click: function(){
                $('#Del-loading_'+pDedicationId).show(); 
                $.eliminaDedication(pDedicationId);
               
                return false;
            }
        });
        
        /****************************************************************************************/
        //    VARIABLES Y ASIGNACION DEL EVENTO CLICK PARA IR A LA INSPIRACION DE LA DEDICATORIA
        /****************************************************************************************/ 
        var goto_link = $('#inspiterLink_'+pDedicationId);
        
        goto_link.on({
            click: function() 
            {
                var url = '/'+pUsernameInspiter+'&post='+pInspiterId;
                $(location).attr('href',url);
            }
        });
	
        
      /****************************************************************************************/
      //               AGREGA EL EVENTO CLICK A LA DEDICACION PARA HACER APARECER EL ZOOM
      /****************************************************************************************/
        
        $("#phrase-box_"+pDedicationId).on({
            click: function(e)
            {
                if( $("#IpType_"+pDedicationId).val() == 'image')
                {
                    $("#zoomIns").krioImageLoader();
                    $("#ImageWithZoom").attr('src','');
                    $(".insvideoOrig").remove();
                    var OriWidth = $("#phrase-box_"+pDedicationId+" .lazy-load").data('oriwidth');
                    var OriHeight = $("#phrase-box_"+pDedicationId+" .lazy-load").data('oriheight');
                    $("#zoomIns").css({
                        width:OriWidth,
                        height:OriHeight
                    });
                    $("#ImageWithZoom").attr('src',pValue6).show();
                }
                else if( $("#IpType_"+pDedicationId).val() == 'video') 
                {   
                    $("#zoomIns").css({
                        width:730,
                        height:500
                    });
                    $(".insvideoOrig").remove();
                    $("#ImageWithZoom").hide();
                    
                    var videoOrig = '<div class="insvideoOrig" id="insVideoOrig_'+pDedicationId+'" style="position:relative;z-index:2;">';
                        videoOrig +='<iframe class="youtube-player" type="text/html" width="730px" height="500px" '; 
                        videoOrig +='src="'+pValue1+'?version=3&fs=1&autoplay=1" allowfullscreen webkitallowfullscreen mozallowfullscreen frameborder="0">'; 
                        videoOrig +='</iframe></div>';
                        $("#zoomIns").append(videoOrig);
                 }
                 $("#zoom-background").fadeIn(100, function(){
                 $("#avatarZoom").attr('src',pPhotoFrom);
                 $("#avatarZoomLink").attr('href',pUserNameFrom);
                 $("#avatarNameZoom").text(pUserFromNameComplete).attr('href',pUserNameFrom);
                 
                 $("#TitleImageZoom").text(pValue4);
                 $("#DescriptionImageZoom").text(pValue2);
                 //$("#TimeZoom").text(pTimeAgo);
                 $("#BlockZoomIns").fadeIn(100);
                 $profile_body.css('overflow-y','hidden');
                 e.preventDefault();
                });
            }
        });
        
          //EVENTO CLICK DEL BOTON CERRAR ZOOM
       $("#BtnZoomClose").on({
         click: function(e)
         {
           $("#zoom-background").fadeOut(100);
           $("#BlockZoomIns").fadeOut(100);    
           $profile_body.css('overflow-y','scroll');
           $(".insvideoOrig").remove();
	   e.preventDefault();
         }
       });
        
}


        /****************************************************************************************/
        //  AGREGAR EVENTO APARECER DESAPARECER: TITULO Y DESCRIPCION
        /****************************************************************************************/ 
 
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
                      "type": OptionSelected,
                      "inspiterId": v_inspiterId,
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
		 if((OptionSelected == 'inspiraciones') || (OptionSelected == 'favoritos')){$("#LoadingInspirations").show();}
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
                      "type": OptionSelected,
                      "inspiterId": v_inspiterId,
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
		if((OptionSelected == 'inspiraciones') || (OptionSelected == 'favoritos')){$("#LoadingInspirations").show();}
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
                    "type": OptionSelected,
                    "inspiterId": v_inspiterId,
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
		if((OptionSelected == 'inspiraciones') || (OptionSelected == 'favoritos')){$("#LoadingInspirations").show();}
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
  /* fin opciones all media texto ********/
  
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
  //Create Date:   29/03/2013
  //Purpose:     - Suma valores negativos a los IPS dependiendo del tipo de transaccion que se haga
  /*****************************************************************************************/				 
  function addIPSNegative(pType, pInspiterId, pUserId)
  {
       $.post("../web/addIPSValue.php",{
             type: pType, 
             inspiterId: pInspiterId,
             userId: pUserId
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
                if(data == 'YES') 
                { 
		   
                }
                else
                {
		   
                }
             }
        });
  }
 
 //sergio ver como hacer este link
 ips_value_div.on({
        click: function()
        {
          if(userId == userIdLogged)
          {
             graphStreamPublishIPS();
          }
          else
          {
          }
        }
 }); 
  /****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/01/2013
//Purpose:     - Funcion que publica los ips a Facebook
/*****************************************************************************************/ 
function graphStreamPublishIPS()
{
   if (FaceIdTo == null || FaceIdTo == '' || FaceIdTo == 0)
   {
         $.genericAlert("Esta persona no tiene una cuenta de facebook asociada");
   }
   else
   { 
     var mensajeIPS = ''; 
     if (parseFloat(IPSAmount) < 1)
     {mensajeIPS = "Recien empiezas, continua de esa forma y podras ser un/a gran inspirador/a";}
     else if (parseFloat(IPSAmount) >= 1 && parseFloat(IPSAmount) < 10)
     {mensajeIPS = "Tienes alma de inspirador/a, continua de esa forma";}
     else if (parseFloat(IPSAmount) >= 10 && parseFloat(IPSAmount) < 50)
     {mensajeIPS = "Eres un/a gran inspirador/a";}
     else if (parseFloat(IPSAmount) >= 50 && parseFloat(IPSAmount) < 1000)
     {mensajeIPS = "Eres un/a genio/a inspirando a las personas";}
     else if (parseFloat(IPSAmount) >= 1000)
     {mensajeIPS = "No hay nada mas que decir. Maximo Inspirador/a";}
     FB.getLoginStatus(function(response) 
     {
       if (response.status === 'connected') 
       {
          var uid = response.authResponse.userID;
          if(FaceIdTo!=uid)
          {
              FB.api('/me/feed', 'post', { 
                            message:  mensajeIPS,
                            description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar cualquier inspiracion, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con inspiraciones que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                            picture:photosmall.val(),
                            name:  fullnameHidden+' tiene '+IPSAmount+' IPS',
                            link:'http://www.inspiter.com/'+usernameHidden,
                            actions: [
                            {
                                name: 'Inspiter', 
                                link:'http://www.inspiter.com'
                            }
                            ]
                        }, function(response) 
                           {  
                            if (response)
                            {
                                  $.genericAlert('¡Que inspirador eres!. Compartiste tus IPS a facebook');
                             }
                           });
                    }
                    else
                    {
                        $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de inspiter');
                    }
          } 
          else if (response.status === 'not_authorized') {
                    // the user is logged in to Facebook, 
                    // but has not authenticated your app
                    $.genericAlert('Usuario no autorizado');
                } 
                else
                {
                    FB.login(function(response) 
                    {
                      if(response.authResponse)
                      {
                         if(FaceIdTo!=response.authResponse.userID)
                         {
                            FB.api('/me/feed', 'post', { 
                            message:  mensajeIPS,
                            description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar cualquier inspiracion, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con inspiraciones que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                            picture:photosmall.val(),
                            name:  fullnameHidden+' tiene '+IPSAmount+' IPS',
                            link:'http://www.inspiter.com/'+usernameHidden,
                            actions: [
                            {
                                name: 'Inspiter', 
                                link:'http://www.inspiter.com'
                            }
                            ]
                        }, function(response) 
                           {  
                            if (response)
                            {
                               $.genericAlert('¡Que inspirador eres!. Compartiste tus IPS a facebook');
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

 $("#icon_denunc_user").on({
        click: function()
        {
          $.confirm({
			'title':'Advertencia',
			'message':'\u00bfSeguro que quieres denunciar esta persona?',
			'buttons':{
			            'Denunciar':{
 			  		         'class':'btn btn-success',
						 'action':function(){
                                                                       denunciarInspiracion(userId);
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option',
				                 'action': function(){}	
                                               }
                                   }
                     });
              return false;
        }
 });
/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   25/04/2013
//Purpose:     - Funcion que denuncia un usuario
/*****************************************************************************************/ 
function denunciarInspiracion(pUserId)
{   
    $.post("../web/denunciasManager.php", {
           accuserId: userIdLogged,
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
	      $.afterRegiter('Usted ha denunciado este usuario, estaremos analizando su denuncia.','Exitoso');
          }
        });
} 
         
});  