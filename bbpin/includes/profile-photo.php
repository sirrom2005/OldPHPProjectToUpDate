<?php
$pageOpen=true;
$img 	= $_GET['img'];
$userId = $_GET['id'];
$rs 	= $obj->getProfileInfo($userId);
$proImg = $obj->getProfilePhotos($userId);
$fullname = trim($rs['fname'].' '.$rs['lname']);
$loggedInUser = isset($_SESSION['BBPINWORLD']['id']) ? $_SESSION['BBPINWORLD']['id'] : NULL;
$imgLoc = 'images/profile/'.$userId.'/';

$err 	= '';
if($_POST){
	if(!isset($_SESSION['BBPINWORLD'])){ header('location: '.DOMAIN); exit();}
	$message = cleanString(trim($_POST['message']));
	if(empty($message)){
		$err = "<span class='error'>Photo comment empty</span>";
	}else{
		if($obj->addPhotoComment($_SESSION['BBPINWORLD']['id'],$userId,$img,$message)){
			$url = DOMAIN."profile-photo-$userId-$img.html#com";
			$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
			$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = 'Photo comment added';
			$message = "{$_SESSION['BBPINWORLD']['fname']} posted a photo comment on your profile click <a href='$url'>here</a> to view comment.";
			@mail($rs['email'], $subject, $message, $headers);
		}
	}
}

$comments = $obj->getProfilePhotoComments($userId,$img);
?>
<div class="boxStyle1" style="text-align:center;">
    <h1 class="h1"><?php echo $fullname;?></h1>
    <h2 class="h2"><?php echo $locale['gallery'];?> (<a href="profile_<?php echo $userId;?>.html" title="back to profile">Back to profile</a>)</h2>
    <?php 
		echo $err;
		$lrgImgUrl = ($layout=="mobile")? '../'.$imgLoc.'250_'.$img : '../'.$imgLoc.$img ;
	?>
	<img src="<?php echo $lrgImgUrl;?>" alt="<?php echo strtolower($fullname);?>" class="largeProfileImg"/>
    <br />
	<?php
        if($proImg)
        {
            foreach($proImg as $row){ 
    ?>
                <a href="profile-photo-<?php echo $userId;?>-<?php echo $row['image_name'];?>.html" ><img src="<?php echo DOMAIN.$imgLoc.'80_'.$row['image_name'];?>" class="img80" title="<?php echo strtolower($fullname);?> profile picture" alt="<?php echo strtolower($fullname);?>" /></a>
    <?php 
            }
        }
        else{
            echo ".....";
        } 
    ?>
</div>
<div class="boxStyle1">
    <form name="comentfrm" id="comentfrm" method="post" action="">
        <h4><?php echo $locale['leave.img.comment'];?></h4>
        <p><textarea name="message" id="message"></textarea></p>
        <p align="right">
            <input type="submit" id="sendcomment" class="button" value="<?php echo $locale['btn.add.comment'];?>" />
        </p>
    </form>
	<?php if($layout=="mobile"){ ?>
        <div style="margin:5px auto; width:320px;">
            <span>
                <script type="text/javascript"><!--
                google_ad_client = "ca-pub-9222115009045453";
                /* mobile320x50 */
                google_ad_slot = "1487029109";
                google_ad_width = 320;
                google_ad_height = 50;
                //-->
                </script>
                <script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </span>
       </div>
    <?php }else{ ?>
        <div id="smallBanner">
            <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9222115009045453";
            /* 468x60banner */
            google_ad_slot = "8060140279";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>
    <?php
    }
    ?>
    <a name="com"></a>
    <ul id="comments">
        <?php 
            if($comments){ 
                foreach($comments as $row){
        ?>
                <li id="cmm<?php echo $row['id'];?>">
                    <a name="com<?php echo $row['id'];?>"></a>
                    <?php if($loggedInUser == $row['senderid'] || $loggedInUser == $userId){ ?>
                        <a onclick="removePost(<?php echo $row['id'];?>);" class="remove"></a>
                    <?php } ?>
                    <?php echo str_replace("\r\n","<br>",$row['comment']);?>
                    <hr />
                    <small>
                        <a href="profile_<?php echo $row['senderid']?>.html"><?php echo $row['sendername']?></a> <?php echo date($locale['date.long'], strtotime($row['date_added']));?>
                    </small>
                </li>
        <?php 
                }
            } 
        ?>
    </ul>
</div>