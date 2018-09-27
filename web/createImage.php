<?php
error_reporting(0);
require_once 'clases/Image.php';
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

function stripslashes_deep ($text, $times) {
    
    $i = 0;
    while (strstr($text, '\\') && $i != $times) {
        
        $text= stripslashes($text);
        $i++;
    }
    return $text;
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{
 try
 {
  //PARA IMAGENES DE VIDEOS INSPIRADORES
  $urlImagejpg = "../images/videoImageIns/".$_SESSION['filenameVideo']."temp.jpg";
  $urlImagepng = "../images/videoImageIns/".$_SESSION['filenameVideo']."temp.png";
  $urlImageJPG = "../images/videoImageIns/".$_SESSION['filenameVideo']."temp.JPG";
  $urlImagePNG = "../images/videoImageIns/".$_SESSION['filenameVideo']."temp.PNG";
          
  if(file_exists($urlImagejpg)==true)
  {unlink($urlImagejpg);}
  else if(file_exists($urlImagepng)==true)
  {unlink($urlImagepng);}
  else if(file_exists($urlImageJPG)==true)
  {unlink($urlImageJPG);}
  else if(file_exists($urlImagePNG)==true)
  {unlink($urlImagePNG);}
  
  $titleContentaux = addslashes($_POST['title']);
  $titleContent = stripslashes_deep ($titleContentaux, 1);
 
  $descContentaux = addslashes($_POST['description']);
  $descContent = stripslashes_deep ($descContentaux, 1);
 
  rename("../images/origGraphIns/".$_SESSION['filenameProfile']."temp".".".$_SESSION['extension'], "../images/origGraphIns/".$_SESSION['filenameProfile'].".".$_SESSION['extension']);
  $resizeObj = new resize("../images/origGraphIns/".$_SESSION['filenameProfile'].".".$_SESSION['extension']);
  $resizeObj -> resizeImage(430, 430, 'landscape');
  $resizeObj -> saveImage("../images/graphIns/".$_SESSION['filenameProfile'].".".$_SESSION['extension'], 100);
  
 
  $image = new Image(NULL,"../images/graphIns/".$_SESSION['filenameProfile'].".".$_SESSION['extension'],$titleContent,$descContent,0,$_SESSION['height'],"../images/origGraphIns/".$_SESSION['filenameProfile'].".".$_SESSION['extension'],$_SESSION['originalWidth'],$_SESSION['originalHeight'],NULL,$_POST['userId'],1);
  $result = $image->insert();

  if($result != false)
  {   
     $_SESSION['filenameProfile'] = '';
     echo $result;
  }
  else
  {
     echo 'NO';
  }
 }
 catch(Exception $e) 
 {
    echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
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