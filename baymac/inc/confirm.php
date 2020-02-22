<?php
/*****************************************************
* New user confirmation page. Should only get here *
* from an email link. *
*****************************************************/
include("dbcontroller.php");

if((isset($_GET['hash']))&&(isset($_GET['email']))){
    $dbcontroller = new DBController();
	
    $worked = $dbcontroller->user_confirm($_GET['email'],$_GET['hash']);
	
    if ($worked == 1) {
        header("Location: ../index.php?action=confirm");
        exit();
    } 
} else {

    header("Location: ../index.php");
}

