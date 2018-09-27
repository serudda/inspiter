<?php 
error_reporting(0);
require_once 'clases/Favourite.php';
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
  $inspiterId = $_POST['inspiterId'];
  $userId   = $_POST['userId'];
  $favouriteObj = new Favourite(null,$userId,$inspiterId,null);
  $resultFavourite = $favouriteObj->addToFavourite();

  if ($resultFavourite == true)
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
