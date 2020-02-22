<?php
$current = "credit";
$title = "Buy Credits";
if(empty($_SESSION['USER'])){ echo "<span class='err'>You must <a href='control/'>login</a> to make your purchase.</span>"; return;}
$credits = $comObj->getData("odb_credit_cost",NULL,"credit","ASC");
$country = $comObj->getData("odb_country",NULL,NULL,"ASC");
$result  = $comObj->getDataById("odb_account",$_SESSION['USER']['id']);
?>
<script type="text/javascript" src="js/global.js"></script>
<form method="post" action="api/plugnpay.php" name="plugnpay" id="plugnpay">
    <input type="hidden" name="publisher_name" value="pnpdemo">
	<input type="hidden" name="publisher_email" value="sirrom2005@gmail.com">
	<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
	<input type="hidden" name="card-allowed" value="Visa,Mastercard,Keycard" />
	<input type="hidden" name="currency_symbol" value="$" />
    <!--input type="hidden" name="currency" value="us" /-->
    <!--input name="mode" value="auth" type="hidden"-->
	<table class="bill-payment">
    	<tr><th colspan="2">Credits Amount</th></tr>
        <tr>
        	<td>&nbsp;</td>
        	<td>
				<?php 
					if(!empty($credits))
					{ 
						$i=0;
						foreach($credits as $row)
						{
				?>
                    <input type="radio" name="credit_id" value="<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" <?php echo ($i==0)? "checked" :"";?> />
					<label for="<?php echo $row['id'];?>"><?php echo $row['credit'];?> credits for US$ <?php echo number_format($row['cost'],2,".", ",");?></label><br />
                <?php 
							$i++;
						} 
					}
				?>
            </td>
        </tr>
		<tr><th colspan="2">Billing Address</th></tr>
		<tr><td>Name:<font class="required">*</font></td><td><INPUT type="text" name="card_name" value="<?php echo cleanString($result['fname']." ".substr($result['mname'],0,1)." ".$result['lname']);?>"  maxlength="40"> <small>Full name as it appears on Credit Card.</small></td></tr>
		<tr><td>Address1:<font class="required">*</font></td><td><INPUT type="text" name="card_address1" value="<?php echo cleanString($result['address1']);?>"  maxlength="30"></td></tr>
		<tr><td>Address2:</td><td><INPUT type="text" name="card_address2" value="<?php echo cleanString($result['address2']);?>"  maxlength="30"></td></tr>
		<tr><td>City:</td><td><INPUT type="text" name="card_city" value="<?php echo cleanString($result['city']);?>"  maxlength="30"></td></tr>
		<tr><td>State:</td><td><INPUT type="text" name="card_state" value="<?php echo cleanString($result['state']);?>"  maxlength="30"></td></tr>
		<tr><td>Zip-Code:</td><td><INPUT type="text" name="card_zip" value="<?php echo cleanString($result['zip_code']);?>"  maxlength="30"></td></tr>
		<tr><td>Country:</td>
        	<td>                
				<select name="card_country">
				<?php foreach($country as $row){?>
				<option value="<?php echo $row['iso_code_2'];?>" <?php echo ($row['country_id']==$result['country_id'])? "selected" : "" ;?> ><?php echo cleanString($row['name']);?></option>
				<?php }?>
				</select>
            </td>
        </tr>
		<tr><td>Email:</td><td><input type="text" name="email" value="<?php echo cleanString($result['email']);?>"  /> <small>Your receipt will be sent here.</small></td>
        <!--tr><td>Send email receipt as:</td><td><input type="radio" name="senmail" value="text" checked="checked" />Plain text <input type="radio" value="html" name="senmail" />Html</td></tr-->
		<tr><th colspan="2">Card Information</th></tr>
		<tr><td>Card Type:</td><td>
		<input type="radio" name="card_type" value="visa" checked="checked" id="visa" />
		<label for="visa">VISA</label> 
		<input type="radio" name="card_type" value="keycard" id="keycard" />
		<label for="keycard">Keycard</label>
		<input type="radio" name="card_type" value="mastercard" id="mastercard" />
		<label for="mastercard">MasterCard</label> 
		</td></tr>
		<tr><td>Card Number:<font class="required">*</font></td><td><INPUT type="text" name="card_number"  maxlength="30" onkeypress="return numbersOnly(event, false)"></td></tr>
		<tr><td>Card Expiration Date:<font class="required">*</font></td><td><INPUT type="text" name="card_exp" size="4" maxlength="5"> <small>(MM/YY)</small></td></tr>
		<tr><td>CVV:</td><td><INPUT type="password" name="card_cvv" size="4" maxlength="3"> <small>3 digit code on back of card.</small></td></tr> 
		<tr><td colspan="2" class="buttons"><input type="button" value="Pay Now" class="pay-now" onclick="validat();" /></td></tr>
	</table>
</form>

<script language="javascript" type="text/javascript">
var visacardcode   = new Array("4543");
var mastercardcode = new Array("5430");
function validat()
{
	var ele = document.plugnpay;
	var valid = true;
	var str   = "";
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
</script>