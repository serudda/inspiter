$(window).load(function()
{
 var mouse_is_inside = false;
 var InspireArray = new Array();
 var usernameHidden = $("#usernameHidden").val();
 var fullname       = $("#fullname").val();
 var facebookId     = $("#faceidHidden").val();
 var userIdLogged   = $("#userIdLogged").val();
 var usernameLogged = $("#usernameHidden").val();
 var fullnameLogged = $("#fullnameHidden").val();
 var $post_inspiration_text = $(".post-inspiration-text");
 var $btn_publish_inspiration = $(".btn-publish-inspiration");
 var $post_inspiration_autor = $(".post-inspiration-autor");
 var doc		= $(document);
 var userId        = $("#userId").val();
 var $modal_background = $('#modal-background');
 var $BlockModalIns = $('#BlockModalIns');
 var $profile_body = $('.profile-body');
 var userIdOther   = $("#useridhidden").val();
 var min=100000000;
 //var imageDescription = $(".title-inspiration").val();
 //
 ////*******REFERENCIAS**********////
 ////value1 = uri,phrase+++++++++////
 ////value2 = descrip, author++++////
 ////value4 = title, author++++++////
 ///********REFERENCIAS*********/////

String.prototype.convertirURL = function() 
{
    return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function(url) {
        return '<a target="_blank" href="'+url+'">'+url+'</a>';
    });
};

   /****************************************************************************************/
   //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Colocar las primeras letras en mayuscula
    /*****************************************************************************************/
    function MaysPrimera(string)
    {
        string = string.toLowerCase();
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
		 
		
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Construye las inspiraciones por partes, esta funcion es llamada por todas las demas
    //               al darle click a cada opcion (Inspiraciones, Favoritos)
    /*****************************************************************************************/
    $.BuildInspiterProfile = function(data,verMas)
    {   
        var $content = $("#content");
        var ico_all_inspirations = $(".ico-all-inspirations");
        var ico_text_inspirations = $(".ico-text-inspirations");
        var ico_media_inspirations = $(".ico-media-inspirations");
        var textOptionSort = $('#textOptionSort');
        var mediaOptionSort = $('#mediaOptionSort');
        var allOptionSort = $('#allOptionSort');
        var $photosmall =    $("#photosmall");

        switch (doc.data('OptionInspiterType')) 
         {
          /****************************************************************************************/
          //	CONSTRUYE LAS INSPIRACIONES CUANDO ESTAS EN: TODO
          /****************************************************************************************/
           case 'all':
           {
                min=100000000;
		/*Da el foco a la opcion: TODO*/
		ico_all_inspirations.addClass("icoActive");
		allOptionSort.addClass("OptionActive");
		ico_media_inspirations.removeClass("icoActive");
		mediaOptionSort.removeClass("OptionActive");
		ico_text_inspirations.removeClass("icoActive");
		textOptionSort.removeClass("OptionActive");
		$.each(data,function(index,value) 
                {
                   var wall_post_dato = '<div class="allPartInspiration" style="margin-top: 20px!important;"><input type="hidden" value="'+((10-index))+'" id="orden_'+data[index].IP_Inspiter_Id+'">';
                   /*CONSTRUYE LOS TEXTOS EN LA OPCION "TODO"*/
		   if(data[index].IP_Type == "text")
                   {						 


                    wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';
                    
                    if(doc.data('OptionSelected') == 'top')
                    {
                      if((10-index) == 1)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                      }
                      else if((10-index) == 2)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                      }
                      else if((10-index) == 3)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                      }
                     }
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
		 
		  else if(data[index].IP_Type == "image")
                  {
                     wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
                     if(doc.data('OptionSelected') == 'top')
                     {
                      if((10-index) == 1)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                      }
                      else if((10-index) == 2)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                      }
                      else if((10-index) == 3)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                      }
                     }

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
		     wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].IP_Type+'" id="IpType_'+data[index].IP_Inspiter_Id+'"><div id="phrase-box_'+data[index].IP_Inspiter_Id+'" class="phrase-box mediaPadd"><div style="height:'+data[index].IP_Value5+'px;" class="inner-phrase"><img class="lazy-load" data-src="'+data[index].IP_Value1+'" data-src-mobile="'+data[index].IP_Value1+'" src="'+data[index].IP_Value1+'" height="'+data[index].IP_Value5+'" data-oriwidth="'+data[index].IP_Value7+'" data-oriheight="'+data[index].IP_Value8+'" /><span class="loadingPost">Cargando...</span>';
                     
                     if(data[index].IP_Value4 != ''){
                        //alert('entro='+data[index].IP_Value4); 
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
                     {}
                  }
                  else if(data[index].IP_Type == "video")
                  {
                     wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small video" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
                     if(doc.data('OptionSelected') == 'top')
                     {
                      if((10-index) == 1)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                      }
                      else if((10-index) == 2)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                      }
                      else if((10-index) == 3)
                      {
                        wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                      }
                     }

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
		     $.addEvenToNewElement(data[index].IP_Inspiter_Id,data[index].SS_User_Logged,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
		     if (data[index].IN_Inspire_Inspiter == 1)//ya lo estamos enviando... bueno sacalo entonces...data[index].IP_Value1
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
          if(doc.data('OptionSelected') != 'top'){
               
               $('.wrapperAll').removeClass('centerWrapp');	       
			   $('#content').masonry({
				 isFitWidth: true,
				 columnWidth: 435,
				 gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
           });
               }else{
                   $('.wrapperAll').addClass('centerWrapp');
                   $('#content').masonry({
				 //isFitWidth: true,
                                 columnWidth: 800,
				//gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
		      	        });
               }             
	 
               break;
            }
						
	  /****************************************************************************************/
          //	 CONSTRUYE LAS INSPIRACIONES CUANDO ESTAS EN: MEDIA
          /****************************************************************************************/		
          case 'media':
          {
             min=100000000;
             /*Da el foco a la opcion: TODO*/
             ico_media_inspirations.addClass("icoActive");
             mediaOptionSort.addClass("OptionActive");
             ico_all_inspirations.removeClass("icoActive");
             allOptionSort.removeClass("OptionActive");
             ico_text_inspirations.removeClass("icoActive");
             textOptionSort.removeClass("OptionActive");				 
             $.each(data,function(index,value) 
             {
               var wall_post_dato = '<div class="allPartInspiration" style="margin-top: 20px!important;"><input type="hidden" value="'+((10-index))+'" id="orden_'+data[index].IP_Inspiter_Id+'">';
               if(data[index].IP_Type == "image")
               {
                  wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
                  if(doc.data('OptionSelected') == 'top')
                  {
                    if((10-index) == 1)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                    }
                    else if((10-index) == 2)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                    }
                    else if((10-index) == 3)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                    }
                   }
                  wall_post_dato += '<div id="multiOptionMenu_'+data[index].IP_Inspiter_Id+'" class="multiOption">';
                  wall_post_dato += '<div class="ico-multiOpt"></div><dl class="multiOptionList" id="multiOptionList_'+data[index].IP_Inspiter_Id+'" >';
                  wall_post_dato += '<dt class="multi-Favorite" id="multi-fav_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiFav" id="ico-multiFav_'+data[index].IP_Inspiter_Id+'" ></div>';
                  wall_post_dato += '<span id="textFav_'+data[index].IP_Inspiter_Id+'">Agregar a Favoritos</span></dt>';
                  wall_post_dato += '<dd class="multi-share" id="multi-dedic_'+data[index].IP_Inspiter_Id+'">';
                  wall_post_dato += '<div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd>';
                  wall_post_dato += '<dd class="multi-link" id="multi-link_'+data[index].IP_Inspiter_Id+'"><div class="linkButton">';
                  wall_post_dato += '<div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input type="text" id="inputLink" name="" value="" class="input linkField"><p>Comparte este link con tus amigos</p></div></dd>';
		  if(data[index].SS_User_Logged != data[index].US_User_Id)
                  {
                    wall_post_dato += '<dd id="multi-denun_'+data[index].IP_Inspiter_Id+'" class="multi-share den"><div class="ico-multiDen"></div>Denunciar inspiraci\u00F3n</dd>';
                  }
                  if(data[index].SS_User_Logged == data[index].US_User_Id)
                  {
                    wall_post_dato += '<dt class="multi-delete" id="multi-delete_'+data[index].IP_Inspiter_Id+'"><div class="ico-multiDel"></div>Eliminar<div class="Del-loading" id="Del-loading_'+data[index].IP_Inspiter_Id+'"></div></dt>';
		  }
                  wall_post_dato += '</dl></div><input type="hidden" value="'+data[index].IP_Inspiter_Id+'" id="InspiterId_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].IP_Type+'" id="IpType_'+data[index].IP_Inspiter_Id+'"><div id="phrase-box_'+data[index].IP_Inspiter_Id+'" class="phrase-box mediaPadd"><div style="height:'+data[index].IP_Value5+'px;" class="inner-phrase">';
                  wall_post_dato += '<img class="lazy imgInspi" src="'+data[index].IP_Value1+'" data-original="'+data[index].IP_Value1+'" height="'+data[index].IP_Value5+'" data-oriwidth="'+data[index].IP_Value7+'" data-oriheight="'+data[index].IP_Value8+'"><span class="loadingPost">Cargando...</span>';
                  
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
                  wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"> <a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a><input type="hidden" value="'+data[index].IN_Inspire_Media+'" id="inspireInspiter_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].FV_Is_In_Favourite+'" id="favouriteInspiter_'+data[index].IP_Inspiter_Id+'">';
                  wall_post_dato += '<a data-placement="bottom" style="margin-top: -28px;" original-title="Facebook" href="#" class="social fb" id="faceShareInspiter_'+data[index].IP_Inspiter_Id+'" data-original-title="Compartir en Facebook">Facebook</a></div></div></div>';
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
		  $.addEvenToNewElement(data[index].IP_Inspiter_Id,data[index].SS_User_Logged,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login,"image",data[index].IP_Value4);  					
                  if (data[index].IN_Inspire_Media == 1)
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
               }
               else if(data[index].IP_Type == "video")
               {
                 wall_post_dato += '<div class="grid-feed-contest-item feed-item box feed-item-new text-inspi-box-small video" id="grid_feed_contest_item_'+data[index].IP_Inspiter_Id+'">';  
                 if(doc.data('OptionSelected') == 'top')
                 {
                    if((10-index) == 1)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                    }
                    else if((10-index) == 2)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                    }
                    else if((10-index) == 3)
                    {
                       wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                    }
                 }
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
                 wall_post_dato += '<div id="social-icons-share_'+data[index].IP_Inspiter_Id+'" class="social-icons-share"> <a style="margin-top: -28px;" original-title="Inspiter" href="#" class="social ins" id="ins_'+data[index].IP_Inspiter_Id+'">Inspiter</a><input type="hidden" value="'+data[index].IN_Inspire_Media+'" id="inspireInspiter_'+data[index].IP_Inspiter_Id+'"><input type="hidden" value="'+data[index].FV_Is_In_Favourite+'" id="favouriteInspiter_'+data[index].IP_Inspiter_Id+'">';
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
		 $.addEvenToNewElement(data[index].IP_Inspiter_Id,data[index].SS_User_Logged,data[index].IP_Value1,data[index].IP_Value2,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login, data[index].IP_Type, data[index].IP_Value4);  					
		 if (data[index].IN_Inspire_Media == 1)
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
               if(parseInt(data[index].IP_Inspiter_Id) < parseInt(min))
               {
                 min=parseInt(data[index].IP_Inspiter_Id);
               }
              });
              console.log("minimo es: "+min);
	      doc.data('FirstInspiterId',parseInt(min));
	      if(doc.data('OptionSelected') != 'top'){
               
               $('.wrapperAll').removeClass('centerWrapp');	       
			   $('#content').masonry({
				 isFitWidth: true,
				 columnWidth: 435,
				 gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
               });
               }else{
                   $('.wrapperAll').addClass('centerWrapp');
                   $('#content').masonry({
				 //isFitWidth: true,
                                 columnWidth: 800,
				//gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
		      	        });
               }
	      break;
           }                     
          /****************************************************************************************/
          //CONSTRUYE LAS INSPIRACIONES CUANDO ESTAS EN: TEXT
          /****************************************************************************************/
          case 'text':
          {
             min=100000000;
	     /*Da el foco a la opcion: TODO*/
             ico_text_inspirations.addClass("icoActive");
             textOptionSort.addClass("OptionActive");
             ico_all_inspirations.removeClass("icoActive");
             allOptionSort.removeClass("OptionActive");
             ico_media_inspirations.removeClass("icoActive");
             mediaOptionSort.removeClass("OptionActive");				 
             $.each(data,function(index,value) 
             {

                  var wall_post_dato = '<div class="allPartInspiration"><input type="hidden" value="'+((10-index))+'" id="orden_'+data[index].PH_Phrase_Id+'">';           

                wall_post_dato += '<div id="grid_feed_contest_item_'+data[index].PH_Phrase_Id+'" class="grid-feed-contest-item feed-item box feed-item-new text-inspiration-box">';
                if(doc.data('OptionSelected') == 'top')
                {
                    if((10-index) == 1)
                    {
                        wall_post_dato += '<div class="medalWinned MedallaTop1"></div>';
                    }
                    else if((10-index) == 2)
                    {
                        wall_post_dato += '<div class="medalWinned MedallaTop2"></div>';
                    }
                    else if((10-index) == 3)
                    {
                        wall_post_dato += '<div class="medalWinned MedallaTop3"></div>';
                    }
                }
				wall_post_dato += '<div id="multiOptionMenu_'+data[index].PH_Phrase_Id+'" class="multiOption"> <div class="ico-multiOpt"></div><dl id="multiOptionList_'+data[index].PH_Phrase_Id+'" class="multiOptionList"><dt id="multi-fav_'+data[index].PH_Phrase_Id+'" class="multi-Favorite"><div id="ico-multiFav_'+data[index].PH_Phrase_Id+'" class="ico-multiFav"></div><span id="textFav_'+data[index].PH_Phrase_Id+'">Agregar a Favoritos</span></dt><dd id="multi-dedic_'+data[index].PH_Phrase_Id+'" class="multi-share"><div class="ico-multiSha"></div>Dedicar inspiraci\u00F3n</dd><dd id="multi-link_'+data[index].PH_Phrase_Id+'" class="multi-link"><div class="linkButton"><div class="ico-multiLin"></div>Obtener link</div><div class="textfieldLink"><input class="input linkField" value="" type="text" name="" id="inputLink" ><p>Comparte este link con tus amigos</p></div></dd>';
                if(data[index].SS_User_Logged != data[index].US_User_Id)
                {
                  wall_post_dato += '<dd id="multi-denun_'+data[index].PH_Phrase_Id+'" class="multi-share den"><div class="ico-multiDen"></div>Denunciar inspiraci\u00F3n</dd>';
                }                   
                if(data[index].SS_User_Logged == data[index].US_User_Id)
                {
                  wall_post_dato += '<dt id="multi-delete_'+data[index].PH_Phrase_Id+'" class="multi-delete"><div class="ico-multiDel"></div>Eliminar<div id="Del-loading_'+data[index].PH_Phrase_Id+'" class="Del-loading"></div></dt>';
                }
                wall_post_dato +=  '</dl></div><input type="hidden" id="InspiterId_'+data[index].PH_Phrase_Id+'" value="'+data[index].PH_Phrase_Id+'"><div class="phrase-box"> <div class="comillas-background-right"><img src="images/comillas-right.png" alt=""></div> <div class="comillas-background-left"><img src="images/comillas-left.png" alt=""></div> <div class="inner-phrase" style="min-height:50px"><blockquote class="pullquote">' + data[index].PH_Phrase + '</blockquote> <div style="position: relative; height: 26px;"><a href="#" class="autor-name">'+ data[index].PH_Author +'</a></div><div class="decorImg"></div></div> </div> <div class="border-div"></div> <div class="extra-tile-info"> <div class="avatar-inspiter"> <a href="/'+data[index].US_User_Login+'"> <img class="img-user-inspiter" src="'+data[index].US_Photo_Small+'" alt=""></a> </div>  <div class="avatar-user-info"> <input type="hidden" id="UserId_'+data[index].SS_User_Logged+'" value='+data[index].SS_User_Logged+'><h4><a class="name-complete-box" href="/'+data[index].US_User_Login+'">'+data[index].US_Full_Name+'</a></h4> <a class="username-box" href="/'+data[index].US_User_Login+'">'+data[index].US_User_Login+'</a> <p class="user-inspiter-city-country">'+data[index].US_City+'</p> </div>';
                //Construimos el contenedor donde muestra la cantidad de Me Inspira y de Comentarios
                wall_post_dato +=  '<div id="Count_Fav_'+data[index].PH_Phrase_Id+'" class="textCountFav Count_Fav"><div id="ico-Fav-Inspiter_'+data[index].PH_Phrase_Id+'" class="ico-Fav-Inspiter"></div><ul id="countsIns_'+data[index].PH_Phrase_Id+'" class="countsIns"><li class="inspired-button"><strong><span id="pCount_'+data[index].PH_Phrase_Id+'" class="count-badge inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspirados</b></strong><a href="javascript:;" class="inspired-button inspired-button" id="inspired_button_'+data[index].PH_Phrase_Id+'"><span>inspirar</span><b></b><div class="icoInsp"></div><span class="i-inspired" id="i_inspired"></span></a></li><li class="comment-count">';
                //Construimos el contador de comentarios
                wall_post_dato += '<strong><span class="count-badge comment-count" id="comment_count_'+data[index].PH_Phrase_Id+'">'+data[index].CM_Comment_Amount+'</span><b>Comments</b></strong><a href="javascript:;" class="comment-button" id="comment_button_'+data[index].PH_Phrase_Id+'"><span>Comment</span><b></b><div class="icoCom"></div></a></li></ul></div>';
                wall_post_dato += '<small class="time"> <a href="#" class="inspiter-timestamp" title="'+data[index].IP_CreateDate+'"><span class="_timestamp js-short-timestamp " data-time="1342325570" data-long-form="true">'+data[index].PH_Time_Ago+'</span></a> </small> <div id="social-icons-share_'+data[index].PH_Phrase_Id+'" class="social-icons-share"> <a id="ins_'+data[index].PH_Phrase_Id+'" class="social ins" href="#" original-title="Inspiter" style="margin-top: -28px; " >Inspiter</a> <input type="hidden" id="inspireInspiter_'+data[index].PH_Phrase_Id+'" value="'+data[index].IN_Inspire_Phrase+'"><input type="hidden" id="favouriteInspiter_'+data[index].PH_Phrase_Id+'" value="'+data[index].FV_Is_In_Favourite+'"><a id="faceShareInspiter_'+data[index].PH_Phrase_Id+'" class="social fb" href="#" original-title="Facebook" style="margin-top: -28px; " title="Compartir en Facebook" data-placement="bottom">Facebook</a></div> </div> </div>';
                //Construir el comment box (Lista de personas que se Inspiraron y Comentarios)
                wall_post_dato += '<div id="comment-wrapper_'+data[index].PH_Phrase_Id+'" class="comment-wrapper text-comment-box"><div class="media-inspired"><h2><span id="inspired-count_'+data[index].PH_Phrase_Id+'" class="inspired-count">'+data[index].IN_Cant_Insp+'</span><b>inspired</b></h2><div id="loadingInspired_'+data[index].PH_Phrase_Id+'"class="loadingInspired"></div><p class="inspired-notice"><span>Nadie le ha dado a me inspira a\u00fan.</span></p><div id="inspired_list_'+data[index].PH_Phrase_Id+'" class="inspired-list inspired-slide"><ul></ul></div></div>  <div id="comment_container_'+data[index].PH_Phrase_Id+'" class="comment-container"><ul id="comment-list_'+data[index].PH_Phrase_Id+'" class="comment-list"><div id="loadingInspired_Com_'+data[index].PH_Phrase_Id+'" class="loadingInspired"></div>';
                wall_post_dato += '<p id="inspired-notice_'+data[index].PH_Phrase_Id+'" class="inspired-notice"><span>Nadie ha comentado a\u00fan.</span></p>';
                wall_post_dato += '<li id="comment-loading_'+data[index].PH_Phrase_Id+'" class="comment comload"></li></ul></div>';
                //Construye el form y el textarea para escribir un comentario
                wall_post_dato += '<form id="media_addcomment" class="media-addcomment text-addcomment"><label>Commentarios</label><span style="background-image: url('+$photosmall.val()+');" class="img img-inset inspired-avatar"><b></b></span><textarea name="comment_text" id="comment_text_'+data[index].PH_Phrase_Id+'" class="placeholder" style="height: 24px;" placeholder="Opinar sobre esta inspiracion"></textarea></form></div></div>';
                if(verMas)
                {
		  var $boxes = $(wall_post_dato);
		  $('#content').append( $boxes ).masonry( 'appended', $boxes);
		  //$content.append(wall_post_dato);
                }
                else
                {
		  $content.prepend(wall_post_dato);
                }
              	$('#comment-wrapper_'+data[index].PH_Phrase_Id+' .comment-container').mCustomScrollbar({
								 set_height:200												
								});						
                //LLAMA A LA FUNCION QUE ASIGNA LOS EVENTOS A CADA UNO DE LOS ELEMENTOS DE LAS INSPIRACIONES
  		$.addEvenToNewElement(data[index].PH_Phrase_Id,data[index].SS_User_Logged,data[index].PH_Phrase,data[index].PH_Author,data[index].US_User_Id,data[index].SS_UserPhoto_Logged,data[index].US_Photo_Small,data[index].IP_Value6,data[index].IP_Time_Ago,data[index].SS_UserFullName_Logged,data[index].SS_Username_Logged,data[index].US_Full_Name, data[index].US_User_Login,"text","");  					                  
                if (data[index].IN_Inspire_Phrase == 1)
                {
                 $('#ins_'+data[index].PH_Phrase_Id).addClass("dontInspire");
                }
                else
                {
                 $('#ins_'+data[index].PH_Phrase_Id).removeClass("dontInspire");
                }
                if(data[index].FV_Is_In_Favourite == 1)
                {
                 $('#ico-Fav-Inspiter_'+data[index].PH_Phrase_Id).css("background-position","-23px -20px");
                 $('#ico-multiFav_'+data[index].PH_Phrase_Id).css("background-position","-23px -18px");
                 $('#textFav_'+data[index].PH_Phrase_Id).text("Quitar de Favoritos");
                }
                else
                {}
                //obtener el minimo
                if(parseInt(data[index].PH_Phrase_Id) < parseInt(min))
                {
                   min=parseInt(data[index].PH_Phrase_Id);
                }
              });
              console.log("minimo: "+min);
	      doc.data('FirstInspiterId',parseInt(min));
	      if(doc.data('OptionSelected') != 'top'){
               
               $('.wrapperAll').removeClass('centerWrapp');	       
			   $('#content').masonry({
				 isFitWidth: true,
				     columnWidth: 570,
				 gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
           });
               }else{
                   $('.wrapperAll').addClass('centerWrapp');
                   $('#content').masonry({
				 //isFitWidth: true,
                                 columnWidth: 800,
				//gutterWidth: 10,
				 itemSelector:'.allPartInspiration'
		      	        });
               }	 
              break;
            }
            default:
            {}
       }
       $(".inner-phrase").krioImageLoader();   
       $('#Bigloading').hide();																	
     }
		
    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Comparte la inspiracion en Facebook
    /*****************************************************************************************/
    $.graphStreamPublish = function(pValue1,pValue2,userId,inspiterId,pFullname,pUserIdOtro,pUsername,inspType,pValue4,amIPublishing,pValue6)
    {
       if (facebookId == null || facebookId == '' || facebookId == 0)
       {
           $.genericAlert("Debes asociar tu cuenta de facebook desde el men\u00fa configurar para poder realizar esta acci\u00f3n.");
           if(amIPublishing == 'SI')
           {
                window.location.reload();
           }
       }
       else
       {
         if(inspType == 'text')
         {
            var nArray=pValue2.split(" ");
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
                NewAuthor =  MaysPrimera(pValue2);
            }
            var body = pValue1 + '. --'+ NewAuthor;
            FB.getLoginStatus(function(response) 
            {
                if (response.status === 'connected') 
                {
                    var uid = response.authResponse.userID;
                    if(facebookId==uid)
                    {
                        FB.api('/me/feed', 'post', { 
                            message:  body,
                            description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar cualquier inspiracion, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con contenido que ha dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                            picture:'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                            name:  'Frase compartida por '+pFullname,
                            link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
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
                                $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                                $.AfterShareFace();
                                if(amIPublishing == 'SI')
                                {
                                    window.location.reload();
                                }
                         
                             }
                           });
                    }
                    else
                    {
                 $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                    }
	   
                } else if (response.status === 'not_authorized') {
                } else {
                    FB.login(function(response) {
                        if(response.authResponse) {
                            if(facebookId==response.authResponse.userID)
                            {
                                var body = pValue1 + '. --'+ NewAuthor;  
                                FB.api('/me/feed', 'post', { 
                                    message:  body,
                                    description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar cualquier inspiracion, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con contenido que ha dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                                    picture:'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                                    name:  'Frase compartida por '+pFullname,
                                    link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                                    actions: [
                                    {
                                        name: 'Inspiter', 
                                        link:'http://www.inspiter.com'
                                    }
                                    ]
                                }, function(response) {
                                    if (response)
                                    {
                                        $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                                        $.AfterShareFace();
                                        if(amIPublishing == 'SI')
                                        {
                                           window.location.reload();
                                        }
                                    }
                                });
                            }
                            else
                            {
                               $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                               if(amIPublishing == 'SI')
                               {
                                   window.location.reload();
                               }
                            }
                        }
                    });
                }
            }, true);
        }
        else if(inspType== 'image')
        {
            //cuando se comparte a face una inspiracion ya publicada si se puede redimensionar
            var uri = 'http://www.inspiter.com'+pValue1.substring(2);
            FB.getLoginStatus(function(response) {
             if (response.status === 'connected') {
             var uid = response.authResponse.userID;
             var accessToken = response.authResponse.accessToken;
             if(facebookId==uid)
             {
               FB.api('/me/feed', 'post', { 
                   message:  pValue4,
                   description: pValue2,
                   picture: uri,
                   name:  pFullname+' compartió una imagen en Inspiter.',
                   link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                   actions: [
                   {
                       name: pUsername+' en Inspiter', 
                       link:'http://www.inspiter.com/'+pUsername
                   }
                   ]
               }, function(response) {  
                   if (response)
                   {
                       $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                       $.AfterShareFace();
                       if(amIPublishing == 'SI')
                       {
                           window.location.reload();
                       }
                    }
               });
             }
             else
             {
                $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                 if(amIPublishing == 'SI')
                 {
                    window.location.reload();
                 }
             }
       } else if (response.status === 'not_authorized') {
       } else {
           FB.login(function(response) {
               if(response.authResponse) {
                   if(facebookId==response.authResponse.userID)
                   {
                       FB.api('/me/feed', 'post', { 
                           message:  pValue4,
                           description: pValue2,
                           picture: uri,
                           name:  pFullname+' compartió una imagen en Inspiter.',
                           link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                           actions: [
                           {
                               name: pUsername+' en Inspiter', 
                               link:'http://www.inspiter.com/'+pUsername
                           }
                           ]
                       }, function(response) {
                           if (response)
                           {
                               $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                               $.AfterShareFace();
                               if(amIPublishing == 'SI')
                               {
                                   window.location.reload();
                               }
                           }
                       });
                   }
                   else
                   {
                      $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                      if(amIPublishing == 'SI')
                      {
                        window.location.reload();
                      }
                   }
               }
           });
       }
   }, true);
 }
 else if(inspType== 'video')
 {
    var uriVideo = 'http://www.inspiter.com'+pValue6.substring(2);
    FB.getLoginStatus(function(response) 
    {
      if (response.status === 'connected') 
      {
        var uid = response.authResponse.userID;
        if(facebookId==uid)
        {
          FB.api('/me/feed', 'post', 
          { 
            message:  pValue4,
            description: pValue2,
            picture: uriVideo,
            name:  pFullname+' compartió un video en Inspiter.',
            link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
            actions: [
                           {
                               name: pUsername+' en Inspiter', 
                               link:'http://www.inspiter.com/'+pUsername
                           }
                     ]
           }, function(response) 
           {  
             if (response)
             {
                $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                $.AfterShareFace();
                if(amIPublishing == 'SI')
                {
                   window.location.reload();
                }
              }
            });
           }
           else
           {
             $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
             if(amIPublishing == 'SI')
             {
                window.location.reload();
             }
           }
        } 
        else 
        {
          FB.login(function(response) 
          {
            if(response.authResponse) 
            {
             if(facebookId==response.authResponse.userID)
             {
                FB.api('/me/feed', 'post', 
                { 
                  message:  pValue4,
                  description: pValue2,
                  picture: uriVideo,
                  name: pFullname+' compartió un video en Inspiter.',
                  link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                  actions: [
                  {
                    name: pUsername+' en Inspiter', 
                    link:'http://www.inspiter.com/'+pUsername
                  }
                  ]
                 }, function(response) 
                 {
                  if (response)
                  {
                    $.verifAddNotification(pUserIdOtro,userId,inspiterId,2);
                    $.AfterShareFace();
                    if(amIPublishing == 'SI')
                    {
                      window.location.reload();
                    }
                   }
                  });
                   }
                  else
                  {
                   $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                   if(amIPublishing == 'SI')
                   {
                      window.location.reload();
                   }
                  }
               }
           });
       }
   }, true);
 }
}
}
		
 //function addEvenToNewElement(pInspiterId, pUserId, pPhraseContent, pAuthor, pUserIdOtro, pPhotoProfile, pFullnameLogged,pUsernameLogged)
 $.addEvenToNewElement = function(pInspiterId, pUserId, pValue1, pValue2,pUserIdOtro, pPhotoProfile,pAvatar,pValue6,pTimeAgo,pFullnameLogged, pUsernameLogged, FullNameOther, UserNameOther, pInspType, pValue4)
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
  //               AGREGA EL EVENTO CLICK AL BOTON ELIMINAR
  /****************************************************************************************/ 
  var idDeleteInspiter = 'multi-delete_'+pInspiterId;
  var $idDeleteLoading = 'Del-loading_'+pInspiterId;
  $('#'+idDeleteInspiter).on({
          click: function()
          {
            $.confirm({
			'title':'Advertencia',
			'message':'\u00bfSeguro que quieres eliminar esta inspiraci\u00f3n?',
			'buttons':{
			            'Eliminar':{
 			  		         'class':'btn btn-success',
						 'action':function(){
								       $('#'+$idDeleteLoading).show(); 
                                                                       eliminaInspiracion(pInspiterId,pUserId,pInspType);
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
   var flagInspireInspiter = $('#inspireInspiter_'+pInspiterId); //0 aun no inspirada, tiene q inspirar
   //1 ya inspirada, tiene q ya no inspirar
   $('#ins_'+pInspiterId).on({
            click: function(){
                   var  CantMeIns;
                   if(flagInspireInspiter.val() == '1')
                   {
                     //Ya le habia dado Me Inspira
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
                    DeleteInspiration(pInspiterId,pUserId,pUserIdOtro);	
                    $(this).removeClass("dontInspire");
                    flagInspireInspiter.val("0");
	            //Si nadie le habia dado me inspira
		    if (CantMeIns == 0){
			$('#comment-wrapper_'+pInspiterId+' .media-inspired .inspired-notice').animate({
                        opacity:'1'
                    },800);								}
                    return false;
		   }
                   else
                   {
                       //No le habia dado Me Inspira
                       CantMeIns = $('#pCount_'+pInspiterId).text();
		       //Si nadie le habia dado me inspira
			if (CantMeIns == 0)
                        {
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
        var $iconFav = $('#ico-Fav-Inspiter_'+pInspiterId);
        var is_favourited = $('#favouriteInspiter_'+pInspiterId);
        agg_fav.on({
            click: function() {
                if(is_favourited.val() == 1)
                    deleteToFavourite(pInspiterId,pUserId,pUserIdOtro);
                else
                    addToFavourite(pInspiterId,pUserId,pUserIdOtro);
            }
        });
        
        //Agregar/Elimina a favoritos dandole click a la estrella encima del contador de Me Inspira
        $iconFav.on({
            click: function() {
                if(is_favourited.val() == 1)
                    deleteToFavourite(pInspiterId,pUserId,pUserIdOtro);
                else
                    addToFavourite(pInspiterId,pUserId,pUserIdOtro);
            }
        });
				
		
		
      /****************************************************************************************/
      //               AGREGA EL EVENTO PARA DEDICAR UNA INSPIRACION
      /****************************************************************************************/
        var ded_insp = $('#multi-dedic_'+pInspiterId);
        ded_insp.on({
            click: function() {
                $('#dedicUsername').val(UserNameOther);
                $('#dedicInspiterId').val(pInspiterId);
                $('#modal-background').fadeIn(200)
                $('#modalDed').fadeIn(200)
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
		 var commenText = comment_text.val();
	         if(commenText != "")
		 {
		   comment_text.val("");
		   if(CurrentResultCom == '0')
		   {
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
            click: function() 
			{
			 $.confirm({
			   	    'title':'Advertencia',
				    'message':'\u00bfSeguro que quieres denunciar esta inspiraci\u00f3n?',
			            'buttons':{
					        'Denunciar':{
 							     'class':'btn btn-success',
							     'action':function(){
								      denunciarInspiracion(pUserIdOtro,pInspiterId);
							              }
							    },
						'No denunciar':{
                                                             'class':'btn btn-cancel-option',
						             'action': function(){}	
                                                               }
                                              }
                                   });
                          }
                       })
     /****************************************************************************************/
     //               AGREGA EL EVENTO CLICK AL BOTON SHARE TO FACEBOOK
     /****************************************************************************************/ 
        $('#faceShareInspiter_'+pInspiterId).on({
            click: function() {
                $.post("../web/verificarSesion.php",
                    function(data)
                    {
                        if (data.toString().indexOf('NOSSID') < 0)
                        {
                            $.graphStreamPublish(pValue1,pValue2,pUserId,pInspiterId,FullNameOther,pUserIdOtro,UserNameOther,pInspType,pValue4,'NO',pValue6);
                        }
                        else
                  {$.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');}     
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
    //																		 FUNCIONES
    /****************************************************************************************/
    
		
	
    /****************************************************************************************/
    //               ELIMINA UNA INSPIRACION POR SU AUTOR Y POR SU ID DE INSPIRACION
    /****************************************************************************************/
    function eliminaInspiracion(pInspiterId,pUserId,pInspType)
    {
        $.post("../web/eliminaFrase.php", {
            inspiterId: pInspiterId, 
            userId: pUserId,
            inspType: pInspType
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
                    InspireArray.remove('grid_feed_contest_item_'+pInspiterId);
                    var resultInspiracion = parseInt($('#pInspiraciones').text())-1;
                    $('#pInspiraciones').text(resultInspiracion);
		    $('#content').masonry('reload');
                });
            }
        })
    }

    Array.prototype.remove=function(s){
        for(i=0;i<this.length;i++) if(s==this[i]) this.splice(i, 1);
    }

    /****************************************************************************************/
    //              AGREGA UN "ME INSPIRA" A LA INSPIRACION
    /****************************************************************************************/
    function AddInspiration(pInspiterId,pUserId,pUserIdotro)
    {
        $.post("../web/add_delete_Inspire.php", {
            IinspiterId: pInspiterId, 
            IuserId: pUserId,
            tokenID: $("#tokenID").val()
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
                    $.verifAddNotification(pUserIdotro, pUserId, pInspiterId, 3);
                    if(userIdOther == userIdLogged && $("#Iam").val() == 'profile')
                      $("#pInspire").text(parseInt($("#pInspire").text())+1);
                }
                else
                {
                }
            }
        });
    }


    /****************************************************************************************/
    //              ELIMINA UN "ME INSPIRA" CUANDO SE LE DA CLICK A UNA INSPIRACION QUE YA FUE INSPIRADA
    /****************************************************************************************/
    function DeleteInspiration(pInspiterId,pUserId,pUserIdOtro)
    {
        $.post("../web/add_delete_Inspire.php", {
            DinspiterId: pInspiterId, 
            DuserId: pUserId
        },
        function (data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(pUserId != pUserIdOtro)
                  addIPSNegative(9,pInspiterId,0);
                if(userIdOther == userIdLogged && $("#Iam").val() == 'profile')
                 $("#pInspire").text(parseInt($("#pInspire").text())-1);
            }
        });
    }
		
		  /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   18/11/2012
    //Purpose:     - Agrega una inspiracion a mis favoritos  
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
                    
                    $.verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 5);
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
    //Purpose:     - Quita una inspiracion a mis favoritos  
    /*****************************************************************************************/   
    function deleteToFavourite(pInspiterId,pUserId,pUserIdOtro)
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
                    if(pUserId != pUserIdOtro)
                      addIPSNegative(10,pInspiterId,0);
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
    $.verifAddNotification = function (pUserIdotro,pUserId,pInspiterId,pType)
    {
        if(pType == '1')
        { 
            $.ajax({
                url: "../web/add_del_seg_sig.php",
                data: {
                    "seSessionId":+ $("#sessionId").val(),
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
        else if(pType == '6') //dedicar una inspiracion
     {}
        else if(pType == '7') //comment
        {
             if(pUserIdotro.toString() != pUserId.toString())
                addNotification(pUserIdotro, pUserId, pInspiterId, pType);
        }
        else if(pType == '8') //commentToo
        {
            $.ajax({
                url: "../web/mostrarCommentPerfil.php",
                data: {
                     "sessionId": $("#sessionId").val(),
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
                                 if(data[index].CM_User_id.toString() != data[index].IP_User_Id.toString() && data[index].CM_User_id != pUserId)
                                 {
                                     addNotification(data[index].CM_User_id,pUserId,data[index].CM_Inspiter_id,8);
                                 }
                            });
                        }
                },
                error: function(data)
                {						 
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
                      
                }
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
        var toyEn = doc.data('OptionInspiterType');
        var dataString = 'IdInspiter='+ pInspiterId;
				
        //var cacheInspired = doc.data('Inspired'+pInspiterId);	 
				
        $.ajax({
            type: "POST",
            url: "/web/buscarUserInspirados.php",
            data: dataString,
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
            "sessionId": $("#sessionId").val(),
            "inspiterId": pInspiterId
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
   var idDeleteComment = 'delComment_'+pCommentId;
   $('#'+idDeleteComment).on({
     click: function()
     {	 
       eliminaComment(pCommentId,pUserId,pInspiterId,pUserIdPhrase);
       return false;
     }
   }); 
	 $('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");
         
   var idDenunciarComment = 'denComment_'+pCommentId;
   $('#'+idDenunciarComment).on({
     click: function()
	 {	 
		$.confirm({
		 'title'		: 'Advertencia',
		 'message'	: '\u00bfSeguro que quieres denunciar este comentario?',
		 'buttons'	: {
                  'Denunciar'	: {
                     'class'	: 'btn btn-success',
                     'action': function()
		     {
		     denunciarComment(pCommentId,pUserId,pInspiterId);
                     }
		   },
		   'No denunciar'	: {
		     'class'	: 'btn btn-cancel-option',
		     'action': function(){}
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
//Purpose:     - Funcion que elimina un comentario de una inspiracion especifica
/*****************************************************************************************/ 
function eliminaComment(pCommentId,pUserId,pInspiterId,pUserIdPhrase)
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
                $('#comment_'+pCommentId).fadeOut(600, function () 
		{
                    var resultCountComment = parseInt($('#comment_count_'+pInspiterId).text())-1;
                    $('#comment_count_'+pInspiterId).text(resultCountComment); 
                    $('#comment_'+pCommentId).remove();
	             switch(resultCountComment)
				 {	 
			 case 0:
				$('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");
				$('#comment_container_'+pInspiterId).addClass("NoResultCom");
				$('#inspired-notice_'+pInspiterId).fadeIn(800);
				break;
		         default:
				break;
		     }
                });
                $('#comment-wrapper_'+pInspiterId+' .comment-container').mCustomScrollbar("update");
                if(pUserId != pUserIdPhrase)
                  addIPSNegative(8,pInspiterId,0);
            }
        })
}

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   30/12/2012
//Purpose:     - Funcion que inserta un comentario de una inspiracion especifica
/*****************************************************************************************/ 
function insertComment(pInspiterId,pUserId,pComment,pUsername,pFullName,pPhoto,pUserIdOtro)
{
     var commentId1;
     
     var comment = pComment.convertirURL();
     $.post("../web/add_Comment.php", {
            inspiterId: pInspiterId,
            userId: pUserId,
            comment: comment 
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
                            list_comment += '<p>'+comment+'</p>';
                            list_comment += '<div class="comment-links">';
                            list_comment += '<span class="script" style="display: inline;">';
                            list_comment += '<a id="delComment_'+commentId+'" class="collapse" href="#">Eliminar</a>';
                            list_comment += '</span></div></h4></div></li>';       
                            $('#comment-list_'+pInspiterId).append(list_comment);	
                            var resultCountComment = parseInt($('#comment_count_'+pInspiterId).text())+1;
                            $('#comment_count_'+pInspiterId).text(resultCountComment);
                            addEvenToNewElementComment(commentId,pUserId,pInspiterId);
                            $.verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 7);
                            $.verifAddNotification(pUserIdOtro, pUserId, pInspiterId, 8);
                 }
             }
           });
   }
	 
/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   09/01/2013
//Purpose:     - Funcion que elimina una dedicatoria
/*****************************************************************************************/ 
$.eliminaDedication = function (pDedicationId)
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
	      $.afterRegiter('Usted ha denunciado la inspiraci\u00f3n, estaremos analizando su denuncia.','Exitoso');
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


    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Crea las frases cuando se le da click en el boton "Publicar" del contenedor pequeno
    /*****************************************************************************************/
    
    function createTextInspiration(phrase_content,autor_content)
    {   
        
        if(phrase_content != '')
        { 
            var inspiterId;
            $.post("../web/CreatePhraseProfile.php", {
                frase: phrase_content, 
                author: autor_content, 
                user: userIdLogged
            },
            function(data,status) {
                inspiterId = data;
                if(inspiterId == 'NOSSID')
                {
                    $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
		    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                }
                else 
                { 
                    if(inspiterId != 'NO')
                    { 
			if(status=='success')
                        {
                           if($(".facebook-share-button").data('checked')=='checked')
                           {
                              $.graphStreamPublish(phrase_content,autor_content,userIdLogged,inspiterId,fullnameLogged,userIdLogged,usernameLogged,'text',"",'SI','');
                           }
                           else
                           {
                               window.location.reload();
                           }
                        }
                    }
                    else
                    {
										 //TODO: Mostrar el mensaje de error si algo falla, al estilo ladyGaga
                    }
                }
            });
        }
    }



    /****************************************************************************************/
    //                            EVENTOS
    /****************************************************************************************/                  

    /************************************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Deshabilitar el boton "Publicar" del contenedor de inspiraciones TEXTO cuando no hay texto
    //               en el textarea.
    /***********************************************************************************************************/
    $post_inspiration_text.keyup(function() { 
        if(($post_inspiration_text.val().length > 0) && ($post_inspiration_text.val() != ' ') ) {   
            $btn_publish_inspiration.removeClass('disabled').attr('disabled', false).css('cursor','pointer');
        } else {  
            $post_inspiration_text.val('');
            $btn_publish_inspiration.addClass('disabled').attr('disabled', 'disabled').css('cursor','default');	
        }  
    });
		
		
		/****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Evitar que el usuario mantenga presionado "space key" en el textarea de Inspirarse
    //               
    /*****************************************************************************************/
    $post_inspiration_text.keypress(function() { 

        if($post_inspiration_text.val() == ' ') {
            $post_inspiration_text.val('');
        }
    });	

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Habilita el boton publicar del textarea del Inspirarse cuando pegas texto con click derecho
    //               
    /*****************************************************************************************/
    $post_inspiration_text.bind("paste",function(e) {
    	    $btn_publish_inspiration.removeClass('disabled').attr('disabled', false).css('cursor','pointer');
    });
   

    /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Crear la inspiracion despues de dar click en el boton publicar del textarea del
    //               contenedor pequeno.
    /*****************************************************************************************/
    $btn_publish_inspiration.livequery("click", function ()
    {
       if ($('.BlockInspireInputs').is (':visible'))
       {
         var textarea_content = $post_inspiration_text.val(); 
         var autor_content = $post_inspiration_autor.val();
         if(autor_content.length == 0)
         { 
            autor_content = 'Desconocido';
         }
         if (textarea_content != '')
         {	
	    $btn_publish_inspiration.text('Publicando...');
            createTextInspiration(textarea_content,autor_content);	
         }
         else 
         {
	    $.TextareaEmpty();	   
         }
       }
       else if ($('.BlockInspireImage').is (':visible'))
       {
            $btn_publish_inspiration.text('Publicando...');
            createImageInspiration();
       }
       else if($('.BlockInspireVideo').is (':visible'))
       {
            $btn_publish_inspiration.text('Publicando...');
            createVideoInspiration();
       }
       
    });  
    
    
     /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   05/03/2013
    //Purpose:     - Crea una imagen cuando se le da click en el boton "Publicar"
    /*****************************************************************************************/
    function createImageInspiration()
    { 
      var inspiterId;
      $.post("../web/createImage.php", {
             title: $("#titleImageInsp").val(), 
             description: $("#DescriptionImageInsp").val(),
             userId: userIdLogged
        },
        function(data,status) {
            inspiterId = data;
            if(inspiterId == 'NOSSID')
            {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else 
            { 
                if(inspiterId != 'NO') //&& inspiterId.toString().indexOf('Excepcion capturada') >= 0)
                { 
		   if(status=='success')
                   {
                       if($(".facebook-share-button").data('checked')=='checked')
                       {
                           $.post("../web/getUrlImage.php", 
                           {
                             inspiterId: inspiterId
                            }, function(data,status)
                            {
                                var uri = data;
                                $.graphStreamPublish(uri,$("#DescriptionImageInsp").val(),userIdLogged,inspiterId,fullnameLogged,userIdLogged,usernameLogged,'image',$("#titleImageInsp").val(),'SI','');
                            });
                       }
                       else
                       {
                           location.reload();
                       }
                      
                   }
                }
                else
                {
		   //TODO: Mostrar el mensaje de error si algo falla, al estilo ladyGaga
                }
                }
           });
    }
    
    /*MODAL INSPIRARSE CERRAR*/
	 $('#closeModalIns').on 
         ({
            click: function(e) 
            {
	       $profile_body.css('overflow-y','scroll');
               $modal_background.fadeOut(200);
               $BlockModalIns.fadeOut(100);
               $('.previewImage').css('background-image','').attr('data-status','withoutImage');
               $(".post-inspiration-text").val('');
               $(".post-inspiration-autor").val('');
               $("#FileUploadBrowser").val('');
               $(".btn-publish-inspiration").addClass('disabled').attr('disabled','disabled');
               $(".title-inspiration").val('');
               $(".description-inspiration").val('');
               $('.previewImageBlock').hide();
               $('.previewVideoBlock').hide();
               $('.descriptionTitleImageBlock').hide();
               $('.add-photo-ico').show();
               $('.add-video-ico').show();
               eliminaImagenesTemp();
             e.preventDefault();
             }
         });
         
 /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   06/03/2013
    //Purpose:     - Elimina la imagen temporal que se cargo en el server al momento de hacer click en la cruz
    /*****************************************************************************************/				 
  function eliminaImagenesTemp()
  {
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
                if(data == 'YES') 
                { 
		   
                }
                else
                {
		   //TODO: Mostrar el mensaje de error si algo falla, al estilo ladyGaga
                }
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
  
  /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   06/04/2013
  //Purpose:       Crear una inspiracion de video. 
  /*****************************************************************************************/	
  function createVideoInspiration()
  {
      var inspiterId;
      $.post("../web/createVideo.php", {
             title: $('#titleVideoInsp').val(), 
             description: $('#DescriptionVideoInsp').val(),
             userId: userIdLogged
        },
        function(data,status) 
        {
            inspiterId = data;
            if(inspiterId == 'NOSSID')
            {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');	
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else 
            { 
                if(inspiterId != 'NO')
                { 
		   if(status=='success')
                   {
                       if($(".facebook-share-button").data('checked')=='checked')
                       {
                           $.post("../web/getUrlVideo.php", 
                           {
                             inspiterId: inspiterId
                            }, function(data,status)
                            {
                                var uri = data;
                                var array = uri.split('@');
                                $.graphStreamPublish(array[0],$('#DescriptionVideoInsp').val(),userIdLogged,inspiterId,fullnameLogged,userIdLogged,usernameLogged,'video',$('#titleVideoInsp').val(),'SI',array[1]);
                           });
                       }
                       else
                       {
                           location.reload();
                       }
                      
                   }
                }
                else
                {
		   
                }
                }
           });
  }
    
});