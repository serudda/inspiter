$(document).ready(function()
{ 
    //global variables

    var ConfigName =            $("#inputNameConf");
    var ConfigLocation =        $("#inputLocationConf");
    var ConfigWebSite =         $("#inputWebConf");
    var ConfigAboutYou =        $("#inputAboutYou");
    var ConfigIdenPhrase =      $("#inputIdenPhrase");
    var ConfigIdenAuthor =      $("#inputIdenAuthor");
    var ConfigImagePredef  =    $("#imagePredef");
    var ConfigPassword1 =       $("#inputPassword1Conf");
    var ConfigPassword2 =       $("#inputPassword2Conf");
    var ConfigPassword3 =       $("#inputPassword3Conf");
    var $NameConf      =        $(".NameConf");
    var $CityConf       =       $(".CityConf");
    var $SiteConf	 =	$(".SiteConf");
    var $AboutConf     =	$(".AboutConf");
    var reqConfigMessagePass =  $(".message-box-pass");
    var reqConfigMessagePass2 = $(".message-box-pass2");
    var ConfigBtnSave =         $("#btn_save_config");
    var ConfigBtnCancel =       $("#btn_cancel_config");
    var ConfigBtnSavePass =     $("#btn_save_pass");
    var UserId      =           $("#userIdLogged");
    var FaceId      =           $("#faceidHidden");
    var Username    =           $("#usernameHidden");
    var AlertMessage =          "";
    var TitleConfig =           "";
    var doc	=		$(document);

    if(FaceId.val() != 0 && FaceId.val() != '')
    {
        $("#asso-btn-facebook-config").text("Desligar tu cuenta de Facebook").addClass("desligarFacebook");
    }
    else
    {
        $("#asso-btn-facebook-config").text("Asociar con Facebook").removeClass("desligarFacebook");
    }
    
    $.ajax({
            url: "../web/getStyles.php", 
            data: {
                     "userId": UserId.val()
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
                                $("#textPhraseIn").css({
                                       'top':data[0].phraseTop,
                                       'left':data[0].phraseLeft,
                                       'font-family':data[0].fontFamily,
                                       'font-size':data[0].fontSize,
                                       'font-weight':data[0].fontWeight,
                                       'font-style' :data[0].fontStyle
                                });

                                $("#textPhraseInAuthor").css({
                                       'top':data[0].authorTop,
                                       'left':data[0].authorLeft
                                });

                                $("#ImagePhraseIn").css({
                                       'top':data[0].imageTop
                                });

                                //MUESTRO LA FRASE/AUTOR DEL USUARIO EN LA IMAGEN
                                var valueTextAreaPhrase = $("#inputIdenPhrase").val();
                                var valueTextAreaAuthor = $("#inputIdenAuthor").val();
                                $("#textPhraseIn").text(valueTextAreaPhrase);
                                $("#textPhraseInAuthor").text(valueTextAreaAuthor);
                          }
                          else
                          {
                             
                          }
                        }
                    },
                    error: function()
                    {
                    }
            });
   ConfigImagePredef.val("");         
 
function ValidaURL(url) 
{
  var regex=/^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i;
  return regex.test(url);
}

    //Validate Config Configuration Profile
    
    //Validate Full Name
    function validateNameConf()
    {  
        if(ConfigName.val().length == 0)
	{		// Es vacio
            $NameConf.html("<strong>Advertencia!</strong> Es necesario que especifiques un nombre.").removeClass("errorHidden");
            ConfigName.addClass("error");
            estadoBox = "true";
            return false;
        }
        else
        {
            $NameConf.addClass("errorHidden");
            ConfigName.removeClass("error");
            estadoBox = "false";
            return true;           
        }
    }
    
    //Validate City
    function validateLocationConf()
    {  
      if(ConfigLocation.val().length == 0) // Es vacio
      {	 
         
         $CityConf.html("<strong>Advertencia!</strong></br>Es necesario que especifiques en donde te encuentras.").removeClass("errorHidden");
         ConfigLocation.addClass("error");
         estadoBox = "true";
         return false;
      }
      else
        if(ConfigLocation.val().length > 25) // Es vacio 
        {	 
           $CityConf.html("<strong>Advertencia!</strong></br>Maximo 25 caracteres.").removeClass("errorHidden");
           ConfigLocation.addClass("error");
           estadoBox = "true";
           return false;
        }
        else
        {
           $CityConf.addClass("errorHidden");
           ConfigLocation.removeClass("error");
           estadoBox = "false";
           return true;
         }
     }
     
     //Validate Website
    function validateWebSite() 
    {  
      var resultUrl;
      if(ConfigWebSite.val().length > 0) 
      {
          resultUrl = addProtocolHTTP(ConfigWebSite.val());
      } 
      else
      {
	$SiteConf.addClass("errorHidden");
	ConfigWebSite.removeClass("error");
        return true;
      }
      //valida si realmente es una url
      if(ValidaURL(resultUrl))
      {	 
	$SiteConf.addClass("errorHidden");
	ConfigWebSite.removeClass("error");
        return true;
      }
      else
      {
	$SiteConf.html("<strong>Advertencia!</strong> No es un website valido, verifica bien la url.").removeClass("errorHidden");
        ConfigWebSite.addClass("error");
        return false;
      }
    }
     
     function addProtocolHTTP(url)
     {
         var protocol = "http://";
         var protocolHttps = 'https://';
         var n =url.indexOf(protocol);
         var m = url.indexOf(protocolHttps);
         var resultUrl;
         if(n < 0 && m < 0)
         { 
             resultUrl = protocol+url;
         }
         else
         {
             resultUrl = url;
         }
         return resultUrl;
             
     }
		 
    //Valida la cantidad de caracteres de Acerca de ti...
    function validateAboutConf()
    {
        var estadoBox ="true";
       if(ConfigAboutYou.val().length > 264) 
       {	 
           $AboutConf.html("<strong>Advertencia!</strong></br>Maximo 264 caracteres.").removeClass("errorHidden");
           ConfigAboutYou.addClass("error");
           estadoBox = "true";
           return false;
       }
       else
       {
           $AboutConf.addClass("errorHidden");
           ConfigLocation.removeClass("error");
           estadoBox = "false";
           return true;
       }
    }
		 
    //Validar Nueva Contrase?a y Verifique Contrase?a
    function validatePassword1()
    { 				
        if(ConfigPassword2.val().length == 0 && ConfigPassword3.val().length == 0 && ConfigPassword1.val().length != 0)
        {
            ConfigPassword2.addClass("error");
            ConfigPassword3.addClass("error");
        }
        else
        {
            ConfigPassword2.removeClass("error");
            ConfigPassword3.removeClass("error");    
        }
    }   
    
    function validatePassword2()
    { 	
        if(ConfigPassword2.val().length < 5 && ConfigPassword2.val().length > 0) 
        {
	        reqConfigMessagePass.show();
            reqConfigMessagePass.text("Coloca una contrase\u00f1a segura");
            ConfigPassword2.addClass("error");
            return false;
        }
        else
        {
            reqConfigMessagePass.hide();
            ConfigPassword2.removeClass("error");
            return true;
        }
        
        if(ConfigPassword3.val() != 0)
        {
            if(ConfigPassword3.val() != ConfigPassword2.val())
            {
                reqConfigMessagePass2.show();
                reqConfigMessagePass2.text("Las contrase\u00f1as no coinciden");
                ConfigPassword3.addClass("error");
                return false;
            }
            else
            {       //Las contrase?as coinciden
            
                reqConfigMessagePass2.hide();
                ConfigPassword3.removeClass("error");
                return true;
            }
        }
    }    
    
    function validatePassword3()
    { 				
        if(ConfigPassword3.val() != ConfigPassword2.val()) 
        {
            reqConfigMessagePass2.show();
            reqConfigMessagePass2.text("Las contrase\u00f1as no coinciden");
            ConfigPassword3.addClass("error");
            return false;
        }
        else
        {       //Las contrase?as coinciden
            reqConfigMessagePass2.hide();
            ConfigPassword3.removeClass("error");
            return true;
        }	
    }   
    //END: Validar Nueva Contrase?a y Verifique Contrase?a
     
    //Events
    ConfigName.blur(validateNameConf);
    ConfigLocation.blur(validateLocationConf);
    ConfigWebSite.blur(validateWebSite);
    ConfigAboutYou.blur(validateAboutConf);
    ConfigPassword1.blur(validatePassword1);
    ConfigPassword2.blur(validatePassword2);
    ConfigPassword3.blur(validatePassword3);
    
    $("#asso-btn-facebook-config").on
    ({
       click: function()
       {
           updateFaceId(0);
           return false;
       }
     });
     
     $("#addImageFace").on
    ({
       click: function()
       {
           addFacebookImage();
           return false;
       }
     });
     
    ConfigBtnCancel.on
    ({
       click: function()
       {
          $.post("../web/eliminaImagenesTemp.php", 
          {
            username: Username.val()
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
              if(data.toString().indexOf('NO') >= 0)
              {
                
              }
              else
              { 
                 $(location).attr('href','/'+Username.val());
              } 
             }
           }); 
           return false;
       }
     });
     
    ConfigBtnSavePass.on
    ({
       click: function()
       {
           savePassword();
           return false;
       }
     });

    // Guardar datos config
    ConfigBtnSave.click(function()
    {   
       if(validateNameConf()== true && validateLocationConf() == true &&  validateWebSite() == true &&
           validateAboutConf() == true)
       {
         var resultUrl
         if(ConfigWebSite.val() != '')
         { resultUrl = addProtocolHTTP(ConfigWebSite.val()); }
         else
          {resultUrl = ConfigWebSite.val(); }
          $.post("../web/saveDataConfig.php", {
             vUserId:        UserId.val(), 
             vName:          ConfigName.val(),
             vUsername:      Username.val(),
             vCity:          ConfigLocation.val(),
             vAboutYou:      ConfigAboutYou.val(),
             vIdentPhrase:   ConfigIdenPhrase.val(), 
             vWebSite:       resultUrl,
             vAuhor:         ConfigIdenAuthor.val(),
             vStyle: {
							"fontFamily":$("#textPhraseIn").css('font-family'),
							"fontSize":$("#textPhraseIn").css('font-size'),
							"fontWeight":$("#textPhraseIn").css('font-weight'),
							"fontStyle":$("#textPhraseIn").css('font-style'),
							"imageTop":$("#ImagePhraseIn").css('top'),
							"phraseTop":$("#textPhraseIn").css('top'),
							"phraseLeft":$("#textPhraseIn").css('left'),
							"authorTop":$("#textPhraseInAuthor").css('top'),
							"authorLeft":$("#textPhraseInAuthor").css('left')
						 },
            vImagePredef: ConfigImagePredef.val()
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
                         $(location).attr('href','/'+Username.val());
                    }, 1000);
                }
                else
                  if(data == 'BAD_LOCATION') 
                  {
                    AlertMessage="Por favor, introduce una ubicacion mas corta, maximo 25 caracteres";
                    TitleConfig="Advertencia";
                    $.ConfigAlert(AlertMessage,TitleConfig);
                  }
                else
                  if(data == 'BAD_FULL_NAME') 
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
       }
       else
       {
           AlertMessage="Por favor, Verifica los campos ingresados";
           TitleConfig="Advertencia";
           $.ConfigAlert(AlertMessage,TitleConfig);       
       }
    });
//End guardar datos confiG
//END:Validate Config Configuration Profile

 function updateFaceId(pPhoto)
 { 
    if (pPhoto == 0)
    {
     if($("#asso-btn-facebook-config").text() == "Asociar con Facebook")
     {
       FB.login(function(response)
       {
	 if(response.authResponse)
         {
	    FB.api('/me', function(me)
            {
              if (me.id) 
              {
                   $.post("../web/updateFace.php", 
                    {
                       user: UserId.val(),
                       faceId: me.id,
                       usernameFace: me.username
                    },
                    function(responseUpdate) 
                    {
                      if(responseUpdate == 'NOSSID')
                      {
                         $.genericAlert('Inicia sesion para poder realizar esta accion');
                         $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                      }
                      else
                      {
                        if(responseUpdate.toString().indexOf('NO') >= 0)
                        {
                           $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
                        }
                        else
                        {
                            FaceId.val(me.id);
                            sendAsocFacebookNotifications();
                            $("#asso-btn-facebook-config").text("Desligar tu cuenta de Facebook").addClass("desligarFacebook");
                        } 
                    }
                  }); 
                 }
              });
            }
         },// Aquí es donde especificamos los permisos que queremos obtener                 
        {scope: 'email,publish_stream,user_birthday'}); 
    }
    else
    {
        $.post("../web/updateFace.php", 
        {
            user: UserId.val(),
            faceId: 0,
            usernameFace: 0
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
              if(data.toString().indexOf('NO') >= 0)
              {
                 $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
              }
              else
              {
                  FaceId.val(0);
                  $.afterRegiter("Desligaste exitosamente tu cuenta de Facebook, no podrás compartir inspiraciones en Facebook. ","Exitoso");
                  $("#asso-btn-facebook-config").text("Asociar con Facebook").removeClass("desligarFacebook");
              } 
             }
          }); 
     }
    }
    else
    {
     if($("#asso-btn-facebook-config").text() == "Asociar con Facebook")
     {
       FB.login(function(response)
       {
	 if(response.authResponse)
         {
	    FB.api('/me', function(me)
            {
              if (me.id) 
              {
                   $.post("../web/updateFace.php", 
                   {
                      user: UserId.val(),
                      faceId: me.id,
                      usernameFace: me.username
                   },
                function(responseUpdate) 
                {
                    if(responseUpdate == 'NOSSID')
                    {
                        $.genericAlert('Inicia sesion para poder realizar esta accion');
                        $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                    }
                    else
                    {
                        if(responseUpdate.toString().indexOf('NO') >= 0)
                        {
                           $.genericAlert('Esta cuenta de facebook ya esta asociada a otro usuario en Inspiter');
                        }
                        else
                        {
                            FaceId.val(me.id);
                            var urlFaceImage = 'http://graph.facebook.com/'+FaceId.val()+'/picture?height=210&width=210';
                            var urlFaceImageSmall = 'http://graph.facebook.com/'+FaceId.val()+'/picture?height=50&width=50';
	                    $.post("../web/uploadFile.php", 
                            {
                              pUserId: UserId.val(),
                              urlFaceImage: urlFaceImage
                            },
                            function(data) 
                            {
                                $('#fotografia').attr('src','../images/perfiles/data/'+data);
	                    });
                            sendAsocFacebookNotifications();
                            $("#asso-btn-facebook-config").text("Desligar tu cuenta de Facebook").addClass("desligarFacebook");
                        } 
                    }
                  }); 
                }
               });
            }
         },// Aquí es donde especificamos los permisos que queremos obtener                 
        {scope: 'email,publish_stream,user_birthday'}); 
    }
    else
    {
       var urlFaceImage = 'http://graph.facebook.com/'+FaceId.val()+'/picture?height=210&width=210';
       var urlFaceImageSmall = 'http://graph.facebook.com/'+FaceId.val()+'/picture?height=50&width=50';
       $.post("../web/uploadFile.php", 
       {
           pUserId: UserId.val(),
           urlFaceImage: urlFaceImage
       },
       function(data) 
       {
          $('#fotografia').attr('src','../images/perfiles/data/'+data);
       });
     }
   }
 }
 
    /****************************************************************************************/
    //      ENVIAR MENSAJE AL MURO DEL FACEBOOK DEL USUARIO CUANDO SE REGISTRA POR PRIMERA VEZ
    /****************************************************************************************/
    function sendAsocFacebookNotifications()
    {
         FB.api('/me/feed', 'post', { 
           message:  'Acabo de asociar mi cuenta de Inspiter a Facebook. Si aun no lo hiciste hazlo y comparte con tus amigos las frases mas inspiradoras',
           description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
           picture:'http://www.inspiter.com/images/logo/inspiter-logo-face2.jpg',
           name:  'Inspiter.com',
           link:'www.inspiter.com',
           actions: [
           {
              name: 'Inspiter', 
              link: 'http://www.inspiter.com'
           }
                    ]
           }, 
           function(response) 
           {  
              if (response)
              {
                 $.afterRegiter("Asociaste tu cuenta a facebook, ahora también podrás compartir tus frases con tus amigos de facebook","Exitoso");
              }
            });
     }
     
    function addFacebookImage()
    {
        updateFaceId(1);
    }
    
    function savePassword()
    {
        $.post("../web/saveNewPassword.php", 
        {
            pUserId: UserId.val(),
            vPasswordOld: ConfigPassword1.val(),
            vPasswordNew: ConfigPassword2.val(),
            vPasswordReNew: ConfigPassword3.val()
            
         },
         function(data) 
         {
            if(data == 'NOSSID')
            {
                
            }
            else if(data == 'YES')
            {
               $.afterRegiter("La contraseña fue guardada correctamente","Exitoso"); 
               ConfigPassword1.val("");
               ConfigPassword2.val("");
               ConfigPassword3.val("");
            }
            else if(data == 'YESNO')
            {
              
            }
            else
            {
                $.afterRegiter("Verifique las contraseñas","Advertencia"); 
            }
         });
    }

});