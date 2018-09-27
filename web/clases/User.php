<?php
require_once 'Database.php';
class User
{ 
 private $userId;
 private $email;
 private $userLogin;
 private $password;
 private $fullName;
 private $birthday;
 private $faceId;
 private $photo;
 private $photoSmall;
 private $theme;
 private $createDate;
 private $rolId;
 private $city;
 private $twitterId;
 private $inviteFriends;
 private $isActivated;
         
 public function User($userId=NULL,$email=NULL,$userLogin=NULL,$password=NULL,$fullName=NULL,$birthday=NULL,$faceId=NULL,$photo=NULL,$photoSmall=NULL,$theme=NULL,$createDate=NULL,$rolId=NULL,$city=NULL,$twitterId=NULL,$inviteFriends=NULL,$isActivated=NULL)
 {
   if($userId != NULL) 
   {$this->userId = $userId;}
   if($email != NULL) 
   {$this->email = $email;}
   if($userLogin != NULL) 
   {$this->userLogin = $userLogin;}
   if($password != NULL) 
   {$this->password = $password;}
   if($fullName != NULL) 
   {$this->fullName = $fullName;}
   if($birthday != NULL) 
   {$this->birthday = $birthday;}
   if($faceId != NULL) 
   {$this->faceId = $faceId;}
   if($photo != NULL) 
   {$this->photo = $photo;}
   if($photoSmall != NULL)
   {$this->photoSmall = $photoSmall;}
   if($theme != NULL)
   {$this->theme = $theme;}
   if($createDate != NULL)
   {$this->createDate = $createDate;}
   if($rolId != NULL)
   {$this->rolId = $rolId;}
   if($city != NULL) 
   {$this->city = $city;}
   if($twitterId != NULL) 
   {$this->twitterId = $twitterId;}
   if($inviteFriends != NULL)
   {$this->inviteFriends = $inviteFriends;}
   if($isActivated != NULL) 
   {$this->isActivated = $isActivated;}
 }
 
 //getter
 public function getUserId()
 {
     if($this->userId != NULL)
       return $this->userId; 
     else return 0;
 }
 
 public function getEmail()
 {return $this->email;}
 
 public function getUserLogin()
 {return $this->userLogin;}
 
 public function getPassword()
 {return $this->password;}
 
 public function getFullName()
 {return $this->fullName;}
 
 public function getBirthday()
 {return $this->birthday;}
 
 public function getFaceId()
 {return $this->faceId;}
 
 public function getPhoto()
 {return $this->photo;}
 
 public function getPhotoSmall()
 {return $this->photoSmall;}
 
 public function getTheme()
 {return $this->theme;}
 
 public function getCreateDate()
 {return $this->createDate;}
 
 public function getRolId()
 {return $this->rolId;}
 
 public function getCity()
 {return $this->city;}
 
  public function getTwitterId()
 {return $this->twitterId;}
 
  public function getInviteFriends()
 {return $this->inviteFriends;}
 
  public function getIsActivated()
 {return $this->isActivated;}
 
 //setter
  public function setUserId($userId)
 { $this->userId = $userId;}
 
 public function setEmail($email)
 { $this->email = $email;}
 
 public function setUserLogin($userLogin)
 { $this->userLogin = $userLogin;}
 
  public function setPassword($password)
 { $this->password = $password;}
 
 public function setFullName($fullName)
 { $this->fullName = $fullName;}
 
 public function setBirthday($birthday)
 { $this->birthday = $birthday;}
 
 public function setFaceId($faceId)
 { $this->faceId = $faceId;}

public function setPhoto($photo)
{ $this->photo = $photo;}

public function setPhotoSmall($photoSmall)
{ $this->photoSmall = $photoSmall;}
 
 public function setTheme($theme)
 { $this->theme = $theme;}
 
 public function setCreateDate($createDate)
 { $this->createDate = $createDate; }
 
 public function setRolId($rolId)
 { $this->rolId = $rolId; }
 
 public function setCity($city)
 { $this->city = $city;}
 
 public function setTwitterId($twitterId)
 { $this->twitterId = $twitterId;}
 
 public function setInviteFriends($inviteFriends)
 { $this->inviteFriends = $inviteFriends;}

public function setIsActivated($isActivated)
{ $this->isActivated = $isActivated;}
 
 public function insert($usernameFace)
 {
     try
     {
      DataBase::ExecuteQuery("CALL INSERT_USER('$this->email','$this->userLogin' , '$this->password' , '$this->fullName' , NULL , '$this->faceId' , '$this->photo','$this->photoSmall' , NULL , NULL , '$this->city' , 0 , '$usernameFace',@USER_ID , @OUTPUT);");	                                             
      $result = DataBase::ExecuteQuery("select @USER_ID,@OUTPUT");
      $OutputResult = mysql_fetch_row($result);	
      if($OutputResult[1] == 'true')
      {
       return $OutputResult[0];
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
 

public static function getUser($ssid)
{    
    try
    {
                     //col0         col1         col2           col3           col4        col5       col6        col7     col8                 col9              col10
  $query = "SELECT `US_User_Id`,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Face_Id`,`US_Photo`,`US_CITY`,`US_Photo_Small`,`US_Invite_Friends`,`US_IS_Activated`
FROM ins_session_tb, ins_users_tb
WHERE SS_USER_ID = US_User_Id 
AND (SS_SSID='".$ssid."')";
 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);
 $user = new User($col[0],$col[1],$col[2],NULL,$col[3],NULL,$col[4],$col[5],$col[7],NULL,NULL,NULL,$col[6],NULL,$col[8],$col[9]);                                                                                                   
 return $user;
}
     catch(Exception $e)
     {
         return false;
     }
}

public static function getUserFriend($userId)
{   
    try
    {
                      //col0         col1         col2           col3           col4        col5       col6        col7               col8             col9
  $query = "SELECT `US_User_Id`,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Face_Id`,`US_Photo`,`US_CITY`, `US_Photo_Small`,`US_Invite_Friends`,`US_IS_Activated`
FROM ins_users_tb	
where US_User_Id='".$userId."'";
 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);
 $user = new User($col[0],$col[1],$col[2],NULL,$col[3],NULL,$col[4],$col[5],$col[7],NULL,NULL,NULL,$col[6],NULL,$col[8],$col[9]);
return $user;
}
     catch(Exception $e)
     {
         return false;
     }
}

public static function exist($username,$password)
 {
    try
    {
   DataBase::ExecuteQuery("CALL EXIST_USER('".$username."','".$password."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 'true')
   {return true;}
   else
   {return false;}
   }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 public static function exist_md5($username,$password)
 {
    try
    {
   DataBase::ExecuteQuery("CALL EXIST_USER_MD5('".$username."','".$password."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 'true')
   {return true;}
   else
   {return false;}
   }
     catch(Exception $e)
     {
         return false;
     }
 }
 
 public static function existFaceId($faceid)
 {
   try
   {
   DataBase::ExecuteQuery("CALL EXIST_USER_FB('".$faceid."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 'true')
   {return true;}
   else
   {return false;}}
     catch(Exception $e)
     {
         return false;
     }
   
 }

public static function getUserLoginFB($faceid)
{
  try
  {
   DataBase::ExecuteQuery("CALL GET_USER_LOGIN_FB('".$faceid."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 'false')
   {return false;}
   else
   {return $OutputExist[0];}
   }
     catch(Exception $e)
     {
         return false;
     }
 }


public static function UpdateStateInviteFriends($userId,$bandInviteFriends)
{
  try
  {
   DataBase::ExecuteQuery("CALL UPDATE_STATE_INVITE_FRIENDS('".$userId."','".$bandInviteFriends."',@Output);");	
   $result = DataBase::ExecuteQuery("select @Output");
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 'true')
   {return true;}
   else
   {return false;}
   }
     catch(Exception $e)
     {
         return false;
     }
}


public static function is_user_exist($userIdParam)
{
   try
    { 
   $result = DataBase::ExecuteQuery("select count(*) from ins_users_tb where US_User_Id = ".$userIdParam);
   $OutputExist = mysql_fetch_row($result);
   if($OutputExist[0] == 1)
   {return true;}
   else
   {return false;}
   }
     catch(Exception $e)
     {
         return false;
     }
}

public static function getUserById($userid)
{   
try
{
                      //col0         col1         col2           col3           col4        col5       col6        col7     col8
  $query = "SELECT `US_User_Id`,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Face_Id`,`US_Photo`,`US_CITY`,`US_Photo_Small`,`US_Invite_Friends`,`US_IS_Activated`
FROM ins_users_tb
WHERE US_User_Id =".$userid;
 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);
 $user = new User($col[0],$col[1],$col[2],NULL,$col[3],NULL,$col[4],$col[5],$col[7],NULL,NULL,NULL,$col[6],NULL,$col[8],$col[9]);
return $user;
}
     catch(Exception $e)
     {
         return false;
     }
}
 
public function updateUser($pUserId,$pName,$pCity,$pPhoto,$pAboutYou,$pIdentPhrase,$pImagePhrase,$pWebSite,$pAuhor,$pStyleJson)
{
   try
   {
     $query = "CALL UPDATE_USER('$pUserId','$pName','$pCity','$pPhoto','$pAboutYou','$pIdentPhrase','$pImagePhrase','$pWebSite','$pAuhor','$pStyleJson',@OUTPUT);";
     DataBase::ExecuteQuery($query);	                                             
     $result = DataBase::ExecuteQuery("select @OUTPUT");
     $OutputResult = mysql_fetch_row($result);	
     if($OutputResult[0] == 'true') 
       return true;
     else 
       return false;
    }
    catch(Exception $e)
    {
       return false;
    }
}
 
 public static function getUserIdByUsername($pUsername)
 {
   try
   {  
     $query = "SELECT `US_User_Id`
               FROM ins_users_tb
               WHERE UPPER(US_User_Login) = UPPER('$pUsername')";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
public static function IsAssocToFace($pUserId)
 {
   try
   {
     $query = "SELECT COUNT(*)
               FROM ins_users_tb
               WHERE US_User_Id = $pUserId 
               AND (US_Face_Id IS NOT NULL AND US_Face_Id > 0)";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col[0] != false && $col[0] != null && $col[0] != '' && $col[0] > 0)
      return true; //Ya se encuentra asociado a facebook
     else
      return false; //No se encuentra asociado a facebook
     }
     catch(Exception $e)
     {
        return false;
     }
}


public static function UpdateFaceId($pUser,$pFaceId,$pUsernameFace)
 {
   try
   {
    $query = "CALL UPDATE_FACE_ID('$pUser','$pFaceId','$pUsernameFace',@OUTPUT)";
    DataBase::ExecuteQuery($query);	                                             
    $result = DataBase::ExecuteQuery("select @OUTPUT");
    $OutputResult = mysql_fetch_row($result);	
    if($OutputResult[0] == 'true')
      return true;
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
}


 public static function getUserData($userid, $ssid, $wordSearch)
 {
        try {
            $UserContent = stripslashes($wordSearch);
            $query = "SELECT user.US_User_Id, user.US_User_Login,user.US_Full_Name,
                      user.US_City,user.US_Photo, 
                      (SELECT COUNT(*)
                        FROM ins_follow_tb,ins_users_tb
                        WHERE FW_DAD_Id = US_User_Id
AND user.US_User_Id = US_User_Id
AND FW_SUN_Id = (SELECT SS_User_Id FROM ins_session_tb WHERE SS_SSID = ".$ssid.")) as FW_Follow_Flag,
             user.US_CreateDate
                      FROM ins_users_tb user
                      WHERE UPPER(user.US_Full_Name) like '%".strtoupper($UserContent)."%'";
            $query = $query." OR UPPER(user.US_User_Login) like '%".strtoupper($UserContent)."%'";
            $query = $query." order by US_CreateDate DESC";

            $result = DataBase::ExecuteQuery($query);
            $jsondata = array();
            $i = mysql_num_rows($result) - 1;
            while ($row = mysql_fetch_assoc($result)) {
                $jsondata[$i]['US_User_Id'] = $row['US_User_Id'];
                $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
                $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
                $jsondata[$i]['US_City'] = $row['US_City'];
                $jsondata[$i]['US_Photo'] = $row['US_Photo'];
                $jsondata[$i]['FW_Follow_Flag'] = $row['FW_Follow_Flag'];
                $i--;
            }
            $jsondata = array_reverse($jsondata);
            return json_encode($jsondata);
        } catch (Exception $e) {
            return 0;
        }
    }

public static function getUserDataVisual($userid, $ssid, $wordSearch)
 {
        try {
            $UserContent = stripslashes($wordSearch);
            $query = "SELECT user.US_User_Id, user.US_User_Login,user.US_Full_Name,
                      user.US_City,user.US_Photo_Small, 
                      (SELECT COUNT(*)
                        FROM ins_follow_tb,ins_users_tb
                        WHERE FW_DAD_Id = US_User_Id
AND user.US_User_Id = US_User_Id
AND FW_SUN_Id = (SELECT SS_User_Id FROM ins_session_tb WHERE SS_SSID = ".$ssid.")) as FW_Follow_Flag,
             user.US_CreateDate
             FROM ins_users_tb user
             WHERE UPPER(user.US_Full_Name) like '%".strtoupper($UserContent)."%'";
             $query = $query." OR UPPER(user.US_User_Login) like '%".strtoupper($UserContent)."%'"; 
             
            $query = $query." order by US_CreateDate DESC";
						$query = $query." LIMIT 5";
            $result = DataBase::ExecuteQuery($query);
            $jsondata = array();
            $i = mysql_num_rows($result) - 1;
            while ($row = mysql_fetch_assoc($result)) {
                $jsondata[$i]['US_User_Id'] = $row['US_User_Id'];
                $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
                $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
                $jsondata[$i]['US_City'] = $row['US_City'];
                $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small'];
                $jsondata[$i]['FW_Follow_Flag'] = $row['FW_Follow_Flag'];
                $i--;
}
            $jsondata = array_reverse($jsondata);
            return json_encode($jsondata);
        } catch (Exception $e) {
            return 0;
        }
    }
    
public static function existMail($email)
{    
    try
    {       
        $query = "SELECT US_User_Id,US_User_Login, US_Full_Name
FROM ins_users_tb	
WHERE upper(US_Email) = upper('$email')";

        $result = DataBase::ExecuteQuery($query);
        $col = mysql_fetch_row($result);

        return $col[2];
     }
     catch(Exception $e)
     {
         return false;
     }
 }

 public static function getUserByToken($token)
{ 
    try
    {
 $query = "SELECT `US_User_Id`,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Face_Id`,`US_Photo`,`US_CITY`, `US_Photo_Small`,`US_Invite_Friends`,`US_IS_Activated`
  FROM ins_users_tb, ins_token_tb
  WHERE TO_User_Email = US_Email
  AND (TO_Token='".$token."')";         
 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);
 $user = new User($col[0],$col[1],$col[2],NULL,$col[3],NULL,$col[4],$col[5],$col[7],NULL,NULL,NULL,$col[6],NULL,$col[8],$col[9]);
 return $user;
}
     catch(Exception $e)
     {
         return false;
     }
} 

public static function updatePassword($pUserId,$pPasswordNew,$pPasswordReNew)
{
   try
   {
      $pPasswordNewMD5 = md5($pPasswordNew);
      $pPasswordReNewMD5 = md5($pPasswordReNew);
      $query = "CALL UPDATE_PASSWORD('$pUserId','$pPasswordNewMD5','$pPasswordReNewMD5',@OUTPUT);";
      DataBase::ExecuteQuery($query);	                                             
      $result = DataBase::ExecuteQuery("select @OUTPUT");
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
 
 public static function getUserIdBySession($SSID)
 {
   try
   {  
     $query = "SELECT `US_User_Id`
               FROM ins_users_tb,ins_session_tb
               WHERE SS_User_Id = Us_User_Id
               and SS_SSID = '$SSID'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
 public static function IsActivateUser($SSID)
 {
   try
   {  
     $query = "SELECT `US_Is_Activated`
               FROM ins_users_tb,ins_session_tb
               WHERE SS_User_Id = Us_User_Id
               and SS_SSID = '$SSID'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
 
 public static function UpdateActivateUser($pUserId)
 {
   try
   {
    $query = "CALL UPDATE_ACTIVATE_USER('$pUserId',@OUTPUT)";
    DataBase::ExecuteQuery($query);	                                             
    $result = DataBase::ExecuteQuery("select @OUTPUT");
    $OutputResult = mysql_fetch_row($result);	
    if($OutputResult[0] == 'true')
      return true;
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
  }

 public static function IsActivateUserById($userId)
 {
   try
   {  
     $query = "SELECT `US_Is_Activated`
               FROM ins_users_tb
               WHERE US_User_Id = '$userId'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
  public static function IsActivateUserByFaceId($faceId)
 {
   try
   {  
     $query = "SELECT `US_Is_Activated`
               FROM ins_users_tb
               WHERE US_Face_Id = '$faceId'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
  public static function IsActivateUserByUsername($username)
 {
   try
   {  
     $query = "SELECT `US_Is_Activated`
               FROM ins_users_tb
               WHERE Us_User_Login = '$username' OR US_Email = '$username'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
   public static function getEmailByUsername($username)
 {
   try
   {  
     $query = "SELECT `US_Email`
               FROM ins_users_tb
               WHERE Us_User_Login = '$username' OR  US_Email = '$username'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
   public static function getEmailByFaceId($faceId)
 {
   try
   {  
     $query = "SELECT `US_Email`
               FROM ins_users_tb
               WHERE Us_Face_Id = '$faceId'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
 
 public static function getUserIdByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `US_User_Id`
               FROM ins_users_tb,ins_inspiter_tb
               WHERE US_User_Id = IP_By_User_Id
               AND IP_Inspiter_Id = '$inspiterId'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
 }
 
 
public static function IsFirstTimeRegister($userId)
{
  try
   {  
     $query = "SELECT `US_Invite_Friends`
               FROM ins_users_tb
               WHERE Us_User_Id = '$userId'";
     $result = DataBase::ExecuteQuery($query);
     $col = mysql_fetch_row($result);
     if($col != false && $col != null && $col != '')
      return $col[0];
     else
      return false;
    }
    catch(Exception $e)
    {
       return false;
    }
}

public static function getInspiterFriends($query,$ssid)
{
   try
   {
      $result = DataBase::ExecuteQuery($query);
      $jsondata = array();
      $i = mysql_num_rows($result) - 1;
      while ($row = mysql_fetch_assoc($result)) 
      {
         $jsondata[$i]['US_User_Id'] = $row['US_User_Id'];
         $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
         $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
         $jsondata[$i]['US_Face_Id'] = $row['US_Face_Id'];
         $jsondata[$i]['US_Photo'] = $row['US_Photo'];
         $jsondata[$i]['US_City'] = $row['US_City'];
         $jsondata[$i]['FW_Follow_Flag'] = $row['FW_Follow_Flag'];
         $i--;
       }
       return json_encode($jsondata);
    } 
    catch (Exception $e) 
    {
       return false;
    }
} 

public static function updatePasswordConfig($pUserId,$pPasswordOld,$pPasswordNew,$pPasswordReNew)
{
   try
   {
      $pPasswordOldMD5  = md5($pPasswordOld);
      $pPasswordNewMD5 = md5($pPasswordNew);
      $pPasswordReNewMD5 = md5($pPasswordReNew);
      $query = "CALL UPDATE_PASSWORD_CONFIG('$pUserId','$pPasswordOldMD5','$pPasswordNewMD5','$pPasswordReNewMD5',@OUTPUT);";
      DataBase::ExecuteQuery($query);	                                             
      $result = DataBase::ExecuteQuery("select @OUTPUT");
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
 
 public static function UpdateEmail($pEmail,$pEmailNew)
 {
   try
   {
    $query = "CALL UPDATE_EMAIL('$pEmail','$pEmailNew',@OUTPUT)";
    DataBase::ExecuteQuery($query);	                                             
    $result = DataBase::ExecuteQuery("select @OUTPUT");
    $OutputResult = mysql_fetch_row($result);	
    if($OutputResult[0] == 'true')
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