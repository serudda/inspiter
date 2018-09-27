<?php
session_start();

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
<meta name="copyright" content="inspiter.com" />
<meta name="description" content="<?php echo recuperarClave01; ?>" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter" />
<meta name="robots" content="index, follow" />
<title><?php echo recuperarClave01; ?></title>

<!-- Styles
====================================-->
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
<!-- End Styles -->

</head>

<body id="body-welcome">


  <div id="main-pri">

<!-- barra de navegacion
=============================================-->	  
		<div class="navbar">
     
			<div class="navbar-inner">
      
				<div class="container">
       
					<a id="logo" class="span4" href="/">
       
						<h1>Inspiter</h1>  <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->
						<!--<small>inspire your world</small> <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->
        
					</a>
             
				</div>
     
			</div>
     
		</div>
	
<!-- END barra de navegacion -->


<!-- bloque principal (imagen, frase randomica)
=============================================-->
  
  <div id="home-main-container">	
	
	
	<div class="wrapper-rec">
	 <?php
if ((isset($_GET['error']) == true) && ($_GET['error'] = 'incorrectMail')) {
    /* si el email puesto por el usuario no corresponde a un email de un usuario registrado en Inspiter*/
    echo "<div class='message'><div class='message-inside'><span class='message-text'>El correo electr&oacute;nico proporcionado no corresponde a un usuario registrado</span></div></div>";
}else if((isset($_GET['success']) == true) && ($_GET['success'] = 'sendMailSuccessful')){
 /* si el email puesto por el usuario no corresponde a un email de un usuario registrado en Inspiter*/
    echo "<div class='message success'><div class='message-inside'><span class='message-text'>Hemos enviado las instrucciones de restablecimiento de contrase&ntilde;a a tu direcci&oacute;n de correo electr&oacute;nico.</span><span class='message-p'>Si no recibes las instrucciones dentro de un minuto o dos, comprueba el spam de tu correo electr&oacute;nico, o intenta nuevamente.</span></div></div>";
}
?>
		<h3><?php echo recuperarClave02; ?></h3>
		
                <p><?php echo recuperarClave03; ?></p>	
                <br/>
                 <form class="form-signup-inspiter" action="/web/sendMail.php" method="post">
                    <label class="RecLabel" class="control-label" for="inputEmail"><?php echo recuperarClave04; ?></label>
                    <div class="input-prepend">
                     <span class="add-on" id="add-on-email">@</span>
                     <input type="text" class="input" id="inputEmail" name="inputEmail" tabindex="2" placeholder="Email">
                    </div>
		    <button id="RecupSubmit" type="submit" class="btn btn-success"><?php echo recuperarClave05; ?></button>
                 </form>	
          </div>
	 <div class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo recuperarClave06; ?></a>
		<div class="icoVolver"></div>
	 </div>
  
  


<!-- footer
=============================================-->
  
  <div id="footer">
		<div class="footer inliner-list">
			
			<div id="footer-container" class="container">
				<ul id="footer-info">
					
					<img id="divider-left" src="images/divider-left.png">
					<img id="logo-inf" src="images/logo-inc.png">
					<img id="divider-right" src="images/divider-right.png">
				
					<li>
						<a href="acercaDe.php"><?php echo acercaDe; ?></a>
					</li>
		
					<li>
						<a href="#"><?php echo ayuda; ?></a>
					</li>
		
					<li>
						<a href="terminosCondiciones.php"><?php echo terminos; ?></a>
					</li>
		
					<li>
						<a href="privacidad.php"><?php echo privacidad; ?></a>
					</li>
			
					<li>
						<a href="contactenos.php"><?php echo contact; ?></a>
					</li>
		
				</ul>
			</div>
		</div>	
  </div>
  
<!-- END bloque principal (imagen, frase randomica)-->



<!-- Scripts
====================================
<!-- Placed at the end of document so the pages load faster -->
<script src="js/jquery-1.7.2.js"></script>
<script src="js/validate-recupPass.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript">

</script>
<!-- End Scripts -->
  
</body>
</html>