<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$contentPage 	= $obj->getContentPage("advertising");
	$classAdvertising= "selected";
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Advertising with us ";
	
	$str = "<p>&nbsp;</p>
		<form name=\"ads\" method=\"get\" action=\"".DOMAIN."advertising_order.html\">
			<input type=\"submit\" value=\"Order Now!!\" />
		</form>";
		
	$contentPage['detail'] = $contentPage['detail'].$str;
		
	include_once("page_tmp.php");
?>