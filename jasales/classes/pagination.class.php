<?php
error_reporting(0);
class Pagination
{
	var $page;
	var $limit;
	var $totalRows;
	var $queryStr;
	var $showDropDownBox;
	var $a_Active_class;
	var $a_Inactive_class;
	var $next_prev_class_Active = "next_prev_class_Active";
	var $next_prev_class_InActive;
	var $first_last_class_Active = "next_prev_class_Active";
	var $first_last_class_InActive;
	var $drop_downbox_class;
	var $numberLinksToShow;
	var $cleanPagination;		
	var $numOfPages;
	var $showInactiveFirstLink;
	var $showInactiveLastLink;
	var $showInactivePrevLink;
	var $showInactiveNextLink;
	var $firstImage;
	var $lastImage;
	var $prevImage;
	var $nextImage;
	var $firstText;
	var $lastText;
	var $prevText;
	var $nextText;

	
	function Pagination($page,$limit,$totalrows,$qstr,$numlinks,$drop_box=false)
	{
		$this->page						= $page;
		$this->limit 					= $limit;
		$this->totalRows				= $totalrows;
		$this->queryStr					= $qstr;
		$this->showDropDownBox 			= $drop_box;
		$this->numberLinksToShow		= $numlinks;
		$this->cleanPagination  		= false;
		
		$this->setImages("","","","");
		$this->setText("First","Last","&laquo PREV","NEXT &#187;");
		$this->showLinksWhenInacive();

		//calculates the amount of pages this result has
		if($this->totalRows == 0 && $this->limit == 0)
			$this->numOfPages = 0;			
		else 
			$this->numOfPages = ceil($this->totalRows / $this->limit);
	}

	function showLinksWhenInacive($showInactiveFirstLink=true,$showInactiveLastLink=true,$showInactiveNextLink=true,$showInactivePrevLink=true)
	{
		$this->showInactiveFirstLink	= $showInactiveFirstLink;
		$this->showInactiveLastLink		= $showInactiveLastLink;
		$this->showInactiveNextLink		= $showInactiveNextLink;
		$this->showInactivePrevLink		= $showInactivePrevLink;	
	}
	
	function cleanPagination($boolValue)
	{
		$this->cleanPagination = $boolValue;
	}
	
	function setImages($firstImage,$lastImage,$prevImage,$nextImage)
	{
		$this->firstImage = $firstImage;
		$this->lastImage  = $lastImage;
		$this->prevImage  = $prevImage;
		$this->nextImage  = $nextImage;
	}
	
	function setText($firstText,$lastText,$prevText,$nextText)
	{
		$this->firstText = $firstText;
		$this->lastText  = $lastText;
		$this->prevText  = $prevText;
		$this->nextText  = $nextText;
	}
	
	//function used to setup the classes that will be used for the text/links
	function setClasses($pageNumActiveLinks="",$pageNumInActiveLinks="",$nextPrevActiveLinks="",$nextPrevInActiveLinks="",$firstLastActiveLinks="",$firstLastInActiveLinks="",$dropDownList="")
	{
		$this->a_Active_class 				= $pageNumActiveLinks;
		$this->a_Inactive_class 			= $pageNumInActiveLinks;
		$this->next_prev_class_Active 		= $nextPrevActiveLinks;
		$this->next_prev_class_InActive 	= $nextPrevInActiveLinks;
		$this->first_last_class_Active		= $firstLastActiveLinks;
		$this->first_last_class_InActive	= $firstLastInActiveLinks;
		$this->drop_downbox_class			= $dropDownList;
	}
	
	function getPageOfAmount($classToUse="")
	{
		if($this->numOfPages <= 0)
			return "";
			
	    $this->numOfPages = ceil($this->totalRows / $this->limit); 
	    
	    $classToUse   = (empty($classToUse)) ? "class=\"$this->a_Inactive_class\"" : $classToUse;
	    
	    $text  = "<font $classToUse>$this->page of $this->numOfPages pages</font>";
	    
	    return $text;
	}
	
	function getPrevLink($classToUseForActive="",$classToUseForInActive="")
	{
		if($this->numOfPages <= 0)
			return "";

		$display = (empty($this->prevImage)) ? $this->prevText : "<img src=\"$this->prevImage\">";
		
		if($this->page != 1)
		{ 
	        $pageprev = $this->page;
	        $pagenext = ($this->page - $this->numberLinksToShow);
			$pageprev--;
			
			$classToUseForActive   = (empty($classToUseForActive)) ? "class=\"$this->next_prev_class_Active\"" : $classToUseForActive;
						
	        $text = "<a href=\"$this->queryStr&page=$pageprev\" $classToUseForActive>$display</a>";
	    }
	    else if($this->showInactivePrevLink)
	    { 
	    	$classToUseForInActive   = (empty($classToUseForInActive)) ? "class=\"$this->next_prev_class_InActive\"" : $classToUseForInActive;
	    	
			$text = "<font $classToUseForInActive>$display</font>";
	    }
	    
	    return $text;
	}

	function getNextLink($classToUseForActive="",$classToUseForInActive="")
	{
		if($this->numOfPages <= 0)
			return "";
		
		$display = (empty($this->nextImage)) ? $this->nextText : "<img src=\"$this->nextImage\">";

		if(($this->totalRows - ($this->limit * $this->page)) > 0)
		{ 
	        $pagenext = $this->page; 
	        $pagenext = ($this->page);// + $this->numberLinksToShow);
			$pagenext++;
			
	    	$classToUseForActive   = (empty($classToUseForActive)) ? "class=\"$this->next_prev_class_Active\"" : $classToUseForActive;
			
	        $text = "<a href=\"$this->queryStr&page=$pagenext\" $classToUseForActive>$display</a>";
	    }
	    else if($this->showInactiveNextLink)
	    {
	    	$classToUseForInActive   = (empty($classToUseForInActive)) ? "class=\"$this->next_prev_class_InActive\"" : $classToUseForInActive;
	    	
			$text = "<font $classToUseForInActive>$display</font>";
	    }
	    
	    return $text;
	}
	
	function getFirst($classToUseForActive="",$classToUseForInActive="")
	{
		if($this->numOfPages <= 0)
			return "";

		$display = (empty($this->firstImage)) ? $this->firstText : "<img src=\"$this->firstImage\">";
			
		if($this->page > 1)
	    {
	    	$classToUseForActive   = (empty($classToUseForActive)) ? "class=\"$this->first_last_class_Active\"" : $classToUseForActive;
	    	
	    	$text = "<a href=\"$this->queryStr&page=1\" $classToUseForActive>$display</a>";
	    }
	    else if($this->showInactiveFirstLink)
	    {
	    	$classToUseForInActive   = (empty($classToUseForInActive)) ? "class=\"$this->a_Inactive_class\"" : $classToUseForInActive;
	    	
			$text = "<font $classToUseForInActive>$display</font>";
	    }	    
	    
	    return $text;
	}
	
	function getLast($classToUseForActive="")
	{
		if($this->numOfPages <= 0)
			return "";

		$display = (empty($this->lastImage)) ? $this->lastText : "<img src=\"$this->lastImage\">";
			
		if($this->page != $this->numOfPages)
	    {
	    	$classToUseForActive   = (empty($classToUseForActive)) ? "class=\"$this->first_last_class_Active\"" : $classToUseForActive;
	    	
	    	$text = "<a href=\"$this->queryStr&page=$this->numOfPages\" $classToUseForActive>$display</a>&nbsp;";
	    }
	    else if($this->showInactiveLastLink)
	    {
	    	$classToUseForInActive   = (empty($classToUseForInActive)) ? "class=\"$this->a_Inactive_class\"" : $classToUseForInActive;
	    	
			$text = "<font $classToUseForInActive>$display</font>";
	    }
	    
	    return $text;
	}
	
	function getPages($classToUseForActive="",$classToUseForInActive="")
	{
		if($this->numOfPages <= 0)
			return "";
		
		//calculate which page is the startpage
		/*$startPage =  (($this->page - $this->numberLinksToShow) < 1) ? 1 :($this->page - $this->numberLinksToShow);	 

		$startAtThisPage = ($this->cleanPagination) ? $this->page : $this->startPage;// -(ceil($this->numberLinksToShow));
		$endAtThisPage   = ($this->page + $this->numberLinksToShow);
		*/
		
		
		//calculate which page is the startpage/endpage
		$startPage	= (floor($this->numberLinksToShow/2) < 1) ? 1 : floor($this->numberLinksToShow/2);
		$startPage  = (($this->page - $startPage) < 1) ?1 : ($this->page - $startPage) ;

		$startAtThisPage = ($this->cleanPagination) ? $this->page : $startPage;
		$endAtThisPage   = $startAtThisPage + $this->numberLinksToShow;

		for($i = $startAtThisPage; $i < $endAtThisPage; $i++)
		{ 
	        if($i == $this->page)
			{ 
				$classToUseForInActive = (empty($classToUseForInActive)) ? "class=\"$this->a_Inactive_class\"" : $classToUseForInActive;
					        		
	            $text .= "<font $classToUseForInActive>$i</font>&nbsp;";	            
	        }
	        else
	        { 
	        	if ($i <= $this->numOfPages)
	        	{
	        		$classToUseForActive   = (empty($classToUseForActive)) ? "class=\"$this->a_Active_class\"" : $classToUseForActive;
	        		
	            	$text .= "<a href=\"$this->queryStr&page=$i\" $classToUseForActive>$i</a>&nbsp;";
	        	}
	        }
		}
		
		return $text;
	}

	function getDropDown($classToUse="")
	{		
	    if($this->numOfPages <= 0)
			return "";

		if($this->showDropDownBox)
	    {
	    	$classToUse = (empty($classToUse)) ? "class=\"$this->drop_downbox_class\"" : $classToUse;
	    				
			$text = "<select name=\"goto\" onchange= \"location = '' + this.options[this.selectedIndex ].value;\" $classToUse>";

			for($j = 1; $j <= $this->numOfPages; $j++)
			{
				$text .= "<option value=\"$this->queryStr&page=$j\"";
				
				if($this->page== $j)
					$text .= "selected";
			    
				$text .=">$j</option>";
			}
			
			$text .="</select>";		
	    }
	    
	    return $text;
	}
	
	function getPaginatedResults($array)
	{
		$result = array();
		
		$numRecords = 0;
		
		for($i=0; $i < $this->totalRows; $i++)
		{
			$startAt = ($this->page * $this->limit) - $this->limit;
			
			if($i >= $startAt)
			{
				$result[] = $array[$i];
				
				$numRecords++;
			}			
			
			if($numRecords == $this->limit)
				break;			
		}
		
		return $result;
	}

	function getPagination()
	{
		return $this->getPageOfAmount()."<br>".$this->getFirst()."&nbsp;".$this->getPrevLink()."&nbsp;".$this->getPages()."&nbsp;".$this->getNextLink()."&nbsp;".$this->getLast()."<br>".$this->getDropDown();
		
	}
	
	function paginate($classToUse="")
	{
		if(!empty($classToUse))
		{		
		 	$this->setClasses($classToUse,$classToUse,$classToUse,$classToUse,$classToUse,$classToUse,$classToUse);
		}
		 
		?>
		<?php //echo Result." ".$this->getPageOfAmount()." ";?>
		<?php echo $this->getFirst();?>
		<?php //echo $this->getPrevLink();?>
		<?php echo $this->getPages();?>
		<?php //echo $this->getNextLink();?>
		<?php echo $this->getLast();?>
		<?php //echo $this->getDropDown();?>
		<?php
	}
}
?>