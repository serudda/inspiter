<?php
class Token
{
 private $tokenId;
 private $token;
 private $userEmail;
 private $endDateToken;
 private $type;
 private $sessionId;
 
 public function Token($tokenId=NULL,$token=NULL,$userEmail=NULL,$endDateToken=NULL,$type=NULL,$sessionId=NULL)
 {
  $this->tokenId = $tokenId;
  $this->token = $token;
  $this->userEmail = $userEmail;
  $this->endDateToken = $endDateToken;
  $this->type = $type;
  $this->sessionId = $sessionId;
 }
 
 //getter
 public function getTokenId()
 {return $this->tokenId;}
 
 public function getToken()
 {return $this->token;}
 
 public function getUserEmail()
 {return $this->userEmail;}
  
 public function getEndDateToken()
 {return $this->endDateToken;}
 
 public function getType()
 {return $this->type;}
 
 public function getSessionId()
 {return $this->sessionId;}
 
 //setter
 public function setTokenId($tokenId)
 {$this->tokenId = $tokenId;}
 
 public function setToken($token)
 {$this->token = $token;}
 
 public function setUserEmail($userEmail)
 {$this->userEmail = $userEmail;}
   
 public function setEndDateToken($endDateToken)
 {$this->endDateToken = $endDateToken;}
  
 public function setType($type)
 {$this->type = $type;}
 
 public function setSessionId($sessionId)
 {$this->sessionId = $sessionId;}
  
 public function insertToken()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_TOKEN('".$this->getToken()."','".$this->getUserEmail()."','".$this->getType()."',@Output);");

        $result = DataBase::ExecuteQuery("select @Output");
        $OutputResult = mysql_fetch_row($result);

        if ($OutputResult[0] == 'true') {
            return true;
        } else {
            return false;
        }
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 public function insertTokenOperation()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_TOKEN_OPERATION('".$this->getToken()."','".$this->getSessionId()."','".$this->getType()."',@OUTPUT,@TOKEN);");

        $result = DataBase::ExecuteQuery("select @OUTPUT,@TOKEN");
        $OutputResult = mysql_fetch_row($result);

        if ($OutputResult[0] == 'true') {
            return $OutputResult[1];
        } else {
            return false;
        }
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
  public static function deleteToken($pUserMail,$pType)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_TOKEN('".$pUserMail."','".$pType."',@Output);");

        $result = DataBase::ExecuteQuery("select @Output");
        $OutputResult = mysql_fetch_row($result);

        if ($OutputResult[0] == 'true') {
            return true;
        } else {
            return false;
        }
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
  public static function deleteTokenOperation($pSessionId,$pType)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_TOKEN_OPERATION('".$pSessionId."','".$pType."',@Output);");

        $result = DataBase::ExecuteQuery("select @Output");
        $OutputResult = mysql_fetch_row($result);

        if ($OutputResult[0] == 'true') {
            return true;
        } else {
            return false;
        }
        }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 public static function isAccountActivated($pUserMail)
 {
   try
   {  
     $query = "SELECT count(*)
               FROM ins_token_tb
               WHERE TO_User_Email = '$pUserMail'
               AND TO_Type = 'account'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     return $col[0];
    }
    catch(Exception $e)
    {
       return 0;
    }
 }
 
 public static function isTokenValid($tokenId,$sessionId)
 {
   try
   {
      $query = "SELECT count(*)
               FROM ins_token_tb
               WHERE TO_Session_Id = '$sessionId'
               AND TO_Token = '$tokenId'
               AND TO_Type = 'operation'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     return $col[0];
    }
    catch(Exception $e)
    {
       return 0;
    }
 }
 
}
?>