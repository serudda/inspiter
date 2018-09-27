
$(window).load(function()
{
    /****************************************************************************************/
    //                           VARIABLES GLOBALES
    /****************************************************************************************/

    var $content = $("#content");
    var mouse_is_inside = false;
    var doc = $(document);
    var FirstInspiterId = 0;
    var v_inspiterId = $("#inspiterId").val();
    var $profile_body = $('.profile-body');
    var verMas;
    var $textImgPhrase = $("#textImgPhrase");
    var $textImgAuthor = $("#textImgAuthor");
    var $PhraseInfoBlock = $(".PhraseInfoBlock");
//    var $imagenPhrase = 'url("'+$("#imagenPhrase").val()+'")';
    var $imagenPhrase = $("#imagenPhrase").val();
    OptionInspiterType = 'all';
    var usernameHidden = $("#usernameHidden").val();
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
    var min=100000000;
    
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   21/03/2013
    //Purpose:     - Aplica el estilo de la frase insignia, el autor y la imagen de fondo
    /*****************************************************************************************/
     $.ajax({
            url: "../web/getStyles.php", 
            data: {
                     "userId": userId,
                     "noSession": "SI"
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
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
                             slide_control.css({top:"150px"}).attr('data-original-title','Mostrar información personal');
                             $PhraseInfoBlock.css("z-index","2"); 
                             $PhraseInfoBlock.css({opacity:"1"});
                           }
                           else
                           {
                             slide_control.css({top:"7px"}).attr('data-original-title','Mostrar Frase Insignia');
                             $PhraseInfoBlock.css("z-index","0")
                             $PhraseInfoBlock.css({opacity:"0"});
                           }
                           /*END: MUESTRA LA FRASE INSIGNIA SI EL USER DEJO EL SWITCH ACTIVADO*/
                          }
                          else
                          {
                             
                          }
                    }
            });
  
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Muestra las inspiraciones, seguidores o siguiendo al cargar la pagina  segun un criterio
    //  - Criterio: Si la variable OptionSelected tiene el valor "inspiraciones" muestra las inspiraciones del usuario del perfil
    //  - Si la variable OptionSelected tiene el valor "seguidores" muestra los seguidores del usuario del perfil
    //  -Si la variable OptionSelected tiene el valor "siguiendo" muestra los usuarios que sigue el usuario del perfil
    /*****************************************************************************************/
    $('#Bigloading').show();
    $.ajax({
            url: "../web/showInspiters.php",
            data:
                {
                 "userId": userId,
                 "inspiterId": v_inspiterId,
                 "inspType": 'all',
                 "noSession": "SI"
                },
            type: "POST",
            dataType: "json",
            success: function(data) 
            {
                if(data.length > 0)
                {
                    verMas = false;
                    BuildInspiterProfile(data, verMas);  // Se construyen los contenedores de "MIS INSPIRACIONES"								
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
        
        /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Construye las inspiraciones por partes, esta funcion es llamada por todas las demas
    //               al darle click a cada opcion (Inspiraciones, Favoritos)
    /*****************************************************************************************/
    function BuildInspiterProfile(data,verMas) 
    {   
        min=100000000;
        var $content = $("#content");
        var $photosmall =    $("#photosmall");

        /*Da el foco a la opcion: TODO*/
        $.each(data,function(index,value) 
        {
           var wall_post_dato = '<div class="allPartInspiration" style="margin-top: 20px!important;"><input type="hidden" value="'+((10-index))+'" id="orden_'+data[index].IP_Inspiter_Id+'">';
           /*CONSTRUYE LOS TEXTOS EN LA OPCION "TODO"*/
           if(data[index].IP_Type == "text")
           {						 
            wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';
            wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption"><div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'"><dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'"></div><span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt><dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';						
            wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><div class="phrase-box"><div class="comillas-background-right" style="margin:3px 0 0 388px!important;"><img src="images/comillas-right.png" alt=""></div> <div class="comillas-background-left"><img src="images/comillas-left.png" alt=""></div><div style="min-height:50px" class="inner-phrase"><blockquote class="pullquote">'+data[index].IP_Value1+'</blockquote><div style="position: relative; height: 26px;"><a href="#" class="autor-name">'+ data[index].IP_Value2 +'</a></div></div></div><div class="border-div"></div><div class="extra-tile-info"><div class="avatar-inspiter"><a href="/'+data[index].US_User_Login+'"><img alt="" src="'+data[index].US_Photo_Small+'" class="img-user-inspiter"></a></div><div class="avatar-user-info"><input type="hidden" value="'+data[index].US_User_Id+'" id="UserId_'+data[index].US_User_Id+'"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box">'+data[index].US_Full_Name+'</a></h4><p class="user-inspiter-city-country">'+data[index].IP_Time_Ago+'</p></div>';
            //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
            wall_post_dato += '<div class="textCountFav Count_Fav" id="Count_Fav_'+data[index].IP_Inspiter_Id+'"><ul class="countsIns" id="countsIns_'+data[index].IP_Inspiter_Id+'"><li class="inspired-button"><strong><span class="count-badge inspired-count" id="pCount_'+data[index].IP_Inspiter_Id+'">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a id="inspired_button_'+data[index].IP_Inspiter_Id+'" class="inspired-button inspired-button" href="javascript:;"><span>inspirar</span><b></b><div class="icoInsp"></div><span id="i_inspired" class="i-inspired"></span></a></li>';
            //Construimos el contador de cantidad de comentarios
            wall_post_dato += '<li class="comment-count"><strong><span id="comment_count_'+data[index].IP_Inspiter_Id+'" class="count-badge comment-count">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a id="comment_button_'+data[index].IP_Inspiter_Id+'" class="comment-button" href="javascript:;"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
            wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"><a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a><a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
            //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
            wall_post_dato += '<div id="comment-wrapper_'+data[index].IP_Inspiter_Id+'" class="comment-wrapper"><div class="media-inspired smallbox"><h2><span id="inspired-count_'+data[index].IP_Inspiter_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].IP_Inspiter_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].IP_Inspiter_Id+'" class="comment-container"><ul id="comment-list_'+data[index].IP_Inspiter_Id+'" class="comment-list smallul"><div id="loadingInspired_Com_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div>';
            wall_post_dato += '<p id="inspired-notice_'+data[index].IP_Inspiter_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
            wall_post_dato += '<li id="comment-loading_'+data[index].IP_Inspiter_Id+'" class="comment comload"></li></ul></div>';
            //Construye el form y el textarea para escribir un comentario
            wall_post_dato += '<form id="media_addcomment" class="media-addcomment NoComment"><label>Commentarios</label><p class="TextNoComment">Para poder comentar es necesario que inicies sesión</p></form></div></div>';
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
            addEvenToNewElement(data[index].IP_Inspiter_Id,0,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,'',data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,'','',data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
           					
          }
          else if(data[index].IP_Type == "image")
          {
             wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
             wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption"><div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'" ><dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'" ></div><span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt><dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';
             //fin dropdown menu
             wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].IP_Type+'" id="IpType_'+data[index].IP_Inspiter_Id+'"><div id="phrase-box_'+data[index].IP_Inspiter_Id+'" class="phrase-box mediaPadd"><div style="height:'+data[index].IP_Value5+'px;" class="inner-phrase"><img class="lazy-load" data-src="'+data[index].IP_Value1+'" data-src-mobile="'+data[index].IP_Value1+'" src="'+data[index].IP_Value1+'" height="'+data[index].IP_Value5+'" data-oriwidth="'+data[index].IP_Value7+'" data-oriheight="'+data[index].IP_Value8+'" /><span class="loadingPost">Cargando...</span>';
             if(data[index].IP_Value4 != ''){
                wall_post_dato += '<div id="title-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText title-image"><p class="text-FooterImgText" id="textTitleImage">'+data[index].IP_Value4+'</p></div>';
             }

             if(data[index].IP_Value2 != ''){
                wall_post_dato += '<div id="description-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText description-image"><p class="text-FooterImgText" id="textDescriptionImage">'+data[index].IP_Value2+'</p></div>';
             }
             wall_post_dato += '</div></div><div class="border-div"></div><div class="extra-tile-info"><div class="avatar-inspiter">';
             wall_post_dato += '<a href="/'+data[index].US_User_Login+'"> <img alt="" src="'+data[index].US_Photo_Small+'" class="img-user-inspiter"> </a> </div>';  
             wall_post_dato += '<div class="avatar-user-info"><input type="hidden" value="'+data[index].US_User_Id+'" id="UserId_'+data[index].US_User_Id+'"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box">'+data[index].US_Full_Name+'</a></h4>';
             wall_post_dato += '<p class="user-inspiter-city-country">'+data[index].IP_Time_Ago+'</p></div>';
             //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
             wall_post_dato += '<div class="textCountFav Count_Fav" id="Count_Fav_'+data[index].IP_Inspiter_Id+'"><ul class="countsIns" id="countsIns_'+data[index].IP_Inspiter_Id+'"><li class="inspired-button"><strong><span class="count-badge inspired-count" id="pCount_'+data[index].IP_Inspiter_Id+'">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a id="inspired_button_'+data[index].IP_Inspiter_Id+'" class="inspired-button inspired-button" href="javascript:;"><span>inspirar</span><b></b><div class="icoInsp"></div><span id="i_inspired" class="i-inspired"></span></a></li>';
             //Construimos el contador de comentarios
             wall_post_dato += '<li class="comment-count"><strong><span id="comment_count_'+data[index].IP_Inspiter_Id+'" class="count-badge comment-count">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a id="comment_button_'+data[index].IP_Inspiter_Id+'" class="comment-button" href="javascript:;"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
             wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"> <a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a>';
             wall_post_dato += '<a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
             //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
             wall_post_dato += '<div id="comment-wrapper_'+data[index].IP_Inspiter_Id+'" class="comment-wrapper"><div class="media-inspired smallbox"><h2><span id="inspired-count_'+data[index].IP_Inspiter_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].IP_Inspiter_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].IP_Inspiter_Id+'" class="comment-container"><ul id="comment-list_'+data[index].IP_Inspiter_Id+'" class="comment-list smallul"><div id="loadingInspired_Com_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div>';
             wall_post_dato += '<p id="inspired-notice_'+data[index].IP_Inspiter_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
             wall_post_dato += '<li id="comment-loading_'+data[index].IP_Inspiter_Id+'" class="comment comload"></li></ul></div>';
             //Construye el form y el textarea para escribir un comentario
             wall_post_dato += '<form id="media_addcomment" class="media-addcomment NoComment"><label>Commentarios</label><p class="TextNoComment">Para poder comentar es necesario que inicies sesión</p></form></div></div>';
             
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
             addEvenToNewElement(data[index].IP_Inspiter_Id,0,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,'',data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,'','',data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
          }
          else if(data[index].IP_Type == "video")
          {
             wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small video" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
             wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption"><div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'" ><dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'" ></div><span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt><dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';
             //fin dropdown menu
             wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].IP_Type+'" id="IpType_'+data[index].IP_Inspiter_Id+'"><div id="phrase-box_'+data[index].IP_Inspiter_Id+'" class="phrase-box mediaPadd"><div class="inner-phrase"><img class="lazy-load" data-src="'+data[index].IP_Value6+'" data-src-mobile="'+data[index].IP_Value6+'" src="'+data[index].IP_Value6+'" height="320px"/><span class="loadingPost">Cargando...</span><span class="post-video-play"></span>';

             if(data[index].IP_Value4 != ''){
                wall_post_dato += '<div id="title-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText title-image"><p class="text-FooterImgText" id="textTitleImage">'+data[index].IP_Value4+'</p></div>';
             }

             if(data[index].IP_Value2 != ''){
                wall_post_dato += '<div id="description-image_'+data[index].IP_Inspiter_Id+'" class="FooterImgText description-image"><p class="text-FooterImgText" id="textDescriptionImage">'+data[index].IP_Value2+'</p></div>';
             }

             wall_post_dato += '</div></div><div class="border-div"></div><div class="extra-tile-info"><div class="avatar-inspiter">';
             wall_post_dato += '<a href="/'+data[index].US_User_Login+'"> <img alt="" src="'+data[index].US_Photo_Small+'" class="img-user-inspiter"> </a> </div>';  
             wall_post_dato += '<div class="avatar-user-info"><input type="hidden" value="'+data[index].US_User_Id+'" id="UserId_'+data[index].US_User_Id+'"><h4><a href="/'+data[index].US_User_Login+'" class="name-complete-box">'+data[index].US_Full_Name+'</a></h4>';
             wall_post_dato += '<p class="user-inspiter-city-country">'+data[index].IP_Time_Ago+'</p></div>';
             //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
             wall_post_dato += '<div class="textCountFav Count_Fav" id="Count_Fav_'+data[index].IP_Inspiter_Id+'"><ul class="countsIns" id="countsIns_'+data[index].IP_Inspiter_Id+'"><li class="inspired-button"><strong><span class="count-badge inspired-count" id="pCount_'+data[index].IP_Inspiter_Id+'">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a id="inspired_button_'+data[index].IP_Inspiter_Id+'" class="inspired-button inspired-button" href="javascript:;"><span>inspirar</span><b></b><div class="icoInsp"></div><span id="i_inspired" class="i-inspired"></span></a></li>';
             //Construimos el contador de comentarios
             wall_post_dato += '<li class="comment-count"><strong><span id="comment_count_'+data[index].IP_Inspiter_Id+'" class="count-badge comment-count">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a id="comment_button_'+data[index].IP_Inspiter_Id+'" class="comment-button" href="javascript:;"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
             wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"> <a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a>';
             wall_post_dato += '<a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
             //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
             wall_post_dato += '<div id="comment-wrapper_'+data[index].IP_Inspiter_Id+'" class="comment-wrapper"><div class="media-inspired smallbox"><h2><span id="inspired-count_'+data[index].IP_Inspiter_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].IP_Inspiter_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].IP_Inspiter_Id+'" class="comment-container"><ul id="comment-list_'+data[index].IP_Inspiter_Id+'" class="comment-list smallul"><div id="loadingInspired_Com_'+data[index].IP_Inspiter_Id+'" class="loadingInspired"></div>';
             wall_post_dato += '<p id="inspired-notice_'+data[index].IP_Inspiter_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
             wall_post_dato += '<li id="comment-loading_'+data[index].IP_Inspiter_Id+'" class="comment comload"></li></ul></div>';
             //Construye el form y el textarea para escribir un comentario
             wall_post_dato += '<form id="media_addcomment" class="media-addcomment NoComment"><label>Commentarios</label><p class="TextNoComment">Para poder comentar es necesario que inicies sesión</p></form></div></div>';
          
             if(verMas)
             {
               $boxes = $(wall_post_dato);
               $('#content').append( $boxes ).masonry( 'appended', $boxes);
               //$content.append(wall_post_dato);
             }
             else
             {
               $content.prepend(wall_post_dato);
             }   
             $('#comment-wrapper_'+data[index].IP_Inspiter_Id+' .comment-container').mCustomScrollbar({
               set_height:200												
             });
             //LLAMA A LA FUNCION QUE ASIGNA LOS EVENTOS A CADA UNO DE LOS ELEMENTOS DE LAS INSPIRACIONES
             addEvenToNewElement(data[index].IP_Inspiter_Id,0,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,'',data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,'','',data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
           }
           //obtener el minimo
           if(parseInt(data[index].IP_Inspiter_Id) < parseInt(min))
           {
             min=parseInt(data[index].IP_Inspiter_Id);
           }           
       }); 
       console.log("minimo: "+min);
       FirstInspiterId=parseInt(min);
       $('.wrapperAll').removeClass('centerWrapp');    
       $('#content').masonry({
                         isFitWidth: true,
                         columnWidth: 435,
                         gutterWidth: 10,
                         itemSelector:'.allPartInspiration'
                        });	 
       $(".inner-phrase").krioImageLoader();   
       $('#Bigloading').hide();																	
     }  
    
function addEvenToNewElement(pInspiterId, pUserId, pValue1, pValue2,pUserIdOtro, pPhotoProfile,pAvatar,pValue6,pTimeAgo,pFullnameLogged, pUsernameLogged, FullNameOther, UserNameOther, pInspType, pValue4)
{
  /****************************************************************************************/
  //       AGREGAR EFECTO SUBE Y BAJA A LOS BOTONES SOCIALES DE COMPARTIR
  /****************************************************************************************/  
  $('#social-icons-share_'+pInspiterId+' a').on({
			mouseenter: function(){
						$(this).animate({
								marginTop:'0px'
						},100);
						$('#social-icons-share_'+pInspiterId+' .fb').tooltip();
						$('#social-icons-share_'+pInspiterId+'.tw').tooltip();
				},

			mouseleave: function(){
						$(this).animate({
								marginTop:'-28px'
						},100);
				}
                  
		});
  /****************************************************************************************/
  //  AGREGA EL EFECTO DE HACER APARECER Y DESAPARECER EL BOTON MULTIOPCION EN CADA INSPIRACION 
  /****************************************************************************************/ 
  var $multiOptionMenu = "multiOptionMenu_"+pInspiterId;
  var $multiOptionList = "multiOptionList_"+pInspiterId;
  var $title_image     = "title-image_"+pInspiterId;
  var $description_image = "description-image_"+pInspiterId;
  $('#grid_feed_contest_item_'+pInspiterId).on({
            mouseenter: function()
            {  
               $("#"+$multiOptionMenu).fadeIn(200);
               $("#"+$title_image).fadeIn(100);
               $("#"+$description_image).fadeIn(100);
	     },
            mouseleave: function()
            { 
               $("#"+$multiOptionMenu).fadeOut(200);
               $("#"+$title_image).fadeOut(100);
               $("#"+$description_image).fadeOut(100);
	     }
        });
  /****************************************************************************************/
  //               AGREGA EL EVENTO AL BOTON MULTIOPCION PARA APARECER Y OCULTARSE 
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
  //     AGREGA EL EVENTO CLICK AL CONTENEDOR DE CANT DE COMENTARIOS E INSPIRACIONES
  /****************************************************************************************/
  $('#comment_button_'+pInspiterId+',#inspired_button_'+pInspiterId).on({
          click: function(){
                          $('#Count_Fav_'+pInspiterId).css('z-index','3');
			  $('#comment-wrapper_'+pInspiterId).css({'position':'relative'});
                          if($('#comment-wrapper_'+pInspiterId).css("max-height") == "324px" )
                          {
                    	    $('#comment-wrapper_'+pInspiterId).css('max-height','0px');
			    $('#comment-wrapper_'+pInspiterId).css({'position':'static'});
			    $('#Count_Fav_'+pInspiterId).css('z-index','');
			    $('#comment-wrapper_'+pInspiterId+' .inspired').remove();
			  }
                          else
                          {
			    $('#loadingInspired_'+pInspiterId).css('opacity','1');
			    $('#loadingInspired_Com_'+pInspiterId).css('opacity','1');
	                    $('#comment-wrapper_'+pInspiterId+' .comment:not(.comload)').remove();	
			    $('#comment-wrapper_'+pInspiterId).css('max-height','324px');
			    $('#inspired_list_'+pInspiterId).addClass('inspired-slide');
			    ShowInspired(pInspiterId);
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
 	    $('#comment-wrapper_'+pInspiterId).css('max-height','0px');
	    $('#Count_Fav_'+pInspiterId).css('z-index','');
	    $('#comment-wrapper_'+pInspiterId).css({'position':'static'});
	    $('#comment-wrapper_'+pInspiterId+' .inspired').remove();
	    $('#inspired-notice_'+pInspiterId).fadeOut();
          } 
        });
   /****************************************************************************************/
   //               EFECTO ME INSPIRA Y YA NO ME INSPIRA CUANDO LE DOY CLICK AL BOTON
   /****************************************************************************************/ 
   $('#ins_'+pInspiterId).on({
            click: function()
            {
                 $.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesi\u00f3n o registrate para poder realizar esta acci\u00f3n',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Registrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });
                 return false;
            }
        });	
    /****************************************************************************************/
    //            AGREGA EL EVENTO PARA OBTENER EL LINK DE LA INSPIRACION
    /****************************************************************************************/
        var obt_link = $('#multi-link_'+pInspiterId);
        var $likeButton = $('.linkButton');
        var $likeField = $('.linkField');
        var $textfieldLink = $('.textfieldLink');
        obt_link.on({
            click: function() {
                var serverName = $('#urlcomienzo').val();
                var url = serverName+'/'+UserNameOther+'&post='+pInspiterId;
                $likeButton.hide();
                $textfieldLink.show();
                $likeField.attr("value",url);
            },
            mouseleave:function(){
                $textfieldLink.hide();
                $likeButton.show();
            }
        });
        
    /****************************************************************************************/
    //               AGREGA EL EVENTO PARA AGREGAR UNA INSPIRACION A MIS FAVORITOS
    /****************************************************************************************/
        var agg_fav = $('#multi-fav_'+pInspiterId);
        agg_fav.on({
            click: function() 
            {
                   $.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesion o registrate para poder agregar esta inspiraci\u00f3n a favoritos',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Regitrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });
                 return false;
            }
        });
				
		
		
      /****************************************************************************************/
      //               AGREGA EL EVENTO PARA DEDICAR UNA INSPIRACION
      /****************************************************************************************/
        var ded_insp = $('#multi-dedic_'+pInspiterId);
        ded_insp.on({
            click: function() 
            {
               $.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesion o registrate para poder dedicar esta inspiraci\u00f3n',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Regitrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });
                 return false;
            }
        });
               

      
       /****************************************************************************************/
       //               AGREGA EL EVENTO PARA COMMENTAR CON ENTER
       /****************************************************************************************/
        var comment_text = $('#comment_text_'+pInspiterId);
	var CurrentResultCom = $('#comment_count_'+pInspiterId).text();
         comment_text.on ({
         keydown: function(e) 
	 {
	    var keycodeCom = (e.keyCode ? e.keyCode : e.which);
            if(keycodeCom == 13) 
	    {      
	       //hacer algo
	       e.preventDefault();
             }
           }
        });
		
	/****************************************************************************************/
        //               AGREGA EL EVENTO PARA DENUNCIAR UNA INSPIRACION
        /****************************************************************************************/
        var denunciar_insp = $('#multi-denun_'+pInspiterId);
        denunciar_insp.on({
            click: function() 
			{
			  //hacer algo  
                        }
                       })
     /****************************************************************************************/
     //               AGREGA EL EVENTO CLICK AL BOTON SHARE TO FACEBOOK
     /****************************************************************************************/ 
        $('#faceShareInspiter_'+pInspiterId).on({
            click: function() 
            {
              $.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesion o registrate para poder compartir a facebook esta inspiraci\u00f3n',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Regitrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });
                 return false;
            }
        });
		
		
      /****************************************************************************************/
      //               AGREGA EL EVENTO CLICK A LA INSPIRACION PARA HACER APARECER EL ZOOM
      /****************************************************************************************/
        
        $("#phrase-box_"+pInspiterId).on({
            click: function(e)
            {
                if( $("#IpType_"+pInspiterId).val() == 'image')
                {
                    $("#zoomIns").krioImageLoader();
                    $("#ImageWithZoom").attr('src','');
                    $(".insvideoOrig").remove();
                    var OriWidth = $("#phrase-box_"+pInspiterId+" .lazy-load").data('oriwidth');
                    var OriHeight = $("#phrase-box_"+pInspiterId+" .lazy-load").data('oriheight');
                    $("#zoomIns").css({
                        width:OriWidth,
                        height:OriHeight
                    });
                    $("#ImageWithZoom").attr('src',pValue6).show();
                }
                else if( $("#IpType_"+pInspiterId).val() == 'video') 
                {   
                    $("#zoomIns").css({
                        width:730,
                        height:500
                    });
                    $(".insvideoOrig").remove();
                    $("#ImageWithZoom").hide();
                    
                    var videoOrig = '<div class="insvideoOrig" id="insVideoOrig_'+pInspiterId+'" style="position:relative;z-index:2;">';
                        videoOrig +='<iframe class="youtube-player" type="text/html" width="730px" height="500px" '; 
                        videoOrig +='src="'+pValue1+'?version=3&fs=1&autoplay=1" allowfullscreen webkitallowfullscreen mozallowfullscreen frameborder="0">'; 
                        videoOrig +='</iframe></div>';
                        $("#zoomIns").append(videoOrig);
                 }
                 $("#zoom-background").fadeIn(100, function(){
                 $("#avatarZoom").attr('src',pAvatar);
                 $("#avatarZoomLink").attr('href',UserNameOther);
                 $("#avatarNameZoom").text(FullNameOther).attr('href',UserNameOther);
                 
                 //y si es video entonces regalame un min, mientras si queres te voy haciendo el if...
                 $("#TitleImageZoom").text(pValue4);
                 $("#DescriptionImageZoom").text(pValue2);
                 $("#TimeZoom").text(pTimeAgo);
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
    //@Author:       Inspiter
    //Create Date:   17/12/2012
    //Purpose:     - Funcion que trae las personas que le dieron me Inspira a una inspiracion
    /*****************************************************************************************/ 
    function ShowInspired(pInspiterId)
    {	
       var ListaUserSearch='';   
       var toyEn = 'all';
       $.ajax({
            type: "POST",
            url: "/web/buscarUserInspirados.php",
            data:
                {
                 "IdInspiter": pInspiterId,
                 "noSession": "SI"
                },
            dataType: "json",
            success: function(arrayData)
            {	
                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired new-inspired"><a id="inspired_0" href="/'+usernameHidden+'"><span style="background-image: url('+$("#photosmall").val()+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_0" class="tooltipInspired">'+fullname+'</strong></a></li>';			
                if(arrayData.length == 0)
		{								
                  $('#comment-wrapper_'+pInspiterId+' .media-inspired .inspired-notice').animate({
                       opacity:'1'
                    },600);
		  $('#inspired_list_'+pInspiterId+' ul').append(ListaUserSearch);
                }
                else{    
                    var i=0;
                    $.each(arrayData,function(index,value) 
                     {
                        
                      if(toyEn == 'all' || toyEn == 'media')
                      {
                        
                        if(i<7)
			{			 
                            if((i == 6))
                            {			
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired last">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                            }
                            else
                            {
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                            }
                        }
                        i++; 
                        
                      }else
                       {
                        
                         if(i<10)
                         {			 
                            if((i == 9))
                            {			
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired last">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                            }
                            else
                            {
                                ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired"><a id="inspired_'+arrayData[index].IN_Inspire_id+'" href="/'+arrayData[index].US_User_Login+'"><span style="background-image: url('+arrayData[index].US_Photo_Small+');" class="img img-inset inspired-avatar"><b></b></span><strong id="tooltip_'+arrayData[index].IN_Inspire_id+'" class="tooltipInspired">'+arrayData[index].US_Full_Name+'</strong></a></li>';
                            }
                         }
                          i++; 
                            
                        }
                    });
                    
                    
                    /*AGREGA EL TEXTO "Y X MÀS..." CUANDO SON MAYORES A 10 SI ESTA EN TEXTO, O CUANDO SON MAYORES A 7 SI ESTA EN ALL O MEDIA*/
                    if(toyEn == 'all' || toyEn == 'media'){
                     if(i>7){
                         i = i-7;
                         ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired more"><a href="#"><span class="moreInspired">y <strong>'+i+'</strong> m\u00e1s...<b></b></span></a></li>';
                     }     
                    }else{
                     if(i>10){
                         i = i-10;
                         ListaUserSearch += '<li id="inspired_'+pInspiterId+'"class="inspired more"><a href="#"><span class="moreInspired">y <strong>'+i+'</strong> m\u00e1s...<b></b></span></a></li>';
                     }
                    }
                    /*END: AGREGA EL TEXTO "Y X MÀS..." CUANDO SON MAYORES A 10 SI ESTA EN TEXTO, O CUANDO SON MAYORES A 7 SI ESTA EN ALL O MEDIA*/
                    
                    $('#inspired_list_'+pInspiterId+' ul').append(ListaUserSearch); 
                    $.each(arrayData,function(index,value)
					{				     
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
                $('#loadingInspired_'+pInspiterId).animate({
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
//Purpose:     - Funcion que recupera los comentarios de una inspiracion especificada por parametro
/*****************************************************************************************/ 
function getCommentData(pInspiterId,pUserId,pUserIdOtro)
{
   $.ajax({
   url: "../web/mostrarCommentPerfil.php",
    data: {
            "inspiterId": pInspiterId,
            "noSession": "SI"
          },
    type: "POST",
    dataType: "json",
    success: function(data) 
    {	 
      if(data.length) 
        {		
            $('#loadingInspired_Com_'+pInspiterId).animate({
                    opacity:'0'
            },100);
            $('#comment-loading_'+pInspiterId).fadeOut(200);
            $('#inspired-notice_'+pInspiterId).fadeOut();
            buildCommentList(data,pInspiterId,pUserId,pUserIdOtro);
						
        }else{
            
             $('#comment_container_'+pInspiterId).addClass("NoResultCom");
	     $('#loadingInspired_Com_'+pInspiterId).animate({
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
//Purpose:     - Funcion que construye los comentarios de una inspiracion especificada por parametro
/*****************************************************************************************/ 
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
           addEvenToNewElementComment(data[index]['CM_Comm_id'],data[index]['US_User_Id'],data[index]['CM_Inspiter_id'],pUserIdOtro);

    });
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   30/12/2012
//Purpose:     - Funcion que agrega los eventos de los comentarios por inspiracion
/*****************************************************************************************/ 
function addEvenToNewElementComment(pCommentId,pUserId,pInspiterId,pUserIdPhrase)
{
   var idDenunciarComment = 'denComment_'+pCommentId;
   $('#'+idDenunciarComment).on({
     click: function()
	 {	 
		$.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesion o registrate para poder denunciar este comentario',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Regitrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });
                 return false;
        }
   }); 
}

 $(".facebook-share-button").click(function(){
	if($(this).data('checked')=='unchecked'){
		$(".facebook-share-button").addClass('checked').data('checked', 'checked');
		$(".externalServices .facebook span").text('Se compartira en cuanto publiques');
	 }else{
		$(".facebook-share-button").removeClass('checked').data('checked', 'unchecked');
		$(".externalServices .facebook span").text('Compartir en Facebook');
	 }
     });

    /*EFECTO DEL BOTON SEGUIR, SIGUIENDO Y DEJAR DE SEGUIR EN EL PERFIL DE OTRO USUARIO*/
    $('.btn-Follow-menu').on({
      click: function()
      {
       $.confirm({
			'title':'Informaci\u00f3n',
			'message':'Inicia sesion o registrate poder seguir a esta persona',
			'buttons':{
			           'Iniciar Sesi\u00f3n':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								        $(location).attr('href','../');
							            }
					        },
                                    'Regitrarse':{
 			  		         'class':'btn btn-success alertOffSuc',
						 'action':function(){
								       $(location).attr('href','../register.php');
							            }
					        },
			            'Cancelar':{
                                                 'class':'btn btn-cancel-option alertOffCan',
				                 'action': function(){}	
                                               }
                                   }
                     });   
    }
    });

	
    /*END: EFECTO DEL BOTON SEGUIR, SIGUIENDO Y DEJAR DE SEGUIR EN EL PERFIL DE OTRO USUARIO*/	


		/*EFECTO SWITCH PARA MOSTRAR LA IMAGEN DE PORTADA DEL USUARIO*/
		slide_control.click(function()
                {
		 if (slide_control.css("top")== "7px")
                 {
		   slide_control.animate({
                   top:'150px'
                   },300).attr('data-original-title','Mostrar información personal').tooltip('hide');
		   $PhraseInfoBlock.css("z-index","2").animate({
			opacity:'1'
			},200);
                 }
                 else
                 {
		   slide_control.animate({
                     top:'7px'
                  },300).attr('data-original-title','Mostrar Frase Insignia').tooltip('hide');
		  $PhraseInfoBlock.animate({
		  opacity:'0'
		  },400).css("z-index","0");	
                 }
		});
		/*END: EFECTO SWITCH PARA MOSTRAR LA IMAGEN DE PORTADA DEL USUARIO*/

       /*EFECTO CARGA SUAVIZADA DE LA IMAGEN DE PERFIL*/
            var urlUserProfile = $("#imgUserProfile").val();
            $("#imgProfileBlock").attr('src',urlUserProfile);
            $("#imgProfileBlock").load(function() 
            {
              $(this).addClass("load");
            });
        /*END: EFECTO CARGA SUAVIZADA DE LA IMAGEN DE PERFIL*/
        
        /*ASIGNA LOS TOOLTIPS DE VARIOS ELEMENTOS DE PERFIL DE USUARIO*/
       $("#ips_value_div").tooltip({
           template: '<div class="tooltip IPSmsg"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'        
       });
       
       $(".icon-face-url").tooltip({
           template: '<div class="tooltip icoProfile"><div class="tooltip-inner"></div></div>'        
       });
       
       $("#icon_denunc_user").tooltip({
           template: '<div class="tooltip icoProfile"><div class="tooltip-inner"></div></div>'        
       });
       
         $(".slide-control").tooltip({
           template: '<div class="tooltip icoProfile slideC"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
       });
     
         /*END:ASIGNA LOS TOOLTIPS DE VARIOS ELEMENTOS DE PERFIL DE USUARIO*/
	
   /**************************************************************************************************/
   //       APARECER Y DESAPARECER EL TITULO Y DESCRIPCION DEL LA IMAGEN EN EL ZOOM
   /**************************************************************************************************/
		
   $('#zoomIns').on({
            mouseenter: function(){
                if($("#TitleImageZoom").text() != ''){$("#title-image-zoom").fadeIn(100);}
		
		if($("#DescriptionImageZoom").text() != ''){$("#description-image-zoom").fadeIn(100);}
            },
				
            mouseleave: function(){
              $("#title-image-zoom").fadeOut(200);
              $("#description-image-zoom").fadeOut(200);
            }
        });
        
        
    
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   23/09/2012
    //Purpose:     - Evento Click del boton "Ver Mas" para las inspiraciones y los favoritos
    /*****************************************************************************************/
     
    $(window).scroll(function()
    {
       if ($(window).scrollTop() == $(document).height() - $(window).height())
       {
         if(v_inspiterId == null || v_inspiterId == 0)
         {
	   $("#LoadingInspirations").animate({
					      opacity: '1'
				             },100);
	   $(".loading-ico-more").show();
	   $(".load-more-inspiration").text("Cargando más inspiraciones para ti...");
	   $.ajax({  
                url: '../web/showInspiters.php',  
                data: 
                    {
                     "userId": userId,
                     "inspType": 'all',
                     "noSession": "SI",
                     "firstInspiterId": FirstInspiterId    
                    }, 
                type: "POST",  
                dataType: "json",  
                cache: false,  
                success: function(data) 
                {  
		  if(data.length > 0)
                  {
                      verMas = true; 
                      BuildInspiterProfile(data,verMas);
		  }
                  else
                  {
		    $(".loading-ico-more").hide();
		    $(".load-more-inspiration").text("No hay más resultados");
		  }
                 },
                 error: function(){alert("error");}
            });
	     $("#LoadingInspirations").animate({
					        opacity: '0'
		               	              },3000);
         }
      }
   });


});  