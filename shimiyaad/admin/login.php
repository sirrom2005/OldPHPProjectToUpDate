<?php
include_once("../config/config.php"); 
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");

$obj = new site();

$err = '';
if($_POST)
{	
	$rs = $_POST;
	$valid = true;
	if(empty($rs['username'])){ $err .= '<li>Username is required.</li>'; $valid = false; }
	if(empty($rs['pass'])    ){ $err .= '<li>Password is required.</li>'; $valid = false; }
	
	if($valid){
		$rt = $obj->userLogin($rs['username'],$rs['pass']);
		
		if($rt){
			$_SESSION['FIMIADMIN'] = $rt;
			header("location: index.php?action=add-event");
		}
		else{
			$err = '<span class="error"><li>Invalid login attempt...</li></span>';
		}
	}
	else
	{
		$err = "<span class='error'>$err</span>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>C.M.S</title>
<style>
h1{ margin:0; padding:0; text-align:center;}
.frmStyle1{display:block; border:solid 1px #2c71d9;border-top:solid 3px #2c71d9; background-color:#eeeeee; padding:0 20px 5px 20px; margin:0 auto; width:340px}
.frmStyle1 label{margin-right:20px; width:100px; display:inline-block; font-weight:bold;}
.frmStyle1 .textbox{width:200px; padding:5px;}
.error{
	background-image: url("../images/glossy-mat.png");
	background-repeat: repeat-x;
	display:block;
	padding:10px 5px;
	font-size:1em;
	text-align:center;
	line-height:0.9em;
	margin:5px auto; 
	width:500px;
}
.error {background-color:#ffcccc;border:solid 2px #ff5555;color:#8a1f11;}
.error li{background:url(../images/tick-bullet.png) no-repeat 0 5px; padding-left:15px; text-align:left; list-style:none;}
</style>
</head>
<body>
<div id="container">
    <?php echo $err;?>
    <form name="frm" class="frmStyle1" method="post" action="">
    	<h1>FIMI Admin Area</h1>
        <p><label for="username">Username</label><input type="text" name="username" id="username" autocomplete="off" value="" class="textbox" /></p>
        <p><label for="pass">Password</label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" /></p>
        <p align="center"><input type="submit" value="Enter" class="btn" /></p>
    </form> 
</div>
</body>
</html>