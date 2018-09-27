<?php
require_once 'Database.php';
require_once 'Session.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase utilizada para realizar las configuraciones de notificaciones, de mails, de privacidad del usuario etc etc
 *
 * @author Inspiter
 */
class Config {
    
    private $configId;
    private $userId;
    private $configStatusNotif;
    private $aboutYou;	
    private $identPhrase; 	
    private $imageIPhrase; 	
    private $IPS; 
    private $faceUri;
    private $webSite;
    private $author;
    private $style;
    private $followAmount;
    private $stateProfile;
    
    public function Config($configId=NULL,$userId=NULL,$configStatusNotif=NULL,
                           $aboutYou=NULL, $identPhrase=NULL, $imageIPhrase=NULL, $IPS=NULL, $faceUri=NULL,$webSite=NULL,$author=NULL,$style=NULL, $followAmount=NULL, $stateProfile=NULL) 
    {
        $this->configId = $configId;
        $this->userId = $userId;
        $this->configStatusNotif = $configStatusNotif;
        $this->aboutYou = $aboutYou;
        $this->identPhrase = $identPhrase;
        $this->imageIPhrase = $imageIPhrase;
        $this->IPS = $IPS;
        $this->faceUri = $faceUri;
        $this->webSite = $webSite;
        $this->author = $author;
        $this->style = $style;
        $this->followAmount = $followAmount;
        $this->stateProfile = $stateProfile;
    }
    
    
    //getter
    public function getConfigId() {
        return $this->configId;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getConfigStatusNotif() {
        return $this->configStatusNotif;
    }
    public function getAboutYou() {
        return $this->aboutYou;
    }
    public function getIdentPhrase() {
        return $this->identPhrase;
    }
    public function getImageIPhrase() {
        return $this->imageIPhrase;
    }
    public function getIPS() {
        return $this->IPS;
    }
    public function getFaceUri() {
        return $this->faceUri;
    }
    public function getWebSite() {
        return $this->webSite;
    }
    public function getAuthor()
    {
       return $this->author;
    }
    public function getStyle()
    {
       return $this->style;
    }
    public function getFollowAmount()
    {
       return $this->followAmount;
    }
    public function getStateProfile()
    {
       return $this->stateProfile;
    }

    //setter  
    public function setConfigId($configId) {
        $this->configId = $configId;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function setConfigStatusNotif($configStatusNotif) {
        $this->configStatusNotif = $configStatusNotif;
    }
    public function setAboutYou($aboutYou) {
        $this->aboutYou = $aboutYou;
    }
    public function setIdentPhrase($identPhrase) {
        $this->identPhrase = $identPhrase;
    }
    public function setImageIPhrase($imageIPhrase) {
        $this->imageIPhrase = $imageIPhrase;
    }
    public function setIPS($IPS) {
        $this->IPS = $IPS;
    }
    public function setFaceUri($faceUri) {
        $this->faceUri = $faceUri;
    }
    public function setWebSite($webSite) {
        $this->webSite = $webSite;
    }
    public function setAuthor($author) {
        $this->author = $author;
    }
    public function setStyle($style) {
        $this->style = $style;
    }
    public function setFollowAmount($followAmount) {
        $this->followAmount = $followAmount;
    }
    public function setStateProfile($stateProfile) {
        $this->stateProfile = $stateProfile;
    }
    
    public function insertStatusNotif()
    {
        try
        {
        DataBase::ExecuteQuery("CALL INSERT_STATUS_NOTIF_USER('".$this->getUserId()."','".$this->getConfigStatusNotif()."',@Output);");

        $result = DataBase::ExecuteQuery("select @Output");
        $OutputResult = mysql_fetch_row($result);

        if ($OutputResult[0] == 'true') {
            return true;
        } else {
            return $OutputResult[0];
        }
        }
     catch(Exception $e)
     {
         return false;
     }
    }
    
    public static function getNotificationAmountShowed($ssid)
    {
     try
     {
      $query = "SELECT CF_Status_Notif
	FROM ins_config_tb
	WHERE CF_User_Id = (select SS_User_Id from ins_session_tb where SS_SSID = $ssid)";
      $result = DataBase::ExecuteQuery($query);
      $outputResult = mysql_fetch_row($result);
      return $outputResult[0];
        } catch (Exception $e) {
            return 0;
        }
    }
    
     public static function getUserConfig($ssid)
     {
        try
       {
                              //col0         col1         col2             col3              col4              col5            col6        col7        col8         col9           col10            col11
         $query = "SELECT `CF_Config_Id`,`CF_User_Id`,`CF_Status_Notif`,`CF_About_You`,`CF_Ident_Phrase`,`CF_Image_IPhrase`,`CF_IPS`,`CF_Face_Uri`,`CF_Web_Site`,`CF_Author`,`CF_Follow_Amount`,`CF_State_Profile`
                   FROM ins_session_tb, ins_users_tb, ins_config_tb
                   WHERE SS_USER_ID = US_User_Id 
                   AND CF_User_Id = US_User_Id
                   AND (SS_SSID='".$ssid."')";
         $result = DataBase::ExecuteQuery($query);
         $col = mysql_fetch_row($result);
         $config = new Config($col[0],$col[1],$col[2],$col[3],$col[4],$col[5],$col[6],$col[7],$col[8],$col[9],null,$col[10],$col[11]);
         return $config;
        }
        catch(Exception $e)
        {
          return false;
        }
     }
     
     public static function getUserConfigFriend($userId)
     {
        try
       {
                              //col0         col1         col2             col3              col4              col5            col6        col7        col8       col9            col10               col11
         $query = "SELECT `CF_Config_Id`,`CF_User_Id`,`CF_Status_Notif`,`CF_About_You`,`CF_Ident_Phrase`,`CF_Image_IPhrase`,`CF_IPS`,`CF_Face_Uri`,`CF_Web_Site`,`CF_Author`,`CF_Follow_Amount`,`CF_State_Profile`
                   FROM ins_users_tb, ins_config_tb
                   WHERE CF_User_Id = US_User_Id
                   AND (US_User_Id='".$userId."')";
         $result = DataBase::ExecuteQuery($query);
         $col = mysql_fetch_row($result);
         $config = new Config($col[0],$col[1],$col[2],$col[3],$col[4],$col[5],$col[6],$col[7],$col[8],$col[9],null,$col[10],$col[11]);
         return $config;
        }
        catch(Exception $e)
        {
          return false;
        }
     }
     
     public static function getConfigStyle($userId)
     {
        try
       {
                             
         $query = "SELECT `CF_Style`
                   FROM ins_users_tb, ins_config_tb
                   WHERE CF_User_Id = US_User_Id
                   AND (US_User_Id='".$userId."')";
         $result = DataBase::ExecuteQuery($query);
         $resultStyle = mysql_fetch_row($result);
        
          $obj = json_decode((string)$resultStyle[0]);
          $jsondata = array(); 
          $jsondata[0]['fontFamily'] = $obj->fontFamily;
          $jsondata[0]['fontSize'] = $obj->fontSize;
          $jsondata[0]['fontWeight'] = $obj->fontWeight;
          $jsondata[0]['fontStyle'] = $obj->fontStyle;
          $jsondata[0]['imageTop'] = $obj->imageTop;
          $jsondata[0]['phraseTop'] = $obj->phraseTop;
          $jsondata[0]['phraseLeft'] = $obj->phraseLeft;
          $jsondata[0]['authorTop'] = $obj->authorTop;
          $jsondata[0]['authorLeft'] = $obj->authorLeft;
          return json_encode($jsondata);
        }
        catch(Exception $e)
        {
          return false;
        }
     }
     public static function addConfigValue($userId,$typeId)
     {
        try
        {
        DataBase::ExecuteQuery("CALL ADD_CONFIG_VALUE('".$userId."','".$typeId."',@Output);");

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
     
     public static function getIPSValue($userId)
     {
      try
      {
        $query = "SELECT CF_IPS
	          FROM ins_config_tb
	          WHERE CF_User_Id = $userId";
        $result = DataBase::ExecuteQuery($query);
        $outputResult = mysql_fetch_row($result);
        return $outputResult[0];
       }
       catch (Exception $e) 
       {
            return 0;
       }
      }
      
     public static function getImagePhraseUri($userId)
     {
      try
      {
        $query = "SELECT `CF_Image_IPhrase`
	          FROM ins_config_tb
	          WHERE CF_User_Id = $userId";
        $result = DataBase::ExecuteQuery($query);
        $outputResult = mysql_fetch_row($result);
        return $outputResult[0];
       }
       catch (Exception $e) 
       {
            return 0;
       }
     }
     
     public static function getFollowAmountbyUser($userId)
     {
      try
      {
        $query = "SELECT `CF_Follow_Amount`
	          FROM ins_config_tb
	          WHERE CF_User_Id = $userId";
        $result = DataBase::ExecuteQuery($query);
        $outputResult = mysql_fetch_row($result);
        return $outputResult[0];
       }
       catch (Exception $e) 
       {
            return 0;
       }
     }
     
    public function insertFollowAmount($userId)
    {
        try
        {
          DataBase::ExecuteQuery("CALL UPDATE_FOLLOW_AMOUNT('".$userId."',@Output,@Amount);");
          $result = DataBase::ExecuteQuery("select @Output,@Amount");
          $OutputResult = mysql_fetch_row($result);
          if ($OutputResult[0] == 'true') 
          {
            return $OutputResult[1];
          }
          else 
          {
            return $OutputResult[0];
          }
         }
        catch(Exception $e)
        {
         return false;
        }
    }
    
     public function updateStateProfile($userId,$value)
    {
        try
        {
          DataBase::ExecuteQuery("CALL UPDATE_STATE_PROFILE('".$userId."','".$value."',@Output);");
          $result = DataBase::ExecuteQuery("select @Output");
          $OutputResult = mysql_fetch_row($result);
          if ($OutputResult[0] == 'true') 
          {
            return $OutputResult[0];
          }
          else 
          {
            return $OutputResult[0];
          }
         }
        catch(Exception $e)
        {
         return false;
        }
    }
}
?>
