<?php
/* Start session and load library. */
session_start();
require_once('twitteroauth.php');
define('CONSUMER_KEY', '2thGmJ6tk1HSJiFyH7w3A');
define('CONSUMER_SECRET', 'AI1FAQs0czjXVcriCi510BFO7Wqruym3ho15j6i1g');
define('OAUTH_CALLBACK', 'http://www.jusbbmpin.com/classes/twitteroauth/callback.php');
/* Build TwitterOAuth object with client credentials. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

/* Get temporary credentials. */
$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
/* If last connection failed don't display authorization link. */
switch ($connection->http_code) {
  case 200:
    /* Build authorize URL and redirect user to Twitter. */
    $url = $connection->getAuthorizeURL($token);
    header('Location: ' . $url); 
    break;
  default:
    /* Show notification if something went wrong. */
    echo 'Could not connect to Twitter. Refresh the page or try again later.';
}
?>