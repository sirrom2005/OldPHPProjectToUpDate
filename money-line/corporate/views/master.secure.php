<?php

defined('RAXANPDI') || die();
$year = date('Y');

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Corporate Moneyline</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <base href="" />
        <link href="../common/raxan/ui/css/master.css" type="text/css" rel="stylesheet" />
        <!--[if lt IE 8]><link href="../common/raxan/ui/css/master.ie.css" type="text/css" rel="stylesheet" /><![endif]-->
        <link href="../common/raxan/ui/css/default/theme.css" type="text/css" rel="stylesheet" />
        <link href="views/theme/theme.css" type="text/css" rel="stylesheet" />
        <link rel="icon" type="image/png" href="favicon.png" />
        <script type="text/javascript" src="views/scripts.js"></script>
    </head>
    <body>
        <div class="container e98">
            <!-- header -->
            <div class="container page-header tpm">
                <div class="banner_bg" >
                    <div class="left"><img src="views/theme/images/jmmb_left2.jpg"/></div>
                    <div class="right"><img src="views/theme/images/jmmb_right2.jpg"/></div>
                </div>
                <div class="infobar_bg">
                    <span>Corporate Moneyline</span>
                </div>
                <!--	<h2 class="bottom">Corporate Moneyline</h2>  -->
                <div class="banner">
                    <ul class="left">
                        <li class="selected"><a href="index.php" title="Dashboard">Home</a></li>
                        <li><a href="myprofile.php">Change Password</a></li>
                        <li class="administrator"><a href="admin.php">Administration</a></li>
                        <li><a href="userguide.php" title="User Guide">User Guides</a></li>
                        <li><a href="login.php?do=logout" title="Logout">Logout</a></li>
                    </ul>
                    <span id="userbar" class="quiet"></span>
                    <span> | © JMMB <?php echo $year; ?></span>
                </div>
            </div>

            <div class="container clear">
                <div class="flashmsg"><!-- Flash Message --></div>
                <div class="container master-content prepend-top mouse-cursor"><!-- body --></div>
            </div>

        </div>
    </body>
</html>
