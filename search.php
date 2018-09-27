<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");
require_once("web/clases/Phrase.php");
require_once("web/clases/Inspiter.php");
require_once("web/clases/Follow.php");
require_once("web/clases/Notification.php");
require_once("web/clases/Config.php");
require_once("web/clases/Token.php");

setcookie("urlLog");
if (!isset($_SESSION['iduser'])) {
    $login = new Login();
    $login->startLogin(3600, NULL, NULL, 1);
} else {
       if(!isset($_COOKIE["iduser"]) || $_COOKIE["iduser"] == '')
           setcookie("iduser",$_SESSION['iduser'],time()+86400);
    //datos user
    $User1 = User::getUser($_SESSION['iduser']);

    //datos frases
    $inspiterAmount = 0;
    $inspiterResult = Inspiter::getAmountInspiter($_SESSION['iduser']);
    if (is_numeric($inspiterResult) == true)
        $inspiterAmount = $inspiterResult;

    //datos follow
    $seguidoresAmount = 0;
    $seguidoresResult = Follow::getAmountSeguidores($_SESSION['iduser']);
    if (is_numeric($seguidoresResult) == true)
        $seguidoresAmount = $seguidoresResult;

    $siguiendoAmount = 0;
    $siguiendoResult = Follow::getAmountSiguiendo($_SESSION['iduser']);
    if (is_numeric($siguiendoResult) == true)
        $siguiendoAmount = $siguiendoResult;

    $notificationsResult = Config::getNotificationAmountShowed($_SESSION['iduser']);
    if (is_numeric($notificationsResult) == true && $notificationsResult > 0)
        $notificationsAmount = $notificationsResult;

    $tokenAccountResult = Token::isAccountActivated($User1->getEmail());
    if (is_numeric($tokenAccountResult) == false)
        $tokenAccountResult = 0;
    
    $registerUserFirst = User::IsFirstTimeRegister($User1->getUserId());
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="inspiter.com" />
        <meta name="description" content="Busqueda <?php echo $_GET['resultsfor']?>" />
        <meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, perfil de usuario, usuarios" />
        <meta name="robots" content="index, follow" />
        <title><?php if($notificationsAmount != null )
            {echo '('.$notificationsAmount.') Inspiter';}
            else echo 'Inspiter';?></title>

        <!--<link rel="shortcut icon" href="images/favicon.png" />-->
        <link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <!--<link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.png"/> -->
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-home.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-Main.css" rel="stylesheet" type="text/css"/> 
        <link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-search.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36281562-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>

    <body class="profile-body">
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
                js.src = "//connect.facebook.net/es_LA/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));
           
    
            
            
        </script>
        <input type="hidden" id="Iam" value="search"/>
        <input type="hidden" id="city" value="<?php echo $User1->getCity(); ?>">
        <input type="hidden" id="sessionId" value="<?php echo $_SESSION['iduser']; ?>">
        <input type="hidden" id="inviteFriends" value="<?php echo $User1->getInviteFriends(); ?>">
        <input type="hidden" id="userFaceid" value="<?php echo $User1->getFaceId(); ?>">
        <input type="hidden" id="userId" value="<?php echo $User1->getUserId(); ?>">
        <input type="hidden" id="fullname" value="<?php echo $User1->getFullName(); ?>">
	<input type="hidden" id="fullnameHidden" value="<?php echo $User1->getFullName(); ?>" />
        <input type="hidden" id="userLogin" value="<?php echo $User1->getUserLogin(); ?>">
	<input type="hidden" id="usernameHidden" value="<?php echo $User1->getUserLogin(); ?>">
        <input type="hidden" id="faceidHidden" value="<?php echo $User1->getFaceId(); ?>">
        <input type="hidden" id="photo" value="<?php
$variable = $User1->getPhoto();
if (isset($variable) == true)
    echo $User1->getPhoto();
else {
    ?> images/perfiles/avatar-inspiter.jpg <?php } ?>"></input>
        <div class="navbar navbar-fixed-top">

            <div class="navbar-inner">


                <div class="container">

                    <a id="logo" class="span4" href="/">

                        <h1>Inspiter</h1>  <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->
                        <!--<small>inspira tu mundo</small> <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->

                    </a>


                    <!-- <div id="messageNavBar" class="messageNavBar"></div>-->

                    <ul class="nav pull-right">

                        <li id="countNotificPos" class="style-Notif">
                            <a id="countNotif" href="#"><?php echo $notificationsAmount; ?><i class="icon-notif"></i></a>
                        </li>

                        <li><a id="btn-inspiration" name="btn-inspiration" href="#"><i class="icon-inspiration"></i></a></li>

                        <li class="divider-vertical"></li>

                        <li class="dropdown">

                            <a data-toggle="dropdown" class="dropdown-toggle" id="btn-myprofile" name="btn-myprofile" role="button" href="#">
                                <i class="icon-myprofile"></i>
                            </a>

                            <ul class="dropdown-menu myprofile" aria-labelledby="btn-myprofile" role="menu">

                                <li class="userInfo-menu">
                                    <a href="/<?php echo $User1->getUserLogin(); ?>" tabindex="-1">

                                        <div class="avatar-img-menu">

                                            <img class="img-user-menu" src="<?php
               $variable = $User1->getPhotoSmall();
               if (isset($variable) == true)
                   echo $User1->getPhotoSmall();
               else {
    ?> images/perfiles/avatar-inspiter-small.jpg <?php } ?>" alt="Inspiter">

                                        </div>

                                        <div class="Name-user-info-menu">
                                            <span id="Name-user-menu"> <?php echo $User1->getFullName(); ?></span>
                                            <span id="Username-user-menu"><?php echo $User1->getUserLogin(); ?></span>
                                        </div>
                                    </a>
                                </li>




                                <li class="main-menu-list">
                                    <a href="main.php" tabindex="-1">
                                        <div id="ico-main"></div> 
                                        Men&uacute; Principal
                                    </a>
                                </li>

                                <li class="invitFriend-menu-list">
                                    <a href="friend.php" tabindex="-1">
                                        <div id="ico-invFri"></div>
                                        Buscar Amigos
                                    </a>
                                </li>
                                
                               <li class="Tutor-menu-list">
                                   <a  id="TutorialOption" href="#" tabindex="-1">
                                  <div id="ico-tuto"></div>
                                      Tutorial
                                    </a>
                                </li>

                                <li class="config-menu-list">
                                    <a id="ConfigButtonMenu" href="#myModal" tabindex="-1" data-toggle="modal" >
                                        <div id="ico-conf"></div>
                                        Configuraci&oacute;n
                                    </a>
                                </li>

                                <li class="logout-menu-list">
                                    <a href="web/logout.php?sessionId=<?php echo $_SESSION['iduser']; ?>" tabindex="-1">
                                        <div id="ico-logout"></div>
                                        <strong>Cerrar Sesi&oacute;n</strong>
                                    </a>
                                </li>
                            </ul>

                        </li>		




                    </ul>

                </div>

            </div>

        </div>



        <!-- Modal de Configuracion  -->

        <div class="modal hide fade in" id="myModal" style="display:none;">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>

                <h3 id="myModalLabel">Configuraci&oacute;n de Cuenta</h3>

            </div>

            <div class="modal-body">

                <div id="login-username-block" class="field">

                    <label class="control-label" for="inputNameConf">Nombre Completo</label>


                    <input type="text" class="input" id="inputNameConf" name="inputNameConf" tabindex="2" maxlength="19" placeholder="Nombre" value="<?php echo $User1->getFullName(); ?>">

                </div>

               
                <div id="city-position-conf">

                    <label class="control-label" for="inputCityConf">

                        Ciudad   

                    </label>



                    <input type="text" class="input" id="inputCityConf" name="inputCityConf"  maxlength="15" tabindex="6" placeholder="Ciudad" value="<?php echo $User1->getCity(); ?>">
                </div>



                <div id="passPosConf">

                    <label id="labelContrasena1" class="control-label" for="password">

                        Contrase&ntilde;a actual

                    </label><span><a id="forgot" href="#">Olvidaste tu contrase&ntilde;a?</a></span>

                    <input type="password" class="input" id="inputPassword1Conf" name="inputPassword1Conf" tabindex="2"></br>

                    <label id="labelContrasena2" class="control-label" for="password">

                        Nueva Contrase&ntilde;a

                    </label>

                    <input type="password" class="input" id="inputPassword2Conf" name="inputPassword2Conf" tabindex="2"></br>

                    <div class="message-box-pass"></div>

                    <label id="labelContrasena3" class="control-label" for="password">

                        Verificar Contrase&ntilde;a

                    </label>

                    <input type="password" class="input" id="inputPassword3Conf" name="inputPassword3Conf" tabindex="2">


                </div>

                <div class="message-box-pass2"></div>

                <div id="NewPhoto-Position">

                    <label class="control-label" for="avatarNewPics">

                        Foto de Perfil  

                    </label>

                    <div id="Image-Pos">

                        <img id="fotografia" src="<?php echo $User1->getPhoto(); ?>" alt="" style="border:1px solid #989898;"></img>

                    </div>

                    <div id="ChangePos">

                        <a id="addImage" class="button" href="#">Cambiar Imagen</a>

                    </div>

                    <div class="loaderAjax" id="loaderAjax">

                        <img src="images/ajax-loader.gif">

                        <span>Actualizando Fotograf&iacute;a...</span>

                    </div>

                </div>

            </div>

            <div class="footer-modal-config">

                <div id="SuccessAsoc">
                    <p id="messageAsocSucc">Su cuenta se encuentra asociada a Facebook exitosamente.</p><span><img src="images/checkSucc.png"/></span>  
                    <a id="inv-facebook" class="special-btn facebook badge-facebook-connect" href="#" label="AssociateWithFormFacebookButton">Invitar amigos de Facebook</a>
                    <p id="invPhrase">Dale la oportunidad a tus amigos de conocer a Inspiter</p>
                </div>

                <div id="AsoPos">
                    <a id="asso-btn-facebook-modal" class="special-btn facebook badge-facebook-connect" href="#" label="AssociateWithFormFacebookButton">Asociar datos de Facebook</a>
                    <p>Si no asocias tu cuenta no podr&aacute;s compartir frases en Facebook</p>
                </div>

                <div id="loadingAssoc" class="loadingAssoc">
                    <img src="images/ajax-loader.gif"/>
                </div>

            </div>

            <div class="modal-footer">

                <div id="boxName" class="message-box"></div>
                <div id="boxCity" class="message-box"></div>
                <div id="boxCountry" class="message-box"></div>

                <button id="btn_cancel_data" class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>

                <button id="btn_save_data" class="btn btn-success">Guardar Cambios</button>

            </div>

        </div>
        <!-- END: Modal de Configuracion  -->




        <div class="profile-container">
				 <div class="wrapperAll">


            <!-- Phrase container writter big -->

            <div id="PhraseContBig" class="phrase-container-big">

                <div id="content-menuPhrase">

                    <h2 class="titleResult">
                        <div id="ico-result"></div>
                        Resultados con: 
                        <strong id="searchQuery" class="search-query"><?php echo $_GET['resultsfor']; ?></strong>
                    </h2>

                </div>

            </div>
            <!-- END Phrase container writter big -->
						<div id="NecSpace"></div>
            <div id="content" class="wrapper">

                <!-- Phrase Box Dynamic-->

            </div>

           <div id="LoadingInspirations"><!-- Aqui separamos en otro content la frase de regalo de Inspiter y el boton Ver mas-->
					 <!-- Load More "Link" -->
					 <div class="PartsLoading"> 
						<div class="loading-ico-more"></div>
					  <div class="load-more-inspiration">Cargando m&aacute;s inspiraciones para ti...</div> 
                                </div>
                            </div>
	 <div style="height:45px;"></div>

            <div id="main_wrapper">
                <div id="border-left-shadow"></div>
                <div id="main-menu">

                    <div id="phrase-container-writer">

                        <form id="phrase-container-form" class="post" name="phraseContainerForm" method="POST" action="#">

                            <div class="loadingPhraseSmall" id="loadingPhraseSmall"><img src="images/ajax-loader.gif"></div>
                            <div class="textarea-quick-box">
                                <textarea class="quick-inspiration-box" placeholder="Inspirate!!..." maxlength="500"></textarea>
                            </div>

                            <div id="Share-container-element">

                                <ul class="Share-element-mini">

                                    <li id="Share-text">
                                        <p>Compartir en:</p>
                                    </li>

                                    <li id="Share-facebook-check">
                                        <input type="checkbox" name="check_01_min" id="checkbox-face-mini"/>
                                    </li>

                                    <li id="Share-facebook-label" >
                                        <i class="facebook-share-icon" title="Compartir en Facebook" data-placement="bottom"></i>
                                    </li>

                                    <li id="Share-twitter-check" style="visibility:hidden">
                                        <input type="checkbox" name="check_02_min" id="checkbox-twitter-mini" />
                                    </li>

                                    <li id="Share-twitter-label" style="visibility:hidden">
                                        <i class="twitter-share-icon" title="Compartir en Twitter" data-placement="bottom"></i>
                                    </li>       <!-- TODO: Actualizacion: Twitter  -->

                                    <li id="Share-btn">
                                        <button id="sharePhrase-btn-mini" type="button" class="btn btn-success disabled" disabled="true">Publicar</button>
                                    </li>


                                </ul>

                                <div id="Share-autor-small">
                                    <p id="autor-label-small">Autor</p>
                                    <input type="text" id="sharePhrase-autor-small" placeholder="An&oacute;nimo"></input>
                                </div>

                            </div>

                        </form>

                    </div>


                    <form method="post" id="search-admire" action="">
                        <span class="search-btn">
                            <img class="icons-search-main" src="images/search-icon.png">
                        </span>

                        <input type="submit" name="submit" id="submit" value="l"></input>
                        <input type="text" name="IdUserPage" id="IdUserPage" value=""></input>
                        <input type="text" name="InspiterField" id="InspiterField" value=""></input>
                        <input type="text" id="b_keywords" name="b_keywords" placeholder="Buscar..." autocomplete="off"></input>

                    </form>

                    <div id="display-result">

                        <ul id="result-users" data-pos="">
                            <div id="result-section-users" class="result-section" data-pos="">
                                <div class="result-section-title">
                                    <span>Personas</span>
                                </div>
                            </div>

                            <!--					<li class="display_box" data-pos="" align="left">
                                                                            <a class="link-user-search" href="">
                                                                                    <img src=''>
                                                                                    <span class="NameResultSearch"></span>
                                                                                    <span class="UserResultSearch"></span>
                                                                                    <span class="CityResultSearch"></span>
                                                                            </a>
                                                                    </li>-->
                        </ul>

                        <ul id="result-phrases" data-pos="">
                            <div id="result-section-phrase" class="result-section" data-pos="">
                                <div class="result-section-title">
                                    <span>Frases</span>
                                </div>
                            </div>

                            <!--				<li id="display_box_phrase" class="display_box" data-pos="" align="left">
                                                                    <a class="link-user-search" href="/profile.php?id=">Phrase</a>
                                                            </li>-->
                        </ul>

                        <ul id="result-authors" data-pos="">
                            <div id="result-section-authors" class="result-section" data-pos="">
                                <div class="result-section-title">
                                    <span>Autores</span>
                                </div>
                            </div>

                            <!--				<li id="display_box_autores" class="display_box" data-pos="'+totalPhrases+'" align="left">
                                                                    <a class="link-user-search" href="/profile.php?id=">Author</a>
                                                            </li>-->
                        </ul>

                        <a class="see-all" href="">
                            <span class="see-all-result">Ver Todos los Resultados de la Busqueda</span>
                        </a>

                    </div>

                    <div id="main-profile-info">

                        <div class="avatar-inspiter-profile">
                            <a href="/<?php echo $User1->getUserLogin(); ?>">
                                <img class="img-user-inspiter-profile" src="<?php
                                                 $variable = $User1->getPhoto();
                                                 if (isset($variable) == true)
                                                     echo $User1->getPhoto();
                                                 else {
    ?>images/perfiles/avatar-inspiter.jpg <?php } ?>" alt="Inspiter">
                            </a>
                        </div>

                        <input type="hidden" id="photoUrl" value="<?php
                                     $variable = $User1->getPhoto();
                                     if (isset($variable) == true)
                                         echo $User1->getPhoto();
                                     else {
    ?> images/perfiles/avatar-inspiter.jpg <?php } ?>"> </input>
                        <div class="avatar-user-info-profile">
                            <input type="hidden" id="useridhidden" name="useridhidden" value="<?php echo $User1->getUserId(); ?>"></input>
                            <h4><a id="fullNamePR" class="name-complete-box-profile" href="/<?php echo $User1->getUserLogin(); ?>">
                                    <?php echo $User1->getFullName(); ?>
                                </a></h4>                    

                            <a id="usernamePR" class="username-box-profile" href="/<?php echo $User1->getUserLogin(); ?>">
                                <?php echo $User1->getUserLogin(); ?>
                            </a>
                            <p  id="cityPR" class="user-inspiter-city-country">
                                <?php echo $User1->getCity(); ?>
                            </p>
                        </div>




                        <div class="info-phrases-user-profile">
                            <ul class="profile-st">

                                <li id="inspirations">
                                    <a id="inspirationsPR" href="/<?php echo $User1->getUserLogin(); ?>"><strong><p id="pInspiraciones"><?php echo $inspiterAmount; ?></p></strong>Inspiraciones</a>
                                </li>

                                <li id="following">
                                    <a href="profile.php?id=<?php echo $User1->getUserId(); ?>&ty_me=flol" id="followingPR"><strong><p id="pFollowing"><?php echo $siguiendoAmount; ?></p></strong>Siguiendo</a>
                                </li>

                                <li id="follower">
                                    <a href="profile.php?id=<?php echo $User1->getUserId(); ?>&ty_me=fler" id="followersPR"><strong><p id="pFollower"><?php echo $seguidoresAmount; ?></p></strong>Seguidores</a><span id="amount-following">
                                </li>

                            </ul>
                        </div>
                    </div>



                    <nav id="main-menu-option">

                        <div class="titleFilterPos">
                            <h4 class="titleFilter">
                                FILTROS DE B&Uacute;SQUEDA
                            </h4>
                        </div>

                        <ul>
                            <li id="menu-tope-insp" class="option-selected">
                                <a id="inspiracionesli" href="#">
                                    <div id="ico-result-phrase"></div>
                                    Inspiraciones
                                </a>
                            </li>


                            <li id="menu-tope-pers">
                                <a id="personasli" href="#">
                                    <div id="ico-result-people"></div>
                                    Personas
                                </a>
                            </li>

                            <li id="menu-tope-aut">
                                <a id="autoresli" href="#">
                                    <div id="ico-result-autor"></div>
                                    Autores
                                </a>
                            </li>


                        </ul>
                    </nav>
                </div>
                <div id="border-right-shadow"></div>		


            </div>

            <div id="footerMainPro">
                <div class="footer inliner-list">
                    <div id="footer-container" class="container">
                        <ul id="footer-info-MainPro">
                            <li>
                                <a href="#">Inspiter &copy; 2013</a>
                            </li>
                            <li>
                                <a href="acercaDe.php">Sobre Nosotros</a>
                            </li>
                            <li>
                                <a href="#">Ayuda</a>
                            </li>
                            <li>
                                <a href="terminosCondiciones.php">Condiciones</a>
                            </li>
                            <li>
                                <a href="privacidad.php">Privacidad</a>
                            </li>
                            <li>
                                <a href="contactenos.php">Cont&aacute;ctenos</a>
                            </li>
                        </ul>
                    </div>
                </div>	
            </div>

            <input type="hidden" id="userIdLogged" value="<?php echo $User1->getUserId(); ?>"></input>
            <input type="hidden" id="isActivated" value="<?php echo $tokenAccountResult; ?>"/>
	    <input type="hidden" id="photosmall" name="photosmall" value="<?php echo $User1->getPhotoSmall(); ?>">
            <input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>"></input>

        </div>
		</div>

       <!--MODALS DEDICATION -->		
                                                                                                <div id="modalDed" class="styled">

                                                                                                    <div class="header-modal grd">
                                                                                                        <a id="closeModalDedic" class="close" href="#"><strong>Cerrar</strong><span></span></a>
                                                                                                        <h2>Dedicar Inspiraci&oacute;n</h2><div id="paper-plane-moved"></div>
                                                                                                    </div>


                                                                                                    <form id="dedicarForm" class="dedicarForm" method="POST" action="#">
                                                                                                        <ul class="ElemGroups">
                                                                                                            <li class="From NoBorderTop">
                                                                                                                <input id="FromName" type="text" name="FromName" value="<?php echo $User1->getFullName(); ?>" disabled="true">
                                                                                                                    <label>De:</label>
                                                                                                            </li>
                                                                                                            <li>
                                                                    <input id="ToName" type="text" name="ToName" autocomplete="off" tabindex="1">
                                                                                                                    <label>Para:</label>
                                                                                                            </li>
																														    <li class="ToEmailBlock">
																																 <div id="ToemailUser" class="input-prepend">
																																	<span class="add-on" id="add-on-email">@</span>
																																	<input type="text" class="input" id="ToinputEmail" name="ToinputEmail" size="16" tabindex="2"/>
																																 </div>
																																 <label>E-Mail:</label>
																																</li>

                                                                                                            <!--BUSCADOR_USER_PARA_DEDICAR-->
                                                                                                            <div id="display-result-Ded" class="display-result-Ded">

                                                                                                                <ul id="result-users-Ded" data-pos="">
                                                                        <div id="result-section-users-Ded" class="result-section" data-pos="">
                                                                            <div id="dedTitleResult" class="result-section-title">
                                                                                                                            <span>Personas</span>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <!--					<li class="display_box" data-pos="" align="left">
                                                                                                                                                                    <a class="link-user-search" href="">
                                                                                                                                                                            <img src=''>
                                                                                                                                                                            <span class="NameResultSearch"></span>
                                                                                                                                                                            <span class="UserResultSearch"></span>
                                                                                                                                                                            <span class="CityResultSearch"></span>
                                                                                                                                                                    </a>
                                                                                                                                                            </li>-->
                                                                                                                </ul>

                                                                                                            </div>
                                                                                                            <!--MODALS DEDICATION -->	

                                                                                                            <li>
                                                                    <textarea id="DedMessage" class="DedMessage" name="DedMessage" tabindex="3"></textarea>
                                                                                                                <label>Dedicatoria:</label>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                                <div class="posCheckMail">
                                                                                                                    <input id="DedCheckMail" type="checkbox" class="DedCheck" name="DedCheckMail">
                                                                                                                        <label class="checkLabelDed">Enviar a su correo electr&oacute;nico.</label>
                                                                                                                </div>
                                                                                                                <div class="posCheckFace">
                                                                                                                    <input id="DedCheckFace" type="checkbox" class="DedCheck" name="DedCheckFace">
                                                                                                                        <label class="checkLabelDed">Dejar la frase en el muro de su Facebook.</label>
                                                                                                                </div>
                                                                                                                <div class="posButtonDed">
                                                                                                                    <button id="DedSubmit" name="DedSubmit" type="button" class="btn btn-success">Dedicar</button>
                                                                                                                </div>
                                                                                                                <input type="hidden" id="dedicInspiterId" name="dedicInspiterId" value=""/>
                                                                                                                <input type="hidden" id="dedicUsername" name="dedicUsername" value=""/>
                                                                                                                <input type="hidden" id="FromUserId" name="FromUserId" value="<?php echo $User1->getUserId(); ?>"/>
                                                                                                                <input type="hidden" id="FromUsername" name="FromUsername" value="<?php echo $User1->getFullName(); ?>"/>
													        <input type="hidden" id="ToUserId" name="ToUserId" value=""/>
                                                                                                                 <input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
																																		
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </form>
                                                                                                    <!--<a href="#" id="close-modal">Close modal</a>-->

                                                                                                </div>

                                                                                                <div id="modal-background"></div>
                                                                                                <!--END: MODALS DEDICATION-->
				<div id="Bigloading" class="Bigloading">
                <img src="images/ajax-loader-big.gif">
        </div>
        <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
        <script type="text/javascript" src="js/animation.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/layoutColumn.js"></script>
        <script type="text/javascript" src="js/build-tuto.js"></script>
        <script type="text/javascript" src="js/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="js/jquery.cokidoo-textarea.js"></script>
        <script type="text/javascript" src="js/jquery.maxlength.js"></script>
        <script type="text/javascript" src="js/jquery.livequery.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
        <script type="text/javascript" src="js/constructorIns.js"></script>
        <script type="text/javascript" src="js/generatorSearch.js"></script>
        <script type="text/javascript" src="js/bootstrap-collapse.js"></script>
        <script type="text/javascript" src="js/validate-modal-main.js"></script>
        <script type="text/javascript" src="js/buscador-jquery.js"></script>
        <script type="text/javascript" src="js/buscadorDed-jquery.js"></script>
        <script type="text/javascript" src="js/notifications.js"></script>
        <script type="text/javascript" src="js/validate-dedicate.js"></script>
        <script type="text/javascript" src="js/jquery.confirm.js"></script>
        <script type="text/javascript" src="js/alert-script.js"></script>
	<!--<script type="text/javascript" src="js/ajaxupload.js"></script> -->
	<!--<script type="text/javascript" src="js/uploadImageInspiration.js"></script>-->
	
        <script type="text/javascript">
            var uvOptions = {};
            (function() {
                var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
                uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/ZfdIuPgm43KneOxv75PnQ.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
            })();
        </script>

        <!-- End Scripts -->




        <script type="text/javascript">
    
                                            

        </script>


    </body>

</html>