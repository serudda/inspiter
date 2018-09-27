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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="https://www.facebook.com/2008/fbml" lang="es">
<head>
<meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Editor Frases Graficas | Inspiter</title>
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
<link href="css/phraseGraphPage.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<link href="css/colorpicker.css" rel="stylesheet" media="screen" type="text/css"  />
<link href="css/jquery.cropzoom.css" rel="stylesheet" type="text/css" /> 
<link href="css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />

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
 <input type="text" id="b_keywords" data-locked="" name="b_keywords" placeholder="Buscar..." autocomplete="off">

 </form>	
 <div id="display-result">

 <ul id="result-users" data-pos="">
		 <div id="result-section-users" class="result-section" data-pos="">
				 <div class="result-section-title">
						 <span>Personas</span>
				 </div>
		 </div>

</ul>

 <ul id="result-phrases" data-pos="">
		 <div id="result-section-phrase" class="result-section" data-pos="">
				 <div class="result-section-title">
						 <span>Frases</span>
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
         <span id="Name-user-menu"> <?php echo $User1->getFullName(); ?></span>
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
                                        Explora tu Mundo
                                    </a>
                                </li>

                                <li class="invitFriend-menu-list">
                                    <a href="friend.php" tabindex="-1">
                                        <div id="ico-invFri"></div>
                                        Buscar Amigos
                                    </a>
                                </li>
                                
                                <li class="Tutor-menu-list">
                                                <a id="TutorialOption" href="#" tabindex="-1">
                                                                <div id="ico-tuto"></div>
                                                                Tutorial
                                                </a>
                                </li>

                                <li class="config-menu-list">
<a id="ConfigButtonMenu" href="/configuracion.php" tabindex="-1">
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
	
<!-- END barra de navegacion -->

<!-- bloque principal
=============================================-->
  
<div class="wrapperAll blockTop">

    <!-- menu superior
=============================================-->
 <div class="menuMain wrapper-pri conf">
     <div class="CropFase">
         <ul class="menuFasesItems">
             <li>
                 <button class="btn btn-success btnConfig btnEdition" id="btn_crop_phraseGraph" disabled="disabled">Guardar y Continuar</button>
             </li>
             <li style="margin-left: 0px;">
                 <p id="titleWelcomePage" class="titleWelcomePage fontBeforeCenter">Crea una frase grafica, para inspirar más a tu mundo</p>
             </li>
         </ul>
     </div>
     <div class="EditionFase">
         <ul class="menuFasesItems">
             <li>
                 <a id="phraseGraphShareToFacebook" class="facebook-share-button external-share-button" href="#" data-checked="unchecked">Facebook</a>
             </li>
             <li>
                 <button class="btn btn-success btnConfig btnEdition" id="btn_save_phraseGraph">Publicar Inspiración</button>
             </li>
             <li>
                 <div id="button-changeImage-phraseGraph" class="btn-phraseGraph button-browser-image">Cambiar Imagen</div>
                 <!--<button id="btn_change_image" class="btn btn-cancel-option btn_cancel_config">Cambiar Imagen</button>-->
             </li>
             <li>
                 <div id="button-returnCrop-phraseGraph" class="btn-phraseGraph button-browser-image">Volver a Cortar</div>
                 <!--<button id="btn_return_crop" class="btn btn-cancel-option btn_cancel_config">Volver a Cortar</button>-->
             </li>
             <li>
                 <p id="titleEditorPage" class="titleWelcomePage fontBefore">Edita tu frase grafica</p>
             </li>
         </ul>
        
     </div>
     <div class="BadgeBeta" style=" background-image: url('../images/beta.png');height:64px;left:-5px;position:absolute;top:-5px;width:64px;"></div>
 </div>
 
    <!-- Cuerpo de la pagina
=============================================--> 
 <div class="BodyPage wrapper-pri conf"> 
     <div class="OptionsBlockPos">
         <h3>Editar Texto de 
             <div id="buttonChangeTextEdit"><b id="textOptionSelected">Frase</b>
                 <span class="icoBlock">
                     <span class="ico-multiOpt" style="position: absolute; top: 9px;margin-top: 0px!important;"></span>
                 </span>
                 <dl id="list-select-text" class="list-option-phraseIn list-select-text" style="display: none;">
		  <dd id="optionTextChange" class="option-font option-font-size" data-option="Autor" data-colorFont="FFF">
		    Autor
		  </dd>
		 </dl>
             </div>
         </h3>
  
        <div class="OptionBlock">
            <div class="FamilyFontBlock">
                <div class="FamilyFontBlockTitle">Tipo de Letra</div>
                <div class="ListOption">
                    <ul>
                        <li class="Arial fontPhraseGraph" data-font="Arial" data-text="Arial" data-phselected="none" data-auselected="none">Arial</li>
                        <li class="Asombro fontPhraseGraph" data-font="Asombro" data-text="Asombro" style="font-size:2em;" data-phselected="none" data-auselected="none">Asombro</li>
                        <li class="Calibri fontPhraseGraph" data-font="Calibri" data-text="Calibri" data-phselected="none" data-auselected="none">Calibri</li>
                        <li class="CourierNew fontPhraseGraph" data-font="Courier" data-text="Courier New" data-phselected="none" data-auselected="none">Courier New</li>
                        <li class="ComicSans fontPhraseGraph" data-font='"ComicSansMS",cursive,sans-serif' data-text="Comic Sans MS" data-phselected="none" data-auselected="none">Comic Sans</li>
                        <li class="HandSean fontPhraseGraph" data-font='HandSean' data-text="HandSean" data-phselected="none" data-auselected="none">HandSean</li>
                        <li class="Impact fontPhraseGraph" data-font="Impact" data-text="Impact" data-phselected="none" data-auselected="none">Impact</li>
                        <li class="JennaSue fontPhraseGraph" data-font="JennaSue" data-text="JennaSue" style="font-size:2.5em;" data-phselected="none" data-auselected="none">Jenna Sue</li>
                        <li class="Jellyka fontPhraseGraph" data-font="Jellyka" data-text="Jellyka" style="font-size:5em;" data-phselected="none" data-auselected="none">Jellyka</li>
                        <li class="LucidaSans fontPhraseGraph" data-font='"LucidaGrande", "LucidaSansUnicode", "LucidaSans", Geneva, Verdana, sans-serif' data-text="Lucida Sans" data-phselected="none" data-auselected="none">Lucida Sans</li>
                        <li class="Motion fontPhraseGraph" data-font='Motion' data-text="Motion" style="font-size:2.3em;" data-phselected="none" data-auselected="none">Motion</li>
                        <li class="PassingNotes fontPhraseGraph" data-font='PassingNotes' data-text="PassingNotes" data-phselected="none" data-auselected="none">Passing Notes</li>
                        <li class="TimesNewRoman fontPhraseGraph" data-font='TimesNewRoman, "TimesNewRoman", Times, Baskerville, Georgia, serif' data-text="Times New Roman" data-phselected="none" data-auselected="none">Times New Roman</li>
                    </ul>
                </div>
            </div>
            <div class="StyleFontBlock FamilyFontBlockTitle">
                <ul class="optionPanelText">
                    <li class="font_text_phrase size">
                        <a href="#" id="font-size-text" data-sizephrase="45" data-sizeauthor="30" data-line="12" title="Aumentar tamaño de la letra">
				A
				<div class="ico-more-font moreSize"></div>
			 </a>
                    </li>
                    
                    <li class="sepLine"></li>
                   
                    <li class="font_text_phrase size">
			 <a href="#" id="font-size-text-less" data-sizephrase="45" data-sizeauthor="30" data-line="12" title="Reducir tamaño de la letra">
				A
				<div class="ico-more-font"></div>
			 </a>
                    </li>
                    
                    <li class="sepLine"></li>
                    
                    <li class="font_text_phrase bold">
			 <a href="#" id="font-bold-text" title="Agregarle Negrita al texto">B</a>
                    </li>
                    
                    <li class="sepLine"></li>
                    
                    <li class="font_text_phrase italic">
			 <a href="#" id="font-italic-text" title="Hacer cursivo el texto">I</a>
                    </li>
                    
                    <li class="sepLine"></li>
                               
                    <li class="font_text_phrase shadow">
			 <a href="#" id="font-shadow-text" title="Agregarle una sombra al texto">S</a>
                    </li>
                    
                    <li class="sepLine"></li>
                    
                    <li class="font_text_phrase TextAlign">
			 <a href="#" id="font-textalign-text" class="textalignstyle">
                             <div class="ico-more-font"></div>
				<dl class="list-option-phraseIn list-option-textalign" id="list-option-textalign">
				 <dd class="option-text textalignleft" data-textalign="left"></dd>
				 <dd class="option-text textaligncenter" data-textalign="center"></dd>
				 <dd class="option-text textalignright" data-textalign="right"></dd>
				</dl>
                         </a>
                    </li>
                    
                    <li class="sepLine"></li>
                    <li class="font_text_phrase TextAlign">
                        <a href="#" id="font-colorpicker-text">   
                         <div id="colorSelector"><div style="background-color: #FFF"></div></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
<!--        <div class="OptionBlock OptionExtra">
            <div class="FamilyFontBlockTitle">Extras</div>
            <div class="ListOption">
                <ul>
                    <li id ="optionExtraShadow" class="optionExtraShadow hoverOption" data-checked="unchecked">Agregar sombras</li>
                    <li id ="optionExtraDescribe" class="optionExtraDescribe hoverOption" data-checked="unchecked">Colocar tu firma</li>
                </ul>
            </div>
        </div> -->
         
     </div>
     
     <div class="ImageGraBlock">
         <div id="loadingFinalCropImg" class="iconLoadingImg"></div>
         <img  id="ImagePhraseGraph" class="ImagePhraseIn" src="" data-status="withoutImage">
            
         <div class="inner-phrase-img">
            <blockquote class="pullquote pageGraphPhrase" id="textPhraseGraph" style="z-index: 3;color:#FFF;font-family: Arial;font-size: 45px;left: 29px;top: 306px;" data-bold="normal" data-italic="normal" data-typefont="Arial"></blockquote>
	 </div>
	 <p class="autor-name" id="textPhraseAuthorGraph" style="cursor:move; position:absolute!important;z-index: 3;color:#FFF;font-family: Arial;font-size: 30px;left: 228px;text-align: right;top: 396px;" data-bold="normal" data-italic="normal" data-shadow="none" data-typefont="Arial"></p>
         
         <p id="InfoFooterGraph" class="InfoFooterGraph">Frase compartida por <?php echo $User1->getFullName(); ?></p>
         <img id="AvatarFooterGraph" class="AvatarFooterGraph" src="<?php $variable = $User1->getPhotoSmall();
               if (isset($variable) == true)
                   echo $User1->getPhotoSmall();?>">
         
         <div id ="ImageFooterGraphBlock" class="ImageFooterGraphBlock">
             <img  id="ImageFooterGraph" class="ImagePhraseIn" src="/images/footerPhraseGraphWithoutLogo.jpg" style="opacity: 0.9;">    
         </div> 
         <img  id="ImageShadowGraph" class="ImagePhraseIn" src="/images/sombraFraseGrafica.png" style="display: none;z-index: 1;">
     </div>
     
     <div class="ImageBeforeBlock">   
         <div id="add-phraseGraph" class="add-phraseGraph">
            Pega una URL o presiona "Examinar" para subir un archivo desde tu computador.
         </div>
         
         <div class="browse-image-phraseGraph">
             <div class="posInputBrowser">
                <input type="text" placeholder="Pegar una URL o presiona &quot;Examinar&quot; para subir un archivo" name="FileUploadBrowserPhraseGraph" class="FileUploadBrowser" id="FileUploadBrowserPhraseGraph">
             </div>
             <div class="posButtonBrowser">
                <div class="button-browser-image" id="button-add-image-phraseGraph" style="display: none;">Agregar</div>
		<div class="button-browser-image" id="button-browser-image-phraseGraph">
                     Examinar
                     <input type="file" name="file" class="btnBrowser">
		</div>
             </div>
	 </div>
     </div>
     
     <div class="ImagePreviewBlock previewBlock">
         <div id="centerBlockImg">
            <img id="ImagePhraseGraphOrig" src="" class="imageP"/>
         </div>
     </div>
     
     <div class="PosTextArea">
        <textarea id="inputPhraseGraph" name="inputPhraseGraph" placeholder="Puedes publicar cualquier contenido inspirador, desde frases, hasta canciones o partes de un libro..." class="textareaAbout phraseTextGraph" name="comment_text" style="margin-bottom: 0px!important;"></textarea>
     </div>
     <div id="NotePhraseGraph" class="PosNoteInfo NotePhraseGraph">
         <div class="infoIco" style="background-image: url('../images/infoIco.png');width: 32px; height: 32px; float: left; margin-right: 7px;"></div>  
         <strong>Esta es una versión de prueba</strong>, estamos trabajo muy duro para poder dejar una versión mucho más estable. Cualquier pregunta o sugerencia por favor, no dude en contactarnos dando click <a href="/contactenos.php" style="font-weight: bold;">aquí</a>. 
     </div>
     <div class="PosAuthorPhraseIn"  style="margin-left: 654px; display: none;">
      <textarea id="inputAuthorGraph" name="inputAuthorGraph" placeholder="ej. Autor, Canción, Libro..." class="inputAuthorGraph textareaAbout phraseIn authorIn" name="author_text"></textarea>
     </div>
     
     <div id="loadingFirstImg" class="iconLoadingImg"></div>
 </div>
 
<div class="blockfoot" style="height: 1px;"></div>
	
    
<!--<div id="footerMainPro">
<div class="footer inliner-list">
<div id="footer-container" class="container">
<ul id="footer-info-MainPro">
<li>
<a href="/">Inspiter &copy; 2013</a>
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
</div>-->
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
<input type="hidden" id="PhraseOrAuthor" value="Frase" />
<input type="hidden" id="ImagePhraseURL" />

</div>  

		 <!-- MODALS INSPIRE-->
	
	<div id="BlockModalIns" class="BlockModalIns">	
	 <div class="BlockModalInsOut">
		<div class="BlockModalInsInner">
		 <div class="BlockModalInsContent" style="height: auto; width: auto;">
    <div id="ModalIns" class="styled">

		 <div class="header-modal grd">
			<a id="closeModalIns" class="close" href="#"><strong>Cerrar</strong><span></span></a>
			<h2>Insp&iacute;rate</h2>
                                                                                                </div>

		 <form id="InsForm" class="InsForm" method="post" action="#">
			<div class="option-inspiration btn-group"> 		
		   <a class="btn textIns active" href="#">Texto</a>
       <a class="btn imageIns" href="#">Imagen</a>
       <a class="btn videoIns" href="#">Video</a>
			</div>
			
			<div class="BlockInspireInputs">
			 <textarea placeholder="Puedes publicar cualquier contenido inspirador, desde frases, hasta canciones o partes de libros." class="post-inspiration post-inspiration-text"></textarea>
			 <span>ej. Autor, nombre del libro o canci&oacute;n.</span>
			 <input class="post-inspiration post-inspiration-autor" type="text" maxlength="50" placeholder="Desconocido">
			</div>
			
			<div class="BlockInspireImage">
			 <div class="uploaderImageBlock">
				
				<div class="previewImageBlock">
				 <div id="previewImage" class="previewImage" data-status="withoutImage"></div>
				 <div id="loadImagePreview" class="loadImgIns loadingNot"></div>
				</div>
				<div id="descriptionTitleImageBlock" class="descriptionTitleImageBlock" style="margin-top: 10px; display:none;">
				 <input id="titleImageInsp" name="titleImageInsp"  type="text" placeholder="¿Titulo de tu inspiración?" maxlength="60" class="post-inspiration title-inspiration">
				 <textarea id="DescriptionImageInsp" name="DescriptionImageInsp" class="post-inspiration description-inspiration" maxlength="200" placeholder="Describe tu inspiración..."></textarea>
				</div>
				<div class="add-photo-ico">
				 Pega una URL o presiona "Examinar" para subir un archivo desde tu computador.
				</div>
				<div class="input-browse-image">
				 <div class="posInputBrowser">
					<input id="FileUploadBrowser" class="FileUploadBrowser" name="urlIns" type="text" placeholder='Pegar una URL o presiona "Examinar" para subir un archivo'>
				 </div>
				 <div class="posButtonBrowser">
					<div id="button-add-image" class="button-browser-image">Agregar</div>
					<div id="button-browser-image" class="button-browser-image">
					 Examinar
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
			 <input id="titleVideoInsp" name="titleImageInsp"  type="text" placeholder="¿Titulo de tu inspiración?" maxlength="60" class="post-inspiration title-inspiration">
			 <textarea id="DescriptionVideoInsp" name="DescriptionImageInsp" class="post-inspiration description-inspiration" maxlength="200" placeholder="Describe tu inspiración..."></textarea>
			</div>   
                        
                        <div class="add-video-ico">
                         Pega una URL para subir un video desde YouTube.
                        </div>
                        
                        <div class="input-browse-video">
		         <div class="posInputBrowser">
			  <input type="text" placeholder="Pegar una URL desde YouTube" name="urlInsVideo" class="VideoUploadBrowser" id="VideoUploadBrowser">
			 </div>
			 <div class="posButtonBrowser">
			  <div class="button-browser-video" id="button-add-video">Agregar</div>
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
						<a href="#" id="facebookChecked" class="facebook-share-button external-share-button" data-checked="unchecked">Facebook</a>
						<span>Compartir en Facebook</span>
					 </li>
					</ul>
				 </div>
				</div>
				<div class="pull-right">	
					<button class="btn-publish-inspiration disabled" type="button" disabled="disabled">Publicar</button>
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
<!--<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>-->
<script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/animation.js"></script>
<script type="text/javascript" src="js/jquery.maxlength.js"></script>
<script type="text/javascript" src="js/jquery.Jcrop.min.js"></script>
<!--<script type="text/javascript" src="js/constructorIns.js"></script>-->
<script type="text/javascript" src="js/buscador-jquery.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="js/notifications.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<!--<script type="text/javascript" src="js/configuration.js"></script>-->
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script type="text/javascript" src="js/uploadImage.js"></script>
<script type="text/javascript" src="js/phraseGraphPage.js"></script>
<script type="text/javascript" src="js/uploadImageInspiration.js"></script>
<script type="text/javascript" src="js/uploadVideoImageInspiration_Url.js"></script>
<script type="text/javascript" src="js/uploadImagePhraseGraph.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/fileDownload.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
           
      
    });
</script>
<!-- End Scripts -->
  
</body>
</html>