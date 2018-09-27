<?php
session_start();
require_once("web/clases/Login.php");
if (isset($_GET['isRegister']) == false || $_GET['isRegister'] != true) {
    if (isset($_SESSION['iduser'])) {
        $login = new Login();
        $login->startLogin(3600, NULL, NULL, 4);
    } 
}

if(!isset($_SESSION['languaje']))
{
 $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}
include("web/lang_".$_SESSION['languaje'].".php");
//se agrego este codigo para preguntar si se encuentra logueado...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="inspiter.com" />
        <meta name="description" content="Registrarse en Inspiter" />
        <meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, perfil de usuario, usuarios" />
        <meta name="robots" content="index, follow" />
        <title><?php echo register01; ?></title>

        <!-- Styles
        ====================================-->
        <link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/style-register.css" rel="stylesheet" type="text/css" />
        <link href="css/style-profile-main.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- End Styles -->

    </head>

    <body id="body-register">
        <!-- <div id="fb-root"></div> -->
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '392076184181252', // App ID
                    channelUrl : '//'+window.location.hostname+'/channel.html', // Path to your Channel File
                    status     : true, // check login status
                    cookie     : true, // enable cookies to allow the server to access the session
                    xfbml      : true  // parse XFBML
                });

                // Additional initialization code here
            };

            // Load the SDK Asynchronously
            (function(d){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));
        </script>

        <div class="wrapperRegiter">
        <div id="container-float" class="signup-login-inspiter">

			<div id="container-gradient">
					<!--<h2>Inspiter</h2>-->
					<IMG id="logo-inspiter-marked" src="images/logo-inspiter-marked.png">


				<div id="container-int">	


					<div id="container-der">
						<div class="description-inspiter">
							<h2><?php echo register02; ?></h2>
							<h3><?php echo register03; ?></h3>
							<h5><?php echo register04; ?></h5>							
                </div>

                <a id="associate-btn-facebook" class="special-btn facebook badge-facebook-connect" href="#" label="AssociateWithFormFacebookButton"><?php echo register05; ?></a>
					</div>

					<!--//////////////////////////////////////////////////////////////////////////////-->	

					<div id="container-izq">
					
					
                <form class="form-signup-inspiter" action="web/registerUser.php" method="post">


                    <label class="control-label" for="inputUsername">
                        <?php echo register06; ?>                                                         	
                    </label>

                    <input type="text" class="input" id="inputUsername" name="inputUsername" tabindex="1" maxlength="15" placeholder="<?php echo register06; ?>" 
                           value="<?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} ?>">
                                                <div id="reqUsername" class="alert-UserName"></div>    


                        <div id="login-username-block" class="field">
                            <label class="control-label" for="inputName"><?php echo register07; ?></label>

                            <input type="text" class="input" id="inputName" name="inputName" tabindex="2" maxlength="19" placeholder="<?php echo register07; ?>"
                                   value="<?php if (isset($_SESSION['fullname'])) {echo $_SESSION['fullname'];} ?>">
                            <div id="reqName" class="alert-NameComplete"></div>
                                </div>

                        <label class="control-label" for="inputPassword">
                            <?php echo register08; ?>                                                        	
                        </label>



                        <input type="password" class="input" id="inputPassword" name="inputPassword" tabindex="3" placeholder="<?php echo register08; ?>"></br>
                        <div id="reqPassword" class="alert-Password"></div>

                            <label class="control-label" for="inputEmail">
                                Email                                                        	
                            </label>

                            <div class="input-prepend">
                                <span class="add-on" id="add-on-email">@</span>
                                <input type="text" class="input" id="inputEmail" name="inputEmail" size="16" placeholder="email.com" tabindex="4"
                                       value="<?php if (isset($_SESSION['email'])) {
    echo $_SESSION['email'];
} ?>">
                            </div>
                            <div id="reqEmail" class="alert-Email"></div>
                            <div class="loaderAjax" id="loaderEmail">
                                <img src="images/ajax-loader.gif"></img>
                            </div>

							
                                <label class="control-label" for="inputCity">
                                    <?php echo register09; ?>                                                    	
                                </label>


							<input type="text" class="input" id="inputCity" name="inputCity" tabindex="6" maxlength="15" placeholder="<?php echo register18; ?>"
								   value="<?php if (isset($_SESSION['city'])) {echo $_SESSION['city'];} ?>">
                                                        <div id="reqCity" class="alert-City"></div>

						
														
                            <!--Facebook id-->
							
                            <input type="hidden" id="fid" name="fid" 
                                   value="<?php if (isset($_SESSION['fid'])) {
    echo $_SESSION['fid'];
} ?>"
                                   ></input>

                            <input type="hidden" id="countryHidden" name="countryHidden" 
                                   value="<?php if (isset($_SESSION['country'])) {
    echo $_SESSION['country'];
} ?>"
                                   ></input>
							  
                            <!--Facebook image -->
							
                            <input type="hidden" id="fimage" name="fimage" 
                                   value="<?php if (isset($_SESSION['image'])) {
    echo $_SESSION['image'];
} ?>"></input>

                            <span id="req-check-cond2" class="requisites"></span>
                            <label id="check-cond1" class="checkbox">
                                <input type="checkbox" id="check-cond2" name="check-cond2" value="true"> <?php echo register10; ?> <a id="term-cond" href="/terminosCondiciones.php"> <?php echo register11; ?></a>.
                            </label>
                            
                            <button id="registerSubmit" type="submit" class="btn btn-success disabled" disabled="true"><?php echo register12; ?></button>

                            </form>

					</div>

				</div>

                            </div>
						
		</div>
														<div id="wrapper-volver-reg" class="wrapper-volver">
														 <a id="volverLink-reg" class="volverLink" href="javascript:history.back();"><?php echo register13; ?></a>
														 <div class="icoVolver"></div>
		</div>
    </div>

<!-- FOOTER=============================================
  <div id="footer">
		<div class="footer inliner-list">
			
			<div id="footer-container" class="container">
				<ul id="footer-info">
					
					<img id="divider-left" src="images/divider-left.png">
					<img id="logo-inf" src="images/logo-inc.png">
					<img id="divider-right" src="images/divider-right.png">
				
					<li><a href="acercaDe.php">Sobre Nosotros</a></li>
					<li><a href="#">Ayuda</a></li>
					<li><a href="terminosCondiciones.php">Condiciones</a></li>
					<li><a href="privacidad.php">Privacidad</a></li>
					<li><a href="contactenos.php">Cont&aacute;ctenos</a></li>
		
				</ul>
                            </div>
		</div>	
  </div>
END FOOTER=============================================--> 
														
  
							<!--Scripts -->
							
                            <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
                            <script type="text/javascript" src="js/validate-register.js"></script>
                            <!--FEEDBACK PLUGIN -->
                            <script type="text/javascript">
                                var uvOptions = {};
                                (function() {
                                    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
                                    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/ZfdIuPgm43KneOxv75PnQ.js';
                                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
                                })();
                            </script>

							<script type="text/javascript">
								$(document).ready(function(){
								var namebox = $("#inputUsername");
								namebox.focus();});
							</script>
							
                            <!-- End Scripts -->

							

                            </body>
                            </html>