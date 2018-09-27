<?php 
error_reporting(0);
require_once 'clases/Dedication.php';
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
 if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && isset($_POST['firstInspiterId'])==true)
 {
   $frasesJson = Dedication::getDedicationData($_POST['userId'],$_POST['sessionId'],$_POST['firstInspiterId']);
   echo $frasesJson;
 }
 else if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && isset($_POST['dedicId'])==true)
 {
   $frasesJson = Dedication::getDedicationData($_POST['userId'],$_POST['sessionId'],$_POST['dedicId']); 
   echo $frasesJson;
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
