<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");
require_once("web/clases/Phrase.php");
require_once("web/clases/Inspiter.php");
require_once("web/clases/Notification.php");
require_once("web/clases/Config.php");

/* * * Begin - Verfica si el user esta logueado.
Caso exitoso: Por el else: "Pregunta por lo parametros que vienen por get estos pueden ser, id (solo indica el id del user), flol(muestra los siguiendo del user), fler(muestra los seguidores del user), post(muestra la phrase del user)"
Caso falso:   Por el if: "Entra a login, verifica las cookies, si no hay, redirecciona a index, si las hay referencia "Caso Exitoso"".
* * */
if (!isset($_SESSION['iduser']))
{
  setcookie("urlLog", $_SERVER['REQUEST_URI'], time() + 31536000);
  $login = new Login();
  $login->startLogin(3600, NULL, NULL, 1);
} 
else 
{ 
  setcookie("urlLog");
  //datos user
  $User1 = User::getUser($_SESSION['iduser']);
  $registerUserFirst = User::IsFirstTimeRegister($User1->getUserId());
  $UserConfig = Config::getUserConfig($_SESSION['iduser']);
  $notificationsResult = Config::getNotificationAmountShowed($_SESSION['iduser']);
  if (is_numeric($notificationsResult) == true && $notificationsResult > 0)
     $notificationsAmount = $notificationsResult;
 /*** End - Verfica si el user esta logueado. ***/
}
if(!isset($_SESSION['languaje']))
{
   $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}
include("web/lang_".$_SESSION['languaje'].".php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="https://www.facebook.com/2008/fbml" lang="es">
<head>
<meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo configuracion01; ?> | Inspiter</title>
<link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
<!--<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin' rel='stylesheet' type='text/css'/>-->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style-home.css" rel="stylesheet" type="text/css"/>
<link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
<link href="css/style-container-inspiration.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
<link href="css/style-configuracion.css" rel="stylesheet" type="text/css"/>
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

</ul>

 <ul id="result-phrases" data-pos="">
		 <div id="result-section-phrase" class="result-section" data-pos="">
				 <div class="result-section-title">
						 <span><?php echo frase; ?></span>
				 </div>
		 </div>
 </ul>

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
      
                        <li>
                            <a href="phraseGraph.php" class="registerBtnWelcome NewOptionNav"><?php echo frasesGraficas; ?></a>
                        </li>

                        <li class="divider-vertical"></li>


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
	
	
	<h3><?php echo configuracion02; ?> <span> <?php echo configuracion03; ?></span></h3>
	<div class="BlockUserInfo">
	 
	 <div class="PosUserName">
		<dl>
		 <dt><?php echo configuracion04; ?></dt>
                 <dd><?php echo $User1->getUserLogin(); ?></dd>
		 <dt style="margin-bottom:22px!important;">Link:</dt>
		 <dd>
			<a href="/<?php echo $User1->getUserLogin(); ?>">http://inspiter.com/<?php echo $User1->getUserLogin(); ?></a>
		 </dd>
		</dl>
	 </div>
	 
	 <span style="bottom:85px;"><?php echo configuracion05; ?></span>
	 
	 <div>
		<label id="labelNameConf" for="inputNameConf"><?php echo configuracion06; ?></label>
		<input type="text" class="input" id="inputNameConf" name="inputNameConf" tabindex="1" maxlength="19" value="<?php echo $User1->getFullName(); ?>">
		 <div class="msgBox NameConf errorHidden"></div>
	 </div>


	 <div>
		<label for="inputLocationConf">
		<?php echo configuracion07; ?>   
		</label>
		<input type="text" class="input" id="inputLocationConf" name="inputLocationConf" tabindex="2" value="<?php echo $User1->getCity(); ?>">
		<div class="msgBox CityConf errorHidden"></div>
	 </div>
	 
	 <div>
		<label for="inputWebConf">
		<?php echo configuracion08; ?>   
		</label>
    <input type="text" class="input" id="inputWebConf" name="inputWebConf"  placeholder="http://" maxlength="200" tabindex="2" value="<?php echo $UserConfig->getWebSite(); ?>">
		<div class="msgBox SiteConf errorHidden"></div>
	 </div>
	 
	 <div class="PosAbout">
		<label for="textareaAbout">
		 <?php echo configuracion09; ?>
		</label>
		
    <textarea id="inputAboutYou" name="inputAboutYou" placeholder="Comentale al mundo más sobre ti..." class="textareaAbout" name="comment_text"><?php echo $UserConfig->getAboutYou(); ?></textarea>
		<div class="msgBox AboutConf errorHidden"></div>
	 </div>
	 
	 <span style="bottom:276px;"><?php echo configuracion10; ?></span>
	 
	 <div id="NewPhoto-Position">
		<label for="avatarNewPics">
		 <?php echo configuracion11; ?>  
    </label>
    <div id="Image-Pos">
		 <div class="previewPhotoBlock">
				 <img id="fotografia" src="<?php echo $User1->getPhoto(); ?>" alt="">
				 <div class="loadPhotoIns loadingNot" id="loadImagePreview"></div>
				 <div id="ChangePos">
      <a id="addImage" class="button" href="#"><?php echo configuracion12; ?></a>
			<a id="addImageFace" class="button" href="#"><?php echo configuracion13; ?></a>
     </div>
		 </div>
     
		 
    </div>
    
    <div class="loaderAjax" id="loaderAjax">
     <img src="images/ajax-loader.gif">
     <p><?php echo configuracion14; ?></p>
    </div>
	 </div>
	 
	 <span style="bottom:189px;"><?php echo configuracion15; ?></span>
	 
	 <div id="PosPhraseUser" class="PosPhraseUser">
		<label for="avatarNewPics">
		 <?php echo configuracion16; ?>  
    </label>
		<button id="ImagesDefaultButton" type="button" class="changePhraseImage default"><?php echo configuracion17; ?></button>
		<!--<button type="button" class="changePhraseImage">Subir una imagen</button>-->
		<a id="changePhraseImage" class="changePhraseImage" style="font-size: 14px;"><?php echo configuracion18; ?></a>
		<div class="PosPanelText">
		 <ul class="optionPanelText">
			<li class="font_text_phrase" style="min-width: 156px">
			 <a id="font-family-text" href="#">
				<b style="margin-right: 5px;">Arial</b>
				<div class="ico-more-font"></div>
				<dl id ="list-option-font" class="list-option-phraseIn list-option-font">
				 <dd class="option-font Arial" data-font="Arial" data-text="Arial">
					Arial
				 </dd>
				 <dd class="option-font Calibri" data-font="Calibri" data-text="Calibri">
					Calibri
				 </dd>
				 <dd class="option-font CourierNew" data-font="Courier" data-text="Courier New">
					Courier New
				 </dd>
                                 <dd class="option-font ComicSans" data-font='"ComicSansMS", cursive, sans-serif' data-text="Comic Sans MS">
					Comic Sans
				 </dd>
                                 <dd class="option-font Futura" data-font='Futura, "TrebuchetMS", Arial, sans-serif' data-text="Futura">
					Futura
				 </dd>
                                  
				 <dd class="option-font Impact" data-font="Impact" data-text="Impact">
					Impact
				 </dd>
                                    
                                 <dd class="option-font LucidaSans" data-font='"LucidaGrande", "LucidaSansUnicode", "LucidaSans", Geneva, Verdana, sans-serif' data-text="Lucida Sans">
					Lucida Sans
				 </dd>
                                    
                                 <dd class="option-font PassingNotes" data-font='PassingNotes' data-text="PassingNotes">
					Passing Notes
				 </dd> 
                                    
				 <dd class="option-font TimesNewRoman" data-font='TimesNewRoman, "TimesNewRoman", Times, Baskerville, Georgia, serif' data-text="Times New Roman">
					Times New Roman
				 </dd>

				</dl>
			 </a>
			</li>
			<li class="sepLine"></li>
			<li class="font_text_phrase">
			 <a id="font-size-text" href="#">
				<?php echo configuracion19; ?>
				<div class="ico-more-font"></div>
				<dl id ="list-option-size" class="list-option-phraseIn list-option-size">
				 <dd class="option-font option-font-size smallfont" data-size="1.3em">
					<?php echo configuracion20; ?>
				 </dd>
				 <dd class="option-font option-font-size normalfont" data-size="1.6em">
					<?php echo configuracion21; ?>
				 </dd>
				 <dd class="option-font option-font-size bigfont" data-size="1.9em">
					<?php echo configuracion22; ?>
				 </dd>
                                 <dd class="option-font option-font-size biggestfont" data-size="2.3em">
					<?php echo configuracion23; ?>
				 </dd>   
				 <dd class="option-font option-font-size hugefont" data-size="2.7em">
					<?php echo configuracion24; ?>
				 </dd>
				</dl>
			 </a>
			</li>
			<li class="sepLine"></li>
			<li class="font_text_phrase bold">
			 <a id="font-bold-text" href="#">B</a>
			</li>
			<li class="sepLine"></li>
			<li class="font_text_phrase italic">
			 <a id="font-italic-text" href="#">I</a>
			</li>
			<li class="sepLine"></li>
		 </ul>
		</div>
		<div id="Image-Pos-Phrase">
		 <div class="ImagePhraseInBlock" >
                     <img id="ImagePhraseIn" class="ImagePhraseIn" data-status="withoutImage" data-thumbnail-big="img5" data-image-big="ImageDefaultLarge1.jpg" src="<?php echo $UserConfig->getImageIPhrase(); ?>">
			<div class="inner-phrase-img">
			 <blockquote class="pullquote imgPhrase" id="textPhraseIn"></blockquote>
			</div>
			<p class="autor-name imgPhrase" id="textPhraseInAuthor" style="cursor:move; position:absolute!important;"></p>
                        <div id="loadImagePreview" class="loadImgPhraseIn loadGifPhrase"></div>
                 </div>
                </div>
		<div class="ImgDefault">
		 <div class="ImageDefaultList img7" data-image="ImageDefaultLarge5.jpg" data-thumbnail="img7"></div>
		 <div class="ImageDefaultList img6" data-image="ImageDefaultLarge4.jpg" data-thumbnail="img6"></div>
		 <div class="ImageDefaultList img0" data-image="ImageDefaultLarge3.jpg" data-thumbnail="img0"></div>
		 <div class="ImageDefaultList img1" data-image="ImageDefaultLarge2.jpg" data-thumbnail="img1"></div>
		 <div class="ImageDefaultList img2" data-image="ImageDefaultLarge6.jpg" data-thumbnail="img2"></div>
		 <div class="ImageDefaultList img3" data-image="ImageDefaultLarge7.jpg" data-thumbnail="img3"></div>
		 <div class="ImageDefaultList img4" data-image="ImageDefaultLarge8.jpg" data-thumbnail="img4"></div> 
		 <div class="ImageDefaultList img5" data-image="ImageDefaultLarge1.jpg" data-thumbnail="img5"></div>
		</div>
		
		<div class="PosPhraseTextArea">
        <textarea id="inputIdenPhrase" name="inputIdenPhrase" placeholder="Escribe tu frase insignia aqui..." class="textareaAbout phraseIn" name="comment_text" style="margin-bottom: 0px!important;"><?php echo $UserConfig->getIdentPhrase(); ?></textarea>
		</div>
                <div class="PosNoteInfo">
                    <strong><?php echo configuracion25; ?></strong>
                    <?php echo configuracion26; ?>
                </div>
		<div class="PosAuthorPhraseIn">
                    <textarea id="inputIdenAuthor" name="inputIdenPhrase" placeholder="Desconocido" class="textareaAbout phraseIn authorIn" name="author_text"><?php echo $UserConfig->getAuthor(); ?></textarea>
		</div>
		
	 </div>
	 
	 
 </div>
	
	
	
	<h3  id="styleh3" style="margin-bottom: 100px;"><?php echo configuracion27; ?></h3>
	<div class="BlockConfAccount">
	 
	 <h4><?php echo configuracion28; ?></h4>
	 
	 <div id="passPosConf">
		<form action="web/checkLogin.php" method="get">
		<label id="labelContrasena1" class="control-label" for="password">
				<?php echo configuracion29; ?>
		</label><div style="float: left;"><a id="forgot" class="forgot" href="/recuperarClave.php"><?php echo configuracion30; ?></a></div>
		<input type="password" class="input" id="inputPassword1Conf" name="inputPassword1Conf" tabindex="2"></br>
		
		<label id="labelContrasena2" class="control-label" for="password">
				<?php echo configuracion31; ?>
		</label>
		<input type="password" class="input" id="inputPassword2Conf" name="inputPassword2Conf" tabindex="2"></br>
		
		<div class="message-box-pass"></div>
		<label id="labelContrasena3" class="control-label" for="password">
				<?php echo configuracion32; ?>
		</label>
		<input type="password" class="input" id="inputPassword3Conf" name="inputPassword3Conf" tabindex="2"/>
		<button class="btn" id="btn_save_pass"><?php echo configuracion33; ?></button>
		</form> 
	 </div>
	 
	 <span style="bottom:216px;"><?php echo configuracion34; ?><strong><?php echo configuracion35; ?></strong></span>
	 
	 <h4 class="title-social-block"><?php echo configuracion36; ?></h4>
	 
	  <label>
		 Facebook
		</label>
	 
	 <div class="PosSocialBlock">

			<div id="AsoPos">
			    <a id="asso-btn-facebook-config" class="special-btn facebook badge-facebook-connect" href="#"><?php echo configuracion37; ?></a>
			</div>

			<span style="bottom: 70px;width: 330px;"><?php echo configuracion38; ?></span>
			
			<div id="loadingAssoc" class="loadingAssoc">
			   <img src="images/ajax-loader.gif"/>
			</div>

	</div>
 
  </div>
	<div class="buttonFormConfig">
    <button class="btn btn-cancel-option" id="btn_cancel_config"><?php echo configuracion39; ?></button>
		<button class="btn btn-success btnConfig" id="btn_save_config"><?php echo configuracion40; ?></button>
	</div>
 </div>
 <div class="blockfoot" style="height: 1px;"></div>
	
    
<div id="footerMainPro">
<div class="footer inliner-list">
<div id="footer-container" class="container">
<ul id="footer-info-MainPro">
<li>
<a href="/">Inspiter &copy; 2013</a>
</li>
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
<input type="hidden" id="Iam" value="configuracion"/>
<input type="hidden" id="userIdLogged" value="<?php echo $User1->getUserId(); ?>">
<input type="hidden" id="userId" value="<?php echo $User1->getUserId(); ?>">
<input type="hidden" id="photosmall" name="photosmall" value="<?php echo $User1->getPhotoSmall(); ?>">
<input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
<input type="hidden" id="urlfinal" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" id="faceidHidden" value="<?php echo $User1->getFaceId(); ?>">
<input type="hidden" id="usernameHidden" value="<?php echo $User1->getUserLogin(); ?>">
<input type="hidden" id="sessionId" value="<?php echo $_SESSION['iduser']; ?>">
<input type="hidden" id="fullnameHidden" value="<?php echo $User1->getFullName(); ?>" />
<input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
<input type="hidden" id="imagePredef" value="" />
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
				 <input id="titleImageInsp" name="titleImageInsp"  type="text" placeholder="¿Titulo de tu inspiración?" maxlength="60" class="post-inspiration title-inspiration">
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
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/animation.js"></script>
<script type="text/javascript" src="js/jquery.maxlength.js"></script> 
<script type="text/javascript" src="js/constructorIns.js"></script>
<script type="text/javascript" src="js/buscador-jquery.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="js/notifications.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript" src="js/configuration.js"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script type="text/javascript" src="js/uploadImage.js"></script>
<script type="text/javascript" src="js/uploadImagePhraseIn.js"></script>
<script type="text/javascript" src="js/PhraseInsigEffect.js"></script>
<script type="text/javascript" src="js/uploadImageInspiration.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/build-tuto.js"></script>
<!-- End Scripts -->
  
</body>
</html>