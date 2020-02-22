<?php
header("Content-Type: text/xml");
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/wbs.class.php");
$obj = new wbs();
$id = (isset($_GET['id']))? $_GET['id'] : 0;
$rs = $obj->getUserPinRequest($id);

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<pinrequest title="jusbbmpins.com xml feed" publisher="jusbbmpins.com | Iceman">'."\n";
if($rs){
    foreach($rs as $row){
        echo "<request>";
        echo '<name>'.trim($row['fullname']).'</name>'."\n";
        echo '<pin>'.$row['bbmpin'].'</pin>'."\n";
        echo '<str>'.strip_tags($row['str1']).'</str>'."\n";
        echo '<date_added>'.$row['date_added'].'</date_added>'."\n";
        echo '<id>'.trim($row['id']).'</id>'."\n";
        echo "</request>";
    }
}
echo "</pinrequest>";
?>
