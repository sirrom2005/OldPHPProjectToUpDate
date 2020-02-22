<?php
	$rs = $obj->userLookUp($_SESSION['ADMIN_USER']['username']);
	$err = "";
	
	if($_POST)
	{
		$_POST['username'] = $rs['username'];
		$rs 	= $_POST;
		$email 	= $_POST['email'];
		$pass 	= $_POST['password'];
		$pass2 	= $_POST['password2'];
		
		$rs['dob'] = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
		
		if(@!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){$err .= "Valid email address is required.<br>";unset($_POST);}
		if($pass != $pass2){ $err .= "Password do not match.<br>";unset($_POST); }
		if(!empty($pass)){ if(strlen($pass)<5){ $err .= "Password must be more be 6 characters or more.<br>";unset($_POST);} }
		if(!empty($err)){$err = "<span class='err'>$err</span>";}
	}
	
	if(!empty($_POST))
	{
		if($obj->updateAccount($rs, $_SESSION['ADMIN_USER']['username']))
		{
			$err = "<span class='msg'>Profile updated...</span>";
		}
	}
	
	include_once("../classes/commonDB.class.php");
	$comObj = new commonDB();
	$country = $comObj->getHtmlListControlData( "country", "name", "country_id", NULL,"ASC");
?>
<div class="leftside">
<?php echo $err;?>
<form name="frm" class="formStyle1" method="post" action="">
    <h1>Update My Profile</h1>
    <p><label for="username">Username:</label><input class="text readonly" type="text" readonly="readonly" id="username" value="<?php echo cleanString($rs['username']);?>" /></p>
    <p><label for="email">Email:</label><input class="text" type="text" name="email" id="email" value="<?php echo cleanString($rs['email']);?>" /></p>
    <p>
        <label for="title">Date of birth:</label><br />    
        <select name="day">
            <?php for($d=1; $d<=31; $d++){ ?>
            <option value="<?php echo $d;?>" <?php echo ($d == date("d", strtotime($rs['dob'])))? "selected" : "";?>><?php echo $d;?></option>
            <?php } ?>
        </select> /   
        <select name="month">
            <?php $m=1; while($m<=12){ ?>
            <option value="<?php echo $m;?>" <?php echo ($m == date("n", strtotime($rs['dob'])))? "selected" : "";?>><?php echo date("M",mktime(0,0,0,$m+1,0,0));?></option>
            <?php $m++; } ?>
        </select> /  
        <select name="year">
            <?php for($y=5; $y<=70; $y++){ ?>
            <option value="<?php echo date("Y",strtotime("-$y year"));?>" <?php echo (date("Y",strtotime("-$y year")) == date("Y", strtotime($rs['dob'])))? "selected" : "";?>><?php echo date("Y",strtotime("-$y year"));?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label for="title">Country:</label>
        <select class="text" name="country_id">
            <option value="">Select your country</option>
            <?php foreach($country as $key => $value){ ?>
            <option value="<?php echo $key;?>" <?php echo ($key == $rs['country_id'])? "selected" : "";?> ><?php echo $value;?></option>
            <?php } ?>
        </select>
    </p>
    <p>Gender: <input type="radio" checked="checked" name="gender" value="male" />Male <input type="radio" name="gender" value="female" <?php echo ($rs['gender'] == "female")? "checked" : "";?> />Female</p>
    <p>Receive newsletter:<input type="radio" checked="checked" name="newsletter" value="1" />Yes <input type="radio" name="newsletter" value="0" <?php echo (empty($rs['newsletter']))? "checked" : "";?> />No</p>
    <p style="font-size:11px;" align="center">To change the password type a new one.<br />Otherwise leave this blank.</p>
    <p>
    	<label for="password">Password:</label><input class="text" type="password" name="password" id="password" /><br />
    	<label for="password2">Confirm:</small></label><input class="text" type="password" name="password2" id="password2" />
    </p>
    <p align="center"><input type="submit" value="Update..." class="btn" /></p>
</form>
</div>
<div class="rightside">
    <script type="text/javascript"><!--
    google_ad_client = "pub-7769573252573851";
    /* 300x250_txt_img */
    google_ad_slot = "6699070243";
    google_ad_width = 300;
    google_ad_height = 250;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>

<script>
function numberFormat(e, decimal) {
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
	else if ((("0123456789/").indexOf(keychar) > -1)) {
	   return true;
	}
	else if (decimal && (keychar == ".")) {
	  return true;
	}
	else
	   return false;
}
</script>