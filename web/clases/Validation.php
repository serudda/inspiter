<?php
require_once 'Database.php';
class Validation
{	

 public static function validateUsername($name){ 
     try
     {
     //NO cumple longitud minima  
     if(strlen($name) < 4)  
         return false;  
     // SI longitud, SI caracteres A-z  
     else  
       {
         $result1 = DataBase::ExecuteQuery("SELECT US_User_Login FROM ins_users_tb WHERE upper(US_User_Login) = upper('".$name."')");
         if(mysql_num_rows($result1) > 0){
           return false;
         } else{
           return true;
         }
       } 
       }
     catch(Exception $e)
     {
         return false;
     }
    }  
   
 public static function validatePassword($password){  
     try
     {
     //NO tiene minimo de 5 caracteres o mas de 12 caracteres  
     if(strlen($password) < 5)  
         return false;  
		 
     // SI rellenado,  
     else  
         return true;  
     }
     catch(Exception $e)
     {
         return false;
     }
 }  
   
 public static function validatePassword2($password1, $password2){
     try
     {
     //NO coinciden  
     if($password1 != $password2)  
         return false;  
     else  
         return true; 
     }
     catch(Exception $e)
     {
         return false;
     }
 }  
   
 public static function validateEmail($email){  
     try
     {
     //NO hay nada escrito  
     if(strlen($email) == 0)  
         return false;  
     // SI escrito, NO VALIDO email  
     else if(!filter_var($email, FILTER_SANITIZE_EMAIL))  
         return false;  
     // SI rellenado, SI email valido  
     else  
         {
             $result2 = Database::ExecuteQuery("SELECT US_Email FROM ins_users_tb WHERE upper(US_Email) =upper('".$email."')");
             if(mysql_num_rows($result2) > 0){
             return false;
             } else{
				 return true;
              }
          }
         }
     catch(Exception $e)
     {
         return false;
     }
   }
 public static function validateFacebookId($faceid){ 
     try
     {
     //si es nulo  
     if($faceid == NULL)  
         return false;  
     else  
         {    //si ya existe el faceid cargado
             $result2 = Database::ExecuteQuery("SELECT US_Face_Id FROM ins_users_tb WHERE US_Face_Id = '".$faceid."'");
             /*if(mysql_num_rows($result2) > 0){
             return false; //existe faceid
             } else{
		return true; //no existe faceid
              }*/
             return mysql_num_rows($result2)+1;
          } 
        }
     catch(Exception $e)
     {
         return false;
     }
   }
    
 public static function validateCity($myCity){
      try
     {
     if(($myCity == '') || (strlen($myCity) == 0) || (strlen($myCity) > 25)) 
         return false;    
     else  
         return true;  
     }
     catch(Exception $e)
     {
         return false;
     }
 }
 
public static function validateFullName($myFullName){
     try
     {
     if(($myFullName == '') || (strlen($myFullName) == 0)|| (strlen($myFullName) > 19)) 
         return false;    
     else  
         return true;  
     }
     catch(Exception $e)
     {
         return false;
     }
}
}
?>