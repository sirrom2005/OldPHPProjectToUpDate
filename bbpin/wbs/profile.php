<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();
$id = (isset($_GET['id']))? $_GET['id'] : 0;
$rs = $obj->getUserProfile($id);

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<profile title="jusbbmpins.com xml feed" publisher="jusbbmpins.com | Iceman">'."\n";
echo '<user id="'.$rs['id'].'" verified="'.$rs['pinverified'].'">'."\n";
if($rs){
	foreach($rs as $key => $value){	
?>
    	<?php echo "<$key>".parseString($value)."</$key>"."\n"; ?>
<?php 
	}
} 
echo '</user>'."\n";
echo "</profile>";

function parseString($str=""){
	$str = strip_tags($str);
	$str = str_replace("\r\n",'',$str);
        $str = ($str == '')? 'null' : $str;
	return $str;
}
?>
