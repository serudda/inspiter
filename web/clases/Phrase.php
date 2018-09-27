<?php
require_once 'Database.php';
require_once 'Inspiter.php';
header("Content-Type: text/html;charset=utf-8");
class Phrase extends Inspiter
{
 private $phraseId;
 private $phrase;
 private $author;
 private $authorId;
 
 public function Phrase($phraseId=NULL,$phrase=NULL,$author=NULL, $authorId=NULL,$inspiterId=NULL,$userId=NULL,$category=NULL)
 {
  parent::__construct($inspiterId,$userId,$category); 
  $this->phraseId = $phraseId;
  $this->phrase = $phrase;
  $this->author = $author;
  $this->authorId = $authorId;
 }
 
 //getter
 public function getPhraseId()
 {return $this->phraseId;}
 
 public function getPhrase()
 {return $this->phrase;}
 
 public function getAuthor()
 {return $this->author;}
 
 public function getAuthorId()
 {return $this->authorId;}
 
 //setter
 public function setPhraseId($phraseId)
 {$this->phraseId = $phraseId;}
  
 public function setPhrase($phrase)
  {$this->phrase = $phrase;}
  
 public function setAuthor($author)
 {$this->author = $author;}
  
 public function setAuthorId($authorId)
 {$this->authorId = $authorId;}
    
public function insert()
 {
    try
    {
	DataBase::ExecuteQuery("CALL INSERT_PHRASE('".$this->getPhrase()."','".parent::getUserId()."','".$this->getAuthor()."','".$this->getAuthorId()."','".parent::getCategory()."',@Output,@PhraseId);");	
	
	 $result = DataBase::ExecuteQuery("select @Output,@PhraseId");
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
	 
public static function getAmountPhrases($ssid)
{
  try
  {	
   $query = "SELECT PH_Phrase_Id
             FROM   ins_users_tb,ins_phrases_tb,ins_session_tb
             WHERE  ins_users_tb.US_User_Id = ins_phrases_tb.PH_By_User_Id
             AND    ins_session_tb.SS_User_Id = ins_users_tb.US_User_Id
             AND    ins_session_tb.SS_SSID = ".$ssid;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}


//Friends
public static function getAmountPhrasesFriend($userId)
{
  try
  {	
   $query = "SELECT PH_Phrase_Id
             FROM   ins_users_tb,ins_phrases_tb
             WHERE  ins_users_tb.US_User_Id = ins_phrases_tb.PH_By_User_Id
             AND    ins_users_tb.Us_User_Id =".$userId;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}


public static function is_phrase_exist($userId,$phraseIdParam)
{
    try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_phrases_tb where PH_Phrase_Id = ".$phraseIdParam." and PH_By_User_Id = ".$userId);
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


public static function getAmountPhrasesAll()
{
  try
  {	
   $query = "SELECT count(*)
             FROM   ins_phrases_tb";

   $result = DataBase::ExecuteQuery($query);
   $OutputExist = mysql_fetch_row($result);
  
   return $OutputExist[0];
  }
  catch (Exception $e){    
         return 0;
    }
}


}
?>