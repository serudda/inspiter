<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
ini_set('memory_limit','1280000M');

session_start();

define("maxUpload", 5000000);
define("maxWidth", 10000);
define("maxHeight", 10000);
define("minWidth", 400);
define("minHeight", 300);
define("imagedirectory", '../images/origGraphIns/');

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{ 
 if (isset($_SESSION['filenameProfile']) && $_SESSION['filenameProfile'] != '')
 {
   try
   { 
     $urlImagejpg = imagedirectory.$_SESSION['filenameProfile']."temp.jpg";
     $urlImagepng = imagedirectory.$_SESSION['filenameProfile']."temp.png";
     $urlImageJPG = imagedirectory.$_SESSION['filenameProfile']."temp.JPG";
     $urlImagePNG = imagedirectory.$_SESSION['filenameProfile']."temp.PNG";
     
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
  $fileName = $_GET['userId'].'a'.$numeroRand.'temp';
  // Tipos MIME
  $fileType = array('2','3');
  //Obtener la imagen de la url
  $img = file_get_contents($_POST['urlAddImage']);
  if($img === false)
  {
    throw new Exception("No se puede procesar: (".$_POST['urlAddImage']."). Verifique que la URL contenga una imagen valida.");
    //Manejador de error: http://stackoverflow.com/questions/272361/how-can-i-handle-the-warning-of-file-get-contents-function-in-php
    $mensajeFile = 'Verifique la url que acaba de proporcionar.';
  }
  else
  {
    
    //Obtengo la extension de la imagen Original
       
    $extensionOrig = substr($_POST['urlAddImage'], -3);
    $file = '../images/origGraphIns/'.$fileName.'.'.$extensionOrig;
    file_put_contents($file, $img);
    // Bandera para procesar imagen 
    $pasaImgSize = false;
    //bandera de error al procesar la imagen
    $respuestaFile = false;
    // error del lado del servidor
    $mensajeFile = 'ERROR EN EL SCRIPT';
    // Tamaño de la imagen
    list($ancho, $alto, $tipo, $atributos) = getimagesize($file);//aqui uso el getimagesize de otra forma,
    $tamanio = filesize($file);//aqui consigo el tamañño en bytes de la imagen
    // Verificamos la extensión del archivo independiente del tipo mime
    $extension = explode('.',$file);
    $num = count($extension)-1;

    $imgFile = $fileName.'.'.$extension[$num];
    $_SESSION['filenameProfile'] = $_GET['userId'].'a'.$numeroRand;
    $_SESSION['extension'] = $extension[$num];
    // Verificamos el tamaño válido para los logotipos
    $anchoOrig = $ancho;
	$altoOrig  = $alto;
    if($ancho <= maxWidth && $alto <= maxHeight && $ancho >= minWidth && $alto >= minHeight) 
	$pasaImgSize = true;

    // Verificamos el status de las dimensiones de la imagen a publicar
    if($pasaImgSize == true)
    {
       // Verificamos Tamaño y extensiones
       if(in_array($tipo, $fileType) && $tamanio>0 && $tamanio<=maxUpload && ($extension[$num]=='jpg' || $extension[$num]=='JPG' || $extension[$num]=='png' || $extension[$num]=='PNG'))
       {
          $OutputFile = imagedirectory.$fileName.'.jpg';  
           
         if(($extension[$num] =='PNG')|| ($extension[$num] == 'png')){
                 $image = imagecreatefrompng(imagedirectory.$imgFile);
                 imagejpeg($image,$OutputFile, 100);
                 imagedestroy($image);
         } 
         
	 $respuestaFile = 'done';
	 $fileName = $imgFile;
	 $mensajeFile = $imgFile;
         //para cambiar la extension a .jpg
         //$info = pathinfo($fileName);
         //$new_extension ='jpg';
         //$fileName = $info['filename'] . '.' . $new_extension;
         if($anchoOrig >= 740)
         {
           $resizeObj = new resize(imagedirectory.$imgFile);
           //resize la imagen en 430xundefined y lo guarda en la carpeta graphIns
           $resizeObj -> resizeImage(740, 430, 'landscape');
           $resizeObj -> saveImage(imagedirectory.$fileName, 100);
           $ArrayDimentions = $resizeObj->getDimensions(740, $alto, 'landscape');										//$size = GetImageSize($fileName);
           $_SESSION['originalWidth'] = $ArrayDimentions['optimalWidth'];
           $_SESSION['originalHeight'] = $ArrayDimentions['optimalHeight'];
         }
         else
         {
           $resizeObj = new resize(imagedirectory.$imgFile);
           $resizeObj -> saveImage(imagedirectory.$fileName, 100);
           $ArrayDimentions = $resizeObj->getDimensions($anchoOrig, $alto, 'landscape');										//$size = GetImageSize($fileName);
           $_SESSION['originalWidth'] = $ArrayDimentions['optimalWidth'];
           $_SESSION['originalHeight'] = $ArrayDimentions['optimalHeight'];
         }
         $heightArray = $resizeObj->getDimensions(430, $alto, 'landscape');
         $heightAux = $heightArray['optimalHeight'];
         $_SESSION['height'] = $heightAux;
  	}
	else
		// Error en el tamaño y tipo de imagen
		$mensajeFile = 'Verifique el tamaño y tipo de imagen, recuerde que recibimos solo archivos .jpg o .png. Y archivos no tan pesados.';
					
}
else
	// Error en las dimensiones de la imagen
	$mensajeFile = 'Verifique las dimensiones de la imagen, recuerde que las dimensiones minimas son de '.minWidth.'x'.minHeight.' pixeles.';

$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $mensajeFile,
					"fileName" => $OutputFile);
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
