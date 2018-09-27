<?php
require_once 'Database.php';
class Comment
{
 protected $commentId;
 protected $inspiterId;
 protected $userId;
 protected $comment;
 protected $commentDate;
 
 public function Comment($commentId=NULL,$inspiterId=NULL,$userId=NULL, $comment=NULL,$commentDate=NULL)
 {
  $this->commentId = $commentId;
  $this->inspiterId = $inspiterId;
  $this->userId = $userId;
  $this->comment = $comment;
  $this->commentDate = $commentDate;
 }
 
 //getter
 public function getCommentId()
 {return $this->dedicationId;}
 
 public function getInspiterId()
 {return $this->inspiterId;}
 
 public function getUserId()
 {return $this->userId;}
 
  public function getComment()
 {return $this->comment;}
 
 public function getCommentDate()
 {return $this->commentDate;}
 
 
 
 //setter
 public function setCommentId($dedicationId)
 {$this->dedicationId = $dedicationId;}
  
 public function setInspiterId($inspiterId)
  {$this->inspiterId = $inspiterId;}
  
 public function setUserId($userId)
 {$this->userId = $userId;}
  
 public function setComment($comment)
 {$this->comment = $comment;}
  
 public function setCommentDate($commentDate)
  {$this->commentDate = $commentDate;}
  
 public function insertComment()
 {
      try
        {
        DataBase::ExecuteQuery("CALL INSERT_COMMENT('".$this->getInspiterId()."','".$this->getUserId()."','".$this->getComment()."',@OUTPUT,@p_Comment_Id);");

        $result = DataBase::ExecuteQuery("select @Output,@p_Comment_Id");
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
 
  public static function deleteComment($pCommentId,$pUserId)
 {
      try
        {
        DataBase::ExecuteQuery("CALL DELETE_COMMENT('".$pCommentId."','".$pUserId."',@Output);");

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
 
 
 public static function getAmountComment($userId,$inspiterId)
 {
     try {
            $query = "SELECT count(*) from ins_comment_tb
             WHERE AND CM_Inspiter_id = ".$inspiterId;
            $result = DataBase::ExecuteQuery($query);
            $outputResult = mysql_fetch_row($result);
                return $outputResult[0];
        } catch (Exception $e) {
            return 0;
        }
 }
 

public static function getCommentData($ssid,$inspiterId)
{    
   
   try
    {
     $query = "SELECT US_User_Id, US_User_Login, US_Full_Name, US_Photo, CM_Comm_id, CM_Inspiter_id, CM_User_id, CM_Comment, CM_Create_Date,";
     $query = $query." CASE 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 360 AND DATEDIFF(SYSDATE(), CM_Create_Date) <= 365 THEN 'Hace 1 anio'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 330 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 300 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 270 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 240 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 210 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 180 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 150 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 120 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 90 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 60 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) >= 29 AND DATEDIFF(SYSDATE(), CM_Create_Date) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), CM_Create_Date) = 0 AND HOUR(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), CM_Create_Date)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'CM_Time_Ago', 
 (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
 (select IP_By_User_Id from ins_inspiter_tb where IP_Inspiter_Id=".$inspiterId.") as 'IP_User_Id'
  FROM   ins_users_tb, ins_comment_tb 
  WHERE  US_User_Id = CM_User_Id
  AND    CM_Inspiter_Id = $inspiterId
  ORDER BY CM_Create_Date DESC";
       
  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; 
  while ($row = mysql_fetch_assoc($result)) 
  { 
	$jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
	$jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
        $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
	$jsondata[$i]['US_Photo'] = $row['US_Photo']; 
	$jsondata[$i]['CM_Comm_id'] = $row['CM_Comm_id']; 
	$jsondata[$i]['CM_Inspiter_id'] = $row['CM_Inspiter_id']; 
	$jsondata[$i]['CM_Create_Date'] = $row['CM_Create_Date']; 
	$jsondata[$i]['CM_User_id'] = $row['CM_User_id'];
	$jsondata[$i]['CM_Comment'] = $row['CM_Comment'];
        $jsondata[$i]['CM_Time_Ago'] = $row['CM_Time_Ago'];
	$jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
        $jsondata[$i]['IP_User_Id'] = $row['IP_User_Id'];
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

 
}

?>