$(document).ready(function(){
    //global variables
    
    var $ConfigButtonMenu =  $("#ConfigButtonMenu");
    var ModalName =           $("#inputNameConf");
    var ModalCity =           $("#inputCityConf");
    var ModalPassword1 =      $("#inputPassword1Conf");
    var ModalPassword2 =      $("#inputPassword2Conf");
    var ModalPassword3 =      $("#inputPassword3Conf");
    var reqMessageName =     $("#boxName");
    var reqMessageCity =     $("#boxCity");
    var reqModalMessagePass = $(".message-box-pass");
    var reqModalMessagePass2 = $(".message-box-pass2");
    var estadoBox           = "false";
    var prim                = "false";
    var ModalBtnSave =        $("#btn_save_data");
    var ModalImage   =        $("#fotografia");
    var UserId      =         $("#userIdLogged");
    var FaceId      =         $("#faceidHidden");
    var Username    =         $("#usernameHidden");
    var SaveChanges =         $("#btn_save_data");
    var AlertMessage =        "";
    var TitleConfig =        "";
    var UserFaceId;
    var inviteFace = $("#inv-facebook");
    var linkudpateFace = $("#asso-btn-facebook-modal");
 
    //Validate Modal Configuration Profile
    //Validate Full Name

    function validateNameConf(){  

		
        if(ModalName.val().length == 0)	{		// Es vacio
            //reqMessageName.removeClass("success");
            reqMessageName.addClass("error");
            reqMessageName.html("<strong>Advertencia!</strong></br>Es necesario mostrar tu nombre");
            // SaveChanges.attr('disabled', true);
            // SaveChanges.addClass("disabled");
            ModalName.addClass("error");
            estadoBox = "true";
            return false;
        }

        /*else if(estadoBox == "true"){ 										//Si no esta vacio
	
			ModalName.removeClass("error");
                        estadoBox = "false";
                        SaveChanges.attr('disabled', true);
			SaveChanges.addClass("disabled");
			return true;
		}*/
                
        else{
            reqMessageName.removeClass("error");
            ModalName.removeClass("error");
            // SaveChanges.attr('disabled', false);
            // SaveChanges.removeClass("disabled");
            estadoBox = "false";
            return true;
                   
        }
	
    }

    //END: Validate Full Name




    //Validate City

    function validateCityConf(){  

		
        if(ModalCity.val().length == 0)	{		// Es vacio
            //reqMessageCity.removeClass("success");
            reqMessageCity.addClass("error");
            reqMessageCity.html("<strong>Advertencia!</strong></br>Es necesario mostrar tu ciudad");
            // SaveChanges.attr('disabled', true);
            // SaveChanges.addClass("disabled");
            ModalCity.addClass("error");
            estadoBox = "true";
            return false;
        }

        /*else if(estadoBox == "true"){ 										//Si no esta vacio
			
			ModalCity.removeClass("error");
                        estadoBox = "false";
                        SaveChanges.attr('disabled', true);
			SaveChanges.addClass("disabled");
			return true;
		}*/	
        else{
            reqMessageCity.removeClass("error");
            ModalCity.removeClass("error");
            // SaveChanges.attr('disabled', false);
            // SaveChanges.removeClass("disabled");
            estadoBox = "false";
            return true;
        }
	
    }

    //END: Validate City


    //Validar Nueva Contrase�a y Verifique Contrase�a
    
    
    function validatePassword1(){ 				// Si el campo Nueva Contrase�a o Verificar Contrase�a
        // Estan vacios
        if(ModalPassword2.val().length == 0 && ModalPassword3.val().length == 0 && ModalPassword1.val().length != 0) {
		
            ModalPassword2.addClass("error");
            ModalPassword3.addClass("error");
            
        }
        else
        {
            ModalPassword2.removeClass("error");
            ModalPassword3.removeClass("error");    
        }
	
    }
    
    
    
    function validatePassword2(){ 				// Es menor a 5 caracteres
        if(ModalPassword2.val().length < 5 && ModalPassword2.val().length > 0) {
		
            reqModalMessagePass.show();
            reqModalMessagePass.text("Coloca una contrase\u00f1a segura");
            ModalPassword2.addClass("error");
            return false;
        }
        
        else{       //Es mayor a 5 caracteres y menor a 16 caracteres

            reqModalMessagePass.hide();
            ModalPassword2.removeClass("error");
            return true;
        }
        
        if(ModalPassword3.val() != 0){
            if(ModalPassword3.val() != ModalPassword2.val()) {
            
                reqModalMessagePass2.show();
                reqModalMessagePass2.text("Las contrase\u00f1as no coinciden");
                ModalPassword3.addClass("error");
                return false;
            }
        
            else{       //Las contrase�as coinciden
            
                reqModalMessagePass2.hide();
                ModalPassword3.removeClass("error");
                return true;
            }
        }

        

	
    }
    
    
    function validatePassword3(){ 				// La contrase�as no coinciden
        
        
        if(ModalPassword3.val() != ModalPassword2.val()) {
            
            reqModalMessagePass2.show();
            reqModalMessagePass2.text("Las contrase\u00f1as no coinciden");
            ModalPassword3.addClass("error");
            return false;
        }
        
        else{       //Las contrase�as coinciden
            
            reqModalMessagePass2.hide();
            ModalPassword3.removeClass("error");
            return true;
        }	

	
    }    
    //END: Validar Nueva Contrase�a y Verifique Contrase�a


    //VALIDA QUE EL USUARIO LOGUEADO HAYA ASOCIADO SU CUENTA EN FACEBOOK ANTERIORMENTE
    function validateAsocFacebook(){
        
        /*PRIMERO SE OCULTA TODO (BOTON ASOCIAR Y EL BOTON INVITAR), Y APARECE EL LOADING*/
        $('#AsoPos').hide();
        $('#SuccessAsoc').hide();
        $('#loadingAssoc').show();
        UserFaceIdExist = 'NO';
        $.post("../web/existFaceId.php", {
            user: UserId.val()
        },
        function(UserFaceIdExist) {
            if(UserFaceIdExist == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta accion');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(UserFaceIdExist.toString().indexOf('NO') >= 0){
                    setTimeout(function() {
                        $('#loadingAssoc').hide();
                        $('#AsoPos').show(); 
                    }, 3000);
                }
                else{
                    setTimeout(function() {
                        $('#loadingAssoc').hide();
                        $('#SuccessAsoc').show();
                    }, 3000);
               
                } 
            }
        }
        )
    }
    //END VALIDA QUE EL USUARIO LOGUEADO HAYA ASOCIADO SU CUENTA EN FACEBOOK ANTERIORMENTE 



    //Events
    ModalName.blur(validateNameConf);
    ModalCity.blur(validateCityConf);
    ModalPassword1.blur(validatePassword1);
    ModalPassword2.blur(validatePassword2);
    ModalPassword3.blur(validatePassword3);
    $ConfigButtonMenu.click(validateAsocFacebook);
    inviteFace.click(sendRequestMultiFriendSelector);
    linkudpateFace.click(updateFaceId);

    // Guardar datos config
    ModalBtnSave.click(function()
    {
        $.post("../web/saveDataConfig.php", {
            vUserId:        UserId.val(), 
            vUsername:      Username.val(),
            vName:          ModalName.val(), 
            vCity:          ModalCity.val(),
            vPasswordOld:   ModalPassword1.val(),
            vPasswordNew:   ModalPassword2.val(),
            vPasswordReNew: ModalPassword3.val()
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta accion'); //alert de advertencia, ya que se deslogueo y sigue abierta otra pestaña
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            } 
            else
            {
                if(data == 'YES')
                {
                    AlertMessage="Datos Guardados correctamente";
                    TitleConfig="Exitoso!";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                else
                if(data == 'BADPASS') 
                {
                    AlertMessage="Por favor, verifica la clave";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                }
                else
                if(data == 'SHORTPASS') 
                {
                    AlertMessage="Por favor, introduce una clave mas larga";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                }
                else
                if(data == 'BADCITY') 
                {
                    AlertMessage="Por favor, introduce una ciudad mas corta, maximo 15 caracteres";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                }
                else
                if(data == 'BADNAME') 
                {
                    AlertMessage="Por favor, introduce un nombre mas corto, maximo 19 caracteres";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                }
                else
                {    
                    AlertMessage="Completa los campos faltantes o verifica tus datos";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                }
            }
        });
    });
    //End guardar datos config

    //END:Validate Modal Configuration Profile

    function sendRequestMultiFriendSelector() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                var uid = response.authResponse.userID;
                if(FaceId.val()== response.authResponse.userID)
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
                        if(FaceId.val() == response.authResponse.userID)
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
                }, {
                    scope: 'email,publish_stream,user_birthday'
                });
            }
        },{
            scope: 'email,publish_stream,user_birthday'
        });
    }
 
    function updateFaceId()
    {    
         FB.login(function(response) {
		  if(response.authResponse) {
		   FB.api('/me', function(me){
              if (me.id) {
                    $.post("../web/updateFace.php", {
                    user: UserId.val(),
                    faceId: me.id
                },
                function(responseUpdate) {
                    if(responseUpdate == 'NOSSID')
                    {
                        $.genericAlert('Inicia sesion para poder realizar esta accion');
                        $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                    }
                    else
                    {
                        if(responseUpdate.toString().indexOf('NO') >= 0){
                           
                            $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
                        }
                        else{
                            sendAsocFacebookNotifications();
                        } 
                    }
                }
                )
              }
                   });
                  }
         },// Aquí es donde especificamos los permisos que queremos obtener                 
               {scope: 'email,publish_stream,user_birthday'}); 
        
        /*FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                var uid = response.authResponse.userID;
                $.post("../web/updateFace.php", {
                    user: UserId.val(),
                    faceId: uid
                },
                function(responseUpdate) {
                    if(responseUpdate == 'NOSSID')
                    {
                        $.genericAlert('Inicia sesion para poder realizar esta accion');
                        $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                    }
                    else
                    {
                        if(responseUpdate.toString().indexOf('NO') >= 0){
                           
                            $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
                        }
                        else{
                            sendAsocFacebookNotifications();
                        } 
                    }
                }
                )
            }
            else
            {
                FB.login(function(response) {
                    if(response.authResponse) {
                        $.post("../web/updateFace.php", {
                            user: UserId.val(),
                            faceId: response.authResponse.userID
                        },
                        function(responseUpdate) {
                            if(responseUpdate == 'NOSSID')
                            {
                                $.genericAlert('Inicia sesion para poder realizar esta accion');
                                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                            }
                            else
                            {
                                if(responseUpdate.toString().indexOf('NO') >= 0){
                                    $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
                                }
                                else{ 
                                    sendAsocFacebookNotifications();
                                } 
                            }
                        }
                        )
                    }
                }, {
                    scope: 'email,publish_stream,user_birthday'
                });
            }
        },{
            scope: 'email,publish_stream,user_birthday'
        });  */
    }
    
     /****************************************************************************************/
    //      ENVIAR MENSAJE AL MURO DEL FACEBOOK DEL USUARIO CUANDO SE REGISTRA POR PRIMERA VEZ
    /****************************************************************************************/
    function sendAsocFacebookNotifications()
    {
         FB.api('/me/feed', 'post', { 
           message:  'Me acabo de registrar en Inspiter. Registrate tu tambien y comparte las frases mas inspiradoras',
           description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
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
                  $.afterRegiter("Asociaste tu cuenta a facebook, ahora también podrás compartir tus frases con tus amigos de facebook","Exitoso");
                }
                });
    }
 
});