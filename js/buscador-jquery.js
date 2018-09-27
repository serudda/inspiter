$(document).ready(function(){
 

var $buscador = $("#b_keywords");
var $myList = $('#display-result');
//var search_admire = $("#search-admire");
//var paramSearch = $('#b_keywords').val();
var mouse_is_inside_bus = false;
//var CajaBusqueda = 'all';
var doc = $(document);
var ListSavedUsers;
var ListSavedPhrases;
//var ListSavedAuthors;
var ListaUserSearch = [];
var ListaPhraseSearch = [];
//var ListaAuthorSearch = [];
var IsNotUser;
var IsNotPhrase;
//var IsNotAuthor;

/*EVENTOS*/
/*-----------------------------------------------------------------------------*/

/*CUANDO EL USER DIGITE ALGO*/
/*-----------------------------------------*/

$buscador.keyup(function(e) 

{
	var CajaBusqueda = $(this).val();
	//$("#search-admire").attr("action",'/search.php?resultsfor='+CajaBusqueda);
	
	if(IsNotUser != '' && IsNotPhrase != ''){
        	var cache = doc.data(CajaBusqueda); 
	}
			
        var dataString = CajaBusqueda; 
	          
        var keycode = (e.keyCode ? e.keyCode : e.which); /* para saber que tecla presiono*/
        CajaBusqueda = $(this).val();
        //var URLVerMas = '/search.php?resultsfor='+$(this).val();
	var vSessionId = $("#sessionId");	
        
	//$(".see-all").attr("href",URLVerMas);
				
        switch(keycode)
        {
            case 40: //abajo

                keyEvent ('next');
           
                break;
            
            
            case 38://arriba
       
                keyEvent ('prev');
       
                break;
        
            case 13:

                $("#b_keywords").val($("li[class='display_box active'] .NameResultSearch").text());
                $myList.hide();
        
                break;
            
            default:
            
            	
                if(CajaBusqueda=='')
                {
		 $(".users").detach();
		 $(".pharses").detach();
		 //$(".authors").detach();
                    $myList.hide();
                }
                else
                {			
		 if( cache ) {
			 
			 
			$(".users").detach();
			$(".pharses").detach();
		//	$(".authors").detach();
			
			ListSavedUsers = doc.data(CajaBusqueda).ListUsers;
			ListSavedPhrases = doc.data(CajaBusqueda).ListPhrases;
		//	ListSavedAuthors = doc.data(CajaBusqueda).ListAuthors;
			
			if(ListSavedUsers != ''){
			 $("#result-section-users").show();
			 $("#result-users").append(ListSavedUsers.join(''));
			}else{
			 $("#result-section-users").hide();
			}
			
			if(ListSavedPhrases != ''){
			 $("#result-section-phrase").show();
			 $("#result-phrases").append(ListSavedPhrases.join(''));
			}else{
			 $("#result-section-phrase").hide();
			}
			
//			if(ListSavedAuthors != ''){
//			 $("#result-section-authors").show();
//			 $("#result-authors").append(ListSavedAuthors.join(''));
//		 }else{
//			 $("#result-section-authors").hide();
//			}	
			
			$myList.show();
     
                 }else{

		 doc.data(CajaBusqueda,{ListUsers: '',ListPhrases: ''});					
		 /*BUSCAR LAS PERSONAS*/
                    $.ajax({
			type: "POST",
			url: "../web/mostrarPhrasesSearch.php",
												
			data: {
			 "sessionId": vSessionId.val(),
			 "type": 'personas',
			 "section": 'visual',
			 "searchWord": dataString
			},
			//beforeSend: function(){ $b.data('locked',true); },									
                        dataType: "json",
			success: function(arrayDataUser)
                        {
			 
			 if(arrayDataUser == 'NOSSID')
                           {
                             $.genericAlert('Inicia sesion para poder realizar esta accion');
                             $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                            }
                           else
                            {
				 if(arrayDataUser != 0)
			 {
				
				//var tipo = 'personas';
				ListaUserSearch = [];
				$("#result-section-users").show();
				
			$.each(arrayDataUser,function(index,value) {

               		 ListaUserSearch.push('<li id="display_box_users" class="display_box users" data-pos="" align="left"> <a class="link-user-search" href="/'+arrayDataUser[index].US_User_Login+'"><div class="cotainImgSe" style="background-image:url('+arrayDataUser[index].US_Photo_Small+');background-size: 29px 29px;"></div><span class="NameResultSearch">'+arrayDataUser[index].US_Full_Name+'</span><span class="UserResultSearch">'+arrayDataUser[index].US_User_Login+'</span><span class="CityResultSearch">'+arrayDataUser[index].US_City+'</span></a></li>');

			 });
						 
                            doc.data(CajaBusqueda).ListUsers = ListaUserSearch;
                            IsNotUser = doc.data(CajaBusqueda).ListUsers;


                            $(".users").detach();
                            $("#result-users").append(ListaUserSearch.join(''));

                            }
			 else
			 {
				//No haga nada, solo oculte su titulo
				$(".users").detach();
				$("#result-section-users").hide();
                        }
			}
			}//,
			//complete: function(){$b.data('locked',false);}
                    });
            
            
			
		 /*BUSCAR LAS FRASES*/
		 $.ajax({
			type: "POST",
			url: "../web/mostrarPhrasesSearch.php",
												
			data: {
			 "sessionId": vSessionId.val(),
			 "type": 'inspiraciones',
			 "section": 'visual',
			 "searchWord": dataString
			},
												
			dataType: "json",
			success: function(arrayDataPhrase)
			{
			 if(arrayDataPhrase == 'NOSSID')
			 {
				$.genericAlert('Inicia sesion para poder realizar esta accion');
				$(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                }
			 else
			 {
				 if(arrayDataPhrase != 0)
			 {	
				var tipo = 'inspiraciones';
				ListaPhraseSearch = [];
				$("#result-section-phrase").show();
	    			$.each(arrayDataPhrase,function(index,value) {
        
               			 //totalPhrases = totalPhrases + 1;
				 var Phrase = [];
				 Phrase = arrayDataPhrase[index].PH_Phrase;
                       	         var longitud=140;

				 if(Phrase.length > longitud){
				  Phrase = Phrase.substring(0,longitud)+'...';
				 //	var indiceUltimoEspacio= texto.lastIndexOf(' ');
                                 }
       
				 ListaPhraseSearch.push('<li id="display_box_phrase" class="display_box pharses" data-pos="" align="left"><a class="link-user-search" href="/'+arrayDataPhrase[index].US_User_Login+'&post='+arrayDataPhrase[index].IP_Inspiter_Id+'">'+Phrase+'</a></li>');
        
				});
				doc.data(CajaBusqueda).ListPhrases = ListaPhraseSearch;
				IsNotPhrase = doc.data(CajaBusqueda).ListPhrases;

				$(".pharses").detach();
				$("#result-phrases").append(ListaPhraseSearch.join(''));
			   }
			   else
			   {
				//No haga nada, solo oculte su titulo
				$(".pharses").detach();
				$("#result-section-phrase").hide();
			   }

			}
			}
    });
    
//		 /*BUSCAR LOS AUTORES*/
//		 $.ajax({
//			type: "POST",
//			url: "../web/mostrarPhrasesSearch.php",
//
//			data: {
//			 "sessionId": vSessionId.val(),
//			 "type": 'autores',
//			 "section": 'visual',
//			 "searchWord": dataString
//			},
//    
//			dataType: "json",
//			success: function(arrayDataAuthor)
//			{
//			 if(arrayDataAuthor == 'NOSSID')
//			 {
//				$.genericAlert('Inicia sesion para poder realizar esta accion');
//				window.location.reload();
//			 }
//			 else
//		  {
//    
//			 if(arrayDataAuthor != 0)
//			 {	
//    
//				ListaAuthorSearch = [];
//				$("#result-section-authors").show();
//				tipo = 'autores';
//				$.each(arrayDataAuthor,function(index,value) {
//    
//							//totalAutores = totalAutores + 1;
//	 
//							
//
//							ListaAuthorSearch.push('<li id="display_box_autores" class="display_box authors" data-pos="" align="left"><a class="link-user-search" href="/profile.php?id=">'+arrayDataAuthor[index].PH_Author+'</a></li>');
//
//						 });
//						  doc.data(CajaBusqueda).ListAuthors = ListaAuthorSearch;
//						  IsNotAuthor = doc.data(CajaBusqueda).ListAuthors;
//						 $(".authors").detach();
//						 $("#result-authors").append(ListaAuthorSearch.join(''));
//					
//			 }
//			 else
//			 {
//				//No haga nada, solo oculte su titulo
//				$(".authors").detach();
//				$("#result-section-authors").hide();
//			 }
//
//			}
//			}
//		 });
		
		 //doc.data(CajaBusqueda,{ListUsers: ListaUserSearch,ListPhrases: ListaPhraseSearch,ListAuthors: ListaAuthorSearch});
		 var asign = doc.data(CajaBusqueda);
			
		$myList.show();
		}
	}
	break; 
    }  
    return false;    
 });

 
    
/*CUANDO EL USER VUELVE A FOCO DEL BUSCADOR*/
/*-----------------------------------------*/
    
$buscador.focus(function(){
    mouse_is_inside_bus=true;    
    if ($buscador.val().length != 0) {
     $buscador.css("width","270px").attr("placeholder","Busca personas o inspiraciones...");
     $myList.show();
    }else{
      //$("#IdUserPage").attr("value","profile.php");  
     $buscador.css("width","270px").attr("placeholder","Busca personas o inspiraciones...");
    }
        
});
   
    
    
 /****************************************************************************************/
  //     PARA CERRAR O ABRIR LA LISTA DE RESULTADOS SI LE DOY CLICK A CUALQUIER PARTE DE DOCUMENTO
 /****************************************************************************************/
			
        $myList.on({ 
            mouseenter:function(){
                mouse_is_inside_bus=true;
            },
            mouseleave:function(){
                mouse_is_inside_bus=false;
            } 
        });

        //Agrega el evento click al documento, para cuando le de click en cualquier lugar excepto 
        //los comment-wrapper, me cierre los commment-wrappers
        doc.click(function(){ 
            if(!mouse_is_inside_bus){
		$buscador.css("width","130px").attr("placeholder","Buscar...");//ENCOGER EL TEXTFIELD DEL BUSCADOR
                $myList.hide();
            }
        });


/*EFECTO AMPLIAR TEXTFIELD - BUSCADOR*/
		
		/*$buscador.blur(function(){
		 $buscador.css("width","130px").attr("placeholder","Buscar...");//ENCOGER EL TEXTFIELD DEL BUSCADOR
		});*/
		/*END:EFECTO AMPLIAR TEXTFIELD - BUSCADOR*/

    
/*-----------------------------------------------------------------------------*/
    
    
    
    
/*FUNCIONES*/
/*-----------------------------------------------------------------------------*/
    
    
    
      
/*CUANDO EL USER PRESIONA ARRIBA O ABAJO PARA NAVEGAR LA LISTA*/
/*-------------------------------------------------------*/ 

function keyEvent (action)
{
    var yx = 0;
	var yxtitle = 0;
	var yxu = 0;
    var ul;
		var ulPrev;
		var ulPrevLiLast;
		var LiActive;
    
    
    $("#display-result").find("li").each(function(){ //buscar los li marcados

        if($(this).attr("data-pos") == "active"){
     
            yx = 1;
        }
    });
		
		$("#display-result").find("div").each(function(){  //buscar los div marcados
     
        if($(this).attr("data-pos") == "active"){

            yxtitle = 1;
        }
    });
	
	$("#display-result").find("ul").each(function(){  //buscar los ul marcados
     
        if($(this).attr("data-pos") == "active"){
            ul = $("#display-result").find("ul[data-pos='active']");
            yxu = 1;
        }
    });


if( yxu == 1 )//Encontro un ul marcado
    {
        
	if( yxtitle == 1 )// Se esta posicionado en el div de este ul?
	{
	var selDiv = ul.find("div[data-pos='active']");
        
        if(action=='next'){
	 selDiv.next().addClass("active").attr("data-pos","active");
	}else{
	 ulPrev = ul.prev();
	 ulPrevLiLast = ulPrev.find("li:last");
	 ulPrev.attr("data-pos","active");
	 ulPrevLiLast.addClass("active").attr("data-pos","active");
	 ul.attr("data-pos","");
			
    }
        selDiv.attr("data-pos","");
	 sendLiData();
	}
	else if( yx == 1 )//Se esta posicionado en un li de este ul?
	{
	 var selLi = ul.find("li[data-pos='active']");
		
	 if(action=='next')
	 {
	  ul.find("li:last").each(function()
	  {  /*Tengo que preguntar si estoy en el ultimo li, entonces le asigno el marcador al ul siguiente*/
	   if($(this).attr("data-pos") == "active")
	   {
	    ul.attr("data-pos","").next().attr("data-pos","active");
	   }
	  });
	  selLi.next().addClass("active").attr("data-pos","active");  /*Tener cuidado con esto testear bien*/
			
	  }
          else
	  {
	   selLi.prev().addClass("active").attr("data-pos","active");
        
	  } 
		
           selLi.removeClass("active").attr("data-pos","");
	   sendLiData();
	 }
	 else  //No esta posicionado en ningun elemento del ul.
	 { 
	
	  if(action=='next')
	  {
	   ul.find("div").attr("data-pos","active");
	  }
	  else // La accion es prev, entonces al ul anterior a este lo guardo en una variable, y a su ultimo li le asigno el marcador
	  {
	   ulPrev = ul.prev();
	   ulPrevLiLast = ulPrev.find("li:last");
	   ulPrev.attr("data-pos","active");
	   ulPrevLiLast.addClass("active").attr("data-pos","active");
	   ul.attr("data-pos","");
	  }
        
	 }

    }
    else  //No hay ningun ul marcado quiere decir que no he recorrido la lista
    {
	
	$("#display-result").find('div:first').attr('data-pos','active');
	$("#display-result").find('ul:first').attr('data-pos','active');
    }

//Para setear en el attribute action del form la url de: search.php ya que no hay ningun li activo
$("#display-result").find("li").each(function(){ //buscar los li marcados
        if($(this).attr("data-pos") == "active"){
         LiActive = 'si';
        }
    });
	
 if(LiActive == 'si'){
  $("#search-admire").attr("action","web/checkBuscarUser.php");
 }else{
 // var URLData = $('#b_keywords').val(); 
 // $("#search-admire").attr("action",'/search.php?resultsfor='+URLData);
 }

}





//Para enviar los datos de los autores, frases y user a las etiquetas input, para cuando le de enter, me lleve a su url correspondiente

function sendLiData(){
 
  var UserNameField;
  var PhraseField;
 
 $("#display-result").find("li").each(function(){ //buscar los li marcados
     
         if(($(this).attr("data-pos") == "active")&&($(this).attr("id")=="display_box_users")){ //Si estoy parado en algun resultado de user
          PhraseField="";
          $("#PhraseField").attr("value",PhraseField);
          UserNameField = $("li[data-pos='active'] .link-user-search").attr("href");
          $("#IdUserPage").attr("value",UserNameField);
         }

         if(($(this).attr("data-pos") == "active")&&($(this).attr("id")=="display_box_phrase")){ //Si estoy parado en algun resultado de phrases
          UserNameField = "";
          $("#IdUserPage").attr("value",UserNameField);
          PhraseField = $("li[data-pos='active'] .link-user-search").attr("href");
          $("#PhraseField").attr("value",PhraseField);
         }
  });
		
 
}

});
