<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();

$user = $_GET['user'];
$pass = $_GET['pass'];
$rt = $obj->userLogin($user,$pass);
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<profile id="'.$rt.'" title="jusbbmpins.com xml feed" publisher="jusbbmpins.com | Iceman"> ';
echo '</profile>'; 
?>