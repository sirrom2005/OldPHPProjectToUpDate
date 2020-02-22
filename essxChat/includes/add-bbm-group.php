<?php 
include_once("classes/commonDB.class.php");
$commObj = new commonDB();
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
$err = "";
$rs = array('group_name' => '', 'country_id' => '', 'group_detail' => '', '' => '');

if($_POST){
	$rs = $_POST;
	$data['group_name']	  = cleanText($rs['group_name']);
	$data['group_detail'] = addslashes(cleanText($rs['group_detail']));
	$data['country_id']	  = $rs['country_id'];
	$valid  = true;
	
	if(empty($data['group_name'])){
		$err .= "<li>group name is required.</li>";
		$valid  = false;
	}
	if(empty($data['group_detail'])){
		$err .= "<li>group detail is required.</li>";
		$valid  = false;
	}
	
	if($valid){
		$data['account_id']   = $_SESSION['BBPINWORLD']['id'];
		$data['date_added']   = date("Y-m-d H:i:s");
		$data['date_updated'] = date("Y-m-d H:i:s");  
		if($commObj->insertRecord($data,'bbm_group')){
			$groupId = mysql_insert_id();
			$rs['interest'] = (isset($rs['interest']))? $rs['interest'] : array();
			if($obj->insertGroupInterest($rs['interest'],$groupId)){
				if($_FILES){
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
						chmod($targetFile,0755);
						
						$gdata['group_id'] = $groupId;
						$gdata['image_name'] = $img;
						$gdata['date_added'] = date("Y-m-d H:i:s");
						$commObj->insertRecord($gdata,'group_gallery'); 
						
						$size = getimagesize($targetPath.'/'.$img);
						imageResize($targetPath.'/', $img, 250, $size[1]/($size[0]/250));
						imageResize($targetPath.'/', $img, 80,  $size[1]/($size[0]/80) );		
					}else{ echo 'Invalid file type.';}
				}
				header("location: bbm-groups.html");
			}
		}
	}else{
		$err = "<span class='error'>$err</span>";
	}
}
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold; border:solid 0px #c00;}
label.nostyle{width:auto;font-weight:normal;display:inline;}
.img250{width:250px;border:solid 1px #FFFFFF;}
</style>
<div class="largeProfile">
   	<h2>New BBM Group</h2>
    <div class="info">
    	<?php echo $err;?>
        <form name="frm" method="post" action="" enctype="multipart/form-data">
    	<table style="width:100%;" >
        	<tr>
            	<td width="150"><label for="group_name">Group Name:</label></td>
                <td><input type="text" name="group_name" id="group_name" value="<?php echo $rs['group_name'];?>" class="textbox" /></td>
            </tr>
            <tr>
            	<td><label for="status">Country of origin:</label></td>
                <td>
                    <select name="country_id" id="country_id">
						<?php foreach($country as $key => $value){ ?>
                        <option value="<?php echo $key;?>" <?php if($rs['country_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                	<h3>Group Description:</h3>
                	<textarea name="group_detail" id="group_detail" style="width:98%;" ><?php echo cleanString($rs['group_detail']);?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>Group Category:</h3>
                    <ol>
					<?php foreach($interest as $key => $value){ ?>
                        <li><input type="radio" name="interest[]" id="interest<?php echo $key;?>" value="<?php echo $key;?>" <?php if(isset($userInterest[$key])){ echo "checked"; } ?> /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></li>
                    <?php } ?>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>Group Image or BBM group barcode image</h3>
                    <input type="file" name="Filedata" />
                </td>
            </tr>
            <tr>
            	<td colspan="2" align="center"><input type="submit" value="Update" /></td>
            </tr>
        </table>
        </form>
    </div>
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
	@chmod($dir.$newfile,0755);
    return $newfile;
}
?>