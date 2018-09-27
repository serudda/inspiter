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
<meta name="description" content="Contacto Equipo Inspiter" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, contactanos, contacto equipo inspiter" />
<meta name="robots" content="index, follow" />
<title><?php echo contactanos01; ?></title>

<!-- Styles
====================================-->
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/style-register.css" rel="stylesheet" type="text/css"/>
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
	
	
	<div id="wrapper-pri-cont" class="wrapper-pri">
		
		<h3 style="font-size: 32px; margin-bottom: 20px; border-bottom:1px dashed #BCBCBC; line-height: 49px;"><?php echo contact; ?></h3>
		

		<div id="section1">
		<h3><?php echo contactanos02; ?></h3>
		
		<p> <?php echo contactanos03; ?><a id="ContSoporte" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		<div id="section2">
		<h3><?php echo contactanos05; ?></h3>
		
		<p> <?php echo contactanos06; ?> <a id="ContConsulta" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		<div id="section3">
		<h3><?php echo contactanos07; ?></h3>
		
		<p> <?php echo contactanos08; ?> <a id="ContSugerencia" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		<div id="section4">
		<h3><?php echo contactanos09; ?></h3>
		
		<p> <?php echo contactanos10; ?> <a id="ContEmpresa" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		<div id="section5">
		<h3><?php echo contactanos11; ?></h3>
		
		<p> <?php echo contactanos12; ?> <a id="ContDenuncia" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		<div id="section6">
		<h3><?php echo contactanos13; ?></h3>
		
		<p> <?php echo contactanos14; ?> <a id="ContOtro" class="linkGreen" href="#"><?php echo contactanos04; ?></a>.
		</p>
		</div>
		
		
		<div id="collapse-form">
		 <div id="form-contact" class="container">
		 <form id="form-contact-inspiter" class="form-signup-inspiter" action="/web/sendMail.php" tabindex="1" method="post">
				<label class="control-label contactLabel" for="inputNewPass"><?php echo contactanos15; ?></label>
				<div id="reqNameCont" class="alert-NameCont"></div>
				<div class="input-prepend">
				 <input type="text" class="input contact" id="ContactName" name="ContactName" tabindex="1" maxlength="30">
				</div>
				<label class="control-label contactLabel" for=""><?php echo contactanos16; ?></label>
				<div id="reqMailCont" class="alert-MailCont"></div>
				<div class="input-prepend">
				 <input type="text" class="input contact" id="ContactEmail" name="ContactEmail" tabindex="2" maxlength="30">
				</div>
				<label class="control-label contactLabel" for=""><?php echo contactanos17; ?></label>
				<div id="reqSubjectCont" class="alert-SubjectCont"></div>
				<div class="input-prepend">
				 <input type="text" class="input contact" id="ContactAsunto" name="ContactAsunto" tabindex="3" maxlength="30">
				</div>
				<label class="control-label contactLabel" for=""><?php echo contactanos18; ?></label>
				<div id="reqMessageCont" class="alert-MessageCont"></div>
				<div class="input-prepend">
				 <textarea id="ContacTextArea" name="ContacTextArea" class="quick-inspiration-box-big" tabindex="4"></textarea>
				</div>
                                <input type="hidden" class="input contact" id="ContactOption" name="ContactOption">
				<button id="ContactSubmit" type="submit" class="btn btn-success"><?php echo contactanos19; ?></button>
		 </form>
		 </div>
		 <div id="socialInv">
		 <p id="socialTextInv"> <?php echo contactanos20; ?></p>
		 <div id="socialInspiterSite">
			<a id="FaceInspiter" href="http://www.facebook.com/InspiterOficial" target="_blank"><div id ="iconFaceSite" class="iconSite"></div>Facebook</a>
			<a id="TwitterInspiter" href="https://twitter.com/InspiterOficial" target="_blank"><div id ="iconTwitterSite" class="iconSite"></div>Twitter</a>
		 </div>
		 </div>
		</div>
		
		
		
		
	</div>
	 
	  <div id="wrapper-volver-ter" class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo contactanos21; ?></a>
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
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript" src="js/validate-contactenos.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
 /*EFECTO SUBE Y BAJA DEL FORMULARIO CONTACTENOS*/
 var $collapse_form = $("#collapse-form");
 
	 $("#ContSoporte").click(function(){
		
		if($collapse_form.css("top") == "180px" )
			 {
				
				$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
					return false;
			 }
			 else
				{
				
				$collapse_form.animate({
						top:'180px',
						height:'510px'
        },600);
				 return false;
				}
	 });
	 
	 $("#ContConsulta").click
	 (
			function(){
			 
			 if($collapse_form.css("top") == "200px" )
			 {
	
					$("#section1").fadeIn();
					$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
				return false;
			 }
			 else
			 {
				
				
					$collapse_form.animate({
						top:'200px',
						height:'510px'
					},500);
					$("#section1").fadeOut(450);
				 return false;
			 }
					
			});
	
	 
	 
	 $("#ContSugerencia").click(function(){
					
			 if($collapse_form.css("top") == "220px" )
			 {
					
					$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
					$("#section1").fadeIn();
					$("#section2").fadeIn();
				return false;
			 }
			 else
			 {
				
				 $collapse_form.animate({
						top:'220px',
						height:'510px'
				 },600);
				 $("#section1").fadeOut(600);
				$("#section2").fadeOut(600);
				 return false;
			 }
		
	 });
	 
	 $("#ContEmpresa").click(function(){
		
		 if($collapse_form.css("top") == "180px" )
			 {
					
					$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
					$("#section1").fadeIn();
					$("#section2").fadeIn();
					$("#section3").fadeIn();
				return false;
			 }
			 else
			 {
				
				 $collapse_form.animate({
						top:'180px',
						height:'510px'
        },600);
				
				 $("#section1").fadeOut(600);
				$("#section2").fadeOut(600);
				$("#section3").fadeOut(600);
				 return false;
			 }
		
		
	 });
	 
	 	 $("#ContDenuncia").click(function(){
		
		 if($collapse_form.css("top") == "180px" )
			 {
					
					$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
					$("#section1").fadeIn();
					$("#section2").fadeIn();
					$("#section3").fadeIn();
					$("#section4").fadeIn();
				return false;
			 }
			 else
			 {
				
				 $collapse_form.animate({
						top:'180px',
						height:'510px'
        },600);
				
				 $("#section1").fadeOut(600);
				$("#section2").fadeOut(600);
				$("#section3").fadeOut(600);
				$("#section4").fadeOut(600);
				 return false;
			 }
		
		
	 });
	 
	 $("#ContOtro").click(function(){
		
		if($collapse_form.css("top") == "180px" )
			 {
					
					$collapse_form.animate({
						top:'745px',
						height:'0'
					},400);
					$("#section1").fadeIn();
					$("#section2").fadeIn();
					$("#section3").fadeIn();
					$("#section4").fadeIn();
					$("#section5").fadeIn();
				return false;
			 }
			 else
			 {
				
				 $collapse_form.animate({
						top:'180px',
						height:'510px'
        },600);
				
				 $("#section1").fadeOut(600);
				$("#section2").fadeOut(600);
				$("#section3").fadeOut(600);
				$("#section4").fadeOut(600);
				$("#section5").fadeOut(600);
				 return false;
			 }
		
	 });
	 
	 
	 
 });
</script>
<!-- End Scripts -->
  
</body>
</html>