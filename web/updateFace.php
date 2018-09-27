<?php
error_reporting(0);
require_once 'clases/Session.php';
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
 if(isset($_POST['user']) && isset($_POST['faceId']))
 {
   $userUpdate = User::UpdateFaceId($_POST['user'],$_POST['faceId'],$_POST['usernameFace']);
   if ($userUpdate == 'true')
    echo 'YES';
   else
   {
      echo 'NO';
   }
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