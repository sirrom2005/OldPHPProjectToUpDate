<?php 
include_once("classes/commonDB.class.php");
$commObj = new commonDB();
$userId = $_SESSION['BBPINWORLD']['id'];

$lookingFor 	= $commObj->getHtmlListControlData('odb_looking_for','name','id',NULL,NULL);
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$maritalStatus 	= $commObj->getHtmlListControlData('odb_marital_status','name','id',NULL,NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
$err = "";

if($_POST)
{
	$rs = $_POST;
	$data['fname']	= cleanText($rs['fname']);
	$data['lname']	= cleanText($rs['lname']);
	$data['gender']	= $rs['gender'];
	$data['dob'] 	= cleanText($rs['dob']);
	$data['hide_age'] = $rs['hide_age'] = (isset($rs['hide_age']))? 1 : 0;
	$data['status'] = $rs['status'];
	$data['country_id'] = $rs['country_id'];
	$data['about_me'] = addslashes(cleanText($rs['about_me'])); 
	$data['gender_prefrence'] = $rs['gender_prefrence']; 
	$data['date_updated'] = date("Y-m-d H:i:s"); 
	###########################################	 
	$pin['account_id'] 	= $userId;
	$pin['bbmpin'] 		= $rs['bbmpin'];
	$pin['hidepin'] 	= $rs['hidepin']  = (isset($rs['hidepin']) )? 1 : 0;
	$valid  = true;
	
	if(empty($data['fname'])){
		$err .= "<li>First name is required.</li>";
		$valid  = false;
	}
	if(empty($data['dob'])){
		$err .= "<li>Date of birth is required.</li>";
		$valid  = false;
	}
	if(empty($data['about_me'])){
		$err .= "<li>About me is required.</li>";
		$valid  = false;
	}
	if(empty($pin['bbmpin'])){
		$err .= "<li>Your bbm pin is required.</li>";
		$valid  = false;
	}
	
	if($valid){
		if($commObj->updateRecord($data,'people',$userId)){
			if($commObj->deleteData('bbm_pin','account_id',$userId)){
				$commObj->insertRecord($pin,'bbm_pin');
				
				$rs['lookingFor'] = (isset($rs['lookingFor']))? $rs['lookingFor'] : array();
				if($commObj->deleteData('account_look_for','account_id',$userId)){
					$obj->insertUserLookingFor($rs['lookingFor'],$userId);
				}
				
				$rs['interest'] = (isset($rs['interest']))? $rs['interest'] : array();
				if($commObj->deleteData('account_interest','account_id',$userId)){
					$obj->insertUserInterest($rs['interest'],$userId);
				}
			}
		}
	}else{
		$err = "<span class='error'>$err</span>";
	}
}

$rs = $obj->getProfileInfo($userId);
$ph = $obj->getProfilePhotos($userId);
$userInterest 	= $obj->getUserInterestKeyArray($userId);
$userlookingFor = $obj->getUserLookForKeyArray($userId);
$proImg = $obj->getProfilePhotos($userId);
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold; border:solid 0px #c00;}
label.nostyle{width:auto;font-weight:normal;display:inline;}
.img250{border:solid 1px #b7c6ec;padding:3px;width:240px;}
</style>
<div class="largeProfile">
   	<h2>Update Profile</h2>
    <div class="gallery">
        <?php $img = ($proImg[0]['image_name'])? 'images/profile/'.$userId.'/250_'.$proImg[0]['image_name'] : 'images/profile/profile.png'; ?>
        <a href="edit-my-gallery.html"><img src="<?php echo $img;?>" alt="" title="edit my photo gallery" class="img250" /></a>
        <center><button onclick="location='edit-my-gallery.html'">Edit your photo gallery</button></center>
    </div>
    <div class="info">
    	<?php echo $err;?>
        <form name="frm" method="post" action="">
    	<table style="width:100%;">
        	<tr>
            	<td width="150"><label for="fname">First name:<font class="required">*</font></label></td>
                <td><input type="text" name="fname" id="fname" value="<?php echo $rs['fname'];?>" class="textbox" /></td>
            </tr>
            <tr>
            	<td><label for="lname">Last name:</label></td>
                <td><input type="text" name="lname" id="lname" value="<?php echo $rs['lname'];?>" class="textbox" /></td>
            </tr>
            <tr>
            	<td><label>Gender:</label></td>
                <td>
                	<input type="radio" name="gender" id="genderf" value="F" checked="checked" /> <label for="genderf" class="nostyle">female</label> 
                	<input type="radio" name="gender" id="genderm" value="M" <?php if($rs['gender']=='Male'){ echo "checked"; } ?> /> <label for="genderm" class="nostyle">male</label>
                </td>
            </tr>
            <tr>
            	<td><label for="dob">Date of birth:<font class="required">*</font></label></td>
                <td>
                	<input type="text" name="dob" id="dob" value="<?php echo $rs['dob'];?>" size="8" maxlength="10" class="dob" /> yyyy-mm-dd
                    <input type="checkbox" name="hide_age" id="hide_age" value="1" <?php if($rs['hide_age']){ echo "checked"; } ?> /> <label for="hide_age" class="nostyle">hide my age</label>
                </td>
            </tr>
            <tr>
            	<td><label for="status">Status:</label></td>
                <td>
                    <select name="status" id="status">
						<?php foreach($maritalStatus as $key => $value){ ?>
                        <option value="<?php echo $key;?>" <?php if($rs['status_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td><label for="bbpin">BB-PIN:<font class="required">*</font></label></td>
                <td>
                	<input type="text" name="bbmpin" id="bbmpin" value="<?php echo $rs['bbmpin'];?>" class="dob" maxlength="10" /> 
                	&nbsp;&nbsp;<input type="checkbox" name="hidepin" id="hidepin" value="1" <?php if($rs['hidepin']){ echo "checked"; } ?> /> <label for="hidepin" class="nostyle">hide my bbm-pin</label>
                </td>
            </tr>
            <tr>
            	<td><label for="status">Country:</label></td>
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
                	<h3>About Me:<font class="required">*</font></h3>
                	<textarea name="about_me" id="about_me" style="width:98%;" ><?php echo cleanString($rs['about_me']);?></textarea>
                </td>
            </tr>
            <tr>
            	<td valign="top"><label>Looking For:</label></td>
                <td>
					<?php foreach($lookingFor as $key => $value){ ?>
                        <input type="checkbox" name="lookingFor[]" id="lookingFor<?php echo $key;?>" value="<?php echo $key;?>"  <?php if(isset($userlookingFor[$key])){ echo "checked"; } ?> /> <label for="lookingFor<?php echo $key;?>" class="nostyle"><?php echo $value;?></label><br />
                    <?php } ?>
                </td>
            </tr>
            <tr>
            	<td><label>Gender Prefrence:</label></td>
                <td>
                    <input type="radio" name="gender_prefrence" id="genderpf" value="F" checked="checked" /> <label for="genderpf" class="nostyle">female</label>
                    <input type="radio" name="gender_prefrence" id="genderpm" value="M" <?php if($rs['gender_prefrence']=='Male'){ echo "checked"; } ?> /> <label for="genderpm" class="nostyle">male</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>Interest:</h3>
                    <ol>
					<?php foreach($interest as $key => $value){ ?>
                        <li><input type="checkbox" name="interest[]" id="interest<?php echo $key;?>" value="<?php echo $key;?>" <?php if(isset($userInterest[$key])){ echo "checked"; } ?> /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></li>
                    <?php } ?>
                    </ol>
                </td>
            </tr>
            <tr>
            	<td colspan="2" align="center"><input type="submit" value="Update" /></td>
            </tr>
        </table>
        </form>
    </div>
</div>