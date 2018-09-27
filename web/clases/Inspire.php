<?php
require_once 'Database.php';
class Inspire
{
 private $inspireId;
 private $inspiterId;
 private $userInspire;
 private $dateInspire;
 
 public function Inspire($inspireId=NULL,$inspiterId=NULL,$userInspire=NULL,$dateInspire=NULL)
 {
  $this->inspireId = $inspireId;
  $this->inspiterId = $inspiterId;
  $this->userInspire = $userInspire;
  $this->dateInspire = $dateInspire;
 }
 
 //getter
 public function getInspireId()
 {return $this->inspireId;}
 
 public function getInspiterId()
 {return $this->inspiterId;}
 
 public function getUserInspire()
 {return $this->userInspire;}
 
 public function getDateInspire()
 {return $this->dateInspire;}
 
 //setter
 public function setInspireId($inspireId)
 {$this->inspireId = $inspireId;}
  
 public function setInspiterId($inspiterId)
  {$this->inspiterId = $inspiterId;}
  
 public function setUserInspire($userInspire)
 {$this->userInspire = $userInspire;}
  
 public function setDateInspire($dateInspire)
  {$this->dateInspire = $dateInspire;}


public function insert()
 {
      try
      {
	DataBase::ExecuteQuery("CALL INSERT_INSPIRATION('".$this->getInspiterId()."','".$this->getUserInspire()."',@Output,@inspireId);");	
	
	 $result = DataBase::ExecuteQuery("select @Output,@inspireId");
	 $OutputResult = mysql_fetch_row($result);
	
	 if($OutputResult[0] == 'true')
	 {
		 return $OutputResult[1];
	 }
	 else 
	 {
		 return false;
	 }
         }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 
public static function getInspire($ssid)
{   
    try
    {
    //col0           col1           col2             col3                   	                   
  $query = "SELECT `IN_Inspire_id`,`IN_Inspiter_id`,`IN_Inspire_User`,`IN_CreateDate`,US_User_Login,US_Full_Name,US_Photo_Small,US_City
	FROM ins_session_tb, ins_inspire_tb, ins_users_tb
	WHERE SS_USER_ID = US_User_Id 
	AND (SS_SSID='".$ssid."')";

	$result = DataBase::ExecuteQuery($query);
    $jsondata = array(); 
    $i = mysql_num_rows($result)-1; //0
    while ($row = mysql_fetch_assoc($result)) 
    { 
	 $jsondata[$i]['IN_Inspire_id'] = $row['IN_Inspire_id']; 
         $jsondata[$i]['IN_Inspiter_id'] = $row['IN_Inspiter_id']; 
	 $jsondata[$i]['IN_Inspire_User'] = $row['IN_Inspire_User']; 
	 $jsondata[$i]['IN_CreateDate'] = $row['IN_CreateDate']; 
	 $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
         $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
	 $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
	 $jsondata[$i]['US_City'] = $row['US_City']; 
	 $i--; 
    }  
    $jsondata = array_reverse($jsondata);
  return json_encode($jsondata);
  }
     catch(Exception $e)
     {
         return false;
     }
}


public static function delete($p_IN_Inspiter_id,$p_IN_Inspire_User)
{
    try
    {
   DataBase::ExecuteQuery("CALL DELETE_INPITARION('".$p_IN_Inspiter_id."','".$p_IN_Inspire_User."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputResult = mysql_fetch_row($result);
   if($OutputResult[0] == 'true')
   {
	  return true;
   }
   else 
   {
	  return false;
    }
    }
     catch(Exception $e)
     {
         return false;
     }
}
 
public static function getIfInspireInspiter($inspiterId,$userId) 
{
    try
    {
  	$query = "SELECT IN_Inspiter_Id
	FROM ins_inspire_tb
	WHERE IN_Inspiter_Id = ".$inspiterId. 
	" AND IN_Inspire_User='".$userId;
	
	$result = DataBase::ExecuteQuery($query);
	if ($result != NULL	)
	{ $i = mysql_num_rows($result); }
	else
	{ $i = 0; }
	 if($i > 0)
	 {
		 return true;
	 }
	 else 
	 {
		 return false;
	 }
       }
     catch(Exception $e)
     {
         return false;
     }
}

public static function getAmountInspireFriend($userId) 
{
  try
  {	
   $query = "SELECT IN_Inspire_id
             FROM   ins_users_tb,ins_inspire_tb
             WHERE  US_User_Id = IN_Inspire_User
             AND    US_User_Id =".$userId;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    } 
}

}
?>