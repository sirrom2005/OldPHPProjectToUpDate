<?php 
include_once(DOCROOT."classes/commonDB.class.php");
$commObj = new commonDB();
$userId = $_SESSION['BBPINWORLD']['id'];

if(isset($_GET['f'])){
	$file = base64_decode(base64_decode($_GET['f']));
	
	if($obj->deleteImage($file))
	{
		$folder = $_SERVER['DOCUMENT_ROOT'] . PORFILEPHOTO . $userId.'/';
		unlink($folder.$file);	
		unlink($folder.'80_'.$file);
		unlink($folder.'250_'.$file);
		@unlink(DOCROOT."cache/$lang/profile_{$userId}.html");
	}
	echo "<script> location='edit-my-gallery.html';</script>"; exit();
}
if(isset($_GET['sdp'])){	
	$proDate['profile_img'] = '1';
	$obj->setProfileImage($userId,base64_decode($_GET['sdp']));
	@unlink(DOCROOT."cache/$lang/profile_{$userId}.html");
	echo "<script> location='edit-my-gallery.html';</script>"; exit();
}

if($_FILES){
	$tempFile = $_FILES['file_upload']['tmp_name'];
	if($tempFile){
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . PORFILEPHOTO . $userId.'/';
		if(!is_dir($targetPath)){mkdir($targetPath,0755);}
		
		// Validate the file type
		$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
		$fileParts = pathinfo($_FILES['file_upload']['name']);
		
		$img = time().'.'.strtolower($fileParts['extension']);
		$targetFile = rtrim($targetPath,'/') . '/' . $img;
		
		if(in_array(strtolower($fileParts['extension']),$fileTypes)) {
			move_uploaded_file($tempFile,$targetFile);
			chmod($targetFile,0755);
								
			$size = getimagesize($targetPath.'/'.$img);
			imageResize($targetPath.'/', $img, 250, $size[1]/($size[0]/250));
			imageResize($targetPath.'/', $img, 80,  $size[1]/($size[0]/80) );

            $data['account_id'] = $userId;
			$data['image_name'] = $img;
			$data['date_added'] = date("Y-m-d H:i:s");
			$commObj->insertRecord($data,'account_gallery');

			chmod($targetPath.'250_'.$img,0755);	
			chmod($targetPath.'80_'.$img,0755);
			@unlink(DOCROOT."cache/$lang/profile_{$userId}.html");
		}else{ echo 'Invalid file type.';}
	}
}
$proImg = $obj->getProfilePhotos($userId);
$_SESSION['BBPINWORLD']['hasImage'] = (empty($proImg))? 0 : 1;
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold; border:solid 0px #c00;}
label.nostyle{width:auto;font-weight:normal;display:inline;}
ol li{width:170px;margin:0 4px 4px 0; float:left; border:solid 1px #FFFFFF;}
#images li.profile1{ background-color:#A0E0AC;}
#images li{float:left;border:solid 1px #333333;padding:3px; margin:0 1px 2px 0;}
#images li img{width:80px; height:60px;border:solid 1px #333333;}
#images li a.opt{text-decoration:none;margin-bottom:3px;display:block;padding:3px;background-color:#c3cce0;border:solid 1px #000000;}
#images li a.del{background-position:2px 5px; padding-left:22px; color:#c00;}
.swfupload{margin-left:-58px;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/spinners/spinners.js"></script>
<script type="text/javascript" src="js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="styles/lightview/lightview.css" />
<link rel="stylesheet" type="text/css" href="js/uploadify/uploadify.css" />
<script type="text/javascript" src="js/uploadify/jquery.uploadify-3.1.min.js"></script>
<div class="boxStyle1">
<h2>Upload Profile Photo</h2>
    <form method="post" name="ff" action="" enctype="multipart/form-data">
        <p align="center">
        <input type="file" name="file_upload" id="file_upload" />
        <input type="submit" id="btn" value="Upload image..." />
        </p>
    </form>
    <span id="txt"></span>
    <h3>My Gallery</h3>
    <ul id="images">
    <?php 
        $imgLoc = 'images/profile/'.$userId.'/';
        if($proImg)
        {
            foreach($proImg as $row){ 
    ?>
            <li class="profile<?php echo $row['profile_img'];?>">
                <a target="_blank" href="<?php echo DOMAIN.$imgLoc.$row['image_name'];?>" class="lightview" data-lightview-group="album" data-lightview-options="viewport:'scale'" ><img src="<?php echo DOMAIN.$imgLoc.'80_'.$row['image_name'];?>" alt="" title="" class="img80" /></a>
                <a href="#" onclick="javaScript:setProfileImage('<?php echo base64_encode($row['id']);?>');" class="opt">Profile Photo</a>
                <a href="#" onclick="javaScript:removeImage('<?php echo base64_encode(base64_encode($row['image_name']));?>');" class="del opt">delete</a>
            </li>    
    <?php 
            }
        }
    ?>
    </ul><br />
</div>
<script type="text/javascript">
function removeImage(i){
	if(confirm('You are about to DELETE this image.'))
	{
		window.location = 'index.php?action=edit-my-gallery&f='+i;
	}
}

function setProfileImage(i){
	if(confirm('Set as your profile image'))
	{
		window.location = 'index.php?action=edit-my-gallery&sdp='+i;
	}
}
var j= jQuery;
$(function() {
	j("#file_upload").uploadify({
		'swf'      		 : 'js/uploadify/uploadify.swf',
		'uploader' 		 : 'js/uploadify/uploadify.php',
		'fileSizeLimit'  : '0', 
		'method'   		 : 'post',
		'formData' 		 : { 'folder' : <?php echo $userId;?> },
		'fileTypeExts'   : '*.jpeg;*.jpg;*.png;*.gif',
		'fileTypeDesc'   : 'Select image',
		'auto'           : true,
		'multi'          : false,
		'buttonText'     : 'Click To Add Photo',
		'onSWFReady'     : function(){ j('#btn').css("display",'none'); },
		'onUploadStart'  : function(file){ j('#txt').html("<span class='warning'>Page will automatically reload when image process is complete.</span>"); },
		'onQueueComplete': function(event_,data){ window.location = 'edit-my-gallery.html'; }
	});
});
</script>
<?php
function imageResize($dir, $img, $w=50, $h=50)
{
    $src = $dir.$img;
    $ext = explode('.', $img);
    $newfile = $dir.$w.'_'.$ext[0].'.'.$ext[1];

    if( $ext[1] == "jpg"  ){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "jpeg" ){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "pjpeg"){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "gif"  ){ $imageSrc = imagecreatefromgif($src); }
    if( $ext[1] == "png"  ){ $imageSrc = imagecreatefrompng($src); }

    $srcImgWidth	= imagesx($imageSrc);
    $srcImgHeight	= imagesy($imageSrc);
    $dstImgWidth    = (int)$w;
    $dstImgHeight   = (int)$h;

    $imgdest = imagecreatetruecolor( $dstImgWidth, $dstImgHeight );
    imagecopyresampled( $imgdest, $imageSrc, 0,0,0,0, $dstImgWidth , $dstImgHeight, $srcImgWidth, $srcImgHeight );

    if( $ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "pjpeg" )
    {
        @imagejpeg($imgdest, $newfile, 75);
    }
    if( $ext[1] == "gif" )
    {
        /*NOt really sure but wen i add the NULL parameter i get an error*/
        @imagegif($imgdest, $newfile);
    }
    if( $ext[1] == "png" )
    {
        @imagepng($imgdest, $newfile);
    }
    @imagedestroy($imgdest);
    @imagedestroy($imageSrc);
    return $newfile;
}
?>