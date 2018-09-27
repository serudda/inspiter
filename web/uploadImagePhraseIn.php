<?php
error_reporting(0);
require_once 'clases/Session.php';
require_once 'clases/User.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
ini_set('memory_limit','1280000M');
session_start();
$User1 = User::getUser($_SESSION['iduser']);
define("maxUpload", 5000000);
define("maxWidth", 5000);
define("maxHeight", 5000);
define("minWidth", 300);
define("minHeight", 200);
define("imagedirectory", '../images/PhraseIns/');

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
 if (isset($_SESSION['filenamePhIm']) && $_SESSION['filenamePhIm'] != '')
 {
   try
   { 
     $urlImagejpg = imagedirectory.$_SESSION['filenamePhIm'].".jpg";
     $urlImagepng = imagedirectory.$_SESSION['filenamePhIm'].".png";
     $urlImageJPG = imagedirectory.$_SESSION['filenamePhIm'].".JPG";
     $urlImagePNG = imagedirectory.$_SESSION['filenamePhIm'].".PNG";
     
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

$UserNameToFile = $User1->getUserLogin();
$numeroRand = rand(1000,1000000000);
//$UserNameToFile = $User1->getUserLogin();
$fileName = $UserNameToFile.'_'.$numeroRand;

// Tipos MIME $fileType = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/JPG','image/JPEG','image/PJPEG','image/PNG');
$fileType = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/JPG','image/JPEG','image/PJPEG','image/PNG');

// Bandera para procesar imagen
$pasaImgSize = false;

//bandera de error al procesar la imagen
$respuestaFile = false;

// nombre por default de la imagen a subir
//$fileName = '';
// error del lado del servidor
$mensajeFile = 'ERROR EN EL SCRIPT';

// Obtenemos los datos del archivo
$tamanio = $_FILES['changePhraseImg']['size'];
$tipo = $_FILES['changePhraseImg']['type'];
$archivo = $_FILES['changePhraseImg']['name'];

// Tamaño de la imagen
$imageSize = getimagesize($_FILES['changePhraseImg']['tmp_name']);
						
// Verificamos la extensión del archivo independiente del tipo mime
$extension = explode('.',$_FILES['changePhraseImg']['name']);
$num = count($extension)-1;


// Creamos el nombre del archivo dependiendo la opción
$imgFile = $fileName.'.'.$extension[$num];
$_SESSION['filenamePhIm'] = $UserNameToFile.'_'.$numeroRand;
$_SESSION['extensionPhIm'] = $extension[$num];

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
		if(is_uploaded_file($_FILES['changePhraseImg']['tmp_name']))
		{
                        
                                
			if(move_uploaded_file($_FILES['changePhraseImg']['tmp_name'], imagedirectory.$imgFile))
			{
				$respuestaFile = 'done';
				$fileName = $imgFile;
				$mensajeFile = $imgFile;
                                
                                //para cambiar la extension a .jpg
                               /* $info = pathinfo($fileName);
                                $new_extension ='jpg';
                                $fileName = $info['filename'] . '.' . $new_extension;*/
                                
                                $resizeObj = new resize(imagedirectory.$imgFile);
                                
                                //resize la imagen en 430xundefined y lo guarda en la carpeta graphIns
                                
                                $resizeObj -> resizeImage(625, 625, 'landscape');
                                $resizeObj -> saveImage(imagedirectory.$fileName, 100);
                                
																//$size = GetImageSize($fileName);
																//$heightArray=$size[1]; 
																
                                $heightArray = $resizeObj->getDimensions(625, $imageSize[1], 'landscape');
                                
                                $heightAux = $heightArray['optimalHeight'];
                                
                                $_SESSION['heightPhIm'] = $heightAux;
                              
			}
			else
				// error del lado del servidor
				$mensajeFile = 'No se pudo subir el archivo';
		}
		else
			// error del lado del servidor
			$mensajeFile = 'No se pudo subir el archivo';
	}
	else
		// Error en el tamaño y tipo de imagen
		$mensajeFile = 'Verifique el tamaño y tipo de imagen, recuerde que recibimos solo archivos .jpg o .png. Y archivos no tan pesados.';
					
}
else
	// Error en las dimensiones de la imagen
	$mensajeFile = 'Verifique las dimensiones de la Imagen, recuerde que las dimensiones minimas son de '.minWidth.'x'.minHeight.' pixeles.';

$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $mensajeFile,
					"fileName" => $fileName);

echo json_encode($salidaJson);
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
