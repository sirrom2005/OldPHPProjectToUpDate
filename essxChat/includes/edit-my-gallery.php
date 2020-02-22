<?php 
include_once("classes/commonDB.class.php");
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
	}
	header('location: edit-my-gallery.html');
}

if($_FILES){
	$tempFile = $_FILES['file_upload']['tmp_name'];
	if($tempFile){
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . PORFILEPHOTO . $userId.'/';
		if(!is_dir($targetPath)){mkdir($targetPath);}
		
		// Validate the file type
		$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
		$fileParts = pathinfo($_FILES['file_upload']['name']);
		
		$img = time().'.'.strtolower($fileParts['extension']);
		$targetFile = rtrim($targetPath,'/') . '/' . $img;
		
		if(in_array(strtolower($fileParts['extension']),$fileTypes)) {
			move_uploaded_file($tempFile,$targetFile);
			chmod($targetFile,0755);
					
			$data['account_id'] = $userId;
			$data['image_name'] = $img;
			$data['date_added'] = date("Y-m-d H:i:s");
			$commObj->insertRecord($data,'account_gallery'); 
			
			$size = getimagesize($targetPath.'/'.$img);
			imageResize($targetPath.'/', $img, 250, $size[1]/($size[0]/250));
			imageResize($targetPath.'/', $img, 80,  $size[1]/($size[0]/80) );		
		}else{ echo 'Invalid file type.';}
	}
}
			
$proImg = $obj->getProfilePhotos($userId);
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold; border:solid 0px #c00;}
label.nostyle{width:auto;font-weight:normal;display:inline;}
ol li{width:170px;margin:0 4px 4px 0; float:left; border:solid 1px #FFFFFF;}
.img250{border:solid 1px #b7c6ec;padding:3px;width:240px;}
#images li{float:left; width:80px;border:solid 1px #333333;padding:3px; margin:0 1px 2px 0;}
#images li img{width:80px; height:60px;border:solid 1px #333333;}
.del{display:block; background:url(images/remove.png) no-repeat; padding-left:17px;text-decoration:none;}
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
<h2>Upload profile photo</h2>
<div class="largeProfile">
    <div class="gallery">
        <?php $img = ($proImg[0]['image_name'])? 'images/profile/'.$userId.'/250_'.$proImg[0]['image_name'] : 'images/profile/profile.png'; ?>
        <a href="profile.html"><img src="<?php echo $img;?>" alt="" title="" class="img250" /></a>
    </div>
    <div class="info">
        <script type="text/javascript">
        $(function() {
            $("#file_upload").uploadify({
                'swf'      : 'js/uploadify/uploadify.swf',
                'uploader' : 'js/uploadify/uploadify.php',
                'fileSizeLimit'  : '0', 
				'method'   : 'post',
                'formData' : { 'folder' : <?php echo $userId;?> },
                'fileTypeExts'   : '*.jpeg;*.jpg;*.png;*.gif',
                'fileTypeDesc'   : 'Select image',
                'auto'           : true,
                'multi'          : false,
				'onSWFReady'     : function(){ $('#btn').css("display",'none'); },
                'onQueueComplete': function(event_,data){ 
                                        window.location = 'edit-my-gallery.html';
                                    }
            });
        });
        </script>
        <form method="post" name="ff" action="" enctype="multipart/form-data">
        	<input type="file" name="file_upload" id="file_upload" />
            <input type="submit" id="btn" value="Upload image..." />
        </form>
        <h3>My Gallery</h3>
        <ul id="images">
        <?php 
			$imgLoc = 'images/profile/'.$userId.'/';
			if($proImg)
			{
				foreach($proImg as $row){ 
		?>
        		<li>
        			<a target="_blank" href="<?php echo $imgLoc.$row['image_name'];?>" class="lightview" data-lightview-group="album" data-lightview-options="viewport:'scale'" ><img src="<?php echo $imgLoc.'80_'.$row['image_name'];?>" alt="" title="" class="img80" /></a>
                    <a href="#" onclick="javaScript:removeImage('<?php echo base64_encode(base64_encode($row['image_name']));?>');" class="del">delete</a>
                </li>    
        <?php 
				}
			}
		?>
        </ul>
    </div>
</div>
<script>
function removeImage(i){
	if(confirm('You are about to delete this image.'))
	{
		window.location = 'index.php?action=edit-my-gallery&f='+i;
	}
}
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
	@chmod($dir.$newfile,0755);
    return $newfile;
}
?>