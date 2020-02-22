<link href="../css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/swfobject.js"></script>
<script type="text/javascript" src="../js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var str = "";
	$("#uploadify").uploadify({
		'uploader'       : '../js/uploadify.swf',
		'script'         : '../js/uploadify.php',
		'cancelImg'      : '../images/cancel.png',
		'folder'         : '../mp3store/',
		'fileExt'        : '*.mp3;*.wma;*.wav',
		'fileDesc'       : 'Music Files',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'onComplete'     : function(event_,queueID,fileObj,response,data)
						   {
								$.get("../includes/ajax_addmp3.php",{file:fileObj.name, filesize:fileObj.size, ext:fileObj.type},
									function(data,textStatus,XMLHttpRequest)
									{ 
										if(textStatus == "success")
										{
											str += data;
											$("#uploadifyTxt").html(str + "<span class='uploadifyMsg'>Please wait until all files<br/>are uploaded.</span>");
										}
										else
										{
											$("#uploadifyTxt").html("File NOT added. " + fileObj.name); 
										}
									}
								)
						   },
		'onAllComplete'  :function(event_,data)
		{
			window.setTimeout("window.location = 'index.php?action=list_music'", 3000);
		}
	});
});
</script>
<span id="uploadifyTxt"></span>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
<p><a href="javascript:jQuery('#uploadify').uploadifyClearQueue()" style="background:url(../images/cancel.png) no-repeat; display:inline-block; padding-left:20px; height:20px; margin-top:5px;">Cancel All Uploads</a></p>
