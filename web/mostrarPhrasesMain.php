<?php 
error_reporting(0);
require_once 'clases/Inspiter.php';
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
if(Session::checkSession($_SESSION['iduser']) != false)
{
 if(isset($_GET['sessionId'])==true && isset($_GET['type']) == true && isset($_GET['firstInspiterId'])==true)
 {
    if(isset($_GET['userId']) == true && $_GET['type'] == 'seguidores')
    {
        $inspiterJson = Inspiter::getInspiterData($_GET['userId'],$_GET['sessionId'],$_GET['firstInspiterId'],$_GET['type'],0,0,$_GET['inspType']); 
    } 
    else
    {
         $inspiterJson = Inspiter::getInspiterData(0,$_GET['sessionId'],$_GET['firstInspiterId'],$_GET['type'],0,0,$_GET['inspType']); 
    }
   echo $inspiterJson; 
 }
 else if(isset($_GET['sessionId'])==true)
 {
     if(isset($_GET['userId'])== true)    
     {
        $inspiterJson = Inspiter::getInspiterData($_GET['userId'],$_GET['sessionId'],0,$_GET['type'],0,0,$_GET['inspType']); 
     }
     else
     {
	$inspiterJson = Inspiter::getInspiterData(0,$_GET['sessionId'],0,$_GET['type'],0,0,$_GET['inspType']);  
     
     }
     echo $inspiterJson;
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
