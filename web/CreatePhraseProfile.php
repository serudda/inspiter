<?php
error_reporting(0);
require_once 'clases/Phrase.php';
require_once 'clases/Session.php';
require_once 'clases/Token.php';
session_start();

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}    
    

function stripslashes_deep ($text, $times) {
    
    $i = 0;
    while (strstr($text, '\\') && $i != $times) {
        
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
 
 $praseContent  = addslashes($_POST['frase']);
 $praseContent1 = stripslashes_deep ($praseContent, 1);
 $praseContent2 = strip_tags($praseContent1);
 $phrase = new Phrase(NULL,$praseContent2,$_POST['author'],1,NULL,$_POST['user'],1);
 $result = $phrase->insert();

 if($result != false)
 {   
    Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
    $token = getToken();
    //se inserta el token generado en la base
    $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
    $resultTokenOperation =  $resultToken->insertTokenOperation();
    if($resultTokenOperation != false)
    {
      $_SESSION['tokenId']=$resultTokenOperation;  
      echo $result;
    }
    else
    {
     echo 'NO';
    }
 }
 else
 {
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