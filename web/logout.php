<?php 
error_reporting(0);
require_once 'clases/Database.php';
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
 if(isset($_SESSION['iduser'])==true && $_GET['sessionId'] == $_SESSION['iduser'])
 {
   Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
   header("location: http://www.inspiter.com?logout=ok&activate=si&uid=Y");
 }
 else
 {
   Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
   header("location: http://www.inspiter.com?logout=ok&activate=si&uid=Y");
 }
}
else
{
  Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
  header("location: http://www.inspiter.com?logout=ok&activate=si&uid=Y");
}
?>