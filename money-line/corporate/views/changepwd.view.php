<?php defined('RAXANPDI') || die(); ?>

<!-- Panel HTML Code -->
<div id="changepwd" class="container c19 rax-box alert">
    <h2 class="bottom">Change Password</h2>
    <p class="bmm">You are required to change your password</p>
    <div id="msgbox" class="bmm"></div>
    <form class="webform ltm" method="post" action="login.php">
        <div class="ctrl-group">
            <label>Old Password:</label><input class="textbox" type="password" name="old" size="30" /><br />
        </div>
        <div class="ctrl-group">           
            <label>New Password:</label><input class="textbox" type="password" name="pwd1" size="30" /><br />
        </div>
        <div class="ctrl-group">
            <label>Retype New Password:</label><input class="textbox" type="password" name="pwd2" size="30" /><br />
        </div>
        <hr />
        <div class="ctrl-group" style="text-align:right; line-height:30px; vertical-align:baseline">
            <a href="login.php?do=logoff">Logout</a>&nbsp;|&nbsp;
            <input id="btnchange" type="submit" value="Change" xt-bind="#click,changeEvent" />
        </div>
    </form>
</div>
