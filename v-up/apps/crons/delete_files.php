<?php
/**DELETE SOME TMP FILES**/
$files = array("../index.html");
foreach($files as $key => $value){if(file_exists($value)){ unlink($value);echo "File [$value] removed.";}}
?>