<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop" enctype="multipart/form-data">
<fieldset>
	<legend>Grid-Tied PV Info</legend>
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
        <span class="right">or <a class="button tpm" href="client.php?n=sq">Add New Client</a></span><br />
    </p>
    <p>
    	<label for="placetype">Place of Visit</label>
        <select name="placetype" id="placetype" class="textbox">
        	<option value="Residence">Residence</option>
            <option value="Business">Business</option>
            <option value="Others">Others</option>
        </select>
    </p>
    <p>
    	<label for="placetype">Add-in SunPower Information</label>
        <input type="checkbox" value="1" name="sunpower" id="sunpower" />
    </p>
    <div id="sections">
        <div id="divsec1">
            <h3>
            	Roof Section 1
                <span class="right">
                    <a id="btnadd" style="cursor:pointer;"><img src="views/images/add.png"/></a>
                    <a id="btnremove" style="cursor:pointer;"><img src="views/images/delete.png" /></a>
                </span><br />
            </h3>
            <p>
                <input type="hidden" value="1" name="section[]" id="section1" />
                <label for="dc_rating1">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating1" value="4.00" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch1">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch1" value="0.77" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing1">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing1" value="180" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter1">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter1" value="" />
            </p>
            <p>
                <label for="roofwiresection1">Wire Run between Roof Section 1 and 2</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection1" value="" />
            </p>
            <p>
                <label for="img_upload1_1">Section 1 Images 1</label>
                <input type="file" class="textbox" name="img_upload1_1" id="img_upload1_1" value="" />
            </p>
            <p>
                <label for="img_upload1_2">Section 1 Images 2</label>
                <input type="file" class="textbox" name="img_upload1_2" id="img_upload1_2" value="" />
            </p>
            <p>
                <label for="img_upload1_3">Section 1 Images 3</label>
                <input type="file" class="textbox" name="img_upload1_3" id="img_upload1_3" value="" />
            </p>
        </div>
        <div id="divsec2" style="display:none;">
            <h3>Roof Section 2</h3>
            <p>
                <input type="hidden" value="2" name="section[]" id="section2" disabled="disabled" />
                <label for="dc_rating2">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating2" value="0" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch2">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch2" value="0" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing2">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing2" value="180" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter2">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter2" value="" />
            </p>
            <p>
                <label for="roofwiresection2">Wire Run between Roof Section 2 and 3</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection2" value="" />
            </p>
            <p>
                <label for="img_upload2_1">Upload Images 1</label>
                <input type="file" class="textbox" name="img_upload2_1" id="img_upload2_1" value="" />
            </p>
            <p>
                <label for="img_upload2_2">Upload Images 2</label>
                <input type="file" class="textbox" name="img_upload2_2" id="img_upload2_2" value="" />
            </p>
            <p>
                <label for="img_upload2_3">Upload Images 3</label>
                <input type="file" class="textbox" name="img_upload2_3" id="img_upload2_3" value="" />
            </p>
        </div>
        <div id="divsec3" style="display:none;">
            <h3>Roof Section 3</h3>
            <p>
                <input type="hidden" value="3" name="section[]" id="section3" disabled="disabled" />
                <label for="dc_rating3">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating3" value="0" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch3">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch3" value="0" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing3">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing3" value="180" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter3">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter3" value="" />
            </p>
            <p>
                <label for="roofwiresection3">Wire Run between Roof Section 3 and 4</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection3" value="" />
            </p>
            <p>
                <label for="img_upload3_1">Upload Images 1</label>
                <input type="file" class="textbox" name="img_upload3_1" id="img_upload3_1" value="" />
            </p>
            <p>
                <label for="img_upload3_2">Upload Images 2</label>
                <input type="file" class="textbox" name="img_upload3_2" id="img_upload3_2" value="" />
            </p>
            <p>
                <label for="img_upload3_3">Upload Images 3</label>
                <input type="file" class="textbox" name="img_upload3_3" id="img_upload3_3" value="" />
            </p>
        </div>
        <div id="divsec4" style="display:none;">
            <h3>Roof Section 4</h3>
            <p>
                <input type="hidden" value="4" name="section[]" id="section4" disabled="disabled" />
                <label for="dc_rating4">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating4" value="0" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch4">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch4" value="0" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing4">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing4" value="180" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter4">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter4" value="" />
            </p>
            <p>
                <label for="roofwiresection4">Wire Run between Roof Section 4 and 5</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection4" value="" />
            </p>
            <p>
                <label for="img_upload4_1">Upload Images 1</label>
                <input type="file" class="textbox" name="img_upload4_1" id="img_upload4_1" value="" />
            </p>
            <p>
                <label for="img_upload4_2">Upload Images 2</label>
                <input type="file" class="textbox" name="img_upload4_2" id="img_upload4_2" value="" />
            </p>
            <p>
                <label for="img_upload4_3">Upload Images 3</label>
                <input type="file" class="textbox" name="img_upload4_3" id="img_upload4_3" value="" />
            </p>
        </div>
        </div>
            <p>
                <label for="length">Length</label>
                <input type="text" class="textbox" name="length" id="length" value=""  onkeypress="return numberOnly(event,false)"/>
            </p>
            <p>
                <label for="width">Width</label>
                <input type="text" class="textbox" name="width" id="width" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="layout2x3columns">layout (2 x 3) columns by rows</label>
                <input type="text" class="textbox" name="layout2x3columns" id="layout2x3columns" value="" />
            </p>
            <p>
                <label for="rooftype">Type of roofing material </label>
                <select id="rooftype" name="rooftype" class="textbox" >
                	<option value="{id}">{name}</option>
                </select>
            </p>
            <p>
                <label for="wire_between_arrary_inverter">Wire run between solar arrary and inverter (ft)</label>
                <input type="text" class="textbox" name="wire_between_arrary_inverter" id="wire_between_arrary_inverter" value="" />
            </p>
            <p>
                <label for="where_will_the_inverter_be_placed">Where will the inverter be placed?</label>
                <input type="text" class="textbox" name="where_will_the_inverter_be_placed" id="where_will_the_inverter_be_placed" value="" />
            </p>
        </div>

    </div>
    <p>
    	<label for="notes">Notes/Comments</label>
        <textarea id="notes" name="notes" class="textbox" cols="40" rows="6"></textarea>
    </p>
    <p>
        <label for="total_cost_of_system">Total Installed Cost of System (USD)</label>
        <input type="text" class="textbox" name="total_cost_of_system" id="total_cost_of_system" value="" onkeypress="return numberOnly(event,false)" />
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