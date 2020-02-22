<?php
include_once("classes/pagination.class.php");
$current = "mymusic";
$title = "My Library";

if(empty($_SESSION['USER'])){ echo "<span class='err'>You must <a href='control/'>login</a> to view this page.</span>"; return;}

$presult = $siteObj->getMyMusic($_SESSION['USER']['id']);

$_LIMIT 	= 7;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "page.php?action=my_music";
$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results 	= $p->getPaginatedResults($presult);

if(empty($results)){ echo "<span class='err'>No purchase made...</span>"; return; }
?>
<div class="track-listing">
    <?php foreach($results as $row){?>	
    <div class="track sample">
            <a href="artiste.php?p=<?php echo base64_encode($row['photo']);?>&k=<?php echo base64_encode($row['artId']);?>&a=<?php echo base64_encode($row['stagename']);?>" rel="facebox" title="<?php echo $row['stagename'];?>"><img alt="<?php echo $row['title'];?>" height="48" width="50" class="thumb" src="<?php echo (empty($row['photo']))?ARTISTE_IMG_URL.'default.png' : ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" /></a>
            <a href="play_sample.php?id=<?php echo $row['id'];?>&title=<?php echo base64_encode($row['title']);?>" rel="facebox" class="play" ><img alt="" src="images/btn_play.png" /></a>
            <span class="track info">
                <span class="track title"><a href="<?php echo DOMAIN;?>song_<?php echo $row['id'];?>.htm" title="<?php echo $row['title'];?>" ><?php echo $row['title'];?></a></span>
                <span class="track sub-title"><?php echo $row['riddim'];?> (<?php echo $row['producerfname'];?>)</span>
            </span>
            <span class="credit info">
                <span class="credit amount"><?php echo $row['credit_amount'];?></span>
                <span class="credit text">Credits</span>
            </span>
            <a class="btn buy" href="downloader.php?f=<?php echo base64_encode($row['filename']);?>&i=<?php echo base64_encode($row['id']);?>" title="download full song" rel="facebox"><img alt="" src="images/btn_buy.png" /></a>
    </div><!-- track sample -->
    <?php }?>
    <div class="pagination">
    <?php
        if( count($presult) > $_LIMIT)
        {						
            $p->cleanPagination(false);
            $p->paginate();
        }
    ?>					
    </div><!-- pagination -->
</div><!-- track-listing -->