<?
	include_once("../classes/user.class.php");
	
	$userObj = new user();
	
	$results = $userObj->getUserById();
?>

<table width="95%">
	<tr><th colspan="2" class="header">User Listing</th></tr>
<?	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
		<? if( fileExists(VIDTHUM_IMG_PATH.$row['thumbnail']) ){ ?>
        <tr><td colspan="2"><img src="../classes/thumbnail.class.php?image=<?=VIDTHUM_THUM_FOLDER.$row['thumbnail']?>&h=120" /></td></tr>
        <? } ?>
        <tr><th width="80">User Name</th><td><?=$row['user_name'] ?></td></tr>
        <tr><th>Country</th><td><?=$row['country'] ?></td></tr>
        <tr><th>Level</th><td><?=$row['userLevel'] ?></td></tr>
        <tr>
        	<td colspan="2">
            	[<a href="index.php?action=change_pass&id=<?=$row['id'] ?>" >Change password</a>]<br />
                <? if($row['user_level'] != 1){ ?>[<a href="javascript:removeUser( <?=$row['id'] ?>); " >Delete</a>]<br /><? } ?><hr />
           </td>
        </tr> 
        <tr><td>&nbsp;</td></tr> 
<?
		}
	}else{ echo "<tr><td colspan='2' align='center'>No listing found...</td></tr> "; }
?>
</table>


<script>
function removeUser(id)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "includes/delete_user.php?id=" + id;
	}	
}
</script>