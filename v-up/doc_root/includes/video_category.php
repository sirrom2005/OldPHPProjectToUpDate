<?php foreach($category as $row){?>
	<h1><a href="<?php echo DOMAIN;?><?php echo urlFix($row['category']);?>.htm"><?php echo cleanString($row['category']);?></a></h1>
    <?php
		$catList = $obj->getVideoByCategory(urlUnFix($row['category']), 2);
		if(!empty($catList)){mediumVideoList($catList);}
	?>
<?php }?>

