$(document).ready(function(){
 

var $ToUser = $("#ToName");
var $myListDed = $('#display-result-Ded');
var paramSearch = $('#ToName').val();
var CajaBusquedaDed = 'all';
var docded = $(document);
var ListSavedUsersDed;
var ListaUserSearchDed = [];
var IsNotUserDed;
var ToUserId = $("#ToUserId");
var ToUserFullName = $("#ToUserFullName");


/*EVENTOS*/
/*-----------------------------------------------------------------------------*/

/*CUANDO EL USER DIGITE ALGO*/
/*-----------------------------------------*/

$ToUser.keyup(function(e) 

{
    
			var CajaBusquedaDed = $(this).val();
			$("#search-admire-Ded").attr("action",'/search.php?resultsfor='+CajaBusquedaDed);
			
			if(IsNotUserDed != ''){
			//var cacheDed = docded.data(CajaBusquedaDed); 
			}
			
			
		var dataStringDed = CajaBusquedaDed; 
	 
   
                  
        var keycodeDed = (e.keyCode ? e.keyCode : e.which); /* para saber que tecla presiono*/
        CajaBusquedaDed = $(this).val();
				var vSessionId = $("#sessionId");	

				
        switch(keycodeDed)
        {
            case 40: //abajo

                keyEventDed ('next');
           
                break;
            
           
            case 38://arriba
       
                keyEventDed('prev');
       
                break;
        
            case 13:
								
                $ToUser.val('Nombre Completo'); 
                $myListDed.hide();
                break;
            
            default:
								
								ToUserId.val('');
								
                if(CajaBusquedaDed=='')
                {
									  $(".users-Ded").detach();
                    $myListDed.hide();
                }
                else
                {
			

			
			/*if( cacheDed ) {
			 
			 
			$(".users-Ded").detach();

			ListSavedUsersDed = docded.data(CajaBusquedaDed).ListUsersDed;
			
			if(ListSavedUsersDed != ''){
			 $("#result-section-users-Ded").show();
			 $("#result-users-Ded").append(ListSavedUsersDed.join(''));
			}else{
			 $("#result-section-users-Ded").hide();
			}			
			
			$myListDed.show();
     
    }else{

				 docded.data(CajaBusquedaDed,{ListUsersDed: ''});					
		 /*BUSCAR LAS PERSONAS*/
    $.ajax({
			type: "POST",
			url: "../web/mostrarPhrasesSearch.php",
												
			data: {
			 "sessionId": vSessionId.val(),
			 "type": 'personas',
			 "section": 'visual',
			 "searchWord": dataStringDed
			},
			//beforeSend: function(){ $b.data('locked',true); },									
                        dataType: "json",
			success: function(arrayDataUserDed)
                        {
			 
			 if(arrayDataUserDed == 'NOSSID')
                           {
                             $.genericAlert('Inicia sesion para poder realizar esta accion');
                             $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                            }
                           else
                            {
				 if(arrayDataUserDed != 0)
			 {
				
				//tipo = 'personas';
				ListaUserSearchDed = [];
				$("#result-section-users-Ded").show();
				
				$.each(arrayDataUserDed,function(index,value) {

			
							ListaUserSearchDed.push('<li id="display_box_users_Ded" class="display_box_Ded users-Ded" data-pos="" align="left"> <a id="userResult_'+arrayDataUserDed[index].US_User_Id+'" class="link-user-search-Ded" href="#"><img src='+arrayDataUserDed[index].US_Photo_Small+'><span class="NameResultSearchDed">'+arrayDataUserDed[index].US_Full_Name+'</span><span class="UserResultSearchDed">'+arrayDataUserDed[index].US_User_Login+'</span><span class="CityResultSearchDed">'+arrayDataUserDed[index].US_City+'</span></a></li>');

						 });
						 
						 /*docded.data(CajaBusquedaDed).ListUsersDed = ListaUserSearchDed;
						 IsNotUserDed = docded.data(CajaBusquedaDed).ListUsersDed;*/
			
						 
						 $(".users-Ded").detach();
						 $("#result-users-Ded").append(ListaUserSearchDed.join(''));
						 
						 
						 $("#result-users-Ded li").each(function (index) {
								 addEvenToNewElementSearched(arrayDataUserDed[index].US_User_Id);
						 });
        }
			 else
			 {
				//No haga nada, solo oculte su titulo
				$(".users-Ded").detach();
				$("#result-section-users-Ded").hide();
       }
			}
			}//,
			
      });
            
		 //doc.data(CajaBusqueda,{ListUsers: ListaUserSearch,ListPhrases: ListaPhraseSearch,ListAuthors: ListaAuthorSearch});
		 //var asign = docded.data(CajaBusquedaDed);
			
		$myListDed.show();
			//}
		}
		break; 
	}  
	return false;    
 });







/*CUANDO EL USER DEJA EL FOCO DEL BUSCADOR*/
/*-----------------------------------------*/
    
$ToUser.blur(function(){
    
    setTimeout(function () {
        $myListDed.hide()
    }, 150)     
    
});
    

    
    
/*CUANDO EL USER VUELVE A FOCO DEL BUSCADOR*/
/*-----------------------------------------*/
    
$ToUser.focus(function(){
        
    if ($ToUser.val().length != 0) {
        $myListDed.show();
    }else{
      //$("#IdUserPage").attr("value","profile.php");  
    }
        
});
   
    
    
/*-----------------------------------------------------------------------------*/
    
    
    
    
/*FUNCIONES*/
/*-----------------------------------------------------------------------------*/
    
 
 function addEvenToNewElementSearched(pUserId)
    {	
        /*******************************************************************************************************************************/
        //       AGREGAR EL EVENTO CUANDO LE DOY CLICK A USUARIO ENCONTRADO, PARA CARGAR EL TEXTFIELD CON SU NOMBRE Y SU ID OCULTA
        /*******************************************************************************************************************************/  
        $('#userResult_'+pUserId).on({
				
            click: function(){
             var nombreCompleto = $('#userResult_'+pUserId+' .NameResultSearchDed').text();
						$ToUser.val(nombreCompleto);
						ToUserId.val(pUserId);
						
            }
        });
		}
 
 
    
      
/*CUANDO EL USER PRESIONA ARRIBA O ABAJO PARA NAVEGAR LA LISTA*/
/*-------------------------------------------------------*/ 

function keyEventDed (action)
{
    var yxded = 0;
	var yxtitleded = 0;
	var yxuded = 0;
    var ulded;
		var ulPrevded;
		var ulPrevLiLastded;
		var LiActiveded;
    
    
    $myListDed.find("li").each(function(){ //buscar los li marcados

        if($(this).attr("data-pos") == "active"){
     
            yxded = 1;
        }
    });
		
		$myListDed.find("div").each(function(){  //buscar los div marcados
     
        if($(this).attr("data-pos") == "active"){

            yxtitleded = 1;
        }
    });
	
	$myListDed.find("ul").each(function(){  //buscar los ul marcados
     
        if($(this).attr("data-pos") == "active"){
					  ulded = $myListDed.find("ul[data-pos='active']");
            yxuded = 1;
        }
    });


if( yxuded == 1 )//Encontro un ul marcado
    {
        
	if( yxtitleded == 1 )// Se esta posicionado en el div de este ul?
	{
	var selDivded = ulded.find("div[data-pos='active']");
        
        if(action=='next'){
				 selDivded.next().addClass("active").attr("data-pos","active");
				 
				}else{
			ulPrevded = ulded.prev();
			ulPrevLiLastded = ulPrevded.find("li:last");
			ulPrevded.attr("data-pos","active");
			ulPrevLiLastded.addClass("active").attr("data-pos","active");
			ulded.attr("data-pos","");
			
    }
        selDivded.attr("data-pos","");
				sendLiDataDed();
	}
	else if( yxded == 1 )//Se esta posicionado en un li de este ul?
	{
		var selLided = ulded.find("li[data-pos='active']");
		
		if(action=='next')
		{
			ulded.find("li:last").each(function()
			{  /*Tengo que preguntar si estoy en el ultimo li, entonces le asigno el marcador al ul siguiente*/
				if($(this).attr("data-pos") == "active")
				{
					ulded.attr("data-pos","").next().attr("data-pos","active");
				}
			});
			selLided.next().addClass("active").attr("data-pos","active");  /*Tener cuidado con esto testear bien*/
			
		}
    else
		{
			selLided.prev().addClass("active").attr("data-pos","active");
        
		} 
		
        selLided.removeClass("active").attr("data-pos","");
				sendLiDataDed();
	}
	else  //No esta posicionado en ningun elemento del ul.
	{
	
		if(action=='next')
		{
			ulded.find("div").attr("data-pos","active");
		}
		else // La accion es prev, entonces al ul anterior a este lo guardo en una variable, y a su ultimo li le asigno el marcador
		{
			ulPrevded = ulded.prev();
			ulPrevLiLastded = ulPrevded.find("li:last");
			ulPrevded.attr("data-pos","active");
			ulPrevLiLastded.addClass("active").attr("data-pos","active");
			ulded.attr("data-pos","");
		}
        
	}

}
else  //No hay ningun ul marcado quiere decir que no he recorrido la lista
{
	
	$myListDed.find('div:first').attr('data-pos','active');
	$myListDed.find('ul:first').attr('data-pos','active');
}

//Para setear en el attribute action del form la url de: search.php ya que no hay ningun li activo
$myListDed.find("li").each(function(){ //buscar los li marcados
        if($(this).attr("data-pos") == "active"){
         LiActiveded = 'si';
			 }
    });
	
		if(LiActiveded == 'si'){
		 	$("#search-admire-Ded").attr("action","web/checkBuscarUser.php");
		}else{
		 var URLDataded = $ToUser.val(); 
		 	$("#search-admire-Ded").attr("action",'/search.php?resultsfor='+URLDataded);
		}

}





//Para enviar los datos de los autores, frases y user a las etiquetas input, para cuando le de enter, me lleve a su url correspondiente

function sendLiDataDed(){
 
  var UserNameFieldDed;
	var PhraseFieldDed;
 
 $myListDed.find("li").each(function(){ //buscar los li marcados
     
        if(($(this).attr("data-pos") == "active")&&($(this).attr("id")=="display_box_users_Ded")){ //Si estoy parado en algun resultado de user
					PhraseFieldDed="";
					$("#PhraseFieldDed").attr("value",PhraseFieldDed);
					UserNameFieldDed = $("li[data-pos='active'] .link-user-search-Ded").attr("href");
        $("#IdUserPageDed").attr("value",UserNameFieldDed);
				
		
        }
				
				    if(($(this).attr("data-pos") == "active")&&($(this).attr("id")=="display_box_phrase_Ded")){ //Si estoy parado en algun resultado de phrases
					UserNameFieldDed = "";
        $("#IdUserPageDed").attr("value",UserNameFieldDed);
					PhraseFieldDed = $("li[data-pos='active'] .link-user-search-Ded").attr("href");
					$("#PhraseFieldDed").attr("value",PhraseFieldDed);

		
    }
				
    });
		
 
}


});