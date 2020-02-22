<div id="products">
    <div class="bg">
        <h2>Product List View <?php echo $textHeading.$keywordHeading;?></h2>
        <?php
			if(!empty($results))
			{
        		foreach( $results as $row )
				{
		?>
        		<div class="apps">
                	<div class="icon"><img src="<?php echo $row['app_icon'];?>" width="32" /></div>
                    <div class="app">
                        <a href="<?php echo DOMAIN;?>software/<?php echo $row['ceo_url_category']; ?>/<?php echo $row['url_title']; ?>.html"><?php echo cleanString($row['title']);?></a> <a href="<?php echo DOMAIN;?>software/<?php echo $row['ceo_url_category']; ?>/" class="category"><?php echo $row['category'];?></a> 
                        - <span><a href="<?php echo DOMAIN;?>download.php?file=<?php echo base64_encode(cleanString($row['app_download']));?>&id=<?php echo $row['id'];?>" title="download <?php echo strtolower(cleanString($row['title']));?>" target="_blank" ><?php echo $row['app_filesize'];?> MB</a>
                        <?php if( !empty($row['app_buy_url']) ){ ?>| <a href="<?php echo $row['app_buy_url']; ?>" target="_blank" title="Buy now!!!">$<?php echo number_format($row['app_price'], 2, ".", ",");?></a><?php } ?></span>
                        <p><?php echo cleanString($row['app_summary'], 80);?>...</p>
                    </div> 
                </div>
		<?php
				}
			}
		?>
        <div class="pagination">
        	<span>
				<?php if(!$showSearchSort){ ?>
            	Sort by: 
				<?php $linkPage = ($subCat==true)? "sub_cat_software" : "software" ;?>
				<a href="<?php echo DOMAIN.$linkPage;?>.php?cat=<?php echo $_GET['cat']?>&sub_cat=<?php echo $_GET['sub_cat']?>&page=<?php echo $_GET['page']?>&sort=name">title</a> | 
                <a href="<?php echo DOMAIN.$linkPage;?>.php?cat=<?php echo $_GET['cat']?>&sub_cat=<?php echo $_GET['sub_cat']?>&page=<?php echo $_GET['page']?>&sort=date_added">date added</a> | 
                <a href="<?php echo DOMAIN.$linkPage;?>.php?cat=<?php echo $_GET['cat']?>&sub_cat=<?php echo $_GET['sub_cat']?>&page=<?php echo $_GET['page']?>&sortby=downloads">downloaded</a> | 
                <a href="<?php echo DOMAIN.$linkPage;?>.php?cat=<?php echo $_GET['cat']?>&sub_cat=<?php echo $_GET['sub_cat']?>&page=<?php echo $_GET['page']?>&sortby=view">viewed</a>
            	<?php } ?>
			</span>
        	<?php
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </div>
    </div>
</div>