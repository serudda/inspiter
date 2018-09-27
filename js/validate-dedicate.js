$(document).ready(function()
{
 var vToname = $("#ToName");
 var vDedMessage = $("#DedMessage");
 var InpucheckDed = $("#DedCheckMail");
 var ToEmailBlock = $(".ToEmailBlock");
 var VdedicInspiterId = $("#dedicInspiterId");
 var VfromUserId   = $("#FromUserId");
 var VtoUserId   = $("#ToUserId"); 
 var VdedicUsername = $("#dedicUsername"); 
 var VdedCheckMail = $("#DedCheckMail");
 var VdedCheckFace = $("#DedCheckFace");
 var VfromUsername = $("#FromUsername");
 var VinputMail    = $("#ToinputEmail");
 //HACER APARECER EL TEXTFIELD DE EMAIL CUANDO EL USUARIO ESCOJA LA OPCION DE DEDICAR AL CORREO
 InpucheckDed.click(function() 
 {  
  if(InpucheckDed.is(':checked'))
  {    
    ToEmailBlock.fadeIn(400);
  }
  else 
  {  
    ToEmailBlock.fadeOut(400);  
  }  
 });
 $("#DedSubmit").click(function(e)
 { 
   if(validateToname() == true && validateComment() == true)
   {
     var VdedCheckMailCheck = 0;
     var VdedCheckFaceCheck = 0;
     if(VdedCheckMail.attr("checked")) 
     {
       VdedCheckMailCheck=1;
     }
     else
     {
       VdedCheckMailCheck=0;
     }
     if(VdedCheckFace.attr("checked")) 
     {
       VdedCheckFaceCheck=1;
     } 
     else
     {
       VdedCheckFaceCheck=0;
     }
     $.post("../web/add_dedication.php", {
                dedicInspiterId: VdedicInspiterId.val(),
                FromUserId: VfromUserId.val(),
                ToUserId: VtoUserId.val(),
                DedMessage: vDedMessage.val(),
                dedicUsername: VdedicUsername.val(),
                DedCheckMail: VdedCheckMailCheck,
                DedCheckFace: VdedCheckFaceCheck,
                FromUsername: VfromUsername.val(),
                inputMail: VinputMail.val()
      },
      function(data)
      {
       if(data.toString().indexOf('NOSSID') >= 0)
       {
         $.genericAlert('Inicia sesion para poder realizar esta accion');
         $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
        }
        else
        {
          if(data.toString().indexOf('YES_FACE') >= 0)
          {
             var InspiterUsername = data.toString().split('@@')[1];
             $(location).attr('href','/'+$.trim(InspiterUsername)+'&dedicationStatus=sent&postFace=yes&dedicId='+$.trim(data.toString().split('@@')[2]));
           }
           else if(data.toString().indexOf('YES_NOFACE') >= 0 || data.toString().indexOf('YES_NOTHING') >= 0)
           {
              var InspiterUsername2 = data.toString().split('@@')[1];
              $(location).attr('href','/'+$.trim(InspiterUsername2)+'&post='+VdedicInspiterId.val());
           }
           else
           {
              $.genericAlert('No puedes realizar esta accion.');
           }
         }
        });
       }        
    e.preventDefault();
});
      
function validateToname()
{
    if(vToname.val().length == 0)
    {  	
      alert('Coloca el nombre de la persona a la que le dedicaras la inspiracion');
      return false;
    }
    else
    {
      return true;
    }
}

function validateComment()
{
    if(vDedMessage.val().length == 0)
    {  	
      if(confirm('Deseas enviar la dedicatoria sin comentarios?')==true)
      {return true;}
      else
      {return false;}
    }
    else
    {
      return true;
    }
}

 /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   01/05/2013
    //Purpose:     - Genera una notificacion de algun tipo  
    /*****************************************************************************************/   
   /* function addNotification(pUserIdotro,pUserId,pInspiterId,pType)
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
    }*/


});