<style>
body {
	font: 12px/16px Arial, Helvetica, sans-serif;
}
#fileQueue {
	width: 400px;
	height: 300px;
	overflow: auto;
	border: 1px solid #E5E5E5;
	margin-bottom: 10px;
}
.uploadifyQueueItem {
	font: 11px Verdana, Geneva, sans-serif;
	border: 2px solid #E5E5E5;
	background-color: #F5F5F5;
	margin:0 auto;
	padding: 10px;
	width: 350px;
}
.uploadifyError {
	border: 2px solid #FBCBBC !important;
	background-color: #FDE5DD !important;
}
.uploadifyQueueItem .cancel {
	float: right;
}
.uploadifyProgress {
	background-color: #FFFFFF;
	border-top: 1px solid #808080;
	border-left: 1px solid #808080;
	border-right: 1px solid #C5C5C5;
	border-bottom: 1px solid #C5C5C5;
	margin-top: 10px;
	width: 100%;
}
.uploadifyProgressBar {
	background-color: #0099FF;
	width: 1px;
	height: 3px;
}
.uploadifyQueue{margin-top:10px;}
</style>
<script type="text/javascript" src="../js/jquery.tools.min.js"></script>
<script type="text/javascript" src="../js/swfobject.js"></script>
<script type="text/javascript" src="../js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : '../js/uploadify.swf',
		'script'         : '../js/uploadify.php',
		'cancelImg'      : '../images/cancel.png',
		'folder'         : 'the_tmp_store',
		'auto'           : true,
		'multi'          : false,
		'fileDesc'		 : 'Select video file',
		'fileExt'	  	 : '*.wmv;*.avi;*.mp4;*.mov;*.flv;*.3gp;*.mpg',
		'sizeLimit' 	 : '2097152000', 
		'onComplete'	 : function (event_,queueID,fileObj,response,data)
						 { 
							$.get("<?php echo DOMAIN;?>includes/ajax_preparefile.php",
									{file:fileObj.name},
									function(data)
									{
										window.location = data;
									}
							)
						 }
	});
});
</script>

<div class="leftside">
	<div class="msg">
    <p>Click browse button below to locate video file, max file-size 200mb.</p><br />
    <input type="file" name="uploadify" id="uploadify" />
<!--p>Down for maintenance</p-->
    </div>
</div>
<div class="rightside">
    <script type="text/javascript"><!--
    google_ad_client = "pub-7769573252573851";
    /* 300x250_txt_img */
    google_ad_slot = "6699070243";
    google_ad_width = 300;
    google_ad_height = 250;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>