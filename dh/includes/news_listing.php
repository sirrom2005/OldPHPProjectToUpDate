<div id="products" class="news">
    <div class="bg">
        <h2>Download Hours News Center</h2>
         <div id="headline">
         	<div><a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/<?php echo $latestNews[0]['id'];?>_news.html" title="<?php echo $latestNews[0]['title'];?>..."><?php echo $latestNews[0]['title'];?></a> - <a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/" class="category" title="View more <?php echo strtolower($latestNews[0]['category']); ?> article..."><?php echo $latestNews[0]['category'];?></a></div>
            <p><?php echo cleanString($latestNews[0]['detail'], 60);?>...</p>
            [<a href="<?php echo DOMAIN;?>news/<?php echo $latestNews[0]['cat_url_title']; ?>/<?php echo $latestNews[0]['id'];?>_news.html" title="Read full article..." class="readmore" >read more</a>]
         </div>
         <h1>NEWS</h1>
         <ul id="newsLatest">
         <?php
            if(!empty($results))
            {
                foreach($results as $row)
                {
        ?>
                <li>
                	<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/<?php echo $row['id'];?>_news.html" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a> - 
                	<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/" class="category" title="View more <?php echo strtolower($row['cat_name']); ?> article..." ><?php echo $row['cat_name'];?></a>
                    <p><?php echo cleanString($row['detail'], 30);?>...</p>
                    [<a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/<?php echo $row['id'];?>_news.html" title="Read full article..." class="readmore" >more</a>] on <?php echo date("d/m/Y", strtotime($row['date_added'])); ?>
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
                <div class="pagination">
        	<!--span>Sort by: <a href="<?php echo DOMAIN;?>software.php?cat=<?php echo $_GET['cat']?>&page=<?php echo $_GET['page']?>&sort=title">title</a> | <a href="<?php echo DOMAIN;?>software.php?cat=<?php echo $_GET['cat']?>&page=<?php echo $_GET['page']?>&sort=entry_date">date added</a> | <a href="<?php echo DOMAIN;?>software.php?cat=<?php echo $_GET['cat']?>&page=<?php echo $_GET['page']?>&sort=view_count_one">downloaded</a> | <a href="<?php echo DOMAIN;?>software.php?cat=<?php echo $_GET['cat']?>&page=<?php echo $_GET['page']?>&sort=view_count_two">viewed</a></span-->
        	<?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </div>
    </div>
</div>