<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");

if (isset($_SESSION['iduser'])) 
{
   header("Location:../../main.php");
}
else if(!isset($_SESSION['email']) || $_SESSION['email']=='')
{
   header("Location: /");  
}

if(!isset($_SESSION['languaje']))
{
 $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}
include("web/lang_".$_SESSION['languaje'].".php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inspiter</title>
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
                
<!-- Styles
====================================-->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/style-register.css" rel="stylesheet" type="text/css" />
<!-- End Styles -->

</head>

<body id="body-activeAccount">



<!-- bloque principal (imagen, frase randomica)
=============================================-->
  
  <div id="home-main-container">	
	
	
	<div id="wrapper-pri" style="height: 490px;">
	 <div class="logoActiveAccount"></div>
	 <div class="lineGreen"></div>
	 <div id="mainActive">
	 <div class="boxActive" id="email-verification-box" style="display: block;">
		<header class="step-header">
			<h2><?php echo activarCuenta1; ?></h2>
		</header>
              <form class="form-sendMail-inspiter" action="web/sendMailAgain.php" method="post">
		<div class="">
                    <h3><?php echo activarCuenta2; ?><span class="yourEmail"><?php echo $_SESSION['email'];?></span></h3>
                    <div class="posChangeBlock">
                        <p style="margin: 9px 0px 12px;"><?php echo activarCuenta3; ?></p>
                        
                            <div class="input-prepend" style="margin-bottom:0px;margin-left: 34px;">
                              
                                <span class="add-on" id="add-on-email">@</span>
                                <input type="text" class="input" id="inputEmail" name="inputEmail" size="16" placeholder="email.com" value="" style="width: 240px;border-radius: 0px;-moz-border-radius: 0px;-webkit-border-radius: 0px;">
                            </div>
                            <div id="reqEmail" class="alert-Email verify"></div>
                            <div class="loaderAjax" id="loaderEmail">
                                <img src="images/ajax-loader.gif"></img>
                            </div>
                         <input type="hidden" id="EmailOld" name="EmailOld" value="<?php echo $_SESSION['email'];?>">
                         <input type="hidden" id="isActiveAccount" name="isActiveAccount" value="1">
                          <button id="sendMail" name="sendMail" type="submit" class="verifybtn btn btn-success disabled" disabled="true"><?php echo activarCuenta4; ?></button>
                    </div>
			<!--<p>
			 Por favor confirme su dirección de correo electrónico. Si usted no recibió un email, podemos volver a enviarle el correo electrónico, <a id="resendActiveMail" href="../web/sendMailAgain.php">presione aquí</a>. <strong style="color:#000; font-size: 14px;">(También revise su carpeta de correos no deseados o SPAM)</strong>.
				
			</p> -->
                    <p> 
                       <strong style="color:#000; font-size: 14px;"><?php echo activarCuenta5; ?></strong>
                    </p>
		</div>
              </form>
	</div>
  </div>
	</div>
	
			
  </div>
  



<!-- Scripts
====================================
<!-- Placed at the end of document so the pages load faster -->
<script src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/validate-register.js"></script>
<script type="text/javascript">

</script>
<!-- End Scripts -->
  
</body>
</html>