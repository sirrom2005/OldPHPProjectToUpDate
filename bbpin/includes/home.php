<?php
include_once(DOCROOT."classes/pagination.class.php");
$data = array();
if($_REQUEST){
	$data = $_REQUEST;
}
$rs = $obj->getUserList(NULL,true);
$groups = $obj->getGroupList(NULL,4);
?>
<?php if(isset($_SESSION['BBPINWORLD']['complete']) && empty($_SESSION['BBPINWORLD']['complete'])){?>
	<span class="warning"><?php echo utf8_encode($locale['pro.incomplete']);?></span>
<?php return; }?>
<link href="<?php echo DOMAIN;?>styles/profilelisting.css" rel="stylesheet" type="text/css">
<div class="boxStyle1">
    <h2><?php echo utf8_encode($locale['latest.members']);?></h2>
    <ul class="userlist">
        <?php 
        if(!empty($rs)){
            $i = 0;
            foreach($rs as $row){ 
                $proImg = ($row['proImg'])? '<img src="'.DOMAIN.'images/profile/'.$row['id'].'/80_'.$row['proImg'].'" class="proImg" />' : '<span class="'.strtolower($row['gender']).'"></span>';		
        ?>
        <li class="<?php echo ($i%2==1)? 'nostyle' : '';?>" >
            <a href="profile_<?php echo $row['id'];?>.html" title="<?php profileLinkTitle($row['fullname']);?>">
                <?php echo $proImg;?> 
                <h3><?php echo $row['fullname'];?></h3>
                <h4><?php echo $locale[strtolower($row['gender']).'.gender'];?> &bull; <img src="<?php echo DOMAIN;?>images/flags/<?php echo strtolower($row['flag']);?>.png" class="flagImg" alt="<?php echo $row['country'];?>" title="<?php echo $row['country'];?>" /></h4>
                <h5><?php echo ($row['status']=='&nbsp;')? '' : utf8_encode($locale['status.'.strtolower($row['status'])]);?></h5>
                <small class="<?php echo ($row['pinverified'])? 'verified' : 'notverified';?>"><b><?php echo ($row['pinverified'])? utf8_encode($locale['pin.verified']) : utf8_encode($locale['pin.not.verified']);?></b></small>
            </a>        
        </li>
        <?php 
                $i++;
            }
        }else{
            echo "<span class='error'>results not found.</span>";
        } 
        ?>
    </ul>
    <p id="pagination">
	First&nbsp;1&nbsp;<a href="index.php?action=search&page=2">2</a>&nbsp;<a href="index.php?action=search&page=3">3</a>&nbsp;<a href="index.php?action=search&page=4">4</a>&nbsp;<a href="index.php?action=search&page=5">5</a>
    </p>
    <hr style="bdr" />
</div>
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
if(!empty($groups)){
?>
<div class="boxStyle1">
    <h2><?php echo utf8_encode($locale['newest.groups']);?></h2>
    <ul class="userlist">
        <?php 
        $i = 0;
        foreach($groups as $row){ 
            $proImg = ($row['proImg'])? 'images/profile/group_'.$row['id'].'/80_'.$row['proImg'] : 'images/profile/80_profile.png';	
        ?>
        <li class="<?php echo ($i%2==1)? 'nostyle' : '';?>" >
            <a href="group_<?php echo $row['id'];?>.html" title="blackberry chat group <?php echo strtolower($row['group_name']);?>">
                <img src="<?php echo DOMAIN.$proImg;?>" class="proImg" />
                <h3><?php echo $row['group_name'];?></h3>
                <h4><img src="<?php echo DOMAIN;?>images/flags/<?php echo strtolower($row['flag']);?>.png" class="flagImg" alt="<?php echo $row['country'];?>" title="<?php echo $row['country'];?>" /> <?php echo $row['country'];?></h4>
                <h5><?php echo utf8_encode($locale['group.category']);?>: <?php echo ($row['category'])? $row['category'] : 'none' ;?></h5>
            </a>        
        </li>
        <?php 
                $i++;
            } 
        ?>
    </ul>
    <br />
</div>
<?php }?>