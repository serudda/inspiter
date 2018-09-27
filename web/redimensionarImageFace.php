<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/resize-class.php';
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
  $imagedirectory = $_POST['uri'];                                                       
  $resizeObj = new resize($imagedirectory);
  //resize la imagen en 430xundefined y lo guarda en la carpeta graphIns
  $resizeObj -> resizeImage(50, 50, 'crop');
  $resizeObj -> saveImage('../images/faceImage/'.$_POST['inspiterId'].'.jpg', 100);	
  echo $_POST['uri'];
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

