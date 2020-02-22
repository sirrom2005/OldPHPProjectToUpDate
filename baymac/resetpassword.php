<?php
require_once("inc/core.php");
$objCore = new Core();
$objCore->initSessionInfo();
if(isset($_GET['email']) && isset($_GET['c'])){
	$retval = $objCore->confirmResetPasswordData($_GET['email'],$_GET['c']);
	if($retval == 1){
		$objCore->setSessionVariable('emailreset',urldecode($_GET['email']));
		header("Location: login.php?reset=1");
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
