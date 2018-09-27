<?php
require_once 'Database.php';

class Session
{ 
 private $ssid;
 private $userLogin; //puede ser mail o username
 private $startDate;
 private $expireDate;
 
 public function Session($ssid=NULL,$userLogin=NULL,$startDate=NULL,$expireDate=NULL)
 {
   $this->ssid = $ssid;
   $this->userLogin = $userLogin;
   $this->startDate = $startDate;
   $this->expireDate = $expireDate;
 }
 
 //getter
 public function getSsid()
 {return $this->ssid;}
 
 public function getUserLogin()
 {return $this->userLogin;} 
 
 public function getStartDate()
 {return $this->startDate;}
 
 public function getExpireDate()
 {return $this->expireDate;}
 
 //setter
  public function setSsid($ssid)
 { $this->ssid = $ssid;}
 
  public function setUserLogin($userLogin)
 { $this->userLogin = $userLogin;}
 
 public function setStartDate($startDate)
 { $this->startDate = $startDate;}
 
  public function setExpireDate($expireDate)
 { $this->expireDate = $expireDate;}
 
 
 public function create()
 {
     try
     {
    DataBase::ExecuteQuery("CALL CREATE_SSID('".$this->getUserLogin()."',@OUTPUT,@SSID)");
	$result = DataBase::ExecuteQuery("select @OUTPUT,@SSID");
	$ResultSessionId = mysql_fetch_row($result);
	if($ResultSessionId[0] != 'false')
	  return $ResultSessionId[1];
	else
	  return false;
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 public static function delete($ssid)
 {
     try
     {
	DataBase::ExecuteQuery("CALL KILL_SSID('".$ssid."',@A)");
	$result = DataBase::ExecuteQuery("select @A");
	$resultDelete = mysql_fetch_row($result);
	if($resultDelete[0] != 'false')
	  return $resultDelete[0];
	else
	  return false;
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
  public static function checkSession($ssid)
 {
      try
      {
	if($ssid == NULL || $ssid == '')
	 return false;
	else
	{
	DataBase::ExecuteQuery("CALL CHECK_SESSION('".$ssid."',@A)");
	$result = DataBase::ExecuteQuery("select @A");
	$ResultUserId = mysql_fetch_row($result);
	if($ResultUserId[0] != 'false')    
	  return $ResultUserId[0];
	else
	  return false;
   }
 }
     catch(Exception $e)
     {
         return false;
     }
 }
 
  public static function deleteOldSessions($userLogin)
 {
     try
     {
	DataBase::ExecuteQuery("CALL DELETE_SESSION_OLD('".$userLogin."',@Output)");
	$result = DataBase::ExecuteQuery("select @Output");
	$resultDelete = mysql_fetch_row($result);
	if($resultDelete[0] != 'false')
	  return true;
	else
	  return false;
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
  public static function checkUser($sesion,$user)
 {
     try
     {
	DataBase::ExecuteQuery("CALL CHECK_USER('$sesion','$user',@Output)");
	$result = DataBase::ExecuteQuery("select @Output");
	$resultDelete = mysql_fetch_row($result);
	if($resultDelete[0] != 'false')
	  return true;
	else
	  return false;
        }
     catch(Exception $e)
     {
         return false;
     }
 }
}
?>