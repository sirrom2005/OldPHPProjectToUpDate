<?php 
class wbs extends mySqlDB
{	
	function site(){ parent::mySqlDB(); }

	function getUserList($data=array(),$offSet=0)
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
				,if(ms.name = '&nbsp;','None',ms.name) AS `status`
				,(SELECT image_name FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC,date_added DESC LIMIT 1) as photo
				,c.name AS country
				,c.iso_code_2 AS flag
				,pin.pinverified
				FROM people p 
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				LEFT JOIN account_gallery g ON g.account_id = p.id
				INNER JOIN bbm_pin pin ON pin.account_id = p.id 
				$innerQuery
				WHERE 0=0 $query GROUP BY p.id ORDER BY g.date_added DESC LIMIT $offSet, 10";
		return parent::executeQuery($sql, true);
	}
		
	function getUserProfile($id)
	{				
		$sql = "SELECT 
				 CONCAT(p.fname,' ',p.lname) as fullname
				,if(p.gender='M','Male','Female') AS gender
				,if(ms.name = '&nbsp;','None',ms.name) AS `status`
				,(SELECT if(image_name is null,'t',image_name) FROM account_gallery WHERE account_id = p.id ORDER BY profile_img DESC,date_added DESC LIMIT 1) as photo
				,c.name AS country
				,LOWER(c.iso_code_2) AS flag
				,c.country_id
				,p.country_zone_id
				,if(z.name IS NULL,'',z.name) AS country_zone
				,if(p.gender_prefrence = 'M', 'Male', if(p.gender_prefrence = 'F', 'Female', 'Male/Female')) AS gender_prefrence
				-- ,DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(dob)),'%y') AS age
				-- ,p.hide_age
				,ms.id AS status_id
				,if(p.about_me='','...',p.about_me) as about_me
				,if(pin.hidepin=1,'HIDDEN',pin.bbmpin) as bbmpin
				,pin.hidepin
				,pin.pinverified 
				,p.id
				FROM people p 
				LEFT JOIN odb_marital_status ms ON ms.id = p.status
				INNER JOIN bbm_pin pin ON pin.account_id = p.id
				LEFT JOIN odb_country c ON c.country_id = p.country_id
				LEFT JOIN obd_county_zone z ON z.zone_id = p.country_zone_id
				LEFT JOIN job_category j ON j.id = p.job_category_id
				LEFT JOIN education_level e ON e.id = p.education_level_id
				WHERE p.id = '$id' LIMIT 1";				
		return parent::executeQuery($sql, false);
	}
	
	function getUnverifedPins() 
	{				
		$sql = "SELECT CONCAT(p.fname,' ',p.lname) as fullname,pin.bbmpin,CONCAT(pin.id,'x',pin.account_id) as pkey
				FROM people p 
				INNER JOIN bbm_pin pin ON pin.account_id = p.id
				WHERE pin.pinverified = '0' AND LENGTH(pin.bbmpin)=8";				
		return parent::executeQuery($sql, true);
	}
	
	function userLogin($user,$pass)
	{			
		if(isValidEmail($user)){
			$query = "p.email = '$user'";
		}else{
			$query = "pin.bbmpin = '$user'";
		}
			
		$sql = "SELECT p.id
				FROM people p 
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id
				WHERE $query AND p.password = MD5('$pass') LIMIT 1";
		$rt = parent::executeQuery($sql, false);
		if($rt){
			$sql = "INSERT INTO account_last_login (user_id,login_date) VALUES ({$rt['id']},NOW())";
			parent::executeNoneQuery($sql);
			return $rt['id'];
		}
		return 0;
	}
	
	function getUserPinRequest($id)
	{				
		$sql = "SELECT p.id,CONCAT(p.fname,' ',p.lname) AS fullname,'--' AS str1,pin.bbmpin,a.date_added 
				FROM account_request a 
				INNER JOIN people p ON p.id = a.account_id 
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id 
				WHERE a.user_id = '$id' 
				UNION 
				SELECT p.id,CONCAT(p.fname,' ',p.lname) AS fullname,CONCAT('Group Request for <b>',g.group_name,'</b>') AS str1,pin.bbmpin,g.date_added 
				FROM bbm_group g 
				INNER JOIN group_request gr ON gr.group_Id = g.id 
				INNER JOIN people p ON p.id = gr.account_id
				LEFT JOIN bbm_pin pin ON pin.account_id = p.id  
				WHERE g.account_id = '$id' ORDER BY date_added DESC LIMIT 5";
		return parent::executeQuery($sql, true);
	}
	
	function getMemberWithNoPhoto()
	{				
		$sql = "select concat(p.fname,' ',p.lname) as fullname, b.bbmpin from people p 
				inner join bbm_pin b on b.account_id = p.id
				where p.id not in( select account_id from account_gallery group by account_id ) and LENGTH(b.bbmpin)=8";
		return parent::executeQuery($sql, true);
	}
	
	function getMemberList($showGender,$except=null)
	{		
		$query = "";
		if(!empty($showGender)){
			$g = ($showGender==1)?'F':'M';
			$query = "AND p.gender = '$g'";
		}		
		$except = (empty($except))? -1 : $except;
		
		$sql = "SELECT concat(p.fname,' ',p.lname) as fullname, UPPER(b.bbmpin) as bbmpin FROM people p 
				INNER JOIN bbm_pin b ON b.account_id = p.id
				WHERE LENGTH(b.bbmpin) = 8 AND p.id NOT IN(1,5,$except) $query ORDER BY b.pinverified DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getNewUser()
	{				
		$sql = "SELECT 
				bbm.bbmpin, concat(p.fname,' ',p.lname) as fullname,
				concat('Hello ',trim(concat(p.fname,' ',p.lname)),',\n\rA new user has been added to jusbbmpin.com [',trim(concat(n.fname,' ',n.lname)),'],\n\rClick the link below to view profile.\n\rhttp://www.jusbbmpin.com/m/profile_',n.id,'.html') as msg
				FROM people n,people p,bbm_pin bbm 
				WHERE n.date_added 
				BETWEEN 
				DATE_FORMAT(concat(year(now()),'-',month(now()),'-',day(now()),' ',hour(subtime(now(),'2:00:00')),':00:00'), '%Y-%m-%d %H:%i:%s')
				AND
				DATE_FORMAT(concat(year(now()),'-',month(now()),'-',day(now()),' ',hour(subtime(now(),'2:00:00')),':59:59'), '%Y-%m-%d %H:%i:%s')
				AND n.gender IS NOT NULL
				AND if(n.gender_prefrence = 'B',p.gender != 'B', n.gender_prefrence = p.gender)
				AND p.id NOT IN (n.id)
				AND bbm.account_id = p.id
				AND LENGTH(bbm.bbmpin)=8
				ORDER BY n.fname";
		return parent::executeQuery($sql, true);
	}
	
	function getNewPhotoAdded()
	{				
		$sql = "SELECT 
				bbm.bbmpin, concat(p.fname,' ',p.lname) as fullname,
				concat('Hello ',trim(concat(p.fname,' ',p.lname)),',\n\r[',trim(concat(pg.fname,' ',pg.lname)),'] has uploaded a new photo on jusbbmpin.com,\n\rClick the link below to view photo.\n\rhttp://www.jusbbmpin.com/m/profile-photo-',pg.id,'-',g.image_name,'.html') as msg
				FROM account_gallery g,people pg,people p,bbm_pin bbm
				WHERE g.date_added 
				BETWEEN 
				DATE_FORMAT(concat(year(now()),'-',month(now()),'-',day(now()),' ',hour(addtime(now(),'1:00:00')),':00:00'), '%Y-%m-%d %H:%i:%s')
				AND
				DATE_FORMAT(concat(year(now()),'-',month(now()),'-',day(now()),' ',hour(addtime(now(),'1:00:00')),':59:59'), '%Y-%m-%d %H:%i:%s')
				AND pg.id = g.account_id
				AND if(pg.gender_prefrence = 'B',p.gender != 'B', pg.gender_prefrence = p.gender)
				AND p.id NOT IN (pg.id)
				AND bbm.account_id = p.id
				AND LENGTH(bbm.bbmpin)=8";
		return parent::executeQuery($sql, true);
	}
}
?>