<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();
$id = $_GET['id'];
if($id==1){
	$rs = $obj->getNewUser();
}
if($id==2){
	$rs = $obj->getNewPhotoAdded();
}
/*echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";*/
echo "<data title=\"jusbbmpins.com xml feed\" publisher=\"jusbbmpins.com | Iceman\">\n";
if($rs){
	foreach($rs as $row){
	$pin = 	strtoupper($row['bbmpin']);
?>
    <user>
		<fullname><?php echo trim($row['fullname']);?></fullname>
		<bbmpin><?php echo $pin;?></bbmpin>
        <msg><?php echo trim($row['msg']);?></msg>
    </user>
<?php 
	}
}
echo "</data>"; 
?>