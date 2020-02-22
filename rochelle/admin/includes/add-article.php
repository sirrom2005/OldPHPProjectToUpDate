<?php
	if(isset($_GET['d']) && isset($_GET['id']))
	{
		$obj->deleteData('articles', 'id', $_GET['id']);
		header('location: ?p=manage-articles');
	}
		
	$rs = array('title' => '', 'detail' => '');
	if($_POST)
	{
		$rs['title'] 	= cleanString($_POST['title']);
		$rs['detail'] 	= cleanHTML($_POST['detail']);
		$rs['user_id'] 	= 1;//$_SESSION['MED_ROCH_ADMIN']['user_id'];
		$rs['date_added']= date('Y-m-d g:i:s');
		$valid = true;
		$errMes = '';
		if(empty($rs['title']))
		{
			$errMes .= "Title is required.<br>";
			$valid = false;
		}
		
		if(empty($rs['detail']))
		{
			$errMes .= "Detail is required.";
			$valid = false;
		}
		
		if(!$valid)
		{
			echo "<span class='error'>$errMes</span>";
		}
		else
		{
			if(isset($_GET['id'])){
				$obj->updateRecord($rs, 'articles', $_GET['id']);
			}
			else
			{
				$obj->insertRecord( $rs, 'articles' );
			}
			header('location: ?p=manage-articles');
		}
	}
	
	if(isset($_GET['id'])){
		$editTxt = 'Edit';
		echo '<a href="#" class="button del right" onclick="dele('.$_GET['id'].')">Delete Article</a>';
		$rs = $obj->getDataById( 'articles', $_GET['id'] );
	}
	else
	{
		$editTxt = 'Add';
	}
?>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<h1><?php echo $editTxt;?> Articles</h1>
<form name="frm" action="" method="post">
<table>
	<tr>
    	<td>Title</td>
        <td><input type="text" name="title" value="<?php echo cleanString($rs['title']);?>" /></td>
    </tr>
    <tr>
    	<td>Content</td>
        <td>
        	<textarea name="detail" id="detail"><?php echo cleanHTML($rs['detail']);?></textarea>
        	<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( 'detail' );

			//]]>
			</script>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<input type="submit" value="Save..." />
            <input type="reset" value="Reset..." />
        </td>
    </tr>
</table>
</form>
<script language="javascript">
function dele(id)
{
	if(confirm('You are about to delete this record.'))
	{
		window.location = '?p=add-article&id=' + id + '&d=t';
	}
}
</script>