<?php

class commonDB extends mySqlDB
{
	function commonDB()
	{
		parent::mySqlDB();
	}
	
	function getData( $tableName, $limit=NULL, $orderColumn=NULL, $orderDir = "ASC" )
	{	
		$orderStr = (!empty($orderColumn))? "ORDER BY $orderColumn $orderDir" : "";
		$limitStr = ( !empty($limit) )? " LIMIT $limit" : "" ;
		
		$sql = "SELECT * FROM $tableName $orderStr $limitStr"; 
		return parent::executeQuery($sql);
	}
	
	function getDataById( $tableName, $id )
	{			
		$sql = "SELECT * FROM $tableName WHERE id = '$id' LIMIT 1"; 
		return parent::executeQuery($sql, false);
	}
	
	function getHtmlListControlData( $tableName, $columnName, $columnId, $orderColumn=NULL, $orderDir = "ASC" )
	{	
		/* 
		 * This function return data to fill a HTML control ex. list box, check box, radio button.
		 * this function accepts the name of the table, the name of the column which will be display, and it's id.
		 * and optional [orderColumn] the column to sort the data by, and [orderDir] the direction eg [ASC/DESC]
		 */
		$orderStr = (!empty($orderColumn))? "ORDER BY $orderColumn $orderDir" : "";
		$sql = "SELECT tn.$columnName AS dataName, tn.$columnId AS dataKey from $tableName tn WHERE tn.$columnName != '' $orderStr"; 

		$dbResult = mysql_query($sql, $this->db);
	
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['dataKey']] = $row['dataName'];
			}
			return $data;
		}

		return false;		
	}
	
	function insertRecord( $DATA, $TABLE )
	{
		/*if( $_SESSION['admin']['user_type'] != 1 )
		{
			//$this->sendMail( "sirrom2005@gmail.com", NULL, "test", "send text" );
			$DATA['enable'] = 0;
		}
		unset($_SESSION['adminEmailMessage']);*/
		
		$insertValuesStr = "''";
		$coulumeNameStr =  "id";
		
		foreach( $DATA as $key => $value )
		{
			$insertValuesStr	= $insertValuesStr.", '".addslashes(trim($value))."'";
			$coulumeNameStr 	= $coulumeNameStr.", $key"; 
		}
			
		$sql = "INSERT INTO $TABLE ($coulumeNameStr) VALUES ( $insertValuesStr )"; 
		return $this->executeNoneQuery( $sql );
	}
	
	function updateRecord( $DATA, $TABLE, $id )
	{
		/*if( $_SESSION['admin']['user_type'] != 1 )
		{
			//$this->sendMail( "sirrom2005@gmail.com", NULL, "test", "send text" );
			$DATA['enable'] = 0;
		}
		unset($_SESSION['adminEmailMessage']);*/
		
		$updateStr = "id = '$id' ";
		
		foreach( $DATA as $key => $value )
		{
			$updateStr = $updateStr.", $key = '".addslashes(trim($value))."'" ;
		}
			
		$sql = "UPDATE $TABLE SET $updateStr WHERE id = '$id'";
		return $this->executeNoneQuery( $sql );
	}
	
	function deleteData( $tableName, $idColumn, $key )
	{
		$sql = "DELETE from $tableName WHERE $idColumn = $key "; 	
		$rs = parent::executeNoneQuery($sql);
		return $rs;
	}
	
	function enable()
	{	
		
	}
	
	function uploadFile( $fileName, $tempName, $location, $allowedFiles=NULL )
	{
		if(empty($tempName))
			return NULL;
			
		if(!empty($allowedFiles))
		{
			$ext = explode( ".", strtolower($fileName) );
			
			if( !in_array($ext[count($ext)-1], $allowedFiles) )
			{
				die( "[{$ext[count($ext)-1]}] File type not allowed. <a href='javaScript:history.back();'>Back</a>");
			}
		}
		
		$fileName = date("Ymd_").rand(10000, 99999).".".$ext[count($ext)-1];
			
		if( @is_uploaded_file( $tempName ) )
		{			
			if( !@move_uploaded_file($tempName, $location.$fileName) )
			{
				die("Error in copying uploaded file <a href='javaScript:history.back();'>Back</a>");
			}
		}
		else
		{
			die("Error in uploading file <a href='javaScript:history.back();'>Back</a>");
		}
		
		return $fileName;
	}
	
	function singleEnable( $tableName, $id )
	{		
		$sql = "UPDATE $tableName t SET t.enable = if( t.enable = '1', '0', '1') WHERE t.id = '$id' LIMIT 1"; 
		return $this->executeNoneQuery( $sql );
	}
	
	function singleFeatured( $tableName, $id )
	{		
		$sql = "UPDATE $tableName t SET t.featured = if( t.featured = '1', '0', '1') WHERE t.id = '$id' LIMIT 1";
		return $this->executeNoneQuery( $sql );
	}
	
	function singleBreakingNewsEnable( $tableName, $id )
	{		
		$sql = "UPDATE $tableName t SET t.breaking_new = if( t.breaking_new = '1', '0', '1') WHERE t.id = '$id' LIMIT 1";
		return $this->executeNoneQuery( $sql );
	}
	
	function deleteImage( $tableName, $columnName, $id, $location )
	{		
		$sql = "SELECT $columnName AS image FROM $tableName WHERE id = '$id' LIMIT 1";
		$name = parent::executeQuery($sql, false); 
	
		$sql = "UPDATE $tableName SET $columnName = '' WHERE id = '$id' LIMIT 1";
		if( $this->executeNoneQuery( $sql ) )
		{ 
			@unlink( $location.$name['image'] );
		}		
	}
	
	function assign_rand_value($num)
	{
	// accepts 1 - 36
	  switch($num)
	  {
		case "1":
		 $rand_value = "a";
		break;
		case "2":
		 $rand_value = "b";
		break;
		case "3":
		 $rand_value = "c";
		break;
		case "4":
		 $rand_value = "d";
		break;
		case "5":
		 $rand_value = "e";
		break;
		case "6":
		 $rand_value = "f";
		break;
		case "7":
		 $rand_value = "g";
		break;
		case "8":
		 $rand_value = "h";
		break;
		case "9":
		 $rand_value = "i";
		break;
		case "10":
		 $rand_value = "j";
		break;
		case "11":
		 $rand_value = "k";
		break;
		case "12":
		 $rand_value = "l";
		break;
		case "13":
		 $rand_value = "m";
		break;
		case "14":
		 $rand_value = "n";
		break;
		case "15":
		 $rand_value = "o";
		break;
		case "16":
		 $rand_value = "p";
		break;
		case "17":
		 $rand_value = "q";
		break;
		case "18":
		 $rand_value = "r";
		break;
		case "19":
		 $rand_value = "s";
		break;
		case "20":
		 $rand_value = "t";
		break;
		case "21":
		 $rand_value = "u";
		break;
		case "22":
		 $rand_value = "v";
		break;
		case "23":
		 $rand_value = "w";
		break;
		case "24":
		 $rand_value = "x";
		break;
		case "25":
		 $rand_value = "y";
		break;
		case "26":
		 $rand_value = "z";
		break;
		case "27":
		 $rand_value = "0";
		break;
		case "28":
		 $rand_value = "1";
		break;
		case "29":
		 $rand_value = "2";
		break;
		case "30":
		 $rand_value = "3";
		break;
		case "31":
		 $rand_value = "4";
		break;
		case "32":
		 $rand_value = "5";
		break;
		case "33":
		 $rand_value = "6";
		break;
		case "34":
		 $rand_value = "7";
		break;
		case "35":
		 $rand_value = "8";
		break;
		case "36":
		 $rand_value = "9";
		break;
	  }
	return $rand_value;
	}
	
	function get_rand_string($length)
	{
		if($length>0) 
		{ 
			$rand_id="";
			for($i=1; $i<=$length; $i++)
			{
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1,36);
				$rand_id .= $this->assign_rand_value($num);
			}
		}
		return $rand_id;
	}
	
}

?>
