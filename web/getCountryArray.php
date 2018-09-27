<?php
error_reporting(0);
require_once 'clases/Country.php';
require_once 'clases/Session.php';

if (isset($_POST['country'])==true)
{
  $resultCountryId = Country::getCountryIdByName($_POST['country']);
   echo $resultCountryId;
}
else
{
   $frasesJson = Country::getCountries();
   echo $frasesJson;
}


?>
