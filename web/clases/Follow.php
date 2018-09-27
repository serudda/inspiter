<?php

require_once 'Database.php';

class Follow {

    private $dadId;
    private $sunId;
    private $dateFollow;

    public function Follow($dadId = NULL, $sunId = NULL, $dateFollow = NULL) {
        $this->dadId = $dadId;
        $this->sunId = $sunId;
        $this->dateFollow = $dateFollow;
    }

    //getter
    public function getDadId() {
        return $this->dadId;
    }

    public function getSunId() {
        return $this->sunId;
    }

    public function getDateFollow() {
        return $this->dateFollow;
    }

    //setter  
    public function setFatherId($dadId) {
        $this->dadId = $dadId;
    }

    public function setSunId($sunId) {
        $this->sunId = $sunId;
    }

    public function setDateFollow($dateFollow) {
        $this->dateFollow = $dateFollow;
    }

    public function startToFollow() {
        
        try
        {
        DataBase::ExecuteQuery("CALL INSERT_FOLLOW_USER('" . $this->getDadId() . "','" . $this->getSunId() . "',@Output);");

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

    public static function leaveToFollow($dadId, $sunId) {
        try
        {
        DataBase::ExecuteQuery("CALL DELETE_FOLLOW_USER('" . $dadId . "','" . $sunId . "',@Output);");

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

    public static function getAmountSeguidores($ssid) {
        try {
            $query = "SELECT fw_dad_id, FW_Sun_Id FROM ins_follow_tb, ins_users_tb, ins_session_tb 
             WHERE FW_Dad_Id = US_User_Id
             AND US_User_id = SS_User_Id
             AND SS_SSID =" . $ssid;

            $result = DataBase::ExecuteQuery($query);

             if(((int) mysql_num_rows($result)-1) <= 0)
             return 0;
            else
             return (int) mysql_num_rows($result)-1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getAmountSiguiendo($ssid) {
        try {
            $query = "SELECT fw_dad_id, FW_Sun_Id FROM ins_follow_tb, ins_users_tb, ins_session_tb 
             WHERE FW_Sun_Id = US_User_Id
             AND US_User_id = SS_User_Id
             AND SS_SSID =" . $ssid;

            $result = DataBase::ExecuteQuery($query);

             if(((int) mysql_num_rows($result)-1) <= 0)
             return 0;
            else
             return (int) mysql_num_rows($result)-1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getSeguidoresData($userid, $ssid) {
        try {
            $query = "SELECT insfol.FW_Dad_Id, user.US_User_Login,user.US_Full_Name,user.US_City,user.US_Photo,insfol.FW_Sun_Id, (SELECT COUNT(*)
FROM ins_follow_tb,ins_users_tb
WHERE FW_DAD_Id = US_User_Id
AND insfol.FW_SUN_Id = US_User_Id
AND FW_SUN_Id = (SELECT SS_User_Id FROM ins_session_tb WHERE SS_SSID = " . $ssid . ")) as FW_Follow_Flag, conf.CF_IPS,
             insfol.FW_CreateDate
             FROM ins_follow_tb insfol,ins_users_tb user,ins_config_tb conf
             WHERE conf.CF_User_Id = user.US_User_Id 
             AND insfol.FW_SUN_Id = user.US_User_Id
             AND insfol.FW_DAD_Id = ".$userid." and user.US_User_Id  not in (select US_User_Id from ins_users_tb where US_User_Id =".$userid.")";
            
             $query = $query." order by FW_CreateDate DESC";

            $result = DataBase::ExecuteQuery($query);
            $jsondata = array();
            $i = mysql_num_rows($result) - 1;
            while ($row = mysql_fetch_assoc($result)) {
                $jsondata[$i]['FW_Dad_Id'] = $row['FW_Dad_Id'];
                $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
                $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
                $jsondata[$i]['US_City'] = $row['US_City'];
                $jsondata[$i]['US_Photo'] = $row['US_Photo'];
                $jsondata[$i]['FW_Sun_Id'] = $row['FW_Sun_Id'];
                $jsondata[$i]['FW_Follow_Flag'] = $row['FW_Follow_Flag'];
                $jsondata[$i]['CF_IPS'] = $row['CF_IPS'];
                $i--;
            }
            $jsondata = array_reverse($jsondata);
            return json_encode($jsondata);
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getSiguiendoData($userid, $ssid) {
        try {
            $query = "SELECT FW_Sun_Id,US_User_Login,US_Full_Name,US_City,US_Photo,FW_Dad_Id, (SELECT COUNT(*)
FROM ins_follow_tb,ins_users_tb
WHERE FW_DAD_Id = US_User_Id
AND insfol.FW_Dad_Id = US_User_Id
AND FW_SUN_Id = (SELECT SS_User_Id FROM ins_session_tb WHERE SS_SSID = " . $ssid . ")) as FW_Follow_Flag, conf.CF_IPS,
     FW_CreateDate
FROM ins_follow_tb insfol,ins_users_tb user,ins_config_tb conf
 WHERE conf.CF_User_Id = user.US_User_Id 
 AND FW_DAD_Id = US_User_Id
 AND FW_SUN_Id = " . $userid." and user.US_User_Id  not in (select US_User_Id from ins_users_tb where US_User_Id =".$userid.")";
            $query = $query." ORDER BY FW_CreateDate DESC"; 

            $result = DataBase::ExecuteQuery($query);
            $jsondata = array();
            $i = mysql_num_rows($result) - 1;
            while ($row = mysql_fetch_assoc($result)) {
                $jsondata[$i]['FW_Sun_Id'] = $row['FW_Sun_Id'];
                $jsondata[$i]['US_User_Login'] = $row['US_User_Login'];
                $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name'];
                $jsondata[$i]['US_City'] = $row['US_City'];
                $jsondata[$i]['US_Photo'] = $row['US_Photo'];
                $jsondata[$i]['FW_Dad_Id'] = $row['FW_Dad_Id'];
                $jsondata[$i]['FW_Follow_Flag'] = $row['FW_Follow_Flag'];
                $jsondata[$i]['CF_IPS'] = $row['CF_IPS'];
                $i--;
            }
            $jsondata = array_reverse($jsondata);
            return json_encode($jsondata);
        } catch (Exception $e) {
            return 0;
        }
    }

//friends

    public static function getAmountSeguidoresFriend($userId) {
        try {
            $query = "SELECT fw_dad_id, FW_Sun_Id FROM ins_follow_tb, ins_users_tb 
             WHERE FW_Dad_Id = US_User_Id
             AND US_User_Id =" . $userId;

            $result = DataBase::ExecuteQuery($query);

             if(((int) mysql_num_rows($result)-1) <= 0)
             return 0;
            else
             return (int) mysql_num_rows($result)-1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getAmountSiguiendoFriend($userId) {
        try {
            $query = "SELECT fw_dad_id, FW_Sun_Id FROM ins_follow_tb, ins_users_tb
             WHERE FW_Sun_Id = US_User_Id
             AND US_User_Id =" . $userId;

            $result = DataBase::ExecuteQuery($query);

             if(((int) mysql_num_rows($result)-1) <= 0)
             return 0;
            else
             return (int) mysql_num_rows($result)-1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getFollowUserFlag($dadId, $sunId) {

        try {
            $query = "SELECT count(*) from ins_follow_tb
             WHERE FW_Sun_Id = " . $sunId .
                    " AND FW_Dad_Id =" . $dadId;

            $result = DataBase::ExecuteQuery($query);

            $outputResult = mysql_fetch_row($result);
            if ($outputResult[0] == '1')
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>