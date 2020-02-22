<?
	include_once("../classes/news.class.php");
	include_once("../classes/pagination.class.php");
	
	$newsObj = new news();
		
	$presult = $newsObj->getNewsListing($country_id, NULL);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_news";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>

<table width="95%">
	<tr><th colspan="2" class="header">Article Listing</th></tr>
    <tr>
        <td colspan="3" class="pagination">
            <?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
<?	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr><th>Title</th><td><?=cleanString($row['title'])?></td></tr>
        <tr><th>Date</th><td><?=$row['date'] ?></td></tr>
        <tr><th>Article type</th><td><b><?=($row['article_type']==2)? "Event Review" : "News Article";?></b></td></tr>
        <tr><th>Intro text</th><td><?=cleanString($row['intro_text']) ?></td></tr>
        <tr>
        	<th>&nbsp;</th>
        	<td>
            	[<a href="index.php?action=add_news&id=<?=$row['news_id'] ?>" >Edit</a>]&nbsp;
                [<a href="javascript:removeNews(<?=$row['news_id'] ?>); " >Delete</a>]
           </td>
        </tr> 
        <tr><td colspan="2">&nbsp;</td></tr> 
<?
		}
	}else{ echo "<tr><td colspan='2' align='center'>No listing found...</td></tr> "; }
?>
    <tr>
        <td colspan="3" class="pagination">
            <?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
</table>


<script>
function removeNews(id)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "includes/delete_news.php?id=" + id;
	}	
}
</script>