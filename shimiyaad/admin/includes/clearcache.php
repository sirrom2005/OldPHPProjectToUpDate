<?php
$mydir = "../site_cache/"; 
if(is_dir($mydir)){
$d = dir($mydir); 
while($entry = $d->read()) { 
	if($entry!= "." && $entry!= "..") { 
		unlink($mydir.$entry); 
	} 
} 
$d->close(); 
}
echo "All cache files cleared...";
?>