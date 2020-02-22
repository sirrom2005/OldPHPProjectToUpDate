<?php defined('RAXANPDI')||exit(); ?>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>

<hr class="space" />
<form name="frm" id="frm" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Edit Template Text</legend>
    <div id="flashfrm"></div>
	<p>
    	<h3 id="title" class="bmm"></h3>
    	<textarea id="detail" name="detail" rows="15" cols="80" style="width: 80%"></textarea>
    </p>
    <p>
    	<input type="submit" value="Submit" class="button" id="btn" onclick="javaScript:tinyMCE.triggerSave();return true;" />
    </p>
    <p class="required">Do not edit key words eg [ _AVGPOWER_ | _CLIENTNAME_ ]</p>
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
</script>