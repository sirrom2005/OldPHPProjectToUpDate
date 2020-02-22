<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frmquote" id="frmquote" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Solar Quote Form Review</legend>
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
        <input type="text" value="" class="textbox" name="telephone" id="telephone" />
    </p>
    <p>
    	<label for="email">Email</label>
        <input type="text" value="" class="textbox" name="email" id="email" />
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
    	<label for="address">Address <font class="required">*</font></label>
        <textarea name="address" id="address" class="textbox"></textarea>
    </p>
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
    <!--p>
        <label for="">Upload Images</label>
        <input type="file" class="textbox" name="img_upload" id="img_upload" value="" />
    </p-->
    <p>
        <label for="rooftype">Type of roofing material </label>
        <select id="rooftype" name="rooftype" class="textbox" >
            <option value="{id}">{name}</option>
        </select>
    </p>
    <p>
        <label for="">Wire run between solar arrary and inverter (ft)</label>
        <input type="text" class="textbox" name="wire_between_arrary_inverter" id="wire_between_arrary_inverter" value="" />
    </p>
    <p>
        <label for="">Where will the inverter be placed?</label>
        <input type="text" class="textbox" name="where_will_the_inverter_be_placed" id="where_will_the_inverter_be_placed" value="" />
    </p>
    <div id="sections">
        <div id="divsec1">
            <h3>
            	Roof Section 1
            </h3>
            <p>
                <input type="hidden" value="1" name="section[]" id="section1" />
                <label for="dc_rating1">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating1" value="" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch1">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch1" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing1">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing1" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter1">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter1" value="" />
            </p>
            <p>
                <label for="roofwiresection1">Wire Run between Roof Section 1 and 2</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection1" value="" />
            </p>
        </div>
        <div id="divsec2" class="hide">
            <h3>Roof Section 2</h3>
            <p>
                <input type="hidden" value="2" name="section[]" id="section2" disabled="disabled" />
                <label for="dc_rating2">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating2" value="" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch2">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch2" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing2">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing2" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter2">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter2" value="" />
            </p>
            <p>
                <label for="roofwiresection2">Wire Run between Roof Section 2 and 3</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection2" value="" />
            </p>
        </div>
        <div id="divsec3" class="hide">
            <h3>Roof Section 3</h3>
            <p>
                <input type="hidden" value="3" name="section[]" id="section3" disabled="disabled" />
                <label for="dc_rating3">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating3" value="" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch3">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch3" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing3">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing3" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter3">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter3" value="" />
            </p>
            <p>
                <label for="roofwiresection3">Wire Run between Roof Section 3 and 4</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection3" value="" />
            </p>
        </div>
        <div id="divsec4" class="hide">
            <h3>Roof Section 4</h3>
            <p>
                <input type="hidden" value="4" name="section[]" id="section4" disabled="disabled" />
                <label for="dc_rating4">DC Rating/DC Array Size(Kw)</label>
                <input type="text" class="textbox" name="dc_rating[]" id="dc_rating4" value="" onkeypress="return numberOnly(event,false)"  />
            </p> 
            <p>
                <label for="pitch4">Array Title/Pitch</label>
                <input type="text" class="textbox" name="pitch[]" id="pitch4" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="bearing4">Array Azzimuth/Bearing of Roof</label>
                <input type="text" class="textbox" name="bearing[]" id="bearing4" value="" onkeypress="return numberOnly(event,false)" />
            </p>
            <p>
                <label for="inverter4">Wire Run from Roof to Inverter</label>
                <input type="text" class="textbox" name="inverter[]" id="inverter4" value="" />
            </p>
            <p>
                <label for="roofwiresection4">Wire Run between Roof Section 4 and 5</label>
                <input type="text" class="textbox" name="roofwiresection[]" id="roofwiresection4" value="" />
            </p>
        </div>
    </div>
    <p>
    <p>
    	<label for="notes">Notes/Comments</label>
        <textarea id="notes" name="notes" class="textbox" cols="40" rows="6"></textarea>
    </p>
    <p>
        <label for="total_cost_of_system">Total Installed Cost of System (USD)</label>
        <input type="text" class="textbox" name="total_cost_of_system" id="total_cost_of_system" value="" onkeypress="return numberOnly(event,false)" />
    </p>
</fieldset>    
</form>
<hr />