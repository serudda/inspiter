<?php
require_once 'Database.php';
class Inspiter
{
 private $inspiterId;
 private $userId;
 private $category;

 
 public function Inspiter($inspiterId=NULL,$userId=NULL,$category=NULL)
 {
  $this->inspiterId = $inspiterId;
  $this->userId = $userId;
  $this->category = $category;
 }
 
 //getter
 public function getInspiterId()
 {return $this->inspiterId;}
 
 public function getUserId()
 {return $this->userId;}
  
 public function getCategory()
 {return $this->category;}
 
 
 //setter
 public function setInspiterId($inspiterId)
 {$this->inspiterId = $inspiterId;}
  
 public function setUserId($userId)
  {$this->userId = $userId;}
  
 public function setCategory($category)
 {$this->category = $category;}
 	 
public static function getInspiterData($userId,$ssid,$firstInspiterId,$type,$inspiterId,$wordSearch,$inspiterType)
{    
  try 
  {
   if($inspiterType == 'text')  /**** TEXT PROCESS ****/
   {
    $query = "SELECT PH_Phrase_Id, PH_Phrase, PH_Author, US_User_Id, US_User_Login, US_Full_Name, US_Photo_Small, US_City, IP_CreateDate,";
    $query = $query." CASE 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 360 AND DATEDIFF(SYSDATE(), IP_CreateDate) <= 365 THEN 'Hace 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 330 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 300 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 270 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 240 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 210 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 180 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 150 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 120 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 90 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 60 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 29 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'PH_Time_Ago', 
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Cant_Insp',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IN_Inspire_User = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") AND ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Inspire_Phrase', 
  (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
  (select US_User_Login from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_Username_Logged',
  (select US_Full_Name from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserFullName_Logged',
  (select US_Photo_Small from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserPhoto_Logged',
  (select count(*) FROM ins_favourites_tb fav WHERE  FV_Inspiter_Id = ip.IP_Inspiter_Id AND fav.FV_ser_Id =(select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")) as 'FV_Is_In_Favourite',
  (select count(*) FROM ins_comment_tb where CM_Inspiter_id = ip.IP_Inspiter_Id) as 'CM_Comment_Amount'";
   
if($type == 'seguidores')
{
	$query = $query." FROM ins_users_tb AS us,ins_phrases_tb AS ph, ins_inspiter_tb as ip, ins_follow_tb AS fol
WHERE  us.US_User_Id = ip.IP_By_User_Id
AND ip.IP_Inspiter_Id = ph.PH_Phrase_Id
AND fol.FW_Dad_Id = us.US_User_Id
AND fol.FW_Sun_Id = ".$userId;
}
else if ($type == 'favoritos')
{
    $query = $query." FROM ins_favourites_tb fav, ins_phrases_tb ph, ins_inspiter_tb as ip, ins_users_tb AS us
WHERE fav.FV_Inspiter_Id = ph.PH_Phrase_Id
AND ip.IP_By_User_Id = us.US_User_Id
AND ip.IP_Inspiter_Id = ph.PH_Phrase_Id
AND fav.FV_ser_Id = ".$userId;
}
else if ($type == 'top')
{
	$query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph, ins_inspiter_tb as ip 
WHERE  us.US_User_Id = ip.IP_By_User_Id 
AND ip.IP_Inspiter_Id = ph.PH_Phrase_Id ";
}
else
{
	$query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph, ins_inspiter_tb as ip 
WHERE  us.US_User_Id = ip.IP_By_User_Id 
AND ip.IP_Inspiter_Id = ph.PH_Phrase_Id ";
}

if ($type == 'perfil')
{
   $query = $query." AND    us.US_User_Id = ".$userId;
   if($inspiterId != 0)
     $query = $query." AND ip.IP_Inspiter_Id = ".$inspiterId;
   
   if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'favoritos')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
 ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'recientes')
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'top')
{
   $query = $query." ORDER BY IN_Cant_Insp DESC, (select CF_IPS FROM ins_config_tb where CF_User_Id = us.US_User_Id) DESC, IP_CreateDate DESC LIMIT 10";
}
else if($type == 'aleatorios')
{
  if ($firstInspiterId == '0')
   {$query = $query." ORDER BY RAND() DESC LIMIT 50";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY RAND() DESC LIMIT 20";}
}
else if ($type == 'seguidores')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
  {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
    ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'inspiraciones') 
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
    $jsondata[$i]['PH_Phrase_Id'] = $row['PH_Phrase_Id']; 
    $jsondata[$i]['PH_Phrase'] = $row['PH_Phrase'];  
    $jsondata[$i]['PH_Author'] = $row['PH_Author']; 
    $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
    $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
    $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
    $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
    $jsondata[$i]['US_City'] = $row['US_City']; 
    $jsondata[$i]['IP_CreateDate'] = $row['IP_CreateDate']; 
    $jsondata[$i]['PH_Time_Ago'] = $row['PH_Time_Ago'];
    $jsondata[$i]['IN_Cant_Insp'] = $row['IN_Cant_Insp'];
    $jsondata[$i]['IN_Inspire_Phrase'] = $row['IN_Inspire_Phrase'];
    $jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
    $jsondata[$i]['FV_Is_In_Favourite'] = $row['FV_Is_In_Favourite'];
    $jsondata[$i]['CM_Comment_Amount'] = $row['CM_Comment_Amount'];
    $jsondata[$i]['SS_Username_Logged'] = $row['SS_Username_Logged']; 
    $jsondata[$i]['SS_UserFullName_Logged'] = $row['SS_UserFullName_Logged']; 
    $jsondata[$i]['SS_UserPhoto_Logged'] = $row['SS_UserPhoto_Logged'];
    $i--; 
  } 
   if($firstInspiterId == '0')
   {
     $jsondata = array_reverse($jsondata);
   }
   else
   {
     $jsondata = array_reverse($jsondata);
     $jsondata = array_reverse($jsondata);
   }
  return json_encode($jsondata);

  }
else if($inspiterType == 'media')  /**** MEDIA PROCESS (Image, Video)****/
{
     //$query = "SELECT IM_Image_Id, IM_Uri, IM_Title, IM_Description, IM_Image_Height, US_User_Id, US_User_Login, US_Full_Name, US_Photo, US_City, IP_CreateDate,";
    $query = "SELECT ip.IP_Inspiter_Id as 'IP_Inspiter_Id', US_User_Id, US_User_Login, US_Full_Name, US_Photo_Small, US_City,IP_CreateDate,";
    $query = $query." CASE 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 360 AND DATEDIFF(SYSDATE(), IP_CreateDate) <= 365 THEN 'Hace 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 330 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 300 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 270 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 240 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 210 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 180 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 150 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 120 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 90 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 60 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 29 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'IP_Time_Ago', 
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Cant_Insp',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IN_Inspire_User = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") AND ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Inspire_Media', 
  (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
  (select US_User_Login from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_Username_Logged',
  (select US_Full_Name from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserFullName_Logged',
  (select US_Photo_Small from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserPhoto_Logged',
  (select count(*) FROM ins_favourites_tb fav WHERE  FV_Inspiter_Id = ip.IP_Inspiter_Id AND fav.FV_ser_Id =(select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")) as 'FV_Is_In_Favourite',
  (select count(*) FROM ins_comment_tb where CM_Inspiter_id = ip.IP_Inspiter_Id) as 'CM_Comment_Amount',
  tipoInsp.IP_Value1 as IP_Value1, tipoInsp.IP_Value2 as IP_Value2, tipoInsp.IP_Value3 as IP_Value3, tipoInsp.IP_Value4 as IP_Value4, tipoInsp.IP_Value5 as IP_Value5,tipoInsp.IP_Value6 as IP_Value6,tipoInsp.IP_Value7 as IP_Value7,tipoInsp.IP_Value8 as IP_Value8, tipoInsp.IP_Type as IP_Type";

   
if($type == 'seguidores')
{
	$query = $query." FROM   ins_users_tb AS us, ins_inspiter_tb as ip, ins_follow_tb AS fol,
(SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5, IM_Original_Uri as IP_Value6, IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5,VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
WHERE  us.US_User_Id = ip.IP_By_User_Id
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id
AND fol.FW_Dad_Id = us.US_User_Id
AND fol.FW_Sun_Id = ".$userId;
}
else if ($type == 'favoritos')
{
    $query = $query." FROM ins_favourites_tb fav, ins_inspiter_tb as ip, ins_users_tb AS us,
(SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5, IM_Original_Uri as IP_Value6, IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5,VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
WHERE fav.FV_Inspiter_Id = ip.IP_Inspiter_Id
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id
AND ip.IP_By_User_Id = us.US_User_Id
AND fav.FV_ser_Id = ".$userId;
}
else if ($type == 'top')
{
   $query = $query." FROM   ins_users_tb as us, ins_inspiter_tb as ip,  
(SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5,IM_Original_Uri as IP_Value6,IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5,VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
WHERE  us.US_User_Id = ip.IP_By_User_Id 
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id ";
}
else
{
	$query = $query." FROM   ins_users_tb as us, ins_inspiter_tb as ip,  
(SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5,IM_Original_Uri as IP_Value6,IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5,VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
WHERE  us.US_User_Id = ip.IP_By_User_Id 
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id ";
}

if ($type == 'perfil')
{
   $query = $query." AND us.US_User_Id = ".$userId;
   if($inspiterId != 0)
     $query = $query." AND ip.IP_Inspiter_Id = ".$inspiterId;
   
   if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'favoritos')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
 ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'recientes')
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'top')
{
   $query = $query." ORDER BY IN_Cant_Insp DESC, (select CF_IPS FROM ins_config_tb where CF_User_Id = us.US_User_Id) DESC, IP_CreateDate DESC LIMIT 10";
}
else if($type == 'aleatorios')
{
  if ($firstInspiterId == '0')
   {$query = $query." ORDER BY RAND() DESC LIMIT 50";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY RAND() DESC LIMIT 20";}
}
else if ($type == 'seguidores')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
  {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
    ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'inspiraciones') 
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
    $jsondata[$i]['IP_Inspiter_Id'] = $row['IP_Inspiter_Id']; 
    $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
    $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
    $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
    $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
    $jsondata[$i]['US_City'] = $row['US_City']; 
    $jsondata[$i]['IP_CreateDate'] = $row['IP_CreateDate']; 
    $jsondata[$i]['IP_Time_Ago'] = $row['IP_Time_Ago'];
    $jsondata[$i]['IN_Cant_Insp'] = $row['IN_Cant_Insp'];
    $jsondata[$i]['IN_Inspire_Media'] = $row['IN_Inspire_Media'];
    $jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
    $jsondata[$i]['FV_Is_In_Favourite'] = $row['FV_Is_In_Favourite'];
    $jsondata[$i]['CM_Comment_Amount'] = $row['CM_Comment_Amount'];
    $jsondata[$i]['SS_Username_Logged'] = $row['SS_Username_Logged']; 
    $jsondata[$i]['SS_UserFullName_Logged'] = $row['SS_UserFullName_Logged']; 
    $jsondata[$i]['SS_UserPhoto_Logged'] = $row['SS_UserPhoto_Logged'];
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
   if($firstInspiterId == '0')
   {
     $jsondata = array_reverse($jsondata);
   }
   else
   {
     $jsondata = array_reverse($jsondata);
     $jsondata = array_reverse($jsondata);
   }
  return json_encode($jsondata);
 } 
 
 else if($inspiterType == 'all')  /**** ALL PROCESS ****/
 {
    $query = "SELECT ip.IP_Inspiter_Id as 'IP_Inspiter_Id', US_User_Id, US_User_Login, US_Full_Name, US_Photo_Small, US_City, IP_CreateDate,";
    $query = $query."CASE 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 366 THEN 'Hace mas de 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 360 AND DATEDIFF(SYSDATE(), IP_CreateDate) <= 365 THEN 'Hace 1 anio' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 330 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 360 THEN 'Hace 11 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 300 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 330 THEN 'Hace 10 meses'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 270 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 300 THEN 'Hace 9 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 240 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 270 THEN 'Hace 8 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 210 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 240 THEN 'Hace 7 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 180 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 210 THEN 'Hace 6 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 150 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 180 THEN 'Hace 5 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 120 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 150 THEN 'Hace 4 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 90 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 120 THEN 'Hace 3 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 60 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 90 THEN 'Hace 2 meses' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) >= 29 AND DATEDIFF(SYSDATE(), IP_CreateDate) < 60 THEN 'Hace 1 mes' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 28 THEN 'Hace 28 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 27 THEN 'Hace 27 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 26 THEN 'Hace 26 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 25 THEN 'Hace 25 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 24 THEN 'Hace 24 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 23 THEN 'Hace 23 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 22 THEN 'Hace 22 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 21 THEN 'Hace 21 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 20 THEN 'Hace 20 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 19 THEN 'Hace 19 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 18 THEN 'Hace 18 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 17 THEN 'Hace 17 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 16 THEN 'Hace 16 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 15 THEN 'Hace 15 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 14 THEN 'Hace 14 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 13 THEN 'Hace 13 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 12 THEN 'Hace 12 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 11 THEN 'Hace 11 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 10 THEN 'Hace 10 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 9 THEN 'Hace 9 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 8 THEN 'Hace 8 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 7 THEN 'Hace 7 dias' 
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 6 THEN 'Hace 6 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 5 THEN 'Hace 5 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 4 THEN 'Hace 4 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 3 THEN 'Hace 3 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 2 THEN 'Hace 2 dias'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 1 THEN 'Hace 1 dia'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 23 THEN 'Hace 23 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 22 THEN 'Hace 22 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 21 THEN 'Hace 21 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 20 THEN 'Hace 20 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 19 THEN 'Hace 19 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 18 THEN 'Hace 18 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 17 THEN 'Hace 17 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 16 THEN 'Hace 16 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 15 THEN 'Hace 15 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14 THEN 'Hace 14 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13 THEN 'Hace 13 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12 THEN 'Hace 12 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11 THEN 'Hace 11 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10 THEN 'Hace 10 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9 THEN 'Hace 9 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8 THEN 'Hace 8 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7 THEN 'Hace 7 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6 THEN 'Hace 6 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5 THEN 'Hace 5 horas'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4 THEN 'Hace 4 horas'
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 3 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 3 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 3 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND  MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 3 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 2 horas y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 2 horas y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 2 horas y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 2 horas'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 1 hora y 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 1 hora y 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 1 hora y 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 0  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 15 THEN 'Hace 1 hora'  
  
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 45  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 59 THEN 'Hace 45 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 30  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 45 THEN 'Hace 30 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) > 15  AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) <= 30 THEN 'Hace 15 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 14  THEN 'Hace 14 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 13  THEN 'Hace 13 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 12  THEN 'Hace 12 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 11  THEN 'Hace 11 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 10  THEN 'Hace 10 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 9   THEN 'Hace 9 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 8   THEN 'Hace 8 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 7   THEN 'Hace 7 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 6   THEN 'Hace 6 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 5   THEN 'Hace 5 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 4   THEN 'Hace 4 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 3   THEN 'Hace 3 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 2   THEN 'Hace 2 minutos'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 1   THEN 'Hace 1 minuto'
  WHEN DATEDIFF(SYSDATE(), IP_CreateDate) = 0 AND HOUR(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0 AND MINUTE(TIMEDIFF(SYSDATE(), IP_CreateDate)) = 0   THEN 'Hace un instante'
  ELSE 'Hace un tiempo'
  END  AS 'IP_Time_Ago',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Cant_Insp',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IN_Inspire_User = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") AND ip.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Inspire_Inspiter', 
  (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
  (select US_User_Login from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_Username_Logged',
  (select US_Full_Name from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserFullName_Logged',
  (select US_Photo_Small from ins_session_tb,ins_users_tb where US_User_Id = SS_User_Id and SS_SSID=".$ssid.") as 'SS_UserPhoto_Logged',
  (select count(*) FROM ins_favourites_tb fav WHERE  FV_Inspiter_Id = ip.IP_Inspiter_Id AND fav.FV_ser_Id =(select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")) as 'FV_Is_In_Favourite',
  (select count(*) FROM ins_comment_tb where CM_Inspiter_id = ip.IP_Inspiter_Id) as 'CM_Comment_Amount',
  tipoInsp.IP_Value1 as IP_Value1, tipoInsp.IP_Value2 as IP_Value2, tipoInsp.IP_Value3 as IP_Value3, tipoInsp.IP_Value4 as IP_Value4, tipoInsp.IP_Value5 as IP_Value5, tipoInsp.IP_Value6 as IP_Value6, tipoInsp.IP_Value7 as IP_Value7, tipoInsp.IP_Value8 as IP_Value8, tipoInsp.IP_Type as IP_Type";

   
if($type == 'seguidores') 
{
	$query = $query." FROM ins_users_tb AS us, ins_inspiter_tb as ip, ins_follow_tb AS fol,  

(SELECT IP_Inspiter_Id, IP_By_User_Id, PH_Phrase AS IP_Value1, PH_Author AS IP_Value2, PH_Author_Id AS IP_Value3, PH_Author AS IP_Value4, PH_Author_Id as IP_Value5, PH_Phrase AS IP_Value6, PH_Author_Id as IP_Value7, PH_Author_Id as IP_Value8, 'text' as IP_Type
FROM ins_inspiter_tb, ins_phrases_tb
WHERE IP_Inspiter_Id = PH_Phrase_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5, IM_Original_Uri AS IP_Value6, IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5, VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp

WHERE  us.US_User_Id = ip.IP_By_User_Id
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id
AND fol.FW_Dad_Id = us.US_User_Id
AND fol.FW_Sun_Id =".$userId;
}
else if ($type == 'favoritos')
{
    $query = $query." FROM ins_favourites_tb fav, ins_inspiter_tb as ip, ins_users_tb AS us,
	(SELECT IP_Inspiter_Id, IP_By_User_Id, PH_Phrase AS IP_Value1, PH_Author AS IP_Value2, PH_Author_Id AS IP_Value3, PH_Author AS IP_Value4, PH_Author_Id as IP_Value5,PH_Phrase AS IP_Value6, PH_Author_Id as IP_Value7, PH_Author_Id as IP_Value8, 'text' as IP_Type
FROM ins_inspiter_tb, ins_phrases_tb
WHERE IP_Inspiter_Id = PH_Phrase_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, IM_Uri AS IP_Value1, IM_Description AS IP_Value2, IM_OverPhrase AS IP_Value3, IM_Title AS IP_Value4, IM_Image_Height as IP_Value5,IM_Original_Uri AS IP_Value6, IM_Original_Width AS IP_Value7, IM_Original_Height AS IP_Value8, 'image' as IP_Type
FROM ins_inspiter_tb, ins_image_tb
WHERE IP_Inspiter_Id = IM_Image_Id
UNION
SELECT IP_Inspiter_Id, IP_By_User_Id, VI_Link AS IP_Value1, VI_Descripcion AS IP_Value2,  VI_Video_id AS IP_Value3, VI_Title AS IP_Value4, VI_Video_id AS IP_Value5, VI_Url_Image AS IP_Value6, VI_Video_id AS IP_Value7, VI_Video_id AS IP_Value8, 'video' as IP_Type
FROM ins_inspiter_tb, ins_video_tb
WHERE IP_Inspiter_Id = VI_Video_id) as tipoInsp
WHERE fav.FV_Inspiter_Id = ip.IP_Inspiter_Id
AND tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id
AND ip.IP_By_User_Id = us.US_User_Id
AND fav.FV_ser_Id = ".$userId;
}
else if($type == 'inspiraciones')
{
    $content = stripslashes($wordSearch);
    $query = $query." FROM   ins_users_tb as us, ins_inspiter_tb as ip,
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
		       WHERE IP_Inspiter_Id = VI_Video_id)
		       as tipoInsp
		      WHERE  us.US_User_Id = ip.IP_By_User_Id 
		      AND tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id
                      AND (
                           (tipoInsp.IP_Type = 'text' and upper(tipoInsp.IP_Value1) like '%".strtoupper($content)."%')
                         or(tipoInsp.IP_Type = 'image' and (upper(tipoInsp.IP_Value2) like '%".strtoupper($content)."%' or upper(tipoInsp.IP_Value4) like '%".strtoupper($content)."%'))
                         or(tipoInsp.IP_Type = 'video' and upper(tipoInsp.IP_Value2) like '%".strtoupper($content)."%')
                          )";			     
}
else
{
	$query = $query." FROM   ins_users_tb as us, ins_inspiter_tb as ip, 
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
WHERE   us.US_User_Id = ip.IP_By_User_Id
and tipoInsp.IP_Inspiter_Id = ip.IP_Inspiter_Id";
}

if ($type == 'perfil')
{
   $query = $query." AND us.US_User_Id = ".$userId;
   if($inspiterId != 0)
     $query = $query." AND ip.IP_Inspiter_Id = ".$inspiterId;
   
   if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'favoritos')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
 ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'recientes')
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if($type == 'top')
{
 $query = $query." ORDER BY IN_Cant_Insp DESC, (select CF_IPS FROM ins_config_tb where CF_User_Id = us.US_User_Id) DESC, IP_CreateDate DESC LIMIT 10";
}
else if($type == 'populares')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IN_Cant_Insp DESC LIMIT 50";}  //cambiar
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IN_Cant_Insp DESC LIMIT 20";}
}
else if($type == 'aleatorios')
{
  if ($firstInspiterId == '0')
   {$query = $query." ORDER BY RAND() DESC LIMIT 50";}
else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY RAND() DESC LIMIT 20";}
}
else if ($type == 'seguidores')
{
 if ($firstInspiterId == '0')
   {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
else
  {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
    ORDER BY IP_CreateDate DESC LIMIT 20";}
}
else if ($type == 'inspiraciones') 
{
 if ($firstInspiterId == '0')
    {$query = $query." ORDER BY IP_CreateDate DESC LIMIT 20";}
 else
   {$query = $query." AND ip.IP_Inspiter_Id < ".$firstInspiterId." 
ORDER BY IP_CreateDate DESC LIMIT 20";}
}
  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  {
    $jsondata[$i]['IP_Inspiter_Id'] = $row['IP_Inspiter_Id']; 
    $jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
    $jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
    $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
    $jsondata[$i]['US_Photo_Small'] = $row['US_Photo_Small']; 
    $jsondata[$i]['US_City'] = $row['US_City']; 
    $jsondata[$i]['IP_CreateDate'] = $row['IP_CreateDate']; 
    $jsondata[$i]['IP_Time_Ago'] = $row['IP_Time_Ago'];
    $jsondata[$i]['IN_Cant_Insp'] = $row['IN_Cant_Insp'];
    $jsondata[$i]['IN_Inspire_Inspiter'] = $row['IN_Inspire_Inspiter'];
    $jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
    $jsondata[$i]['FV_Is_In_Favourite'] = $row['FV_Is_In_Favourite'];
    $jsondata[$i]['CM_Comment_Amount'] = $row['CM_Comment_Amount'];
    $jsondata[$i]['SS_Username_Logged'] = $row['SS_Username_Logged']; 
    $jsondata[$i]['SS_UserFullName_Logged'] = $row['SS_UserFullName_Logged']; 
    $jsondata[$i]['SS_UserPhoto_Logged'] = $row['SS_UserPhoto_Logged'];
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
  if($firstInspiterId == '0')
   {
     $jsondata = array_reverse($jsondata);
   }
   else
   {
     $jsondata = array_reverse($jsondata);
     $jsondata = array_reverse($jsondata);
   }
  return json_encode($jsondata);  
 }
  
  }
     catch(Exception $e)
     {
         return false;
     }

}




public static function getInspiterDataVisual($userId,$ssid,$firstPhraseId,$type,$phraseId,$wordSearch)
{    
    try
    {
     $query = "SELECT IP_Inspiter_Id, PH_Phrase, PH_Author, US_User_Id, US_User_Login, US_Full_Name, US_Photo, US_City, IP_CreateDate,";
     $query = $query." 
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IP_Inspiter_Id = ins.IN_Inspiter_id) as 'IN_Cant_Insp',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IN_Inspire_User = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") AND ph.PH_Phrase_Id = ins.IN_Inspiter_id) as 'IN_Inspire_Inspiter', 
  (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
  (select count(*) FROM ins_favourites_tb fav WHERE  FV_Inspiter_Id = ins.IP_Inspiter_Id AND fav.FV_ser_Id =(select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")) as 'FV_Is_In_Favourite',
  (select count(*) from ins_comment_tb cm where cm.CM_Inspiter_id = ins.IP_Inspiter_Id) as 'CM_Comment_Amount'";
  if($type == 'inspiraciones')
  {
    $phraseContent = stripslashes($wordSearch);
    $query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph, ins_inspiter_tb as ins  
                      WHERE  us.US_User_Id = ins.IP_By_User_Id 
                      AND    ph.PH_Phrase_Id = ins.IP_Inspiter_Id
                      AND    upper(ph.PH_Phrase) like '%".strtoupper($phraseContent)."%'";
		$query = $query."LIMIT 5";
  }
/*else if($type == 'autores')
{
    $autorContent = stripslashes($wordSearch);
    $query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph 
                      WHERE  us.US_User_Id = ph.PH_By_User_Id 
                      AND    upper(ph.PH_Author) like '%".strtoupper($autorContent)."%'"; 
		$query = $query."LIMIT 2";
}*/
else
{
	$query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph, ins_inspiter_tb as ins
WHERE  us.US_User_Id = ins.IP_By_User_Id
AND ins.IP_Inspiter_Id = ph.PH_Phrase_Id";
	
}

  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
        $jsondata[$i]['IP_Inspiter_Id'] = $row['IP_Inspiter_Id']; //PH_Phrase_Id
        $jsondata[$i]['PH_Phrase'] = $row['PH_Phrase']; 
	$jsondata[$i]['PH_Author'] = $row['PH_Author']; 
	$jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
	$jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
        $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
	$jsondata[$i]['US_Photo'] = $row['US_Photo']; 
	$jsondata[$i]['US_City'] = $row['US_City']; 
	$jsondata[$i]['IP_CreateDate'] = $row['IP_CreateDate']; //PH_CreateDate
	$jsondata[$i]['IN_Cant_Insp'] = $row['IN_Cant_Insp'];
	$jsondata[$i]['IN_Inspire_Inspiter'] = $row['IN_Inspire_Inspiter']; //IN_Inspire_Phrase
	$jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
        $jsondata[$i]['FV_Is_In_Favourite'] = $row['FV_Is_In_Favourite'];
        $jsondata[$i]['CM_Comment_Amount'] = $row['CM_Comment_Amount'];
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






public static function getAuthorDataVisual2($userId,$ssid,$firstPhraseId,$type,$phraseId,$wordSearch)
{    
    try
    {
      $query = "SELECT PH_Phrase_Id, PH_Phrase, PH_Author, US_User_Id, US_User_Login, US_Full_Name, US_Photo, US_City, PH_CreateDate,";
     $query = $query." 
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ph.PH_Phrase_Id = ins.IN_Phrase_id) as 'IN_Cant_Insp',
  (SELECT COUNT(*) FROM ins_inspire_tb AS ins WHERE ins.IN_Inspire_User = (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") AND ph.PH_Phrase_Id = ins.IN_Phrase_id) as 'IN_Inspire_Phrase', 
  (select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.") as 'SS_User_Logged',
  (select count(*) FROM ins_favourites_tb fav WHERE  FV_Phrases_Id = ph.PH_Phrase_Id AND fav.FV_ser_Id =(select SS_User_Id from ins_session_tb where SS_SSID=".$ssid.")) as 'FV_Is_In_Favourite'";
   
    $autorContent = stripslashes($wordSearch);
    $query = $query." FROM   ins_users_tb as us,ins_phrases_tb as ph
                      WHERE  us.US_User_Id = ph.PH_By_User_Id 
                      AND    upper(ph.PH_Author) like '%".strtoupper($autorContent)."%'"; 
		$query = $query."LIMIT 2";


  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
        $jsondata[$i]['PH_Phrase_Id'] = $row['PH_Phrase_Id']; 
        $jsondata[$i]['PH_Phrase'] = $row['PH_Phrase']; 
	$jsondata[$i]['PH_Author'] = $row['PH_Author']; 
	$jsondata[$i]['US_User_Id'] = $row['US_User_Id']; 
	$jsondata[$i]['US_User_Login'] = $row['US_User_Login']; 
        $jsondata[$i]['US_Full_Name'] = $row['US_Full_Name']; 
	$jsondata[$i]['US_Photo'] = $row['US_Photo']; 
	$jsondata[$i]['US_City'] = $row['US_City']; 
	$jsondata[$i]['PH_CreateDate'] = $row['PH_CreateDate']; 
	$jsondata[$i]['PH_Time_Ago'] = $row['PH_Time_Ago'];
	$jsondata[$i]['IN_Cant_Insp'] = $row['IN_Cant_Insp'];
	$jsondata[$i]['IN_Inspire_Phrase'] = $row['IN_Inspire_Phrase'];
	$jsondata[$i]['SS_User_Logged'] = $row['SS_User_Logged'];
        $jsondata[$i]['FV_Is_In_Favourite'] = $row['FV_Is_In_Favourite'];
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

public static function getAuthorDataVisual($wordSearch)
{   
    try
    {
      $query = "SELECT PH_Author, COUNT(*) as PH_Cont";
      $autorContent = stripslashes($wordSearch);
      $query = $query." FROM ins_phrases_tb
                        WHERE upper(PH_Author) like '%".strtoupper($autorContent)."%'";
      $query = $query." GROUP BY PH_Author";        //HAVING count(*)>1
      $query = $query." LIMIT 3";


  $result = DataBase::ExecuteQuery($query);
  $jsondata = array();
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result))
  {

    $jsondata[$i]['PH_Author'] = $row['PH_Author'];
    $jsondata[$i]['PH_Cont'] = $row['PH_Cont'];
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






public static function deleteInspiter($inspiterId,$userId,$type)
{
    try
    {
	DataBase::ExecuteQuery("CALL DELETE_INSPITER('".$inspiterId."','".$userId."','".$type."',@Output);");	
	
	 $result = DataBase::ExecuteQuery("select @Output");
	 
	 $OutputResult = mysql_fetch_row($result);
	
	 if($OutputResult[0] == 'true')
	 {
		 return $OutputResult[0];
	 }
	 else 
	 {
		 return $OutputResult[0];
	 }
     }
     catch(Exception $e)
     {
         return false;
     }
}

public static function getAmountInspiter($ssid)
{
  try
  {	
   $query = "SELECT IP_Inspiter_Id
             FROM   ins_users_tb,ins_inspiter_tb,ins_session_tb
             WHERE  US_User_Id = IP_By_User_Id
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
public static function getAmountInspiterFriend($userId)
{
  try
  {	
   $query = "SELECT IP_Inspiter_Id
             FROM   ins_users_tb,ins_inspiter_tb
             WHERE  US_User_Id = IP_By_User_Id
             AND    US_User_Id =".$userId;

   $result = DataBase::ExecuteQuery($query);
  
   return (int) mysql_num_rows($result);
  }
  catch (Exception $e){    
         return $e->getMessage();
    }
}


public static function is_inspiter_exist($userId,$inspiterIdParam)
{
    try
    {
   $result = DataBase::ExecuteQuery("select count(*) from ins_inspiter_tb where IP_Inspiter_Id = ".$inspiterIdParam." and IP_By_User_Id = ".$userId);
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

public static function getInspiterById($inspiterId)
{   
    try
    {
    //col0         col1           col2             col3                  
  $query = "SELECT `IP_Inspiter_Id`,`IP_By_User_Id`,'IP_Categories'
FROM ins_inspiter_tb
WHERE  IP_Inspiter_Id =".$inspiterId;
 $result = DataBase::ExecuteQuery($query);
 $col = mysql_fetch_row($result);
 $inspiter = new Inspiter($col[0],$col[1],$col[2]);
return $inspiter;
}
     catch(Exception $e)
     {
         return false;
     }
}


public static function getAmountInspiterAll()
{
  try
  {	
   $query = "SELECT count(*)
             FROM   ins_inspiter_tb";

   $result = DataBase::ExecuteQuery($query);
   $OutputExist = mysql_fetch_row($result);
  
   return $OutputExist[0];
  }
  catch (Exception $e){    
         return 0;
    }
}

public static function getAmountInspiterSeguidores($ssid)  //seguir desarrollando
{
  try
  {	
   $query = "SELECT count(*)-(select count(*) from ins_users_tb,ins_session_tb,ins_phrases_tb where US_User_id = SS_User_Id
AND PH_By_User_Id = US_User_id AND SS_SSID =".$ssid.") FROM ins_follow_tb, ins_phrases_tb, ins_users_tb, ins_session_tb 
             WHERE FW_Sun_Id = US_User_Id
             AND FW_Dad_Id = PH_By_User_Id
             AND US_User_id = SS_User_Id
             AND SS_SSID =".$ssid;
   $result = DataBase::ExecuteQuery($query);
   $OutputExist = mysql_fetch_row($result);
  
   return $OutputExist[0];
  }
  catch (Exception $e){    
         return 0;
    }
}
}
