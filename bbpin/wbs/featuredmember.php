<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();

$id = (isset($_GET['id']))? $_GET['id'] : 0;
$g = (isset($_GET['g']))? $_GET['g'] : 0;

$rt = $obj->getUserProfile($id);
$rs = $obj->getMemberList($g,$id);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<profile title="jusbbmpins.com xml feed" name="'.trim($rt['fullname']).'" gender="'.$rt['gender'].'" gender_prefrence="'.$rt['gender_prefrence'].'" country="'.$rt['country'].'" >';
if($rs){
	foreach($rs as $row){
	$pin = 	strtoupper($row['bbmpin']);
?>
    <user>
		<fullname><?php echo trim($row['fullname']);?></fullname>
		<bbmpin><?php echo $pin;?></bbmpin>
    </user>
<?php 
	}
}
echo "</profile>"; 
?>