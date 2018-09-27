<?php 
error_reporting(0);
require_once 'clases/Session.php';
session_start();

if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}

if(Session::checkSession($_SESSION['iduser']) != false)
{
  echo 'YES';
}
else
{
    echo 'NOSSID';
    header("location: ../index.php?logout=ok&activate=si&uid=Y");
}
?> 
