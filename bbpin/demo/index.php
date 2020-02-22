<?php
/*include_once("config/config.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
$menuLinks = $obj->getMenuLinks();
$ftrLinks  = $obj->getWebSiteLinks(10);

//echo "<pre>";print_r($menuLinks);
$page = (isset($_GET['action']))? $_GET['action'].'.php' : "home.php";*/
define("DOMAIN", "http://127.0.0.1/bbpin/demo/");
include_once("HTML_LAYOUT.php");
?>