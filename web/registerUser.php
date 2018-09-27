<?php
error_reporting(0);
session_start();
require_once 'clases/Validation.php';
require_once 'clases/Database.php';
require_once 'clases/User.php';
require_once 'clases/Login.php';
require_once 'clases/resize-class.php';
require_once 'clases/Mail.php';
require_once 'clases/Token.php';
require_once 'clases/Follow.php';

/**
* stripAccents()
* @description Esta función remplaza todos los caracteres especiales de un texto dado por su equivalente
* @author      Esteban Novo
* @link        http://www.notasdelprogramador.com/2011/01/13/php-funcion-para-quitar-acentos-y-caracteres-especiales/
* @access      public
* @copyright   Todos los Derechos Reservados
* @param       string $String
* @return      Retorna el nuevo String sin caracteres especiales
*/
function stripAccents($String)
{
    $String = str_replace("ä","a",$String);
    $String = str_replace("á","a",$String);
    $String = str_replace("à","a",$String);
    $String = str_replace("â","a",$String);
    $String = str_replace("ã","a",$String);
    
    $String = str_replace("Á","A",$String);
    $String = str_replace("À","A",$String);
    $String = str_replace("Â","A",$String);
    $String = str_replace("Ã","A",$String);
    $String = str_replace("Ä","A",$String);
    
    $String = str_replace("é","e",$String);
    $String = str_replace("è","e",$String);
    $String = str_replace("ê","e",$String);
    $String = str_replace("ë","e",$String);
    
    $String = str_replace("É","E",$String);
    $String = str_replace("È","E",$String);
    $String = str_replace("Ê","E",$String);
    $String = str_replace("Ë","E",$String);
    
    $String = str_replace("í","i",$String);
    $String = str_replace("ì","i",$String);
    $String = str_replace("î","i",$String);
    $String = str_replace("ï","i",$String);
    
    $String = str_replace("Í","I",$String);
    $String = str_replace("Ì","I",$String);
    $String = str_replace("Î","I",$String);
    $String = str_replace("Ï","I",$String);
    
    $String = str_replace("ó","o",$String);
    $String = str_replace("ò","o",$String);
    $String = str_replace("ô","o",$String);
    $String = str_replace("õ","o",$String);
    $String = str_replace("ö","o",$String);
    
    $String = str_replace("Ó","O",$String);
    $String = str_replace("Ò","O",$String);
    $String = str_replace("Ô","O",$String);
    $String = str_replace("Õ","O",$String);
    $String = str_replace("Ö","O",$String);
    
    $String = str_replace("ú","u",$String);
    $String = str_replace("ù","u",$String);
    $String = str_replace("û","u",$String);
    $String = str_replace("ü","u",$String);
    
    $String = str_replace("Ú","U",$String);
    $String = str_replace("Ù","U",$String);
    $String = str_replace("Û","U",$String);
    $String = str_replace("Ü","U",$String);
    
    $String = str_replace("^","",$String);
    
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","C",$String);
    $String = str_replace("ñ","n",$String);
    $String = str_replace("Ñ","N",$String);
    $String = str_replace("Ý","Y",$String);
    $String = str_replace("ý","y",$String);
    return $String;
}


 $serverName = $_SERVER['SERVER_NAME'];
 $myUsernameTrimNo = $_POST['inputUsername']; 
 $myPassword = md5($_POST['inputPassword']);  
 $myEmail = $_POST['inputEmail']; 
 $myFullNameAux = $_POST['inputName'];
 $myCityAux = $_POST['inputCity'];
 $myfid = $_POST['fid'];
 $myfImage = $_POST['fimage'];
 $myfImageSmall = $_POST['fimageSmall'];
 $usernameFace = $_POST['UsernameHidden'];
 
 $myUsernameAux2 = str_replace(' ', '', $myUsernameTrimNo);
 $myUsernameAux3 = stripAccents($myUsernameAux2);
 
 $myUsername = substr($myUsernameAux3, 0, 14);
 $myFullName = substr($myFullNameAux, 0, 18);
 $myCity = substr($myCityAux, 0, 24);
 
 //define variable de sesiones
 $_SESSION['username']=$myUsername;
 $_SESSION['email']=$myEmail;
 $_SESSION['fullname']=$myFullName;
 $_SESSION['city']=$myCity;
 $_SESSION['fid']=$myfid;
 $_SESSION['image']=$myfImage;
 $_SESSION['imageSmall']=$myfImageSmall;

   function getToken()
   {
       $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
       $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
       //$_SESSION["token_".$name] = $token;
       return $token;
   }
 try
 {
     if(Validation::validateUsername($myUsername) == true &&
      Validation::validateEmail($myEmail)       == true &&
      Validation::validateCity($myCity) == true &&
      Validation::validateFullName($myFullName) == true)
  { 	    
    $faceband = false; 
    if(isset($_POST['fid']) && $_POST['fid']!='')
    {
	 //imagen normal - traigo y guardo imagen en el server
	 $myfImage = str_replace('https','http',$myfImage);
         $contents= file_get_contents($myfImage);
	 $imagedirectory = '../images/perfiles/data/'.$myUsername.'.jpg';
         $savefile = fopen($imagedirectory, 'w');
         fwrite($savefile, $contents);
         fclose($savefile);
	 
	 //imagen chica
	 $resizeObj = new resize($imagedirectory);
	 $resizeObj->resizeImage(50, 50, 'crop');
	 $imagedirectorySmall = '../images/perfiles/smallMenu/'.$myUsername.'.jpg';
	 $resizeObj->saveImage($imagedirectorySmall, 100); 
	 
	 $user1 = new User(NULL,$myEmail,$myUsername,$myPassword,$myFullName,NULL,$_POST['fid'],$imagedirectory,$imagedirectorySmall,NULL,NULL,NULL,$myCity,10,NULL,'YES');
         $faceband = true;
	}
	else
	{
	 $myfImage = "../images/perfiles/avatar-inspiter-big.jpg";
     $contents= file_get_contents($myfImage);
	 $imagedirectory = '../images/perfiles/data/'.$myUsername.'.jpg';
     $savefile = fopen($imagedirectory, 'w');
     fwrite($savefile, $contents);
     fclose($savefile);
	 
	
	 $myfImageSmall = "../images/perfiles/avatar-inspiter.jpg";
     $contentsSmall = file_get_contents($myfImageSmall);
	 $imagedirectorySmall = '../images/perfiles/smallMenu/'.$myUsername.'.jpg';
     $savefileSmall = fopen($imagedirectorySmall, 'w');
     fwrite($savefileSmall, $contentsSmall);
     fclose($savefileSmall);

	 $user1 = new User(NULL,$myEmail,$myUsername,$myPassword,$myFullName,NULL,NULL,$imagedirectory,$imagedirectorySmall,NULL,NULL,NULL,$myCity,10,NULL,'YES');
	 $faceband = false;
	}
        //existe faceId               //no esta cargado este faceid                  //no existe faceid
	if(($faceband == true && Validation::validateFacebookId($_POST['fid'])==true) || $faceband == false)
	{
	    $result = $user1->insert($usernameFace);
        
	 if($result != false) // != false
	 {
           //te seguis a ti mismo al registrarte para que puedas ver tus propias frases
           $follow1 = new Follow($result,$result,NULL); 
           $follow1->startToFollow();
            
           //todo sergio arreglar el html, por favor
           $token = getToken();
           //se inserta el token generado en la base
           $resultToken = new Token(NULL,$token,$myEmail,NULL,'account');
           $resultToken->insertToken();
	   //user ya registrado
           $remitente   = 'no-reply@inspiter.com';
           $destino     = $myEmail;
           $asunto      = "Confirma tu cuenta de Inspiter, ".$myFullName;
           
           /*$mensaje     = '<div id="MsgContainer"><pre>Hey '.$myFullName.
                     ' Confirma tu cuenta para que tengas acceso completo a Inspiter y todas las notificaciones y novedades futuras ser&aacute;n enviadas a esta direcci&oacute;n de correo electr&oacute;nico.<br>'.
                     ' Haz click en el siguiente enlace para activar tu cuenta <a href="'.$serverName.'/web/activarCuenta.php?uid='.$myUsername.'&token='.$token.'" target="_blank"><b>ACTIVA TU CUENTA</b></a><br> <br>- Equipo Inspiter<br></pre></div>';*/
           
           $mensaje = '<div lang="es" style="background-color:#C5E1B9;background:#C5E1B9 url("http://www.inspiter.com/images/bg-slice.jpg") repeat;padding:0;margin:0">
	<table cellspacing="0" cellpadding="0" border="0" width="100%" background="http://www.inspiter.com/images/bg-slice.jpg">
		<tbody>
			<tr>
				<td style="padding:20px 20px 40px">
					<table cellspacing="0" cellpadding="0" border="0" align="center" width="620">
						<tbody>
							<tr>

								<td align="center" style="padding:20px 0 40px">

									<a href="http://www.inspiter.com" title="Visita inspiter.com" style="border:none" target="_blank">

										<img src="http://www.inspiter.com/images/inspiter-logo-large.png" width="200" height="52" style="vertical-align:top;outline:none;border:none" alt="Inspiter">

									</a>

								</td>

							</tr>
							<tr>
							<td background="http://www.inspiter.com/images/line-mail-logo.gif" align="center">
								<table cellspacing="0" cellpadding="0" border="0" align="center">
									<tbody>
										<tr>
											<td background="http://www.inspiter.com/images/bg-slice.jpg" style="background-color:#C5E1B9">
	
												<h1 style="font-family:georgia,serif;font-weight:normal;font-size:22px;line-height:21px;color:#211922!important;margin:0;padding:0 20px">

													&iexcl;Hola, '.$myFullName.'!
												
												</h1>
											
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							
							<tr>
								<td background="http://www.inspiter.com/images/bg-slice.jpg" style="background-color:#C5E1B9">
								<p style="font-family:georgia,serif;font-weight:normal;font-size:18px;line-height:21px;color:#211922!important;margin:0;padding:38px 20px 15px;text-align:center">
								&iexcl;Bienvenido a Inspiter!, es necesario que confirmes tu correo electr&oacute;nico:
								</p>

								</td>
							</tr>
							
							<tr>
								<td width="140" align="center" style="padding:12px 0 60px">
									<table cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td height="34"  align="center" style="background-repeat:repeat-x;border-radius:3px;background-color:#5BB75B;white-space:nowrap;min-height:34px">
													<a target="_blank" title="Activar Cuenta" style="color:#fcf9f9;text-align:center;text-decoration:none;vertical-align:baseline; text-shadow:0 -1px 0 rgba(0, 0, 0, 0.25);" href="http://www.inspiter.com/web/activarCuenta.php?uid='.$myUsername.'&token='.$token.'">';
							 	if(stripos($destino,'@gmail') !== false || stripos($destino,'@hotmail') !== false || stripos($destino,'@live') !== false)					
                { $mensaje .=  ' <span style="padding:9px 48px;color:#fcf9f9;text-decoration:none;font-family:calibri;font-weight:normal;font-size:22px;line-height:18px;white-space:nowrap">Activar Cuenta</span>';}
                else
								{ $mensaje .= 'Activar Cuenta';}
                 $mensaje .= '</a>
								    </td>
											</tr>

										</tbody>
									</table>
								</td>

							</tr>
							
							<tr>

								<td align="center">
								
									<img src="http://www.inspiter.com/images/line-footer-mail.png" height="18" style="vertical-align:top;outline:none;border:none">
								
								</td>

							</tr>

							<tr>

								<td align="center" style="padding:30px 0 15px">

									<p style="font-family:helvetica;font-size:12px;color:#767676;line-height:10px;margin:0;padding:0">Este correo electr&oacute;nico se ha enviado a <a href="mailto:admin@inspiter.com" style="color:#4D4D4D;text-decoration:none" target="_blank">'.$myEmail.'</a>.
									<!--<br> �No quieres notificaciones sobre la actividad? <span><a href="#" style="color:#4D4D4D;text-decoration:underline" title="Date de baja o gestiona tus preferencias de correo electrónico electrónico" target="_blank">Modifica tus preferencias de correo electrónico</a>.</span>-->
									</p>

								</td>

							</tr>
							
							<tr>

								<td align="center">

									<p style="font-family:helvetica; font-size:11px; color:#767676; line-height:10px; margin:0; padding:0"><span>&copy;</span>2013 Inspiter. <font style="color:#aaa;padding:0 2px">|</font> Todos los derechos reservados<br><a href="http://www.inspiter.com/privacidad.php" style="color:#4D4D4D;text-decoration:underline" target="_blank">Privacidad</a> <font style="color:#aaa;padding:0 2px"> |</font> <a href="http://www.inspiter.com/terminosCondiciones.php" style="color:#4D4D4D;text-decoration:underline" target="_blank">Condiciones</a></p><img src="" width="0" height="0">

								</td>

							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>';
           
           
           $header .= "From: Inspiter <$remitente>\r\n"; 
           $header .= "Organization: Inspiter\r\n"; 
           $header .= "Content-Type: text/html; charset=iso-8859-1";
           $emailObj    = new Mail($remitente,$destino,$asunto,$mensaje,$header);
           $resultMail  = $emailObj->sendMail();
           $_SESSION['email'] = $destino;
           if ($resultMail == true) 
	   {
               header("Location:../../activeAccount.php");  
           }
           else
           {
              
              header("Location:../../activeAccount.php");
           }
         }
	 else
	 {header("location:../register.php?invalid_register=true&error=Error al insertar");
         }                                                          
	}
	else
	{
	   header("location:../register.php?invalid_register=true&error=Error al insertar id de face");
        }
  }
 else
 {
     header("location:../register.php?invalid_register=true&error=ErrorDatos");
  }
}
 catch(Exception $e)
 {header("location:../index.php?invalid_register=".$e->getMessage());}
?>