<?php
require_once 'Database.php';
require_once 'Inspiter.php';

class Image extends Inspiter
{
 private $imageId;
 private $uri;
 private $title;
 private $description;
 private $phraseId; 
 private $height;
 private $originalUri;
 private $originalWidth;
 private $originalHeight;

 public function Image($imageId=NULL,$uri=NULL,$title=NULL,$description=NULL,$phraseId=NULL,$height=NULL,$originalUri=NULL,$originalWidth=NULL,
                       $originalHeight=NULL,$inspiterId=NULL,$userId=NULL,$category=NULL)
 {
  parent::__construct($inspiterId,$userId,$category); 
  $this->imageId = $imageId;
  $this->uri = $uri;
  $this->title= $title;
  $this->description = $description;
  $this->phraseId = $phraseId;
  $this->height = $height;
  $this->originalUri = $originalUri;
  $this->originalWidth = $originalWidth;
  $this->originalHeight = $originalHeight;
 }
 
 //getter
 public function getImageId()
 {return $this->imageId;}
 
 public function getUri()
 {return $this->uri;}
 
 public function getTitle()
 {return $this->title;}
  
 public function getDescription()
 {return $this->description;}
 
 public function getPhraseId()
 {return $this->phraseId;}
 
 public function getHeight()
 {return $this->height;}
 
 public function getOriginalUri()
 {return $this->originalUri;}
 
 public function getOriginalWidth()
 {return $this->originalWidth;}
 
 public function getOriginalHeight()
 {return $this->originalHeight;}
 
//setter
 public function setImageId($imageId)
  {$this->imageId = $imageId;}
  
 public function setUri($uri)
 {$this->uri = $uri;}
 
 public function setTitle($title)
 {$this->title = $title;}
  
 public function setDescription($description)
 {$this->description = $description;}
  
 public function setPhraseId($phraseId)
 {$this->phraseId = $phraseId;}
 
 public function setHeight($height)
 {$this->height = $height;}
 
 public function setOriginalUri($originalUri)
 {$this->originalUri = $originalUri;}
 
 public function setOriginalWidth($originalWidth)
 {$this->originalWidth = $originalWidth;}
 
 public function setOriginalHeight($originalHeight)
 {$this->originalHeight = $originalHeight;}
 
public function insert()
 {
    try
    {
	DataBase::ExecuteQuery("CALL INSERT_IMAGE('".parent::getUserId()."','".$this->getUri()."','".$this->getTitle()."','".$this->getDescription()."','".$this->getPhraseId()."','".$this->getHeight()."','".$this->getOriginalUri()."','".$this->getOriginalWidth()."','".$this->getOriginalHeight()."','".parent::getCategory()."',@Output,@ImageId);");	
	
	 $result = DataBase::ExecuteQuery("select @Output,@ImageId");
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

public static function getAmountImages($ssid)
{
  try
  {	
   $query = "SELECT IM_Image_Id
             FROM   ins_users_tb,ins_image_tb,ins_session_tb,ins_inspiter_tb
             WHERE  US_User_Id = IP_By_User_Id
             AND    IP_Inspiter_Id = IM_Image_Id
             AND    SS_User_Id = US_User_Id
             AND    SS_SSID = ".$ssid;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}

//Friends
public static function getAmountImagesFriend($userId)
{
  try
  {	
   $query = "SELECT IM_Image_Id
             FROM   ins_users_tb,ins_image_tb,ins_inspiter_tb
             WHERE  US_User_Id = IP_By_User_Id
             AND    IP_Inspiter_Id = IM_Image_Id
             AND    Us_User_Id =".$userId;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}

public static function is_image_exist($userId,$imageIdParam)
{
    try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_image_tb,ins_inspiter_tb where IM_Image_Id = IP_Inspiter_Id AND IM_Image_Id = ".$imageIdParam." and IP_By_User_Id = ".$userId);
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

public static function getAmountImagesAll()
{
  try
  {	
   $query = "SELECT count(*)
             FROM   ins_image_tb";

   $result = DataBase::ExecuteQuery($query);
   $OutputExist = mysql_fetch_row($result);
  
   return $OutputExist[0];
  }
  catch (Exception $e){    
         return 0;
    }
}

 public static function getUriByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `IM_Uri`
               FROM ins_image_tb
               WHERE IM_Image_Id = '$inspiterId'";
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
 
 public static function getHeightByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `IM_Image_Height`
               FROM ins_image_tb
               WHERE IM_Image_Id = '$inspiterId'";
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
 
 public static function getOriginalUriByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `IM_Original_Uri`
               FROM ins_image_tb
               WHERE IM_Image_Id = '$inspiterId'";
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
}
?>