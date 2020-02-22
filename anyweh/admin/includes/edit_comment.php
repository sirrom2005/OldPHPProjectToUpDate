<?
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/banner.class.php");
	
	$bannerObj = new banner();
	
	$id = $_GET['id'];
	
	if($_POST)
	{		
		if(!empty($id))
		{
			if($bannerObj->editComment( $_POST, $id ))
			{
				echo "<script> location='index.php?action=list_comment'; </script>";
				echo "<meta http-equiv='refresh' content='0;index.php?action=list_comment' />";
			}
		}
	}
	
	if(isset($id))
	{
		$rs = $bannerObj->getCommentById($id);
	}
?>

<form name="comment" action="" method="post" >
<table>
  <tr><th colspan="2" class="header">Edit Comment</th></tr>
  <tr>
    <th>Name</th>
    <td><input type="text" name="name" value="<?=cleanString($rs['name'])?>" /></td>
  </tr>
  <tr>
    <th>Email</th>
    <td><input type="text" name="email" value="<?=cleanString($rs['email'])?>" /></td>
  </tr>
  <tr>
    <th valign="top">Comment</th>
    <td><textarea name="comment" cols="80" rows="8"><?=cleanString($rs['comment'])?></textarea></td>
  </tr>
  <tr>
    <td colspan="2">
    <input type="submit" value="Save..." />
    </td>
  </tr>
</table>
</form>