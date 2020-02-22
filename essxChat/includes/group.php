<?php 
$groupId = $_GET['id'];
$rs = $obj->getGroupInfo($groupId);
$interest = $obj->getUserInterest($groupId);
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold;}
.img250{border:solid 1px #b7c6ec;padding:3px;width:240px;}
.img80 {border:solid 1px #b7c6ec;padding:3px;width:72px;height:72px;}
.img250:hover,.img80:hover{border:solid 1px #666666;}
table{ width:100%;}
table th{width:150px;text-align:left;}
table td{padding-bottom:5px;}
ol li{width:170px;margin:0 4px 4px 0; float:left; border:solid 1px #FFFFFF;}
</style>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/spinners/spinners.js"></script>
<script type="text/javascript" src="js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="styles/lightview/lightview.css" />
<div class="largeProfile">
    <div class="gallery">
    	<?php 
			$proImg = $obj->getGroupPhotos($groupId);
			$imgLoc = 'images/profile/group_'.$groupId.'/';
			if($proImg)
			{
				$imgPre = 250;
				foreach($proImg as $row){ 
		?>
        			<a target="_blank" href="<?php echo $imgLoc.$row['image_name'];?>" class="lightview" data-lightview-group="album" data-lightview-options="viewport:'scale'" ><img src="<?php echo $imgLoc.$imgPre.'_'.$row['image_name'];?>" alt="" title="" class="img<?php echo $imgPre;?>" /></a>
        <?php 
					$imgPre = 80;
				}
			}
			else{
				echo "<img src='images/profile/profile.png' alt='' title='profile picture' class='img250' />";
			} 
		?>
    </div>
    <div class="info">
        <table>
        	<tr>
            	<th>Name:</th>
                <td>
                	<span style="float:right;">
                    	<?php if($_SESSION['BBPINWORLD']['id'] == $rs['groupUser']){ ?>
            				<button>Edit Your Group</button>
                        <?php }else{ ?>
            				<button onclick="location='<?php echo DOMAIN;?>?action=group-request&groupid=<?php echo $groupId;?>&ge=<?php echo base64_encode(base64_encode($rs['email']));?>'">Send Group Request</button>
                        <?php } ?>
        			</span>
					<?php echo $rs['group_name'];?>
            	</td>
            </tr>
            <tr>
            	<th>Category:</th>
                <td><?php echo $rs['category'];?></td>
            </tr>
            <tr>
            	<th>Country of Origin:</th>
                <td><img src="images/flags/<?php echo strtolower($rs['flag']);?>.png" class="flagImg" alt="<?php echo $rs['country'];?>" title="<?php echo $rs['country'];?>" /> <?php echo $rs['country'];?></td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>Group Description</h3>
					<?php echo $rs['group_detail'];?>
                </td>
            </tr>
        </table>
    </div>
</div>