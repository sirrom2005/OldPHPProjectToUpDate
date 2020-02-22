<?php
include_once ("includes/miniPoll.class.php");
include_once ("config.php");	

$connection = mysql_connect ($host, $user, $pass) or die ("Unable to connect");
mysql_select_db ($db) or die ("Unable to select database");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Anyweh.com : Poll Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style/poll.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="pollDiv">
    <?php
    $test = new miniPoll;
    
    if (isset($_GET['poll']) && is_numeric($_GET['pollid'])) {
        $pollid = $_GET['pollid'];
    
        if (isset($_GET['voteid']) && is_numeric($_GET['voteid'])) {
            $voteid = $_GET['voteid'];
            $test->processPoll($pollid, $voteid);
        }
    
    }
    if (isset($_GET['pollid'])) {
        $pollid = $_GET['pollid'];
        $test->pollResults($pollid);
    }
    
    @mysql_close($connection);
    ?>
</div>
</body>
</html>