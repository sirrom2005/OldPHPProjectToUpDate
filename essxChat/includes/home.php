<?php
$data = array();
if($_REQUEST){
	$data = $_REQUEST;
}
$rs = $obj->getUserList($data);
?>
<h2>BBM contacts</h2>
<ul class="userlist">
	<?php 
	if(!empty($rs)){
		foreach($rs as $row){ 
			$proImg = ($row['proImg'])? 'images/profile/'.$row['id'].'/80_'.$row['proImg'] : 'images/profile/80_profile.png';		
	?>
	<li>
    	<a href="profile_<?php echo $row['id'];?>.html">
        	<img src="<?php echo $proImg;?>" class="proImg" /> 
            <span><?php echo $row['fname'].' '.$row['lname'];?></span>
            <span><?php echo $row['gender'];?> &bull; <img src="images/flags/<?php echo strtolower($row['flag']);?>.png" class="flagImg" alt="<?php echo $row['country'];?>" title="<?php echo $row['country'];?>" /></span>
            <span><?php echo $row['status'];?></span>
            <span>Pin: <small class="<?php echo ($row['pinverified'])? 'verified' : 'notverified';?>"><b><?php echo ($row['pinverified'])? '' : 'not';?> verified</b></small></span>
        </a>        
    </li>
    <?php 
		}
	}else{
		echo "results not found.";
	} 
	?>
</ul>