<?php
require_once 'web/clases/Login.php';
require_once 'web/clases/Session.php';
session_start();

//cerea las varaibles de sesiones
$_SESSION['email'] = '';
$_SESSION['username']='';
$_SESSION['email']='';
$_SESSION['fullname']='';
$_SESSION['city']='';
$_SESSION['fid']='';
$_SESSION['image']='';
$_SESSION['imageSmall']='';

//detecta el lenguaje del sistema
$_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
include("web/lang_".$_SESSION['languaje'].".php");

//if (strrpos($_SERVER['SERVER_NAME'],"inspiter.com") == 0)
  //{header("Location:http://www.inspiter.com");}

if($_GET['logout']=='ok' && $_GET['activate']=='si' && $_GET['uid']=='Y')
{
         $result = Session::delete($_SESSION['iduser']);
         session_destroy();
         setcookie("iduser","",time()-86400);
         setcookie("iduser","",time()-86400,"/js");
         setcookie("iduser","",time()-86400,"/css");
         unset($_COOKIE["iduser"]);
         header("location: /");
}
else
if (!isset($_SESSION['iduser']))
{
  if (isset($_COOKIE['iduser'])==true && $_COOKIE['iduser'] != '')
  {
      $_SESSION['iduser'] = $_COOKIE['iduser'];
      header("location: /main.php");
  }
}
 else
 {header("location: /main.php"); }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Inspiter</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="google-site-verification" content="UqzIPGK-7bS900ojkJ8nTlUNrJSF73fj-Be3ge4STTg" />
<meta name="copyright" content="inspiter.com" />
<meta name="description" content="Inspiter es la primera red social del mundo en la que podr&aacute;s encontrar las frases m&aacute;s inspiradoras, desde aqu&iacute; podr&aacute;s seguir a las personas que d&iacute;a a d&iacute;a inspiran con frases que han dado la vuelta al mundo durante much&iacute;simos a&ntilde;os." />
<meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter" />
<meta name="robots" content="index, follow" />
<!-- Styles
====================================-->
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/style-index.css" rel="stylesheet" type="text/css"/>

<!-- End Styles -->
</head>

<body class="indexBody">
<div id="fb-root"></div>

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

<?php
if ((isset($_GET['error']) == true) && ($_GET['error'] = 'ExistUser')) {
    /* mensaje de validacion de username y/o contrase�a */
    echo "<div id='ErrorMesUser'>Su usuario o contrase&ntilde;a no son correctas</div>";
}
?>

        <!-- barra de navegacion

        =============================================-->

        <div class="navbar navIndex">

            <div class="navbar-inner">

                <div class="container">

                    <a id="logo" class="span4" href="/">

                        <h1>Inspiter</h1>  <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->

                            <!--<small>inspira tu mundo</small> <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->
                    </a>

                </div>

            </div>

        </div>

        <!-- END barra de navegacion -->

        <!--Primer bloque: Cambio de colores, frase insignia de Inspiter -->
        <div class="Oneblock effectColor">
            <div class="InspiterPhraseIns">
                <h1><?php echo defineInspiterIndex; ?></h1>
                <form id="logging" class="sign_up" action="web/checkLogin.php" method="post">
                    <input type="text" class="inputIndex" id="log-username" name="log-username" tabindex="1" maxlength="200" placeholder="<?php echo useroremail; ?>">
                    <span><a id="forgot" class="textForget" href="/recuperarClave.php"><?php echo olvidaPass; ?></a></span>
                    <input type="password" class="inputIndex" id="log-password" name="log-password" tabindex="2" placeholder="<?php echo contrasenia; ?>">
                    <button id="iniciar-sesion" name="iniciar-sesion" type="submit" class="special-btn facebook badge-facebook-connect LoginBtnIndex"><?php echo iniSes; ?></button>
                    <a id="auth-loginlink" name="auth-loginlink" class="special-btn facebook badge-facebook-connect faceBtnIndex" label="LoginFormFacebookButton"><?php echo iniFacebook; ?></a>
                    <div id="register-text">
                        <a class="register-btn-index" href="register.php"><?php echo registrarse; ?></a>
                    </div>

                </form>
            </div>
        </div>
        <!-- END Primer bloque: Cambio de colores, frase insignia de Inspiter -->



        <!-- Segundo bloque: Minitutorial, resumen de que es Inspiter -->
        <div class="containerTuto">
            <div class="row">
                    <h1 style="display: none;">
                        <strong>Inspiter</strong> <?php echo defineInspiterIndex2; ?>
                    </h1>
                    <ul class="BlockTextMiniTuto">
                        <li>
                            <span class="textMiniTuto tutotext1"><?php echo motivado; ?></span>
                        </li>
                        <li>
                            <span class="textMiniTuto tutotext2"><?php echo comparteMotiva; ?></span>
                        </li>
                        <li>
                            <span class="textMiniTuto tutotext3"><?php echo contagiaInsp; ?></span>
                        </li>
                    </ul>

                    <ul class="BlockImgMiniTuto">
                        <li>
                            <div class="imgMiniTuto tuto1"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto2"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto3"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto2"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto5"></div>
                        </li>
                    </ul>

                    <div class="separateBlock">
                        <div class="lineSeparate"></div>
                        <div class="OrText"></div>
                    </div>

                    <ul class="BlockImgMiniTuto">
                        <li>
                            <div class="imgMiniTuto tuto6"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto2" style="margin:40px 0 0 35px !important"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto4"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto2" style="margin: 40px 0px 0px 14px!important;"></div>
                        </li>
                        <li>
                            <div class="imgMiniTuto tuto1" style="margin-left: 22px!important;"></div>
                        </li>
                    </ul>

                    <ul class="BlockTextMiniTuto">
                        <li>
                            <span class="textMiniTuto tutotext1 blocktext1"><?php echo desmotivado; ?></span>
                        </li>
                        <li>
                            <span class="textMiniTuto tutotext2 blocktext2"><?php echo disfrutaInspFav; ?></span>
                        </li>
                        <li>
                            <span class="textMiniTuto tutotext3 blocktext3"><?php echo contagMotRecar; ?></span>
                        </li>
                    </ul>
            </div>
            <div class="tutoFase">

            </div>
        </div>
        <!-- END Segundo bloque: Minitutorial,resumen de que es Ispiter -->

        <!-- Tercer bloque: Lo que encontraran en Inspiter -->
        <div class="ThreeBlock">
        <div class="TitleBlock">
            <span><?php echo loqueEncontraras; ?></span>
        </div>
        <div id="containerImagesIndex" class="containerImagesIndex">
            <div class="ImagesIndex" style="height:330px;">
                <img class="imageToShow" src="/images/graphIns/3a759324035.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Ariel Valles" target="_blank" href="/ArielValles">Ariel Valles</a>
                        <a id="post_avatar" class="post_avatar" title="Ariel Valles" target="_blank" href="/ArielValles" style="background-image: url('../images/perfiles/smallMenu/ArielValles_131433801.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:496px;">
                <img class="imageToShow" src="/images/graphIns/4a731611184.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">Sergio Ruiz Davila</a>
                        <a id="post_avatar" class="post_avatar" title="Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:247px;">
                <img class="imageToShow" src="/images/graphIns/66a11815829.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:219px;">
                <img class="imageToShow" src="/images/graphIns/81a841345004.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Maru Heredia" target="_blank" href="/Maruk">Maru Heredia</a>
                        <a id="post_avatar" class="post_avatar" title="Maru Heredia" target="_blank" href="/Maruk" style="background-image: url('../images/perfiles/smallMenu/Maruk_970265812.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:493px;">
                <img class="imageToShow" src="/images/graphIns/66a911754597.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex TextIndex" style="height:178px;">
                <div class="comillas-background-right">
                    <img alt="" src="images/comillas-right.png">
                </div>
                <div class="comillas-background-left">
                    <img alt="" src="images/comillas-left.png">
                </div>
                <div class="inner-phrase phraseIndex">
                    <blockquote class="pullquote">Se humilde para admitir tus errores, inteligente para aprender de ellos, y maduro para corregirlos.</blockquote>
                    <div class="autorTextIndex">
                        <a class="autor-name" href="#">ANONIMO</a>
                    </div>
                </div>
                <div class="footerBgText"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sebastian Lopez" target="_blank" href="/sebii">Sebastian Lopez</a>
                        <a id="post_avatar" class="post_avatar" title="Sebastian Lopez" target="_blank" href="/sebii" style="background-image: url('../images/perfiles/smallMenu/sebii.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:239px;">
                <img class="imageToShow" src="/images/graphIns/3a56145668.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Ariel Valles" target="_blank" href="/ArielValles">Ariel Valles</a>
                        <a id="post_avatar" class="post_avatar" title="Ariel Valles" target="_blank" href="/ArielValles" style="background-image: url('../images/perfiles/smallMenu/ArielValles_131433801.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:203px;">
                <img class="imageToShow" src="/images/graphIns/184a748524719.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sebastian Molina" target="_blank" href="/molinacle">Sebastian Molina</a>
                        <a id="post_avatar" class="post_avatar" title="Sebastian Molina" target="_blank" href="/molinacle" style="background-image: url('../images/perfiles/smallMenu/molinacle.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:331px;">
                <img class="imageToShow" src="/images/graphIns/79a143251692.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Christian Langer" target="_blank" href="/Langer">Christian Langer</a>
                        <a id="post_avatar" class="post_avatar" title="Christian Langer" target="_blank" href="/Langer" style="background-image: url('../images/perfiles/smallMenu/Langer_938774611.JPG');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:247px;">
                <img class="imageToShow" src="/images/graphIns/66a27314901.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex TextIndex" style="height:156px;">
                <div class="comillas-background-right">
                    <img alt="" src="images/comillas-right.png">
                </div>
                <div class="comillas-background-left">
                    <img alt="" src="images/comillas-left.png">
                </div>
                <div class="inner-phrase phraseIndex">
                    <blockquote class="pullquote">NO SE DEBE CONFUNDIR LA VERDAD CON LA OPINIÓN DE LA MAYORÍA.</blockquote>
                    <div class="autorTextIndex">
                        <a class="autor-name" href="#">JEAN COCTEAU</a>
                    </div>
                </div>
                <div class="footerBgText"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Verónica Maza" target="_blank" href="/Veronica">Verónica Maza</a>
                        <a id="post_avatar" class="post_avatar" title="Verónica Maza" target="_blank" href="/Veronica" style="background-image: url('../images/perfiles/smallMenu/Veronica.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:292px;">
                <img class="imageToShow" src="/images/graphIns/66a70135505.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:247px;">
                <img class="imageToShow" src="/images/videoImageIns/6a879114833.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Gonzalo Platero" target="_blank" href="/gonzza">Gonzalo Platero</a>
                        <a id="post_avatar" class="post_avatar" title="Gonzalo Platero" target="_blank" href="/gonzza" style="background-image: url('../images/perfiles/smallMenu/gonzza_480503357.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:496px;">
                <img class="imageToShow" src="/images/graphIns/6a224320976.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Gonzalo Platero" target="_blank" href="/gonzza">Gonzalo Platero</a>
                        <a id="post_avatar" class="post_avatar" title="Gonzalo Platero" target="_blank" href="/gonzza" style="background-image: url('../images/perfiles/smallMenu/gonzza_480503357.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:220px;">
                <img class="imageToShow" src="/images/graphIns/66a981012707.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:473px;">
                <img class="imageToShow" src="/images/graphIns/93a11164054.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Roxi" target="_blank" href="/roxi.penaloza">Roxi</a>
                        <a id="post_avatar" class="post_avatar" title="Roxi" target="_blank" href="/roxi.penaloza" style="background-image: url('../images/perfiles/smallMenu/roxi.penaloza.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:247px;">
                <img class="imageToShow" src="/images/videoImageIns/181a99032910.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Gabriela Montoya A." target="_blank" href="/GabyMontoya">Gabriela Montoya A.</a>
                        <a id="post_avatar" class="post_avatar" title="Gabriela Montoya A." target="_blank" href="/GabyMontoya" style="background-image: url('../images/perfiles/smallMenu/GabyMontoya_745658780.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex TextIndex" style="height:156px;">
                <div class="comillas-background-right">
                    <img alt="" src="images/comillas-right.png">
                </div>
                <div class="comillas-background-left">
                    <img alt="" src="images/comillas-left.png">
                </div>
                <div class="inner-phrase phraseIndex">
                    <blockquote class="pullquote">La curiosidad ha dejado más mujeres embarazadas, que gatos muertos..</blockquote>
                    <div class="autorTextIndex">
                        <a class="autor-name" href="#">ANONIMO</a>
                    </div>
                </div>
                <div class="footerBgText"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Laura" target="_blank" href="/Laura">Laura</a>
                        <a id="post_avatar" class="post_avatar" title="/Laura" target="_blank" href="/Laura" style="background-image: url('../images/perfiles/smallMenu/Laura_359002177.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:466px;">
                <img class="imageToShow" src="/images/graphIns/66a694701568.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:330px;">
                <img class="imageToShow" src="/images/graphIns/4a94113446.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">Sergio Ruiz Davila</a>
                        <a id="post_avatar" class="post_avatar" title="Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex TextIndex" style="height:155px;">
                <div class="comillas-background-right">
                    <img alt="" src="images/comillas-right.png">
                </div>
                <div class="comillas-background-left">
                    <img alt="" src="images/comillas-left.png">
                </div>
                <div class="inner-phrase phraseIndex">
                    <blockquote class="pullquote">Me gustaría ser pobre por un dia...Porque esto de serlo todos los días me parece un abuso...</blockquote>
                    <div class="autorTextIndex">
                        <a class="autor-name" href="#">ANONIMO</a>
                    </div>
                </div>
                <div class="footerBgText"></div>
                <div class="posted_by thumbIndex">
                      <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Federico Gonzalez" target="_blank" href="/federico.gonzalez.7771">Federico Gonzalez</a>
                        <a id="post_avatar" class="post_avatar" title="Federico Gonzalez" target="_blank" href="/federico.gonzalez.7771" style="background-image: url('../images/perfiles/smallMenu/federico.gonzalez.7771.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:219px;">
                <img class="imageToShow" src="/images/graphIns/81a346185557.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Maru Heredia" target="_blank" href="/Maruk">Maru Heredia</a>
                        <a id="post_avatar" class="post_avatar" title="Maru Heredia" target="_blank" href="/Maruk" style="background-image: url('../images/perfiles/smallMenu/Maruk_970265812.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:190px;">
                <img class="imageToShow" src="/images/graphIns/3a832985720.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Ariel Valles" target="_blank" href="/ArielValles">Ariel Valles</a>
                        <a id="post_avatar" class="post_avatar" title="Ariel Valles" target="_blank" href="/ArielValles" style="background-image: url('../images/perfiles/smallMenu/ArielValles_131433801.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:409px;">
                <img class="imageToShow" src="/images/graphIns/24a34064802.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por gera" target="_blank" href="/chavexx">gera</a>
                        <a id="post_avatar" class="post_avatar" title="gera" target="_blank" href="/chavexx" style="background-image: url('../images/perfiles/smallMenu/chavexx.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:233px;">
                <img class="imageToShow" src="/images/graphIns/66a454257475.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Memii Lo" target="_blank" href="/emilialopez">Memii Lo</a>
                        <a id="post_avatar" class="post_avatar" title="Memii Lo" target="_blank" href="/emilialopez" style="background-image: url('../images/perfiles/smallMenu/emilialopez_210756248.jpg');">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:251px;">
                <img class="imageToShow" src="/images/graphIns/4a59068041.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">Sergio Ruiz Davila</a>
                        <a id="post_avatar" class="post_avatar" title="Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ImagesIndex" style="height:206px;">
                <img class="imageToShow" src="/images/graphIns/4a972807772.jpg">
                <div class="footerBg"></div>
                <div class="posted_by thumbIndex">
                    <div class="post_info">
                        <?php echo compartidoPor; ?> <a title="Publicado por Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">Sergio Ruiz Davila</a>
                        <a id="post_avatar" class="post_avatar" title="Sergio Ruiz Davila" target="_blank" href="http://www.inspiter.com/sedavila">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="TitleBlockFooter">
            <div class="wraptext">
                <span><?php echo muchasInspmas; ?></span>
            </div>
        </div>
    </div>
        <!-- END Tercer bloque: Lo que encontraras en Inspiter -->

        <!-- Cuarto bloque: Frases Graficas -->
        <div class="containerTuto BlockPhraseGraph">

            <div class="textInviteBlock">
                    <h1><?php echo crearfrasegrafica; ?></h1>
                    <h2><?php echo colocaFondo; ?></h2>
                    <h2>:o</h2>
                </div>

            <div class="ContainerPhraseGraph">
                <div class="EditPhrase">
                    <div class="TitleEditPhrase">
                        <span class="textMiniTuto textEditShow"><?php echo creaPropFrase; ?></span>
                    </div>
                    <div class="PhraseGraphImage"></div>
                </div>
                <div class="posSharePhrase">
                    <div class="arrowsShare"></div>
                    <div class="boxShare"></div>
                    <div class="textShare">
                        <span class="textMiniTuto" style="font-size: 23px;text-align: left;"><h1><?php echo publicalasRedes; ?> </h1>
<br>
<?php echo editarInstagram; ?></span>
                    </div>
                    <div class="posLiSocial">
                        <ul>
                            <li class="socialMedia face"></li>
                            <li class="socialMedia instagram"></li>
                            <li class="socialMedia google"></li>
                            <li class="socialMedia twitter"></li>
                            <li class="socialMedia pinterest"></li>
                            <li class="socialMedia tumblr"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Cuarto bloque: Frases Graficas -->



        <!-- Quinto bloque: Invitación a registrarse -->

        <div class="InviteRegiterBlock">
            <div class="innerBlock">
                <div class="textInviteBlock">
                    <h1><?php echo listoFabuloso; ?></h1>
                    <h2><?php echo nodemoraras; ?></h2>
                </div>
                <div class="buttonInviteBlock">
                    <a class="buttonRegisterInvite" href="register.php"><?php echo uneteInsp; ?></a>
                </div>
            </div>
        </div>

        <!-- END Quinto bloque: Invitación a registrarse -->

        <!-- bloque principal (imagen, frase randomica)

        =============================================-->


        <!-- END bloque principal (imagen, frase randomica)-->


        <!-- footer

        =============================================-->

        <input type="hidden" id="faceid" name="faceid"></input>
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

                            <li>                                                                                                                                                                                                             <a id="footerSiteFace" href="http://www.facebook.com/InspiterOficial" target="_blank"><span>Facebook</span></a>

                                <a id="footerSiteTwitter" href="https://twitter.com/InspiterOficial" target="_blank"><span>Twitter</span></a>

                            </li>

                     </ul>

                </div>

            </div>

        </div>

    <!-- END bloque principal (imagen, frase randomica)-->

    <!-- Scripts

    ====================================

    <!-- Placed at the end of document so the pages load faster -->

    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>

    <script type="text/javascript" src="js/bootstrap-collapse.js"></script>

    <script type="text/javascript" src="js/loginFace.js"></script>

    <script type="text/javascript" src="js/layoutColumn.js"></script>

    <script type="text/javascript" src="js/indexNew.js"></script>

 </body>

</html>

