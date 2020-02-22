<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frm" id="frm" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Settings</legend>
    <div id="controls">
    <p>
    	<label for="{opt_key}">{opt_name}</label>
        <input type="text" value="{opt_value}" class="textbox" name="{opt_key}" id="{opt_key}" onkeypress="return numberOnly(event,false)" />
    </p>
    </div>
    <p>
    	<input type="submit" value="Save" class="button" id="btn" />
    </p>
</fieldset>    
</form>
<hr />

<script language="javascript">
	function numberOnly(e, decimal) 
	{
		var key;
		var keychar;
	
		if (window.event) {
		   key = window.event.keyCode;
		}
		else if (e) {
		   key = e.which;
		}
		else {
		   return true;
		}
		keychar = String.fromCharCode(key);
		
		if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
		   return true;
		}
		else if ((("0123456789.").indexOf(keychar) > -1)) {
		   return true;
		}
		else if (decimal && (keychar == ".")) {
		  return true;
		}
		else
		   return false;
	}
</script>