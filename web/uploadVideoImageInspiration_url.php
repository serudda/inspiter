<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
ini_set('memory_limit','1280000M');

session_start();

define("maxUpload", 5000000);//aqui hacemos lo mismo de siempre
define("maxWidth", 10000);
define("maxHeight", 10000);
define("minWidth", 400);
define("minHeight", 400);
define("imagedirectory", '../images/videoImageIns/');//la misma carpeta que las frases graficas

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

function youtube_data($url,$return='',$width='',$height='',$rel=0)
{
 $urls = parse_url($url);
 //url is http://youtu.be/xxxx 
 if($urls['host'] == 'youtu.be')
 {
  $id = ltrim($urls['path'],'/');
 }
 //url is http://www.youtube.com/embed/xxxx
 else if(strpos($urls['path'],'embed') == 1)
 {
  $id = end(explode('/',$urls['path']));
 }
 else if(strpos($url,'/')===false){
  $id = $url;
}
//http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
//url is http://www.youtube.com/watch?v=xxxx
else{
parse_str($urls['query']);
$id = $v;
}
//return embed iframe
if($return == 'embed'){
return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen></iframe>';
}
//return normal thumb
else if($return == 'thumb'){
return 'http://img.youtube.com/vi/'.$id.'/default.jpg';
}
//return hqthumb
else if($return == 'hqthumb'){
return 'http://img.youtube.com/vi/'.$id.'/0.jpg';
}
//return title
else if ($return == 'title') {
$url = "http://gdata.youtube.com/feeds/api/videos/". $id;
$doc = new DOMDocument;
$doc->load($url);
return $doc->getElementsByTagName("title")->item(0)->nodeValue;
}
// else return id
else{
return $id;
}
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{ 
 if (isset($_SESSION['filenameVideo']) && $_SESSION['filenameVideo'] != '')
 {
   try
   { 
     $urlImagejpg = imagedirectory.$_SESSION['filenameVideo']."temp.jpg";
     $urlImagepng = imagedirectory.$_SESSION['filenameVideo']."temp.png";
     $urlImageJPG = imagedirectory.$_SESSION['filenameVideo']."temp.JPG";
     $urlImagePNG = imagedirectory.$_SESSION['filenameVideo']."temp.PNG";
     
     if(file_exists($urlImagejpg)==true)
     {unlink($urlImagejpg);}
     else if(file_exists($urlImagepng)==true)
     {unlink($urlImagepng);}
     else if(file_exists($urlImageJPG)==true)
     {unlink($urlImageJPG);}
     else if(file_exists($urlImagePNG)==true)
     {unlink($urlImagePNG);}
   }
   catch(Exception $e)
   {}
 }    
 
 try
 {
  $numeroRand = rand(1000,1000000000);
  $fileName = $_POST['userId'].'a'.$numeroRand.'temp';
  $fileType = array('2','3');
  $urlImage = youtube_data($_POST['urlVideo'],'hqthumb');
  $img = file_get_contents($urlImage);
  if($img == false)
  {
    throw new Exception("No se puede procesar: (".$_POST['urlVideo']."). Verifique que la URL sea valida.");
    $mensajeFile = 'Verifique la url que acaba de proporcionar.';
  }
  else
  {
    $file = imagedirectory.$fileName.'.jpg';
    file_put_contents($file, $img);
    $pasaImgSize = false;
    $respuestaFile = false;
    $mensajeFile = 'ERROR EN EL SCRIPT';
    list($ancho, $alto, $tipo, $atributos) = getimagesize($file);
    $tamanio = filesize($file);//aqui consigo el tamañño en bytes de la imagen
    // Verificamos la extensión del archivo independiente del tipo mime
    $extension = explode('.',$file);
    $num = count($extension)-1;
    // Creamos el nombre del archivo dependiendo la opción
    $imgFile = $fileName.'.'.$extension[$num];
    $_SESSION['filenameVideo'] = $_POST['userId'].'a'.$numeroRand;
    $_SESSION['extension'] = $extension[$num];
    
    $respuestaFile = 'done';
    $fileName = $imgFile;
    $mensajeFile = $imgFile;
    $info = pathinfo($fileName);
    $resizeObj = new resize(imagedirectory.$imgFile);
    $resizeObj -> resizeImage(430, 430, 'landscape');
    $resizeObj -> saveImage(imagedirectory.$fileName, 100);
    $_SESSION['urlVideo'] = "http://www.youtube.com/v/".youtube_data($_POST['urlVideo']);
$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $urlImage.' '.$file,
					"fileName" => $fileName);
 echo json_encode($salidaJson);
 }
 }
catch(Exception $e)
{ 
    $salidaJson = array("respuesta" => "error",
					"mensaje" => $e->getMessage() ,
					"fileName" => "No file");
    echo json_encode($salidaJson);
}

}

else
{
    echo 'NOSSID';
    header("location: ../index.php?logout=ok&activate=si&uid=Y");
}
}
else
   echo 'NOSSID'; 
?>
