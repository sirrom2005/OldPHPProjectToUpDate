<?php
$bc = "";
$winFeature = "height=350,width=600";
if(isset($_GET['d'])){
	$rs = $obj->getEventsByDate( date('Y-m-d',strtotime($_GET['d'])));
}
else{
	$catid = (isset($_GET['catid']))? $_GET['catid'] : 'jamaica';
	$rs = $obj->getEvents($catid); 
	$bc = $rs[0]['category'];
}
if($rs)
{
?>   
<script type="text/javascript" src="<?php echo DOMAIN;?>js/swfobject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo DOMAIN;?>js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo DOMAIN;?>js/spinners/spinners.js"></script>
<script type="text/javascript" src="<?php echo DOMAIN;?>js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN;?>css/lightview/lightview.css" />
<?php 
	$i=1;
	$evnt1=$evnt2=$evnt3="";
	foreach($rs as $row){ 
		$str = '<div class="eventList">
					<a href="'.DOMAIN.'images/content/events/'.$row['image_name'].'" title="'.cleanString($row['title']).'" target="_blank" class="lightview" data-lightview-group="album" data-lightview-options="viewport:\'scale\'" data-lightview-title="'.cleanString($row['title']).' - '.date('l, F d Y.', strtotime($row['event_date'])).'" ><img src="'.DOMAIN.'images/content/events/305_'.$row['image_name'].'" title="'.strtolower($row['title']).'" alt="'.strtolower($row['title']).'" /></a>
					<span>
						<a href="'.DOMAIN.'events.php?action=eventsbyid&catid='.$row['cat_url_name'].'&img='.$row['image_name'].'" class="title" >'.cleanString($row['title']).'</a>
						<small>'.date('l, F d Y.', strtotime($row['event_date'])).'</small><hr>
						<span>
						<font>share on</font>
						<a href="'.DOMAIN.'getimage.php?img='.DOMAIN.'images/content/events/'.$row['image_name'].'" class="download right" target="_blank" title="download this banner from fimiyaad.com"></a>
						<a class="facebook" title="share on facebook.com" onclick="open(\'http://www.facebook.com/sharer/sharer.php?u='.urlencode(DOMAIN.'events.php?action=eventsbyid&catid='.$row['cat_url_name'].'&img='.$row['image_name']).'\',\'fb\',\''.$winFeature.'\');"></a>
						<a class="twitter" title="share on twitter.com" onclick="open(\'https://twitter.com/intent/tweet?original_referer='.urlencode(DOMAIN.'events.php?action=eventsbyid&catid='.$row['cat_url_name'].'&img='.$row['image_name']).'&text='.urlencode(cleanString($row['title'])).'&tw_p=tweetbutton&url='.urlencode(DOMAIN.'events.php?action=eventsbyid&catid='.$row['cat_url_name'].'&img='.$row['image_name']).'%23.UTvHZ2j8tOo.twitter\',\'tw\',\''.$winFeature.'\');"></a>
						</span>
					</span>
				</div>';
		if($i==1){$evnt1 .= $str;}
		if($i==2){$evnt2 .= $str;}
		if($i==3){$evnt3 .= $str;$i=0;}
		$i++;
	} 
?>
<h2><?php echo $bc; ?></h2>
<div class="eventCell1"><?php echo $evnt1;?></div>
<div class="eventCell2"><?php echo $evnt2;?></div>
<div class="eventCell3"><?php echo $evnt3;?></div>
<?php }else{ echo "<span class='error'>No events found, really!!!</span>"; } ?>