<?php
/*~~ SYSTEM MATCH ~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
if(isset($_SESSION['sysMatch'])){
	$sysMatch = $_SESSION['sysMatch'];
}else{
	include_once("../classes/mySQlDB__.class.php");
	include_once("../classes/site.class.php");
	$obj = new site();
	$sysMatch = $obj->getSystemMatch();
	$_SESSION['sysMatch'] = $sysMatch;
}
?>
<ul class="items">
    <?php foreach($sysMatch as $row){ ?>
    <li>
        <a href="profile_<?php echo $row['id'];?>.html" title="<?php echo strtolower($row['fullname']);?>">
            <img class="img" src="images/profile/<?php echo $row['id'];?>/80_<?php echo $row['proImg'];?>" alt="<?php echo strtolower($row['fullname']);?>" />
            <span class="name"><?php echo $row['fullname'];?> &bull; <b><?php echo $row['gender'];?></b> &bull; <img src="images/flags/<?php echo strtolower($row['flag']);?>.png" alt="<?php echo strtolower($row['country']);?>"/></span>
            <span class="pin">BBM-PIN: <b><?php echo $row['bbmpin'];?></b></span>
        </a>
        <hr>
    </li>
    <?php } ?>
</ul>