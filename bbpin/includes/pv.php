<?php
$pageOpen=true;
?>
<div class="boxStyle1">
<?php
$key = explode('x',base64_decode($_GET['k']));
$id 	= (isset($key[0]))? $key[0] : 0;
$userid = (isset($key[1]))? $key[1] : 0;

$rs = $obj->setPinToVerifie($id,$userid);

if($rs==1){
?>
	<div class="good"><b>BBM-PIN</b> successfully verified.<br /><br />Thank you, <a href="http://www.jusbbmpin.com/profile_5.html">Jusbbmpin Admin</a>.</div>
<?php }else{ ?>
	<div class="error">This request is ether invalid or you BBM-PIN is already verified.<br /><br /><a href="http://www.jusbbmpin.com/contact-us.htm">Contact Admin</a>.</div>
<?php } ?>
</div>