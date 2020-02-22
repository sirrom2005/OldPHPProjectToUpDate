<?php
/*
* Company: Au-Fait Esolutions
* Name: Rohan Morris
* Date: 20/2/2006
* Note: Common function use for the site
*/

class common
{
	var $db;
	
	function common( $dns )
	{
		$this->db = $dns;
			
		if(!$this->db)			
		{
			die("Failed to connect to database.");			
		}	
	}
	
	function getlistForHtmlControl( $table, $idColumn, $nameColumn )
	{
		$sql = "SELECT $idColumn, $nameColumn FROM $table";
		$result = $this->db->query($sql);
		
		if (DB::isError($result))
            return false;
			
		$i=0;
		while ($r = $result->fetchRow())
        {
			$row[$r[$idColumn]] = $r[$nameColumn];
        } 

        return $row;
	}
	
	
	function getAllRecordFrmThisTable( $thisTable, $orderBy="", $queryField="", $query="" )
	{
		/* Qurey to retrive records from a gevin table name */
		
		$queryStr = ( empty($query) )? "" : "WHERE $queryField $query" ;
		$orderByStr = ( empty($orderBy) )? "" : "ORDER BY $orderBy ASC" ;
		$sql = "SELECT * FROM $thisTable $queryStr $orderByStr";	

		return $this->ExecuteQuery($sql, true);
	}
	
	function insertNewRecord( $table, $data )
	{
		$fieldName = "id ";
		$values = "' '";
		foreach( $data as $key => $value )
		{
			$fieldName 	= $fieldName.",$key ";
			$values 	= $values.",'$value' "; 
		}
		
		$sql = "INSERT INTO $table ( $fieldName ) VALUES ( $values )";

		return $this->ExecuteNonQuery($sql);
	}
	
	
	function updateRecord( $table, $data, $id )
	{
		$updateStr = "id = '$id'";
		foreach( $data as $key => $value )
		{
			$updateStr  = $updateStr.", $key = '$value'"; 
		}
		
		$sql = "UPDATE $table SET
				$updateStr
				WHERE id = '$id'";

		return $this->ExecuteNonQuery($sql);
	}
	
	
	function deleteRecord( $table, $id )
	{
		$sql = "DELETE FROM $table WHERE id = '$id'";
		return $this->ExecuteNonQuery($sql);
	}
	
	function uploadFile( $controlName, $saveAsPath, $rename="", $fileType )
	{
		/* Function name uploadFile
		 * ( <name of the html control for uploading a file>, <saveAsPath- the location to save the uploaded file>, 
		 *   <set to NULL if you want to keep the orginal file name>, an array of the accepted files )
		 *  Upload a file to folder and return the name of the file if sucessfull.
		 */
	
		$tmpFileName 	= $_FILES[$controlName]['tmp_name'];
		$fileName 		= $_FILES[$controlName]['name'];
		$ext 			= explode(".",$fileName);
		$fileExt 		= NULL;
		
		if( !empty($fileType))
		{
			foreach( $fileType as $type )
			{
				$fileExt = $fileExt." [ $type ]"; 
			} 
		}
		else
		{
			exit("<center><b>File type allowed $fileExt only</b></center>");
			return false;
		}

	 	if( in_array( strtolower($ext[1]), $fileType ) )
		{
			if( !empty($rename) )
			{
				$uniq 		= rand(101,999);
				$fileName 	= $rename.date("d").date("m").date("y").$uniq.".".$ext[1];
			}
			
			$saveFileTo	= $saveAsPath."/".$fileName;
			
			if( is_uploaded_file($tmpFileName) )
			{					
				if( copy( $tmpFileName, $saveFileTo ) )
				{				
					return $fileName;
				}
				else
				{
					echo("<center><b>Fail in copying file to server.</b></center>");
					return false;
				}
			}
			else
			{
				echo("<center><b>File not uploaded</b></center>");
				return false;
			}
		}
		else{
			exit("<center><b>File type allowed $fileExt only</b></center>");
			return false;
		}			
	}
	
	function login( $user, $password )
	{
		 $sql = "SELECT * FROM admin 
		 WHERE 0=0
		 AND user = '$user' 
		 AND password = '$password' 
		 AND active = '1'"; 
		 return $this->ExecuteQuery($sql, false);
	}

	function ExecuteNonQuery($sql)
    { 
        $result = $this->db->query($sql);

        if (DB::isError($result))
        {
            echo "<pre>";
            print_r($result);
            return false;
        } 
        return true;
    }
	
	
	function ExecuteQuery($sql, $ReturnArray = false)
    { 
        $result = $this->db->query($sql);

        if (DB::isError($result))
        {
            echo "<pre>";
            print_r($result);
            return false;
        } 

        if ($ReturnArray)
        {
            while ($row = $result->fetchRow())
            {
                $res[] = $row;
            } 
        } 
        else
        {
            $res = $result->fetchRow();
        } 
        return $res;
    } 
}

?>
