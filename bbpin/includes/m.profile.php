<?php 
$loggedInUser = NULL;
$userId  = (isset($_GET['id']))? $_GET['id'] : $_SESSION['BBPINWORLD']['id'] ;
if(isset($_SESSION['BBPINWORLD'])){$loggedInUser = $_SESSION['BBPINWORLD']['id'];}
$rs 		= $obj->getProfileInfo($userId);
$lookFor 	= $obj->getUserLookFor($userId);
$interest 	= $obj->getUserInterest($userId);
$comments 	= $obj->getProfileComments($userId);
$proImg 	= $obj->getProfilePhotos($userId);
$fullname 	= trim($rs['fname'].' '.$rs['lname']);
if($loggedInUser == $userId){
	if(empty($_SESSION['BBPINWORLD']['hasImage'])){ echo "<span class='warning'>To view members with photo you must first upload a photo of your self.<br>click <a href='edit-my-gallery.html'>here</a> a add a photo.</span>"; }
	if(empty($_SESSION['BBPINWORLD']['complete'])){ echo "<span class='warning'>You profile information is incomplete.<br />Click <a href='edit-profile.html'>here</a> to complete your profile.</span>";}
}
?>
<link href="../styles/profile.css" rel="stylesheet" type="text/css">
<h2 align="center"><?php echo strtoupper($fullname);?></h2>
<p align="center">
	<?php 
    $imgLoc = '../images/profile/';
    $imgPre = 250;
    if($proImg)
    {
        foreach($proImg as $row){ 
            $img = ($row['image_name'])? $imgLoc.$userId.'/'.$imgPre.'_'.$row['image_name'] : $imgLoc.strtolower($rs['gender']).'_silhouette.jpg';	
    ?>
            <a href="profile-photo-<?php echo $userId;?>-<?php echo $row['image_name'];?>.html" class="imglink<?php echo $imgPre;?>" ><img src='<?php echo $img;?>' alt='' title='<?php echo $fullname;?> profile picture' class='img<?php echo $imgPre;?>' /></a>
    <?php 
			if($imgPre == 250){}
            $imgPre = 80;
        } 
    }
    else{
        echo "<img src='".$imgLoc.strtolower($rs['gender'])."_silhouette.jpg' alt='' title='profile picture' class='img250' />";
    }
    ?>
    
    <?php if($loggedInUser == $userId){ ?>
        <a class="button" href="edit-profile.html">Edit Your Profile</a>    
        <a class="button" href="edit-my-gallery.html"><?php echo $locale['edit.gallery'];?></a>
        <a class="button" href="add-bbm-group.html"><?php echo $locale['add.bbm.group'];?></a>
        <a class="button" href="your-group.html">Edit/Delete Your BBM Group</a>
    <?php }else{
    ?>
        <a class="button" style="display:block;" href="index.php?action=send-message&id=<?php echo $userId;?>" >Send Message</a>
        <a class="button" style="display:block;" href="index.php?action=request-pin&id=<?php echo $userId;?>&ed=<?php echo base64_encode(base64_encode($rs['email']));?>" >Request BBM-Pin</a>
    <?php
        }
    ?>
</p>
<hr />
<h1 align="center"><?php echo ($rs['status']!='&nbsp;')? ''.$rs['status'].' &bull; ' : '';?><?php echo $rs['gender'];?><?php echo (!$rs['hide_age'] && $rs['age']!='00')? ' &bull; '.$rs['age'] : ''; ?></h1>
<h1 align="center">
	BB-PIN: <?php echo ($rs['hidepin'])? '<small>[<b>Hidden by user</b>]</small>' : strtoupper($rs['bbmpin']);?>
	<small class="<?php echo ($rs['pinverified'])? 'verified' : 'notverified';?>"><b><?php echo ($rs['pinverified'])? $locale['pin.verified'] : $locale['pin.not.verified'];?></b></small>
</h1>
<hr />
<ul class="ulFrmStyle">
	<li><label class="lbl">Gender Pref:</label><?php if($rs['gender_prefrence'] == 'M'){ echo "Male";}elseif($rs['gender_prefrence'] == 'F'){ echo "Female";}else{ echo "None";}?></li>
    <?php if($lookFor){ ?>
    <li><label class="lbl">Looking For:</label><?php foreach($lookFor as $row){ echo '&laquo;<i>'.$row['name'].'</i>&raquo; ';}?></li>
    <?php } ?>
    <li><label class="lbl">Country:</label><img src="../images/flags/<?php echo strtolower($rs['flag']);?>.png" class="flagImg" alt="<?php echo $rs['country'];?>" title="<?php echo $rs['country'];?>" /> <a href="search.php?country_id=<?php echo $rs['country_id'];?>"><?php echo $rs['country'];?></a><?php echo $rs['country_zone'];?></li>
    <?php if($rs['education_level']){ ?>
    <li><label class="lbl">Education:</label><a href="search.php?edu=<?php echo $rs['education_level_id'];?>"><?php echo $rs['education_level'];?></a></li>
    <?php } ?>
    <?php if($rs['job_category']){ ?>
    <li><label class="lbl">Job Field:</label><a href="search.php?job=<?php echo $rs['job_category_id'];?>"><?php echo $rs['job_category'];?></a></li>
    <?php } ?>
</ul>
<?php if($rs['about_me']){ ?>
	<hr />
	<h3>About Me</h3>
	<?php echo cleanHtml(str_replace("\r\n","<br>",$rs['about_me']));?>
    <hr />
<?php } ?>
<?php if($interest){ ?>
		<h3>My Interest</h3>
		<?php foreach($interest as $row){ ?>
			<a class="proInterest" href="search.php?interest=<?php echo $row['id'];?>" title="<?php echo $row['name'];?>"><?php echo $row['name'];?></a>
		<?php } ?>

<?php } ?>
<hr />
<div>
    <form name="comentfrm" id="comentfrm" class="frmStyle1" method="post" action="">
        <p>
          <textarea name="message" id="message" style="width:95%;"></textarea>
        </p>
      <p align="right"><input type="submit" id="sendcomment" value="Add comment..."  class="button" /></p>
	  <input type="hidden" value="<?php echo base64_encode($rs['email']);?>" name="em" />
    </form>
    <a name="com"></a>
    <ul id="comments">
        <?php 
            if($comments){ 
                foreach($comments as $row){
        ?>
                <li>
                    <a name="com<?php echo $row['id'];?>"></a>
                    <?php if($loggedInUser == $row['senderid'] || $loggedInUser == $userId){ ?>
                        <a href="javascript:removePost(<?php echo $row['id'];?>);" class="remove"></a>
                    <?php } ?>
                    <?php echo cleanHtml($row['comment']);?>
                    <hr />
                    <small>
                        <a href="profile_<?php echo $row['senderid']?>.html"><?php echo $row['sendername']?></a> <?php echo date('l, F d Y. h:i a', strtotime($row['date_added']));?>
                        <?php if($loggedInUser == $userId &&  $row['senderid'] != $userId){ ?>
                            <a class="reply" href="profile_<?php echo $row['senderid'];?>.html#com" title="reply on <?php echo $row['sendername']?> wall"></a>
                        <?php } ?> 
                    </small>
                </li>
        <?php 
                }
            } 
        ?>
    </ul>
</div>