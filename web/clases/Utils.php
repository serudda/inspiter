<?php
class Utils
{	
 public static function urls_amigables($url)
 {
     try
     { 
  // Tranformamos todo a minusculas
  $url = strtolower($url);
  //Rememplazamos caracteres especiales latinos
  $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
  $repl = array('a', 'e', 'i', 'o', 'u', 'n');
  $url = str_replace ($find, $repl, $url);
  // Añaadimos los guiones
  $find = array(' ', '&', '\r\n', '\n', '+'); 
  $url = str_replace ($find, '-', $url);
  // Eliminamos y Reemplazamos demás caracteres especiales
  $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
  $repl = array('', '-', '');
  $url = preg_replace ($find, $repl, $url);
  return $url;
     }
     catch(Exception $e)
     {
         return false;
     }
  }
}
?>