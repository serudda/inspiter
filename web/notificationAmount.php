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

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(Session::checkSession($_SESSION['iduser']) != false)
{
 if(isset($_POST['sessionId'])==true)
 {
    $notificationsAmount = 0;
    $notificationsResult = Config::getNotificationAmountShowed($_SESSION['iduser']);
    if ($notificationsResult > 0)
        $notificationsAmount = $notificationsResult;
    else
        $notificationsAmount = 0;
     echo $notificationsAmount;
 }
 else
  echo 0;
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
