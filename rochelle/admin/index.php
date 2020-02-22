<?php
	session_start();
	include_once('../config/config.php');
	include_once('../classes/functions.php');
	include_once('../classes/mySqlDB__.class.php');
	include_once('../classes/commonDB.class.php');
	$page = ( isset($_GET['p']) && file_exists('includes/'.$_GET['p'].'.php') )? $_GET['p'] : 'home';
	$obj = new commonDB();
?>
<!DOCTYPE html>
<html>
<head>
<title>CMS</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="contianer">
	<div id="header">
    	<span class="topmenu">Welcome: <a href="?p=profile" title="edit my profile">jodi</a> | <a href="?p=change-pass" title="change my password">Change password</a> | <a href="?p=logout" title="log out of system">Log out</a></span>
    	<h2>Excellence in healthcare is our minimum standard</h2>       
         <div id="menu">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="?p=manage-articles">Manage Articles</a></li>
           </ul>
          </div>
    </div>
    <div id="content"><?php include_once('includes/'.$page.'.php'); ?></div>
    <div id="footer"></div>
</div>
</body>
</html>