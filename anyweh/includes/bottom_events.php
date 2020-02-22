<?php
	$blogImg = NULL;
	if(!empty($eventReview))
	{
		foreach($eventReview as $row)
		{
			$blogImg  = img_attr($row['post_content']); 
			$blogImg = ( !empty($blogImg) )? $blogImg : NEWS_IMG_URL."default_news.jpg" ;
?>
<div class="b_event">
    <a href="<?=$row['guid']?>" title='<?=cleanString($row['post_title'])?>' class='event'><img class="b_eventImg" src="<?=$blogImg?>" align="left" alt="<?=cleanString($row['post_title'])?>" title="<?=cleanString($row['post_title'])?>" /></a>
    <h6><a href="<?=$row['guid']?>" class='event' title="<?=cleanString($row['post_title'])?>"><?=cleanString( $row['post_title'], 3 )?></a></h6>
    <div><?=cleanString($row['post_content'], 13)?>...</div>
</div>
<?php	}
	}
?>