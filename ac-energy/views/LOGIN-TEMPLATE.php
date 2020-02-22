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
        <div class="rax-content-pal container round">
            <div class="page-header container rax-header-pal rax-glass pad">
                <h1 class="bmm">IREE SOLAR</h1>
            </div>
            <div class="flashmsg" xt-autoupdate></div>
            <div class="page-content prepend1 append1">
                <hr class="space" />
                <form name="frmlogin" id="frmlogin" method="post" action="" class="rax-backdrop">
                	<fieldset>
                        <legend>Login</legend>
                        <div id="flashfrm"></div>
                        <p>
                            <label for="username">Title</label>
                            <input type="text" name="username" id="username" class="textbox" />
                        </p>
                        <p>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="textbox" />
                        </p>
                        <p align="center">
                            <input type="submit" id="btn" value="login" class="button" />
                        </p>
                    </fieldset>
               	</form>
            </div>
            <hr class="space clear" />
        </div>
        <hr class="space clear" />
    </body>
</html>