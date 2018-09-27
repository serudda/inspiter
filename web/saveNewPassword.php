<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/Validation.php';
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
 if(isset($_POST['vPasswordOld'])==true && isset($_POST['vPasswordNew'])==true &&  isset($_POST['vPasswordReNew'])==true)
 {
   if((($_POST['vPasswordOld'] != '' || $_POST['vPasswordOld'] != NULL) && ($_POST['vPasswordNew'] != '' || $_POST['vPasswordNew'] != NULL) && ($_POST['vPasswordReNew'] != '' || $_POST['vPasswordReNew'] != NULL)  && $_POST['vPasswordNew'] == $_POST['vPasswordReNew']) || 
      (($_POST['vPasswordOld']=='' || $_POST['vPasswordOld'] == NULL) && ($_POST['vPasswordNew']=='' || $_POST['vPasswordNew'] == NULL) && ($_POST['vPasswordReNew']=='' || $_POST['vPasswordReNew'] == NULL)))
   {
    if(($_POST['vPasswordOld']=='' && $_POST['vPasswordNew']=='' && $_POST['vPasswordReNew']=='') || Validation::validatePassword($_POST['vPasswordNew'])==true)
    {
        if($_POST['vPasswordOld']!='' || $_POST['vPasswordNew']!='' || $_POST['vPasswordReNew']!='')
        {
            $userUpdate = User::updatePasswordConfig($_POST['pUserId'],$_POST['vPasswordOld'],$_POST['vPasswordNew'],$_POST['vPasswordReNew']);        
            if ($userUpdate == true)
            {
              echo 'YES';
            }
            else
            {
             echo 'BADPASS1';
            }
        }
        else
          echo 'YESNO';
    }
 else
   echo 'BADPASS2';
   }
    else
      echo 'BADPASS3';
 }
  else
     echo 'BADPASS4';
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
