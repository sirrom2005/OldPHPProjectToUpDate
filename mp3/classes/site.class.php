<?php 
class site extends mySqlDB
{	
	function site(){ parent::mySqlDB(); }
	function emailLookUp($email)
	{				
		$sql = "SELECT email FROM odb_account WHERE email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function addMP3($data)
	{
		$producerId = $_SESSION['USER']['id']; 
		if(empty($data))
		{ return false; }
		
		$sql = "INSERT INTO odb_mp3 (id, title, filename, filesize, producer_id, date_added) VALUES 
				(\"\", \"{$data['title']}\", \"{$data['filename']}\", \"{$data['filesize']}\", \"$producerId\", now())";
		
		$rs = $this->executeNoneQuery( $sql );
		if(!$rs)
		{
			echo "Error in adding song.";
		}
		else
		{
			$id = mysql_insert_id();
			echo "<a href='index.php?action=edit_music&id=$id'>{$data['title']}</a><br/>";
		}
	}
	
	function getProducerList()
	{				
		$sql = "SELECT id,fname,mname,lname,bio FROM odb_account WHERE 	account_type='2'";
		return parent::executeQuery($sql, true);
	}
	function getMP3ByProducerId($id)
	{				
		$sql = "SELECT * FROM odb_mp3 WHERE producer_id = '$id' ORDER BY date_added DESC";
		return parent::executeQuery($sql, true);
	}
	function getArtiste()
	{				
		$sql 		= "SELECT id, stagename FROM odb_artistes ORDER BY stagename";
		$dbResult 	= mysql_query($sql, $this->db);
		$data 		= array();
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['id']] = $row['stagename'];
			}
			return $data;
		}
		return false;	
	}
	
	function getRandArtiste()
	{				
		$sql = "SELECT id, stagename, bio, photo FROM odb_artistes WHERE photo != '' ORDER BY RAND() LIMIT 1";
		return parent::executeQuery($sql, false);	
	}
	
	function getArtisteInfo($id)
	{				
		$sql = "SELECT * FROM odb_artistes WHERE id = '$id'";
		return parent::executeQuery($sql, false);	
	}
	function updateMusicRecord($rs,$id)
	{			
		$values = "";
		$sql = "UPDATE odb_mp3 set  title = \"{$rs['title']}\", 
									detail = \"{$rs['detail']}\", 
									keywords = \"{$rs['keywords']}\", 
									riddim_id = \"{$rs['riddim_id']}\", 
									label = \"{$rs['label']}\", 
									credit_amount = \"{$rs['credit_amount']}\" 
									WHERE id = \"$id\"";
									
		if($this->executeNoneQuery($sql))
		{
			$sql = "DELETE FROM odb_mp3_artiste WHERE mp3_id = '$id'";
			if($this->executeNoneQuery($sql))
			{ 	
				foreach($rs['artiste'] as $key => $value)
				{
					$values .= "('','$id','$value'),";
				}
				$values .= "ENDZ";
				$values = str_replace(",ENDZ", "", $values);
				$sql = "INSERT INTO odb_mp3_artiste (id, mp3_id, artiste_id) VALUES $values";
				return $this->executeNoneQuery($sql);
			}
			else{return false;}
		}
		else{return false;}
	}
	function getArtisteByMusic($id)
	{				
		$sql = "SELECT a.artiste_id, ap.stagename FROM odb_mp3_artiste a 
				INNER JOIN odb_artistes ap ON a.artiste_id = ap.id
				WHERE a.mp3_id = '$id'";
		$data = NULL;
		$dbResult = mysql_query($sql, $this->db);
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['artiste_id']] = $row['stagename'];
			}
			return $data;
		}
		return false;	
	}
	###########################MAIN SITE#################################
	/*function getFeaturedTunes($limit=NULL)
	{
		$limit = (empty($limit))? "" : "limit $limit";
		$sql = "SELECT id,title,credit_amount FROM odb_mp3 WHERE featured = '1' $limit";
		return parent::executeQuery($sql, true);	
	}
	
	function getNewRelease($limit=NULL)
	{
		$limit = (empty($limit))? "" : "limit $limit";
		$sql = "SELECT id,title,credit_amount FROM odb_mp3 ORDER BY date_added $limit";
		return parent::executeQuery($sql, true);	
	}
	
	function getLatestNews($limit=NULL)
	{
		$limit = (empty($limit))? "" : "limit $limit";
		$sql = "SELECT * FROM odb_news ORDER BY date_added $limit";
		return parent::executeQuery($sql, true);	
	}
	function getCartItems($data)
	{
		$id = "-1";
		foreach($data as $key => $value){$id .= ",$value";}
		//$sql = "SELECT id,title,credit_amount FROM odb_mp3 WHERE id IN ($id)";
		
	$sql = "SELECT mp3.id, art.stagename, mp3.title, mp3.label, mp3.filename, mp3.credit_amount, art.photo, 
			r.name AS riddim, acc.fname AS producerfname, acc.mname AS producermname, acc.lname AS producerlname 
			FROM odb_mp3 mp3
			LEFT JOIN odb_riddims r ON mp3.riddim_id = r.id
			INNER JOIN odb_mp3_artiste mpa ON mp3.id = mpa.mp3_id
			INNER JOIN odb_artistes art ON mpa.artiste_id = art.id
			INNER JOIN odb_account acc ON mp3.producer_id = acc.id
			WHERE 0=0 AND mp3.id IN ($id)
			GROUP BY mp3.title";
		return parent::executeQuery($sql, true);	
	}*/		
	function buyMp3($id)
	{ 
		$sql 			= "SELECT SUM(credit_amount) AS costTotal FROM odb_mp3 WHERE id = '$id'";
		$cost 			= parent::executeQuery($sql, false);
		$costTotal 		= (int)$cost['costTotal'];
	
		$sql			= "SELECT credit_amount FROM odb_account WHERE id = '".$_SESSION['USER']['id']."'";
		$credit 		= parent::executeQuery($sql, false);
		$myCreditAmount = (int)$credit['credit_amount'];
	
		if( $costTotal > $myCreditAmount              ){exit("Not enough credit to complete purchase.");}
		if(empty($costTotal) || empty($myCreditAmount)){exit("<span class='fberr'>System error [001] please try again later.</span>");}

		$sql = "UPDATE odb_account set credit_amount = credit_amount - $costTotal WHERE id = '".$_SESSION['USER']['id']."'";	
		if($this->executeNoneQuery($sql))
		{
			$sql = "INSERT INTO odb_transaction (id, mp3_id, user_id, date, credit_amount) VALUES ('', $id, '".$_SESSION['USER']['id']."', now(), '$costTotal')";
			if($this->executeNoneQuery($sql))
			{
				if(mysql_affected_rows()>0)
				{
					/*GOOD*/
					$_SESSION['USER']['credit_amount'] = $myCreditAmount - $costTotal;
					exit("{$_SESSION['USER']['credit_amount']}");
				}
				exit("<span class='fberr'>System error [003] please try again later.</span>");
			}
		}
		exit("<span class='fberr'>System error [002] please try again later.</span>");
	}
	
	function getMyMusic($id)
	{
		$sql = "SELECT mp3.id, art.stagename, mp3.title, mp3.label, mp3.filename, mp3.credit_amount, art.id AS artId, art.photo, art.stagename,
				r.name AS riddim, acc.fname AS producerfname, acc.mname AS producermname, acc.lname AS producerlname 
				FROM odb_mp3 mp3
				LEFT JOIN odb_riddims r ON mp3.riddim_id = r.id
				INNER JOIN odb_mp3_artiste mpa ON mp3.id = mpa.mp3_id
				INNER JOIN odb_artistes art ON mpa.artiste_id = art.id
				INNER JOIN odb_account acc ON mp3.producer_id = acc.id
				WHERE mp3.id IN (SELECT mp3_id FROM odb_transaction WHERE user_id = '$id' GROUP BY mp3_id) GROUP BY mp3.id";
		return parent::executeQuery($sql, true);
	}
	
	function addCredits($amt)
	{
		$sql = "UPDATE odb_account set credit_amount = credit_amount + $amt WHERE id = '".$_SESSION['USER']['id']."'";	
		if($this->executeNoneQuery($sql))
		{
			$sql = "SELECT credit_amount FROM odb_account WHERE id ='".$_SESSION['USER']['id']."'";
			return parent::executeQuery($sql, false);
		}
		return 0;
	}
/*	function getPurchaseHistory($id)
	{
		$time = time();
		$sql = "SELECT id,items,transaction_date FROM odb_transaction WHERE user_id ='$id' AND expire_date > '$time' ORDER BY id DESC";
		return parent::executeQuery($sql, true);	
	}
	function getPurchaseItem($item)
	{				
		$sql = "SELECT mp3.id, art.stagename, mp3.title, mp3.label, mp3.filename, mp3.credit_amount, art.photo, 
				r.name AS riddim, acc.fname AS producerfname, acc.mname AS producermname, acc.lname AS producerlname 
				FROM odb_mp3 mp3
				LEFT JOIN odb_riddims r ON mp3.riddim_id = r.id
				INNER JOIN odb_mp3_artiste mpa ON mp3.id = mpa.mp3_id
				INNER JOIN odb_artistes art ON mpa.artiste_id = art.id
				INNER JOIN odb_account acc ON mp3.producer_id = acc.id
				WHERE mp3.id IN ($item)
				GROUP BY mp3.title";
		return parent::executeQuery($sql, true);	
	}*/
	
	function searchMP3($data, $order=NULL, $limit=NULL)
	{
		$query1="";
		$query2="";
		$query3="";
		switch($data['opt'])
		{
			case "artise":
				$tableField = "art.stagename";
			break;
			case "title": 
				$tableField = "mp3.title";
			break;
			case "riddim":
				$tableField = "r.name";
			break;
			case "label":
				$tableField = "mp3.label";
			break;
			case "keywords":
				$tableField = "mp3.keywords";
			break;
			default:
				$tableField = "mp3.title";
			break;
		}
		$query1 = (!empty($data['s']))? "AND $tableField LIKE \"%{$data['s']}%\"" : "" ;

		if($data['opt']=="producer")
		{
			$query1  = "";
			$query2 = "AND acc.fname LIKE \"%{$data['s']}%\" OR acc.mname LIKE \"%{$data['s']}%\" OR acc.lname LIKE \"%{$data['s']}%\"";
		}
		
		$query3 = ($data['featured'] == "featured")? "AND mp3.featured = '1'" :"";
		
		$order = (empty($order))? "mp3.title" : $order;
		$limit = (empty($limit))? "" : "LIMIT $limit";
		$sql = "SELECT mp3.id, art.stagename, mp3.title, mp3.label, mp3.filename, mp3.credit_amount, art.id AS artId, art.photo, art.stagename,
				r.name AS riddim, acc.fname AS producerfname, acc.mname AS producermname, acc.lname AS producerlname 
				FROM odb_mp3 mp3
				LEFT JOIN odb_riddims r ON mp3.riddim_id = r.id
				INNER JOIN odb_mp3_artiste mpa ON mp3.id = mpa.mp3_id
				INNER JOIN odb_artistes art ON mpa.artiste_id = art.id
				INNER JOIN odb_account acc ON mp3.producer_id = acc.id
				WHERE 0=0 $query1 $query2 $query3
				GROUP BY mp3.title ORDER BY $order, mpa.artiste_id $limit";
		return parent::executeQuery($sql, true);	
	}
	
	function addTransaction($data)
	{ 
		
		$sql = "INSERT INTO odb_credit_purchase 
				( trans_date,trans_states,client_id,credit_amount,amount,ipaddress,transaction_code, order_id ) 
				VALUES 
				( NOW(), '{$data['trans_states']}', '{$_SESSION['USER']['id']}', '{$data['credit_amount']}', '{$data['card_amount']}', '{$data['ipaddress']}', '{$data['MErrMsg']}', '{$data['orderID']}' )";
		return $this->executeNoneQuery( $sql );
	}
	function getTransaction()
	{ 
		$sql = "SELECT t.*, a.fname, a.mname, a.lname FROM odb_credit_purchase t INNER JOIN odb_account a ON a.id = t.client_id";
		return parent::executeQuery($sql, true);
	}
	
	function getPageContent($page)
	{ 
		$sql = "SELECT * FROM odb_content WHERE page = '$page'";
		return parent::executeQuery($sql, false);
	}
	
	function getCreditPurchase()
	{ 
		$sql = "SELECT a.fname AS fullname, cp.* FROM odb_credit_purchase cp 
				INNER JOIN odb_account a ON a.id = cp.client_id
				WHERE 0=0 ORDER BY trans_date DESC";
		return parent::executeQuery($sql, true);
	}
	
	function addDownloadCount($id)
	{
		$sql = "UPDATE odb_mp3 SET downloaded = downloaded + 1 WHERE id = '$id'";	
		return $this->executeNoneQuery($sql);
	}
}
?>