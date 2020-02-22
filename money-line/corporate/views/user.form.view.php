<?php defined('RAXANPDI') || die(); ?>

<div id="login" class="container rax-box info c25">
    <h2 class="title bottom textcolor"></h2>
    <p class="textcolor">Enter user information</p>
    <div id="msgbox" class="bmm"></div>
    <form class="webform ltm" method="post" action="login.php">
        <input type="hidden" name="userid" />
        <div class="ctrl-group">
            <label><span class="bold">User Name:</span></label><input class="textbox" type="text" name="username" id="username" size="40" maxlength="64"/><br />
        </div>
        <div class="ctrl-group">
            <label>First Name:</label><input class="textbox" type="text" name="first_name" size="40" maxlength="25"/><br />
        </div>
        <div class="ctrl-group">
            <label>Last Name:</label><input class="textbox" type="text" name="last_name" size="40" maxlength="25"/><br />
        </div>
        <div class="ctrl-group">
            <label><span class="bold">Email Address:</span></label><input class="textbox" type="text" name="email" size="40" maxlength="60"/><br />
        </div>
        <div class="ctrl-group">
            <label>Retype Email Address:</label><input class="textbox" type="text" name="email2" size="40" maxlength="60"/><br />
        </div>
        <div class="ctrl-group">
            <label>Status:</label>
                <select name="status" class="c7 left">
                    <option value="A">Active</option>
                    <option value="I">Inactive</option>
                    <option value="L">Locked</option>
                </select><br />
        </div>
        <hr />
        <div class="ctrl-group">
            <label>
                <span class="bold">User Role</span>:<br />
                <span>Select roles that apply</span>
            </label>
        </div>
        <div class="ctrl-group roles left ltm textcolor">
            <input type="checkbox" name="roles[]" value="{name}">&nbsp;{name} - {description}<br />
        </div>
        <hr />
        <div class="ctrl-group applets"></div>
        <hr />
        <div class="ctrl-group">
            <label>
                <span class="bold">Admin Password</span>:<br />
                <span>Enter admin password</span>
            </label>
            <input class="textbox" type="password" name="password" size="40" /><br />
        </div>
        <hr />
        <div class="ctrl-group" style="text-align:right">
            <a href="admin.php">Cancel</a> | <input id="btnsave" type="submit" value="Submit" />
        </div>
    </form>
</div>
