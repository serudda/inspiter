<?php 
error_reporting(0);
require_once 'clases/Mail.php';
require_once 'clases/User.php';
require_once 'clases/Token.php';
session_start();

$serverName = $_SERVER['SERVER_NAME'];
function getToken()
{
     $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
     $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
     //$_SESSION["token_".$name] = $token;
     return $token;
}
   //para el recuperar contraseña
  if (isset($_POST['inputEmail']))
  {
    $fullNameUser = User::existMail($_POST['inputEmail']);
    if ($fullNameUser != false)
    {   
         $token = getToken();
      
         //se inserta el token generado en la base
         $resultToken = new Token(NULL,$token,$_POST['inputEmail'],NULL,'pass');
         $resultToken->insertToken();
            
         $remitente  = 'no-reply@inspiter.com';
         $destino= $_POST['inputEmail'];
         $asunto= "Recuperacion de cuenta de Inspiter";
         $mensaje= '<div id="MsgContainer"><pre>Hey '.$fullNameUser.'  - Haz click en el siguiente enlace para poder recuperar tu cuenta.<br> <br><a href="'.$serverName.'/reingresarClave.php?token='.$token.'" target="_blank">'.$serverName.'/reingresarClave.php?token='.$token.'</a><br> <br>- Equipo Inspiter<br></pre></div>';
         $header .= "From: Inspiter <$remitente>\r\n"; 
         $header .= "Organization: Inspiter\r\n"; 
         $header .= "Content-Type: text/html; charset=iso-8859-1";
      //Reply-To: $remitente\n
         $emailObj = new Mail($remitente,$destino,$asunto,$mensaje,$header);
         $resultMail = $emailObj->sendMail();

         if ($resultMail == true)
             header("location:/recuperarClave.php?success=sendMailSuccessful");
             //Todo sergio, aqui pasa que el mail se envio satisfactoriamente 
             //a un mail el cual no sabemos a ciencia cierta si existe. ALERT O HTML
         else
             header("location:/recuperarClave.php?error=sendMail");
          //Todo sergio, aqui pasa que el mail no se envio correctamente. ALERT O HTML
      
      }
  else 
     header("location:/recuperarClave.php?error=incorrectMail");
     //Todo sergio, aqui pasa que el user puso un mail con el formato correcto
     //pero este es un mail inexistente . HTML
  }
  //para el contactenos
  else if(isset($_POST['ContactOption']))
  {
      $contactName = $_POST['ContactName'];
      $contactEmail = $_POST['ContactEmail'];
      $contactAsunto = $_POST['ContactAsunto'];
      $contacTextArea = $_POST['ContacTextArea'];
      $contactOption = $_POST['ContactOption'];
      
      $contactAsuntoFinal = '['.$contactOption.'] '.$contactAsunto;
      
      if($contactName == NULL || $contactEmail == NULL || $contacTextArea == NULL)
      {
           header("location:/contactenos.php?error=validation");
      }
      else
      {
         $remitente  = $contactEmail;
         $destino= 'admin@inspiter.com';
         $asunto= $contactAsuntoFinal;
         $mensaje= '<div id="MsgContainer"><pre>'.$contacTextArea.'</pre></div>';
         $header .= "From: $contactName <$remitente>\r\n"; 
         $header .= "Organization: Inspiter\r\n"; 
         $header .= "Content-Type: text/html; charset=iso-8859-1";
         $emailObj = new Mail($remitente,$destino,$asunto,$mensaje,$header);
         $resultMail = $emailObj->sendMail();

         if ($resultMail == true)
             header("location:/contactenos.php?success=sendMailSuccessful");
             //Todo sergio, aqui pasa que el mail se envio satisfactoriamente 
             //a un mail el cual no sabemos a ciencia cierta si existe. ALERT O HTML
         else
             header("location:/contactenos.php?error=sendMail");
          //Todo sergio, aqui pasa que el mail no se envio correctamente. ALERT O HTML
      }
      
  }
  else
    header("location:/index.php?error=Generico");
  ?> 
