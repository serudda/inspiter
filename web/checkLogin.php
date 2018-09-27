<?php
error_reporting(0);
session_start();
include_once("clases/Login.php");
if(isset($_POST['iniciar-sesion']))
{// username and password sent from form 
if(isset($_POST['log-username'])== true && isset($_POST['log-password'])== true)
{
	$myusername=$_POST['log-username']; 
	$mypasswordMD5NO=$_POST['log-password']; 
        
        $mypassword = md5($mypasswordMD5NO);      
}	
else
{
	$myusername=NULL;
	$mypassword=NULL;
}
/*if(isset($_POST['rememberme']))
{$rememberMe=$_POST['rememberme'];}*/


if(($myusername == NULL || $myusername == '') && ($mypassword ==NULL || $mypassword==''))
{ 
  header("Location:../index.php?errorValidacion=true"); 
}
else
{
  $login=new Login();
  $login->startLogin(3600,$myusername,$mypassword);
  //$_SESSION['vRememberme'] = $rememberMe;
}
}
else
{ 
  $myfaceid = NULL;
  if(isset($_GET['faceid']))
  {
   $myfaceid = $_GET['faceid'];
   $login=new Login();
   $login->startLoginFacebook($myfaceid);
  }
  else if(isset($_GET['profile']))
  {
     $login=new Login();
	 $login->startLogin();
  }
  else
  {
      header("Location:../"); 
  }
}
?>