<?php
class blog extends mySqlDB
{	
	var $blogBd = "";
	
	function blog(){ parent::mySqlDB(); }
	
	function getHeadlines()
	{
		$sql = "SELECT p.post_title, p.post_content, p.guid FROM {$this->blogBd}.wp_posts p
				INNER JOIN {$this->blogBd}.wp_term_relationships r ON r.object_id = p.ID
				INNER JOIN {$this->blogBd}.wp_term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id
				INNER JOIN {$this->blogBd}.wp_terms ts ON ts.term_id = t.term_id
				WHERE ts.slug = 'news' AND post_status = 'publish' AND post_type = 'post' 
				GROUP BY p.post_title ORDER BY p.post_date DESC LIMIT 4";
		return parent::executeQuery($sql, true);
	}
	
	function getFotterNewsList()
	{
		$sql = "SELECT p.post_title, p.guid FROM {$this->blogBd}.wp_posts p
				INNER JOIN {$this->blogBd}.wp_term_relationships r ON r.object_id = p.ID
				INNER JOIN {$this->blogBd}.wp_term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id
				INNER JOIN {$this->blogBd}.wp_terms ts ON ts.term_id = t.term_id
				WHERE ts.slug = 'news' AND post_status = 'publish' AND post_type = 'post' 
				GROUP BY p.post_title ORDER BY p.post_date DESC LIMIT 11"; 
		return parent::executeQuery($sql, true);
	}
}
?>