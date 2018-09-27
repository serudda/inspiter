$(document).ready(function(){

/******************************************************************/
//     VARIABLES GLOBALES            //
/*****************************************************************/
var $ImagePhraseIn = $("#ImagePhraseGraph");
var $inputIdenPhrase = $("#inputPhraseGraph");
var $inputIdenAuthor  = $("#inputAuthorGraph");
var $textPhraseIn = $("#textPhraseGraph");
var $textImgAuthor = $("#textPhraseAuthorGraph");
var $option_font = $(".fontPhraseGraph");
var $option_text = $(".option-text");
var $font_size_text = $("#font-size-text");
var $font_size_text_less = $("#font-size-text-less");
var $font_textalign_text = $("#font-textalign-text");
var $buttonChangeTextEdit = $("#buttonChangeTextEdit");
var $optionTextChange = $("#optionTextChange");
var $list_option_textalign = $("#list-option-textalign");
var $list_select_text = $("#list-select-text");
var $font_bold_text = $("#font-bold-text");
var $font_italic_text = $("#font-italic-text");
var $font_shadow_text = $("#font-shadow-text");
var $PhraseOrAuthor = $("#PhraseOrAuthor");
var $optionExtraShadow = $("#optionExtraShadow");
var $optionExtraDescribe = $("#optionExtraDescribe");
var $ImageShadowGraph = $("#ImageShadowGraph");
var $ImageFooterGraphBlock = $("#ImageFooterGraphBlock");
var $ImageFooterGraph = $("#ImageFooterGraph");
var $InfoFooterGraph =$("#InfoFooterGraph");
var $AvatarFooterGraph = $("#AvatarFooterGraph");
var $btn_save_phraseGraph = $("#btn_save_phraseGraph");
var userId   = $("#userIdLogged").val();
var facebookId = $("#faceidHidden").val();
var username = $("#usernameHidden").val();
var fullname = $("#fullnameHidden").val();
var doc    =    $(document);
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
//      EVENTOS                //
/*****************************************************************/


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

$(window).click(function(){
    var posPhraseTop = $textPhraseIn.css('top');
        posPhraseTop = posPhraseTop.replace('px','');
    var posPhraseLeft = $textPhraseIn.css('left');
        posPhraseLeft = posPhraseLeft.replace('px','');
    var posAuthorTop = $textImgAuthor.css('top');
        posAuthorTop = posAuthorTop.replace('px','');
    var posAuthorLeft = $textImgAuthor.css('left');
        posAuthorLeft = posAuthorLeft.replace('px','');
    
    if(posPhraseTop > 580 || posPhraseTop < -25){
        $textPhraseIn.css('top','306px');
        $textPhraseIn.css('left','29px');
    }else if(posPhraseLeft > 570 || posPhraseLeft < -500){
        $textPhraseIn.css('top','306px');
        $textPhraseIn.css('left','29px');
    }
    
    if(posAuthorTop > 582 || posAuthorTop < -20){
        $textImgAuthor.css('top','396px');
        $textImgAuthor.css('left','228px');
    }else if(posAuthorLeft > 500 || posAuthorLeft < -300){
        $textImgAuthor.css('top','396px');
        $textImgAuthor.css('left','228px');
    }
    
});

//EVENTO CLICK DE TAMAÑO DE FUENTE - AUMENTAR TAMAÑO DE LA FUENTE
var fontsizePhraseOrig;
var fontsizeAuthorOrig;
var fontsizePhraseNew;
var fontsizeAuthorNew;
//var lineHeightNew;

$font_size_text.click(function(e){
    
    var fontSizeMax = 100;
    fontsizePhraseOrig = $(this).data('sizephrase');
    fontsizeAuthorOrig = $(this).data('sizeauthor');
    var fontTypePhrase = $textPhraseIn.data('typefont');
    var fontTypeAuthor = $textImgAuthor.data('typefont');
    //lineHeightOrig = $(this).data('line');
    
    if($PhraseOrAuthor.val() == "Frase"){
        
        //Casos especiales para las fuentes especiales como Jellyka le agregamos un maximo especial
        switch(fontTypePhrase){
            case "Jellyka":
                fontSizeMax = 150;
                break;
            default:
                fontSizeMax = 100;
                break;
        }
        
        if(fontsizePhraseOrig < fontSizeMax){
          fontsizePhraseNew = fontsizePhraseOrig + 5;
          $textPhraseIn.css('font-size',fontsizePhraseNew+'px');
          $(this).data('sizephrase',fontsizePhraseNew);
          $font_size_text_less.data('sizephrase',fontsizePhraseNew);
          AddLineHeight(fontTypePhrase, fontsizePhraseNew);
        }
        
    }else{
        if(fontsizeAuthorOrig < 100){
            fontsizeAuthorNew = fontsizeAuthorOrig + 5;
            $textImgAuthor.css('font-size',fontsizeAuthorNew);
            $(this).data('sizeauthor',fontsizeAuthorNew);
            $font_size_text_less.data('sizeauthor',fontsizeAuthorNew);
        }
    }

 e.preventDefault();
});
//EVENTO CLICK DE TAMAÑO DE FUENTE - REDUCE TAMAÑO DE LA FUENTE

$font_size_text_less.click(function(e){
    
    fontsizePhraseOrig = $(this).data('sizephrase');
    fontsizeAuthorOrig = $(this).data('sizeauthor');
    var fontTypePhrase = $textPhraseIn.data('typefont');
    var fontTypeAuthor = $textImgAuthor.data('typefont');

    if($PhraseOrAuthor.val() == "Frase"){

        //Esto es para validar por si la fuente es menor a 15
        if(fontsizePhraseOrig > 15){
            fontsizePhraseNew = fontsizePhraseOrig - 5;
        }
        else{
            fontsizePhraseNew = fontsizePhraseOrig;
        }

        $textPhraseIn.css('font-size',fontsizePhraseNew+'px');
        $(this).data('sizephrase',fontsizePhraseNew);
        $font_size_text.data('sizephrase',fontsizePhraseNew);
        AddLineHeight(fontTypePhrase,fontsizePhraseNew);
    }else{
        //Esto es para validar por si la fuente en menor a 0
        if(fontsizeAuthorOrig > 15){
            fontsizeAuthorNew = fontsizeAuthorOrig - 5;
        }else{
            fontsizeAuthorNew = fontsizeAuthorOrig;
        }

        $textImgAuthor.css('font-size',fontsizeAuthorNew);
        $(this).data('sizeauthor',fontsizeAuthorNew);
        $font_size_text.data('sizeauthor',fontsizeAuthorNew);
    }

 e.preventDefault();
});


//EVENTO CLICK AGREGAR NEGRITA, CURSIVA Y SOMBRA
//CURSIVA
$font_italic_text.click(function(e){

     if($PhraseOrAuthor.val() == "Frase"){
        
        if($(this).attr('data-hasitalic') == 'yes'){
            if($textPhraseIn.css('font-style')=='italic'){
                $textPhraseIn.css('font-style','normal').data("italic","normal");
                $(this).removeClass("actived");
            }else{
                $textPhraseIn.css('font-style','italic').data("italic","italic");
                $(this).addClass("actived");
            }
        }else
         {
             $("#tooltipDontItalic").fadeIn(600);
             $textPhraseIn.css('font-style','normal').data("italic","normal");
             $(this).removeClass("actived");
             setTimeout(function() {
	     $("#tooltipDontItalic").fadeOut();
             }, 300);
         }   

     }else{
         
    if($(this).attr('data-hasitalicauthor') == 'yes'){    
        if($textImgAuthor.css('font-style')=='italic'){
            $textImgAuthor.css('font-style','normal').data("italic","normal");
            $(this).removeClass("actived");
        }else{
            $textImgAuthor.css('font-style','italic').data("italic","italic");
            $(this).addClass("actived");
        }
        
     }else
         {
             $("#tooltipDontItalic").fadeIn(600);
             $textImgAuthor.css('font-style','normal').data("italic","normal");
             $(this).removeClass("actived");
             setTimeout(function() {
	     $("#tooltipDontItalic").fadeOut();
             }, 300);
         } 

     }
 e.preventDefault();
});

//NEGRITA
$font_bold_text.toggle(function (e) {
    if($PhraseOrAuthor.val() == "Frase"){
        $textPhraseIn.css("font-weight", "bold").data("bold","bold");
        $(this).addClass("actived");
    }else{
        $textImgAuthor.css("font-weight", "bold").data("bold","bold");
        $(this).addClass("actived");
    }
    e.preventDefault();

},function (e) {
    if($PhraseOrAuthor.val() == "Frase"){
        $textPhraseIn.css("font-weight", "normal").data("bold","normal");
        $(this).removeClass("actived");
    }else{
        $textImgAuthor.css("font-weight", "normal").data("bold","normal");
        $(this).removeClass("actived");
    }
    e.preventDefault();
});

//SOMBRA
$font_shadow_text.toggle(function (e) {
    if($PhraseOrAuthor.val() == "Frase"){
        $textPhraseIn.css("text-shadow", "1px 1px 3px #000").data("shadow","yes");
        $(this).addClass("actived");
    }else{
        $textImgAuthor.css("text-shadow", "1px 1px 3px #000").data("shadow","yes");
        $(this).addClass("actived");
    }
    e.preventDefault();
},function (e) {
    if($PhraseOrAuthor.val() == "Frase"){
        $textPhraseIn.css("text-shadow", "none").data("shadow","none");
        $(this).removeClass("actived");
    }else{
        $textImgAuthor.css("text-shadow", "none").data("shadow","none");
        $(this).removeClass("actived");
    }
e.preventDefault();
});


//EVENTO CLICK DE ALIGN TEXT
$font_textalign_text.click(function(e){
 if($list_option_textalign.css('display')=='none')
    $list_option_textalign.show();
 else $list_option_textalign.hide();
 e.preventDefault();
});

var fontalign;
//EVENTO PARA CAMBIAR EL ALIGN AL DAR CLICK EN CADA OPCION TEXTALIGN
$option_text.click(function(e){
    fontalign = $(this).data('textalign');
    if($PhraseOrAuthor.val() == "Frase"){
        $textPhraseIn.css('text-align',fontalign);
    }else{
        $textImgAuthor.css('text-align',fontalign);
    }
    e.preventDefault();
});


var fontstyle;
var fonttext;
var fontHasItalic;
var lineHeightFont
//EVENTO PARA CAMBIAR EL TIPO DE FUENTE AL DAR CLICK EN CADA OPCION FONT
$option_font.click(function(e){
 fontstyle = $(this).data('font');
 fonttext = $(this).data('text');
 fontHasItalic = $(this).attr('data-hasitalic');
 lineHeightFont = $(this).attr('data-line');
 if($PhraseOrAuthor.val() == "Frase"){
    //Controlo el tamaño de la fuente, si es mayor a 100, se la dejo en 100
    if($font_size_text.data('sizephrase') > 100){
        $textPhraseIn.css('font-size',100);
        $font_size_text.data('sizephrase',100);
        $font_size_text_less.data('sizephrase',100);
    }
    //Asignar su respectivo line height (en este momento solo el de Jellyka)
    if(lineHeightFont != 0)
        $textPhraseIn.css('line-height',lineHeightFont+'px');
    else
        $textPhraseIn.css('line-height','normal');
    
    $textPhraseIn.css('font-family',fontstyle).data('typefont',fontstyle);
    $(".mCSB_container ul").children().removeClass('actived').data('phselected','none');
    $(this).data('phselected','selected').addClass('actived');
    $font_italic_text.attr('data-hasitalic',fontHasItalic);
    //Si el usuario ya habia escogido la opcion: italic. Preguntamos si la nueva fuente que escogio tiene italic
    if(fontHasItalic == 'none'){
        $textPhraseIn.css('font-style','normal').data("italic","normal");
        $font_italic_text.removeClass("actived");
    }
    
 }else{
     
    //Controlo el tamaño de la fuente, si es mayor a 100, se la dejo en 100
    if($font_size_text.data('sizeauthor') > 100){
        $textImgAuthor.css('font-size',100); 
        $font_size_text.data('sizeauthor',100);
        $font_size_text_less.data('sizeauthor',100);
    }    
        
    $textImgAuthor.css('font-family',fontstyle).data('typefont',fontstyle);
    $(".mCSB_container ul").children().removeClass('actived').data('auselected','none');
    $(this).data('auselected','selected').addClass('actived');
    $font_italic_text.attr('data-hasitalicauthor',fontHasItalic);
    //Si el usuario ya habia escogido la opcion: italic. Preguntamos si la nueva fuente que escogio tiene italic
    if(fontHasItalic == 'none'){
        $textImgAuthor.css('font-style','normal').data("italic","normal");
        $font_italic_text.removeClass("actived");
    }
 }
 $("#font-family-text b").text(fonttext);
 e.preventDefault();
});

//EVENTO COLORPICKER

$('#colorSelector').ColorPicker({
    color: '#fff',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
    return false;
    },
    onChange: function (hsb, hex, rgb) {
    $('#colorSelector div').css('backgroundColor', '#' + hex);
        if($PhraseOrAuthor.val() == "Frase"){
            $textPhraseIn.css('color', '#' + hex);
        }else{
            $textImgAuthor.css('color', '#' + hex);
        }
    }
});


//EVENTO CLICK PARA CAMBIAR DE FRASE A AUTOR
$buttonChangeTextEdit.click(function(e){
 if($list_select_text.css('display')=='none')
    $list_select_text.show();
 else $list_select_text.hide();
 e.preventDefault();
});

//EVENTO CLICK EN EL TEXTO PARA CAMBIAR DE FRASE A AUTOR
$textPhraseIn.click(function(e){
 AddStyle("Frase");
 e.preventDefault();
});

$textImgAuthor.click(function(e){
 AddStyle("Autor");
 e.preventDefault();
});

//EVENTO FOCUS, PARA CAMBIAR DE FRASE A AUTOR CUANDO LE DE FOCO A ALGUN TEXTAREA
$inputIdenPhrase.focus(function(e){
  AddStyle("Frase");  
  e.preventDefault();  
});

$inputIdenAuthor.focus(function(e){
  AddStyle("Autor");  
  e.preventDefault();  
});


//EVENTO CLICK, PARA CAMBIAR DE FRASE A AUTOR EN LA LISTA DE OPCIONES
$optionTextChange.click(function(e){
var optionSelected = $(this).data('option');
AddStyle(optionSelected);
e.preventDefault();
});

//EVENTO CLICK PARA AGREGAR LA SOMBRA A LA IMAGEN
$optionExtraShadow.toggle(function (e) {
    $ImageShadowGraph.show();
    $(this).data('checked','checked').css('opacity','1');
    e.preventDefault();
},function (e) {
    $ImageShadowGraph.hide();
    $(this).data('checked','unchecked').css('opacity','0.60');
    e.preventDefault();
});


////EVENTO CLICK PARA AGREGAR LA FIRMA A LA IMAGEN
//$optionExtraDescribe.toggle(function (e) {
//    //CountChar();
//    $(this).data('checked','checked').css('opacity','1');
//    $ImageFooterGraphBlock.show();
//    $InfoFooterGraph.show();
//    $AvatarFooterGraph.show();
//    e.preventDefault();
//},function (e) {
//    $(this).data('checked','unchecked').css('opacity','0.6');
//    $ImageFooterGraphBlock.hide();
//    $InfoFooterGraph.hide();
//    $AvatarFooterGraph.hide();
//    e.preventDefault();
//});


    /**************************************************************************************************/
    //       APARECER Y DESAPARECER EL BOTON "AGREGAR" CUANDO SE PEGA TEXTO EN EL INPUT TYPE TEXT
    /**************************************************************************************************/
		
    $("#FileUploadBrowserPhraseGraph").bind("paste",function(e) {
    $("#button-add-image-phraseGraph").show();
    });

		$("#FileUploadBrowserPhraseGraph").keyup(function(){
		 if($(this).val()==''){
			$("#button-add-image-phraseGraph").hide();
		 }else{
			$("#button-add-image-phraseGraph").show();
		 }
		});


//EVENTO CLICK, BOTON PUBLICAR INSPIRACION
$btn_save_phraseGraph.click(function()
{
  var PhraseStyleReturn = GetStylePhraseGraph();
  var AuthorStyleReturn = GetStyleAuthorGraph();
  var FooterStyleReturn = GetStyleFooterGraph();
/****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   21/03/2013
    //Purpose:     - Aplica el estilo de la frase insignia, el autor y la imagen de fondo
/*****************************************************************************************/
     $.ajax({
            url: "../web/createImagePhraseGraph.php",
            data: {
                     "userId": userId,
                     "phrase": $inputIdenPhrase.val(),
                     "author": $inputIdenAuthor.val(),
                     "imageURL": $("#ImagePhraseGraph").attr('src'),
                     "shadowURL": $ImageShadowGraph.attr('src'),
                     "shadowChecked":$optionExtraShadow.data('checked'),
                     "footerURL": $ImageFooterGraph.attr('src'),
                     "footerChecked":$optionExtraDescribe.data('checked'),
                     "infoFooter": $InfoFooterGraph.text(),
                     "avatarFooter": $AvatarFooterGraph.attr('src'),
                     "vStylePhrase":
                                   {
                    "color": PhraseStyleReturn.color,
                    "fontFamily": PhraseStyleReturn.fontFamily,
                    "fontSize":PhraseStyleReturn.fontSize,
                    "fontWeight":PhraseStyleReturn.fontWeight,
                    "fontStyle":PhraseStyleReturn.fontStyle,
                    "textAlign":PhraseStyleReturn.textAlign,
                    "textShadow":PhraseStyleReturn.textShadow,
                    "phraseTop":PhraseStyleReturn.phraseTop,
                    "phraseLeft":PhraseStyleReturn.phraseLeft
                                   },
                     "vStyleAutor":
                                   {
                    "color": AuthorStyleReturn.color,
                     "fontFamily": AuthorStyleReturn.fontFamily,
                    "fontSize":AuthorStyleReturn.fontSize,
                    "fontWeight":AuthorStyleReturn.fontWeight,
                    "fontStyle":AuthorStyleReturn.fontStyle,
                    "textAlign":AuthorStyleReturn.textAlign,
                    "textShadow":AuthorStyleReturn.textShadow,
                    "authorTop":AuthorStyleReturn.authorTop,
                    "authorLeft":AuthorStyleReturn.authorLeft
                                   },
                     "vStyleFooter":
                                    {
                    "footerTop":FooterStyleReturn.footerTop,
                    "footerLeft":FooterStyleReturn.footerLeft,
                    "footerInfoTop":FooterStyleReturn.footerInfoTop,
                    "footerInfoLeft":FooterStyleReturn.footerInfoLeft,
                    "footerAvatarTop":FooterStyleReturn.footerAvatarTop,
                    "footerAvatarLeft":FooterStyleReturn.footerAvatarLeft
                                    }
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(data)
                    {
                        if (data.toString().indexOf('NOSSID') >= 0)
                        {
                          $('#Bigloading').hide();
                          $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                          $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                        }
                        else
                        {
                            $.post("../web/eliminaImagenesTemp.php",
                            {
                             FimageCut: 1,
                             Fimage: 1
                            },
                            function(data1,status)
                            {
                             if(data1 == 'NOSSID')
                             {
                               $.genericAlert('Inicia sesion para poder realizar esta acci\u00f3n');
                               $(location).attr('href','../index.php?logout=ok&activate=si&uid=Y');
                             }
                             else
                             {
                               $("#ImagePhraseURL").val(data.fileName.split("-")[1]);
                               $.SuccessPhraseGraph(data.fileName.split("-")[1]);
                               //$.MultiOption();
                               if($("#facebookChecked").data('checked')== "checked")
                                graphStreamPublish(data.fileName.split("-")[1],"",data.fileName.split("-")[0],fullname,username,"");
                               //else
                              
                             }
                            });
                        }
                    },
                    error: function()
                    {
                    }
            });
});

/******************************************************************/
//        FUNCIONES                //
/*****************************************************************/

function GetStylePhraseGraph(){
    //Estilos de la Frase
    var PhraseStyle = {
        "fontFamily":$textPhraseIn.css('font-family'),
        "fontSize":$textPhraseIn.css('font-size'),
        "fontWeight":$textPhraseIn.css('font-weight'),
        "fontStyle":$textPhraseIn.css('font-style'),
        "textShadow":$textPhraseIn.css('text-shadow'),
        "textAlign":$textPhraseIn.css('text-align'),
        "color":$textPhraseIn.css("color"),
        "phraseTop":$textPhraseIn.css('top'),
        "phraseLeft":$textPhraseIn.css('left')
    };

    return PhraseStyle;
}


function GetStyleAuthorGraph(){
    //Estilos del Autor
    var AuthorStyle = {
        "fontFamily":$textImgAuthor.css('font-family'),
        "fontSize":$textImgAuthor.css('font-size'),
        "fontWeight":$textImgAuthor.css('font-weight'),
        "fontStyle":$textImgAuthor.css('font-style'),
        "textShadow":$textImgAuthor.css('text-shadow'),
        "textAlign":$textImgAuthor.css('text-align'),
        "color":$textImgAuthor.css("color"),
        "authorTop":$textImgAuthor.css('top'),
        "authorLeft":$textImgAuthor.css('left')
     };

    return AuthorStyle;
}

function GetStyleFooterGraph(){
    //Estilos del footer
    var FooterStyle = {
        "footerTop":$ImageFooterGraphBlock.css('top'),
        "footerLeft":$ImageFooterGraphBlock.css('left'),
        "footerInfoTop":$InfoFooterGraph.css('top'),
        "footerInfoLeft":$InfoFooterGraph.css('left'),
        "footerAvatarTop":$AvatarFooterGraph.css('top'),
        "footerAvatarLeft":$AvatarFooterGraph.css('left')
     };

    return FooterStyle;
}

//Asignar todos los valores que el usuario escogio para la frase o el autor
 function AddStyle(option){

     var colorFontPhrase  = $textPhraseIn.css("color");
     var colorFontAuthor  = $textImgAuthor.css("color");
     var BoldPhrase       = $textPhraseIn.data("bold"); 
     var BoldAuthor       = $textImgAuthor.data("bold");
     var ItalicPhrase     = $textPhraseIn.data("italic");
     var ItalicAuthor     = $textImgAuthor.data("italic");
     var ShadowPhrase     = $textPhraseIn.data("shadow");
     var ShadowAuthor     = $textImgAuthor.data("shadow");
     
     
     if(option == "Frase"){
         $("#textOptionSelected").text("Frase");
         $("#buttonChangeTextEdit").removeClass("changeColorAuthor");
         $optionTextChange.text("Autor").data('option',"Autor").data('colorFont',colorFontAuthor);
         $PhraseOrAuthor.val("Frase");
         $('#colorSelector div').css('backgroundColor', colorFontPhrase);
         if(BoldPhrase == "bold")
             $font_bold_text.addClass("actived");
         else
             $font_bold_text.removeClass("actived");
         
         if(ItalicPhrase == "italic")
             $font_italic_text.addClass("actived");
         else
             $font_italic_text.removeClass("actived");
         
         if(ShadowPhrase == "yes")
             $font_shadow_text.addClass("actived");
         else
             $font_shadow_text.removeClass("actived");

         //Buscar la opcion Fuente seleccionada
         $(".mCSB_container ul").find("li").each(function(){ //buscar los li marcados
            
            if($(this).data("phselected") == "selected")
               $(this).addClass("actived"); 
            else
               $(this).removeClass("actived");  
        });
            
     }else if(option == "Autor"){
         $("#textOptionSelected").text("Autor");
         $("#buttonChangeTextEdit").addClass("changeColorAuthor");
         $optionTextChange.text("Frase").data('option',"Frase").data('colorFont',colorFontPhrase);
         $PhraseOrAuthor.val("Autor");
         $('#colorSelector div').css('backgroundColor', colorFontAuthor);
         if(BoldAuthor == "bold")
             $font_bold_text.addClass("actived");
         else
             $font_bold_text.removeClass("actived");
         
         if(ItalicAuthor == "italic")
             $font_italic_text.addClass("actived");
         else
             $font_italic_text.removeClass("actived");
         
         if(ShadowAuthor == "yes")
             $font_shadow_text.addClass("actived");
         else
             $font_shadow_text.removeClass("actived");
         
         //Buscar la opcion Fuente seleccionada
         $(".mCSB_container ul").find("li").each(function(){ //buscar los li marcados
            
            if($(this).data("auselected") == "selected")
               $(this).addClass("actived"); 
            else
               $(this).removeClass("actived");  
        });
     }
     
 } 
 
 
 function AddLineHeight(TypeFont,fontsize){
     switch(TypeFont){
         case "Jellyka":
             if((fontsize > 35) && (fontsize < 54)){
                 $textPhraseIn.css('line-height','25px');
                 $(".Jellyka").attr('data-line',25);
             } else if((fontsize > 55) && (fontsize < 69)){
                 $textPhraseIn.css('line-height','30px');
                 $(".Jellyka").attr('data-line',30);
             } else if((fontsize > 70) && (fontsize < 84)){
                 $textPhraseIn.css('line-height','35px');
                 $(".Jellyka").attr('data-line',35);
             } else if((fontsize > 85) && (fontsize < 99)){
                 $textPhraseIn.css('line-height','40px');
                 $(".Jellyka").attr('data-line',40);
             } else if((fontsize > 100) && (fontsize < 109)){
                 $textPhraseIn.css('line-height','45px');
                 $(".Jellyka").attr('data-line',45);
             } else if((fontsize > 110) && (fontsize < 129)){
                 $textPhraseIn.css('line-height','50px');
                 $(".Jellyka").attr('data-line',50);
             } else if((fontsize > 130) && (fontsize < 149)){
                 $textPhraseIn.css('line-height','55px');
                 $(".Jellyka").attr('data-line',55);
             } else if(fontsize == 150){
                 $textPhraseIn.css('line-height','60px');
                 $(".Jellyka").attr('data-line',60);
             }
         break;
     }
 }

////Sirve para ser más precisos a la hora de colocar la firma en la imagen, si el nombre tiene pocos caracteres
////lo va moviendo cada vez mas al lado de la foto del perfil del usuario
// function CountChar(){
//    var CountCharVar = $("#Name-user-menu").text().length;
////    alert(CountCharVar);
//    switch(CountCharVar){
//        case 18:
//        case 17:
//            $InfoFooterGraph.css('left','305px');
//            break;
//        case 16:
//        case 15:
//            $InfoFooterGraph.css('left','316px');
//            break;
//        case 14:
//        case 13:
//            $InfoFooterGraph.css('left','321px');
//            break;
//        case 12:
//        case 11:
//            $InfoFooterGraph.css('left','349px');
//            break;
//        case 10:
//        case 9:
//            $InfoFooterGraph.css('left','361px');
//            break;
//        case 8:
//        case 7:
//            $InfoFooterGraph.css('left','374px');
//            break;
//        case 6:
//        case 5:
//            $InfoFooterGraph.css('left','388px');
//            break;
//        case 4:
//        case 3:
//            $InfoFooterGraph.css('left','399px');
//            break;
//        case 2:
//        case 1:
//            $InfoFooterGraph.css('left','418px');
//            break;
//    }
// }

 /****************************************************************************************/
    //@Author:       Inspiter
    //Create Date:   15/09/2012
    //Purpose:     - Comparte la inspiracion en Facebook
    /*****************************************************************************************/
    function graphStreamPublish(pUrl,pDescription,inspiterId,pFullname,pUsername,pTitle)
    {
       if (facebookId == null || facebookId == '' || facebookId == 0)
       {
          $.genericAlert("Debes asociar tu cuenta de facebook desde el men\u00fa configurar para poder realizar esta acci\u00f3n.");
          window.location.reload();
       }
       else
       {
            //cuando se comparte a face una inspiracion ya publicada si se puede redimensionar
            var uri = 'http://www.inspiter.com'+pUrl.substring(2);
            FB.getLoginStatus(function(response) {
             if (response.status === 'connected') {
             var uid = response.authResponse.userID;
             if(facebookId==uid)
             {
               FB.api('/me/feed', 'post', { 
                   message:  pTitle,
                   description: pDescription,
                   picture: uri,
                   name:  pFullname+' compartio una imagen en Inspiter',
                   link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                   actions: [
                   {
                       name: 'Inspiter', 
                       link:'http://www.inspiter.com'
                   }
                   ]
               }, function(response) {  
                   if (response)
                   {
                       $(location).attr('href','../main.php');
                    }
               });
             }
             else
             {
                $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                window.location.reload();
             }
       } else if (response.status === 'not_authorized') {
       } else {
           FB.login(function(response) {
               if(response.authResponse) {
                   if(facebookId==response.authResponse.userID)
                   {
                       FB.api('/me/feed', 'post', { 
                           message:  pTitle,
                           description: pDescription,
                           picture: uri,
                           name:  pFullname+' compartio una imagen en Inspiter',
                           link:'http://www.inspiter.com/'+pUsername+'&post='+inspiterId,
                           actions: [
                           {
                               name: 'Inspiter', 
                               link:'http://www.inspiter.com'
                           }
                           ]
                       }, function(response) {
                           if (response)
                           {
                               $(location).attr('href','../main.php');
                           }
                       });
                   }
                   else
                   {
                      $.genericAlert('Tu cuenta de facebook no corresponde a tu cuenta de Inspiter');
                        window.location.reload();
                   }
               }
           });
       }
   }, true);
}
}

});