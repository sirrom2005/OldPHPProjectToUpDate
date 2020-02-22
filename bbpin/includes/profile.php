<?php 
$pageOpen=true;
$loggedInUser = NULL;
$userId = (isset($_GET['id']))? $_GET['id'] : $_SESSION['BBPINWORLD']['id'];
if(!$userId){header("location: ".DOMAIN);exit();}
if($layout=="mobile"){
	echo '<link href="styles/dds.css" rel="stylesheet" type="text/css">';
}
                
if(isset($_SESSION['BBPINWORLD'])){
	$loggedInUser = $_SESSION['BBPINWORLD']['id'];
}

$rs 		= $obj->getProfileInfo($userId);
$proImg 	= $obj->getProfilePhotos($userId,4);
$lookFor 	= $obj->getUserLookFor($userId);
$interest 	= $obj->getUserInterest($userId);
$comments 	= $obj->getProfileComments($userId);
$fullname 	= trim($rs['fname'].' '.$rs['lname']);
$pageTitle  = 'Exchange blackberry messenger pin with '.strtolower($fullname).' on jusbbmpins.com - The blackberry pin yellow page';
$pageDesc   = 'Exchange blackberry messenger pin with '.strtolower($fullname).' view and find more blackberry messenger pin to swap on jusbbmpins.com, connect with users that share your similar interest.';
if(empty($rs)){ echo "<h2 style='margin:120px 0'>Profile not found...</h2>"; return;}
?>
<link href="styles/profile.css" rel="stylesheet" type="text/css">
<div class="right-bar">
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style ">
    <a class="addthis_button_facebook_like"></a>
    <a class="addthis_button_tweet"></a>
    </div>
    <!-- AddThis Button END -->
    <?php
        if($proImg)
        {
            $imgLoc = 'images/profile/'.$userId.'/';
            $imgPre = 250;
            foreach($proImg as $row){ 
    ?>
                <a href="profile-photo-<?php echo $userId;?>-<?php echo $row['image_name'];?>.html" ><img src="<?php echo $imgLoc.$imgPre.'_'.$row['image_name'];?>" class="img<?php echo $imgPre;?>" title="<?php echo strtolower($fullname);?> profile picture" alt="<?php echo strtolower($fullname);?>" /></a>
    <?php 
                $imgPre = 80;
            }
        }
        else{
            echo "<img src='".DOMAIN."images/profile/".strtolower($rs['gender'])."_silhouette.jpg' alt='' title='' class='img250' />";
        } 
    ?>
    <?php if($loggedInUser == $userId){ ?>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>edit-profile.html"><?php echo $locale['edit.profile'];?></a>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>edit-my-gallery.html"><?php echo $locale['edit.gallery'];?></a>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>add-bbm-group.html"><?php echo $locale['add.bbm.group'];?></a>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>your-group.html">Edit/Delete Your BBM Group</a>
    <?php }else{
    ?>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>index.php?action=send-message&id=<?php echo $userId;?>"><?php echo $locale['send.message'];?></a>
        <a class="linkStyle1" href="<?php echo DOMAIN;?>index.php?action=request-pin&id=<?php echo $userId;?>&ed=<?php echo base64_encode(base64_encode($rs['email']));?>"><?php echo $locale['request.bbm.pin'];?></a>
    <?php
        } 
    ?>
    <script type="text/javascript"><!--
	google_ad_client = "ca-pub-9222115009045453";
	/* 250x250_media */
	google_ad_slot = "9766270638";
	google_ad_width = 250;
	google_ad_height = 250;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
<div class="boxStyle1 profile">
    <h1><?php echo $fullname;?> &bull; <?php echo $locale[strtolower($rs['gender']).'.gender'];?><?php echo (!$rs['hide_age'] && !empty($rs['age']))? ' &bull; '.$locale['age'].':'.$rs['age'] : '' ;?></h1>
    <h2>
        <acronym title="blackberry messenger pin">BBM-PIN:</acronym>
      	<?php echo ($rs['hidepin'])? '<small>[<b>'.$locale['hidden.by.user'].'</b>]</small>' : strtoupper($rs['bbmpin']);?>&nbsp;<small class="<?php echo ($rs['pinverified'])? 'verified' : 'notverified';?>"><b><?php echo ($rs['pinverified'])? $locale['pin.verified'] : $locale['pin.not.verified'];?></b></small><br>
        <?php echo ($rs['hidepin'] && $loggedInUser != $userId)? myPinRequest($userId,$rs['email'],$fullname) : '';?>
    </h2>
    <ul class="ulFrmStyle">
        <?php if($rs['status']!='&nbsp;'){ ?>
            <li><label class="lbl"><?php echo $locale['pro.status'];?>:</label><?php echo $locale['status.'.strtolower($rs['status'])];?></li>
        <?php } ?>
        <li><label class="lbl" style="white-space:nowrap;"><?php echo $locale['pro.gender.pre'];?>:</label><?php if($rs['gender_prefrence'] == 'M'){ echo $locale['male.gender'];}?><?php if($rs['gender_prefrence'] == 'F'){ echo $locale['female.gender'];}?><?php if($rs['gender_prefrence'] == 'B' || empty($rs['gender_prefrence'])){echo "None";}?></li>
        <?php if($lookFor){ ?>
        <li>
            <label class="lbl" style="float:left;"><?php echo $locale['pro.looking'];?>:</label>
            <span style=" display:inline-block; margin-bottom:3px;">
            <?php 
                foreach($lookFor as $row){ 
                    echo $row['name'].'<br>';
                }	
            ?>
            </span><br />
        </li>
        <?php } ?>
        <li><label class="lbl"><?php echo $locale['pro.country'];?>:</label><img src="images/flags/<?php echo strtolower($rs['flag']);?>.png" class="flagImg" alt="<?php echo $rs['country'];?>" title="<?php echo $rs['country'];?>" /> <a href="<?php echo DOMAIN;?>index.php?action=search&country_id=<?php echo $rs['country_id'];?>" title="view blackberry user from <?php echo $rs['country'];?>"><?php echo $rs['country'];?></a><?php echo $rs['country_zone'];?></li>
        <?php if($rs['education_level']){ ?>
        <li><label class="lbl"><?php echo $locale['pro.education'];?>:</label><a href="<?php echo DOMAIN;?>index.php?action=search&edu=<?php echo $rs['education_level_id'];?>"><?php echo $rs['education_level'];?></a></li>
        <?php } ?>
        <?php if($rs['job_category']){ ?>
        <li><label class="lbl"><?php echo $locale['pro.employment'];?>:</label><a href="<?php echo DOMAIN;?>index.php?action=search&job=<?php echo $rs['job_category_id'];?>"><?php echo $rs['job_category'];?></a></li>
        <?php } ?>
    </ul>
    <?php if($rs['about_me']){ ?>
        <div class="aboutme">
            <h3><?php echo $locale['pro.about'];?></h3>
            <?php echo cleanHtml(str_replace("\r\n","<br>",$rs['about_me']));?>
        </div>
    <?php } ?>
    <?php if($interest){ ?>
        <h3><?php echo $locale['pro.interest'];?></h3>
        <?php foreach($interest as $row){ ?>
            <a class="proInterest" href="<?php echo DOMAIN;?>index.php?action=search&interest=<?php echo $row['id'];?>" title="<?php echo strtolower($row['name']);?>"><?php echo $row['name'];?></a>
        <?php } ?>
    <?php } ?>
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
        <h3><?php echo $locale['leave.comment'];?></h3>
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
                    <?php if($loggedInUser == $row['senderid'] || $loggedInUser == $userId){ ?>
                        <a onclick="removePost(<?php echo $row['id'];?>);" class="remove"></a>
                    <?php } ?>
                    <?php echo cleanHtml($row['comment']);?>
                    <hr />
                    <small>
                        <a href="profile_<?php echo $row['senderid']?>.html"><?php echo $row['sendername']?></a> <?php echo date($locale['date.long'], strtotime($row['date_added']));?>
                        <?php if($loggedInUser == $userId &&  $row['senderid'] != $userId){ ?>
                            <a class="reply" id="<?php echo $row['id'];?>" title="reply to this"></a>
                        <?php } ?>
                    </small>
                    <div id="reply<?php echo $row['id'];?>Div" class="replyDiv"></div>
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
	$.get("includes/ajx_ca.php",{ti:txt,s:<?php echo (isset($_SESSION['BBPINWORLD']['id']))? $_SESSION['BBPINWORLD']['id'] : 0;?>,p:<?php echo $userId;?>,e:"<?php echo base64_encode($rs['email']);?>" },
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
		$.get("includes/ajx_cd.php",{i:id},
		function(data){
				$('#cmm' + id).remove();
			}
		);
	}
} 

$(".reply").toggle(function(){
		$("#reply"+this.id+"Div").html("<p><textarea id='replyTxt"+this.id+"'></textarea></p><p align='right'><input type='button' id='sendreply' value='Reply' class='button' onclick='sendReply("+this.id+")' /><img src='images/loading.gif' class='ldr' /></p>");
	},
	function(){ $("#reply"+this.id+"Div").html(""); }
);

function sendReply(id){
	var txt = $("#replyTxt"+id).val();
	if(isEmpty(txt)){return false;}
	$("#reply"+id+"Div .ldr").css('visibility','visible'); 
	$("#reply"+id+"Div #sendreply").attr('disabled',true);
	$.get("includes/ajx_cr.php",{ti:txt,cid:id},
		function(data){
			$('#comments').prepend(data);
			$("#reply"+id+"Div").html("");
		}
	);
}
</script>