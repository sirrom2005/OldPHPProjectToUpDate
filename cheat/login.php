<?php 
session_start();
echo "<a href='includes/clearsessions.php'>clear<a/>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>

<style>
body, h3, form{margin:0;}
#container{margin:2% 15%;border:solid 1px #333333; padding:10px; text-align:center;}
#login{background-color:#E5E5E5; display:inline-block; border:solid 1px #003366; margin-bottom:10px; padding:0 10px 10px 10px;}
a.fb{background:url(images/facebook_signin.png) no-repeat;display:inline-block; width:150px; height:22px; margin-bottom:5px;}
a.tw{background:url(images/twitter_signin.png) no-repeat; display:inline-block; width:150px; height:22px;}
a.fb:hover,a.tw:hover{background-position:0 -24px;}
p{margin:0 0 5px 0;}
</style>
</head>

<body>

<div id="container">
	<form name="f" method="post" action="" id="login">
    	<h3>Login</h3>
    	<p>username <input type="text" name="username" value="" /></p>
        <p>password <input type="password" name="username" value="" /></p>
        <p><input type="submit" value="login" /></p><hr />   
        <a class="fb" href="#" title="login with your facebook account" onclick="open('https://www.facebook.com/login.php?api_key=140831285963477&cancel_url=http://cheats.rohanmorris.net/includes/error.php&display=page&fbconnect=1&next=http://cheats.rohanmorris.net/includes/facebook_callback.php&return_session=1&session_version=3&v=1.0', 'facebook', 'height=500,with=300,location=no,menubar=no,resizable=no,status=no,titlebar=no,toolbar=no');"></a>
        <br /><a class="tw" href="#" title="login with your twitter account" onclick="open('includes/twitter_login.php', 'twitter', 'height=500,with=300,location=no,menubar=no,resizable=no,status=no,titlebar=no,toolbar=no');" ></a>
    </form>
</div>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId   : '<?php echo $facebook->getAppId(); ?>',
      session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
      status  : true, // check login status
      cookie  : true, // enable cookies to allow the server to access the session
      xfbml   : true // parse XFBML
    });

    // whenever the user logs in, we refresh the page
    FB.Event.subscribe('auth.login', function() {
      window.location.reload();
	  //window.location = "http://www.videouploader.net/vci/";
    });
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
</body>
</html>
