<?php 
@$pageBanner = $_GET['action'];
if($pageBanner == 'read-news' || $pageBanner == 'news-articlesbycategory'){ $pageBanner = 'news-articles';}
if($pageBanner == 'classifiedbycategory'){ $pageBanner = 'classifieds';}
if($pageBanner == 'find'){ $pageBanner = 'home';}
if($pageBanner == 'eventsbycategory' || $pageBanner == 'eventsbyid'){ $pageBanner = 'events';}
if($pageBanner == 'profilesbycategory' || $pageBanner == 'profile-items'){ $pageBanner = 'profiles';}
class site extends mySqlDB
{	
	function site(){ parent::mySqlDB(); }
	
	function getEvents($catid,$limit=100)
	{				
		$sql = "SELECT e.id,e.title,e.desc,e.image_name,e.event_date,c.name AS category,c.url_name AS cat_url_name FROM event e 
				INNER JOIN category c ON c.id = e.category_id
				WHERE DATE_FORMAT(e.start_date,'%Y-%m-%d') <= '".date('Y-m-d')."' AND DATE_FORMAT(e.end_date,'%Y-%m-%d') >= '".date('Y-m-d')."' AND c.url_name = '$catid' ORDER BY e.event_date,e.title LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	function getHomePageEvents($catid)
	{				
		$sql = "SELECT e.id,e.title,e.desc,e.image_name,e.event_date,c.name AS category,c.url_name AS cat_url_name FROM event e 
				INNER JOIN category c ON c.id = e.category_id
				WHERE DATE_FORMAT(e.start_date,'%Y-%m-%d') <= '".date('Y-m-d')."' AND DATE_FORMAT(e.end_date,'%Y-%m-%d') >= '".date('Y-m-d')."' AND c.url_name = '$catid' ORDER BY RAND() LIMIT 10";
		return parent::executeQuery($sql, true);
	}
	function getEventById($id)
	{				
		$sql = "SELECT e.id,e.title,e.desc,e.image_name,e.event_date,c.name AS category,c.url_name AS cat_url_name FROM event e 
				INNER JOIN category c ON c.id = e.category_id
				WHERE e.image_name = '$id'";
		return parent::executeQuery($sql, false);
	}
	function getEventsByDate($date)
	{				
		$sql = "SELECT e.id,e.title,e.desc,e.image_name,e.event_date,c.name AS category,c.url_name AS cat_url_name FROM event e 
				INNER JOIN category c ON c.id = e.category_id
				WHERE DATE_FORMAT(e.start_date,'%Y-%m-%d') <= '".date('Y-m-d')."' AND DATE_FORMAT(e.end_date,'%Y-%m-%d') >= '".date('Y-m-d')."' AND DATE_FORMAT(e.event_date,'%Y-%m-%d') = DATE_FORMAT('$date','%Y-%m-%d') ORDER BY e.event_date";
		return parent::executeQuery($sql, true);
	}
	function getEventDates()
	{				
		$sql = "SELECT DISTINCT(DATE_FORMAT(e.event_date,'%Y-%m-%d')) AS event_date FROM event e WHERE DATE_FORMAT(e.start_date,'%Y-%m-%d') <= '".date('Y-m-d')."' AND DATE_FORMAT(e.end_date,'%Y-%m-%d') >= '".date('Y-m-d')."' ORDER BY e.event_date";
		return parent::executeQuery($sql, true);
	}
	function getNewsByCategory($cat)
	{				
		$sql = "SELECT n.id,n.title,c.name AS category,n.summary,n.news_date,n.video,n.audio,i.image_name FROM news_articles n
				LEFT JOIN news_articles_images i ON i.news_id = n.id
				INNER JOIN `news-category` c ON c.id = n.category_id
				WHERE c.url_name = '$cat'
				GROUP BY n.id ORDER BY n.news_date DESC";
		return parent::executeQuery($sql, true);
	}
	function getNewsById($id)
	{				
		$sql = "SELECT n.id,n.title,n.summary,c.name AS category,c.url_name,n.detail,n.news_date,n.video,n.audio FROM news_articles n 
				INNER JOIN `news-category` c ON c.id = n.category_id
				WHERE n.id = '$id'";
		return parent::executeQuery($sql, false);
	}
	function getHomePageNews($limit=3)
	{				
		$sql = "SELECT n.id,n.title,n.summary,n.news_date,g.image_name,c.url_name FROM news_articles n
				LEFT JOIN news_articles_images g on g.news_id = n.id
				INNER JOIN `news-category` c ON c.id = n.category_id
				GROUP BY n.id ORDER BY n.news_date DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}	
	function getNewsImage($id)
	{				
		$sql = "SELECT id,image_name,description FROM news_articles_images WHERE news_id = $id";
		return parent::executeQuery($sql,true);
	}
	function getNewsGallery($id)
	{				
		$sql = "SELECT a.folder AS folder,i.filename,CONCAT(a.folder) AS url,a.title FROM news_gallery_tags n
				INNER JOIN `photo-gallery_obj_to_tag` tag ON tag.tagid = n.gallery_tag
				INNER JOIN `photo-gallery_albums` a ON a.id = tag.objectid 
				INNER JOIN `photo-gallery_images` i ON i.albumid = a.id 
				WHERE n.news_id = '$id' AND tag.type = 'albums' GROUP BY a.id
				UNION
				SELECT a.folder AS folder,i.filename, CONCAT(a.folder,'/',i.filename) AS url,i.title FROM news_gallery_tags n
				INNER JOIN `photo-gallery_obj_to_tag` tag ON tag.tagid = n.gallery_tag
				INNER JOIN `photo-gallery_images` i ON i.id = tag.objectid
				INNER JOIN `photo-gallery_albums` a ON a.id = i.albumid
				WHERE n.news_id = '$id' AND tag.type = 'images'";
		return parent::executeQuery($sql,true);
	}
	function getClassifiedCategory()
	{				
		$sql = "SELECT c.id,c.url_name,c.name FROM category c WHERE c.cat_type = 1 ORDER BY c.name";
		return parent::executeQuery($sql,true);
	}
	function getProfileCategory()
	{				
		$sql = "SELECT c.id,c.url_name,c.name FROM category c WHERE c.cat_type = 2 ORDER BY c.name";
		return parent::executeQuery($sql,true);
	}
	function getEventCategory()
	{				
		$sql = "SELECT c.id,c.url_name,c.name FROM category c WHERE c.cat_type = 3 ORDER BY c.id";
		return parent::executeQuery($sql,true);
	}
	function getProfileInfo($cat,$id)
	{				
		$sql = "SELECT cat.name AS category,p.title,p.detail,p.date_added FROM profile p
				INNER JOIN category cat ON cat.id = p.category_id
				WHERE cat.url_name = '$cat' AND p.id = '$id'";
		return parent::executeQuery($sql,false);
	}
	function getProfileInfoImages($id)
	{				
		$sql = "SELECT image_name,description FROM profile_gallery WHERE profile_id = $id";
		return parent::executeQuery($sql,true);
	}
	function getClassifiedByCategoryType($id)
	{				
		$sql = "SELECT cat.name AS category,c.* FROM classified c
				INNER JOIN category cat ON cat.id = c.category_id
				WHERE cat.url_name = '$id' ORDER BY date_added DESC";
		return parent::executeQuery($sql,true);
	}
	function getProfileByCategoryType($id=NULL,$catname=NULL,$limit=NULL)
	{				
		$limit = (!empty($limit))? "LIMIT $limit" : "" ;
		$category = ($id)? "cat.id = '$id'" : "cat.url_name = '$catname'" ;
		$sql = "SELECT cat.name AS category, cat.url_name, p.id, p.title, p.summary, g.image_name,p.date_added FROM profile p 
				LEFT JOIN profile_gallery g ON g.profile_id = p.id
				INNER JOIN category cat ON cat.id = p.category_id 
				WHERE $category ORDER BY p.date_added DESC $limit";
		return parent::executeQuery($sql,true);
	}
	function getClassifiedInfo($cat,$id)
	{				
		$sql = "SELECT cat.name AS category,c.title,c.date_needed,c.detail,c.date_added,c.account_id FROM classified c
				INNER JOIN category cat ON cat.id = c.category_id
				WHERE cat.url_name = '$cat' AND c.id = '$id'";
		return parent::executeQuery($sql,false);
	}
	function getClassifiedListing()
	{				
		$sql = "SELECT c.id,cat.name AS category,c.title,c.detail,c.date_added,c.account_id FROM classified c
				INNER JOIN category cat ON cat.id = c.category_id ORDER BY c.date_added DESC";
		return parent::executeQuery($sql,true);
	}
	function getClassifiedInfoImages($id)
	{				
		$sql = "SELECT image_name,description FROM classified_gallery WHERE classified_id = $id";
		return parent::executeQuery($sql,true);
	}
	function deleteClassifiedImage($img,$id)
	{
		$sql = "DELETE from classified_gallery WHERE image_name = '$img' AND classified_id = $id";
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
	function searchTxt($txt)
	{				
		$sql = "SELECT CONCAT('news-articles/',c.url_name,'/fimiyaad-news-',n.id,'.html') as url,n.title FROM news_articles n
				INNER JOIN `news-category` c ON c.id = n.category_id
				WHERE n.title LIKE '%$txt%' OR n.detail LIKE '%$txt%' LIMIT 5
				UNION
				SELECT CONCAT('profiles/',c.url_name,'/profile',p.id,'.html') as url,p.title FROM profile p
				INNER JOIN category c ON c.id = p.category_id
				WHERE p.title LIKE '%$txt%' OR p.detail LIKE '%$txt%'
				UNION
				SELECT CONCAT('classifieds/',cat.url_name,'/item',c.id,'.html') as url,c.title FROM classified c
				INNER JOIN category cat ON cat.id = c.category_id
				WHERE c.title LIKE '%$txt%' OR c.detail LIKE '%$txt%'
				UNION
				SELECT s.url,s.title FROM site_search_tags s
				WHERE s.title LIKE '%$txt%' OR s.tags LIKE '%$txt%'";
		return parent::executeQuery($sql,true);
	}

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
		$sql = "INSERT INTO people (fname,lname,email,fb_id,date_added) 
							VALUES (\"{$rs['fname']}\",\"{$rs['lname']}\",\"{$rs['email']}\",\"{$rs['fb_id']}\",NOW())";
		return parent::executeNoneQuery($sql);
	}
	
	function userLogin($user,$pass)
	{			
		$sql = "SELECT p.id,p.username FROM people p WHERE p.username='$user' AND p.pass = MD5('$pass') LIMIT 1";
		return parent::executeQuery($sql, false);
	}

	function updatePassword($old,$new)
	{
		$sql = "UPDATE people a SET a.password = '".md5($new)."' WHERE a.password = '".md5($old)."' AND a.id = " . $_SESSION['BBPINWORLD']['id'];
		$rt = parent::executeNoneQuery($sql);
		return mysql_affected_rows();
	}
	
	function getUserFbId($id,$email)
	{				
		$sql = "SELECT p.id,CONCAT(p.fname,' ',p.lname) AS fname,p.email FROM people p 
				WHERE p.fb_id = '$id' OR p.email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
		
	function insertNewsGalleryTags($id,$rs)
	{
		$sql = "DELETE FROM news_gallery_tags WHERE news_id = '$id'";
		parent::executeNoneQuery($sql);
		
		if(empty($rs)){ return false; }
		$query = "";
		foreach($rs as $key => $value){
			$query .= "($id,$value),";
		}
		$query = str_replace(',ENDZ','',$query.='ENDZ');
		$sql = "INSERT INTO news_gallery_tags (news_id,gallery_tag) VALUES $query";
		return parent::executeNoneQuery($sql);
	}
	
	function getNewsGalleryTags($id)
	{				
		$sql = "SELECT * FROM news_gallery_tags WHERE news_id = '$id'";
		$dbResult = mysql_query($sql);
		$data = array();
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['gallery_tag']] = $row['gallery_tag'];
			}
			return $data;
		}
		return false;
	}
}
?>