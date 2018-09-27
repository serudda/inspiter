$(document).ready(function()
{
  //global variables
  var InputName = $("#inputName");
  var reqName = $("#reqName");
  var InputUserName = $("#inputUsername");
  var reqUserName = $("#reqUsername");
  var InputPassword = $("#inputPassword");
  var reqPassword = $("#reqPassword");
  var InputEmail = $("#inputEmail");
  var reqEmail = $("#reqEmail");
  var InputCity = $("#inputCity");
  var reqCity = $("#reqCity");
  var InputcheckCond = $("#check-cond2");
  var reqcheckCond = $("#req-check-cond2");
  var RegisBtn = $("#registerSubmit");


   /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   02/01/2013
    //Purpose:     - A�ade dos funciones para obtener los parametros de de una url por GET. 
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
 
//SignUp validate functions
function validateName()
{  
  if(InputName.val().length == 0)	
  {
      reqName.removeClass("success");
      reqName.addClass("error");
      reqName.html("<strong>Advertencia!</strong>Coloque su Nombre");
      InputName.addClass("error");
      return false;
   }
   else
   { 	
      reqName.removeClass("error");
      reqName.addClass("success");
      reqName.html("<strong>Excelente!</strong>Su Nombre se ve genial");
      InputName.removeClass("error");
      return true;
   }		
}


//VALIDATE PASSWORD
function validatePassword()
{ 
   if(InputPassword.val().length < 5) 
   {
      reqPassword.removeClass("success");
      InputPassword.addClass("error");
      reqPassword.html("<strong>Advertencia!</strong>Por favor coloque una contrase\u00f1a segura");
      reqPassword.addClass("error");
      return false;
    } 
    else
    { 											
	reqPassword.removeClass("error");
	reqPassword.addClass("success");
	reqPassword.html("<strong>Excelente!</strong>");
	InputPassword.removeClass("error");
	return true;
    }	

	
}


// VALIDATE USERNAME
function validateUserName()
{
  $("#loaderUserName").fadeIn(900,0);
  if (InputUserName.val().length == 0)
  {
    reqUserName.removeClass("success");
    reqUserName.addClass("error");
    reqUserName.html("<strong>Advertencia!</strong>Coloque un Nombre de Usuario");
    InputUserName.addClass("error");
    $("#loaderUserName").fadeOut('slow');
    return false;
   }
   else
    if(InputUserName.val().length < 4)
    {
	reqUserName.removeClass("success");
	reqUserName.addClass("error");
	reqUserName.html("<strong>Advertencia!</strong>Coloque un nombre de usuario mas largo");
	InputUserName.addClass("error");
        $("#loaderUserName").fadeOut('slow');
	return false;
    }
    else
    {
        var result = true;
        $.post("../web/InspValidator.php", {
            userName: InputUserName.val()
        },
        function(data)
        {
            if(data == 'YES')
            {
              reqUserName.html("<strong>Excelente!</strong>");
              reqUserName.removeClass("error");  
              InputUserName.removeClass("error");
	      reqUserName.addClass("success");  
              $("#loaderUserName").fadeOut('slow');
              result = true;
            }
            else
            {
               reqUserName.html("<strong>Advertencia!</strong>Nombre de Usuario no disponible");
	       reqUserName.addClass("error");  
               InputUserName.addClass("error");
	       reqUserName.removeClass("success");
               $("#loaderUserName").fadeOut('slow');
               result = false;
            }
        });
        return result;
    }
 }




//VALIDATE EMAIL

function validateEmail()
{     
   if(InputEmail.val().length == 0)
   {  
      if ($('#isActiveAccount').length) 
      {
         $("#sendMail").attr('disabled', true);
         $("#sendMail").addClass("disabled");
         reqEmail.removeClass("success");
         reqEmail.addClass("error");  
         reqEmail.html("<strong>Upp!!</strong>Necesitas ingresar un mail");
         InputEmail.addClass("error");
         return false; 
      }
      else
      {
       reqEmail.removeClass("success");
       reqEmail.addClass("error");  
       reqEmail.html("<strong>Upp!!</strong>Necesitas un email para registrarte");
       InputEmail.addClass("error");
       return false;  
      }
    } 
    else 
    if(!InputEmail.val().match(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i))
    {	
       if ($('#isActiveAccount').length) 
       {
         $("#sendMail").attr('disabled', true);
         $("#sendMail").addClass("disabled");
         reqEmail.removeClass("success");
         reqEmail.addClass("error");  
         reqEmail.html("<strong>Upp!!</strong>Asegurate que sea un email valido");  
         InputEmail.addClass("error"); 
         return false;  
       }
       else
       {
        reqEmail.removeClass("success");
        reqEmail.addClass("error");  
        reqEmail.html("<strong>Upp!!</strong>Asegurate que sea un email valido");  
        InputEmail.addClass("error"); 
        return false;  
       }
    }  
    else
    {
        var result = true;
        $.post("../web/InspValidator.php", {
            email: InputEmail.val()
        },
        function(data)
        {
          if(data == 'YES')
          {
             if ($('#isActiveAccount').length) 
             {
               $("#sendMail").attr('disabled', false);
               $("#sendMail").removeClass("disabled");
             }
             reqEmail.html("<strong>Excelente!</strong>");
             reqEmail.removeClass("error");  
             InputEmail.removeClass("error");
	     reqEmail.addClass("success"); 
	     result = true;
             
	   }
	   else
	   {
              if ($('#isActiveAccount').length) 
              {
                if(InputEmail.val() == $('#EmailOld').val())
                {
                  $("#sendMail").attr('disabled', false);
                  $("#sendMail").removeClass("disabled");
                  reqEmail.html("<strong>Excelente!</strong>");
                  reqEmail.removeClass("error");  
                  InputEmail.removeClass("error");
	          reqEmail.addClass("success"); 
                  result = true;
                }
                else
                {
                  $("#sendMail").attr('disabled', true); 
                  $("#sendMail").addClass("disabled");
                  reqEmail.html("<strong>Advertencia!</strong>Ya existe una cuenta asociada a este email");
	          reqEmail.addClass("error");  
                  InputEmail.addClass("error");
	          reqEmail.removeClass("success");
	          result = false;
                }
              }
              else
              {
      	       reqEmail.html("<strong>Advertencia!</strong>Ya existe una cuenta asociada a este email");
	       reqEmail.addClass("error");  
               InputEmail.addClass("error");
	       reqEmail.removeClass("success");
	       result = false;
              }
           } 
        });
        return result;
    }
}

//VALIDATE CITY

function validateCity()
{  
  if(InputCity.val().length == 0)	
  {
    reqCity.removeClass("success");
    reqCity.addClass("error");
    reqCity.html("<strong>Advertencia!</strong>Especifica tu ciudad");
    InputCity.addClass("error");
    return false;
  }
  else
  { 										//Si no esta vacio
    reqCity.removeClass("error");
    reqCity.addClass("success");
    reqCity.html("<strong>Excelente!</strong>");
    InputCity.removeClass("error");
    return true;
  }		
}

//END VALIDATE CITY
InputcheckCond.click(function()
{  
  if(InputcheckCond.is(':checked')) 
  {    
    RegisBtn.attr('disabled', false);
    RegisBtn.removeClass("disabled");
  }
  else
  {  
    RegisBtn.attr('disabled', true);
    RegisBtn.addClass("disabled");
  }  
 });

InputName.blur(validateName);
InputPassword.blur(validatePassword);
InputEmail.blur(validateEmail);
InputUserName.blur(validateUserName);
InputCity.blur(validateCity);


InputName.change(validateName);
InputCity.change(validateCity);

InputUserName.keyup(validateUserName);
InputName.keyup(validateName);
InputPassword.keyup(validatePassword);
InputEmail.keyup(validateEmail);
InputCity.keyup(validateCity);




$(".form-signup-inspiter").submit(function(){ 
    if(validateName()==true && validatePassword()==true && validateEmail()==true && validateUserName() == true && validateCity() == true){ 
		if(InputcheckCond.is(' :checked'))
                {
                  doSubmit();
		  return true;
		}
		
		else{
			reqcheckCond.text("Debe aceptar los terminos y condiciones de Inspiter");
			return false;
		}
	}
    else  
	{
      return false; 
	}
});


var flag = false;
if (!$('#isActiveAccount').length) 
{			
        // respond to clicks on the login and logout links
        document.getElementById('associate-btn-facebook').addEventListener('click', function(){
		 FB.login(function(response) {
		  if(response.authResponse) {
		   FB.api('/me', function(me){
              if (me.id) {
				 $("#loading").fadeIn(900,0);
                 $("#loading").html("<img src='../images/ajax-loader-register.gif' />");
				 $.ajax({
			                type: "POST",
			                url: "web/InspValidator.php",
			                data: "faceid="+me.id,
                                       	success: function(data)
                                        {
			                 if (data.indexOf('NO') < 0)
			                 {
                                           document.getElementById('fid').value = me.id;
				           document.getElementById('inputEmail').value = me.email;
                                   	   var query = FB.Data.query('select uid,name, pic_square, username from user where uid=me() or uid IN (select uid2 from friend where uid1=me())', me.id);
                                           query.wait(function(rows) {
			                   $("#loading").fadeOut('slow');
			                   document.getElementById('inputUsername').value = rows[0].username;
                                           document.getElementById('UsernameHidden').value = rows[0].username;
                                           document.getElementById('inputName').value = rows[0].name;
			     	           document.getElementById('fimage').value = 'http://graph.facebook.com/'+rows[0].username+'/picture?height=210&width=210';
			    	           validateEmail();  
                                           validateName();
                                           validateCity();
                                           setTimeout(function(){validateUserName()},1000);   
                                           });
                                         }
                                         else
                                         {
                                            $("#loading").fadeOut('slow');
				            var url = "../web/checkLogin.php?faceid="+me.id;
                                            $(location).attr('href',url);
                                         }
			                }
		                       });
		              }
			  });
			 }
                         
              },// Aquí es donde especificamos los permisos que queremos obtener                 
               {scope: 'email,publish_stream,user_birthday'}); 
			 /* else
			  {
				  FB.login();
				  scope: 'email'; 
				  flag = true;
			  }*/
		});
}
 

function fqlQuery(){
        FB.api('/me', function(response) {
        var query = FB.Data.query('select uid, name, pic_square, username from user where uid=me() or uid IN (select uid2 from friend where uid1=me())', response.id);
        query.wait(function(rows) {
                         /*'<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";*/
			     		 document.getElementById('fimage').value = rows[0].pic_square;
						 document.getElementById('inputUsername').value = rows[0].username;
                                                 document.getElementById('UsernameHidden').value = rows[0].username;
						 document.getElementById('inputName').value = rows[0].name;
						 //document.getElementById('inputCity').value = rows[0].current_location.country;
						 document.getElementById('fid').value = rows[0].uid;
                                                 
                     });
                });
                
            }
			

function validateFaceid(fid){
		var existe;
		$.ajax({
			type: "POST",
			url: "web/InspValidator.php",
			data: "faceid="+fid,
                        async: false,
			success: function(data)
                        {
			  if (data.indexOf('NO') > 0)
			   {existe = 'EXIST';}
			  else
			   {existe = 'NOEXIST';}
			}
		});
		return existe;
}

    //validar cuando viene por parametro algun error desde PHP
    var byName = $.getUrlVar('error');
    if(byName == 'ErrorDatos')
    {
       validateName();
       validatePassword();
       validateUserName();
       validateEmail();
       validateCity();
       
    }

$("#sendMail").click(function()
{  
   if(validateEmail()==true)
    { 
      doSubmit();
      return true;
    }
    else  
    {
      return false; 
    }
 });
    
$(".form-sendMail-inspiter").submit(function()
{ 
    if(validateEmail()==true)
    { 
      doSubmit();
      return true;
    }
    else  
    {
      return false; 
    }
});

});

