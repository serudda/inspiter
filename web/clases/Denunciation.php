<?php
require_once 'Database.php';
class Denunciation
{
 protected $denunciationId;
 protected $accuserId;
 protected $userId;
 protected $inspiterId;
 protected $commentId;
 protected $motive;
 protected $denuncationDate;

 
 public function Denunciation($denunciationId=NULL,$accuserId=NULL,$userId=NULL,$inspiterId=NULL,$commentId=NULL,$motive=NULL,$denuncationDate=NULL)
 {
  $this->denunciationId = $denunciationId;
  $this->accuserId = $accuserId;
  $this->userId = $userId;
  $this->inspiterId = $inspiterId;
  $this->commentId = $commentId;
  $this->motive = $motive;
  $this->denuncationDate = $denuncationDate;
 }
 
 //getter
 public function getDenunciationId()
 {return $this->denunciationId;}
 
 public function getAccuserId()
 {return $this->accuserId;}
 
 public function getUserId()
 {return $this->userId;}
 
 public function getInspiterId()
 {return $this->inspiterId;}
 
  public function getCommentId()
 {return $this->commentId;}
 
  public function getMotive()
 {return $this->motive;}
 
 public function getDenuncationDate()
 {return $this->denuncationDate;}
 
 
 
 //setter
 public function setDenunciationId($denunciationId)
 {$this->denunciationId = $denunciationId;}
  
 public function setAccuserId($accuserId)
 {$this->accuserId = $accuserId;}
   
 public function setUserId($userId)
  {$this->userId = $userId;}
 
 public function setInspiterId($inspiterId)
  {$this->inspiterId = $inspiterId;}
  
 public function setCommentId($commentId)
 {$this->commentId = $commentId;}
 
 public function setMotive($motive)
 {$this->motive = $motive;}
 
 public function setDenuncationDate($denuncationDate)
  {$this->denuncationDate = $denuncationDate;}
  
 public function insertDenunciation()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_DENUNCIATION('".$this->getAccuserId()."','".$this->getUserId()."','".$this->getInspiterId()."','".$this->getCommentId()."','".$this->getMotive()."',@OUTPUT,@DENUNCIATION_ID);");

        $result = DataBase::ExecuteQuery("select @Output,@DENUNCIATION_ID");
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
 
 public static function deleteDenunciation($pDenunciationId)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_DENUNCIATION('".$pDenunciationId."',@Output);");

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
  
 public static function getDedicationData($userId,$ssid,$dedicId)
{    
    try
    {
     $query = "SELECT DD_Dedications_Id, DD_Inspiter_Id, DD_From_User_Id, DD_To_User_Id, DD_Comment, DD_Creation_Date, US_User_Id, US_User_Login, US_Full_Name, US_Photo, US_City, PH_Phrase, PH_Author,";
     $query = $query." CASE 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 360 AND DATEDIFF(SYSDATE(), DD_Creation_Date) <= 365 THEN 'Hace 1 anio' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 330 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 300 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 270 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 240 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 210 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 180 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 150 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 120 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 90 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 60 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) >= 29 AND DATEDIFF(SYSDATE(), DD_Creation_Date) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), DD_Creation_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), DD_Creation_Date)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'DD_Time_Ago',
  (select US_User_Login from ins_users_tb where US_User_Id = IP_By_User_Id) AS 'IP_Username', 
  (select US_Full_Name from ins_users_tb where US_User_Id = IP_By_User_Id) AS '`IP_Fullname',
  (select US_User_Id from ins_users_tb where US_User_Id = IP_By_User_Id) AS 'IP_User_Id'";
   $query = $query." FROM ins_users_tb, ins_dedications_tb, ins_phrases_tb, ins_inspiter_tb
WHERE DD_From_User_Id = US_User_Id
AND IP_Inspiter_Id = PH_Phrase_Id
AND DD_Inspiter_Id = IP_Inspiter_Id
AND DD_To_User_Id = (select SS_User_Id from ins_session_tb where SS_SSID= ".$ssid.")";
  if($dedicId != 0 && $dedicId != NULL)
   $query = $query." AND DD_Dedications_Id = ".$dedicId;
   
$query = $query." ORDER BY DD_Creation_Date DESC LIMIT 20";

  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
    $jsondata[$i]['DD_Dedications_Id'] = $row['DD_Dedications_Id']; 
    $jsondata[$i]['DD_Inspiter_Id'] = $row['DD_Inspiter_Id']; 
    $jsondata[$i]['DD_From_User_Id'] = $row['DD_From_User_Id']; 
    $jsondata[$i]['DD_To_User_Id'] = $row['DD_To_User_Id']; 
    $jsondata[$i]['DD_Comment'] = $row['DD_Comment']; 
    $jsondata[$i]['DD_Creation_Date'] = $row['DD_Creation_Date']; 
    $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
    $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
    $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
    $jsondata[$i]['US_Photo'] = $row['US_Photo']; 
    $jsondata[$i]['US_City'] = $row['US_City'];
    $jsondata[$i]['DD_Time_Ago'] = $row['DD_Time_Ago'];
    $jsondata[$i]['PH_Phrase'] = $row['PH_Phrase'];
    $jsondata[$i]['PH_Author'] = $row['PH_Author'];
    $jsondata[$i]['IP_Username'] = $row['IP_Username'];
    $jsondata[$i]['IP_Fullname'] = $row['IP_Fullname'];
    $jsondata[$i]['IP_User_Id'] = $row['IP_User_Id'];
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
 
 public static function is_denunciation_exist($userId)
 {
      try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_denunciation_tb 
                                     where DE_User_id = ".$userId);
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
}

?>