<?php
class Author
{
 private $authorId;
 private $name;
 private $description;
 private $photo;
 
 public function Author($authorId=NULL,$name=NULL,$description=NULL,$photo=NULL)
 {
  $this->authorId = $authorId;
  $this->name = $name;
  $this->description = $description;
  $this->photo = $photo;
 }
 
 //getter
 public function getAuthorId()
 {return $this->authorId;}
 
 public function getName()
 {return $this->name;}
 
 public function getDescription()
 {return $this->description;}
 
 public function getPhoto()
 {return $this->photo;}
 
 //setter
 public function setAuthorId($authorId)
 {$this->authorId = $authorId;}
  
 public function setName($name)
 {$this->name = $name;}
  
 public function setDescription($description)
  {$this->description = $description;}
  
 public function setPhoto()
 {$this->photo = $photo;}
 
 
 public function insert()
 {
     try
     {
	DataBase::ExecuteQuery("CALL INSERT_AUTHORS('".$this->getName()."','".$this->getDescription()."','".$this->getPhoto()."',@authorId,@Output);");	
	
	 $result = DataBase::ExecuteQuery("select @authorId,@Output");
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
 

public static function getAuthor($ssid)
{    
    try
     {//col0         col1         col2           col3           col4           
  $query = "SELECT `AU_Author_Id`,`AU_Name`,`AU_Descripcion`,`AU_Photo`,`AU_CreateDate`
FROM ins_session_tb, ins_authors_tb, ins_users_tb
//hacer join	
WHERE SS_USER_ID = US_User_Id 
AND (SS_SSID='".$ssid."')";

 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);

 $author = new Author($col[0],$col[1],$col[2],$col[3],$col[4]);
return $author;
}
     catch(Exception $e)
     {
         return false;
     }
}
}
?>