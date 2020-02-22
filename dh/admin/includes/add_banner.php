<?php
	include_once("../classes/user.class.php");
	include_once("../classes/software.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$id			= $_GET['id'];
	$userObj 	= new user();
	$obj 		= new software();
	$tableName  = "od_banner_ads";
		
	if($_POST)
	{
		$rs 			= $_POST;
		$advertiser		= trim($rs['advertiser']);
		$banner_code	= trim($rs['banner_code']);	
		$_POST['enable']= (empty($rs['enable']))? "0" : "1";
		
		if(empty($advertiser) ){ $err  = "<div class='err'>Advertiser name is required.</div>"; unset($_POST);}
		if(empty($banner_code)){ $err .= "<div class='err'>Banner code is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		if(empty($id))
		{ 
			$_POST['date_added'] = date("Y-m-d"); 
			$comObj->insertRecord( $_POST, $tableName );
			$comObj->logAdminActions("ADD ADS BANNER FOR ADVERTISER [$advertiser]");
		}
		else
		{ 
			$comObj->updateRecord( $_POST, $tableName, $id ); 
			$comObj->logAdminActions("UPDATE ADS BANNER FOR ADVERTISER [$advertiser]");
		}
		echo "<script> location='index.php?action=list_banners'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_banners' />";
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById( $tableName, $id );
	}
	
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
	
	$adsType = $comObj->getData( "odb_ads_type", NULL, "id", "ASC" );
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<?php echo $rs['banner_code'];?>
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> News</th></tr>
  <tr>
    <th>Banner Size</th>
    <td>
		<select name="banner_type_id">
		<?php foreach($adsType as $row){?> 
			<option value="<?php echo $row[id];?>" <?php echo ($rs['banner_type_id']==$row[id])? "selected" : "";?> ><?php echo $row['size'];?> - <?php echo (empty($row['rotating']))? "None Rotating Banner" : "Rotating Banner";?> </option>
		<?php } ?> 
		</select>
	</td>
  </tr>
  <tr>
    <th>Advertiser<font class="required">*</font></th> 
    <td><input type="text" name="advertiser" size="50" value="<?php echo cleanString($rs['advertiser']);?>" /></td>
  </tr>
  <tr>
    <th>Website</th> 
    <td><input type="text" name="website" size="50" value="<?php echo cleanString($rs['website']);?>" /></td>
  </tr>
  <tr>
    <th>Email</th> 
    <td><input type="text" name="email" size="50" value="<?php echo cleanString($rs['email']);?>" /></td>
  </tr>
  <tr>
    <th>Paypal Email</th> 
    <td><input type="text" name="paypal_email" size="50" value="<?php echo cleanString($rs['paypal_email']);?>" /></td>
  </tr>
  <tr>
    <th>Banner Code<font class="required">*</font></th>
    <td><textarea name="banner_code"><?php echo htmlentities(stripcslashes($rs['banner_code']));?></textarea></td>
  </tr>
  <tr>
    <th>Enable</th>
    <td><input type="checkbox" name="enable" value="1" <?php echo empty($rs['enable'])? "" : "checked";?> /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?php echo $btnTitle;?>..." /></td>
  </tr>
</table>
</form>