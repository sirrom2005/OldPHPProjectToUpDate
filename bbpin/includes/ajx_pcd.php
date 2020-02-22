<?php
/*~~PROFILE PHOTO COMMENT DELETE~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$id = $_GET['i'];
$sql = "DELETE FROM profile_photo_comment WHERE id = $id";
$rs  = mysql_query($sql);
?>