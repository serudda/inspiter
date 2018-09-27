$(document).ready(function(){

var inputEmail = $("#inputEmail");

$(".form-signup-inspiter").submit(function(){ 
          if(validateMail() == false)
              return false;
          else
              return true;
});
      
function validateMail()
{ 
    if(inputEmail.val().length == 0)
    {  	

				$(".message").remove();
				$.PasswordError('No has introducido tu direcci\u00f3n de correo electronica. Por favor, no dejes el campo vacio.');
        inputEmail.addClass("error");
        return false;  
    } 
    else if(!inputEmail.val().match(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i))
    {	
				 $(".message").remove();
         $.PasswordError('Al parecer no es un email valido. Por favor, int\u00e9ntalo de nuevo.');   
         inputEmail.addClass("error"); 
       return false;  
    }  
    else
    {
        return true;
    }
}  
});

