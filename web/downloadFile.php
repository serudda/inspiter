<?php
error_reporting(0);
require_once 'clases/Comment.php';
require_once 'clases/Session.php';
require_once 'clases/Token.php';
session_start();


if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}


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
  Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
  $token = getToken();
  //se inserta el token generado en la base
  $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
  $resultTokenOperation =  $resultToken->insertTokenOperation();
  if($resultTokenOperation != false)
  {
    $_SESSION['tokenId']=$resultTokenOperation;   
    if (!isset($_GET['imageFile']) || empty($_GET['imageFile']))
    {
    }
    $file = $_GET['imageFile'];
    $path = '../images/'.$file;
    $type = '';
 
    if (is_file($path)) 
    {
     $size = filesize($path);
     if (function_exists('mime_content_type')) 
     {
      $type = mime_content_type($path);
     }
     else if (function_exists('finfo_file')) 
     {
      $info = finfo_open(FILEINFO_MIME);
      $type = finfo_file($info, $path);
      finfo_close($info);
     }
     if ($type == '') 
     {
      $type = "application/force-download";
     }
     // Definir headers
     header("Content-Type: $type");
     header("Content-Disposition: attachment; filename=".$file);
     header("Content-Transfer-Encoding: binary");
     header("Content-Length: " . $size);
     // Descargar archivo
     readfile($path);
     header("location: ../main.php");
    }
    else
    {
      echo 'NO';
    }
  }
  else 
     echo 'NO';
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
