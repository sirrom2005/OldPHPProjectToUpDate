<?php
if(base64_decode($_GET['er'])==2)
{
	echo "Not enough credits to make purchase.";
}
else
{
	echo "An erro accur whille processing transaction, please ret again later.";	
}
?>