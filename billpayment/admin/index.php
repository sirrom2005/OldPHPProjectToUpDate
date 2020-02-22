<?php	
	session_start();	
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/commonDB.class.php");
	
	$comObj = new commonDB();	
	$page = (empty($_GET['action']))? "transaction.php" : "{$_GET['action']}.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Telstar Cable Ltd. | Bill Payment | Administration</title>

	<!-- JavaScript -->
	<script language="javascript" type="text/javascript" src="../js/calendar/cal2.js">
	/*
	Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
	Script featured on/available at http://www.dynamicdrive.com/
	This notice must stay intact for use
	*/
	</script>
	<script language="javascript" type="text/javascript" src="../js/calendar/cal_conf2.js"></script>

	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/reset.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/grid.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/forms.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/ie.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/typography.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.admin.css" />

</head>
<body>
<?php 
	if( empty($_SESSION['admin']))
	{
		echo "<script> location='login.php'; </script>";
		echo "<meta http-equiv='refresh' content='0;login.php' />";
	}
	else
	{
?>

	<div class="container">

	<div class="span-24 last top">
		<ul class="menu">
			<li><a href="index.php">View Transactions</a></li>
			<li>|</li>
			<li><a href="index.php?action=change_pass&id=<?php echo $_SESSION['admin']['id'];?>">Change Password</a></li>
			<li><span class="separator">|</li>
			<li><a href="index.php?action=logout">Logout <?php echo ucfirst($_SESSION['admin']['user_name']);?></a></li>
		</ul><!-- menu -->
	

		<a href="http://www.telstarjamaica.com" title="Telstar Cable Ltd." class="logo">
			<img src="../images/logo.jpg" alt="Telstar Logo"/>
		</a>
	</div><!-- top -->

	<table id="DataTable">
		<tr>
	    	<td id="main"><?php include_once("includes/$page") ?></td>
	    </tr>
		<tr>
			<td id="footer">

				<div class="span-24 last footer">
				
						<div class="span-18 left">
							Copyright &copy; 2009 - <?php echo date('Y'); ?> Telstar Cable Ltd. | <a href="http://www.telstarjamaica.com/terms.php">Terms &amp; Conditions</a> | <a href="http://www.telstarjamaica.com/privacy.php">Privacy Policy</a>
						</div>
						<div class="span-5 last right">
						Site Developed by <a href="http://www.thesecoya.com" title="Secoya" target="_blank"><img src="../images/secoya.gif"></a>
					</div>
					
				</div><!-- footer -->			
						
			</td>
		</tr>
	</table>
<?php
	}
?>

	</div><!-- container -->

</body>
</html>