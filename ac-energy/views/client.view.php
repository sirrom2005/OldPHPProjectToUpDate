<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frm" id="frm" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>New Client</legend>
    <div id="flashfrm"></div>
	<p>
    	<label for="title">Title</label>
        <select name="title" id="title" class="textbox">
        	<option value="Mr.">Mr.</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Miss.">Miss.</option>
            <option value="Dr.">Dr.</option>
        </select>
    </p>
    <p>
    	<label for="firstname">Firstname <font class="required">*</font></label>
        <input type="text" value="" class="textbox" name="firstname" id="firstname" />
    </p>
    <p>
    	<label for="lastname">Lastname</label>
        <input type="text" value="" class="textbox" name="lastname" id="lastname" />
    </p>
   	<p>
    	<label for="telephone">Telephone</label>
        <input type="text" value="" class="textbox" name="telephone" id="telephone" onkeypress="return phoneNumber(event,false)" />
    </p>
    <p>
    	<label for="email">Email</label>
        <input type="text" value="" class="textbox" name="email" id="email" />
    </p>
    <p>
    	<label for="address">Address <font class="required">*</font></label>
        <textarea name="address" id="address" class="textbox"></textarea>
    </p>
  
    <p>
    	<input type="submit" value="Submit" class="button" id="btn" />
    </p>
</fieldset>    
</form>
<hr />

<script language="javascript">
var sect = 1;
var html = "";


$("#btnadd").click(function(){
	sect+=1;
	if(sect>5){return false;}
	$("#divsec" + sect).show();
	$("#section" + sect).attr("disabled", false);
});

$("#btnremove").click(function(){
	if(sect==1){return false;}
	$("#divsec" + sect).hide();
	$("#section" + sect).attr("disabled", "disabled");
	sect-=1;
});

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

function moneyOnly(e, decimal) 
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
	else if ((("0123456789.,").indexOf(keychar) > -1)) {
	   return true;
	}
	else if (decimal && (keychar == ".")) {
	  return true;
	}
	else
	   return false;
}

function phoneNumber(e, decimal) 
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
	else if ((("0123456789-() ").indexOf(keychar) > -1)) {
	   return true;
	}
	else if (decimal && (keychar == ".")) {
	  return true;
	}
	else
	   return false;
}
</script>