<?php
error_reporting(0);
require_once 'clases/Database.php';
require_once 'clases/Session.php';
require_once 'clases/Token.php';
session_start();

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

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1 || $_POST['noSession'] == "SI")
{
 if((isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false) || $_POST['noSession'] == "SI")
 {
  if(isset($_POST['IdInspiter']))
  {
    $query = $_POST['IdInspiter'];
    $mysql_query = DataBase::ExecuteQuery("SELECT US_User_Id,US_User_Login,US_Full_Name,US_Photo_Small,IN_Inspire_id, IN_CreateDate FROM ins_inspire_tb, ins_users_tb WHERE IN_inspire_User = US_User_Id AND IN_Inspiter_id ='$query' ORDER BY IN_CreateDate DESC");                  
    $jsondata = array(); 
    $i = mysql_num_rows($mysql_query)-1; //0
    while ($row = mysql_fetch_assoc($mysql_query)) 
    { 
      $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
      $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
      $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
      $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
      $jsondata[$i]['IN_Inspire_id'] = $row['IN_Inspire_id'];
      $i--; 
     }
     
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
       echo json_encode($jsondata);
       }
       else
         echo 'NO';
     }
     else
       echo json_encode($jsondata);
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
{
    echo 'NOSSID';
}

?>