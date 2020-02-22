<?php
session_start(); 
session_destroy();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/software.class.php");

$obj = new software();

$country = $obj->getCountry();
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

	<div class="span-14 last content-area">
	<h1>Bill Payment</h1>

<?php
	$ipAddress		= $_SERVER['REMOTE_ADDR'];
	$currency		= "jmd";
	$client_id		= (!empty($_GET['id']) )? $_GET['id']  : NULL ;
	$client_id		= str_replace("001-", "", $client_id );
	$card_amount	= (!empty($_GET['amt']))? $_GET['amt'] : NULL ;
	$card_amount	= str_replace("$", "", $card_amount );
	$card_amount	= str_replace(",", "", $card_amount );
?>
<form method="post" action="api/plugnpay.php" name="plugnpay" id="plugnpay">
	<input type="hidden" name="publisher_name" value="telstarcab" />
	<input type="hidden" name="publisher_email" value="telstarcsr@telstarjamaica.com" />
	<input type="hidden" name="ipaddress" value="<?php echo $ipAddress;?>" />
	<input type="hidden" name="card-allowed" value="Visa,Mastercard,Keycard" />
	<input type="hidden" name="currency_symbol" value="$" />
	<input type="hidden" name="currency" value="<?php echo $currency;?>" />
    <input name="mode" value="auth" type="hidden">
	<!--input type="hidden" name="order-id" /-->
	<table class="bill-payment">
		<tr><td>Telstar Account No.:</td><td><input type="text" name="client_id" value="<?php echo $client_id;?>"  maxlength="6" size="12" onkeypress="return numberOnly(event, false)" /> <small>Enter the last six digits.</small></td></tr>
		<tr><td>Telstar Account Name:</td><td><input type="text" name="telstar_account_name" value="" size="30" maxlength="30"  /></td></tr>
        <tr><td>Amount (<acronym title="Jamaican Dollars">JMD</acronym>$):</td>
        <td><input type="text" name="card_amount" value="<?php echo $card_amount;?>" maxlength="9" size="12" onkeypress="return priceOnly(event, false)" /></td>
        </tr>
		<tr><th colspan="2">Billing Address</th></tr>
		<tr><td>Name:</td><td><INPUT type="text" name="card_name" value="" size="30" maxlength="50"> <small>Full name as it appears on Credit Card.</small></td></tr>
		<tr><td>Address1:</td><td><INPUT type="text" name="card_address1" value="" size="30" maxlength="30"></td></tr>
		<tr><td>Address2:</td><td><INPUT type="text" name="card_address2" value="" size="30" maxlength="30"></td></tr>
		<tr><td>City:</td><td><INPUT type="text" name="card_city" value="" size="30" maxlength="30"></td></tr>
		<tr><td>State:</td><td><INPUT type="text" name="card_state" value="" size="30" maxlength="30"></td></tr>
		<tr><td>Zip-Code:</td><td><INPUT type="text" name="card_zip" value="" size="30" maxlength="30"></td></tr>
		<tr><td>Country:</td>
        	<td>                
				<select name="card_country">
				<?php foreach($country as $row){?>
				<option value="<?php echo $row['iso_code_2'];?>"><?php echo cleanString($row['name']);?></option>
				<?php }?>
				</select>
            </td>
        </tr>
		<tr><td>Email:</td><td><input type="text" name="email" value="" size="30" /> <small>A copy of receipt will be sent here.</small></td>
        <tr><td>Send email receipt as:</td><td><input name="senmail" type="radio" value="html" checked="checked" />
        Html</td></tr>
		<tr><th colspan="2">Card Information</th></tr>
		<tr><td>Card Type:</td><td>
		<input type="radio" name="card_type" value="visa" checked="checked" id="visa" />
		<label for="visa">VISA</label> 
		<input type="radio" name="card_type" value="keycard" id="keycard" />
		<label for="keycard">Keycard</label>
		<input type="radio" name="card_type" value="mastercard" id="mastercard" />
		<label for="mastercard">MasterCard</label> 
		</td></tr>
		<tr><td>Card Number:</td><td><INPUT type="text" name="card_number" size="30" maxlength="30" onkeypress="return numberOnly(event, false)"></td></tr>
		<tr><td>Card Expiration Date:</td><td><INPUT type="text" name="card_exp" size="4" maxlength="5"> <small>(MM/YY)</small></td></tr>
		<tr><td>CVV:</td><td><INPUT type="password" name="card_cvv" size="4" maxlength="3"> <small>3 digit code on back of card.</small></td></tr> 
		<tr><td colspan="2" class="buttons"><input type="button" value="Pay Now" class="pay-now" onclick="validat();" /> &nbsp; <a href="http://www.telstarjamaica.com" class="cancel">Cancel</a></td></tr>
	</table>
	
</form>
<script language="javascript">
	var visacardcode   = new Array("4543");
	var mastercardcode = new Array("5430");

	function validat()
	{
		var ele = document.plugnpay;
		var valid = true;
		var str   = "";
		if( isEmpty(ele.client_id.value) )
		{
			str += "Client ID is required.\n";
			valid = false;
		}
		if( isEmpty(ele.card_amount.value) )
		{
			str += "Payment amount is required.\n";
			valid = false;
		}
		if( isEmpty(ele.card_name.value) )
		{
			str += "Card holder name is required.\n";
			valid = false;
		}
		if( isEmpty(ele.card_address1.value) )
		{
			str += "Billing Address is required.\n";
			valid = false;
		}
		if( isEmpty(ele.card_number.value) )
		{
			str += "Credit card number is required.\n";
			valid = false;
		}
		if( isEmpty(ele.card_exp.value) )
		{
			str += "Credit card expire date is required.\n";
			valid = false;
		}
		if(!isEmailValid(ele.email.value) )
		{
			str += "Invalid E-mail.\n";
			valid = false;
		}

		if(ele.card_type[0].checked || ele.card_type[2].checked)
		{
			if(ele.card_type[0].checked)
			{
				//visa with mastercard code
				var cardnumber = ele.card_number.value;
				cardnumber = cardnumber.slice(0,4);
				for(var i=0;i<mastercardcode.length;i++)
				{
					if( cardnumber.indexOf(mastercardcode[i])!= -1)
					{
						str += "Card number does not match card type.\n";
						valid = false;
					}
				}
			}
			if(ele.card_type[2].checked)
			{
				//mastercard with visa code
				var cardnumber = ele.card_number.value;
				cardnumber = cardnumber.slice(0,4);
				for(var i=0;i<mastercardcode.length;i++)
				{
					if( cardnumber.indexOf(visacardcode[i])!= -1)
					{
						str += "Card number does not match card type.\n";
						valid = false;
					}
				}
			}
		}
		
		if(valid)
		{ele.submit();}	
		else
		{alert(str);}	
	}
	
	function rTrim(sString)
	{
		while (sString.substring(sString.length-1, sString.length) == ' ')
		{
		sString = sString.substring(0,sString.length-1);
		}
		return sString;
	}
	
	function lTrim(sString)
	{
		while (sString.substring(0,1) == ' ')
		{
		sString = sString.substring(1, sString.length);
		}
		return sString;
	}
	
	function Trim( sString )
	{
		return lTrim( rTrim(sString) );
	}
	
	function isEmpty( ele )
	{
		ele = Trim(ele);
		if( ele == "" || ele == null )
			return true;	
		return false;
	}
	
	function priceOnly(e, decimal) 
	{
		var key;
		var keychar;
	
		if (window.event) {
		   key = window.event.keyCode;
		}
		else if (e) {
		   key = e.which;
		}
		else {
		   return true;
		}
		keychar = String.fromCharCode(key);
		
		if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
		   return true;
		}
		else if ((("0123456789.").indexOf(keychar) > -1)) {
		   return true;
		}
		else if (decimal && (keychar == ".")) {
		  return true;
		}
		else
		   return false;
	}
	function numberOnly(e, decimal) 
	{
		var key;
		var keychar;
	
		if (window.event) {
		   key = window.event.keyCode;
		}
		else if (e) {
		   key = e.which;
		}
		else {
		   return true;
		}
		keychar = String.fromCharCode(key);
		
		if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
		   return true;
		}
		else if ((("0123456789").indexOf(keychar) > -1)) {
		   return true;
		}
		else if (decimal && (keychar == ".")) {
		  return true;
		}
		else
		   return false;
	}
	function isEmailValid(str) 
    {
		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    //alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    //alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
}
</script>
	
	<div class="span-14 last verified">
		<script type="text/javascript" src="https://sealserver.trustwave.com/seal.js?style=normal"></script><br /> <!-- to be replaced with script from verisign -->
		<a href="" target="_blank" title="visa"><img src="images/visa.gif" alt="visa" /></a>
		<a href="" target="_blank" title="ncb keycard"><img src="images/keycard.gif" alt="keycard" /></a>
		<a href="" target="_blank" title="mastercard"><img src="images/mastercard.gif" alt="mastercard" /></a>
	</div>
	
	</div><!-- content-area -->
	
	<div class="span-24 last footer">
	
		<div class="span-18 left">
			Copyright &copy; 2009 - <?php echo date('Y'); ?> Telstar Cable Ltd. | <a href="http://www.telstarjamaica.com/terms.php">Terms &amp; Conditions</a> | <a href="http://www.telstarjamaica.com/privacy.php">Privacy Policy</a>
		</div>
		<div class="span-5 last right">
			Site Developed by <a href="http://www.thesecoya.com" title="Secoya" target="_blank"><img src="images/secoya.gif"></a>
		</div>
		
	</div><!-- footer -->
	
</div><!-- container -->
</body>
</html>
