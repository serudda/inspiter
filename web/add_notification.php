<?php 
error_reporting(0);
require_once 'clases/Notification.php';
require_once 'clases/Session.php';
require_once 'clases/Config.php';
require_once 'clases/Token.php';
session_start();

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}

$resultConfig = 'NO';
if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
 {
  if (isset($_POST['userEventId']) && isset($_POST['userNotifiedId']) 
   &&isset($_POST['inspiterId']) && isset($_POST['typeId']))
  {
      $userEventId   = $_POST['userEventId'];
      $userNotifiedId =  $_POST['userNotifiedId']; 
      $inspiterId = $_POST['inspiterId'];
      $typeId = $_POST['typeId'];
      $dedicationId = $_POST['dedicationId'];
            
      $notificationObj = new Notification(NULL,$userEventId,$userNotifiedId,$inspiterId,$typeId,1,NULL,$dedicationId);
      $resultNotification = $notificationObj->insertNotification();
        
      if ($resultNotification == true)
      {   
           $configIPS = Config::addConfigValue($userNotifiedId,$typeId);
          
          $config1 = new Config(null,$userNotifiedId,1,null);
          $resultConfig = $config1->insertStatusNotif();
          if($resultConfig != false)
		  {
            Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
            $token = getToken();
            //se inserta el token generado en la base
            $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
            $resultTokenOperation =  $resultToken->insertTokenOperation();
            if($resultTokenOperation != false)
            {
              $_SESSION['tokenId']=$resultTokenOperation;
              echo $configIPS;
            }
            else
              echo 'NO1';  
          } 
          else 
            echo 'NO2';
       }
	   else 
            echo 'NO3';
   }
   else
      echo 'NO4'; 
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
