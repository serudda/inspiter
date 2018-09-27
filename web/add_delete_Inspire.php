<?php
error_reporting(0);
require_once("clases/Inspire.php"); 
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

if($_SESSION['tokenID'] == $_POST["tokenID"] && 
   (Session::checkUser($_SESSION['iduser'],$_POST['IuserId']) || (Session::checkUser($_SESSION['iduser'],$_POST['DuserId']))
   || Session::checkUser($_SESSION['iduser'],$_POST['userId'])))
{
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
     if(isset($_POST['IinspiterId'])==true && isset($_POST['IuserId'])==true)
     {
       $inspire1 = new Inspire(NULL,$_POST['IinspiterId'],$_POST['IuserId'],NULL);
       $resultadd = $inspire1->insert();
       echo $resultadd;
     }
     else if(isset($_POST['DinspiterId'])==true && isset($_POST['DuserId'])==true)
     {
	   $ResultDel = Inspire::delete($_POST['DinspiterId'],$_POST['DuserId']);
       if ($ResultDel == true)
	    echo 'YES';
	   else
	    echo 'NO';
     }
     else if(isset($_POST['inspiterId'])==true && isset($_POST['userId'])==true)
     {
	   $ResultGet = Inspire::getIfInspireInspiter($_POST['inspiterId'],$_POST['userId']);
	   if ($ResultGet == true)
	    echo 'YES';
	   else
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
}
else
  echo 'No esta autorizado para realizar la accion'; 
?>