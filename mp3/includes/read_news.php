<?php
	$result = $comObj->getDataById("odb_news",$_GET['id']);
?>
<h2><?php echo cleanString($result['title']);?></h2>
<small><?php echo date("M-j-Y", strtotime($result['date_added']));?></small>
<?php echo cleanHtml($result['detail']);?>
