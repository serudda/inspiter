<?php
error_reporting(0);

header("Content-type: image/png");
$cadena = $_GET['texto'];
$im     = imagecreatefrompng("images/ariel-valles23.png");
$naranja = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($cadena)) / 2;
imagestring($im, 3, $px, 9, $cadena, $naranja);
imagepng($im);
imagedestroy($im);

?>