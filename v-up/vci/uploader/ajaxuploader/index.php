<?php
require_once "phpuploader/include_phpuploader.php";
session_start();
?>   
<style>
#uploader{text-align:center; padding:5px; height:100px;font-size:10pt;margin:0 145px;}
.AjaxUploaderQueueTable{ margin:0 auto;}
</style>
<div id="uploader">
<?php
	$uploader=new PhpUploader();
	/*$uploader->MultipleFilesUpload=false;*/
	$uploader->InsertText="Find your video...";
	$uploader->MaxSizeKB=2048000;
	$uploader->AllowedFileExtensions="*.wmv,*.avi,*.mp4,*.mov,*.flv,*.3gp,*.mpg"; 
	$uploader->SaveDirectory="the_tmp_store";
	$uploader->Render();
?>
</div>
<span class="msg">Max file size 200MB</span>
<script type='text/javascript'>
function CuteWebUI_AjaxUploader_OnTaskComplete(task)
{
	var url = task.FileName;
	url =  url.replace('&', '%26');
	window.location.href = "uploader/ajaxuploader/rename.php?id=" + url;
	//window.location.href = "../../vid_converter.php?id=" + task.FileName;
}
//if(!window.top.fuploadername){window.location.href = "http://videouploader.net/";}
</script>
