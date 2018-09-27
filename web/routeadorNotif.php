<?php 
error_reporting(0);
require_once 'clases/Notification.php';
require_once 'clases/Session.php';
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
   $notifId = $_GET['notifId'];
   $username  = $_GET['userid'];
   $inspiterId = $_GET['inspiterId'];
   $typeName = $_GET['typeName'];
   $dedicId = $_GET['dedicId'];
   
   $resultVisto = Notification::setNotifVisto($notifId);
   if ($resultVisto == true)
   {
       if($typeName == 'publish')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'sharefb')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'mif')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'follow')
           header("Location:/$username");
       else if($typeName == 'favourite')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'dedicate')
           header("Location:/$username&dedic=$dedicId");
       else if($typeName == 'comment')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'commenToo')
           header("Location:/$username&post=$inspiterId");
       else if($typeName == 'dedicInsp')
           header("Location:/$username&post=$inspiterId");
       else 
           header("Location:/main.php");
   }
   else
    header("Location:/main.php");
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
