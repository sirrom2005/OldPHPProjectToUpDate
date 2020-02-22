<?php
session_start();

function writeToFile($file, $content){
    if (!$handle = fopen($file, 'a')) {
            echo "Cannot open file ($file)";
            exit;
    }
    if (fwrite($handle, $content) === FALSE) {
            echo "Cannot write to file ($file)";
            exit;
    }
    fclose($handle);
}
function getHttpHeaders() { 
    $out = array();
    foreach($_SERVER as $key=>$value) { 
		if (substr($key,0,5)=="HTTP_" || in_array($key, array('REMOTE_ADDR', 'REQUEST_TIME'))) {  
			$out[$key]=($key=='REQUEST_TIME' ? date('d-m-Y H:i', $value) : $value); 
		} 
    } 
    return $out; 
} 

function pageLanding(){ 
	// Debug.
	writeToFile('classes/mobile_detect/ua.txt', print_r(getHttpHeaders(),true));
	// Check for mobile device.
	require_once 'classes/mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');

	if(isset($_SESSION['BBPINWORLD'])){
		if($detect->isMobile()){
			header('location: m/index.php');  exit();
		}
		else{
			header('location: index.php'); exit();
		}
	}

	if($detect->isMobile()){
		header('location: m.login.php');
	}
	else{
		header('location: login.php');
	}
}

pageLanding();
?>