<?php
include_once(DOCROOT."classes/commonDB.class.php");
$commObj = new commonDB();
$lookingFor 	= $commObj->getHtmlListControlData('odb_looking_for','name','id',NULL,NULL);
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$maritalStatus 	= $commObj->getHtmlListControlData('odb_marital_status','name','id',NULL,NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
?>
<div class="boxStyle1">
    <h2><?php echo $locale['find.pins'];?></h2>
    <form name="findbbm" method="post" action="index.php?action=search" class="frmStyle1" >	
        <p>
            <label class="lbl"><?php echo $locale['pro.looking'];?></label>
            <select name="gender" id="gender">
                <option value="" ><?php echo $locale['any'];?></option>
                <option value="f" ><?php echo $locale['female.gender'];?></option>
                <option value="m" ><?php echo $locale['male.gender'];?></option>
            </select>
        </p>
        <p>
            <label class="lbl"><?php echo $locale['pro.status'];?></label>
            <select name="status" id="status">
                <option value="" ><?php echo $locale['any'];?></option>
                <?php foreach($maritalStatus as $key => $value){ ?>
                <option value="<?php echo $key;?>" ><?php echo $locale['status.'.strtolower($value)];?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label class="lbl"><?php echo $locale['pro.looking'];?></label>
            <select name="lookingFor" id="lookingFor">
                <option value="" ><?php echo $locale['any'];?></option>
                <?php foreach($lookingFor as $key => $value){ ?>
                <option value="<?php echo $key;?>" ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </p>
        <p>
        	<label class="lbl"><?php echo $locale['pro.country'];?></label>
            <select name="country_id" id="country_id">
                <option value="" >Any country</option>
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>" ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <h3>Interest</h3>
            <ol>
            <?php foreach($interest as $key => $value){ ?>
                <li><input type="radio" name="interest" id="interest<?php echo $key;?>" value="<?php echo $key;?>" /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></li>
            <?php } ?>
            </ol>
        </p>
        <p><input type="submit" value="<?php echo $locale['btn.find.user'];?>" class="button" /></p>
    </form>
</div>