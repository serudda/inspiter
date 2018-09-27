$(document).ready(function()
{
   //global variables
    var $profile_body = $('.profile-body');
    var BtnWriter = $("#btn-inspiration");
    var aSocial = $("a.social");
    var ShareFaceIcoBig = $("#Share-facebook-ico-big");
    var ShareTwiIcoBig = $("#Share-twitter-ico-big");
    var QuickInspirationBoxBig = $(".quick-inspiration-box-big");
    var QucikInspirationBox = $(".quick-inspiration-box");
    var SharePhraseAutorBig = $("#sharePhrase-autor-big");
    var ShareAutorBig = $("#Share-autor-big");
    var ShareAutorSmall = $("#Share-autor-small");
    var CountUserData   = $(".info-phrases-user-profile");
    var $PhraseContBig  = $("#PhraseContBig");
    var vSessionId = $("#sessionId");
    var slide_control = $(".slide-control");
    var PhraseInfoBlock = $(".PhraseInfoBlock");
    var ProfileImageBlock = $("#ProfileImageBlock");
    var ProfileBlockHeader = $(".ProfileBlockHeader");
    var UserMenuComplete = $(".UserMenuComplete");
    var allOptionSort = $("#allOptionSort");
    var textOptionSort = $("#textOptionSort");
    var mediaOptionSort = $("#mediaOptionSort");
    var ico_all_inspirations = $(".ico-all-inspirations");
    var ico_text_inspirations = $(".ico-text-inspirations");
    var ico_media_inspirations = $(".ico-media-inspirations");
    var $modalDed = $('#modalDed');
    var $modal_background = $('#modal-background');
    var $BlockModalIns = $('#BlockModalIns');
    var $textIns = $('.textIns');
    var $imageIns = $('.imageIns');
    var $videoIns = $('.videoIns');
    var $BlockInspireImage = $('.BlockInspireImage');
    var $BlockInspireInputs = $('.BlockInspireInputs');
    var $BlockInspireVideo = $(".BlockInspireVideo");
    var resultSeguidores;
    var stateProfile = $("#stateProfile");
		
    var userId        = $("#useridhidden").val();
    var userIdLogged = $("#userIdLogged").val();


    if (userIdLogged != userId)
    {
        $("#main-profile-info").css("height","164px");
    }
    else
    {
        $("#main-profile-info").css("height","130px");
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

	
    // TEXTAREA EFFECTS	
	
    QuickInspirationBoxBig.maxlength({
        statusClass: "charCount"
    });
    QucikInspirationBox.maxlength( {
        statusClass: "charCount-small"
    } );
    SharePhraseAutorBig.maxlength( {
        maxCharacters: 30
    } );
	
    QuickInspirationBoxBig.focus(function(){
        $(".charCount").animate({
            opacity:'1'
        },500);
    });
	
    QuickInspirationBoxBig.blur(function(){
        $(".charCount").animate({
            opacity:'0'
        },500);
    });
	
    QucikInspirationBox.focus(function(){
        $(".charCount-small").animate({
            opacity:'1'
        },300);
    });
	
    QucikInspirationBox.blur(function(){
        $(".charCount-small").animate({
            opacity:'0'
        },300);
    });

	
    $("#content-phrasecont").hover(function(){
        ShareAutorBig.animate({
            opacity:'1'
        },500);
    }, function() {
        ShareAutorBig.animate({
            opacity:'0'
        },400);
    });

    $("#phrase-container-form").hover(function(){
        ShareAutorSmall.animate({
            opacity:'1'
        },500);
    }, function() {
        ShareAutorSmall.animate({
            opacity:'0'
        },400);
    });
	
    // END TEXTAREA EFFECTS	



    /*EFECTO DEL BOTON SEGUIR, SIGUIENDO Y DEJAR DE SEGUIR EN LOS CONTENEDORES DE SEGUIDORES*/


    var textBtnFollowMenu = "Seguir";

    if (userIdLogged != userId)
    {
        $.post("../web/add_del_seg_sig.php", {
            "pDadId": userId, 
            "pSunId": userIdLogged, 
            'type': 'followprofile'
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta accion');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data == 'YES')    //SI LO SIGUE SON A DAD
                {
                    $('.btn-Follow-menu').addClass('following');
                    $('.btn-Follow-menu').text('Siguiendo');
                    textBtnFollowMenu = "Siguiendo";
                }
                else
                {
                    $('.btn-Follow-menu').removeClass("unfollowing");
                    $('.btn-Follow-menu').text('Seguir');
                    textBtnFollowMenu = "Seguir";
                }
            }
        });
    }

		/*END: EFECTO DEL BOTON SEGUIR, SIGUIENDO Y DEJAR DE SEGUIR EN LOS CONTENEDORES DE SEGUIDORES*/

    /*EFECTO DEL BOTON SEGUIR, SIGUIENDO Y DEJAR DE SEGUIR EN EL PERFIL DE OTRO USUARIO*/
    $('.btn-Follow-menu').click(function(){
	
        if(textBtnFollowMenu == 'Dejar de Seguir'){
	
            /*TODO:QUIERO DECIR QUE YA LO ESTA SIGUIENDO, Y LE DOY CLICK, COLOCAR AQUI CODIGO QUE LO ELIMINE DE LOS QUE SIGO*/
            leaveToFollowProfile(userId,userIdLogged);
            $(this).removeClass("unfollowing");
            $(this).text('Seguir');
            textBtnFollowMenu = "Seguir";
            return false; 
		
        }else{
            startToFollowProfile(userId,userIdLogged);
            $(this).addClass("following");
            $(this).text('Siguiendo');
            textBtnFollowMenu = "Siguiendo";
            return false;
		
        }
    });

	
    $('.btn-Follow-menu').hover(function(){
	
        if(textBtnFollowMenu == 'Siguiendo'){
			
            $(this).removeClass("following");
            $(this).addClass("unfollowing");
            $(this).text('Dejar de Seguir');
            textBtnFollowMenu = "Dejar de Seguir";
			
        }
		
    }, function() {
			
        if(textBtnFollowMenu == 'Dejar de Seguir'){
			
            $(this).removeClass("unfollowing");
            $(this).addClass("following");
            $(this).text('Siguiendo');
            textBtnFollowMenu = "Siguiendo";
			
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
		   PhraseInfoBlock.css("z-index","2").animate({
			opacity:'1'
			},200);
                   if(userId == userIdLogged)     
                   {
                     $.post("../web/updateStateProfile.php", {
                      userId: userId, 
                      value: 1
                     },
                     function(data)
                     {
                      if(data == 'NOSSID')
                      {
                       $.genericAlert('Inicia sesion para poder realizar esta accion');
                       $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                      }
                     });
                   }
                 }
                 else
                 {
		   slide_control.animate({
                     top:'7px'
                  },300).attr('data-original-title','Mostrar Frase Insignia').tooltip('hide');
		  PhraseInfoBlock.animate({
		  opacity:'0'
		  },400).css("z-index","0");	
                  if(userId == userIdLogged)     
                  {
                   $.post("../web/updateStateProfile.php", {
                     userId: userId, 
                     value: 0
                    },
                    function(data)
                    {
                     if(data == 'NOSSID')
                     {
                      $.genericAlert('Inicia sesion para poder realizar esta accion');
                      $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                     }
                    });
                  }
                 }
		});
		/*END: EFECTO SWITCH PARA MOSTRAR LA IMAGEN DE PORTADA DEL USUARIO*/
		
                
           /*EFECTO APARECER-DESAPARECER BOTONES CAMBIAR IMAGEN DE PERFIL Y FRASE INSIGNIA*/
           ProfileImageBlock.on({
            mouseenter: function(){  
		$("#edit-avatar-button").fadeIn(100);
            },
				
            mouseleave: function(){
              $("#edit-avatar-button").fadeOut(100);
            }
        });   
        
        PhraseInfoBlock.on({
            mouseenter: function(){  
		$("#edit-phraseIns-button").fadeIn(100);
            },
				
            mouseleave: function(){
              $("#edit-phraseIns-button").fadeOut(100);
            }
        });
           /*END: EFECTO APARECER-DESAPARECER BOTONES CAMBIAR IMAGEN DE PERFIL Y FRASE INSIGNIA*/
                
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
       
       $("#btn-inspiration").tooltip({
           template: '<div class="tooltip icoProfile slideC"><div class="tooltip-inner"></div></div>'
       });
       
        $("#countNotif").tooltip({
           template: '<div class="tooltip icoProfile slideC" style="margin-top:-19px!important;"><div class="tooltip-inner"></div></div>',
       });
       
       $("#btn-myprofile").tooltip({
           template: '<div class="tooltip icoProfile slideC"><div class="tooltip-inner"></div></div>'
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
		
                
        /*COLOCAR FIJA LOS MENUS DEL USUARIO CUANDO SCROLLEA HACIA ABAJO*/
		 
				//Calcula el tamaño de ProfileBlockHeader, con el outerHeight (el outerHeight incluye el height mas el padding si lo tiene)
        var aboveHeight = ProfileBlockHeader.outerHeight();
				
	//Cuando se scrollee
        $(window).scroll(function(){
	        //Si el scroll baja más del height del ProfileBlockHeader
                if ($(window).scrollTop() > aboveHeight){
 
	        // Si es SI, Adiciona la class "fixed" al UserMenuProfile
	        // Adiciona padding top a el profile-container, para dar un espacio al contenido y que no lo cubra el Menu fijo.
                UserMenuComplete.addClass('fixed').css('top','50px').next()
                .css('padding-top','60px');
 
                } else {
 
	        // Cuando scrollee hacia arriba y es menor a height de ProfileBlockHeader,
					// se remueve la class "fixed", y el padding-top
                UserMenuComplete.removeClass('fixed').css('top','0px').next()
                .css('padding-top','0');
                }
        });
				
		/*END:COLOCAR FIJA LOS MENUS DEL USUARIO CUANDO SCROLLEA HACIA ABAJO*/
		
				
		/*EFECTO HOVER DE LAS OPCION MEDIA, TODO, TEXTO*/
		allOptionSort.hover(function(){
		 ico_all_inspirations.css("opacity","1");
		 allOptionSort.css("color","#000");
		},function(){
		 ico_all_inspirations.css("opacity","0.5");
		 allOptionSort.css("color","#8C8C8C");
		});
		
		textOptionSort.hover(function(){
		 ico_text_inspirations.css("opacity","1");
		 textOptionSort.css("color","#000");
		},function(){
		 ico_text_inspirations.css("opacity","0.5");
		 textOptionSort.css("color","#8C8C8C");
		});
		
		mediaOptionSort.hover(function(){
		 ico_media_inspirations.css("opacity","1");
		 mediaOptionSort.css("color","#000");
		},function(){
		 ico_media_inspirations.css("opacity","0.5");
		 mediaOptionSort.css("color","#8C8C8C");
		});
		/*END:EFECTO HOVER DE LAS OPCION MEDIA, TODO, TEXTO*/
		

    function leaveToFollowProfile(pDadId,pSunId)
    {
        $.post("../web/add_del_seg_sig.php", {
            LFdadId: pDadId, 
            LFsunId: pSunId
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta accion');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data != 'NO')
                {
                   var resultSeguidores = parseInt($('#pFollower').text())-1;
                   $('#pFollower').text(resultSeguidores); 
                   addIPSNegative(11,0,pDadId);
                }
            }
        });
    }

    function startToFollowProfile(pDadId,pSunId)
    {
        $.post("../web/add_del_seg_sig.php", {
            FdadId: pDadId, 
            FsunId: pSunId
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta accion');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data != 'NO')
                {
                  resultSeguidores = parseInt($('#pFollower').text())+1;
                  $('#pFollower').text(resultSeguidores);
                  verifAddNotificationAni(pDadId,pSunId,0,4);
                }
            }
        });
    }
    
    
     /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   07/12/2012
  //Purpose:     - Verifica cada uno de los llamados para chequear si se generan notificaciones o no   
  /*****************************************************************************************/   
  function verifAddNotificationAni(pUserIdotro,pUserId,pInspiterId,pType)
  {
      if(pType == '1')
      { 
           $.ajax({
            url: "../web/add_del_seg_sig.php",
            data: {
                "seSessionId":+ vSessionId.val(),
                "seUserId":+pUserIdotro
            },
            type: "POST",
            dataType: "json",
            success: function(data) 
            {
                if(data.length > 0)
                
                 if(data.toString().indexOf('NOSSID') >= 0)
                 {
                    $.genericAlert('Inicia sesion para poder realizar esta accion');
                    $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                 }
                 else
                 {
                     $.each(data,function(index,value)
                      { 
                        addNotificationAni(data[index].FW_Sun_Id, pUserId, pInspiterId, pType);
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
            addNotificationAni(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '3') //me inspira
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotificationAni(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '4') //seguir
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotificationAni(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '5') //agregar a favoritos
     {
         if(pUserIdotro.toString() != pUserId.toString())
            addNotificationAni(pUserIdotro, pUserId, pInspiterId, pType);
     }
     else if(pType == '6') //dedicar una frase
     {}
  }
  
  /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   07/12/2012
  //Purpose:     - Genera una notificacion de algun tipo  
  /*****************************************************************************************/   
  function addNotificationAni(pUserIdotro,pUserId,pInspiterId,pType)
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
                 $.genericAlert('Inicia sesion para poder realizar esta accion');
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
    
    CountUserData.show();
    $PhraseContBig.show();
    
		
		
		  /****************************************************************************************/
      //               AGREGA EL EVENTO CLICK AL LAPICITO PARA HACER APARECER EL MODAL
      /****************************************************************************************/
        
        BtnWriter.on({
            click: function(e) {
                 $modal_background.fadeIn(200, function(){
								 $BlockModalIns.fadeIn(200);
								 $profile_body.css('overflow-y','hidden');
								 e.preventDefault();
								});
            }
        });
		
  
	       /****************************************************************************************/
			 //               AGREGA EL EVENTO PARA CERRAR LOS MODALES (DEDICAR, INSPIRARSE)
       /****************************************************************************************/
        
				/*MODAL DEDICAR*/
				
				$('#closeModalDedic').on ({
            click: function(e) {
               $modal_background.fadeOut(200)
               $modalDed.fadeOut(200)
							 e.preventDefault();
						 }
        });
												
	 

        $modal_background.on ({
            click: function(e) {
               $modal_background.fadeOut(200)
               $modalDed.fadeOut(200)
						   e.preventDefault();	
						 }
        });	
				
		/**************************************************************************************************/
		//               AGREGA EL EVENTO A LOS BOTONES DEL MODAL DE INSPIRACIONES (TEXTO, IMAGEN, VIDEO)
    /**************************************************************************************************/
		 
		 $imageIns.click(function(e)
                 {
			$BlockInspireImage.show();
			$BlockInspireInputs.hide();
                        $BlockInspireVideo.hide();
			$imageIns.addClass('active');
			$textIns.removeClass('active');
			$videoIns.removeClass('active');
                     if($("#previewImage").attr('data-status') == 'withImage') 
                        {
			   $(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
			}
                        else
                        {
                           $(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
                           //estop no esta andando.. ver q es
                        }
			e.preventDefault();
		 });
		 
		 $videoIns.click(function(e)
                 {
                     $BlockInspireImage.hide();
		     $BlockInspireInputs.hide();
                     $BlockInspireVideo.show();
                     $imageIns.removeClass('active');
		     $textIns.removeClass('active');
                     $videoIns.addClass('active');                     
                     if($("#previewVideo").attr('data-status') == 'withImage') 
                        {
			   $(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
			}
                        else
                        {
                           $(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
                           //estop no esta andando.. ver q es
                        }
                     e.preventDefault();
		 });
                 
                 $textIns.click(function(e)
                 {
			$BlockInspireImage.hide();
                        $BlockInspireVideo.hide();
			$BlockInspireInputs.show();
			$imageIns.removeClass('active');
			$textIns.addClass('active');
                        $videoIns.removeClass('active');
                        
			if(($(".post-inspiration-text").val().length > 0) && ($(".post-inspiration-text").val() != ' ') ) 
                        {
			   $(".btn-publish-inspiration").removeClass('disabled').attr('disabled', false).css('cursor','pointer');
			}
                        else
                        {
                            $(".btn-publish-inspiration").addClass('disabled').attr('disabled', 'disabled').css('cursor','default');
                        }
			e.preventDefault();
		 });
		
		
    /**************************************************************************************************/
    //       APARECER Y DESAPARECER EL BOTON "AGREGAR" CUANDO SE PEGA TEXTO EN EL INPUT TYPE TEXT
    /**************************************************************************************************/
		
    $("#FileUploadBrowser").bind("paste",function(e) {
    $("#button-add-image").show();
    });

		$("#FileUploadBrowser").keyup(function(){
		 if($(this).val()==''){
			$("#button-add-image").hide();
		 }else{
			$("#button-add-image").show();
		 }
		});
			
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
            }
        });
  }
});
