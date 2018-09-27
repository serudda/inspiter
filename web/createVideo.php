<?php
error_reporting(0);
require_once 'clases/Video.php';
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
  //PARA IMAGENES INSPIRADORAS
  $urlImagejpg = "../images/origGraphIns/".$_SESSION['filenameProfile']."temp.jpg";
  $urlImagepng = "../images/origGraphIns/".$_SESSION['filenameProfile']."temp.png";
  $urlImageJPG = "../images/origGraphIns/".$_SESSION['filenameProfile']."temp.JPG";
  $urlImagePNG = "../images/origGraphIns/".$_SESSION['filenameProfile']."temp.PNG";
          
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
 
  rename("../images/videoImageIns/".$_SESSION['filenameVideo']."temp".".jpg", "../images/videoImageIns/".$_SESSION['filenameVideo'].".jpg");
  
  $video = new Video(NULL,$_SESSION['urlVideo'],$titleContent,$descContent,"../images/videoImageIns/".$_SESSION['filenameVideo'].".jpg",NULL,$_POST['userId'],1);
  $result = $video->insert();

  if($result != false)
  {   
     $_SESSION['filenameVideo'] = '';
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