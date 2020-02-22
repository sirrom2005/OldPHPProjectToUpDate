<?php
/*~~PROFILE COMMENT DELETE~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$id = $_GET['i'];
$sql = "DELETE FROM profile_comment WHERE id = $id";
$rs  = mysql_query($sql);
@unlink("../cache/en/profile_{$_SESSION['BBPINWORLD']['id']}.html");
@unlink("../cache/es/profile_{$_SESSION['BBPINWORLD']['id']}.html");
@unlink("../cache/fr/profile_{$_SESSION['BBPINWORLD']['id']}.html");
@unlink("../m/profile_{{$_SESSION['BBPINWORLD']['id']}.html");
?>