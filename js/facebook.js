    window.fbAsyncInit = function() {
        FB.init({appId: '392076184181252', status: true, cookie: true, xfbml: true});
		/* All the events registered */
     FB.Event.subscribe('auth.login', function(response) {
         // do something with response
         login();
     });
     FB.Event.subscribe('auth.logout', function(response) {
         // do something with response
         logout();
     });
 
     FB.getLoginStatus(function(response) {
         if (response.session) {
             // logged in and connected user, someone you know
             login();
         }
     });
    };
	
    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
	
    function login(){
                FB.api('/me', function(response) {
                   // document.getElementById('login').style.display = "block";
                   //document.getElementById('login').innerHTML = response.name + " succsessfully logged in!";
				   var loginto = false;
                });
            }
    function logout(){
                //document.getElementById('login').style.display = "none";
				var logouto = false;
            }
			
    function userInfo(){
            FB.api('/me', function(response) {
					
			$.post("post.php", { 
								bio: response.bio,
								birthday: response.birthday,
								email: response.email,
								first_name: response.first_name,
								last_name: response.last_name,
								name: response.name,
								gender: response.gender, 
								id: response.id 
								},
   function(data) {
     alert("Data Loaded: " + data);
   });                  
   });
    }
 
            //stream publish method
    function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
            FB.ui(
            {
               method: 'stream.publish',
               message: '',
               attachment: {
               name: name,
               caption: '',
               description: (description),
               href: hrefLink
              },
              action_links: [
              { text: hrefTitle, href: hrefLink }
               ],
              user_prompt_message: userPrompt
             },
            function(response) {
 
                });
            }
            
	function showStream(){
             FB.api('/me', function(response) {
                 //console.log(response.id);
                 //streamPublish(response.name, 'inspiter', 'Inspiter', 'http://www.inspiter.com', "Compartir desde inspiter");
		         streamPublish("la vida me castigo y me seguira castigando", 'Anonimous', 'Inspiter', 'http://www.inspiter.com', "Compartir desde inspiter");
                });
            }
			
	function allUser(){
             FB.api('/me', function(response) {
             console.log(response);
	          //document.getElementById('name').innerHTML = response
              });
            }
			
	function showStatus(){
             FB.getLoginStatus(function(response) {
             if (response.session) {
	        //document.getElementById('name').innerHTML = response.session;
             console.log(response.session);
             } else {
             console.log('not connectted');
             }
            });
            }
			
			
    function friends(){
	$('.link').click(function(){
	//alert();
    var publish = {
    method: 'friends',
    id: $(this).attr("title")
    };
 
    FB.ui(publish);
		return false;		
	});
    }
	
	function share(){			
			 FB.ui({
    method: 'stream.share',
    u: 'http:www.twitter.com/'
    }, 
    function(response) { alert(response); }
    );
    }
 
    function graphStreamPublish(){
         var body = '<b>"La vida es bella"</b>';
         FB.api('/me/feed', 'post', { message: body }, function(response) {
         if (!response || response.error) {
           alert('Error occured');
         } else {
           alert('la frase fue inspirada correctamente');
             }
            });
           }
 
    function fqlQuery(){
        FB.api('/me', function(response) {
	    var InputName = $("#inputName");
        var query = FB.Data.query('select uid, name, pic_square, email, current_location, username from user where uid=me() or uid IN (select uid2 from friend where uid1=me())', response.id);
        query.wait(function(rows) {
	            bandera = true;
                         /*'<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";*/
						 document.getElementById('fimage').value = rows[0].pic_square;
						 document.getElementById('inputUsername').value = rows[0].username;
						 document.getElementById('inputName').value = rows[0].name;
						 document.getElementById('inputEmail').value = rows[0].email;
						 document.getElementById('inputCountry').value = rows[0].current_location.country;
						 document.getElementById('inputCity').value = rows[0].current_location.city;
						 document.getElementById('fid').value = rows[0].uid;
						 InputName.focus();
                     });
                });
            }
	 
	  function getPhoto(pHeight,pWidth)
	  {
		   FB.api('/me', function(response) {
	    var InputName = $("#inputName");
        var query = FB.Data.query('select url, real_width, real_height from profile_pic where id=me() and width=270 and height=230', response.id);
        query.wait(function(rows) {
	          
                         /*'<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";*/
                    document.getElementById('').value = rows[0].url;
                     });
                });
            }
				  
	function fqlQueryLogin(){
        FB.api('/me', function(response) {
        var query = FB.Data.query('select uid, name, pic_square, email, current_location, username from user where uid=me() or uid IN (select uid2 from friend where uid1=me())', response.id);
        query.wait(function(rows) {       
			       return rows[0].uid;
                     });
                });
            }
	 
	 
    function setStatus(){
          //status1 = document.getElementById('status').value;
	      status1 = true;
          FB.api(
            {
             method: 'status.set',
             status: status1
             },
           function(response) {
             if (response == 0){
                alert('Your facebook status not updated. Give Status Update Permission.');
                }
             else{
                   alert('Your facebook status updated');
                 }
             }
            );
          }
			
	function showFriends(){		
	   FB.api('/me', function(response) {
	   var query = FB.Data.query('select uid, name, pic_square, email from user where uid=me() or uid IN (select uid2 from friend where uid1=me())', response.id);
	   query.wait(function(rows) {
		http://www.facebook.com/profile.php?id= 
		 console.log(rows);
		 var html = '';
		   FB.Array.forEach(query.value, function(rows) {
		   html += '<div class="friends"><p>' + rows.name + '</p>' + '<a class="link" title="' + rows.uid + '" href="http://www.facebook.com/profile.php?id=' + rows.uid + '" onclick="friends(); return false;">link</a>' +
		  '<img src="' + rows.pic_square + '"></div>';
		   });
		 //document.getElementById('display').innerHTML = html;
		 });
		});
    	}
