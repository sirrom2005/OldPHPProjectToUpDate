<?php 
include_once(DOCROOT."classes/commonDB.class.php");
$commObj = new commonDB();
$userId = $_SESSION['BBPINWORLD']['id'];

$lookingFor 	= $commObj->getHtmlListControlData('odb_looking_for','name','id','name',NULL);
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$maritalStatus 	= $commObj->getHtmlListControlData('odb_marital_status','name','id','name',NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
$jobCategory    = $commObj->getHtmlListControlData('job_category','name','id','name',NULL);
$educationLevel = $commObj->getHtmlListControlData('education_level','name','id','id',NULL);
$err 	= "";
$fnameErrTxt = $dobErrTxt = $bioErrTxt = $pinErrTxt = $emailErrTxt = '';
$bbCnt  = NULL;
if($_POST)
{
	$rs = $_POST;
	$data['fname']	= cleanText($rs['fname']);
	$data['lname']	= cleanText($rs['lname']);
	$data['gender']	= (isset($rs['gender']))? $rs['gender'] : 'F';
	$data['dob'] 	= cleanText($rs['dob']);
	$data['email']	= $rs['email'];
	$data['hide_age'] 	= $rs['hide_age'] = (isset($rs['hide_age']))? 1 : 0;
	$data['status'] 	= (isset($rs['status_id']))? $rs['status_id'] : 1;
	$data['country_id'] = (isset($rs['country_id']))? $rs['country_id'] : 1;
	$data['country_zone_id'] 	= (isset($rs['country_zone_id'])   )? $rs['country_zone_id']    : 0;
	$data['education_level_id'] = (isset($rs['education_level_id']))? $rs['education_level_id'] : 0;
	$data['job_category_id'] 	= (isset($rs['job_category_id'])   )? $rs['job_category_id']    : 0;  
	$data['about_me'] 			= cleanText($rs['about_me']); 
	$data['gender_prefrence'] 	= (isset($rs['gender_prefrence'])  )? $rs['gender_prefrence']  : 'B'; 
	$data['date_updated'] 	  	= date("Y-m-d H:i:s"); 
	###########################################	 
	$pin['account_id'] 	= $userId;
	$pin['bbmpin'] 		= cleanText(str_replace('pin:','',$rs['bbmpin']));
	$pin['hidepin'] 	= $rs['hidepin'] = (isset($rs['hidepin']) )? 1 : 0;
	$valid  = true;
	
	if(empty($data['fname'])){
		$err .= "<li>Your first name is required.</li>";
		$fnameErrTxt = 'controlErr';
		$valid  = false;
	}
	if(!isValidEmail($data['email'])){
		$err .= "<li>invalid email address.</li>";
		$emailErrTxt = 'controlErr';
		$valid  = false;
	}
	if(empty($data['dob'])){
		$err .= "<li>Your date of birth is required.</li>";
		$dobErrTxt = 'controlErr';
		$valid  = false;
	}else{
		$exd = explode('-',$data['dob']);
		$exd[1] = (isset($exd[1]))? $exd[1] : 0;
		$exd[2] = (isset($exd[2]))? $exd[2] : 0;
		$age = (int)date('Y') - (int)$exd[0];
		if((int)$exd[2]<1 || (int)$exd[2]>31 || (int)$exd[1]<1 || (int)$exd[1]>12 ){
			$err .= "<li>Invalid date of birth: yyyy-mm-dd.</li>";
			$dobErrTxt = 'controlErr';
			$valid  = false;
		}elseif($age<13 || $age>100){
			$err .= "<li>Sorry this age group is not allowed.</li>";
			$dobErrTxt = 'controlErr';
			$valid  = false;
		}
	}
	
	$rs['lookingFor'] = (isset($rs['lookingFor']))? $rs['lookingFor'] : array();
	$rs['interest']   = (isset($rs['interest']))? $rs['interest'] : array();
	if(empty($data['about_me'])){
		$err .= "<li>Please add small bio about yourself.</li>";
		$bioErrTxt = 'controlErr';
		$valid  = false;
	}

	if(!isValidPin($pin['bbmpin'])){
		$err .= "<li>Your BBM-PIN is not valid.</li>";
		$pinErrTxt = 'controlErr';
		$valid  = false;
	}else{
		$bbCnt = $obj->bbmPinLookUp($pin['bbmpin']);
		$bbCnt = $bbCnt['cnt'];
	}
	if($bbCnt){
		$err .= "<li>This BBM-PIN is already in use by another user, if this is not a mistake please report this to the <a href='contact-us.html'>admin</a>.</li>";
		$pinErrTxt = 'controlErr';
		$valid  = false;
	}
	
	if(empty($rs['lookingFor'])){
		$err .= "<li>Please select at least one option from the \"Looking For\" section.</li>";
		$valid  = false;
	}
	if(empty($rs['interest'])){
		$err .= "<li>Please select at least one option from the \"Interest\" section.</li>";
		$valid  = false;
	}
	
	if($valid){
		$rt = $obj->emailProfileLookUp($data['email']);
		if(!$rt['cnt']){
			if($commObj->updateRecord($data,'people',$userId)){
				$chkey = base64_decode($rs['chkey']);
				if($chkey != $pin['bbmpin']){
					$commObj->deleteData('bbm_pin','account_id',$userId);
					$commObj->insertRecord($pin,'bbm_pin');
				}
				else
				{
					$pinkey = base64_decode($rs['pinkey']);
					$pinver = base64_decode($rs['pinver']);
					$pinhid['hidepin'] = $pin['hidepin'];
					$pinhid['pinverified'] = $pinver;	
					$commObj->updateRecord($pinhid,'bbm_pin',$pinkey);
				}
					
				if($commObj->deleteData('account_look_for','account_id',$userId)){
					$obj->insertUserLookingFor($rs['lookingFor'],$userId);
				}
				
				if($commObj->deleteData('account_interest','account_id',$userId)){
					$obj->insertUserInterest($rs['interest'],$userId);
				}
				$_SESSION['BBPINWORLD']['bbm'] = 1;
				@unlink(DOCROOT."cache/en/profile_{$userId}.html");
				@unlink(DOCROOT."cache/es/profile_{$userId}.html");
				@unlink(DOCROOT."cache/fr/profile_{$userId}.html");
				@unlink(DOCROOT."m/profile_{$userId}.html");
				$_SESSION['BBPINWORLD']['complete'] = 1;
				$err = "<span class='good'>Profile updated...</span>";
				header("location: profile.html");
			}
		}else{ $err .= "<span class='error'><li>email already in system.</li></span>"; }
		postInit();
	}else{
		$err = "<span class='error'>$err</span>";
		#########################################
		postInit();
	}
}else{
	$rs = $obj->getProfileInfo($userId);
}

$ph = $obj->getProfilePhotos($userId);
$userInterest 	= $obj->getUserInterestKeyArray($userId);
$userlookingFor = $obj->getUserLookForKeyArray($userId);

if(isset($_POST['country_id'])){$rs['country_id'] = $_POST['country_id'];}
function postInit(){
	global $rs;
	$rs['bbmid']  = base64_decode($rs['pinkey']);
	$rs['pinverified'] = base64_decode($rs['pinver']);
	$rs['gender'] = ($rs['gender']=='M')? 'Male' : 'Female';
}
?>
<script type="text/javascript" src="<?php echo DOMAIN;?>js/jquery.js"></script>
<div class="boxStyle1">
	<h2><?php echo $locale['pro.update'];?></h2>
    <?php echo $err;?>
    <form name="frm" method="post" action="" class="frmStyle1" >
        <p>
            <label for="fname"><?php echo $locale['fname'];?>:<font class="required">*</font></label>
            <input type="text" name="fname" id="fname" value="<?php echo $rs['fname'];?>" class="textbox <?php echo $fnameErrTxt?>" />
        </p>
        <p>
        	<label for="lname"><?php echo $locale['lname'];?>:</label>
          	<input type="text" name="lname" id="lname" value="<?php echo $rs['lname'];?>" class="textbox" />
        </p>
        <p>
            <label><?php echo $locale['gender'];?>:</label>
            <select name="gender">
                <option value="F"><?php echo $locale['female.gender.edit'];?></option>
                <option value="M" <?php if($rs['gender']=='Male'){ echo "selected"; } ?> ><?php echo $locale['male.gender.edit'];?></option>
            </select>
        </p>
        <p>
            <label><?php echo $locale['pro.looking'];?>:</label>
            <select name="gender_prefrence">              	
                <option value="F" <?php if($rs['gender_prefrence']=='F'){ echo "selected"; } ?> ><?php echo $locale['female.gender.edit'];?></option>
                <option value="M" <?php if($rs['gender_prefrence']=='M'){ echo "selected"; } ?> ><?php echo $locale['male.gender.edit'];?></option>
                <option value="B" <?php if($rs['gender_prefrence']=='B'){ echo "selected"; } ?> >Both</option>
            </select>
        </p>
        <p>
        	<label for="dob"><?php echo $locale['pro.dob'];?><font class="required">*</font>:</label>
            <input type="text" name="dob" id="dob" value="<?php echo (!empty($rs['dob']))? $rs['dob']: '';?>" size="8" maxlength="10" class="dob textbox <?php echo $dobErrTxt?>" /> yyyy-mm-dd |
            <label for="hide_age" class="nostyle">hide my age</label><input type="checkbox" name="hide_age" id="hide_age" value="1" <?php if($rs['hide_age']){ echo "checked"; } ?> />
        </p>
        <p>
        	<label for="status_id"><?php echo $locale['pro.status'];?>:</label>
        	<select name="status_id" id="status_id">
				<?php foreach($maritalStatus as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php if($rs['status_id']==$key){ echo "selected";} ?> ><?php echo $locale['status.'.strtolower($value)];?></option>
                <?php } ?>
            </select>
        <p>
        	<label for="bbpin">BB-PIN:<font class="required">*</font></label>
        	<input type="text" name="bbmpin" id="bbmpin" value="<?php echo $rs['bbmpin'];?>" class="dob textbox <?php echo $pinErrTxt?>" maxlength="14" /> 
           	<label for="hidepin" class="nostyle">hide my bbm-pin</label><input type="checkbox" name="hidepin" id="hidepin" value="1" <?php if($rs['hidepin']){ echo "checked"; } ?> />
        </p>
        <p>
        	<label for="status"><?php echo $locale['pro.country'];?>:</label>
            <select name="country_id" id="country_id">
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php if($rs['country_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </p>
        <p>
        	<label for="status">State:</label>
            <select name="country_zone_id" id="country_zone_id">
            </select>
        </p>
        <p>
            <label for="about_me"><?php echo $locale['pro.about'];?>:</label>
            <textarea name="about_me" id="about_me" class="<?php echo $bioErrTxt?>" ><?php echo cleanHTML($rs['about_me']);?></textarea>
        </p>
        <p>
        	<label style="display:block;"><?php echo $locale['pro.looking'];?>:</label>
			<?php foreach($lookingFor as $key => $value){ ?>
                <input type="checkbox" name="lookingFor[]" id="lookingFor<?php echo $key;?>" value="<?php echo $key;?>"  <?php if(isset($userlookingFor[$key])){ echo "checked"; } ?> /> <label for="lookingFor<?php echo $key;?>" class="nostyle"><?php echo $value;?></label><br />
            <?php } ?>
        </p>
        <p>
            <label style="display:block;"><?php echo $locale['pro.interest'];?>:</label>
            <?php foreach($interest as $key => $value){ ?>
                <input type="checkbox" name="interest[]" id="interest<?php echo $key;?>" value="<?php echo $key;?>" <?php if(isset($userInterest[$key])){ echo "checked"; } ?> /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></br>
            <?php } ?>
        </p>
        <p>
        	<label><?php echo $locale['pro.education'];?>:</label>
        	<select name="education_level_id" id="education_level_id">
                <option value=""> --- </option>
                <?php foreach($educationLevel as $key => $value){ ?>
                    <option value="<?php echo $key;?>" <?php if($rs['education_level_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                <?php } ?>
            </select>
 		</p>
        <p>
        	<label><?php echo $locale['pro.employment'];?>:</label>
        	<select name="job_category_id" id="job_category_id">
                <option value="">     ---   </option>
                <?php foreach($jobCategory as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php if($rs['job_category_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                <?php } ?>
            </select>
		</p>
       	<p>
        	<label for="lname">Email:<font class="required">*</font></label></label>
            <input type="text" name="email" id="email" value="<?php echo $rs['email'];?>" class="textbox <?php echo $emailErrTxt?>" />
        </p>
        <p><input type="submit" value="<?php echo $locale['btn.save'];?>" class="button" /></p>
        <input type="hidden" name="chkey" id="chkey" value="<?php echo base64_encode($rs['bbmpin']);?>" /> 
        <input type="hidden" name="pinkey" id="pinkey" value="<?php echo base64_encode($rs['bbmid']);?>" /> 
        <input type="hidden" name="pinver" id="pinver" value="<?php echo base64_encode($rs['pinverified']);?>" /> 
    </form>
</div>
<script>

$('#country_id').bind('change', function(){
	loadCountryZone($('#country_id').val());
});

function loadCountryZone(id){
 	$.get("<?php echo DOMAIN;?>includes/ajx_country_zone.php",{id:id,z:<?php echo (empty($rs['country_zone_id']))? 0 : $rs['country_zone_id'];?>},
		function(data){$('#country_zone_id').html(data);}
	);
}
loadCountryZone(<?php echo $rs['country_id'];?>);
</script>