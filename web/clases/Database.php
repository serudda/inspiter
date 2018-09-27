<?php
class DataBase
{ 
	//Ingresar lo parametros necesarios para insertar en la Base de Datos. 
	public static Function ExecuteQuery($query)
	{
           $mysql_host = "localhost";
   	   $mysql_database = "inspiter_db_python_prd";
    	   $mysql_user = "inspiter_usrPRD";
           $mysql_password = "./Passw0rd123";
       	    try 
            {
		//Open Data Base.
		$connectionString = mysql_connect($mysql_host,$mysql_user,$mysql_password);
		$valor = mysql_select_db($mysql_database,$connectionString);
                $output2 = mysql_query( 'SET NAMES utf8' , $connectionString);
		$output = mysql_query($query,$connectionString);
		//Close Data Base.
		return $output;
                mysql_close($connectionString);
                
                               
	     }
	    catch(Exception $e)
	    {
                mysql_close($connectionString);
                return $e->getMessage();
	    }
	}
}
?>