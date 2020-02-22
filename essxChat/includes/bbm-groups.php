<?php
$data = array();
if($_POST){
	$data = $_POST;
}
$rs = $obj->getGroupList($data);
?>
<style>
.grouplist li{float:left;width:300px;margin:0 5px 5px 0;}
.grouplist li a{display:block;padding:5px;height:90px;text-decoration:none;}
.grouplist li .proImg{float:left; margin:0 5px 5px 0; width:80px;border:solid 1px #666666; padding:2px;}
.grouplist li span{display:block;}
ol li{width:170px;margin:0 4px 4px 0; float:left; border:solid 1px #FFFFFF;}
</style>
<h2>BBM contacts</h2>
<ul class="grouplist">
	<?php 
	if(!empty($rs)){
		foreach($rs as $row){ 
			$proImg = ($row['proImg'])? 'images/profile/group_'.$row['id'].'/80_'.$row['proImg'] : 'images/profile/80_profile.png';		
	?>
	<li>
    	<a href="group_<?php echo $row['id'];?>.html">
        	<img src="<?php echo $proImg;?>" class="proImg" /> 
            <span><?php echo $row['group_name'];?></span>
            <span>Category: <?php echo ($row['category'])? $row['category'] : 'none' ;?></span>
            <span><img src="images/flags/<?php echo strtolower($row['flag']);?>.png" class="flagImg" alt="<?php echo $row['country'];?>" title="<?php echo $row['country'];?>" /> <?php echo $row['country'];?></span>
        </a>        
    </li>
    <?php 
		}
	}else{
		echo "results not found.";
	} 
	?>
</ul>