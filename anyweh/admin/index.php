<?php	
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/commonDB.class.php");
	
	$action = $_GET['action'];
	if( file_exists("includes/$action.php") )
	{
		$page = "$action.php";
	}
	else
	{
		$page = "home.php";
	}
	
	$comObj = new commonDB(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anyweh.com - C.M.S.</title>
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
<? 
	if( empty($_SESSION['admin']))
	{
		echo "<div id='main'>";
		include_once( "includes/login.php" );
		echo "</div>";
	}
	else
	{
?>
<table border="1" width="100%">
	<tr>
        <td colspan="2" id="cms_header" >
            <script type="text/javascript"><!--
            google_ad_client = "pub-7769573252573851";
            /* 728x90_image_ads */
            google_ad_slot = "7700170488";
            google_ad_width = 728;
            google_ad_height = 90;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </td>
    </tr>
	<tr>
    	<td valign="top" id="menuCell" height="400" width="150">
        	<table id="menu" width="100%">
                <!--tr><td><a href="index.php?action=add_news">Add News</a></td></tr>
                <tr><td><a href="index.php?action=list_news">List News</a></td></tr-->
				<tr><td><a href="index.php?action=add_events">Add Events</a></td></tr>
                <tr><td><a href="index.php?action=list_events">List Events</a></td></tr>
				<tr><td><a href="index.php?action=ads">Ads</a></td></tr>
<tr><td><a href="index.php?action=list_ads">List ads</a></td></tr>
				<!--tr><td><a href="index.php?action=banners">Add Banners</a></td></tr>
				<tr><td><a href="index.php?action=list_banners">List Banner</a></td></tr-->
				<!--tr><td><a href="index.php?action=add_hottgirl">Hot Girl</a></td></tr>
                <tr><td><a href="index.php?action=add_video">Add Video</a></td></tr>
                <tr><td><a href="index.php?action=list_video">List Video</a></td></tr>
				<tr><td><a href="index.php?action=list_comment">List Comments</a></td></tr-->
                <tr><td><a href="../gallery/zp-core/admin.php" target="_blank">Photo Gallery</a></td></tr>
                <tr><td><a href="../blog/wp-login.php" target="_blank">Blog</a></td></tr>
                <tr><td><a href="../poll/poll_admin.php" target="_blank">Poll</a></td></tr>
                <tr><td><a href="index.php?action=clear_cache">Clear Site Cache</a></td></tr>
                <tr><td><a href="http://anyweh.com/crons/gallery.php" target="_blank">Slideshow (home)</a></td></tr>
                <tr><td><a href="index.php?action=change_pass">Change password</a></td></tr>
                <tr><td><a href="index.php?action=logout">Logout</a></td></tr>
            </table>
        </td>
    	<td valign="top" id="main"><? include_once("includes/$page") ?></td>
    </tr>
</table>
<?
	}
?>
</body>
</html>


