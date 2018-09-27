<?php
error_reporting(0);
require_once 'clases/Inspiter.php';
require_once 'clases/Session.php';
require_once 'clases/Token.php';
session_start();
header("Content-Type: text/html;charset=utf-8");

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

  if($_POST['noSession'] == "SI" || Session::checkSession($_SESSION['iduser']) != false)
  {
   if($_POST['noSession'] == "SI" || Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
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
      }
     }
     if($_POST['type'] == 'recientes' || $_POST['type'] == 'top' || $_POST['type'] == 'populares' 
        || $_POST['type'] == 'aleatorios' || $_POST['type'] == 'seguidores')
     {
      if(isset($_POST['sessionId'])==true && isset($_POST['type']) == true && isset($_POST['firstInspiterId'])==true)
      {
       if(isset($_POST['userId']) == true && $_POST['type'] == 'seguidores')
       {
          $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],$_POST['firstInspiterId'],$_POST['type'],0,0,$_POST['inspType']); 
       } 
       else
       {
         $inspiterJson = Inspiter::getInspiterData(0,$_POST['sessionId'],$_POST['firstInspiterId'],$_POST['type'],0,0,$_POST['inspType']); 
       }
       echo $inspiterJson; 
      }
      else if(isset($_POST['sessionId'])==true)
      {
       if(isset($_POST['userId'])== true)    
       {
        $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],0,$_POST['type'],0,0,$_POST['inspType']); 
       }
       else
       {
	$inspiterJson = Inspiter::getInspiterData(0,$_POST['sessionId'],0,$_POST['type'],0,0,$_POST['inspType']);  
       }
       echo $inspiterJson;
      }
     }
     else
     {
      if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && isset($_POST['firstInspiterId'])==true && (isset($_POST['type'])!=true || $_POST['type']!='favoritos'))
      {  
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],$_POST['firstInspiterId'],'perfil',0,0,$_POST['inspType']);
       echo $inspiterJson;
      }
      else if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && isset($_POST['inspiterId'])==true && (isset($_POST['type'])!=true || $_POST['type']!='favoritos')) //todas las inspiraciones perfil
      {
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],0,'perfil',$_POST['inspiterId'],0,$_POST['inspType']); 
       echo $inspiterJson;
      }
      else if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && isset($_POST['inspiterId']) && $_POST['type']=='favoritos' && isset($_POST['firstInspiterId'])!=true)
      {
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],0,'favoritos',$_POST['inspiterId'],0,$_POST['inspType']); 
       echo $inspiterJson;
      } 
      else if(isset($_POST['userId']) == true && isset($_POST['sessionId'])==true && $_POST['type']=='favoritos' && isset($_POST['firstInspiterId'])==true)
      {
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],$_POST['sessionId'],$_POST['firstInspiterId'],'favoritos',0,0,$_POST['inspType']);
       echo $inspiterJson;
      }
      else if(isset($_POST['userId']) == true && isset($_POST['inspiterId'])==true && $_POST['noSession'] == "SI") 
      {
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],0,0,'perfil',$_POST['inspiterId'],0,$_POST['inspType']); 
       echo $inspiterJson;
      }
      else if(isset($_POST['userId']) == true && $_POST['noSession'] == "SI" && isset($_POST['firstInspiterId'])==true) 
      {
       $inspiterJson = Inspiter::getInspiterData($_POST['userId'],0,$_POST['firstInspiterId'],'perfil',0,0,$_POST['inspType']); 
       echo $inspiterJson;
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
{
  echo 'NOSSID';
}
?> 
