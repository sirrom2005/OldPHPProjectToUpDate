<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();

$step = (isset($_GET['step']) && !empty($_GET['step']))? $_GET['step'] : 0;
$data = (isset($_GET))? $_GET : null;
$rs = $obj->getUserList($data,$step);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<profile title="jusbbmpins.com xml feed" publisher="jusbbmpins.com | Iceman">';
if($rs){
	foreach($rs as $row){	
?>
    <user id="<?php echo $row['id'];?>" verified="<?php echo $row['pinverified'];?>">
		<fullname><?php echo trim($row['fullname']);?></fullname>
		<gender><?php echo $row['gender'];?></gender>
		<status><?php echo $row['status'];?></status>
                <photo><?php echo (!empty($row['photo']))? $row['photo'] : 'none';?></photo>
		<country flag="<?php echo strtolower($row['flag']);?>"><?php echo $row['country'];?></country>
    </user>
<?php 
	}
}
echo "</profile>"; 
?>