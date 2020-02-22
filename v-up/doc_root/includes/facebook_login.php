<?php
session_start();
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");
require_once('../classes/facebook/facebook.php');

$obj = new site();

/*FACEBOOK*/
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '136619716380889',
  'secret' => 'ac2c464295197dcdf2881d52b4ff1f06',
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

// login or logout url will be needed depending on current user state.
if($me) 
{
	$usname = str_replace(" ", "", strtolower($me['first_name']));
	$usname .= '_fb';
	$_SESSION['ADMIN_USER'] = $obj->OAuthConnetion($me['id'], $usname);
	header("location: /vci/");
}
?>