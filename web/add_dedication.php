<?php 
error_reporting(0);
require_once 'clases/Dedication.php';
require_once 'clases/Notification.php';
require_once 'clases/Config.php';
require_once 'clases/Session.php';
require_once 'clases/Mail.php';
require_once 'clases/User.php';
require_once 'clases/Inspiter.php';
require_once 'clases/Token.php';
session_start();

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

function stripslashes_deep ($text, $times) 
{
  $i = 0;
  // loop will execute $times times.
  while (strstr($text, '\\') && $i != $times) 
  {
    $text= stripslashes($text);
    $i++;
  }
  return $text;  
}

if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
 {
  $serverName = $_SERVER['SERVER_NAME'];
  if(isset($_POST['dedicInspiterId']) && $_POST['dedicInspiterId'] != NULL 
  && isset($_POST['DedMessage']))
  {
    $inspiterId = $_POST['dedicInspiterId'];
    $userFromId = $_POST['FromUserId'];
    $userToId = $_POST['ToUserId'];
    $username = $_POST['dedicUsername'];
    $CommContent = addslashes($_POST['DedMessage']);
    $comment1 = stripslashes_deep ($CommContent, 1);
    $comment = strip_tags($comment1);
    $User1 = null;
    
   if($userToId != null && $userToId != '')
   { 
       $User1 = User::getUserById($userToId);  
   }
   $inspiter1 = Inspiter::getInspiterById($inspiterId);
   $userIdInspiter = User::getUserIdByInspiterId($inspiterId);
    
    if($userToId != null && $userToId != '' && $User1 != null && $User1 != '')
    {
        $dedicationObj = new Dedication(null,$inspiterId,$userFromId,$userToId,$comment,null);
        $resultDedication = $dedicationObj->insertDedication();
    }
    else
        $resultDedication = true;

    if ($resultDedication != false)
    {  
      Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
      $token = getToken();
      //se inserta el token generado en la base
      $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
      $resultTokenOperation =  $resultToken->insertTokenOperation();
      if($resultTokenOperation != false)
      {
       $_SESSION['tokenId']=$resultTokenOperation; 
       if($_POST['DedCheckMail']==1)
       {
         $remitente  = 'no-reply@inspiter.com';
         $destino= $_POST['inputMail'];
         $asunto= $_POST['FromUsername']." te dedico una inspiracion";
         $mensaje = '<html>
<head>
<style type="text/css">
p {margin-bottom:0; margin:0}
</style>
</head>

<body>
<div lang="es" style="background-color:#C5E1B9;background: url("http://www.inspiter.com/images/bg-slice.jpg") repeat;padding:0;margin:0">
	<table cellspacing="0" cellpadding="0" border="0" width="100%" background="http://www.inspiter.com/images/bg-slice.jpg">
		<tbody>
			<tr>
				<td style="padding:20px 20px 40px">
					<table cellspacing="0" cellpadding="0" border="0" align="center" width="620">
						<tbody>
							<tr>

								<td align="center" style="padding:20px 0 40px">

									<a href="http://www.inspiter.com" title="Visita inspiter.com" style="border:none" target="_blank">

										<img src="http://www.inspiter.com/images/inspiter-logo-large.png" width="200" height="52" style="vertical-align:top;outline:none;border:none" alt="Inspiter">

									</a>

								</td>

							</tr>
							<tr>
							<td background="http://www.inspiter.com/images/line-mail-logo.gif" align="center">
								<table cellspacing="0" cellpadding="0" border="0" align="center">
									<tbody>
										<tr>
											<td background="http://www.inspiter.com/images/bg-slice.jpg" style="background-color:#C5E1B9">
	
												<h1 style="font-family:georgia,serif;font-weight:normal;font-size:22px;line-height:21px;color:#211922!important;margin:0;padding:0 20px">

													&iexcl;Hola, ';
                                                       if($userToId != null && $userToId != '' && $User1 != null && $User1 != '') 
                                                           $mensaje .= $User1->getFullName();
                                                       else
                                                          $mensaje .= $_POST['ToName']; 
                                                       
                                                       $mensaje .='!
												
												</h1>
											
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							
							<tr>
								<td background="http://www.inspiter.com/images/bg-slice.jpg" align="center" style="background-color:#C5E1B9; padding-top:38px; padding-bottom: 15px;">
								<span style="font-family:georgia,serif;font-weight:normal;font-size:18px;line-height:21px;color:#211922!important; margin:0; padding-top:38px; padding-right:20px; padding-bottom:15px; padding-left:20px; text-align:center">
								'.$_POST["FromUsername"].' te ha dedicado algo, esperamos te guste:
								</span>
								</td>
							</tr>
							
							<tr>
								<td align="center" background="http://www.inspiter.com/images/QuoteTeam.png" style="background-repeat: no-repeat; background-position: 5px 3px;  background-color: #EEEEEE; padding-top: 13px; padding-bottom: 13px; padding-left: 40px; padding-right: 13px; font-family: Georgia; font-size: 17px; font-style: italic; color:#757575;  border-top: 1px solid #cfcece; border-right: 1px solid #c1bfc0; border-bottom: 1px solid #a09f9f; border-left: 1px solid #c1bfc0; border-radius: 6px;">
									<table>
											<tbody>
												<tr>
												<td>
													<a style="margin: 0; margin-bottom:0; color:#7E7E7E;text-decoration:none" href="http://www.inspiter.com/';
                                                      if($userToId != null && $userToId != '' && $User1 != null && $User1 != '')  
                                                       {  $mensaje .= $User1->getUserLogin().'&amp;dedic='.$resultDedication.'">';}
                                                       else
                                                       {$mensaje .= 'register.php">'; }
                                                      






                                                       $mensaje .=  'Haz clic para ver la dedicatoria</a>
												</td>
												</tr>

											</tbody>
									</table>
								</td>
						
							</tr>
							
							<tr>
								<td background="http://www.inspiter.com/images/bg-slice.jpg" align="center" style="background-color:#C5E1B9; padding-top:38px; padding-bottom: 15px;">
								<span style="font-family:georgia,serif;font-weight:normal;font-size:18px;line-height:21px;color:#211922!important;padding-top:38px; padding-right: 20px; padding-bottom: 15px; padding-left: 20px; text-align:center">
								Adem&aacute;s agrego esta dedicatoria:
								</span>
								</td>
							</tr>
							
							<tr>
								<td style="background:#FFFFFF; padding-top:13px; padding-bottom:13px; padding-left:18px; padding-right:18px; font-family:Calibri; font-size:17px; color:#333333;  border-top:1px solid #cfcece; border-right:1px solid #c1bfc0; border-bottom:1px solid #a09f9f; border-left:1px solid #c1bfc0;">
									<p style="margin:0; margin-bottom:0;">'.$comment.'</p>
								</td>
							</tr>
							
							<tr height="25"></tr>
							
							<tr >

								<td align="center">
								
									<img src="http://www.inspiter.com/images/line-footer-mail.png" height="18" style="vertical-align:top;outline:none;border:none">
								
								</td>
					
							</tr>

							<tr>

								<td align="center" style="padding-top:30px; padding-bottom:5px;">

									<p style="font-family:helvetica; font-size:12px; color:#767676; line-height:10px; padding:0 ">Este correo electrónico se ha enviado a <a href="mailto:admin@inspiter.com" style="color:#4D4D4D;text-decoration:none" target="_blank">'.$destino.'</a>.
									<!--<br> &iquest;No quieres notificaciones sobre la actividad? <span><a href="#" style="color:#4D4D4D;text-decoration:underline" title="Date de baja o gestiona tus preferencias de correo electrónico electrónico" target="_blank">Modifica tus preferencias de correo electrónico</a>.</span>-->
									</p>

								</td>

							</tr>
							
							<tr>

								<td align="center">

									<p style="font-family:helvetica; font-size:11px; color:#767676; line-height:10px; margin:0; padding:0"><span>&copy;</span>2013 Inspiter. <font style="color:#aaa;padding:0 2px">|</font> Todos los derechos reservados<br><a href="" style="color:#4D4D4D;text-decoration:underline" target="_blank">Privacidad</a> <font style="color:#aaa;padding:0 2px"> |</font> <a href="" style="color:#4D4D4D;text-decoration:underline" target="_blank">Condiciones</a></p><img src="" width="0" height="0">

								</td>

							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</body>
</html>';
         
         $header .= "From: Inspiter <$remitente>\r\n"; 
         $header .= "Organization: Inspiter\r\n"; 
         $header .= "Content-Type: text/html; charset=UTF-8";
         $emailObj = new Mail($remitente,$destino,$asunto,$mensaje,$header);
         $resultMail = $emailObj->sendMail();
      }    
      if($userToId != null && $userToId != '' && $User1 != null && $User1 != '')
      {
       $notificationObj = new Notification(NULL,$userFromId,$userToId,$inspiterId,6,1,NULL,strval($resultDedication));
       $resultNotification = $notificationObj->insertNotification();
          
      if ($resultNotification == true)
      {   
          if($userFromId != $userToId)
          { 
              if($userFromId != $userIdInspiter)
              {
                  $notification1 = new Notification(NULL,$userFromId,$userIdInspiter,$inspiterId,9,1,NULL,NULL);
                  $resultNotification = $notification1->insertNotification();
                  $configIPS = Config::addConfigValue($userIdInspiter,6);
                  $configAux = new Config(null,$userIdInspiter,1,null);
                  $resultConfig1 = $configAux->insertStatusNotif();
              }
              $config1 = new Config(null,$userToId,1,null);
              $resultConfig = $config1->insertStatusNotif();
              if($resultConfig != false)       
              {
                  $inspiterAux = Inspiter::getInspiterById($inspiterId);
                  $userAux = User::getUserById($inspiterAux->getUserId());
                  if($_POST['DedCheckFace']==1)
                      echo 'YES_FACE@@'.$userAux->getUserLogin().'@@'.strval($resultDedication);
                  else
                      echo 'YES_NOFACE@@'.$userAux->getUserLogin();
              }
              else
                 echo 'NO_CONFIG';
          }
          else
          {
                 echo 'YES_NOTHING@@'.$userAux->getUserLogin();
          }
      } 
      else 
          echo 'NO_NOTIFICATION';
   }
    else
    {
       $inspiterAux = Inspiter::getInspiterById($inspiterId);
       $userAux = User::getUserById($inspiterAux->getUserId());
       echo 'YES_NOFACE@@'.$userAux->getUserLogin();
    }
    }
 else {
      echo 'NO_DEDICATION';  
    }
  }    
    else 
        echo 'NO_DEDICATION';
  }
  else
     echo 'NO_VARIABLE';
} 
else
{
    echo 'NOSSID';
    header("location: ../index.php?logout=ok&activate=si&uid=Y");
}
}
else
    echo 'NOSSID'; 
?> 
