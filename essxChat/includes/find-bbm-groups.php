<?php
include_once("classes/commonDB.class.php");
$commObj = new commonDB();
$lookingFor 	= $commObj->getHtmlListControlData('odb_looking_for','name','id',NULL,NULL);
$interest 		= $commObj->getHtmlListControlData('odb_interest','name','id','name',NULL);
$maritalStatus 	= $commObj->getHtmlListControlData('odb_marital_status','name','id',NULL,NULL);
$country 		= $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);
?>
<span style="float:right"><input type="button" value="Add Your BBM Group" onclick="window.location='add-bbm-group.html'" /></span>
<h2>Find bbm groups</h2>
<form name="findbbm" method="post" action="bbm-groups.html">
<table align="center" style="width:708px;">
    <tr>
        <td colspan="4" align="center">
            <select name="country_id" id="country_id">
                <option value="" >Find any country</option>
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>" ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <h3>Interest</h3>
            <ol>
            <?php foreach($interest as $key => $value){ ?>
                <li><input type="radio" name="interest" id="interest<?php echo $key;?>" value="<?php echo $key;?>" /> <label for="interest<?php echo $key;?>" class="nostyle"><?php echo $value;?></label></li>
            <?php } ?>
            </ol>
        </td>
    </tr>
    <tr><td colspan="4" align="center" ><input type="submit" value="Find groups" /></td></tr>
</table>    
</form>