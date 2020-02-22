<?php
class software extends mySqlDB
{	
	function software(){ parent::mySqlDB(); }
	
	function addNews($data)
	{
		$title 			= preFixString($data['title']);
		$intro_text		= preFixString($data['intro_text']);
		$detail 		= addslashes(trim($data['detail']));
		$news_image 	= $data['news_image'];
		$date 			= $data['date'];
		$date_added		= date("Y-m-d G:i:s");
		$article_type	= $data['article_type']; 
		$enable			= $data['enable'];
					
		$sql = "INSERT INTO news (title, intro_text, detail, news_image, date, date_added, article_type, enable) VALUES(\"$title\", \"$intro_text\", \"$detail\", \"$news_image\", \"$date\", \"$date_added\", \"$article_type\", \"$enable\" )";	
		return parent::executeNoneQuery($sql);
	}
	
	function updateNews( $data, $id )
	{
		$title 			= preFixString($data['title']);
		$intro_text		= preFixString($data['intro_text']);
		$detail 		= addslashes(trim($data['detail']));
		$news_image 	= $data['news_image'];
		$date 			= $data['date'];
		$article_type	= $data['article_type'];
		$enable			= $data['enable'];
		
		$sql = "UPDATE news SET title=\"$title\", intro_text=\"$intro_text\", detail=\"$detail\", news_image=\"$news_image\", date=\"$date\", article_type=\"$article_type\", enable=\"$enable\"  WHERE news_id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
	
	function getSoftware($name, $cat)
	{
		$sql = "SELECT 
				p.id AS id,
				p.name AS title,
				p.ceo_url_name AS url_title,  
				p.program_type AS program_type, 
				p.keywords AS keywords, 
				p.summary_80 AS summary_80, 
				p.summary AS app_summary, 
				p.system_requirements AS system_requirements,
				p.publisher_url AS app_website,
				p.publisher AS app_developer,
				p.application_icon_url AS app_icon,
				p.price AS app_price,
				p.file_size AS app_filesize,
				p.buy_url AS app_buy_url,
				p.download_url AS app_download, 
				p.description AS app_desc,  
				p.screenshot_url AS app_screenshot,
				p.os AS operating_system,
				p.install_support AS install_support, 
				p.release_status AS release_status,
				p.program_version as program_version,
				p.release_date AS release_date,
				p.date_added AS date_added,
				p.category AS category,
				p.downloaded AS downloaded
				FROM odb_product_item p
				WHERE 0=0 AND p.enable = '1' AND p.ceo_url_category = '$cat' AND p.ceo_url_name = '$name' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
		
	function getSoftwareList($data=NULL)
	{ 		
		$query1 = (empty($data['cat'])   )? "" : "AND p.ceo_url_category = '{$data['cat']}'";
		$query2 = (empty($data['title']) )? "" : "AND p.name LIKE '{$data['title']}%'";
		$query3 = (empty($data['pub'])   )? "" : "AND p.publisher = '{$data['pub']}'"; 
		$query4 = (empty($data['text'])  )? "" : "AND p.name LIKE '%{$data['title']}%'"; 
		$query5 = (empty($data['subcat']))? "" : "AND p.ceo_url_program_category_class LIKE '%{$data['subcat']}%'"; 
		$query6 = (empty($data['filesize']))? "" : "AND p.file_size BETWEEN {$data['filesize']}";
		$query8 = (empty($data['keyword']))? "" : "AND keywords LIKE '%{$data['keyword']}%'";
		
		if(isset($data['sprice']))
		{
			$query7 = "AND p.price BETWEEN {$data['sprice']} AND {$data['eprice']}"; 
		}		
		
		$sort 	= (empty($data['sort']))? "p.name ASC" : "p.{$data['sort']} ASC";
		if( !empty($data['sortby']) )
		{
			$count      = ", count(p.id) as cunt";
			$sort 		= "cunt ASC";
			$innerStr 	= "LEFT JOIN odb_product_{$data['sortby']} d ON p.id = d.product_id";
		}		
		
		$sql = "SELECT 
				p.id AS id, 
				p.name AS title,
				p.ceo_url_name AS url_title,
				p.summary_80 AS app_summary, 
				p.publisher_url AS app_website,
				p.publisher AS app_developer,
				p.application_icon_url AS app_icon,
				p.price AS app_price,
				p.file_size AS app_filesize,
				p.buy_url AS app_buy_url,
				p.download_url AS app_download,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category
				$count
				FROM odb_product_item p 
				$innerStr
				WHERE 0=0 AND p.enable = '1' AND p.category != '' $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 GROUP BY p.id ORDER BY $sort";
		return parent::executeQuery($sql, true);
	}
	
	function getSoftwareBySubcategory($data=NULL)
	{ 	
		$query1 = (empty($data['cat']))? "" : "AND p.category = '{$data['cat']}'";
		
		$sort 	= (empty($data['sort']))? "p.name ASC" : "p.{$data['sort']} ASC";
		if( !empty($data['sortby']) )
		{
			$count      = ", count(p.id) as cunt";
			$sort 		= "cunt ASC";
			$innerStr 	= "LEFT JOIN odb_product_{$data['sortby']} d ON p.id = d.product_id";
		}	
		
		$sql = "SELECT 
				p.id AS id, 
				p.name AS title,
				p.ceo_url_name AS url_title,
				p.summary_80 AS app_summary, 
				p.publisher_url AS app_website,
				p.publisher AS app_developer,
				p.application_icon_url AS app_icon,
				p.price AS app_price,
				p.file_size AS app_filesize,
				p.buy_url AS app_buy_url,
				p.download_url AS app_download,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category,
				p.program_category_class AS program_category_class
				$count
				FROM odb_product_item p
				$innerStr
				WHERE 0=0 AND p.enable = '1' AND p.ceo_url_category = '{$data['cat']}' 
						  AND p.ceo_url_program_category_class LIKE '%{$data['sub_cat']}%' GROUP BY p.id ORDER BY $sort";
		return parent::executeQuery($sql, true);
	}
	
	function getLatestSoftware($limit=10, $featured=false)
	{
		$featured = (!empty($featured))? "AND featured = '1'" : "" ;
		$sql = "SELECT 
				p.id AS id, 
				p.name AS title,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category,
				p.program_category_class AS program_category_class,
				p.ceo_url_name AS url_title,
				p.summary_80 AS app_summary,
				p.summary AS title_summary, 
				p.price AS app_price,
				p.file_size AS app_filesize,
				p.buy_url AS app_buy_url,
				p.download_url AS app_download
				FROM odb_product_item p WHERE 0=0 AND p.enable = '1' AND p.category != '' $featured ORDER BY p.release_date DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function featuredSoftware($limit=3)
	{
		$sql = "SELECT 
				p.id AS id, 
				p.name AS title,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category,
				p.program_category_class AS program_category_class,
				p.ceo_url_name AS url_title,
				p.summary_80 AS app_summary,
				p.summary AS title_summary, 
				p.price AS app_price,
				p.file_size AS app_filesize,
				p.buy_url AS app_buy_url,
				p.download_url AS app_download
				FROM odb_product_item p WHERE 0=0 AND p.enable = '1' AND p.category != '' AND featured = '1' ORDER BY RAND() LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getSoftwareForPublisher($publisher)
	{
		$sql = "SELECT 
				p.id AS id, 
				p.name AS title,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category,
				p.ceo_url_name AS url_title
				FROM odb_product_item p WHERE 0=0 AND p.enable = '1' AND publisher = \"$publisher\"";
		return parent::executeQuery($sql, true);
	}
	
	function getPopularDownload($limit=10)
	{
		$sql = "SELECT 
				count(d.product_id) AS count,
				p.id AS id, 
				p.name AS title,
				p.category AS category,
				p.ceo_url_category AS ceo_url_category,
				p.ceo_url_name AS url_title
				FROM odb_product_item p 
				INNER JOIN odb_product_downloads d ON p.id = d.product_id
				WHERE 0=0 AND p.enable = '1' GROUP BY product_id ORDER BY count DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getDownloadCount($id)
	{
		$sql = "SELECT count(id) AS downloadcount FROM odb_product_downloads WHERE product_id = '$id'";
		return parent::executeQuery($sql, false);
	}
	function getViewCount($id)
	{
		$sql = "SELECT count(id) AS viewcount FROM odb_product_view WHERE product_id = '$id'";
		return parent::executeQuery($sql, false);
	}
	
	function getProductRating($id)
	{
		$sql = "SELECT COUNT(id) AS count, SUM(rating) AS sum FROM odb_product_rate WHERE product_id = '$id'";
		return parent::executeQuery($sql, false);
	}
	
	function getContentPage($page)
	{
		$sql = "SELECT title, detail FROM odb_content WHERE 0=0 AND ceo_url_name = '$page' LIMIT 1";
		return parent::executeQuery($sql, false);
	}

	function getCategory($limit=NULL)
	{
		$limit   = (empty($limit))?   "10"    : $limit;
		$sql = "SELECT category, ceo_url_category FROM odb_product_item WHERE category != '' GROUP BY category ORDER BY category LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getNewsCategory($limit=NULL)
	{
		$limit  = (empty($limit))? "10" : $limit;
		$sql 	= "SELECT id, cat_name, cat_url_title FROM odb_categories WHERE 0=0 ORDER BY cat_order LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function printSubCategories($cat_id)
	{
		$sql = "SELECT program_category_class, ceo_url_program_category_class FROM odb_product_item WHERE ceo_url_category = '$cat_id' GROUP BY program_category_class";
		$rs = parent::executeQuery($sql, true);
		$seperator = NULL;	
		
		if(!empty($rs))
		{
			echo "<ul class='subCat'>";
			$i=0;
			foreach($rs as $row)
			{
				$str = explode("::", $row['program_category_class']);
				if(!empty($str[1]))  
				{
					$seperator = " &bull; ";
					echo "<li>$seperator<a href='". DOMAIN."software/$cat_id/{$row['ceo_url_program_category_class']}/'>{$str[1]}</a></li>";
					$i++;
				}
			}
			echo "</ul><div class='clear'></div>";
		}
		else
		{
			echo "<div class='clear'></div>";
		}
	}
	
	function getSoftwareSubCategories($id)
	{
		$sql = "SELECT program_category_class, ceo_url_program_category_class FROM odb_product_item WHERE ceo_url_category = '$id' GROUP BY program_category_class";
		return parent::executeQuery($sql, true);
	}	
	##############################################################################
	function getLatestNews($limit=10)
	{
		$sql = "SELECT c.cat_name AS category, c.cat_url_title, n.id, n.title, n.detail, n.date_added FROM odb_news n
				INNER JOIN  odb_categories c ON c.id = n.category_id
				WHERE n.enable = '1'
				ORDER BY n.date_added DESC LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	/*function getNewsListing()
	{
		$sql = "SELECT 
				wd.entry_id AS id, 
				wt.title AS title,
				wt.url_title AS url_title,
				wt.entry_date AS entry_date,
				wd.field_id_2 AS body, 
				c.cat_id AS cat_id,
				c.cat_name AS category,
				c.cat_url_title AS cat_url_title
				FROM exp_weblog_data wd
				LEFT JOIN exp_weblog_titles wt ON wd.entry_id  = wt.entry_id
				LEFT JOIN exp_category_posts cp ON wd.entry_id = cp.entry_id
				LEFT JOIN exp_categories c ON cp.cat_id = c.cat_id
				LEFT JOIN exp_weblogs w ON wd.weblog_id = w.weblog_id
				WHERE 0=0 
				AND w.blog_name = 'news' 
				AND wt.status = 'open'
				GROUP BY title ORDER BY wt.entry_date DESC";
		return parent::executeQuery($sql, true);
	}*/
	
	function getNewsByCategory($cat, $limit=NULL)
	{
		$limit = (!empty($limit))? "LIMIT $limit" : "" ;
		
		$sql = "SELECT c.id AS cat_id, c.cat_name AS category, c.cat_url_title, n.id, n.title, n.detail, n.date_added FROM odb_categories c
				INNER JOIN odb_news n ON c.id = n.category_id
				WHERE c.cat_url_title = '$cat' AND enable = 1
				ORDER BY n.date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getNews($cat, $id)
	{	
		$sql = "SELECT c.id AS cat_id, c.cat_name AS category, c.cat_url_title, n.id, n.title, n.detail, n.date_added FROM odb_categories c
				INNER JOIN odb_news n ON c.id = n.category_id
				WHERE c.cat_url_title = '$cat' AND n.id = '$id' AND enable = '1'";
		return parent::executeQuery($sql, false);
	}
	
	function getBanner($data)
	{	
		$query1 = ($data['sortby'] == "advertiser")? "ORDER BY b.advertiser {$data['ord']}" : "ORDER BY b.date_added {$data['ord']}" ;
		$query2 = (empty($data['banner_type']))? "" : "AND b.banner_type_id = '{$data['banner_type']}'" ;
		
		$sql = "SELECT bt.size, b.* FROM od_banner_ads b
				INNER JOIN odb_ads_type bt ON b.banner_type_id = bt.id WHERE 0=0 $query2 $query1 ";
		return parent::executeQuery($sql, true);
	}
	
	function getPageBanner($type, $limit=1)
	{	
		$sql = "SELECT b.banner_code FROM od_banner_ads b WHERE 0=0 AND b.banner_type_id = '$type' LIMIT $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getProductReviews($id, $section, $limit=NULL)
	{	
		$limit = (!empty($limit))? "LIMIT $limit" : "" ;
		$sql = "SELECT name, comment, date_added FROM odb_product_review WHERE enable = '1' AND item_id = '$id' AND section = '$section' ORDER BY date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getLatestReviews($limit=NULL)
	{	
		$limit = (!empty($limit))? "LIMIT $limit" : "" ;
		$sql = "SELECT c.name, c.comment, c.date_added, p.name AS product, ceo_url_category, ceo_url_name FROM odb_product_review c
				INNER JOIN odb_product_item p ON c.item_id = p.id
				WHERE c.enable = '1' ORDER BY c.date_added DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function isPad($URL)
	{
		$sql = "SELECT count(id) AS cnt FROM odb_product_item WHERE xml_file_url = '$URL'";
		$rs =  parent::executeQuery($sql, false);
		if(empty($rs['cnt'])){ return false; }else{ return true; }
	}
	
	################-----ADMIN----#######################
	function searchSoftware($data=NULL)
	{ 
		$query1 = (empty($data['name']    ))? "" : "AND p.name LIKE '%{$data['name']}%'";
		$query2 = (empty($data['category']))? "" : "AND p.ceo_url_category = '{$data['category']}'";
		$order 	= (empty($data['ord']     ))? "" : "ORDER BY p.name {$data['ord']}";
		
		$sql = "SELECT p.id, p.name, p.enable, p.featured, p.category FROM odb_product_item p WHERE 0=0 $query1 $query2 $order";
		if(!empty($data['enable']))
		{
			$sql = "SELECT p.id, p.name, p.enable, p.featured, p.category FROM odb_product_item p WHERE p.enable= '0' $query1 $query2 ORDER BY date_added";
		}
		if(!empty($data['featured']))
		{
			$sql = "SELECT p.id, p.name, p.enable, p.featured, p.category FROM odb_product_item p WHERE p.featured= '1' $query1 $query2 ORDER BY date_added";
		}
		
		return parent::executeQuery($sql, true);
	}
	
	function searchNews($data=NULL)
	{ 
		$ord    = $data['ord'];
		$query1 = (empty($data['title']      ))? "" : "AND p.title LIKE '%{$data['title']}%'";
		$query2 = (empty($data['category_id']))? "" : "AND p.category_id = '{$data['category_id']}'";
		$query3 = (empty($data['acc_id'])     )? "" : "AND p.account_id = '{$data['acc_id']}'"; 
		$order 	= ($data['sortby']=="title"   )? "ORDER BY p.title $ord" : "ORDER BY p.date_added $ord";

		$sql = "SELECT p.id, p.title, p.enable, p.date_added, c.cat_name AS category FROM odb_news p 
				INNER JOIN odb_categories c ON c.id = p.category_id
				WHERE 0=0 $query1 $query2 $query3 $order";
		return parent::executeQuery($sql, true);
	}
	
	function searchReviews($data=NULL)
	{
		$ord 	= ($data['ord'] == "asc"  )? "asc" : "desc";
		$order 	= (empty($data['sortby']) )? "ORDER BY p.date_added $ord" : "ORDER BY p.{$data['sortby']} $ord";
		$query1	= (empty($data['section']))? "" : "AND section = '{$data['section']}'" ;
		$query2	= (empty($data['text'])   )? "" : "AND comment LIKE '%{$data['text']}%' OR name LIKE '%{$data['text']}%'" ;
		
		$sql = "SELECT p.id, p.name, p.comment, p.enable, p.section, p.date_added FROM  odb_product_review p WHERE 0=0 $query1 $query2 $order";
		return parent::executeQuery($sql, true);
	}
	
	function addToNewsLetter($email)
	{	
		$sql = "INSERT INTO newsletterlist VALUES('', '$email')";	
		return parent::executeNoneQuery($sql);
	}
	
	function getEmailList()
	{	
		$sql = "SELECT email FROM newsletterlist GROUP BY email";	
		return parent::executeQuery($sql, true);
	}
}
?>