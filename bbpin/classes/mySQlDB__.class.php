 <?php
	/* Company: Nova-Labs
	 * File Name: mySqlyDB__.class.php
	 * Date: 06/25/2008
	 * Author:Rohan Morris
	 * Description: Main class for connecting to MysSql database and executing SQL query
	 */
	include_once("functions.php");
	class mySqlDB
	{
		var $db;
		var $dbUser;
		var $dbDataBase;
		var $dbPass;
		var $dbHost;
		
		function mySqlDB()
		{
			$this->start();
		}
		
		function start()
		{			
			$this->dbDataBase 	= DBDATABASE;
			$this->dbUser 		= DBUSERNAME;
			$this->dbPass 		= DBPASSWORD;
			$this->dbHost 		= DBHOST;	
			
			$this->db_connect();
			$this->select_db();
		}
		
		function executeQuery( $sql, $resultSet=true )
		{
			/*
			 * Return a result set
			 * $resultSet = true will return all rows
			 * $resultSet = false will return only a single rows
			*/
			$dbResult = mysql_query($sql, $this->db);
			if(!$dbResult)
			{ 
				/*sql failed error*/
				die( "<p>&nbsp;</p><p align='center'><a href='{$_SERVER['REQUEST_URI']}'><img src='".DOMAIN."images/server_error.jpg' alt='server error' /></a></p>" );
				return false;
			}
			
			$data = NULL;
			if($resultSet)
			{ 
				/*return a result set of the query string*/
				$i=0;
				while( $row = mysql_fetch_assoc($dbResult) )
				{
					$data[$i] = $row;
					$i++;
				}
			}
			else
			{
				/*return a single row of record*/
				$data = mysql_fetch_assoc($dbResult);
			}
						
			return $data;
		}
		
		function executeNoneQuery( $sql )
		{
			$dbResult = mysql_query($sql, $this->db) ;
			
			if($dbResult)
			{
				return true;
			}
			else
			{
				echo( "SQl command Error...<br>".mysql_error() );
			}
			return false;
		}
		
		
		function select_db()
		{
			$rs = @mysql_select_db($this->dbDataBase);
			if(!$rs)
			{
				die( "<style>body{background-color:#000; padding-top:10%; text-align:center;}</style><img src='images/under-construction.jpg'/>" );
			}
		}
		
		function db_connect()
		{ 
			$conn = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPass );
			if(!$conn)
			{
				die( "<style>body{background-color:#000; padding-top:10%; text-align:center;}</style><img src='images/under-construction.jpg'/>" );
			} 
			$this->db = $conn;
		}
		
		function db_close()
		{
			@mysql_close($this->db);
		}
	}
?>