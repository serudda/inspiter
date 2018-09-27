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
  if (isset($_SESSION['email']))
  {
    $fullNameUser = User::existMail($_SESSION['email']);
    
    //updetear mail de usuario
    $resultUpdateEmail = User::UpdateEmail($_SESSION['email'],$_POST['inputEmail']);
    
    if ($resultUpdateEmail == true)
      $_SESSION['email'] = $_POST['inputEmail'];
    
    if ($fullNameUser != false)
    {   
          $token = getToken();
           //se inserta el token generado en la base
           $resultToken = new Token(NULL,$token,$_SESSION['email'],NULL,'account');
           $resultToken->insertToken();
           
           $User1 = User::getUserByToken($token);
           
	   //user ya registrado
           $remitente   = 'no-reply@inspiter.com';
           $destino     = $_SESSION['email'];
           $asunto      = "Confirma tu cuenta de Inspiter, ".$fullNameUser;
          /* $mensaje     = '<div id="MsgContainer"><pre>Hey '.$fullNameUser.
                     ' Confirma tu cuenta para que tengas acceso completo a Inspiter y todas las notificaciones y novedades futuras ser&aacute;n enviadas a esta direcci&oacute;n de correo electr&oacute;nico.<br>'.
                     ' Haz click en el siguiente enlace para activar tu cuenta <a href="'.$serverName.'/web/activarCuenta.php?uid='.$User1->getUserLogin().'&token='.$token.'" target="_blank"><b>ACTIVA TU CUENTA</b></a><br> <br>- Equipo Inspiter<br></pre></div>';*/
           
           
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

													&iexcl;Hola, '.$fullNameUser.'!
												
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

									<p style="font-family:helvetica;font-size:12px;color:#767676;line-height:10px;margin:0;padding:0">Este correo electr&oacute;nico se ha enviado a <a href="mailto:admin@inspiter.com" style="color:#4D4D4D;text-decoration:none" target="_blank">'.$_SESSION['email'].'</a>.
									<!--<br> No quieres notificaciones sobre la actividad? <span><a href="#" style="color:#4D4D4D;text-decoration:underline" title="Date de baja o gestiona tus preferencias de correo electrónico electr�nico" target="_blank">Modifica tus preferencias de correo electrónico</a>.</span>-->
									</p>

								</td>

							</tr>
							
							<tr>

								<td align="center">

									<p style="font-family:helvetica;font-size:11px;color:#767676;line-height:10px;margin:0;padding:0"><span>&copy;</span>2013 Inspiter. <font style="color:#aaa;padding:0 2px">|</font> Todos los derechos reservados<br><a href="http://www.inspiter.com/privacidad.php" style="color:#4D4D4D;text-decoration:underline" target="_blank">Privacidad</a> <font style="color:#aaa;padding:0 2px"> |</font> <a href="http://www.inspiter.com/terminosCondiciones.php" style="color:#4D4D4D;text-decoration:underline" target="_blank">Condiciones</a></p><img src="" width="0" height="0">

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

         if ($resultMail == true)
             header("location:/activeAccount.php?mail=succesful");
         else
             header("location:/activeAccount.php?error=sendMail");    
      }
  else 
     header("location:/activeAccount.php?error=incorrectMail");
  }
  else
    header("location:/activeAccount.php?error=Generico");
  ?> 
