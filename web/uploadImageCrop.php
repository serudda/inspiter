<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
ini_set('memory_limit','1280000M');

session_start();
define("imagedirectory", '../images/graphIns/');

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
 { 
  if (isset($_SESSION['filenamePhraseGraphCrop']) && $_SESSION['filenamePhraseGraphCrop'] != '')
  {
   try
   { 
     $urlImagejpg = imagedirectory.$_SESSION['filenamePhraseGraphCrop']."temp.jpg";
     $urlImageJPG = imagedirectory.$_SESSION['filenamePhraseGraphCrop']."temp.JPG";     
     
     if(file_exists($urlImagejpg)==true)
     {unlink($urlImagejpg);}
     else if(file_exists($urlImageJPG)==true)
     {unlink($urlImageJPG);}
   }
   catch(Exception $e)
   {}
  }    
  $numeroRand = rand(1000,1000000000);
  $fileName = $_POST['userId'].'a'.$numeroRand.'temp.jpg';
  $targ_w = $targ_h = 600; 
  $jpeg_quality = 90; 

 try
 {
  $_SESSION['filenamePhraseGraphCrop'] = $fileName;
  $_SESSION['extension'] = 'jpg';
 
  $respuestaFile = 'done'; 
  $mensajeFile = $fileName;
  $img_r = imagecreatefromjpeg($_POST['fileOrigName']);//aqui guardo la imagen original
  $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );//aqui la redimensiono a 600x600
  imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);//aqui la creo pasandole todos los parametros
  imagejpeg($dst_r, imagedirectory.$fileName, $jpeg_quality);//aqui la guardo en el directorio con ext jpg                              
 }
 catch(Exception $e)
 {
     $respuestaFile = "error";
     $mensajeFile = $e->getMessage();     
 }
 $salidaJson = array("respuesta" => $respuestaFile,
   	             "mensaje" => $mensajeFile,
		     "fileName" => $fileName);
  echo json_encode($salidaJson);
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
