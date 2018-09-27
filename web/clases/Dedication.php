<?php
require_once 'Database.php';
class Dedication
{
 protected $dedicationId;
 protected $inspiterId;
 protected $userFromId;
 protected $userToId;
 protected $comment;
 protected $dedicationDate;
 
 public function Dedication($dedicationId=NULL,$inspiterId=NULL,$userFromId=NULL,$userToId=NULL,$comment=NULL,$dedicationDate=NULL)
 {
  $this->dedicationId = $dedicationId;
  $this->inspiterId = $inspiterId;
  $this->userFromId = $userFromId;
  $this->userToId = $userToId;
  $this->comment = $comment;
  $this->dedicationDate = $dedicationDate;
 }
 
 //getter
 public function getDedicationId()
 {return $this->dedicationId;}
 
 public function getInspiterId()
 {return $this->inspiterId;}
 
 public function getUserFromId()
 {return $this->userFromId;}
 
 public function getUserToId()
 {return $this->userToId;}
 
  public function getComment()
 {return $this->comment;}
 
 public function getDedicationDate()
 {return $this->dedicationDate;}
 
 
 
 //setter
 public function setDedicationId($dedicationId)
 {$this->dedicationId = $dedicationId;}
  
 public function setInspiterId($inspiterId)
  {$this->inspiterId = $inspiterId;}
  
 public function setUserFromId($userFromId)
 {$this->userFromId = $userFromId;}
  
 public function setUserToId($userToId)
  {$this->userToId = $userToId;}
  
 public function setComment($comment)
 {$this->comment = $comment;}
  
 public function setDedicationDate($dedicationDate)
  {$this->dedicationDate = $dedicationDate;}
  
 public function insertDedication()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_DEDICATIONS('".$this->getInspiterId()."','".$this->getUserFromId()."','".$this->getUserToId()."','".$this->getComment()."',@OUTPUT,@dedication_Id);");

        $result = DataBase::ExecuteQuery("select @Output,@dedication_Id");
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
 
  public static function deleteDedication($pDedicationId)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_DEDICATION('".$pDedicationId."',@Output);");

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
 
 
 public static function getAmountDedicationToOther($userId)
 {
     try {
            $query = "SELECT count(*) from ins_dedications_tb
             WHERE DD_From_User_Id = ".$userId;
            $result = DataBase::ExecuteQuery($query);
            $outputResult = mysql_fetch_row($result);
                return $outputResult[0];
        } catch (Exception $e) {
            return 0;
        }
 }
 
  
 public static function getAmountDedicationToMe($userId)
 {
     try {
             $query = "SELECT count(*) from ins_dedications_tb
             WHERE DD_To_User_Id = ".$userId;
            $result = DataBase::ExecuteQuery($query);
            $outputResult = mysql_fetch_row($result);
                return $outputResult[0];
        } catch (Exception $e) {
            return 0;
        }
 }
 
public static function getDedicationData($userId,$ssid,$dedicId)
{    
    try
    {
     $query = "SELECT DD_Dedications_Id, DD_Inspiter_Id, DD_From_User_Id, DD_To_User_Id, DD_Comment, DD_Creation_Date, US_User_Id, US_User_Login, US_Full_Name, US_Photo_Small, US_City,";
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
  (select US_User_Login from ins_users_tb where US_User_Id = ins.IP_By_User_Id) AS 'IP_Username', 
  (select US_Full_Name from ins_users_tb where US_User_Id = ins.IP_By_User_Id) AS 'IP_Fullname',
  (select US_User_Id from ins_users_tb where US_User_Id = ins.IP_By_User_Id) AS 'IP_User_Id',
  tipoInsp.IP_Value1 as IP_Value1, tipoInsp.IP_Value2 as IP_Value2, tipoInsp.IP_Value3 as IP_Value3, tipoInsp.IP_Value4 as IP_Value4, tipoInsp.IP_Value5 as IP_Value5, tipoInsp.IP_Value6 as IP_Value6,tipoInsp.IP_Value7 as IP_Value7,tipoInsp.IP_Value8 as IP_Value8, tipoInsp.IP_Type as IP_Type";
   
    $query = $query." FROM ins_users_tb, ins_dedications_tb, ins_inspiter_tb ins,  
   (SELECT IP_Inspiter_Id, IP_By_User_Id, PH_Phrase AS IP_Value1, PH_Author AS IP_Value2, PH_Author_Id AS IP_Value3, PH_Author AS IP_Value4, PH_Author_Id as IP_Value5,PH_Phrase AS IP_Value6,PH_Author_Id as IP_Value7, PH_Author_Id as IP_Value8, 'text' as IP_Type
    FROM ins_inspiter_tb, ins_phrases_tb
    WHERE IP_Inspiter_Id = PH_Phrase_Id
    UNION
    SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5,IM_Original_Uri AS IP_Value6,IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
    FROM ins_inspiter_tb, ins_image_tb
    WHERE IP_Inspiter_Id = IM_Image_Id
    UNION
    SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5,VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
    FROM ins_inspiter_tb, ins_video_tb
    WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
    WHERE DD_From_User_Id = US_User_Id
    and tipoInsp.IP_Inspiter_Id = ins.IP_Inspiter_Id
    AND DD_Inspiter_Id = ins.IP_Inspiter_Id
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
    $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
    $jsondata[$i]['US_City'] = $row['US_City'];
    $jsondata[$i]['DD_Time_Ago'] = $row['DD_Time_Ago'];
    $jsondata[$i]['IP_Username'] = $row['IP_Username'];
    $jsondata[$i]['IP_Fullname'] = $row['IP_Fullname'];
    $jsondata[$i]['IP_User_Id'] = $row['IP_User_Id'];
    $jsondata[$i]['IP_Value1'] = $row['IP_Value1'];
    $jsondata[$i]['IP_Value2'] = $row['IP_Value2'];
    $jsondata[$i]['IP_Value3'] = $row['IP_Value3'];
    $jsondata[$i]['IP_Value4'] = $row['IP_Value4'];
    $jsondata[$i]['IP_Value5'] = $row['IP_Value5'];
    $jsondata[$i]['IP_Value6'] = $row['IP_Value6'];
    $jsondata[$i]['IP_Value7'] = $row['IP_Value7'];
    $jsondata[$i]['IP_Value8'] = $row['IP_Value8'];
    $jsondata[$i]['IP_Type'] = $row['IP_Type'];
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
 
 public static function getDedicationDataToShareFace($dedicId)
 {
   try
   {    
     $query = "SELECT `IP_Inspiter_Id`,`IP_By_User_Id`,`DD_Dedications_Id`,`DD_Inspiter_Id`,`DD_From_User_Id`,
                      `DD_To_User_Id`,`DD_Comment`,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Face_Id`,
                      (SELECT US_Full_Name FROM ins_users_tb WHERE US_User_Id = DD_From_User_Id) AS DD_Full_Name_From,
                      (SELECT US_User_Login FROM ins_users_tb WHERE US_User_Id = IP_By_User_Id) AS IP_User_Login,
                      (SELECT IF ((select count(*) from ins_image_tb where IM_Image_Id = IP_Inspiter_Id) > 0,'image',IF ((select count(*) from ins_video_tb where VI_Video_id = IP_Inspiter_Id) > 0,'video','frase'))) as DD_Inspiter_Type
               FROM ins_dedications_tb, ins_users_tb, ins_inspiter_tb
               WHERE  IP_Inspiter_Id    = DD_Inspiter_Id
               AND    US_User_Id        = DD_To_User_Id
               AND    DD_Dedications_Id = $dedicId";
    $result = DataBase::ExecuteQuery($query);
    $jsondata = array(); 
    $i = mysql_num_rows($result)-1; //0
    while ($row = mysql_fetch_assoc($result)) 
    { 
        $jsondata[$i]['IP_Inspiter_Id'] = $row['IP_Inspiter_Id']; 
        $jsondata[$i]['IP_By_User_Id'] = $row['IP_By_User_Id']; 
	$jsondata[$i]['DD_Dedications_Id'] = $row['DD_Dedications_Id']; 
        $jsondata[$i]['DD_Inspiter_Id'] = $row['DD_Inspiter_Id']; 
	$jsondata[$i]['DD_From_User_Id'] = $row['DD_From_User_Id']; 
	$jsondata[$i]['DD_To_User_Id'] = $row['DD_To_User_Id']; 
	$jsondata[$i]['DD_Comment'] = $row['DD_Comment']; 
	$jsondata[$i]['US_Email'] = $row['US_Email']; 
	$jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
	$jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
	$jsondata[$i]['US_Face_Id'] = $row['US_Face_Id'];
	$jsondata[$i]['DD_Full_Name_From'] = $row['DD_Full_Name_From'];
        $jsondata[$i]['IP_User_Login'] = $row['IP_User_Login'];
        $jsondata[$i]['DD_Inspiter_Type'] = $row['DD_Inspiter_Type'];
	$i--; 
  } 
  
 // asort($jsondata);
  $jsondata = array_reverse($jsondata);
  return json_encode($jsondata);
  }
     catch(Exception $e)
     {
         return false;
     }
}

 public static function is_dedication_exist($userToId, $dedicId)
 {
      try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_dedications_tb 
                                     where DD_To_User_id = ".$userToId." and DD_Dedications_Id = ".$dedicId);
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