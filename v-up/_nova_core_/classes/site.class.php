<?php
class site extends mySqlDB
{
	function site(){parent::mySqlDB();}
	function addvideo($data)
	{				
		$sql = "INSERT INTO video_pool (id, video, date_added, user_id, duration) VALUES ('', '{$data['video']}', NOW(), '{$data['user_id']}', '{$data['duration']}')";
		return $this->executeNoneQuery( $sql );
	}
	function updateVideoInfo($data)
	{				
		$sql = "UPDATE video_pool SET 	title = \"{$data['title']}\", 
										url_title = \"{$data['url_title']}\",
										tags  = \"{$data['tags']}\", 
										description = \"{$data['description']}\", 
										meta_desc = \"{$data['meta_desc']}\", 
										category_id = \"{$data['category_id']}\", 
										user_id = \"{$data['user_id']}\", 
										enable = \"1\",
										explicit = \"{$data['explicit']}\" 
										WHERE video = \"{$data['id']}\"";
		if($this->executeNoneQuery($sql))
		{
			$url_title = (!empty($data['url_title']))? $data['url_title'] : $data['title'] ;
			$this->updateVideoUrl($url_title,$data['id']);
			return true;
		}
		return false;		
	}
	function updateVideoUrl($url,$videoId)
	{ 
		$url = strtolower(trim($url));
		$url = preg_replace('([^a-zA-Z0-9_ ])', '', $url );
		$url = str_replace('  ', '_', $url);
		$url = str_replace(' ', '_', $url);

		$sql = "SELECT COUNT(id) AS cnt FROM video_pool WHERE url_title = '$url' AND video != '$videoId'";
		$rs = parent::executeQuery($sql, false);
	
		if(empty($rs['cnt']))
		{
			$sql = "UPDATE video_pool SET url_title = '$url' WHERE video = '$videoId'";
		}
		else
		{ 
			$url .= rand(10,99).date("ymd");
			$sql = "UPDATE video_pool SET url_title = '$url' WHERE video = '$videoId'";
		}	
		return $this->executeNoneQuery( $sql );
	}
	function updateCategory($data)
	{				
		$sql = "UPDATE categories SET category = \"{$data['category']}\", 
									keywords = \"{$data['keywords']}\",
									description = \"{$data['description']}\"
									WHERE id = \"{$data['id']}\""; 
		return $this->executeNoneQuery( $sql );
	}
	function getUserVideoList($user_id,$limit=NULL,$video=NULL)
	{			
		$limit = (!empty($limit))? "LIMIT $limit" : "";
		$video = (!empty($video))? "AND v.video != '$video'" : "";
		$sql = "SELECT v.*, a.username, c.category  FROM video_pool v 
				INNER JOIN categories c ON v.category_id = c.id
				LEFT JOIN accounts a ON v.user_id = a.id
				WHERE v.user_id = '$user_id' AND v.enable = '1' $video ORDER BY v.date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	function getMyVideoList($myId)
	{			
		$sql = "SELECT v.*, a.username FROM video_pool v 
				LEFT JOIN accounts a ON v.user_id = a.id
				WHERE v.user_id = '$myId' ORDER BY v.date_added DESC"; 
		return parent::executeQuery($sql, true);
	}
	function getVideoRecord($url, $enable=false, $explicit=false, $cat=NULL)
	{			
		$enable   = ($enable==true)? "AND v.enable = '1'" : "";
		$explicit = ($explicit==true)? "AND v.explicit = '1'" : "";
		$cat 	  = (empty($cat))? "" : "AND c.category = '".str_replace("_", " ", $cat)."'";
		$sql = "SELECT v.*, c.id AS category_id, c.category, a.username, a.id AS userId FROM video_pool v
				LEFT JOIN categories c ON v.category_id = c.id
				LEFT JOIN accounts a ON v.user_id = a.id
				WHERE v.video = '$url' OR v.url_title = '$url' $cat $explicit $enable LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	function getCategory($limit=NULL,$query=NULL)
	{			
		$limit = (empty($limit))? "" : "limit $limit";
		$query = (empty($query))? "" : "AND category = '$query'";
		$sql = "SELECT c.* FROM categories c WHERE 0=0 $query ORDER BY c.order $limit";
		return parent::executeQuery($sql, true);
	}
	function deleteVideo($id)
	{			
		$sql = "DELETE FROM video_pool WHERE id = '$id'";
		$this->executeNoneQuery($sql);
		return mysql_affected_rows();
	}
	function getLatestVideo($limit=6)
	{			
		$sql = "SELECT v.video, v.title, v.url_title, v.tags, v.description, v.date_added, v.viewed, v.duration, v.explicit, a.username, c.category FROM video_pool v
				INNER JOIN categories c ON v.category_id = c.id
				INNER JOIN accounts a ON v.user_id = a.id WHERE v.enable = '1' ORDER BY v.date_added DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	function getFeaturedVideo($limit=1)
	{			
		$sql = "SELECT v.video, v.title, v.url_title, v.description, v.date_added, v.explicit, c.category FROM video_pool v
				LEFT JOIN categories c ON v.category_id = c.id
				LEFT JOIN accounts a ON v.user_id = a.id WHERE v.feature = 1 AND v.enable = '1' ORDER BY v.date_added DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	function getMoreVideo($limit=1)
	{			
		$sql = "SELECT v.video, v.title, v.url_title, v.tags, v.description, v.date_added, v.viewed, v.duration, v.explicit, a.username, c.category FROM video_pool v
		 		INNER JOIN categories c ON v.category_id = c.id
				INNER JOIN accounts a ON v.user_id = a.id WHERE v.enable = '1' ORDER BY RAND() LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	function getVideoPicks()
	{		
		/* 10 randdom video will deside what to do later */	
		$sql = "SELECT v.video, v.title, v.url_title, c.category FROM video_pool v 
				INNER JOIN categories c ON v.category_id = c.id
				WHERE v.enable = '1' AND v.explicit = '0' ORDER BY v.viewed DESC LIMIT 10";
		return parent::executeQuery($sql, true);
	}
	function getFavorites($id)
	{			
		$sql = "SELECT v.video, v.title, v.description, v.date_added, v.explicit FROM video_pool v
				INNER JOIN favorites f ON f.video_id = v.id
				INNER JOIN accounts a ON a.id = f.user_id";
		return parent::executeQuery($sql, true);
	}
	function getRelatedVideos($data)
	{		
		$tags = "";
		foreach(explode(",",$data['tags']) as $key => $value)
		{
			$tags .="OR v.tags LIKE '%".trim($value)."%' ";
		}
		
		$sql = "SELECT v.id, v.video, v.url_namae, v.title, v.tags, v.date_added, v.viewed, v.explicit, a.username, c.category FROM video_pool v 
				INNER JOIN categories c ON v.category_id = c.id
				INNER JOIN accounts a ON a.id = v.user_id 
				WHERE tags LIKE '%-1%' $tags LIMIT 30";
		$dbResult = mysql_query($sql, $this->db);
		$data = array();
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['id']]['title'] = $row['title'];
				$data[$row['id']]['url_namae'] = $row['url_namae'];
				$data[$row['id']]['video'] = $row['video'];
				$data[$row['id']]['tags'] = $row['tags'];
				$data[$row['id']]['date_added'] = $row['date_added'];
				$data[$row['id']]['username']   = $row['username'];
				$data[$row['id']]['viewed']   	= $row['viewed'];
				$data[$row['id']]['explicit']   = $row['explicit'];
				$data[$row['id']]['category']   = $row['category'];
			}
			return $data;
		}

		return false;	
	}
	function getVideoByCategory($id, $limit=NULL)
	{			
		$limit = (!empty($limit))? "LIMIT $limit" : "";
		$sql = "SELECT v.*,a.username, c.category FROM video_pool v
				INNER JOIN accounts a ON a.id = v.user_id 
				INNER JOIN categories c ON c.id = v.category_id WHERE c.category = '$id' ORDER BY v.date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	function getSearchVideo($data, $limit=NULL)
	{			
		$text = (!empty($data['text']))? "AND v.title LIKE '%{$data['text']}%' OR v.description LIKE '%{$data['text']}%'" : "";
		$tags = (!empty($data['tags']))? "AND v.tags LIKE '%".str_replace("_", " ",$data['tags'])."%'" : "";
		$user = (!empty($data['user']))? "AND a.username = '{$data['user']}'" : "";
		$usId = (!empty($data['userid']))?"AND a.id = '{$data['userid']}'" : "";
		$feat = (!empty($data['feat'])  )? "AND v.feature = '1'"  : "";
		$latest=(!empty($data['latest']))? "ORDER BY v.date_added DESC"  : "";
		$limit =(empty($limit))? "" : "LIMIT $limit";
		
		$sql = "SELECT v.video, v.title, v.url_title, v.description, v.date_added, v.viewed, v.duration, v.tags, v.explicit, c.category, a.username FROM video_pool v
				LEFT JOIN categories c ON c.id = v.category_id 
				LEFT JOIN accounts a ON a.id = v.user_id 
				WHERE 0=0 $text $tags $user $usId $feat $latest $limit";
		return parent::executeQuery($sql, true);
	}
	function getVideoTags($limit=60)
	{
		$sql = "SELECT tags FROM video_pool WHERE tags != '' LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	############################################### 
	##################### BEGIN USER SECTION ########################## 
	function loginUser($usr, $pass)
	{			
		$pass = md5($pass);
		$sql = "SELECT id, username, account_type FROM accounts WHERE username = '$usr' AND password = '$pass' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	function addUser($data)
	{				
		$sql = "INSERT INTO accounts (id, username, email, password, reg_date, dob, gender, country_id, newsletter) 
				VALUES
				('', '{$data['username']}', '{$data['email']}', md5('{$data['password']}'), NOW(), '{$data['dob']}', '{$data['gender']}', '{$data['country_id']}', '{$data['newsletter']}')";
		return $this->executeNoneQuery( $sql );
	}
	function updateAccount($data,$user)
	{	
		$pass = (!empty($data['password']))? ", password = md5('{$data['password']}')" : "";
		$sql  = "UPDATE accounts SET 
				email 		= '{$data['email']}', 
				country_id 	= '{$data['country_id']}',
				gender 		= '{$data['gender']}',
				dob 		= '{$data['dob']}',
				newsletter 	= '{$data['newsletter']}'				
				$pass 
				WHERE username = '$user'";
		return $this->executeNoneQuery( $sql );
	}
	function getAcountInfoByEmail($email, $pass)
	{				
		$sql = "SELECT * FROM accounts WHERE email = '$email' LIMIT 1";
		$rs = parent::executeQuery($sql, false);
		
		if(!empty($rs))
		{
			$sql = "UPDATE accounts SET password = md5('$pass') WHERE email = '$email'"; 
			if($this->executeNoneQuery($sql))
			{
				return $rs;
			}
		}
		return false;
	}
	function emailLookUp($email)
	{				
		$sql = "SELECT * FROM accounts WHERE email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	function userLookUp($user)
	{				
		$sql = "SELECT * FROM accounts WHERE username = '$user' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function OAuthConnetion($userId, $user)
	{
		/* RUN WHEN USING OUT SIDE LOGIN eg twitter/Facebook */
		$sql = "SELECT id, username, account_type FROM accounts WHERE id = '$userId' LIMIT 1";
		$rs = parent::executeQuery($sql, false);
	
		if(!empty($rs))
		{
			//USER IS THERE.
			$_SESSION['ADMIN_USER']=NULL;
			return $rs;
		}
		else
		{
			//ADD NEW USER.		
			$sql = "INSERT INTO accounts (id,username,reg_date,account_type) VALUES ('$userId', '$user', NOW(), '3')";
			if($this->executeNoneQuery($sql))
			{
				$rs['id'] 			= $userId;
				$rs['username'] 	= $user;
				$rs['account_type'] = 3;
				return $rs;
			}
		}
		return NULL;
	}
	##################### END USER SECTION ########################## 
	####################################################
	function addFavorites($data)
	{
		$sql = "INSERT INTO favorites (user_id, video_id) VALUES ('{$data['user_id']}', '{$data['video_id']}')";
		return mysql_query($sql, $this->db);
	}
	function addVideoCount($id)
	{
		$sql = "UPDATE video_pool SET viewed = viewed+1 WHERE id = '$id'";
		return mysql_query($sql, $this->db);
	}
	function runEmailList($amt)
	{
		$sql = "SELECT email FROM accounts WHERE 0=0 limit $amt, 300";
		return parent::executeQuery($sql, true);
	}
}
?>