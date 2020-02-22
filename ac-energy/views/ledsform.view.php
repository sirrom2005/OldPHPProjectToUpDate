<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>LED Info</legend>
    <div id="flashfrm"></div>
    <p>
    	<label for="findname">Search for Client</label>
        <input type="text" name="findname" id="findname" class="textbox" autocomplete="off" maxlength="50" />
        <input type="hidden" name="clientid" id="clientid" value="" />
		<script>
			$('#findname').blur(function(){ $('#findname').val(''); $('#clientid').val(''); window.setTimeout("$('#namelist').html('');",150); });
			$('#findname').click(function(){$('#findname').val(''); $('#clientid').val(''); window.setTimeout("$('#namelist').html('');",150); });
        </script>
        <span id="namelist"></span>
        <span class="right">or <a class="button tpm" href="client.php?n=led">Add New Client</a></span><br />
    </p>
	<p>
    	<label for="colour_tem">Colour Temperature?</label>
        <select name="colour_tem" id="colour_tem" class="textbox">
        	<option value="2,400K">2,400K</option>
            <option value="5,000K">5,000K</option>
        </select>
    </p>
    <p>
    	<label for="a19_light_bulb_cnt">How many A19 light bulb fixtures?</label>
        <input type="text" value="0" class="textbox" name="a19_light_bulb_cnt" id="a19_light_bulb_cnt" />
    </p>
    <p>
    	<label for="down_lights_cnt">How many down lights?</label>
        <input type="text" value="0" class="textbox" name="down_lights_cnt" id="down_lights_cnt" />
    </p>
    <p>
    	<label for="tube_4ft_fixtures_cnt">How many 4ft tube fixtures?</label>
        <input type="text" value="0" class="textbox" name="tube_4ft_fixtures_cnt" id="tube_4ft_fixtures_cnt" />
    </p>
    <p>
    	<label for="tube_2ft_fixtures_cnt">How many 2ft tube fixtures?</label>
        <input type="text" value="0" class="textbox" name="tube_2ft_fixtures_cnt" id="tube_2ft_fixtures_cnt" />
    </p>
    <p>
    	<label for="troffers_4ft_cnt">How many 4ft troffers?</label>
        <input type="text" value="0" class="textbox" name="troffers_4ft_cnt" id="troffers_4ft_cnt" />
    </p>
    <p>
    	<label for="outdoor_floodlights_cnt">How many outdoor floodlights?</label>
        <input type="text" value="0" class="textbox" name="outdoor_floodlights_cnt" id="outdoor_floodlights_cnt" />
    </p>
    <p>
    	<label for="street_lights_cnt">How many street lights?</label>
        <input type="text" value="0" class="textbox" name="street_lights_cnt" id="street_lights_cnt" />
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