<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/Config.php';
require_once 'clases/Validation.php';
require_once 'clases/resize-class.php';
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
 try 
 {
  if(isset($_POST['vUserId']) &&  isset($_POST['vName'])==true &&
    isset($_POST['vCity'])==true &&  isset($_POST['vAboutYou'])==true &&
    isset($_POST['vIdentPhrase'])==true &&  isset($_POST['vWebSite'])==true && isset($_POST['vUsername'])==true &&
    $_POST['vUserId'] != '' && $_POST['vName'] != '' && $_POST['vCity'] != '')
    {
     if(Validation::validateFullName($_POST['vName'])==true)
     {
       if(Validation::validateCity($_POST['vCity'])==true)
       {
          $perfilPhoto='';
          if (!empty($_SESSION['filename']))
          {
              $urlImagejpg = "../images/perfiles/data/".$_SESSION['filename'].".jpg";
              $urlImageJPG = "../images/perfiles/data/".$_SESSION['filename'].".JPG";
              if(file_exists($urlImagejpg)==true) 
              {$perfilPhoto= $_SESSION['filename'].".jpg";}
              else if(file_exists($urlImageJPG)==true)
              {$perfilPhoto= $_SESSION['filename'].".JPG";}
              
              $vUser = User::getUserFriend($_POST['vUserId']);
              try 
              {
                unlink($vUser->getPhoto());
                unlink($vUser->getPhotoSmall());
              }
              catch(Exception $e)
              {echo $e->getMessage();}
          }
          else
          {$perfilPhoto='';}  
          
          $perfilImagePhrase ='';
          if (!empty($_POST['vImagePredef']) && $_POST['vImagePredef']!= "")
          {
              $perfilImagePhrase= $_POST['vImagePredef'];
          }
          else 
          if (!empty($_SESSION['filenamePhIm']))
          {
              $urlImagejpg = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".jpg";
              $urlImageJPG = "../images/PhraseIns/".$_SESSION['filenamePhIm'].".JPG";
              if(file_exists($urlImagejpg)==true) 
              {$perfilImagePhrase= $_SESSION['filenamePhIm'].".jpg";}
              else if(file_exists($urlImageJPG)==true)
              {$perfilImagePhrase= $_SESSION['filenamePhIm'].".JPG";} 
              
              $vUriImagePhrase1 = Config::getImagePhraseUri($_POST['vUserId']);
               try 
               {
                 unlink($vUriImagePhrase1);
               }
              catch(Exception $e)
              {echo 'error';}
          }
          else  
          {$perfilImagePhrase='';} 
         
          $arrayStyleJson = '';
          if (!empty($_POST['vStyle']) && isset($_POST['vStyle']) && $_POST['vStyle'] != null && $_POST['vStyle'] != '')
          {$arrayStyleJson = json_encode($_POST['vStyle']);}
          else
          {$arrayStyleJson = '';} 

        $userUpdate = User::UpdateUser($_POST['vUserId'],$_POST['vName'],$_POST['vCity'],$perfilPhoto,$_POST['vAboutYou'],$_POST['vIdentPhrase'],$perfilImagePhrase,$_POST['vWebSite'],$_POST['vAuhor'],$arrayStyleJson); 
        if ($userUpdate == true)
        {
            if($_POST['vUsername'] != '' && $_SESSION['filename'] != '')
            {
              $urlImageOrigjpg = "../images/perfiles/data/".$_SESSION['filename'].".jpg";
              $urlImageOrigJPG = "../images/perfiles/data/".$_SESSION['filename'].".JPG";
              
              if(file_exists($urlImageOrigjpg)==true) 
              {
                 $resizeObj = new resize($urlImageOrigjpg);
                 $resizeObj -> resizeImage(50, 50, 'crop');
                 $urlImageOrigSmall = "../images/perfiles/smallMenu/".$_SESSION['filename'].".jpg";
                 $resizeObj -> saveImage($urlImageOrigSmall, 100);
              }
              else if(file_exists($urlImageOrigJPG)==true) 
              {
                 $resizeObj = new resize($urlImageOrigJPG);
                 $resizeObj -> resizeImage(50, 50, 'crop');
                 $urlImageOrigSmall = "../images/perfiles/smallMenu/".$_SESSION['filename'].".JPG";
                 $resizeObj -> saveImage($urlImageOrigSmall, 100);
              }
            }
            $_SESSION['filename'] = '';
            $_SESSION['filenamePhIm'] = '';
            echo 'YES';
            
        }
        else
          echo 'NO1';
       }
       else
         echo 'BAD_LOCATION'; 
     }
     else
         echo 'BAD_FULL_NAME'; 
    }
    else
       echo 'NO2';
 }
 catch(Exception $e)
 {echo $e->getMessage();}
 

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
