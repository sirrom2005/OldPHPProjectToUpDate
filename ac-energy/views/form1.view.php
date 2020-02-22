<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>SWH Info</legend>
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
        <span class="right">or <a class="button tpm" href="client.php?n=wh">Add New Client</a></span><br />
    </p>
    <p>
    	<label for="value1">How many persons will use the system daily?</label>
        <input type="text" value="" class="textbox" name="value1" id="value1" />
    </p>
    <p>
    	<label for="value2">Will we need to drill through the wall, where?</label>
        <input type="text" value="" class="textbox" name="value2" id="value2" />
    </p>
   	<p>
    	<label for="value3">System size</label>
        <select name="value3" id="value3" class="textbox">
        	<option value="100L/30gal">100L/30gal</option>
            <option value="150L/40gal">150L/40gal</option>
            <option value="200L/53gal">200L/53gal</option>
            <option value="300L/80gal">300L/80gal</option>
        </select>
    </p>
    <p>
    	<label for="value4">Will the client require an eletrical back up?</label>
        <select name="value4" id="value4" class="textbox">
        	<option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
    </p>
    <p>
    	<label for="value5">Type of System</label>
        <select name="value5" id="value5" class="textbox">
        	<option value="Residence">Integrated SELECT</option>
            <option value="Business">Integrated PREMIUM</option>
            <option value="Others">Split</option>
            <option value="Others">Retrofit</option>
        </select>
    </p>
    <p>
    	<label for="value6">Will the client require a thermostat system?</label>
        <input type="text" value="" class="textbox" name="value6" id="value6" />
    </p>
    <p>
    	<label for="value7">Type of Roof</label>
        <select name="value7" id="value7" class="textbox">
        	<option value="Concrete Slab">Concrete Slab</option>
            <option value="South South West with Foam">South South West with Foam</option>
            <option value="Gable Roof (Inside Out)">Gable Roof (Inside Out)</option>
            <option value="Gable Roof (Outside In)">Gable Roof (Outside In)</option>
        </select>
    </p>
    <p>
    	<label for="value8">Where will the thermostat be place, Wire run.</label>
        <input type="text" value="" class="textbox" name="value8" id="value8" />
    </p>
    <p>
    	<label for="value9">Orientation of intended roof for installation </label>
        <select name="value9" id="value9" class="textbox">
        	<option value="East">East</option>
            <option value="South South East">South South East</option>
            <option value="South">South</option>
            <option value="South South West">South South West</option>
        </select>
    </p>
    <p>
    	<label for="value10">Is there a existing heater? how many?</label>
        <input type="text" value="" class="textbox" name="value10" id="value10" />
    </p>
    <p>
    	<label for="value11">Where will the pipes be connected to the building</label>
        <input type="text" value="" class="textbox" name="value11" id="value11" />
    </p>
    <p>
    	<label for="value12">Does the client wish to keep the existing heater?</label>
        <input type="text" value="" class="textbox" name="value12" id="value12" />
    </p>
    <p>
    	<label for="value13">Addition cold water pipe 10ft length</label>
        <input type="text" value="" class="textbox" name="value13" id="value13" />
    </p>
    <p>
    	<label for="value14">Does the client want muliple quotation</label>
       	<select name="value14" id="value14" class="textbox">
        	<option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
    </p>
    <p>
    	<label for="value15">Addition hot water pipe 10ft length</label>
        <input type="text" value="" class="textbox" name="value15" id="value15" />
    </p>
    <p>
    	<label for="value16">How many 10ft length of trucking, How many bends</label>
        <input type="text" value="" class="textbox" name="value16" id="value16" />
    </p>
    <p>
    	PVC Info
        <hr />
    	<label for="value17">Available roof space for panel sq/ft</label>
        <input type="text" value="" class="textbox" name="value17" id="value17" />
    </p>
    <p>
    	<label for="value18">What is the currently monthly KHW usage?</label>
        <input type="text" value="" class="textbox" name="value18" id="value18" />
    </p>
    <p>
    	<label for="value19">What is their currently dollar value of the JPS bill:</label>
        <input type="text" value="" class="textbox" name="value19" id="value19" />
    </p>
    <p>
    	<label for="value20">Estimated  lenght of wire run from PV panel to box</label>
        <input type="text" value="" class="textbox" name="value20" id="value20" />
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