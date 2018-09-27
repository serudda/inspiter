// JavaScript Document
$(document).ready(function(){

//global variables
var flag = false;
			
 (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '392076184181252', // App ID
          channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });

        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook
            FB.api('/me', function(me){
              if (me.id) {
				if (flag == true)
				{
				 var result = validateFaceid(me.id);
				 if(result == true)
				 { fqlQuery();}
				 else
				 {
				   var url = "../web/checkLogin.php?faceid="+me.id;
                   $(location).attr('href',url);
				  }
				 }
              }
            })
          } else {
            // user has not auth'd your app, or is not logged into Facebook
           // document.getElementById('auth-loggedout').style.display = 'block';
           // document.getElementById('auth-loggedin').style.display = 'none';
          }
        });
 } 
 
 });
 
  function mensaje()
  {
		  FB.api('/me', function(me){
              if (me.id) {
				 alert('buenisimo');
              }
			  else
			  {
				  FB.login();
				  flag = true;
			  }
        });
		} 



