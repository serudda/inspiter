<?php 
error_reporting(0);
require_once 'clases/Notification.php';
require_once 'clases/Session.php';
require_once 'clases/Config.php';
require_once 'clases/User.php';
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

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{   
  if (isset($_POST['sessionId']) && isset($_POST['configStatusNotif']))
  {
      $userId = User::getUserIdBySession($_POST['sessionId']);
      $config1 = new Config(null,$userId,0,null);
      $resultConfig = $config1->insertStatusNotif();
      if($resultConfig != false)
          echo 'YES';  
      else
          echo 'NO';   
  } 
  else
  {
      $resultVisto = Notification::setNotifVisto($_SESSION['iduser']);
      if ($resultVisto == true)
        echo 'YES';    
      else
        echo 'NO';   
  }
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

   