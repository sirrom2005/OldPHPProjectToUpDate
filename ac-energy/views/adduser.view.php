<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Add User</legend>
    <p>
    	<label for="firstname">Firstname <font class="required">*</font></label>
        <input type="text" value="" class="textbox" name="firstname" id="firstname" />
    </p>
    <p>
    	<label for="lastname">Lastname</label>
        <input type="text" value="" class="textbox" name="lastname" id="lastname" />
    </p>
    <p>
    	<label for="email">Email <font class="required">*</font></label>
        <input type="text" value="" class="textbox" name="email" id="email" />
    </p>
    <p>
    	<label for="position">Position <font class="required">*</font></label>
        <input type="text" value="" class="textbox" name="position" id="position" />
    </p>
    <p>
    	<label for="">Account Type</label>
    	<input name="acc_level" type="radio" value="1" id="acc1" /> <label for="acc1" class="labelNoSTyle">Administrator</label>
        <input name="acc_level" type="radio" value="2" id="acc2" checked="checked" /> <label for="acc2" class="labelNoSTyle">User</label>
    </p>
    <p>
    	<input type="submit" value="Save" class="button" id="btn" />
    </p>
</fieldset>    
</form>
<hr />