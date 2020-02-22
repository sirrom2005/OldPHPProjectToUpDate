<?php 
class site extends mySqlDB
{	
	function site(){ parent::mySqlDB(); }
	
	function emailLookUp($email)
	{				
		$sql = "SELECT count(email) as cnt FROM people WHERE email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function bbmPinLookUp($pin)
	{				
		$sql = "SELECT count(bbmpin) as cnt FROM bbm_pin WHERE bbmpin = '$pin' AND account_id != '{$_SESSION['BBPINWORLD']['id']}' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function bbmPinRegLookUp($pin)
	{				
		$sql = "SELECT count(bbmpin) as cnt FROM bbm_pin WHERE bbmpin = '$pin' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function emailProfileLookUp($email)
	{				
		$sql = "SELECT count(email) as cnt FROM people WHERE email = '$email' AND id != '{$_SESSION['BBPINWORLD']['id']}' LIMIT 1";
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
		$newUserId = NULL;
		$bio = (empty($rs['about_me']))? "" : $rs['about_me'];
		$sql = "INSERT INTO people (fname,lname,email,`password`,`status`,about_me,country_id,fb_id,date_added,date_updated) 
							VALUES (\"{$rs['fname']}\",\"{$rs['lname']}\",\"{$rs['email']}\",MD5('{$rs['pass']}'),1,\"$bio\",'{$rs['country_id']}','{$rs['fb_id']}',NOW(),NOW())";				
		if(parent::executeNoneQuery($sql)){
			$newUserId = mysql_insert_id();	
			$sql = "INSERT INTO profile_comment (sender_id,profile_id,`comment`,date_added) 
					VALUES (5,$newUserId,\"<p>Welcome {$rs['fname']} to <a href='http://www.jusbbmpin.com' title='jusbbmpins official website'>jusbbmpins.com</a>.<br>
										   	Find bbm pins and make new friends world wide,<br>
											Please remember to invite your other BlackBerry friends and like our <a href='http://www.facebook.com/jusbbmpins' title='like our facebook page.com official website'>facebook page</a>.</p></p>\",NOW())";
			$folder = $_SERVER['DOCUMENT_ROOT'] . PORFILEPHOTO . $newUserId.'/';
			if(!is_dir($folder)){mkdir($folder,0755);}
			if(parent::executeNoneQuery($sql)){
				$sql = "INSERT INTO account_last_login (user_id,login_date) VALUES ($newUserId,NOW())";
				parent::executeNoneQuery($sql);
				return $newUserId;
			}
		}
		return false;
	}
	
	function getUserList($data=array())
	{
		$query = $innerQuery = "";
		$query .= (!empty($data['status'])    )? 'AND ms.id = ' . $data['status'] .' ' : '';
		$query .= (!empty($data['country_id']))? 'AND p.country_id = ' . $data['country_id'] . ' ' : '';
		$query .= (!empty($data['cz'])        )? 'AND p.country_zone_id = ' . $data['cz'] . ' ' : '';
		$query .= (!empty($data['edu'])       )? 'AND p.education_level_id =\''.$data['edu'].'\'' : '';
		$query .= (!empty($data['job'])       )? 'AND p.job_category_id =\''.$data['job'].'\'' : '';
		$query .= (!empty($data['gender'])    )? 'AND p.gender =\''.$data['gender'].'\'' : '';
		if(!empty($data['lookingFor'])){
			$query .= 'AND lf.look_for_id = ' . $data['lookingFor'] . ' ';
			$innerQuery .= 'LEFT JOIN account_look_for lf ON lf.account_id = p.id ';
		}
		if(!empty($data['interest'])){
			$query .= 'AND ai.interest_id = ' . $data['interest'] . ' ';
			$innerQuery .= 'LEFT JOIN account_interest ai ON ai.account_id = p.id ';
		}
  
		$sql = "SELECT p.id 
				,CONCAT(p.fname,' ',p.lname) AS fullname
				,if(p.gender='M','Male','Female') AS gender
				,ms.name AS `status`
				,(SELECT image_name FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC,date_added DESC LIMIT 1) as proImg
				,c.name AS country
				,c.iso_code_2 AS flag
				,pin.pinverified
				FROM people p 
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				LEFT JOIN account_gallery g ON g.account_id = p.id
				INNER JOIN bbm_pin pin ON pin.account_id = p.id 
				$innerQuery
				WHERE 0=0 $query GROUP BY p.id ORDER BY g.date_added DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getHomeUserList()
	{  
		$sql = "SELECT 
				distinct(p.id)
				,CONCAT(p.fname,' ',p.lname) AS fullname
				,if(p.gender='M','Male','Female') AS gender
				,ms.name AS `status`
				,(SELECT image_name FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC,date_added DESC LIMIT 1) as proImg
				,c.name AS country
				,c.iso_code_2 AS flag
				,pin.pinverified
				FROM people p 
				INNER JOIN odb_country c ON c.country_id = p.country_id
				INNER JOIN odb_marital_status ms ON ms.id = p.status
				INNER JOIN account_gallery g ON g.account_id = p.id
				INNER JOIN bbm_pin pin ON pin.account_id = p.id 
				ORDER BY p.date_added DESC 
				LIMIT 8";
		return parent::executeQuery($sql, true);
	}
	
	function getSystemMatch()
	{  
		$sql = "SELECT 
				distinct(p.id)
				,CONCAT(p.fname,' ',p.lname) AS fullname
				,if(p.gender='M','M','F') AS gender
				,ms.name AS `status`
				,(SELECT image_name FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC,date_added DESC LIMIT 1) as proImg
				,c.name AS country
				,c.iso_code_2 AS flag
				,pin.bbmpin
				FROM people p 
				INNER JOIN odb_country c ON c.country_id = p.country_id
				INNER JOIN odb_marital_status ms ON ms.id = p.status
				INNER JOIN account_gallery g ON g.account_id = p.id
				INNER JOIN bbm_pin pin ON pin.account_id = p.id 
				WHERE pin.hidepin = '0' AND p.id != '{$_SESSION['BBPINWORLD']['id']}'
				ORDER BY RAND() LIMIT 20";
		return parent::executeQuery($sql, true);
	}
	
	function getGroupList($data=array(),$limit=null)
	{
		$query = $innerQuery = "";
		$query .= (!empty($data['country_id']))? 'AND p.country_id = ' . $data['country_id'] . ' ' : '';
		$query .= (!empty($data['interest']))? 'AND gi.interest_id = ' . $data['interest'] . ' ' : '';
		$limit  = (!empty($limit))? 'LIMIT '.$limit : '';
  
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
				WHERE 0=0 $query ORDER BY p.date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getProfileInfo($id)
	{				
		$sql = "SELECT p.fname,p.lname,p.email,if(p.gender='M','Male','Female') AS gender,p.gender_prefrence AS gender_prefrence
				,DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(dob)),'%y') AS age
				,p.dob
				,p.hide_age,p.education_level_id,p.job_category_id,e.name as education_level,j.name AS job_category
				,c.country_id,c.name AS country,c.iso_code_2 AS flag,p.country_zone_id
				,if(z.name IS NULL,'',CONCAT(' - (<a href=\"search.php?cz=',p.country_zone_id,'\">',z.name,'</a>)')) AS country_zone,
				ms.id AS status_id,ms.name AS `status`,
				p.about_me,pin.id AS bbmid,
				pin.bbmpin,pin.hidepin,pin.pinverified 
				FROM people p 
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN obd_county_zone z ON z.zone_id = p.country_zone_id
				LEFT JOIN job_category j ON j.id = p.job_category_id
				LEFT JOIN education_level e ON e.id = p.education_level_id
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
		$sql = "SELECT id,image_name,profile_img,description FROM account_gallery WHERE account_id = '$id' ORDER BY profile_img DESC,date_added DESC";
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
	
	function getGroupInterest($id)
	{				
		$sql = "SELECT interest_id FROM group_interest WHERE group_id = '$id'";
		return parent::executeQuery($sql, false);
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
		if(isValidEmail($user)){
			$query = "p.email = '$user'";
		}else{
			$query = "pin.bbmpin = '$user'";
		}
			
		$sql = "SELECT p.id,p.fname,p.lname,p.email,if(pin.id IS null,0,1) as bbm,(SELECT if(is_read=1,'no','yes') FROM messages WHERE receiver_id = p.id AND is_read = 0 LIMIT 1) as newMessage
				FROM people p 
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id
				WHERE $query AND p.password = MD5('$pass') LIMIT 1";
		$rt = parent::executeQuery($sql, false);
		if($rt){
			$sql = "INSERT INTO account_last_login (user_id,login_date) VALUES ({$rt['id']},NOW())";
			parent::executeNoneQuery($sql);
			return $rt;
		}
		return false;
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
	
	
	function deleteGroupImage($img,$id)
	{
		$sql = "DELETE from group_gallery WHERE image_name = '$img' AND group_id = " . $id;
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
	
	function getUserFbId($id,$email)
	{				
		$sql = "SELECT p.id,p.fname,p.lname,p.email,if(pin.id IS null,0,1) as bbm FROM people p 
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id
				WHERE p.fb_id = '$id' OR p.email = '$email' LIMIT 1";
		$rt = parent::executeQuery($sql, false);
		if($rt){
			$sql = "INSERT INTO account_last_login (user_id,login_date) VALUES ({$rt['id']},NOW())";
			parent::executeNoneQuery($sql);
			return $rt;
		}
		return false;
	}
	
	function getProfileComments($id)
	{				
		$sql = "SELECT c.id,p.id AS senderid, CONCAT(p.fname,' ',p.lname) AS sendername,c.comment,c.date_added FROM profile_comment c
				LEFT JOIN people p ON p.id = c.sender_id
				WHERE c.profile_id = '$id' ORDER BY c.date_added DESC LIMIT 20";
		return parent::executeQuery($sql, true);
	}
	
	function getProfilePhotoComments($id,$img)
	{				
		$sql = "SELECT c.id,p.id AS senderid, CONCAT(p.fname,' ',p.lname) AS sendername,c.comment,c.date_added FROM profile_photo_comment c
				LEFT JOIN people p ON p.id = c.sender_id
				WHERE c.profile_id = '$id' AND img = '$img' ORDER BY c.date_added DESC LIMIT 20";				
		return parent::executeQuery($sql, true);
	}
	
	function getGroupComments($id)
	{				
		$sql = "SELECT c.id,p.id AS senderid,g.account_id AS group_owner,CONCAT(p.fname,' ',p.lname) AS sendername,c.comment,c.date_added FROM group_comment c
				INNER JOIN bbm_group g ON g.id = c.group_id
				LEFT JOIN people p ON p.id = c.sender_id
				WHERE c.group_id = '4' ORDER BY c.date_added DESC LIMIT 20";
		return parent::executeQuery($sql, true);
	}
	
	function addPhotoComment($s,$p,$i,$c)
	{				
		$sql = "INSERT INTO profile_photo_comment (sender_id,profile_id,img,`comment`,date_added) VALUES ('$s','{$p}','{$i}',\"{$c}\",NOW())";
		return parent::executeNoneQuery($sql);
	}
	
	function getUserPinRequest($id)
	{				
		$sql = "SELECT p.id,CONCAT(p.fname,' ',p.lname) AS fullname,'' AS str1,pin.bbmpin,a.date_added 
				FROM account_request a 
				INNER JOIN people p ON p.id = a.account_id 
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id 
				WHERE a.user_id = '$id' 
				UNION 
				SELECT p.id,CONCAT(p.fname,' ',p.lname) AS fullname,CONCAT('Group Request for <b>',g.group_name,'</b>') AS str1,pin.bbmpin,gr.date_added 
				FROM bbm_group g 
				INNER JOIN group_request gr ON gr.group_Id = g.id 
				INNER JOIN people p ON p.id = gr.account_id
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id  
				WHERE g.account_id = '$id' ORDER BY date_added DESC";
		return parent::executeQuery($sql, true);
	}

	function getMessages($id)
	{				
		$sql = "SELECT p.id AS account_id,CONCAT(p.fname,' ',p.lname) as fullname, m.id,m.subject,m.message,m.date_added, 'from' as mtype,m.is_read FROM messages m
				INNER JOIN people p ON p.id = m.sender_id
				WHERE m.receiver_id = '$id'
				UNION 
				SELECT p.id AS account_id,CONCAT(p.fname,' ',p.lname) as fullname, m.id,m.subject,m.message,m.date_added, 'send' as mtype, NULL as is_read FROM messages m
				INNER JOIN people p ON p.id = m.receiver_id
				WHERE m.sender_id = '$id' ORDER BY date_added DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getMessage($id)
	{				
		$sql = "SELECT p.id AS account_id,CONCAT(p.fname,' ',p.lname) as fullname,m.id,m.subject,m.message,m.date_added, 'send' as mtype,m.is_read FROM messages m 
				INNER JOIN people p ON p.id = m.sender_id
				WHERE m.id = '$id'";
		return parent::executeQuery($sql, false);
	}
	
	function setProfileImage($id,$imgId)
	{				
		$sql = "update account_gallery set profile_img = '0'
				where account_id = '$id'";
		if(parent::executeNoneQuery($sql)){
			$sql = "update account_gallery set profile_img = '1'
				where id = '$imgId'";
			return parent::executeNoneQuery($sql);
		}
		return false;	
	}
	
	function setPinToVerifie($id,$userid)
	{				
		$sql = "update bbm_pin set pinverified = '1'
				where id = '$id' AND account_id = '$userid'";
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
}
?>