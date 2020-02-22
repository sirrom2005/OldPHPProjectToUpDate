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
		$data = array();
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
		$updateStr = "id = '$id' ";
		
		foreach( $DATA as $key => $value ){
			$updateStr .= ", $key = \"$value\" " ;
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
}
?>