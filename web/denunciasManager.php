<?php 
error_reporting(0);
require_once 'clases/Denunciation.php';
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
  if($_POST['accuserId'] != '0' && $_POST['userId'] != '0'
     && $_POST['inspiterId'] != '0' && $_POST['commentId'] == '0')
  {
      //denuncia inspiracion
      $denunciationId=NULL;
      $accuserId=$_POST['accuserId'];
      $userId=$_POST['userId'];
      $inspiterId=$_POST['inspiterId'];
      $commentId=$_POST['commentId'];
      $motive=$_POST['motive'];
      $denuncationDate=NULL;
      
      $denunciationObj = new Denunciation($denunciationId,$accuserId,$userId,$inspiterId,$commentId,$motive,$denuncationDate);
      $resultDenunciation = $denunciationObj ->insertDenunciation();

      if ($resultDenunciation != false)
        echo 'YES';
      else 
        echo 'NO';
  }
  else
     if($_POST['accuserId'] != '0' && $_POST['userId'] != '0'
     && $_POST['inspiterId'] != '0' && $_POST['commentId'] != '0')
     {   //denuncia comentario
         $denunciationId=NULL;
         $accuserId=$_POST['accuserId'];
         $userId=$_POST['userId'];
         $inspiterId=$_POST['inspiterId'];
         $commentId=$_POST['commentId'];
         $motive=$_POST['motive'];
         $denuncationDate=NULL;
      
         $denunciationObj = new Denunciation($denunciationId,$accuserId,$userId,$inspiterId,$commentId,$motive,$denuncationDate);
         $resultDenunciation = $denunciationObj ->insertDenunciation();

         if ($resultDenunciation != false)
            echo 'YES';
         else 
            echo 'NO';
     }
     else if($_POST['accuserId'] != '0' && $_POST['userId'] != '0')
     {
         $denunciationId=NULL;
         $accuserId=$_POST['accuserId'];
         $userId=$_POST['userId'];
         $motive='';
         $denuncationDate=NULL;
      
         $denunciationObj = new Denunciation($denunciationId,$accuserId,$userId,0,0,$motive,$denuncationDate);
         $resultDenunciation = $denunciationObj ->insertDenunciation();

         if ($resultDenunciation != false)
            echo 'YES';
         else 
            echo 'NO';
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