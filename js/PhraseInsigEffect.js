$(document).ready(function(){

/******************************************************************/
//	 VARIABLES GLOBALES													  //
/*****************************************************************/
var $ImgDefault = $(".ImgDefault");
var $ImagesDefaultButton = $("#ImagesDefaultButton");
var $ImagePhraseIn = $("#ImagePhraseIn");
var $inputIdenPhrase = $("#inputIdenPhrase");
var $inputIdenAuthor  = $("#inputIdenAuthor");
var $textPhraseIn = $("#textPhraseIn");
var $textImgAuthor = $("#textPhraseInAuthor");
var $option_font = $(".option-font"); 
var $option_font_size = $(".option-font-size");
var $font_family_text = $("#font-family-text");
var $font_size_text = $("#font-size-text");
var $list_option_font = $("#list-option-font");
var $list_option_size = $("#list-option-size");
var $font_bold_text = $("#font-bold-text");
var $font_italic_text = $("#font-italic-text");
var ConfigImagePredef= $("#imagePredef");
var doc	=	$(document);
doc.data('xPosPhrase','');
doc.data('yPosPhrase','');
doc.data('xPosAuthor','');
doc.data('yPosAuthor','');
doc.data('yPosImg','');
/*doc.data( 'PhraseInsigStyle' , {
 xPosPhrase: '',
 yPosPhrase: '',
 xPosAuthor: '',
 yPosAuthor: ''
});*/


/******************************************************************/
//	  EVENTOS																  //
/*****************************************************************/
		
//HACE APARECES LAS IMAGENES DE DEFECTO PARA LA FRASE INSIGNIA
$ImagesDefaultButton.click(function(){
 if($ImgDefault.css('height')=='0px'){
 $ImgDefault.animate({
	height:'213px'
 },100);
}else{
  $ImgDefault.animate({
	height:'0px'
 },100);
}
});


//EVENTO CLICK PARA ASIGNAR LA IMAGEN DE DEFAULT DE CADA PEQUEÑA IMAGEN A LA GRANDE
$('.img0, .img1, .img2, .img3, .img4, .img5, .img6, .img7').click(function(){
 
 var imgBackground = $(this).data('image');
 
 /*$(this).removeClass('img1 img2 img3 img4 img5 img6 img7 img8').addClass(imgthumbnailBig).data({
	'image':imgBackgroundBig,
	'thumbnail':imgthumbnailBig
 });*/
 $ImagePhraseIn.attr('src','').hide().css('top','0');
	
 setTimeout(function(){
	$ImagePhraseIn.attr('src','/images/PhraseIns/'+imgBackground).show();
        ConfigImagePredef.val(imgBackground);
 },2000);
 
});

var textTextareaPhraseIn;
//EVENTO KEYUP CUANDO SE ESTA ESCRIBIENDO EN EL TEXTAREA, REFLEJA INMEDIATAMENTE EL TEXTO EN LA IMAGEN
$inputIdenPhrase.on({
        keyup:function(){
					textTextareaPhraseIn = $(this).val(); 
					$textPhraseIn.text(textTextareaPhraseIn);
				},
				blur:function(){
				 textTextareaPhraseIn = $(this).val(); 
					$textPhraseIn.text(textTextareaPhraseIn);
				}
});


//EVENTO KEYUP CUANDO SE ESTA ESCRIBIENDO EN EL TEXTFIELD AUTOR, REFLEJA INMEDIATAMENTE EL TEXTO EN LA IMAGEN
var textTextareaAuthorIn;
$inputIdenAuthor.on({
 keyup:function(){
 textTextareaAuthorIn = $(this).val(); 
 $textImgAuthor.text(textTextareaAuthorIn);
 },
 blur:function(){
  textTextareaAuthorIn = $(this).val(); 
  $textImgAuthor.text(textTextareaAuthorIn);	
 }
});

//EVENTO DRAGGER PARA MOVER EL TEXTO DE LA IMAGE
$textPhraseIn.draggable();

$textImgAuthor.draggable();

$ImagePhraseIn.draggable({
    axis: 'y',
    drag: function(event, ui) {
				
        var pos = ui.position;
        var $this = $(this);
        
        if((pos.top * -1) >= ($this.height() - $this.parent().height()))
        {
            return false;
        }
          
        if(pos.top > 0)
        {
            return false;
        }
    }
});


//EVENTO CLICK DE TIPO DE FUENTE
$font_family_text.click(function(e){
 if($list_option_font.css('display')=='none')
	$list_option_font.show();
 else $list_option_font.hide();
 e.preventDefault();
});

//EVENTO CLICK DE TAMAÑO DE FUENTE
$font_size_text.click(function(e){
 if($list_option_size.css('display')=='none')
	$list_option_size.show();
 else $list_option_size.hide();
 e.preventDefault();
});

//EVENTO CLICK AGREGAR NEGRITA Y CURSIVA
//CURSIVA
$font_italic_text.click(function(e){
 if($textPhraseIn.css('font-style')=='italic'){
	$textPhraseIn.css('font-style','normal');
 }else{
	$textPhraseIn.css('font-style','italic');
 }
 e.preventDefault();
});

//NEGRITA
/*$font_bold_text.click(function(e){
 if($textPhraseIn.css('font-weight')=='normal'){

	$textPhraseIn.css('font-weight','bold');
 }else{
	$textPhraseIn.css('font-weight','normal');
 }
 e.preventDefault();
});*/

$font_bold_text.toggle(function (e) {

$textPhraseIn.css("font-weight", "bold");
e.preventDefault();
},function (e) {

$textPhraseIn.css("font-weight", "normal");
e.preventDefault();
}); 

var fontstyle;
var fonttext;
//EVENTO PARA CAMBIAR EL TIPO DE FUENTE AL DAR CLICK EN CADA OPCION FONT
$option_font.click(function(e){
 fontstyle = $(this).data('font');
 fonttext = $(this).data('text');
 $textPhraseIn.css('font-family',fontstyle);
 $("#font-family-text b").text(fonttext);
 e.preventDefault();
});


var fontsize;
//EVENTO PARA CAMBIAR EL TAMAÑO DE LA FUENTE AL DAR CLICK EN CADA OPCION FONT-SIZE
$option_font_size.click(function(e){
 fontsize = $(this).data('size');
 $textPhraseIn.css('font-size',fontsize);
 e.preventDefault();
});




/******************************************************************/
//		FUNCIONES															  //
/*****************************************************************/



});