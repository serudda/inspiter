$(document).ready(function(){

var oUserIdRC  = $("#userIdRC");
var oInputNewPass = $("#inputNewPass");
var oInputConPass = $("#inputConPass");
var reqPasswordCon = $("#reqPasswordCon");
var reqPasswordNew = $("#reqPasswordNew");

if (oUserIdRC.val() == 0)
{
    //alert('token invalido'); 
		$.genericAlert('No puede realizar esta acci&oacute;n.');
    //todo sergio, mensaje diciendo que el token
    //es invalido, es decir no esta en base y por lo tanto no 
    //pertenece a ningun usuario. ALERT y luego ahi mismo redireccionar a 
    //index.php
		setTimeout(function () {
        $(location).attr('href','/index.php');
    }, 1500)
		
}

$(".form-signup-inspiter").submit(function(){ 
          if(validatePassword() == false || validatePassword1() == false)
              return false;
          else
              return true;
});
      
 //Validar Nueva Contrase�a y Verifique Contrase�a
    
  function validatePassword(){ 
     
     if(oInputNewPass.val().length <= 0)
     {
          reqPasswordNew.removeClass("success");
					reqPasswordCon.removeClass("success");
					reqPasswordNew.html("<strong>Advertencia!</strong>Es necesario escribir la contrase\u00f1as");
					reqPasswordNew.addClass("error");
          //alert("pasword vacio"); //todo sergio HTML como en validate-register.js
          return false;
     }
      // Es menor a 5 caracteres
    else if(oInputNewPass.val().length < 5 && oInputNewPass.val().length > 0) {
		
            reqPasswordNew.removeClass("success");
					  reqPasswordNew.html("<strong>Advertencia!</strong>Por favor coloque una contrase\u00f1a segura");
					  reqPasswordNew.addClass("error");
            //alert("pasword incorrecto"); //todo sergio HTML como en validate-register.js
            return false;
        }
        
        else{       //Es mayor a 5 caracteres y menor a 16 caracteres


        
        if(oInputConPass.val().length != 0){
            if(oInputConPass.val() != oInputNewPass.val()) {
            
                reqPasswordNew.removeClass("success");
								//reqPasswordNew.html("<strong>Advertencia!</strong></br>Las contrase\u00f1as no coinciden");
								//reqPasswordNew.addClass("error");
                //alert("las contraseñas no coinciden"); //todo sergio HTML como en validate-register.js
                return false;
            }
        
            else{       //Las contrase�as coinciden
            
								 reqPasswordNew.removeClass("error");
						     //reqPasswordNew.html("<strong>Excelente!</strong></br>Las contrase\u00f1as coinciden");
						     //reqPasswordNew.addClass("success");
                 //alert("las contraseñas coinciden"); //todo sergio HTML como en validate-register.js
                return true;
            }
        }
        else
        {
						 reqPasswordNew.removeClass("error");
						 reqPasswordNew.html("<strong>Excelente!</strong>");
						 reqPasswordNew.addClass("success");
            //alert("password correcto");
            return true;
        }  
    }
    
  }
    function validatePassword1(){ 				// La contrase�as no coinciden
        
        
        if(oInputConPass.val() != oInputNewPass.val()) {
				 
						reqPasswordCon.removeClass("success");
						reqPasswordCon.html("<strong>Advertencia!</strong>Las contrase\u00f1as no coinciden");
						reqPasswordCon.addClass("error");
            //alert("las contraseñas no coinciden"); //todo sergio HTML como en validate-register.js
            return false;
        }
        
        else if(oInputNewPass.val().length <= 0)
     {

					reqPasswordCon.removeClass("success");
          //alert("pasword vacio"); //todo sergio HTML como en validate-register.js
          return false;
     }
		 else
		 {       //Las contrase�as coinciden
            
            reqPasswordCon.removeClass("error");
						reqPasswordCon.html("<strong>Excelente!</strong>Las contrase\u00f1as coinciden");
						reqPasswordCon.addClass("success");
            //alert("las contraseñas coinciden"); //todo sergio HTML como en validate-register.js
            return true;
        }	

	
    }
        
    //END: Validar Nueva Contrase�a y Verifique Contrase�a
    
    //eventos
    oInputNewPass.blur(validatePassword);
    oInputConPass.blur(validatePassword1);
});

