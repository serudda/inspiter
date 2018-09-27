<?php 
error_reporting(0);
require_once 'clases/Comment.php';
require_once 'clases/Session.php';
require_once 'clases/Token.php';
session_start();

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}


function stripslashes_deep ($text, $times) {
    
    $i = 0;
    
    // loop will execute $times times.
    while (strstr($text, '\\') && $i != $times) {
        
        $text= stripslashes($text);
        $i++;
    }
    return $text;
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
 {
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
 }
 if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
 {
  $inspiterId = $_POST['inspiterId'];
  $userId   = $_POST['userId'];
  $commentContent = addslashes($_POST['comment']);
  $finalComment1 = stripslashes_deep ($commentContent, 1);
  $finalComment = strip_tags($finalComment1);
  $commentObj = new Comment(NULL,$inspiterId,$userId,$finalComment,NULL);
  $resultComment = $commentObj->insertComment();
  if ($resultComment != false)
   {
    Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
    $token = getToken();
    //se inserta el token generado en la base
    $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
    $resultTokenOperation =  $resultToken->insertTokenOperation();
    if($resultTokenOperation != false)
    {
      $_SESSION['tokenId']=$resultTokenOperation;     
      echo trim($resultComment);
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