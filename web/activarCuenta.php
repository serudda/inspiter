<?php
error_reporting(0);
require_once 'clases/User.php';
require_once 'clases/Token.php';
require_once 'clases/Session.php';
session_start();
$url = '/index.php?account';

if(isset($_GET['uid']) && isset($_GET['token']))
{
   $myToken = $_GET['token'];
   $User1 = User::getUserByToken($myToken);
   if($User1->getUserId() != NULL &&  $User1->getUserId() != '')
   {
       $emailAC = $User1->getEmail();
       $resultToken = Token::deleteToken($emailAC, 'account'); 
       
       
       if($resultToken != false)
       {
          $resultActivate = User::UpdateActivateUser($User1->getUserId());
          if($resultActivate != false)
              header("location:".$url."=activate"); //TODO SERGIO TEENS Q LEER EL PARAEMTRO ACCOUNT = activate para mostrar un mensaje que diga que la cuenta ha sido activada
          else
              header("location:".$url."=errorActivate"); 
       }
       else 
          header("location:".$url."=errorToken");
    } 
    else
       {header("location:".$url."=error");}
}
 else
   {header("location:".$url."=GenericError");}
?>
