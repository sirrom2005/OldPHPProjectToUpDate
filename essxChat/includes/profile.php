<?php 
$userId = (isset($_GET['id']))? $_GET['id'] : $_SESSION['BBPINWORLD']['id'];
$rs = $obj->getProfileInfo($userId);
$lookFor = $obj->getUserLookFor($userId);
$interest = $obj->getUserInterest($userId);

/*View requested userprofile*/
if(isset($_GET['rd'])){
	/*give user permission to view your BBM-PIN if was hidden*/
	$rd = base64_decode($_GET['rd']);
	if($_SESSION['BBPINWORLD']['id'] == $rd){
		$rs['hidepin'] = null;
	}
}
?>
<style>
.info label{display:inline-block;width:140px; font-weight:bold;}
.img250{border:solid 1px #b7c6ec;padding:3px;width:240px;}
.img80 {border:solid 1px #b7c6ec;padding:3px;width:72px;height:72px;}
.img250:hover,.img80:hover{border:solid 1px #666666;}
table{ width:100%;}
table th{width:150px;text-align:left;}
table td{padding-bottom:5px;}
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
			$proImg = $obj->getProfilePhotos($userId);
			$imgLoc = 'images/profile/'.$userId.'/';
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
                	<span style="float:right; position:relative;">
                    	<?php if($_SESSION['BBPINWORLD']['id'] == $userId){ ?>
            				<button onclick="location='edit-profile.html'">Edit Your Profile</button>
                        <?php }else{ ?>
            				<button onclick="location='<?php echo DOMAIN;?>?action=request-pin&id=<?php echo $userId;?>&ed=<?php echo base64_encode(base64_encode($rs['email']));?>'">Request BBM-Pin</button>
                        <?php } ?>
        			</span>
					<?php echo $rs['fname'].' '.$rs['lname'];?>
            	</td>
            </tr>
            <tr>
            	<th>Gender:</th>
                <td><?php echo $rs['gender'];?></td>
            </tr>
            <?php if(!$rs['hide_age']){ ?>
            <tr>
            	<th>Age:</th>
                <td><?php echo $rs['dob'];?></td>
            </tr>
            <?php } ?>
            <tr>
            	<th>Status:</th>
                <td><?php echo $rs['status'];?></td>
            </tr>
            <tr>
            	<th>Gender Prefrence:</th>
                <td><?php echo $rs['gender_prefrence'];?></td>
            </tr>
            <tr>
            	<th valign="top">Looking For:</th>
                <td>
                	<?php 
						if($lookFor){
							foreach($lookFor as $row){ 
								echo $row['name'].'<br>';
							}
						}		
					?>
                </td>
            </tr>
            <tr>
            	<th>BB-PIN:</th>
                <td>
					<?php echo ($rs['hidepin'])? '<small>[<b>Hidden by user</b>]</small>' : strtoupper($rs['bbmpin']);?>
                	<small class="<?php echo ($rs['pinverified'])? 'verified' : 'notverified';?>"><b>pin <?php echo ($rs['pinverified'])? '' : 'not';?> verified</b></small>
                </td>
            </tr>
            <tr>
            	<th>Country:</th>
                <td><img src="images/flags/<?php echo strtolower($rs['flag']);?>.png" class="flagImg" alt="<?php echo $rs['country'];?>" title="<?php echo $rs['country'];?>" /> <a href="<?php echo DOMAIN;?>?country_id=<?php echo $rs['country_id'];?>"><?php echo $rs['country'];?></a></td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>About Me</h3>
					<?php echo $rs['about_me'];?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<h3>Interest</h3>
                    <ol>
					<?php 
					if($interest){
						foreach($interest as $row){ 
					?>
                    	<li><a href="<?php echo DOMAIN;?>?interest=<?php echo $row['id'];?>" title="<?php echo $row['name'];?>"><?php echo $row['name'];?></a></li>
                    <?php
						}
					}		
					?>
                    </ol>
                </td>
            </tr>
        </table>
    </div>
</div>