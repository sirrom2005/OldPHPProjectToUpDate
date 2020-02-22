<?php defined('RAXANPDI')||die(); ?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Corporate Moneyline</title>
        <base href="" />
        <link href="../common/raxan/ui/css/master.css" type="text/css" rel="stylesheet" />
        <!--[if lt IE 8]><link href="../common/raxan/ui/css/master.ie.css" type="text/css" rel="stylesheet" /><![endif]-->
        <link href="../common/raxan/ui/css/default/theme.css" type="text/css" rel="stylesheet" />
        <link href="views/theme/theme.css" type="text/css" rel="stylesheet" />
        <link rel="icon" type="image/png" href="favicon.png" />
    </head>

    <body>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="container c32">
            <div id="errorbox" class="c31 round rax-box-shadow">
                <div class="content round  pad1">
                    <h2 id="errortitle" class="box-title">System Error</h2>
                    <hr />
                    <div id="errormsg" class="flashmsg pad"></div>
                    <hr />
                    <div class="pad buttonbar" align="right">
                        <a id="signinbtn" class="button" href="login.php" langid="signin">Sign In</a>
                        <div id="homebtn">
                            <a class="button" href="index.php" langid="back-to-home">Back to Home Page</a>&nbsp;
                            <a class="button cancel" href="login.php?do=logout" langid="logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
    </body>

</html>

