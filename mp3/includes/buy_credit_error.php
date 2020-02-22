<?php
$current = "music";
?>
<h2>Payment Error</h2>
<h5>
<?php
$id = base64_decode($_GET['id']);
if($id==1)
{
	echo "This card is invalid";
}
if($id==2)
{
	echo "Fraudulent payment";
}
if($id==3)
{
	echo "Transaction error";
}
if($id==4)
{
	echo "Unknown error";
}
?>
</h5>