<?php
require_once 'Database.php';
/**
 * La clase country obtiene los paises de todo el mundo
 * Esta clase tiene dos campos countryId (indica el id del pais) y name (indica el nombre del pais propiamente dicho)
 * @author Ariel Valles
 */
class Country {
 
    private $countryId;
    private $name;
    
    public function Country($countryId,$name)
    {
     $this->countryId = $countryId;
     $this->name = $name;
    }
    
 //getter
 public function getCountryId()
 {return $this->countryId;}
 
 public function getName()
 {return $this->name;}
 
 //setter
 public function setCountryId($countryId)
 {$this->countryId = $countryId;}
   
 public function setName($name)
 {$this->name = $name;}

public static function getCountries()
{
   try
     {
  $query = "select CO_Country_id, CO_Country from ins_countries_tb order by CO_Country desc";
  $result = DataBase::ExecuteQuery($query);
  $jsondata = array(); 
  $i = mysql_num_rows($result)-1; //0
  while ($row = mysql_fetch_assoc($result)) 
  { 
     $jsondata[$i]['CO_Country_id'] = $row['CO_Country_id']; 
     $jsondata[$i]['CO_Country'] = $row['CO_Country']; 
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

public static function getCountryIdByName($countryName)
{
    try
    {
     $query = "select CO_Country_id from ins_countries_tb where CO_Country='".$countryName."'";
     $result = DataBase::ExecuteQuery($query);
     $row = mysql_fetch_assoc($result);
     return $row['CO_Country_id'];
     }
     catch(Exception $e)
     {
         return false;
     }
}

}
?>
