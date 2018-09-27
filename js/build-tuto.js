$(document).ready(function()
{
/****************************************************************************************/
//                           VARIABLES GLOBALES
/****************************************************************************************/
var Iam = $("#Iam");
var ProfileBlockHeader = $(".ProfileBlockHeader");
var tuto_background = $("#tuto-background");
var tuto_wrapper = $(".tuto-wrapper");
var UserMenuComplete= $(".UserMenuComplete");
var content = $("#content");
var modalDed = $("#modalDed"); 
var $ips_block = $(".ips-block");
var btn_inspiration = $("#btn-inspiration");
var modal_background_dedtuto = $("#modal-background"); 
var dedicarForm = $("#dedicarForm .ElemGroups");
var userLogin = $("#usernameHidden");
var btn_myprofile_tuto = $("#btn-myprofile");
var TutorialOption     = $("#TutorialOption");
var $dropdown = $(".dropdown");
var usernameLogged = $("#usernameHidden");
var b_keywords = $("#b_keywords");
var isRegisterFirstTime = $("#isRegisterFirstTime");
var userIdLogged = $("#userIdLogged");
var content_menuPhrase = $('#content-menuPhrase');
var UserMenuCompleteMain = $(".UserMenuCompleteMain");
var InspiterPeople = $(".InspiterPeople");
var InspiterPeoplemCSB = $(".mCSB_1");
var vSessionId     = $("#sessionId");
var faceId   = $("#faceidHidden");
var vUserIdLogged     = $("#userIdLogged").val();
var arrayInspiterFriend = new Array();
var arrayInspiterFriendFacebook = new Array();
var progressbar = 0;
var cantAct = 0;
var $boxesTuto;

/****************************************************************************************/
//																 TEXTOS
/****************************************************************************************/
var title_tuto_text = "¡Felicitaciones y Bienvenido!";
var paragraph1 = "Te invitamos a publicar y compartir tus inspiraciones, frases que te conmuevan, imágenes que te hayan impactado, videos que te hayan robado una lagrima. Así les brindaras a otras personas en el mundo, la oportunidad de experimentar lo mismo que sentiste en ese momento.";																																																	
var paragraph2 = "Además Inspiter sirve como un espacio para compartir tus creaciones con el mundo (canciones, poemas, fotografías) así obtendrás sugerencias y comentarios sobre tus inspiraciones.";
var paragraph3 = "<strong>Si eres un inspitero frecuente, te recomendamos que cambies tu foto de perfil, ya que aumentamos su tamaño mucho más, así las demás personas pueden saber quién eres.</strong>";																																												
var paragraph4 = "Desde aquí podrás ver las inspiraciones de todo el mundo, las 10 mejores, las más populares a nivel mundial, aleatorias y las inspiraciones de las personas  que estás siguiendo.";
var paragraph5 = "Podrás publicar tus inspiraciones desde cualquier parte de Inspiter, encontrarás este ícono siempre.";
var paragraph6 = "En cada Inspiración encontrarás un botón oculto, donde podrás agregar a tu lista de favoritos esa inspiración, dedicarla a quien quieras, obtener su link para compartirla con los demás en forma rápida, o denunciarla si vez que contiene contenido no apto.";
var paragraph7 = 'Podrás darle "Me Inspira" al contenido compartido, si sientes que logro ser inspirador para ti.';
var paragraph8 = "Aquí podrás ver las personas que se inspiraron con cada contenido, y además sus opiniones o sugerencias.";
var paragraph9 = "Aquí podrás buscar a la persona dentro de Inspiter. Si esa persona no está registrada, no aparecerá en la lista de resultados, pero puedes invitarla para que vea lo que deseas dedicarle.";
var paragraph10 = "Puedes dedicarle a la persona que desees, enviándole al e-mail o dejándolo en su muro de Facebook. Recuerda que si esta persona no está registrada en Inspiter, no vas a poder dedicar en su muro, pero si enviar a su correo electrónico.";
var paragraph11 = 'Los puntos "ips" muestran que tan inspirador eres para los demás. Tener muchos puntos ips, significa que le has alegrado el dia a más de una persona y que el contenido que compartes en verdad logra llegarle a las personas.';
var paragraph12 = "Desde aqui podrás ver tu frase insignia o la de los demás.";
var paragraph14 = "Podrás buscar por personas o por inspiraciones.";
var paragraph15 = "Este será tu menú personal, donde podrás ver tus inspiraciones, tus favoritos, lo que te han dedicado o a las personas que sigues o te están siguiendo.";

/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/01/2013
//Purpose:     - Implementa la funcion contains en un array
/*****************************************************************************************/
Array.prototype.contains = function(element) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == element) {
            return true;
        }
    }
    return false;
}


/****************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/01/2013
//Purpose:     - Llamamos a cada uno de los tutoriales 
/*****************************************************************************************/

$.FollowPeople = function()
{ 
 tuto_background.css('overflow-y','scroll').css('z-index','9999');
 $(".profile-body").css('overflow-y','hidden');
 $("#InspiterPeopleTuto").animate({marginTop:'30px'},300);
 loadInspiterFriends();
 if(parseInt($("#SiguiendoAmount").val())  >= 5) 
 {   
   var interval = true;
   $("#beginTu").show();
   $("#beginInv").hide();
   $("#cantSigIni").text(0);
   if ( $("#contiTutoX")[0] )
   {}
   else
   {
     var button_tuto_htmlX = '<a id="contiTutoX" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';	
     tuto_background.append(button_tuto_htmlX);
     addEventButtonTuto(0);
   }
   if ( $("#contiTutoX")[0] )
   {
      setInterval(function() 
      {
       if(interval == false)
       {
         $("#contiTutoX").fadeIn();
         interval = true;
       }
       else
       {
          $("#contiTutoX").fadeOut();
          interval = false;
        }
       }, 1200);
     }
  }
  else
  {
     $("#beginTu").hide();
     $("#beginInv").show();
     $("#cantSigIni").text(5 - parseInt($("#SiguiendoAmount").val()));
     progressbar = 20*parseInt($("#SiguiendoAmount").val());
     $("#barSeg").css('width',progressbar+'%'); 
     
  }
  if(parseInt($("#SiguiendoAmount").val()) == 5)
  {
    $("#barSeg").css('width','100%');
    progressbar = 100;
  }
}

$.tutoBegin = function (){
 b_keywords.attr("disabled","true");
 $("#countNotif").off('click');
 $("#btn-inspiration").off('click');
 tuto_background.children('a').remove();
 tuto_background.css('overflow-y','hidden').css('z-index','10');
 $(".profile-body").css('overflow-y','scroll');   
 var button_tuto_html = '<a id="contiTuto1" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';
 var begin_tuto_html = '<div class="title-tuto"><h4>'+title_tuto_text+'</h4></div>';
     begin_tuto_html += '<div class="text-tuto"><p>'+paragraph1+'</p><p>'+paragraph2+'</p><p>'+paragraph3+'</p></div>';
 tuto_background.append(button_tuto_html);
 tuto_wrapper.append(begin_tuto_html);
 addEventButtonTuto(1);
}

$.tutoMainMenu = function(){
 tuto_background.children('a').remove();
 tuto_wrapper.children().remove();
 UserMenuCompleteMain.css("z-index","11");
 var button_tuto_html2 = '<a id="beforeTuto2" class="tutorialButtons tutorial-prev button" href="#"><span class="ico"></span></a><a id="contiTuto2" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';
 content_menuPhrase.popover({ title: 'Menú Principal', placement: 'bottom', trigger: 'manual', content: paragraph4, animation:true }).popover('show');
 btn_inspiration.popover({ title: 'Publicar una inspiración', placement: 'bottom', trigger: 'manual', content: paragraph5, animation:true }).popover('show');
 tuto_background.append(button_tuto_html2);
 addEventButtonTuto(2);
}

$.tutoPhraseParts = function(){
 tuto_background.children('a').remove();
 tuto_wrapper.children().remove();
 content.children().slice(1,2).addClass("tutoexample");
 var button_tuto_html3 = '<a id="beforeTuto3" class="tutorialButtons tutorial-prev button" style="top:5%;" href="#"><span class="ico"></span></a><a id="contiTuto3" class="tutorialButtons tutorial-next button" style="top:5%;" href="#"><span class="ico"></span></a>';
 $(".tutoexample .inner-phrase").popover({ title: 'Botón de Opciones', placement: 'left', trigger: 'manual', content: paragraph6, animation:true }).popover('show');
 $(".tutoexample .extra-tile-info .social-icons-share").popover({ title: 'Botón Me Inspira', placement: 'bottom', trigger: 'manual', content: paragraph7, animation:true }).popover('show');
 $(".tutoexample .extra-tile-info .Count_Fav").popover({ title: 'Comentarios y lista de personas inspiradas', placement: 'top', trigger: 'manual', content: paragraph8, animation:true }).popover('show');
 tuto_background.append(button_tuto_html3);
 addEventButtonTuto(3);
}

$.tutoDedicarPhrase = function(){
 tuto_background.children('a').remove();
 tuto_wrapper.children().remove();
 tuto_background.addClass("tutobackgroundDed");
 modalDed.addClass("modalDed");
 modal_background_dedtuto.addClass("modal-background");
 var button_tuto_html4 = '<a id="beforeTuto4" class="tutorialButtons tutorial-prev button" href="#"><span class="ico"></span></a><a id="contiTuto4" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';
$("#ToName").popover({ title: 'Buscar Personas', placement: 'right', trigger: 'manual', content: paragraph9, animation:true }).popover('show');
$(".posCheckFace").popover({ title: 'Dedicar en Facebook o en el correo electrónico', placement: 'bottom', trigger: 'manual', content: paragraph10, animation:true }).popover('show');
tuto_background.append(button_tuto_html4);
addEventButtonTuto(4);
}
 $.tutoBigContainWritePhrase = function(){
 b_keywords.attr("disabled","true");
 $("#countNotif").off('click');
 $("#btn-inspiration").off('click');
 var button_tuto_html5 = '<a id="beforeTuto5" class="tutorialButtons tutorial-prev button" href="#"><span class="ico"></span></a><a id="contiTuto5" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';	
 tuto_background.children('a').remove();
 tuto_wrapper.children().remove();
 ProfileBlockHeader.css("z-index","11");
 $ips_block.popover({ title: '¿Que tan inspirador eres? ', placement: 'left', trigger: 'manual', content: paragraph11, animation:true }).popover('show');
 $(".slide-change-profile").popover({ title: 'Frase Insignia', placement: 'right', trigger: 'manual', content: paragraph12, animation:true }).popover('show');
 tuto_background.append(button_tuto_html5);
 addEventButtonTuto(5);
}

$.tutoRightMenuSearch = function(){
 tuto_background.children('a').remove();
 tuto_wrapper.children().remove();
 //b_keywords.attr("disabled","true");
 UserMenuComplete.css("z-index","11");
 var button_tuto_html6 = '<a id="beforeTuto6" class="tutorialButtons tutorial-prev button" style="top: 55%;" href="#"><span class="ico"></span></a><a id="contiTuto6" class="tutorialButtons tutorial-next button" style="top: 55%;" href="#"><span class="ico"></span></a>';	
 content_menuPhrase.popover({ title: 'Menú Personal', placement: 'bottom', trigger: 'manual', content: paragraph15, animation:true }).popover('show');
 b_keywords.popover({ title: 'Buscador', placement: 'bottom', trigger: 'manual', content: paragraph14, animation:true }).popover('show');
 tuto_background.append(button_tuto_html6);
 addEventButtonTuto(6);
}


/***********************************************************************************************************/
//@Author:       Inspiter
//Create Date:   02/01/2013
//Purpose:     - Asignamos el evento a los botones (Continuar)(Atras) de cada pagina del tutorial 
/***********************************************************************************************************/

function addEventButtonTuto (page){
 
 switch(page){
        case 0:
	 $("#contiTutoX").on({
		click: function(){
                 tuto_wrapper.removeClass("ViewFollow");   
		 tuto_wrapper.children().hide();
                 $("#contiTutoX").remove();
                 //$.tutoBegin();
                 window.location.reload();
		}
	 });
        break;
	case 1:
	 $("#contiTuto1").on({
		click: function(){
		 $.tutoMainMenu();
		}
	 });
	 break;
	
	case 2:
	 $("#beforeTuto2").on({
		click: function(){
                 tuto_wrapper.removeClass("ViewFollow");      
		 UserMenuCompleteMain.css("z-index","10");
		 content_menuPhrase.popover('hide').popover('destroy');
		 btn_inspiration.popover('hide').popover('destroy');
		 tuto_wrapper.children().remove();
		 $.tutoBegin();
		}
	 });
	 $("#contiTuto2").on({
		click: function(){
		 content_menuPhrase.popover('hide').popover('destroy');
		 btn_inspiration.popover('hide').popover('destroy');
		 UserMenuCompleteMain.css("z-index","9");
		 $.tutoPhraseParts();
		}
	 });
	 break;
	
	case 3:
	 $("#beforeTuto3").on({
		click: function(){
		 $(".tutoexample .inner-phrase").popover('hide').popover('destroy');
		 $(".tutoexample .extra-tile-info .social-icons-share").popover('hide').popover('destroy');
		 $(".tutoexample .extra-tile-info .Count_Fav").popover('hide').popover('destroy');
		 content.children().slice(1,2).removeClass("tutoexample");
		 tuto_wrapper.children().remove();
		 $.tutoMainMenu();
		}
	 });
	 $("#contiTuto3").on({
		click: function(){
		 $(".tutoexample .inner-phrase").popover('hide').popover('destroy');
		 $(".tutoexample .extra-tile-info .social-icons-share").popover('hide').popover('destroy');
		 $(".tutoexample .extra-tile-info .Count_Fav").popover('hide').popover('destroy');
                 content.children().slice(1,2).removeClass("tutoexample");
		 tuto_wrapper.children().remove();
		 $.tutoDedicarPhrase();
		}
	 });
	break;
	case 4:
	 $("#beforeTuto4").on({
		click: function(){
		 $("#ToName").popover('hide').popover('destroy');
     $(".posCheckFace").popover('hide').popover('destroy');
		 content.children().slice(1,2).addClass("tutoexample");
		  tuto_background.removeClass("tutobackgroundDed");
		  modalDed.removeClass("modalDed");
			modalDed.css("display","none");
			modal_background_dedtuto.removeClass("modal-background");
			modal_background_dedtuto.css("display","none");
			tuto_wrapper.children().remove();
		 $.tutoPhraseParts();			
		}
	 });
	 $("#contiTuto4").on({
		click: function(){
		 tuto_background.children('a').remove();
                 $("#ToName").popover('hide').popover('destroy');
                 $(".posCheckFace").popover('hide').popover('destroy');
		 content.children().first().removeClass("tutoexample");
		 tuto_background.removeClass("tutobackgroundDed");
	         modalDed.removeClass("modalDed");
		 modalDed.css("display","none");
		 modal_background_dedtuto.removeClass("modal-background");
		 modal_background_dedtuto.css("display","none");
		 tuto_wrapper.children().remove();
		 $(location).attr('href','/'+userLogin.val());
		}
	 });
	break;
	case 5:
	 $("#beforeTuto5").on({
		click: function(){
		 $ips_block.popover('hide').popover('destroy');
		 $(".slide-change-profile").popover('hide').popover('destroy');
		 ProfileBlockHeader.css("z-index","10");
		 tuto_wrapper.children().remove();
		 $(location).attr('href','/main.php?back=si');
		}
	 });
	 $("#contiTuto5").on({
		click: function(){
		 $ips_block.popover('hide').popover('destroy');
		 $(".slide-change-profile").popover('hide').popover('destroy');
		 ProfileBlockHeader.css("z-index","10");
		 $.tutoRightMenuSearch();
		}
	 });
	 break;

	case 6:
	 $("#beforeTuto6").on({
		click: function(){
		 content_menuPhrase.popover('hide').popover('destroy');
		 b_keywords.popover('hide').popover('destroy');
		 UserMenuComplete.css("z-index","10");
		 tuto_wrapper.children().remove();
		 $.tutoBigContainWritePhrase();
		}
	 });
	 $("#contiTuto6").on({
		click: function()
                {
                 var userId = userIdLogged.val();
		 content_menuPhrase.popover('hide').popover('destroy');
		 b_keywords.popover('hide').popover('destroy');
		 tuto_background.css("display","none");
		 btn_myprofile_tuto.attr("data-toggle","dropdown");
		 tuto_wrapper.children().remove();
                 $.post("../web/inviteFriends.php", {
                    IFuserId: userId, 
                    IFband: 'NO' //pongo en SI de neuvo al campo para iniciar el tutorial
                  },
                  function(data)
                  {
                    if(data == 'NOSSID')
                    {
                        $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                        $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                    }
                    else
                    {
                      window.location.reload();
                    }
                 });
                }
	 });
	 break;
	 
	default:break;
 }
 
}


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
     
     
 //INICIO DE TUTORIAL
if(isRegisterFirstTime.val() == 'NO') 
{}
else if(isRegisterFirstTime.val() == '' || isRegisterFirstTime.val() == null) 
{$(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');}
else
{
    btn_myprofile_tuto.removeAttr("data-toggle");
     tuto_background.css("display","block");
     
    if(Iam.val() == 'main')
    {
      var back = $.getUrlVar('back'); 
      
      if(back == 'si')
      {
        //$("#countNotif").attr("id","countNotificPosMod");
         b_keywords.attr("disabled","true");
         $("#countNotif").off('click');
         $("#btn-inspiration").off('click');
        $.tutoDedicarPhrase();
      }
      else
      {
	$("#countNotif").attr("id","countNotificPosMod");
	if( parseInt($("#SiguiendoAmount").val()) < 5)
          $.FollowPeople();
        else
        {
          tuto_wrapper.removeClass("ViewFollow");   
	  tuto_wrapper.children().hide();
          $("#contiTutoX").remove();
          $.tutoBegin();
        }
      } 
    }
    else
    {
        if( parseInt($("#SiguiendoAmount").val()) < 5)
           $(location).attr('href','/main.php');
        else
        {
          $("#countNotif").attr("id","countNotificPosMod");
          $.tutoBigContainWritePhrase();
        }
    }
}
    
  /****************************************************************************************/
  //      Agrega el evento click a la opcion Tutorial
  /****************************************************************************************/ 
 TutorialOption.click(IniciaTutorialMenu);
 
 function IniciaTutorialMenu()
 {
     var userId = userIdLogged.val();
 
     $.post("../web/inviteFriends.php", {
            IFuserId: userId, 
            IFband: 'SI' //pongo en SI de neuvo al campo para iniciar el tutorial
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                
                if(Iam.val() == 'main')
                {
                 b_keywords.attr("disabled","true");
                  btn_myprofile_tuto.removeAttr("data-toggle"); //y aqui hago aparecer el tutorial, la cagada es q me qeuda abierto el menu cuando hago click en turorial me entendes mira lo q te digo...
                  $dropdown.removeClass("open");
                  tuto_background.css("display","block");
                  if( parseInt($("#SiguiendoAmount").val()) < 5)
                    $.FollowPeople();
                  else
                  {
                      tuto_wrapper.removeClass("ViewFollow");   
		      tuto_wrapper.children().hide();
                      $("#contiTutoX").remove();
                      $.tutoBegin();
                  }
                }
                else
                {
                     $(location).attr('href','/main.php');
                }
            }
        });
 }
 
//DESHABILITAMOS TODOS LOS BOTONES (INSPIRACION, NOTIFICACION)
function disableLink(e) {
    // cancels the event
    e.preventDefault();

    return false;
}


 
function loadInspiterFriends()
{
  var queryFriend = "select distinct(US_User_Id),US_Face_Id,US_Full_Name,US_User_Login,US_Photo,US_City,(SELECT COUNT(*) FROM ins_follow_tb WHERE FW_DAD_Id = US_User_Id AND FW_Sun_Id = (select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+")) as FW_Follow_Flag from ins_users_tb where "
  queryFriend += " US_User_Id not in (select FW_Dad_Id from ins_follow_tb,ins_users_tb where US_User_Id = FW_Sun_Id and US_User_Id=(select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+"))";
  queryFriend += " and (select count(*) from ins_inspiter_tb where IP_By_User_Id = US_User_Id) > 0 ";
  queryFriend += "and US_User_Id <> 1 ORDER BY RAND() DESC LIMIT 30";
  $.ajax({
           url: "../web/inspiterFriend.php",
           data: {
                   "stringQuery": queryFriend,
                   "sessionId": vSessionId.val()
                 },
           type: "POST",
           dataType: "json",
           success: function(data) 
           {
            if (data.toString().indexOf('NOSSID') >= 0)
            {
              $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
              $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else 
            {
                var insFriendHtml ='';
               $.each(data,function(index,value) 
               {
                  if(arrayInspiterFriend.length < 30 && arrayInspiterFriend.contains('follow_'+data[index].US_User_Id) == false)
                  {
                     insFriendHtml += '<div class="allPartSeg People" id="allPartSeg_'+data[index].US_User_Id+'">';
                     insFriendHtml += '<div class="grid-feed-follow feed-item-follow boxFo feed-item-newFo Tutofollow" id="gridSiguiendo_'+data[index].US_User_Id+'">';
                     insFriendHtml += '<div class="border-divFo"></div>';
                     insFriendHtml += '<a id="follow_'+data[index].US_User_Id+'" class="btn-Follow" href="#">Seguir</a>';
                     insFriendHtml += '<div class="extra-tile-info-follow"><div class="avatar-inspiter-follow">';
                     insFriendHtml += '<a href="#">';
                     insFriendHtml += '<img class="img-user-inspiter-follow" src="'+data[index].US_Photo+'" alt=""></a>';
                     insFriendHtml += '</div><div class="avatar-user-info-follow"><h4>';
                     insFriendHtml += '<a class="name-complete-box-follow" href="#">'+data[index].US_Full_Name+'</a></h4>'; 
                     insFriendHtml += '<a class="username-box-follow" href="#">'+data[index].US_User_Login+'</a>';
                     insFriendHtml += '<p class="follow-inspiter-city-country">'+data[index].US_City+'</p>';
                     insFriendHtml += '</div><div class="BlockIpsPerson">';
                     insFriendHtml += '</div></div><input type="hidden" value="'+data[index].FW_Follow_Flag+'" id="followUser_'+data[index].US_User_Id+'"></div></div>';
                     arrayInspiterFriend.push('follow_'+data[index].US_User_Id);
                   }
                });
                InspiterPeople.append(insFriendHtml);
                InspiterPeople.mCustomScrollbar({set_height:460});
                var id_amigo;
                for(i=0;i<arrayInspiterFriend.length;i++)
                {
                 id_amigo = arrayInspiterFriend[i].split("_")[1];
                 addEvenToNewElementSiguiendo(id_amigo);
                }
            }
    }
  });
}

/****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   18/02/2013
  //Purpose:     - Funcion apra comenzar a seguir a alguien 
/*****************************************************************************************/   
function followFriend(userId) 
{
    $.post("../web/add_del_seg_sig.php", {
            FdadId: userId, 
            FsunId: vUserIdLogged,
            FcantFollow: 1
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data != 'NO')
                {
                    addNotification(userId,vUserIdLogged,0,4);
                    
                    if(data >= 5) 
                    {   
                        var interval = true;
                        $("#beginTu").show();
                        $("#beginInv").hide();
                        $("#cantSigIni").text(0);
                        if ( $("#contiTutoX")[0] )
                        {}else{
                        var button_tuto_htmlX = '<a id="contiTutoX" class="tutorialButtons tutorial-next button" href="#"><span class="ico"></span></a>';	
                        tuto_background.append(button_tuto_htmlX);
                         addEventButtonTuto(0);
                        }
                        
                        if ( $("#contiTutoX")[0] )
                        {
                            setInterval(function() {
                                if(interval == false){
                                    $("#contiTutoX").fadeIn();
                                    interval = true;
                                }else{
                                    $("#contiTutoX").fadeOut();
                                    interval = false;
                                }
                            }, 1200);
                        }
                        
                    }else
                    {
                        $("#beginTu").hide();
                        $("#beginInv").show();
                        $("#cantSigIni").text(5 - data);
                        progressbar = 20*data;
                        $("#barSeg").css('width',progressbar+'%'); 
                    }
                    
                    if(data == 5){
                    $("#barSeg").css('width','100%');
                    progressbar = 100;
                    }
                    return false;
                }
                else
                {
                
                }
            }
        });
}

 /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   18/02/2013
  //Purpose:     - Genera una notificacion de algun tipo  
  /*****************************************************************************************/   
  function addNotification(pUserIdotro,pUserId,pInspiterId,pType)
  {
       $.post("../web/add_notification.php", {
             userEventId: pUserId,
             userNotifiedId: pUserIdotro,
             inspiterId: pInspiterId,
             typeId: pType,
             dedicationId: '0' 
         },
         function(data)
         {
             if(data.toString().indexOf('NOSSID') >= 0)
             {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
             }
             else
             {
                 if(data.toString().indexOf('YES') >= 0)
                 {
                   
                 }
                 else
                 {
                 }
             }
         });
  }
  
   /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   18/11/2012
    //Purpose:     - Funcion para dejar de seguir a una persona
    /*****************************************************************************************/   
    function leaveToFollowFriend(userId)
    {
        $.post("../web/add_del_seg_sig.php", {
            LFdadId: userId, 
            LFsunId: vUserIdLogged,
            LFcantFollow: 1
        },
        function(data)
        {
            if(data == 'NOSSID')
            {
                $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else
            {
                if(data != 'NO')
                {
                    if(data >= 5)
                    {
                    }
                    else
                    {
                        if ( $("#contiTutoX")[0] )
                        {
                            var contiTutoX = $("#contiTutoX");
                            contiTutoX.remove();    
                        }
                        
                        $("#beginTu").hide();
                        $("#beginInv").show();
                        cantAct = $("#cantSigIni").text();
                        var sumPeople = parseInt(cantAct) + 1;
                        $("#cantSigIni").text(sumPeople);
                        progressbar = progressbar - 20;
                        $("#barSeg").css('width',progressbar+'%');
                    }
                    
                    addIPSNegative(11,0,userId);
                    return false;
                }
            }
        });
    }
    
  /****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   29/03/2013
  //Purpose:     - Suma valores negativos a los IPS dependiendo del tipo de transaccion que se haga
  /*****************************************************************************************/				 
  function addIPSNegative(pType, pInspiterId, pUserId)
  {
       $.post("../web/addIPSValue.php",{
             type: pType, 
             inspiterId: pInspiterId,
             userId: pUserId
        },
        function(data,status) 
        {
            if(data == 'NOSSID')
            {
                 $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');	
                 $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
            }
            else 
            { 
                if(data == 'YES') 
                { 
		   
                }
                else
                {
		   
                }
             }
        });
  }
  
  /****************************************************************************************/
    //  AGREGA LOS EVENTOS DE SIGUIENDO
    /****************************************************************************************/
    function addEvenToNewElementSiguiendo(pUserId)
    {	
        $('#follow_'+pUserId).hover(function()
        {
          if($('#follow_'+pUserId).text() == "Siguiendo")
          { 
              $('#follow_'+pUserId).removeClass("following");
              $('#follow_'+pUserId).addClass("unfollowing");
              $('#follow_'+pUserId).text('Dejar de Seguir');
          }
        }, function() 
        {
          if($('#follow_'+pUserId).text() == "Dejar de Seguir")
          {
             $('#follow_'+pUserId).removeClass("unfollowing");
             $('#follow_'+pUserId).addClass("following");
             $('#follow_'+pUserId).text('Siguiendo');
          }
       });
       var flagFollowUser = $('#followUser_'+pUserId);
       //0 aun no inspirada, tiene q inspirar  
       //1 ya inspirada, tiene q ya no inspirar
       $('#follow_'+pUserId).on
       ({			
            click: function()
            {
               if(flagFollowUser.val() == '1')
               {
                  $('#follow_'+pUserId).removeClass("unfollowing");
                  $('#follow_'+pUserId).removeClass("following");
                  $('#follow_'+pUserId).text('Seguir');
                  $('#followUser_'+pUserId).val("0");
                  leaveToFollowFriend(pUserId);
                  return false;
                }
                else
                {
                  $('#follow_'+pUserId).addClass("following");
                  $('#follow_'+pUserId).text('Siguiendo');
                  $('#followUser_'+pUserId).val("1");
                  followFriend(pUserId);
                  return false;
                 }	
              }
       });
    }
    
 $("#asso-btn-facebook-search").on
 ({
     click: function()
     {
        updateFaceId();
        return false;
     }
 });
 
 function updateFaceId()
 {
   FB.login(function(response)
   {
     if(response.authResponse)
     {
       FB.api('/me', function(me)
       {
         if (me.id) 
         {
           if(faceId.val() == 0)
           {
            $.post("../web/updateFace.php", 
            {
              user: vUserIdLogged,
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
                     faceId.val(me.id);
                     loadFriendFacebook();
                  } 
                 }
              });
           }
           else
           {
               loadFriendFacebook();
           }
          }
         });
        }
      },// Aquí es donde especificamos los permisos que queremos obtener                 
     {scope: 'email,publish_stream,user_birthday'}); 
  }

 
function loadFriendFacebook()
{
  var queryFriend;
  if(faceId.val()!='' && faceId.val()!='0' && faceId.val()!= 0)
  {
    FB.getLoginStatus(function(response)
    {
      if (response.status === 'connected' && response.authResponse.userID == faceId.val())
      { 
        queryFriend = "select distinct(US_User_Id),US_Face_Id,US_Full_Name,US_User_Login,US_Photo,US_City,(SELECT COUNT(*) FROM ins_follow_tb WHERE FW_DAD_Id = US_User_Id AND FW_Sun_Id = (select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+")) as FW_Follow_Flag from ins_users_tb, ins_inspiter_tb where US_User_Id = IP_By_User_Id AND US_Face_Id IN (";
        FB.api('/me/friends', function(response) 
        {
          for(i=0;i<(response.data.length)-1;i++)
          {
            queryFriend += response.data[i].id+',';
          }
          queryFriend += response.data[response.data.length-1].id+")";
          queryFriend += ' and US_User_Id not in (select FW_Dad_Id from ins_follow_tb,ins_users_tb where US_User_Id = FW_Sun_Id and US_User_Id=(select SS_User_Id from ins_session_tb where SS_SSID ='+vSessionId.val()+'))';
          queryFriend += ' and US_User_Id <> 1 ORDER BY RAND() LIMIT 30';
          $.ajax({
              url: "../web/inspiterFriend.php",
              data: {
                  "stringQuery": queryFriend,
                  "sessionId": vSessionId.val()
                  },
              type: "POST",
              dataType: "json",
              success: function(data) 
              {
                if (data.toString().indexOf('NOSSID') >= 0)
                {
                  $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                  $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                }
                else 
                {
                  var insFriendHtml ='';
                  $.each(data,function(index,value) 
                  {
                     if(arrayInspiterFriend.contains('follow_'+data[index].US_User_Id) == false)
                     {
                        insFriendHtml += '<div class="allPartSeg People" id="allPartSeg_'+data[index].US_User_Id+'">';
                        insFriendHtml += '<div class="grid-feed-follow feed-item-follow boxFo feed-item-newFo Tutofollow" id="gridSiguiendo_'+data[index].US_User_Id+'">';
                        insFriendHtml += '<div class="border-divFo"></div>';
                        insFriendHtml += '<a id="follow_'+data[index].US_User_Id+'" class="btn-Follow" href="#">Seguir</a>';
                        insFriendHtml += '<div class="extra-tile-info-follow"><div class="avatar-inspiter-follow">';
                        insFriendHtml += '<a href="#">';
                        insFriendHtml += '<img class="img-user-inspiter-follow" src="'+data[index].US_Photo+'" alt=""></a>';
                        insFriendHtml += '</div><div class="avatar-user-info-follow"><h4>';
                        insFriendHtml += '<a class="name-complete-box-follow" href="#">'+data[index].US_Full_Name+'</a></h4>'; 
                        insFriendHtml += '<a class="username-box-follow" href="#">'+data[index].US_User_Login+'</a>';
                        insFriendHtml += '<p class="follow-inspiter-city-country">'+data[index].US_City+'</p>';
                        insFriendHtml += '</div><div class="BlockIpsPerson">';
                        insFriendHtml += '</div></div><input type="hidden" value="'+data[index].FW_Follow_Flag+'" id="followUser_'+data[index].US_User_Id+'"></div></div>';
                        arrayInspiterFriendFacebook.push('follow_'+data[index].US_User_Id); 
                     }
                 });
                 if(arrayInspiterFriendFacebook.length > 0)
                 {
                    $(".InspiterPeople .mCustomScrollBox .mCSB_container").prepend(insFriendHtml); //sergio aqui hago el prepend
                    InspiterPeople.mCustomScrollbar("update");
                    //$boxesTuto = $(insFriendHtml);
                    //InspiterPeople.prepend( $boxesTuto ).masonry( 'reload', $boxesTuto);
                   //InspiterPeople.mCustomScrollbar({set_height:460});
                   var id_amigo;
                   for(i=0;i<arrayInspiterFriendFacebook.length;i++)
                   {
                    id_amigo = arrayInspiterFriendFacebook[i].split("_")[1];
                    addEvenToNewElementSiguiendo(id_amigo);
                   }
                   $("#InspiterPeopleTuto").animate({marginTop:'-93px'},300);
                 }
                 else
                 {
                     $.genericAlert('No pudimos encontrar mas amigos de Facebook con alguna inspiracion publicada');
                     $("#InspiterPeopleTuto").animate({marginTop:'-93px'},300);
                 }
                }
              }
            });
          });
      }
      else
      {
        $.genericAlert('Conectate con tu cuenta de Facebook');
      }
    });
  }
}
 
});