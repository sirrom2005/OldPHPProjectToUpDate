<?php
/*~~PROFILE COMMENT REPLY~~*/
include_once("../config/config.php");
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$id = $_GET['id'];
$zone = $_GET['z'];
$str = "";
$sql = "select c.zone_id,c.name as state from obd_county_zone c where country_id = '$id' order by c.name";
$rt = mysql_query($sql);
if($rt){
	while( $row = mysql_fetch_assoc($rt) ){
		$selected = ($zone == $row['zone_id'])? 'selected' : '';
		$str .= "<option value='{$row['zone_id']}' $selected >{$row['state']}</option>";
	} 
}
echo $str;
?>