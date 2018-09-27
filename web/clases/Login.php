<?php
session_start();
require_once 'Database.php';
require_once 'Session.php';
require_once 'User.php';
require_once 'Token.php';
class Login 
{
 public function getToken()
 {
   $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
   $token = md5(substr(md5(str_shuffle($alphanum)), 0, 30));
   return $token;
 }    
    
public function startLogin($time=3600, $user=NULL, $pass=NULL, $ctrl=NULL) {  
    try
    {
    $flag = true;
	$resultUser = 0;
	if ($user==NULL && $pass==NULL) 
	{
	   if (isset($_SESSION['iduser']))
	   {
	    $resultUser =  Session::checkSession($_SESSION['iduser']);
	    if($resultUser != 'false' && $resultUser != false) //si es distinto de false trae el user id
	      $flag = true;
	    else
		{
		 $flag = false;
		  if($ctrl != 4)
                      header("Location: /");
		  else
		    header("Location: ../../register.php?isRegister=true");
		}
	   }
	   else
       if (isset($_COOKIE['iduser']) && $_COOKIE['iduser']!= '')
       {
        $_SESSION['iduser']=$_COOKIE['iduser'];
	    $resultUser =  Session::checkSession($_SESSION['iduser']);
	    if($resultUser != 'false' && $resultUser != false) //q no exista un usuario = 0 porque se parte
	      $flag = true;
	    else
		{
		 $flag = false;
		  if($ctrl != 4)
                    header("Location: /");
		  else
		    header("Location: ../../register.php?isRegister=true");
		 }
	}
        else 
		{
		 $flag = false;
		 if ($flag == false && $ctrl != 2)
                  if($ctrl != 4)
                    header("Location: /");
		  else
		    header("Location: ../../register.php?isRegister=true");
                }
		 
		if ($flag == true && $ctrl != 1)
		{
                   header("Location:../../main.php");
                }
		
    } else {
        $this->check_user($time, $user, $pass, $ctrl);
    }
    }
     catch(Exception $e)
     {
         return false;
     }
}   
//  Verifica login
private function check_user($time, $user, $pass, $ctrl) {
    try 
    {
    $user = stripslashes($user);
    if($ctrl != 100)
     $pass = stripslashes($pass);
	
	if(!isset($_SESSION['iduser']))
	{
         if($ctrl != 100)
	   $resultExist = User::exist($user,$pass);
         else
           $resultExist = User::exist_md5($user,$pass);  
// If result matched, i.e exist==true then exist user-pass combination, therefore it will start with login
         if($resultExist==true){  
             
             //elimina sessiones viejas
             Session::deleteOldSessions($user); 
             $isActivated = User::IsActivateUserByUsername($user);
             $resultMail =  User::getEmailByUsername($user);
             $_SESSION['email'] = $resultMail;
             if($isActivated  == '0')
               header("Location:../../activeAccount.php");
             else
             {
                $session1 = new Session(NULL,$user,NULL,NULL);
                $result = $session1->create();
                //CREA UNA NUEVA SESION DE USUARIO QUE LA MANTIENE HASTA DESLOGUEARSE
                    if($result != false)
                    {
                       $_SESSION['iduser']=$result; //asigna a una varaible de session la sesion creada en la bd
                       $resultCheck =  Session::checkSession($_SESSION['iduser']);
                       if($resultCheck!=FALSE)
                       {
                           $token =$this->getToken();
                           //se inserta el token generado en la base
                           $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
                           $resultTokenOperation =  $resultToken->insertTokenOperation();
                           if($resultTokenOperation != false)
                           {
                             $_SESSION['tokenId']=$resultTokenOperation;
                             if(isset($_COOKIE['urlLog']) && $_COOKIE['urlLog']!= null && $_COOKIE['urlLog']!='')
                               header("Location:".$_COOKIE['urlLog']); 
                             else
                              if($ctrl != 100)
                              {
                                header("Location:../../main.php");
                              }
                           }
                           else
                              header("Location:../../index.php?error=tokenNoGenerado"); 
                       }
                        else
                            header( "Location: ../index.php?error=checkSession");
                    }
		    else
		      header( "Location: ../index.php?error=createSession" );
             }
         }
     else {
        // Si la clave es incorrecta
        header( "Location: ../index.php?error=ExistUser");
    }
	
 }
 else
 {
   $resultCheck =  Session::checkSession($_SESSION['iduser']);
   if($resultCheck!=FALSE)
   {
       header("Location:../../main.php");
   }
  }
  }
     catch(Exception $e)
     {
         return false;
     }
}

public function startLoginFacebook($faceid)
{
    try
    {
  if(isset($faceid))
  {
   $resultExistFB = User::existFaceId($faceid);
   if($resultExistFB == true)
   {
       $isActivated = User::IsActivateUserByFaceId($faceid);
       $resultMail =  User::getEmailByFaceId($faceid);
       $_SESSION['email'] = $resultMail;
       if($isActivated  == '0')
           header("Location:../../activeAccount.php");
       else
       {
	 $resultUserLogin = User::getUserLoginFB($faceid);
	 if($resultUserLogin != false)
	 {
          //elimina sessiones viejas
          Session::deleteOldSessions($faceid); 
 	  $session1 = new Session(NULL,$resultUserLogin,NULL,NULL);
	  $result = $session1->create();
	  //CREA UNA NUEVA SESION DE USUARIO QUE LA MANTIENE HASTA DESLOGUEARSE
	  if($result!=FALSE)
		{
		 $_SESSION['iduser']=$result; //asigna a una varaible de session la sesion creada en la bd
	         $resultCheck =  Session::checkSession($_SESSION['iduser']);
		 if($resultCheck!=FALSE)
		 {
                     $token =$this->getToken();
                     //se inserta el token generado en la base
                     $resultToken = new Token(NULL,$token,NULL,NULL,'operation',$_SESSION['iduser']);
                     $resultTokenOperation =  $resultToken->insertTokenOperation();
                     if($resultTokenOperation != false)
                     {
                       $_SESSION['tokenId']=$resultTokenOperation;
                       if(isset($_COOKIE['urlLog']) && $_COOKIE['urlLog']!= null && $_COOKIE['urlLog']!='')
                         header("Location:".$_COOKIE['urlLog']);
                       else
                       {  
                         header("Location:../../main.php");
                       }
                     }
                      else
                         header("Location:../../index.php?error=tokenNoGenerado"); 
                 }
		 else
		 header( "Location: ../index.php?error=checkSession");
		}
		else
		 header( "Location: ../index.php?error=createSession" );
    } else {
        // Si la clave es incorrecta
        header( "Location: ../index.php?error=ExistUser" );
    }
   }
  }
 else
 {
    header( "Location: ../register.php?faceid=".$faceid );
 }
  }
  }
     catch(Exception $e)
     {
         header( "Location: ../index.php?error=unknown" );
         return false;
     }
}
}
?>