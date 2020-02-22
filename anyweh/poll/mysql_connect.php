<?php
define ('DB_USER', 'root');
define ('DB_PASSWORD', '');
define ('DB_HOST', 'localhost'); // Probably doesn't need to change.
define ('DB_NAME', 'anyweh');

$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );

?>
