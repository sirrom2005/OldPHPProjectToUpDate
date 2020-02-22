<?php
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/software.class.php");
	
	$obj = new software();
	if(empty($_GET['id'])){exit();}
	$rs = $obj->getSoftwareSubCategories($_GET['id']);
	
	if(!empty($rs))
	{
		foreach($rs as $row)
		{ 
			$str = explode("::", $row['program_category_class']);
			if(!empty($str[1])){$option .= "<option value='{$row['ceo_url_program_category_class']}'>{$str[1]}</option>";}
		}
		echo "<select name='subcategories'><option value=''>Any sub category</option>$option</select>";
	}
?>