// JavaScript Document
$(document).ready(function(){
//global variables
        // respond to clicks on the login and logout links
        document.getElementById('auth-loginlink').addEventListener('click', function(){
		   FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
          var uid = response.authResponse.userID;
          var accessToken = response.authResponse.accessToken;
	    
		  document.getElementById('faceid').value = response.authResponse.userID;
		  var url = "../web/checkLogin.php?faceid="+document.getElementById('faceid').value;  
          $(location).attr('href',url);     
	   
      } else if (response.status === 'not_authorized') {
          
    // the user is logged in to Facebook, 
    // but has not authenticated your app
	   var url1 = "/register.php";  
          $(location).attr('href',url1); 
      } else {
         
    FB.login(function(response) {
	   if(response.authResponse) {
	    document.getElementById('faceid').value = response.authResponse.userID;
		var url = "../web/checkLogin.php?faceid="+document.getElementById('faceid').value;  
        $(location).attr('href',url);
		}
      },// Aquí es donde especificamos los permisos que queremos obtener                 
       {scope: 'email,publish_stream,user_birthday'});
  }
 }, {scope: 'email,publish_stream,user_birthday'});
		 
    }); 
	
 }); 
