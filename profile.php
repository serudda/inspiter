<?php
session_start();
require_once("web/clases/Login.php");
require_once("web/clases/User.php");
require_once("web/clases/Session.php");
require_once("web/clases/Phrase.php");
require_once("web/clases/Inspiter.php");
require_once("web/clases/Follow.php");
require_once("web/clases/Favourite.php");
require_once("web/clases/Notification.php");
require_once("web/clases/Config.php");
require_once("web/clases/Token.php");
require_once("web/clases/Dedication.php");
require_once("web/clases/Inspire.php");
$userlogged = true;

if (!isset($_SESSION['iduser'])) 
{  
    if (isset($_COOKIE['iduser'])==true && $_COOKIE['iduser'] != '') 
    {
       $_SESSION['iduser'] = $_COOKIE['iduser'];
    }
    else
    {
       setcookie("urlLog", $_SERVER['REQUEST_URI'], time() + 31536000); 
    }
}

if (isset($_SESSION['iduser']))
{
    if(!isset($_SESSION['languaje']))
    {
        $_SESSION['languaje'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
    }
    include("web/lang_".$_SESSION['languaje'].".php");
    
    if(!isset($_COOKIE["iduser"]) || $_COOKIE["iduser"] == '')
         setcookie("iduser",$_SESSION['iduser'],time()+86400);
    $serverName = $_SERVER['SERVER_NAME'];
    setcookie("urlLog");
    //datos user
    $User1 = User::getUser($_SESSION['iduser']);
    $UserConfig = Config::getUserConfig($_SESSION['iduser']);
    $registerUserFirst = User::IsFirstTimeRegister($User1->getUserId());
    $usernameId = $User1->getUserLogin();
    $inspiterId = 0;
    $dedicId = 0;
    try {

        $posaux = strrpos($_SERVER['REQUEST_URI'], "%26");
        if ($posaux == true) {
            $url = str_replace('%26', '&', $_SERVER['REQUEST_URI']);
            header("location:" . $serverName . $url);
        }

        $pos = strrpos($_SERVER['REQUEST_URI'], "profile.php?id=");
        if ($pos === false) {
            //falta lo de la frase
            $userAmigableArray = explode("/", $_SERVER['REQUEST_URI']);
            if (is_numeric($userAmigableArray[1])) {
                if (User::is_user_exist($userAmigableArray[1]) == true) {
                    $userId = $userAmigableArray[1];
                    $usernameId = 'NO';
                } else {
                    $userId = $User1->getUserId();
                }
            } else {
                $inspiterAmigableArray = explode("&", $userAmigableArray[1]);

                $userIdByName = trim(User::getUserIdByUsername($inspiterAmigableArray[0]));
                if ($userIdByName != false) {
                    $userId = $userIdByName;
                    $usernameId = $AmigableArray[0];
                    $inspiterAmigableArray2 = explode("=", $inspiterAmigableArray[1]);
                    if (is_numeric($inspiterAmigableArray2[1])) {
                        if (isset($_GET['post']) && Inspiter::is_inspiter_exist($userId, $inspiterAmigableArray2[1]) == true) {
                            $inspiterId = $inspiterAmigableArray2[1];
                        } else {
                           if(isset($_GET['dedic']) && Dedication::is_dedication_exist($userId, $inspiterAmigableArray2[1]) == true)
                           {
                               $dedicId = $inspiterAmigableArray2[1];
                               $inspiterId = 0;
                           }
                           else
                           {
                               $inspiterId = 0;
                               $dedicId = 0;
                           }
                        }
                    } else {
                        $inspiterId = 0;
                        $dedicId = 0;
                    }
                } else {
                    $userId = $User1->getUserId();
                    $usernameId = 'NO';
                    $inspiterId = 0;
                    $dedicId = 0;
                }
            }
        } else {
            $pieces = explode("=", $_SERVER['REQUEST_URI']);
            $userIdParam = $pieces[1];

            if (is_numeric($userIdParam)) {
                if (User::is_user_exist($userIdParam) == true) {
                    $userId = $_GET['id'];
                    $usernameId = 'NO';
                } else {
                    $userId = $User1->getUserId();
                }
            } else {
                $pieces2 = explode("&", $pieces[1]);
                $userIdParam2 = $pieces2[0];
                if (is_numeric($userIdParam2)) {
                    if (User::is_user_exist($userIdParam2) == true) {
                        $userId = $_GET['id'];
                        $usernameId = 'NO';
                        $inspiterIdPar = $pieces[2];
                        if (is_numeric($inspiterIdPar)) {
                             if (isset($_GET['post']) && Inspiter::is_inspiter_exist($userId, $inspiterIdPar) == true) {
                                $inspiterId = $_GET['post'];
                                $dedicId = 0;
                            } else {
                                if (isset($_GET['dedic']) && Dedication::is_dedication_exist($userId, $inspiterIdPar) == true)
                                {
                                  $dedicId = $_GET['dedic'];
                                  $inspiterId = 0;
                                }
                                else
                                {
                                    $inspiterId = 0;
                                    $dedicId = 0;
                                 }
                            }
                        } else {
                            $inspiterId = 0;
                            $dedicId = 0;
                            
                        }
                    } else {
                        $userId = $User1->getUserId();
                        $inspiterId = 0;
                        $dedicId = 0;
                    }
                } else {
                    $userId = $User1->getUserId();
                    $inspiterId = 0;
                    $dedicId = 0;
                }
            }
        }
        // $userId = $_GET['id'];
        $UserFriend = User::getUserFriend($userId);
        $UserConfigFriend = Config::getUserConfigFriend($userId);

        if ($User1->getUserId() == $userId) {
            $userlogged = true;
        } else {
            $userlogged = false;
        }
        //datos frases
        $inspiterAmount = 0;
        $inspiterResult = Inspiter::getAmountInspiterFriend($userId);
        if (is_numeric($inspiterResult) == true)
            $inspiterAmount = $inspiterResult;

        $inspiterFavoritos = 0;
        $inspiterFavoritosResult = Favourite::getAmountFavourite($userId);
        if (is_numeric($inspiterFavoritosResult) == true)
            $inspiterFavoritos = $inspiterFavoritosResult;
        
        $inspireAmount = 0;
        $inspireResult = Inspire::getAmountInspireFriend($userId);
        if (is_numeric($inspireResult) == true)
            $inspireAmount = $inspireResult;

        //datos follow
        $seguidoresAmount = 0;
        $seguidoresResult = Follow::getAmountSeguidoresFriend($userId);
        if (is_numeric($seguidoresResult) == true)
            $seguidoresAmount = $seguidoresResult;

        $siguiendoAmount = 0;
        $siguiendoResult = Follow::getAmountSiguiendoFriend($userId);
        if (is_numeric($siguiendoResult) == true)
            $siguiendoAmount = $siguiendoResult;

        $notificationsResult = Config::getNotificationAmountShowed($_SESSION['iduser']);
        if (is_numeric($notificationsResult) == true && $notificationsResult > 0)
            $notificationsAmount = $notificationsResult;

        $tokenAccountResult = Token::isAccountActivated($User1->getEmail());
        if (is_numeric($tokenAccountResult) == false)
            $tokenAccountResult = 0;

        $dedicAccountResult = Dedication::getAmountDedicationToMe($userId);
        if (is_numeric($dedicAccountResult) == false)
            $dedicAccountResult = 0;
    } catch (Exception $e) {
        $userId = $User1->getUserId();
        $inspiterId = 0;
        $dedicId = 0;
        $usernameId = 'NO';
    }

?>

<!-- HTML PARA USERS LOGUEADOS -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="https://www.facebook.com/2008/fbml" lang="es">
    <head>
        <meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="inspiter.com" />
        <meta name="description" content="Inspirame en Inspiter" />
        <meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, perfil de usuario, usuarios" />
        <meta name="robots" content="index, follow" />
            <title><?php
if ($notificationsAmount != null) {
    echo '(' . $notificationsAmount . ') ' . $UserFriend->getFullName();
}
else
    echo $UserFriend->getFullName();
?></title>
            <link href="<?php echo "http://www.inspiter.com".substr($UserFriend->getPhoto(),2) ?>" rel="image_src" />
            <link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
            <link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
            <link href="css/style-home.css" rel="stylesheet" type="text/css"/>
            <link href="css/style-container-inspiration.css" rel="stylesheet" type="text/css"/>
            <link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
            <link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
            <link href="css/style-Main.css" rel="stylesheet" type="text/css"/>
            <link href="css/jquery.confirm.css" rel="stylesheet" type="text/css"/>
            <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
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

                                            <a data-toggle="dropdown" class="dropdown-toggle" id="btn-myprofile" name="btn-myprofile" role="button" href="#" data-original-title="<?php echo menu; ?>" data-toggle="tooltip" data-placement="bottom">
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
                                                    <a  id="TutorialOption" href="#" tabindex="-1">
                                                        <div id="ico-tuto"></div>
                                                        <?php echo tutorial; ?>
                                                    </a>
                                                </li>

                                                <li class="config-menu-list">
                                                    <a id="ConfigButtonMenu" href="/configuracion.php" tabindex="-1" >
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



<!-- BLOQUE INFORMACIÓN DEL USUARIO -->
<div class="ProfileBlockHeader">
<div class="profile-header-background"> </div>

<div class="Wrapper-Profile">
<div id="ProfileImageBlock" class="ProfileImageBlock">
    <img id="imgProfileBlock" class="imgProfileBlock" src="">
    <span class="loadingPost">Cargando...</span>
    <?php if($User1->getUserId() == $UserFriend->getUserId()) 
       echo '<a id="edit-avatar-button" class="edit-avatar-button btnIns" href="/configuracion.php#NewPhoto-Position">Cambiar Foto</a>'; 
    ?>
</div>
<div class="ProfileInfoBlock ProfileBlock">

<div class="slide-change-profile">
<div class="slide-line"></div>
<div class="slide-control" data-original-title="Mostrar Frase Insignia" data-toggle="tooltip" data-placement="right"></div>
</div>

<div class="PhraseInfoBlock">
   <img id="ImagePhraseProfile" class="ImagePhraseProfile"> 
   <div id="textBlockPhraseIns" class="inner-phrase-img">
    <blockquote id="textImgPhrase" class="pullquote imgPhrase"><?php echo $UserConfigFriend->getIdentPhrase(); ?></blockquote>
    <p id="textImgAuthor" class="autor-name imgPhrase"><?php echo $UserConfigFriend->getAuthor(); ?></p>
     <?php if($User1->getUserId() == $UserFriend->getUserId()) 
    echo '<a id="edit-phraseIns-button" class="edit-phraseIns-button btnIns" href="/configuracion.php#NewPhoto-Position">Cambiar frase insignia</a>';
    ?>
   </div>
    <div id="loadingPhraseIns" class="iconLoadingImg"></div>
    <div id="NoPhraseInsText" class="NoPhraseInsText">No tiene una frase insignia aún  :(</div>
</div>
    

<div class="UserInfoBlock">
<span class="NameInfoBlock"><?php echo $UserFriend->getFullName();  ?></span>
<?php if($User1->getUserId() != $UserFriend->getUserId())
{
 echo '<span class="position-follow-btn">
       <a id="followProfile_<?php echo $User1->getUserId(); ?>" href="/<?php echo $User1->getUserLogin(); ?>" class="btn-Follow-menu">Seguir</a>
       </span>';
}?>   
<p id="cityCounInfoBlock" class="cityCounInfoBlock"><?php echo $UserFriend->getCity()?></p>
<p><?php echo $UserConfigFriend->getAboutYou(); ?> </p>

<ul class="ProfileUrls">
 <!--Region Url Face -->
 <?php if($UserConfigFriend->getFaceUri()!='' && $UserConfigFriend->getFaceUri()!=null) {?>     
 <li style="margin-right:0px;">
    <a class="icon-face-url" target="_blank" data-toggle="tooltip" data-original-title="<?php echo $UserConfigFriend->getFaceUri(); ?>" title="<?php echo $UserConfigFriend->getFaceUri(); ?>" href="<?php echo $UserConfigFriend->getFaceUri(); ?>"></a>
 </li>
 <?php } ?>
 <!--End Region Url Face -->
 
 <!--Region Url Web Site -->
 <?php if($UserConfigFriend->getWebSite()!='' && $UserConfigFriend->getWebSite()!=null) { ?>    
  <li id="urlSiteBlock" style="margin-left: 15px;border-left: 1px solid #CCC;padding-left: 15px;">
    <a class="url-site-profile site-url-icon" target="_blank" href="<?php echo $UserConfigFriend->getWebSite();?> "><?php echo $UserConfigFriend->getWebSite();?></a>    
  </li>   
 <?php } ?>
 <!--End Region Url Web Site -->
 
 <!--Region Icono denunciar -->
<?php if($User1->getUserId() != $UserFriend->getUserId())
{
 echo '<li style="float:right;">
<a class="icon-den-url" id="icon_denunc_user" data-toggle="tooltip" data-original-title="Denunciar a esta persona" title="Denunciar a esta persona" href="#"></a>
</li>';
}?>
<!--End Region Icono denunciar -->
</ul>
</div>

<div class="StatInfoBlock">
<h5 class="statsUser">
<span class="icoStatsBlock"></span>
Estad&iacute;sticas
</h5>
<table class="stats-block">
<tbody>
<tr>
<td class="measure"><?php echo $inspiterAmount; ?></td>
<td class="value">Inspiraciones</td>
</tr>
<tr>
<td class="measure" id="pFollower"><?php echo $seguidoresAmount; ?></td>
<td class="value">Seguidores</td>
</tr>
<tr>
<td class="measure" id="pFollowing"><?php echo $siguiendoAmount; ?></td>
<td class="value">Siguiendo</td>
</tr>
<tr>
<td class="measure" id="pInspire"> <?php echo $inspireAmount; ?></td>
<td class="value">"Me Inspira Dados"</td>
</tr>
</tbody>
</table>
<div class="ips-block" id="ips_value_div" data-toggle="tooltip" data-original-title="Los puntos IPS muestran que tan inspirador eres para el mundo, este valor se calcula en base a la CALIDAD de inspiraciones que hayas publicado." >
<table class="ips-contain">
<tbody>
<tr>
    <td class="ipscount" id="ips_value_td"><span id="ipsValue"><?php echo $UserConfigFriend->getIPS(); ?></span> ips</td> 
</tr>
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>
<div class="UserMenuComplete" id="userMenu">	
<div class="UserMenuProfile">

<div id="content-menuPhrase">

<ul id="nav-menu-main" class="nav nav-pills">
<li id="menu-tope-insp" class="active-menu"><a id="inspiracionesli" href="#">Inspiraciones</a></li>
<li id="menu-tope-pref"><a id="favoritosli" href="#">Favoritos</a></li>
 <?php if($User1->getUserId() == $UserFriend->getUserId()) 
     echo '<li id="menu-tope-ded"><a id="dedicationli" href="#">Dedicatorias</a></li>';
 ?>
<li id="menu-tope-seg"><a id="seguidoresli" href="#">Seguidores</a></li>
<li id="menu-tope-sig"><a id="siguiendoli" href="#">Siguiendo</a></li>
</ul>

</div>
</div>
</div>
<div class="option-sort-contain">
<ul class="nav nav-pills list-option-sort">
<li id="allOptionSort"><div class="ico-all-inspirations"></div><?php echo all; ?></li>
<li id="textOptionSort"><div class="ico-text-inspirations"></div><?php echo text; ?></li>
<li id="mediaOptionSort"><div class="ico-media-inspirations"></div><?php echo media; ?></li>
</ul>
</div>

<div class="profile-container">

<div class="wrapperAll">



<div id="content" class="wrapper">

															 
</div><!-- Aqui se van a crear las frases dinamicamente-->


<div id="LoadingInspirations"><!-- Aqui separamos en otro content la frase de regalo de Inspiter y el boton Ver mas-->
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
																														<input type="hidden" id="Iam" value="profile"/>
                                                            <input type="hidden" id="fullnameInput" value="<?php echo $UserFriend->getFullName(); ?>">
                                                             <input type="hidden" id="imgUserProfile" value="<?php echo $UserFriend->getPhoto(); ?>">   
                                                                <input type="hidden" id="usernameInput" value="<?php echo $UserFriend->getUserLogin(); ?>">
                                                                    <input type="hidden" id="cityInput" value="<?php echo $UserFriend->getCity();?>">
                                                                        <input type="hidden" id="userIdLogged" value="<?php echo $User1->getUserId(); ?>">
                                                                            <input type="hidden" id="photosmall" name="photosmall" value="<?php echo $User1->getPhotoSmall(); ?>">
                                                                                <input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
                                                                                    <input type="hidden" id="urlfinal" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                                                                        <input type="hidden" id="faceidHidden" value="<?php echo $User1->getFaceId(); ?>">
                                                                                            <input type="hidden" id="usernameHidden" value="<?php echo $User1->getUserLogin(); ?>">
		<input type="hidden" id="sessionId" value="<?php echo $_SESSION['iduser']; ?>">
		<input type="hidden" id="useridhidden" name="useridhidden" value="<?php echo $UserFriend->getUserId(); ?>"></input>
                                                                                                <input type="hidden" id="typeMenu" value="<?php
                                                                                                if (isset($_GET['ty_me']) == true) {
                                                                                                    echo $_GET['ty_me'];
                                                                                                }
?>"> </input>
                                                                                                <input type="hidden" id="inspiterId" value="<?php echo $inspiterId; ?>"></input>
                                                                                                <input type="hidden" id="dedicId" value="<?php echo $dedicId; ?>"></input>
                                                                                                <input type="hidden" id="fullnameHidden" value="<?php echo $User1->getFullName(); ?>" />
                                                                                                <input type="hidden" id="imagenPhrase" value="<?php echo $UserConfigFriend->getImageIPhrase(); ?>" />
                                                                                                <input type="hidden" id="userIdparam" value="<?php echo $userId; ?>"/>																																				
                                                                                                <input type="hidden" id="userId" value="<?php echo $User1->getUserId(); ?>">
                                                                                                <input type="hidden" id="usernameParam" value="<?php echo $usernameId; ?>"/>
                                                                                                <input type="hidden" id="cantinspiter" value="<?php echo $inspiterResult; ?>"/>
                                                                                                <input type="hidden" id="cantfavoritos" value="<?php echo $inspiterFavoritos; ?>"/>
                                                                                                <input type="hidden" id="isActivated" value="<?php echo $tokenAccountResult; ?>"/>
                                                                                                <input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
                                                                                                <input type="hidden" id="SiguiendoAmount" name="SiguiendoAmount" value="<?php echo $siguiendoAmount; ?>">
                                                                                                <input type="hidden" id="IPSAmount" name="IPSAmount" value="<?php echo $UserConfig->getIPS(); ?>">
                                                                                                <input type="hidden" id="stateProfile" name="statePorfile" value="<?php echo $UserConfig->getStateProfile(); ?>">
                                                                                                <input type="hidden" id="stateProfileFriend" name="statePorfileFriend" value="<?php echo $UserConfigFriend->getStateProfile(); ?>">
                                                                                                    
                                                                                                  </div>
                                                                                                </div>

                                                                                                <!--MODALS DEDICATION -->		
                                                                                                <div id="modalDed" class="styled">

                                                                                                    <div class="header-modal grd">
                                                                                                        <a id="closeModalDedic" class="close" href="#"><strong>Cerrar</strong><span></span></a>
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
                                                                                                                        <label class="checkLabelDed"><?php echo sendDedicMail; ?></label>
                                                                                                                </div>
                                                                                                                <div class="posCheckFace">
                                                                                                                    <input id="DedCheckFace" type="checkbox" class="DedCheck" name="DedCheckFace">
                                                                                                                        <label class="checkLabelDed"><?php echo facebookdedic; ?></label>
                                                                                                                </div>
                                                                                                                <div class="posButtonDed">
                                                                                                                    <button id="DedSubmit" name="DedSubmit" type="button" class="btn btn-success">Dedicar</button>
                                                                                                                </div>
                                                                                                                <input type="hidden" id="dedicInspiterId" name="dedicInspiterId" value=""/>
                                                                                                                <input type="hidden" id="dedicUsername" name="dedicUsername" value=""/>
                                                                                                                <input type="hidden" id="FromUserId" name="FromUserId" value="<?php echo $User1->getUserId(); ?>"/>
                                                                                                                <input type="hidden" id="FromUsername" name="FromUsername" value="<?php echo $User1->getFullName(); ?>"/>
																																																							  <input type="hidden" id="ToUserId" name="ToUserId" value=""/>
																																		
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </form>
                                                                                                    <!--<a href="#" id="close-modal">Close modal</a>-->

                                                                                                </div>
				<!--END: MODALS DEDICATION-->

				
				
						 
		 <!-- MODALS INSPIRE-->
	
	<div id="BlockModalIns" class="BlockModalIns">	
	 <div class="BlockModalInsOut">
		<div class="BlockModalInsInner">
		 <div class="BlockModalInsContent" style="height: auto; width: auto;">
    <div id="ModalIns" class="styled">

		 <div class="header-modal grd">
			<a id="closeModalIns" class="close" href="#"><strong>Cerrar</strong><span></span></a>
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
			 <textarea id="DescriptionVideoInsp" name="DescriptionImageInsp" class="post-inspiration description-inspiration" maxlength="200" placeholder="<?php echo describeInspc; ?>"></textarea>
			</div>   
                        
                        <div class="add-video-ico">
                        <?php echo pegaSubeVideo ; ?>
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
	 <div id="tuto-background">
		<div class="tuto-wrapper">
		</div>
	 </div>

<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>         
<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="js/krioImageLoader.js"></script>
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
<script type="text/javascript" src="js/generators.js"></script>
<script type="text/javascript" src="js/buscador-jquery.js"></script>
<script type="text/javascript" src="js/buscadorDed-jquery.js"></script> 
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript" src="js/notifications.js"></script>
<script type="text/javascript" src="js/validate-dedicate.js"></script>
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
<!-- End Scripts -->
</body>
</html>
<?php 
 }
else
{
  $registerUserFirst = "NO";  
  $usernameId = 'NO';
  $inspiterId = 0; 
  $dedicId = 0; 
  try 
  {
    $posaux = strrpos($_SERVER['REQUEST_URI'], "%26");
    if ($posaux == true) 
    {
      $url = str_replace('%26', '&', $_SERVER['REQUEST_URI']);
      header("location:" . $serverName . $url);
    }
    $pos = strrpos($_SERVER['REQUEST_URI'], "profile.php?id=");
    if ($pos === false) 
    {
      //falta lo de la frase
      $userAmigableArray = explode("/", $_SERVER['REQUEST_URI']);
      if (is_numeric($userAmigableArray[1])) 
      {
         if (User::is_user_exist($userAmigableArray[1]) == true) 
         {
          $userId = $userAmigableArray[1];
          $usernameId = 'NO';
          }
          else 
          {
            $userId = 0;
          }
       }
       else 
       {
         $inspiterAmigableArray = explode("&", $userAmigableArray[1]);
         $userIdByName = trim(User::getUserIdByUsername($inspiterAmigableArray[0]));
         if ($userIdByName != false) 
         {
            $userId = $userIdByName;
            $usernameId = $AmigableArray[0];
            $inspiterAmigableArray2 = explode("=", $inspiterAmigableArray[1]);
            if(is_numeric($inspiterAmigableArray2[1]))
            {
              if (isset($_GET['post']) && Inspiter::is_inspiter_exist($userId, $inspiterAmigableArray2[1]) == true)
              {
                $inspiterId = $inspiterAmigableArray2[1];
              }
              else
              {
                if(isset($_GET['dedic']) && Dedication::is_dedication_exist($userId, $inspiterAmigableArray2[1]) == true)
                {
                  $dedicId = $inspiterAmigableArray2[1];
                  $inspiterId = 0;
                }
                else
                {
                  $inspiterId = 0;
                  $dedicId = 0;
                }
               }
             }
             else
             {
               $inspiterId = 0;
               $dedicId = 0;
             }
           }
           else
           {
             $userId = 0;
             $usernameId = 'NO';
             $inspiterId = 0;
             $dedicId = 0;
            }
          }
        } 
        else
        {
          $pieces = explode("=", $_SERVER['REQUEST_URI']);
          $userIdParam = $pieces[1];
          if (is_numeric($userIdParam)) 
          {
             if (User::is_user_exist($userIdParam) == true)
             {
                $userId = $_GET['id'];
                $usernameId = 'NO';
             }
             else
             {
               $userId = 0;
             }
           }
           else
           {
             $pieces2 = explode("&", $pieces[1]);
             $userIdParam2 = $pieces2[0];
             if (is_numeric($userIdParam2)) 
             {
               if (User::is_user_exist($userIdParam2) == true)
               {
                 $userId = $_GET['id'];
                 $usernameId = 'NO';
                 $inspiterIdPar = $pieces[2];
                 if (is_numeric($inspiterIdPar))
                 {
                    if (isset($_GET['post']) && Inspiter::is_inspiter_exist($userId, $inspiterIdPar) == true) 
                    {
                      $inspiterId = $_GET['post'];
                      $dedicId = 0;
                    }
                    else 
                    {
                      if (isset($_GET['dedic']) && Dedication::is_dedication_exist($userId, $inspiterIdPar) == true)
                      {
                        $dedicId = $_GET['dedic'];
                        $inspiterId = 0;
                      }
                      else
                      {
                        $inspiterId = 0;
                        $dedicId = 0;
                      }
                     }
                  }
                  else 
                  {
                    $inspiterId = 0;
                    $dedicId = 0;
                  }
                  } 
                  else 
                  {
                    $userId = 0;  
                    $inspiterId = 0;
                    $dedicId = 0;
                  }
                } 
                else 
                {
                  $userId = 0;
                  $inspiterId = 0;
                  $dedicId = 0;
                }
            }
        }
        $UserFriend = User::getUserFriend($userId);
        $UserConfigFriend = Config::getUserConfigFriend($userId);
        $userlogged = false;
       
        //datos frases
        $inspiterAmount = 0;
        $inspiterResult = Inspiter::getAmountInspiterFriend($userId);
        if (is_numeric($inspiterResult) == true)
            $inspiterAmount = $inspiterResult;

        $inspiterFavoritos = 0;
        $inspiterFavoritosResult = Favourite::getAmountFavourite($userId);
        if (is_numeric($inspiterFavoritosResult) == true)
            $inspiterFavoritos = $inspiterFavoritosResult;
        
        $inspireAmount = 0;
        $inspireResult = Inspire::getAmountInspireFriend($userId);
        if (is_numeric($inspireResult) == true)
            $inspireAmount = $inspireResult;

        //datos follow
        $seguidoresAmount = 0;
        $seguidoresResult = Follow::getAmountSeguidoresFriend($userId);
        if (is_numeric($seguidoresResult) == true)
            $seguidoresAmount = $seguidoresResult;

        $siguiendoAmount = 0;
        $siguiendoResult = Follow::getAmountSiguiendoFriend($userId);
        if (is_numeric($siguiendoResult) == true)
            $siguiendoAmount = $siguiendoResult;
    }          
    catch (Exception $e) 
    {
      $userId = 0;
      $inspiterId = 0;
      $dedicId = 0;
      $usernameId = 'NO';
    }
?>
<!-- HTML PARA USERS NO LOGUEADOS -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="https://www.facebook.com/2008/fbml" lang="es">
    <head>
                
        <meta name="google-site-verification" content="KcL1kq7t7gBoHOJJDB_6rybHNeX4Xl3dfk-40qnBtdA">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="inspiter.com" />
        <meta name="description" content="Inspirame en Inspiter" />
        <meta name="keywords" content="Frases inspiradoras, Inspiraciones, frases para dedicar, Inspiter, perfil de usuario, usuarios" />
        <meta name="robots" content="index, follow" />
        <title>
        <?php
        if ($UserFriend->getFullName() == '')
        {
          echo 'Inspiter';
        }
        else
        {
          echo $UserFriend->getFullName();
        }
        ?> 
        </title>
        <link href="<?php echo "http://www.inspiter.com".substr($UserFriend->getPhoto(),2) ?>" rel="image_src" />
        <link rel="shortcut icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="http://www.inspiter.com/images/favicon.ico" type="image/x-icon">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-home.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-container-inspiration.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-profile-main.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
        <link href="css/style-Main.css" rel="stylesheet" type="text/css"/>
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
              
          <!--NAVIBAR BLOQUE-->
          <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
              <div class="container">
               <a id="logo" class="span4" href="/">
                 <h1>Inspiter</h1>  
               </a>
               <ul id="pull-right" class="nav pull-right">
                   <li style="margin-right:11px;">
                       <a href="register.php" class="registerBtnWelcome">¡Comienza Ahora!</a>
                   </li>
                   <li class="divider-vertical"></li>
                   <li>
                       <a href="index.php" style="color:#FFF;cursor:pointer;">Entrar</a>
                   </li>      
               </ul>   
              </div>
            </div>
          </div>
          <!--END NAVIBAR BLOQUE-->

          <!-- BLOQUE INFORMACIÓN DEL USUARIO -->
          <div class="ProfileBlockHeader">
           <div class="profile-header-background"> 
           </div>
           <div class="Wrapper-Profile">
            <div id="ProfileImageBlock" class="ProfileImageBlock">
             <img id="imgProfileBlock" class="imgProfileBlock" src="">
             <span class="loadingPost">Cargando...</span>
            </div>
               
            <div class="ProfileInfoBlock ProfileBlock">
             <div class="slide-change-profile">
              <div class="slide-line"></div>
              <div class="slide-control" data-original-title="Mostrar Frase Insignia" data-toggle="tooltip" data-placement="right"></div>
            </div>
            <div class="PhraseInfoBlock">
            <img id="ImagePhraseProfile" class="ImagePhraseProfile">
             <div id="textBlockPhraseIns" class="inner-phrase-img">
              <blockquote id="textImgPhrase" class="pullquote imgPhrase"><?php echo $UserConfigFriend->getIdentPhrase(); ?></blockquote>
              <p id="textImgAuthor" class="autor-name imgPhrase"><?php echo $UserConfigFriend->getAuthor(); ?></p>
             </div> 
              <div id="loadingPhraseIns" class="iconLoadingImg"></div>
              <div id="NoPhraseInsText" class="NoPhraseInsText">No tiene una frase insignia aún  :(</div>
            </div>
            <div class="UserInfoBlock">
             <span class="NameInfoBlock"><?php echo $UserFriend->getFullName();  ?></span>
             <span class="position-follow-btn">
               <a id="followProfile_<?php echo $UserFriend->getUserId(); ?>" href="#" class="btn-Follow-menu">Seguir</a>
             </span>;
             <p id="cityCounInfoBlock" class="cityCounInfoBlock"><?php echo $UserFriend->getCity()?></p>
             <p><?php echo $UserConfigFriend->getAboutYou(); ?> </p>
             <ul class="ProfileUrls">
             
             <!--Region Url Face -->
             <?php
              if($UserConfigFriend->getFaceUri()!='' && $UserConfigFriend->getFaceUri()!=null) 
              {
             ?>     
               <li style="margin-right:0px;">
                <a class="icon-face-url" target="_blank" data-toggle="tooltip" data-original-title="<?php echo $UserConfigFriend->getFaceUri(); ?>" title="<?php echo $UserConfigFriend->getFaceUri(); ?>" href="<?php echo $UserConfigFriend->getFaceUri(); ?>"></a>
               </li>
             <?php 
              } 
             ?>
             <!--End Region Url Face -->
 
             <!--Region Url Web Site -->
             <?php
              if($UserConfigFriend->getWebSite()!='' && $UserConfigFriend->getWebSite()!=null) 
              { 
             ?>    
               <li id="urlSiteBlock" style="margin-left: 15px;border-left: 1px solid #CCC;padding-left: 15px;">
                <a class="url-site-profile site-url-icon" target="_blank" href="<?php echo $UserConfigFriend->getWebSite();?> "><?php echo $UserConfigFriend->getWebSite();?></a>    
               </li>   
             <?php 
             }
             ?>
            <!--End Region Url Web Site -->
         </ul>
       </div>
       <div class="StatInfoBlock">
        <h5 class="statsUser">
        <span class="icoStatsBlock"></span>
         Estad&iacute;sticas
        </h5>
        <table class="stats-block">
         <tbody>
          <tr>
           <td class="measure"><?php echo $inspiterAmount; ?></td>
           <td class="value">Inspiraciones</td>
          </tr>
          <tr>
           <td class="measure" id="pFollower"><?php echo $seguidoresAmount; ?></td>
           <td class="value">Seguidores</td>
          </tr>
          <tr>
           <td class="measure" id="pFollowing"><?php echo $siguiendoAmount; ?></td>
           <td class="value">Siguiendo</td>
          </tr>
          <tr>
           <td class="measure" id="pInspire"> <?php echo $inspireAmount; ?></td>
           <td class="value">"Me Inspira Dados"</td>
          </tr>
         </tbody>
        </table>
        <div class="ips-block" id="ips_value_div" data-toggle="tooltip" data-original-title="Los puntos IPS muestran que tan inspirador eres para el mundo, este valor se calcula en base a la CALIDAD de inspiraciones que hayas publicado." >
         <table class="ips-contain">
          <tbody>
           <tr>
            <td class="ipscount" id="ips_value_td"><span id="ipsValue"><?php echo $UserConfigFriend->getIPS(); ?></span> ips</td> 
           </tr>
          </tbody>
         </table>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="profile-container">
    <div class="wrapperAll">
    <div id="content" class="wrapper">
   </div>
   <div id="LoadingInspirations"><!-- Aqui separamos en otro content la frase de regalo de Inspiter y el boton Ver mas-->
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
     <input type="hidden" id="Iam" value="profile"/>
     <input type="hidden" id="fullnameInput" value="<?php echo $UserFriend->getFullName(); ?>">
     <input type="hidden" id="imgUserProfile" value="<?php echo $UserFriend->getPhoto(); ?>">    
     <input type="hidden" id="usernameInput" value="<?php echo $UserFriend->getUserLogin(); ?>">
     <input type="hidden" id="cityInput" value="<?php echo $UserFriend->getCity();?>">
     <input type="hidden" id="userIdLogged" value="<?php echo 0 ?>">
     <input type="hidden" id="photosmall" name="photosmall" value="">
     <input type="hidden" id="urlcomienzo" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
     <input type="hidden" id="urlfinal" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
     <input type="hidden" id="faceidHidden" value="0">
     <input type="hidden" id="usernameHidden" value="">
     <input type="hidden" id="sessionId" value="0">
     <input type="hidden" id="useridhidden" name="useridhidden" value="<?php echo $UserFriend->getUserId(); ?>">
     <input type="hidden" id="typeMenu" value="<?php if (isset($_GET['ty_me']) == true){echo $_GET['ty_me'];}?>">
     <input type="hidden" id="inspiterId" value="<?php echo $inspiterId; ?>">
     <input type="hidden" id="dedicId" value="<?php echo $dedicId; ?>">
     <input type="hidden" id="fullnameHidden" value="" />
     <input type="hidden" id="imagenPhrase" value="<?php echo $UserConfigFriend->getImageIPhrase(); ?>" />
     <input type="hidden" id="userIdparam" value="<?php echo $userId; ?>"/>																																				
     <input type="hidden" id="userId" value="">
     <input type="hidden" id="usernameParam" value="<?php echo $usernameId; ?>"/>
     <input type="hidden" id="cantinspiter" value="<?php echo $inspiterResult; ?>"/>
     <input type="hidden" id="cantfavoritos" value="<?php echo $inspiterFavoritos; ?>"/>
     <input type="hidden" id="isRegisterFirstTime" value="<?php echo $registerUserFirst; ?>">
     <input type="hidden" id="SiguiendoAmount" name="SiguiendoAmount" value="<?php echo $siguiendoAmount; ?>">
     <input type="hidden" id="stateProfileFriend" name="statePorfileFriend" value="<?php echo $UserConfigFriend->getStateProfile(); ?>">
     <input type="hidden" id="photocomplet" value="<?php echo 'http://www.inspiter.com'.substr($UserFriend->getPhoto(),2)?>">
    </div>
   </div>
   <div id="Bigloading" class="Bigloading">
    <img src="images/ajax-loader-big.gif">
   </div>
          
          
                                                                                                  
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


<!--IMPORTAMOS SCRIPT PARA USERS NO LOGUEADOS-->          
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>         
<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="js/krioImageLoader.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/layoutColumn.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="js/jquery.cokidoo-textarea.js"></script>
<script type="text/javascript" src="js/jquery.maxlength.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/generatorsOffline.js"></script>
<script type="text/javascript" src="js/jquery.confirm.js"></script>
<script type="text/javascript" src="js/alert-script.js"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<!--FEEDBACK PLUGIN -->
<script type="text/javascript">
 var uvOptions = {};
 (function() {
   var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
   uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/ZfdIuPgm43KneOxv75PnQ.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
<!-- End Scripts -->
</body>
</html>
<?php
}
?>