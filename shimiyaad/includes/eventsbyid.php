<?php 
$rs = $obj->getEventById($_GET['img']);
$pageTitle = 'EVENTS :: '.cleanString($rs['title']);
$pageDesc  = (!empty($rs['desc']))? cleanString($rs['desc']) : cleanString($rs['title']);
$pageFBImg = DOMAIN.'images/content/events/305_'.$rs['image_name'];
?>
<h2 class="title"><a href="events.php?action=bc&catid=<?php echo $rs['cat_url_name'];?>"><?php echo $rs['category'];?></a> &lsaquo; <?php echo cleanString($rs['title']);?></h2>
<span class="shear">
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style ">
    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
    <a class="addthis_button_tweet"></a>
    <a class="addthis_button_pinterest_pinit"></a>
    <a class="addthis_counter addthis_pill_style"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-502db22540551681"></script>
    <!-- AddThis Button END -->
</span>
<small><b>Event date:</b> <?php echo date('l, F d Y.', strtotime($rs['event_date']));?></small><hr />
<div id="eventsinfo">
<img src="<?php echo DOMAIN;?>images/content/events/<?php echo $rs['image_name'];?>"  />
<div>
<h4><?php echo cleanString($rs['title']);?></h4>
<?php echo cleanString($rs['desc']);?>
<p><small><b>Event date:</b> <?php echo date('l, F d Y.', strtotime($rs['event_date']));?></small></p>
</div>
</div>