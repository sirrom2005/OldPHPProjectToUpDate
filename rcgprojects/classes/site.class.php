<?php

	class site
	{
		var $db;
	
		function site( $dns )
		{
			$this->db = $dns;
				
			if(!$this->db)			
			{
				die("Failed to connect to database.");			
			}	
		}
		
		function getLatestProject()
		{
			$sql = "SELECT * FROM projects ORDER BY date DESC limit 4";
			return $this->ExecuteQuery($sql, true);
		}
		
		/*function getAllProject()
		{
			$sql = "SELECT * FROM projects ORDER BY date DESC";
			return $this->ExecuteQuery($sql, true);
		}*/
		
		function getAllProject()
		{ 
			$sql = "SELECT * FROM projects ORDER BY date DESC ";
			$result = $this->db->query($sql);
		
			if (DB::isError($result))
				return false;
				
			echo "<script language='javascript'> var tmpPorImag = new Array(); "; 
			$i=0;
			$img=0;
			while ($r = $result->fetchRow())
			{
				$row[$r['p_type']][$i]['title'] = $r['title'];
				$row[$r['p_type']][$i]['id']    = $r['id'];
				$row[$r['p_type']][$i]['image'] = $r['image'];
				
				if( !empty($row[$r['p_type']][$i]['image']) )
				{
					echo "tmpPorImag[$img] = new Image(); ";
					echo "tmpPorImag[$img].src = 'images/projects/".$row[$r['p_type']][$i]['image']."'; ";
					$img++;
				}
				
				$i++;
			} 
			echo "</script>";
			
			return $row;
		}
		
		function getAllProspects()
		{
			$sql = "SELECT * FROM prospects ORDER BY date DESC";
			return $this->ExecuteQuery($sql, true);
		}
		
		function getProjectBanner( $id )
		{
			$sql = "SELECT p.banner FROM  projects p WHERE p.id = '$id'";
			return $this->ExecuteQuery($sql, false);
		}
		
		function getProjectBySection( $id )
		{
			$sql = "SELECT pt.project_type, p.id, p.title FROM  projects p 
					INNER JOIN project_type pt ON p.p_type = pt.id
					WHERE pt.id = '$id' ";
			return $this->ExecuteQuery($sql, true);
		}
		
		function getAllNews()
		{
			$sql = "SELECT * FROM news ORDER BY date DESC";
			return $this->ExecuteQuery($sql, true);
		}
		
		function getFeaturedProject()
		{
			$sql = "SELECT * FROM projects WHERE featured = '1' AND image != '' ORDER BY RAND() limit 2";
			return $this->ExecuteQuery($sql, true);
		}
		
		
		function getImageByProject( $id )
		{
			$sql = "SELECT * FROM gallery WHERE project_id = '$id' ";
			return $this->ExecuteQuery($sql, true);
		}
		
		
		function getTopNews( )
		{
			$sql = "SELECT * FROM news ORDER BY date DESC LIMIT 3";
			return $this->ExecuteQuery($sql, true);
		}
		
		function searchNews( $text )
		{
			$sql = "SELECT id, title, details from news WHERE title LIKE '%$text%' OR details LIKE '%$text%'";
			return $this->ExecuteQuery($sql, true);
		}
		
		function searchproject( $text )
		{
			$sql = "SELECT id, title, details from projects WHERE title LIKE '%$text%' OR details LIKE '%$text%'";
			return $this->ExecuteQuery($sql, true);
		}
		
		function searchContent( $text )
		{
			$sql = "SELECT section, title, details from content WHERE section LIKE '%$text%' OR title LIKE '%$text%' OR details LIKE '%$text%'";
			return $this->ExecuteQuery($sql, true);
		}
		
		
		function getProjectTypeList( )
		{
			$sql = "SELECT pt.*, p.image AS proImage, p.id as proId FROM  projects p 
					INNER JOIN project_type pt ON p.p_type = pt.id
					WHERE p.image <> '' GROUP BY pt.project_type";
				
			return $this->ExecuteQuery($sql, true);
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