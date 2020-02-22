<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
$mysqli = mysqli_connect("localhost","shimiyaad","Yaadfimi6580","mobile-apps");
//$mysqli = mysqli_connect("localhost","root","","mobile_apps");
$err = mysqli_connect_error();
if($err){
	die($err);
}

$sql = "SELECT title,video FROM fimiyaad_videos LIMIT 100";	

$rt = $mysqli->query($sql,MYSQLI_USE_RESULT);
$rs = array();
$i=0;
while($row = mysqli_fetch_assoc($rt)){
	$rs[$i]['title'] = $row['title'];
	$rs[$i]['video'] = $row['video'];
	$i++;
}
if($rs){
	$json = json_encode($rs);
	print_r($json);
}
$mysqli->close();
?>