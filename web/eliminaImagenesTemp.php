<?php
error_reporting(0);
require_once 'clases/Inspiter.php';
require_once 'clases/Session.php';
require_once 'clases/Image.php';
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
  if(isset($_POST['username']) && $_POST['username'] != '')
  {
     //PARA IMAGENES DE PERFILES --> CONFIG
     $urlImagejpg = "../images/perfiles/data/".$_SESSION['filename'].".jpg";
     $urlImagepng = "../images/perfiles/data/".$_SESSION['filename'].".png";
     $urlImageJPG = "../images/perfiles/data/".$_SESSION['filename'].".JPG";
     $urlImagePNG = "../images/perfiles/data/".$_SESSION['filename'].".PNG";
          
     if(file_exists($urlImagejpg)==true)
     {unlink($urlImagejpg);}
     else if(file_exists($urlImagepng)==true)
     {unlink($urlImagepng);}
     else if(file_exists($urlImageJPG)==true)
     {unlink($urlImageJPG);}
     else if(file_exists($urlImagePNG)==true)
     {unlink($urlImagePNG);}
      
     
      //PARA IMAGENES DE LA PHRASE INSIGNIA --> CONFIG
     $urlImagejpg = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".jpg";
     $urlImagepng = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".png";
     $urlImageJPG = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".JPG";
     $urlImagePNG = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".PNG";
          
     if(file_exists($urlImagejpg)==true)
     {unlink($urlImagejpg);}
     else if(file_exists($urlImagepng)==true)
     {unlink($urlImagepng);}
     else if(file_exists($urlImageJPG)==true)
     {unlink($urlImageJPG);}
     else if(file_exists($urlImagePNG)==true)
     {unlink($urlImagePNG);}
  }
  else if(isset($_POST['FimageCut']) && isset($_POST['Fimage']))
  {
      //PARA INSPIRACIONES CREADAS COMO FRASES GRAFICAS EDITADAS POR EL USUARIO
      if($_POST['FimageCut'] == 1)
      {
        $urlImagejpg = "../images/graphIns/".$_SESSION['filenamePhraseGraphCrop'];
        $urlImageJPG = "../images/graphIns/".$_SESSION['filenamePhraseGraphCrop'];
        if(file_exists($urlImagejpg)==true)
        {unlink($urlImagejpg);}
        else if(file_exists($urlImageJPG)==true)
        {unlink($urlImageJPG);}
      }
      if($_POST['Fimage'] == 1)
      {
        $urlImagejpg = "../images/origGraphIns/".$_SESSION['filenamePhraseGraphOrig'].".jpg";
        $urlImageJPG = "../images/origGraphIns/".$_SESSION['filenamePhraseGraphOrig'].".JPG";
        if(file_exists($urlImagejpg)==true)
        {unlink($urlImagejpg);}
        else if(file_exists($urlImageJPG)==true)
        {unlink($urlImageJPG);}
      }
  }
  else
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
  }
 Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
 $token = getToken();
 //se inserta el token generado en la base
 $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
 $resultTokenOperation =  $resultToken->insertTokenOperation();
 if($resultTokenOperation != false)
 {
   $_SESSION['tokenId']=$resultTokenOperation;
  echo $_SESSION['nroTemp'];   
}
 else {
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
{
   echo 'NOSSID'; 
}
?>
