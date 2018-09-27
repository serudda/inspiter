<?php 
error_reporting(0);
require_once 'clases/User.php';

$email = $_POST['email'];
$resultMail = User::existMail($email);

if ($resultMail != false)
{
    echo $resultMail;
}
else 
  echo 'NO';
?> 
