<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");
require_once("web/clases/Inspiter.php");
require_once("web/clases/Phrase.php");
require_once("web/clases/Follow.php");
require_once("web/clases/Notification.php");
require_once("web/clases/Config.php");
require_once("web/clases/Token.php");

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum+$_SESSION['iduser'])), 0, 30));
   return $token;
}
$tokenID = getToken();
$_SESSION['tokenID'] = $tokenID;

setcookie("urlLog");
if (!isset($_SESSION['iduser'])) {
  if (isset($_COOKIE['iduser'])==true && $_COOKIE['iduser'] != '') 
    $_SESSION['iduser'] = $_COOKIE['iduser'];
else 
{
   header("location: /");   
}
   /* $login = new Login();
    $login->startLogin(3600, NULL, NULL, 1);*/
} 
if(isset($_SESSION['iduser']))
{
    if(!isset($_SESSION['languaje']))
    {
        $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
    }
    include("web/lang_".$_SESSION['languaje'].".php");
    
    if(!isset($_COOKIE["iduser"]) || $_COOKIE["iduser"] == '')
       setcookie("iduser",$_SESSION['iduser'],time()+86400);
      //datos user
    $User1 = User::getUser($_SESSION['iduser']);
    $registerUserFirst = User::IsFirstTimeRegister($User1->getUserId());
      

    //datos frases
    $inspiterAmount = 0;
    $inspiterResult = Inspiter::getAmountInspiter($_SESSION['iduser']);
    if (is_numeric($inspiterResult) == true)
        $inspiterAmount = $inspiterResult;

    $inspiterAmountTotal = 0;
    $inspiterResultTotal = Inspiter::getAmountInspiterAll();
    if (is_numeric($inspiterResultTotal) == true)
        $inspiterAmountTotal = $inspiterResultTotal;

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
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['languaje']; ?>">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="inspiter.com" />
        <meta name="description" content="<?php echo definicionInspiter1; ?>" />
        <meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter" />
        <meta name="robots" content="index, follow" />
        <title><?php if($notificationsAmount != null )
            {echo '('.$notificationsAmount.') Inspiter';}
             else echo 'Inspiter';?></title>

        <!--<link rel="shortcut icon" href="images/favicon.png" />-->
        <link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon"/>
        <!--<link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.png"/> -->
        <!--<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin' rel='stylesheet' type='text/css'/>-->
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-home.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-Main.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-container-inspiration.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="profile-body">

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=392076184181252";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>	

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
	<input type="hidden" id="Iam" value="main"/>
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
        <input type="hidden" id="tokenID" value="<?= $tokenID; ?>">
        <input type="hidden" id="photo" value="<?php
$variable = $User1->getPhoto();
if (isset($variable) == true)
    echo $User1->getPhoto();
else {
    ?> images/perfiles/avatar-inspiter.jpg <?php } ?>">
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
                          <a id="countNotif" href="#" data-original-title="Notificaciones" data-toggle="tooltip" data-placement="bottom"><?php echo $notificationsAmount; ?><i class="icon-notif"></i></a>
                        </li>

                        <li>
                            <a href="phraseGraph.php" class="registerBtnWelcome NewOptionNav"><?php echo frasesGraficas; ?></a>
                        </li>
                        
                        <li class="divider-vertical"></li>
                        
                        <li><a id="btn-inspiration" name="btn-inspiration" href="#" data-original-title="<?php echo inspirate; ?>" data-toggle="tooltip" data-placement="bottom"><i class="icon-inspiration"></i></a></li>

                        <li class="divider-vertical"></li>

                        <li class="dropdown">

                            <a data-toggle="dropdown" class="dropdown-toggle" id="btn-myprofile" name="btn-myprofile" role="button" href="#" data-original-title="Menú" data-toggle="tooltip" data-placement="bottom">
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


<!-- MENU USUARIO (INSPIRACIONES, FAVORITOS, DEDICACIONES, SEGUIDORES,SIGUIENDO)-->
					 <div class="UserMenuCompleteMain">	
            <div class="UserMenuProfile">

                <div id="content-menuPhrase" class="content-menu-main">

                    <ul id="nav-menu-main" class="nav nav-pills">
                        <li id="menu_siguiendo" class="active-menu"><a id="PhrasesSiguiendo" href="#"><?php echo siguiendo; ?></a></li>
                        <li id="menu_top"><a id="PhrasesTop10" href="#"><?php echo top; ?></a></li>
                        <li id="menu_populares"><a id="PhrasesPopulares" href="#"><?php echo popular; ?></a></li>
                        <li id="menu_aleatorios"><a id="PhrasesAleatorios" href="#"><?php echo aleatorio; ?></a></li>
                        <li id="menu_todo"><a id="PhrasesTodo" href="#"><?php echo todo; ?></a></li>
                    </ul>

                </div>
            </div>
            </div>
<!-- END: MENU USUARIO (INSPIRACIONES, FAVORITOS, DEDICACIONES, SEGUIDORES, SIGUIENDO)-->

		 <!-- MENU DE OPCIONES PARA ORDEN POR TEXTO O MEDIA-->
		 <div class="option-sort-contain" style="margin:109px auto 0!important;">
			<ul class="nav nav-pills list-option-sort">
			 <li id="allOptionSort"><div class="ico-all-inspirations"></div><?php echo all; ?></li>
			 <li id="textOptionSort"><div class="ico-text-inspirations"></div><?php echo text; ?></li>
			 <li id="mediaOptionSort"><div class="ico-media-inspirations"></div><?php echo media; ?></li>
                                </ul>
                                </div>
		 <!-- END: MENU DE OPCIONES PARA ORDEN POR TEXTO O MEDIA-->


        <div class="profile-container">
	    <div class="wrapperAll">

            <div id="content" class="wrapper">
                <!-- Phrase Box Dynamic-->
                <!--END Phrase Box DYnamic-->
            </div>

	<div id="LoadingInspirations">
	  <div class="PartsLoading"> 
	   <div class="loading-ico-more"></div>
	   <div class="load-more-inspiration"><?php echo loadmore; ?></div> 
          </div>
        </div>
	<div style="height:45px;"></div>
            <div id="footerMainPro">
                <div class="footer inliner-list">
                    <div id="footer-container" class="container">
                        <ul id="footer-info-MainPro">
                            <li>
                                <a href="#">Inspiter &copy; 2013</a>
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

            <input type="hidden" id="userIdLogged" value="<?php echo $User1->getUserId(); ?>">
	    <input type="hidden" id="useridhidden" name="useridhidden" value="<?php echo $User1->getUserId(); ?>">
            <input type="hidden" id="cantInspiterTotal" value="<?php echo $inspiterAmountTotal; ?>">
            <input type="hidden" id="cantInspiterSeg" value="<?php echo $inspiterAmountSeg; ?>">
            <input type="hidden" id="cantinotif" value="<?php echo $notificationsResult ?>">
            <input type="hidden" id="isActivated" value="<?php echo $tokenAccountResult; ?>">
            <input type="hidden" id="photosmall" name="photosmall" value="<?php echo $User1->getPhotoSmall(); ?>">
            <input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
            <input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
            <input type="hidden" id="OptionSeletedMenu" name="OptionSeletedMenu" />
            <input type="hidden" id="SiguiendoAmount" name="SiguiendoAmount" value="<?php echo $siguiendoAmount; ?>">
             <input type="hidden" id="usernamelink" name="usernamelink" value="http://graph.facebook.com/1660156026?fields=link" >
				</div>
		</div>


    <!--MODALS DEDICATION -->		
        <div id="modalDed" class="styled">
            <div class="header-modal grd">
                <a id="closeModalDedic" class="close" href="#"><strong><?php echo cerrar; ?></strong><span></span></a>
                <h2><?php echo dedicarInsp; ?></h2><div id="paper-plane-moved"></div>
            </div>
            <form id="dedicarForm" class="dedicarForm" method="POST" action="#">
                <ul class="ElemGroups">
                    <li class="From NoBorderTop">
                        <input id="FromName" type="text" name="FromName" value="<?php echo $User1->getFullName(); ?>" disabled="true">
                        <label><?php echo de; ?></label>
                    </li>
                    <li>
                        <input id="ToName" type="text" name="ToName" autocomplete="off" tabindex="1">
                        <label><?php echo para; ?></label>
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
                        <span><?php echo personadedic; ?></span>
                       </div>
                      </div>
                     </ul>
                    </div>
                    <li>
                        <textarea id="DedMessage" class="DedMessage" name="DedMessage" tabindex="3"></textarea>
                        <label><?php echo dedicatory; ?></label>
                    </li>
                    <li>
                        <div class="posCheckMail">
                            <input id="DedCheckMail" type="checkbox" class="DedCheck" name="DedCheckMail">
                            <label class="checkLabelDed"><?php echo sendDedicMail; ?></label>
                        </div>
                        <div class="posCheckFace">
                            <input id="DedCheckFace" type="checkbox" class="DedCheck" name="DedCheckFace">
                            <label class="checkLabelDed"><?php echo facebookdedic ?></label>
                        </div>
                        <div class="posButtonDed">
                            <button id="DedSubmit" name="DedSubmit" type="button" class="btn btn-success"><?php echo dedicate; ?></button>
                        </div>
                        <input type="hidden" id="dedicInspiterId" name="dedicInspiterId" value=""/>
                        <input type="hidden" id="dedicUsername" name="dedicUsername" value=""/>
                        <input type="hidden" id="FromUserId" name="FromUserId" value="<?php echo $User1->getUserId(); ?>"/>
                        <input type="hidden" id="FromUsername" name="FromUsername" value="<?php echo $User1->getFullName(); ?>"/>
                        <input type="hidden" id="ToUserId" name="ToUserId" value=""/>
                    </li>
                </ul>
            </form>
       </div>
  <!--END: MODALS DEDICATION-->

		 
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
		 
<!--ZOOM INSPIRATIONS-->

<div id="zoom-background" class="zoom-background"></div>

<div id="BlockZoomIns" class="BlockModalIns" style="display: none;">
    
    <button id="BtnZoomClose" class="BtnZoom close visible"><em></em></button>
    
 <div class="BlockModalInsOut">
  <div class="BlockModalInsInner">
   <div class="posContainZoom">
    <div class="avatarZoomInfo">
     <div class="posInfoZoom">
      <a id="avatarNameZoom" style=" font-size: 18px;" href=""></a>
      <span id="TimeZoom">hace 3 mes</span>
     </div>
     <a id="avatarZoomLink" href="">   
      <img id="avatarZoom" class="img-user-inspiter avatarZoom" alt="" width="50" height="50" src="">
     </a>
    </div>
			<div class="BlockModalInsContent BlockZoomContent">
			 <div class="zoomIns" id="zoomIns">
				<img id="ImageWithZoom" class="lazy-load" data-src="../images/graphIns/4a215601506.jpg" data-src-mobile="../images/graphIns/4a215601506.jpg" src="/images/PhraseIns/sedavila_367118846.jpg">
                                <span class="loadingZoom"></span>
                                <div id="title-image-zoom" class="FooterImgText title-image-zoom">
				 <p id="TitleImageZoom" class="text-FooterImgText" style="font-size:20px;"></p>
				</div>
				<div id="description-image-zoom" class="FooterImgText description-image-zoom" id="description-image_1685" style="display: none;">
				 <p id="DescriptionImageZoom" class="text-FooterImgText"></p>
				</div>
			 </div>
			</div>
		 </div>	 
		</div>
	 </div> 
</div>

<!--END: ZOOM INSPIRATIONS-->
	
<div id="Bigloading" class="Bigloading">
                <img src="images/ajax-loader-big.gif">
         </div>

<!--BACKGROUND TUTORIAL-->
<div id="tuto-background" class="PeopleIns">
  <div class="tuto-wrapper ViewFollow">
    <div class="welcomeText">
       <strong style="color: #FFF; font-family: calibri; font-size: 25px;">Bienvenido, <?php echo $User1->getFullName(); ?>.</strong><br>
      Es necesario que sigas a minimo 5 personas, para que puedas empezar a ver que esta inspirando en este momento al mundo.
    </div>
    <div class="posBar">
        <div class="progress progress-success progress-striped active" style="width: 240px !important; height: 30px!important;">
            <div id="barSeg" class="bar" style="width: 0%; height: 30px!important;"></div>
        </div>
        <span id="beginInv">Comienza por seguir a <strong id="cantSigIni" style="font-size: 25px;">5</strong> personas.</span>
        <span id="beginTu" style="right:105px;top:5px;display:none;">¡Puedes comenzar!...</span>
    </div>
      
    <div class="posButtonFace">
        <a href="#" class="special-btn facebook badge-facebook-connect asso-btn-facebook-small" id="asso-btn-facebook-search" style="margin: 0 0 10px 57px !important;">Buscar amigos de Facebook</a>     
        <span>Busca a tus amigos de Facebook que ya estan usando Inspiter, para que compartas tus inspiraciones con ellos.</span>
    </div>  
      
    <div id="InspiterPeopleTuto" class="InspiterPeople" style="margin-top: -93px;">
        
    </div>
 </div>
</div>
 <!--BACKGROUND TUTORIAL-->

 <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
 <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
 <script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
 <!--<script type="text/javascript" src="js/LazyLoad.js"></script>-->
 <script type="text/javascript" src="js/krioImageLoader.js"></script>
 <script type="text/javascript" src="js/bootstrap.js"></script>
 <script type="text/javascript" src="js/animation.js"></script>
 <script type="text/javascript" src="js/layoutColumn.js"></script>
 <script type="text/javascript" src="js/jquery.livequery.js"></script>
 <script type="text/javascript" src="js/jquery.scrollTo.js"></script> 
 <script type="text/javascript" src="js/constructorIns.js"></script>
 <script type="text/javascript" src="js/generatorsX.js"></script>
 
 <script type="text/javascript" src="js/jquery.maxlength.js"></script> 
 <script type="text/javascript" src="js/buscador-jquery.js"></script>
 <script type="text/javascript" src="js/buscadorDed-jquery.js"></script>
 <script type="text/javascript" src="js/notifications.js"></script>
 <script type="text/javascript" src="js/validate-dedicate.js"></script>
 <script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
 <script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
 <script type="text/javascript" src="js/build-tuto.js"></script>
 <script type="text/javascript" src="js/jquery.confirm.js"></script>
 <script type="text/javascript" src="js/alert-script.js"></script>
 <script type="text/javascript" src="js/ajaxupload.js"></script>
 <script type="text/javascript" src="js/uploadImageInspiration.js"></script>  
 <script type="text/javascript" src="js/uploadVideoImageInspiration_Url.js"></script>
        
<!--FEEDBACK PLUGIN -->
 <script type="text/javascript">
  var uvOptions = {};
  (function() {
     var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
     uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/ZfdIuPgm43KneOxv75PnQ.js';
     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
     })();
  </script>
  
  <!--<script type="text/javascript">
    var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36281562-1']);
        _gaq.push(['_trackPageview']);
    (function() 
    {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();
  </script>-->
<!-- End Scripts -->
</body>
</html>