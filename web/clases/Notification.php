<?php
require_once 'Database.php';
require_once 'Session.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase utilizada para guardar cada una de las notificaciones que el usuario genera en la app
 *
 * @author Inspiter
 */
class Notification {
    
    private $notifId;
    private $userEventId;
    private $userNotifiedId;
    private $inspiterId;
    private $typeId;
    private $status;
    private $createDate;
    private $dedicationId;

    public function Notification($notifId=NULL,$userEventId=NULL,$userNotifiedId=NULL,$inspiterId=NULL,$typeId=NULL,$status=NULL,$createDate=NULL,$dedicationId=NULL) 
    {
        $this->userEventId = $userEventId;
        $this->userNotifiedId = $userNotifiedId;
        $this->inspiterId = $inspiterId;
        $this->typeId = $typeId;
        $this->status = $status;
        $this->dedicationId = $dedicationId;
    }
    
    
    //getter
    public function getUserEventId() {
        return $this->userEventId;
    }

    public function getUserNotifiedId() {
        return $this->userNotifiedId;
    }

    public function getInspiterId() {
        return $this->inspiterId;
    }
    
    public function getTypeId() {
        return $this->typeId;
    }

    public function getStatus() {
        return $this->status;
    }
    
    public function getDedicationId() {
        return $this->dedicationId;
    }

    //setter  
    public function setUserEventId($userEventId) {
        $this->userEventId = $userEventId;
    }

    public function setUserNotifiedId($userNotifiedId) {
        $this->userNotifiedId = $userNotifiedId;
    }

    public function setInspiterId($inspiterId) {
        $this->inspiterId = $inspiterId;
    }
    
    public function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function setDedicationId($dedicationId) {
        $this->dedicationId = $dedicationId;
    }
    
    public function insertNotification()
    {
        try
        {
        DataBase::ExecuteQuery("CALL INSERT_NOTIFICATION('".$this->getUserEventId()."','".$this->getUserNotifiedId()."','".$this->getInspiterId()."','".$this->getTypeId()."','".$this->getDedicationId()."',@Output);");

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
    
     public static function getNotificationData($ssid) {
        try {
            $query = "select `NO_Notif_Id`, `NO_User_Event_Id`, `NO_User_Notified_Id`, `NO_Inspiter_Id`, `NO_Type_Id`, 
                             `NO_Status`, `NO_CreateDate`,`NO_Dedication_Id`, US_User_Id,`US_Email`,`US_User_Login`,`US_Full_Name`,`US_Photo`, `US_Photo_Small`, 
                             `NT_Name`, `NT_Descripcion`, (SELECT US_User_Login FROM ins_users_tb
                                                           WHERE US_User_Id = IP_By_User_Id
                                                           ) AS 'IP_By_User',
                                                           (SELECT US_Full_Name FROM ins_users_tb
                                                           WHERE US_User_Id = IP_By_User_Id
                                                           ) AS 'IP_Full_Name',
                    CASE 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 360 AND DATEDIFF(SYSDATE(), NO_CreateDate) <= 365 THEN 'Hace 1 anio' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 330 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 300 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 270 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 240 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 210 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 180 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 150 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 120 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 90 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 60 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) >= 29 AND DATEDIFF(SYSDATE(), NO_CreateDate) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), NO_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), NO_CreateDate)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'NO_Time_Ago',
  (select US_User_Login from ins_users_tb,ins_session_tb where SS_User_Id = US_User_Id and SS_SSID=".$ssid.") as 'SS_User_Login'
             FROM ins_users_tb, ins_notificationtype_tb, ins_notifications_tb
             LEFT OUTER JOIN ins_inspiter_tb ON IP_Inspiter_Id = NO_Inspiter_Id
             WHERE NO_User_Event_Id = US_User_Id
             and NT_Id = NO_Type_Id
             and NO_User_Notified_Id = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")";
             $query = $query." order by NO_CreateDate DESC";
             $query = $query." limit 60";

            $result = DataBase::ExecuteQuery($query);
            $jsondata = array();
            $i = mysql_num_rows($result) - 1;
            while ($row = mysql_fetch_assoc($result)) {
                $jsondata[$i]['NO_Notif_Id'] = $row['NO_Notif_Id'];
                $jsondata[$i]['NO_User_Event_Id'] = $row['NO_User_Event_Id'];
                $jsondata[$i]['NO_User_Notified_Id'] = $row['NO_User_Notified_Id'];
                $jsondata[$i]['NO_Inspiter_Id'] = $row['NO_Inspiter_Id'];
                $jsondata[$i]['NO_Type_Id'] = $row['NO_Type_Id'];
                $jsondata[$i]['NO_CreateDate'] = $row['NO_CreateDate'];
                $jsondata[$i]['US_User_Id'] = $row['US_User_Id'];
                $jsondata[$i]['US_Email'] = $row['US_Email'];
                $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
                $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
                $jsondata[$i]['US_Photo'] = $row['US_Photo'];
                $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small'];
                $jsondata[$i]['NT_Name'] = $row['NT_Name'];
                $jsondata[$i]['NT_Descripcion'] = $row['NT_Descripcion'];
                $jsondata[$i]['NO_Time_Ago'] = $row['NO_Time_Ago'];
                $jsondata[$i]['NO_Status'] = $row['NO_Status'];
                $jsondata[$i]['SS_User_Login'] = $row['SS_User_Login'];
                $jsondata[$i]['IP_By_User'] = $row['IP_By_User'];
                $jsondata[$i]['IP_Full_Name'] = $row['IP_Full_Name'];
                $jsondata[$i]['NO_Dedication_Id'] = $row['NO_Dedication_Id'];
                $i--;
            }
            $jsondata = array_reverse($jsondata);
            $jsondata = array_reverse($jsondata);
            return json_encode($jsondata);
        } catch (Exception $e) {
            return false;
        }
    }
    
   public static function getNotificationAmount($ssid) {
        try {
            $query = "select count(*)
             FROM ins_notifications_tb
             WHERE NO_User_Notified_Id = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")
             AND NO_STATUS = 1";

            $result = DataBase::ExecuteQuery($query);
            $OutputResult = mysql_fetch_row($result);
            
            return $OutputResult[0];
           }
        catch (Exception $e) {
            return 0;
        }
   }
   
 public static function setNotifVisto($notifiedId) {
       try
        {
        DataBase::ExecuteQuery("CALL Visto($notifiedId,@Output);");

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
}
?>
