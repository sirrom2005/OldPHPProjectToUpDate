<?php
$fold1 = '../cache/en/';
$except = array(".","..");
if ($handle = opendir($fold1)) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        echo "Deleting $entry<br>";
		if(!in_array($entry,$except)){
			unlink($fold1.$entry);
		}
    }
    closedir($handle);
}
$fold1 = '../cache/es/';
if ($handle = opendir($fold1)) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        echo "Deleting $entry<br>";
		if(!in_array($entry,$except)){
			unlink($fold1.$entry);
		}
    }
    closedir($handle);
}
$fold1 = '../cache/fr/';
if ($handle = opendir($fold1)) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        echo "Deleting $entry<br>";
		if(!in_array($entry,$except)){
			unlink($fold1.$entry);
		}
    }
    closedir($handle);
}
?>