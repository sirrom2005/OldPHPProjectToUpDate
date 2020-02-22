<?php 
class site extends mySqlDB
{	
	function site(){ parent::mySqlDB(); }
	
	function emailLookUp($email)
	{				
		$sql = "SELECT count(email) as cnt FROM people WHERE email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function passwordReset($pass,$email)
	{				
		$sql = "UPDATE people SET `password` = md5('$pass') WHERE email = '$email'";
		$rt = parent::executeQuery($sql, false);
		return mysql_affected_rows();
	}
	
	function createNewAccount($rs)
	{				
		$sql = "INSERT INTO people (fname,lname,email,`password`,country_id,date_added,date_updated) 
							VALUES (\"{$rs['fname']}\",\"{$rs['lname']}\",\"{$rs['email']}\",MD5(\"{$rs['pass']}\"),{$rs['country_id']},NOW(),NOW())";
		return parent::executeNoneQuery($sql);
	}
	
	function getUserList($data=array())
	{			
		$query = $innerQuery = "";
		$query .= (!empty($data['status'])    )? 'AND ms.id = ' . $data['status'] .' ' : '';
		$query .= (!empty($data['country_id']))? 'AND p.country_id = ' . $data['country_id'] . ' ' : '';
		if(!empty($data['lookingFor'])){
			$query .= 'AND lf.look_for_id = ' . $data['lookingFor'] . ' ';
			$innerQuery .= 'LEFT JOIN account_look_for lf ON lf.account_id = p.id ';
		}
		if(!empty($data['interest'])){
			$query .= 'AND ai.interest_id = ' . $data['interest'] . ' ';
			$innerQuery .= 'LEFT JOIN account_interest ai ON ai.account_id = p.id ';
		}
  
		$sql = "SELECT p.id 
				,p.fname
				,p.lname
				,if(p.gender='M','Male','Female') AS gender
				,p.dob,p.hide_age
				,ms.name AS `status`,
				(SELECT image_name FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC LIMIT 1) as proImg
				,c.name AS country
				,c.iso_code_2 AS flag
				,pin.pinverified
				FROM people p 
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id 
				$innerQuery
				WHERE 0=0 $query ORDER BY p.date_updated DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getGroupList($data=array())
	{			
		$query = $innerQuery = "";
		$query .= (!empty($data['country_id']))? 'AND p.country_id = ' . $data['country_id'] . ' ' : '';
		$query .= (!empty($data['interest']))? 'AND gi.interest_id = ' . $data['interest'] . ' ' : '';
  
		$sql = "SELECT p.id 
				,p.group_name
				,p.group_detail
				,(SELECT image_name FROM group_gallery WHERE group_id = p.id ORDER BY profile_img DESC LIMIT 1) as proImg
				,i.name AS category
				,c.name AS country
				,c.iso_code_2 AS flag
				FROM bbm_group p 
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN group_interest gi ON gi.group_id = p.id
				LEFT JOIN odb_interest i ON i.id = gi.interest_id
				WHERE 0=0 $query";
		return parent::executeQuery($sql, true);
	}
	
	function getProfileInfo($id)
	{				
		$sql = "SELECT p.fname,p.lname,p.email,if(p.gender='M','Male','Female') AS gender,if(p.gender_prefrence='M','Male','Female') AS gender_prefrence,p.dob,p.hide_age,c.country_id,c.name AS country,c.iso_code_2 AS flag,ms.id AS status_id,ms.name AS `status`,p.about_me,pin.bbmpin,pin.hidepin,pin.pinverified 
				FROM people p 
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				WHERE p.id = '$id' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function getGroupInfo($id)
	{				
		$sql = "SELECT g.id 
				,g.group_name
				,g.group_detail
				,(SELECT image_name FROM group_gallery WHERE group_id = g.id ORDER BY profile_img DESC LIMIT 1) as proImg
				,i.name AS category
				,c.name AS country
				,c.iso_code_2 AS flag
				,p.id AS groupUser
				,p.email
				FROM bbm_group g 
				INNER JOIN people p ON p.id = g.account_id
				INNER JOIN odb_country c ON c.country_id = g.country_id
				LEFT JOIN group_interest gi ON gi.group_id = g.id
				LEFT JOIN odb_interest i ON i.id = gi.interest_id
				WHERE g.id = '$id' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function getProfilePhotos($id)
	{				
		$sql = "SELECT * FROM account_gallery WHERE account_id = '$id' ORDER BY profile_img DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getGroupPhotos($id)
	{				
		$sql = "SELECT * FROM group_gallery WHERE group_id = '$id' ORDER BY profile_img DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getUserLookFor($id)
	{				
		$sql = "SELECT lf.id,lf.name FROM account_look_for alf
				INNER JOIN odb_looking_for lf ON lf.id = alf.look_for_id
				WHERE account_id = '$id'";
		return parent::executeQuery($sql, true);
	}
	
	function getUserInterest($id)
	{				
		$sql = "SELECT a.id,a.name FROM account_interest ai
				INNER JOIN odb_interest a ON a.id = ai.interest_id
				WHERE account_id = '$id' ORDER BY a.name";
		return parent::executeQuery($sql, true);
	}
	
	function getUserLookForKeyArray($id)
	{				
		$sql = "SELECT lf.id FROM account_look_for alf
				INNER JOIN odb_looking_for lf ON lf.id = alf.look_for_id
				WHERE account_id = '$id'";
				
		$rs  = parent::executeQuery($sql, true);
		$data = array();
		if($rs)
		{
			foreach( $rs as $row )
			{
				$data[$row['id']] = $id;
			}
			return $data;
		}
		return false;
	}
	
	
	function getUserInterestKeyArray($id)
	{				
		$sql = "SELECT a.id FROM account_interest ai
				INNER JOIN odb_interest a ON a.id = ai.interest_id
				WHERE account_id = '$id' ORDER BY a.name";
				
		$rs  = parent::executeQuery($sql, true);
		$data = array();
		if($rs)
		{
			foreach( $rs as $row )
			{
				$data[$row['id']] = $id;
			}
			return $data;
		}
		return false;
	}
	
	function insertUserInterest($interest,$userId)
	{
		if(empty($interest)){return false;}
		$str = "";
		if(is_array($interest)){
			foreach($interest as $key => $value){
				$str .= "('$value',$userId),";
			}
		}
		else{
			$str .= "('$interest',$userId),";
		}
		
		$str = str_replace(',ENDZ','', $str.'ENDZ');
		$sql = "INSERT INTO account_interest (interest_id,account_id) VALUES $str";
		return parent::executeNoneQuery($sql);
	}
	
	function insertUserLookingFor($lookingFor,$userId)
	{
		if(empty($lookingFor)){return false;}
		$str = "";
		if(is_array($lookingFor)){
			foreach($lookingFor as $key => $value){
				$str .= "('$value',$userId),";
			}
		}
		else{
			$str .= "('$lookingFor',$userId),";
		}
		
		$str = str_replace(',ENDZ','', $str.'ENDZ');
		$sql = "INSERT INTO account_look_for (look_for_id,account_id) VALUES $str";
		return parent::executeNoneQuery($sql);
	}
	
	function insertGroupInterest($interest,$groupId)
	{
		if(empty($interest)){return false;}
		$str = "";
		if(is_array($interest)){
			foreach($interest as $key => $value){
				$str .= "('$value',$groupId),";
			}
		}
		else{
			$str .= "('$interest',$groupId),";
		}
		
		$str = str_replace(',ENDZ','', $str.'ENDZ');
		$sql = "INSERT INTO group_interest (interest_id,group_id) VALUES $str";
		return parent::executeNoneQuery($sql);
	}
	
	function userLogin($user,$pass)
	{			
		/*if(isValidEmail($user)){
		}else{
		}*/			
		$sql = "SELECT p.id,p.fname,p.email FROM people p 
				WHERE p.email = '$user' AND p.password = MD5('$pass') LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function insertPinRequest($data)
	{				
		$sql = "INSERT INTO account_request (account_id,user_id,date_added) VALUES ({$data['account_id']},{$data['user_id']},NOW())";
		$dbResult = mysql_query($sql) ;
		
		if($dbResult){
			return true;
		}
		else{
			return false;
		}
	}
	
	function insertGroupRequest($data)
	{				
		$sql = "INSERT INTO group_request (group_Id,account_id,date_added) VALUES ({$data['group_Id']},{$data['account_id']},NOW())";
		$dbResult = mysql_query($sql) ;
		
		if($dbResult){
			return true;
		}
		else{
			return false;
		}
	}
	
	function updatePassword($old,$new)
	{
		$sql = "UPDATE people a SET a.password = '".md5($new)."' WHERE a.password = '".md5($old)."' AND a.id = " . $_SESSION['BBPINWORLD']['id'];
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
	
	function deleteImage($img)
	{
		$sql = "DELETE from account_gallery WHERE image_name = '$img' AND account_id = " . $_SESSION['BBPINWORLD']['id'];
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
}
?>