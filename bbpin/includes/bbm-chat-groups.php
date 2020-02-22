<?php
include_once(DOCROOT."classes/pagination.class.php");
$data = array();
if($_REQUEST){
	$data = $_REQUEST;
}
$presult = $obj->getGroupList($data);

$_LIMIT 	= 20;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=bbm-chat-groups&country_id={$data['country_id']}&interest={$data['interest']}";
$p 	= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$rs = $p->getPaginatedResults($presult);
?>
<link href="styles/profilelisting.css" rel="stylesheet" type="text/css">
<div class="boxStyle1">
    <h2><?php echo $locale['find.group'];?></h2>
    <ul class="userlist">
        <?php 
        if(!empty($rs)){
            $i = 0;
            foreach($rs as $row){ 
                $proImg = ($row['proImg'])? 'images/profile/group_'.$row['id'].'/80_'.$row['proImg'] : 'images/profile/80_profile.png';		
        ?>
        <li class="<?php echo ($i%2==1)? 'nostyle' : '';?>">
            <a href="group_<?php echo $row['id'];?>.html">
                <img src="<?php echo DOMAIN.$proImg;?>" class="proImg" /> 
                <h3><?php echo $row['group_name'];?></h3>
                <h4>Category: <?php echo ($row['category'])? $row['category'] : 'none' ;?></h4>
                <h5><img src="<?php echo DOMAIN;?>images/flags/<?php echo strtolower($row['flag']);?>.png" class="flagImg" alt="<?php echo $row['country'];?>" title="<?php echo $row['country'];?>" /> <?php echo $row['country'];?></h5>
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