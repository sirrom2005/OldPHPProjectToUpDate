<?php
include_once("../classes/site.class.php");
$obj = new site();

$str = "";
$category_id = null;
if($_POST){
	$rs = $_POST;
	$valid = true;
	
	$data['title'] 		= trim($rs['title']); 
	$data['category_id']= $rs['category_id'];
	$data['event_date'] = $rs['year'].'-'.$rs['month'].'-'.$rs['day'];
	$data['start_date'] = $rs['syear'].'-'.$rs['smonth'].'-'.$rs['sday'];
	$data['end_date'] 	= $rs['eyear'].'-'.$rs['emonth'].'-'.$rs['eday'];
		
	if(empty($data['title'])){ $str .= "<li>Event title required.</li>"; $valid = false;}
	
	if(isset($_FILES['Filedata'])){						
		if($_FILES['Filedata']['tmp_name']){
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] .'/'. EVENTSPHOTO;
		//exit($targetPath.'---'.EVENTSPHOTO);	
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			$img = time().'.'.strtolower($fileParts['extension']);
			$targetFile = rtrim($targetPath,'/') . '/' . $img;
			
			if(in_array(strtolower($fileParts['extension']),$fileTypes)){
				move_uploaded_file($tempFile,$targetFile);		
				$size = getimagesize($targetPath.'/'.$img);
				imageResize($targetPath.'/', $img, 305,$size[1]/($size[0]/305));	
				chmod($targetPath.'305_'.$img,0755);	
				$data['image_name'] = $img;
				
				chmod($targetPath,0755);
				chmod($targetFile,0755);	
			}else{
				$str .= "<li>Invalid file type.</li>";
				$valid = false;
			}
		}
	}
	
	if($valid)
	{
		if(isset($_GET['id']) && !empty($_GET['id'])){	
			if($comObj->updateRecord($data,'event',$_GET['id'])){
				echo "<script> location = 'index.php?action=events';</script>";
			}
		}else{
			$data['date_added'] = date("Y-m-d H:i:s");
			if($comObj->insertRecord($data,'event')){
				echo "<script> location = 'index.php?action=events';</script>";
			}
		}
	}
	else
	{
		echo "<span class='error'>$str</span>";
	}
} 

$category = $obj->getEventCategory();

if(isset($_GET['id']) && !empty($_GET['id'])){	
	$rs = $comObj->getDataById('event', $_GET['id']);
}else{
	$rs=array('image_name'=>'', 'title'=>'', 'event_date' => '', 'start_date' => '', 'end_date' => '', 'category_id' => '');	
}
?>
<form method="post" name="ff" action="" enctype="multipart/form-data">
	<h2>Add Event Banner</h2>
    <p>
    	<?php if(empty($rs['image_name'])){ ?>
    	<label>Event Banner</label><input type="file" name="Filedata" id="Filedata" />
        <?php }else{ ?>
        <img src="../images/content/events/305_<?php echo $rs['image_name'];?>" border="1" />
        <?php } ?>
    </p>
    <p><label>Event name</label><input type="text" name="title" class="textbox" value="<?php echo cleanString($rs['title']);?>" /></p>
    <p><label for="category_id">Category <font style="color:#FF0000;">*</font></label>
        <select name="category_id">
            <?php foreach($category as $row){?>
            <option value="<?php echo $row['id'];?>" <?php echo ($row['id'] == $rs['category_id'])? "selected" : "" ;?>><?php echo $row['name'];?></option>
            <?php } ?>
        </select>
    </p>
    <p><label>Event date</label>
    	<select name="day">
        	<?php for($i=1;$i<=31;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('d', strtotime($rs['event_date']))==$i)? "selected"  : ""; ?> ><?php echo date('d',mktime(0,0,0,0,$i,0));?></option>
            <?php } ?>
        </select>
        <select name="month">
        	<?php for($i=1;$i<=12;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('m', strtotime($rs['event_date']))==$i)? "selected"  : ""; ?> ><?php echo date('M',mktime(0,0,0,$i+1,0,0));?></option>
            <?php }?>
        </select>
        <select name="year">
            <option value="2013" <?php echo (date('Y', strtotime($rs['event_date']))==2013)? "selected"  : ""; ?>>2013</option>
            <option value="2014" <?php echo (date('Y', strtotime($rs['event_date']))==2014)? "selected"  : ""; ?>>2014</option>
        </select>
    </p>
	<p>
    	<b style="color:#F00;">Publish Date</b><br />
    	<label>Start date</label>
    	<select name="sday">
        	<?php for($i=1;$i<=31;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('d', strtotime($rs['start_date']))==$i)? "selected"  : ""; ?> ><?php echo date('d',mktime(0,0,0,0,$i,0));?></option>
            <?php } ?>
        </select>
        <select name="smonth">
        	<?php for($i=1;$i<=12;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('m', strtotime($rs['start_date']))==$i)? "selected"  : ""; ?> ><?php echo date('M',mktime(0,0,0,$i+1,0,0));?></option>
            <?php }?>
        </select>
        <select name="syear">
            <option value="2013" <?php echo (date('Y', strtotime($rs['start_date']))==2013)? "selected"  : ""; ?>>2013</option>
            <option value="2014" <?php echo (date('Y', strtotime($rs['start_date']))==2014)? "selected"  : ""; ?>>2014</option>
        </select>
        <br />
        <label>End date</label>
    	<select name="eday">
        	<?php for($i=1;$i<=31;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('d', strtotime($rs['end_date']))==$i)? "selected"  : ""; ?> ><?php echo date('d',mktime(0,0,0,0,$i,0));?></option>
            <?php } ?>
        </select>
        <select name="emonth">
        	<?php for($i=1;$i<=12;$i++){?>
        	<option value="<?php echo $i;?>" <?php echo (date('m', strtotime($rs['end_date']))==$i)? "selected"  : ""; ?> ><?php echo date('M',mktime(0,0,0,$i+1,0,0));?></option>
            <?php }?>
        </select>
        <select name="eyear">
            <option value="2013" <?php echo (date('Y', strtotime($rs['end_date']))==2013)? "selected"  : ""; ?>>2013</option>
            <option value="2014" <?php echo (date('Y', strtotime($rs['end_date']))==2014)? "selected"  : ""; ?>>2014</option>
        </select>
    </p>
    <p align="center">
    	<input type="submit" id="btn" value="<?php echo isset($_GET['id'])? 'Update...' : 'Add...'?>" class="btn" />
        <?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
        <input type="button" id="btn" value="Delete this event..." class="btn" style="background-color:#F00; margin-left:20px;" onclick="delPost(<?php echo $rs['id']; ?>,'<?php echo base64_encode($rs['image_name']); ?>');" />
        <?php }?>
    </p>
    
</form>
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
        @imagejpeg($imgdest, $newfile, 85);
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

<script>
function delPost(id,f)
{
	if(confirm("You are about to delete this event")){
		window.location = "index.php?action=del-events&id=" + id + "&f=" + f;
	}
}
</script>