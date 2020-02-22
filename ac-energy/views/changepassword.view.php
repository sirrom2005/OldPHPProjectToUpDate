<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Change Password</legend>
    <div id="flashfrm"></div>
    <p>
    	<label for="oldpass">Old Password <font class="required">*</font></label>
        <input type="password" value="" class="textbox" name="oldpass" id="oldpass" />
    </p>
    <p>
    	<label for="password">New Password</label>
        <input type="password" value="" class="textbox" name="password" id="password" />
    </p>
    <p>
    	<label for="password2">Confirm Password</label>
        <input type="password" value="" class="textbox" name="password2" id="password2" />
    </p>
    <p>
    	<input type="submit" value="Submit" class="button" id="btn" />
    </p>
</fieldset>    
</form>
<hr />