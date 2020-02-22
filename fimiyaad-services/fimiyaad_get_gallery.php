<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
//$mysqli = mysqli_connect("localhost","shimiyaad","Yaadfimi6580","mobile-apps");
$mysqli = mysqli_connect("localhost","root","","mobile-apps");
$err = mysqli_connect_error();
if($err){
	die($err);
}

$sql = "SELECT id as id,country,url,img,`date`,gallery_list FROM fimiyaad_gallery GROUP by url order by id";	

$rt = $mysqli->query($sql,MYSQLI_USE_RESULT);
$rs = array();
$i=0;
while($row = mysqli_fetch_assoc($rt)){
	$rs[$i]['id'] = $row['id'];
	$rs[$i]['url'] = $row['url'];
	$rs[$i]['img'] = $row['img'];
	$rs[$i]['country'] = $row['country'];
	$url = explode("/",$rs[$i]['url']);
	$rs[$i]['title'] = $url[count($url)-2];
	$rs[$i]['date'] = $row['date'];
	$rs[$i]['gallery_list'] = $row['gallery_list'];
	$i++;
}
if($rs){
	$json = json_encode($rs);
	print_r($json);
}
$mysqli->close();



function is404($url){
 	$valide = false;
	$handle = curl_init($url);
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

	/* Get the HTML or whatever is linked in $url. */
	$response = curl_exec($handle);

	/* Check for 404 (file not found). */
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	if($httpCode == 404) {
    	    $valide = true;
	}
	curl_close($handle);
	return $valide;
}
?>