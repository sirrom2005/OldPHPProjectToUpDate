<?php
/*~~PROFILE COMMENT DELETE~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$id = $_GET['i'];
$sql = "DELETE FROM group_comment WHERE id = $id";
$rs  = mysql_query($sql);
@unlink("../profile_{$_SESSION['BBPINWORLD']['id']}.html");
?>