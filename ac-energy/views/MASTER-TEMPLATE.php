<?php defined('RAXANPDI')||exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>IREE SOLAR</title>
        <link href="raxan/ui/css/master.css" type="text/css" rel="stylesheet" />
        <!--[if lt IE 8]><link rel="stylesheet" href="raxan/ui/css/master.ie.css" type="text/css"><![endif]-->
        <link href="raxan/ui/css/default/theme.css" type="text/css" rel="stylesheet" />
        <link href="views/css/styles.css" type="text/css" rel="stylesheet" />
    </head>

    <body>
    	<div id="imgloader" class="hide"><span>acessing server please wait...</span><p align="center"><img src="views/images/loading.gif" alt="." /></p></div>
        <div class="rax-content-pal container round">
            <div class="page-header container rax-header-pal rax-glass pad">
                <span id="topmenu"><span id="username"></span> | <a href="changepassword.php">change password</a> | <a href="logout.php">logout</a></span>
                <h1 class="bmm">IREE SOLAR</h1>
                <div class="container rax-toolbar-pal round">
                    <ul>
                    	<li><a href="clients.php">Clients</a></li>
                        <li><a href="quote_listing.php">Grid-Tied PV Form</a></li>
                        <li><a href="off_grid_quote_listing.php">Off Grid PV Form</a></li>
                        <li><a href="ledlisting.php">LED Form</a></li>
                        <li><a href="whlisting.php">SWH Form</a></li>
                        <li class="adm"><a href="submissions.php">Submissions</a></li>
                        <li class="adm"><a href="users.php">Users</a></li>
                        <li class="adm"><a href="settings.php">Settings</a></li>
                        <li class="adm"><a href="texttemplate.php">Edit Template Text</a></li>
                    </ul>
                </div>
            </div>
            <div class="flashmsg" xt-autoupdate></div>
            <div class="page-content master-content prepend1 append1"></div>
            <hr class="space clear" />
        </div>
        <hr class="space clear" />
    </body>
</html>