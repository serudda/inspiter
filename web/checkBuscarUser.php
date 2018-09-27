<?php
error_reporting(0);
session_start();
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
  if(isset($_POST['IdUserPage'])== true && $_POST['IdUserPage'] != null && $_POST['IdUserPage'] != '')
  {
      $user = $_POST['IdUserPage'];
				header("Location:$user");
      }
			else if(isset($_POST['PhraseField'])== true && $_POST['PhraseField'] != null && $_POST['PhraseField'] != '')
			{
				$PhraseUrl = $_POST['PhraseField'];
				header("Location:$PhraseUrl");
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
