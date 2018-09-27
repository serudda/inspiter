$(document).ready(function(){

var contactName = $("#ContactName");
var contactEmail = $("#ContactEmail");
var contactAsunto = $("#ContactAsunto");
var contacTextArea = $("#ContacTextArea");
var contactOption = $("#ContactOption");
var reqNameCont = $("#reqNameCont");
var reqMailCont = $("#reqMailCont");
var reqSubjectCont =$("#reqSubjectCont");
var reqMessageCont = $("#reqMessageCont");


$("#ContSoporte").on({
        
        click: function(){
            contactOption.val('Soporte');
        }
});
$("#ContConsulta").on({
        
        click: function(){
            contactOption.val('Consulta');
        }
});
$("#ContSugerencia").on({
        
        click: function(){
            contactOption.val('Sugerencia');
        }
});
$("#ContEmpresa").on({
        
        click: function(){
            contactOption.val('Empresa');
        }
});
$("#ContDenuncia").on({
        
        click: function(){
            contactOption.val('Denuncia');
        }
});
$("#ContOtro").on({
        
        click: function(){
            contactOption.val('Otro');
        }
});


$(".form-signup-inspiter").submit(function(){ 
          if(validateMail() == false && validateBody() == false)
              return false;
          else{

					 return true;
				  }
              
});

function validateName()
{
    if(contactName.val().length == 0)
    {
        //alert('Name vacio');  
				reqNameCont.addClass("error");  
				reqNameCont.html("Por favor especifique un nombre.");
        contactName.addClass("error");   	
    }else{
		 contactName.removeClass("error");
		 reqNameCont.removeClass("error");
		}
}

function validateMail()
{ 
    if(contactEmail.val().length == 0)
    {  	
        //alert('mail vacio'); //sergio todo coloque un mail
  reqMailCont.addClass("error");  
	reqMailCont.html("Por favor especifique su email.");
  contactEmail.addClass("error");
     return false;  
    } 
    else if(!contactEmail.val().match(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i))
    {	
         //alert('mail malo'); //sergio todo coloque un mail valido
	       reqMailCont.addClass("error");  
	       reqMailCont.html("Por favor especifique un email correcto."); 
	 //reqEmail.html("<strong>Upp!!</strong></br>Aseg&uacute;rate que sea un email v&aacute;lido");  
         contactEmail.addClass("error"); 
       return false;  
    }  
    else
    {		
				reqMailCont.removeClass("error");  
				contactEmail.removeClass("error");
        return true;
    }
}

function validateAsunto()
{
    if(contactAsunto.val().length == 0)
    {
        //alert('Asunto vacio');
				reqSubjectCont.addClass("error");  
	      reqSubjectCont.html("Por favor es necesario un asunto.");
        contactAsunto.addClass("error");   	
    }else{
		 reqSubjectCont.removeClass("error");  
     contactAsunto.removeClass("error");
		}
}

function validateBody()
{
    if(contacTextArea.val().length == 0)
    {
        //alert('Name vacio'); 
				reqMessageCont.addClass("error");  
	      reqMessageCont.html("Por favor escribamos lo que nos desea trasmitir, nos pondremos en contacto con usted lo antes posible."); 
        contacTextArea.addClass("error");   	
    }else{
		 reqMessageCont.removeClass("error");      
     contacTextArea.removeClass("error");
		}
}

contactName.blur(validateName);
contactEmail.blur(validateMail);
contactAsunto.blur(validateAsunto);
contacTextArea.blur(validateBody);

});

