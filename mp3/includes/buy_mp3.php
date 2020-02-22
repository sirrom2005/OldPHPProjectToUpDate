<?php 
	if(empty($_POST)){header("location: index.html"); exit();}
	$rs = $siteObj->runPaymentTransaction($_SESSION['CARTITEM']);
	if($rs == 1)
	{
		/*GOOD*/
		$result = $comObj->getDataById("odb_account",$_SESSION['USER']['id']);
		$_SESSION['USER']['credit_amount'] = $result['credit_amount'];
		header("location: buy_mp3_success.html");
	}
	if($rs == 2){/*NOT ENUFF CREDITS*/ header("location: page.php?action=buy_mp3_error&er=".base64_encode(2));}
	if($rs == 3){/*SOME ERROR*/ header("location: page.php?action=buy_mp3_error&er=".base64_encode(3));}
?>