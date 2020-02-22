<?php
session_start();
require_once("../classes/facebook/facebook.php");

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId' => '140831285963477',
  'secret' => 'e6d3809baeb406e283a70dcc28f801ea',
  'cookie' => true,
));

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');
if($me)
{
	$_SESSION['USER'] = $me;
}
?>
<script>
	opener.focus();
	opener.location.reload();
	window.close();
</script>