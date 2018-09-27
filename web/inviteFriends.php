<?php
error_reporting(0);
require_once("clases/User.php"); 
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
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{
 if(isset($_POST['IFuserId'])==true && isset($_POST['IFband'])==true)
 { 
    $userResult = User::UpdateStateInviteFriends($_POST['IFuserId'],$_POST['IFband']);
    if ($userResult == true)
	 echo 'YES';
	else
	 echo 'NO';
 }
 else
 if(isset($_GET['IFuserId'])==true && isset($_GET['IFband'])==true && isset($_GET['Iam'])==true)
 { 
    $userResult = User::UpdateStateInviteFriends($_GET['IFuserId'],$_GET['IFband']);
    $User1 = User::getUserById($_GET['IFuserId']);
    if($_GET['Iam'] == 'main')
      header("location:../main.php");
    else
      header("location:../".$User1->getUserLogin()); 
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