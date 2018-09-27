<?php
error_reporting(0);
require_once 'clases/Database.php';

$result1 = Database::ExecuteQuery("SELECT ph.ph_phrase, us.US_Full_Name
FROM ins_phrases_tb AS ph, ins_users_tb AS us
WHERE ph.PH_By_User_Id = us.us_user_id
ORDER BY RAND() 
LIMIT 1");

if(isset($result1) && $result1!=false)
{ if(mysql_num_rows($result1) > 0){
	$fila = mysql_fetch_row($result1);
    echo $fila[0].' - '.$fila[1];
  } else{
    echo "Vivir Rapido, morir joven para dejar un bello cadaver - Kurt Kobain";
    }
}
else
{
    echo "Vivir Rapido, morir joven para dejar un bello cadaver - Kurt Kobain";
    }
?>