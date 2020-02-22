<?php
include_once("../classes/site.class.php");
$obj = new site();

$id = (isset($_GET['id']))? $_GET['id'] : 0;
$title = $summary = $detail = $msg = $category_id = null;
if($_POST){
    $rs = $_POST;
	$tags = (isset($rs['tags']))? $rs['tags'] : null;
	$data['title']   = $title   = addslashes(cleanText($rs['title']));
	$data['category_id'] = $rs['category_id'];
	$data['summary'] = $summary = addslashes($rs['summary']);
	$data['detail']  = $detail  = addslashes(cleanHtml($rs['detail']));
	$valid	= true;    
	        
	if(empty($title)  ){ $msg .= '<li>Title is required.</li>';  $valid = false;}
	if(empty($summary)){ $msg .= '<li>Summary is required.</li>'; $valid = false;}
	if(empty($detail) ){ $msg .= '<li>Detail is required.</li>'; $valid = false;}
		
	if($valid){		
		if($id)
		{
			$data['news_date'] = $rs['year'].'-'.$rs['month'].'-'.$rs['day'];
			$rs = $comObj->updateRecord($data,'news_articles',$id);
			$obj->insertNewsGalleryTags($id,$tags);
			echo "<script> location = 'index.php?action=news';</script>";
		}else{
			$data['news_date'] = $data['date_added'] = date("Y-m-d H:i:s");
			if($comObj->insertRecord($data,'news_articles')){
				$id = mysql_insert_id();
				$obj->insertNewsGalleryTags($id,$tags);
				echo "<script> location = 'index.php?action=add-news&id=$id';</script>";
			}
		}
	}
    echo $msg = "<span class='error'>$msg</span><br>";
}

$tags = $comObj->getHtmlListControlData('`photo-gallery_tags`','name','id','name',NULL);
$category = $comObj->getHtmlListControlData('`news-category`','name','id','id',NULL);

if($id){
	$rs 		= $comObj->getDataById('news_articles',$id);
	$title 		= $rs['title'];
	$category_id= $rs['category_id'];
	$summary 	= $rs['summary'];
	$detail 	= $rs['detail'];
	$tagList    = $obj->getNewsGalleryTags($id);
	$date 		= explode('-',date('Y-m-d',strtotime($rs['news_date'])));
	$btn		= "Edit Post";
}else{
	$btn  = "Add Post";
	$date = explode('-',date('Y-m-d'));
}
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		elements : "detail",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,preview,help,code",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		template_templates : [
        {
                title : "Newspaper  layout",
                src : "newspaperlayout.html",
                description : "2 column news paper layout."
        }
		]
	});
</script>
<!-- /TinyMCE -->
<h2>Add News Item</h2>
<form name="frm" id="frm" class="frmStyle" method="post" action=""> 
	<div class="right">
    	<h5>Gallery Tags</h5>
    	<?php 
			if($tags){ 
			foreach($tags as $key => $value){	
		?>
        	<input type="checkbox" name="tags[]" value="<?php echo $key;?>" id="g<?php echo $key;?>" <?php echo ( isset($tagList[$key]) && $tagList[$key] == $key)? "checked" : "" ;?> /><label for="g<?php echo $key;?>"><?php echo $value;?></label><br />
        <?php }} ?>
    </div>
    <p><label for="title">Title <font style="color:#FF0000;">*</font></label><input type="text" name="title" id="title" value="<?php echo cleanString($title);?>" class="textbox" /></p>
    <p><label for="category_id">Category <font style="color:#FF0000;">*</font></label>
        <select name="category_id">
            <?php foreach($category as $key => $value){?>
            <option value="<?php echo $key;?>" <?php echo ($key == $category_id)? "selected" : "" ;?>><?php echo $value;?></option>
            <?php } ?>
        </select>
    </p>
    <p><label>Date</label>
    	<select name="day">
        	<?php for($i=1;$i<=31;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo ((int)$i == (int)$date[2])? "selected" : "" ;?>><?php echo date('d',mktime(0,0,0,0,$i,0));?></option>
            <?php } ?>
        </select>
        <select name="month">
        	<?php for($i=1;$i<=12;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo ((int)$i == (int)$date[1])? "selected" : "" ;?>><?php echo date('M',mktime(0,0,0,$i+1,0,0));?></option>
            <?php }?>
        </select>
        <select name="year">
        	<?php 
				for($i=0;$i<=3;$i++){
				$yr = date('Y',mktime(0,0,0,0,0,2013+$i));
			?>
        		<option value="<?php echo $yr;?>" <?php echo ((int)$yr == (int)$date[0])? "selected" : "" ;?>><?php echo $yr;?></option>
            <?php }?>
        </select>
    </p>
    <p><label for="summary" style="white-space:nowrap;">Summary <font style="color:#FF0000; font-size:12px; font-weight:normal;">*(Only plain text)</font></label><br><textarea cols="50" rows="8" name="summary" id="summary"><?php echo cleanString($summary);?></textarea></p>
    <p><label for="detail">Description <font style="color:#FF0000;">*</font></label><br><textarea cols="50" rows="8" name="detail" id="detail" style="height:300px;" ><?php echo cleanHtml($detail);?></textarea></p>
    <p align="center"><input type="submit" class="btn" id="btn" value="<?php echo $btn;?>"></p>
    <?php 
		if($id){ 
			$img = $obj->getNewsImage($id);
	?>
    	<div class="mediabk">
        	<h3>Media Files For This Article</h3>
            	<?php if($img){ ?>
                <ul id="imgs">
                	<?php foreach($img as $ig){ ?>
                    <li><img src="<?php echo '/'.NEWSFOLDER.$id.'/100_'.$ig['image_name'];?>" /><a href="javaScript:delImage(<?php echo $ig['id'];?>,'<?php echo base64_encode($ig['image_name']);?>',<?php echo $id;?>);" class="remove"></a></li>
                    <?php } ?>
                </ul>
                <hr />
                <?php } ?>
            <p><input type="file" name="Filedata" id="Filedata" /></p>
            <?php if(!$rs['video']){ ?>
            	<p id="vt"><input type="file" name="videoData" id="videoData" /></p>
            <?php }else{ echo "<p><a href='javaScript:delVideo(\"". base64_encode($rs['video'])."\");' >Delete video file</a></p>";} ?>
            <?php if(!$rs['audio']){ ?>
            	<p id="at"><input type="file" name="audioData" id="audioData" /></p>
             <?php }else{ echo "<p><a href='javaScript:delAudio(\"". base64_encode($rs['audio'])."\");' >Delete audio file</a></p>";} ?>
        </div>
	<?php } ?>
</form>

<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN;?>js/uploadify/uploadify.css" />
<script type="text/javascript" src="<?php echo DOMAIN;?>js/uploadify/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript">
$(function() {
    $("#Filedata").uploadify({
        'swf'      : '<?php echo DOMAIN;?>js/uploadify/uploadify.swf',
        'uploader' : '<?php echo DOMAIN;?>js/uploadify/uploadify-news-photo.php',
        'fileSizeLimit'  : '0', 
        'method'   : 'post',
        'formData' : { 'folder' : <?php echo $id;?> },
        'fileTypeExts'   : '*.jpg;*.jpeg;*.gif;*.png',
        'fileTypeDesc'   : 'Select image',
        'auto'           : true,
        'multi'          : false,
		'buttonText'	 : 'UPLOAD IMAGE',
        'onSWFReady'     : function(){ },
        'onQueueComplete': function(event_,data){ 
                                window.location.reload();
                            }
    });
});

$(function() {
    $("#videoData").uploadify({
        'swf'      : '<?php echo DOMAIN;?>js/uploadify/uploadify.swf',
        'uploader' : '<?php echo DOMAIN;?>js/uploadify/uploadify-news-video.php',
        'fileSizeLimit'  : '0', 
        'method'   : 'post',
        'formData' : { 'folder' : <?php echo $id;?> },
        'fileTypeExts'   : '*.mpeg;*.mpg;*.flv;*.avi',
        'fileTypeDesc'   : 'Select video file',
        'auto'           : true,
        'multi'          : false,
		'buttonText'	 : 'UPLOAD VIDEO',
        'onSWFReady'     : function(){ },
        'onQueueComplete': function(event_,data){ 
                                $("#vt").html("Video file added...");
                            }
    });
});

$(function() {
    $("#audioData").uploadify({
        'swf'      : '<?php echo DOMAIN;?>js/uploadify/uploadify.swf',
        'uploader' : '<?php echo DOMAIN;?>js/uploadify/uploadify-audio.php',
        'fileSizeLimit'  : '0', 
        'method'   : 'post',
        'formData' : { 'folder' : <?php echo $id;?> },
        'fileTypeExts'   : '*.mp3;*.wav',
        'fileTypeDesc'   : 'Select audio file',
        'auto'           : true,
        'multi'          : false,
		'buttonText'	 : 'UPLOAD AUDIO',
        'onSWFReady'     : function(){ },
        'onQueueComplete': function(event_,data){ 
                                $("#at").html("Audio file added...");
                            }
    });
});

function delImage(id,img,rt){
	if(confirm("Remove this image")){
		window.location = "index.php?action=del-news-image&id=" + id + "&f=" + img + "&rt=" + rt;
	}
}
function delVideo(vd){
	if(confirm("Remove this video file")){
		window.location = "index.php?action=del-news-video&v=" + vd + "&id=" + <?php echo $id;?>;
	}
}
function delAudio(vd){
	if(confirm("Remove this audio file")){
		window.location = "index.php?action=del-news-audio&v=" + vd + "&id=" + <?php echo $id;?>;
	}
}
</script>
