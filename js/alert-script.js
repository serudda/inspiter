$(document).ready(function(){
        
       //Global Variables
       var ContainerWriter = $("#phrase-container-writer");
        
    //Cuando se esta en el Modal de Configuracion de cuenta, y el user quiere subir un archivo
    //con una extension incorrecta
        
    $.errorExtension = function(){
		
        /*var elem = $(this).closest('.item');*/
		
        $.confirm({
            'title'     : 'Advertencia',
            'message'	: 'Solo se permiten Imagenes .jpg o .png.<br />Por favor intenta de nuevo con otro tipo de imagen',
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
		
    }
            
        
        
    //Cuando se esta en el Modal de Configuracion de cuenta, y el user quiere subir una imagen
    //con tamaño o dimensiones incorrectas
        
    $.genericAlert = function(respuesta){
		
        /*var elem = $(this).closest('.item');*/
		
        $.confirm({
            'title'     : 'Advertencia',
            'message'	: respuesta,
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
		
    }
    
		
		//Cuando se esta en el Modal de Configuracion de cuenta, y el user quiere subir una imagen
    //con tamaño o dimensiones incorrectas
        
    $.generiConfirm = function(respuesta){
		
        /*var elem = $(this).closest('.item');*/
		
        $.confirm({
            'title'		: 'Advertencia',
            'message'	: respuesta,
            'buttons'	: {
				
                'Denunciar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){
										 
										}	// Nothing to do in this case. You can as well omit the action property.
                },
								
								'No denunciar'	: {
                    'class'	: 'btn btn-cancel-option',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
		
    }
     
     //Cuando el usuario comparte la frase en facebok correctamente
    
        
    $.AfterShareFace = function(){
		
        /*var elem = $(this).closest('.item');*/
		
        $.confirm({
            'title'		: 'Compartir en Facebook',
            'message'	: 'Gracias por compartir tus frases con tus demas amigos en Facebook',
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
		
    }
     
     
     
        
        
    //Cuando los textarea esten vacios, sugiere al usuario ingresar algo
        
        
    $.TextareaEmpty = function(){
		
        $.confirm({
            'title'     : 'Advertencia',
            'message'	: 'Por favor, introduce alguna frase',
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
		
    }
        
        
        
    //Cuando el user creo la frase satisfactoriamente: BIG CONTAINER
        
    $.afterCreateBig = function(){
            
                
        var markup = '<div id="reqCreatedPhrase" class="reqCreatedPhrase">Tu frase fue creada!</div>';
		
        /*$(markup).appendTo('textarea-box-big').fadeIn();*/
                
                
                    
        $('.textarea-box-big').prepend(markup).fadeIn(3000);
              
                  
               
                
        setTimeout(function() {  
                    
                    
            $('#reqCreatedPhrase').fadeOut(1000); 
                  
        }, 1000);
            
    }
        
        
    //Cuando el user creo la frase satisfactoriamente: SMALL CONTAINER
        
    $.afterCreateSmall = function(){
            
                
        var markup = '<div id="reqCreatedPhraseSmall" class="reqCreatedPhraseSmall">Tu frase fue creada!</div>';
		
        /*$(markup).appendTo('textarea-box-big').fadeIn();*/
                
                
                    
        $('.textarea-quick-box').prepend(markup).fadeIn(3000);
              
                  
               
                
        setTimeout(function() {  
                    
                    
            $('#reqCreatedPhraseSmall').fadeOut(1000); 
                  
        }, 1000);
        
        setTimeout(function() {  
                    
                    
            ContainerWriter.animate({marginTop:'-157px'},500); 
                  
        }, 1300);
            
    }
        
        
      //Cuando el user creo la frase satisfactoriamente: BIG CONTAINER
        
    $.afterRegiter = function(respuesta, title){
        
        
	
        $.confirm({
            'title'		: title,
            'message'	: respuesta,
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
});
		
    }
        
        
     //Cuando se le da click al boton Guardar Datos en el Modal de Configuracion
        
    $.ConfigAlert = function(respuesta, title){
        
        
	
        $.confirm({
            'title'     : title,
            'message'	: respuesta,
            'buttons'	: {
				
                'Continuar'	: {
                    'class'	: 'btn btn-success',
                    'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                }
            }
});
		
    }
        
    /*****************************************************************************/    
    //											   RECUPERAR CONTRASE�A
		/*****************************************************************************/
		
		$.PasswordError = function(messageError){
		 
		 var markupPass = '<div class="message"><div class="message-inside"><span class="message-text">'+messageError+'</span></div></div>';
		 $('.wrapper-rec').prepend(markupPass).fadeIn(3000);
		}
		
		
      $.SuccessPhraseGraph = function(respuesta){
	
            /*var elem = $(this).closest('.item');*/
		
            $.confirm({
                'title':'Perfecto',
                'message':'Tu frase grafica se creó perfectamente. Si deseas descargar la imagen, para poderla editar en <strong>Instagram</strong>, puedes dar click en "Descargar"',
                'buttons':{
                   'Descargar':{
                                 'class':'btn btn-cancel-option alertOffSuc',
                                 'action':function(e)
                                 {
                                    $(location).attr('href','../web/downloadFile.php?imageFile='+$("#ImagePhraseURL").val());
                                    e.stopPropagation();
                                 }
                                },
                    'Continuar':{
                        'class':'btn btn-success alertOffSuc',
                        'action': function(){
                            $(location).attr('href','../main.php');
                        }
                    }
                }
           });
       }           		
		
});