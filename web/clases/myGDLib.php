<?php
require_once 'Database.php';
class MyGDLib
{
  private $background;
  private $texts;
  private $layers;
  private $ALIGN_LEFT = "left";
  private $ALIGN_CENTER = "center";
  private $ALIGN_RIGHT = "right";
  private $flagInfoUser = null;
  private $infoFooter = null;
  private $avatarFooter = null;
  private $footerAvatarTop = null;
  private $footerAvatarLeft = null;
  private $filtro = "N";
   
  function __construct()
  {
    $this->texts = array();  
    $this->layers = array();
  }
 
  //Crea la imagen
  function create($fileName=NULL)
  {
    $picture = @imagecreatefromjpeg ($this->background);
    
    //insertamos marca de agua de footer (sombra y logo)
    $ruta_marca = '../images/footerPhraseGraph.jpg';
    $watermark = imagecreatefromjpeg($ruta_marca);
    $tamanyo_imagen = getimagesize($this->background);
    $tamanyo_marca = getimagesize($ruta_marca);    
    // Copy and merge
    $dest_x = $tamanyo_imagen[0] - $tamanyo_marca[0]; 
    $dest_y = $tamanyo_imagen[1] - $tamanyo_marca[1];
    imagecopymerge($picture, $watermark, $dest_x, $dest_y, 0, 0,$tamanyo_marca[0], $tamanyo_marca[1], 90);
    //fin marca de agua de footer (sombra y logo)  
    $dest_xx = 0; 
    $dest_yy = 0;
    if($this->flagInfoUser == 'Y')
    {
     $avatarFooterImage = $this->avatarFooter;
     $tamanyo_imagen = getimagesize($this->background);
     // Copy and merge
     $dest_xx = $this -> footerAvatarLeft; 
     $dest_yy = $this -> footerAvatarTop;
     imagecopymerge($picture, $avatarFooterImage, $dest_xx, $dest_yy, 0, 0,22, 22, 100);
    }
    
    if($this->filtro == 'Y')
    {imagefilter($picture, IMG_FILTER_MEAN_REMOVAL); }
    
    foreach($this->texts as $text) //Escribimos los textos que hemos ido añadiendo
    {
      $color = ImageColorAllocate ($picture, $text['r'], $text['g'], $text['b']);
      //nueva funcion
      $text_lines = explode("\n", $text['text']); // Supports manual line breaks!
      $lines = array();
      $line_widths = array();
      $largest_line_height = 0;
      foreach($text_lines as $block)
      {
        $current_line = ''; // Reset current line
        $words = explode(' ', $block); // Split the text into an array of single words
        $first_word = TRUE;
        $last_width = 0;
        for($i = 0; $i < count($words); $i++)
        {
           $item = $words[$i];
           $dimensions = imagettfbbox($text['size'], 0, $text['font'], $current_line . ($first_word ? '' : ' ') . $item);
           $line_width = $dimensions[2] - $dimensions[0];
           $line_height = $dimensions[1] - $dimensions[7] + $text['lineHeight'];
          
           if($line_height > $largest_line_height) 
              $largest_line_height = $line_height;
           
           if($line_width > $text['textwidth'] && !$first_word)
           {
             $lines[] = $current_line;
             $line_widths[] = $last_width ? $last_width : $line_width;
             $current_line = $item;
           }
           else
           {
             $current_line .= ($first_word ? '' : ' ') . $item;
           }
           if($i == count($words)-1)
           {
             $dimensions = imagettfbbox($text['size'], 0, $text['font'], $current_line);
             $line_widthNew = $dimensions[2] - $dimensions[0];
             $lines[] = $current_line;
             $line_widths[] = $line_widthNew;
             
            // $lines[] = $current_line;
            //$line_widths[] = $line_width;
           }
           $last_width = $line_width;
           $first_word = FALSE;
         }
         if($current_line)
         {
          $current_line = $item;
         }
        }
        $i = 0;
        foreach($lines as $line)
        {
          if($text['align'] == $this->ALIGN_CENTER)
          {
            $left_offset = ($text['textwidth'] - $line_widths[$i]) / 2;
          }
          else if($text['align'] == $this->ALIGN_RIGHT)
          {
             $left_offset = ($text['textwidth'] - $line_widths[$i]);
          }
          if($text['bold'] == 1)
          {
            $_x=array(1,0,1,0,-1,-1,1,0,-1);
            $_y=array(0,-1,-1,0,0,-1,1,1,1);        
            $gris   = imagecolorallocate($picture, 50, 50, 50);
            if($text['shadow'] == 1)
            {
              imagettftext($picture, $text['size'], 0, $text['x']+1+$left_offset, $text['y']+1+$largest_line_height + ($largest_line_height * $i), $gris, $text['font'], $line);
            }
            for($n=0;$n<=8;$n++)
            {
             imagettftext($picture, $text['size'], 0, $text['x']+$_x[$n]+$left_offset, $text['y']+$_y[$n]+$largest_line_height + ($largest_line_height * $i),$color,$text['font'], $line);
            }
          }
          else
          {
           if($text['shadow'] == 1)
           {
             $gris   = imagecolorallocate($picture, 50, 50, 50);
             imagettftext($picture, $text['size'], 0, $text['x']+1+$left_offset, $text['y']+1+$largest_line_height + ($largest_line_height * $i), $gris, $text['font'], $line);
           }
           imagettftext($picture, $text['size'], 0, $text['x']+$left_offset, $text['y']+$largest_line_height + ($largest_line_height * $i), $color, $text['font'], $line);
          }
          //imagettftext($picture, $size, 0, $text['x'] + $left_offset, $text['y'] + $largest_line_height + ($largest_line_height * $i), $text['color'], $text['font'], $line);
          $i++;
        }
        //return $largest_line_height * count($lines);
        /*fin nueva funcion*/
    }
    ob_start();
    imagejpeg($picture,null,100); 
      $jpg = ob_get_contents();
    ob_end_clean();
    file_put_contents($fileName, $jpg); 
 
    return $fileName;
  }
 
  //Establece la 'imagen base'
  function setBackground($bg) 
  {
    $this->background = $bg;
  }
  
  //Establece la informacion del usuario que creo la frase grafica
  function setFlagInfoUser($flagInfoUser) 
  {
    $this->flagInfoUser = $flagInfoUser;
  }
  
  //Establece la informacion del usuario que creo la frase grafica
  function setInfoFooter($infoFooter) 
  {
    $this->infoFooter = $infoFooter;
  }
  
   //Establece la imagen del usuario que que creo la frase grafica
  function setAvatarFooter($avatarFooter) 
  {
    $this->avatarFooter = $avatarFooter;
  }
  
  //Establece el top de la imagen del usuario que que creo la frase grafica
  function setFooterAvatarTop($footerAvatarTop) 
  {
    $this->footerAvatarTop = $footerAvatarTop;
  }
  
  //Establece el left de la imagen del usuario que que creo la frase grafica
  function setFooterAvatarLeft($footerAvatarLeft) 
  {
    $this->footerAvatarLeft = $footerAvatarLeft;
  }
  
  //Establece la 'imagen base'
  function setFiltro($filtro) 
  {
    $this->filtro = $filtro;
  }
  
 
 
  //Añade una línea de texto en unas coordenadas determinadas, en base a un código de color RGB y una determinada alineación ('L' para izquierda, 'C' para centrado y 'R' para derecha)
  function addText($x, $y, $font, $size, $text, $r, $g, $b, $align='C',$bold=0,$shadow=0,$textWidth=0,$lineHeight=0) 
  {
    $this->texts[] = array('x' => $x, 'y' => $y, 'font' => $font, 'size' => $size, 'text' => $text, 'r' => $r, 'g' => $g, 'b' => $b, 'align' => $align, 'bold' => $bold,'shadow' => $shadow, 'textwidth' => $textWidth, 'lineHeight' => $lineHeight);
  }

public function generate_gradient($width, $height, $colors, $direction='vertical', $invert=false)
{
  //Crear imagen
  $image = imagecreatetruecolor($width, $height);
  //Comprobar colores      
  $positions = array_keys($colors);
  if (!isset($colors[0]))//Usar el primer color
    $colors[0] = $colors[reset($positions)];
  if (!isset($colors[100]))
    $colors[1000] = $colors[end($positions)];
  //Calcular el número de líneas a dibujar
  $lines;
  switch ($direction)
  {
    case 'vertical':
      $lines = $height;
      break;
    case 'horizontal':
      $lines = $width;
      break;
    case 'diagonal':
      $lines = max($width, $height) * 2;
      break;
    case 'ellipse':
      $center_x = $width / 2;
      $center_y = $height / 2;
      $rh = $height > $width ? 1 : $width / $height;
      $rw = $width > $height ? 1 : $height / $width;
      $lines = min($width, $height);
      //Rellenar fondo
      list($r1, $g1, $b1) = $this->_hex2rgb($colors[100]);
      imagefill($image, 0, 0, imagecolorallocate($image, $r1, $g1, $b1));
      $invert = !$invert; //Es necesario para no tener que dibujar el degradado del revés
      break;
    case 'square':
    case 'rectangle':
      $lines = max($width, $height) / 2;
      $invert = !$invert; //Es necesario para no tener que dibujar el degradado del revés
      break;
    case 'diamond':
      $rh = $height > $width ? 1 : $width / $height;
      $rw = $width > $height ? 1 : $height / $width;
      $lines = min($width, $height);
      $invert = !$invert; //Es necesario para no tener que dibujar el degradado del revés
      break;
    }
    //Invertir colores
    if ($invert)
    {
      $invert_colors = array();
      foreach ($colors as $key => $value) 
      {
        $invert_colors[100 - $key] = $value;
      }
      $colors = $invert_colors;
    }
    ksort($colors);
    //Dibujar línea a línea
    $incr = 1;
    $color_change_positions = array_keys($colors);
    $end_color_progress = 0; //Forzar que en la primera iteración se seleccione el rango de colores
    for ($i = 0; $i < $lines; $i = $i + $incr)
    {
      //Escoger color
     $total_progress = 100 / $lines * $i;
     if ($total_progress >= $end_color_progress) 
     { 
       ////Cambiar de rango de colores
       //Buscar color inicial a partir del progreso total
       $j = intval($total_progress);
       do 
       {
         $color_index = array_search($j--, $color_change_positions);
       } while ($color_index === false && $j >= 0);
       //Obtener colores inicio y final para este rango
       $start_color_progress = $color_change_positions[$color_index];
       $start_color = $this->_hex2rgb($colors[$start_color_progress]);
       $end_color_progress = $color_change_positions[$color_index + 1];
       $end_color = $this->_hex2rgb($colors[$end_color_progress]);
      }
      $internal_progress = ($total_progress - $start_color_progress) / ($end_color_progress - $start_color_progress);
      $r = $start_color[0] + ($end_color[0] - $start_color[0]) * $internal_progress;
      $g = $start_color[1] + ($end_color[1] - $start_color[1]) * $internal_progress;
      $b = $start_color[2] + ($end_color[2] - $start_color[2]) * $internal_progress;
      $color = imagecolorallocate($image, $r, $g, $b);
      //Dibujar línea
      switch ($direction)
      {
       case 'vertical':
         imagefilledrectangle($image, 0, $i, $width, $i + $incr, $color);
         break;
       case 'horizontal':
         imagefilledrectangle($image, $i, 0, $i + $incr, $height, $color);
         break;
       case 'diagonal':
         imagefilledpolygon($image, array(
         $i, 0,
         $i + $incr, 0,
         0, $i + $incr,
         0, $i), 4, $color);
         break;
       case 'ellipse':
         imagefilledellipse($image, $center_x, $center_y, ($lines - $i) * $rh, ($lines - $i) * $rw, $color);
         break;
       case 'square':
       case 'rectangle':
         imagefilledrectangle($image, $i * $width / $height, $i * $height / $width, $width - ($i * $width / $height), $height - ($i * $height / $width), $color);
         break;
       case 'diamond':
         imagefilledpolygon($image, array(
         $width / 2, $i * $rw - 0.5 * $height,
         $i * $rh - 0.5 * $width, $height / 2,
         $width / 2, 1.5 * $height - $i * $rw,
         1.5 * $width - $i * $rh, $height / 2), 4, $color);
         break;
      }
    }
    return $image;
 }

 public function save_image($image, $path, $format='png', $quality=100) 
 {
    switch ($format) 
    {
       case 'jpg':
       case 'jpeg':
           return imagejpeg($image, $path, $quality);
       case 'gif':
           return imagegif($image, $path);
       default:
           imagesavealpha($image, true);
           return imagepng($image, $path, 9, PNG_ALL_FILTERS); //Compresión máxima
    }
 }
 /**
     * Convierte un color en formato html hexadecimal a formato array RGB
     * @param string $color Color en formato #ffffff o #fff
     * @return array */
 private function _hex2rgb($color) 
 {
  if (is_array($color))
     return $color;
  $color = str_replace('#', '', $color);
  $s = strlen($color) / 3;
  $rgb[] = hexdec(str_repeat(substr($color, 0, $s), 2 / $s));
  $rgb[] = hexdec(str_repeat(substr($color, $s, $s), 2 / $s));
  $rgb[] = hexdec(str_repeat(substr($color, 2 * $s, $s), 2 / $s));
  return $rgb;
 }
}
?>