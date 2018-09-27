<?php
error_reporting(0);
require_once 'clases/Mail.php';
require_once 'clases/User.php';
require_once 'clases/Token.php';

if (isset($_POST['RecupSubmit']))
{
    $pUserId = $_POST['userIdRC'];
    $pPasswordNew = $_POST['inputNewPass'];
    $pPasswordReNew = $_POST['inputConPass'];
    $pUserMail = $_POST['emailRC'];
    
    if($pUserId != 0)
    {
        $resultPass = User::updatePassword($pUserId, $pPasswordNew, $pPasswordReNew);
        if($resultPass != false)
        {
            $resultDeleteToken = Token::deleteToken($pUserMail,'pass');
            if($resultDeleteToken != false)
                header("location:/index.php?sucess=passwordChangedSuccesful"); 
                //todo sergio se cambio el password correctamente 
                //ya podra usar nuevamente su cuenta
            else
                header("location:/index.php?error=TokenError");
                //todo sergio, se produjo un error porque no se pudo eliminar
                // el token 
        }
        else
            header("location:/index.php?error=passwordError");
            //todo sergio, se produjo un error porque el password es invalido 
    } 
    else
        header("location:/index.php?error=TokenNoExist");
       //todo sergio, se produjo un error porque el token es nulo o no existe
}

?>
