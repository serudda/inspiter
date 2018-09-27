<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");
require_once("web/clases/Inspiter.php");
require_once("web/clases/Phrase.php");
require_once("web/clases/Follow.php");
require_once("web/clases/Favourite.php");
require_once("web/clases/Notification.php");
require_once("web/clases/Config.php");
require_once("web/clases/Token.php");
require_once("web/clases/Dedication.php");
$userlogged = true;


/* * * Begin - Verfica si el user esta logueado.
Caso exitoso: Por el else: "Pregunta por lo parametros que vienen por get estos pueden ser, id (solo indica el id del user), flol(muestra los siguiendo del user), fler(muestra los seguidores del user), post(muestra la inspiracion del user)"
Caso falso:   Por el if: "Entra a login, verifica las cookies, si no hay, redirecciona a index, si las hay referencia "Caso Exitoso"".
* * */
if (!isset($_SESSION['iduser'])) {
setcookie("urlLog", $_SERVER['REQUEST_URI'], time() + 31536000);
$login = new Login();
$login->startLogin(3600, NULL, NULL, 1);
} 
else 
{
  
  $User1 = User::getUser($_SESSION['iduser']);
  
 $notificationsResult = Config::getNotificationAmountShowed($_SESSION['iduser']);
 if (is_numeric($notificationsResult) == true && $notificationsResult > 0)
 $notificationsAmount = $notificationsResult;
 
 $registerUserFirst = User::IsFirstTimeRegister($User1->getUserId());
 
 $tokenAccountResult = Token::isAccountActivated($User1->getEmail()); 
 if (is_numeric($tokenAccountResult) == false)
 $tokenAccountResult = 0;
 
}
if(!isset($_SESSION['languaje']))
{
   $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}
include("web/lang_".$_SESSION['languaje'].".php");
/* * * End - Verfica si el user esta logueado.** */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="https://www.facebook.com/2008/fbml" lang="es">
<head>
<meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php
if ($notificationsAmount != null) {
echo '(' . $notificationsAmount . ') ' . $User1->getFullName();
}
else
echo $User1->getFullName();
?></title>
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin' rel='stylesheet' type='text/css'/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/style-container-inspiration.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
<link href="css/style-configuracion.css" rel="stylesheet" type="text/css"/>
<link href="css/style-inviteFriends.css" rel="stylesheet" type="text/css"/>
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
js.src = "//connect.facebook.net/en_US/all.js";
ref.parentNode.insertBefore(js, ref);
}(document));
</script>

<!-- barra de navegacion
=============================================-->	  
              <div class="navbar navbar-fixed-top">

            <div class="navbar-inner">

                <div class="container">

                    <a id="logo" class="span4" href="/">

                        <h1>Inspiter</h1>  <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->
                        <!--<small>inspira tu mundo</small> <!--Se deja para que a la hora de aplicar SEO se facilite la busqueda-->

                    </a>
	   
  <ul id="pull-right" class="nav pull-right">

<li style="margin-right: 5px;">
 <form method="post" id="search-admire" action="">
 <span class="search-btn">
 <img class="icons-search" src="images/search-icon.png">
 </span>

 <input type="submit" name="submit" id="submit" value=""/>
 <input type="text" name="IdUserPage" id="IdUserPage" value=""/>
 <input type="text" name="PhraseField" id="PhraseField" value=""/>
 <input type="text" id="b_keywords" data-locked="" name="b_keywords" placeholder="<?php echo buscar; ?>" autocomplete="off">

 </form>	
 <div id="display-result">

 <ul id="result-users" data-pos="">
		 <div id="result-section-users" class="result-section" data-pos="">
				 <div class="result-section-title">
						 <span><?php echo persona; ?></span>
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
						 <span><?php echo frase; ?></span>
				 </div>
		 </div>

		 <!--				<li id="display_box_phrase" class="display_box" data-pos="" align="left">
																						 <a class="link-user-search" href="/profile.php?id=">Phrase</a>
																		 </li>-->
 </ul>

 <ul id="result-authors" data-pos="">
		 <div id="result-section-authors" class="result-section" data-pos="">
				 <div class="result-section-title">
						 <span><?php echo friend1; ?></span>
				 </div>
		 </div>

		 <!--				<li id="display_box_autores" class="display_box" data-pos="'+totalPhrases+'" align="left">
																						 <a class="link-user-search" href="/profile.php?id=">Author</a>
																		 </li>-->
 </ul>

 <a class="see-all" href="">
		 <span class="see-all-result"><?php echo friend2; ?></span>
 </a>

</div>
</li>
      
          <li class="userInfo-menu">
      <a href="/<?php echo $User1->getUserLogin(); ?>" tabindex="-1">

       <div class="avatar-img-menu">
         <img class="img-user-menu" src="<?php $variable = $User1->getPhotoSmall();
               if (isset($variable) == true)
                   echo $User1->getPhotoSmall();?>"> </img>
       </div>

       <div class="Name-user-info-menu">
         <span id="Name-user-menu"> <?php
         if(strlen($User1->getFullName()) > 13){
         $rest = substr($User1->getFullName(), 0, -6);
         $rest = $rest."...";
         echo $rest;
         }else{
         echo $User1->getFullName();
         }
         ?></span>
       </div>
      </a>
     </li>

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

                                <li class="main-menu-list">
                                    <a href="main.php" tabindex="-1">
                                        <div id="ico-main"></div> 
                                        <?php echo exploreWorld; ?>
                                    </a>
                                </li>

                                <li class="invitFriend-menu-list">
                                    <a href="friend.php" tabindex="-1">
                                        <div id="ico-invFri"></div>
                                       <?php echo buscaAmigo; ?>
                                    </a>
                                </li>
                                
                                <li class="Tutor-menu-list">
                                                <a id="TutorialOption" href="#" tabindex="-1">
                                                                <div id="ico-tuto"></div>
                                                                <?php echo tutorial; ?>
                                                </a>
                                </li>

                                <li class="config-menu-list">
<a id="ConfigButtonMenu" href="/configuracion.php" tabindex="-1">
                                        <div id="ico-conf"></div>
                                        <?php echo configuracion; ?>
                                    </a>
                                </li>


                                <li class="logout-menu-list">
                                    <a href="web/logout.php?sessionId=<?php echo $_SESSION['iduser']; ?>" tabindex="-1">
                                        <div id="ico-logout"></div>
                                        <strong><?php echo logout; ?></strong>
                                    </a>
                                </li>
                            </ul>

                        </li>		




                    </ul>

                </div>

            </div>

        </div>
	
<!-- END barra de navegacion -->


<!-- bloque principal
=============================================-->
  
<div class="wrapperAll blockTop">
 
 <div class="wrapper-pri conf">
	
	
	<h3><?php echo friend3; ?></h3>
	<div id="divFriends" class="BlockInviteFriends">
            <span id="loadingFriend" class="loadingStyle"></span>
            <div id="blockInviteFriendFace" class="centerButton">
             <div class="blockSearchButton">
                <span style="font-size: 20px;"><?php echo friend4; ?></span>
                <a href="#" class="special-btn facebook badge-facebook-connect asso-btn-facebook-small" id="asso-btn-facebook-invited">Buscar amigos de Facebook</a>
             </div>
            </div>
	</div>
	
	
	
	<h3><?php echo friend5; ?> <!--<span> (Ya sigues a <strong>10</strong> amigos)</span> --></h3>
	<div id="divInspiterFriends" class="BlockInviteFriends">
            <span id="loadingFriend2" class="loadingStyle"></span>
	</div>
	
	
 </div>
 <div class="blockfoot" style="height: 1px;"></div>
 
<div id="footerMainPro">
<div class="footer inliner-list">
<div id="footer-container" class="container">
<ul id="footer-info-MainPro">
<li>
<a href="#">Inspiter &copy; 2013</a>
</li>
<li>
<a href="#"><?php echo acercaDe; ?></a>
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
<input type="hidden" id="Iam" value="profile"/>
<input type="hidden" id="fullnameInput" value="<?php echo $User1->getFullName(); ?>">
<input type="hidden" id="usernameInput" value="<?php echo $User1->getUserLogin(); ?>">
<input type="hidden" id="cityInput" value="<?php echo $User1->getCity();?>">
<input type="hidden" id="userIdLogged" value="<?php echo $User1->getUserId();?>">
<input type="hidden" id="photosmall" name="photosmall" value="<?php echo $User1->getPhotoSmall(); ?>">
<input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
<input type="hidden" id="urlfinal" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" id="faceidHidden" value="<?php echo $User1->getFaceId(); ?>">
<input type="hidden" id="usernameHidden" value="<?php echo $User1->getUserLogin(); ?>">
<input type="hidden" id="sessionId" value="<?php echo $_SESSION['iduser']; ?>">
<input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
	 <input type="hidden" id="typeMenu" value="<?php
	 if (isset($_GET['ty_me']) == true) {
			 echo $_GET['ty_me'];
	 }
?>"> </input>

	 <input type="hidden" id="isActivated" value="<?php echo $tokenAccountResult; ?>"/> 
</div>

  <!-- MODALS INSPIRE-->
	
	<div id="BlockModalIns" class="BlockModalIns">	
	 <div class="BlockModalInsOut">
		<div class="BlockModalInsInner">
		 <div class="BlockModalInsContent" style="height: auto; width: auto;">
    <div id="ModalIns" class="styled">

		 <div class="header-modal grd">
			<a id="closeModalIns" class="close" href="#"><strong><?php echo cerrar; ?></strong><span></span></a>
			<h2><?php echo inspirateModal; ?></h2>
                                                                                                </div>

		 <form id="InsForm" class="InsForm" method="post" action="#">
			<div class="option-inspiration btn-group"> 		
		   <a class="btn textIns active" href="#"><?php echo textModal; ?></a>
       <a class="btn imageIns" href="#"><?php echo imagenModal; ?></a>
       <a class="btn videoIns" href="#"><?php echo videoModal; ?></a>
			</div>
			
			<div class="BlockInspireInputs">
			 <textarea placeholder="<?php echo canPublish; ?>" class="post-inspiration post-inspiration-text"></textarea>
			 <span><?php echo autorFrase; ?></span>
			 <input class="post-inspiration post-inspiration-autor" type="text" maxlength="50" placeholder="<?php echo desconocido; ?>">
			</div>
			
			<div class="BlockInspireImage">
			 <div class="uploaderImageBlock">
				
				<div class="previewImageBlock">
				 <div id="previewImage" class="previewImage" data-status="withoutImage"></div>
				 <div id="loadImagePreview" class="loadImgIns loadingNot"></div>
				</div>
				<div id="descriptionTitleImageBlock" class="descriptionTitleImageBlock" style="margin-top: 10px; display:none;">
				 <input id="titleImageInsp" name="titleImageInsp"  type="text" placeholder="<?php echo tituloInsp; ?>" maxlength="60" class="post-inspiration title-inspiration">
				 <textarea id="DescriptionImageInsp" name="DescriptionImageInsp" class="post-inspiration description-inspiration" maxlength="200" placeholder="<?php echo describeInsp; ?>"></textarea>
				</div>
				<div class="add-photo-ico">
				 <?php echo pegaURLBrowse; ?>
				</div>
				<div class="input-browse-image">
				 <div class="posInputBrowser">
					<input id="FileUploadBrowser" class="FileUploadBrowser" name="urlIns" type="text" placeholder='<?php echo pegaURLBrowse; ?>'>
				 </div>
				 <div class="posButtonBrowser">
					<div id="button-add-image" class="button-browser-image"><?php echo agregarImage; ?></div>
					<div id="button-browser-image" class="button-browser-image">
					 <?php echo examinarImage; ?>
					 <input class="btnBrowser" type="file" name="file">
					</div>
				 </div>
			  </div>
			 </div>
			</div>
                        
                     <div class="BlockInspireVideo">
                      <div class="uploaderVideoBlock">
                       	
                        <div class="previewVideoBlock">
			 <div id="previewVideo" class="previewImage" data-status="withoutImage"></div>
			 <div id="loadImagePreview" class="loadImgIns loadingNot"></div>
                         <span class="post-video-play"></span>
			</div>
			
                        <div id="descriptionTitleVideoBlock" class="descriptionTitleImageBlock" style="margin-top: 10px; display:none;">
			 <input id="titleVideoInsp" name="titleImageInsp"  type="text" placeholder="<?php echo tituloInsp; ?>" maxlength="60" class="post-inspiration title-inspiration">
			 <textarea id="DescriptionVideoInsp" name="DescriptionImageInsp" class="post-inspiration description-inspiration" maxlength="200" placeholder="<?php echo describeInsp; ?>"></textarea>
			</div>   
                        
                        <div class="add-video-ico">
                         <?php echo pegaSubeVideo; ?>
                        </div>
                        
                        <div class="input-browse-video">
		         <div class="posInputBrowser">
			  <input type="text" placeholder="<?php echo pegaVideo; ?>" name="urlInsVideo" class="VideoUploadBrowser" id="VideoUploadBrowser">
			 </div>
			 <div class="posButtonBrowser">
			  <div class="button-browser-video" id="button-add-video"><?php echo agregarVideo; ?></div>
			 </div>
		        </div>
                       </div>    
                      </div>
			
			<div class="postInspiration form-action">
			 <div class="clearfix">
				<div class="BlockSocialButtonForm">
				 <div class="externalPosting">
					<ul class="externalServices">
					 <li class="facebook">
						<a href="#" class="facebook-share-button external-share-button" data-checked="unchecked">Facebook</a>
						<span><?php echo shareFaceVideo; ?></span>
					 </li>
					</ul>
				 </div>
				</div>
				<div class="pull-right">	
					<button class="btn-publish-inspiration disabled" type="button" disabled="disabled"><?php echo publicar; ?></button>
				</div>
			</div>
		</div>
			
	   </form>
	  </div>
	 </div>
	</div>		
 </div>
</div>		 
<!--END: MODALS INSPIRE-->
				
<div id="modal-background"></div>
  
<!-- Scripts
====================================
<!-- Placed at the end of document so the pages load faster -->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/inviteFriends.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/animation.js"></script>
<script type="text/javascript" src="js/krioImageLoader.js"></script>
<script type="text/javascript" src="js/jquery.maxlength.js"></script> 
<script type="text/javascript" src="js/buscador-jquery.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="js/notifications.js"></script>
<script type="text/javascript" src="js/constructorIns.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script type="text/javascript" src="js/uploadImageInspiration.js"></script>  
<script type="text/javascript" src="js/uploadVideoImageInspiration_Url.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/build-tuto.js"></script>
<!-- End Scripts -->
  
</body>
</html>