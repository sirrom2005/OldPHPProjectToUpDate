<?php
include_once(DOCROOT."classes/commonDB.class.php");
$commObj = new commonDB();
$lookingFor 	= $commObj->getHtmlListControlData('odb_looking_for','name','id',NULL,NULL);
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$maritalStatus 	= $commObj->getHtmlListControlData('odb_marital_status','name','id',NULL,NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
?>
<div class="boxStyle1">
    <h2><?php echo $locale['find.group'];?></h2>
    <form name="findbbm" class="frmStyle1" method="post" action="bbm-chat-groups.html">
       <p>
       		<label for="country_id"><?php echo $locale['pro.country'];?></label>
            <select name="country_id" id="country_id">
                <option value="" >Find any country</option>
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>" ><?php echo $value;?></option>
                <?php } ?>
            </select>
       </p>
       <p>
       		<h3>Group Category</h3>
            <ol>
            <?php foreach($interest as $key => $value){ ?>
                <li><input type="radio" name="interest" id="interest<?php echo $key;?>" value="<?php echo $key;?>" /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></li>
            <?php } ?>
            </ol>
		</p>
		<p><input type="submit" value="<?php echo $locale['btn.find.groups'];?>" class="button" /></p>  
    </form>
</div>