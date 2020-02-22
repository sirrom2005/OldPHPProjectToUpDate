<?php 
$current = "music";
if(empty($_SESSION['TRANSACTION'])){ header("location: index.html"); exit();}
include_once("templates/payment_templete.txt"); 
$credit = $comObj->getDataById("odb_credit_cost",$_SESSION['TRANSACTION']['credit_id']);

$address = "";
$address .= $_SESSION['TRANSACTION']['card_address1']."\r";
$address .= $_SESSION['TRANSACTION']['card_address2']."\r";
$address .= $_SESSION['TRANSACTION']['card_city']."\r";
$address .= $_SESSION['TRANSACTION']['card_state']."\r";
$address .= $_SESSION['TRANSACTION']['card_zip']."\r";
$address .= $_SESSION['TRANSACTION']['card_country']."\r";

$cardNumber = trim(str_replace("-","",$_SESSION['TRANSACTION']['card_number']));
$cardNumber = substr($cardNumber,strlen($cardNumber)-5,strlen($cardNumber));

$cacheEmailContents = str_replace("_DATE_", date("M-d-Y"), $cacheEmailContents);
$cacheEmailContents = str_replace("_BILLING_ADDRESS_", $address, $cacheEmailContents);
$cacheEmailContents = str_replace("_CARD_TYPE_", ucfirst($_SESSION['TRANSACTION']['card_type']), $cacheEmailContents);
$cacheEmailContents = str_replace("_EMAIL_", $_SESSION['TRANSACTION']['email'], $cacheEmailContents);
$cacheEmailContents = str_replace("_CUSTOMER_NAME_", $_SESSION['TRANSACTION']['card_name'], $cacheEmailContents);
$cacheEmailContents = str_replace("_CARD_LAST5_DIGITS_", $cardNumber, $cacheEmailContents);
$cacheEmailContents = str_replace("_POINTS_", $credit['credit'], $cacheEmailContents);
$cacheEmailContents = str_replace("_ORDER_ID_", $_SESSION['TRANSACTION']['orderID'], $cacheEmailContents); 
$cacheEmailContents = str_replace("_PRICE_", number_format($_SESSION['TRANSACTION']['card_amount'],2,".",","), $cacheEmailContents);
$cacheEmailContents = str_replace("_DOMAIN_", DOMAIN, $cacheEmailContents);
//$cacheEmailContents = str_replace("\r", "<br>", $cacheEmailContents);
//echo $cacheEmailContents;
?>
<span class="msg">Please don't click the back button or refress this page.</span>
<h1>Payment sucessfull</h1>
<p><?php echo $credit['credit'];?> credit points was susefully added to your account.</p>
<p align='center'>
Your transaction receipt was sent to the email address, please print or retain your copy.<br>
(email may be in your junk mail inbox.)
</p>
<?php 
	$rs = $siteObj->addCredits($credit['credit']);
	if(!empty($rs))
	{
		$header  = 'MIME-Version: 1.0' . "\r\n";
		//$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From:mp3store no-reply@mp3store.com\r\n";
		
		@mail($_SESSION['TRANSACTION']['email'],"Payment receipt",$cacheEmailContents,$header);
		unset($_SESSION['TRANSACTION']);
		$_SESSION['USER']['credit_amount'] = (int)$rs['credit_amount'];
	}
?>