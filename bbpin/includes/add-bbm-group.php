<?php 
include_once(DOCROOT."classes/commonDB.class.php");
$commObj = new commonDB();

if(isset($_GET['rem'])){
	$id = $_GET['rem'];
	if($commObj->deleteData('bbm_group','id',$id)){		
		$mydir = "images/profile/group_{$id}/"; 
		if(is_dir($mydir)){
			$d = dir($mydir); 
			while($entry = $d->read()) { 
			 if ($entry!= "." && $entry!= "..") { 
				unlink($mydir.$entry); 
			 } 
			} 
			$d->close(); 
			rmdir($mydir); 
		}
		header("location: your-group.html");
	}
}

$interest 	= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$country 	= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
$groupId 	= (isset($_GET['id']))? $_GET['id'] : 0;
$err = "";
$rs = array('group_name' => '', 'country_id' => '', 'group_detail' => '', '' => '');

if($_POST){
	$rs = $_POST;
	$data['group_name']	  = cleanText($rs['group_name']);
	$data['group_detail'] = addslashes(cleanText($rs['group_detail']));
	$data['country_id']	  = $rs['country_id'];
	$data['date_updated'] = date("Y-m-d H:i:s");
	$valid  = true;
	
	if(empty($data['group_name'])){
		$err .= "<p>group name is required.</p>";
		$valid  = false;
	}
	if(empty($data['group_detail'])){
		$err .= "<p>group detail is required.</p>";
		$valid  = false;
	}
	if(!isset($rs['interest'])){
		$err .= "<p>group category is required.</p>";
		$valid  = false;
	}
	
	if($valid){
		if(isset($_GET['id'])){
			if($commObj->updateRecord($data,'bbm_group',$groupId)){
				$commObj->deleteData('group_interest','group_id',$groupId);
				$rs['interest'] = (isset($rs['interest']))? $rs['interest'] : array();
				if($obj->insertGroupInterest($rs['interest'],$groupId)){}
				echo "<script>location='group_{$groupId}.html';</script>";
			}
		}
		else
		{
			$data['account_id']   = $_SESSION['BBPINWORLD']['id'];
			$data['date_added']   = date("Y-m-d H:i:s"); 
			if($commObj->insertRecord($data,'bbm_group')){
				$groupId = mysql_insert_id();
				$rs['interest'] = (isset($rs['interest']))? $rs['interest'] : array();
				if($obj->insertGroupInterest($rs['interest'],$groupId)){
					if($_FILES['Filedata']['tmp_name']){
						$targetFolder = 'group_'.$groupId;
						$tempFile = $_FILES['Filedata']['tmp_name'];
						$targetPath = $_SERVER['DOCUMENT_ROOT'] . PORFILEPHOTO . $targetFolder.'/';
						
						if(!is_dir($targetPath)){mkdir($targetPath);}
						
						// Validate the file type
						$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
						$fileParts = pathinfo($_FILES['Filedata']['name']);
						
						$img = time().'.'.strtolower($fileParts['extension']);
						$targetFile = rtrim($targetPath,'/') . '/' . $img;
						
						if(in_array(strtolower($fileParts['extension']),$fileTypes)) {
							move_uploaded_file($tempFile,$targetFile);
							chmod($targetPath,0755);
							chmod($targetFile,0755);
							
							$gdata['group_id'] = $groupId;
							$gdata['image_name'] = $img;
							$gdata['date_added'] = date("Y-m-d H:i:s");
							$commObj->insertRecord($gdata,'group_gallery'); 
							
							$size = getimagesize($targetPath.'/'.$img);
							imageResize($targetPath.'/', $img, 250, $size[1]/($size[0]/250));
							imageResize($targetPath.'/', $img, 80,  $size[1]/($size[0]/80) );	
							chmod($targetPath.'250_'.$img,0755);	
							chmod($targetPath.'80_'.$img,0755);	
						}else{ echo 'Invalid file type.';}
					}
					echo "<script>location='bbm-groups.html';</script>";
				}
			}
		}
	}else{
		$err = "<span class='error'>$err</span>";
	}
}

if(isset($_GET['id'])){
	$rs = $commObj->getDataById('bbm_group',$groupId);
	$gi = $obj->getGroupInterest($groupId);
}
else{
	$gi['interest_id'] = null;
}
?>
<div class="boxStyle1">
   	<h2><?php echo $locale['group.add.new'];?></h2>
	<?php echo $err;?>
    <form name="frm" method="post" action="" enctype="multipart/form-data" class="frmStyle1">
        <p>
        	<label for="group_name" class="lbl"><?php echo $locale['group.name'];?>:</label>
            <input type="text" name="group_name" id="group_name" value="<?php echo $rs['group_name'];?>" class="textbox" />
        </p>
        <p>
        	<label for="country_id" class="lbl"><?php echo $locale['group.country'];?>:</label>
            <select name="country_id" id="country_id">
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php if($rs['country_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="group_detail"><?php echo $locale['group.about'];?>:</label>
            <textarea name="group_detail" id="group_detail" ><?php echo cleanString($rs['group_detail']);?></textarea>
        </p>
        <p>
            <h3><?php echo $locale['group.category'];?>:</h3>
            <ol>
            <?php foreach($interest as $key => $value){ ?>
                <p><input type="radio" name="interest[]" id="interest<?php echo $key;?>" value="<?php echo $key;?>" <?php if($gi['interest_id'] == $key){ echo "checked"; } ?> /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></p>
            <?php } ?>
            </ol>
        </p>
        <p>
			<?php 
                if(isset($_GET['id'])){ 
            ?>
                    <a class="button" href="index.php?action=edit-group-gallery&id=<?php echo $groupId;?>"><?php echo $locale['edit.group.photo'];?></a>
                    <a class="button right required" href="javaScript:rem(<?php echo $groupId;?>);"><?php echo $locale['btn.del.group'];?></a>
            <?php
                }else{
            ?>
            <h3><?php echo $locale['group.photo'];?></h3>
            <input type="file" name="Filedata" />
            <a href="faqs.html#faqs5" target="_blank">How to get my BBM Group Barcode image?</a>
            <?php } ?>
        </p>
        <p><input type="submit" value="<?php echo $locale['btn.save'];?>" class="button" /></p>
    </form>
</div>
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
<script language="javascript">
function rem(id){
	if(confirm("You are about to delete this group.")){
		window.location = "index.php?action=add-bbm-group&id=" + id + "&rem=" + id;
	}
}
</script>