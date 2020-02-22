<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();

$rs = $obj->getUnverifedPins();

/*echo '<?xml version="1.0" encoding="UTF-8"?>';*/
echo '<profile title="jusbbmpins.com xml feed" publisher="jusbbmpins.com | Iceman">';
if($rs){
	foreach($rs as $row){
	$pin = 	strtoupper($row['bbmpin']);
?>
    <user>
		<fullname><?php echo trim($row['fullname']);?></fullname>
		<bbmpin><?php echo $pin;?></bbmpin>
        <pass><?php echo base64_encode($row['pkey']);?></pass>
    </user>
<?php 
	}
}
echo "</profile>"; 
?>