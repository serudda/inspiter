<?php
class Favourite
{
 protected $favouriteId;
 protected $userId;
 protected $inspiterId;
 protected $dateFavourite;
 
 public function Favourite($favouriteId=NULL,$userId=NULL,$inspiterId=NULL,$dateFavourite=NULL)
 {
  $this->favouriteId = $favouriteId;
  $this->userId = $userId;
  $this->inspiterId = $inspiterId;
  $this->dateFavourite = $dateFavourite;
 }
 
 //getter
 public function getFavouriteId()
 {return $this->favouriteId;}
 
 public function getUserId()
 {return $this->userId;}
 
 public function getInspiterId()
 {return $this->inspiterId;}
 
 public function getDateFavourite()
 {return $this->dateFavourite;}
 
 //setter
 public function setFavouriteId($favouriteId)
 {$this->favouriteId = $favouriteId;}
  
 public function setUserId($userId)
  {$this->userId = $userId;}
  
 public function setInspiterId($inspiterId)
 {$this->inspiterId = $inspiterId;}
  
 public function setDateFavourite($dateFavourite)
  {$this->dateFavourite = $dateFavourite;}
  
 public function addToFavourite()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_FAVOURITES('".$this->getUserId()."','".$this->getInspiterId()."',@Output);");

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
 
  public static function deleteToFavourite($pInspiterId,$pUserId)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_FAVOURITES('".$pInspiterId."','".$pUserId."',@Output);");

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
 
 
 public static function getAmountFavourite($userId)
 {
     try {
            $query = "SELECT count(*) from ins_favourites_tb
             WHERE FV_ser_Id = ".$userId;
            $result = DataBase::ExecuteQuery($query);
            $outputResult = mysql_fetch_row($result);
                return $outputResult[0];
        } catch (Exception $e) {
            return 0;
        }
 }
 
}

?>