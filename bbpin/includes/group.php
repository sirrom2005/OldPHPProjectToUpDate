<?php
$pageOpen=true;
$loggedInUser = NULL;
$groupId 	= $_GET['id'];
$rs 		= $obj->getGroupInfo($groupId);
$interest 	= $obj->getUserInterest($groupId);
$proImg 	= $obj->getGroupPhotos($groupId);
$comments 	= $obj->getGroupComments($groupId);
$locPre		= DOMAIN;
if(isset($_SESSION['BBPINWORLD'])){
	$loggedInUser = $_SESSION['BBPINWORLD']['id'];
}
$pageFBImg = ($proImg) ? 'images/profile/group_'.$groupId.'/'.$proImg[0]['image_name'] : 'images/profile/profile.png';
$thisURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($rs)){ echo "<h2 style='margin:120px 0'>Profile not found...</h2>"; return;}
?>
<link href="<?php echo DOMAIN;?>styles/profile.css" rel="stylesheet" type="text/css">
<div class="right-bar">
	<?php 
		if($loggedInUser){
			if($loggedInUser == $rs['groupUser']){ 
	?>
        <a class="linkStyle1" href="index.php?action=add-bbm-group&id=<?php echo $groupId;?>"><?php echo $locale['group.edit'];?></a>
        <a class="linkStyle1" href="index.php?action=edit-group-gallery&id=<?php echo $groupId;?>"><?php echo $locale['group.edit.gallery'];?></a>
    <?php }else{ ?>
        <a class="linkStyle1" href="index.php?action=group-request&groupid=<?php echo $groupId;?>&ge=<?php echo base64_encode(base64_encode($rs['email']));?>"><?php echo $locale['group.request'];?></a>
    	<a class="linkStyle1" href="add-bbm-group.html"><?php echo $locale['btn.add.group'];?></a>
	<?php 
			}
		}
	?>
    <?php 
        $imgLoc = $locPre.'images/profile/group_'.$groupId.'/';
        if($proImg)
        {
            $imgPre = 250;
            foreach($proImg as $row){ 
    ?>
                <a target="_blank" href="<?php echo $imgLoc.$row['image_name'];?>" class="lightview" data-lightview-group="album" data-lightview-options="viewport:'scale'" data-lightview-title="<?php echo $row['description'];?>" ><img src="<?php echo $imgLoc.$imgPre.'_'.$row['image_name'];?>" alt="" title="" class="img<?php echo $imgPre;?>" /></a>
    <?php 
                $imgPre = 80;
            }
        }
        else{
            echo "<img src='images/profile/profile.png' alt='' title='profile picture' class='img250' />";
        } 
    ?>
</div>
<div class="boxStyle1 profile">
	<h1><?php echo $rs['group_name'];?></h1>
    <?php echo ($loggedInUser != $rs['groupUser'])? '<h2>'.sendGroupRequest($groupId,$rs['email']).'</h2>' : '';?>
    <ul class="ulFrmStyle">
        <li><label class="lbl"><?php echo $locale['group.category'];?>:</label><?php echo $rs['category'];?></li>
        <li><label class="lbl"><?php echo $locale['group.country'];?>:</label><img src="<?php echo DOMAIN;?>images/flags/<?php echo strtolower($rs['flag']);?>.png" class="flagImg" alt="<?php echo $rs['country'];?>" title="<?php echo $rs['country'];?>" /> <?php echo $rs['country'];?></li>
    </ul>
    <div class="aboutme">
        <h3><?php echo $locale['group.about'];?></h3>
        <?php echo str_replace("\r\n","<br>",cleanHtml($rs['group_detail']));?>
    </div>
    <span class="warning"><?php echo $locale['group.notice'];?></span>
</div>
<div id="textBanner">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-9222115009045453";
	/* text_add_468 */
	google_ad_slot = "5941130927";
	google_ad_width = 468;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div class="boxStyle1">
    <form name="comentfrm" id="comentfrm" method="post" action="">
        <h4><?php echo $locale['leave.comment'];?></h4>
        <p><textarea name="message" id="message"></textarea></p>
        <p align="right">
            <input type="button" id="sendcomment" class="button" value="<?php echo $locale['btn.add.comment'];?>" />
            <img src="images/loading.gif" id="ldr" />
        </p>
    </form>
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
    <a name="com"></a>
    <ul id="comments">
        <?php 
            if($comments){ 
                foreach($comments as $row){
        ?>
                <li id="cmm<?php echo $row['id'];?>">
                    <a name="com<?php echo $row['id'];?>"></a>
                    <?php if($loggedInUser == $row['senderid'] || $loggedInUser == $row['group_owner']){ ?>
                        <a href="javascript:removePost(<?php echo $row['id'];?>);" class="remove"></a>
                    <?php } ?>
                    <?php echo $row['comment'];?>
                    <hr />
                    <small><a href="profile_<?php echo $row['senderid']?>.html"><?php echo $row['sendername']?></a> <?php echo date($locale['date.long'], strtotime($row['date_added']));?></small>
                    <div id="reply<?php echo $row['id'];?>Div" class="replyDiv" >
                    </div>
                </li>
        <?php 
                }
            } 
        ?>
    </ul>
</div>
<script language="javascript">
$('#sendcomment').bind('click', function(){
	var txt = $('#message').val();
	if(isEmpty(txt)){return false;}
	$('#ldr').css('visibility','visible'); 
	$('#sendcomment').attr('disabled',true);
  	$.get("includes/ajx_gca.php",{ti:txt,g:<?php echo $groupId;?>},
		function(data){
			$('#comments').prepend(data);
			$('#message').val('');
			$('#sendcomment').attr('disabled',false);
			$('#ldr').css('visibility','hidden');
		}
	);
});
function removePost(id){
	if(confirm('You are about to delete this post')){
		$.get("includes/ajx_gcd.php",{i:id},
		function(data){
				$('#cmm' + id).remove();
			}
		);
	}
} 
</script>