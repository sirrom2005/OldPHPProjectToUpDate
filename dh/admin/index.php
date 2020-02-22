<?php		
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/commonDB.class.php");
	
	$comObj = new commonDB();	
	$page = (empty($_GET['action']))? "home.php" : "{$_GET['action']}.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>C.M.S.</title>
<script language="javascript" type="text/javascript" src="../js/script.js"></script>
<script language="javascript" type="text/javascript" src="../js/calendar/cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" type="text/javascript" src="../js/calendar/cal_conf2.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
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
<table align="center" id="mainTbale" width="980">
	<tr>
        <td colspan="2" id="header" >
			<div>
				<script type="text/javascript"><!--
                google_ad_client = "pub-7769573252573851";
                /* wide_image_banner */
                google_ad_slot = "7284682713";
                google_ad_width = 468;
                google_ad_height = 60;
                //-->
                </script>
                <script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
				<span>
                	<?php if( $_SESSION['admin']['account_type'] == 2 ){ ?>
                    	[ <a href="index.php?action=newscategory">News Category</a> ]
                    	[ <a href="index.php?action=newsletter_form">News Letter</a> ]
                    	[ <a href="index.php?action=view_logs">View Logs</a>]
					<?php } ?>
                	[ <a href="index.php?action=change_pass&id=<?php echo $_SESSION['admin']['id'];?>">Change Password</a> ]
                    [ <a href="index.php?action=logout">Logout <?php echo ucfirst($_SESSION['admin']['user_name']);?></a> ]
                </span>
			</div>			
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="index.php?action=add_news">Post News</a></li>
				<li><a href="index.php?action=list_news">List News</a></li>
				<?php if( $_SESSION['admin']['account_type'] == 2 ){ ?>
				<li><a href="index.php?action=add_item">Add Software</a></li>
				<li><a href="index.php?action=list_items">List Software</a></li>
				<li><a href="index.php?action=list_reviews">List Reviews</a></li>
				<li><a href="index.php?action=add_banner">Add Banners</a></li>
				<li><a href="index.php?action=list_banners">List Banners</a></li>
				<li><a href="index.php?action=list_pages">Edit Pages</a></li>
				<li><a href="index.php?action=add_user">Add User</a></li>
				<li><a href="index.php?action=list_users">List User</a></li> 
				<?php } ?>
            </ul>
        </td>
    </tr>
	<tr>
    	<td id="main"><?php include_once("includes/$page") ?></td>
    </tr>
	<tr>
		<td id="footer">
        	<a href="<?php echo DOMAIN;?>privacy_policy.html">Privacy Policy</a> | <a href="<?php echo DOMAIN;?>terms_and_conditions.html">Terms And Conditions</a>
        	<br />Copyright <?php echo date("Y");?> DownloadHours.com All rights reserved
        </td>
	</tr>
</table>
<?php
	}
?>
</body>
</html>