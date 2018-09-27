$(document).ready(function()
{
 /****************************************************************************************/
 //                            VARIEBLES GLOBALES
 /****************************************************************************************/
 var vSessionId     = $("#sessionId");
 var vUserIdLogged     = $("#userIdLogged").val();
 var faceId   = $("#faceidHidden");
 var arrayFriend = new Array();
 var arrayInspiterFriend = new Array();
 
$(window).load(function () 
{
   loadFriends();
   loadInspiterFriends();
});

/****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   18/02/2013
  //Purpose:     - Funcion que carga los amigos de facebook para poder invitarlos a usar Inspiter
/*****************************************************************************************/   
function loadFriends()
{
  //get array of friends
    FB.getLoginStatus(function(response)
    {
      if (response.status === 'connected') 
      {
         var uid = response.authResponse.userID;
         if(faceId.val()==uid)
         {     
            FB.api('/me/friends', function(response) 
            {
                var friendHtml = '<ul id="ListofInvitesId" class="ListofInvites" style="margin:0!important;">';
                for(i=0;i<response.data.length;i++)
                {
                    friendHtml += '<li class=" grid-feed-contest-item feed-item-new box friend">';
                    friendHtml += '<div class="phrase-box">';
                    friendHtml += '<img class="avatarFriends" alt="" src="http://graph.facebook.com/'+response.data[i].id+'/picture?height=150&width=150">';
                    friendHtml += '</div>';
                    friendHtml += '<div class="border-div"></div>';
                    friendHtml += '<div class="extra-tile-info">';
                    friendHtml += '<div class="InfoFriend">';
                    friendHtml += '<div class="NameFriend">'+response.data[i].name+'</div>';
                    friendHtml += '</div>';
                    friendHtml += '<a id="invite_'+response.data[i].id+'" class="btn-Follow FriendInvited" href="#">Invitar</a>';
                    friendHtml += ' </div>';
                    friendHtml += '</li>';              
                    arrayFriend.push('invite_'+response.data[i].id);
                 }
                  friendHtml += '</ul>';
                 $("#divFriends").append(friendHtml);
                 $("#loadingFriend").hide();
                  var id_amigo;
                  for(i=0;i<arrayFriend.length;i++)
                  {
                      id_amigo = arrayFriend[i].split("_")[1];
                      $("#"+arrayFriend[i]).bind("click", {id: id_amigo},function(event)
                      {
                        FB.ui({ method: 'feed',
                                name: 'Registrate en Inspiter',
                                link: 'http://www.inspiter.com',
                                picture: 'http://www.inspiter.com/images/logo/inspiter-logo-face.jpg',
                                caption: 'Inspiter',
                                description: 'Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os.',
                                to: event.data.id
                              },
                         function(response)
                         {
                             if(response)
                             {
                                 $.genericAlert("Se ha enviado una invitacion a tu amigo");
                             }
                         });
                      });
                   }
            });
         }
         else
         {      
            $("#loadingFriend").hide();  
            $("#divFriends").animate({
               height:'200px'
            },200);
            $("#blockInviteFriendFace").show().animate({
               opacity:'1'
            },400);
          }
      }
      else
      {
          $("#loadingFriend").hide();  
            $("#divFriends").animate({
               height:'200px'
            },200);
            $("#blockInviteFriendFace").show().animate({
               opacity:'1'
            },400);
      }
    });  
}

/****************************************************************************************/
  //@Author:       Inspiter
  //Create Date:   17/02/2013
  //Purpose:     - Carga recomendados para empezar a seguir
/*****************************************************************************************/   
function loadInspiterFriends()
{
   var queryFriend;
   //get array of friends
   FB.getLoginStatus(function(response)
   {
     if (response.status === 'connected') 
     {
        var uid = response.authResponse.userID;
        if(faceId.val()==uid)
        {     
            queryFriend = "select US_Face_Id,US_User_Id,US_Full_Name,US_User_Login,US_Photo from ins_users_tb where US_Face_Id IN (";
            FB.api('/me/friends', function(response) 
            {
		for(i=0;i<(response.data.length)-1;i++)
                {
		   queryFriend += response.data[i].id+',';
		}
		queryFriend += response.data[response.data.length-1].id+")";
                // queryFriend += ' and US_User_Id = (select SS_User_Id from ins_session_tb where SS_SSID ='+vSessionId.val()+')';
                queryFriend += ' and US_User_Id not in (select FW_Dad_Id from ins_follow_tb,ins_users_tb where US_User_Id = FW_Sun_Id and US_User_Id=(select SS_User_Id from ins_session_tb where SS_SSID ='+vSessionId.val()+'))';
                $.ajax({
                url: "web/inspiterFriend.php",
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
                      var insFriendHtml = '<ul id="ListofInvitesIdInspiter" class="ListofInvites" style="margin:0!important;">';
                      $.each(data,function(index,value) 
                      {
                        insFriendHtml += '<li id="grid-feed-contest-item_'+data[index].US_User_Id+'" class=" grid-feed-contest-item feed-item-new box friend">';
                        insFriendHtml += '<div class="phrase-box">';
                        insFriendHtml += '<img class="avatarFriends" alt="" src="'+data[index].US_Photo+'">';
                        insFriendHtml += '</div>';
                        insFriendHtml += '<div class="border-div"></div>';
                        insFriendHtml += '<div class="extra-tile-info">';
                        insFriendHtml += '<div class="InfoFriend">';
                        insFriendHtml += '<div class="NameFriend">'+data[index].US_Full_Name+'</div>';
                        insFriendHtml += '</div>';
                        insFriendHtml += '<a id="follow_'+data[index].US_User_Id+'" class="btn-Follow FriendFollow" href="#">Seguir</a>';
                        insFriendHtml += ' </div>';
                        insFriendHtml += '</li>';              
                        arrayInspiterFriend.push('follow_'+data[index].US_User_Id);
                     });
                      insFriendHtml += '</ul>';
                     $("#divInspiterFriends").append(insFriendHtml);
                     $("#loadingFriend2").hide();
                     $("#divFriends").mCustomScrollbar({set_height:500});                    
                     $("#divInspiterFriends").mCustomScrollbar({set_height:500});   
                      var id_amigo;
                     for(i=0;i<arrayInspiterFriend.length;i++)
                     {
                        id_amigo = arrayInspiterFriend[i].split("_")[1];
                        $("#"+arrayInspiterFriend[i]).bind("click", {id: id_amigo},function(event)
                        {
                           followFriend(event.data.id);
                           return false;
                        });
                      }
                   }
		}
	      });
	  });
       }
       else
       {
           queryFriend = "select distinct(US_User_Id),US_Face_Id,US_Full_Name,US_User_Login,US_Photo,US_City,(SELECT COUNT(*) FROM ins_follow_tb WHERE FW_DAD_Id = US_User_Id AND FW_Sun_Id = (select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+")) as FW_Follow_Flag from ins_users_tb where "
           queryFriend += " US_User_Id not in (select FW_Dad_Id from ins_follow_tb,ins_users_tb where US_User_Id = FW_Sun_Id and US_User_Id=(select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+"))";
           queryFriend += " and (select count(*) from ins_inspiter_tb where IP_By_User_Id = US_User_Id) > 0 ORDER BY RAND() DESC LIMIT 30";
           $.ajax({
              url: "web/inspiterFriend.php",
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
                  var insFriendHtml = '<ul id="ListofInvitesIdInspiter" class="ListofInvites" style="margin:0!important;">';
                  $.each(data,function(index,value) 
                  {
                     insFriendHtml += '<li id="grid-feed-contest-item_'+data[index].US_User_Id+'" class=" grid-feed-contest-item feed-item-new box friend">';
                     insFriendHtml += '<div class="phrase-box">';
                     insFriendHtml += '<img class="avatarFriends" alt="" src="'+data[index].US_Photo+'">';
                     insFriendHtml += '</div>';
                     insFriendHtml += '<div class="border-div"></div>';
                     insFriendHtml += '<div class="extra-tile-info">';
                     insFriendHtml += '<div class="InfoFriend">';
                     insFriendHtml += '<div class="NameFriend">'+data[index].US_Full_Name+'</div>';
                     insFriendHtml += '</div>';
                     insFriendHtml += '<a id="follow_'+data[index].US_User_Id+'" class="btn-Follow FriendFollow" href="#">Seguir</a>';
                     insFriendHtml += '<input type="hidden" value="'+data[index].FW_Follow_Flag+'" id="followUser_'+data[index].US_User_Id+'">';
                     insFriendHtml += ' </div>';
                     insFriendHtml += '</li>';              
                     arrayInspiterFriend.push('follow_'+data[index].US_User_Id);
                   });
                   insFriendHtml += '</ul>';
                   $("#divInspiterFriends").append(insFriendHtml);
                   
                   $("#loadingFriend2").hide();
                   //$("#divFriends").mCustomScrollbar({set_height:500});
                   $("#divInspiterFriends").mCustomScrollbar({set_height:500});
                               
                   var id_amigo;
                   for(i=0;i<arrayInspiterFriend.length;i++)
                   {
                     id_amigo = arrayInspiterFriend[i].split("_")[1];
                     $("#"+arrayInspiterFriend[i]).bind("click", {id: id_amigo},function(event)
                     {
                        followFriend(event.data.id);
                        return false;
                     });
                   }
                }
               }
          });
               
       }
     }
     else 
     {
        queryFriend = "select distinct(US_User_Id),US_Face_Id,US_Full_Name,US_User_Login,US_Photo,US_City,(SELECT COUNT(*) FROM ins_follow_tb WHERE FW_DAD_Id = US_User_Id AND FW_Sun_Id = (select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+")) as FW_Follow_Flag from ins_users_tb where "
        queryFriend += " US_User_Id not in (select FW_Dad_Id from ins_follow_tb,ins_users_tb where US_User_Id = FW_Sun_Id and US_User_Id=(select SS_User_Id from ins_session_tb where SS_SSID ="+vSessionId.val()+"))";
        queryFriend += " and (select count(*) from ins_inspiter_tb where IP_By_User_Id = US_User_Id) > 0 ORDER BY RAND() DESC LIMIT 30";
        $.ajax({
              url: "web/inspiterFriend.php",
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
                  var insFriendHtml = '<ul id="ListofInvitesIdInspiter" class="ListofInvites" style="margin:0!important;">';
                  $.each(data,function(index,value) 
                  {
                    insFriendHtml += '<li id="grid-feed-contest-item_'+data[index].US_User_Id+'" class=" grid-feed-contest-item feed-item-new box friend">';
                    insFriendHtml += '<div class="phrase-box">';
                    insFriendHtml += '<img class="avatarFriends" alt="" src="'+data[index].US_Photo+'">';
                    insFriendHtml += '</div>';
                    insFriendHtml += '<div class="border-div"></div>';
                    insFriendHtml += '<div class="extra-tile-info">';
                    insFriendHtml += '<div class="InfoFriend">';
                    insFriendHtml += '<div class="NameFriend">'+data[index].US_Full_Name+'</div>';
                    insFriendHtml += '</div>';
                    insFriendHtml += '<a id="follow_'+data[index].US_User_Id+'" class="btn-Follow FriendFollow" href="#">Seguir</a>';
                    insFriendHtml += '<input type="hidden" value="'+data[index].FW_Follow_Flag+'" id="followUser_'+data[index].US_User_Id+'">';
                    insFriendHtml += ' </div>';
                    insFriendHtml += '</li>';              
                    arrayInspiterFriend.push('follow_'+data[index].US_User_Id);
                  });
                  insFriendHtml += '</ul>';
                  $("#divInspiterFriends").append(insFriendHtml);
                  
                  $("#loadingFriend2").hide();
                  //$("#divFriends").mCustomScrollbar({set_height:500});
                  $("#divInspiterFriends").mCustomScrollbar({set_height:500});
                   
                  var id_amigo;
                  for(i=0;i<arrayInspiterFriend.length;i++)
                  {
                    id_amigo = arrayInspiterFriend[i].split("_")[1];
                    $("#"+arrayInspiterFriend[i]).bind("click", {id: id_amigo},function(event)
                    {
                       followFriend(event.data.id);
                       return false;
                   });
                  }
                }               }
          });
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
            FsunId: vUserIdLogged
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
                if(data == 'YES')
                {
                    $('#follow_'+userId).text("Siguiendo");
                    $('#follow_'+userId).addClass("following");
                    addNotification(userId,vUserIdLogged,0,4);
                    //aqui sergio ver como hacer desaparecer el contenedor 
                    $('#grid-feed-contest-item_'+userId).fadeOut(1000, function(){ $('#grid-feed-contest-item_'+userId).remove() });
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
  
  
  function streamPublish(name, description, hrefTitle, hrefLink, userPrompt)
  {
            FB.ui(
            {
               method: 'stream.publish',
               message: 'hola como estas',
               attachment: {
               
               "media": [{
                       "type": "image", 
                       "href": "http://www.inspiter.com",
                       "src": "http://www.inspiter.com/images/graphIns/3a115544373.jpg"
                       }],
               name: name,
               caption: 'Inspiter',
               description: (description),
               href: hrefLink
           }
              ,
              action_links: [
              { text: hrefTitle, href: hrefLink }
               ],
              user_prompt_message: userPrompt
             },
            function(response) {
 
                });
 }
 
 $("#asso-btn-facebook-invited").on
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
                     location.reload();
                  } 
                 }
              });
           }
           else
           {
               if(me.id == faceId.val())
                location.reload();
               else
                $.genericAlert('Entra con tu cuenta de facebook');
           }
          }
         });
        }
      },// Aquí es donde especificamos los permisos que queremos obtener                 
     {scope: 'email,publish_stream,user_birthday'}); 
  }

});