<?php 
error_reporting(0);
require_once 'clases/Inspiter.php';
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
if(Session::checkSession($_SESSION['iduser']) != false)
{
 if(isset($_POST['sessionId'])==true && isset($_POST['type']) == true && 
    isset($_POST['firstInspiterId'])==true && isset($_POST['searchWord'])==true)
 {
    $frasesJson = Inspiter::getInspiterData(0,$_POST['sessionId'],$_POST['firstInspiterId'],$_POST['type'],0,$_POST['searchWord'],"all"); 
    echo $frasesJson;
 }
 else if(isset($_POST['sessionId'])==true && isset($_POST['type']) == true && isset($_POST['searchWord'])==true)
 {
    if($_POST['type'] != 'personas')
    {
      if($_POST['section'] == 'visual')
      {
	 if($_POST['type'] == 'autores')
         {
	    $frasesJson = Inspiter::getAuthorDataVisual($_POST['searchWord']);
	    echo $frasesJson;					 
	 }
         else
         {
	    $frasesJson = Inspiter::getInspiterDataVisual(0,$_POST['sessionId'],0,$_POST['type'],0,$_POST['searchWord']);
	    echo $frasesJson;
         }
       }
       else
       {
         $frasesJson = Inspiter::getInspiterData(0,$_POST['sessionId'],0,$_POST['type'],0,$_POST['searchWord'], "all");
         echo $frasesJson;
       }
     }
     else 
     {
	if($_POST['section'] == 'visual')
	{
          $usersJson = User::getUserDataVisual(0,$_POST['sessionId'],$_POST['searchWord']);
          echo $usersJson;
	}
	else
	{
          $usersJson = User::getUserData(0,$_POST['sessionId'],$_POST['searchWord']);
          echo $usersJson;
        }
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
