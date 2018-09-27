<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
ini_set('memory_limit','1280000M');
session_start();
$User1 = User::getUser($_SESSION['iduser']);
// Definimos variables generales
define("maxUpload", 5000000);
define("maxWidth", 5000);
define("maxHeight", 5000);
define("minWidth", 100);
define("minHeight", 100);
define("imagedirectory", '../images/perfiles/data/');
define("imagedirectorySmall", '../images/perfiles/smallMenu/');

function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}

if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
{

$UserNameToFile = $User1->getUserLogin();

if (isset($_SESSION['filename']) && $_SESSION['filename'] != '')
{
  try
  { 
     $urlImagejpg = imagedirectory.$_SESSION['filename'].".jpg";
     $urlImagepng = imagedirectory.$_SESSION['filename'].".png";
     $urlImageJPG = imagedirectory.$_SESSION['filename'].".JPG";
     $urlImagePNG = imagedirectory.$_SESSION['filename'].".PNG";
     
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
$numeroRand = rand(1000,1000000000);
$fileName = $UserNameToFile.'_'.$numeroRand;


if(isset($_POST['urlFaceImage']))
{
    $img = file_get_contents($_POST['urlFaceImage']);
    $file = '../images/perfiles/data/'.$fileName.'.jpg';
    file_put_contents($file, $img);
    $_SESSION['filename'] = $UserNameToFile.'_'.$numeroRand;
    $imgFile = $fileName.'.jpg';
    
    $resizeObj = new resize(imagedirectory.$imgFile);
    $resizeObj -> resizeImage(275, 275, 'crop');
    $resizeObj -> saveImage(imagedirectory.$imgFile, 100);
    $heightArray = $resizeObj->getDimensions(275, 275, 'crop');
    $heightAux = $heightArray['optimalHeight'];
    $_SESSION['height'] = $heightAux;
    
 
    echo $imgFile;
}
else
{
  // Tipos MIME
  $fileType = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/JPG','image/JPEG','image/PJPEG','image/PNG');

  // Bandera para procesar imagen
  $pasaImgSize = false;

  //bandera de error al procesar la imagen
  $respuestaFile = false;
  $mensajeFile = 'ERROR EN EL SCRIPT';

  // Obtenemos los datos del archivo
  $tamanio = $_FILES['userfile']['size'];
  $tipo = $_FILES['userfile']['type'];
  $archivo = $_FILES['userfile']['name'];

  // Tamaño de la imagen
  $imageSize = getimagesize($_FILES['userfile']['tmp_name']);						

  // Verificamos la extensión del archivo independiente del tipo mime
  $extension = explode('.',$_FILES['userfile']['name']);
  $num = count($extension)-1;

  //Creamos el nombre del archivo dependiendo la opción
  $imgFile = $fileName.'.'.$extension[$num];
  $_SESSION['filename'] = $UserNameToFile.'_'.$numeroRand;
  $_SESSION['extension'] = $extension[$num];

  // Verificamos el tamaño válido para los logotipos
  if($imageSize[0] <= maxWidth && $imageSize[1] <= maxHeight && $imageSize[0] >= minWidth && $imageSize[1] >= minHeight)
  $pasaImgSize = true;

  // Verificamos el status de las dimensiones de la imagen a publicar
  if($pasaImgSize == true)
  {
    // Verificamos Tamaño y extensiones
    if(in_array($tipo, $fileType) && $tamanio>0 && $tamanio<=maxUpload && ($extension[$num]=='jpg' || $extension[$num]=='png' || $extension[$num]=='JPG' || $extension[$num]=='PNG'))
    {
 	// Intentamos copiar el archivo
	if(is_uploaded_file($_FILES['userfile']['tmp_name']))
	{
            if(move_uploaded_file($_FILES['userfile']['tmp_name'], imagedirectory.$imgFile))
    	    {
		$respuestaFile = 'done';
		$fileName = $imgFile;
		$mensajeFile = $imgFile;

                //para cambiar la extension a .jpg
               /* $info = pathinfo($fileName);
                $new_extension ='jpg';
                $fileName = $info['filename'].'.'.$new_extension;*/
                
                $resizeObj = new resize(imagedirectory.$imgFile);
                //resize la imagen en 275x275 y lo guarda en la carpeta data
                $resizeObj -> resizeImage(275, 275, 'crop');
                $resizeObj -> saveImage(imagedirectory.$fileName, 100);
                $heightArray = $resizeObj->getDimensions(275, $imageSize[1], 'crop');
                $heightAux = $heightArray['optimalHeight'];
                $_SESSION['height'] = $heightAux;
             }
	     else
	         $mensajeFile = 'No se pudo subir el archivo';
	 }
	 else
	   $mensajeFile = 'No se pudo subir el archivo';
    }
    else
      $mensajeFile = 'Verifique el tamaño y tipo de imagen, recuerde que recibimos solo archivos .jpg o .png. Y archivos no tan pesados.';
}
else
 $mensajeFile = 'Verifique las dimensiones de la Imagen, recuerde que las dimensiones minimas son de '.minWidth.'x'.minHeight.' pixeles.';
 $salidaJson = array("respuesta" => $respuestaFile,
 		     "mensaje" => $mensajeFile,
	             "fileName" => $fileName);
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