<?php
include_once(DOCROOT."classes/pagination.class.php");
$data = array();
if($_REQUEST){
	$data = $_REQUEST;
}
$presult = $obj->getUserList($data);

$_LIMIT 	= 12;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=search&status={$data['status']}&lookingFor={$data['lookingFor']}&country_id={$data['country_id']}&cz={$data['cz']}&interest={$data['interest']}&gender={$data['gender']}&job={$data['job']}&edu={$data['edu']}";
$p 	= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$rs = $p->getPaginatedResults($presult);
?>
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
                <h5><?php echo ($row['status']=='&nbsp;')? '' : $locale['status.'.strtolower($row['status'])];?></h5>
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
    <br />
    <p id="pagination">
    <?php
    if( count($presult) > $_LIMIT)
    {						
        $p->cleanPagination(false);
        $p->paginate();
    }
    ?>
    </p>
</div>
