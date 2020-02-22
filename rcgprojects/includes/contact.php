<?php
	if($_POST['subForm'])
	{
		include_once("classes/email.class.php");
		
		$emailObj = new email();
		
		$name 			= $_POST['name'];
		$emailAddress 	= $_POST['email'];
		$tel 			= $_POST['tel'];
		$comment 		= strip_tags( $_POST['request'], "<b><i><u>");
		
		$subject		= "Contact form submitted";
		$message		= 
		"
		<table border='0'>
		  <tr>
			<td width='130'><b>Name</b></td>
			<td width='150'>$name</td>
		  </tr>
		  <tr>
			<td><b>Email</b></td>
			<td>$emailAddress</td>
		  </tr>
		  <tr>
			<td><b>Phone</b></td>
			<td>$tel</td>
		  </tr>
		  <tr>
			<td><b>Comment\Request</b></td>
			<td>$comment</td>
		  </tr>
		</table>
		";

		$mail = $emailObj->sendEmail( $emailAddress, $subject, trim($message),  $name, "sirrom2005@gmail.com" );
		if($mail)
		{
			echo "<script>alert('Comment\\Request was submitted');</script>";
			echo "<script>location='index.php?action=home'</script>";
		}
	}
?>
<script language="javascript" type="text/javascript">
function validate()
{ 
	var errStr = "";
	
	
	if( isEmpty( Trim(document.getElementById("name").value) ) )
	{
		errStr += "A name is required\r\n";
	}
	
	if( !isValidEmail( Trim(document.getElementById("email").value) ) )
	{
		errStr += "A valid e-mail address is required\r\n";
	}
	
	if( isEmpty( Trim(document.getElementById("request").value) ) )
	{
		errStr += "CommentRequest is required\r\n";
	}
	
	if( !isEmpty(errStr) )
	{
		alert(errStr);
		return false;
	}
	
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
</style>


<table>
	<tr>
	  <td width="424" height="393" rowspan="2">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="395">
			<tr><td height="10"></td></tr>
			<tr>
			  <td class="infoHeading" height="20"><b><span class="blue_text">CONTACT </span><span class="green_text">US</span></b></td>
			</tr><tr>
			</tr><tr><td valign="top">
				<form method="post" name="contactx" onSubmit="return validate();" style="margin-top:0px; margin-bottom:0px;">
				 <table width="98%" border="0" align="center" cellpadding=0 cellspacing=0  >
					  <tr><td height="10"></td></tr>
					  <tr> 
						<td width="221" height="27"  class="controlLableStyle">Name:</td>
						<td width="166" >  
						<input type="text" id="name" name="name" size="25" class="controlStyle">		  </td>
					  </tr>
					  <tr> 
						<td height="27"  class="controlLableStyle">E-Mail:</td>
						<td >  
						  <input type="text" name="email" id="email" size="25" class="controlStyle">		  </td>
					  </tr>
					  <tr> 
						<td height="29"  class="controlLableStyle">Tel #:</td>
						<td >  
						  <input type="text" name="tel" id="tel" size="15" class="controlStyle">		  </td>
					  </tr>
					  <tr> 
						<td  valign="top" class="controlLableStyle">Comment\Request:</td>
						<td >  
						  <textarea name="request" id="request" cols="25" rows="5" class="controlStyle"></textarea>	    </td>
					  </tr>
					  <tr> 
						<td></td>
					    <td class="btnRow" height="40" >
							<div align="right">
							  <input type="submit" value="Submit" name="subForm" id="subForm" class="btnStyle" >
							  <input type="reset" value="Reset" class="btnStyle" >						
						  </div></td>
					  </tr>
				</table>
			  </form>
				</td>
			</tr>
			<tr><td><hr />
			  <span class="style1">RELIANCE CONSULTING GROUP				</span>
    <table width="100%" border="0" id="contact">
				    
			      <tr>
			        <td width="37%" rowspan="5" valign="top">
			          <strong>Head Office</strong><br>
			          9 Devon Road <br>
			          Kingston 10 <br>
		            Jamaica, W.I.			          </td>
					<td width="13%" valign="top">
					Phone:</td>
					<td width="50%" valign="top"> 876-968-5521</td>
				  </tr>
				  <tr>
					<td valign="top">Fax: </td>
					<td valign="top">876-968-5524</td>
				  </tr>
				  <tr>
					<td height="54" valign="top">Email: </td>
					<td valign="top"><a href="mailto:amahmood@rcgprojects.com?cc=mmcnally@rcgprojects.com">info@rcgprojects.com</a></td>
				  </tr>
			  </table>
			</td>
			</tr>
		</table>
	</tr>

</table>