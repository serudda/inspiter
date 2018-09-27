<?php
error_reporting(0);
require_once 'clases/Database.php';
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
  if(isset($_POST['buscarpalabra'])){
    
    
    $query1 = $_POST['buscarpalabra'];
    $queryContent = addslashes($query1);
    $queryfinalComment1 = stripslashes_deep ($queryContent, 1);
    $query = strip_tags($queryfinalComment1);
    $mysql_query = DataBase::ExecuteQuery("SELECT ins_users_tb.US_User_Id, ins_users_tb.US_User_Login, ins_users_tb.US_Full_Name, ins_users_tb.US_Photo_Small, ins_users_tb.US_City
FROM ins_users_tb
WHERE (ins_users_tb.US_Full_Name like '%$query%' or US_User_Login like '$query%') LIMIT 6");

  $jsondata = array(); 
  $i = mysql_num_rows($mysql_query)-1; //0
  while ($row = mysql_fetch_assoc($mysql_query)) 
  { 
    $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
    $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
    $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
    $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
    $jsondata[$i]['US_City'] = $row['US_City']; 
    $i--; 
  } 
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
    'NO';
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
