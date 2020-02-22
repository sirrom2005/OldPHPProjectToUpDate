<script src="js/jquery_tabs.js"></script>
<style>
/* accordion header */
#accordion h2 {cursor:pointer;}
/* currently active header */
#accordion h2.current {
	cursor:default;
	background-color:#fff;
}
/* accordion pane */
#accordion .pane {
	display:none;
}
</style>
<div id="accordion">
<?php
$current = "faq";
$title = "Frequently Asked Questions";
$result = $comObj->getData("odb_faqs",NULL,NULL,"ASC");
$i=0;
foreach($result as $row)
{
	if($i==0)
	{
		$class = "class='current'"; 
		$style = "style='display:block'";
	}
	else
	{ 
		$class = ""; $style = ""; 
	}
	echo "<h2 $class>{$row['title']}</h2>";
	echo "<div class='pane' $style >{$row['detail']}</div>";
	$i++;
}
?>
</div>

<script>
$(function() { 
$("#accordion").tabs("#accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
});
</script>