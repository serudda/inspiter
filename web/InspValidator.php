<?php
error_reporting(0);
require_once 'clases/Validation.php';

if(isset($_POST['userName'])) 
{
 $username = $_POST['userName'];	
 if(Validation::validateUsername($username) == true)
 echo "YES";
 else
 echo "NO";
}
else
{
 if(isset($_POST['email']))
 {
   $email=$_POST['email'];
   if(Validation::validateEmail($email) == true)
    echo "YES";
   else
    echo "NO";
 }
 else
 if(isset($_POST['faceid']))
 {
	$fid= $_POST['faceid'];
	if(Validation::validateFacebookId($fid) == false || Validation::validateFacebookId($fid) > 1)
     echo "NO"; //existe faceid
    else
     echo "YES"; //no existe faceid
 }
}

?>