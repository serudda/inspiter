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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="copyright" content="inspiter.com" />
<meta name="description" content="Pol&iacute;tica de privacidad y protecci&oacute;n de datos" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, Privacidad y Protecci&oacute;n de datos" />
<meta name="robots" content="index, follow" />
<title><?php echo privacidad01; ?></title>

<!-- Styles
====================================-->
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
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
	
	
	<div class="wrapper-pri">
		
		<h3><?php echo privacidad02; ?></h3>
		
		<p><?php echo privacidad03; ?></p>
		
		<h3><?php echo privacidad04; ?></h3>
		
		<p>
                    <?php echo privacidad05; ?>
		</p>
		
		<h3><?php echo privacidad06; ?></h3>
		
		<p><?php echo privacidad07; ?>
		</p>
		
		<h4><?php echo privacidad08; ?></h4><p><?php echo privacidad09; ?></p>
		
		<h4><?php echo privacidad10; ?>
		</p>
		
		<h3><?php echo privacidad11; ?></h3>
		
		<p><?php echo privacidad12; ?></p>
		
		<h3><?php echo privacidad13; ?></h3>
		
		<p><?php echo privacidad14; ?></p>
		
		<h3><?php echo privacidad15; ?></h3>
		
		<p><?php echo privacidad16; ?></p>
		
		<h3><?php echo privacidad17; ?></h3>
		
		<p><?php echo privacidad18; ?> <a href="/privacidad.php">http://www.inspiter.com/privacidad.php</a>. <?php echo privacidad19; ?>
		</p>
		
		<p><?php echo privacidad20; ?> <a href="mailto:admin@inspiter.com">admin@inspiter.com</a></p>
		
		
	</div>
	 
	  <div id="wrapper-volver-ter" class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo privacidad21; ?></a>
		<div class="icoVolver"></div>
	 </div>
	
			
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

	</div>

<!-- Scripts
====================================
<!-- Placed at the end of document so the pages load faster -->
<script src="js/jquery-1.7.2.js"></script>

<script type="text/javascript">

</script>
<!-- End Scripts -->
  
</body>
</html>