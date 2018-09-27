<?php 
error_reporting(0);
require_once 'clases/Inspiter.php';
require_once 'clases/Session.php';
require_once 'clases/Image.php';
require_once 'clases/Video.php';
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
$inspiterId = $_POST['inspiterId'];
$userId = $_POST['userId'];
$inspType = $_POST['inspType'];

if($inspType == "image")
{
      $vUri = Image::getUriByInspiterId($inspiterId);
      $VUriOrig = Image::getOriginalUriByInspiterId($inspiterId);
      try 
      {
       unlink($vUri);
       unlink($VUriOrig);
      }
      catch(Exception $e)
      {echo $e->getMessage(); return;}
}
else if($inspType == "video")
{
      $vUri = Video::getURLImageByInspiterId($inspiterId);
      try 
      {
       unlink($vUri);
      }
      catch(Exception $e)
      {echo $e->getMessage(); return;}
}

$resultDelete = Inspiter::deleteInspiter($inspiterId,$userId,$inspType);

echo $resultDelete;
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