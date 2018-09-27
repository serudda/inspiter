$(document).ready(function()
{
 /****************************************************************************************/
 //                           VARIABLES GLOBALES
 /****************************************************************************************/
 var $countNotif = $("#countNotif");
 var $style_Notif = $(".style-Notif");
 var $icon_notif = $(".icon-notif"); 
 var mouse_is_inside_not = false;
 
 /****************************************************************************************/
 //                            DATOS DE USUARIO
 /****************************************************************************************/
 var vSessionId     = $("#sessionId");
 var doc	    = $(document);

   var refreshId = setInterval(function() {
      $.post("../web/notificationAmount.php", {
            "sessionId": vSessionId.val()
        },
        function(data)
        { 
          if(data != '' && data != null && data!= 0 && data.toString().indexOf('NOSSID') < 0)
          {
             $("#countNotif").html(data);
	     $icon_notif.css("display","none");
	     $style_Notif.css('background-color','#D72929');
	     $countNotif.css("background-image","url()");
	     $countNotif.css("display","block");
             if ($('#fullnameInput').val() != null &&  $('#fullnameInput').val() != undefined && $('#Iam').val()=='profile')
                          $(document).attr("title", "("+parseInt(data)+") "+$('#fullnameInput').val());
                         else
                           $(document).attr("title", "("+parseInt(data)+") "+"Inspiter"); 
	   }
           else if (data == 0)
           {
   	     $countNotif.text('');
	     $style_Notif.css('background-color','transparent');
	     $countNotif.html('<i class="icon-notif" style="display: block;"></i>');
             if ($('#fullnameInput').val() != null &&  $('#fullnameInput').val() != undefined && $('#Iam').val()=='profile')
                      $(document).attr("title", $('#fullnameInput').val());
                  else
                      $(document).attr("title", 'Inspiter'); 
           }
           else if (data.toString().indexOf('NOSSID') >= 0)
            {
               $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
               $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }

        }
        );
   }, 20000);
   $.ajaxSetup({ cache: false });


  if($countNotif.text() == ''){
      //$style_Notif.css('background-color','#525B52');
			$countNotif.css("display","block");
			$icon_notif.css("display","block");
			}else{
			 $icon_notif.css("display","none");
			 $style_Notif.css('background-color','#D72929');
			// $countNotif.css("padding","10px");
			 $countNotif.css("background-image","url()");
			 $countNotif.css("display","block");
			 
			}
  /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   03/12/2012
    //Purpose:     - Agrega el evento click a la opci�n "Notificaciones" del menu de la derecha
    //             - Muestra las Notificaciones del usuario logueado
  /*****************************************************************************************/
  $countNotif.on({
      click: function(e){
					
	var cacheNot = doc.data('Notif'); 
					
          if(!$("#display-result-notif").length) //pregunto si existe el elemento...
          {	
          /*  if(cacheNot){	
                var ListNot = doc.data('Notif');
                var notiFinal = '<ul id="display-result-notif" class="display-result-notif">'+ListNot+'</ul>';
                $('#countNotificPos').after(notiFinal);
                $('#display-result-notif').mCustomScrollbar({ set_height:253 });
            }
	    else{*/
                /*MOSTRAMOS EL LOADING*/
                var notifLoading = '<ul id="display-result-notif" class="display-result-notif"><div class="loadingNot"></div></ul>';
                $('#countNotificPos').after(notifLoading);
                $('#display-result-notif').css("overflow-y","hidden");
                $.ajax({
                 url: "../web/mostrarNotificacionesPerfil.php",
                    data: {
                        "sessionId": vSessionId.val()
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data) 
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta accion');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                          if(data.length > 0)
                          {
                             BuildNotificationProfile(data);  // Se construyen los contenedores de "MIS NOTIFICACIONES"
                          }
                          else
                          {
                          }
                        }
                    },
                    error: function(data)
                    {
                    }
            });
            
            setearVisto();
	  //}
         }
         else
         {
             $("#display-result-notif").remove();
         }
	 e.preventDefault(); 
      },
      mouseenter:function(){
                mouse_is_inside_not=true;
      },
      mouseleave:function(){
                mouse_is_inside_not=false;
      }
  });
 
  function BuildNotificationProfile(data)
  {
      var textNotif = ' ';
      var notif_wall_post = '<div class="result-section-title-notif"><span>Notificaciones</span></div>';
      $.each(data,function(index,value) 
      {	
	var VistoNot = data[index].NO_Status;	
        var desc = data[index].NT_Descripcion;
        var textNotifAux = desc.toString().replace('User','<b>'+data[index].US_Full_Name+'</b>');
        if (data[index].NT_Name=='commenToo')
        {
            if(data[index].US_Full_Name != data[index].IP_Full_Name)
                 textNotif = textNotifAux.replace('User2','<b>'+data[index].IP_Full_Name+'</b>');
            else
                 textNotif = '<b>'+data[index].IP_Full_Name+'</b> tambien ha comentado su inspiracion';
        }
        else
        {
            textNotif = textNotifAux;
        }
      	 /*PINTAR LAS NOTIF. QUE NO SE HAN VISTO*/
	if(VistoNot == 1){
	      notif_wall_post += '<li id="notif_'+data[index].NO_Notif_Id+'" class="display_box_notif" data-pos="" align="left" style="background-color:#E5F7CF;">';
	}
	 else
	{
	      notif_wall_post += '<li id="notif_'+data[index].NO_Notif_Id+'" class="display_box_notif" data-pos="" align="left">';
	}		 
           if(data[index].NT_Name=='publish')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].US_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='sharefb')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].SS_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='mif')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].SS_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='follow')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].US_User_Login+'&inspiterId=0&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='favourite')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].SS_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='dedicate')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].SS_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'&dedicId='+data[index].NO_Dedication_Id+'">';
           else if (data[index].NT_Name=='comment')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].IP_By_User+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='commenToo')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].IP_By_User+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           else if (data[index].NT_Name=='dedicInsp')
              notif_wall_post += '<a class="link-user-notif" href="/web/routeadorNotif.php?notifId='+data[index].NO_Notif_Id+'&userid='+data[index].SS_User_Login+'&inspiterId='+data[index].NO_Inspiter_Id+'&typeName='+data[index].NT_Name+'">';
           notif_wall_post += '<img src="'+data[index].US_Photo_Small+'">';
           notif_wall_post += '<span class="ResultNotif">'+textNotif+'</span>';
           notif_wall_post += '<span class="TimeResultNotif">'+data[index].NO_Time_Ago+'</span></a></li>';
      });
			 $(".loadingNot").remove();
			 $('#display-result-notif').append(notif_wall_post);
			 /*CACHEADA*/
	//		 doc.data('Notif',notif_wall_post);
			//if(data.length < 5){
			/* $('#display-result-notif').css("overflow-y","hidden");*/
			// $('#display-result-notif').css("width","277px");
			//}
			//else
			// {
				/*$('#display-result-notif').css("overflow-y","scroll");*/
			// }
			
      $('#display-result-notif').mCustomScrollbar({ set_height:253 });
      //if($countNotif.text() != '')
      //{
         // setearVisto();
      //}
			$countNotif.text('');
			$style_Notif.css('background-color','transparent');
			$countNotif.html('<i class="icon-notif" style="display: block;"></i>');

  }


function setearVisto()
{    
     $.post("../web/visto.php", {
            "sessionId": vSessionId.val(),
            "configStatusNotif": 0
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
                  if ($('#fullnameHidden').val() != null &&  $('#fullnameHidden').val() != undefined && $('#Iam').val()=='profile')
                      $(document).attr("title", $('#fullnameHidden').val());
                  else
                      $(document).attr("title", 'Inspiter'); 
                }
                else
                {
                }
            }
        });  
}


        /****************************************************************************************/
        //     PARA CERRAR O ABRIR LOS COMMENT BOX SI LE DOY CLICK A CUALQUIER PARTE DE DOCUMENTO
        /****************************************************************************************/
			
        $('#display-result-notif').on({ 
            mouseenter:function(){
                mouse_is_inside_not=true;
            },
            mouseleave:function(){
                mouse_is_inside_not=false;
            } 
        });

        //Agrega el evento click al documento, para cuando le de click en cualquier lugar excepto 
        //los comment-wrapper, me cierre los commment-wrappers
        doc.click(function(){ 
            if(!mouse_is_inside_not){
                $("#display-result-notif").remove();
            }
        });
			


});


