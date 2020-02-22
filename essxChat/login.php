<?php
include_once("config/config.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
include_once("classes/commonDB.class.php");

$obj = new site();
$comObj = new commonDB();

$err = '';
$rs = array('email' => '','fname'=>'','lname'=>'','country_id'=>'');

if(isset($_POST['login'])){
	$post = $_POST;
	$rt = $obj->userLogin($post['username'],$post['pass']);
	
	if($rt){
		$rt['time'] = time();
		$_SESSION['SEXXCHAT'] = $rt;
		header('location: index.php');
	}
	else{
		$err = '<span class="error"><li>Invalid login attempt...</li></span>';
	}
}

if(isset($_POST['reg']))
{
	$rs = $_POST;
	$fname	= cleanText($rs['fname']);
	$lname	= cleanText($rs['lname']);
	$email	= cleanText($rs['email']);
	$country_id	= $rs['country_id'];
	$pass 	= cleanText($rs['pass']);
	$pass2 	= cleanText($rs['pass2']);
	$valid  = true;
	
	if(!isValidEmail($email)){
		$err .= "<li>invalid email address.</li>";
		$valid  = false;
	}
	if(empty($fname)){
		$err .= "<li>firstname is required.</li>";
		$valid  = false;
	}
	if( strlen($pass)<6){
		$err .= "<li>password too short or empty (6 or more characters).</li>";
		$valid  = false;
	}
	if($pass != $pass2){
		$err .= "<li>password does not match.</li>";
		$valid  = false;
	}

	if($valid){
		$rt = $obj->emailLookUp($email);
		if(!$rt['cnt']){
			if($obj->createNewAccount($rs)){
				$s['id'] = mysql_insert_id();
				$s['fname'] = $fname;
				$s['email'] = $email;
				$s['time']  = time();
				$_SESSION['SEXXCHAT'] = $s;
				header("location: edit-profile.html");
			}
			else{
				die("DB ERROR");
			}
		}
		else{
			$err = "<li>email already in system.</li>";
		}
	}
	else{
		$err = "<span class='error'>$err</span>";
	}
}

$country = $comObj->getHtmlListControlData('odb_country','name','country_id','name',"ASC");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<meta name="title" content="video chat live with sexy hot girl from around the world">
<meta name="keywords" content="video,chat,room,live,girls,pron,single">
<meta name="description" content="video chat live with sexy hot naked girl from around the world">
<title><?php echo SITE_NAME;?> :: chat live with sexy hot girl from around the world</title>
<style>
@import url("styles/front-page.css");
</style>
</head>
<body>
	<div id="container">
      	<h1><a href="<?php echo DOMAIN;?>"><?php echo SITE_NAME;?></a></h1>
        <p>Have live video chat with sexy hot naked girl from around the world.</p>
        <?php echo $err;?>
      	<form name="frm" method="post" action="">
        	<h2>Login</h2>
        	<p style="text-align:center;font-size:0.8em;padding-right:275px;"><a href="forget-login.php">Forget your password? click here.</a></p>
        	<p><label for="username">Email/Username</label><input type="text" name="username" id="username" autocomplete="off" value="" class="textbox" /></p>
            <p><label for="pass">Password</label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" /></p>
            <p><input type="submit" value="Enter" class="btn" name="login" /></p>
        </form> 
        
        <form name="frm" method="post" action="">
        	<h2>Register</h2>
        	<p><label for="username">Email</label><input type="text" name="email" id="email" autocomplete="off" value="<?php echo cleanText($rs['email']);?>" class="textbox" /></p>
            <p><label for="fname">First name</label><input type="text" name="fname" id="fname" autocomplete="off" value="<?php echo cleanText($rs['fname']);?>" class="textbox" /></p>
            <p><label for="lname">Last name</label><input type="text" name="lname" id="lname" autocomplete="off" value="<?php echo cleanText($rs['lname']);?>" class="textbox" /></p>
            <p><label for="pass">Country</label><select name="country_id" id="country_id">
            <?php foreach($country as $key => $value){?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php }?>
            </select>
            </p>
            <p><label for="pass">Password</label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" /></p>
            <p><label for="pass2">Confirm Password</label><input type="password" name="pass2" id="pass2" autocomplete="off" value="" class="textbox" /></p>
            <p><input type="submit" value="Enter" class="btn" name="reg" /></p>
        </form> 
    </div>
</body>
</html>
