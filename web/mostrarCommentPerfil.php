<?php 
error_reporting(0);
require_once 'clases/Comment.php';
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

if($_POST['noSession'] == "SI" || Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(Session::checkSession($_SESSION['iduser']) != false || $_POST['noSession'] == "SI")
 {
  if(Session::checkSession($_SESSION['iduser']) != false)
  {
   Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
   $token = getToken();
   //se inserta el token generado en la base
   $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
   $resultTokenOperation =  $resultToken->insertTokenOperation();
   if($resultTokenOperation != false)
   {
    $_SESSION['tokenId']=$resultTokenOperation;
    if(isset($_POST['sessionId']) == true && isset($_POST['inspiterId'])==true)
    {
     $CommentJson = Comment::getCommentData($_POST['sessionId'],$_POST['inspiterId']);
     echo $CommentJson;
    }
    else if(isset($_POST['inspiterId'])==true)
    {
     $CommentJson = Comment::getCommentData(0,$_POST['inspiterId']);
     echo $CommentJson;
    }
   }
   else
      echo 'NO';
  }
  else
  {
    if(isset($_POST['inspiterId'])==true)
    {
     $CommentJson = Comment::getCommentData(0,$_POST['inspiterId']);
     echo $CommentJson;
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
    echo 'NO';
?> 
