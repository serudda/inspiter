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
<meta name="description" content="T&eacute;rminos y Condiciones | Inspiter" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter" />
<meta name="robots" content="index, follow" />
<title><?php echo terminos1; ?></title>

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
		
		<h3><?php echo terminos2; ?></h3>
		
		<p><?php echo terminos3; ?></p>
		
		
		<p><?php echo terminos4; ?></p>
		
		
		<p><?php echo terminos5; ?></p>
		
		<p><?php echo terminos6; ?></p>
		
		<p><?php echo terminos7; ?></p>
		
		<p><?php echo terminos8; ?></p>
		
		<p><?php echo terminos9; ?></p>
		
		<p><?php echo terminos10; ?> <a href="#">admin@inspiter.com</a></p>
		
		<p><?php echo terminos11; ?></p>
		
		<p><?php echo terminos12; ?></p>
		
		<p><?php echo terminos13; ?></p>
		
		<h3><?php echo terminos14; ?></h3>
		
		<p>- <?php echo terminos15; ?></p>
		
		<p>- <?php echo terminos16; ?></p>
		
		<p>- <?php echo terminos17; ?></p>
		
		<p>- <?php echo terminos18; ?></p>
		
		<p>- <?php echo terminos19; ?></p>
		
		<p>- <?php echo terminos20; ?></p>
		
		<p>- <?php echo terminos21; ?></p>
		
		<p>- <?php echo terminos22; ?> </p>
		
		<p>- <?php echo terminos23; ?> </p>
		
		<p>- <?php echo terminos24; ?></p>
		
		<p>- <?php echo terminos25; ?> <a href="<?php echo "http://".$_SERVER['SERVER_NAME'];?>">www.inspiter.com</a><?php echo terminos26; ?></p>
		
		<p>- <?php echo terminos27; ?></p>
		
		<p>- <?php echo terminos28; ?></p>
		
		<p>- <?php echo terminos29; ?></p>
		
		<p><?php echo terminos30; ?></p>
		
		<p><?php echo terminos31; ?></p>
		
		<p><?php echo terminos32; ?></p>
		
		<p><?php echo terminos33; ?></p>
		 
		 <p><?php echo terminos34; ?></p>

		<p><?php echo terminos35; ?></p>

		<p><?php echo terminos36; ?></p>

		<p><?php echo terminos37; ?></p>

		<p><?php echo terminos38; ?></p>
		
	</div>
	 
	 <div id="wrapper-volver-ter" class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo volver; ?></a>
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



<!-- Scripts
====================================
<!-- Placed at the end of document so the pages load faster -->
<script src="js/jquery-1.7.2.js"></script>

<script type="text/javascript">

</script>
<!-- End Scripts -->
  
</body>
</html>