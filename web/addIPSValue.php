<?php
error_reporting(0);
require_once 'clases/User.php';
require_once 'clases/Config.php';
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
  
  $type = $_POST['type']; 
  $inspiterId = $_POST['inspiterId'];
  
  if ($inspiterId == 0)
  {
      $userId = $_POST['userId'];
  }
  else
  {
      $userId = User::getUserIdByInspiterId($inspiterId);
  }
  $configIPS = Config::addConfigValue($userId,$type);
  if ($configIPS == true)
  {
    Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
    $token = getToken();
    //se inserta el token generado en la base
    $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
    $resultTokenOperation =  $resultToken->insertTokenOperation();
    if($resultTokenOperation != false)
    {
      $_SESSION['tokenId']=$resultTokenOperation;      
      echo 'YES';
    }
    else 
      echo 'NO';    
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
