<?php
error_reporting(0);
require_once("clases/Follow.php"); 
require_once("clases/Config.php"); 
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

if($_SESSION['tokenID'] == $_POST("tokenID") && Session::checkUser($_SESSION['iduser'],$_POST['seUserId']))
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
   
   //seguidores
   if(isset($_POST['seSessionId'])==true && isset($_POST['seFirstPhraseId'])==true)
   {
     $followSegJson = Follow::getSeguidoresData($_POST['seUserId'],$_SESSION['iduser']);
     echo $followSegJson;
   }
   else if(isset($_POST['seSessionId'])==true)
   {
     $followSegJson = Follow::getSeguidoresData($_POST['seUserId'],$_SESSION['iduser']);
      echo $followSegJson;
   }

   //siguiendo
   if(isset($_POST['siSessionId'])==true && isset($_POST['siFirstPhraseId'])==true)
   {
     $followSigJson = Follow::getSiguiendoData($_POST['siUserId'],$_SESSION['iduser']);
     echo $followSigJson;
   }
   else if(isset($_POST['siSessionId'])==true)
   {
     $followSigJson = Follow::getSiguiendoData($_POST['siUserId'],$_SESSION['iduser']);
     echo $followSigJson;
   }

   //seguir
   if(isset($_POST['FdadId'])==true && isset($_POST['FsunId'])==true)
   {
     if($_POST['FdadId']!=$_POST['FsunId'])
     {
        $follow1 = new Follow($_POST['FdadId'],$_POST['FsunId'],NULL);
	    $followUser = $follow1->startToFollow();
        if ($followUser == true)
        {
          $resultAmount = Config::insertFollowAmount($_POST['FsunId']);
          if(isset($_POST['FcantFollow']))
             echo $resultAmount;
          else
             echo 'YES';
        }
	    else
	        echo 'NO';
      }
      else
         echo 'NO';
    }
    //dejar de seguir
    else
     if(isset($_POST['LFdadId'])==true && isset($_POST['LFsunId'])==true)
     {
       if($_POST['LFdadId']!=$_POST['LFsunId'])
       {
	 $LeaveFollowUser = Follow::leaveToFollow($_POST['LFdadId'],$_POST['LFsunId']);
         if ($LeaveFollowUser == true)
         {
           $resultAmount = Config::insertFollowAmount($_POST['LFsunId']);
           if(isset($_POST['LFcantFollow']))
              echo $resultAmount;
           else
              echo 'YES';
         }
	     else
            echo 'NO';
       } 
       else
          echo 'NO';
     }
     else
      if(isset($_POST['pDadId'])==true && isset($_POST['pSunId'])==true && isset($_POST['type'])==true)
      {
	$FollowUser = Follow::getFollowUserFlag($_POST['pDadId'],$_POST['pSunId']);
        if ($FollowUser == true)
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
    echo 'No esta autorizado para realizar esta accion'; 
?>