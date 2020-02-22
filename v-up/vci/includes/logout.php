<?php
	unset($_SESSION['ADMIN_USER']);
	session_destroy();
?>
<meta http-equiv="refresh" content="3;index.php" />
<span class='msg'>Logging out please wait...</span>