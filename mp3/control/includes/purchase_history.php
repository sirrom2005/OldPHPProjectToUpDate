<?php
	$result = $siteObj->getPurchaseHistory($_SESSION['USER']['id']);
	if(!empty($result))
	{
		foreach($result as $row)
		{
			echo "<li><a href=\"index.php?action=purchase_record&id=".base64_encode($row['items'])."\">".date("l, F d Y", $row['transaction_date'])."</a></li>";
		}
	}
	else
	{ echo "<span class='err'>No purchase made...</span>";}
?>