<?php
error_reporting(0);
require_once 'clases/Image.php';
require_once 'clases/Session.php';
require_once 'clases/resize-class.php';
require_once 'clases/Token.php';
require_once 'clases/myGDLib.php';
session_start();

if(!isset($_SESSION['iduser']) || $_SESSION['iduser'] == '')
{
  if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
  {
    $_SESSION['iduser']=$_COOKIE['iduser'];
  }
}

function stripslashes_deep ($text, $times) 
{
  $i = 0;
  while (strstr($text, '\\') && $i != $times) 
  {
    $text= stripslashes($text);
    $i++;
  }
  return $text;
}
function getToken()
{
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
}

function getArrayColor($colorRGB)
{
    $arr = explode(',', $colorRGB);
    $colores = array(substr($arr[0],4),$arr[1],substr($arr[2],0,-1));
    return $colores;
}

function getFontName($fontFamily)
{
  if($fontFamily == 'arial')
      return 'arial.ttf';
  else if($fontFamily == 'asombro')
      return 'Asombro.ttf';
  else if($fontFamily == 'calibri')
      return 'CALIBRI.TTF';
  else if($fontFamily == 'courier')
      return 'COUR.TTF';
  else if(strrpos($fontFamily, "comic") !== false)  
      return 'COMIC.TTF';
  else if($fontFamily ==  'futura')
      return 'Futura.ttf';
  else if($fontFamily == 'handsean')
      return 'HandSean.ttf';
  else if($fontFamily == 'impact')
      return 'IMPACT.TTF';
  else if($fontFamily == 'jennasue')
      return 'JennaSue.ttf';
  else if($fontFamily == 'jellyka')
      return 'Jellyka.ttf';
  else if(strrpos($fontFamily,'lucidasans') !== false)
      return 'LSANS.TTF';
  else if($fontFamily == 'motion')
      return 'Motion.ttf';
  else if($fontFamily == 'passingnotes')
      return 'Passing Notes.ttf';
  else if(strrpos($fontFamily,'timesnewroman') !== false)
      return 'TIMES.TTF';
  else if($fontFamily == 'vampire')
       return 'VAMPIRE_.TTF';
  else  return 'VERDANA.TTF';
}

function wrap($fontSize, $angle, $fontFace, $string, $width)
{
  $ret = "";
  $arr = explode(' ', $string);
  foreach ( $arr as $word )
  {
    $teststring = $ret.' '.$word;
    $testbox = imagettfbbox($fontSize, $angle, $fontFace, $teststring);
    if ( $testbox[2]-$testbox[0] > $width )
    {
      $ret.=($ret==""?"":"\n").$word;
    }
    else
    {
      $ret.=($ret==""?"":' ').$word;
    }
   } 
   return $ret;
}

function getPodium($urlImage, $file, $filtro, $flagInfoUser, $infoFooter, $footerInfoTop, $footerInfoLeft, $avatarFooter, $footerAvatarTop, $footerAvatarLeft, $phrase, $colorPhrase, $fontFamilyPhrase, $fontSizePhrase, $fontWeightPhrase,
                   $fontStylePhrase,$textAlignPhrase, $textShadowPhrase, $phraseTop, $phraseLeft,
                   $author,$colorAuthor, $fontFamilyAuthor, $fontSizeAuthor, $fontWeightAuthor,
                   $fontStyleAuthor, $textAlignAuthor, $textShadowAuthor, $authorTop, $authorLeft)
{
  $myGDLibObj = new MyGDLib(); 
  $myGDLibObj->setBackground($urlImage); //Establezco imagen base  
  $myGDLibObj->setFlagInfoUser($flagInfoUser); //Establece una bandera que indica si va la info del user en la imagen o no
  $myGDLibObj->setInfoFooter($infoFooter); //Establece la info del usuario que creo la imagen
  $myGDLibObj->setAvatarFooter($avatarFooter); //Establece la imagen del usuario que creo la imagen
  $myGDLibObj->setFooterAvatarTop($footerAvatarTop);
  $myGDLibObj->setFooterAvatarLeft($footerAvatarLeft);
  $myGDLibObj->setFiltro($filtro); //Establezco filtro
  
  /*********SOBRE LA FRASE*********/
  $bold = 0;
  if($fontWeightPhrase == 'bold')
    $bold = 1; 
  $italic = 0;
  if($fontStylePhrase == 'italic')
    $italic = 1;
  $shadow = 0;
  if($textShadowPhrase != null && $textShadowPhrase != 'none')
    $shadow = 1;
  
  $fontSizeText = 20;
  $lineHeight = 0;
  if($fontFamilyPhrase == 'arial.ttf')
  {
    if($fontSizePhrase == 15)
    {$fontSizeText = $fontSizePhrase - 4;}   
    else if($fontSizePhrase == 20)
    {$fontSizeText = $fontSizePhrase - 5;}  
    else if($fontSizePhrase == 25)
    {$fontSizeText = $fontSizePhrase - 6;}  
    else if($fontSizePhrase == 30)
    {$fontSizeText = $fontSizePhrase - 7;}  
    else if($fontSizePhrase == 35)
    {$fontSizeText = $fontSizePhrase - 8;}  
    else if($fontSizePhrase == 40)
    {$fontSizeText = $fontSizePhrase - 9;}  
    else if($fontSizePhrase == 45)
    {$fontSizeText = $fontSizePhrase - 9;}  
    else if($fontSizePhrase == 50)
    {$fontSizeText = $fontSizePhrase - 10;}  
    else if($fontSizePhrase == 55)
    {$fontSizeText = $fontSizePhrase - 10;}  
    else if($fontSizePhrase == 60)
    {$fontSizeText = $fontSizePhrase - 11;}  
    else if($fontSizePhrase == 65)
    {$fontSizeText = $fontSizePhrase - 11;}  
    else if($fontSizePhrase == 70)
    {$fontSizeText = $fontSizePhrase - 12;}  
    else if($fontSizePhrase == 75)
    {$fontSizeText = $fontSizePhrase - 13;}  
    else if($fontSizePhrase == 80)
    {$fontSizeText = $fontSizePhrase - 13;}  
    else if($fontSizePhrase == 85)
    {$fontSizeText = $fontSizePhrase - 14;}  
    else if($fontSizePhrase == 90)
    {$fontSizeText = $fontSizePhrase - 15;}  
    else if($fontSizePhrase == 95)
    {$fontSizeText = $fontSizePhrase - 16;}  
    else if($fontSizePhrase == 100)
    {$fontSizeText = $fontSizePhrase - 17;}  
    else 
    {$fontSizeText = $fontSizePhrase - 23;}  
  }
  else if($fontFamilyPhrase == 'Asombro.ttf')
  {
    if($fontSizePhrase == 15)
    {$fontSizeText = $fontSizePhrase - 4;}   
    else if($fontSizePhrase == 20)
    {$fontSizeText = $fontSizePhrase - 6;}  
    else if($fontSizePhrase == 25)
    {$fontSizeText = $fontSizePhrase - 7;}  
    else if($fontSizePhrase == 30)
    {$fontSizeText = $fontSizePhrase - 8;}  
    else if($fontSizePhrase == 35)
    {$fontSizeText = $fontSizePhrase - 9;}  
    else if($fontSizePhrase == 40)
    {$fontSizeText = $fontSizePhrase - 10;}  
    else if($fontSizePhrase == 45)
    {$fontSizeText = $fontSizePhrase - 11;}  
    else if($fontSizePhrase == 50)
    {$fontSizeText = $fontSizePhrase - 12;}  
    else if($fontSizePhrase == 55)
    {$fontSizeText = $fontSizePhrase - 13;}  
    else if($fontSizePhrase == 60)
    {$fontSizeText = $fontSizePhrase - 14;}  
    else if($fontSizePhrase == 65)
    {$fontSizeText = $fontSizePhrase - 15;}  
    else if($fontSizePhrase == 70)
    {$fontSizeText = $fontSizePhrase - 16;}  
    else if($fontSizePhrase == 75)
    {$fontSizeText = $fontSizePhrase - 17;}  
    else if($fontSizePhrase == 80)
    {$fontSizeText = $fontSizePhrase - 18;}  
    else if($fontSizePhrase == 85)
    {$fontSizeText = $fontSizePhrase - 19;}  
    else if($fontSizePhrase == 90)
    {$fontSizeText = $fontSizePhrase - 20;}  
    else if($fontSizePhrase == 95)
    {$fontSizeText = $fontSizePhrase - 21;}  
    else if($fontSizePhrase == 100)
    {$fontSizeText = $fontSizePhrase - 22;}  
    else 
    {$fontSizeText = $fontSizePhrase - 23;}  
  }
  else if($fontFamilyPhrase == 'CALIBRI.TTF')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 3;
     $lineHeight = 6;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 7;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 8;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 9;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 10;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 11;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 12;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 13;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 14;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 15;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 16;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 17;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 18;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 19;
    }  
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 20;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 21;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 22;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 23;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 26;
    }  
  }
  else if($fontFamilyPhrase == 'COUR.TTF')
  {
      if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 0;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 1;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 2;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 3;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 4;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 5;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 6;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 7;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 8;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 10;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 11;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 12;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 13;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 14;
    }  
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 15;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 16;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 17;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 18;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 19;
    }  
  } //fin courier
  else if($fontFamilyPhrase == 'COMIC.TTF')  
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 3;
     $lineHeight = 6;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 7;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 8;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 9;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 10;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 11;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 12;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 13;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 14;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 15;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 16;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 17;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 18;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 19;
    }  
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 20;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 21;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 22;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 23;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 23;
     $lineHeight = 24;
    } 
  }  //fin de comic sanz
  else if($fontFamilyPhrase == 'HandSean.ttf')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 3;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 4;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 5;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 6;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 7;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 8;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 9;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 10;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 11;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 12;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 13;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 14;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 15;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 16;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 17;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 18;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 19;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 20;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 21;
    }
  }//fin handsean
  else if($fontFamilyPhrase == 'IMPACT.TTF')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 3;
     $lineHeight = 5;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 6;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 7;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 8;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 9;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 10;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 11;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 12;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 13;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 14;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 15;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 16;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 17;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 18;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 19;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 20;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 21;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 22;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 23;
    }
  }//fin impact
  else if($fontFamilyPhrase == 'JennaSue.ttf')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 10;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 23;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 50;
    }
  } //fin jennaSue
  else if($fontFamilyPhrase == 'Jellyka.ttf')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 3;
     $lineHeight = 0;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 0;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = -4;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = -10;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = -15;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = -10;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = -15;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = -18;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = -18;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = -20;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 23;
     $lineHeight = -22;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = -22;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = -28;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = -29;
     //$phraseTop = $phraseTop - 50;
    }  
    else if($fontSizePhrase == 105)
    {
     $fontSizeText = $fontSizePhrase - 26;
     $lineHeight = -29;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 110)
    {
     $fontSizeText = $fontSizePhrase - 27;
     $lineHeight = -32;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 115)
    {
     $fontSizeText = $fontSizePhrase - 26;
     $lineHeight = -33;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 120)
    {
     $fontSizeText = $fontSizePhrase - 31;
     $lineHeight = -33;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 125)
    {
     $fontSizeText = $fontSizePhrase - 32;
     $lineHeight = -35;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 130)
    {
     $fontSizeText = $fontSizePhrase - 34;
     $lineHeight = -40;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 135)
    {
     $fontSizeText = $fontSizePhrase - 33;
     $lineHeight = -27;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 140)
    {
     $fontSizeText = $fontSizePhrase - 35;
     $lineHeight = -40;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 145)
    {
     $fontSizeText = $fontSizePhrase - 35;
     $lineHeight = -44;
     //$phraseTop = $phraseTop - 50;
    }
    else if($fontSizePhrase == 150)
    {
     $fontSizeText = $fontSizePhrase - 35;
     $lineHeight = -44;
     //$phraseTop = $phraseTop - 50;
    } 
  }//fin Jellyka
  else if($fontFamilyPhrase == 'LSANS.TTF')
  {
      if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 4;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60) //bien
    {
     $fontSizeText = $fontSizePhrase - 13; 
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 50;
    }
  }//fin lucida sans
  else if($fontFamilyPhrase == 'Motion.ttf')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 4;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 13;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60) //bien
    {
     $fontSizeText = $fontSizePhrase - 14; 
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 15;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 10;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 24;
     $lineHeight = 11;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 26;
     $lineHeight = 12;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 27;
     $lineHeight = 13;
     //$phraseTop = $phraseTop - 50;
    }
  }//fin motion
  else if($fontFamilyPhrase == 'Passing Notes.ttf')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 3;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60) //bien
    {
     $fontSizeText = $fontSizePhrase - 14; 
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 23;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 24;
     $lineHeight = 14;
     //$phraseTop = $phraseTop - 50;
    }
  }//fin passing notes
  else if($fontFamilyPhrase == 'TIMES.TTF')
  {
    if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 2;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 2;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 6;
     $lineHeight = 2;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 2;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60) //bien
    {
     $fontSizeText = $fontSizePhrase - 13; 
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 14;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 11;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 11;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 12;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 13;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 14;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 15;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 15;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 17;
     //$phraseTop = $phraseTop - 50;
    }
  } //fin times new roman
  else  
  {
      if($fontSizePhrase == 15)
    {
     $fontSizeText = $fontSizePhrase - 4;
     $lineHeight = 3;
     //$phraseTop = $phraseTop;
    }   
    else if($fontSizePhrase == 20)
    {
     $fontSizeText = $fontSizePhrase - 5;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 12;
    }  
    else if($fontSizePhrase == 25)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 3;
     //$phraseTop = $phraseTop - 13;
    }  
    else if($fontSizePhrase == 30)
    {
     $fontSizeText = $fontSizePhrase - 7;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 14;
    }  
    else if($fontSizePhrase == 35)
    {
     $fontSizeText = $fontSizePhrase - 8;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 15;
    }  
    else if($fontSizePhrase == 40)
    {
     $fontSizeText = $fontSizePhrase - 9;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 16;
    }  
    else if($fontSizePhrase == 45)
    {
     $fontSizeText = $fontSizePhrase - 10;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 17;
    }  
    else if($fontSizePhrase == 50)
    {
     $fontSizeText = $fontSizePhrase - 11;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 18;
    }  
    else if($fontSizePhrase == 55)
    {
     $fontSizeText = $fontSizePhrase - 12;
     $lineHeight = 4;
     //$phraseTop = $phraseTop - 19;
    }  
    else if($fontSizePhrase == 60) //bien
    {
     $fontSizeText = $fontSizePhrase - 14; 
     $lineHeight = 5;
     //$phraseTop = $phraseTop - 20;
    }  
    else if($fontSizePhrase == 65)
    {
     $fontSizeText = $fontSizePhrase - 16;
     $lineHeight = 6;
     //$phraseTop = $phraseTop - 24;
    }  
    else if($fontSizePhrase == 70)
    {
     $fontSizeText = $fontSizePhrase - 17;
     $lineHeight = 7;
     //$phraseTop = $phraseTop - 28;
    }  
    else if($fontSizePhrase == 75)
    {
     $fontSizeText = $fontSizePhrase - 18;
     $lineHeight = 8;
     //$phraseTop = $phraseTop - 32;
    }  
    else if($fontSizePhrase == 80)
    {
     $fontSizeText = $fontSizePhrase - 19;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 36;
    } 
    else if($fontSizePhrase == 85)
    {
     $fontSizeText = $fontSizePhrase - 20;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 40;
    }  
    else if($fontSizePhrase == 90)
    {
     $fontSizeText = $fontSizePhrase - 21;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 44;
    }  
    else if($fontSizePhrase == 95)
    {
     $fontSizeText = $fontSizePhrase - 22;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 46;
    }  
    else if($fontSizePhrase == 100)
    {
     $fontSizeText = $fontSizePhrase - 23;
     $lineHeight = 9;
     //$phraseTop = $phraseTop - 50;
    }  
    else 
    {
     $fontSizeText = $fontSizePhrase - 24;
     $lineHeight = 14;
     //$phraseTop = $phraseTop - 50;
    }
  }
  $fontFamilyPhraseURL = '../fonts/'.$fontFamilyPhrase;
  if($italic == 0)
    $fontFamilyPhraseURL = '../fonts/'.$fontFamilyPhrase;
  else
  {
      $fontFamilyPhraseURL = '../fonts/italic/'.$fontFamilyPhrase;
      $bandExistCursiva = 0;
      if (file_exists($fontFamilyPhraseURL))
      {
         $bandExistCursiva = 1;
      }
      else
      {
         $fontFamilyPhraseURL = '../fonts/'.$fontFamilyPhrase; 
      }
  }
 
      
  $myGDLibObj->addText($phraseLeft, $phraseTop, '../fonts/'.$fontFamilyPhraseURL, $fontSizeText, $phrase, $colorPhrase[0], $colorPhrase[1], $colorPhrase[2], $textAlignPhrase, $bold, $shadow, 530, $lineHeight);  
  /*********FIN SOBRE LA FRASE*********/
  
  /*********SOBRE EL AUTOR************/
  $boldAuthor = 0;
  if($fontWeightAuthor == 'bold')
     $boldAuthor = 1; 
  $italicAuthor = 0;
  if($fontStyleAuthor == 'italic')
    $italicAuthor = 1;
  $shadowAuthor = 0;
  if($textShadowAuthor != null && $textShadowAuthor != 'none')
    $shadowAuthor = 1;
   
  $fontSizeText = 20;
  $lineHeight = 0;
  if($fontFamilyAuthor == 'arial.ttf')
  {
    if($fontSizeAuthor == 15)
    {$fontSizeText = $fontSizeAuthor - 5;}   
    else if($fontSizeAuthor == 20)
    {$fontSizeText = $fontSizeAuthor - 6;}  
    else if($fontSizeAuthor == 25)
    {$fontSizeText = $fontSizeAuthor - 7;}  
    else if($fontSizeAuthor == 30)
    {$fontSizeText = $fontSizeAuthor - 8;}  
    else if($fontSizeAuthor == 35)
    {$fontSizeText = $fontSizeAuthor - 9;}  
    else if($fontSizeAuthor == 40)
    {$fontSizeText = $fontSizeAuthor - 10;}  
    else if($fontSizeAuthor == 45)
    {$fontSizeText = $fontSizeAuthor - 11;}  
    else if($fontSizeAuthor == 50)
    {$fontSizeText = $fontSizeAuthor - 12;}  
    else if($fontSizeAuthor == 55)
    {$fontSizeText = $fontSizeAuthor - 13;}  
    else if($fontSizeAuthor == 60)
    {$fontSizeText = $fontSizeAuthor - 14;}  
    else if($fontSizeAuthor == 65)
    {$fontSizeText = $fontSizeAuthor - 15;}  
    else if($fontSizeAuthor == 70)
    {$fontSizeText = $fontSizeAuthor - 16;}  
    else if($fontSizeAuthor == 75)
    {$fontSizeText = $fontSizeAuthor - 17;}  
    else if($fontSizeAuthor == 80)
    {$fontSizeText = $fontSizeAuthor - 18;}  
    else if($fontSizeAuthor == 85)
    {$fontSizeText = $fontSizeAuthor - 19;}  
    else if($fontSizeAuthor == 90)
    {$fontSizeText = $fontSizeAuthor - 20;}  
    else if($fontSizeAuthor == 95)
    {$fontSizeText = $fontSizeAuthor - 21;}  
    else if($fontSizeAuthor == 100)
    {$fontSizeText = $fontSizeAuthor - 22;}  
    else 
    {$fontSizeText = $fontSizeAuthor - 23;}  
  }
  else if($fontFamilyAuthor == 'Asombro.ttf')
  {
    if($fontSizeAuthor == 15)
    {$fontSizeText = $fontSizeAuthor - 4;}   
    else if($fontSizeAuthor == 20)
    {$fontSizeText = $fontSizeAuthor - 6;}  
    else if($fontSizeAuthor == 25)
    {$fontSizeText = $fontSizeAuthor - 7;}  
    else if($fontSizeAuthor == 30)
    {$fontSizeText = $fontSizeAuthor - 8;}  
    else if($fontSizeAuthor == 35)
    {$fontSizeText = $fontSizeAuthor - 9;}  
    else if($fontSizeAuthor == 40)
    {$fontSizeText = $fontSizeAuthor - 10;}  
    else if($fontSizeAuthor == 45)
    {$fontSizeText = $fontSizeAuthor - 11;}  
    else if($fontSizeAuthor == 50)
    {$fontSizeText = $fontSizeAuthor - 12;}  
    else if($fontSizeAuthor == 55)
    {$fontSizeText = $fontSizeAuthor - 13;}  
    else if($fontSizeAuthor == 60)
    {$fontSizeText = $fontSizeAuthor - 14;}  
    else if($fontSizeAuthor == 65)
    {$fontSizeText = $fontSizeAuthor - 15;}  
    else if($fontSizeAuthor == 70)
    {$fontSizeText = $fontSizeAuthor - 16;}  
    else if($fontSizeAuthor == 75)
    {$fontSizeText = $fontSizeAuthor - 17;}  
    else if($fontSizeAuthor == 80)
    {$fontSizeText = $fontSizeAuthor - 18;}  
    else if($fontSizeAuthor == 85)
    {$fontSizeText = $fontSizeAuthor - 19;}  
    else if($fontSizeAuthor == 90)
    {$fontSizeText = $fontSizeAuthor - 20;}  
    else if($fontSizeAuthor == 95)
    {$fontSizeText = $fontSizeAuthor - 21;}  
    else if($fontSizeAuthor == 100)
    {$fontSizeText = $fontSizeAuthor - 22;}  
    else 
    {$fontSizeText = $fontSizeAuthor - 23;}  
  }
  else if($fontFamilyAuthor == 'CALIBRI.TTF')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 3;
     $lineHeight = 6;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 16;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 18;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 19;
    }  
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 20;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 21;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 22;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 23;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 26;
    }  
  }
  else if($fontFamilyAuthor == 'COUR.TTF')
  {
      if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 0;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 1;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 2;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 16;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 18;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 19;
    }  
  } //fin courier
  else if($fontFamilyAuthor == 'COMIC.TTF')  
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 3;
     $lineHeight = 6;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 16;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 18;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 19;
    }  
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 20;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 21;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 22;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 23;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 23;
     $lineHeight = 24;
    } 
  }  //fin de comic sanz
  else if($fontFamilyAuthor == 'HandSean.ttf')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 3;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 16;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 18;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 19;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 20;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 21;
    }
  }//fin handsean
  else if($fontFamilyAuthor == 'IMPACT.TTF')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 3;
     $lineHeight = 5;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 16;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 18;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 19;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 20;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 21;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 22;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 23;
    }
  }//fin impact
  else if($fontFamilyAuthor == 'Jellyka.ttf')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 3;
     $lineHeight = 0;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 0;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 12;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 15;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 16;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 17;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 18;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 19;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 23;
     $lineHeight = 20;
    }
  }//fin Jellyka
  else if($fontFamilyAuthor == 'LSANS.TTF')
  {
      if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 4;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 13; 
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 9;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 10;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 10;
    }
  }//fin lucida sans
  else if($fontFamilyAuthor == 'Motion.ttf')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 4;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 13;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 14; 
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 15;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 8;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 10;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 24;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 26;
     $lineHeight = 12;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 27;
     $lineHeight = 13;
    }
  }//fin motion
  else if($fontFamilyAuthor == 'Passing Notes.ttf')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 3;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 14; 
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 9;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 23;
     $lineHeight = 9;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 24;
     $lineHeight = 14;
    }
  }//fin passing notes
  else if($fontFamilyAuthor == 'TIMES.TTF')
  {
    if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 2;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 2;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 6;
     $lineHeight = 2;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 2;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 60) 
    {
     $fontSizeText = $fontSizeAuthor - 13; 
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 14;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 11;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 12;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 13;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 14;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 15;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 15;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 17;
    }
  } //fin times new roman
  else  
  {
      if($fontSizeAuthor == 15)
    {
     $fontSizeText = $fontSizeAuthor - 4;
     $lineHeight = 3;
    }   
    else if($fontSizeAuthor == 20)
    {
     $fontSizeText = $fontSizeAuthor - 5;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 25)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 3;
    }  
    else if($fontSizeAuthor == 30)
    {
     $fontSizeText = $fontSizeAuthor - 7;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 35)
    {
     $fontSizeText = $fontSizeAuthor - 8;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 40)
    {
     $fontSizeText = $fontSizeAuthor - 9;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 45)
    {
     $fontSizeText = $fontSizeAuthor - 10;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 50)
    {
     $fontSizeText = $fontSizeAuthor - 11;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 55)
    {
     $fontSizeText = $fontSizeAuthor - 12;
     $lineHeight = 4;
    }  
    else if($fontSizeAuthor == 60)
    {
     $fontSizeText = $fontSizeAuthor - 14; 
     $lineHeight = 5;
    }  
    else if($fontSizeAuthor == 65)
    {
     $fontSizeText = $fontSizeAuthor - 16;
     $lineHeight = 6;
    }  
    else if($fontSizeAuthor == 70)
    {
     $fontSizeText = $fontSizeAuthor - 17;
     $lineHeight = 7;
    }  
    else if($fontSizeAuthor == 75)
    {
     $fontSizeText = $fontSizeAuthor - 18;
     $lineHeight = 8;
    }  
    else if($fontSizeAuthor == 80)
    {
     $fontSizeText = $fontSizeAuthor - 19;
     $lineHeight = 9;
    } 
    else if($fontSizeAuthor == 85)
    {
     $fontSizeText = $fontSizeAuthor - 20;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 90)
    {
     $fontSizeText = $fontSizeAuthor - 21;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 95)
    {
     $fontSizeText = $fontSizeAuthor - 22;
     $lineHeight = 9;
    }  
    else if($fontSizeAuthor == 100)
    {
     $fontSizeText = $fontSizeAuthor - 23;
     $lineHeight = 9;
    }  
    else 
    {
     $fontSizeText = $fontSizeAuthor - 24;
     $lineHeight = 14;
    }
  }
    
  $fontFamilyAuthorURL = '../fonts/'.$fontFamilyAuthor;
  if($italicAuthor == 0)
    $fontFamilyAuthorURL = '../fonts/'.$fontFamilyAuthor;
  else
  {
      $fontFamilyAuthorURL = '../fonts/italic/'.$fontFamilyAuthor;
      $bandExistAuthorCursiva = 0;
      if (file_exists($fontFamilyAuthorURL))
      {
         $bandExistAuthorCursiva = 1;
      }
      else
      {
         $fontFamilyAuthorURL = '../fonts/'.$fontFamilyAuthor; 
      }
  }
  
    //$authorRet = wrap($sizeFuenteAuthor,0,'../fonts/'.$fontFamilyAuthor,$author,600-($authorLeft+5));
    $myGDLibObj->addText($authorLeft, $authorTop, '../fonts/'.$fontFamilyAuthorURL, $fontSizeText, $author, $colorAuthor[0], $colorAuthor[1], $colorAuthor[2], $textAlignAuthor, $boldAuthor, $shadowAuthor, 350,$lineHeight);
  /*********FIN SOBRE EL AUTOR*********/
 
  /**********SOBRE EL FOOTER***********/
  if($flagInfoUser == 'Y')
  {
     $myGDLibObj->addText($footerInfoLeft-120, $footerInfoTop+5, '../fonts/Helvetica.ttf', 9, $infoFooter, 255,255,255, 'L', 0, 1, 600);
  }
  /*********FIN SOBRE EL FOOTER*******/
 
  return $myGDLibObj->create($file);
}


if(Token::IsTokenValid($_SESSION['tokenId'],$_SESSION['iduser'])==1)
{
 if(isset($_SESSION['iduser']) == true && Session::checkSession($_SESSION['iduser']) != false)
 {
  try
  { 
    //direccion de la imagen a guardar
    $numeroRand = rand(1000,1000000000);
    $fileName = $_POST['userId'].'a'.$numeroRand.'.jpg';
    $file = '../images/origGraphIns/'.$fileName;
    $flagInfoUserChecked = $_POST['footerChecked'];
    $infoFooter = $_POST['infoFooter'];
    $avatarFooter = $_POST['avatarFooter'];
    
    $arrayStyleFooter = $_POST['vStyleFooter'];
    $footerTop = $arrayStyleFooter['footerTop'];
    $footerLeft = $arrayStyleFooter['footerLeft'];
    $footerInfoTop = $arrayStyleFooter['footerInfoTop'];
    $footerInfoLeft = $arrayStyleFooter['footerInfoLeft'];
    $footerAvatarTop = $arrayStyleFooter['footerAvatarTop'];
    $footerAvatarLeft = $arrayStyleFooter['footerAvatarLeft'];
     
    
    $checked = $_POST['shadowChecked'];
    $flagInfoUser = 'N';
    if($flagInfoUserChecked == "unchecked" || $flagInfoUserChecked == null)
    {
      $flagInfoUser = 'N';
    }
    else
    {
      $flagInfoUser = 'Y';  
    }
    
    $newImageFooter = null;
    if($flagInfoUser == 'Y')
    {
      $resizeObj = new resize($avatarFooter);
      //resize la imagen en 430xundefined y lo guarda en la carpeta graphIns
      $resizeObj -> resizeImage(22, 22, 'crop');
      $newImageFooter = $resizeObj->imageResized;
    }
    
    $filtro = 'N';
    if($checked == "unchecked" || $checked == null)
    {
      $filtro = 'N';
    }
    else
    {
      $filtro = 'Y';  
    }
        
    /****SOBRE LA FRASE****/
    //frase escrita
    $praseContent1 = stripslashes_deep ($_POST['phrase'], 1);
    $prase = strip_tags($praseContent1);
   
    $arrayStylePhrase = $_POST['vStylePhrase'];
    $colorPhrase = getArrayColor($arrayStylePhrase['color']);
    $fontFamily = $arrayStylePhrase['fontFamily'];
    $fontNamePhrase =  getFontName(strtolower($fontFamily));
    $fontSizePhrase = $arrayStylePhrase['fontSize'];
    $fontWeightPhrase = $arrayStylePhrase['fontWeight'];
    $fontStylePhrase = $arrayStylePhrase['fontStyle'];
    $textAlignPhrase = $arrayStylePhrase['textAlign'];
    $textShadowPhrase = $arrayStylePhrase['textShadow'];
    $phraseTop = $arrayStylePhrase['phraseTop'];
    $phraseLeft = $arrayStylePhrase['phraseLeft'];
    /****FIN SOBRE LA FRASE****/
    
    /*****SOBRE EL AUTOR******/
    $authorContent1 = stripslashes_deep ($_POST['author'], 1);
    $author = strip_tags($authorContent1);
   
    $arrayStyleAuthor = $_POST['vStyleAutor'];
    $colorAuthor = getArrayColor($arrayStyleAuthor['color']);
    $fontFamilyAuthor = $arrayStyleAuthor['fontFamily'];
    $fontNameAuthor =  getFontName(strtolower($fontFamilyAuthor));
    $fontSizeAuthor = $arrayStyleAuthor['fontSize'];
    $fontWeightAuthor = $arrayStyleAuthor['fontWeight'];
    $fontStyleAuthor = $arrayStyleAuthor['fontStyle'];
    $textAlignAuthor = $arrayStyleAuthor['textAlign'];
    $textShadowAuthor = $arrayStyleAuthor['textShadow'];
    $authorTop = $arrayStyleAuthor['authorTop'];
    $authorLeft = $arrayStyleAuthor['authorLeft'];
    /****FIN SOBRE EL AUTOR****/
       
    $urlAux = getPodium($_POST['imageURL'], $file, $filtro, $flagInfoUser, $infoFooter, $footerInfoTop, $footerInfoLeft, $newImageFooter, $footerAvatarTop, $footerAvatarLeft, $prase, $colorPhrase, $fontNamePhrase, $fontSizePhrase, $fontWeightPhrase, $fontStylePhrase,
                        $textAlignPhrase, $textShadowPhrase, $phraseTop, $phraseLeft,
                        $author, $colorAuthor, $fontNameAuthor, $fontSizeAuthor, $fontWeightAuthor, $fontStyleAuthor,
                       $textAlignAuthor, $textShadowAuthor, $authorTop, $authorLeft);
      
    $resizeObj = new resize($file);
    $resizeObj -> resizeImage(430, 430, 'landscape');
    $resizeObj -> saveImage("../images/graphIns/".$fileName, 100);
    
    $image = new Image(NULL,"../images/graphIns/".$fileName,null,null,0,430,$file,600,600,NULL,$_POST['userId'],1);
    $result = $image->insert();
    
    /*FIN CREA LA IMAGEN*/
    Token::deleteTokenOperation($_SESSION['iduser'], 'operation');
    $token = getToken();
    //se inserta el token generado en la base
    $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
    $resultTokenOperation =  $resultToken->insertTokenOperation();
    $salidaJson = null;
    if($resultTokenOperation != false)
    {
     $_SESSION['tokenId']=$resultTokenOperation;
     $salidaJson = array("respuesta" => "done",
  		         "mensaje" => "Se ha creado tu imagen personalizada ",
		         //"fileName" => $result.'-'."../images/graphIns/".$fileName);
                         "fileName" => $result.'-'.$urlAux);
    }
    else 
    {  
        $salidaJson = array("respuesta" => "done",
  		         "mensaje" => "Se ha creado la imagen",
		         "fileName" => $file);
    }
    echo json_encode($salidaJson);
  }
  catch(Exception $e) 
  {
      $salidaJson = array("respuesta" => "done",
  		         "mensaje" => $e->getMessage(),
		         "fileName" => $e->getFile());
      echo json_encode($salidaJson);
  }
 }
 else
 {
    $salidaJson = array("respuesta" => "done",
  		         "mensaje" => 'NOSSID',
		         "fileName" => '');
    echo json_encode($salidaJson);
 }
}
else
{
   $salidaJson = array("respuesta" => "done",
  		         "mensaje" => 'NOSSID',
		         "fileName" => '');
    echo json_encode($salidaJson);
}
?>
