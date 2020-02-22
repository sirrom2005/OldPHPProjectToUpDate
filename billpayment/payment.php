<?php 
session_start(); 
if(empty($_SESSION['DATA'])){ header("location: /billpayment/");}
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/software.class.php");

$obj = new software();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<title>Telstar Cable Ltd. | Bill Payment</title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/blueprint/src/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/blueprint/src/grid.css" />
	<link rel="stylesheet" type="text/css" href="css/blueprint/src/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/blueprint/src/ie.css" />
	<link rel="stylesheet" type="text/css" href="css/blueprint/src/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/style.payment.css" />
	
</head>
<body>
<div class="container">
	<div class="span-24 last top">
		<ul class="menu">
			<li><a href="http://www.telstarjamaica.com/">Home</a></li>
			<li>|</li>
			<li><a href="http://telstarjamaica.com/about-us.html">About Us</a></li>
			<li><span class="separator">|</li>
			<li><a href="http://telstarjamaica.com/services.html">Services</a></li>
			<li><span class="separator">|</li>
			<li><a href="http://telstarjamaica.com/support.html">Support</a></li>
			<li><span class="separator">|</li>
			<li><a href="http://telstarjamaica.com/contact-us.html">Contact Us</a></li>
		</ul><!-- menu -->
	

		<a href="http://www.telstarjamaica.com" title="Telstar Cable Ltd." class="logo">
			<img src="images/logo.jpg" alt="Telstar Logo"/>
		</a>
	</div><!-- top -->
	
		<?php
			if( !empty($_GET['err']) ){$errCode = base64_decode($_GET['err']);}
			
			$str = "";
			if(empty($errCode))
			{
				//Payment Successful;
				ob_start();
				$country = $obj->getCountryByCode($_SESSION['DATA']['card_country']);
				$billingAddress = "<b>".$_SESSION['DATA']['card_name']."</b><br>".$_SESSION['DATA']['card_address1']."<br>".$_SESSION['DATA']['card_address2']."<br>".$_SESSION['DATA']['card_city']."<br>".$_SESSION['DATA']['card_state']."<br>".$_SESSION['DATA']['card_zip']."<br>".$country['name'];
				
				$clientId = $_SESSION['DATA']['client_id'];
				for($c=strlen($clientId); $c<6; $c++){ $ph .="0"; } 
				$clientId  = $ph.$clientId;
				
				include_once("receipt_templetes.html");
				
				$cachecontents=ob_get_contents();
				$cachecontents = str_replace("_CUSTOMER_NAME_", $_SESSION['DATA']['card_name'],$cachecontents);
				$cachecontents = str_replace("_CUSTOMER_ID_", $clientId,$cachecontents);
				$cachecontents = str_replace("_ORDER_ID_", $_SESSION['DATA']['orderID'],$cachecontents);
				$cachecontents = str_replace("_CARD_TYPE_", ucfirst($_SESSION['DATA']['card_type']),$cachecontents); 
				$cachecontents = str_replace("_CARD_LAST5_DIGITS_", ucfirst($_SESSION['DATA']['card_number']),$cachecontents);
				$cachecontents = str_replace("_BILLING_ADDRESS_", $billingAddress, $cachecontents);
				$cachecontents = str_replace("_PRICE_", $_SESSION['DATA']['currency_symbol']."(".strtoupper($_SESSION['DATA']['currency']).") ".$_SESSION['DATA']['card_amount'],$cachecontents);
				ob_get_clean();
				if($_SESSION['DATA']['senmail']=="text")
				{
						include_once("payment_templete_txt.txt");
						$billingAddress = str_replace("<br>", "\r\n", $billingAddress);
						$billingAddress = strip_tags($billingAddress);
						
						$cacheEmailContents = str_replace("_DATE_", date("Y-m-d"),$cacheEmailContents);
						$cacheEmailContents = str_replace("_DATE2_", date("Ymd"),$cacheEmailContents);
						$cacheEmailContents = str_replace("_CUSTOMER_NAME_", $_SESSION['DATA']['card_name'],$cacheEmailContents);
						$cacheEmailContents = str_replace("_CUSTOMER_ID_", $clientId,$cacheEmailContents);
						$cacheEmailContents	= str_replace("_ORDER_ID_", $_SESSION['DATA']['orderID'],$cachecontents);
						$cacheEmailContents = str_replace("_CARD_TYPE_", ucfirst($_SESSION['DATA']['card_type']),$cacheEmailContents); 
						$cacheEmailContents = str_replace("_CARD_LAST5_DIGITS_", ucfirst($_SESSION['DATA']['card_number']),$cacheEmailContents);
						$cacheEmailContents = str_replace("_BILLING_ADDRESS_", $billingAddress, $cacheEmailContents);
						$cacheEmailContents = str_replace("_PRICE_", $_SESSION['DATA']['currency_symbol']."(".strtoupper($_SESSION['DATA']['currency']).") ".$_SESSION['DATA']['card_amount'],$cacheEmailContents);
				}
				else
				{
					$cacheEmailContents = $cachecontents;
				}
			
				echo $cachecontents;
				echo "<p align='center'>A copy of this transaction receipt has been sent to the email address you specified, please print and retain your copy.<br>(If Telstarjamaica is not added to your contact list email may be in your junk mail inbox.)</p>";
				
				$subject = "Telstarjamaica receipt for billpayment."; 
				$header = "";
				if($_SESSION['DATA']['senmail']=="html"){$header  .= 'MIME-Version: 1.0' . "\r\n"; $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";}
				
				$header .= "From: no-reply@telstarjamaica.com\r\n";
				
				@mail($_SESSION['DATA']["email"], $subject, $cacheEmailContents, $header);
			}
			else
			{
				if($errCode == 2)
				{
					$str = "Fraudulent payment.";
				}
				elseif($errCode == 1)
				{
					$str = "This card is invalid.";
				}
				else
				{
					$str = "Payment Failed.";
				}
				echo "<h1>$str</h1>";
				echo "<b>Error-Msg:</b> $str Please contact your bank.";
			}
		?>
			
        <div class="span-24 last footer">
            <div class="span-18 left">
                Copyright &copy; 2009 - <?php echo date('Y'); ?> Telstar Cable Ltd. | <a href="http://www.telstarjamaica.com/terms.php">Terms &amp; Conditions</a> | <a href="http://www.telstarjamaica.com/privacy.php">Privacy Policy</a>
            </div>
            <div class="span-5 last right">
                Site Developed by <a href="http://www.thesecoya.com" title="Secoya" target="_blank"><img src="images/secoya.gif"></a>
            </div>
		</div><!-- footer -->	
	</div><!-- content-area -->
</div><!-- container -->
</body>
</html>