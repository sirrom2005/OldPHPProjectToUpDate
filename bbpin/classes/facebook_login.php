<?php
require_once('facebook/facebook.php');
/*FACEBOOK*/
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '403128376414775',
  'secret' => 'd1ddb3afab7b46b3da13694b2d876aec',
  'cookie' => true,
));

$session = $facebook->getSession();

$me = NULL;
// Session based API call.
if ($session) {
  try {
	$uid = $facebook->getUser();
	$me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
	error_log($e);
  }
}

$logoutUrl = $facebook->getLogoutUrl();
$loginUrl = $facebook->getLoginUrl();
?>