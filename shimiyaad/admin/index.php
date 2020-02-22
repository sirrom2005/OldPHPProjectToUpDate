<?php
include_once("../config/config.php");
if(!isset($_SESSION['FIMIADMIN']) || empty($_SESSION['FIMIADMIN'])){ header("location: login.php"); }
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/commonDB.class.php");
$comObj = new commonDB();
@$page = (file_exists('includes/'.$_GET['action'].'.php') )? $_GET['action'].'.php' : 'home.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>    
    <meta name="language" content="English" />
    <title>FIMIYAAD.COM ADMIN</title>
<style>
body,ol,ul,li,p,h2,h3,h4,h5,form{margin:0;padding:0;list-style:none;font-family:Arial;}
h5{ background-color:#003366; color:#FFFFFF; padding:5px; font-weight:bold;}
form{}
p{ margin-bottom:8px;}
#adminSpan{float:right;padding:4px 5px 0 0 ; font-size:0.9em;}
#adminSpan a{color:#FFFFFF;}
#adminSpan a:hover{color:#f00;}
#container{width:900px; border:solid 1px #CCCCCC; margin:0 auto;}
#header{ background-color:#000000; color:#FFFFFF;font-weight:bold; padding:5px;margin-bottom:0px;}
#content{ padding:5px;}
.right{float:right;border:solid 1px #999999;height:460px; width:180px; padding:5px;}
li{ width:400px;}
.remove{float:right;color:red;}
#menu li{float:left; width:auto; margin:0 1px 5px 0;}
#menu li a{display:block;padding:2px 5px;text-decoration:none;background-color:#c3d9ff;color:#000000; text-align:center;font-weight:bold; border:solid 1px #333333;}
#menu li a:hover{background-color:#FFFFFF; color:#666666;}
label{display:inline-block; width:120px; font-size:0.85em; font-weight:bold;}
textarea{width:590px; height:70px;}
.textbox{padding:5px; width:450px;}
ol li{background-color:#e5ecf9;padding:5px;margin-bottom:1px;}
ol li.even{background-color:#f0f0f0;}
ol li small{display:block; font-weight:bold; margin-top:3px;}
hr{
	clear:both;
	height: 0;
	border: 0;
}
.mediabk{border:solid 1px #E1E1FD;}
.mediabk h3{background-color:#F00; color:#FFFFFF; padding:2px 5px;}
.mediabk label{font-size:0.75em;}
.mediabk p{padding:5px;}
.mediabk #imgs li{float:left; width:100px; height:100px; margin:5px 5px 0 0;}
.mediabk #imgs li img{width:100px; height:80px; border:solid 1px #666666;}
.remove{background-image:url("../images/remove.png"); background-repeat:no-repeat; display:block; width:16px; height:16px; margin-left:8px;}
.edit{background-image:url("../images/edit.png"); background-repeat:no-repeat; display:block; width:16px; height:16px; margin-left:8px; float:right;}
.error{
	background-image: url("../images/glossy-mat.png");
	background-repeat: repeat-x;
	display:block;
	padding:10px 5px;
	font-size:0.9em;
	line-height:0.9em;
	width:500px;
}
.error {background-color:#ffcccc;border:solid 2px #ff5555;color:#8a1f11;}
.btn{
	background-image: url("../images/glossy-mat.png");
	background-repeat: repeat-x;
	border:solid 1px #000000;
	padding:5px;
	background-color:#f1f6dd;
	font-weight:bold;
}
</style>
</head>
<body>
<div id="container">
	<span id="adminSpan"><a href="logout.php">logout</a></span>
	<div id="header">FIMIYAAD.COM - ADMIN</div>
    <div id="content">
    <ul id="menu">
        <li><a href="index.php?action=add-event">Add Events</a></li>
        <li><a href="index.php?action=events">List Events</a></li>
        <!--li><a href="index.php?action=add-news">Add Articles</a></li>
        <li><a href="index.php?action=news">List News</a></li>
        <li><a href="index.php?action=classifieds">Classifieds</a></li>
        <li><a href="index.php?action=clearcache">Clear cache</a></li-->
    </ul>
    <hr>
    <?php include_once('includes/'.$page);?>
    </div>
</div>
</body>
</html>