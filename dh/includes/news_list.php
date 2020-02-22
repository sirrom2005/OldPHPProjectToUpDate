<div id="products" class="news">
    <div class="bg">
        <h2>Download Hours News Center</h2>
         <div id="headline">
         	<div><a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/<?php echo $latestNews[0]['id']; ?>_news.html" title="<?php echo $latestNews[0]['title'];?>..."><?php echo $latestNews[0]['title'];?></a> - <a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/" class="category" title="View more <?php echo strtolower($latestNews[0]['category']); ?> article..."><?php echo $latestNews[0]['category'];?></a></div>
            <p><?php echo cleanString($latestNews[0]['detail'], 60);?>...</p>
            [<a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/<?php echo $latestNews[0]['id']; ?>_news.html" title="Read full article..." class="readmore" >read more</a>]
         </div>
         <h1>LATEST NEWS (all categories)</h1>
         <ul id="newsLatest">
         <?php
            if(!empty($latestNews))
            {
                foreach($latestNews as $row)
                {
        ?>
                <li>
                	<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/<?php echo $row['id']; ?>_news.html" title="<?php echo $row['title'];?>"><?php echo cleanString($row['title']);?></a> 
                    - <a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/" class="category" title="View more <?php echo strtolower($row['category']); ?> article..." ><?php echo $row['category'];?></a>
                    <p><?php echo cleanString($row['detail'], 20);?>...</p>
                    [<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/<?php echo $row['id']; ?>_news.html" title="Read full article..." class="readmore" >more</a>] on <?php echo date("d/m/Y", strtotime($row['date_added'])); ?>
                </li>
        <?php
                }
            }
        ?>      
        </ul>
        <div id="newsAds">
			<script type="text/javascript"><!--
            google_ad_client = "pub-7769573252573851";
            /* downloadhours_link_ads */
            google_ad_slot = "8851136611";
            google_ad_width = 468;
            google_ad_height = 15;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>
        <h1>LATEST NEWS BY CATEGORY</h1>
        <ul id="newsByCategory">
		 <?php
            if(!empty($newsCategory))
            {
                foreach($newsCategory as $row)
                {
        ?>
                <li>
                	<div>
                	<h3><img src="../images/rss2.jpg" /><a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/" title="View all <?php echo strtolower($row['cat_name']);?> articles."><?php echo $row['cat_name'];?></a></h3>
					<?php 
						$rs = $obj->getNewsByCategory($row['cat_url_title'], 4); 	
						if(!empty($rs))
						{		
					?>
                    		<a href="<?php echo DOMAIN;?>news/<?php echo $rs[0]['cat_url_title']; ?>/<?php echo $rs[0]['id']; ?>_news.html" title="Read full article on: <?php echo strtolower($rs[0]['title']);?>" class="title"><?php echo $rs[0]['title'];?></a>		
							<p><?php echo cleanString($rs[0]['detail'], 15);?>...</p>
                            <font>Other <?php echo $row['cat_name'];?> Headlines</font>
                            <ol>
					<?php
							$len = count($rs);
							for( $i=1; $i<$len; $i++ )
							{
					?>
                    			<li class="newsList"><a href="<?php echo DOMAIN;?>news/<?php echo $rs[$i]['cat_url_title']; ?>/<?php echo $rs[$i]['id'];?>_news.html" title="<?php echo strtolower($rs[$i]['title']);?>"><?php echo $rs[$i]['title'];?></a></li>
                    <?php
							}
                        }
                    ?>  
                    		</ol>
                            [<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/" title="View more <?php echo $row['cat_name']; ?> article..." class="viewmore" >view more</a>]
               		</div>
                </li>
        <?php
                }
            }
        ?>  
        </ul>
        <div class="clear"></div>
    </div>
</div>