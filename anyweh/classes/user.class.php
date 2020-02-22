<?php
class user extends mySqlDB
{
	var $thisDB =  "admin_users";
	
	function user()
	{
		parent::mySqlDB();
	}
	
	function addUser($data)
	{
		$user_name 		= preFixString($data['user_name']);
		$password 		= md5(preFixString($data['pass'])); 
		$user_level		= $data['user_level'];
		$country_id		= $data['country_id'];
		$register_date	= date("Y-m-d G:i:s");
		
		$sql = "INSERT INTO admin_users (user_name, password, user_level, register_date, enable) VALUES(\"$user_name\", \"$password\", \"$user_level\", \"$register_date\", '1' )";	
		return parent::executeNoneQuery($sql);
	}
	
	function updateUser( $data, $id )
	{
		$password 		= md5(preFixString($data['pass'])); 
		$user_level		= $data['user_level'];
		$country_id		= $data['country_id'];
		$register_date	= date("Y-m-d G:i:s");
		
		$sql = "INSERT INTO admin_users (user_name, user_level, register_date) VALUES(\"$user_name\", \"$user_level\", \"$register_date\" )";	
		return parent::executeNoneQuery($sql);
	}
	
	function userLogin( $username, $password )
	{			
		$sql = "SELECT us.id, us.user_level FROM {$this->thisDB} us 
				WHERE us.user_name = '$username' AND us.password = md5('$password') AND us.enable = '1' LIMIT 1"; 
		
		$data = parent::executeQuery($sql, false);
		if( !empty($data) )
		{
			$sql = "UPDATE {$this->thisDB} us SET us.last_login_date = NOW() 
					WHERE us.user_name = '$username' AND us.password = md5('$password') AND us.enable = '1' LIMIT 1 ";
			parent::executeNoneQuery($sql); 
			return $data;
		}
		return false;
	}
	
	function changePassword( $password, $id )
	{		
		$sql = "UPDATE {$this->thisDB} SET password = md5('$password') WHERE 0=0 AND id = '$id'";
		if( parent::executeNoneQuery($sql) )
		{
			$sql = "SELECT count(user_name) AS usCount FROM {$this->thisDB} WHERE 0=0 AND id = '$id' AND password = md5('$password')";
			return parent::executeQuery($sql, false);
		}
		return false;
	}
	
	function getUserById( $id=NULL )
	{			
		$query = (!empty($id))? "AND au.id = '$id'" : "" ;
		$sql = "select au.*, ul.name AS userLevel from admin_users au 
				INNER JOIN user_level ul ON au.user_level = ul.id 
				WHERE 0=0 $query";
		return parent::executeQuery($sql, true);
	}
	
	function deleteUser( $id )
	{
		if( $id == 1 )
		{
			echo "<div class='errormessage'>This user connot be deleted<div>";
			return true;
		}
		
		$sql = "DELETE FROM {$this->thisDB} WHERE id = '$id' ";
		parent::executeNoneQuery($sql); 
	}
	
	function updateRecord( $DATA, $id)
	{
		if( $id == 1 )
		{
			echo "<div class='errormessage'>This user connot be updated<div>";
			return false;
		}
		
		$updateStr = "id = '$id' ";
		
		foreach( $DATA as $key => $value )
		{
			$updateStr = $updateStr.", $key = '".addslashes(trim($value))."'" ;
		}
			
		$sql = "UPDATE {$this->thisDB} SET $updateStr WHERE id = '$id'";
		return $this->executeNoneQuery( $sql );
	}
	
	/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
	function membersLogin( $username, $password )
	{		
		$password = base64_encode("$password");
		$sql = "SELECT us.id, us.user_name, us.last_login_date, us.email, us.website FROM members us 
				WHERE us.user_name = '$username' AND us.password = '$password' AND us.enable = '1' LIMIT 1";
		
		$data = parent::executeQuery($sql, false);
		if( !empty($data) )
		{
			$sql = "UPDATE members us SET us.last_login_date = NOW() 
					WHERE us.user_name = '$username' AND us.password = $password' AND us.enable = '1' LIMIT 1 ";
			parent::executeNoneQuery($sql); 
			return $data;
		}
		return false;
	}
	
	function getMemberPassword( $email )
	{		
		$sql = "SELECT us.user_name, us.password FROM members us WHERE us.email = '$email'";
		return parent::executeQuery($sql, false);
	}
	
	function cheackUserName( $username )
	{		
		$sql = "SELECT us.user_name FROM members us WHERE us.user_name = '$username'";
		return parent::executeQuery($sql, false);
	}
}
?>