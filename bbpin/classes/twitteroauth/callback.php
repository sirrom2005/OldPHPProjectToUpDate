<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/*Start session and load lib */
session_start();
require_once('twitteroauth.php');
define('CONSUMER_KEY', '2thGmJ6tk1HSJiFyH7w3A');
define('CONSUMER_SECRET', 'AI1FAQs0czjXVcriCi510BFO7Wqruym3ho15j6i1g');
define('OAUTH_CALLBACK', 'http://www.jusbbmpin.com/classes/twitteroauth/callback.php');
//require_once('config/config.php');
//include_once("classes/mySqlDB__.class.php");
//include_once("classes/site.class.php");

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
	session_destroy();
  	header('Location: http://www.jusbbmpin.com');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
	$_SESSION['status'] = 'verified';

	if(isset($_SESSION['access_token']))
	{
		$access_token = $_SESSION['access_token'];
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		/* If method is set change API call made. Test is called by default.*/
		//$content = $connection->get('account/verify_credentials');
		if(!empty($access_token))
		{
			//ADD MY LOGIN CODE HERE
			$_SESSION['ADMIN_USER'] = $obj->OAuthConnetion($access_token['user_id'], $access_token['screen_name']);
			header('Location: http://www.jusbbmpin.com/index.php');
		}
	}
}
else
{
	/* Save HTTP status for error dialog on connnect page.*/
	session_destroy();
  	header('Location: http://www.jusbbmpin.com');
}