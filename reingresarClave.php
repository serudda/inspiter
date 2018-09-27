<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");

if(!isset($_SESSION['languaje']))
{
 $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}
include("web/lang_".$_SESSION['languaje'].".php");

try
{
  $userIdRC = 0;
  $emailRC = '';
  if(isset($_GET['token']) && $_GET['token'] != '')
  {
      $User1 = User::getUserByToken($_GET['token']);
      if($User1->getUserId() != NULL &&  $User1->getUserId() != '')
      {
          $userIdRC = $User1->getUserId();
          $emailRC = $User1->getEmail();
      }
      else 
          $userIdRC = 0;  
  }
  else {
      
  }
 }
 catch (Exception $e)
 { 
     $userIdRC = 0;    
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="inspiter.com" />
<meta name="description" content="Cambiar contrase&ntilde;a Inspiter" />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter" />
<meta name="robots" content="index, follow" />
<title><?php echo reingresarClave01; ?></title>

<!-- Styles
====================================-->
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin' rel='stylesheet' type='text/css'/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-register.css" rel="stylesheet" type="text/css" />
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
	
	
	<div id="wrapper-rec-con" class="wrapper-rec">
		<h3><?php echo reingresarClave02; ?></h3>
                <p><?php echo reingresarClave03." "; ?> <strong id="UserMailRec"><?php echo $User1->getFullName(); ?></strong>:</p>	
                <br/>
                 <form class="form-signup-inspiter" action="/web/actualizarClave.php" method="post">
                    <label class="RecLabel" class="control-label" for="inputNewPass"><?php echo reingresarClave04; ?></label>
		    
                    <div class="input-prepend">
                      <input type="password" class="input" id="inputNewPass" name="inputNewPass" tabindex="1" maxlength="16">
                    </div>
                    <div id="reqPasswordNew" class="alertRC alert-PasswordNew"></div>
		    <label class="RecLabel" class="control-label" for="inputConPass"><?php echo reingresarClave05; ?></label>
		
		    <div class="input-prepend">
                      <input type="password" class="input" id="inputConPass" name="inputConPass" tabindex="2" maxlength="16">
                    </div>
                    <div id="reqPasswordCon" class="alertRC alert-PasswordCon"></div>
		    <button id="RecupSubmit" name="RecupSubmit" type="submit" class="btn btn-success"><?php echo reingresarClave06; ?></button>
                    <input type="hidden" id="userIdRC" name="userIdRC" value="<?php echo $userIdRC; ?>"></input>
                    <input type="hidden" id="emailRC" name="emailRC" value="<?php echo $emailRC; ?>"></input>
                    </form>	
         </div>
	 <div id="wrapper-volver-con" class="wrapper-volver">
		<a class="volverLink" href="javascript:history.back();"><?php echo reingresarClave07; ?></a>
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
<script src="js/jquery.confirm.js"></script>
<script src="js/alert-script.js"></script>
<script src="js/validate-reingrPass.js"></script>
<script type="text/javascript">

</script>
<!-- End Scripts -->
  
</body>
</html>