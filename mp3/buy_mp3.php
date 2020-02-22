<div id="fbox">
<h4 align="center"><b>Are you sure you want to buy:</b></h4>
<h4 align="center"><?php echo base64_decode($_GET['title']); ?></h4>
<p align="center">
	<a href="#" onclick="buymp3(<?php echo $_GET['id']; ?>);">Yes</a>
    <a href="#" onclick="$.facebox.close();">No</a>
</p>
</div>