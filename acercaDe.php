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
<meta name="description" content="Equipo Inspiter" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Equipo Inspiter, Staff Inspiter" />
<meta name="robots" content="index, follow" />
<title><?php echo acercaDeInspiter; ?></title>

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
	
	 <div id="BigContainer">
	 <h3 id="acerDe"><?php echo acercaDe_acerdaDe; ?></h3>
	 
	 <div class="wrapper-pri">
		<p style="margin-bottom: 10px; font-size: 18px;"><strong style="font-size: 26px;">Inspiter</strong> <?php echo defineInspiterAcercaDe; ?></p>
		<p style="margin-bottom: 0px; font-size: 18px;"> <?php echo aquiEncontraras; ?>

		</p>
	 </div></br>
	
	<div class="wrapper-pri">
	
		
		<h3 id="FunDe"><?php echo fundadores; ?></h3>
		
		<div id="Team-Photo1">
		 
		</div>
		<h3 id="">Ariel Valles <span><?php echo arielValles1; ?></span></h3>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo arielValles2; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo arielValles3; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo arielValles4; ?></p>
		<p><?php echo arielValles5; ?></p>
		<div class="blockquoteTeam">
		<blockquote><?php echo arielValles6; ?></blockquote>
		<span>Ariel Valles</span>
		</div>
		
		<div id="Team-Photo2">
		 
		</div>
		<h3 id="">Sergio Ruiz Davila <span><?php echo sergioruiz1; ?></span></h3>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo sergioruiz2; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo sergioruiz3; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo sergioruiz4; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo sergioruiz5; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo sergioruiz6; ?></p>
		<div class="blockquoteTeam">
		<blockquote><?php echo sergioruiz7; ?></blockquote>
		<span><?php echo sergioruiz8; ?></span>
		</div>
		
		
		<div id="Team-Photo3">
		 
		</div>
		<h3>Enzo Castro <span><?php echo enzocastro1; ?></span></h3>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo enzocastro2; ?></p>
<p class="pDe" style="margin-bottom: 13px!important"><?php echo enzocastro3." ".enzocastro4; ?></p>
<p style="margin-bottom: 15px!important;"><?php echo enzocastro5; ?> 
</p>
		<div class="blockquoteTeam">
		<blockquote><?php echo enzocastro6; ?></blockquote>
		<span>G. Bernard Shaw</span>
		</div>
		
		<div id="Team-Photo4">
		 
		</div>
		<h3>Gonzalo Daniel Platero <span><?php echo gonzaloplatero1; ?></span></h3>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo gonzaloplatero2; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo gonzaloplatero3; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo gonzaloplatero4; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo gonzaloplatero5; ?>  
		</p>
		<p  class="pDe" style="margin-bottom:10px!important;"><?php echo gonzaloplatero6; ?></p>
		<p style="margin-bottom: 15px!important;"><?php echo gonzaloplatero7; ?></p>
		
		<div class="blockquoteTeam">
		<blockquote><?php echo gonzaloplatero8; ?></blockquote>
		<span>Nelson Mandela</span>
		</div>
		
		<div id="Team-Photo5">
		 
		</div>
		<h3>Facundo Gallardo <span><?php echo facundogallardo1; ?></span></h3>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo facundogallardo2; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo facundogallardo3; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo facundogallardo4; ?></p>
		<p class="pDe" style="margin-bottom:10px!important;"><?php echo facundogallardo5; ?></p>
		<p class="pDe" style="margin-bottom:35px!important;"><?php echo facundogallardo6; ?></p>
		<div class="blockquoteTeam" style="margin-bottom: 10px!important;">
		 <blockquote><?php echo facundogallardo7; ?></blockquote>
		 <span>John F. Kennedy</span>
		</div>

	</div>
	 
	  <div id="wrapper-volver-ter" class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo volver; ?></a>
		<div class="icoVolver"></div>
	 </div>
	
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