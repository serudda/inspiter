<?php
//Thumbnail sample
/*include ('Thumbnail.class.php');

$thumb=new Thumbnail("source.jpg");	        // Contructor and set source image file

//$thumb->memory_limit='32M';               //[OPTIONAL] set maximun memory usage, default 32 MB ('32M'). (use '16M' or '32M' for litter images)
//$thumb->max_execution_time='30';             //[OPTIONAL] set maximun execution time, default 30 seconds ('30'). (use '60' for big images o slow server)

/*
$thumb->quality=85;                         // [OPTIONAL] default 75 , only for JPG format
$thumb->output_format='JPG';                // [OPTIONAL] JPG | PNG
$thumb->jpeg_progressive=0;               // [OPTIONAL] set progressive JPEG : 0 = no , 1 = yes
$thumb->allow_enlarge=false;              // [OPTIONAL] allow to enlarge the thumbnail
//$thumb->CalculateQFactor(10000);          // [OPTIONAL] Calculate JPEG quality factor for a specific size in bytes
//$thumb->bicubic_resample=false;             // [OPTIONAL] set resample algorithm to bicubic
*/

$thumb->img_watermark='watermark.png';	    // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]

/*
$thumb->img_watermark_Valing='TOP';   	    // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTON
$thumb->img_watermark_Haling='LEFT';   	    // [OPTIONAL] set watermark horizonatal position, LEFT | CENTER | RIGHT

$thumb->txt_watermark='Watermark Text';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='FF0000';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=5;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='BOTTOM';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='RIGHT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->txt_watermark_Hmargin=10;           // [OPTIONAL] set watermark text horizonatal margin in pixels
$thumb->txt_watermark_Vmargin=10;           // [OPTIONAL] set watermark text vertical margin in pixels

$thumb->size_width(150);				    // [OPTIONAL] set width for thumbnail, or
$thumb->size_height(113);				    // [OPTIONAL] set height for thumbnail, or
$thumb->size_auto(150);					    // [OPTIONAL] set the biggest width or height for thumbnail


$thumb->size(150,113);		            // [OPTIONAL] set the biggest width and height for thumbnail

$thumb->process();   				        // generate image

$thumb->show();						        // show your thumbnail, or

//$thumb->save("thumbnail.".$thumb->output_format);			// save your thumbnail to file, or
//$image = $thumb->dump();                  // get the image

//echo ($thumb->error_msg);                 // print Error Mensage

*/

//Thumbnail sample: generate thumbnail + watermark and save to a file with a unique filename 

include ('web/clases/Thumbnail.class.php');  

$thumb=new Thumbnail("images/ariel-valles.png");            // Contructor and set source image file 
$thumb->img_watermark='images/favicon.png';        // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ] 
$thumb->img_watermark_Valing='TOP';   	    // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTON
$thumb->img_watermark_Haling='LEFT';   	    // [OPTIONAL] set watermark horizonatal position, LEFT | CENTER | RIGHT

$thumb->txt_watermark='Inspiter';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='000000';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=25;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='BOTTOM';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='RIGHT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->txt_watermark_Hmargin=10;           // [OPTIONAL] set watermark text horizonatal margin in pixels
$thumb->txt_watermark_Vmargin=10;           // [OPTIONAL] set watermark text vertical margin in pixels

$thumb->size_width(150);				    // [OPTIONAL] set width for thumbnail, or
$thumb->size_height(113);				    // [OPTIONAL] set height for thumbnail, or
$thumb->size_auto(150);	
$thumb->size(500,353);                        // [OPTIONAL] set the biggest width and height for thumbnail 
$thumb->process();                           // generate image 
$filename=$thumb->unique_filename ( '.' , 'sample.jpg' , 'thumb');  // generate unique filename 
$status=$thumb->save($filename);            // save your thumbnail to file 
if ($status) { 
    echo('Thumbnail save as '.$filename); 
} else { 
    echo('ERROR: '.$thumb->error_msg); 
} 

?>


<?php
/*header("Content-type: image/png");
require_once 'web/clases/resize-class.php';

$cadena = "Ariel Valles";
$im     = imagecreatefrompng("images/ariel-valles.png");
$naranja = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($cadena)) / 2;
imagestring($im, 3, $px, 9, $cadena, $naranja);
//$myfImageSmall = "../images/perfiles/avatar-inspiter.jpg";
//$contentsSmall = file_get_contents($myfImageSmall);
$imagedirectory = 'images/images/arielvalles.png';
$savefile = fopen($imagedirectory, 'w');
fwrite($savefile, $im);
fclose($savefile);

echo '<img src="images/images/arielvalles.png">';
/*
// Crear una imagen de 300x100
$im = imagecreatetruecolor(300, 100);
$rojo = imagecolorallocate($im, 0xFF, 0x00, 0x00);
$negro = imagecolorallocate($im, 0x00, 0x00, 0x00);

// Hacer el fondo rojo
imagefilledrectangle($im, 0, 0, 299, 99, $rojo);

// Ruta a nuestro archivo de fuente ttf
$archivo_fuente = 'fonts/DIN Medium.ttf';

// Dibuja el texto 'PHP Manual' usando un tamaño de fuente de 13
imagefttext($im, 13, 0, 105, 55, $negro, null, 'Ariel Valles');

// Imprimir la imagen al navegador
header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);  
 */
?>