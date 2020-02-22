<?php
	/* Company: Gleaner
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
		var $spanstyle = "border:solid 1px #CCCCCC;background-color:#eff4fc;color:#333333;padding:5px;font-weight:bold;display:block;text-align:center;color:#f00;margin:10% 20%;";
		
		function mySqlDB()
		{
			$this->__construct();
		}
		
		function __construct()
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
				die( "<span style='$this->spanstyle'>Error in getting resource...go to <a href='http://www.videouploader.net/'>home</a></span>" );
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
				echo( "<span style='$this->spanstyle'>Command failed...<span>".mysql_error() );
			}
			return false;
		}
		
		
		function select_db()
		{
			$rs = @mysql_select_db($this->dbDataBase);
			if(!$rs)
			{
				die( "<span style='$this->spanstyle'>Resource not found...</span>");
			}
		}
		
		function db_connect()
		{ 
			$conn = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPass );
			if(!$conn)
			{
				die( "<span style='$this->spanstyle'>Connection lost, please <a href='#' onclick='window.reload;'>try again</a>...or visit <a href='http://www.videouploader.net/'>home page</a></span>" );
			} 
			$this->db = $conn;
		}
		
		function db_close()
		{
			@mysql_close($this->db);
		}
	}
?>