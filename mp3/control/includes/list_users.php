<?php
	$results = $comObj->getData( "odb_account", NULL, "account_type", "ASC" )
?>
<table width="95%">
	<tr><th colspan="2" class="header">User Listing</th></tr>
	<tr><th width="40">&nbsp;</th><th>User Name</th></tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
        	<td>
                <a href="javascript:deleteThis(<?php echo $row['id'];?>);" title="delete record..." ><img src="images/delete.png" /></a>
				<a href="index.php?action=add_user&id=<?php echo $row['id'];?>" title="edit record..." ><img src="images/application_edit.png" /></a>
           </td>
		   <td><?php echo $row['user_name'] ?> [<a href="index.php?action=change_pass&id=<?php echo $row['id'];?>" >Change password</a>]</td>
        </tr> 
<?php
		}
	}else{ echo "<tr><td colspan='2' align='center'>No listing found...</td></tr> "; }
?>
</table>

<script>
function deleteThis(id)
{
	if(confirm("Delete this record?"))
	{
		window.location = "includes/delete_user.php?id=" + id;
	}	
}
</script>