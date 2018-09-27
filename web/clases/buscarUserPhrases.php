<?php
require_once 'Database.php';

class SearchUser
{
  
   public static function BuscarUsuarios($NombreUsuarios)
   {//CONCAT(US_User_Id,'-',US_Full_Name)  US_User_Search 
    try
    {
     $result = DataBase::ExecuteQuery("SELECT US_Full_Name,US_User_Id FROM ins_users_tb 
                WHERE US_Full_Name like '%$NombreUsuarios%'");	
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
	 {
       $datos[] = array("value" => $row['US_Full_Name']);     
	   $datos[] = array("id" => $row['US_User_Id']);      
     }  
     return $datos;   
   }
     catch(Exception $e)
     {
         return false;
     }
}
}
?>
