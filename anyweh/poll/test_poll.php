<?php
error_reporting(E_ALL); // when you finish testing you should change this to E_NONE

include_once ("includes/miniPoll.class.php");
include_once ("config.php");

$connection = mysql_connect ($host, $user, $pass) or die ("Unable to connect");
mysql_select_db ($db) or die ("Unable to select database");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mini Poll Example</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style/poll.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
// this is all you need :)
$test = new miniPoll;
$test->pollForm();
@mysql_close($connection);
?>
</body>
</html>