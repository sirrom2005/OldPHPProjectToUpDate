<?php
	include_once("../classes/user.class.php");
	include_once("../classes/pagination.class.php");
	
	$userObj = new user();
	
	$data['category'] 	= $_REQUEST['category']; 
	$data['ord']		= (!empty($_GET['ord']))? $_GET['ord'] : "" ;
	
	$presult  = $userObj->getUsers($data);
	$category = $userObj->getUserCategories();
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_users&ord={$data['ord']}&category={$data['category']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">Filter</th></tr>
		<td>
			<select name="category" onchange="document.f.submit();">
				<option value="">Select Category</option>
				<?php
					if(!empty($category))
					{
						foreach($category as $row)
						{
				?>
						<option value="<?php echo $row['id'];?>" <?php echo ($data['category']==$row['id'])? "selected" : "" ;?> ><?php echo $row['category'];?></option>
				<?php
						}
					}
				?>
			</select>
		</td>
	</tr>
</table>
</form>
<table width="95%">
	<tr><th colspan="3" class="header">User Listing</th></tr>
	<tr>
    	<th width="210">&nbsp;</th>
    	<th>
        	User Name
            <a class="asc"  href="index.php?action=list_users&ord=asc<?php  echo "&category={$data['category']}";?>"></a>
			<a class="desc" href="index.php?action=list_users&ord=desc<?php echo "&category={$data['category']}";?>"></a>
        </th>
        <th>Category</th>
    </tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
        	<td>
				[<a href="index.php?action=add_user&id=<?php echo $row['id'];?>" >Edit</a>]
            	[<a href="index.php?action=change_pass&id=<?php echo $row['id'];?>" >Change password</a>]
                [<a href="javascript:deleteThis('USER -<?php echo $row['user_name']?>-', <?php echo $row['id'];?>);" >Delete</a>]
           </td>
		   <td><?php echo $row['user_name'] ?></td>
           <td><?php echo $row['category'] ?></td>
        </tr> 
<?php
		}
	}else{ echo "<tr><td colspan='3' align='center'>No listing found...</td></tr> "; }
?>
    <tr>
        <td colspan="3">
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
function deleteThis(str, id)
{
	if(confirm("Delete :: ["+str+"] ?"))
	{
		window.location = "includes/delete_user.php?id=" + id;
	}	
}
</script>
<?php $comObj->logAdminActions("View User Listing"); ?>