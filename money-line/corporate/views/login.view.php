<?php defined('RAXANPDI')||die(); ?>

<hr class="space" />
<div id="login-content">
    <div id="login" class="container rax-box info c19">
        <h2 class="bottom textcolor">Login</h2>
        <p class="bmm textcolor">Enter your corporate id, user name and password</p>
        <div id="msgbox" class="flashmsg bmm"></div>
        <form class="webform ltm" method="post" action="login.php">
            <div class="ctrl-group">
                <label>User Name:</label><input class="textbox" type="text" name="uid" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <label>Password:</label><input class="textbox" type="password" name="pwd" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <label>Corporate ID:</label><input class="textbox" type="text" name="corpid" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <div class="infobox textcolor">Forget password? <a href="forgetpwd.php">Click to Reset</a></div>
            </div
            <hr/>
            <div class="textcolor ctrl-group" style="text-align:right">
                <input id="btnlogin" type="submit" value="Login" xt-bind="#click,loginEvent" />
            </div>
        </form>
    </div>
    <div class="container c22 tpm quiet hlf-pad" style="text-align:center">Recommended Browsers: Internet Explorer 7+, Firefox 3+, Chrome 2+, Safari 3+</div>
</div>

