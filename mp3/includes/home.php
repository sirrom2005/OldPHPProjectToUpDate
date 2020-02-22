<?php
	$data['searchtext']= "";
	$data['featured']  = "featured";
	$data['searchopt'] = "";
	$featuredTunes = $siteObj->searchMP3($data, NULL, 5);
	$newRelease    = $siteObj->searchMP3(NULL, "mp3.date_added DESC", 5);
	$latestNews    = $siteObj->getLatestNews(5);
	$artisteList   = $siteObj->getArtiste();
	$producerList  = $siteObj->getProducerList();
	
	if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = NULL;}
	
	/*$str = "<b>so'm\"e te</b>xt";
	echo html_entity_decode(htmlentities($str));
	echo html_entity_decode($str);*/
?>
<?php if(!empty($featuredTunes)){?>
    <div class="box">
    	<h3>Feature</h3>
		<?php foreach($featuredTunes as $row){?>
        	<li><a href="javascript:addtocart(<?php echo $row['id'];?>);" class="addtocart"></a> &cent;<?php echo $row['credit_amount'];?> <?php echo cleanString($row['title']);?> </li>
        <?php }?>  	
    </div>
<?php }?>

<?php if(!empty($newRelease)){?>
    <div class="box">
    	<h3>New Releases</h3>
		<?php foreach($newRelease as $row){?>
        	<li><a href="javascript:addtocart(<?php echo $row['id'];?>);" class="addtocart"></a> &cent;<?php echo $row['credit_amount'];?> <?php echo $row['title'];?> </li>
        <?php }?>  	
    </div>
<?php }?>

<?php if(!empty($latestNews)){?>
    <div class="box">
    	<h3>Latest News</h3>
		<?php foreach($latestNews as $row){?>
            <a href="index.php?action=read_news&id=<?php echo $row['id'];?>"><?php echo cleanString($row['title']);?></a>
            <p><?php echo cleanString($row['detail'], 10);?></p>
        <?php }?>  	
    </div>
<?php }?>

<?php if(!empty($artisteList)){?>
    <div class="box">
    	<h3>Artiste List</h3>
		<?php foreach($artisteList as $key => $value){?>
			<a href="index.php?action=artiste_view&id=<?php echo $key;?>"><?php echo cleanString($value);?></a><br />
        <?php }?>  	
    </div>
<?php }?>

<?php if(!empty($producerList)){?>
    <div class="box">
    	<h3>Producer List</h3>
		<?php foreach($producerList as $row){?>
			<a href="index.php?action=producer_view&id=<?php echo $row['id'];?>"><?php echo $row['fname']." ".$row['lname'];?></a><br />
        <?php }?>  	
    </div>
<?php }?>

<script>
function addtocart(id)
{
	$.get("includes/addtocart.php",
			{id:id},
			function(data)
			{
				$("#cartItemCount").html(data);
			}
	)
}
</script>