<?
	include_once("../classes/banner.class.php");
	include_once("../classes/pagination.class.php");
	
	$bannerObj = new banner();
	
	$presult = $bannerObj->getComments();
		
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_comment";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>

<table width="95%">
	<tr><th colspan="2" class="header">List Comments</th></tr>
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
        <tr><th>Name</th><td><?=cleanString($row['name'])?></td></tr>
        <tr><th>Email</th><td><?=$row['email'] ?></td></tr>
        <tr><th>Comment</th><td><?=cleanString($row['comment']) ?></td></tr>
        <tr><th>&nbsp;</th><td><a href="#" onclick="enable(<?=$row['id']?>, '<?=base64_encode($_SERVER['QUERY_STRING'])?>');">Click To <?=($row['enable']==1)? "Unapprove" : "Approve" ?></a></td></tr>
        <tr>
        	<th>&nbsp;</th>
        	<td>
            	[<a href="index.php?action=edit_comment&id=<?=$row['id'] ?>" >Edit</a>]&nbsp;
                [<a href="javascript:removeNews(<?=$row['id'] ?>); " >Delete</a>]
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
		window.location = "includes/delete_comment.php?id=" + id;
	}	
}
function enable(id, url)
{
	window.location = "includes/enable_comment.php?id=" + id + "&url=" + url;
}
</script>