<?php
require_once 'Database.php';
require_once 'Inspiter.php';

class Video extends Inspiter
{
 private $videoId;
 private $link;
 private $title;
 private $description;
 private $urlImage;
 
 public function Video($videoId=NULL,$link=NULL,$title=NULL,$description=NULL,$urlImage=NULL,$inspiterId=NULL,$userId=NULL,$category=NULL)
 {
  parent::__construct($inspiterId,$userId,$category); 
  $this->videoId = $videoId;
  $this->link = $link;
  $this->title= $title;
  $this->description = $description;
  $this->urlImage = $urlImage;
 }
 
 //getter
 public function getVideoId()
 {return $this->videoId;}
 
 public function getLink()
 {return $this->link;}
 
 public function getTitle()
 {return $this->title;}
  
 public function getDescription()
 {return $this->description;}
 
 public function getUrlImage()
 {return $this->urlImage;}
 
//setter
 public function setVideoId($videoId)
  {$this->videoId = $videoId;}
  
 public function setLink($link)
 {$this->link = $link;}
 
 public function setTitle($title)
 {$this->title = $title;}
  
 public function setDescription($description)
 {$this->description = $description;}
 
  public function setUrlImage($urlImage)
 {$this->urlImage = $urlImage;}
    
public function insert()
 {
    try
    {
	DataBase::ExecuteQuery("CALL INSERT_VIDEO('".parent::getUserId()."','".$this->getLink()."','".$this->getTitle()."','".$this->getDescription()."','".$this->getUrlImage()."','".parent::getCategory()."',@Output,@VideoId);");	
	
	 $result = DataBase::ExecuteQuery("select @Output,@VideoId");
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

public static function getAmountVideos($ssid)
{
  try
  {	
   $query = "SELECT VI_Video_Id
             FROM   ins_users_tb,ins_video_tb,ins_session_tb,ins_inspiter_tb
             WHERE  US_User_Id = IP_By_User_Id
             AND    IP_Inspiter_Id = VI_Video_Id
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
public static function getAmountVideosFriend($userId)
{
  try
  {	
   $query = "SELECT VI_Video_Id
             FROM   ins_users_tb,ins_video_tb,ins_inspiter_tb
             WHERE  US_User_Id = IP_By_User_Id
             AND    IP_Inspiter_Id = VI_Video_Id
             AND    Us_User_Id =".$userId;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}

public static function is_video_exist($userId,$videoIdParam)
{
    try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_video_tb,ins_inspiter_tb where VI_Video_Id = IP_Inspiter_Id AND VI_Video_Id = ".$videoIdParam." and IP_By_User_Id = ".$userId);
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

public static function getAmountVideosAll()
{
  try
  {	
   $query = "SELECT count(*)
             FROM   ins_video_tb";

   $result = DataBase::ExecuteQuery($query);
   $OutputExist = mysql_fetch_row($result);
  
   return $OutputExist[0];
  }
  catch (Exception $e){    
         return 0;
    }
}

 public static function getLinkByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `VI_Link`
               FROM ins_video_tb
               WHERE VI_Video_id = '$inspiterId'";
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
 
 public static function getURLImageByInspiterId($inspiterId)
 {
   try
   {  
     $query = "SELECT `VI_Url_Image`
               FROM ins_video_tb
               WHERE VI_Video_id = '$inspiterId'";
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